<?php
/**
 * Taxes class
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      2.72.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
 */

if ( !class_exists('FG_Magento_to_WooCommerce_Taxes', false) ) {

	/**
	 * Taxes class
	 *
	 * @package    FG_Magento_to_WooCommerce_Premium
	 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Magento_to_WooCommerce_Taxes {

		private $plugin;
		private $imported_tax_classes = array();
		
		/**
		 * Initialize the class and set its properties.
		 *
		 * @param    object    $plugin       Admin plugin
		 */
		public function __construct( $plugin ) {
			$this->plugin = $plugin;
		}

		/**
		 * Reset the Magento last imported tax class ID
		 *
		 */
		public function reset_taxes() {
			update_option('fgm2wc_last_tax_class_id', 0);
		}
		
		/**
		 * Update the number of total elements found in Magento
		 * 
		 * @param int $count Number of total elements
		 * @return int Number of total elements
		 */
		public function get_total_elements_count($count) {
			if ( !isset($this->plugin->premium_options['skip_products']) || !$this->plugin->premium_options['skip_products'] ) {
				$count += $this->get_tax_classes_count();
			}
			return $count;
		}

		/**
		 * Get the number of Magento tax classes
		 * 
		 * @return int Number of taxes
		 */
		private function get_tax_classes_count() {
			$prefix = $this->plugin->plugin_options['prefix'];
			$sql = "
				SELECT COUNT(*) AS nb
				FROM {$prefix}tax_class t
				WHERE t.class_type = 'PRODUCT'
			";
			$result = $this->plugin->magento_query($sql);
			$taxes_count = isset($result[0]['nb'])? $result[0]['nb'] : 0;
			return $taxes_count;
		}

		/**
		 * Import the Magento tax classes
		 *
		 */
		public function import_tax_classes() {
			
			if ( $this->plugin->import_stopped() ) {
				return;
			}
			$this->plugin->log(__('Importing taxes...', $this->plugin->get_plugin_name()));
			$wc_tax_classes = $this->get_wc_tax_classes();
			
			$tax_classes = $this->get_tax_classes();
			$tax_class_count = count($tax_classes);
			$imported_tax_classes_count = 0;
			
			foreach ( $tax_classes as $tax_class ) {
				if ( !in_array($tax_class['class_name'], $wc_tax_classes) ) {
					$this->add_wp_tax_class($tax_class['class_name']);
					$imported_tax_classes_count++;
				}
				$this->imported_tax_classes[$tax_class['class_id']] = $tax_class['class_name'];
				
				// Increment the last imported tax class ID
				update_option('fgm2wc_last_tax_class_id', $tax_class['class_id']);
			}
			
			$this->plugin->progressbar->increment_current_count($tax_class_count);
			$this->plugin->display_admin_notice(sprintf(_n('%d tax class imported', '%d tax classes imported', $imported_tax_classes_count, $this->plugin->get_plugin_name()), $imported_tax_classes_count));
		}
		
		/**
		 * Get the WooCommerce tax classes
		 * 
		 * @since 2.77.0
		 * 
		 * @global object $wpdb
		 * @return array WooCommerce tax classes
		 */
		private function get_wc_tax_classes() {
			global $wpdb;
			$tax_classes = array();
			
			$sql = "
				SELECT t.name
				FROM {$wpdb->prefix}wc_tax_rate_classes t
			";
			$tax_classes = $wpdb->get_col($sql);
			
			return $tax_classes;
		}
		
		/**
		 * Add a tax class
		 * 
		 * @since 2.77.0
		 * 
		 * @global object $wpdb
		 * @param int|false Number of rows inserted, or false on error
		 */
		private function add_wp_tax_class($tax_class_name) {
			global $wpdb;
			
			return $wpdb->insert($wpdb->prefix . 'wc_tax_rate_classes', array(
				'name' => $tax_class_name,
				'slug' => sanitize_title($tax_class_name)
			));
		}
		
		/**
		 * Get the Magento tax classes
		 *
		 * @return array of tax classes
		 */
		private function get_tax_classes() {
			$tax_class = array();

			$last_tax_class_id = (int)get_option('fgm2wc_last_tax_class_id'); // to restore the import where it left

			$prefix = $this->plugin->plugin_options['prefix'];
			$sql = "
				SELECT t.class_id, t.class_name
				FROM {$prefix}tax_class t
				WHERE t.class_type = 'PRODUCT'
				AND t.class_id > '$last_tax_class_id'
				ORDER BY t.class_id
			";
			$tax_class = $this->plugin->magento_query($sql);

			return $tax_class;
		}
		
		/**
		 * Update the tax class for the product
		 * 
		 * @param int $new_post_id WP Post ID
		 * @param array $product Product data
		 */
		public function update_product_tax_class($new_post_id, $product) {
			if ( isset($product['tax_class_id']) ) {
				if ( $product['tax_class_id'] == 0 ) {
					// No tax
					add_post_meta($new_post_id, '_tax_status', 'none', true);
					
				} elseif ( array_key_exists($product['tax_class_id'], $this->imported_tax_classes) ) {
					// Tax class
					$meta_value = sanitize_title($this->imported_tax_classes[$product['tax_class_id']]);
					add_post_meta($new_post_id, '_tax_status', 'taxable', true);
					add_post_meta($new_post_id, '_tax_class', $meta_value, true);
				}
			}
		}
		
	}
}
