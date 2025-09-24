<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      1.0.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/includes
 * @author     Frédéric GILLES
 */
class FG_Magento_to_WooCommerce_Premium {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      FG_Magento_to_WooCommerce_Premium_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;
	protected $parent_plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'FGM2WCP_PLUGIN_VERSION' ) ) {
			$this->version = FGM2WCP_PLUGIN_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'fgm2wcp';
		$this->parent_plugin_name = 'fg-magento-to-woocommerce';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - FG_Magento_to_WooCommerce_Loader. Orchestrates the hooks of the plugin.
	 * - FG_Magento_to_WooCommerce_i18n. Defines internationalization functionality.
	 * - FG_Magento_to_WooCommerce_Premium_Admin. Defines all hooks for the admin area.
	 * - FG_Magento_to_WooCommerce_Premium_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-fg-magento-to-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-fg-magento-to-woocommerce-i18n.php';

		// Load Importer API
		require_once ABSPATH . 'wp-admin/includes/import.php';
		if ( !class_exists( 'WP_Importer' ) ) {
			$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			if ( file_exists( $class_wp_importer ) ) {
				require_once $class_wp_importer;
			}
		}

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-admin.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-compatibility.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-modules-check.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-progressbar.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-debug-info.php';

		// Premium features
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-fg-magento-to-woocommerce-tools.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-cli.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-premium-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-users.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-customer-address.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-customers.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-orders.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-attributes.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-product-attributes.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-product-options.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-product-variations.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-urls.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-reviews.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-coupons.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-up-cross-sell.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-grouped-products.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-downloadable-products.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-taxes.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fg-magento-to-woocommerce-tags.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-fg-magento-to-woocommerce-users-authenticate.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-fg-magento-to-woocommerce-url-rewriting.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-fg-magento-to-woocommerce-redirect.php';

		$this->loader = new FG_Magento_to_WooCommerce_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the FG_Magento_to_WooCommerce_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new FG_Magento_to_WooCommerce_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

		// Load parent translation file
		$plugin_i18n_parent = new FG_Magento_to_WooCommerce_i18n();
		$plugin_i18n_parent->set_domain( $this->get_parent_plugin_name() );
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n_parent, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		global $fgm2wcp;
		
		// Add links to the plugin page
		$this->loader->add_filter( 'plugin_action_links_fg-magento-to-woocommerce-premium/fg-magento-to-woocommerce-premium.php', $this, 'plugin_action_links' );
		
		/**
		 * The plugin is hooked to the WordPress importer
		 */
		if ( !defined('WP_LOAD_IMPORTERS') && !defined('DOING_AJAX') && !defined('DOING_CRON') && !defined('WP_CLI') ) {
			return;
		}

		$plugin_admin = new FG_Magento_to_WooCommerce_Premium_Admin( $this->get_plugin_name(), $this->get_version() );
		$fgm2wcp = $plugin_admin; // Used by add-ons

		/*
		 * WP CLI
		 */
		if ( defined('WP_CLI') && WP_CLI ) {
			$plugin_cli = new FG_Magento_to_WooCommerce_WPCLI($plugin_admin);
			WP_CLI::add_command('import-magento', $plugin_cli);
		}
		
		$this->loader->add_action( 'admin_init', $plugin_admin, 'init' );
		$this->loader->add_action( 'fgm2wc_post_get_plugin_options', $plugin_admin, 'get_premium_options' );
		$this->loader->add_action( 'fgm2wc_post_test_database_connection', $plugin_admin, 'get_magento_info', 9 );
		$this->loader->add_action( 'load-importer-fgm2wc', $plugin_admin, 'add_help_tab', 20 );
		$this->loader->add_action( 'fgm2wc_import_notices', $plugin_admin, 'display_media_count', 10 );
		$this->loader->add_action( 'fgm2wc_post_empty_database', $plugin_admin, 'delete_woocommerce_data', 10, 1 );
		$this->loader->add_action( 'admin_footer', $plugin_admin, 'display_notices', 20 );
		$this->loader->add_action( 'wp_ajax_fgm2wcp_import', $plugin_admin, 'ajax_importer' );
		$this->loader->add_filter( 'fgm2wc_pre_import_check', $plugin_admin, 'pre_import_check', 10, 1 );
		
		/*
		 * Modules checker
		 */
		$plugin_modules_check = new FG_Magento_to_WooCommerce_Modules_Check( $plugin_admin );
		$this->loader->add_action( 'fgm2wc_post_test_database_connection', $plugin_modules_check, 'check_modules' );
		
		/*
		 * Premium features
		 */
		$this->loader->add_action( 'fgm2wc_pre_display_admin_page', $plugin_admin, 'process_admin_page' );
		$this->loader->add_action( 'fgm2wc_post_empty_database', $plugin_admin, 'delete_yoastseo_data' );
		$this->loader->add_action( 'fgm2wc_post_save_plugin_options', $plugin_admin, 'save_premium_options' );
		$this->loader->add_action( 'fgm2wc_post_save_plugin_options', $plugin_admin, 'update_websites_and_stores' );
		$this->loader->add_action( 'fgm2wc_pre_test_database_connection', $plugin_admin, 'set_store_id');
		$this->loader->add_action( 'fgm2wc_pre_test_database_connection', $plugin_admin, 'set_enterprise_edition_variables');
		$this->loader->add_action( 'fgm2wc_post_test_database_connection_click', $plugin_admin, 'append_websites_and_stores' );
		$this->loader->add_action( 'fgm2wc_pre_get_total_elements_count', $plugin_admin, 'set_store_id');
		$this->loader->add_action( 'fgm2wc_pre_import', $plugin_admin, 'set_store_id');
		$this->loader->add_action( 'fgm2wc_pre_update', $plugin_admin, 'set_store_id');
		$this->loader->add_action( 'fgm2wc_post_empty_database', $plugin_admin, 'delete_wpseo_taxonomy_meta');
		$this->loader->add_action( 'fgm2wc_post_insert_product_category', $plugin_admin, 'set_product_cat_meta_seo', 10, 2);
		$this->loader->add_action( 'fgm2wc_post_insert_post', $plugin_admin, 'set_meta_seo', 10, 2);
		$this->loader->add_action( 'fgm2wc_post_insert_post', $plugin_admin, 'set_post_tags', 10, 2);
		$this->loader->add_action( 'fgm2wc_post_import_product_details', $plugin_admin, 'set_meta_seo', 10, 2);
		$this->loader->add_action( 'fgm2wc_post_import_product_details', $plugin_admin, 'set_product_tags', 10, 2);
		$this->loader->add_filter( 'fgm2wc_get_database_info', $plugin_admin, 'get_premium_database_info' );
		$this->loader->add_action( 'fgm2wc_post_import_products', $plugin_admin, 'recount_terms', 20 );
		$this->loader->add_action( 'fgm2wc_dispatch', $plugin_admin, 'update', 10, 1 );
		$this->loader->add_filter( 'fgm2wc_get_option_names', $plugin_admin, 'get_option_names', 10, 1 );
		
		/*
		 * Users
		 */
		$plugin_users = new FG_Magento_to_WooCommerce_Users( $plugin_admin );
		$this->loader->add_action( 'fgm2wc_post_empty_database', $plugin_users, 'delete_users', 10, 1 );
		$this->loader->add_action( 'fgm2wc_post_import', $plugin_users, 'import_users' );
		$this->loader->add_filter( 'fgm2wc_get_total_elements_count', $plugin_users, 'get_total_elements_count' );

		/*
		 * Customers
		 */
		$plugin_customers = new FG_Magento_to_WooCommerce_Customers( $plugin_admin );
		$this->loader->add_action( 'fgm2wc_pre_display_magento_info', $plugin_customers, 'display_magento_info' );
		$this->loader->add_action( 'fgm2wc_post_import', $plugin_customers, 'import_customers' );
		$this->loader->add_filter( 'fgm2wc_get_total_elements_count', $plugin_customers, 'get_total_elements_count' );
		$this->loader->add_action( 'fgm2wc_post_update', $plugin_customers, 'update_customers', 10, 1 );
		
		/*
		 * Orders
		 */
		$plugin_orders = new FG_Magento_to_WooCommerce_Orders( $plugin_admin );
		$this->loader->add_action( 'fgm2wc_pre_display_magento_info', $plugin_orders, 'display_magento_info' );
		$this->loader->add_action( 'fgm2wc_post_empty_database', $plugin_orders, 'reset_orders' );
		$this->loader->add_action( 'fgm2wc_post_import', $plugin_orders, 'import_orders' );
		$this->loader->add_filter( 'fgm2wc_get_total_elements_count', $plugin_orders, 'get_total_elements_count' );
		$this->loader->add_action( 'fgm2wc_post_update', $plugin_orders, 'update_orders', 10, 1 );
		
		/*
		 * Product options
		 */
		$plugin_product_options = new FG_Magento_to_WooCommerce_Product_Options( $plugin_admin );
		$this->loader->add_action( 'fgm2wc_post_empty_database', $plugin_product_options, 'reset_options' );
		$this->loader->add_action( 'fgm2wc_pre_import', $plugin_product_options, 'import_options');
		$this->loader->add_action( 'fgm2wc_post_import_product_details', $plugin_product_options, 'import_product_options', 10, 2 );
		$this->loader->add_action( 'fgm2wc_pre_update', $plugin_product_options, 'import_options');
		
		/*
		 * Product attributes
		 */
		$plugin_product_attributes = new FG_Magento_to_WooCommerce_Product_Attributes( $plugin_admin );
		$this->loader->add_action( 'fgm2wc_post_empty_database', $plugin_product_attributes, 'reset_attributes' );
		$this->loader->add_action( 'fgm2wc_pre_import', $plugin_product_attributes, 'import_attributes');
		$this->loader->add_action( 'fgm2wc_post_import_product_details', $plugin_product_attributes, 'import_product_attributes', 10, 2 );
		$this->loader->add_action( 'fgm2wc_pre_update', $plugin_product_attributes, 'import_attributes');
		
		/*
		 * Product variations
		 */
		$plugin_product_variations = new FG_Magento_to_WooCommerce_Product_Variations( $plugin_admin );
		$this->loader->add_action( 'fgm2wc_post_import_product_details', $plugin_product_variations, 'import_product_variations', 20, 4 );
		$this->loader->add_action( 'fgm2wc_post_update_product', $plugin_product_variations, 'update_product_variations_stocks', 20, 2 );
		
		/*
		 * URLs
		 */
		$plugin_urls = new FG_Magento_to_WooCommerce_Urls( $plugin_admin );
		$this->loader->add_action( 'fgm2wc_post_empty_database', $plugin_urls, 'reset_urls' );
		$this->loader->add_action( 'fgm2wc_post_import', $plugin_urls, 'import_urls' );
		$this->loader->add_filter( 'fgm2wc_get_total_elements_count', $plugin_urls, 'get_total_elements_count' );
		$this->loader->add_action( 'fgm2wc_post_import_product_details', $plugin_urls, 'import_product_url', 10, 2 );
		$this->loader->add_action( 'fgm2wc_post_insert_product_category', $plugin_urls, 'import_product_category_url', 10, 2 );
		
		/*
		 * Reviews
		 */
		$plugin_reviews = new FG_Magento_to_WooCommerce_Reviews( $plugin_admin );
		$this->loader->add_action( 'fgm2wc_post_empty_database', $plugin_reviews, 'reset_reviews' );
		$this->loader->add_action( 'fgm2wc_post_import', $plugin_reviews, 'import_reviews' );
		$this->loader->add_filter( 'fgm2wc_get_total_elements_count', $plugin_reviews, 'get_total_elements_count' );
		
		/*
		 * Coupons
		 */
		$plugin_coupons = new FG_Magento_to_WooCommerce_Coupons( $plugin_admin );
		$this->loader->add_action( 'fgm2wc_post_empty_database', $plugin_coupons, 'reset_coupons' );
		$this->loader->add_action( 'fgm2wc_post_import', $plugin_coupons, 'import_coupons' );
		$this->loader->add_filter( 'fgm2wc_get_total_elements_count', $plugin_coupons, 'get_total_elements_count' );
		
		/*
		 * Grouped products
		 */
		$plugin_grouped_products = new FG_Magento_to_WooCommerce_Grouped_Products( $plugin_admin );
		$this->loader->add_action( 'fgm2wc_post_import_products', $plugin_grouped_products, 'set_parent_products');
		$this->loader->add_action( 'fgm2wc_post_insert_product', $plugin_grouped_products, 'import_child_products', 30, 2 );
		$this->loader->add_action( 'fgm2wc_post_update_product', $plugin_grouped_products, 'update_child_products', 30, 2 );
		
		/*
		 * Up Sell and Cross Sell
		 */
		$plugin_up_cross_sell = new FG_Magento_to_WooCommerce_Up_Cross_Sell( $plugin_admin );
		$this->loader->add_action( 'fgm2wc_post_import_products', $plugin_up_cross_sell, 'import_up_and_cross_sells' );
		
		/*
		 * Downloadable products
		 */
		$plugin_downloadable_products = new FG_Magento_to_WooCommerce_Downloadable_Products( $plugin_admin );
		$this->loader->add_action( 'fgm2wc_post_import_product_details', $plugin_downloadable_products, 'set_virtual_downloadable_type', 10, 2);
		$this->loader->add_action( 'fgm2wc_post_import_product_details', $plugin_downloadable_products, 'import_downloadable_files', 10, 4);
		$this->loader->add_action( 'fgm2wc_post_save_option_variation', $plugin_downloadable_products, 'set_virtual_downloadable_type', 10, 2);
		
		/*
		 * Taxes
		 */
		$plugin_taxes = new FG_Magento_to_WooCommerce_Taxes( $plugin_admin );
		$this->loader->add_action( 'fgm2wc_post_empty_database', $plugin_taxes, 'reset_taxes' );
		$this->loader->add_action( 'fgm2wc_pre_import_products', $plugin_taxes, 'import_tax_classes', 10 );
		$this->loader->add_filter( 'fgm2wc_get_total_elements_count', $plugin_taxes, 'get_total_elements_count' );
		$this->loader->add_action( 'fgm2wc_post_import_product_details', $plugin_taxes, 'update_product_tax_class', 10, 2 );

		/*
		 * Tags
		 */
		$plugin_tags = new FG_Magento_to_WooCommerce_Tags( $plugin_admin );
		$this->loader->add_action( 'fgm2wc_post_import_product_details', $plugin_tags, 'import_product_tags', 10, 2 );
		
	}

	/**
	 * Customize the links on the plugins list page
	 *
	 * @param array $links Links
	 * @return array Links
	 */
	public function plugin_action_links($links) {
		// Add the import link
		$import_link = '<a href="admin.php?import=fgm2wc">'. __('Import', $this->plugin_name) . '</a>';
		array_unshift($links, $import_link);
		return $links;
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		/*
		 * Users authentication
		 */
		$plugin_users_authenticate = new FG_Magento_to_WooCommerce_Users_Authenticate();
		$this->loader->add_filter('authenticate', $plugin_users_authenticate, 'auth_signon', 30, 3);
		
		/*
		 * URL redirect
		 */
		new FG_Magento_to_WooCommerce_URL_Rewriting();
		$plugin_redirect = new FG_Magento_to_Woocommerce_Redirect();
		$this->loader->add_action( 'fgm2wc_post_empty_database', $plugin_redirect, 'empty_redirects' );
		$this->loader->add_action( 'template_redirect', $plugin_redirect, 'process_url' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The name of the parent plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_parent_plugin_name() {
		return $this->parent_plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    FG_Magento_to_WooCommerce_Premium_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
