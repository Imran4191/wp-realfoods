<?php
/**
 * Up Sell and Cross Sell class
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      2.17.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
 */

if ( !class_exists('FG_Magento_to_WooCommerce_Up_Cross_Sell', false) ) {

	/**
	 * Up Sell and Cross Sell class
	 *
	 * @package    FG_Magento_to_WooCommerce_Premium
	 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Magento_to_WooCommerce_Up_Cross_Sell {

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
		 * Import the Up Sell, Cross Sell and related products for every products
		 * 
		 */
		public function import_up_and_cross_sells() {
			$this->plugin->log(__('Importing Up Sell and Cross Sell...', $this->plugin->get_plugin_name()));
			$imported_product_links_count = 0;
			$imported_products_in_all_languages = $this->plugin->get_imported_magento_products();
			
			$product_links = $this->get_product_links();
			foreach ( $product_links as $product_link ) {
				foreach ( $imported_products_in_all_languages as $imported_products ) {
					if ( isset($imported_products[$product_link['product_id']]) && isset($imported_products[$product_link['linked_product_id']]) ) {
						$wc_product_id = $imported_products[$product_link['product_id']];
						$wc_linked_product_id = $imported_products[$product_link['linked_product_id']];

						switch ( $product_link['code'] ) {
							case 'relation':
							case 'up_sell':
								$meta_key = '_upsell_ids';
								break;

							case 'cross_sell':
								$meta_key = '_crosssell_ids';
								break;

							default:
								$meta_key = '';
						}
						if ( !empty($meta_key) ) {
							$product_ids = get_post_meta($wc_product_id, $meta_key, true);
							if ( !is_array($product_ids) ) {
								$product_ids = array();
							}
							if ( !in_array($wc_linked_product_id, $product_ids) ) {
								$product_ids[] = $wc_linked_product_id;
								update_post_meta($wc_product_id, $meta_key, $product_ids);
								$imported_product_links_count++;
							}
						}
					}
				}
			}
			$this->plugin->display_admin_notice(sprintf(_n('%d Up Sell and Cross Sell imported', '%d Up Sell and Cross Sell imported', $imported_product_links_count, $this->plugin->get_plugin_name()), $imported_product_links_count));
		}
		
		/**
		 * Get the products Up Sell and Cross Sell
		 * 
		 * @return array Product links
		 */
		private function get_product_links() {
			$product_links = array();
			$prefix = $this->plugin->plugin_options['prefix'];
			$sql = "
				SELECT p.entity_id AS product_id, pl.linked_product_id, plt.code
				FROM {$prefix}catalog_product_link pl
				INNER JOIN {$prefix}catalog_product_link_type plt ON plt.link_type_id = pl.link_type_id
				INNER JOIN {$prefix}catalog_product_entity p ON p.{$this->plugin->entity_id_field} = pl.product_id
				WHERE plt.code IN('relation', 'up_sell', 'cross_sell')
			";
			$product_links = $this->plugin->magento_query($sql);
			
			return $product_links;
		}

	}
}
