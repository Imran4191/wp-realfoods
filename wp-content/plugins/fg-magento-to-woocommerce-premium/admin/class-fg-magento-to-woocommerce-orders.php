<?php
/**
 * Orders class
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      1.0.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
 */

if ( !class_exists('FG_Magento_to_WooCommerce_Orders', false) ) {

	/**
	 * Orders class
	 *
	 * @package    FG_Magento_to_WooCommerce_Premium
	 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Magento_to_WooCommerce_Orders {

		private $plugin;
		private $customers = '';
		private $products_ids = array();
		private $orders_table = '';
		private $order_payments_table = '';
		private $order_items_table = '';
		private $order_address_table = '';
		private $order_status_history_table = '';
		private $order_item_cost_column = '';
		
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
		 * Get some Magento Premium information
		 *
		 * @param string $message Message to display
		 * @return string Message to display
		 */
		public function display_magento_info($message) {
			// Orders
			$orders_count = $this->get_orders_count();
			$message .= sprintf(_n('%d order', '%d orders', $orders_count, 'fgm2wcp'), $orders_count) . "\n";
			return $message;
		}
		
		/**
		 * Reset the Magento last imported order ID
		 *
		 */
		public function reset_orders() {
			update_option('fgm2wc_last_magento_order_id', 0);
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
			if ( !isset($this->plugin->premium_options['skip_orders']) || !$this->plugin->premium_options['skip_orders'] ) {
				$count += $this->get_orders_count();
			}
			return $count;
		}

		/**
		 * Get the number of orders in the Magento database
		 * 
		 * @return int Number of orders
		 */
		private function get_orders_count() {
			$prefix = $this->plugin->plugin_options['prefix'];
			$store_criteria = $this->plugin->import_selected_store_only ? "WHERE store_id IN (0, {$this->plugin->store_id})" : '';
			$this->set_orders_tables();
			$sql = "
				SELECT COUNT(*) AS nb
				FROM {$prefix}{$this->orders_table}
				$store_criteria
			";
			$result = $this->plugin->magento_query($sql);
			$orders_count = isset($result[0]['nb'])? $result[0]['nb'] : 0;
			return $orders_count;
		}
		
		/**
		 * Set the orders tables names
		 * 
		 * @since 2.34.0
		 */
		private function set_orders_tables() {
			if ( $this->plugin->table_exists('sales_flat_order') ) {
				$this->orders_table = 'sales_flat_order';
				$this->order_payments_table = 'sales_flat_order_payment';
				$this->order_address_table = 'sales_flat_order_address';
				$this->order_status_history_table = 'sales_flat_order_status_history';
			} else {
				$this->orders_table = 'sales_order';
				$this->order_payments_table = 'sales_order_payment';
				$this->order_address_table = 'sales_order_address';
				$this->order_status_history_table = 'sales_order_status_history';
			}
			if ( $this->plugin->table_exists('sales_flat_order_item') ) {
				$this->order_items_table = 'sales_flat_order_item';
			} else {
				$this->order_items_table = 'sales_order_item';
			}
			if ( $this->plugin->column_exists($this->order_items_table, 'cost') ) {
				$this->order_item_cost_column = 'cost';
			} else {
				$this->order_item_cost_column = 'base_cost';
			}
		}
		
		/**
		 * Import the orders
		 * 
		 */
		public function import_orders() {
			if ( isset($this->plugin->premium_options['skip_orders']) && $this->plugin->premium_options['skip_orders'] ) {
				return;
			}
			
			if ( $this->plugin->import_stopped() ) {
				return;
			}
			
			$this->set_orders_tables();
			
			$message = __('Importing orders...', $this->plugin->get_plugin_name());
			if ( defined('WP_CLI') ) {
				$progress_cli = \WP_CLI\Utils\make_progress_bar($message, $this->get_orders_count());
			} else {
				$this->plugin->log($message);
			}
			$imported_orders_count = 0;
			
			$this->customers = $this->get_imported_customers();
			$this->products_ids = $this->get_woocommerce_products();
			
			do {
				if ( $this->plugin->import_stopped() ) {
					return;
				}
				$orders = $this->get_orders($this->plugin->chunks_size);
				$orders_count = count($orders);
				foreach ( $orders as $order ) {
					$order_id = $this->import_order($order);
					if ( !empty($order_id) ) {
						$imported_orders_count++;
					}
				}
				$this->plugin->progressbar->increment_current_count($orders_count);
				
				if ( defined('WP_CLI') ) {
					$progress_cli->tick($this->plugin->chunks_size);
				}
			} while ( ($orders != null) && ($orders_count > 0) );
			
			if ( defined('WP_CLI') ) {
				$progress_cli->finish();
			}
			
			$this->plugin->display_admin_notice(sprintf(_n('%d order imported', '%d orders imported', $imported_orders_count, $this->plugin->get_plugin_name()), $imported_orders_count));
		}
		
		/**
		 * Get the Magento orders
		 * 
		 * @param int $limit Number of orders max
		 * @return array of orders
		 */
		private function get_orders($limit=1000) {
			$orders = array();
			$prefix = $this->plugin->plugin_options['prefix'];

			$last_order_id = (int)get_option('fgm2wc_last_magento_order_id'); // to restore the import where it left
			$store_criteria = $this->plugin->import_selected_store_only ? "AND o.store_id IN (0, {$this->plugin->store_id})" : '';
			if ( version_compare($this->plugin->magento_version, '1.4', '>=') ) {
				// Magento 1.4+
				$sql = "
					SELECT o.entity_id, o.status, o.created_at, o.updated_at, o.customer_id, o.billing_address_id, o.shipping_address_id, o.increment_id, o.order_currency_code, o.remote_ip, o.customer_note, o.grand_total, o.tax_amount, o.shipping_amount, o.shipping_tax_amount, o.discount_amount, o.total_refunded, o.shipping_description
					, p.method AS payment_method, p.po_number
					FROM {$prefix}{$this->orders_table} o
					LEFT JOIN {$prefix}{$this->order_payments_table} p ON p.entity_id = o.entity_id
					WHERE o.entity_id > '$last_order_id'
					$store_criteria
					ORDER BY o.entity_id
					LIMIT $limit
				";
			} else {
				// Magento 1.4-
				if ( $this->plugin->column_exists('sales_order', 'status') ) {
					$status_column = 'o.status';
				} else {
					$status_column = "'' AS status";
				}
				$sql = "
					SELECT o.entity_id, $status_column, o.created_at, o.updated_at, o.customer_id, '' AS billing_address_id, '' AS shipping_address_id, o.increment_id, '' AS order_currency_code, '' AS remote_ip, '' AS customer_note, o.grand_total, o.tax_amount, o.shipping_amount, o.shipping_tax_amount, o.discount_amount, o.total_refunded, '' AS shipping_description, '' AS payment_method, '' AS po_number
					FROM {$prefix}{$this->orders_table} o
					WHERE o.entity_id > '$last_order_id'
					$store_criteria
					ORDER BY o.entity_id
					LIMIT $limit
				";
			}
			$sql = apply_filters('fgm2wc_get_orders_sql', $sql);
			$orders = $this->plugin->magento_query($sql);
			
			return $orders;
		}
		
		/**
		 * Import an order
		 * 
		 * @since 2.34.0
		 * 
		 * @param array $order Order
		 * @return int Order ID
		 */
		private function import_order($order) {
			$order_id = 0;
			
			if ( function_exists('wc_create_order') ) {
				// Magento 1.4-
				if ( version_compare($this->plugin->magento_version, '1.4', '<') ) {
					$order = $this->get_order_m14($order);
				}

				// Order status
				$order_status = $this->map_order_status($order['status']);
				// Refunded order
				if ( $order['total_refunded'] == $order['grand_total'] ) {
					$order_status = 'wc-refunded';
				}

				// Customer ID
				$customer_id = isset($this->customers[$order['customer_id']])? $this->customers[$order['customer_id']] : 0;

				$args = array(
					'status'		=> $order_status,
					'customer_id'	=> $customer_id,
					'customer_note'	=> $order['customer_note'],
				);
				$wc_order = wc_create_order($args);

				if ( !is_wp_error($wc_order) ) {
					$order_id = $wc_order->get_id();
					$order_key = $order['increment_id'];
					$wc_order->set_date_created($order['created_at']);
					$wc_order->set_date_modified($order['updated_at']);

					if ( version_compare($this->plugin->magento_version, '1.4', '<') ) {
						// Magento 1.4-
						$order_addresses = $this->get_order_addresses_m14($order['entity_id']);
						$billing_address = isset($order_addresses['billing'])? $order_addresses['billing'] : '';
						$shipping_address = isset($order_addresses['shipping'])? $order_addresses['shipping'] : '';
					} else {
						// Magento 1.5+
						$billing_address = $this->get_order_address($order['billing_address_id']);
						$shipping_address = $this->get_order_address($order['shipping_address_id']);
					}

					if ( !empty($billing_address) ) {
						$billing_address = $this->append_address_fields($billing_address);
						$wc_order->set_billing_address(array(
							'first_name' => $billing_address['firstname'],
							'last_name' => $billing_address['lastname'],
							'company' => $billing_address['company'],
							'address_1' => $billing_address['address1'],
							'address_2' => $billing_address['address2'],
							'postcode' => $billing_address['postcode'],
							'city' => $billing_address['city'],
							'state' => $billing_address['region'],
							'country' => $billing_address['country_id'],
							'email' => isset($billing_address['email'])? $billing_address['email']: '',
							'phone' => $billing_address['telephone'],
						));
					}
					if ( !empty($shipping_address) ) {
						$shipping_address = $this->append_address_fields($shipping_address);
						$wc_order->set_shipping_address(array(
							'first_name' => $shipping_address['firstname'],
							'last_name' => $shipping_address['lastname'],
							'company' => $shipping_address['company'],
							'address_1' => $shipping_address['address1'],
							'address_2' => $shipping_address['address2'],
							'postcode' => $shipping_address['postcode'],
							'city' => $shipping_address['city'],
							'state' => $shipping_address['region'],
							'country' => $shipping_address['country_id'],
						));
					}

					$wc_order->set_payment_method($order['payment_method']);
					$wc_order->set_payment_method_title($order['payment_method']);
					$wc_order->set_shipping_total($order['shipping_amount']);
					$wc_order->set_discount_total(abs($order['discount_amount']));
					$wc_order->set_cart_tax($order['tax_amount'] - $order['shipping_tax_amount']);
					$wc_order->set_shipping_tax($order['shipping_tax_amount']);
					$wc_order->set_total($order['grand_total']);
					$wc_order->set_order_key($order_key);
					$wc_order->set_currency($order['order_currency_code']);
					$wc_order->set_prices_include_tax(false);
					$wc_order->set_customer_ip_address($order['remote_ip']);
					$wc_order->set_customer_user_agent('');
					$wc_order->set_recorded_coupon_usage_counts(true);

					$order['base_cost'] = 0.0; // Order cost of goods

					// Order items
					$order_items = $this->get_order_items($order['entity_id']);
					$order_items = apply_filters('fgm2wc_get_order_items', $order_items, $order['entity_id']);
					foreach ( $order_items as $order_item ) {
						if ( !empty($order_item['base_cost']) ) {
							$order['base_cost'] += $order_item['base_cost'];
						}
						$product_options = $this->decode_product_options($order_item);
						// Downloadable links
						if ( isset($product_options['links']) ) {
							$links = $product_options['links'];
							$price = $order_item['row_total'] / count($links);
							$tax = $order_item['tax_amount'] / count($links);
							foreach ( $links as $link ) {
								$variation_id = $this->plugin->get_wp_post_id_from_meta('_fgm2wc_old_link_id', $link);
								if ( !empty($variation_id) ) {
									$downloadable_files = get_post_meta($variation_id, '_downloadable_files', true);
									if ( !empty($downloadable_files) ) {
										$order_item['downloadable_files'] = $downloadable_files;
									}
								}
								$order_item['row_total'] = $price;
								$order_item['tax_amount'] = $tax;
								$this->add_order_item($order_id, $order_item, $variation_id, $customer_id, $order_key);
								if ( empty($variation_id) ) {
									break; // Avoid duplicating the order items
								}
							}
						} else {
							$variation_id = $this->plugin->get_wp_post_id_from_meta('_sku', $order_item['sku']);
							$this->add_order_item($order_id, $order_item, $variation_id, $customer_id, $order_key);
						}
					}

					// Shipping
					$this->add_shipping_row($order_id, $order);

					// Taxes
					$this->add_tax_row($order_id, $order);

					// Order comments
					$this->import_order_comments($order_id, $order['entity_id']);

					// Add the Magento ID as a post meta and as a wc_orders_meta
					add_post_meta($order_id, '_fgm2wc_old_order_id', $order['entity_id'], true);
					$wc_order->add_meta_data('_fgm2wc_old_order_id', $order['entity_id'], true);

					// Update the WooCommerce Customers screen
					if ( method_exists('Automattic\WooCommerce\Admin\API\Reports\Orders\Stats\DataStore', 'sync_order') ) {
						Automattic\WooCommerce\Admin\API\Reports\Orders\Stats\DataStore::sync_order($order_id);
					}

					// Hook for doing other actions after inserting the order
					do_action('fgm2wc_post_insert_order', $order_id, $order, $billing_address, $shipping_address);

					$wc_order->save();
				}
			}
			
			// Increment the Magento last imported order ID
			update_option('fgm2wc_last_magento_order_id', $order['entity_id']);
			
			return $order_id;
		}
		
		/**
		 * Get the order fields (Magento 1.4 and less)
		 * 
		 * @since 1.12.1
		 * 
		 * @param array $order Order
		 * @return array Order
		 */
		private function get_order_m14($order) {
			$order_attributes = $this->get_order_attributes($order['entity_id']);
			foreach ( $order_attributes as $key => $value ) {
				$order[$key] = $value;
			}
			return $order;
		}
		
		/**
		 * Get the order attributes (Magento 1.4 and less)
		 * 
		 * @since 1.12.1
		 * 
		 * @param int $order_id Order ID
		 * @return array Order attributes
		 */
		private function get_order_attributes($order_id) {
			$attributes = array();
			
			if ( version_compare($this->plugin->magento_version, '1.4', '<') ) {
				$prefix = $this->plugin->plugin_options['prefix'];

				$sql = "
					SELECT sov.value, a.attribute_code
					FROM {$prefix}sales_order_varchar sov
					INNER JOIN {$prefix}eav_attribute a ON a.attribute_id = sov.attribute_id
					WHERE sov.entity_id = '$order_id'
				";
				$result = $this->plugin->magento_query($sql);
				foreach ( $result as $row ) {
					$attributes[$row['attribute_code']] = $row['value'];
				}
			}
			return $attributes;
		}
		
		/**
		 * Get the order addresses (Magento 1.4 and less)
		 * 
		 * @since 1.12.1
		 * 
		 * @param int $order_id Order ID
		 * @return array Order addresses
		 */
		private function get_order_addresses_m14($order_id) {
			$addresses = array();
			$address_entity_ids = $this->get_order_address_entity_ids_m14($order_id);
			foreach ( $address_entity_ids as $address_entity_id ) {
				$address_data = $this->get_order_address_m14($address_entity_id);
				if ( isset($address_data['address_type']) ) {
					$addresses[$address_data['address_type']] = $address_data;
				}
			}
			return $addresses;
		}
		
		/**
		 * Get the order addresses entities
		 * 
		 * @since 1.12.1
		 * 
		 * @param int $order_id Order ID
		 * @return array Order address entities IDs
		 */
		private function get_order_address_entity_ids_m14($order_id) {
			$ids = array();
			
			if ( version_compare($this->plugin->magento_version, '1.4', '<') ) {
				$prefix = $this->plugin->plugin_options['prefix'];

				$sql = "
					SELECT soe.entity_id
					FROM {$prefix}sales_order_entity soe
					INNER JOIN {$prefix}eav_entity_type t ON t.entity_type_id = soe.entity_type_id
					WHERE soe.parent_id = '$order_id'
					AND t.entity_type_code = 'order_address'
				";
				$result = $this->plugin->magento_query($sql);
				foreach ( $result as $row ) {
					$ids[] = $row['entity_id'];
				}
			}
			return $ids;
		}
		
		/**
		 * Get the order address
		 * 
		 * @since 1.12.1
		 * 
		 * @param int $entity_id Entity ID
		 * @return array Order address fields
		 */
		private function get_order_address_m14($entity_id) {
			$address = array();
			
			if ( version_compare($this->plugin->magento_version, '1.4', '<') ) {
				$prefix = $this->plugin->plugin_options['prefix'];

				$sql = "
					SELECT soev.value, a.attribute_code
					FROM {$prefix}sales_order_entity_varchar soev
					INNER JOIN {$prefix}eav_attribute a ON a.attribute_id = soev.attribute_id
					WHERE soev.entity_id = '$entity_id'
				";
				$result = $this->plugin->magento_query($sql);
				foreach ( $result as $row ) {
					$address[$row['attribute_code']] = $row['value'];
				}
			}
			return $address;
		}
		
		/**
		 * Get the Magento order items
		 * 
		 * @param int $order_id Order ID
		 * @return array of order items
		 */
		private function get_order_items($order_id) {
			$order_items = array();
			$prefix = $this->plugin->plugin_options['prefix'];
			$sql = "
				SELECT i.item_id, i.product_id, i.product_type, i.product_options, i.sku, i.{$this->order_item_cost_column}, i.name AS product_name, i.qty_ordered, i.row_total, i.tax_amount, i.tax_before_discount, i.tax_percent, i.discount_invoiced
				FROM {$prefix}{$this->order_items_table} i
				WHERE i.order_id = '$order_id'
				AND i.parent_item_id IS NULL
				ORDER BY i.item_id
			";
			$order_items = $this->plugin->magento_query($sql);
			
			return $order_items;
		}
		
		/**
		 * Add downloadable product permission rows
		 * 
		 * @since 2.56.0
		 * 
		 * @param array $order_item Order item data
		 * @param int $order_id Order ID
		 * @param string $order_key Order key
		 * @param int $product_id Product ID
		 * @param int $user_id User ID
		 * @param string $customer_email Customer email
		 */
		private function add_wc_downloadable_product_permission($order_item, $order_id, $order_key, $product_id, $user_id, $customer_email) {
			global $wpdb;
			
			$downloadable_purchased_item = $this->get_downloadable_purchased_item($order_item['item_id']);
			$download_ids = $this->get_download_ids($product_id);
			foreach ( $download_ids as $download_id ) {
				$number_of_downloads_used = isset($downloadable_purchased_item['number_of_downloads_used'])? $downloadable_purchased_item['number_of_downloads_used'] : 0;
				$wpdb->insert($wpdb->prefix . 'woocommerce_downloadable_product_permissions', array(
					'download_id'			=> $download_id,
					'product_id'			=> $product_id,
					'order_id'				=> $order_id,
					'order_key'				=> $order_key,
					'user_email'			=> $customer_email,
					'user_id'				=> $user_id,
					'download_count'		=> $number_of_downloads_used,
					'downloads_remaining'	=> $this->calculate_downloads_remaining($product_id, $number_of_downloads_used),
					'access_granted'		=> isset($downloadable_purchased_item['created_at'])? $downloadable_purchased_item['created_at'] : '0000-00-00 00:00:00',
				));
			}
		}
		
		/**
		 * Get the downloadable link purchased item data
		 * 
		 * @param int $order_item_id Order item ID
		 * @return array Downloadable link purchased item data
		 */
		private function get_downloadable_purchased_item($order_item_id) {
			$downloadable_purchased_item = array();
			$prefix = $this->plugin->plugin_options['prefix'];

			$sql = "
				SELECT d.number_of_downloads_used, d.created_at
				FROM {$prefix}downloadable_link_purchased_item d
				WHERE d.order_item_id = '$order_item_id'
				AND d.status = 'available'
				LIMIT 1
			";
			$result = $this->plugin->magento_query($sql);
			if ( isset($result[0]) ) {
				$downloadable_purchased_item = $result[0];
			}
			return $downloadable_purchased_item;
		}
		
		/**
		 * Get the download IDs of a product
		 * 
		 * @since 2.56.0
		 * 
		 * @param int $product_id Product ID
		 * @return array Download IDs
		 */
		private function get_download_ids($product_id) {
			$download_ids = array();
			$downloadable_files = get_post_meta($product_id, '_downloadable_files');
			if ( is_array($downloadable_files) ) {
				foreach ( $downloadable_files as $downloadable_file ) {
					$download_ids = array_merge($download_ids, array_keys($downloadable_file));
				}
			}
			return $download_ids;
		}
		
		/**
		 * Calculate the downloads remaining number
		 * 
		 * @since 2.56.0
		 * 
		 * @param int $product_id Product ID
		 * @param int $download_nb Downloads already processed
		 * @return int Downloads remaining
		 */
		private function calculate_downloads_remaining($product_id, $download_nb) {
			$downloads_remaining = '';
			$download_limit = get_post_meta($product_id, '_download_limit', true);
			if ( !empty($download_limit) && ($download_limit != -1) ) {
				$downloads_remaining = $download_limit - $download_nb;
			}
			return $downloads_remaining;
		}
		
		/**
		 * Get the imported customers mapped with their Magento IDs
		 * 
		 * @return array [Magento customer ID => WP user ID]
		 */
		private function get_imported_customers() {
			global $wpdb;
			$tab_customers = array();
			$sql = "
				SELECT user_id, meta_value
				FROM $wpdb->usermeta
				WHERE meta_key = 'magento_customer_id'
			";
			foreach ( $wpdb->get_results($sql) as $usermeta ) {
				$tab_customers[$usermeta->meta_value] = $usermeta->user_id;
			}
			return $tab_customers;
		}
		
		/**
		 * Get the WooCommerce products
		 *
		 * @return array of products mapped with the Magento products ids
		 */
		private function get_woocommerce_products() {
			global $wpdb;
			$products = array();
			
			try {
				$sql = "
					SELECT post_id, meta_value
					FROM $wpdb->postmeta
					WHERE meta_key = '_fgm2wc_old_product_id'
				";
				$rows = $wpdb->get_results($sql);
				foreach ( $rows as $row ) {
					$products[$row->meta_value] = $row->post_id;
				}
			} catch ( PDOException $e ) {
				$this->plugin->display_admin_error(__('Error:', get_class($this->plugin)) . $e->getMessage());
			}
			return $products;
		}
		
		/**
		 * Mapping between Magento and WooCommerce status
		 *
		 * @param string $magento_status Magento order status
		 * @return string WooCommerce order status
		 */
		private function map_order_status($magento_status) {
			$magento_status = strtolower($magento_status);
			switch ( $magento_status ) {
				case 'pending':
					$status = 'wc-pending'; break;
				case 'processing':
					$status = 'wc-processing'; break;
				case 'holded':
					$status = 'wc-on-hold'; break;
				case 'canceled':
					$status = 'wc-cancelled'; break;
				case 'fraud':
					$status = 'wc-failed'; break;
				case 'complete':
				case 'shipped':
					$status = 'wc-completed'; break;
				default:
					$status = 'wc-pending'; break;
			}
			$status = apply_filters('fgm2wc_map_order_status', $status, $magento_status);
			return $status;
		}
		
		/**
		 * Append extra fields to the address
		 * 
		 * @param array $address Address data
		 * @return array Address data
		 */
		private function append_address_fields($address) {
			$customer_address = new FG_Magento_to_WooCommerce_Customer_Address($this->plugin);
			if ( !empty($address) ) {
				// Address fields
				list($address['address1'], $address['address2']) = $customer_address->split_address($address['street']);
				
				// Region code
				if ( isset($address['region']) ) {
					$address['region'] = $customer_address->get_region_code_from_name($address['region']);
				} elseif ( isset($address['region_id']) ) {
					$address['region'] = $customer_address->get_region_code($address['region_id']);
				} else {
					$address['region'] = '';
				}
			}
			return $address;
		}
		
		/**
		 * Get the order address
		 * 
		 * @param int $entity_id Entity ID
		 * @return array Address data
		 */
		private function get_order_address($entity_id) {
			$address = array();
			$prefix = $this->plugin->plugin_options['prefix'];

			$sql = "
				SELECT a.firstname, a.lastname, a.street, a.city, a.postcode, a.region_id, a.country_id, a.company, a.email, a.telephone
				FROM {$prefix}{$this->order_address_table} a
				WHERE a.entity_id = '$entity_id'
				LIMIT 1
			";
			$sql = apply_filters('fgm2wc_get_order_address_sql', $sql, $entity_id);
			$result = $this->plugin->magento_query($sql);
			if ( isset($result[0]) ) {
				$address = $result[0];
			}
			return $address;
		}
		
		/**
		 * Add a tax row into the order
		 * 
		 * @param int $order_id Order ID
		 * @param array $order Order
		 */
		private function add_tax_row($order_id, $order) {
			$wc_order_item_id = wc_add_order_item($order_id, array(
				'order_item_name'	=> 'Tax',
				'order_item_type'	=> 'tax',
			));
			if ( !empty($wc_order_item_id) ) {
				wc_update_order_item_meta($wc_order_item_id, 'rate_id', 0);
				wc_update_order_item_meta($wc_order_item_id, 'label', 'Tax');
				wc_update_order_item_meta($wc_order_item_id, 'compound', '');
				wc_update_order_item_meta($wc_order_item_id, 'tax_amount', $order['tax_amount'] - $order['shipping_tax_amount']);
				wc_update_order_item_meta($wc_order_item_id, 'shipping_tax_amount', $order['shipping_tax_amount']);
			}
		}
		
		/**
		 * Add a shipping row into the order
		 * 
		 * @param int $order_id Order ID
		 * @param array $order Order
		 */
		private function add_shipping_row($order_id, $order) {
			$order_item_name = isset($order['shipping_description']) && !is_null($order['shipping_description'])? $order['shipping_description'] : '';
			$wc_order_item_id = wc_add_order_item($order_id, array(
				'order_item_name'	=> $order_item_name,
				'order_item_type'	=> 'shipping',
			));
			if ( !empty($wc_order_item_id) ) {
				$line_tax = $order['shipping_tax_amount'];
				wc_update_order_item_meta($wc_order_item_id, 'method_id', 0);
				wc_update_order_item_meta($wc_order_item_id, 'cost', $order['shipping_amount']);
				wc_update_order_item_meta($wc_order_item_id, 'taxes', array(
					'total' => array((string)$line_tax),
					'subtotal' => array((string)$line_tax),
				));

			}
		}
		
		/**
		 * Add an order item row into the order
		 * 
		 * @param int $order_id Order ID
		 * @param array $order_item Order item
		 * @param int $variation_id Variation ID
		 * @param int $user_id Customer ID
		 * @param string $order_key Order reference
		 * @return int $wc_order_item_id Order item ID
		 */
		private function add_order_item($order_id, $order_item, $variation_id, $user_id, $order_key) {
			$order_item_name = is_null($order_item['product_name'])? '': $order_item['product_name'];
			$wc_order_item_id = wc_add_order_item($order_id, array(
				'order_item_name'	=> $order_item_name,
				'order_item_type'	=> 'line_item',
			));
			if ( !empty($wc_order_item_id) ) {
				$product_id = isset($this->products_ids[$order_item['product_id']])? $this->products_ids[$order_item['product_id']]: 0;
				wc_update_order_item_meta($wc_order_item_id, '_qty', $order_item['qty_ordered']);
				wc_update_order_item_meta($wc_order_item_id, '_tax_class', $order_item['tax_percent']);
				wc_update_order_item_meta($wc_order_item_id, '_product_id', $product_id);
				if ( !empty($variation_id) ) {
					wc_update_order_item_meta($wc_order_item_id, '_variation_id', $variation_id);
				} elseif ( !empty($order_item['sku']) ) { // Add the SKU even if a variation is not found
					wc_update_order_item_meta($wc_order_item_id, 'SKU', $order_item['sku']);
				}
				$line_subtotal = floatval($order_item['row_total']); // Full price
				$line_total = floatval($line_subtotal - $order_item['discount_invoiced']); // Discounted price
				$line_subtotal_tax = floatval($order_item['tax_before_discount']);
				$line_tax = floatval($order_item['tax_amount']);
				wc_update_order_item_meta($wc_order_item_id, '_line_subtotal', $line_subtotal);
				wc_update_order_item_meta($wc_order_item_id, '_line_total', $line_total);
				wc_update_order_item_meta($wc_order_item_id, '_line_subtotal_tax', $line_subtotal_tax);
				wc_update_order_item_meta($wc_order_item_id, '_line_tax', $line_tax);
				wc_update_order_item_meta($wc_order_item_id, '_line_tax_data', array(
					'total' => array((string)$line_tax),
					'subtotal' => array((string)$line_tax),
				));
				
				// Attributes and options
				if ( !isset($this->plugin->premium_options['skip_attributes']) || !$this->plugin->premium_options['skip_attributes'] ) {
					$product_options = $this->decode_product_options($order_item);
					$attributes = array();
					if ( isset($product_options['options']) ) {
						$attributes = $product_options['options'];
					}
					if ( isset($product_options['attributes_info']) ) {
						$attributes = array_merge($attributes, $product_options['attributes_info']);
					}
					foreach ( $attributes as $attribute ) {
						$meta_key = 'pa_' . $this->plugin->normalize_attribute_name($attribute['label']);
						$meta_value = $attribute['value'];
						wc_update_order_item_meta($wc_order_item_id, $meta_key, $meta_value);
					}
				}
				
				// Downloadable files
				if ( isset($order_item['downloadable_files']) && !empty($order_item['downloadable_files']) ) {
					wc_update_order_item_meta($wc_order_item_id, 'downloadable-files', $order_item['downloadable_files']);
					// Create downloadable product permission rows
					$customer = get_user_by('id', $user_id);
					$customer_email = isset($customer->user_email)? $customer->user_email : '';
					$this->add_wc_downloadable_product_permission($order_item, $order_id, $order_key, $variation_id, $user_id, $customer_email);
				}
				
				// Hook for doing other actions after inserting the order item
				do_action('fgm2wc_post_insert_order_item', $wc_order_item_id, $order_item);
			}
			return $wc_order_item_id;
		}
		
		/**
		 * Decode the product options
		 * 
		 * @since 2.47.0
		 * 
		 * @param array $order_item Order item
		 * @return array Product options
		 */
		private function decode_product_options($order_item) {
			$product_options = array();
			if ( preg_match('/^a:/', $order_item['product_options']) ) {
				// serialized
				$product_options = unserialize($order_item['product_options']);
			} else {
				// JSON
				$product_options = json_decode($order_item['product_options'], ARRAY_A);
			}
			return $product_options;
		}
		
		/**
		 * Import the order comments
		 * 
		 * @since 2.8.0
		 * 
		 * @param int $order_id Order ID
		 * @param int $magento_order_id Magento Order ID
		 */
		private function import_order_comments($order_id, $magento_order_id) {
			$comments = $this->get_comments($magento_order_id);
			foreach ( $comments as $comment ) {
				// Insert the comment in the WP comments table
				$data = array(
					'comment_post_ID' => $order_id,
					'comment_content' => $comment['comment'],
					'comment_type' => 'order_note',
					'comment_parent' => 0,
					'comment_agent' => 'WooCommerce',
					'comment_date' => $comment['created_at'],
					'comment_approved' => 1,
				);
				$comment_id = wp_insert_comment($data);
				
				if ( $comment_id ) {
					if ( $comment['is_customer_notified'] > 0 ) {
						add_comment_meta($comment_id, 'is_customer_note', 1);
					}
				}
			}
		}
		
		/**
		 * Get the Magento comments of an order
		 * 
		 * @since 2.8.0
		 * 
		 * @param int $order_id Magento Order ID
		 * @return array Comments
		 */
		private function get_comments($order_id) {
			$comments = array();
			$prefix = $this->plugin->plugin_options['prefix'];

			if ( version_compare($this->plugin->magento_version, '1.4', '<') ) {
				// Magento 1.4-
				$sql = "
					SELECT soet.value_id AS entity_id, '' AS is_customer_notified, soet.value AS comment, soe.created_at
					FROM {$prefix}sales_order_entity_text soet
					INNER JOIN {$prefix}sales_order_entity soe ON soe.entity_id = soet.entity_id AND soe.parent_id = '$order_id'
					INNER JOIN {$prefix}eav_attribute a ON a.attribute_id = soet.attribute_id AND a.attribute_code = 'comment'
					WHERE soet.value != ''
				";
			} else {
				$sql = "
					SELECT h.entity_id, h.is_customer_notified, h.comment, h.created_at
					FROM {$prefix}{$this->order_status_history_table} h
					WHERE h.parent_id = '$order_id'
					AND h.comment IS NOT NULL
					AND h.comment != ''
				";
			}
			$sql .= " LIMIT 100"; // To avoid hangs due to orders with thousands of notes
			$comments = $this->plugin->magento_query($sql);
			return $comments;
		}
		
		/**
		 * Update the already imported orders
		 * 
		 * @param date $last_update Last update date
		 * 
		 * @since 2.3.0
		 */
		public function update_orders($last_update) {
			$this->set_orders_tables();
			$orders = $this->get_updated_orders($last_update);

			$message = __('Updating orders...', $this->plugin->get_plugin_name());
			if ( defined('WP_CLI') ) {
				$progress_cli = \WP_CLI\Utils\make_progress_bar($message, count($orders));
			} else {
				$this->plugin->log($message);
			}

			$updated_orders_count = 0;
			
			foreach ( $orders as $order ) {
				$order_id = $this->get_wp_order_id_from_magento_id($order['entity_id']);
				if ( !empty($order_id) ) {
					// Order status
					$order_status = $this->map_order_status($order['status']);
					// Refunded order
					if ( $order['total_refunded'] == $order['grand_total'] ) {
						$order_status = 'wc-refunded';
					}
					// Update the order status
					$wc_order = new WC_Order($order_id);
					$wc_order->set_status($order_status);
					$wc_order->save();
					$updated_orders_count++;
				}
				if ( defined('WP_CLI') ) {
					$progress_cli->tick(1);
				}
			}
			if ( defined('WP_CLI') ) {
				$progress_cli->finish();
			}

			// Hook for doing other actions after all orders are updated
			do_action('fgm2wc_post_update_orders');

			$this->plugin->display_admin_notice(sprintf(_n('%d order updated', '%d orders updated', $updated_orders_count, $this->plugin->get_plugin_name()), $updated_orders_count));
		}

		/**
		 * Get the orders updated after a date
		 * 
		 * @since 2.3.0
		 * 
		 * @param date $last_update
		 */
		private function get_updated_orders($last_update) {
			$orders = array();
			$prefix = $this->plugin->plugin_options['prefix'];

			if ( $this->plugin->column_exists($this->orders_table, 'status') ) {
				$status_column = 'o.status';
			} else {
				$status_column = "'' AS status";
			}
			$sql = "
				SELECT o.entity_id, $status_column, o.grand_total, o.total_refunded
				FROM {$prefix}{$this->orders_table} o
				WHERE o.updated_at > '$last_update'
			";
			$orders = $this->plugin->magento_query($sql);

			return $orders;
		}
		
		/**
		 * Returns the imported order ID corresponding to a Magento ID
		 *
		 * @since 2.3.0
		 * 
		 * @param int $magento_id Magento order ID
		 * @return int WordPress order ID
		 */
		public function get_wp_order_id_from_magento_id($magento_id) {
			$order_id = $this->plugin->get_wp_post_id_from_meta('_fgm2wc_old_order_id', $magento_id);
			return $order_id;
		}

	}
}
