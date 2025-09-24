<?php
/**
 * Downloadable products
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      2.27.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
 */

if ( !class_exists('FG_Magento_to_WooCommerce_Downloadable_Products', false) ) {

	/**
	 * Downloadable products
	 *
	 * @package    FG_Magento_to_WooCommerce_Premium
	 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Magento_to_WooCommerce_Downloadable_Products {

		private $plugin;
		
		/**
		 * Initialize the class and set its properties.
		 *
		 * @param object $plugin Admin plugin
		 */
		public function __construct($plugin) {

			$this->plugin = $plugin;
		}
		
		/**
		 * Sets the virtual or downloadable type
		 *
		 * @since 2.15.0
		 * 
		 * @param int $new_post_id WordPress ID
		 * @param array $product Magento product
		 */
		public function set_virtual_downloadable_type($new_post_id, $product) {
			switch ( $product['type_id'] ) {
				case 'virtual':
					// Set the virtual attribute
					update_post_meta($new_post_id, '_virtual', 'yes');
					break;

				case 'downloadable':
					// Set the downloadable attribute
					update_post_meta($new_post_id, '_downloadable', 'yes');
					update_post_meta($new_post_id, '_virtual', 'yes');
					break;
			}
		}

		/**
		 * Import the downloadable files for a product
		 * 
		 * @since 2.26.0
		 * 
		 * @param int $new_post_id WordPress ID
		 * @param array $product Magento product
		 * @param float $regular_price Product regular price
		 * @param float $sale_price Product sale price
		 */
		public function import_downloadable_files($new_post_id, $product, $regular_price, $sale_price) {
			if ( isset($this->plugin->plugin_options['skip_media']) && $this->plugin->plugin_options['skip_media'] ) {
				return;
			}
			if ( $product['type_id'] == 'downloadable' ) {
				$downloads = $this->get_downloadable_files($product['entity_id']);
				if ( empty($downloads) ) {
					return;
				}
				
				$downloadable_files = array();
				$file_titles = array();
				$download_limit = 0;
				foreach ( $downloads as &$download ) {
					$file_title = $this->get_downloadable_link_title($download['link_id']);

					// Upload the file
					if ( $download['link_type'] == 'url' ) {
						$filename = $download['link_url'];
					} else {
						$filename = $this->plugin->media_path . '/downloadable/files/links' . $download['link_file'];
					}
					
					$upload_path = $this->wc_upload_dir($filename, $product['created_at']);
					// Make sure we have an uploads directory
					if ( !wp_mkdir_p($upload_path) ) {
						$this->plugin->display_admin_error(sprintf(__("Unable to create directory %s", $this->plugin->get_plugin_name()), $upload_path));
						continue;
					}
					
					// Relative URLs
					if ( !preg_match('/^http/', $filename) ) {
						if ( strpos($filename, '/') === 0 ) { // Avoid a double slash
							$filename = untrailingslashit($this->plugin->plugin_options['url']) . $filename;
						} else {
							$filename = trailingslashit($this->plugin->plugin_options['url']) . $filename;
						}
					}
					
					$basename = basename($filename);
					if ( empty($file_title) ) {
						$file_title = $basename;
					}
					$file_titles[] = $file_title;
					$download['name'] = $file_title;
					$new_full_filename = $upload_path . '/' . $basename;

					$old_filename = $filename;
					
					if ( ! @$this->plugin->remote_copy($old_filename, $new_full_filename) ) {
						$error = error_get_last();
						$error_message = $error['message'];
						$this->plugin->display_admin_error("Can't copy $old_filename to $new_full_filename : $error_message");
						continue;
					}
					$filetype = wp_check_filetype($new_full_filename);
					$attachment_id = $this->plugin->insert_attachment($file_title, $basename, $new_full_filename, '', $product['created_at'], $filetype['type']);
					if ( $attachment_id !== false ) {
						$download_id = md5($filename);
						$downloadable_data = array(
							'name' => $file_title,
							'file' => wp_get_attachment_url($attachment_id),
						);
						$downloadable_files[$download_id] = $downloadable_data;
						$download['data'][$download_id] = $downloadable_data;
					}
					
					// Download limit
					if ( $download['number_of_downloads'] > $download_limit ) { // Max of all the downloads limits
						$download_limit = $download['number_of_downloads'];
					}
				}
				
				if ( isset($product['links_purchased_separately']) && $product['links_purchased_separately'] ) {
					// Create the downloadable files as product attributes
					$attribute_name = 'Downloadable files';
					$attribute_slug = sanitize_title($attribute_name);
					$product_attributes = get_post_meta($new_post_id, '_product_attributes', true);
					if ( empty($product_attributes) ) {
						$product_attributes = array();
					}
					$product_attributes[$attribute_slug] = array(
						'name' => $attribute_name,
						'value' => implode('|', $file_titles),
						'is_visible' => '1',
						'is_variation' => '1',
						'is_taxonomy' => '0',
					);
					update_post_meta($new_post_id, '_product_attributes', $product_attributes);
					
					// Import the downloadable files as variations
					foreach ( $downloads as &$download ) {
						$download_price = $this->get_downloadable_link_price($download['link_id']);
						$this->create_download_variation($new_post_id, $product, $download, $download_price, $regular_price, $sale_price, $attribute_slug, $download['link_id']);
					}

					// Set the product type as variable
					wp_set_object_terms($new_post_id, $this->plugin->product_types['variable'], 'product_type', false);

				} else {
					// Attach the downloads to the product
					add_post_meta($new_post_id, '_downloadable_files', $downloadable_files, true);
					add_post_meta($new_post_id, '_download_limit', ($download_limit > 0)? $download_limit : -1, true);
					foreach ( $downloads as $download ) {
						add_post_meta($new_post_id, '_fgm2wc_old_link_id', $download['link_id'], true);
					}
				}
			}
		}

		/**
		 * Get the downloadable files
		 * 
		 * @since 2.26.0
		 * 
		 * @param int $product_id Product ID
		 * @return array Files
		 */
		private function get_downloadable_files($product_id) {
			$files = array();
			$prefix = $this->plugin->plugin_options['prefix'];

			$sql = "
				SELECT l.link_id, l.number_of_downloads, l.link_url, l.link_file, l.link_type
				FROM {$prefix}downloadable_link l
				WHERE l.product_id = '$product_id'
				ORDER BY l.sort_order
			";
			$files = $this->plugin->magento_query($sql);

			return $files;
		}

		/**
		 * Get the downloadable file title
		 * 
		 * @since 2.27.0
		 * 
		 * @param int $link_id Link ID
		 * @return string Title
		 */
		private function get_downloadable_link_title($link_id) {
			$title = '';
			$prefix = $this->plugin->plugin_options['prefix'];

			$sql = "
				SELECT lt.title
				FROM {$prefix}downloadable_link_title lt
				WHERE lt.link_id = $link_id
				AND lt.store_id IN (0, {$this->plugin->store_id})
				ORDER BY lt.store_id DESC
			";
			$result = $this->plugin->magento_query($sql);
			if ( count($result) > 0 ) {
				$title = $result[0]['title'];
			}

			return $title;
		}

		/**
		 * Get the downloadable file price
		 * 
		 * @since 2.27.0
		 * 
		 * @param int $link_id Link ID
		 * @return float Price
		 */
		private function get_downloadable_link_price($link_id) {
			$price = 0.0;
			$prefix = $this->plugin->plugin_options['prefix'];

			$sql = "
				SELECT lp.price
				FROM {$prefix}downloadable_link_price lp
				WHERE lp.link_id = $link_id
				AND lp.website_id IN (0, {$this->plugin->website_id})
				ORDER BY lp.website_id DESC
			";
			$result = $this->plugin->magento_query($sql);
			if ( count($result) > 0 ) {
				$price = $result[0]['price'];
			}

			return $price;
		}

		/**
		 * Get the WooCommerce uploads dir
		 * 
		 * @since 2.26.0
		 * 
		 * @param string $filename Filename
		 * @param date $date Date
		 * @return string Upload directory
		 */
		private function wc_upload_dir($filename, $date) {
			$wp_upload_dir = wp_upload_dir();
			$upload_path = $wp_upload_dir['basedir'];
			$upload_dir = $this->upload_dir($filename, $date);
			$upload_dir = str_replace($upload_path, $upload_path . '/woocommerce_uploads', $upload_dir);
			return $upload_dir;
		}

		/**
		 * Determine the media upload directory
		 * 
		 * @since 2.26.0
		 * 
		 * @param string $filename Filename
		 * @param date $date Date
		 * @return string Upload directory
		 */
		private function upload_dir($filename, $date) {
			$upload_dir = wp_upload_dir(date('Y/m', strtotime($date)));
			$use_yearmonth_folders = get_option('uploads_use_yearmonth_folders');
			if ( $use_yearmonth_folders ) {
				$upload_path = $upload_dir['path'];
			} else {
				$short_filename = preg_replace('#.*img/#', '/', $filename);
				if ( strpos($short_filename, '/') != 0 ) {
					$short_filename = '/' . $short_filename; // Add a slash before the filename
				}
				$upload_path = $upload_dir['basedir'] . untrailingslashit(dirname($short_filename));
			}
			return $upload_path;
		}
		
		/**
		 * Create the download variation
		 * 
		 * @param int $new_product_id WooCommerce product ID
		 * @param array $product Product
		 * @param array $download Download data
		 * @param float $download_price Download price
		 * @param float $regular_price Product regular price
		 * @param float $sale_price Product sale price
		 * @param string $attribute_slug Attribute slug
		 * @param int $link_id Link ID
		 * @return int Post ID
		 */
		private function create_download_variation($new_product_id, $product, $download, $download_price, $regular_price, $sale_price, $attribute_slug, $link_id) {
			// Date
			$date = $product['created_at'];
			
			$new_post = array(
				'post_title'	=> 'Variation # of ' . $product['name'],
				'post_name'		=> "product-$new_product_id-variation",
				'post_date'		=> $date,
				'post_parent'	=> $new_product_id,
				'menu_order'	=> 0,
				'post_type'		=> 'product_variation',
				'post_status'	=> 'publish',
			);
			$new_post_id = wp_insert_post($new_post);
			
			if ( $new_post_id ) {
				add_post_meta($new_post_id, '_fgm2wc_old_link_id', $link_id, true);
				add_post_meta($new_post_id, '_downloadable', 'yes', true);
				add_post_meta($new_post_id, 'attribute_' . $attribute_slug, $download['name'], true);
				
				// Prices
				$price = $regular_price + $download_price;
				add_post_meta($new_post_id, '_regular_price', $price, true);
				if ( $sale_price != 0 ) {
					$download_sale_price = $sale_price + $download_price;
					add_post_meta($new_post_id, '_price', floatval($download_sale_price), true);
					add_post_meta($new_post_id, '_sale_price', floatval($download_sale_price), true);
				} else {
					add_post_meta($new_post_id, '_price', floatval($price), true);
				}
				
				// Attach the downloads to the product
				if ( isset($download['data']) ) {
					add_post_meta($new_post_id, '_downloadable_files', $download['data'], true);
				}
				
				// Download limit
				$download_limit = ($download['number_of_downloads'] > 0)? $download['number_of_downloads'] : -1;
				add_post_meta($new_post_id, '_download_limit', $download_limit, true);
			}
			return $new_post_id;
		}
		
	}
}
