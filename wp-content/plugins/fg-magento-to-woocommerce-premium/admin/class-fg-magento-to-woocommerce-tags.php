<?php
/**
 * Tags class
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      2.90.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
 */

if ( !class_exists('FG_Magento_to_WooCommerce_Tags', false) ) {

	/**
	 * Tags class
	 *
	 * @package    FG_Magento_to_WooCommerce_Premium
	 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Magento_to_WooCommerce_Tags {
		
		private $plugin;
		
		/**
		 * Initialize the class and set its properties.
		 *
		 * @param    object    $plugin       Admin plugin
		 */
		public function __construct($plugin) {
			$this->plugin = $plugin;
		}
		
		/**
		 * Import the tags of a product
		 * 
		 * @param int $new_post_id WP post ID
		 * @param array $product Product data
		 */
		public function import_product_tags($new_post_id, $product) {
			$tags = $this->get_product_tags($product['entity_id']);
			wp_set_post_terms($new_post_id, $tags, 'product_tag', true);
		}
		
		/**
		 * Get the tags of a product
		 * 
		 * @param int $product_id Magento product ID
		 * @return array List of tags
		 */
		private function get_product_tags($product_id) {
			$tags = array();
			
			if ( $this->plugin->table_exists('tag') ) {
				$prefix = $this->plugin->plugin_options['prefix'];

				$sql = "
					SELECT t.name
					FROM {$prefix}tag t
					INNER JOIN {$prefix}tag_relation r ON r.tag_id = t.tag_id
					WHERE r.product_id = '$product_id'
				";
				$result = $this->plugin->magento_query($sql);
				foreach ( $result as $row ) {
					$tags[] = $row['name'];
				}
			}
			return $tags;
		}
		
	}
}
