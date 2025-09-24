<?php
/**
 * Coupons class
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      2.21.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
 */

if ( !class_exists('FG_Magento_to_WooCommerce_Coupons', false) ) {

	/**
	 * Coupons class
	 *
	 * @package    FG_Magento_to_WooCommerce_Premium
	 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Magento_to_WooCommerce_Coupons {

		private $plugin;
		
		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    2.21.0
		 * @param    object    $plugin       Admin plugin
		 */
		public function __construct( $plugin ) {

			$this->plugin = $plugin;

		}

		/**
		 * Reset the Magento last imported coupon ID
		 *
		 */
		public function reset_coupons() {
			update_option('fgm2wc_last_coupon_id', 0);
		}
		
		/**
		 * Update the number of total elements found in Magento
		 * 
		 * @param int $count Number of total elements
		 * @return int Number of total elements
		 */
		public function get_total_elements_count($count) {
			if ( !isset($this->plugin->premium_options['skip_coupons']) || !$this->plugin->premium_options['skip_coupons'] ) {
				$count += $this->get_coupons_count();
			}
			return $count;
		}

		/**
		 * Get the number of Magento coupons
		 * 
		 * @return int Number of coupons
		 */
		private function get_coupons_count() {
			$coupons_count = 0;
			$prefix = $this->plugin->plugin_options['prefix'];
			if ( $this->plugin->table_exists('salesrule_coupon') ) {
				$sql = "
					SELECT COUNT(*) AS nb
					FROM {$prefix}salesrule_coupon
				";
				$result = $this->plugin->magento_query($sql);
				$coupons_count = isset($result[0]['nb'])? $result[0]['nb'] : 0;
			}
			return $coupons_count;
		}

		/**
		 * Import the Magento coupons
		 *
		 */
		public function import_coupons() {
			
			if ( isset($this->plugin->premium_options['skip_coupons']) && $this->plugin->premium_options['skip_coupons'] ) {
				return;
			}
			if ( $this->plugin->import_stopped() ) {
				return;
			}
			$message = __('Importing coupons...', $this->plugin->get_plugin_name());
			if ( defined('WP_CLI') ) {
				$progress_cli = \WP_CLI\Utils\make_progress_bar($message, $this->get_coupons_count());
			} else {
				$this->plugin->log($message);
			}
			$imported_coupons_count = 0;
			
			$products_ids = $this->plugin->get_woocommerce_products();
			$coupons = $this->get_coupons();
			$coupons_count = count($coupons);
			foreach ( $coupons as $coupon ) {
				if ( $coupon['from_date'] > date('Y-m-d H:i:s') ) {
					$post_status = 'future';
				} else {
					$post_status = 'publish';
				}
				$description = $coupon['name'];
				if ( !empty($coupon['description']) ) {
					$description .= "\n" . $coupon['description'];
				}
				$data = array(
					'post_type'			=> 'shop_coupon',
					'post_date'			=> $coupon['from_date'],
					'post_title'		=> $coupon['code'],
					'post_excerpt'		=> $description,
					'post_status'		=> ($coupon['is_active'] == 1)? $post_status: 'draft',
					'comment_status'	=> 'closed',
					'ping_status'		=> 'closed',
				);
				$coupon_id = wp_insert_post($data);
				if ( !empty($coupon_id) ) {
					$imported_coupons_count++;
					add_post_meta($coupon_id, '_fgm2wc_old_coupon_id', $coupon['coupon_id']);
					
					//  Percent or amount
					if ( $coupon['simple_action'] == 'by_percent' ) {
						$discount_type = 'percent';
					} else {
						$discount_type = 'fixed_cart';
					}
					
					$coupon_amount = floatval($coupon['discount_amount']);
					$free_shipping = ($coupon['simple_free_shipping'] != 0)? 'yes': 'no';

					// Not cumulable with other discounts
					if ( $coupon['stop_rules_processing'] != 0 ) {
						add_post_meta($coupon_id, 'individual_use', 'yes', true);
					}

					// Expiry date
					$expiry_date = !empty($coupon['to_date'])? $coupon['to_date'] : '';

					add_post_meta($coupon_id, 'discount_type', $discount_type, true);
					add_post_meta($coupon_id, 'coupon_amount', $coupon_amount, true);
					add_post_meta($coupon_id, 'usage_limit', $coupon['usage_limit'], true);
					add_post_meta($coupon_id, 'usage_limit_per_user', $coupon['usage_per_customer'], true);
					add_post_meta($coupon_id, 'expiry_date', $expiry_date, true);
					add_post_meta($coupon_id, 'free_shipping', $free_shipping, true);
					add_post_meta($coupon_id, 'usage_count', $coupon['times_used'], true);
					
					// Products restrictions
					$products = array();
					$restricted_product_ids = explode(',', $coupon['product_ids']);
					foreach ( $restricted_product_ids as $product_id ) {
						if ( array_key_exists($product_id, $products_ids) ) {
							$products[] = $products_ids[$product_id];
						}
					}
					if ( !empty($products) ) {
						add_post_meta($coupon_id, 'product_ids', implode(',', $products), true);
					}
				}
				// Increment the last imported coupon ID
				update_option('fgm2wc_last_coupon_id', $coupon['coupon_id']);
				
				if ( defined('WP_CLI') ) {
					$progress_cli->tick(1);
				}
			}
			if ( defined('WP_CLI') ) {
				$progress_cli->finish();
			}
			
			$this->plugin->progressbar->increment_current_count($coupons_count);
			$this->plugin->display_admin_notice(sprintf(_n('%d coupon imported', '%d coupons imported', $imported_coupons_count, $this->plugin->get_plugin_name()), $imported_coupons_count));
		}

		/**
		 * Get the Magento coupons
		 *
		 * @return array of coupons
		 */
		private function get_coupons() {
			$coupons = array();

			if ( $this->plugin->table_exists('salesrule_coupon') ) {
				$last_magento_coupon_id = (int)get_option('fgm2wc_last_coupon_id'); // to restore the import where it left

				$prefix = $this->plugin->plugin_options['prefix'];
				$sql = "
					SELECT c.coupon_id, c.code, c.usage_limit, c.usage_per_customer, c.times_used,
					r.name, r.description, r.from_date, r.to_date, r.is_active, r.stop_rules_processing, r.product_ids, r.simple_action, r.discount_amount, r.simple_free_shipping
					FROM {$prefix}salesrule_coupon c
					INNER JOIN {$prefix}salesrule r ON r.rule_id = c.rule_id
					WHERE c.coupon_id > '$last_magento_coupon_id'
					ORDER BY c.coupon_id
				";
				$coupons = $this->plugin->magento_query($sql);
			}
			
			return $coupons;
		}
		
	}
}
