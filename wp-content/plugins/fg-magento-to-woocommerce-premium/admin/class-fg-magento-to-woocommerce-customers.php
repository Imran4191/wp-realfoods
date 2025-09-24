<?php
/**
 * Customers class
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      1.0.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
 */

if ( !class_exists('FG_Magento_to_WooCommerce_Customers', false) ) {

	/**
	 * Customers class
	 *
	 * @package    FG_Magento_to_WooCommerce_Premium
	 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Magento_to_WooCommerce_Customers {

		private $plugin;
		private $orders_table = '';
		
		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 * @param    object    $plugin       Admin plugin
		 */
		public function __construct( $plugin ) {

			$this->plugin = $plugin;

		}

		/**
		 * Update the number of total elements found in Magento
		 * 
		 * @since 2.0.0
		 * 
		 * @param int $count Number of total elements
		 * @return int Number of total elements
		 */
		public function get_total_elements_count($count) {
			if ( !isset($this->plugin->premium_options['skip_customers']) || !$this->plugin->premium_options['skip_customers'] ) {
				$count += $this->get_customers_count();
			}
			return $count;
		}

		/**
		 * Get some Magento Premium information
		 *
		 * @param string $message Message to display
		 * @return string Message to display
		 */
		public function display_magento_info($message) {
			// Customers
			$customers_count = $this->get_customers_count();
			$message .= sprintf(_n('%d customer', '%d customers', $customers_count, 'fgm2wcp'), $customers_count) . "\n";
			return $message;
		}
		
		/**
		 * Get the number of customers in the Magento database
		 * 
		 * @return int Number of customers
		 */
		private function get_customers_count() {
			$this->guess_orders_table_name();
			$prefix = $this->plugin->plugin_options['prefix'];
			$store_criteria = $this->plugin->import_selected_store_only ? "AND c.store_id IN (0, {$this->plugin->store_id}) AND (c.website_id = '{$this->plugin->website_id}' OR c.website_id IS NULL)" : '';
			$extra_joins = $this->plugin->premium_options['skip_inactive_customers']? "INNER JOIN {$prefix}{$this->orders_table} o ON o.customer_id = c.entity_id" : '';
			$sql = "
				SELECT COUNT(DISTINCT(c.entity_id)) AS nb
				FROM {$prefix}customer_entity c
				$extra_joins
				WHERE c.is_active = 1
				$store_criteria
			";
			$result = $this->plugin->magento_query($sql);
			$customers_count = isset($result[0]['nb'])? $result[0]['nb'] : 0;
			return $customers_count;
		}
		
		/**
		 * Determine the orders table name
		 */
		private function guess_orders_table_name() {
			if ( $this->plugin->table_exists('sales_flat_order') ) {
				$this->orders_table = 'sales_flat_order';
			} else {
				$this->orders_table = 'sales_order';
			}
		}
		
		/**
		 * Import the customers
		 */
		public function import_customers() {
			
			if ( isset($this->plugin->premium_options['skip_customers']) && $this->plugin->premium_options['skip_customers'] ) {
				return;
			}
			
			if ( $this->plugin->import_stopped() ) {
				return;
			}
			
			// Hook for other actions
			do_action('fgm2wcp_pre_import_customers');
			
			$message = __('Importing customers...', $this->plugin->get_plugin_name());
			if ( defined('WP_CLI') ) {
				$progress_cli = \WP_CLI\Utils\make_progress_bar($message, $this->get_customers_count());
			} else {
				$this->plugin->log($message);
			}
			$imported_customers_count = 0;
			
			$this->guess_orders_table_name();
			
			do {
				if ( $this->plugin->import_stopped() ) {
					return;
				}
				$customers = $this->get_customers($this->plugin->chunks_size);
				$customers_count = count($customers);
				foreach ( $customers as $customer ) {
					// Get the other fields
					$customer = array_merge($customer, $this->get_other_customer_fields($customer['entity_id'], $this->plugin->customer_type_id));
					if ( !isset($customer['firstname']) ) {
						$customer['firstname'] = ''; // Allow the customers without a first name (the companies for example)
					}
					if ( !isset($customer['lastname']) ) {
						$customer['lastname'] = ''; // Allow the customers without a last name
					}
					$password_hash = isset($customer['password_hash'])? $customer['password_hash']: '';
					
					// Increment the Magento last imported customer ID
					update_option('fgm2wc_last_magento_customer_id', $customer['entity_id']);
					
					if ( isset($customer['email']) ) {
						$user_id = $this->plugin->add_user($customer['firstname'], $customer['lastname'], '', $customer['email'], $password_hash, $customer['entity_id'], $customer['created_at'], 'customer');
						if ( !is_wp_error($user_id) && !empty($user_id) ) {
							$imported_customers_count++;

							// Link between the Magento ID and the WordPress user ID
							add_user_meta($user_id, 'magento_customer_id', $customer['entity_id'], true);

							$this->update_customer_meta($user_id, $customer);
							
							do_action('fgm2wcp_post_add_customer', $user_id, $customer);
						}
					}
				}
				
				$this->plugin->progressbar->increment_current_count($customers_count);
				
				if ( defined('WP_CLI') ) {
					$progress_cli->tick($this->plugin->chunks_size);
				}
			} while ( ($customers != null) && ($customers_count > 0) );
			
			if ( defined('WP_CLI') ) {
				$progress_cli->finish();
			}
			
			$this->plugin->display_admin_notice(sprintf(_n('%d customer imported', '%d customers imported', $imported_customers_count, $this->plugin->get_plugin_name()), $imported_customers_count));
		}
		
		/**
		 * Get the Magento customers
		 * 
		 * @param int $limit Number of customers max
		 * @return array of customers
		 */
		protected function get_customers($limit=1000) {
			$customers = array();
			$prefix = $this->plugin->plugin_options['prefix'];
			$last_customer_id = (int)get_option('fgm2wc_last_magento_customer_id'); // to restore the import where it left
			$store_criteria = $this->plugin->import_selected_store_only ? "AND c.store_id IN (0, {$this->plugin->store_id}) AND (c.website_id = '{$this->plugin->website_id}' OR c.website_id IS NULL)" : '';
			$extra_joins = $this->plugin->premium_options['skip_inactive_customers']? "INNER JOIN {$prefix}{$this->orders_table} o ON o.customer_id = c.entity_id" : '';
			
			$extra_columns = '';
			if ( version_compare($this->plugin->magento_version, '2', '>=') ) {
				// Magento 2+
				$extra_columns = ', c.firstname, c.lastname, c.password_hash, c.default_billing, c.default_shipping';
			}
			$sql = "
				SELECT DISTINCT c.entity_id, c.email, c.group_id, c.created_at $extra_columns
				FROM {$prefix}customer_entity c
				$extra_joins
				WHERE c.is_active = 1
				AND c.entity_id > '$last_customer_id'
				$store_criteria
				ORDER BY c.entity_id
				LIMIT $limit
			";
			$sql = apply_filters('fgm2wc_get_customers_sql', $sql);
			$customers = $this->plugin->magento_query($sql);
			
			return $customers;
		}
		
		/**
		 * Get the other customer fields
		 * 
		 * @since 2.91.0
		 * 
		 * @param int $customer_id Customer ID
		 * @param int $customer_entity_id Customer Entity ID
		 * @return array Customer data
		 */
		public function get_other_customer_fields($customer_id, $customer_entity_id) {
			$fields = array(
				'firstname',
				'lastname',
				'password_hash',
				'default_billing',
				'default_shipping',
			);
			$fields = apply_filters('fgm2wc_get_other_customer_fields', $fields);
			return $this->plugin->get_attribute_values($customer_id, $customer_entity_id, $fields);
		}
		
		/**
		 * Update the customer meta data
		 * 
		 * @since 3.20.0
		 * 
		 * @param int $user_id WP user ID
		 * @param array $customer Customer data
		 */
		private function update_customer_meta($user_id, $customer) {
			// Add the address fields
			$address = new FG_Magento_to_WooCommerce_Customer_Address($this->plugin);
			if ( isset($customer['default_billing']) ) {
				$billing_address = $address->get_customer_address($customer['default_billing']);
				if ( !empty($billing_address) ) {
					update_user_meta($user_id, 'billing_company', isset($billing_address['company'])? $billing_address['company']: '');
					update_user_meta($user_id, 'billing_last_name', isset($billing_address['lastname'])? $billing_address['lastname']: '');
					update_user_meta($user_id, 'billing_first_name', isset($billing_address['firstname'])? $billing_address['firstname']: '');
					update_user_meta($user_id, 'billing_phone', isset($billing_address['telephone'])? $billing_address['telephone']: '');
					update_user_meta($user_id, 'billing_address_1', isset($billing_address['address1'])? $billing_address['address1']: '');
					update_user_meta($user_id, 'billing_address_2', isset($billing_address['address2'])? $billing_address['address2']: '');
					update_user_meta($user_id, 'billing_city', isset($billing_address['city'])? $billing_address['city']: '');
					update_user_meta($user_id, 'billing_state', isset($billing_address['region'])? $billing_address['region']: '');
					update_user_meta($user_id, 'billing_country', isset($billing_address['country_id'])? $billing_address['country_id']: '');
					update_user_meta($user_id, 'billing_postcode', isset($billing_address['postcode'])? $billing_address['postcode']: '');
					update_user_meta($user_id, 'billing_email', isset($customer['email'])? $customer['email']: '');
				}
			}
			if ( isset($customer['default_shipping']) ) {
				$shipping_address = $address->get_customer_address($customer['default_shipping']);
				if ( !empty($shipping_address) ) {
					update_user_meta($user_id, 'shipping_company', isset($shipping_address['company'])? $shipping_address['company']: '');
					update_user_meta($user_id, 'shipping_last_name', isset($shipping_address['lastname'])? $shipping_address['lastname']: '');
					update_user_meta($user_id, 'shipping_first_name', isset($shipping_address['firstname'])? $shipping_address['firstname']: '');
					update_user_meta($user_id, 'shipping_phone', isset($shipping_address['telephone'])? $shipping_address['telephone']: '');
					update_user_meta($user_id, 'shipping_address_1', isset($shipping_address['address1'])? $shipping_address['address1']: '');
					update_user_meta($user_id, 'shipping_address_2', isset($shipping_address['address2'])? $shipping_address['address2']: '');
					update_user_meta($user_id, 'shipping_city', isset($shipping_address['city'])? $shipping_address['city']: '');
					update_user_meta($user_id, 'shipping_state', isset($shipping_address['region'])? $shipping_address['region']: '');
					update_user_meta($user_id, 'shipping_country', isset($shipping_address['country_id'])? $shipping_address['country_id']: '');
					update_user_meta($user_id, 'shipping_postcode', isset($shipping_address['postcode'])? $shipping_address['postcode']: '');
				}
			}
		}
		
		/**
		 * Update the already imported customers
		 * 
		 * @since 3.20.0
		 * 
		 * @param date $last_update Last update date
		 */
		public function update_customers($last_update) {
			$this->guess_orders_table_name();
			$customers = $this->get_updated_customers($last_update);
			
			$message = __('Updating customers...', $this->plugin->get_plugin_name());
			if ( defined('WP_CLI') ) {
				$progress_cli = \WP_CLI\Utils\make_progress_bar($message, count($customers));
			} else {
				$this->plugin->log($message);
			}

			$updated_customers_count = 0;

			$imported_customers = $this->plugin->get_imported_magento_customers();
			foreach ( $customers as $customer ) {
				if ( isset($imported_customers[$customer['entity_id']]) ) {
					$user_id = $imported_customers[$customer['entity_id']];
					$email = sanitize_email($customer['email']);
					$display_name = $customer['firstname'] . ' ' . $customer['lastname'];
					$userdata = array(
						'ID'				=> $user_id,
						'user_nicename'		=> $email,
						'user_email'		=> $email,
						'display_name'		=> $display_name,
						'first_name'		=> $customer['firstname'],
						'last_name'			=> $customer['lastname'],
					);
					wp_update_user($userdata);
					if ( !empty($customer['password_hash']) && !empty(get_user_meta($user_id, 'magento_pass', true)) ) {
						// Magento password to authenticate the users
						update_user_meta($user_id, 'magento_pass', $customer['password_hash']);
					}
					$this->update_customer_meta($user_id, $customer);
					
					do_action('fgm2wc_post_update_customer', $user_id, $customer);
					$updated_customers_count++;
				}
				if ( defined('WP_CLI') ) {
					$progress_cli->tick(1);
				}
			}
			if ( defined('WP_CLI') ) {
				$progress_cli->finish();
			}
			
			// Hook for doing other actions after all customers are updated
			do_action('fgm2wc_post_update_customers');

			$this->plugin->display_admin_notice(sprintf(_n('%d customer updated', '%d customers updated', $updated_customers_count, $this->plugin->get_plugin_name()), $updated_customers_count));
		}

		/**
		 * Get the customers updated after a date
		 * 
		 * @since 3.20.0
		 * 
		 * @param date $last_update Last update date
		 */
		private function get_updated_customers($last_update) {
			$customers = array();
			$prefix = $this->plugin->plugin_options['prefix'];

			$store_criteria = $this->plugin->import_selected_store_only ? "AND c.store_id IN (0, {$this->plugin->store_id}) AND (c.website_id = '{$this->plugin->website_id}' OR c.website_id IS NULL)" : '';
			$extra_joins = $this->plugin->premium_options['skip_inactive_customers']? "INNER JOIN {$prefix}{$this->orders_table} o ON o.customer_id = c.entity_id" : '';
			
			$extra_columns = '';
			if ( version_compare($this->plugin->magento_version, '2', '>=') ) {
				// Magento 2+
				$extra_columns = ', c.firstname, c.lastname, c.password_hash, c.default_billing, c.default_shipping';
			}
			$sql = "
				SELECT DISTINCT c.entity_id, c.email, c.group_id, c.created_at, c.updated_at $extra_columns
				FROM {$prefix}customer_entity c
				LEFT JOIN {$prefix}customer_address_entity a ON a.parent_id = c.entity_id
				$extra_joins
				WHERE c.is_active = 1
				AND (c.updated_at > '$last_update' OR a.updated_at > '$last_update')
				$store_criteria
				ORDER BY c.updated_at
			";
			$sql = apply_filters('fgm2wc_get_customers_sql', $sql);
			$customers = $this->plugin->magento_query($sql);

			return $customers;
		}
		
	}
}
