<?php

/**
 * URLs module
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      2.7.0
 *
 * @package    FG_Magento_to_Woocommerce_Premium
 * @subpackage FG_Magento_to_Woocommerce_Premium/admin
 */

if ( !class_exists('FG_Magento_to_Woocommerce_Urls', false) ) {

	/**
	 * URLs class
	 *
	 * @package    FG_Magento_to_Woocommerce_Premium
	 * @subpackage FG_Magento_to_Woocommerce_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Magento_to_Woocommerce_Urls {
		
		private $plugin;
		private $imported_products = array();
		private $imported_product_categories = array();
		
		/**
		 * Initialize the class and set its properties.
		 *
		 * @param    object    $plugin       Admin plugin
		 */
		public function __construct( $plugin ) {
			$this->plugin = $plugin;
		}
		
		/**
		 * Reset the Magento last imported URL ID
		 *
		 */
		public function reset_urls() {
			update_option('fgm2wc_last_magento_url_id', 0);
			update_option('fgm2wc_last_magento_enterprise_url_id', 0);
		}
		
		/**
		 * Import the URLs
		 * 
		 */
		public function import_urls() {
			if ( isset($this->plugin->premium_options['skip_redirects']) && $this->plugin->premium_options['skip_redirects'] ) {
				return;
			}
			
			if ( $this->plugin->import_stopped() ) {
				return;
			}
			
			$message = __('Importing redirects...', $this->plugin->get_plugin_name());
			if ( defined('WP_CLI') ) {
				$progress_cli = \WP_CLI\Utils\make_progress_bar($message, $this->get_urls_count());
			} else {
				$this->plugin->log($message);
			}
			$imported_redirect_count = 0;
			
			$this->imported_products = $this->plugin->get_imported_magento_products();
			$this->imported_product_categories = $this->plugin->get_term_metas_by_metakey('_fgm2wc_old_product_category_id' . '-lang' . $this->plugin->default_language);
			
			// Import the Magento Community Edition URLs
			do {
				if ( $this->plugin->import_stopped() ) {
					return;
				}
				$urls = $this->get_urls($this->plugin->chunks_size);
				$urls_count = count($urls);

				foreach ( $urls as $url ) {
					// Increment the Magento last imported URL ID
					update_option('fgm2wc_last_magento_url_id', $url['url_rewrite_id']);
					
					if ( $this->import_url($url['request_path'], $url['entity_id'], $url['entity_type']) ) {
						$imported_redirect_count++;
					}
				}
				$this->plugin->progressbar->increment_current_count($urls_count);
				
				if ( defined('WP_CLI') ) {
					$progress_cli->tick($this->plugin->chunks_size);
				}
			} while ( ($urls != null) && ($urls_count > 0) );
			
			if ( defined('WP_CLI') ) {
				$progress_cli->finish();
			}
			
			// Import the Magento Enterprise Edition URLs
			if ( $this->plugin->table_exists('enterprise_url_rewrite_redirect') ) {
				$message = __('Importing Enterprise Edition redirects...', $this->plugin->get_plugin_name());
				if ( defined('WP_CLI') ) {
					$progress_cli = \WP_CLI\Utils\make_progress_bar($message, $this->get_enterprise_urls_count());
				} else {
					$this->plugin->log($message);
				}
				do {
					if ( $this->plugin->import_stopped() ) {
						return;
					}
					$urls = $this->get_enterprise_urls($this->plugin->chunks_size);
					$urls_count = count($urls);

					foreach ( $urls as $url ) {
						// Increment the Magento last imported URL ID
						update_option('fgm2wc_last_magento_enterprise_url_id', $url['redirect_id']);

						if ( $this->import_url($url['identifier'], $url['product_id'], $url['category_id']) ) {
							$imported_redirect_count++;
						}
					}
					$this->plugin->progressbar->increment_current_count($urls_count);

					if ( defined('WP_CLI') ) {
						$progress_cli->tick($this->plugin->chunks_size);
					}
				} while ( ($urls != null) && ($urls_count > 0) );
				
				if ( defined('WP_CLI') ) {
					$progress_cli->finish();
				}
			}
			
			unset($this->imported_products);
			unset($this->imported_product_categories);
			
			$this->plugin->display_admin_notice(sprintf(_n('%d redirect imported', '%d redirects imported', $imported_redirect_count, $this->plugin->get_plugin_name()), $imported_redirect_count));
		}
		
		/**
		 * Get the URLs
		 * 
		 * @param int $limit Number of urls max
		 * @return array of urls
		 */
		private function get_urls($limit=1000) {
			$urls = array();
			$prefix = $this->plugin->plugin_options['prefix'];
			$last_magento_url_id = (int)get_option('fgm2wc_last_magento_url_id'); // to restore the import where it left

			if ( version_compare($this->plugin->magento_version, '2', '<') ) {
				// Magento 1
				$sql = "
					SELECT u.url_rewrite_id, u.request_path, IFNULL(u.product_id, u.category_id) AS entity_id, IF(u.product_id IS NULL, 'category', 'product') AS entity_type
					FROM {$prefix}core_url_rewrite u
					WHERE u.url_rewrite_id > '$last_magento_url_id'
					LIMIT $limit
				";
			} else {
				// Magento 2+
				$sql = "
					SELECT u.url_rewrite_id, u.request_path, u.entity_id, u.entity_type
					FROM {$prefix}url_rewrite u
					WHERE u.url_rewrite_id > '$last_magento_url_id'
					LIMIT $limit
				";
			}
			
			$urls = $this->plugin->magento_query($sql);
			return $urls;
		}
		
		/**
		 * Get the Magento Enterprise Edition URLs
		 * 
		 * @since 2.19.0
		 * 
		 * @param int $limit Number of urls max
		 * @return array of urls
		 */
		private function get_enterprise_urls($limit=1000) {
			$urls = array();
			$prefix = $this->plugin->plugin_options['prefix'];
			$last_magento_url_id = (int)get_option('fgm2wc_last_magento_enterprise_url_id'); // to restore the import where it left

			$sql = "
				SELECT u.redirect_id, u.identifier, u.category_id, u.product_id
				FROM {$prefix}enterprise_url_rewrite_redirect u
				WHERE u.redirect_id > '$last_magento_url_id'
				LIMIT $limit
			";
			
			$urls = $this->plugin->magento_query($sql);
			return $urls;
		}
		
		/**
		 * Import an URL
		 * 
		 * @since 2.19.0
		 * 
		 * @param string $path URL path
		 * @param int $entity_id Entity ID (product, category)
		 * @param int $entity_type (product, category)
		 * @return bool URL imported?
		 */
		private function import_url($path, $entity_id, $entity_type) {
			$object_id = 0;
			$object_type = '';
			switch ( $entity_type ) {
				case 'product':
					// Product redirect
					if ( isset($this->imported_products[$this->plugin->default_language][$entity_id]) ) {
						$object_id = $this->imported_products[$this->plugin->default_language][$entity_id];
						$object_type = 'product';
					}
					break;
				case 'category':
					// Product category redirect
					if ( isset($this->imported_product_categories[$entity_id]) ) {
						$object_id = $this->imported_product_categories[$entity_id];
						$object_type = 'product_cat';
					}
					break;
			}
			if ( !empty($object_id) && !empty($object_type) ) {
				FG_Magento_to_Woocommerce_Redirect::add_redirect($path, $object_id, $object_type);
				return true;
			}
			return false;
		}
		
		/**
		 * Update the number of total elements found in Magento
		 * 
		 * @param int $count Number of total elements
		 * @return int Number of total elements
		 */
		public function get_total_elements_count($count) {
			if ( !isset($this->plugin->premium_options['skip_redirects']) || !$this->plugin->premium_options['skip_redirects'] ) {
				$count += $this->get_urls_count();
				if ( $this->plugin->table_exists('enterprise_url_rewrite_redirect') ) {
					$count += $this->get_enterprise_urls_count();
				}
			}
			return $count;
		}
		
		/**
		 * Get the number of URLs
		 * 
		 * @return int Number of URLs
		 */
		private function get_urls_count() {
			$count = 0;
			$prefix = $this->plugin->plugin_options['prefix'];
			$url_rewrite_table = version_compare($this->plugin->magento_version, '2', '<')? 'core_url_rewrite' : 'url_rewrite';

			$sql = "
				SELECT COUNT(*) AS nb
				FROM {$prefix}{$url_rewrite_table}
			";
			
			$result = $this->plugin->magento_query($sql);
			if ( isset($result[0]['nb']) ) {
				$count = $result[0]['nb'];
			}
			return $count;
		}
		
		/**
		 * Get the number of Magento Enterprise Edition URLs
		 * 
		 * @since 2.19.0
		 * 
		 * @return int Number of URLs
		 */
		private function get_enterprise_urls_count() {
			$count = 0;
			$prefix = $this->plugin->plugin_options['prefix'];

			$sql = "
				SELECT COUNT(*) AS nb
				FROM {$prefix}enterprise_url_rewrite_redirect
			";
			
			$result = $this->plugin->magento_query($sql);
			if ( isset($result[0]['nb']) ) {
				$count = $result[0]['nb'];
			}
			return $count;
		}
		
		/**
		 * Import a product URL
		 * 
		 * @since 2.19.0
		 * 
		 * @param int $new_post_id WordPress post ID
		 * @param array $product Product data
		 */
		public function import_product_url($new_post_id, $product) {
			if ( isset($product['url_path']) && !empty($product['url_path']) ) {
				FG_Magento_to_Woocommerce_Redirect::add_redirect($product['url_path'], $new_post_id, 'product');
			}
		}
		
		/**
		 * Import a product category URL
		 * 
		 * @since 2.19.0
		 * 
		 * @param int $new_term_id WordPress term ID
		 * @param array $category Product data
		 */
		public function import_product_category_url($new_term_id, $category) {
			if ( isset($category['url_path']) && !empty($category['url_path']) ) {
				FG_Magento_to_Woocommerce_Redirect::add_redirect($category['url_path'], $new_term_id, 'product_cat');
			}
		}
		
	}
}
