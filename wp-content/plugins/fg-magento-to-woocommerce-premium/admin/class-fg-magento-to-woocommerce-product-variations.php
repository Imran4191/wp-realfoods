<?php
/**
 * Product variations class
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      1.10.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
 */

if ( !class_exists('FG_Magento_to_WooCommerce_Product_Variations', false) ) {

	/**
	 * Product options class
	 *
	 * @package    FG_Magento_to_WooCommerce_Premium
	 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Magento_to_WooCommerce_Product_Variations {

		private $plugin;
		private $too_many_variations_message_displayed = false; // True if we already displayed the message "Too many variations"
		private $min_variation_price;
		private $max_variation_price;
		
		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.10.0
		 * @param    object    $plugin       Admin plugin
		 */
		public function __construct( $plugin ) {

			$this->plugin = $plugin;
		}

		/**
		 * Import the Magento product variations
		 *
		 * @param int $new_product_id WordPress ID
		 * @param array $product Magento product
		 * @param float $regular_price Product regular price
		 * @param float $sale_price Product sale price
		 */
		public function import_product_variations($new_product_id, $product, $regular_price, $sale_price) {
			if ( isset($this->plugin->premium_options['skip_attributes']) && $this->plugin->premium_options['skip_attributes'] ) {
				return;
			}
			
			// Get the options variations
			$options_variations = $this->get_options_variations($new_product_id);
			
			// Get the super attributes prices
			$super_attributes_prices = array();
			if ( version_compare($this->plugin->magento_version, '2', '<') ) {
				$super_attributes_prices = $this->get_super_attributes_prices($product['entity_id']);
			}
			
			// Get the child products
			$child_products = $this->get_child_products($product['entity_id']);
			
			unset($this->min_variation_price);
			unset($this->max_variation_price);
			$instock = false; // Main product stock status
			
			if ( count($child_products) > 0 ) {
				
				// Get the attribute IDs of the parent product
				$attributes_ids_list = implode(', ', $this->get_attributes_ids_list($product['entity_id']));

				foreach ( $child_products as $child_product ) {
					$child_product_id = $child_product['entity_id'];
					
					// Other fields
					$child_product = array_merge($child_product, $this->plugin->get_other_product_fields($child_product_id, $this->plugin->product_type_id));
					
					// Stock
					$stock = $this->plugin->get_stock($child_product_id, $this->plugin->website_id);
					if ( empty($stock) ) {
						$stock = $this->plugin->get_stock($child_product_id, 0); // Get the stock of the website 0
					}
					$instock |= isset($stock['qty']) && ($stock['qty'] > 0);
					$child_product = array_merge($child_product, $stock);
					
					// Don't import the disabled child products
					if ( isset($this->plugin->premium_options['skip_disabled_products']) && $this->plugin->premium_options['skip_disabled_products'] ) {
						if ( $child_product['status'] != 1 ) {
							continue;
						}
					}
					if ( count($options_variations) > 0 ) {
						foreach ( $options_variations as $option_variation ) {
							// Save the variation
							$this->save_child_product_variation($new_product_id, $child_product, $attributes_ids_list, $super_attributes_prices, $option_variation, $regular_price, $sale_price);
						}
					} else {
						// Save the variation
						$this->save_child_product_variation($new_product_id, $child_product, $attributes_ids_list, $super_attributes_prices, null, $regular_price, $sale_price);
					}
				}
			} else {
				foreach ( $options_variations as $option_variation ) {
					// Save the variation
					$this->save_option_variation($new_product_id, $product, $option_variation, $regular_price, $sale_price);
				}
				do_action('fgm2wc_post_save_option_variations', $new_product_id, $product, $options_variations);
			}
			
			if ( count($child_products) + count($options_variations) > 0 ) {
				// Set the product type as "variable"
				wp_set_object_terms($new_product_id, $this->plugin->product_types['variable'], 'product_type', false);
				
				// Don't manage the stock at the product level
				update_post_meta($new_product_id, '_manage_stock', 'no');
				
				// Main product stock status
				$manage_stock = $this->plugin->set_manage_stock($product);
				$stock_status = ($instock || ($manage_stock == 'no'))? 'instock': 'outofstock';
				update_post_meta($new_product_id, '_stock_status', $stock_status);
				if ( $stock_status == 'instock' ) {
					wp_remove_object_terms($new_product_id, $this->plugin->product_visibilities['outofstock'], 'product_visibility');
				}
			}
			
			// Store the min and max variation prices
			if ( isset($this->min_variation_price) ) {
				update_post_meta($new_product_id, '_min_variation_price', $this->min_variation_price);
			}
			if ( isset($this->max_variation_price) ) {
				update_post_meta($new_product_id, '_max_variation_price', $this->max_variation_price);
			}
		}
		
		/**
		 * Get the options variations
		 * 
		 * @param int $new_product_id WooCommerce product ID
		 * @return array Options variations
		 */
		private function get_options_variations($new_product_id) {
			$variations = array();
			$variations_count = 1;
			$variations_limit = 1000;
			
			$product_attributes_values = get_post_meta($new_product_id, '_product_attributes_values', true);
			if ( is_array($product_attributes_values) ) {
				$attributes_values = array();
				foreach ( array_keys($product_attributes_values) as $taxonomy ) {
					// Get the attribute values
					$terms = wp_get_object_terms(array($new_product_id), $taxonomy, array('orderby' => 'term_order'));
					$attribute_values = array();
					if ( !is_wp_error($terms) ) {
						$variations_count *= count($terms);
						foreach ( $terms as $term ) {
							$term_name = html_entity_decode($term->name);
							$price = isset($product_attributes_values[$taxonomy][$term_name]['price'])? $product_attributes_values[$taxonomy][$term_name]['price']: 0.0;
							$sku = isset($product_attributes_values[$taxonomy][$term_name]['sku'])? $product_attributes_values[$taxonomy][$term_name]['sku']: '';
							$stock = isset($product_attributes_values[$taxonomy][$term_name]['stock'])? $product_attributes_values[$taxonomy][$term_name]['stock']: '';
							$attribute_values[$term->slug] = array(
								'attributes'	=> array($term->taxonomy => $term->slug),
								'price'			=> $price,
								'sku'			=> $sku,
								'stock'			=> $stock,
							);
						}
						$attributes_values[$taxonomy] = $attribute_values;
					}
				}
				if ( $variations_count <= $variations_limit ) {
					// Generate the variations
					$variations = $this->generate_variations($attributes_values);
				} else {
					$this->plugin->display_admin_error(sprintf(__('Too many variations (%d) for product #%d', $this->plugin->get_plugin_name()), $variations_count, $new_product_id));
					if ( !$this->too_many_variations_message_displayed ) {
						$this->plugin->display_admin_error(sprintf(__('You may need the <a href="%s" target="_blank">WooCommerce Product Add-Ons plugin</a> and the <a href="%s" target="_blank">Product Options add-on</a> to import the Magento options as add-ons instead of as variations.', $this->plugin->get_plugin_name()), 'https://woocommerce.com/products/product-add-ons/?aff=3777', 'https://www.fredericgilles.net/fg-magento-to-woocommerce/product-options/'));
						$this->too_many_variations_message_displayed = true;
					}
				}
			}
			
			return $variations;
		}
		
		/**
		 * Get the Magento option
		 *
		 * @param int $option_id Option ID
		 * @return array Option value
		 */
		private function get_attribute_option($option_id) {
			$option = array();

			$prefix = $this->plugin->plugin_options['prefix'];
			$sql = "
				SELECT o.option_id, o.attribute_id, o.sort_order, a.attribute_code
				FROM {$prefix}eav_attribute_option o
				INNER JOIN {$prefix}eav_attribute a ON a.attribute_id = o.attribute_id
				WHERE o.option_id = $option_id
				ORDER BY o.sort_order
				LIMIT 1
			";
			$result = $this->plugin->magento_query($sql);
			if ( isset($result[0]) ) {
				$option = $result[0];
			}
			
			return $option;
		}
		
		/**
		 * Save the child product variation
		 * 
		 * @param int $new_product_id WooCommerce product ID
		 * @param array $child_product Child product
		 * @param string $attributes_ids_list Comma separated list of product attributes IDs
		 * @param array $super_attributes_prices Super attributes prices
		 * @param array $option_variation Option variation
		 * @param float $parent_regular_price Product regular price
		 * @param float $parent_sale_price Product sale price
		 */
		private function save_child_product_variation($new_product_id, $child_product, $attributes_ids_list, $super_attributes_prices, $option_variation, $parent_regular_price, $parent_sale_price) {
			$child_product_id = $child_product['entity_id'];
			
			$store_id = $this->plugin->store_id;
			
			// Date
			$date = $child_product['created_at'];
			if ( strtotime($date) > time() || ($date == '0000-00-00 00:00:00')) {
				// Future or null date
				$date = date('Y-m-d H:i:s');
			}
			
			$new_post = array(
				'post_title'	=> $child_product['name'],
				'post_name'		=> isset($child_product['url_key'])? $child_product['url_key']: $child_product['name'],
				'post_date'		=> $date,
				'post_parent'	=> $new_product_id,
				'post_type'		=> 'product_variation',
				'post_status'	=> (!isset($child_product['status']) || ($child_product['status'] == 1))? 'publish': 'private',
			);
			$new_post_id = wp_insert_post($new_post);

			if ( $new_post_id ) {
				$option_price = 0.0;
				$use_super_attribute_price = false;
				// Get the option IDs of the variation
				$options_ids = $this->get_options_ids($child_product_id, $attributes_ids_list);
				foreach ( $options_ids as $option_id ) {
					$option = $this->get_attribute_option($option_id);
					if ( isset($option['attribute_code']) ) {
						$attribute_name = $this->plugin->normalize_attribute_name($option['attribute_code']);
						$taxonomy = 'pa_' . $attribute_name;
						$meta_key = '';
						$option_with_store_id = $option_id . '-' . $store_id;
						if ( isset($this->plugin->attribute_options[$taxonomy][$option_with_store_id]) ) {
							$meta_key = $option_with_store_id;
						} elseif ( isset($this->plugin->attribute_options[$taxonomy][$option_id]) ) {
							$meta_key = $option_id;
						}
						if ( !empty($meta_key) ) {
							$wp_term_id = $this->plugin->attribute_options[$taxonomy][$meta_key];
							$term = get_term_by('term_id', $wp_term_id, $taxonomy);
							if ( $term ) {
								$option_value = $term->slug;
								add_post_meta($new_post_id, 'attribute_' . $taxonomy, $option_value, true);
							}
						}
						
						// Super attribute price
						if ( isset($super_attributes_prices[$option['attribute_id']]) ) {
							if ( isset($super_attributes_prices[$option['attribute_id']][$option['option_id']])) {
								$option_price += $super_attributes_prices[$option['attribute_id']][$option['option_id']];
							}
							$use_super_attribute_price = true;
						}
					}
				}
				if ( is_array($option_variation) ) {
					foreach ( $option_variation['attributes'] as $taxonomy => $attribute_value ) {
						add_post_meta($new_post_id, 'attribute_' . $taxonomy, $attribute_value, true);
					}
					$option_price += $option_variation['price'];
				}

				// Prices
				$regular_price = (isset($child_product['price']) && !$use_super_attribute_price)? floatval($child_product['price']): $parent_regular_price;
				$sale_price = (isset($child_product['special_price']) && !$use_super_attribute_price)? floatval($child_product['special_price']) : $parent_sale_price;
				if ( ($this->plugin->plugin_options['sale_price'] == 'msrp') && isset($child_product['msrp']) && !empty($child_product['msrp']) ) {
					// Manufacturer´s Suggested Retail Price
					$regular_price = floatval($child_product['msrp']);
					$sale_price = isset($child_product['price'])? floatval($child_product['price']): '';
				}
				if ( $regular_price == 0.0 ) {
					$regular_price = $parent_regular_price;
				}
				$regular_price += $option_price;
				$sale_price = !empty($sale_price)? $sale_price + $option_price : $parent_sale_price;
				if ( $this->plugin->plugin_options['price'] == 'with_tax' ) {
					$regular_price *= $this->plugin->global_tax_rate;
					if ( !empty($sale_price) ) {
						$sale_price *= $this->plugin->global_tax_rate;
					}
				}
				$price = !empty($sale_price)? $sale_price: $regular_price;
				// Minimum variation price
				if ( !isset($this->min_variation_price) || ($price < $this->min_variation_price) ) {
					$this->min_variation_price = $price;
				}
				// Maximum variation price
				if ( !isset($this->max_variation_price) || ($price > $this->max_variation_price) ) {
					$this->max_variation_price = $price;
				}
				$special_from_date = isset($child_product['special_from_date'])? strtotime($child_product['special_from_date']): '';
				$special_to_date = isset($child_product['special_to_date'])? strtotime($child_product['special_to_date']): '';

				// Stock
				$manage_stock = $this->plugin->set_manage_stock($child_product);
				$stock_status = (($child_product['is_in_stock'] > 0) || ($child_product['qty'] > 0) || ($manage_stock == 'no'))? 'instock': 'outofstock';
				if ( $stock_status == 'outofstock' ) {
					wp_set_object_terms($child_product_id, $this->plugin->product_visibilities['outofstock'], 'product_visibility', true);
				}

				// Backorders
				$backorders = $this->plugin->allow_backorders($child_product['backorders'], $child_product['use_config_backorders']);
				
				// SKU
				$sku = $child_product['sku'];
				if ( isset($option_variation['sku']) && !empty($option_variation['sku']) ) {
					$sku .= '-' . $option_variation['sku'];
				}
				
				// Add the meta data
				add_post_meta($new_post_id, '_stock_status', $stock_status, true);
				add_post_meta($new_post_id, '_regular_price', $regular_price, true);
				add_post_meta($new_post_id, '_price', $price, true);
				add_post_meta($new_post_id, '_sale_price', $sale_price, true);
				add_post_meta($new_post_id, '_sale_price_dates_from', $special_from_date, true);
				add_post_meta($new_post_id, '_sale_price_dates_to', $special_to_date, true);
				if ( isset($child_product['weight']) ) {
					add_post_meta($new_post_id, '_weight', floatval($child_product['weight']), true);
				}
				if ( isset($child_product['length']) ) {
					add_post_meta($new_post_id, '_length', floatval($child_product['length']), true);
				}
				if ( isset($child_product['width']) ) {
					add_post_meta($new_post_id, '_width', floatval($child_product['width']), true);
				}
				if ( isset($child_product['height']) ) {
					add_post_meta($new_post_id, '_height', floatval($child_product['height']), true);
				}
				add_post_meta($new_post_id, '_sku', $sku, true);
				add_post_meta($new_post_id, '_stock', $child_product['qty'], true);
				add_post_meta($new_post_id, '_manage_stock', $manage_stock, true);
				add_post_meta($new_post_id, '_backorders', $backorders, true);
				
				// Product variation images
				if ( !$this->plugin->plugin_options['skip_media'] ) {
					list($product_medias, $post_media) = $this->plugin->import_product_medias($child_product);
					// Add links between the post and its medias
					$this->plugin->add_post_media($new_post_id, $product_medias, $date, true);
					$this->plugin->add_post_media($new_post_id, $this->plugin->get_attachment_ids($post_media), $date, false);
				}
				
				// Add the Magento ID as a post meta
				add_post_meta($new_post_id, '_fgm2wc_old_product_id', $child_product_id, true);
				
				// Hook for doing other actions after inserting the variation
				do_action('fgm2wc_post_insert_variation', $new_post_id, $child_product, $regular_price, $sale_price, $new_product_id);
			}
		}
		
		/**
		 * Save the option variation
		 * 
		 * @param int $new_product_id WooCommerce product ID
		 * @param array $product Product
		 * @param array $option_variation Option variation
		 * @param float $regular_price Product regular price
		 * @param float $sale_price Product sale price
		 */
		private function save_option_variation($new_product_id, $product, $option_variation, $regular_price, $sale_price) {
			
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
				add_post_meta($new_post_id, '_fgm2wc_imported', 1, true);
				foreach ( $option_variation['attributes'] as $attribute => $attribute_value ) {
					add_post_meta($new_post_id, 'attribute_' . $attribute, $attribute_value, true);
				}

				// Prices
				$price = floatval($regular_price) + $option_variation['price'];
				add_post_meta($new_post_id, '_regular_price', $price, true);
				if ( $sale_price != 0 ) {
					$option_variation_sale_price = floatval($sale_price) + $option_variation['price'];
					add_post_meta($new_post_id, '_price', floatval($option_variation_sale_price), true);
					add_post_meta($new_post_id, '_sale_price', floatval($option_variation_sale_price), true);
				} else {
					add_post_meta($new_post_id, '_price', floatval($price), true);
				}
				// Minimum variation price
				if ( !isset($this->min_variation_price) || ($price < $this->min_variation_price) ) {
					$this->min_variation_price = $price;
				}
				// Maximum variation price
				if ( !isset($this->max_variation_price) || ($price > $this->max_variation_price) ) {
					$this->max_variation_price = $price;
				}

				// SKU
				if ( isset($option_variation['sku']) ) {
					if ( preg_match('#^' . preg_quote($product['sku']) . '#', $option_variation['sku']) ) {
						// If the product variation SKU starts with the product SKU
						$sku = $option_variation['sku'];
					} else {
						// Else we concatenate the product SKU and the variation SKU
						$sku = $product['sku'] . $option_variation['sku'];
					}
					add_post_meta($new_post_id, '_sku', $sku, true);
				}
				
				// Stock
				if ( isset($option_variation['stock']) && ($option_variation['stock'] !== '') ) {
					add_post_meta($new_post_id, '_manage_stock', 'yes', true);
					add_post_meta($new_post_id, '_stock', $option_variation['stock'], true);
				} else {
					add_post_meta($new_post_id, '_manage_stock', 'no', true);
				}
				$stock_status = (isset($option_variation['stock']) && ($option_variation['stock'] === '0'))? 'outofstock' : 'instock';
				add_post_meta($new_post_id, '_stock_status', $stock_status, true);
				
				// Hook for doing other actions after inserting the variation
				do_action('fgm2wc_post_save_option_variation', $new_post_id, $product, $option_variation, $regular_price, $sale_price);
			}
		}
		
		/**
		 * Get a list of product attributes IDs
		 * 
		 * @param int $product_id Magento product ID
		 * @return array Attributes IDs
		 */
		private function get_attributes_ids_list($product_id) {
			$attributes_ids = array();
			$attributes = $this->get_product_attributes($product_id);
			foreach ( $attributes as $attribute ) {
				if ( $attribute['variation'] ) {
					$attributes_ids[] = $attribute['attribute_id'];
				}
			}
			return $attributes_ids;
		}

		/**
		 * Get the Magento attributes of a product
		 * 
		 * @param int $product_id Product ID
		 * @return array of product attributes
		 */
		private function get_product_attributes($product_id) {
			$attributes = array();
			$prefix = $this->plugin->plugin_options['prefix'];

			if ( version_compare($this->plugin->magento_version, '1.4', '<') ) {
				$sql = "
					SELECT a.attribute_id, a.attribute_code, ea.sort_order, IF(sa.product_super_attribute_id IS NULL, 0, 1) AS variation, 1 AS is_visible_on_front
					FROM {$prefix}eav_attribute a
					INNER JOIN {$prefix}eav_entity_attribute ea ON ea.attribute_id = a.attribute_id
					INNER JOIN {$prefix}catalog_product_entity p ON p.attribute_set_id = ea.attribute_set_id
					LEFT JOIN {$prefix}catalog_product_super_attribute sa ON sa.product_id = p.entity_id AND sa.attribute_id = a.attribute_id
					WHERE a.is_user_defined = 1
					AND p.entity_id = '$product_id'
					ORDER BY ea.sort_order
				";
			} else {
				$sql = "
					SELECT a.attribute_id, a.attribute_code, ea.sort_order, IF(sa.product_super_attribute_id IS NULL, 0, 1) AS variation, ca.is_visible_on_front
					FROM {$prefix}eav_attribute a
					INNER JOIN {$prefix}eav_entity_attribute ea ON ea.attribute_id = a.attribute_id
					INNER JOIN {$prefix}catalog_product_entity p ON p.attribute_set_id = ea.attribute_set_id
					LEFT JOIN {$prefix}catalog_product_super_attribute sa ON sa.product_id = p.entity_id AND sa.attribute_id = a.attribute_id
					LEFT JOIN {$prefix}catalog_eav_attribute ca ON ca.attribute_id = a.attribute_id
					WHERE a.is_user_defined = 1
					AND p.entity_id = '$product_id'
					ORDER BY ea.sort_order
				";
			}
			$attributes = $this->plugin->magento_query($sql);
			
			return $attributes;
		}
		
		/**
		 * Get the product super attributes prices
		 * 
		 * @param int $product_id Product ID
		 * @return array of super attributes prices
		 */
		private function get_super_attributes_prices($product_id) {
			$super_attributes_prices = array();
			$prefix = $this->plugin->plugin_options['prefix'];

			if ( version_compare($this->plugin->magento_version, '1.4', '<') ) {
				$website_criteria = '';
			} else {
				$website_criteria = 'AND (p.website_id = 0 OR p.website_id IS NULL)';
			}
			$sql = "
				SELECT sa.product_super_attribute_id, sa.attribute_id, p.value_index, p.pricing_value
				FROM {$prefix}catalog_product_super_attribute sa
				LEFT JOIN {$prefix}catalog_product_super_attribute_pricing p ON p.product_super_attribute_id = sa.product_super_attribute_id
				WHERE sa.product_id = '$product_id'
				$website_criteria
				ORDER BY sa.position
			";
			$result = $this->plugin->magento_query($sql);
			foreach ( $result as $row ) {
				if ( !empty($row['attribute_id']) && !empty($row['value_index']) ) {
					$super_attributes_prices[$row['attribute_id']][$row['value_index']] = $row['pricing_value'];
				}
			}
			
			return $super_attributes_prices;
		}
		
		/**
		 * Generate all the variations recursively
		 * 
		 * @param array $attributes Attributes with their prices
		 * @return array Variations with the calculated prices
		 *
		 */
		private function generate_variations($attributes) {
			$variations = array();
			if ( is_array($attributes) && (count($attributes) > 0) ) {
				$attribute = array_shift($attributes);
				foreach ($attribute as $key => $value) {
					if ( empty($attributes) ) {
						$variations[$key] = $value;
					} else {
						$children_variations = $this->generate_variations($attributes);
						foreach ($children_variations as $vkey => $vvalue ) {
							$variations[$key.'-'.$vkey] = array(
								'attributes'	=> array_merge($value['attributes'], $vvalue['attributes']),
								'price'			=> $vvalue['price'] + $value['price'],
								'sku'			=> $vvalue['sku'] . $value['sku'],
								'stock'			=> intval($vvalue['stock']) + intval($value['stock']),
							);
						}
					}
				}
			}
			return $variations;
		}
		
		/**
		 * Get the child products of a product
		 * 
		 * @param int $product_id Product ID
		 * @return array Child products
		 */
		private function get_child_products($product_id) {
			$products = array();
			$prefix = $this->plugin->plugin_options['prefix'];

			if ( version_compare($this->plugin->magento_version, '1.4', '<') ) {
				// Magento 1.3 and less
				$relation_criteria = "INNER JOIN {$prefix}catalog_product_super_link r on r.product_id = p.entity_id";
			} else {
				// Magento 1.4+
				$relation_criteria = "INNER JOIN {$prefix}catalog_product_relation r on r.child_id = p.entity_id";
			}
			$sql = "
				SELECT p.entity_id, p.type_id, p.sku, p.created_at
				FROM {$prefix}catalog_product_entity p
				$relation_criteria
				INNER JOIN {$prefix}catalog_product_entity pp ON pp.entity_id = r.parent_id
				WHERE pp.entity_id = '$product_id'
				AND pp.type_id NOT IN ('bundle', 'grouped')
				ORDER BY p.entity_id
			";
			$products = $this->plugin->magento_query($sql);
			
			return $products;
		}
		
		/**
		 * Get the options IDs of a product
		 * 
		 * @param int $product_id Product ID
		 * @param string $attributes_ids_list List of attributes IDs
		 * @return array Option IDs
		 */
		private function get_options_ids($product_id, $attributes_ids_list) {
			$option_ids = array();
			
			if ( !empty($attributes_ids_list) ) {
				$prefix = $this->plugin->plugin_options['prefix'];

				$sql = "
					SELECT DISTINCT pei.value
					FROM {$prefix}catalog_product_entity_int pei
					WHERE pei.{$this->plugin->entity_id_field} = '$product_id'
					AND pei.attribute_id IN ($attributes_ids_list)
					AND pei.value IS NOT NULL
				";
				$result = $this->plugin->magento_query($sql);
				foreach ( $result as $row ) {
					$option_ids[] = $row['value'];
				}
			}
			
			return $option_ids;
		}
		
		/**
		 * Update the product variations stocks
		 * 
		 * @since 3.18.0
		 * 
		 * @param int $product_id WP product ID
		 * @param array $product Main product
		 */
		public function update_product_variations_stocks($product_id, $product) {
			if ( $this->plugin->premium_options['update_stock_only'] ) {
				$instock = false; // Main product stock status
				$variations = $this->get_imported_product_variations($product_id);
				foreach ( $variations as $variation ) {
					$child_product = $this->plugin->get_product($variation->product_id);
					$child_product = array_merge($child_product, $this->plugin->get_other_product_fields($child_product['entity_id'], $this->plugin->product_type_id));
					// Stock
					$stock = $this->plugin->get_stock($child_product['entity_id'], $this->plugin->website_id);
					if ( empty($stock) ) {
						$stock = $this->plugin->get_stock($child_product['entity_id'], 0); // Get the stock of the website 0
					}
					$instock |= isset($stock['qty']) && ($stock['qty'] > 0);
					$child_product = array_merge($child_product, $stock);
					if ( $this->plugin->update_product_stock_and_backorders($variation->ID, $child_product) ) {
						do_action('fgm2wc_post_update_variation', $variation);
					}
				}
				
				// Main product stock status
				$stock = $this->plugin->get_stock($product['entity_id'], $this->plugin->website_id);
				if ( empty($stock) ) {
					$stock = $this->plugin->get_stock($product['entity_id'], 0); // Get the stock of the website 0
				}
				$product = array_merge($product, $stock);
				$manage_stock = $this->plugin->set_manage_stock($product);
				$stock_status = ($instock || ($manage_stock == 'no'))? 'instock': 'outofstock';
				update_post_meta($product_id, '_stock_status', $stock_status);
				if ( $stock_status == 'instock' ) {
					wp_remove_object_terms($product_id, $this->plugin->product_visibilities['outofstock'], 'product_visibility');
				}
			}
		}
		
		/**
		 * Get the imported variations of a product
		 * 
		 * @since 3.18.0
		 * 
		 * @param int $product_id WP product ID
		 * @return array Product variations
		 */
		private function get_imported_product_variations($product_id) {
			global $wpdb;
			$product_variations = array();
			
			$sql = "
				SELECT p.ID, pm.meta_value AS product_id
				FROM {$wpdb->posts} p
				LEFT JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID AND pm.meta_key = '_fgm2wc_old_product_id'
				WHERE p.post_parent = '%s'
			";
			$product_variations = $wpdb->get_results($wpdb->prepare($sql, $product_id));
			
			return $product_variations;
		}
		
	}
}
