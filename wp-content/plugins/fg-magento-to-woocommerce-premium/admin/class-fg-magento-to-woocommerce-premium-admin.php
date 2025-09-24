<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      1.0.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
 * @author     Frédéric GILLES
 */
class FG_Magento_to_WooCommerce_Premium_Admin extends FG_Magento_to_WooCommerce_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	public $premium_options = array();			// Options specific for the Premium version
	public $display_multistore = true;			// Display the multistore options
	public $import_selected_store_only = false;	// Import the selected store only
	public $updated_products_count = 0;			// Number of updated products
	public $imported_customers = array();		// Already imported customers
	public $attribute_values = array();			// Attribute values
	public $attribute_options = array();		// Attribute options
	
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string    $plugin_name       The name of this plugin.
	 * @param    string    $version           The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		parent::__construct($plugin_name, $version);
		$this->faq_url = 'https://www.fredericgilles.net/fg-magento-to-woocommerce/faq/';

	}

	/**
	 * Initialize the plugin
	 */
	public function init() {
		if ( !defined('WP_CLI') ) { // deactivate_plugins() doesn't work with WP CLI on Windows
			$this->deactivate_free_version();
		}
		parent::init();
	}

	/**
	 * Get the Premium options
	 */
	public function get_premium_options() {

		// Default options values
		$this->premium_options = array(
			'meta_keywords_in_tags'				=> false,
			'import_meta_seo'					=> false,
			'url_redirect'						=> false,
			'website'							=> null,
			'store'								=> null,
			'import_customers_orders'			=> 'all',
			'update_stock_only'					=> false,
			'skip_cms'							=> false,
			'skip_products_categories'			=> false,
			'skip_disabled_products_categories'	=> false,
			'skip_products'						=> false,
			'skip_disabled_products'			=> false,
			'skip_attributes'					=> false,
			'skip_users'						=> false,
			'skip_customers'					=> false,
			'skip_inactive_customers'			=> false,
			'skip_orders'						=> false,
			'skip_reviews'						=> false,
			'skip_coupons'						=> false,
			'skip_redirects'					=> false,
		);
		$this->premium_options = apply_filters('fgm2wcp_post_init_premium_options', $this->premium_options);
		$options = get_option('fgm2wcp_options');
		if ( is_array($options) ) {
			$this->premium_options = array_merge($this->premium_options, $options);
		}
	}

	/**
	 * Get the WP options name
	 * 
	 * @since 3.0.0
	 * 
	 * @param array $option_names Option names
	 * @return array Option names
	 */
	public function get_option_names($option_names) {
		$option_names = parent::get_option_names($option_names);
		$option_names[] = 'fgm2wcp_options';
		return $option_names;
	}

	/**
	 * Deactivate the free version of FG Magento to WooCommerce to avoid conflicts between both plugins
	 */
	private function deactivate_free_version() {
		deactivate_plugins( 'fg-magento-to-woocommerce/fg-magento-to-woocommerce.php' );
	}
	
	/**
	 * Add information to the admin page
	 * 
	 * @param array $data
	 * @return array
	 */
	public function process_admin_page($data) {
		$data['title'] = __('Import Magento Premium', $this->plugin_name);
		$data['description'] = __('This plugin will import product categories, products, images, CMS, users, customers, orders, reviews and coupons from Magento to WooCommerce.<br />Compatible with Magento versions 1.3 to 2.4.', $this->plugin_name);
		$data['description'] .= "<br />\n" . sprintf(__('For any issue, please read the <a href="%s" target="_blank">FAQ</a> first.', $this->plugin_name), $this->faq_url);

		// Premium options
		foreach ( $this->premium_options as $key => $value ) {
			$data[$key] = $value;
		}
		
		// List of web sites
		$websites = get_option('fgm2wc_websites');
		if ( empty($websites) ) {
			$data['websites_options'] = '<option value="0">default</option>';
		} else {
			$data['websites_options'] = $this->format_options($websites, $this->premium_options['website'], true);
		}
		// List of stores
		$stores = get_option('fgm2wc_stores');
		if ( empty($stores) ) {
			$data['stores_options'] = '<option value="0">default</option>';
		} else {
			$data['stores_options'] = $this->format_options($stores, $this->premium_options['store']);
		}
		$data['display_multistore'] = $this->display_multistore;

		return $data;
	}

	/**
	 * Get the WordPress database info
	 * 
	 * @since 2.0.0
	 * 
	 * @return string Database info
	 */
	public function get_premium_database_info($database_info) {
		// Users
		$count_users = count_users();
		$users_count = $count_users['total_users'];
		$database_info .= sprintf(_n('%d user', '%d users', $users_count, $this->plugin_name), $users_count) . "<br />";

		// Orders
		$orders_count = $this->count_posts('shop_order') + $this->count_posts('shop_order_placehold');
		$database_info .= sprintf(_n('%d order', '%d orders', $orders_count, $this->plugin_name), $orders_count) . "<br />";

		return $database_info;
	}
	
	/**
	 * Save the Premium options
	 *
	 */
	public function save_premium_options() {
		$this->premium_options = array_merge($this->premium_options, $this->validate_form_premium_info());
		update_option('fgm2wcp_options', $this->premium_options);
	}

	/**
	 * Validate POST info
	 *
	 * @return array Form parameters
	 */
	private function validate_form_premium_info() {
		$result = array(
			'meta_keywords_in_tags'				=> filter_input(INPUT_POST, 'meta_keywords_in_tags', FILTER_VALIDATE_BOOLEAN),
			'import_meta_seo'					=> filter_input(INPUT_POST, 'import_meta_seo', FILTER_VALIDATE_BOOLEAN),
			'url_redirect'						=> filter_input(INPUT_POST, 'url_redirect', FILTER_VALIDATE_BOOLEAN),
			'website'							=> filter_input(INPUT_POST, 'website', FILTER_SANITIZE_SPECIAL_CHARS),
			'store'								=> filter_input(INPUT_POST, 'store', FILTER_VALIDATE_INT),
			'import_customers_orders'			=> filter_input(INPUT_POST, 'import_customers_orders', FILTER_SANITIZE_SPECIAL_CHARS),
			'update_stock_only'					=> filter_input(INPUT_POST, 'update_stock_only', FILTER_VALIDATE_BOOLEAN),
			'skip_cms'							=> filter_input(INPUT_POST, 'skip_cms', FILTER_VALIDATE_BOOLEAN),
			'skip_products_categories'			=> filter_input(INPUT_POST, 'skip_products_categories', FILTER_VALIDATE_BOOLEAN),
			'skip_disabled_products_categories'	=> filter_input(INPUT_POST, 'skip_disabled_products_categories', FILTER_VALIDATE_BOOLEAN),
			'skip_products'						=> filter_input(INPUT_POST, 'skip_products', FILTER_VALIDATE_BOOLEAN),
			'skip_disabled_products'			=> filter_input(INPUT_POST, 'skip_disabled_products', FILTER_VALIDATE_BOOLEAN),
			'skip_attributes'					=> filter_input(INPUT_POST, 'skip_attributes', FILTER_VALIDATE_BOOLEAN),
			'skip_users'						=> filter_input(INPUT_POST, 'skip_users', FILTER_VALIDATE_BOOLEAN),
			'skip_customers'					=> filter_input(INPUT_POST, 'skip_customers', FILTER_VALIDATE_BOOLEAN),
			'skip_inactive_customers'			=> filter_input(INPUT_POST, 'skip_inactive_customers', FILTER_VALIDATE_BOOLEAN),
			'skip_orders'						=> filter_input(INPUT_POST, 'skip_orders', FILTER_VALIDATE_BOOLEAN),
			'skip_reviews'						=> filter_input(INPUT_POST, 'skip_reviews', FILTER_VALIDATE_BOOLEAN),
			'skip_coupons'						=> filter_input(INPUT_POST, 'skip_coupons', FILTER_VALIDATE_BOOLEAN),
			'skip_redirects'					=> filter_input(INPUT_POST, 'skip_redirects', FILTER_VALIDATE_BOOLEAN),
		);
		$result = apply_filters('fgm2wcp_validate_form_premium_info', $result);
		return $result;
	}

	/**
	 * Delete all the Yoast SEO data
	 * 
	 * @since 2.80.0
	 * 
	 * @global object $wpdb WPDB object
	 * @param string $action Action
	 */
	public function delete_yoastseo_data($action) {
		global $wpdb;
		if ( $action == 'all' ) {
			$wpdb->hide_errors();
			$sql_queries = array();
			
			// Delete the Yoast SEO tables
			$sql_queries[] = "TRUNCATE {$wpdb->prefix}yoast_indexable";
			$sql_queries[] = "TRUNCATE {$wpdb->prefix}yoast_indexable_hierarchy";
			$sql_queries[] = "TRUNCATE {$wpdb->prefix}yoast_migrations";
			$sql_queries[] = "TRUNCATE {$wpdb->prefix}yoast_primary_term";
			$sql_queries[] = "TRUNCATE {$wpdb->prefix}yoast_seo_links";
			$sql_queries[] = "TRUNCATE {$wpdb->prefix}yoast_seo_meta";
			
			// Execute SQL queries
			if ( count($sql_queries) > 0 ) {
				foreach ( $sql_queries as $sql ) {
					$wpdb->query($sql);
				}
			}
		}
	}
	
	/**
	 * Set the store ID
	 */
	public function set_store_id() {
		if ( $this->display_multistore ) {
			$this->website_id = $this->premium_options['website'];
			$this->store_id = $this->premium_options['store'];
		}
		$this->import_selected_store_only = $this->display_multistore && $this->premium_options['import_customers_orders'] == 'selected_store';
	}
	
	/**
	 * Set the variables used by Magento Enterprise Edition
	 */
	public function set_enterprise_edition_variables() {
		$this->entity_id_field = $this->column_exists('catalog_product_entity_int', 'row_id')? 'row_id' : 'entity_id';
		$this->page_id_field = $this->column_exists('cms_page_store', 'row_id')? 'row_id' : 'page_id';
	}
	
	/**
	 * Sets the SEO meta fields
	 * 
	 * @param int $new_post_id WordPress ID
	 * @param array $post Magento post or product
	 */
	public function set_meta_seo($new_post_id, $post) {
		if ( $this->premium_options['import_meta_seo'] ) {
			if ( array_key_exists('meta_title', $post) && !empty($post['meta_title']) ) {
				if ( defined('WPSEO_VERSION') ) { // Yoast SEO
					update_post_meta($new_post_id, '_yoast_wpseo_title', $post['meta_title']);
				}
				if ( class_exists('RankMath') ) { // RankMath
					update_post_meta($new_post_id, 'rank_math_title', $post['meta_title']);
				}
			}
			if ( array_key_exists('meta_description', $post) && !empty($post['meta_description']) ) {
				if ( defined('WPSEO_VERSION') ) { // Yoast SEO
					update_post_meta($new_post_id, '_yoast_wpseo_metadesc', $post['meta_description']);
				}
				if ( class_exists('RankMath') ) { // RankMath
					update_post_meta($new_post_id, 'rank_math_description', $post['meta_description']);
				}
			}
			if ( array_key_exists('meta_keyword', $post) && !empty($post['meta_keyword']) ) {
				if ( defined('WPSEO_VERSION') ) { // Yoast SEO
					update_post_meta($new_post_id, '_yoast_wpseo_metakeywords', str_replace(array("\n", "\r"), array(',', ''), trim($post['meta_keyword'])));
				}
			}
			if ( array_key_exists('meta_keywords', $post) && !empty($post['meta_keywords']) ) {
				if ( defined('WPSEO_VERSION') ) { // Yoast SEO
					update_post_meta($new_post_id, '_yoast_wpseo_metakeywords', str_replace(array("\n", "\r"), array(',', ''), trim($post['meta_keywords'])));
				}
			}
		}
	}

	/**
	 * Delete the Yoast SEO taxonomy meta data (title, description, keywords)
	 * 
	 * @since 2.32.0
	 */
	public function delete_wpseo_taxonomy_meta() {
		delete_option('wpseo_taxonomy_meta');
	}
	
	/**
	 * Sets the product categories SEO meta fields
	 * 
	 * @since 2.32.0
	 * 
	 * @param int $new_term_id WordPress term ID
	 * @param array $product_category Magento product category
	 */
	public function set_product_cat_meta_seo($new_term_id, $product_category) {
		if ( $this->premium_options['import_meta_seo'] &&
			( array_key_exists('meta_title', $product_category) ||
			  array_key_exists('meta_description', $product_category) ||
			  array_key_exists('meta_keywords', $product_category)
			)
		) {
			$wpseo_taxonomy_meta = get_option('wpseo_taxonomy_meta');
			if ( array_key_exists('meta_title', $product_category) && !empty($product_category['meta_title']) ) {
				if ( defined('WPSEO_VERSION') ) { // Yoast SEO
					$wpseo_taxonomy_meta['product_cat'][$new_term_id]['wpseo_title'] = $product_category['meta_title'];
				}
				if ( class_exists('RankMath') ) { // RankMath
					update_term_meta($new_term_id, 'rank_math_title', $product_category['meta_title']);
				}
			}
			if ( array_key_exists('meta_description', $product_category) && !empty($product_category['meta_description']) ) {
				if ( defined('WPSEO_VERSION') ) { // Yoast SEO
					$wpseo_taxonomy_meta['product_cat'][$new_term_id]['wpseo_desc'] = $product_category['meta_description'];
				}
				if ( class_exists('RankMath') ) { // RankMath
					update_term_meta($new_term_id, 'rank_math_description', $product_category['meta_description']);
				}
			}
			if ( array_key_exists('meta_keywords', $product_category) && !empty($product_category['meta_keywords']) ) {
				$wpseo_taxonomy_meta['product_cat'][$new_term_id]['wpseo_metakey'] = $product_category['meta_keywords'];
			}
			if ( defined('WPSEO_VERSION') ) { // Yoast SEO
				update_option('wpseo_taxonomy_meta', $wpseo_taxonomy_meta);
			}
		}
	}
	
	/**
	 * Sets the post tags from the meta keywords
	 *
	 * @since 1.12.0
	 * 
	 * @param int $new_post_id WordPress ID
	 * @param array $post Magento post
	 */
	public function set_post_tags($new_post_id, $post) {
		$this->set_tags($new_post_id, $post, 'post_tag');
	}

	/**
	 * Sets the product tags from the meta keywords
	 *
	 * @since 1.12.0
	 * 
	 * @param int $new_post_id WordPress ID
	 * @param array $product Magento product
	 */
	public function set_product_tags($new_post_id, $product) {
		$this->set_tags($new_post_id, $product, 'product_tag');
	}

	/**
	 * Sets the tags from the meta keywords
	 *
	 * @since 1.12.0
	 * 
	 * @param int $new_post_id WordPress ID
	 * @param array $post Magento post or product
	 * @param string $taxonomy post_tag or product_tag
	 */
	public function set_tags($new_post_id, $post, $taxonomy) {
		if ( $this->premium_options['meta_keywords_in_tags'] ) {
			$meta_keywords = '';
			if (isset($post['meta_keyword']) ) {
				$meta_keywords = $post['meta_keyword'];
			} elseif (isset($post['meta_keywords']) ) {
				$meta_keywords = $post['meta_keywords'];
			}
			$meta_keywords = str_replace(array("\n", "\r"), array(',', ''), trim($meta_keywords));
			$tags = explode(',', $meta_keywords);
			$this->import_tags($tags, $taxonomy);
			
			if ( !empty($tags) ) {
				// Assign the tags to the post
				wp_set_object_terms($new_post_id, $tags, $taxonomy);
			}
		}
	}

	/**
	 * Import tags
	 * 
	 * @since 2.13.0
	 * 
	 * @param array $tags Tags
	 * @param string $taxonomy Taxonomy (post_tag | product_tag)
	 */
	public function import_tags($tags, $taxonomy) {
		foreach ( $tags as $tag ) {
			$new_term = wp_insert_term($tag, $taxonomy);
			if ( !is_wp_error($new_term) ) {
				add_term_meta($new_term['term_id'], '_fgm2wc_imported', 1, true);
			}
		}
	}

	/**
	 * Add a user if it does not exists
	 *
	 * @param string $firstname User's first name
	 * @param string $lastname User's last name
	 * @param string $login Login
	 * @param string $email User's email
	 * @param string $password User's password in Magento
	 * @param int $mg_user_id Magento User ID
	 * @param string $register_date Registration date
	 * @param string $role User's role - default: subscriber
	 * @return int User ID
	 */
	public function add_user($firstname, $lastname, $login, $email, $password, $mg_user_id, $register_date='', $role='subscriber') {
		$display_name = trim($firstname . ' ' . $lastname);
		// Login and nickname
		if ( empty($login) ) {
			$login = sanitize_user($email, false); // Keep the @
			$nickname = $display_name;
		} else {
			$login = FG_Magento_to_WooCommerce_Tools::convert_to_latin(remove_accents($login));
			$login = sanitize_user($login, true);
			$nickname = $login;
		}
		$login = substr($login, 0, 60);
		$user_nicename = mb_substr(str_replace(' ', '', $nickname), 0, 50, 'UTF-8');
		$email = sanitize_email($email);
		
		$user = get_user_by('slug', $login);
		if ( !$user ) {
			$user = get_user_by('email', $email);
		}
		if ( !$user ) {
			// Create a new user
			$userdata = array(
				'user_login'		=> $login,
				'user_pass'			=> wp_generate_password( 12, false ),
				'nickname'			=> $nickname,
				'user_nicename'		=> $user_nicename,
				'user_email'		=> $email,
				'display_name'		=> $display_name,
				'first_name'		=> $firstname,
				'last_name'			=> $lastname,
				'user_registered'	=> $register_date,
				'role'				=> $role,
			);
			$user_id = wp_insert_user( $userdata );
			if ( is_wp_error($user_id) ) {
				//$this->display_admin_error(sprintf(__('Creating user %s: %s', $this->get_plugin_name()), $login, $user_id->get_error_message()));
			} else {
				add_user_meta($user_id, '_fgm2wc_old_user_id', $mg_user_id, true);
				if ( !empty($password) ) {
					// Magento password to authenticate the users
					add_user_meta($user_id, 'magentopass', $password, true);
				}
				//$this->display_admin_notice(sprintf(__('User %s created', $this->get_plugin_name()), $login));
			}
		}
		else {
			$user_id = $user->ID;
			global $blog_id;
			if ( is_multisite() && $blog_id && !is_user_member_of_blog($user_id) ) {
				// Add user to the current blog (in multisite)
				add_user_to_blog($blog_id, $user_id, $role);
			}
		}
		return $user_id;
	}

	/**
	 * Recount the terms
	 * 
	 * @since 2.1.0
	 */
	public function recount_terms() {
		$taxonomy_names = wc_get_attribute_taxonomy_names();
		foreach ( $taxonomy_names as $taxonomy ) {
			$terms = get_terms($taxonomy, array('hide_empty' => 0));
			$termtax = array();
			foreach ( $terms as $term ) {
				$termtax[] = $term->term_taxonomy_id; 
			}
			wp_update_term_count($termtax, $taxonomy);
		}
	}
	
	/**
	 * Append the lists of websites and stores to an array
	 * 
	 * @since 2.20.0
	 * 
	 * @param array $result Array
	 * @return array Same array with the websites and stores appended
	 */
	public function append_websites_and_stores($result) {
		$websites_and_stores = $this->get_lists_of_websites_and_stores();
		if ( $websites_and_stores !== false ) {
			$result = array_merge($result, $websites_and_stores);
		}
		return $result;
	}
	
	/**
	 * Get the lists of websites and stores
	 * 
	 * @since 2.20.0
	 * 
	 * @return array [
	 *			websites: string HTML SELECT list of websites
	 *			stores: string HTML SELECT list of stores
	 *			] | false
	 */
	private function get_lists_of_websites_and_stores() {
		$websites = get_option('fgm2wc_websites');
		$stores = get_option('fgm2wc_stores');
		if ( !empty($websites) && !empty($stores) ) {
			return array(
				'websites' => $this->format_options($websites, $this->premium_options['website'], true),
				'stores' => $this->format_options($stores, $this->premium_options['store']),
			);
		}
		return false;
	}
	
	/**
	 * Update the websites and the stores
	 * 
	 * @since 2.20.1
	 */
	public function update_websites_and_stores() {
		if ( $this->magento_connect() ) {
			$websites = $this->get_websites();
			update_option('fgm2wc_websites', $websites);
			
			$stores = $this->get_stores();
			update_option('fgm2wc_stores', $stores);
			
			if ( is_null($this->premium_options['website']) ) {
				$this->premium_options['website'] = $this->get_default_website_id();
			}
			if ( is_null($this->premium_options['store']) ) {
				$this->premium_options['store'] = isset($stores[0]['id'])? $stores[0]['id'] : 0;
			}
		}
	}
	
	/**
	 * Get the list of Magento web sites
	 * 
	 * @since 2.16.0
	 * 
	 * @return array List of web sites
	 */
	public function get_websites() {
		$websites = array();
		$prefix = $this->plugin_options['prefix'];
		$website_table = version_compare($this->magento_version, '2', '<')? 'core_website' : 'store_website';

		$sql = "
			SELECT w.website_id AS id, w.code, w.name, w.is_default
			FROM {$prefix}{$website_table} w
			ORDER BY w.sort_order
		";
		$websites = $this->magento_query($sql);
		
		return $websites;
	}
	
	/**
	 * Get the list of Magento stores
	 * 
	 * @since 2.2.0
	 * 
	 * @return array List of stores
	 */
	public function get_stores() {
		$stores = array();
		$prefix = $this->plugin_options['prefix'];
		$store_table = version_compare($this->magento_version, '2', '<')? 'core_store' : 'store';
		$store_group_table = version_compare($this->magento_version, '2', '<')? 'core_store_group' : 'store_group';

		$sql = "
			SELECT s.store_id AS id, s.code, s.name, IF(sg.group_id IS NULL, 0, 1) AS is_default
			FROM {$prefix}{$store_table} s
			LEFT JOIN {$prefix}{$store_group_table} sg ON sg.default_store_id = s.store_id
			WHERE s.is_active = 1
			ORDER BY s.sort_order
		";
		$stores = $this->magento_query($sql);
		
		return $stores;
	}
	
	/**
	 * Print the options of the websites and stores select boxes
	 * 
	 * @since 2.16.0
	 * 
	 * @param array $items Magento items
	 * @param string $selected_value Selected value
	 * @param bool $option_all Add the "All" option
	 * @return string Options
	 */
	private function format_options($items, $selected_value, $option_all=false) {
		$options = '';
		if ( $option_all ) {
			$selected = ($selected_value == 'all');
			$options .= '<option value="all"' . ($selected? ' selected="selected"': '') . '>' . __('All', $this->plugin_name) . '</option>' . "\n";
		}
		foreach ( $items as $item ) {
			if ( isset($item['id']) ) {
				$selected = is_null($selected_value)? $item['is_default'] == 1 : $item['id'] == $selected_value;
				$options .= '<option value="' . $item['id'] . '"' . ($selected? ' selected="selected"': '') . '>' . $item['name'] . '</option>' . "\n";
			}
		}
		return $options;
	}
	
	/**
	 * Update the already imported products and orders
	 * 
	 * @since 2.3.0
	 * 
	 * @param string $action Action
	 */
	public function update($action) {
		if ( $action != 'update' ) {
			return;
		}
		
		if ( defined('WP_CLI') || defined('DOING_CRON') || check_admin_referer( 'parameters_form', 'fgm2wc_nonce' ) ) { // Security check
			if ( !defined('WP_CLI') && !defined('DOING_CRON') ) {
				// Save database options
				$this->save_plugin_options();
			}

			if ( $this->magento_connect() ) {
				do_action('fgm2wc_pre_test_database_connection');
				$this->pre_import();

				$last_update = get_option('fgm2wc_last_update');
				
				// Hook for doing other actions before the update
				do_action('fgm2wc_pre_update', $last_update);

				$this->update_categories($last_update);
				$this->update_products($last_update);
				
				// Hook for doing other actions after the update
				do_action('fgm2wc_post_update', $last_update);

				update_option('fgm2wc_last_update', date('Y-m-d H:i:s'));
			}
		}
	}
	
	/**
	 * Update the already imported products
	 * 
	 * @since 2.3.0
	 * 
	 * @param date $last_update Last update date
	 */
	private function update_products($last_update) {
		$product_ids = $this->get_updated_product_ids($last_update);
		
		$message = __('Updating products...', $this->plugin_name);
		if ( defined('WP_CLI') ) {
			$progress_cli = \WP_CLI\Utils\make_progress_bar($message, count($product_ids));
		} else {
			$this->log($message);
		}
		$this->updated_products_count = 0;
		$this->imported_products = $this->get_imported_magento_products();

		$this->get_imported_categories($this->default_language);
		$this->attribute_types = $this->get_magento_attributes();
		$this->entity_type_codes = $this->get_magento_entity_type_codes();

		foreach ( $product_ids as $product_id ) {
			// Get the WordPress product ID
			$post_id = $this->get_wp_product_id_from_magento_id($product_id);
			if ( !empty($post_id) ) {
				if ( $this->update_product($post_id, $product_id, $this->default_language) ) {
					$this->updated_products_count++;
					
					// Hook for doing other actions after updating the post
					do_action('fgm2wc_post_post_update_product', $post_id, $product_id);
				}
			}
			if ( defined('WP_CLI') ) {
				$progress_cli->tick(1);
			}
		}
		if ( defined('WP_CLI') ) {
			$progress_cli->finish();
		}
		$this->display_admin_notice(sprintf(_n('%d product updated', '%d products updated', $this->updated_products_count, $this->plugin_name), $this->updated_products_count));

		// Hook for doing other actions after all products are updated
		do_action('fgm2wc_post_update_products', $last_update);
	}
	
	/**
	 * Get the products updated after a date
	 * 
	 * @since 2.3.0
	 * 
	 * @param date $last_update Last update date
	 */
	private function get_updated_product_ids($last_update) {
		$product_ids = array();
		$prefix = $this->plugin_options['prefix'];

		$order_items_table = $this->table_exists('sales_flat_order_item')? 'sales_flat_order_item' : 'sales_order_item';
		if ( version_compare($this->magento_version, '1.4', '<') ) {
			// Magento 1.3 and less
			$relation_criteria = "INNER JOIN {$prefix}catalog_product_super_link r on r.product_id = p.entity_id";
		} else {
			// Magento 1.4+
			$relation_criteria = "INNER JOIN {$prefix}catalog_product_relation r on r.child_id = p.entity_id";
		}
		$sql = "
			SELECT DISTINCT p.entity_id
			FROM {$prefix}catalog_product_entity p
			INNER JOIN {$prefix}catalog_product_entity_int pei ON pei.{$this->entity_id_field} = p.entity_id
			INNER JOIN {$prefix}eav_attribute a ON a.attribute_id = pei.attribute_id
			WHERE p.updated_at > '$last_update'
			AND a.attribute_code = 'visibility'
			AND pei.value != 1 -- Different from 'Not visible individually'

			UNION

			SELECT DISTINCT p.entity_id
			FROM {$prefix}catalog_product_entity p
			INNER JOIN {$prefix}{$order_items_table} oi ON oi.product_id = p.entity_id
			INNER JOIN {$prefix}catalog_product_entity_int pei ON pei.{$this->entity_id_field} = p.entity_id
			INNER JOIN {$prefix}eav_attribute a ON a.attribute_id = pei.attribute_id
			WHERE oi.updated_at > '$last_update'
			AND a.attribute_code = 'visibility'
			AND pei.value != 1 -- Different from 'Not visible individually'
			
			UNION
			
			-- parents of the updated child products
			SELECT DISTINCT pp.entity_id
			FROM {$prefix}catalog_product_entity p
			INNER JOIN {$prefix}catalog_product_entity_int pei ON pei.{$this->entity_id_field} = p.entity_id
			INNER JOIN {$prefix}eav_attribute a ON a.attribute_id = pei.attribute_id
			$relation_criteria
			INNER JOIN {$prefix}catalog_product_entity pp ON pp.entity_id = r.parent_id
			WHERE p.updated_at > '$last_update'
			AND a.attribute_code = 'visibility'
			AND pei.value = 1 -- 'Not visible individually'
		";
		$sql = apply_filters('fgm2wc_get_updated_products_sql', $sql);
		$results = $this->magento_query($sql);
		foreach ( $results as $row ) {
			$product_ids[] = $row['entity_id'];
		}
		$product_ids = apply_filters('fgm2wc_get_updated_product_ids', $product_ids);

		return $product_ids;
	}
	
	/**
	 * Update a product
	 * 
	 * @since 3.17.0
	 * 
	 * @param int $post_id WP post ID
	 * @param int $product_entity_id Magento Product entity ID
	 * @param int $language Language ID
	 * @return bool Product updated?
	 */
	public function update_product($post_id, $product_entity_id, $language) {
		$result = false;
		
		$product = $this->get_product($product_entity_id);
		$product = array_merge($product, $this->get_other_product_fields($product['entity_id'], $this->product_type_id));

		if ( $this->premium_options['update_stock_only'] ) {
			// Stock
			$stock = $this->get_stock($product['entity_id'], $this->website_id);
			if ( empty($stock) ) {
				$stock = $this->get_stock($product['entity_id'], 0); // Get the stock of the website 0
			}
			$product = array_merge($product, $stock);
			
			// Update the stock and backorders only
			$result = $this->update_product_stock_and_backorders($post_id, $product);
			
		} else {
			// Update all data
			list($new_post, $product_medias, $post_media) = $this->build_product_post($product, $product_entity_id, $language);
			$new_post['ID'] = $post_id;

			// Hook for modifying the WordPress post just before the update
			$new_post = apply_filters('fgm2wc_pre_update_product', $new_post, $product);

			$new_post_id = wp_update_post($new_post);

			if ( $new_post_id ) {

				$prices = $this->import_product_details($new_post_id, $product, $product_medias, $post_media);

				// Remove the product attributes before reimporting them
				$this->remove_product_attributes($new_post_id);

				// Remove the product variations before reimporting them
				$this->remove_product_variations($new_post_id);

				// Hook for doing other actions after importing the product details
				do_action('fgm2wc_post_import_product_details', $new_post_id, $product, $prices['regular_price'], $prices['sale_price']);
				$result = true;
			}
		}
		if ( $result ) {
			// Hook for doing other actions after updating the post
			do_action('fgm2wc_post_update_product', $post_id, $product);
		}
		return $result;
	}
	
	/**
	 * Update the product stock and backorders
	 * 
	 * @since 3.18.0
	 * 
	 * @param int $post_id WP post ID
	 * @param array $product Magento product
	 * @return bool Product updated?
	 */
	public function update_product_stock_and_backorders($post_id, $product) {
		$manage_stock = $this->set_manage_stock($product);
		$stock_status = (($product['is_in_stock'] > 0) || ($manage_stock == 'no'))? 'instock': 'outofstock';
		$backorders = $this->allow_backorders($product['backorders'], $product['use_config_backorders']);
		update_post_meta($post_id, '_manage_stock', $manage_stock);
		update_post_meta($post_id, '_stock_status', $stock_status);
		update_post_meta($post_id, '_stock', $product['qty']);
		update_post_meta($post_id, '_backorders', $backorders);
		
		return true;
	}
	
	/**
	 * Remove the WooCommerce product attributes
	 * 
	 * @since 3.17.0
	 * 
	 * @param int $product_id Product ID
	 */
	private function remove_product_attributes($product_id) {
		delete_post_meta($product_id, '_product_attributes');
		
		$taxonomies = get_post_taxonomies($product_id);
		$attributes_taxonomies = array();
		foreach ( $taxonomies as $taxonomy ) {
			if ( strpos($taxonomy, 'pa_') === 0 ) {
				$attributes_taxonomies[] = $taxonomy;
			}
		}
		wp_delete_object_term_relationships($product_id, $attributes_taxonomies);
	}
	
	/**
	 * Remove the WooCommerce product variations
	 * 
	 * @since 3.17.0
	 * 
	 * @param int $product_id Product ID
	 */
	private function remove_product_variations($product_id) {
			$product_variations = get_children(array(
			'numberposts'    => -1,
			'post_parent'    => $product_id,
			'post_status'    => 'any',
			'post_type'      => 'product_variation',
		));
		foreach ( $product_variations as $product_variation ) {
			wp_delete_post($product_variation->ID, true);
		}
	}
	
	/**
	 * Normalize the attribute name
	 * 
	 * @since 2.5.0
	 * 
	 * @param string $attribute_label Attribute label
	 * @return string Normalized attribute name
	 */
	public function normalize_attribute_name($attribute_label) {
		$attribute_label = trim($attribute_label);
		// To avoid duplicates between 1.2 and 12 for example
		// And to get both the negative and positive values if they have the same absolute value
		$attribute_label = str_replace(array('.', ',', '-', '+', '*', '/'), '_', $attribute_label);
		$attribute_name = sanitize_key(FG_Magento_to_WooCommerce_Tools::convert_to_latin($attribute_label));
		
		// Add a CRC prefix if the attribute name has more than 29 characters
		// to avoid the duplicates due to the truncation of long labels
		$max_attribute_length = 29;
		if ( strlen($attribute_name) > $max_attribute_length ) {
			$crc = hash("crc32b", $attribute_label);
			$short_crc = substr($crc, 0, 2); // Keep only the 2 first characters (should be enough)
			$attribute_name = $short_crc . '-' . $attribute_name;
		}
		$attribute_name = str_replace('pa_', 'paa_', $attribute_name); // Workaround to WooCommerce bug that doesn't process well the attributes containing "pa_". Issue opened on WooCommerce: https://github.com/woocommerce/woocommerce/issues/22101
		$attribute_name = substr($attribute_name, 0, $max_attribute_length); // The taxonomy is limited to 32 characters in WordPress
		return $attribute_name;
	}
	
	/**
	 * Get the WooCommerce products
	 *
	 * @since 2.21.0
	 * 
	 * @return array of products mapped with the Magento products ids
	 */
	public function get_woocommerce_products() {
		global $wpdb;
		$products = array();

		try {
			$sql = "
				SELECT post_id, meta_value
				FROM $wpdb->postmeta
				WHERE meta_key = '_fgm2wc_old_product_id'
			";
			$rows = $wpdb->get_results($sql);
			foreach ( $rows as $row ) {
				$products[$row->meta_value] = $row->post_id;
			}
		} catch ( PDOException $e ) {
			$this->display_admin_error(__('Error:', __CLASS__) . $e->getMessage());
		}
		return $products;
	}

	/**
	 * Update the already imported product categories
	 * 
	 * @since 3.27.0
	 * 
	 * @param date $last_update Last update date
	 */
	private function update_categories($last_update='') {
		$category_ids = $this->get_updated_category_ids($last_update);
		
		$message = __('Updating product categories...', $this->plugin_name);
		if ( defined('WP_CLI') ) {
			$progress_cli = \WP_CLI\Utils\make_progress_bar($message, count($category_ids));
		} else {
			$this->log($message);
		}
		
		// Allow HTML in term descriptions
		foreach ( array('pre_term_description') as $filter ) {
			remove_filter($filter, 'wp_filter_kses');
		}

		$this->updated_categories_count = 0;
		$language = $this->default_language;
		$this->used_slugs = array();
		$this->get_imported_categories($language);

		foreach ( $category_ids as $category_id ) {
			// Get the WordPress category ID
			$term_id = $this->get_wp_term_id_from_meta('_fgm2wc_old_product_category_id-lang' . $language, $category_id);
			if ( !empty($term_id) ) {
				if ( $this->update_category($term_id, $category_id, $language) ) {
					$this->updated_categories_count++;
					
					// Hook for doing other actions after updating the category
					do_action('fgm2wc_post_update_category', $term_id, $category_id);
				}
			}
			if ( defined('WP_CLI') ) {
				$progress_cli->tick(1);
			}
		}
		if ( defined('WP_CLI') ) {
			$progress_cli->finish();
		}
		$this->display_admin_notice(sprintf(_n('%d category updated', '%d categories updated', $this->updated_categories_count, $this->plugin_name), $this->updated_categories_count));

		// Hook for doing other actions after all categories are updated
		do_action('fgm2wc_post_update_categories', $last_update);
	}
	
	/**
	 * Get the categories updated after a date
	 * 
	 * @since 3.27.0
	 * 
	 * @param date $last_update Last update date
	 * @return array of category IDs
	 */
	private function get_updated_category_ids($last_update='') {
		$category_ids = array();
		$prefix = $this->plugin_options['prefix'];

		$sql = "
			SELECT DISTINCT c.entity_id
			FROM {$prefix}catalog_category_entity c
			WHERE c.parent_id != 0 -- don't import the root category
			AND c.updated_at > '$last_update'
			ORDER BY c.entity_id
		";
		$results = $this->magento_query($sql);
		foreach ( $results as $row ) {
			$category_ids[] = $row['entity_id'];
		}

		return $category_ids;
	}
	
	/**
	 * Update a category
	 * 
	 * @since 3.27.0
	 * 
	 * @param int $term_id WP term ID
	 * @param $category_id Magento category ID
	 * @param int $language Language ID
	 * @return bool Category updated?
	 */
	public function update_category($term_id, $category_id, $language) {
		$result = false;
		
		$category = $this->get_category($category_id);
		
		// Other fields
		$category = array_merge($category, $this->get_other_category_fields($category['entity_id'], $this->category_type_id));
		if ( !isset($category['name']) ) {
			return false;
		}

		// Date
		$date = $category['created_at'];

		// Slug
		$slug = isset($category['url_key'])? $category['url_key']: sanitize_title($category['name']);
		$slug = $this->build_unique_slug($slug, $this->used_slugs);
		$this->used_slugs[] = $slug;

		// Parent
		$parent_id = isset($this->imported_categories[$language][$category['parent_id']])? $this->imported_categories[$language][$category['parent_id']] : 0;

		// Description
		$description = isset($category['description'])? $this->replace_media_shortcodes(html_entity_decode($category['description'])): '';
		if ( !empty($description) ) {
			if ( !$this->plugin_options['skip_media'] ) {
				$media = $this->import_media_from_content($description, $category['created_at']);
				$category_media = $media['media'];
			} else {
				// Skip media
				$category_media = array();
			}
			$description = $this->process_content($description, $category_media);
		}

		// Insert the category
		$taxonomy = 'product_cat';
		$new_category = array(
			'description'	=> $description,
			'slug'			=> $slug,
			'parent'		=> $parent_id,
		);

		// Hook before updating the category
		$new_category = apply_filters('fgm2wc_pre_update_product_category', $new_category, $category);

		$new_term = wp_update_term($term_id, $taxonomy, $new_category);
		if ( !is_wp_error($new_term) ) {
			$result = true;
			// Category ordering
			if ( function_exists('wc_set_term_order') ) {
				wc_set_term_order($new_term['term_id'], $category['position'], $taxonomy);
			}

			// Category image
			if ( !$this->plugin_options['skip_media'] ) {
				$image_filename = $this->guess_image_filename($category);
				if ( !empty($image_filename) ) {
					if ( strpos($image_filename, $this->media_path) === 0 ) {
						$image_path = $image_filename;
					} else {
						$image_path = $this->media_path . '/catalog/category/' . $image_filename;
					}
					$thumbnail_id = $this->import_media($category['name'], $image_path, $date);
					if ( !empty($thumbnail_id) ) {
						$this->media_count++;
						update_term_meta($new_term['term_id'], 'thumbnail_id', $thumbnail_id);
					}
				}
			}
			// Hook after updating the category
			do_action('fgm2wc_post_update_product_category', $new_term['term_id'], $category);
		}
		return $result;
	}
	
}
