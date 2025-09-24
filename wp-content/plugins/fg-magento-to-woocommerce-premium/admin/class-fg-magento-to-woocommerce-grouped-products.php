<?php
/**
 * Grouped products
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      2.23.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
 */

if ( !class_exists('FG_Magento_to_WooCommerce_Grouped_Products', false) ) {

	/**
	 * Grouped products class
	 *
	 * @package    FG_Magento_to_WooCommerce_Premium
	 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Magento_to_WooCommerce_Grouped_Products {

		private $plugin;
		
		/**
		 * Initialize the class and set its properties.
		 *
		 * @param    object    $plugin       Admin plugin
		 */
		public function __construct( $plugin ) {

			$this->plugin = $plugin;
		}
		
		/**
		 * Set the parent product IDs for the products included in a grouped product
		 * 
		 * @since      1.10.0
		 */
		public function set_parent_products() {
			if ( isset($this->plugin->premium_options['skip_products']) && $this->premium_options['skip_products'] ) {
				return;
			}

			if ( version_compare($this->plugin->magento_version, '1.4', '<') ) {
				return;
			}
			
			$this->plugin->log(__('Setting grouped products relations...', $this->plugin->get_plugin_name()));
			
			// Get all the imported products with their Magento product IDs
			$imported_products_in_all_languages = $this->plugin->get_imported_magento_products();

			// Get the Magento grouped product relations
			$product_relations = $this->get_grouped_product_relations();

			foreach ( $product_relations as $product_relation ) {
				$product_id = $product_relation['child_id'];
				$parent_id = $product_relation['parent_id'];
				foreach ( $imported_products_in_all_languages as $imported_products ) {
					if ( isset($imported_products[$product_id]) && isset($imported_products[$parent_id]) ) {
						$wp_product_id = $imported_products[$product_id];
						$wp_parent_id = $imported_products[$parent_id];

						// Set the product as a child of its parent (new in WooCommerce 3.0)
						$children = get_post_meta($wp_parent_id, '_children', true);
						if ( empty($children) ) {
							$children = array();
						}
						$children[] = $wp_product_id;
						update_post_meta($wp_parent_id, '_children', $children);
					}
				}
			}
			$this->plugin->log(__('Grouped products relations set', $this->plugin->get_plugin_name()));
		}
		
		/**
		 * Get the Magento grouped product relations
		 * 
		 * @since      1.10.0
		 * 
		 * @return array Product relations
		 */
		private function get_grouped_product_relations() {
			$relations = array();
			$prefix = $this->plugin->plugin_options['prefix'];

			$sql = "
				SELECT r.child_id, r.parent_id
				FROM {$prefix}catalog_product_relation r
				INNER JOIN {$prefix}catalog_product_entity p ON p.entity_id = r.parent_id
				WHERE p.type_id = 'grouped'
			";
			$relations = $this->plugin->magento_query($sql);

			return $relations;
		}
		
		/**
		 * Import the child products of a grouped product
		 * 
		 * @param int $new_product_id WordPress ID
		 * @param array $product Magento product
		 */
		public function import_child_products($new_product_id, $product) {
			if ( $product['type_id'] == 'grouped' ) {
				$child_products = $this->get_child_products($product['entity_id']);
				foreach ( $child_products as $child_product ) {
					$new_post_id = $this->plugin->import_product($child_product['entity_id'], $this->plugin->default_language);
					if ( $new_post_id ) {
						$this->plugin->imported_products_count++;
						do_action('fgm2wc_post_import_product', $new_post_id, $child_product['entity_id']);
					}
				}
			}
		}
		
		/**
		 * Update the child products of a grouped product
		 * 
		 * @since 3.18.2
		 * 
		 * @param int $new_product_id WordPress ID
		 * @param array $product Magento product
		 */
		public function update_child_products($new_product_id, $product) {
			if ( $product['type_id'] == 'grouped' ) {
				$language = $this->plugin->default_language;
				$child_products = $this->get_child_products($product['entity_id']);
				foreach ( $child_products as $child_product ) {
					$child_product_id = $child_product['entity_id'];
					if ( isset($this->plugin->imported_products[$language][$child_product_id]) ) {
						$wp_child_product_id = $this->plugin->imported_products[$language][$child_product_id];

						// Other fields
						$child_product = array_merge($child_product, $this->plugin->get_other_product_fields($child_product_id, $this->plugin->product_type_id));

						// Stock
						$stock = $this->plugin->get_stock($child_product_id, $this->plugin->website_id);
						if ( empty($stock) ) {
							$stock = $this->plugin->get_stock($child_product_id, 0); // Get the stock of the website 0
						}
						$child_product = array_merge($child_product, $stock);
						$result = $this->plugin->update_product($wp_child_product_id, $child_product, $language);
						if ( $result ) {
							$this->plugin->updated_products_count++;
							do_action('fgm2wc_post_update_product', $wp_child_product_id, $child_product);
						}
					}
				}
			}
		}
		
		/**
		 * Get the child products of a product
		 * 
		 * @param int $product_id Product ID
		 * @return array Child product
		 */
		private function get_child_products($product_id) {
			$products = array();
			$prefix = $this->plugin->plugin_options['prefix'];

			if ( version_compare($this->plugin->magento_version, '1.4', '>=') ) {
				$sql = "
					SELECT DISTINCT p.entity_id, p.type_id, p.sku, p.created_at
					FROM {$prefix}catalog_product_entity p
					INNER JOIN {$prefix}catalog_product_relation r on r.child_id = p.entity_id
					INNER JOIN {$prefix}catalog_product_entity pp ON pp.entity_id = r.parent_id
					INNER JOIN {$prefix}catalog_product_entity_int pei ON pei.{$this->plugin->entity_id_field} = p.entity_id
					INNER JOIN {$prefix}eav_attribute a ON a.attribute_id = pei.attribute_id
					WHERE pp.entity_id = '$product_id'
					AND a.attribute_code = 'visibility'
					AND pei.value = 1 -- 'Not visible individually'
					ORDER BY p.entity_id
				";
				$products = $this->plugin->magento_query($sql);
			}
			
			return $products;
		}
		
	}
}
