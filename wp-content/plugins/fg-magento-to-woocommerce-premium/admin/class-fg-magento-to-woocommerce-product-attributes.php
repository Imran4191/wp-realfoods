<?php
/**
 * Product attributes class
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      1.0.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
 */

if ( !class_exists('FG_Magento_to_WooCommerce_Product_Attributes', false) ) {

	/**
	 * Product attributes class
	 *
	 * @package    FG_Magento_to_WooCommerce_Premium
	 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Magento_to_WooCommerce_Product_Attributes extends FG_Magento_to_WooCommerce_Attributes {

		/**
		 * Import the Magento attributes
		 *
		 */
		public function import_attributes() {
			$this->plugin->attribute_values = array();
			$this->plugin->attribute_options = array();
			
			if ( isset($this->plugin->premium_options['skip_products']) && $this->plugin->premium_options['skip_products'] ) {
				return;
			}
			
			if ( isset($this->plugin->premium_options['skip_attributes']) && $this->plugin->premium_options['skip_attributes'] ) {
				return;
			}
			
			if ( $this->plugin->import_stopped() ) {
				return;
			}
			
			$imported_attributes_count = 0;
			
			$this->plugin->log(__('Importing attributes...', $this->plugin->get_plugin_name()));
			
			do {
				$attributes = $this->get_attributes($this->plugin->chunks_size);
				$attributes_count = count($attributes);
				foreach ( $attributes as $attribute ) {
					// Increment the Magento last imported attribute ID
					update_option('fgm2wc_last_magento_attribute_id', $attribute['attribute_id']);
					
					if ( in_array($attribute['attribute_code'], array('product_name', 'product_sku', 'tags')) ) {
						continue; // Don't import the product name, product sku or tags as attributes
					}

					if ( $this->is_custom_attribute($attribute) ) {
						continue; // Don't import the custom attributes as predefined attributes
					}
					
					$attribute = apply_filters('fgm2wc_pre_import_attribute', $attribute);
					if ( empty($attribute) ) {
						continue;
					}

					// Create the attribute
					$attribute_type = in_array($attribute['frontend_input'], array('select', 'multiselect', 'boolean'))? 'select': 'text';
					$attribute_type = apply_filters('fgm2wc_attribute_type', $attribute_type, $attribute);
					$attribute_label = !empty($attribute['translated_label'])? $attribute['translated_label'] : $attribute['frontend_label'];
					$taxonomy = apply_filters('fgm2wc_pre_create_attribute_taxonomy', '', $attribute);
					if ( empty($taxonomy) ) {
						$taxonomy = $this->create_woocommerce_attribute($attribute['attribute_code'], $attribute_label, $attribute_type);
						$imported_attributes_count++;
					}

					// Create the attributes options
					$attributes_options = $this->get_attribute_options($attribute['attribute_id'], $this->plugin->store_id);
					$terms = array();
					foreach ( $attributes_options as $attribute_option ) {
						$meta_value = intval($attribute_option['option_id']);
						$attribute_options_term_id = $this->create_woocommerce_attribute_value($taxonomy, $attribute_option['value'], '_fgm2wc_attribute_option', $meta_value, $attribute_option['sort_order']);
						if ( $attribute_options_term_id != 0 ) {
							$terms[] = $attribute_options_term_id;
							do_action('fgm2wc_post_create_woocommerce_attribute_value', $attribute_options_term_id, $taxonomy, $meta_value);
						}
					}
					// Update cache
					if ( !empty($terms) ) {
						clean_term_cache($terms, $taxonomy);
					}

					if ( empty($attributes_options) ) {
						// Create the attributes values
						$this->create_attribute_values($attribute, $taxonomy, $this->plugin->store_id);
						do_action('fgm2wc_post_create_attribute_values', $attribute, $taxonomy, array($this, 'create_attribute_values'));
					}

					// Empty attribute taxonomies cache
					delete_transient('wc_attribute_taxonomies');
					wp_cache_flush();
				}
				
			} while ( ($attributes != null) && ($attributes_count > 0) );
			
			$this->plugin->attribute_values = $this->get_imported_attribute_values('_fgm2wc_attribute_value');
			$this->plugin->attribute_options = $this->get_imported_attribute_values('_fgm2wc_attribute_option');
			do_action('fgm2wc_post_import_attributes', $attributes);
			$this->plugin->display_admin_notice(sprintf(_n('%d attribute imported', '%d attributes imported', $imported_attributes_count, $this->plugin->get_plugin_name()), $imported_attributes_count));
		}
		
		/**
		 * Get the Magento attributes
		 *
		 * @param int $limit Number of articles max
		 * @return array of attributes
		 */
		private function get_attributes($limit=1000) {
			$attributes = array();
			$prefix = $this->plugin->plugin_options['prefix'];
			
			$last_magento_attribute_id = (int)get_option('fgm2wc_last_magento_attribute_id'); // to restore the import where it left
			
			$extra_joins = '';
			if ( $this->plugin->table_exists('eav_attribute_label') ) {
				$translated_label = 'al.value';
				$extra_joins .= "LEFT JOIN {$prefix}eav_attribute_label al ON al.attribute_id = a.attribute_id AND al.store_id = '{$this->plugin->store_id}'";
			} else {
				$translated_label = 'a.frontend_label';
			}
			$sql = "
				SELECT DISTINCT a.attribute_id, a.attribute_code, a.frontend_label, a.frontend_input, $translated_label AS translated_label
				FROM {$prefix}eav_attribute a
				INNER JOIN {$prefix}eav_entity_attribute ea ON ea.attribute_id = a.attribute_id
				$extra_joins
				WHERE (a.is_user_defined = 1 OR a.attribute_code = 'country_of_manufacture')
				AND a.attribute_id > '$last_magento_attribute_id'
				ORDER BY a.attribute_id
				LIMIT $limit
			";
			$sql = apply_filters('fgm2wc_get_attributes_sql', $sql);
			$attributes = $this->plugin->magento_query($sql);
			
			return $attributes;
		}
		
		/**
		 * Check if the attribute needs to be a custom attribute
		 * 
		 * @since 2.43.0
		 * 
		 * @param array $attribute Attribute
		 * @return bool Is it a custom attribute?
		 */
		private function is_custom_attribute($attribute) {
			if ( $this->has_attribute_options($attribute['attribute_id']) ) {
				return false;
			}
			$nb = $this->get_attribute_values_count($attribute['attribute_id']);
			if ( $nb > 300 ) { // If too many values, we consider it is a custom attribute
				return true;
			}
			$max_length = $this->get_attribute_values_max_length($attribute['attribute_id']);
			if ( $max_length > 200 ) { // If the attribute value max length is too high, we consider it is a custom attribute
				return true;
			}
			
			return false;
		}
		
		/**
		 * Get the default boolean attribute values
		 * 
		 * @since 1.13.0
		 * 
		 * @return array Attribute values
		 */
		private function get_boolean_attribute_values() {
			return array(
				array('value' => __('No')),
				array('value' => __('Yes')),
			);
		}
		
		/**
		 * Get the Magento attribute values
		 *
		 * @param int $attribute_id Attribute ID
		 * @param int $store_id Store ID
		 * @return array of attributes values
		 */
		private function get_attribute_values($attribute_id, $store_id) {
			$attribute_values = array();

			$prefix = $this->plugin->plugin_options['prefix'];
			$sql = "
					SELECT pev.value
					FROM {$prefix}catalog_product_entity_varchar pev
					WHERE pev.attribute_id = '$attribute_id'
					AND pev.store_id = '$store_id'
				UNION
					SELECT pet.value
					FROM {$prefix}catalog_product_entity_text pet
					WHERE pet.attribute_id = '$attribute_id'
					AND pet.store_id = '$store_id'
				UNION
					SELECT pei.value
					FROM {$prefix}catalog_product_entity_int pei
					WHERE pei.attribute_id = '$attribute_id'
					AND pei.store_id = '$store_id'
				UNION
					SELECT ped.value
					FROM {$prefix}catalog_product_entity_decimal ped
					WHERE ped.attribute_id = '$attribute_id'
					AND ped.store_id = '$store_id'
				UNION
					SELECT pedt.value
					FROM {$prefix}catalog_product_entity_datetime pedt
					WHERE pedt.attribute_id = '$attribute_id'
					AND pedt.store_id = '$store_id'
				ORDER BY value
			";
			$attribute_values = $this->plugin->magento_query($sql);
			
			return $attribute_values;
		}
		
		/**
		 * Count the number of Magento attribute values
		 *
		 * @since 2.43.0
		 * 
		 * @param int $attribute_id Attribute ID
		 * @return int Number of attributes values
		 */
		private function get_attribute_values_count($attribute_id) {
			$count = 0;
			$tables = array('catalog_product_entity_varchar', 'catalog_product_entity_text', 'catalog_product_entity_int', 'catalog_product_entity_decimal', 'catalog_product_entity_datetime');
			foreach ( $tables as $table ) {
				$count += $this->get_attribute_values_count_in_table($attribute_id, $table);
			}
			return $count;
		}
		
		/**
		 * Count the number of Magento attribute values in a table
		 *
		 * @since 2.43.0
		 * 
		 * @param int $attribute_id Attribute ID
		 * @param string $table Table
		 * @return int Number of attributes values
		 */
		private function get_attribute_values_count_in_table($attribute_id, $table) {
			$attribute_values_count = array();

			$prefix = $this->plugin->plugin_options['prefix'];
			$sql = "
					SELECT COUNT(DISTINCT(value)) AS nb
					FROM {$prefix}$table
					WHERE attribute_id = '$attribute_id'
			";
			$result = $this->plugin->magento_query($sql);
			
			$attribute_values_count = (count($result) > 0)? $result[0]['nb'] : 0;
			
			return $attribute_values_count;
		}
		
		/**
		 * Get the max length of Magento attribute values
		 *
		 * @since 2.43.0
		 * 
		 * @param int $attribute_id Attribute ID
		 * @return int Max length
		 */
		private function get_attribute_values_max_length($attribute_id) {
			$max_length = array();

			$prefix = $this->plugin->plugin_options['prefix'];
			$sql = "
					SELECT MAX(LENGTH(value)) AS max_length
					FROM {$prefix}catalog_product_entity_text
					WHERE attribute_id = '$attribute_id'
			";
			$result = $this->plugin->magento_query($sql);
			
			$max_length = (count($result) > 0)? $result[0]['max_length'] : 0;
			
			return $max_length;
		}
		
		/**
		 * Create all the values for an attribute
		 * 
		 * @since 2.84.0
		 * 
		 * @param array $attribute Attribute
		 * @param string $taxonomy Attribute taxonomy
		 * @param int $store_id Store ID
		 */
		public function create_attribute_values($attribute, $taxonomy, $store_id) {
			if ( $attribute['frontend_input'] == 'boolean' ) {
				// Boolean values
				$attributes_values = $this->get_boolean_attribute_values();
			} else {
				$attributes_values = $this->get_attribute_values($attribute['attribute_id'], $store_id);
				if ( empty($attributes_values) ) {
					$attributes_values = $this->get_attribute_values($attribute['attribute_id'], 0);
				}
			}
			$terms = array();
			foreach ( $attributes_values as $attribute_value ) {
				$meta_value = apply_filters('fgm2wc_attribute_value_slug', $attribute_value['value'], $taxonomy);
				$attribute_values_term_id = $this->create_woocommerce_attribute_value($taxonomy, $attribute_value['value'], '_fgm2wc_attribute_value', $meta_value, 0);
				if ( $attribute_values_term_id != 0 ) {
					$terms[] = $attribute_values_term_id;
				}
			}
			// Update cache
			if ( !empty($terms) ) {
				clean_term_cache($terms, $taxonomy);
			}
		}
		
		/**
		 * Get the Magento attribute options
		 *
		 * @param int $attribute_id Attribute ID
		 * @param int $store_id Store ID
		 * @return array of attributes options
		 */
		private function get_attribute_options($attribute_id, $store_id) {
			$attribute_options = array();
			$prefix = $this->plugin->plugin_options['prefix'];
			$sql = "
				SELECT o.option_id, o.sort_order, ov.value
				FROM {$prefix}eav_attribute_option o
				INNER JOIN {$prefix}eav_attribute_option_value ov ON ov.option_id = o.option_id AND ov.store_id IN(0, $store_id)
				WHERE o.attribute_id = '$attribute_id'
				ORDER BY ov.store_id
			";
			$result = $this->plugin->magento_query($sql);
			foreach ( $result as $row ) {
				if ( !empty(trim($row['value'])) ) {
					$attribute_options[$row['option_id']] = $row;
				}
			}
			
			return $attribute_options;
		}
		
		/**
		 * Has the attribute got any options?
		 *
		 * @since 2.43.0
		 * 
		 * @param int $attribute_id Attribute ID
		 * @return bool Contains options
		 */
		private function has_attribute_options($attribute_id) {
			$has_options = false;
			$prefix = $this->plugin->plugin_options['prefix'];
			$sql = "
				SELECT COUNT(*) AS nb
				FROM {$prefix}eav_attribute_option o
				WHERE o.attribute_id = '$attribute_id'
			";
			$result = $this->plugin->magento_query($sql);
			
			$has_options = (count($result) > 0) && ($result[0]['nb'] > 0);
			
			return $has_options;
		}
		
		/**
		 * Get the Magento attribute options by option ID
		 *
		 * @param int $option_id Attribute ID
		 * @param int $store_id Store ID
		 * @return array of attributes options
		 */
		public function get_attribute_options_by_option_id($option_id, $store_id) {
			$attribute_options = array();
			$prefix = $this->plugin->plugin_options['prefix'];
			$sql = "
				SELECT o.option_id, o.sort_order, ov.value, ov.store_id
				FROM {$prefix}eav_attribute_option o
				INNER JOIN {$prefix}eav_attribute_option_value ov ON ov.option_id = o.option_id AND ov.store_id = $store_id
				WHERE o.option_id = '$option_id'
			";
			$attribute_options = $this->plugin->magento_query($sql);
			
			return $attribute_options;
		}
		
		/**
		 * Import the Magento product attributes
		 *
		 * @param int $new_product_id WordPress ID
		 * @param array $product Magento product
		 */
		public function import_product_attributes($new_product_id, $product) {
			if ( isset($this->plugin->premium_options['skip_attributes']) && $this->plugin->premium_options['skip_attributes'] ) {
				return;
			}
			
			$store_id = $this->plugin->store_id;
			$i = 0;
			$position = 0;
			// Assign the attributes to the product
			$attributes = $this->get_product_attributes($product['entity_id']);
			foreach ( $attributes as $attribute ) {
				if ( $attribute['attribute_code'] == 'tags' ) {
					continue; // Don't import the tags as attributes
				}
				$must_create_predefined_attribute = false;
				$must_create_custom_attribute = false;
				$custom_attribute_value = '';
				$attribute_name = $this->plugin->normalize_attribute_name($attribute['attribute_code']);
				$taxonomy = 'pa_' . $attribute_name;
				
				// Set the relationship between the product and the attribute values
				$attributes_values = $this->get_product_attributes_values($product['entity_id'], $attribute['attribute_id'], $store_id);
				if ( empty($attributes_values) ) {
					// Get the attribute values from the main store
					$attributes_values = $this->get_product_attributes_values($product['entity_id'], $attribute['attribute_id'], 0);
				}
				
				$attribute = apply_filters('fgm2wc_pre_import_product_attribute', $attribute, $new_product_id, $attributes_values);
				if ( empty($attribute) ) {
					continue;
				}
				$taxonomy = apply_filters('fgm2wc_taxonomy_pre_import_product_attribute', $taxonomy, $attribute);

				foreach ( $attributes_values as $attribute_value ) {
					if ( $attribute['frontend_input'] == 'boolean' ) {
						// Boolean value
						$attribute_value = ($attribute_value == 0)? __('No') : __('Yes');
					}
					if ( !empty($attribute_value) ) {
						$attribute_value = apply_filters('fgm2wc_attribute_value_slug', $attribute_value, $taxonomy);
						if ( isset($this->plugin->attribute_values[$taxonomy][$attribute_value]) ) {
							$this->set_object_terms($new_product_id, $this->plugin->attribute_values[$taxonomy][$attribute_value], $i++);
							$must_create_predefined_attribute = true;
						} else {
							$custom_attribute_value = $attribute_value;
							$must_create_custom_attribute = true;
						}
					}
				}
				
				if ( !$must_create_predefined_attribute ) {
					// Set the relationship between the product and the attribute options
					$attributes_options = $this->get_product_attributes_options($product['entity_id'], $attribute['attribute_id'], $store_id);
					if ( empty($attributes_options) ) {
						// Get the options from the main store
						$attributes_options = $this->get_product_attributes_options($product['entity_id'], $attribute['attribute_id'], 0);
					}
					$child_attribute_options = $this->get_child_product_attributes_options($product['entity_id'], $attribute['attribute_id'], $store_id); // Variations attribute values
					if ( empty($child_attribute_options) ) {
						// Get the options from the main store
						$child_attribute_options = $this->get_child_product_attributes_options($product['entity_id'], $attribute['attribute_id'], 0);
					}
					$attributes_options = array_unique(array_merge($attributes_options, $child_attribute_options));
					foreach ( $attributes_options as $attribute_option ) {
						$meta_key = '';
						$attribute_option_with_store_id = $attribute_option . '-' . $store_id;
						if ( isset($this->plugin->attribute_options[$taxonomy][$attribute_option_with_store_id]) ) {
							$meta_key = $attribute_option_with_store_id;
						} elseif ( isset($this->plugin->attribute_options[$taxonomy][$attribute_option]) ) {
							$meta_key = $attribute_option;
						}
						if ( !empty($meta_key) ) {
							$this->set_object_terms($new_product_id, $this->plugin->attribute_options[$taxonomy][$meta_key], $i++);
							$must_create_predefined_attribute = true;
						}
					}
				}
				
				// Create the product attribute only if a value was found
				if ( $must_create_predefined_attribute || $must_create_custom_attribute ) {
					$args = array(
						'position'		=> $position++,
						'is_visible'	=> strval($attribute['is_visible_on_front']),
						'is_variation'	=> strval($attribute['variation']),
					);

					if ( !$must_create_predefined_attribute ) {
						// Create a custom attribute
						$args = array_merge($args, array(
							'value'			=> $custom_attribute_value,
							'is_taxonomy'	=> '0',
						));
						$taxonomy = $attribute['frontend_label'];
					}
					$args = apply_filters('fgm2wc_args_pre_create_woocommerce_product_attribute', $args, $attribute, $taxonomy);
					if ( !empty($args) ) {
						$this->create_woocommerce_product_attribute($new_product_id, $taxonomy, $args);
					}
				}
			}
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
				$is_visible_on_front_column = '1 AS is_visible_on_front';
				$catalog_eav_attribute_criteria = '';
			} else {
				$is_visible_on_front_column = 'ca.is_visible_on_front';
				$catalog_eav_attribute_criteria = "LEFT JOIN {$prefix}catalog_eav_attribute ca ON ca.attribute_id = a.attribute_id";
			}
			$sql = "
				SELECT a.attribute_id, a.attribute_code, a.frontend_label, a.frontend_input, ea.sort_order, IF(sa.product_super_attribute_id IS NULL, 0, 1) AS variation, $is_visible_on_front_column, sa.position
				FROM {$prefix}eav_attribute a
				INNER JOIN {$prefix}eav_entity_attribute ea ON ea.attribute_id = a.attribute_id
				INNER JOIN {$prefix}catalog_product_entity p ON p.attribute_set_id = ea.attribute_set_id
				LEFT JOIN {$prefix}catalog_product_super_attribute sa ON sa.product_id = p.entity_id AND sa.attribute_id = a.attribute_id
				$catalog_eav_attribute_criteria
				WHERE (a.is_user_defined = 1 OR a.attribute_code = 'country_of_manufacture')
				AND p.entity_id = '$product_id'
				ORDER BY sa.position, ea.sort_order
			";
			$sql = apply_filters('fgm2wc_get_product_attributes_sql', $sql, $product_id, $catalog_eav_attribute_criteria);
			$attributes = $this->plugin->magento_query($sql);
			
			return $attributes;
		}
		
		/**
		 * Get the Magento attributes values of a product
		 * 
		 * @param int $product_id Product ID
		 * @param int $attribute_id Attribute ID
		 * @param int $store_id Store ID
		 * @return array of product attributes values
		 */
		private function get_product_attributes_values($product_id, $attribute_id, $store_id) {
			$attributes_values = array();
			$prefix = $this->plugin->plugin_options['prefix'];

			$sql = "
				SELECT pev.value
				FROM {$prefix}catalog_product_entity_varchar pev
				WHERE pev.{$this->plugin->entity_id_field} = $product_id
				AND pev.attribute_id = '$attribute_id'
				AND pev.store_id = $store_id
				UNION
				SELECT pet.value
				FROM {$prefix}catalog_product_entity_text pet
				WHERE pet.{$this->plugin->entity_id_field} = $product_id
				AND pet.attribute_id = '$attribute_id'
				AND pet.store_id = $store_id
				UNION
				SELECT pei.value
				FROM {$prefix}catalog_product_entity_int pei
				WHERE pei.{$this->plugin->entity_id_field} = $product_id
				AND pei.attribute_id = '$attribute_id'
				AND pei.store_id = $store_id
				UNION
				SELECT ped.value
				FROM {$prefix}catalog_product_entity_decimal ped
				WHERE ped.{$this->plugin->entity_id_field} = $product_id
				AND ped.attribute_id = '$attribute_id'
				AND ped.store_id = $store_id
				UNION
				SELECT pedt.value
				FROM {$prefix}catalog_product_entity_datetime pedt
				WHERE pedt.{$this->plugin->entity_id_field} = $product_id
				AND pedt.attribute_id = '$attribute_id'
				AND pedt.store_id = $store_id
			";
			$result = $this->plugin->magento_query($sql);
			foreach ( $result as $row ) {
				$attributes_values[] = $row['value'];
			}
			
			return $attributes_values;
		}
		
		/**
		 * Get the Magento attributes options of a product
		 * 
		 * @param int $product_id Product ID
		 * @param int $attribute_id Attribute ID
		 * @param int $store_id Store ID
		 * @return array of product attributes options
		 */
		private function get_product_attributes_options($product_id, $attribute_id, $store_id) {
			$attributes_options = array();
			$prefix = $this->plugin->plugin_options['prefix'];
			
			// Get the product attribute values
			$attributes_values = $this->get_product_attributes_values($product_id, $attribute_id, $store_id);
			$exploded_attributes_values = array();
			foreach ( $attributes_values as $attributes_value ) {
				$values = explode(',', $attributes_value);
				foreach ( $values as $value ) {
					if ( is_numeric($value) ) { // We need option IDS, so we get only the integers
						$exploded_attributes_values[] = $value;
					}
				}
			}
			$attributes_values_list = implode(',', $exploded_attributes_values);
			
			// Get the product attribute values sorted
			if ( !empty($attributes_values_list) ) {
				$sql = "
					SELECT o.option_id
					FROM {$prefix}eav_attribute_option o
					WHERE o.option_id IN($attributes_values_list)
					ORDER BY o.sort_order
				";
				$result = $this->plugin->magento_query($sql);
				foreach ( $result as $row ) {
					$attributes_options[] = $row['option_id'];
				}
			}
			
			return $attributes_options;
		}
		
		/**
		 * Get the Magento attributes options of the children of a product
		 * 
		 * @param int $product_id Product ID
		 * @param int $attribute_id Attribute ID
		 * @param int $store_id Store ID
		 * @return array of product attributes options
		 */
		private function get_child_product_attributes_options($product_id, $attribute_id, $store_id) {
			$attributes_options = array();
			$prefix = $this->plugin->plugin_options['prefix'];

			if ( version_compare($this->plugin->magento_version, '1.4', '<') ) {
				// Magento 1.3 and less
				$relation_criteria = "INNER JOIN {$prefix}catalog_product_super_link r on r.product_id = pei.{$this->plugin->entity_id_field}";
			} else {
				// Magento 1.4+
				$relation_criteria = "INNER JOIN {$prefix}catalog_product_relation r on r.child_id = pei.{$this->plugin->entity_id_field}";
			}
			$sql = "
				SELECT DISTINCT o.option_id, o.sort_order
				FROM {$prefix}eav_attribute_option o
				INNER JOIN {$prefix}catalog_product_entity_int pei ON pei.value = o.option_id AND pei.attribute_id = o.attribute_id
				$relation_criteria
				INNER JOIN {$prefix}catalog_product_entity pp ON pp.entity_id = r.parent_id
				WHERE pp.entity_id = $product_id
				AND pp.type_id != 'bundle'
				AND o.attribute_id = $attribute_id
				AND pei.store_id = $store_id
				ORDER BY o.sort_order
			";
			$result = $this->plugin->magento_query($sql);
			foreach ( $result as $row ) {
				$attributes_options[] = $row['option_id'];
			}
			
			return $attributes_options;
		}
		
		/**
		 * Reset the Magento last imported attribute ID
		 *
		 */
		public function reset_attributes() {
			update_option('fgm2wc_last_magento_attribute_id', 0);
		}
		
	}
}
