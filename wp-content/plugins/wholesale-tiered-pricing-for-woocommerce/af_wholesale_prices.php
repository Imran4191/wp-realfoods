<?php

/**
	* Plugin Name:       WooCommerce Wholesale and Tier Prices
	* Requires Plugins:  woocommerce
	* Plugin URI:        https://woocommerce.com/products/wholesale-tiered-pricing-for-woocommerce
	* Description:       Wholesale Pricing for WooCommerce by Addify enables you to add quantity based product pricing based on specific customers and user roles.
	* Version:           1.6.0
	* Author:            Addify
	* Developed By:      Addify
	* Author URI:        https://woocommerce.com/vendor/addify/
	* Support:           https://woocommerce.com/vendor/addify/
	* License:           GNU General Public License v3.0
	* License URI:       http://www.gnu.org/licenses/gpl-3.0.html
	* Domain Path:       /languages
	* Text Domain:       addify_wholesale_prices
	* WC requires at least: 4.0
	* WC tested up to: 9.*.*
	* Requires at least: 6.5
	* Tested up to: 6.*.*
	* Requires PHP: 7.4
 * Woo: 7493671:7e020622ab2fda3e883d4af5523aa674

	*/
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( !class_exists( 'Addify_Wholesale_Prices' ) ) {

	class Addify_Wholesale_Prices {


		public function __construct() {

			add_action( 'wp_loaded', array( $this, 'afwsp_main_init' ) );
			add_action( 'init', array( $this, 'afwsp_custom_post' ));
			$this->afwsp_constant_vars();


			require ADDIFY_WSP_PLUGINDIR . 'afwsp_front_ajax_controller_class.php';

			if ( is_admin() ) {
				require ADDIFY_WSP_PLUGINDIR . 'afwsp_admin_class.php';
			} else {
				require ADDIFY_WSP_PLUGINDIR . 'afwsp_front_class.php';
			}

			//HOPS compatibility
			add_action('before_woocommerce_init', array( $this, 'afwsp_HOPS_Compatibility' ));

			add_action( 'plugins_loaded', array( $this, 'afwsp_checks' ) ); 

			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'afwsp_plugin_action_links' ) );

			register_activation_hook(__FILE__, array( $this, 'afwsp_register_plugin_create_settings' ));
		}

		public function afwsp_checks() {

			// Check the installation of WooCommerce module if it is not a multi site.
			if ( ! is_multisite() ) {
				if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
					
					add_action( 'admin_notices', array( $this, 'afwsp_check_wocommerce' ));
				}
			}
		}

		public function afwsp_register_plugin_create_settings() {


			$afwsp_discount_data = (array) get_option('addify_wsp_discount_price');

			global $wp_roles;
			$roles = wp_roles()->get_names();

			foreach ( $roles as $role_id => $role ) {
				
				if (isset($afwsp_discount_data[ $role_id ]) &&  '' == $afwsp_discount_data[ $role_id ]) {
					$afwsp_discount_data[ $role_id ] = 'sale';
				} elseif (!isset($afwsp_discount_data[ $role_id ])) {
					$afwsp_discount_data[ $role_id ] = 'sale';
				}
			}

			$afwsp_discount_data['guest'] = isset($afwsp_discount_data['guest']) && '' != $afwsp_discount_data['guest']?$afwsp_discount_data['guest']:'sale';
			
			//error messages

			if (!get_option('addify_wsp_min_qty_error_msg')) {
				update_option( 'addify_wsp_min_qty_error_msg', 'Kindly enter quantity greater than %u.' );
			}
			if (!get_option('addify_wsp_max_qty_error_msg')) {
				update_option( 'addify_wsp_max_qty_error_msg', 'Kindly enter quantity less than %u.' );
			}
			if (!get_option('addify_wsp_update_cart_error_msg')) {
				update_option( 'addify_wsp_update_cart_error_msg', 'Kindly enter value between %min and  %max.' );
			}

			update_option( 'addify_wsp_discount_price', $afwsp_discount_data );

			update_option('addify_wsp_enable_table', 'yes');

			//general settings
			update_option('addify_wsp_pricing_design_type', 'table');
			update_option('addify_wsp_enable_template_heading', 'yes');
			update_option('addify_wsp_template_heading_text', 'Select your Deal');
			update_option('addify_wsp_template_heading_text_font_size', '28');
			update_option('addify_wsp_enable_template_icon', 'yes');
			update_option('addify_wsp_template_font_family', '');

			//table settings
			update_option('addify_wsp_table_header_color', '#FFFFFF');
			update_option('addify_wsp_table_header_text_color', '#000000');
			update_option('addify_wsp_table_odd_rows_color', '#FFFFFF');
			update_option('addify_wsp_table_odd_rows_text_color', '#000000');
			update_option('addify_wsp_table_even_rows_color', '#FFFFFF');
			update_option('addify_wsp_table_even_rows_text_color', '#000000');
			update_option('addify_wsp_enable_table_border', 'yes');
			update_option('addify_wsp_table_border_color', '#CFCFCF');
			update_option('addify_wsp_table_header_font_size', '18');
			update_option('addify_wsp_table_rows_font_size', '16');
			
			// List settings
			update_option('addify_wsp_list_border_color', '#95B0EE');
			update_option('addify_wsp_list_background_color', '#FFFFFF');
			update_option('addify_wsp_list_text_color', '#000000');
			update_option('addify_wsp_selected_list_background_color', '#DFEBFF');
			update_option('addify_wsp_selected_list_text_color', '#000000');

			//card settings
			update_option('addify_wsp_card_border_color', '#A3B39E');
			update_option('addify_wsp_card_background_color', '#FFFFFF');
			update_option('addify_wsp_card_text_color', '#000000');
			update_option('addify_wsp_selected_card_border_color', '#27CA34');
			update_option('addify_wsp_enable_card_sale_tag', 'yes');
			update_option('addify_wsp_sale_tag_background_color', '#FF0000');
			update_option('addify_wsp_sale_tag_text_color', '#FFFFFF');
		}

		public function afwsp_plugin_action_links( $actions ) {
			$afwsp_custom_actions = array(
				'settings' => sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=addify-wsp-settings' ), __( 'Settings', 'addify_wholesale_prices' ) ),
			);
			return array_merge( $afwsp_custom_actions, $actions );
		}

		public function afwsp_check_wocommerce() {


			// Deactivate the plugin.
			deactivate_plugins(__FILE__);

			$afwsp_woo_check = '<div id="message" class="error">
				<p><strong>' . __('Wholesale Prices for WooCommerce plugin is inactive.', 'addify_wholesale_prices') . '</strong> The <a href="http://wordpress.org/extend/plugins/woocommerce/">WooCommerce plugin</a> ' . __('must be active for this plugin to work. Please install &amp; activate WooCommerce.', 'addify_wholesale_prices') . ' »</p></div>';
			echo wp_kses_post($afwsp_woo_check);
		}

		public function afwsp_HOPS_Compatibility() {

			if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
				\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
			}
		}

		public function afwsp_main_init() {
			$afwsp_discount_data = (array) get_option('addify_wsp_discount_price');

			global $wp_roles;
			$roles = wp_roles()->get_names();

			foreach ( $roles as $role_id => $role ) {
				
				if (isset($afwsp_discount_data[ $role_id ]) &&  '' == $afwsp_discount_data[ $role_id ]) {
					$afwsp_discount_data[ $role_id ] = 'sale';
				} elseif (!isset($afwsp_discount_data[ $role_id ])) {
					$afwsp_discount_data[ $role_id ] = 'sale';
				}
			}

			$afwsp_discount_data['guest'] = isset($afwsp_discount_data['guest']) && '' != $afwsp_discount_data['guest']?$afwsp_discount_data['guest']:'sale';
			
			update_option( 'addify_wsp_discount_price', $afwsp_discount_data );


			if ( function_exists( 'load_plugin_textdomain' ) ) {
				load_plugin_textdomain( 'addify_wholesale_prices', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
			}
		}
	
		public function afwsp_constant_vars() {

			// update_option( 'addify_wsp_discount_price', '' );
			
			if ( !defined( 'ADDIFY_WSP_URL' ) ) {
				define( 'ADDIFY_WSP_URL', plugin_dir_url( __FILE__ ) );
			}

			if ( !defined( 'ADDIFY_WSP_BASENAME' ) ) {
				define( 'ADDIFY_WSP_BASENAME', plugin_basename( __FILE__ ) );
			}

			if ( ! defined( 'ADDIFY_WSP_PLUGINDIR' ) ) {
				define( 'ADDIFY_WSP_PLUGINDIR', plugin_dir_path( __FILE__ ) );
			}
		}

		public function afwsp_custom_post() {

			$labels = array(
				'name'                => __('Wholesale Prices Rules', 'addify_wholesale_prices'),
				'singular_name'       => __('Wholesale Prices Rules', 'addify_wholesale_prices'),
				'add_new'             => __('Add New Rule', 'addify_wholesale_prices'),
				'add_new_item'        => __('Add Rule', 'addify_wholesale_prices'),
				'edit_item'           => __('Edit Rule', 'addify_wholesale_prices'),
				'new_item'            => __('New Rule', 'addify_wholesale_prices'),
				'view_item'           => __('View Rule', 'addify_wholesale_prices'),
				'search_items'        => __('Search Rule', 'addify_wholesale_prices'),
				'exclude_from_search' => true,
				'not_found'           => __('No rule found', 'addify_wholesale_prices'),
				'not_found_in_trash'  => __('No rule found in trash', 'addify_wholesale_prices'),
				'parent_item_colon'   => '',
				'all_items'           => __('Wholesale Prices', 'addify_wholesale_prices'),
				'menu_name'           => __('Wholesale Prices', 'addify_wholesale_prices'),
			);
	
			$args = array(
				'labels'             => $labels,
				'menu_icon'          => plugin_dir_url( __FILE__ ) . 'assets/img/small_logo_grey.png',
				'public'             => false,
				'publicly_queryable' => false,
				'show_ui'            => true,
				'show_in_menu'       => 'woocommerce',
				'query_var'          => true,
				'capability_type'    => 'page', 
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 30,
				'rewrite'            => array(
					'slug'       => 'af-wholesale-prices-rule',
					'with_front' =>false,
				),
				'supports'           => array( 'title' ),
			);
	
			register_post_type( 'af_wholesale_price', $args );
		}
	}

	new Addify_Wholesale_Prices();

}
