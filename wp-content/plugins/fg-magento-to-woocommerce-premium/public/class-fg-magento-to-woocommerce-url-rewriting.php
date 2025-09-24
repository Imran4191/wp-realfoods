<?php

/**
 * URL Rewriting module
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      3.35.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/public
 */

if ( !class_exists('FG_Magento_to_WooCommerce_URL_Rewriting', false) ) {

	/**
	 * URL Rewriting class
	 *
	 * @package    FG_Magento_to_WooCommerce_Premium
	 * @subpackage FG_Magento_to_WooCommerce_Premium/public
	 * @author     Frédéric GILLES
	 */
	class FG_Magento_to_WooCommerce_URL_Rewriting {

		private static $rewrite_rules = array(
			array( 'rule' => '^.*/(.+?)(\.html)?$', 'method' => 'slug'), // Product or term slug
			array( 'rule' => '^.*/view/id/(\d+)', 'method' => 'id', 'view' => 'post', 'meta_key' => '_fgm2wc_old_product_id'), // Product ID
		);

		/**
		 * Set up the plugin
		 */
		public function __construct() {
			$premium_options = get_option('fgm2wcp_options');
			$do_redirect = isset($premium_options['url_redirect']) && !empty($premium_options['url_redirect']);
			$do_redirect = apply_filters('fgm2wcp_do_redirect', $do_redirect);
			if ( $do_redirect ) {
				// Hook on template redirect
				add_action('template_redirect', array($this, 'template_redirect'));
			}
		}

		/**
		 * Redirection to the new URL
		 */
		public function template_redirect() {
			$matches = array();
			do_action('fgm2wcp_pre_404_redirect');

			if ( !is_404() ) { // A page is found, don't redirect
				return;
			}

			do_action('fgm2wcp_post_404_redirect');

			// Process the rewrite rules
			$rewrite_rules = apply_filters('fgm2wcp_rewrite_rules', self::$rewrite_rules);
			// Magento configured with SEF URLs
			$base_url = get_home_url();
			$base_url = preg_replace('#.*' . preg_quote($_SERVER['HTTP_HOST']) . '#', '', $base_url);
			$uri = $_SERVER['REQUEST_URI'];
			if ( !empty($base_url) ) {
				$uri = preg_replace('#.*' . preg_quote(untrailingslashit($base_url)) . '#', '', $uri);
			}

			foreach ( $rewrite_rules as $rewrite_rule ) {
				if ( preg_match('#' . $rewrite_rule['rule'] . '#', $uri, $matches) ) {
					switch ( $rewrite_rule['method'] ) {
						case 'id':
							$old_id = $matches[1];
							if ( $rewrite_rule['view'] == 'term' ) {
								$rewrite_rule['meta_key'] .= '-lang' . $this->plugin->default_language; // Add the default language to the meta key
							}
							self::redirect($rewrite_rule['meta_key'], $old_id, $rewrite_rule['view']);
							break;

						case 'slug':
							$slug = $matches[1];
							self::redirect_slug($slug);
							break;
					}
				}
			}
		}

		/**
		 * Query and redirect to the new URL
		 *
		 * @param string $meta_key Meta Key to search in the postmeta or termmeta table
		 * @param int $old_id Magento ID
		 * @param string $view post|term
		 */
		public static function redirect($meta_key, $old_id, $view='post') {
			if ( !empty($old_id) ) {
				switch ( $view ) {
					case 'post':
						// Get the post by its old ID
						$known_post_types = array_keys(get_post_types(array('public' => 1)));
						$args = array(
							'post_type' => $known_post_types,
							'meta_key' => $meta_key,
							'meta_value' => $old_id,
							'ignore_sticky_posts' => 1,
							'suppress_filters' => 1,
						);
						query_posts($args);
						if ( have_posts() ) {
							self::redirect_to_post();
						}
						break;

					case 'term':
						// Search a term by its id
						$args = array(
							'hide_empty' => false, // also retrieve terms which are not used yet
							'meta_query' => array(
								array(
								   'key'       => $meta_key,
								   'value'     => $old_id,
								   'compare'   => '='
								)
							)
						);
						$terms = get_terms($args);
						if ( count($terms) > 0 ) {
							self::redirect_to_category($terms[0]);
						}
						break;
				}
				// else continue the normal workflow
			}
		}

		/**
		 * Search a post by its slug and redirect to it if found
		 *
		 * @param string $slug Slug to search
		 */
		public static function redirect_slug($slug) {
			if ( !empty($slug) ) {
				$slug = sanitize_title(urldecode($slug));
				// Try to find a post by its slug
				query_posts(array(
					'post_type' => array('post', 'page', 'product'),
					'name' => $slug,
					'ignore_sticky_posts' => 1,
				));
				if ( have_posts() ) {
					self::redirect_to_post();

				} else {
					// Try to find a term by its slug
					$taxonomies = array('product_cat', 'product_brand', 'brand', 'pwb-brand');
					foreach ( $taxonomies as $taxonomy ) {
						$cat = get_term_by('slug', $slug, $taxonomy);
						if ( $cat !== false ) {
							self::redirect_to_category($cat);
						}
					}
				}
				// else continue the normal workflow
				wp_reset_query();
			}
		}

		/**
		 * Redirect to the new product URL if a post is found
		 */
		protected static function redirect_to_post() {
			the_post();
			$url = get_permalink();
//			die($url);
			wp_redirect($url, 301);
			wp_reset_query();
			exit;
		}

		/**
		 * Redirect to the new category URL if a category is found
		 */
		protected static function redirect_to_category($term) {
			$url = get_term_link($term);
			if ( !is_wp_error($url) ) {
//				die($url);
				wp_redirect($url, 301);
				wp_reset_query();
				exit;
			}
		}

	}
}
