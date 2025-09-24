<?php
/**
 * Attributes class
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      1.10.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
 */

if ( !class_exists('FG_Magento_to_WooCommerce_Attributes', false) ) {

	/**
	 * Attributes class
	 *
	 * @package    FG_Magento_to_WooCommerce_Premium
	 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
	 * @author     Frédéric GILLES
	 */
	abstract class FG_Magento_to_WooCommerce_Attributes {

		protected $plugin;
		
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
		 * Create a product attribute
		 *
		 * @param string $attribute_name Attribute name
		 * @param string $attribute_label Attribute label
		 * @param string $attribute_type select | text
		 * @return string Taxonomy
		 */
		protected function create_woocommerce_attribute($attribute_name, $attribute_label, $attribute_type) {
			global $wpdb;
			global $wc_product_attributes;
			
			$attribute_name = $this->plugin->normalize_attribute_name($attribute_name);
			$taxonomy = 'pa_' . $attribute_name;
			
			if ( !array_key_exists($taxonomy, $wc_product_attributes) ) {
				// Create the taxonomy
				$attribute_taxonomy = array(
					'attribute_name'	=> $attribute_name,
					'attribute_label'	=> $attribute_label,
					'attribute_type'	=> $attribute_type,
					'attribute_orderby'	=> 'menu_order',
				);
				$wpdb->insert($wpdb->prefix . 'woocommerce_attribute_taxonomies', $attribute_taxonomy);

				// Register the taxonomy
				register_taxonomy($taxonomy,
					apply_filters('woocommerce_taxonomy_objects_' . $taxonomy, array('product')),
					apply_filters('woocommerce_taxonomy_args_' . $taxonomy, array(
						'hierarchical' => true,
						'show_ui' => false,
						'query_var' => true,
						'rewrite' => array(),
					))
				);
				$wc_product_attributes[$taxonomy] = (object)$attribute_taxonomy; // useful for wc_set_term_order()
			}
			return $taxonomy;
		}
		
		/**
		 * Create an attribute value
		 *
		 * @param string $taxonomy Taxonomy
		 * @param string $attribute_value Attribute value
		 * @param string $meta_key Meta key to store in the termmeta table
		 * @param string $meta_value Meta value to store in the termmeta table
		 * @param int $attribute_value_ordering Attribute value ordering
		 * @return int Term ID created
		 */
		public function create_woocommerce_attribute_value($taxonomy, $attribute_value, $meta_key, $meta_value, $attribute_value_ordering = 0) {
			$term_id = 0;
			
			if ( !empty($attribute_value) ) {
				$attribute_value = trim($attribute_value);
				// Create one term by custom value
				$attribute_value = substr($attribute_value, 0, 197); // term name is limited to 200 characters (minus 3 for the language code)
				$attribute_value_slug = $this->plugin->normalize_attribute_name($attribute_value);
				$attribute_value_slug = apply_filters('fgm2wc_attribute_value_slug', $attribute_value_slug, $taxonomy);
				$term_id = $this->get_term_id_by_slug($attribute_value_slug, $taxonomy);
				if ( $term_id ) {
					add_term_meta($term_id, $meta_key, $meta_value, false);
				} else {
					$newterm = wp_insert_term($attribute_value, $taxonomy, array('slug' => $attribute_value_slug));
					if ( !is_wp_error($newterm) ) {
						$term_id = $newterm['term_id'];
						add_term_meta($term_id, $meta_key, $meta_value, false);

						// Category ordering
						if ( function_exists('wc_set_term_order') ) {
							wc_set_term_order($term_id, $attribute_value_ordering, $taxonomy);
						}
					}
				}
			}
			return $term_id;
		}
		
		/**
		 * Same as get_term_by() but avoid WPML hooks
		 * 
		 * @since 3.35.1
		 * @global object $wpdb
		 * 
		 * @param string $slug Term slug
		 * @param string $taxonomy Taxonomy
		 * @return int Term ID
		 */
		private function get_term_id_by_slug($slug, $taxonomy) {
			global $wpdb;
			$sql = "SELECT t.term_id
					FROM $wpdb->terms t
					INNER JOIN $wpdb->term_taxonomy tt ON tt.term_id = t.term_id
					WHERE t.slug = %s
					AND tt.taxonomy = %s
					";
			return $wpdb->get_var($wpdb->prepare($sql, $slug, $taxonomy));
		}
		
		/**
		 * Get the imported attribute values
		 * 
		 * @since 2.8.0
		 * 
		 * @param string $meta_key Meta key
		 * @return array Attribute values map table
		 */
		protected function get_imported_attribute_values($meta_key) {
			global $wpdb;
			$metas = array();
			
			$sql = "
				SELECT tt.term_taxonomy_id, tm.meta_value, tt.taxonomy
				FROM {$wpdb->termmeta} tm
				INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_id = tm.term_id
				WHERE tm.meta_key = %s
			";
			$results = $wpdb->get_results($wpdb->prepare($sql, $meta_key));
			foreach ( $results as $result ) {
				$metas[$result->taxonomy][$result->meta_value] = $result->term_taxonomy_id;
			}
			ksort($metas);
			return $metas;
		}
		
		/**
		 * Create a product attribute
		 *
		 * @param string $product_id Product ID
		 * @param string $taxonomy Taxonomy
		 * @param array $args Product attributes arguments
		 */
		protected function create_woocommerce_product_attribute($product_id, $taxonomy, $args) {
			// Assign the attribute to the product
			$product_attributes = get_post_meta($product_id, '_product_attributes', true);
			if ( empty($product_attributes) ) {
				$product_attributes = array();
			}
			if ( !array_key_exists($taxonomy, $product_attributes) ) {
				$default_args = array(
					'name'			=> $taxonomy,
					'value'			=> '',
					'position'		=> '0',
					'is_visible'	=> '0',
					'is_variation'	=> '0',
					'is_taxonomy'	=> '1',
				);
				$args = array_merge($default_args, $args);
				$product_attribute = array($taxonomy => $args);
				$product_attributes = array_merge($product_attributes, $product_attribute);
				update_post_meta($product_id, '_product_attributes', $product_attributes);
			}
		}
		
		/**
		 * Create a product attribute value
		 *
		 * @param string $product_id Product ID
		 * @param string $taxonomy Taxonomy
		 * @param array $args Product attributes arguments
		 */
		protected function create_product_attribute_values($product_id, $taxonomy, $args) {
			// Assign the attribute values to the product
			$product_attributes = get_post_meta($product_id, '_product_attributes_values', true);
			if ( empty($product_attributes) ) {
				$product_attributes = array();
			}
			if ( !array_key_exists($taxonomy, $product_attributes) ) {
				$product_attribute = array($taxonomy => $args);
				$product_attributes = array_merge($product_attributes, $product_attribute);
				update_post_meta($product_id, '_product_attributes_values', $product_attributes);
			}
		}
		
		/**
		 * Same function as wp_set_object_terms but with the term_order parameter
		 *
		 * @param int $object_id Object ID
		 * @param int $term_taxonomy_id Term taxonomy ID
		 * @param int $term_order Term order
		 */
		protected function set_object_terms($object_id, $term_taxonomy_id, $term_order) {
			global $wpdb;
			
			$wpdb->hide_errors(); // to prevent the display of an error if the term relashionship already exists
			$wpdb->insert($wpdb->prefix . 'term_relationships', array(
				'object_id'			=> $object_id,
				'term_taxonomy_id'	=> $term_taxonomy_id,
				'term_order'		=> $term_order,
			));
			$wpdb->show_errors();
		}
	}
}
