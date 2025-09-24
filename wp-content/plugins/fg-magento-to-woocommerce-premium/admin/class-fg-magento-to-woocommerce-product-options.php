<?php
/**
 * Product options class
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      1.10.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
 */

if ( !class_exists('FG_Magento_to_WooCommerce_Product_Options', false) ) {

	/**
	 * Product options class
	 *
	 * @package    FG_Magento_to_WooCommerce_Premium
	 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Magento_to_WooCommerce_Product_Options extends FG_Magento_to_WooCommerce_Attributes {

		private $option_values = array(); // Options values
		private $stock_field = ''; // Stock field in the catalog_product_option_type_value table
		
		/**
		 * Import the Magento options
		 *
		 */
		public function import_options() {
			$this->option_values = array();
			
			if ( defined('FGM2WCP_IMPORT_PRODUCT_OPTIONS_AS_ADDONS') ) {
				return;
			}
			
			if ( isset($this->plugin->premium_options['skip_products']) && $this->plugin->premium_options['skip_products'] ) {
				return;
			}
			
			if ( isset($this->plugin->premium_options['skip_attributes']) && $this->plugin->premium_options['skip_attributes'] ) {
				return;
			}
			
			if ( $this->plugin->import_stopped() ) {
				return;
			}
			
			$this->plugin->log(__('Importing options...', $this->plugin->get_plugin_name()));
			
			$this->stock_field = $this->set_stock_field();
			$options = $this->get_options();
			$options_count = count($options);
			foreach ( $options as $option ) {
				
				// Increment the Magento last imported option ID
				update_option('fgm2wc_last_magento_option_id', $option['option_id']);
				
				if ( $this->is_custom_attribute($option) ) {
					continue; // Don't import the custom attributes as predefined attributes
				}

				// Create the attribute
				$option_type = ($option['type'] == 'drop_down')? 'select': 'text';
				$option_type = apply_filters('fgm2wc_option_type', $option_type, $option);
				$taxonomy = $this->create_woocommerce_attribute($option['title'], $option['title'], $option_type);
				
				// Create the attribute values
				$option_values = $this->get_option_values($option['option_id']);
				$terms = array();
				foreach ( $option_values as $option_value ) {
					$title = wp_unslash(apply_filters('pre_term_name', $option_value['title'], $taxonomy)); // Fix names with double spaces
					if ( !isset($this->option_values[$taxonomy][$title]) ) { // Don't reimport already imported values
						$option_values_term_id = $this->create_woocommerce_attribute_value($taxonomy, $title, '_fgm2wc_option_value', $title, 0);
						if ( $option_values_term_id != 0 ) {
							$this->option_values[$taxonomy][$title] = $option_values_term_id;
							$terms[] = $option_values_term_id;
							do_action('fgm2wc_post_create_woocommerce_option_value', $option_values_term_id, $option_value, $option_type, $taxonomy);
						}
					}
				}

				// Update cache
				if ( !empty($terms) ) {
					clean_term_cache($terms, $taxonomy);
				}
			}
			$this->option_values = $this->get_imported_attribute_values('_fgm2wc_option_value');
			$this->plugin->display_admin_notice(sprintf(_n('%d option imported', '%d options imported', $options_count, $this->plugin->get_plugin_name()), $options_count));
			
			// Empty option taxonomies cache
			delete_transient('wc_attribute_taxonomies');
			wp_cache_flush();
		}
		
		/**
		 * Set the stock field
		 * 
		 * @since 2.62.0
		 * 
		 * @return string Stock field
		 */
		private function set_stock_field() {
			$stock_field = '';
			$supported_fields = array('stock', 'customoptions_qty');
			foreach ( $supported_fields as $supported_field ) {
				if ( $this->plugin->column_exists('catalog_product_option_type_value', $supported_field) ) {
					$stock_field = $supported_field;
					break;
				}
			}
			return $stock_field;
		}
		
		/**
		 * Get the Magento options
		 *
		 * @return array of options
		 */
		private function get_options() {
			$options = array();
			$prefix = $this->plugin->plugin_options['prefix'];

			$last_magento_option_id = (int)get_option('fgm2wc_last_magento_option_id'); // to restore the import where it left
			
			$sql = "
				SELECT DISTINCT o.option_id, ot.title, o.type
				FROM {$prefix}catalog_product_option_title ot
				INNER JOIN {$prefix}catalog_product_option o ON o.option_id = ot.option_id
				WHERE ot.title IS NOT NULL
				AND o.option_id > '$last_magento_option_id'
				ORDER BY o.option_id
			";
			$options = $this->plugin->magento_query($sql);
			
			return $options;
		}
		
		/**
		 * Check if the option needs to be a custom attribute
		 * 
		 * @since 2.43.0
		 * 
		 * @param array $option Option
		 * @return bool Is it a custom attribute?
		 */
		private function is_custom_attribute($option) {
			$result = in_array($option['type'], array('area', 'date', 'time', 'date_time', 'file'));
			return $result;
		}
		
		/**
		 * Get the Magento option values
		 *
		 * @param string $option_id Option ID
		 * @return array of options values
		 */
		private function get_option_values($option_id) {
			$option_values = array();

			$prefix = $this->plugin->plugin_options['prefix'];
			$sql = "
				SELECT DISTINCT ott.option_type_id, ott.title
				FROM {$prefix}catalog_product_option_type_title ott
				INNER JOIN {$prefix}catalog_product_option_type_value otv ON otv.option_type_id = ott.option_type_id
				WHERE otv.option_id = '$option_id'
			";
			$option_values = $this->plugin->magento_query($sql);
			
			return $option_values;
		}
		
		/**
		 * Import the Magento product options
		 *
		 * @param int $new_product_id WordPress ID
		 * @param array $product Magento product
		 */
		public function import_product_options($new_product_id, $product) {
			if ( isset($this->plugin->premium_options['skip_attributes']) && $this->plugin->premium_options['skip_attributes'] ) {
				return;
			}
			
			// Assign the options to the product
			$options = $this->get_product_options($product['entity_id']);
			foreach ( $options as $option ) {
				$option_title = $this->get_product_option_title($option['option_id'], $this->plugin->store_id);
				$value_found = false;
				$option_name = $this->plugin->normalize_attribute_name($option_title);
				$taxonomy = 'pa_' . $option_name;

				// Set the relationship between the product and the option values
				$option_values = $this->get_product_options_values($option['option_id']);
				$product_attribute_values = array();
				foreach ( $option_values as $option_value ) {
					$title = $this->get_product_option_type_title($option_value['option_type_id'], $this->plugin->store_id);
					$title = wp_unslash(apply_filters('pre_term_name', $title, $taxonomy)); // Fix names with double spaces
					$price = $this->get_product_option_type_price($option_value['option_type_id'], $this->plugin->store_id);
					if ( isset($this->option_values[$taxonomy][$title]) ) {
						$this->set_object_terms($new_product_id, $this->option_values[$taxonomy][$title], $option_value['sort_order']);
						$sku = '';
						$option_sku = !empty($option_value['sku'])? $option_value['sku'] : sanitize_title($title);
						// Add a dash prefix in the SKU if not present
						if ( !empty($option_sku) ) {
							if ( strpos($option_sku, '-') === 0 ) {
								$sku = $option_sku;
							} else {
								$sku = '-' . $option_sku;
							}
						}
						$product_attribute_values[$title] = array(
							'price'		=> $price,
							'sku'		=> $sku,
							'stock'		=> $option_value['stock'],
						);
						$value_found = true;
					}
				}
				
				// Create the product option only if a value was found
				if ( $value_found ) {
					$args = array(
						'position'		=> $option['sort_order'],
						'is_visible'	=> '1',
						'is_variation'	=> '1',
					);
					$this->create_woocommerce_product_attribute($new_product_id, $taxonomy, $args);
					$this->create_product_attribute_values($new_product_id, $taxonomy, $product_attribute_values);
				}
			}
		}
		
		/**
		 * Get the Magento options of a product
		 * 
		 * @param int $product_id Product ID
		 * @return array of product options
		 */
		private function get_product_options($product_id) {
			$options = array();
			$prefix = $this->plugin->plugin_options['prefix'];

			$sql = "
				SELECT o.option_id, o.sort_order
				FROM {$prefix}catalog_product_option o
				WHERE o.product_id = $product_id
				ORDER BY o.sort_order
			";
			$options = $this->plugin->magento_query($sql);
			
			return $options;
		}
		
		/**
		 * Get the title of an option
		 * 
		 * @param int $option_id Option ID
		 * @param int $store_id Store ID
		 * @return string Title
		 */
		public function get_product_option_title($option_id, $store_id) {
			$title = '';
			$prefix = $this->plugin->plugin_options['prefix'];

			$sql = "
				SELECT ot.title
				FROM {$prefix}catalog_product_option_title ot
				WHERE ot.option_id = $option_id
				AND ot.store_id IN (0, $store_id)
				AND ot.title IS NOT NULL
				ORDER BY ot.store_id DESC
				LIMIT 1
			";
			$result = $this->plugin->magento_query($sql);
			if ( isset($result[0]) ) {
				$title = $result[0]['title'];
			}
			
			return $title;
		}
		
		/**
		 * Get the price of an option
		 * 
		 * @since 2.36.0
		 * 
		 * @param int $option_id Option ID
		 * @param int $store_id Store ID
		 * @return float Price
		 */
		public function get_product_option_price($option_id, $store_id) {
			$price = '';
			$prefix = $this->plugin->plugin_options['prefix'];

			$sql = "
				SELECT op.price
				FROM {$prefix}catalog_product_option_price op
				WHERE op.option_id = $option_id
				AND op.store_id IN (0, $store_id)
				ORDER BY op.store_id DESC
				LIMIT 1
			";
			$result = $this->plugin->magento_query($sql);
			if ( isset($result[0]) ) {
				$price = $result[0]['price'];
			}
			
			return $price;
		}
		
		/**
		 * Get the Magento options values of a product
		 * 
		 * @param int $option_id Option ID
		 * @return array of product options values
		 */
		public function get_product_options_values($option_id) {
			$options_values = array();
			$prefix = $this->plugin->plugin_options['prefix'];
			
			if ( !empty($this->stock_field) ) {
				$stock_column = 'otv.' . $this->stock_field;
			} else {
				$stock_column = "''";
			}
			$sql = "
				SELECT otv.option_type_id, otv.sku, otv.sort_order, $stock_column AS stock
				FROM {$prefix}catalog_product_option_type_value otv
				LEFT JOIN {$prefix}catalog_product_option_type_title ott ON ott.option_type_id = otv.option_type_id AND ott.store_id IN(0, {$this->plugin->store_id})
				WHERE otv.option_id = $option_id
				ORDER BY otv.sort_order, ott.title
			";
			$options_values = $this->plugin->magento_query($sql);
			
			return $options_values;
		}
		
		/**
		 * Get the title of an option type
		 * 
		 * @param int $option_type_id Option Type ID
		 * @param int $store_id Store ID
		 * @return string Title
		 */
		public function get_product_option_type_title($option_type_id, $store_id) {
			$title = '';
			$prefix = $this->plugin->plugin_options['prefix'];

			$sql = "
				SELECT ott.title
				FROM {$prefix}catalog_product_option_type_title ott
				WHERE ott.option_type_id = $option_type_id
				AND ott.store_id IN (0, $store_id)
				ORDER BY ott.store_id DESC
				LIMIT 1
			";
			$result = $this->plugin->magento_query($sql);
			if ( isset($result[0]) ) {
				$title = $result[0]['title'];
			}
			
			return $title;
		}
		
		/**
		 * Get the price of an option type
		 * 
		 * @param int $option_type_id Option Type ID
		 * @param int $store_id Store ID
		 * @return float Price
		 */
		public function get_product_option_type_price($option_type_id, $store_id) {
			$price = 0.0;
			$prefix = $this->plugin->plugin_options['prefix'];

			$sql = "
				SELECT otp.price
				FROM {$prefix}catalog_product_option_type_price otp
				WHERE otp.option_type_id = $option_type_id
				AND otp.store_id IN (0, $store_id)
				ORDER BY otp.store_id DESC
				LIMIT 1
			";
			$result = $this->plugin->magento_query($sql);
			if ( isset($result[0]) ) {
				$price = $result[0]['price'];
			}
			
			return $price;
		}
		
		/**
		 * Reset the Magento last imported option ID
		 *
		 */
		public function reset_options() {
			update_option('fgm2wc_last_magento_option_id', 0);
		}
		
	}
}
