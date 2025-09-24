<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // restict for direct access
}



if ( ! class_exists( 'Front_Addify_Wholesale_Prices' ) ) {

	class Front_Addify_Wholesale_Prices extends Addify_Wholesale_Prices {
		
		public $allfetchedrules;

		public $fatched_cats;

		public $wsp_hide_cart_button;
		public $wsp_cart_button_link;

		public $addify_wsp_enable_table;
		public $addify_wsp_table_position;
		public $addify_wsp_enfore_min_max_qty;
		public $addify_wsp_disable_coupon;
		public $addify_wsp_min_qty_error_msg;
		public $addify_wsp_max_qty_error_msg;
		public $addify_wsp_update_cart_error_msg;

		public $addify_wsp_pricing_design_type;
		public $addify_wsp_enable_template_heading;
		public $addify_wsp_template_heading_text;
		public $addify_wsp_template_heading_text_font_size;
		public $addify_wsp_enable_template_icon;
		public $addify_wsp_template_icon;
		public $addify_wsp_template_font_family;

		//table settings
		public $addify_wsp_table_header_color;
		public $addify_wsp_table_header_text_color;
		public $addify_wsp_table_odd_rows_color;
		public $addify_wsp_table_odd_rows_text_color;
		public $addify_wsp_table_even_rows_color;
		public $addify_wsp_table_even_rows_text_color;
		public $addify_wsp_enable_table_border;
		public $addify_wsp_table_border_color;
		public $addify_wsp_table_header_font_size;
		public $addify_wsp_table_rows_font_size;

		//list settings
		public $addify_wsp_list_border_color;
		public $addify_wsp_list_background_color;
		public $addify_wsp_list_text_color;
		public $addify_wsp_selected_list_background_color;
		public $addify_wsp_selected_list_text_color;
	
		//card settings
		public $addify_wsp_card_border_color;
		public $addify_wsp_card_background_color;
		public $addify_wsp_card_text_color;
		public $addify_wsp_selected_card_border_color;
		public $addify_wsp_enable_card_sale_tag;
		public $addify_wsp_sale_tag_background_color;
		public $addify_wsp_sale_tag_text_color;


		public $addify_wsp_discount_price;

		public $wsp_enable_hide_price_feature;
		public $wsp_enable_for_guest;
		public $wsp_enable_hide_pirce_registered;
		public $wsp_enable_hide_price;
		public $wsp_hide_user_role;
		public $wsp_hide_products;
		public $wsp_hide_categories;

		public function __construct() {

			// get all options.

			if (!empty(get_option('addify_wsp_enable_table'))) {
				$this->addify_wsp_enable_table = get_option( 'addify_wsp_enable_table');    
			} else {
				$this->addify_wsp_enable_table = '';
			}

			if (!empty(get_option('addify_wsp_table_position'))) {
				$this->addify_wsp_table_position = get_option( 'addify_wsp_table_position');    
			} else {
				$this->addify_wsp_table_position = '';
			}

			if (!empty(get_option('addify_wsp_enfore_min_max_qty'))) {
				$this->addify_wsp_enfore_min_max_qty = get_option( 'addify_wsp_enfore_min_max_qty');    
			} else {
				$this->addify_wsp_enfore_min_max_qty = '';
			}

			if (!empty(get_option('addify_wsp_disable_coupon'))) {
				$this->addify_wsp_disable_coupon = get_option( 'addify_wsp_disable_coupon');    
			} else {
				$this->addify_wsp_disable_coupon = '';
			}

			if (!empty(get_option('addify_wsp_min_qty_error_msg'))) {
				$this->addify_wsp_min_qty_error_msg = get_option( 'addify_wsp_min_qty_error_msg');  
			} else {
				$this->addify_wsp_min_qty_error_msg = '';
			}

			if (!empty(get_option('addify_wsp_max_qty_error_msg'))) {
				$this->addify_wsp_max_qty_error_msg = get_option( 'addify_wsp_max_qty_error_msg');  
			} else {
				$this->addify_wsp_max_qty_error_msg = '';
			}

			if (!empty(get_option('addify_wsp_update_cart_error_msg'))) {
				$this->addify_wsp_update_cart_error_msg = get_option( 'addify_wsp_update_cart_error_msg');  
			} else {
				$this->addify_wsp_update_cart_error_msg = '';
			}

			//template general settings
			if (!empty(get_option('addify_wsp_pricing_design_type'))) {
				$this->addify_wsp_pricing_design_type = get_option( 'addify_wsp_pricing_design_type');    
			} else {
				$this->addify_wsp_pricing_design_type = '';
			}
			if (!empty(get_option('addify_wsp_enable_template_heading'))) {
				$this->addify_wsp_enable_template_heading = get_option( 'addify_wsp_enable_template_heading');    
			} else {
				$this->addify_wsp_enable_template_heading = '';
			}
			if (!empty(get_option('addify_wsp_template_heading_text'))) {
				$this->addify_wsp_template_heading_text = get_option( 'addify_wsp_template_heading_text');    
			} else {
				$this->addify_wsp_template_heading_text = '';
			}
			if (!empty(get_option('addify_wsp_template_heading_text_font_size'))) {
				$this->addify_wsp_template_heading_text_font_size = get_option( 'addify_wsp_template_heading_text_font_size');    
			} else {
				$this->addify_wsp_template_heading_text_font_size = '';
			}
			if (!empty(get_option('addify_wsp_enable_template_icon'))) {
				$this->addify_wsp_enable_template_icon = get_option( 'addify_wsp_enable_template_icon');    
			} else {
				$this->addify_wsp_enable_template_icon = '';
			}
			if (!empty(get_option('addify_wsp_template_icon'))) {
				$this->addify_wsp_template_icon = get_option( 'addify_wsp_template_icon');    
			} else {
				$this->addify_wsp_template_icon = ADDIFY_WSP_URL . '/assets/img/fire.png';
			}


			if (!empty(get_option('addify_wsp_template_font_family'))) {
				$this->addify_wsp_template_font_family = get_option( 'addify_wsp_template_font_family');    
			} else {
				$this->addify_wsp_template_font_family = '';
			}


			if (!empty(get_option('addify_wsp_table_header_color'))) {
				$this->addify_wsp_table_header_color = get_option( 'addify_wsp_table_header_color');    
			} else {
				$this->addify_wsp_table_header_color = '';
			}

			if (!empty(get_option('addify_wsp_table_header_text_color'))) {
				$this->addify_wsp_table_header_text_color = get_option( 'addify_wsp_table_header_text_color');    
			} else {
				$this->addify_wsp_table_header_text_color = '';
			}

			if (!empty(get_option('addify_wsp_table_odd_rows_color'))) {
				$this->addify_wsp_table_odd_rows_color = get_option( 'addify_wsp_table_odd_rows_color');    
			} else {
				$this->addify_wsp_table_odd_rows_color = '';
			}

			if (!empty(get_option('addify_wsp_table_odd_rows_text_color'))) {
				$this->addify_wsp_table_odd_rows_text_color = get_option( 'addify_wsp_table_odd_rows_text_color');    
			} else {
				$this->addify_wsp_table_odd_rows_text_color = '';
			}

			if (!empty(get_option('addify_wsp_table_even_rows_color'))) {
				$this->addify_wsp_table_even_rows_color = get_option( 'addify_wsp_table_even_rows_color');  
			} else {
				$this->addify_wsp_table_even_rows_color = '';
			}

			if (!empty(get_option('addify_wsp_table_even_rows_text_color'))) {
				$this->addify_wsp_table_even_rows_text_color = get_option( 'addify_wsp_table_even_rows_text_color');  
			} else {
				$this->addify_wsp_table_even_rows_text_color = '';
			}

			if (!empty(get_option('addify_wsp_enable_table_border'))) {
				$this->addify_wsp_enable_table_border = get_option( 'addify_wsp_enable_table_border');  
			} else {
				$this->addify_wsp_enable_table_border = '';
			}

			if (!empty(get_option('addify_wsp_table_border_color'))) {
				$this->addify_wsp_table_border_color = get_option( 'addify_wsp_table_border_color');  
			} else {
				$this->addify_wsp_table_border_color = '';
			}

			if (!empty(get_option('addify_wsp_table_header_font_size'))) {
				$this->addify_wsp_table_header_font_size = get_option( 'addify_wsp_table_header_font_size');    
			} else {
				$this->addify_wsp_table_header_font_size = '';
			}

			if (!empty(get_option('addify_wsp_table_rows_font_size'))) {
				$this->addify_wsp_table_rows_font_size = get_option( 'addify_wsp_table_rows_font_size');    
			} else {
				$this->addify_wsp_table_rows_font_size = '';
			}

			//list design
			if (!empty(get_option('addify_wsp_list_border_color'))) {
				$this->addify_wsp_list_border_color = get_option( 'addify_wsp_list_border_color');  
			} else {
				$this->addify_wsp_list_border_color = '';
			}

			if (!empty(get_option('addify_wsp_list_background_color'))) {
				$this->addify_wsp_list_background_color = get_option( 'addify_wsp_list_background_color');  
			} else {
				$this->addify_wsp_list_background_color = '';
			}

			if (!empty(get_option('addify_wsp_list_text_color'))) {
				$this->addify_wsp_list_text_color = get_option( 'addify_wsp_list_text_color');  
			} else {
				$this->addify_wsp_list_text_color = '';
			}

			if (!empty(get_option('addify_wsp_selected_list_background_color'))) {
				$this->addify_wsp_selected_list_background_color = get_option( 'addify_wsp_selected_list_background_color');  
			} else {
				$this->addify_wsp_selected_list_background_color = '';
			}

			if (!empty(get_option('addify_wsp_selected_list_text_color'))) {
				$this->addify_wsp_selected_list_text_color = get_option( 'addify_wsp_selected_list_text_color');  
			} else {
				$this->addify_wsp_selected_list_text_color = '';
			}

			//card design

			if (!empty(get_option('addify_wsp_card_border_color'))) {
				$this->addify_wsp_card_border_color = get_option( 'addify_wsp_card_border_color');  
			} else {
				$this->addify_wsp_card_border_color = '';
			}

			if (!empty(get_option('addify_wsp_card_background_color'))) {
				$this->addify_wsp_card_background_color = get_option( 'addify_wsp_card_background_color');  
			} else {
				$this->addify_wsp_card_background_color = '';
			}

			if (!empty(get_option('addify_wsp_card_text_color'))) {
				$this->addify_wsp_card_text_color = get_option( 'addify_wsp_card_text_color');  
			} else {
				$this->addify_wsp_card_text_color = '';
			}

			if (!empty(get_option('addify_wsp_selected_card_border_color'))) {
				$this->addify_wsp_selected_card_border_color = get_option( 'addify_wsp_selected_card_border_color');  
			} else {
				$this->addify_wsp_selected_card_border_color = '';
			}
			
			if (!empty(get_option('addify_wsp_enable_card_sale_tag'))) {
				$this->addify_wsp_enable_card_sale_tag = get_option( 'addify_wsp_enable_card_sale_tag');  
			} else {
				$this->addify_wsp_enable_card_sale_tag = '';
			}

			if (!empty(get_option('addify_wsp_sale_tag_background_color'))) {
				$this->addify_wsp_sale_tag_background_color = get_option( 'addify_wsp_sale_tag_background_color');  
			} else {
				$this->addify_wsp_sale_tag_background_color = '';
			}

			if (!empty(get_option('addify_wsp_sale_tag_text_color'))) {
				$this->addify_wsp_sale_tag_text_color = get_option( 'addify_wsp_sale_tag_text_color');  
			} else {
				$this->addify_wsp_sale_tag_text_color = '';
			}


			if (!empty(get_option('addify_wsp_discount_price'))) {
				$this->addify_wsp_discount_price = get_option( 'addify_wsp_discount_price');    
			} else {
				$this->addify_wsp_discount_price = '';
			}

			//Hide price and add to cart options
			if (!empty(get_option('wsp_enable_hide_pirce'))) {
				$this->wsp_enable_hide_price_feature = get_option( 'wsp_enable_hide_pirce');    
			} else {
				$this->wsp_enable_hide_price_feature = '';
			}

			if (!empty(get_option('wsp_enable_hide_pirce_guest'))) {
				$this->wsp_enable_for_guest = get_option( 'wsp_enable_hide_pirce_guest');   
			} else {
				$this->wsp_enable_for_guest = '';
			}

			if (!empty(get_option('wsp_enable_hide_pirce_registered'))) {
				$this->wsp_enable_hide_pirce_registered = get_option( 'wsp_enable_hide_pirce_registered');  
			} else {
				$this->wsp_enable_hide_pirce_registered = '';
			}

			if (!empty(get_option('wsp_hide_price'))) {
				$this->wsp_enable_hide_price = get_option( 'wsp_hide_price');   
			} else {
				$this->wsp_enable_hide_price = '';
			}

			//Hide add to cart
			if (!empty(get_option('wsp_hide_cart_button'))) {
				$this->wsp_hide_cart_button = get_option( 'wsp_hide_cart_button');  
			} else {
				$this->wsp_hide_cart_button = '';
			}

			if (!empty(get_option('wsp_cart_button_link'))) {
				$this->wsp_cart_button_link = get_option( 'wsp_cart_button_link');  
			} else {
				$this->wsp_cart_button_link = '';
			}

			

			if (!empty(get_option('wsp_hide_user_role'))) {
				$this->wsp_hide_user_role = unserialize(get_option( 'wsp_hide_user_role')); 
			} else {
				$this->wsp_hide_user_role = '';
			}

			if (!empty(get_option('wsp_hide_products'))) {
				$this->wsp_hide_products = unserialize(get_option( 'wsp_hide_products'));   
			} else {
				$this->wsp_hide_products = '';
			}

			if (!empty(get_option('wsp_hide_categories'))) {
				$this->wsp_hide_categories = unserialize(get_option( 'wsp_hide_categories'));   
			} else {
				$this->wsp_hide_categories = '';
			}

			


			$this->allfetchedrules = $this->wsp_wholesale_rules();
			add_action( 'wp_enqueue_scripts', array( $this, 'wsp_front_scripts' ) );

			add_action('wp_head', array( $this, 'wsp_load_pricing_template_styles' ));

			//Showing tiered pricing table.
			//now this pricing check is handled through js
			// if ('yes' == $this->addify_wsp_enable_table) {
			// add_action( 'woocommerce_single_product_summary', array( $this, 'af_show_tiered_pricing_table' ), 20 );
			add_action( 'woocommerce_before_add_to_cart_form', array( $this, 'af_show_tiered_pricing_table' ) );

			add_filter( 'woocommerce_available_variation', array( $this, 'af_show_tiered_pricing_table_variation' ), 10, 3 );
			// }

			// Chagen Price HTML
			add_filter( 'woocommerce_get_price_html', array( $this, 'af_wsp_custom_price_html' ), 100, 2 );

			// Variable Products price range
			// add_filter( 'woocommerce_product_variation_get_regular_price', array( $this, 'af_wsp_custom_range_price' ), 99, 2 );
			add_filter( 'woocommerce_product_variation_get_price', array( $this, 'af_wsp_custom_range_price' ), 99, 2 );
			add_filter( 'woocommerce_product_variation_get_sale_price', array( $this, 'af_wsp_custom_range_price' ), 99, 2 );


			add_action( 'woocommerce_before_calculate_totals', array( $this, 'af_wsp_recalculate_price' ), 99, 1 );
			add_filter( 'woocommerce_cart_item_price', array( $this, 'af_wsp_woocommerce_cart_item_price_filter' ), 10, 3 );

			if (!empty($this->addify_wsp_enfore_min_max_qty) && 'yes' == $this->addify_wsp_enfore_min_max_qty) {
				// Min and Max Qty validation
				add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'wsp_validate_min_max_qty' ), 10, 4 );

				// Update Cart validation
				add_filter( 'woocommerce_update_cart_validation', array( $this, 'wsp_update_cart_quantity_validation' ), 10, 4 );

				add_filter( 'woocommerce_store_api_product_quantity_minimum', array( $this, 'wsp_update_cart_quantity_validation_block_minimum' ), 10, 3 );
				add_filter( 'woocommerce_store_api_product_quantity_maximum', array( $this, 'wsp_update_cart_quantity_validation_block_maximum' ), 10, 3 );
			}

			// Hide add to cart shop page.
			add_filter( 'woocommerce_loop_add_to_cart_link', array( $this, 'wsp_replace_loop_add_to_cart_link' ), 10, 2 );

			// Hide button cross sell on block cart.
			add_filter('woocommerce_is_purchasable', array( $this, 'wsp_product_cart_page_block' ), 10, 2);

			// Hide add to cart on product page.
			add_action( 'woocommerce_single_product_summary', array( $this, 'wsp_hide_add_cart_product_page' ), 1, 0 );
		}

		public function wsp_front_scripts() {

			wp_enqueue_style( 'addify_wsp_front_css', plugins_url( '/assets/css/addify_wsp_front_css.css', __FILE__ ), false, '1.0' );
			wp_enqueue_script( 'af_wsp_front_js', plugins_url( '/assets/js/addify_wsp_front_js.js', __FILE__ ), array( 'jquery' ), '1.0' );
			wp_enqueue_script('wc-add-to-cart');

			$user         = wp_get_current_user();
			$role         = ( array ) $user->roles;
			$current_role = !empty(current( $user->roles )) ? current( $user->roles ) : 'guest';

			$wps_price_role = get_option('addify_wsp_discount_price');


			$afwsp_data = array(
				'admin_url'                          => admin_url( 'admin-ajax.php' ),
				'nonce'                              => wp_create_nonce( 'afwsp-ajax-nonce' ),
				'af_wsp_show_pricing_template'       => $this->addify_wsp_enable_table,
				'addify_wsp_pricing_design_type'     => $this->addify_wsp_pricing_design_type,
				'addify_wsp_enable_template_heading' => $this->addify_wsp_enable_template_heading,
				'addify_wsp_enable_template_icon'    => $this->addify_wsp_enable_template_icon,
				'af_wps_price_type'                  =>  $wps_price_role[ $current_role ],
				'cart_hash_key'                      => WC()->ajax_url() . '-wc_cart_hash',
				'active_theme'                       => get_template(),



			);
			wp_localize_script( 'af_wsp_front_js', 'afwsp_php_vars', $afwsp_data );
		}

		public function wsp_load_pricing_template_styles() {
			if (!empty($this->addify_wsp_pricing_design_type)) {

				$this->af_wsp_display_selected_template($this->addify_wsp_pricing_design_type);

			}

			if (!empty($this->addify_wsp_template_font_family)) {

				$this->af_wsp_template_font_family($this->addify_wsp_template_font_family);

			}

			if ('yes' == $this->addify_wsp_enable_table_border) {

				$this->af_wsp_table_border($this->addify_wsp_table_border_color);

			}

			if (!empty($this->addify_wsp_table_odd_rows_color)) {

				$this->af_wsp_odd_row_color($this->addify_wsp_table_odd_rows_color);

			}

			if (!empty($this->addify_wsp_table_odd_rows_text_color)) {

				$this->af_wsp_odd_row_text_color($this->addify_wsp_table_odd_rows_text_color);

			}



			if (!empty($this->addify_wsp_table_even_rows_color)) {

				$this->af_wsp_even_row_color($this->addify_wsp_table_even_rows_color);

			}

			if (!empty($this->addify_wsp_table_even_rows_text_color)) {

				$this->af_wsp_even_row_text_color($this->addify_wsp_table_even_rows_text_color);

			}

			if (!empty($this->addify_wsp_table_rows_font_size)) {

				$this->af_wsp_table_row_font_size($this->addify_wsp_table_rows_font_size);

			}
			
			
			if (!empty($this->addify_wsp_list_border_color)) {

				$this->af_wsp_list_border_color($this->addify_wsp_list_border_color);

			}

			if (!empty($this->addify_wsp_list_background_color)) {

				$this->af_wsp_list_background_color($this->addify_wsp_list_background_color);

			}

			if (!empty($this->addify_wsp_list_text_color)) {

				$this->af_wsp_list_text_color($this->addify_wsp_list_text_color);

			}

			if (!empty($this->addify_wsp_selected_list_background_color)) {

				$this->af_wsp_selected_list_background_color($this->addify_wsp_selected_list_background_color);

			}

			if (!empty($this->addify_wsp_selected_list_text_color)) {

				$this->af_wsp_selected_list_text_color($this->addify_wsp_selected_list_text_color);

			}



			if (!empty($this->addify_wsp_card_border_color)) {

				$this->af_wsp_card_border_color($this->addify_wsp_card_border_color);

			}
			if (!empty($this->addify_wsp_card_text_color)) {

				$this->af_wsp_card_text_color($this->addify_wsp_card_text_color);

			}
			if (!empty($this->addify_wsp_card_background_color)) {

				$this->af_wsp_card_backgrorund_color($this->addify_wsp_card_background_color);

			}
			

			if (!empty($this->addify_wsp_selected_card_border_color)) {

				$this->af_wsp_card_selected_border_color($this->addify_wsp_selected_card_border_color);

			}
			
			
			
			if ( 'yes'!=  $this->addify_wsp_enable_card_sale_tag ) {

				$this->af_wsp_enable_sale_tag();

			}

			if (!empty($this->addify_wsp_sale_tag_background_color)) {

				$this->af_wsp_sale_tag_background_color($this->addify_wsp_sale_tag_background_color);

			}

			if (!empty($this->addify_wsp_sale_tag_text_color)) {

				$this->af_wsp_sale_tag_text_color($this->addify_wsp_sale_tag_text_color);

			}
		}

		public function wsp_wholesale_rules() {

			// get Rules
			$args = array(
				'post_type'        => 'af_wholesale_price',
				'post_status'      => 'publish',
				'orderby'          => 'menu_order',
				'order'            => 'ASC',
				'numberposts'      => -1,
				'suppress_filters' => false,
			);

			return get_posts( $args );
		}


		public function af_show_tiered_pricing_table() {


			global $product;
			
			$user                         = wp_get_current_user();
			$role                         = ( array ) $user->roles;
			$current_role                 = current( $user->roles );
			$customer_discount            = false;
			$role_discount                = false;
			$customer_discount1           = false;
			$role_discount1               = false;
			$role_guest_discount          = false;
			$table_data                   = '';
			$raw_data_for_template_design = array();

			//Hide price and add to cart
			if ( ! empty( $this->wsp_enable_hide_price_feature ) && 'yes' == $this->wsp_enable_hide_price_feature && 'yes' == $this->wsp_enable_hide_price ) {


				// For Guest Users
				if ( ! empty( $this->wsp_enable_for_guest ) && 'yes' == $this->wsp_enable_for_guest ) {

					if ( ! is_user_logged_in() ) {

						if ( ! empty( $this->wsp_hide_products ) ) {

							if ( in_array( $product->get_id(), (array) $this->wsp_hide_products ) ) {

								if ( ! empty( $this->wsp_enable_hide_price ) && 'yes' == $this->wsp_enable_hide_price ) {
									return;
								}
								
							}
						}

						if ( ! empty( $this->wsp_hide_categories ) && ! empty( $this->wsp_enable_hide_price ) && 'yes' == $this->wsp_enable_hide_price ) {
							foreach ( $this->wsp_hide_categories as $cat ) {
								if ( has_term( $cat, 'product_cat', $product->get_id() ) ) {
								
									return;
								}
							}
						}
					}
				}

				// For Registered Users
				if ( ! empty( $this->wsp_enable_hide_pirce_registered ) && 'yes' == $this->wsp_enable_hide_pirce_registered ) {

					if ( is_user_logged_in() ) {

						// get Current User Role
						$curr_user      = wp_get_current_user();
						$user_data      = get_user_meta( $curr_user->ID );
						$curr_user_role = $curr_user->roles[0];


						if ( !empty($this->wsp_hide_user_role) && in_array( $curr_user_role, $this->wsp_hide_user_role ) ) {

							if ( in_array( $product->get_id(), (array) $this->wsp_hide_products ) ) {

								if ( ! empty( $this->wsp_enable_hide_price ) && 'yes' == $this->wsp_enable_hide_price ) {

									return;
								}
							} 
							if ( ! empty( $this->wsp_hide_categories ) && ! empty( $this->wsp_enable_hide_price ) && 'yes' == $this->wsp_enable_hide_price ) {

								foreach ( $this->wsp_hide_categories as $cat ) {
									if ( has_term( $cat, 'product_cat', $product->get_id() ) ) {
										return;
									}
								}
							}
						}
					}
				}


			} //End Hide Price


		

			//Products other than variable product
			// get customer specifc price
			$cus_base_wsp_price = get_post_meta( $product->get_id(), '_cus_base_wsp_price', true );

			// get role base price
			$role_base_wsp_price = get_post_meta( $product->get_id(), '_role_base_wsp_price', true );


			
		
			if ( 'variable' != $product->get_type() ) {

				$get_type_of_price = 'excl' == $this->get_tax_price_display_mode() ? 'wc_get_price_excluding_tax' : 'wc_get_price_including_tax'  ; 

				$product_old_price = $get_type_of_price( $product, array(
					'qty'   => 1,
					'price' => $product->get_price(),
				) );

				$pro_price = get_post_meta( $product->get_id(), '_price', true );
			
				if ( is_user_logged_in() ) {

									
					if ( !empty( $this->addify_wsp_discount_price[ $current_role ] ) ) {

						if ($this->addify_wsp_discount_price[ $current_role ] && 'sale' == $this->addify_wsp_discount_price[ $current_role ] && !empty(get_post_meta( $product->get_id(), '_sale_price', true ))) {

							$pro_price = get_post_meta( $product->get_id(), '_sale_price', true );
						
							$product_old_price = $get_type_of_price( $product, array(
								'qty'   => 1,
								'price' => $product->get_sale_price(),
							) );

						} elseif ('regular' == $this->addify_wsp_discount_price[ $current_role ] && !empty(get_post_meta( $product->get_id(), '_regular_price', true ))) {

							$pro_price = get_post_meta( $product->get_id(), '_regular_price', true );
						
							$product_old_price = $get_type_of_price( $product, array(
								'qty'   => 1,
								'price' => $product->get_regular_price(),
							) );

						}
					}

				$pro_price = '' != $pro_price ?$pro_price :0;



					if ( ! empty( $cus_base_wsp_price )  ) {


						foreach ( $cus_base_wsp_price as $cus_price ) {

							if ( isset( $cus_price['customer_name'] ) && $user->ID == $cus_price['customer_name'] ) {

								if ( '' != $cus_price['discount_value'] || 0 != $cus_price['discount_value'] ) {

									//Fixed Price
									if ( 'fixed_price' == $cus_price['discount_type'] ) {

										$newprice = $get_type_of_price( $product, array(
											'qty'   => 1,
											'price' => $cus_price['discount_value'],
										) );
										
										$replace_price = isset($cus_price['replace_orignal_price'])?$cus_price['replace_orignal_price']:'no';

										if ($pro_price <= $newprice ) {
											$replace_price = 'yes';
										}

										$table_data                    .= '<tr><td data-replace="' . $replace_price . '" id="' . $cus_price['min_qty'] . '">' . $cus_price['min_qty'] . '</td><td>' . $cus_price['max_qty'] . '</td><td>' . wc_price($newprice) . '</td><td>' . ( ( $product_old_price - $newprice ) > 0 ? wc_price($product_old_price - $newprice) : wc_price(0) ) . '</td></tr>';
										$raw_data_for_template_design[] = array(
											'min_qty'      => $cus_price['min_qty'],
											'max_qty'      => $cus_price['max_qty'],
											'discounted_price' => $newprice,
											'saved_amount' => $product_old_price - $newprice,
										);
										$customer_discount              = true;
										
									} elseif ( 'fixed_increase' == $cus_price['discount_type'] ) {

										$newprice = $pro_price + $cus_price['discount_value'];

										$newprice1 = $get_type_of_price( $product, array(
											'qty'   => 1,
											'price' => $newprice,
										) ); 

										$replace_price = isset($cus_price['replace_orignal_price'])?$cus_price['replace_orignal_price']:'no';

										if ($pro_price <= $newprice ) {
											$replace_price = 'yes';
										}

										$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $cus_price['min_qty'] . '</td><td>' . $cus_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
										$raw_data_for_template_design[] = array(
											'min_qty'      => $cus_price['min_qty'],
											'max_qty'      => $cus_price['max_qty'],
											'discounted_price' => $newprice1,
											'saved_amount' => $product_old_price - $newprice1,
										);
										$customer_discount              = true;

													


									} elseif ( 'fixed_decrease' == $cus_price['discount_type'] ) {

										$newprice = $pro_price - $cus_price['discount_value'];

										$newprice1 = $get_type_of_price( $product, array(
											'qty'   => 1,
											'price' => $newprice,
										) ); 
										
										$replace_price = isset($cus_price['replace_orignal_price'])?$cus_price['replace_orignal_price']:'no';

										$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $cus_price['min_qty'] . '</td><td>' . $cus_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
										$raw_data_for_template_design[] = array(
											'min_qty'      => $cus_price['min_qty'],
											'max_qty'      => $cus_price['max_qty'],
											'discounted_price' => $newprice1,
											'saved_amount' => $product_old_price - $newprice1,
										);
										$customer_discount              = true;

													


									} elseif ( 'percentage_decrease' == $cus_price['discount_type'] ) {

										$percent_price = $pro_price * $cus_price['discount_value'] / 100;

										$newprice = $pro_price - $percent_price;

										$newprice1 = $get_type_of_price( $product, array(
											'qty'   => 1,
											'price' => $newprice,
										) ); 

										$replace_price                  = isset($cus_price['replace_orignal_price'])?$cus_price['replace_orignal_price']:'no';
										$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $cus_price['min_qty'] . '</td><td>' . $cus_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
										$raw_data_for_template_design[] = array(
											'min_qty'      => $cus_price['min_qty'],
											'max_qty'      => $cus_price['max_qty'],
											'discounted_price' => $newprice1,
											'saved_amount' => $product_old_price - $newprice1,
										);
										$customer_discount              = true;

													



									} elseif ( 'percentage_increase' == $cus_price['discount_type'] ) {

										$percent_price = $pro_price * $cus_price['discount_value'] / 100;

										$newprice = $pro_price + $percent_price;

										$newprice1 = $get_type_of_price( $product, array(
											'qty'   => 1,
											'price' => $newprice,
										) ); 

										$replace_price = isset($cus_price['replace_orignal_price'])?$cus_price['replace_orignal_price']:'no';
										if ($pro_price <= $newprice ) {
											$replace_price = 'yes';
										}

										$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $cus_price['min_qty'] . '</td><td>' . $cus_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
										$raw_data_for_template_design[] = array(
											'min_qty'      => $cus_price['min_qty'],
											'max_qty'      => $cus_price['max_qty'],
											'discounted_price' => $newprice1,
											'saved_amount' => $product_old_price - $newprice1,
										);
										$customer_discount              = true;

													


									}
												


								}
							}
						}
					} //End Customer Base

					//User Role Base Pricing
					//chcek if there is customer base pricing then User role base pricing will not work.

					if ( ! $customer_discount ) {


						if ( ! empty( $role_base_wsp_price )  ) {

							

							foreach ( $role_base_wsp_price as $role_price ) {

								if ( isset( $role_price['user_role'] ) && ( 'everyone' == $role_price['user_role'] || $role[0] == $role_price['user_role'] )) {

									if ( '' != $role_price['discount_value'] || 0 != $role_price['discount_value'] ) {

										//Fixed Price
										if ( 'fixed_price' == $role_price['discount_type'] ) {

										
											$newprice      = $get_type_of_price( $product, array(
												'qty'   => 1,
												'price' => $role_price['discount_value'],
											) );
											$replace_price = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
											if ($pro_price <= $newprice ) {
												$replace_price = 'yes';
											}
											$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice) . '</td><td>' . ( ( $product_old_price - $newprice ) > 0 ? wc_price($product_old_price - $newprice) : wc_price(0) ) . '</td></tr>';
											$raw_data_for_template_design[] = array(
												'min_qty' => $role_price['min_qty'],
												'max_qty' => $role_price['max_qty'],
												'discounted_price' => $newprice,
												'saved_amount' => $product_old_price - $newprice,
											);

											$role_discount = true;

														
										} elseif ( 'fixed_increase' == $role_price['discount_type'] ) {

											$newprice = $pro_price + $role_price['discount_value'];

											$newprice1     = $get_type_of_price( $product, array(
												'qty'   => 1,
												'price' => $newprice,
											) ); 
											$replace_price = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
											if ($pro_price <= $newprice ) {
												$replace_price = 'yes';
											}    

											$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
											$raw_data_for_template_design[] = array(
												'min_qty' => $role_price['min_qty'],
												'max_qty' => $role_price['max_qty'],
												'discounted_price' => $newprice1,
												'saved_amount' => $product_old_price - $newprice1,
											);
											$role_discount                  = true;

														


										} elseif ( 'fixed_decrease' == $role_price['discount_type'] ) {

											$newprice = $pro_price - $role_price['discount_value'];

											$newprice1                      = $get_type_of_price( $product, array(
												'qty'   => 1,
												'price' => $newprice,
											) ); 
											$replace_price                  = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
											$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
											$raw_data_for_template_design[] = array(
												'min_qty' => $role_price['min_qty'],
												'max_qty' => $role_price['max_qty'],
												'discounted_price' => $newprice1,
												'saved_amount' => $product_old_price - $newprice1,
											);
											$role_discount                  = true;

													


										} elseif ( 'percentage_decrease' == $role_price['discount_type'] ) {

											$percent_price = $pro_price * $role_price['discount_value'] / 100;

											$newprice = $pro_price - $percent_price;

											$newprice1                      = $get_type_of_price( $product, array(
												'qty'   => 1,
												'price' => $newprice,
											) ); 
											$replace_price                  = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
											$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
											$raw_data_for_template_design[] = array(
												'min_qty' => $role_price['min_qty'],
												'max_qty' => $role_price['max_qty'],
												'discounted_price' => $newprice1,
												'saved_amount' => $product_old_price - $newprice1,
											);
											$role_discount                  = true;

														



										} elseif ( 'percentage_increase' == $role_price['discount_type'] ) {

											$percent_price = $pro_price * $role_price['discount_value'] / 100;

											$newprice = $pro_price + $percent_price;

											$newprice1 = $get_type_of_price( $product, array(
												'qty'   => 1,
												'price' => $newprice,
											) ); 

											$replace_price = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
											if ($pro_price <= $newprice ) {
												$replace_price = 'yes';
											}
											$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
											$raw_data_for_template_design[] = array(
												'min_qty' => $role_price['min_qty'],
												'max_qty' => $role_price['max_qty'],
												'discounted_price' => $newprice1,
												'saved_amount' => $product_old_price - $newprice1,
											);
											$role_discount                  = true;

														


										}


									}
								}

							}

						}
					}
					//End Product Level Pricing

					//Start Global Rules
					if ( false == $customer_discount && false == $role_discount ) {

						if ( empty( $this->allfetchedrules ) ) {

							echo '';

						} else {

							$all_rules = $this->allfetchedrules;

						}

						if ( ! empty( $all_rules ) ) {

							foreach ( $all_rules as $rule ) {

								$istrue = false;
								

								$applied_on_all_products = get_post_meta($rule->ID, 'wsp_apply_on_all_products', true);
								$products                = get_post_meta($rule->ID, 'wsp_applied_on_products', true);
								$categories              = get_post_meta($rule->ID, 'wsp_applied_on_categories', true);

								if ('yes' == $applied_on_all_products ) {
									$istrue = true;
								} elseif (! empty($products) && ( in_array($product->get_id(), $products) || in_array($product->get_parent_id(), $products) ) ) {
									$istrue = true;
								}

											
								if (!empty($categories)) {
									foreach ( $categories as $cat ) {

										if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $product->get_id() ) ) || ( has_term( $cat, 'product_cat', $product->get_parent_id() ) ) )) {
											$istrue = true;
										} 
									}
								}
									

								if ( $istrue ) {

									// get rule customer base price
									$rule_cus_base_wsp_price = get_post_meta( $rule->ID, 'rcus_base_wsp_price', true );

									// get rule role base price
									$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

									if ( ! empty( $rule_cus_base_wsp_price )  ) {

										

										foreach ( $rule_cus_base_wsp_price as $rule_cus_price ) {

											if ( $user->ID == $rule_cus_price['customer_name'] ) {

												if ( '' != $rule_cus_price['discount_value'] || 0 != $rule_cus_price['discount_value'] ) {


													//Fixed Price
													if ( 'fixed_price' == $rule_cus_price['discount_type'] ) {

														$newprice = $get_type_of_price( $product, array(
															'qty'   => 1,
															'price' => $rule_cus_price['discount_value'],
														) );
										
														$replace_price = isset($rule_cus_price['replace_orignal_price'])?$rule_cus_price['replace_orignal_price']:'no';
														if ($pro_price <= $newprice ) {
															$replace_price = 'yes';
														}
														$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $rule_cus_price['min_qty'] . '</td><td>' . $rule_cus_price['max_qty'] . '</td><td>' . wc_price($newprice) . '</td><td>' . ( ( $product_old_price - $newprice ) > 0 ? wc_price($product_old_price - $newprice) : wc_price(0) ) . '</td></tr>';
														$raw_data_for_template_design[] = array(
															'min_qty'           => $rule_cus_price['min_qty'],
															'max_qty'           => $rule_cus_price['max_qty'],
															'discounted_price'  => $newprice,
															'saved_amount'      => $product_old_price - $newprice,
														);
														$customer_discount1             = true;

																	
													} elseif ( 'fixed_increase' == $rule_cus_price['discount_type'] ) {

														$newprice = $pro_price + $rule_cus_price['discount_value'];

														$newprice1 = $get_type_of_price( $product, array(
															'qty'   => 1,
															'price' => $newprice,
														) );

														$replace_price = isset($rule_cus_price['replace_orignal_price'])?$rule_cus_price['replace_orignal_price']:'no';
														if ($pro_price <= $newprice ) {
																$replace_price = 'yes';
														}
														$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $rule_cus_price['min_qty'] . '</td><td>' . $rule_cus_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
														$raw_data_for_template_design[] = array(
															'min_qty'           => $rule_cus_price['min_qty'],
															'max_qty'           => $rule_cus_price['max_qty'],
															'discounted_price'  => $newprice1,
															'saved_amount'      => $product_old_price - $newprice1,
														);
														$customer_discount1             = true;

																	


													} elseif ( 'fixed_decrease' == $rule_cus_price['discount_type'] ) {

														$newprice = $pro_price - $rule_cus_price['discount_value'];

														$newprice1 = $get_type_of_price( $product, array(
															'qty'   => 1,
															'price' => $newprice,
														) );

														$replace_price                  = isset($rule_cus_price['replace_orignal_price'])?$rule_cus_price['replace_orignal_price']:'no';
														$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $rule_cus_price['min_qty'] . '</td><td>' . $rule_cus_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
														$raw_data_for_template_design[] = array(
															'min_qty'           => $rule_cus_price['min_qty'],
															'max_qty'           => $rule_cus_price['max_qty'],
															'discounted_price'  => $newprice1,
															'saved_amount'      => $product_old_price - $newprice1,
														);
														$customer_discount1             = true;

																	


													} elseif ( 'percentage_decrease' == $rule_cus_price['discount_type'] ) {

														$percent_price = $pro_price * $rule_cus_price['discount_value'] / 100;

														$newprice = $pro_price - $percent_price;

														$newprice1 = $get_type_of_price( $product, array(
															'qty'   => 1,
															'price' => $newprice,
														) );

														$replace_price                  = isset($rule_cus_price['replace_orignal_price'])?$rule_cus_price['replace_orignal_price']:'no';
														$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $rule_cus_price['min_qty'] . '</td><td>' . $rule_cus_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
														$raw_data_for_template_design[] = array(
															'min_qty'           => $rule_cus_price['min_qty'],
															'max_qty'           => $rule_cus_price['max_qty'],
															'discounted_price'  => $newprice1,
															'saved_amount'      => $product_old_price - $newprice1,
														);
														$customer_discount1             = true;

					

													} elseif ( 'percentage_increase' == $rule_cus_price['discount_type'] ) {

														$percent_price = $pro_price * $rule_cus_price['discount_value'] / 100;

														$newprice = $pro_price + $percent_price;

														$newprice1 = $get_type_of_price( $product, array(
															'qty'   => 1,
															'price' => $newprice,
														) );

														$replace_price = isset($rule_cus_price['replace_orignal_price'])?$rule_cus_price['replace_orignal_price']:'no';
														if ($pro_price <= $newprice ) {
																$replace_price = 'yes';
														}
														$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $rule_cus_price['min_qty'] . '</td><td>' . $rule_cus_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
														$raw_data_for_template_design[] = array(
															'min_qty'           => $rule_cus_price['min_qty'],
															'max_qty'           => $rule_cus_price['max_qty'],
															'discounted_price'  => $newprice1,
															'saved_amount'      => $product_old_price - $newprice1,
														);
														$customer_discount1             = true;

																	


													}


												}
											}

										}

									} //End rule customer base pricing.

									//Start rule role base pricing.
									//check if there is rule customer base pricing then rule role base pricing will not work.

									if ( ! $customer_discount1 ) {

										if ( ! empty( $rule_role_base_wsp_price ) ) {
											

											foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

												if ( 'everyone' == $rule_role_price['user_role'] || $role[0] == $rule_role_price['user_role'] ) { 
													
													if ( '' != $rule_role_price['discount_value'] || 0 != $rule_role_price['discount_value'] ) {


														//Fixed Price
														if ( 'fixed_price' == $rule_role_price['discount_type'] ) {

															$newprice = $get_type_of_price( $product, array(
																'qty'   => 1,
																'price' => $rule_role_price['discount_value'],
															) );

															$replace_price = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';
															if ($pro_price <= $newprice ) {
																$replace_price = 'yes';
															}   
															$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice) . '</td><td>' . ( ( $product_old_price - $newprice ) > 0 ? wc_price($product_old_price - $newprice) : wc_price(0) ) . '</td></tr>';
															$raw_data_for_template_design[] = array(
																'min_qty'           => $rule_role_price['min_qty'],
																'max_qty'           => $rule_role_price['max_qty'],
																'discounted_price'  => $newprice,
																'saved_amount'      => $product_old_price - $newprice,
															);
															$role_discount1                 = true;
																		
														} elseif ( 'fixed_increase' == $rule_role_price['discount_type'] ) {

															$newprice = $pro_price + $rule_role_price['discount_value'];

															$newprice1 = $get_type_of_price( $product, array(
																'qty'   => 1,
																'price' => $newprice,
															) );

															$replace_price = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';

															if ($pro_price <= $newprice ) {
																$replace_price = 'yes';
															}

															$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
															$raw_data_for_template_design[] = array(
																'min_qty'           => $rule_role_price['min_qty'],
																'max_qty'           => $rule_role_price['max_qty'],
																'discounted_price'  => $newprice1,
																'saved_amount'      => $product_old_price - $newprice1,
															);
															$role_discount1                 = true;
																		


														} elseif ( 'fixed_decrease' == $rule_role_price['discount_type'] ) {

															$newprice = $pro_price - $rule_role_price['discount_value'];

															$newprice1 = $get_type_of_price( $product, array(
																'qty'   => 1,
																'price' => $newprice,
															) );

															$replace_price = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';

															$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
															$raw_data_for_template_design[] = array(
																'min_qty'           => $rule_role_price['min_qty'],
																'max_qty'           => $rule_role_price['max_qty'],
																'discounted_price'  => $newprice1,
																'saved_amount'      => $product_old_price - $newprice1,
															);
															$role_discount1                 = true;
																	


														} elseif ( 'percentage_decrease' == $rule_role_price['discount_type'] ) {

															$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

															$newprice = $pro_price - $percent_price;

															$newprice1 = $get_type_of_price( $product, array(
																'qty'   => 1,
																'price' => $newprice,
															) );

															$replace_price                  = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';
															$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
															$raw_data_for_template_design[] = array(
																'min_qty'           => $rule_role_price['min_qty'],
																'max_qty'           => $rule_role_price['max_qty'],
																'discounted_price'  => $newprice1,
																'saved_amount'      => $product_old_price - $newprice1,
															);
															$role_discount1                 = true;
																		



														} elseif ( 'percentage_increase' == $rule_role_price['discount_type'] ) {

															$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

															$newprice = $pro_price + $percent_price;

															$newprice1 = $get_type_of_price( $product, array(
																'qty'   => 1,
																'price' => $newprice,
															) );


															$replace_price = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';

															if ($pro_price <= $newprice ) {
																$replace_price = 'yes';
															}
															$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
															$raw_data_for_template_design[] = array(
																'min_qty'           => $rule_role_price['min_qty'],
																'max_qty'           => $rule_role_price['max_qty'],
																'discounted_price'  => $newprice1,
																'saved_amount'      => $product_old_price - $newprice1,
															);
															$role_discount1                 = true;         


														}


													}
												}

											}
										}
									}

								}


								if ($customer_discount1 || $role_discount1) {
									break;
								}
							}
						}


					}



				} elseif ( !is_user_logged_in() ) {

						//not loggedin users
					

					if ( isset( $this->addify_wsp_discount_price['guest'] ) ) {

						if ('sale' == $this->addify_wsp_discount_price['guest'] && !empty(get_post_meta( $product->get_id(), '_sale_price', true ))) {

							$pro_price = get_post_meta( $product->get_id(), '_sale_price', true );

							$product_old_price = $get_type_of_price( $product, array(
								'qty'   => 1,
								'price' => $product->get_sale_price(),
							) );

						} elseif ('regular' == $this->addify_wsp_discount_price['guest'] && !empty(get_post_meta( $product->get_id(), '_regular_price', true ))) {

							$pro_price = get_post_meta( $product->get_id(), '_regular_price', true );

							$product_old_price = $get_type_of_price( $product, array(
								'qty'   => 1,
								'price' => $product->get_regular_price(),
							) );

						}       
					} 

					$pro_price = '' != $pro_price ?$pro_price :0;

					// Role Based Pricing for guest
					if ( true ) {

						// get role base price for guest
						$role_base_wsp_price = get_post_meta( $product->get_id(), '_role_base_wsp_price', true );
						if ( ! empty( $role_base_wsp_price )  ) {

								

							foreach ( $role_base_wsp_price as $role_price ) {

								if ( isset( $role_price['user_role'] ) && ( 'everyone' == $role_price['user_role'] || 'guest' == $role_price['user_role'] )) {

									if ( '' != $role_price['discount_value'] || 0 != $role_price['discount_value'] ) {


										//Fixed Price
										if ( 'fixed_price' == $role_price['discount_type'] ) {

											$newprice = $get_type_of_price( $product, array(
												'qty'   => 1,
												'price' => $role_price['discount_value'],
											) );

											$replace_price = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
											if ($pro_price <= $newprice ) {
												$replace_price = 'yes';
											}
											$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice) . '</td><td>' . ( ( $product_old_price - $newprice ) > 0 ? wc_price($product_old_price - $newprice) : wc_price(0) ) . '</td></tr>';
											$raw_data_for_template_design[] = array(
												'min_qty' => $role_price['min_qty'],
												'max_qty' => $role_price['max_qty'],
												'discounted_price' => $newprice,
												'saved_amount' => $product_old_price - $newprice,
											);
											$role_discount                  = true;

															
										} elseif ( 'fixed_increase' == $role_price['discount_type'] ) {

											$newprice = $pro_price + $role_price['discount_value'];

											$newprice1 = $get_type_of_price( $product, array(
												'qty'   => 1,
												'price' => $newprice,
											) );

											$replace_price = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
											if ($pro_price <= $newprice ) {
												$replace_price = 'yes';
											}
											$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
											$raw_data_for_template_design[] = array(
												'min_qty' => $role_price['min_qty'],
												'max_qty' => $role_price['max_qty'],
												'discounted_price' => $newprice1,
												'saved_amount' => $product_old_price - $newprice1,
											);
											$role_discount                  = true;

															


										} elseif ( 'fixed_decrease' == $role_price['discount_type'] ) {

											$newprice = $pro_price - $role_price['discount_value'];

											$newprice1 = $get_type_of_price( $product, array(
												'qty'   => 1,
												'price' => $newprice,
											) );

											$replace_price                  = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
											$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
											$raw_data_for_template_design[] = array(
												'min_qty' => $role_price['min_qty'],
												'max_qty' => $role_price['max_qty'],
												'discounted_price' => $newprice1,
												'saved_amount' => $product_old_price - $newprice1,
											);
											$role_discount                  = true;

															


										} elseif ( 'percentage_decrease' == $role_price['discount_type'] ) {

											$percent_price = $pro_price * $role_price['discount_value'] / 100;

											$newprice = $pro_price - $percent_price;

											$newprice1 = $get_type_of_price( $product, array(
												'qty'   => 1,
												'price' => $newprice,
											) );

											$replace_price                  = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
											$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
											$raw_data_for_template_design[] = array(
												'min_qty' => $role_price['min_qty'],
												'max_qty' => $role_price['max_qty'],
												'discounted_price' => $newprice1,
												'saved_amount' => $product_old_price - $newprice1,
											);
											$role_discount                  = true;

															



										} elseif ( 'percentage_increase' == $role_price['discount_type'] ) {

											$percent_price = $pro_price * $role_price['discount_value'] / 100;

											$newprice = $pro_price + $percent_price;

											$newprice1 = $get_type_of_price( $product, array(
												'qty'   => 1,
												'price' => $newprice,
											) );


											$replace_price = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
											if ($pro_price <= $newprice ) {
												$replace_price = 'yes';
											}
											$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
											$raw_data_for_template_design[] = array(
												'min_qty' => $role_price['min_qty'],
												'max_qty' => $role_price['max_qty'],
												'discounted_price' => $newprice1,
												'saved_amount' => $product_old_price - $newprice1,
											);
											$role_discount                  = true;

															


										}

									}
								}
							}
						}



						//Rules - guest users
						if ( false == $role_discount  ) {


							if ( empty( $this->allfetchedrules ) ) {

								echo '';

							} else {

								$all_rules = $this->allfetchedrules;

							}

							if ( ! empty( $all_rules ) ) {

								foreach ( $all_rules as $rule ) {



									$istrue = false;
										

									$applied_on_all_products = get_post_meta($rule->ID, 'wsp_apply_on_all_products', true);
									$products                = get_post_meta($rule->ID, 'wsp_applied_on_products', true);
									$categories              = get_post_meta($rule->ID, 'wsp_applied_on_categories', true);

									if ('yes' == $applied_on_all_products ) {
										$istrue = true;
									} elseif (! empty($products) && ( in_array($product->get_id(), $products) || in_array($product->get_parent_id(), $products) ) ) {
										$istrue = true;
									}

													
									if (!empty($categories)) {
										foreach ( $categories as $cat ) {

											if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $product->get_id() ) ) || ( has_term( $cat, 'product_cat', $product->get_parent_id() ) ) ) ) {

												$istrue = true;
											} 
										}
									}

										

									if ( $istrue ) {


										//get rule role base price for guest
										$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

										if ( ! empty( $rule_role_base_wsp_price ) ) {

												

											foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

												if ('everyone' == $rule_role_price['user_role'] || 'guest' == $rule_role_price['user_role'] ) {

													if ( '' != $rule_role_price['discount_value'] || 0 != $rule_role_price['discount_value'] ) {


														//Fixed Price
														if ( 'fixed_price' == $rule_role_price['discount_type'] ) {
															$newprice = $get_type_of_price( $product, array(
																'qty'   => 1,
																'price' => $rule_role_price['discount_value'],
															) );
				
															$replace_price = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';
															if ($pro_price <= $newprice ) {
																$replace_price = 'yes';
															}
															$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice) . '</td><td>' . ( ( $product_old_price - $newprice ) > 0 ? wc_price($product_old_price - $newprice) : wc_price(0) ) . '</td></tr>';
															$raw_data_for_template_design[] = array(
																'min_qty'           => $rule_role_price['min_qty'],
																'max_qty'           => $rule_role_price['max_qty'],
																'discounted_price'  => $newprice,
																'saved_amount'      => $product_old_price - $newprice,
															);
															$role_guest_discount            = true;
																			
														} elseif ( 'fixed_increase' == $rule_role_price['discount_type'] ) {

															$newprice = $pro_price + $rule_role_price['discount_value'];

															$newprice1 = $get_type_of_price( $product, array(
																'qty'   => 1,
																'price' => $newprice,
															) );
				
															$replace_price = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';
															if ($pro_price <= $newprice ) {
																$replace_price = 'yes';
															}
															$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
															$raw_data_for_template_design[] = array(
																'min_qty'           => $rule_role_price['min_qty'],
																'max_qty'           => $rule_role_price['max_qty'],
																'discounted_price'  => $newprice1,
																'saved_amount'      => $product_old_price - $newprice1,
															);
															$role_guest_discount            = true;

														} elseif ( 'fixed_decrease' == $rule_role_price['discount_type'] ) {

															$newprice = $pro_price - $rule_role_price['discount_value'];

															$newprice1 = $get_type_of_price( $product, array(
																'qty'   => 1,
																'price' => $newprice,
															) );
				
															$replace_price                  = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';
															$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
															$raw_data_for_template_design[] = array(
																'min_qty'           => $rule_role_price['min_qty'],
																'max_qty'           => $rule_role_price['max_qty'],
																'discounted_price'  => $newprice1,
																'saved_amount'      => $product_old_price - $newprice1,
															);
															$role_guest_discount            = true;            

														} elseif ( 'percentage_decrease' == $rule_role_price['discount_type'] ) {

															$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

															$newprice = $pro_price - $percent_price;

															$newprice1 = $get_type_of_price( $product, array(
																'qty'   => 1,
																'price' => $newprice,
															) );
				
															$replace_price = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';
															$table_data   .= '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';

															$raw_data_for_template_design[] = array(
																'min_qty'           => $rule_role_price['min_qty'],
																'max_qty'           => $rule_role_price['max_qty'],
																'discounted_price'  => $newprice1,
																'saved_amount'      => $product_old_price - $newprice1,
															);
															
															$role_guest_discount = true;

														} elseif ( 'percentage_increase' == $rule_role_price['discount_type'] ) {

															$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

															$newprice = $pro_price + $percent_price;

															$newprice1 = $get_type_of_price( $product, array(
																'qty'   => 1,
																'price' => $newprice,
															) );

															
															$replace_price = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';
															if ($pro_price <= $newprice ) {
																$replace_price = 'yes';
															}
															$table_data                    .= '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
															$raw_data_for_template_design[] = array(
																'min_qty'           => $rule_role_price['min_qty'],
																'max_qty'           => $rule_role_price['max_qty'],
																'discounted_price'  => $newprice1,
																'saved_amount'      => $product_old_price - $newprice1,
															);
															$role_guest_discount            = true;                
														}



													}
												}
											}
										}
													

									}



									if ($role_guest_discount) {
										break;
									}

								}
							}



						}



					}
					
				}


						
			}


			if (!empty($table_data)) {
				$table_template = '<div class="responsive pricing_table"><table class="tab_bor"><thead>
								<tr>
									<th style="color:' . esc_attr($this->addify_wsp_table_header_text_color) . '; background-color:' . esc_attr($this->addify_wsp_table_header_color) . '; font-size: ' . esc_attr($this->addify_wsp_table_header_font_size) . 'px;">' . esc_html__('Min', 'addify_wholesale_prices') . '</th>
									<th style="color:' . esc_attr($this->addify_wsp_table_header_text_color) . '; background-color:' . esc_attr($this->addify_wsp_table_header_color) . '; font-size: ' . esc_attr($this->addify_wsp_table_header_font_size) . 'px;">' . esc_html__('Max', 'addify_wholesale_prices') . '</th>
									<th style="color:' . esc_attr($this->addify_wsp_table_header_text_color) . '; background-color:' . esc_attr($this->addify_wsp_table_header_color) . '; font-size: ' . esc_attr($this->addify_wsp_table_header_font_size) . 'px;">' . esc_html__('Price', 'addify_wholesale_prices') . '</th>
									<th style="color:' . esc_attr($this->addify_wsp_table_header_text_color) . '; background-color:' . esc_attr($this->addify_wsp_table_header_color) . '; font-size: ' . esc_attr($this->addify_wsp_table_header_font_size) . 'px;">' . esc_html__('Save', 'addify_wholesale_prices') . '</th>
								</tr>
							</thead><tbody>' . $table_data . '</tbody></table>
						</div>';
						

						$card_template_html = '';

				foreach ($raw_data_for_template_design as $index => $value) {
					$min_qty             = $value['min_qty'];
					$max_qty             = $value['max_qty'];
					$discounted_price    = $value['discounted_price'];
					$saved_amount        = $value['saved_amount'] > 0 ? $value['saved_amount']: 0;
					$original_price      = $discounted_price + $saved_amount;
					$discount_percentage = $original_price>0 ? round(( $saved_amount / $original_price ) * 100):0;

					$discount_text = $saved_amount > 0 ? '<del>' . wc_price($original_price) . '/each</del>' : '<span class="af_wsp_no_discount">No Discount</span>';

						
					$headingText = "Buy $min_qty or<br> more";
							
											
					$card_template_html .= '
							<div class="af_wsp_inner_small_box" data-min-qty=' . $min_qty . ' data-max-qty=' . $max_qty . '>
								<div class="afwsp_offer_data_contianer">
									<div class="afwsp_card_inner_heading">' . ( $headingText ) . '</div>
									<div class="afwsp_card_inner_text">
										<p>' . wc_price($discounted_price) . '</p>
										<p>' . $discount_text . '</p>
									</div>
								</div>
								<div class="afwsp_sale_tag">' . ( $discount_percentage ) . '%</div>
							</div>';
				}


						$list_template_html = '';

				foreach ($raw_data_for_template_design as $index => $value) {
					$min_qty             = $value['min_qty'];
					$max_qty             = $value['max_qty'];
					$discounted_price    = $value['discounted_price'];
					$saved_amount        = $value['saved_amount'];
					$original_price      = $discounted_price + $saved_amount;
					$discount_percentage = $saved_amount > 0 ? round(( $saved_amount / $original_price ) * 100) : 0;

					$headingText = "Buy $min_qty or more";
							

					$headingText .= $saved_amount > 0 ? " & save upto $discount_percentage%" : '';

					$discount_text = $saved_amount > 0 ? '<del>' . wc_price($original_price) . '/each</del>' : '<span class="af_wsp_no_discount">No Discount</span>';

					$list_template_html .= '
							<div class="af_wsp_list_box" data-min-qty=' . $min_qty . ' data-max-qty=' . $max_qty . '>
								<div class="af_wsp_list_inner_container">
									<div class="af_wsp_radio_div"></div>
									<div class="heading">' . $headingText . '</div>
									<div class="af_wsp_list_price_text">
										<p>' . wc_price($discounted_price) . '</p>
										<p>' . $discount_text . '</p>
									</div>
								</div>
							</div>';
				}


						$card_template = '';
						$list_template ='';


				if ('card' == $this->addify_wsp_pricing_design_type) {
					$card_template .= '
							<div class="af_wsp_card_div">
								' . $card_template_html . '
							</div>';
				} elseif ('list' == $this->addify_wsp_pricing_design_type) {
					$list_template = '
							<div class="af_wsp_list_div">
								' . $list_template_html . '
							</div>';
				}

						$template_html = '<div class="af_wsp_template_div">
											<div class="afwsp_template_header">
												<img  src="' . esc_url($this->addify_wsp_template_icon) . '" class="afwsp_deals_icon" >
												<h2 style="font-size: ' . esc_attr($this->addify_wsp_template_heading_text_font_size) . 'px;">' . esc_attr($this->addify_wsp_template_heading_text) . '</h2>
											</div>'
											. $table_template . $card_template . $list_template . '
										</div>';
						
				

					echo wp_kses_post ( $template_html );
					
			}
		}

		public function af_show_tiered_pricing_table_variation( $data, $product, $variation ) {

			$user                         = wp_get_current_user();
			$role                         = ( array ) $user->roles;
			$current_role                 = current( $user->roles );
			$customer_discount            = false;
			$role_discount                = false;
			$customer_discount1           = false;
			$role_discount1               = false;
			$role_discount_guest          = false;
			$table_data                   = '';
			$raw_data_for_template_design = array();
			$msg_data                     = '';


			//Hide price and add to cart
			if ( ! empty( $this->wsp_enable_hide_price_feature ) && 'yes' == $this->wsp_enable_hide_price_feature && 'yes' == $this->wsp_enable_hide_price ) {


				// For Guest Users
				if ( ! empty( $this->wsp_enable_for_guest ) && 'yes' == $this->wsp_enable_for_guest ) {

					if ( ! is_user_logged_in() ) {

						if ( ! empty( $this->wsp_hide_products ) ) {

							if ( in_array( $product->get_id(), (array) $this->wsp_hide_products ) ) {

								if ( ! empty( $this->wsp_enable_hide_price ) && 'yes' == $this->wsp_enable_hide_price ) {
									$msg_data = 'price_hidden';
								}
								
							}
						}

						if ( ! empty( $this->wsp_hide_categories ) && ! empty( $this->wsp_enable_hide_price ) && 'yes' == $this->wsp_enable_hide_price ) {
							foreach ( $this->wsp_hide_categories as $cat ) {
								if ( has_term( $cat, 'product_cat', $product->get_id() ) ) {
								
									$msg_data = 'price_hidden';
								}
							}
						}
					}
				}

				// For Registered Users
				if ( ! empty( $this->wsp_enable_hide_pirce_registered ) && 'yes' == $this->wsp_enable_hide_pirce_registered ) {

					if ( is_user_logged_in() ) {

						// get Current User Role
						$curr_user      = wp_get_current_user();
						$user_data      = get_user_meta( $curr_user->ID );
						$curr_user_role = $curr_user->roles[0];

						if ( !empty($this->wsp_hide_user_role) && in_array( $curr_user_role, $this->wsp_hide_user_role ) ) {

							if ( in_array( $product->get_id(), (array) $this->wsp_hide_products ) ) {

								if ( ! empty( $this->wsp_enable_hide_price ) && 'yes' == $this->wsp_enable_hide_price ) {

									$msg_data = 'price_hidden';
								}
							} 
							if ( ! empty( $this->wsp_hide_categories ) && ! empty( $this->wsp_enable_hide_price ) && 'yes' == $this->wsp_enable_hide_price ) {

								foreach ( $this->wsp_hide_categories as $cat ) {
									if ( has_term( $cat, 'product_cat', $product->get_id() ) ) {
										$msg_data = 'price_hidden';
									}
								}
							}
						}
					}
				}


			} //End Hide Price

		

			//Products other than variable product
			// get customer specifc price
			$cus_base_wsp_price = get_post_meta( $variation->get_id(), '_cus_base_wsp_price', true );

			// get role base price
			$role_base_wsp_price = get_post_meta( $variation->get_id(), '_role_base_wsp_price', true );

			// if (!empty($this->addify_wsp_pricing_design_type)) {

			//  $this->af_wsp_display_selected_template($this->addify_wsp_pricing_design_type);

			// }

			// if (!empty($this->addify_wsp_template_font_family)) {

			//  $this->af_wsp_template_font_family($this->addify_wsp_template_font_family);

			// }

			// if ('yes' == $this->addify_wsp_enable_table_border) {

			//  $this->af_wsp_table_border($this->addify_wsp_table_border_color);

			// }

			// if (!empty($this->addify_wsp_table_odd_rows_color)) {

			//  $this->af_wsp_odd_row_color($this->addify_wsp_table_odd_rows_color);

			// }



			// if (!empty($this->addify_wsp_table_even_rows_color)) {

			//  $this->af_wsp_even_row_color($this->addify_wsp_table_even_rows_color);

			// }

			// if (!empty($this->addify_wsp_table_rows_font_size)) {

			//  $this->af_wsp_table_row_font_size($this->addify_wsp_table_rows_font_size);

			// }

						$get_type_of_price = 'excl' == $this->get_tax_price_display_mode() ? 'wc_get_price_excluding_tax' : 'wc_get_price_including_tax'  ; 

						
						$pro_price = get_post_meta( $variation->get_id(), '_price', true ); 
						
						$product_old_price = $get_type_of_price( $product, array(
							'qty'   => 1,
							'price' => $pro_price,
						) );

			if ( is_user_logged_in() ) {

				if ( !empty( $this->addify_wsp_discount_price[ $current_role ] ) ) {

					if ('sale' == $this->addify_wsp_discount_price[ $current_role ] && !empty(get_post_meta( $variation->get_id(), '_sale_price', true ))) {

						$pro_price = get_post_meta( $variation->get_id(), '_sale_price', true );

						$product_old_price = $get_type_of_price( $product, array(
							'qty'   => 1,
							'price' => $pro_price,
						) );

					} elseif ('regular' == $this->addify_wsp_discount_price[ $current_role ] && !empty(get_post_meta( $variation->get_id(), '_regular_price', true ))) {

						$pro_price = get_post_meta( $variation->get_id(), '_regular_price', true );

						$product_old_price = $get_type_of_price( $product, array(
							'qty'   => 1,
							'price' => $pro_price,
						) );

					} 

				} 

				$pro_price = '' != $pro_price ?$pro_price :0;

				if ( ! empty( $cus_base_wsp_price ) ) {

								
					foreach ( $cus_base_wsp_price as $cus_price ) {

						if ( isset( $cus_price['customer_name'] ) && $user->ID == $cus_price['customer_name'] ) {

							if ( '' != $cus_price['discount_value'] || 0 != $cus_price['discount_value'] ) {

												
								//Fixed Price
								if ( 'fixed_price' == $cus_price['discount_type'] ) {

									$newprice                       = $get_type_of_price( $product, array(
										'qty'   => 1,
										'price' => $cus_price['discount_value'],
									) );
									$replace_price                  = isset($cus_price['replace_orignal_price'])?$cus_price['replace_orignal_price']:'no';
									$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $cus_price['min_qty'] . '</td><td>' . $cus_price['max_qty'] . '</td><td>' . wc_price($newprice) . '</td><td>' . ( ( $product_old_price - $newprice ) > 0 ? wc_price($product_old_price - $newprice) : wc_price(0) ) . '</td></tr>';
									$raw_data_for_template_design[] = array(
										'min_qty'          => $cus_price['min_qty'],
										'max_qty'          => $cus_price['max_qty'],
										'discounted_price' => $newprice,
										'saved_amount'     => $product_old_price - $newprice,
									);
									$customer_discount              = true;

									$msg_data .= wp_kses_post($table_data);
								} elseif ( 'fixed_increase' == $cus_price['discount_type'] ) {

									$newprice = $pro_price + $cus_price['discount_value'];

									$newprice1                      = $get_type_of_price( $product, array(
										'qty'   => 1,
										'price' => $newprice,
									) );
									$replace_price                  = isset($cus_price['replace_orignal_price'])?$cus_price['replace_orignal_price']:'no';
									$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $cus_price['min_qty'] . '</td><td>' . $cus_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
									$raw_data_for_template_design[] = array(
										'min_qty'          => $cus_price['min_qty'],
										'max_qty'          => $cus_price['max_qty'],
										'discounted_price' => $newprice1,
										'saved_amount'     => $product_old_price - $newprice1,
									);
									$customer_discount              = true;

									$msg_data .= wp_kses_post($table_data);


								} elseif ( 'fixed_decrease' == $cus_price['discount_type'] ) {

									$newprice = $pro_price - $cus_price['discount_value'];

									$newprice1                      = $get_type_of_price( $product, array(
										'qty'   => 1,
										'price' => $newprice,
									) );
									$replace_price                  = isset($cus_price['replace_orignal_price'])?$cus_price['replace_orignal_price']:'no';
									$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $cus_price['min_qty'] . '</td><td>' . $cus_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
									$raw_data_for_template_design[] = array(
										'min_qty'          => $cus_price['min_qty'],
										'max_qty'          => $cus_price['max_qty'],
										'discounted_price' => $newprice1,
										'saved_amount'     => $product_old_price - $newprice1,
									);
									$customer_discount              = true;

									$msg_data .= wp_kses_post($table_data);


								} elseif ( 'percentage_decrease' == $cus_price['discount_type'] ) {

									$percent_price = $pro_price * $cus_price['discount_value'] / 100;

									$newprice = $pro_price - $percent_price;

									$newprice1 = $get_type_of_price( $product, array(
										'qty'   => 1,
										'price' => $newprice,
									) );
												
									$replace_price                  = isset($cus_price['replace_orignal_price'])?$cus_price['replace_orignal_price']:'no';
									$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $cus_price['min_qty'] . '</td><td>' . $cus_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
									$raw_data_for_template_design[] = array(
										'min_qty'          => $cus_price['min_qty'],
										'max_qty'          => $cus_price['max_qty'],
										'discounted_price' => $newprice1,
										'saved_amount'     => $product_old_price - $newprice1,
									);
									$customer_discount              = true;

									$msg_data .= wp_kses_post($table_data);



								} elseif ( 'percentage_increase' == $cus_price['discount_type'] ) {

									$percent_price = $pro_price * $cus_price['discount_value'] / 100;

									$newprice = $pro_price + $percent_price;

									$newprice1 = $get_type_of_price( $product, array(
										'qty'   => 1,
										'price' => $newprice,
									) );

									$replace_price                  = isset($cus_price['replace_orignal_price'])?$cus_price['replace_orignal_price']:'no';
									$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $cus_price['min_qty'] . '</td><td>' . $cus_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
									$raw_data_for_template_design[] = array(
										'min_qty'          => $cus_price['min_qty'],
										'max_qty'          => $cus_price['max_qty'],
										'discounted_price' => $newprice1,
										'saved_amount'     => $product_old_price - $newprice1,
									);
									$customer_discount              = true;

									$msg_data .= wp_kses_post($table_data);


								}
												


							}
						}
					}
				} //End Customer Base


				//User Role Base Pricing
				//check if there is customer base pricing then User role base pricing will not work.

				if ( ! $customer_discount ) {


					if ( ! empty( $role_base_wsp_price ) ) {

									

						foreach ( $role_base_wsp_price as $role_price ) {

							if ( isset( $role_price['user_role'] ) && ( 'everyone' == $role_price['user_role'] || $role[0] == $role_price['user_role'] )) {

								if ( '' != $role_price['discount_value'] || 0 != $role_price['discount_value'] ) {


									//Fixed Price
									if ( 'fixed_price' == $role_price['discount_type'] ) {

										$newprice                       = $get_type_of_price( $product, array(
											'qty'   => 1,
											'price' => $role_price['discount_value'],
										) );
										$replace_price                  = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
										$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice) . '</td><td>' . ( ( $product_old_price - $newprice ) > 0 ? wc_price($product_old_price - $newprice) : wc_price(0) ) . '</td></tr>';
										$raw_data_for_template_design[] = array(
											'min_qty'      => $role_price['min_qty'],
											'max_qty'      => $role_price['max_qty'],
											'discounted_price' => $newprice,
											'saved_amount' => $product_old_price - $newprice,
										);
										$role_discount                  = true;

										$msg_data .= wp_kses_post($table_data);
									} elseif ( 'fixed_increase' == $role_price['discount_type'] ) {

										$newprice = $pro_price + $role_price['discount_value'];

										$newprice1                      = $get_type_of_price( $product, array(
											'qty'   => 1,
											'price' => $newprice,
										) );
										$replace_price                  = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
										$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
										$raw_data_for_template_design[] = array(
											'min_qty'      => $role_price['min_qty'],
											'max_qty'      => $role_price['max_qty'],
											'discounted_price' => $newprice1,
											'saved_amount' => $product_old_price - $newprice1,
										);
										$role_discount                  = true;

										$msg_data .= wp_kses_post($table_data);


									} elseif ( 'fixed_decrease' == $role_price['discount_type'] ) {

										$newprice = $pro_price - $role_price['discount_value'];

										$newprice1                      = $get_type_of_price( $product, array(
											'qty'   => 1,
											'price' => $newprice,
										) );
										$replace_price                  = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
										$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
										$raw_data_for_template_design[] = array(
											'min_qty'      => $role_price['min_qty'],
											'max_qty'      => $role_price['max_qty'],
											'discounted_price' => $newprice1,
											'saved_amount' => $product_old_price - $newprice1,
										);
										$role_discount                  = true;

										$msg_data .= wp_kses_post($table_data);


									} elseif ( 'percentage_decrease' == $role_price['discount_type'] ) {

										$percent_price = $pro_price * $role_price['discount_value'] / 100;

										$newprice = $pro_price - $percent_price;

										$newprice1                      = $get_type_of_price( $product, array(
											'qty'   => 1,
											'price' => $newprice,
										) );
										$replace_price                  = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
										$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
										$raw_data_for_template_design[] = array(
											'min_qty'      => $role_price['min_qty'],
											'max_qty'      => $role_price['max_qty'],
											'discounted_price' => $newprice1,
											'saved_amount' => $product_old_price - $newprice1,
										);
										$role_discount                  = true;

										$msg_data .= wp_kses_post($table_data);



									} elseif ( 'percentage_increase' == $role_price['discount_type'] ) {

										$percent_price = $pro_price * $role_price['discount_value'] / 100;

										$newprice = $pro_price + $percent_price;

										$newprice1 = $get_type_of_price( $product, array(
											'qty'   => 1,
											'price' => $newprice,
										) );

										$replace_price                  = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
										$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
										$raw_data_for_template_design[] = array(
											'min_qty'      => $role_price['min_qty'],
											'max_qty'      => $role_price['max_qty'],
											'discounted_price' => $newprice1,
											'saved_amount' => $product_old_price - $newprice1,
										);
										$role_discount                  = true;

										$msg_data .= wp_kses_post($table_data);


									}


								}
							}

						}

					}
				}
				//End Product Level Pricing

				//Start Global Rules
				if ( false == $customer_discount && false == $role_discount ) {

					if ( empty( $this->allfetchedrules ) ) {

						echo '';

					} else {

						$all_rules = $this->allfetchedrules;

					}

					if ( ! empty( $all_rules ) ) {

						foreach ( $all_rules as $rule ) {

							$istrue = false;


							$applied_on_all_products = get_post_meta($rule->ID, 'wsp_apply_on_all_products', true);
							$products                = get_post_meta($rule->ID, 'wsp_applied_on_products', true);
							$categories              = get_post_meta($rule->ID, 'wsp_applied_on_categories', true);

							if ('yes' == $applied_on_all_products ) {
								$istrue = true;
							} elseif (! empty($products) && ( in_array($variation->get_id(), $products) || in_array($variation->get_parent_id(), $products) ) ) {
								$istrue = true;
							}

													
							if (!empty($categories)) {
								foreach ( $categories as $cat ) {

									if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $variation->get_id() ) ) || ( has_term( $cat, 'product_cat', $variation->get_parent_id() ) ) )) {

										$istrue = true;
									} 
								}
							}

										


							if ( $istrue ) {

								// get rule customer base price
								$rule_cus_base_wsp_price = get_post_meta( $rule->ID, 'rcus_base_wsp_price', true );

								// get rule role base price
								$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

								if ( ! empty( $rule_cus_base_wsp_price ) ) {

												

									foreach ( $rule_cus_base_wsp_price as $rule_cus_price ) {

										if ( $user->ID == $rule_cus_price['customer_name'] ) {

											if ( '' != $rule_cus_price['discount_value'] || 0 != $rule_cus_price['discount_value'] ) {


												//Fixed Price
												if ( 'fixed_price' == $rule_cus_price['discount_type'] ) {

													$newprice                       = $get_type_of_price( $product, array(
														'qty'   => 1,
														'price' => $rule_cus_price['discount_value'],
													) );
													$replace_price                  = isset($rule_cus_price['replace_orignal_price'])?$rule_cus_price['replace_orignal_price']:'no';
													$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $rule_cus_price['min_qty'] . '</td><td>' . $rule_cus_price['max_qty'] . '</td><td>' . wc_price($newprice) . '</td><td>' . ( ( $product_old_price - $newprice ) > 0 ? wc_price($product_old_price - $newprice) : wc_price(0) ) . '</td></tr>';
													$raw_data_for_template_design[] = array(
														'min_qty'           => $rule_cus_price['min_qty'],
														'max_qty'           => $rule_cus_price['max_qty'],
														'discounted_price'  => $newprice,
														'saved_amount'      => $product_old_price - $newprice,
													);
													$customer_discount1             = true;

													$msg_data .= wp_kses_post($table_data);
												} elseif ( 'fixed_increase' == $rule_cus_price['discount_type'] ) {

													$newprice = $pro_price + $rule_cus_price['discount_value'];

													$newprice1                      = $get_type_of_price( $product, array(
														'qty'   => 1,
														'price' => $newprice,
													) );
													$replace_price                  = isset($rule_cus_price['replace_orignal_price'])?$rule_cus_price['replace_orignal_price']:'no';
													$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $rule_cus_price['min_qty'] . '</td><td>' . $rule_cus_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
													$raw_data_for_template_design[] = array(
														'min_qty'           => $rule_cus_price['min_qty'],
														'max_qty'           => $rule_cus_price['max_qty'],
														'discounted_price'  => $newprice1,
														'saved_amount'      => $product_old_price - $newprice1,
													);
													$customer_discount1             = true;

													$msg_data .= wp_kses_post($table_data);


												} elseif ( 'fixed_decrease' == $rule_cus_price['discount_type'] ) {

													$newprice = $pro_price - $rule_cus_price['discount_value'];

													$newprice1                      = $get_type_of_price( $product, array(
														'qty'   => 1,
														'price' => $newprice,
													) );
													$replace_price                  = isset($rule_cus_price['replace_orignal_price'])?$rule_cus_price['replace_orignal_price']:'no';
													$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $rule_cus_price['min_qty'] . '</td><td>' . $rule_cus_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
													$raw_data_for_template_design[] = array(
														'min_qty'           => $rule_cus_price['min_qty'],
														'max_qty'           => $rule_cus_price['max_qty'],
														'discounted_price'  => $newprice1,
														'saved_amount'      => $product_old_price - $newprice1,
													);
													$customer_discount1             = true;

													$msg_data .= wp_kses_post($table_data);


												} elseif ( 'percentage_decrease' == $rule_cus_price['discount_type'] ) {

													$percent_price = $pro_price * $rule_cus_price['discount_value'] / 100;

													$newprice = $pro_price - $percent_price;

													$newprice1                      = $get_type_of_price( $product, array(
														'qty'   => 1,
														'price' => $newprice,
													) );
													$replace_price                  = isset($rule_cus_price['replace_orignal_price'])?$rule_cus_price['replace_orignal_price']:'no';
													$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $rule_cus_price['min_qty'] . '</td><td>' . $rule_cus_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
													$raw_data_for_template_design[] = array(
														'min_qty'           => $rule_cus_price['min_qty'],
														'max_qty'           => $rule_cus_price['max_qty'],
														'discounted_price'  => $newprice1,
														'saved_amount'      => $product_old_price - $newprice1,
													);
													$customer_discount1             = true;

													$msg_data .= wp_kses_post($table_data);



												} elseif ( 'percentage_increase' == $rule_cus_price['discount_type'] ) {

													$percent_price = $pro_price * $rule_cus_price['discount_value'] / 100;

													$newprice = $pro_price + $percent_price;

													$newprice1 = $get_type_of_price( $product, array(
														'qty'   => 1,
														'price' => $newprice,
													) );

													$replace_price                  = isset($rule_cus_price['replace_orignal_price'])?$rule_cus_price['replace_orignal_price']:'no';
													$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $rule_cus_price['min_qty'] . '</td><td>' . $rule_cus_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
													$raw_data_for_template_design[] = array(
														'min_qty'           => $rule_cus_price['min_qty'],
														'max_qty'           => $rule_cus_price['max_qty'],
														'discounted_price'  => $newprice1,
														'saved_amount'      => $product_old_price - $newprice1,
													);
													$customer_discount1             = true;

													$msg_data .= wp_kses_post($table_data);


												}


											}
										}

									}

								} //End rule customer base pricing.

								//Start rule role base pricing.
								//chcek if there is rule customer base pricing then rule role base pricing will not work.

								if ( ! $customer_discount1 ) {

									if ( ! empty( $rule_role_base_wsp_price )  ) {

													

										foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

											if ( 'everyone' == $rule_role_price['user_role'] || $role[0] == $rule_role_price['user_role'] ) {

												if ( '' != $rule_role_price['discount_value'] || 0 != $rule_role_price['discount_value'] ) {


													//Fixed Price
													if ( 'fixed_price' == $rule_role_price['discount_type'] ) {

														$newprice                       = $get_type_of_price( $product, array(
															'qty'   => 1,
															'price' => $rule_role_price['discount_value'],
														) );
														$replace_price                  = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';
														$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice) . '</td><td>' . ( ( $product_old_price - $newprice ) > 0 ? wc_price($product_old_price - $newprice) : wc_price(0) ) . '</td></tr>';
														$raw_data_for_template_design[] = array(
															'min_qty'           => $rule_role_price['min_qty'],
															'max_qty'           => $rule_role_price['max_qty'],
															'discounted_price'  => $newprice,
															'saved_amount'      => $product_old_price - $newprice,
														);

														$msg_data      .= wp_kses_post($table_data);
														$role_discount1 = true;

													} elseif ( 'fixed_increase' == $rule_role_price['discount_type'] ) {

														$newprice = $pro_price + $rule_role_price['discount_value'];

														$newprice1                      = $get_type_of_price( $product, array(
															'qty'   => 1,
															'price' => $newprice,
														) );
														$replace_price                  = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';
														$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
														$raw_data_for_template_design[] = array(
															'min_qty'           => $rule_role_price['min_qty'],
															'max_qty'           => $rule_role_price['max_qty'],
															'discounted_price'  => $newprice1,
															'saved_amount'      => $product_old_price - $newprice1,
														);
																	
														$msg_data      .= wp_kses_post($table_data);
														$role_discount1 = true;

													} elseif ( 'fixed_decrease' == $rule_role_price['discount_type'] ) {

														$newprice = $pro_price - $rule_role_price['discount_value'];

														$newprice1     = $get_type_of_price( $product, array(
															'qty'   => 1,
															'price' => $newprice,
														) );
														$replace_price = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';
														$table_data    = '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';

														$raw_data_for_template_design[] = array(
															'min_qty'           => $rule_role_price['min_qty'],
															'max_qty'           => $rule_role_price['max_qty'],
															'discounted_price'  => $newprice1,
															'saved_amount'      => $product_old_price - $newprice1,
														);

														$msg_data      .= wp_kses_post($table_data);
														$role_discount1 = true;

													} elseif ( 'percentage_decrease' == $rule_role_price['discount_type'] ) {

														$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

														$newprice = $pro_price - $percent_price;

														$newprice1                      = $get_type_of_price( $product, array(
															'qty'   => 1,
															'price' => $newprice,
														) );
														$replace_price                  = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';
														$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
														$raw_data_for_template_design[] = array(
															'min_qty'           => $rule_role_price['min_qty'],
															'max_qty'           => $rule_role_price['max_qty'],
															'discounted_price'  => $newprice1,
															'saved_amount'      => $product_old_price - $newprice1,
														);

														$msg_data      .= wp_kses_post($table_data);
														$role_discount1 = true;


													} elseif ( 'percentage_increase' == $rule_role_price['discount_type'] ) {

														$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

														$newprice = $pro_price + $percent_price;

														$newprice1 = $get_type_of_price( $product, array(
															'qty'   => 1,
															'price' => $newprice,
														) );

														$replace_price                  = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';
														$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
														$raw_data_for_template_design[] = array(
															'min_qty'           => $rule_role_price['min_qty'],
															'max_qty'           => $rule_role_price['max_qty'],
															'discounted_price'  => $newprice1,
															'saved_amount'      => $product_old_price - $newprice1,
														);
														$msg_data                      .= wp_kses_post($table_data);
														$role_discount1                 = true;

													}


												}
											}

										}
									}
								}

							}

							if ($customer_discount1 || $role_discount1 ) {
								break;
							}


						}
					}


				}



			} elseif ( !is_user_logged_in() ) {


				if ( isset( $this->addify_wsp_discount_price['guest'] ) ) {

					if ('sale' == $this->addify_wsp_discount_price['guest'] && !empty(get_post_meta( $variation->get_id(), '_sale_price', true ))) {

						$pro_price = get_post_meta( $product->get_id(), '_sale_price', true );

						$product_old_price = $get_type_of_price( $product, array(
							'qty'   => 1,
							'price' => $pro_price,
						) );

					} elseif ('regular' == $this->addify_wsp_discount_price['guest'] && !empty(get_post_meta( $variation->get_id(), '_regular_price', true ))) {
						$pro_price = get_post_meta( $variation->get_id(), '_regular_price', true );

						$product_old_price = $get_type_of_price( $product, array(
							'qty'   => 1,
							'price' => $pro_price,
						) );
					}
									
				}



				$pro_price = '' != $pro_price ?$pro_price :0;



					// Role Based Pricing for guest
				if ( true ) {

					// get role base price for guest
					$role_base_wsp_price = get_post_meta( $variation->get_id(), '_role_base_wsp_price', true );
					if ( ! empty( $role_base_wsp_price ) ) {

										

						foreach ( $role_base_wsp_price as $role_price ) {

							if ( isset( $role_price['user_role'] ) && ( 'everyone' == $role_price['user_role'] || 'guest' == $role_price['user_role'] )) {

								if ( '' != $role_price['discount_value'] || 0 != $role_price['discount_value'] ) {


									//Fixed Price
									if ( 'fixed_price' == $role_price['discount_type'] ) {

										$newprice                       = $get_type_of_price( $product, array(
											'qty'   => 1,
											'price' => $role_price['discount_value'],
										) );
										$replace_price                  = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no'; 
										$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice) . '</td><td>' . ( ( $product_old_price - $newprice ) > 0 ? wc_price($product_old_price - $newprice) : wc_price(0) ) . '</td></tr>';
										$raw_data_for_template_design[] = array(
											'min_qty'      => $role_price['min_qty'],
											'max_qty'      => $role_price['max_qty'],
											'discounted_price' => $newprice,
											'saved_amount' => $product_old_price - $newprice,
										);
										$role_discount                  = true;

										$msg_data .= wp_kses_post($table_data);
									} elseif ( 'fixed_increase' == $role_price['discount_type'] ) {

										$newprice = $pro_price + $role_price['discount_value'];

										$newprice1 = $get_type_of_price( $product, array(
											'qty'   => 1,
											'price' => $newprice,
										) );

										$replace_price                  = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
										$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
										$raw_data_for_template_design[] = array(
											'min_qty'      => $role_price['min_qty'],
											'max_qty'      => $role_price['max_qty'],
											'discounted_price' => $newprice1,
											'saved_amount' => $product_old_price - $newprice1,
										);
										$role_discount                  = true;

										$msg_data .= wp_kses_post($table_data);


									} elseif ( 'fixed_decrease' == $role_price['discount_type'] ) {

										$newprice = $pro_price - $role_price['discount_value'];

										$newprice1                      = $get_type_of_price( $product, array(
											'qty'   => 1,
											'price' => $newprice,
										) );
										$replace_price                  = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
										$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
										$raw_data_for_template_design[] = array(
											'min_qty'      => $role_price['min_qty'],
											'max_qty'      => $role_price['max_qty'],
											'discounted_price' => $newprice1,
											'saved_amount' => $product_old_price - $newprice1,
										);
										$role_discount                  = true;

										$msg_data .= wp_kses_post($table_data);


									} elseif ( 'percentage_decrease' == $role_price['discount_type'] ) {

										$percent_price = $pro_price * $role_price['discount_value'] / 100;

										$newprice = $pro_price - $percent_price;

										$newprice1                      = $get_type_of_price( $product, array(
											'qty'   => 1,
											'price' => $newprice,
										) );
										$replace_price                  = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
										$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
										$raw_data_for_template_design[] = array(
											'min_qty'      => $role_price['min_qty'],
											'max_qty'      => $role_price['max_qty'],
											'discounted_price' => $newprice1,
											'saved_amount' => $product_old_price - $newprice1,
										);
										$role_discount                  = true;

										$msg_data .= wp_kses_post($table_data);



									} elseif ( 'percentage_increase' == $role_price['discount_type'] ) {

										$percent_price = $pro_price * $role_price['discount_value'] / 100;

										$newprice = $pro_price + $percent_price;

										$newprice1 = $get_type_of_price( $product, array(
											'qty'   => 1,
											'price' => $newprice,
										) );

										$replace_price                  = isset($role_price['replace_orignal_price'])?$role_price['replace_orignal_price']:'no';
										$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $role_price['min_qty'] . '</td><td>' . $role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
										$raw_data_for_template_design[] = array(
											'min_qty'      => $role_price['min_qty'],
											'max_qty'      => $role_price['max_qty'],
											'discounted_price' => $newprice1,
											'saved_amount' => $product_old_price - $newprice1,
										);
										$role_discount                  = true;

										$msg_data .= wp_kses_post($table_data);


									}

								}
							}
						}
					}



					//Rules - guest users
					if ( false == $role_discount  ) {


						if ( empty( $this->allfetchedrules ) ) {

							echo '';

						} else {

							$all_rules = $this->allfetchedrules;

						}

						if ( ! empty( $all_rules ) ) {

							foreach ( $all_rules as $rule ) {



								$istrue = false;

								$applied_on_all_products = get_post_meta($rule->ID, 'wsp_apply_on_all_products', true);
								$products                = get_post_meta($rule->ID, 'wsp_applied_on_products', true);
								$categories              = get_post_meta($rule->ID, 'wsp_applied_on_categories', true);

								if ('yes' == $applied_on_all_products ) {
									$istrue = true;
								} elseif (! empty($products) && ( in_array($variation->get_id(), $products) || in_array($variation->get_parent_id(), $products) ) ) {
									$istrue = true;
								}

															
								if (!empty($categories)) {
									foreach ( $categories as $cat ) {

										if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $variation->get_id() ) ) || ( has_term( $cat, 'product_cat', $variation->get_parent_id() ) ) ) ) {

											$istrue = true;
										} 
									}
								}

												

								if ( $istrue ) {


									//get rule role base price for guest
									$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

									if ( ! empty( $rule_role_base_wsp_price )  ) {

														 

										foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

											if ( 'everyone' == $rule_role_price['user_role'] || 'guest' == $rule_role_price['user_role'] ) {

												if ( '' != $rule_role_price['discount_value'] || 0 != $rule_role_price['discount_value'] ) {


													//Fixed Price
													if ( 'fixed_price' == $rule_role_price['discount_type'] ) {

														$newprice                       = $get_type_of_price( $product, array(
															'qty'   => 1,
															'price' => $rule_role_price['discount_value'],
														) );
														$replace_price                  = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';       
														$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice) . '</td><td>' . ( ( $product_old_price - $newprice ) > 0 ? wc_price($product_old_price - $newprice) : wc_price(0) ) . '</td></tr>';
														$raw_data_for_template_design[] = array(
															'min_qty'           => $rule_role_price['min_qty'],
															'max_qty'           => $rule_role_price['max_qty'],
															'discounted_price'  => $newprice,
															'saved_amount'      => $product_old_price - $newprice,
														);
														$role_discount_guest            = true;

														$msg_data .= wp_kses_post($table_data);
													} elseif ( 'fixed_increase' == $rule_role_price['discount_type'] ) {

														$newprice = $pro_price + $rule_role_price['discount_value'];

														$newprice1     = $get_type_of_price( $product, array(
															'qty'   => 1,
															'price' => $newprice,
														) );
														$replace_price = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';       

														$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
														$raw_data_for_template_design[] = array(
															'min_qty'           => $rule_role_price['min_qty'],
															'max_qty'           => $rule_role_price['max_qty'],
															'discounted_price'  => $newprice1,
															'saved_amount'      => $product_old_price - $newprice1,
														);
														$role_discount_guest            = true;

														$msg_data .= wp_kses_post($table_data);


													} elseif ( 'fixed_decrease' == $rule_role_price['discount_type'] ) {

														$newprice = $pro_price - $rule_role_price['discount_value'];

														$newprice1     = $get_type_of_price( $product, array(
															'qty'   => 1,
															'price' => $newprice,
														) );
														$replace_price = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';       

														$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
														$raw_data_for_template_design[] = array(
															'min_qty'           => $rule_role_price['min_qty'],
															'max_qty'           => $rule_role_price['max_qty'],
															'discounted_price'  => $newprice1,
															'saved_amount'      => $product_old_price - $newprice1,
														);
														$role_discount_guest            = true;

														$msg_data .= wp_kses_post($table_data);


													} elseif ( 'percentage_decrease' == $rule_role_price['discount_type'] ) {

														$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

														$newprice = $pro_price - $percent_price;

														$newprice1     = $get_type_of_price( $product, array(
															'qty'   => 1,
															'price' => $newprice,
														) );
														$replace_price = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';       

														$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
														$raw_data_for_template_design[] = array(
															'min_qty'           => $rule_role_price['min_qty'],
															'max_qty'           => $rule_role_price['max_qty'],
															'discounted_price'  => $newprice1,
															'saved_amount'      => $product_old_price - $newprice1,
														);
														$role_discount_guest            = true;
														$msg_data                      .= wp_kses_post($table_data);

													} elseif ( 'percentage_increase' == $rule_role_price['discount_type'] ) {

														$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

														$newprice = $pro_price + $percent_price;

														$newprice1 = $get_type_of_price( $product, array(
															'qty'   => 1,
															'price' => $newprice,
														) );

														$replace_price = isset($rule_role_price['replace_orignal_price'])?$rule_role_price['replace_orignal_price']:'no';       

														$table_data                     = '<tr><td data-replace="' . $replace_price . '">' . $rule_role_price['min_qty'] . '</td><td>' . $rule_role_price['max_qty'] . '</td><td>' . wc_price($newprice1) . '</td><td>' . ( ( $product_old_price - $newprice1 ) > 0 ? wc_price($product_old_price - $newprice1) : wc_price(0) ) . '</td></tr>';
														$raw_data_for_template_design[] = array(
															'min_qty'           => $rule_role_price['min_qty'],
															'max_qty'           => $rule_role_price['max_qty'],
															'discounted_price'  => $newprice1,
															'saved_amount'      => $product_old_price - $newprice1,
														);

														$role_discount_guest = true;
														$msg_data           .= wp_kses_post($table_data);


													}



												}
											}
										}
									}
													

								}

								if ($role_discount_guest) {
									break;
								}

							}
						}



					}



				}
							
			}


						
			if (!empty($msg_data) && 'price_hidden' != $msg_data) { 
	
				$table_template = '<div class="responsive pricing_table"><table class="tab_bor"><thead>
											<tr>
												<th style="color:' . esc_attr($this->addify_wsp_table_header_text_color) . '; background-color:' . esc_attr($this->addify_wsp_table_header_color) . '; font-size: ' . esc_attr($this->addify_wsp_table_header_font_size) . 'px;">' . esc_html__('Min', 'addify_wholesale_prices') . '</th>
												<th style="color:' . esc_attr($this->addify_wsp_table_header_text_color) . '; background-color:' . esc_attr($this->addify_wsp_table_header_color) . '; font-size: ' . esc_attr($this->addify_wsp_table_header_font_size) . 'px;">' . esc_html__('Max', 'addify_wholesale_prices') . '</th>
												<th style="color:' . esc_attr($this->addify_wsp_table_header_text_color) . '; background-color:' . esc_attr($this->addify_wsp_table_header_color) . '; font-size: ' . esc_attr($this->addify_wsp_table_header_font_size) . 'px;">' . esc_html__('Price', 'addify_wholesale_prices') . '</th>
												<th style="color:' . esc_attr($this->addify_wsp_table_header_text_color) . '; background-color:' . esc_attr($this->addify_wsp_table_header_color) . '; font-size: ' . esc_attr($this->addify_wsp_table_header_font_size) . 'px;">' . esc_html__('Save', 'addify_wholesale_prices') . '</th>
											</tr>
										</thead><tbody>' . $msg_data . '</tbody></table>
									</div>';
						

				$card_template_html = '';

				foreach ($raw_data_for_template_design as $index => $value) {
					$min_qty             = $value['min_qty'];
					$max_qty             = $value['max_qty'];
					$discounted_price    = $value['discounted_price'];
					$saved_amount        = $value['saved_amount'] > 0 ? $value['saved_amount']: 0;
					$original_price      = $discounted_price + $saved_amount;
					$discount_percentage = round(( $saved_amount / $original_price ) * 100);

					$discount_text = $saved_amount > 0 ? '<del>' . wc_price($original_price) . '/each</del>' : '<span class="af_wsp_no_discount">No Discount</span>';

							
					$headingText = "Buy $min_qty or more";
								
												
					$card_template_html .= '
								<div class="af_wsp_inner_small_box" data-min-qty=' . $min_qty . ' data-max-qty=' . $max_qty . '>
									<div class="afwsp_offer_data_contianer">
										<div class="afwsp_card_inner_heading">' . ( $headingText ) . '</div>
										<div class="afwsp_card_inner_text">
											<p>' . wc_price($discounted_price) . '</p>
											<p>' . $discount_text . '</p>
										</div>
									</div>
									<div class="afwsp_sale_tag">' . ( $discount_percentage ) . '%</div>
								</div>';
				}


				$list_template_html = '';

				foreach ($raw_data_for_template_design as $index => $value) {
					$min_qty             = $value['min_qty'];
					$max_qty             = $value['max_qty'];
					$discounted_price    = $value['discounted_price'];
					$saved_amount        = $value['saved_amount'];
					$original_price      = $discounted_price + $saved_amount;
					$discount_percentage = $saved_amount > 0 ? round(( $saved_amount / $original_price ) * 100) : 0;

					$headingText = "Buy $min_qty or more";
								

					$headingText .= $saved_amount > 0 ? " & save upto $discount_percentage%" : '';

					$discount_text = $saved_amount > 0 ? '<del>' . wc_price($original_price) . '/each</del>' : '<span class="af_wsp_no_discount">No Discount</span>';

					$list_template_html .= '
								<div class="af_wsp_list_box" data-min-qty=' . $min_qty . ' data-max-qty=' . $max_qty . '>
									<div class="af_wsp_list_inner_container">
										<div class="af_wsp_radio_div"></div>
										<div class="heading">' . $headingText . '</div>
										<div class="af_wsp_list_price_text">
											<p>' . wc_price($discounted_price) . '</p>
											<p>' . $discount_text . '</p>
										</div>
									</div>
								</div>';
				}


				$card_template = '';
				$list_template ='';


				if ('card' == $this->addify_wsp_pricing_design_type) {
					$card_template .= '
								<div class="af_wsp_card_div">
									' . $card_template_html . '
								</div>';
				} elseif ('list' == $this->addify_wsp_pricing_design_type) {
					$list_template = '
								<div class="af_wsp_list_div">
									' . $list_template_html . '
								</div>';
				}

				$data['price_html'] .= '<div class="af_wsp_template_div">
												<div class="afwsp_template_header">
													<img  src="' . esc_url($this->addify_wsp_template_icon) . '" class="afwsp_deals_icon" >
													<h2 style="font-size: ' . esc_attr($this->addify_wsp_template_heading_text_font_size) . 'px;">' . esc_attr($this->addify_wsp_template_heading_text) . '</h2>
												</div>'
									. $table_template . $card_template . $list_template . '
											</div>';
							
					

			}

						return $data;
		}

		public function af_wsp_custom_price_html( $price, $product ) {
			
			$prices       = $price;
			$user         = wp_get_current_user();
			$role         = ( array ) $user->roles;
			$current_role = current( $user->roles );

			//Hide price and add to cart post-476
			if ( ! empty( $this->wsp_enable_hide_price_feature ) && 'yes' == $this->wsp_enable_hide_price_feature && 'yes' == $this->wsp_enable_hide_price ) {

				$adf_product_id = $product->get_id();


				// For Guest Users
				if ( ! empty( $this->wsp_enable_for_guest ) && 'yes' == $this->wsp_enable_for_guest ) {

					if ( ! is_user_logged_in() ) {

						if ( ! empty( $this->wsp_hide_products ) ) {

							if ( in_array( $product->get_id(), (array) $this->wsp_hide_products ) ) {

								if ( ! empty( $this->wsp_enable_hide_price ) && 'yes' == $this->wsp_enable_hide_price ) {
									
									return esc_html(get_option('wsp_price_text'));
								}
								
							}
						}

						if ( ! empty( $this->wsp_hide_categories ) && ! empty( $this->wsp_enable_hide_price ) && 'yes' == $this->wsp_enable_hide_price ) {
							
							foreach ( $this->wsp_hide_categories as $cat ) {
								if ( has_term( $cat, 'product_cat', $product->get_id() ) ) {
									return esc_html(get_option('wsp_price_text'));
								}
							}
							
						}
					}
				}

				// For Registered Users
				if ( ! empty( $this->wsp_enable_hide_pirce_registered ) && 'yes' == $this->wsp_enable_hide_pirce_registered ) {

					if ( is_user_logged_in() ) {

						// get Current User Role
						$curr_user      = wp_get_current_user();
						$user_data      = get_user_meta( $curr_user->ID );
						$curr_user_role = $curr_user->roles[0];

						if ( !empty($this->wsp_hide_user_role) && in_array( $curr_user_role, $this->wsp_hide_user_role ) ) {

							if ( in_array( $product->get_id(), (array) $this->wsp_hide_products ) ) {

								if ( ! empty( $this->wsp_enable_hide_price ) && 'yes' == $this->wsp_enable_hide_price ) {
									return esc_html(get_option('wsp_price_text'));
								}
							} 
							if ( ! empty( $this->wsp_hide_categories ) && ! empty( $this->wsp_enable_hide_price ) && 'yes' == $this->wsp_enable_hide_price ) {

								foreach ( $this->wsp_hide_categories as $cat ) {
									if ( has_term( $cat, 'product_cat', $product->get_id() ) ) {
										return esc_html(get_option('wsp_price_text'));
									}
								}
							}
						}
					}
				}


			}

						
			
			
			$customer_discount              = false;
			$role_discount                  = false;
			$customer_discount1             = false;
			$role_discount1                 = false;
			$role_discount_guest            = false;
			$rule_applied_price_not_changed =false;
			
			if ( 'variable' ==  $product->get_type() ) {


				$variations              = $product->get_children();
				$product_variation_level = false;
				
				foreach ($variations as $variation_id) {
					$product_variation = wc_get_product($variation_id);
					
					if ( is_user_logged_in() ) {

						$user = wp_get_current_user();

						$cus_base_price  = get_post_meta($product_variation->get_id(), '_cus_base_wsp_price', true);
						$role_base_price = get_post_meta($product_variation->get_id(), '_role_base_wsp_price', true);

						if (empty($cus_base_price)) {
							$cus_base_price = array();
						}

						foreach ( $cus_base_price as $rule_cus_price) {

							if ( !empty($rule_cus_price['customer_name']) && $user->ID == $rule_cus_price['customer_name']) {
								$product_variation_level = true;
								break;
							}
						}
						if ( $product_variation_level ) {
							break;
						}

						//get role base price
						if (empty($role_base_price)) {
							$role_base_price = array();
						}

						foreach ( $role_base_price as $role_cus_price) {

							if ( !empty($role_cus_price['user_role']) && ( 'everyone' == $role_cus_price['user_role'] || $role[0] == $role_cus_price['user_role'] )) {
								$product_variation_level = true;
								break;
							}
						}
						


						if ( $product_variation_level ) {
							break;
						}
						
					} elseif ( !is_user_logged_in() ) {

							$role_base_price = get_post_meta($product_variation->get_id(), '_role_base_wsp_price', true);

							//get role base price
						if (empty($role_base_price)) {
							$role_base_price = array();
						}

						foreach ( $role_base_price as $role_cus_price) {

							if ( !empty($role_cus_price['user_role']) && ( 'everyone' == $role_cus_price['user_role'] || 'guest' == $role_cus_price['user_role'] )) {
								$product_variation_level = true;
									
							}
						}

					}

				}//end foreach

				
				$min_price =  999999999999999999999999999999;
				$max_price = 0; 
				if ( $product_variation_level ) {
					$variations = $product->get_children();                 
					foreach ($variations as $variation_id) {
						$variation = wc_get_product( $variation_id );
						
						if (is_user_logged_in()) {

							if (!empty($this->addify_wsp_discount_price[ $current_role ]) && 'sale' == $this->addify_wsp_discount_price[ $current_role ] && !empty($variation->get_sale_price())) {

								$price = $variation->get_sale_price();

							} elseif (!empty($this->addify_wsp_discount_price[ $current_role ]) && 'regular' == $this->addify_wsp_discount_price[ $current_role ] && !empty($variation->get_regular_price())) {

								$price = $variation->get_price();

							} else {

								$price = $variation->get_price();
							}


						} elseif (!is_user_logged_in()) {

							if (!empty($this->addify_wsp_discount_price['guest']) && 'sale' == $this->addify_wsp_discount_price['guest'] && !empty($variation->get_sale_price())) {

								$price = $variation->get_sale_price();

							} elseif (!empty($this->addify_wsp_discount_price['guest']) && 'regular' == $this->addify_wsp_discount_price['guest'] && !empty($variation->get_regular_price())) {

								$price = $variation->get_price();

							} else {

								$price = $variation->get_price();
							}

						}


						if ( $price > $max_price ) {
							$max_price = $price ;
						}
						if ( $price < $min_price ) {
							$min_price = $price ;
						}
					}

					

					if ( 'incl' === $this->get_tax_price_display_mode() ) {
						$min_price = wc_get_price_including_tax( $product, array(
							'qty'   => 1,
							'price' => $min_price,
						) );
					} else {
						$min_price = wc_get_price_excluding_tax( $product, array(
							'qty'   => 1,
							'price' => $min_price,
						) );
					}

					if ( 'incl' === $this->get_tax_price_display_mode() ) {
						$max_price = wc_get_price_including_tax( $product, array(
							'qty'   => 1,
							'price' => $max_price,
						) );
					} else {
						$max_price = wc_get_price_excluding_tax( $product, array(
							'qty'   => 1,
							'price' => $max_price,
						) );
					}
					
					if ($min_price == $max_price) {

						

						$prices = '<p class="price"><ins class="highlight">' . wc_price( $min_price ) . '</ins></p>';

						$price_suffix = $product->get_price_suffix($min_price );

						if ( ! empty( $price_suffix ) ) {

							$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

						}


					} else {

						$prices = '<p class="price"><ins class="highlight">' . wc_price( $min_price ) . ' - ' . wc_price( $max_price ) . '</ins></p>';
					}


					return $prices;
				}

			}

			//get customer specifc price
			$cus_base_wsp_price = get_post_meta( $product->get_id(), '_cus_base_wsp_price', true );

			//get role base price
			$role_base_wsp_price = get_post_meta( $product->get_id(), '_role_base_wsp_price', true );
			

			if ( is_user_logged_in() ) {

				$pro_price = get_post_meta( $product->get_id(), '_price', true );

				if (!empty($this->addify_wsp_discount_price[ $current_role ]) && 'sale' == $this->addify_wsp_discount_price[ $current_role ] && !empty(get_post_meta( $product->get_id(), '_sale_price', true ))) {

					$pro_price = get_post_meta( $product->get_id(), '_sale_price', true );

				} elseif (!empty($this->addify_wsp_discount_price[ $current_role ]) && 'regular' == $this->addify_wsp_discount_price[ $current_role ] && !empty(get_post_meta( $product->get_id(), '_regular_price', true ))) {

					$pro_price = get_post_meta( $product->get_id(), '_regular_price', true );

				} 

				$pro_price = '' != $pro_price? $pro_price:0;

				

				if ( 'incl' === $this->get_tax_price_display_mode() ) {
					$wsp_orignal_price_to_display = wc_get_price_including_tax( $product, array(
						'qty'   => 1,
						'price' => $pro_price,
					) );
				} else {
					$wsp_orignal_price_to_display = wc_get_price_excluding_tax( $product, array(
						'qty'   => 1,
						'price' => $pro_price,
					) );
				}



				if ( ! empty( $cus_base_wsp_price ) ) {

					foreach ( $cus_base_wsp_price as $cus_price ) {

						if (isset($cus_price['customer_name']) && $user->ID == $cus_price['customer_name'] ) {

							if (( '' != $cus_price['discount_value'] || 0 != $cus_price['discount_value'] ) && 1 >= $cus_price['min_qty']) {

								if ('fixed_price' == $cus_price['discount_type'] ) {

									if ( 'incl' == $this->get_tax_price_display_mode() ) {
										$newprice = wc_get_price_including_tax( $product, array(
											'qty'   => 1,
											'price' => $cus_price['discount_value'],
										) );
									} else {
										$newprice = wc_get_price_excluding_tax( $product, array(
											'qty'   => 1,
											'price' => $cus_price['discount_value'],
										) );
									}


									if (! empty($cus_price['replace_orignal_price']) && 'yes' == $cus_price['replace_orignal_price'] ) {

										$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
										
									} else {

										$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
										
									}

									$price_suffix = $product->get_price_suffix($cus_price['discount_value'] );

									if ( ! empty( $price_suffix ) ) {

										$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

									}
									$customer_discount = true; 
									if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
										return $price;
									} else {
										return $prices;
									}

								} elseif ('fixed_increase' == $cus_price['discount_type'] ) {

									$newprice_act = $pro_price + $cus_price['discount_value'];

									if ( 'incl' == $this->get_tax_price_display_mode() ) {
										$newprice = wc_get_price_including_tax( $product, array(
											'qty'   => 1,
											'price' => $newprice_act,
										) );
									} else {
										$newprice = wc_get_price_excluding_tax( $product, array(
											'qty'   => 1,
											'price' => $newprice_act,
										) );
									}

									$prices       = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
									$price_suffix = $product->get_price_suffix($newprice_act );

									if ( ! empty( $price_suffix ) ) {

										$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

									}
									$customer_discount =true;

									if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
										return $price;
									} else {
										return $prices;
									}

								} elseif ('fixed_decrease' == $cus_price['discount_type'] ) {

									$newprice_act = $pro_price - $cus_price['discount_value'];
									
									if ( 'incl' == $this->get_tax_price_display_mode() ) {
										$newprice = wc_get_price_including_tax( $product, array(
											'qty'   => 1,
											'price' => $newprice_act,
										) );
									} else {
										$newprice = wc_get_price_excluding_tax( $product, array(
											'qty'   => 1,
											'price' => $newprice_act,
										) );
									}

									if (! empty($cus_price['replace_orignal_price']) && 'yes' == $cus_price['replace_orignal_price'] ) {

										$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

									} else {

										$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
									}

									$price_suffix = $product->get_price_suffix($newprice_act );

									if ( ! empty( $price_suffix ) ) {

										$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

									}
									$customer_discount =true;

									if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
										return $price;
									} else {
										return $prices;
									}

								} elseif ('percentage_decrease' == $cus_price['discount_type'] ) {

									$percent_price = $pro_price * $cus_price['discount_value'] / 100;
									$newprice_act  = $pro_price - $percent_price;
									
									if ( 'incl' == $this->get_tax_price_display_mode() ) {
										$newprice = wc_get_price_including_tax( $product, array(
											'qty'   => 1,
											'price' => $newprice_act,
										) );
									} else {
										$newprice = wc_get_price_excluding_tax( $product, array(
											'qty'   => 1,
											'price' => $newprice_act,
										) );
									}

									if (! empty($cus_price['replace_orignal_price']) && 'yes' == $cus_price['replace_orignal_price'] ) {

										$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

									} else {

										$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';

									}

									$price_suffix = $product->get_price_suffix($newprice_act );

									if ( ! empty( $price_suffix ) ) {

										$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

									}
									$customer_discount =true;

									if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
										return $price;
									} else {
										return $prices;
									}

								} elseif ('percentage_increase' == $cus_price['discount_type'] ) {

									$percent_price = $pro_price * $cus_price['discount_value'] / 100;
									$newprice_act  = $pro_price + $percent_price;
									
									if ( 'incl' == $this->get_tax_price_display_mode() ) {
										$newprice = wc_get_price_including_tax( $product, array(
											'qty'   => 1,
											'price' => $newprice_act,
										) );
									} else {
										$newprice = wc_get_price_excluding_tax( $product, array(
											'qty'   => 1,
											'price' => $newprice_act,
										) );
									}

									$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

									$price_suffix = $product->get_price_suffix($newprice_act );

									if ( ! empty( $price_suffix ) ) {

										$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

									}
									$customer_discount =true;

									if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
										return $price;
									} else {
										return $prices;
									}

								} else {

									$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($cus_price['discount_value']) . '</ins>';

									$price_suffix = $product->get_price_suffix($pro_price );

									if ( ! empty( $price_suffix ) ) {

										$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

									}
									$customer_discount =true;


								}
							} else {
								$customer_discount =true;

								$prices = $price;
							}
						}
					}
				} else {

					$prices = $price;
				}


				//User Role Based Pricing
				// chcek if there is customer based pricing then role base pricing will not work.
				if ( !$customer_discount ) {

					if ( ! empty( $role_base_wsp_price ) ) {

						foreach ( $role_base_wsp_price as $role_price ) {

							if (isset($role_price['user_role']) && ( 'everyone' == $role_price['user_role'] || $role[0] == $role_price['user_role'] )) {

								if (( '' != $role_price['discount_value'] || 0 != $role_price['discount_value'] ) && 1 >= $role_price['min_qty']) {

									if ('fixed_price' == $role_price['discount_type'] ) {

										if ( 'incl' == $this->get_tax_price_display_mode() ) {
											$newprice = wc_get_price_including_tax( $product, array(
												'qty'   => 1,
												'price' => $role_price['discount_value'],
											) );
										} else {
											$newprice = wc_get_price_excluding_tax( $product, array(
												'qty'   => 1,
												'price' => $role_price['discount_value'],
											) );
										}

										if (! empty($role_price['replace_orignal_price']) && 'yes' == $role_price['replace_orignal_price'] ) {

											$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
										} else {

											$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
										}

										$price_suffix = $product->get_price_suffix($role_price['discount_value'] );

										if ( ! empty( $price_suffix ) ) {

											$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

										}

										if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
											return $price;
										} else {
											return $prices;
										}

									} elseif ('fixed_increase' == $role_price['discount_type'] ) {

										$newprice_act = $pro_price + $role_price['discount_value'];
										
										if ( 'incl' == $this->get_tax_price_display_mode() ) {
											$newprice = wc_get_price_including_tax( $product, array(
												'qty'   => 1,
												'price' => $newprice_act,
											) );
										} else {
											$newprice = wc_get_price_excluding_tax( $product, array(
												'qty'   => 1,
												'price' => $newprice_act,
											) );
										}

										$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

										$price_suffix = $product->get_price_suffix($newprice_act );

										if ( ! empty( $price_suffix ) ) {

											$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

										}

										if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
											return $price;
										} else {
											return $prices;
										}

									} elseif ('fixed_decrease' == $role_price['discount_type'] ) {

										$newprice_act = $pro_price - $role_price['discount_value'];
										
										if ( 'incl' == $this->get_tax_price_display_mode() ) {
											$newprice = wc_get_price_including_tax( $product, array(
												'qty'   => 1,
												'price' => $newprice_act,
											) );
										} else {
											$newprice = wc_get_price_excluding_tax( $product, array(
												'qty'   => 1,
												'price' => $newprice_act,
											) );
										}

										if (! empty($role_price['replace_orignal_price']) && 'yes' == $role_price['replace_orignal_price'] ) {

											$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

										} else {

											$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
										}

										$price_suffix = $product->get_price_suffix($newprice_act );

										if ( ! empty( $price_suffix ) ) {

											$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

										}

										if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
											return $price;
										} else {
											return $prices;
										}

									} elseif ('percentage_decrease' == $role_price['discount_type'] ) {

										$percent_price = $pro_price * $role_price['discount_value'] / 100;
										$newprice_act  = $pro_price - $percent_price;
										
										if ( 'incl' == $this->get_tax_price_display_mode() ) {
											$newprice = wc_get_price_including_tax( $product, array(
												'qty'   => 1,
												'price' => $newprice_act,
											) );
										} else {
											$newprice = wc_get_price_excluding_tax( $product, array(
												'qty'   => 1,
												'price' => $newprice_act,
											) );
										}

										if (! empty($role_price['replace_orignal_price']) && 'yes' == $role_price['replace_orignal_price'] ) {

											$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

										} else {

											$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
										}

										$price_suffix = $product->get_price_suffix($newprice_act );

										if ( ! empty( $price_suffix ) ) {

											$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

										}

										if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
											return $price;
										} else {
											return $prices;
										}

									} elseif ('percentage_increase' == $role_price['discount_type'] ) {

										$percent_price = $pro_price * $role_price['discount_value'] / 100;
										$newprice_act  = $pro_price + $percent_price;
										
										if ( 'incl' == $this->get_tax_price_display_mode() ) {
											$newprice = wc_get_price_including_tax( $product, array(
												'qty'   => 1,
												'price' => $newprice_act,
											) );
										} else {
											$newprice = wc_get_price_excluding_tax( $product, array(
												'qty'   => 1,
												'price' => $newprice_act,
											) );
										}

										$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

										$price_suffix = $product->get_price_suffix($newprice_act );

										if ( ! empty( $price_suffix ) ) {

											$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

										}

										if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
											return $price;
										} else {
											return $prices;
										}

									} else {

										$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($role_price['discount_value']) . '</ins>';

										$price_suffix = $product->get_price_suffix($pro_price );

										if ( ! empty( $price_suffix ) ) {

											$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

										}

									}
								} else {
									$prices = $price;
								}
							}
						}
					} else {

						$prices = $price;
					}
				}


				// Rules
				if ( true ) {

					if ( empty( $this->allfetchedrules ) ) {

						echo '';

					} else {

						$all_rules = $this->allfetchedrules;

					}

					if ( ! empty( $all_rules ) ) {

						foreach ( $all_rules as $rule ) {
							$istrue = false;
							
							$applied_on_all_products = get_post_meta( $rule->ID, 'wsp_apply_on_all_products', true );
							$products                = get_post_meta( $rule->ID, 'wsp_applied_on_products', true );
							$categories              = get_post_meta( $rule->ID, 'wsp_applied_on_categories', true );

							if ( 'yes' == $applied_on_all_products ) {
								$istrue = true;
							} elseif ( ! empty( $products ) && ( in_array( $product->get_id(), $products ) || in_array( $product->get_parent_id(), $products ) ) ) {
								$istrue = true;
							}

							if (!empty($categories)) {
								foreach ( $categories as $cat ) {

									if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $product->get_id() ) ) || ( has_term( $cat, 'product_cat', $product->get_parent_id() ) ) ) ) {

										$istrue = true;
									} 
								}
							}

							

							if ( $istrue ) {
								if ($product->is_type('variable') ) {
									$min_price = $product->get_variation_price( 'min' );
									$max_price = $product->get_variation_price( 'max' );
								}

								//get rule customer based price
								$rule_cus_base_wsp_price = get_post_meta( $rule->ID, 'rcus_base_wsp_price', true );

								//get rule role base price
								$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

								$customer_discount = false;

								if ( ! empty( $rule_cus_base_wsp_price ) ) {
									foreach ( $rule_cus_base_wsp_price as $rule_cus_price ) {

										if ($user->ID == $rule_cus_price['customer_name'] ) {

											if (( '' != $rule_cus_price['discount_value'] || 0 != $rule_cus_price['discount_value'] ) && 1 >= $rule_cus_price['min_qty']) {

												if ('fixed_price' == $rule_cus_price['discount_type'] ) {

													if ($product->is_type('variable') ) {


														if ( 'incl' == $this->get_tax_price_display_mode() ) {
															$newprice = wc_get_price_including_tax( $product, array(
																'qty'   => 1,
																'price' => $rule_cus_price['discount_value'],
															) );
														} else {
															$newprice = wc_get_price_excluding_tax( $product, array(
																'qty'   => 1,
																'price' => $rule_cus_price['discount_value'],
															) );
														}


														if (! empty($rule_cus_price['replace_orignal_price']) && 'yes' == $rule_cus_price['replace_orignal_price'] ) {

															$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
														} else {

															$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
														}


													} else {

														if ( 'incl' == $this->get_tax_price_display_mode() ) {
															$newprice = wc_get_price_including_tax( $product, array(
																'qty'   => 1,
																'price' => $rule_cus_price['discount_value'],
															) );
														} else {
															$newprice = wc_get_price_excluding_tax( $product, array(
																'qty'   => 1,
																'price' => $rule_cus_price['discount_value'],
															) );
														}

														if (! empty($rule_cus_price['replace_orignal_price']) && 'yes' == $rule_cus_price['replace_orignal_price'] ) {

															$prices = '<ins class="highlight">' . wc_price($rule_cus_price['discount_value']) . '</ins>';
														} else {

															$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
														}
													}

													$price_suffix = $product->get_price_suffix($rule_cus_price['discount_value'] );

													if ( ! empty( $price_suffix ) ) {

														$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

													}
													$customer_discount1 =true;
													if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
														return $price;
													} else {
														return $prices;
													}

												} elseif ('fixed_increase' == $rule_cus_price['discount_type'] ) {

													if ($product->is_type('variable') ) {

														$newprice1 = $min_price + $rule_cus_price['discount_value'];
														$newprice2 = $max_price + $rule_cus_price['discount_value'];

														if ( 'incl' == $this->get_tax_price_display_mode() ) {
															$newprice1 = wc_get_price_including_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice1,
															) );
														} else {
															$newprice1 = wc_get_price_excluding_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice1,
															) );
														}

														if ( 'incl' == $this->get_tax_price_display_mode() ) {
															$newprice2 = wc_get_price_including_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice2,
															) );
														} else {
															$newprice2 = wc_get_price_excluding_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice2,
															) );
														}
														
														if ($min_price == $max_price ) {

															$newprice_act = $pro_price + $rule_cus_price['discount_value'];
															
															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															} else {
																$newprice = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															}

															if (! empty($rule_cus_price['replace_orignal_price']) && 'yes' == $rule_cus_price['replace_orignal_price'] ) {

																$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
															} else {

																$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
															}

															$price_suffix = $product->get_price_suffix($newprice_act );

															
														} else {

															$prices = '<ins class="highlight">' . wc_price($newprice1) . ' - ' . wc_price($newprice2) . '</ins>';
														}


													} else {

														$newprice_act = $pro_price + $rule_cus_price['discount_value'];
														
														if ( 'incl' == $this->get_tax_price_display_mode() ) {
															$newprice = wc_get_price_including_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice_act,
															) );
														} else {
															$newprice = wc_get_price_excluding_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice_act,
															) );
														}

														$prices       = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
														$price_suffix = $product->get_price_suffix($newprice_act );
														
													}

													

													if ( ! empty( $price_suffix ) ) {

														$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

													}
													$customer_discount1 =true;
													if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
														return $price;
													} else {
														return $prices;
													}

												} elseif ('fixed_decrease' == $rule_cus_price['discount_type'] ) {

													if ($product->is_type('variable') ) {

														$newprice1 = $min_price - $rule_cus_price['discount_value'];
														$newprice2 = $max_price - $rule_cus_price['discount_value'];
														
														if ( 'incl' == $this->get_tax_price_display_mode() ) {
															$newprice1 = wc_get_price_including_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice1,
															) );
														} else {
															$newprice1 = wc_get_price_excluding_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice1,
															) );
														}

														if ( 'incl' == $this->get_tax_price_display_mode() ) {
															$newprice2 = wc_get_price_including_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice2,
															) );
														} else {
															$newprice2 = wc_get_price_excluding_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice2,
															) );
														}


														if ($min_price == $max_price ) {

															$newprice_act = $pro_price - $rule_cus_price['discount_value'];
															
															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															} else {
																$newprice = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															}
															
															if (! empty($rule_cus_price['replace_orignal_price']) && 'yes' == $rule_cus_price['replace_orignal_price'] ) {

																$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
															} else {

																$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
															}

															$price_suffix = $product->get_price_suffix($newprice_act );

														} else {

															$prices = '<ins class="highlight">' . wc_price($newprice1) . ' - ' . wc_price($newprice2) . '</ins>';
														}
													} else {

														$newprice_act = $pro_price - $rule_cus_price['discount_value'];
														
														if ( 'incl' == $this->get_tax_price_display_mode() ) {
															$newprice = wc_get_price_including_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice_act,
															) );
														} else {
															$newprice = wc_get_price_excluding_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice_act,
															) );
														}

														if (! empty($rule_cus_price['replace_orignal_price']) && 'yes' == $rule_cus_price['replace_orignal_price'] ) {

															$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

														} else {

															$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
														}

														$price_suffix = $product->get_price_suffix($newprice_act );
													}

													

													if ( ! empty( $price_suffix ) ) {

														$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

													}
													$customer_discount1 =true;
													if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
														return $price;
													} else {
														return $prices;
													}

												} elseif ('percentage_decrease' == $rule_cus_price['discount_type'] ) {

													if ($product->is_type('variable') ) {

														$percent_price1 = $min_price * $rule_cus_price['discount_value'] / 100;
														$newprice1      = $min_price - $percent_price1;
														$percent_price2 = $max_price * $rule_cus_price['discount_value'] / 100;
														$newprice2      = $max_price - $percent_price2;
														 
														if ( 'incl' == $this->get_tax_price_display_mode() ) {
															$newprice1 = wc_get_price_including_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice1,
															) );
														} else {
															$newprice1 = wc_get_price_excluding_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice1,
															) );
														}

														if ( 'incl' == $this->get_tax_price_display_mode() ) {
															$newprice2 = wc_get_price_including_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice2,
															) );
														} else {
															$newprice2 = wc_get_price_excluding_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice2,
															) );
														}

														if ($min_price == $max_price ) {

															$percent_price = $pro_price * $rule_cus_price['discount_value'] / 100;
															$newprice_act  = $pro_price - $percent_price;
															
															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															} else {
																$newprice = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															}
															
															if (! empty($rule_cus_price['replace_orignal_price']) && 'yes' == $rule_cus_price['replace_orignal_price'] ) {

																$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
															} else {

																$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
															}

															$price_suffix = $product->get_price_suffix($newprice_act );

														} else {

															$prices = '<ins class="highlight">' . wc_price($newprice1) . ' - ' . wc_price($newprice2) . '</ins>';
														}
													} else {

														$percent_price = $pro_price * $rule_cus_price['discount_value'] / 100;
														$newprice_act  = $pro_price - $percent_price;
														
														if ( 'incl' == $this->get_tax_price_display_mode() ) {
															$newprice = wc_get_price_including_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice_act,
															) );
														} else {
															$newprice = wc_get_price_excluding_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice_act,
															) );
														}

														if (! empty($rule_cus_price['replace_orignal_price']) && 'yes' == $rule_cus_price['replace_orignal_price'] ) {

															$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

														} else {

															$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';

														}

														$price_suffix = $product->get_price_suffix($newprice_act );
													}

													

													if ( ! empty( $price_suffix ) ) {

														$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

													}
													$customer_discount1 =true;

													if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
														return $price;
													} else {
														return $prices;
													}

												} elseif ('percentage_increase' == $rule_cus_price['discount_type'] ) {

													if ($product->is_type('variable') ) {

														$percent_price1 = $min_price * $rule_cus_price['discount_value'] / 100;
														$newprice1      = $min_price + $percent_price1;
														$percent_price2 = $max_price * $rule_cus_price['discount_value'] / 100;
														$newprice2      = $max_price + $percent_price2;
														 
														if ( 'incl' == $this->get_tax_price_display_mode() ) {
															$newprice1 = wc_get_price_including_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice1,
															) );
														} else {
															$newprice1 = wc_get_price_excluding_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice1,
															) );
														}

														if ( 'incl' == $this->get_tax_price_display_mode() ) {
															$newprice2 = wc_get_price_including_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice2,
															) );
														} else {
															$newprice2 = wc_get_price_excluding_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice2,
															) );
														}

														if ($min_price == $max_price ) {

															$percent_price = $pro_price * $rule_cus_price['discount_value'] / 100;
															$newprice_act  = $pro_price + $percent_price;
															
															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															} else {
																$newprice = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															}
															
															if (! empty($rule_cus_price['replace_orignal_price']) && 'yes' == $rule_cus_price['replace_orignal_price'] ) {

																$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
															} else {

																$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
															}

															$price_suffix = $product->get_price_suffix($newprice_act );

														} else {

															$prices = '<ins class="highlight">' . wc_price($newprice1) . ' - ' . wc_price($newprice2) . '</ins>';
														}
													} else {

														$percent_price = $pro_price * $rule_cus_price['discount_value'] / 100;
														$newprice_act  = $pro_price + $percent_price;
														
														if ( 'incl' == $this->get_tax_price_display_mode() ) {
															$newprice = wc_get_price_including_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice_act,
															) );
														} else {
															$newprice = wc_get_price_excluding_tax( $product, array(
																'qty'   => 1,
																'price' => $newprice_act,
															) );
														}

														$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

														$price_suffix = $product->get_price_suffix($newprice_act );
													}

													

													if ( ! empty( $price_suffix ) ) {

														$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

													}
													$customer_discount1 =true;
													if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
														return $price;
													} else {
														return $prices;
													}

												} else {
													$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($rule_cus_price['discount_value']) . '</ins>';

													$price_suffix = $product->get_price_suffix($pro_price );

													if ( ! empty( $price_suffix ) ) {

														$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

													}
													$customer_discount1 =true;

												}
											} else {
												$rule_applied_price_not_changed =true;
												$prices                         = $price;
											}
										}
									}
								} else {

									$prices = $price;
								}


								// Role Based Pricing
								// chcek if there is customer based pricing then role base pricing will not work.
								if ( !$customer_discount1 && !$rule_applied_price_not_changed ) {

										
									if ( ! empty( $rule_role_base_wsp_price ) ) {
										foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

											
											if ('everyone' == $rule_role_price['user_role'] || $role[0] == $rule_role_price['user_role'] ) {

												if (( '' != $rule_role_price['discount_value'] || 0 != $rule_role_price['discount_value'] ) && 1 >= $rule_role_price['min_qty']) {

													if ('fixed_price' == $rule_role_price['discount_type'] ) {

														if ($product->is_type('variable') ) {

															
															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $rule_role_price['discount_value'],
																) );
															} else {
																$newprice = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $rule_role_price['discount_value'],
																) );
															}

															if (! empty($rule_role_price['replace_orignal_price']) && 'yes' == $rule_role_price['replace_orignal_price'] ) {

																$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
															} else {

																$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
															}



														} else {

															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $rule_role_price['discount_value'],
																) );
															} else {
																$newprice = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $rule_role_price['discount_value'],
																) );
															}

															if (! empty($rule_role_price['replace_orignal_price']) && 'yes' == $rule_role_price['replace_orignal_price'] ) {

																$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
															} else {

																$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
															}
														}

														$price_suffix = $product->get_price_suffix($rule_role_price['discount_value'] );

														if ( ! empty( $price_suffix ) ) {

															$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

														}
														$role_discount1 =true;
														if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
															return $price;
														} else {
															return $prices;
														}

													} elseif ('fixed_increase' == $rule_role_price['discount_type'] ) {

														if ($product->is_type('variable') ) {

	
															$newprice1 = $min_price + $rule_role_price['discount_value'];
															$newprice2 = $max_price + $rule_role_price['discount_value'];
															
															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice1 = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice1,
																) );
															} else {
																$newprice1 = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice1,
																) );
															}

															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice2 = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice2,
																) );
															} else {
																$newprice2 = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice2,
																) );
															}

															if ($min_price == $max_price ) {

																$newprice_act = $pro_price + $rule_role_price['discount_value'];

																if ( 'incl' == $this->get_tax_price_display_mode() ) {
																	$newprice = wc_get_price_including_tax( $product, array(
																		'qty'   => 1,
																		'price' => $newprice_act,
																	) );
																} else {
																	$newprice = wc_get_price_excluding_tax( $product, array(
																		'qty'   => 1,
																		'price' => $newprice_act,
																	) );
																}

																if (! empty($rule_role_price['replace_orignal_price']) && 'yes' == $rule_role_price['replace_orignal_price'] ) {

																	$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
																} else {

																	$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
																}

																$price_suffix = $product->get_price_suffix($newprice_act );

															} else {

																$prices = '<ins class="highlight">' . wc_price($newprice1) . ' - ' . wc_price($newprice2) . '</ins>';
															}
														} else {

															$newprice_act = $pro_price + $rule_role_price['discount_value'];
															
															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															} else {
																$newprice = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															}

															$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

															$price_suffix = $product->get_price_suffix($newprice_act );
														}

														

														if ( ! empty( $price_suffix ) ) {

															$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

														}
														$role_discount1 =true;
														if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
															return $price;
														} else {
															return $prices;
														}

													} elseif ('fixed_decrease' == $rule_role_price['discount_type'] ) {

														if ($product->is_type('variable') ) {

															$newprice1 = $min_price - $rule_role_price['discount_value'];
															$newprice2 = $max_price - $rule_role_price['discount_value'];

															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice1 = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice1,
																) );
															} else {
																$newprice1 = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice1,
																) );
															}

															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice2 = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice2,
																) );
															} else {
																$newprice2 = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice2,
																) );
															}


															if ($min_price == $max_price ) {

																$newprice_act = $pro_price - $rule_role_price['discount_value'];

																
																if ( 'incl' == $this->get_tax_price_display_mode() ) {
																	$newprice = wc_get_price_including_tax( $product, array(
																		'qty'   => 1,
																		'price' => $newprice_act,
																	) );
																} else {
																	$newprice = wc_get_price_excluding_tax( $product, array(
																		'qty'   => 1,
																		'price' => $newprice_act,
																	) );
																}

																if (! empty($rule_role_price['replace_orignal_price']) && 'yes' == $rule_role_price['replace_orignal_price'] ) {

																	$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
																} else {

																	$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
																}

																$price_suffix = $product->get_price_suffix($newprice_act );



															} else {

																$prices = '<ins class="highlight">' . wc_price($newprice1) . ' - ' . wc_price($newprice2) . '</ins>';
															}
														} else {

															$newprice_act = $pro_price - $rule_role_price['discount_value'];
															
															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															} else {
																$newprice = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															}

															if (! empty($rule_role_price['replace_orignal_price']) && 'yes' == $rule_role_price['replace_orignal_price'] ) {

																$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

															} else {

																$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
															}

															$price_suffix = $product->get_price_suffix($newprice_act );
														}

														

														if ( ! empty( $price_suffix ) ) {

															$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

														}
														$role_discount1 =true;
														if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
															return $price;
														} else {
															return $prices;
														}

													} elseif ('percentage_decrease' == $rule_role_price['discount_type'] ) { 

														if ($product->is_type('variable') ) { 

															$percent_price1 = $min_price * $rule_role_price['discount_value'] / 100;
															$newprice1      = $min_price - $percent_price1;

															$percent_price2 = $max_price * $rule_role_price['discount_value'] / 100;
															$newprice2      = $max_price - $percent_price2;

															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice1 = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice1,
																) );
															} else {
																$newprice1 = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice1,
																) );
															}

															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice2 = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice2,
																) );
															} else {
																$newprice2 = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice2,
																) );
															}


															if ($min_price == $max_price ) { 

																
																$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

																$newprice_act = $pro_price - $percent_price;


																if ( 'incl' == $this->get_tax_price_display_mode() ) {
																	$newprice = wc_get_price_including_tax( $product, array(
																		'qty'   => 1,
																		'price' => $newprice_act,
																	) );
																} else {
																	$newprice = wc_get_price_excluding_tax( $product, array(
																		'qty'   => 1,
																		'price' => $newprice_act,
																	) );
																}

																if (! empty($rule_role_price['replace_orignal_price']) && 'yes' == $rule_role_price['replace_orignal_price'] ) {

																	$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
																} else {

																	$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
																}

																$price_suffix = $product->get_price_suffix($newprice_act );

																

															} else {

																$prices = '<ins class="highlight">' . wc_price($newprice1) . ' - ' . wc_price($newprice2) . '</ins>';
															}
														} else {

															$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;
															$newprice_act  = $pro_price - $percent_price;
															
															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															} else {
																$newprice = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															}

															if (! empty($rule_role_price['replace_orignal_price']) && 'yes' == $rule_role_price['replace_orignal_price'] ) {

																$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

															} else {

																$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
															}

															$price_suffix = $product->get_price_suffix($newprice_act );
														}

													

														if ( ! empty( $price_suffix ) ) {

															$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

														}
														$role_discount1 =true;
														if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
															return $price;
														} else {
															return $prices;
														}

													} elseif ('percentage_increase' == $rule_role_price['discount_type'] ) {

														if ($product->is_type('variable') ) {


															$percent_price1 = $min_price * $rule_role_price['discount_value'] / 100;
															$newprice1      = $min_price + $percent_price1;

															$percent_price2 = $max_price * $rule_role_price['discount_value'] / 100;
															$newprice2      = $max_price + $percent_price2;

															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice1 = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice1,
																) );
															} else {
																$newprice1 = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice1,
																) );
															}

															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice2 = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice2,
																) );
															} else {
																$newprice2 = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice2,
																) );
															}


															if ($min_price == $max_price ) {

																$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

																$newprice_act = $pro_price + $percent_price;

																
																if ( 'incl' == $this->get_tax_price_display_mode() ) {
																	$newprice = wc_get_price_including_tax( $product, array(
																		'qty'   => 1,
																		'price' => $newprice_act,
																	) );
																} else {
																	$newprice = wc_get_price_excluding_tax( $product, array(
																		'qty'   => 1,
																		'price' => $newprice_act,
																	) );
																}

																if (! empty($rule_role_price['replace_orignal_price']) && 'yes' == $rule_role_price['replace_orignal_price'] ) {

																	$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
																} else {

																	$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
																}

																$price_suffix = $product->get_price_suffix($newprice_act );


															} else {

																$prices = '<ins class="highlight">' . wc_price($newprice1) . ' - ' . wc_price($newprice2) . '</ins>';
															}
														} else {

															$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;
															$newprice_act  = $pro_price + $percent_price;
															
															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															} else {
																$newprice = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															}

															$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

															$price_suffix = $product->get_price_suffix($newprice_act );
														}

														

														if ( ! empty( $price_suffix ) ) {

															$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

														}
														$role_discount1 =true;
														if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
															return $price;
														} else {
															return $prices;
														}

													} else {

														$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($rule_role_price['discount_value']) . '</ins>';

														$price_suffix = $product->get_price_suffix($pro_price );

														if ( ! empty( $price_suffix ) ) {

															$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

														}
														$role_discount1 =true;
														if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
															return $price;
														} else {
															return $prices;
														}
													}
												} else {
													$rule_applied_price_not_changed = true;
													$prices                         = $price;
													return $prices;
												}
											}

										}
									} else {

										$prices = $price;
									}


								}




							}


							if ($customer_discount1 || $role_discount1  || $rule_applied_price_not_changed) {
								break;
							}


						}
					}




				}



			} elseif ( !is_user_logged_in() ) {

				$pro_price = get_post_meta( $product->get_id(), '_price', true );

				if ( isset( $this->addify_wsp_discount_price['guest'] ) ) {

					if ('sale' == $this->addify_wsp_discount_price['guest'] && !empty(get_post_meta( $product->get_id(), '_sale_price', true ))) {

						$pro_price = get_post_meta( $product->get_id(), '_sale_price', true );

					} elseif ('regular' == $this->addify_wsp_discount_price['guest'] && !empty(get_post_meta( $product->get_id(), '_regular_price', true ))) {

						$pro_price = get_post_meta( $product->get_id(), '_regular_price', true );

					}
						
				}
				$pro_price = '' != $pro_price ?$pro_price :0;
 

					$wsp_orignal_price_to_display = wc_get_price_to_display( $product, array(
						'qty'   => 1,
						'price' => $pro_price,
					) );


				if ( true ) {
					// get role base price
					$role_base_wsp_price = get_post_meta( $product->get_id(), '_role_base_wsp_price', true );
					if ( ! empty( $role_base_wsp_price ) ) {

						foreach ( $role_base_wsp_price as $role_price ) {

								
							if (isset($role_price['user_role']) && ( 'everyone' == $role_price['user_role'] || 'guest' == $role_price['user_role'] )) {

								if (( '' != $role_price['discount_value'] || 0 != $role_price['discount_value'] ) && 1 >= $role_price['min_qty']) {

									if ('fixed_price' == $role_price['discount_type'] ) {

										if ( 'incl' == $this->get_tax_price_display_mode() ) {
											$newprice = wc_get_price_including_tax( $product, array(
												'qty'   => 1,
												'price' => $role_price['discount_value'],
											) );
										} else {
											$newprice = wc_get_price_excluding_tax( $product, array(
												'qty'   => 1,
												'price' => $role_price['discount_value'],
											) );
										}

										if (! empty($role_price['replace_orignal_price']) && 'yes' == $role_price['replace_orignal_price'] ) {

											$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
										} else {

											$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
										}

										$price_suffix = $product->get_price_suffix($role_price['discount_value'] );

										if ( ! empty( $price_suffix ) ) {

											$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

										}   
										$role_discount =true;
										if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
											return $price;
										} else {
											return $prices;
										}

									} elseif ('fixed_increase' == $role_price['discount_type'] ) {

										$newprice_act = $pro_price + $role_price['discount_value'];
										
										if ( 'incl' == $this->get_tax_price_display_mode() ) {
											$newprice = wc_get_price_including_tax( $product, array(
												'qty'   => 1,
												'price' => $newprice_act,
											) );
										} else {
											$newprice = wc_get_price_excluding_tax( $product, array(
												'qty'   => 1,
												'price' => $newprice_act,
											) );
										}

										$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

										$price_suffix = $product->get_price_suffix($newprice_act );

										if ( ! empty( $price_suffix ) ) {

											$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

										}
										$role_discount =true;
										if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
											return $price;
										} else {
											return $prices;
										}

									} elseif ('fixed_decrease' == $role_price['discount_type'] ) {

										$newprice_act = $pro_price - $role_price['discount_value'];
										
										if ( 'incl' == $this->get_tax_price_display_mode() ) {
											$newprice = wc_get_price_including_tax( $product, array(
												'qty'   => 1,
												'price' => $newprice_act,
											) );
										} else {
											$newprice = wc_get_price_excluding_tax( $product, array(
												'qty'   => 1,
												'price' => $newprice_act,
											) );
										}

										if (! empty($role_price['replace_orignal_price']) && 'yes' == $role_price['replace_orignal_price'] ) {

											$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

										} else {

											$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
										}

										$price_suffix = $product->get_price_suffix($newprice_act );

										if ( ! empty( $price_suffix ) ) {

											$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

										}
										$role_discount =true;
										if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
											return $price;
										} else {
											return $prices;
										}

									} elseif ('percentage_decrease' == $role_price['discount_type'] ) {

										$percent_price = $pro_price * $role_price['discount_value'] / 100;
										$newprice_act  = $pro_price - $percent_price;
										
										if ( 'incl' == $this->get_tax_price_display_mode() ) {
											$newprice = wc_get_price_including_tax( $product, array(
												'qty'   => 1,
												'price' => $newprice_act,
											) );
										} else {
											$newprice = wc_get_price_excluding_tax( $product, array(
												'qty'   => 1,
												'price' => $newprice_act,
											) );
										}

										if (! empty($role_price['replace_orignal_price']) && 'yes' == $role_price['replace_orignal_price'] ) {

											$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

										} else {

											$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';

										}

										$price_suffix = $product->get_price_suffix($newprice_act );

										if ( ! empty( $price_suffix ) ) {

											$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

										}
										$role_discount =true;

										if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
											return $price;
										} else {
											return $prices;
										}

									} elseif ('percentage_increase' == $role_price['discount_type'] ) {

										$percent_price = $pro_price * $role_price['discount_value'] / 100;
										$newprice_act  = $pro_price + $percent_price;
										
										if ( 'incl' == $this->get_tax_price_display_mode() ) {
											$newprice = wc_get_price_including_tax( $product, array(
												'qty'   => 1,
												'price' => $newprice_act,
											) );
										} else {
											$newprice = wc_get_price_excluding_tax( $product, array(
												'qty'   => 1,
												'price' => $newprice_act,
											) );
										}

										$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

										$price_suffix = $product->get_price_suffix($newprice_act );

										if ( ! empty( $price_suffix ) ) {

											$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

										}
										$role_discount =true;

										if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
											return $price;
										} else {
											return $prices;
										}

									} else {

										$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($role_price['discount_value']) . '</ins>';

										$price_suffix = $product->get_price_suffix($pro_price );

										if ( ! empty( $price_suffix ) ) {

											$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

										}
										$role_discount =true;

									}
								} else {
									$role_discount =true;

									$prices = $price;
								}
							}

						}
					} else {

						$prices = $price;
					}




				} else {

					$prices = $price;
				}



					// Rules - guest users
				if ( ! $role_discount ) {

					if ( empty( $this->allfetchedrules ) ) {

						echo '';

					} else {

						$all_rules = $this->allfetchedrules;

					}

					if ( ! empty( $all_rules ) ) {
						foreach ( $all_rules as $rule ) {

							$istrue = false;

							$applied_on_all_products = get_post_meta( $rule->ID, 'wsp_apply_on_all_products', true );
							$products                = get_post_meta( $rule->ID, 'wsp_applied_on_products', true );
							$categories              = get_post_meta( $rule->ID, 'wsp_applied_on_categories', true );

							if ( 'yes' == $applied_on_all_products ) {
								$istrue = true;
							} elseif ( ! empty( $products ) && ( in_array( $product->get_id(), $products ) || in_array( $product->get_parent_id(), $products ) ) ) {
								$istrue = true;
							}

							if (!empty($categories)) {
								foreach ( $categories as $cat ) {

									if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $product->get_id() ) ) || ( has_term( $cat, 'product_cat', $product->get_parent_id() ) ) ) ) {

										$istrue = true;
									} 
								}
							}

								
							if ( $istrue ) {

								if ($product->is_type('variable') ) {
									$min_price = $product->get_variation_price('min');
									$max_price = $product->get_variation_price('max');

										
								}

								//get rule role base price for guest
								$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

								// Role Based Pricing
								// chcek if there is customer specific pricing then role base pricing will not work.
								if ( true ) {

									if ( ! empty( $rule_role_base_wsp_price ) ) {
										foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

												
											if ('everyone' == $rule_role_price['user_role'] || 'guest' == $rule_role_price['user_role'] ) {

												if (( '' != $rule_role_price['discount_value'] || 0 != $rule_role_price['discount_value'] ) && 1 >= $rule_role_price['min_qty']) {

													if ('fixed_price' == $rule_role_price['discount_type'] ) {

														if ($product->is_type('variable') ) {

															
															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $rule_role_price['discount_value'],
																) );
															} else {
																$newprice = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $rule_role_price['discount_value'],
																) );
															}


															if (! empty($rule_role_price['replace_orignal_price']) && 'yes' == $rule_role_price['replace_orignal_price'] ) {

																$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
															} else {

																$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
															}



														} else {

															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $rule_role_price['discount_value'],
																) );
															} else {
																$newprice = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $rule_role_price['discount_value'],
																) );
															}

															if (! empty($rule_role_price['replace_orignal_price']) && 'yes' == $rule_role_price['replace_orignal_price'] ) {

																$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
															} else {

																$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
															}
														}

														$price_suffix = $product->get_price_suffix($rule_role_price['discount_value'] );

														if ( ! empty( $price_suffix ) ) {

															$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

														}
														$role_discount =true;
														if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
															return $price;
														} else {
															return $prices;
														}

													} elseif ('fixed_increase' == $rule_role_price['discount_type'] ) {

														if ($product->is_type('variable') ) {

	
															$newprice1 = $min_price + $rule_role_price['discount_value'];
															$newprice2 = $max_price + $rule_role_price['discount_value'];
															
															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice1 = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice1,
																) );
															} else {
																$newprice1 = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice1,
																) );
															}

															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice2 = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice2,
																) );
															} else {
																$newprice2 = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice2,
																) );
															}

															if ($min_price == $max_price ) {

																$newprice_act = $pro_price + $rule_role_price['discount_value'];

																if ( 'incl' == $this->get_tax_price_display_mode() ) {
																	$newprice = wc_get_price_including_tax( $product, array(
																		'qty'   => 1,
																		'price' => $newprice_act,
																	) );
																} else {
																	$newprice = wc_get_price_excluding_tax( $product, array(
																		'qty'   => 1,
																		'price' => $newprice_act,
																	) );
																}

																if (! empty($rule_role_price['replace_orignal_price']) && 'yes' == $rule_role_price['replace_orignal_price'] ) {

																	$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
																} else {

																	$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
																}

																$price_suffix = $product->get_price_suffix($newprice_act );

															} else {

																$prices = '<ins class="highlight">' . wc_price($newprice1) . ' - ' . wc_price($newprice2) . '</ins>';
															}
														} else {

															$newprice_act = $pro_price + $rule_role_price['discount_value'];
															
															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															} else {
																$newprice = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															}

															$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

															$price_suffix = $product->get_price_suffix($newprice_act );
														}

														

														if ( ! empty( $price_suffix ) ) {

															$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

														}
														$role_discount =true;

														if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
															return $price;
														} else {
															return $prices;
														}

													} elseif ('fixed_decrease' == $rule_role_price['discount_type'] ) {

														if ($product->is_type('variable') ) {

															$newprice1 = $min_price - $rule_role_price['discount_value'];
															$newprice2 = $max_price - $rule_role_price['discount_value'];

															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice1 = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice1,
																) );
															} else {
																$newprice1 = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice1,
																) );
															}

															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice2 = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice2,
																) );
															} else {
																$newprice2 = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice2,
																) );
															}

															if ($min_price == $max_price ) {

																$newprice_act = $pro_price - $rule_role_price['discount_value'];

																
																if ( 'incl' == $this->get_tax_price_display_mode() ) {
																	$newprice = wc_get_price_including_tax( $product, array(
																		'qty'   => 1,
																		'price' => $newprice_act,
																	) );
																} else {
																	$newprice = wc_get_price_excluding_tax( $product, array(
																		'qty'   => 1,
																		'price' => $newprice_act,
																	) );
																}

																if (! empty($rule_role_price['replace_orignal_price']) && 'yes' == $rule_role_price['replace_orignal_price'] ) {

																	$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
																} else {

																	$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
																}

																$price_suffix = $product->get_price_suffix($newprice_act );



															} else {

																$prices = '<ins class="highlight">' . wc_price($newprice1) . ' - ' . wc_price($newprice2) . '</ins>';
															}
														} else {

															$newprice_act = $pro_price - $rule_role_price['discount_value'];
															
															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															} else {
																$newprice = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															}

															if (! empty($rule_role_price['replace_orignal_price']) && 'yes' == $rule_role_price['replace_orignal_price'] ) {

																$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

															} else {

																$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
															}

															$price_suffix = $product->get_price_suffix($newprice_act );

														}

														

														if ( ! empty( $price_suffix ) ) {

															$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

														}
														$role_discount =true;

														if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
															return $price;
														} else {
															return $prices;
														}

													} elseif ('percentage_decrease' == $rule_role_price['discount_type'] ) { 

														if ($product->is_type('variable') ) { 

															$percent_price1 = $min_price * $rule_role_price['discount_value'] / 100;
															$newprice1      = $min_price - $percent_price1;

															$percent_price2 = $max_price * $rule_role_price['discount_value'] / 100;
															$newprice2      = $max_price - $percent_price2;

															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice1 = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice1,
																) );
															} else {
																$newprice1 = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice1,
																) );
															}

															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice2 = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice2,
																) );
															} else {
																$newprice2 = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice2,
																) );
															}

															if ($min_price == $max_price ) { 

																
																$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

																$newprice_act = $pro_price - $percent_price;


																if ( 'incl' == $this->get_tax_price_display_mode() ) {
																	$newprice = wc_get_price_including_tax( $product, array(
																		'qty'   => 1,
																		'price' => $newprice_act,
																	) );
																} else {
																	$newprice = wc_get_price_excluding_tax( $product, array(
																		'qty'   => 1,
																		'price' => $newprice_act,
																	) );
																}

																if (! empty($rule_role_price['replace_orignal_price']) && 'yes' == $rule_role_price['replace_orignal_price'] ) {

																	$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
																} else {

																	$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
																}

																$price_suffix = $product->get_price_suffix($newprice_act );

																

															} else {

																$prices = '<ins class="highlight">' . wc_price($newprice1) . ' - ' . wc_price($newprice2) . '</ins>';
															}
														} else {

															$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;
															$newprice_act  = $pro_price - $percent_price;
															
															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															} else {
																$newprice = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															}

															if (! empty($rule_role_price['replace_orignal_price']) && 'yes' == $rule_role_price['replace_orignal_price'] ) {

																$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

															} else {

																$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
															}

															$price_suffix = $product->get_price_suffix($newprice_act );
														}

														

														if ( ! empty( $price_suffix ) ) {

															$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

														}
														$role_discount =true;

														if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
															return $price;
														} else {
															return $prices;
														}

													} elseif ('percentage_increase' == $rule_role_price['discount_type'] ) {

														if ($product->is_type('variable') ) {


															$percent_price1 = $min_price * $rule_role_price['discount_value'] / 100;
															$newprice1      = $min_price + $percent_price1;

															$percent_price2 = $max_price * $rule_role_price['discount_value'] / 100;
															$newprice2      = $max_price + $percent_price2;

															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice1 = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice1,
																) );
															} else {
																$newprice1 = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice1,
																) );
															}

															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice2 = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice2,
																) );
															} else {
																$newprice2 = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice2,
																) );
															}

															if ($min_price == $max_price ) {

																$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

																$newprice_act = $pro_price + $percent_price;

																
																if ( 'incl' == $this->get_tax_price_display_mode() ) {
																	$newprice = wc_get_price_including_tax( $product, array(
																		'qty'   => 1,
																		'price' => $newprice_act,
																	) );
																} else {
																	$newprice = wc_get_price_excluding_tax( $product, array(
																		'qty'   => 1,
																		'price' => $newprice_act,
																	) );
																}

																if (! empty($rule_role_price['replace_orignal_price']) && 'yes' == $rule_role_price['replace_orignal_price'] ) {

																	$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';
																} else {

																	$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($newprice) . '</ins>';
																}

																$price_suffix = $product->get_price_suffix($newprice_act );


															} else {

																$prices = '<ins class="highlight">' . wc_price($newprice1) . ' - ' . wc_price($newprice2) . '</ins>';
															}
														} else {

															$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;
															$newprice_act  = $pro_price + $percent_price;
															
															if ( 'incl' == $this->get_tax_price_display_mode() ) {
																$newprice = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															} else {
																$newprice = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $newprice_act,
																) );
															}

															$prices = '<ins class="highlight">' . wc_price($newprice) . '</ins>';

															$price_suffix = $product->get_price_suffix($newprice_act );
														}

														

														if ( ! empty( $price_suffix ) ) {

															$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

														}
														$role_discount =true;

														if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
															return $price;
														} else {
															return $prices;
														}

													} else {

														$role_discount =true;

														$prices = '<del class="strike">' . wc_price( $wsp_orignal_price_to_display ) . '</del><ins class="highlight">' . wc_price($rule_role_price['discount_value']) . '</ins>';

														$price_suffix = $product->get_price_suffix($pro_price );

														if ( ! empty( $price_suffix ) ) {

															$prices .= ' <small class="woocommerce-price-suffix">' . $price_suffix . '</small>';

														}
														if ('simple' ==  $product->get_type() && 'yes' == get_option('addify_wsp_enable_table') && is_product()) {
															return $price;
														} else {
															return $prices;
														}
													}
												} else {
													$role_discount =true;

													$prices = $price;
													return $prices;
												}
											}


										}
									} else {

										$prices = $price;
									}


								} else {

									$prices = $price;

								}
							}

							if ($role_discount) {
								break;
							}
						}
					}
				}


			}


			return $prices;
		}

		public function af_wsp_recalculate_price( $cart_object ) {
			// Avoiding hook repetition (when using price calculations for example)
			if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 ) {
				return;
			}

			$user         = wp_get_current_user();
			$role         = ( array ) $user->roles;
			$current_role = current( $user->roles );
			$quantity     = 0;
			
			$role_discount       = false;
			$customer_discount1  = false;
			$role_discount1      = false;
			$role_guest_discount = false;
			$customer_discount   = false;

			//This will be set to true if rule is applied so that at a time only one rule will be applied.
			$rule_applied_price_not_changed = false;


			if ( is_user_logged_in() ) {
				
				foreach ( $cart_object->get_cart() as $key => $value ) {
					if(isset($value['wcsatt_data']['active_subscription_scheme']) && !empty($value['wcsatt_data']['active_subscription_scheme']) || ('simple-subscription' == $value['data']->get_type() || 'variable-subscription' == $value['data']->get_type()) ){
                        continue;
                    }
					$customer_discount = false;                    
					$quantity     += $value['quantity'];
					
					if (0 != $value['variation_id']) {
						
						$product_id = $value['variation_id'];
						$parent_id  = $value['product_id'];
						
					} else {
						
						$product_id = $value['product_id'];
						$parent_id  = 0;
						
					}
					
					if (!empty($this->addify_wsp_discount_price[ $current_role ]) && 'sale' == $this->addify_wsp_discount_price[ $current_role ] && !empty($value['data']->get_sale_price())) {
						
						$pro_price = $value['data']->get_sale_price();

					} elseif (!empty($this->addify_wsp_discount_price[ $current_role ]) && 'regular' == $this->addify_wsp_discount_price[ $current_role ] && !empty($value['data']->get_regular_price())) {
						
						$pro_price = $value['data']->get_regular_price();
						
					} else {
						
						$pro_price = $value['data']->get_price();
					}

					//get customer specifc price
					$cus_base_wsp_price = get_post_meta( $product_id, '_cus_base_wsp_price', true );
					
					//get role base price
					$role_base_wsp_price = get_post_meta( $product_id, '_role_base_wsp_price', true );


					//Customer pricing
					if ( ! empty( $cus_base_wsp_price ) ) {

						foreach ( $cus_base_wsp_price as $cus_price ) {
							
							if (isset($cus_price['customer_name']) && $user->ID == $cus_price['customer_name'] ) {

								if (( $value['quantity'] >= $cus_price['min_qty'] && $value['quantity'] <= $cus_price['max_qty'] ) 
									|| ( $value['quantity'] >= $cus_price['min_qty'] && '' == $cus_price['max_qty'] )
								|| ( $value['quantity'] >= $cus_price['min_qty'] && 0 == $cus_price['max_qty'] ) 
								|| ( '' == $cus_price['min_qty'] && $value['quantity'] <= $cus_price['max_qty'] ) 
								|| ( 0 == $cus_price['min_qty'] && $value['quantity'] <= $cus_price['max_qty'] )
								) {
									
									
									if ('fixed_price' == $cus_price['discount_type'] ) {

										$value['data']->set_price($cus_price['discount_value']);
										$customer_discount = true;

									} elseif ('fixed_increase' == $cus_price['discount_type'] ) {

										if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

											$newprice = 0;
											$newprice = $newprice + $cus_price['discount_value'];
										} else {

											$newprice = $pro_price + $cus_price['discount_value'];
										}

										
										$value['data']->set_price($newprice);
										$customer_discount = true;


									} elseif ('fixed_decrease' == $cus_price['discount_type'] ) {

										if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

											$newprice = 0;
										} else {

											$newprice = $pro_price - $cus_price['discount_value'];

											if (0 > $newprice) {

												$newprice = 0;

											} else {

												$newprice = $newprice;

											}
										}

										
										$value['data']->set_price($newprice);
										$customer_discount = true;


									} elseif ('percentage_decrease' == $cus_price['discount_type'] ) {

										if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

											$newprice = 0;
										} else {

											$percent_price = $pro_price * $cus_price['discount_value'] / 100;

											$newprice = $pro_price - $percent_price;
											$newprice = wc_format_decimal($newprice, wc_get_price_decimals());

											if (0 > $newprice) {

												$newprice = 0;

											} else {

												$newprice = $newprice;

											}
										}

										

										$value['data']->set_price($newprice);
										$customer_discount = true;


									} elseif ('percentage_increase' == $cus_price['discount_type'] ) {


										if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

											$newprice = 0;
										} else {

											$percent_price = $pro_price * $cus_price['discount_value'] / 100;

											$newprice = $pro_price + $percent_price;
											$newprice = wc_format_decimal($newprice, wc_get_price_decimals());
										}

										

										$value['data']->set_price($newprice);
										$customer_discount = true;

									}
								} else {
									$rule_applied_price_not_changed = true;
									$customer_discount              = true;
								}
							}
						}
					}

					// Role Based Pricing
					// check if there is customer specific pricing then role base pricing will not work.
					if (  !$customer_discount && ! $rule_applied_price_not_changed ) {

						
						if ( ! empty( $role_base_wsp_price ) ) {

							foreach ( $role_base_wsp_price as $role_price ) {

								if (isset($role_price['user_role']) && ( 'everyone' == $role_price['user_role'] ||  $role[0] == $role_price['user_role'] )) {
									if (( $value['quantity'] >= $role_price['min_qty'] && $value['quantity'] <= $role_price['max_qty'] ) 
										|| ( $value['quantity'] >= $role_price['min_qty'] && '' == $role_price['max_qty'] )
										|| ( $value['quantity'] >= $role_price['min_qty'] && 0 == $role_price['max_qty'] ) 
										|| ( '' == $role_price['min_qty'] && $value['quantity'] <= $role_price['max_qty'] ) 
										|| ( 0 == $role_price['min_qty'] && $value['quantity'] <= $role_price['max_qty'] )
									) {


										if ('fixed_price' == $role_price['discount_type'] ) {
											$value['data']->set_price($role_price['discount_value']);
											$role_discount = true;
										} elseif ('fixed_increase' == $role_price['discount_type'] ) {

											if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

												$newprice = 0;
												$newprice = $newprice + $role_price['discount_value'];
											} else {

												$newprice = $pro_price + $role_price['discount_value'];
											}

											
											$value['data']->set_price($newprice);
											$role_discount = true;

										} elseif ('fixed_decrease' == $role_price['discount_type'] ) {

											if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

												$newprice = 0;
												
											} else {

												$newprice = $pro_price - $role_price['discount_value'];
												if (0 > $newprice) {

													$newprice = 0;

												} else {

													$newprice = $newprice;

												}
											}

											
											$value['data']->set_price($newprice);
											$role_discount = true;

										} elseif ('percentage_decrease' == $role_price['discount_type'] ) {

											if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

												$newprice = 0;
												
											} else {

												$percent_price = $pro_price * $role_price['discount_value'] / 100;

												$newprice = $pro_price - $percent_price;
												$newprice = wc_format_decimal($newprice, wc_get_price_decimals());

												if (0 > $newprice) {

													$newprice = 0;

												} else {

													$newprice = $newprice;

												}
											}

											

											$value['data']->set_price($newprice);
											$role_discount = true;

										} elseif ('percentage_increase' == $role_price['discount_type'] ) {

											if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

												$newprice = 0;
												
											} else {

												$percent_price = $pro_price * $role_price['discount_value'] / 100;

												$newprice = $pro_price + $percent_price;
												$newprice = wc_format_decimal($newprice, wc_get_price_decimals());
											}

											

											$value['data']->set_price($newprice);
											$role_discount = true;

										}
									} else {
										$role_discount = true;
									}
								}
							}
						}

					}


					//Rules
					if ( false == $customer_discount && false == $role_discount ) {

						if ( empty( $this->allfetchedrules ) ) {

							echo '';

						} else {

							$all_rules = $this->allfetchedrules;

						}

						if ( ! empty( $all_rules ) ) {

							foreach ( $all_rules as $rule ) {
								

								$istrue = false;

								

								$applied_on_all_products = get_post_meta( $rule->ID, 'wsp_apply_on_all_products', true );
								$products                = get_post_meta( $rule->ID, 'wsp_applied_on_products', true );
								$categories              = get_post_meta( $rule->ID, 'wsp_applied_on_categories', true );

								if ( 'yes' == $applied_on_all_products ) {
									$istrue = true;
								} elseif ( ! empty( $products ) && ( in_array( $product_id, $products ) || in_array( $parent_id, $products ) ) ) {
									$istrue = true;
								}

								if (!empty($categories)) {
									foreach ( $categories as $cat ) {

										if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $product_id ) ) || ( has_term( $cat, 'product_cat', $parent_id ) ) )) {

											$istrue = true;
										} 
									}
								}

								

								if ( $istrue ) {

									//get rule customer based price
									$rule_cus_base_wsp_price = get_post_meta( $rule->ID, 'rcus_base_wsp_price', true );

									//get rule role base price
									$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );



									if ( ! empty( $rule_cus_base_wsp_price ) ) {

										foreach ( $rule_cus_base_wsp_price as $rule_cus_price ) {

											if (isset($rule_cus_price['customer_name']) && $user->ID == $rule_cus_price['customer_name'] ) {

												if (( $value['quantity'] >= $rule_cus_price['min_qty'] && $value['quantity'] <= $rule_cus_price['max_qty'] ) 
														|| ( $value['quantity'] >= $rule_cus_price['min_qty'] && '' == $rule_cus_price['max_qty'] )
														|| ( $value['quantity'] >= $rule_cus_price['min_qty'] && 0 == $rule_cus_price['max_qty'] ) 
														|| ( '' == $rule_cus_price['min_qty'] && $value['quantity'] <= $rule_cus_price['max_qty'] ) 
														|| ( 0 == $rule_cus_price['min_qty'] && $value['quantity'] <= $rule_cus_price['max_qty'] )
													) {

														

													if ('fixed_price' == $rule_cus_price['discount_type'] ) {

														$value['data']->set_price($rule_cus_price['discount_value']);
														$customer_discount1 = true;

															

													} elseif ('fixed_increase' == $rule_cus_price['discount_type'] ) {

														if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

															$newprice = 0;
															$newprice = $newprice + $rule_cus_price['discount_value'];
																
														} else {

															$newprice = $pro_price + $rule_cus_price['discount_value'];
														}

															
														$value['data']->set_price($newprice);
														$customer_discount1 = true; 

													} elseif ('fixed_decrease' == $rule_cus_price['discount_type'] ) {

														if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

															$newprice = 0;
																
																
														} else {

															$newprice = $pro_price - $rule_cus_price['discount_value'];
															if (0 > $newprice) {

																$newprice = 0;

															} else {

																$newprice = $newprice;

															}
														}

															
														$value['data']->set_price($newprice);
														$customer_discount1 = true;

															

													} elseif ('percentage_decrease' == $rule_cus_price['discount_type'] ) {

														if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

															$newprice = 0;
																
																
														} else {

															$percent_price = $pro_price * $rule_cus_price['discount_value'] / 100;

															

															$newprice = $pro_price - $percent_price;
															$newprice = wc_format_decimal($newprice, wc_get_price_decimals());

															if (0 > $newprice) {

																$newprice = 0;

															} else {

																$newprice = $newprice;

															}
														}

															

														$value['data']->set_price($newprice);
														$customer_discount1 = true;

															

													} elseif ('percentage_increase' == $rule_cus_price['discount_type'] ) {

														if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

															$newprice = 0;
																
																
														} else {

															$percent_price = $pro_price * $rule_cus_price['discount_value'] / 100;

															$newprice = $pro_price + $percent_price;
															$newprice = wc_format_decimal($newprice, wc_get_price_decimals());
														}

															 

														$value['data']->set_price($newprice);
														$customer_discount1 = true;

													}
												} else {
													$rule_applied_price_not_changed = true;
												}
											}

										}
									}

									// Rule Role Based Pricing
									// chcek if there is customer specific pricing then role base pricing will not work.
									if ( ! $customer_discount1 && !$rule_applied_price_not_changed ) {
										
										if ( ! empty( $rule_role_base_wsp_price ) ) {

											foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

												if (isset($rule_role_price['user_role']) && ( 'everyone' == $rule_role_price['user_role'] || $role[0] == $rule_role_price['user_role'] )) {

													if (( $value['quantity'] >= $rule_role_price['min_qty'] && $value['quantity'] <= $rule_role_price['max_qty'] ) 
															|| ( $value['quantity'] >= $rule_role_price['min_qty'] && '' == $rule_role_price['max_qty'] )
															|| ( $value['quantity'] >= $rule_role_price['min_qty'] && 0 == $rule_role_price['max_qty'] ) 
															|| ( '' == $rule_role_price['min_qty'] && $value['quantity'] <= $rule_role_price['max_qty'] ) 
															|| ( 0 == $rule_role_price['min_qty'] && $value['quantity'] <= $rule_role_price['max_qty'] )
														) {

															

														if ('fixed_price' == $rule_role_price['discount_type'] ) {

															$value['data']->set_price($rule_role_price['discount_value']);
															$role_discount1 = true;

																

														} elseif ('fixed_increase' == $rule_role_price['discount_type'] ) {

															if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

																$newprice = 0;
																$newprice = $newprice + $rule_role_price['discount_value'];
																
																	
																	
															} else {

																$newprice = $pro_price + $rule_role_price['discount_value'];
															}

															
															$value['data']->set_price($newprice);
															$role_discount1 = true;

														} elseif ('fixed_decrease' == $rule_role_price['discount_type'] ) {

															if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

																$newprice = 0;
																	
																	
																	
															} else {

																$newprice = $pro_price - $rule_role_price['discount_value'];

																if (0 > $newprice) {

																	$newprice = 0;

																} else {

																	$newprice = $newprice;

																}
															}

																
															$value['data']->set_price($newprice);
															$role_discount1 = true;

														} elseif ('percentage_decrease' == $rule_role_price['discount_type'] ) {

															if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

																$newprice = 0;
																	
																	
																	
															} else {

																$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

																$newprice = $pro_price - $percent_price;
																$newprice = wc_format_decimal($newprice, wc_get_price_decimals());

																if (0 > $newprice) {

																	$newprice = 0;

																} else {

																	$newprice = $newprice;

																}
															}

																

															$value['data']->set_price($newprice);
															$role_discount1 = true;
																

														} elseif ('percentage_increase' == $rule_role_price['discount_type'] ) {

															if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

																$newprice = 0;
																	
																	
																	
															} else {

																$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

																$newprice = $pro_price + $percent_price;
																$newprice = wc_format_decimal($newprice, wc_get_price_decimals());
															}

																

															$value['data']->set_price($newprice);
															$role_discount1 = true;
																

														}
													} else {
														$rule_applied_price_not_changed = true;
													}
												}

											}
										}

										
									}
								
									

								}

								if ($customer_discount1 || $role_discount1 || $rule_applied_price_not_changed) {
									break;
								}

							}
						}


					}









				}









			} elseif ( !is_user_logged_in() ) {

				//Non logged in
				
				foreach ( $cart_object->get_cart() as $key => $value ) {
					if(isset($value['wcsatt_data']['active_subscription_scheme']) && !empty($value['wcsatt_data']['active_subscription_scheme']) || ('simple-subscription' == $value['data']->get_type() || 'variable-subscription' == $value['data']->get_type()) ){
                        continue;
                    }

					$quantity += $value['quantity'];

					if (0 != $value['variation_id']) {

						$product_id = $value['variation_id'];
						$parent_id  = $value['product_id'];

					} else {

						$product_id = $value['product_id'];
						$parent_id  = 0;

					}

					if (!empty($this->addify_wsp_discount_price['guest']) && 'sale' == $this->addify_wsp_discount_price['guest'] && !empty($value['data']->get_sale_price())) {

						$pro_price = $value['data']->get_sale_price();

					} elseif (!empty($this->addify_wsp_discount_price['guest']) && 'regular' == $this->addify_wsp_discount_price['guest'] && !empty($value['data']->get_regular_price())) {

						$pro_price = $value['data']->get_regular_price();

					} else {

						$pro_price = $value['data']->get_price();
					}


					// Role Based Pricing for guest
					if ( true ) {

						// get role base price
						$role_base_wsp_price = get_post_meta( $product_id, '_role_base_wsp_price', true );
							
						if ( ! empty( $role_base_wsp_price ) ) {

							foreach ( $role_base_wsp_price as $role_price ) {

								if (isset($role_price['user_role']) && ( 'everyone' == $role_price['user_role'] || 'guest' == $role_price['user_role'] )) {

									if (( $value['quantity'] >= $role_price['min_qty'] && $value['quantity'] <= $role_price['max_qty'] ) 
										|| ( $value['quantity'] >= $role_price['min_qty'] && '' == $role_price['max_qty'] )
										|| ( $value['quantity'] >= $role_price['min_qty'] && 0 == $role_price['max_qty'] ) 
										|| ( '' == $role_price['min_qty'] && $value['quantity'] <= $role_price['max_qty'] ) 
										|| ( 0 == $role_price['min_qty'] && $value['quantity'] <= $role_price['max_qty'] )
									) {


										if ('fixed_price' == $role_price['discount_type'] ) {

											$value['data']->set_price($role_price['discount_value']);
											$role_discount = true;

										} elseif ('fixed_increase' == $role_price['discount_type'] ) {

											if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

												$newprice = 0;
												$newprice = $newprice + $role_price['discount_value'];
																										
											} else {

												$newprice = $pro_price + $role_price['discount_value'];
											}

												
											$value['data']->set_price($newprice);
											$role_discount = true;

										} elseif ('fixed_decrease' == $role_price['discount_type'] ) {

											if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

												$newprice = 0;
													
																										
											} else {

												$newprice = $pro_price - $role_price['discount_value'];

												if (0 > $newprice) {

													$newprice = 0;

												} else {

													$newprice = $newprice;

												}
											}

												
											$value['data']->set_price($newprice);
											$role_discount = true;

										} elseif ('percentage_decrease' == $role_price['discount_type'] ) {

											if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

												$newprice = 0;
													
																										
											} else {

												$percent_price = $pro_price * $role_price['discount_value'] / 100;

												$newprice = $pro_price - $percent_price;
												$newprice = wc_format_decimal($newprice, wc_get_price_decimals());

												if (0 > $newprice) {

													$newprice = 0;

												} else {

													$newprice = $newprice;

												}
											}

												

											$value['data']->set_price($newprice);
											$role_discount = true;

										} elseif ('percentage_increase' == $role_price['discount_type'] ) {

											if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

												$newprice = 0;
													
																										
											} else {

												$percent_price = $pro_price * $role_price['discount_value'] / 100;

												$newprice = $pro_price + $percent_price;
												$newprice = wc_format_decimal($newprice, wc_get_price_decimals());
											}

												

											$value['data']->set_price($newprice);
											$role_discount = true;

										}
									}
								}
							}
						}

							


						// Rules - guest users
						if ( false == $role_discount  ) {

							if ( empty( $this->allfetchedrules ) ) {

								echo '';

							} else {

								$all_rules = $this->allfetchedrules;

							}

							if ( ! empty( $all_rules ) ) {

								foreach ( $all_rules as $rule ) {

									$istrue = false;

									$applied_on_all_products = get_post_meta( $rule->ID, 'wsp_apply_on_all_products', true );
									$products                = get_post_meta( $rule->ID, 'wsp_applied_on_products', true );
									$categories              = get_post_meta( $rule->ID, 'wsp_applied_on_categories', true );

									if ( 'yes' == $applied_on_all_products ) {
										$istrue = true;
									} elseif ( ! empty( $products ) && ( in_array( $product_id, $products ) || in_array( $parent_id, $products ) ) ) {
										$istrue = true;
									}

									if (!empty($categories)) {
										foreach ( $categories as $cat ) {

											if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $product_id ) ) || ( has_term( $cat, 'product_cat', $parent_id ) ) ) ) {

												$istrue = true;
											} 
										}
									}

										

									if ( $istrue ) {

										//get rule role base price for guest
										$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

										if ( ! empty( $rule_role_base_wsp_price ) ) {

											foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

												if (isset($rule_role_price['user_role']) && ( 'everyone' == $rule_role_price['user_role'] || 'guest' == $rule_role_price['user_role'] )) {

													if (( $value['quantity'] >= $rule_role_price['min_qty'] && $value['quantity'] <= $rule_role_price['max_qty'] ) 
															|| ( $value['quantity'] >= $rule_role_price['min_qty'] && '' == $rule_role_price['max_qty'] )
															|| ( $value['quantity'] >= $rule_role_price['min_qty'] && 0 == $rule_role_price['max_qty'] ) 
															|| ( '' == $rule_role_price['min_qty'] && $value['quantity'] <= $rule_role_price['max_qty'] ) 
															|| ( 0 == $rule_role_price['min_qty'] && $value['quantity'] <= $rule_role_price['max_qty'] )
														) {

															

														if ('fixed_price' == $rule_role_price['discount_type'] ) {

															$value['data']->set_price($rule_role_price['discount_value']);
															$role_guest_discount = true;
																	

														} elseif ('fixed_increase' == $rule_role_price['discount_type'] ) {

															if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

																$newprice = 0;
																$newprice = $newprice + $rule_role_price['discount_value'];
																		
																															
															} else {

																$newprice = $pro_price + $rule_role_price['discount_value'];
															}

																	
															$value['data']->set_price($newprice);
															$role_guest_discount = true;            

														} elseif ('fixed_decrease' == $rule_role_price['discount_type'] ) {

															if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

																$newprice = 0;
																		
																		
																															
															} else {

																$newprice = $pro_price - $rule_role_price['discount_value'];

																if (0 > $newprice) {

																	$newprice = 0;

																} else {

																	$newprice = $newprice;

																}
															}

																	
															$value['data']->set_price($newprice);
															$role_guest_discount = true;        

														} elseif ('percentage_decrease' == $rule_role_price['discount_type'] ) {

															if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

																$newprice = 0;
																		
																		
																															
															} else {

																$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

																$newprice = $pro_price - $percent_price;
																$newprice = wc_format_decimal($newprice, wc_get_price_decimals());

																if (0 > $newprice) {

																	$newprice = 0;

																} else {

																	$newprice = $newprice;

																}
															}

																	   

															$value['data']->set_price($newprice);
															$role_guest_discount = true;        

														} elseif ('percentage_increase' == $rule_role_price['discount_type'] ) {

															if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

																$newprice = 0;
																		
																		
																															
															} else {

																$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

																$newprice = $pro_price + $percent_price;
																$newprice = wc_format_decimal($newprice, wc_get_price_decimals());
															}

																	

															$value['data']->set_price($newprice);
															$role_guest_discount = true;        

														}
													}
												}

											}
										}


									}
									
									if ($role_guest_discount) {
										break;
									}

								}
							}

						}



					}
				}
				






			}

			//disable coupon if prices rule are applied
			if ($customer_discount || $customer_discount1 || $role_discount || $role_discount1 || $role_guest_discount) {

				if (!empty($this->addify_wsp_disable_coupon) && 'yes' == $this->addify_wsp_disable_coupon) {
					add_filter('woocommerce_coupons_enabled', function () {
						if (is_cart() || is_checkout()) {
							$enabled = false;
							?>
							<style type="text/css">
								.wp-block-woocommerce-cart-order-summary-coupon-form-block{
									display: none;
								}
							</style>
							<?php
						}
					
						return $enabled;
					});
					add_action('wp_footer', function () {
						if (is_cart() || is_checkout()) {
							?>
							<style type="text/css">
								.wp-block-woocommerce-cart-order-summary-coupon-form-block,
								.wp-block-woocommerce-checkout-order-summary-coupon-form-block{
									display: none;
								}
							</style>
							<?php
						}
					});
				}
				
			}
			WC()->cart->calculate_totals();
		}

		public function af_wsp_woocommerce_cart_item_price_filter( $price, $cart_item, $cart_item_key ) {



			$newprice = 0;
			$product  = isset( $cart_item['data'] ) ? $cart_item['data'] : null;
			if(isset($cart_item['wcsatt_data']['active_subscription_scheme']) && !empty($cart_item['wcsatt_data']['active_subscription_scheme']) || ('simple-subscription' == $cart_item['data']->get_type() || 'variable-subscription' == $cart_item['data']->get_type()) ){
				return $price;
			}

			if ( ! is_cart() ) {

				$user                           = wp_get_current_user();
				$role                           = ( array ) $user->roles;
				$current_role                   = current( $user->roles );
				$quantity                       = 0;
				$customer_discount              = false;
				$role_discount                  = false;
				$customer_discount1             = false;
				$role_discount1                 = false;
				$rule_applied_price_not_changed = false;
				$parent_id                      = 0;
				if (0 != $cart_item['variation_id']) {

					$product_id = $cart_item['variation_id'];
					$parent_id  = $cart_item['product_id'];

				} else {

					$product_id = $cart_item['product_id'];

				}

				$quantity += $cart_item['quantity'];

				if ( is_user_logged_in() ) {    


					if (!empty($this->addify_wsp_discount_price[ $current_role ]) && 'sale' == $this->addify_wsp_discount_price[ $current_role ] && !empty(get_post_meta( $product_id, '_sale_price', true ))) {

						$pro_price = get_post_meta( $product_id, '_sale_price', true );

					} elseif (!empty($this->addify_wsp_discount_price[ $current_role ]) && 'regular' == $this->addify_wsp_discount_price[ $current_role ] && !empty(get_post_meta( $product_id, '_regular_price', true ))) {

						$pro_price = get_post_meta( $product_id, '_regular_price', true );

					} else {

						$pro_price = get_post_meta( $product_id, '_price', true );
					}



					//get customer specifc price
					$cus_base_wsp_price = get_post_meta( $product_id, '_cus_base_wsp_price', true );

					//get role base price
					$role_base_wsp_price = get_post_meta( $product_id, '_role_base_wsp_price', true );


					//Customer pricing

					if ( ! empty( $cus_base_wsp_price ) ) {

						foreach ( $cus_base_wsp_price as $cus_price ) {

							if ( isset( $cus_price['customer_name'] ) && $user->ID == $cus_price['customer_name'] ) {

								if ( ( $cart_item['quantity'] >= $cus_price['min_qty'] && $cart_item['quantity'] <= $cus_price['max_qty'] ) 
								|| ( $cart_item['quantity'] >= $cus_price['min_qty'] && '' == $cus_price['max_qty'] )
								|| ( $cart_item['quantity'] >= $cus_price['min_qty'] && 0 == $cus_price['max_qty'] ) 
								|| ( '' == $cus_price['min_qty'] && $cart_item['quantity'] <= $cus_price['max_qty'] ) 
								|| ( 0 == $cus_price['min_qty'] && $cart_item['quantity'] <= $cus_price['max_qty'] )) {


									if ( 'fixed_price' == $cus_price['discount_type'] ) {

										if ( 'incl' === $this->get_tax_price_display_mode() ) {
											$product_priceFix = wc_get_price_including_tax( $product, array(
												'qty'   => 1,
												'price' => $cus_price['discount_value'],
											) );
										} else {
											$product_priceFix = wc_get_price_excluding_tax( $product, array(
												'qty'   => 1,
												'price' => $cus_price['discount_value'],
											) );
										}

										$price             = wc_price($product_priceFix);
										$customer_discount = true;

									} elseif ( 'fixed_increase' == $cus_price['discount_type'] ) {

										if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

											$newprice = 0;
											$newprice = $newprice + $cus_price['discount_value'];
										} else {

											$newprice = $pro_price + $cus_price['discount_value'];
										}
										
										$price             = wc_price($newprice);
										$customer_discount = true;

									} elseif ( 'fixed_decrease' == $cus_price['discount_type'] ) {

										if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

											$newprice = 0;
										} else {

											$newprice = $pro_price - $cus_price['discount_value'];
										}

										
										$price             = wc_price($newprice);
										$customer_discount = true;

									} elseif ( 'percentage_decrease' == $cus_price['discount_type'] ) {

										if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

											$newprice = 0;
										} else {

											$percent_price = $pro_price * $cus_price['discount_value'] / 100;

											$newprice = $pro_price - $percent_price;
										}


										$price             = wc_price($newprice);
										$customer_discount = true;

									} elseif ( 'percentage_increase' == $cus_price['discount_type'] ) {

										if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

											$newprice = 0;
										} else {

											$percent_price = $pro_price * $cus_price['discount_value'] / 100;

											$newprice = $pro_price + $percent_price;
										}

										$price             = wc_price($newprice);
										$customer_discount = true;

									}
								} else {
									$rule_applied_price_not_changed = true;
								}
							}
						}
					}

					// Role Based Pricing
					// chcek if there is customer specific pricing then role base pricing will not work.
					if ( ! $customer_discount && !$rule_applied_price_not_changed) {

						if ( ! empty( $role_base_wsp_price ) ) {

							foreach ( $role_base_wsp_price as $role_price ) {

								if ( isset( $role_price['user_role'] ) && ( 'everyone' == $role_price['user_role'] ||  $role[0] == $role_price['user_role'] )) {

									if ( ( $cart_item['quantity'] >= $role_price['min_qty'] && $cart_item['quantity'] <= $role_price['max_qty'] ) 
									|| ( $cart_item['quantity'] >= $role_price['min_qty'] && '' == $role_price['max_qty'] )
									|| ( $cart_item['quantity'] >= $role_price['min_qty'] && 0 == $role_price['max_qty'] ) 
									|| ( '' == $role_price['min_qty'] && $cart_item['quantity'] <= $role_price['max_qty'] ) 
									|| ( 0 == $role_price['min_qty'] && $cart_item['quantity'] <= $role_price['max_qty'] )) {


										if ( 'fixed_price' == $role_price['discount_type'] ) {

											if ( 'incl' === $this->get_tax_price_display_mode() ) {
												$product_priceFix = wc_get_price_including_tax( $product, array(
													'qty' => 1,
													'price' => $role_price['discount_value'],
												) );
											} else {
												$product_priceFix = wc_get_price_excluding_tax( $product, array(
													'qty' => 1,
													'price' => $role_price['discount_value'],
												) );
											}

											$price         = wc_price($product_priceFix);
											$role_discount = true;

										} elseif ( 'fixed_increase' == $role_price['discount_type'] ) {

											if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

												$newprice = 0;
												$newprice = $newprice + $role_price['discount_value'];
											} else {

												$newprice = $pro_price + $role_price['discount_value'];
											}

											$price         = wc_price($newprice);
											$role_discount = true;


										} elseif ( 'fixed_decrease' == $role_price['discount_type'] ) {

											if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

												$newprice = 0;
											} else {

												$newprice = $pro_price - $role_price['discount_value'];
											}

											
											$price         = wc_price($newprice);
											$role_discount = true;

										} elseif ( 'percentage_decrease' == $role_price['discount_type'] ) {

											if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

												$newprice = 0;
											} else {

												$percent_price = $pro_price * $role_price['discount_value'] / 100;

												$newprice = $pro_price - $percent_price;
											}


											$price         = wc_price($newprice);
											$role_discount = true;

										} elseif ( 'percentage_increase' == $role_price['discount_type'] ) {

											if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

												$newprice = 0;
											} else {

												$percent_price = $pro_price * $role_price['discount_value'] / 100;

												$newprice = $pro_price + $percent_price;
											}

											

											$price         = wc_price($newprice);
											$role_discount = true;

										}
									} else {
										$rule_applied_price_not_changed = true;
									}
								}
							}
						}
					}

					//Rules
					if ( false == $customer_discount && false == $role_discount && false == $rule_applied_price_not_changed) {

						if ( empty( $this->allfetchedrules ) ) {

							echo '';

						} else {

							$all_rules = $this->allfetchedrules;

						}

						if ( ! empty( $all_rules ) ) {

							foreach ( $all_rules as $rule ) {

								$istrue = false;

								$applied_on_all_products = get_post_meta( $rule->ID, 'wsp_apply_on_all_products', true );
								$products                = get_post_meta( $rule->ID, 'wsp_applied_on_products', true );
								$categories              = get_post_meta( $rule->ID, 'wsp_applied_on_categories', true );

								if ( 'yes' == $applied_on_all_products ) {
									$istrue = true;
								} elseif ( ! empty( $products ) && ( in_array( $product_id, $products ) || in_array( $parent_id, $products ) ) ) {
									$istrue = true;
								}

								if (!empty($categories)) {
									foreach ( $categories as $cat ) {

										if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $product_id ) ) || ( has_term( $cat, 'product_cat', $parent_id ) ) )) {

											$istrue = true;
										} 
									}
								}

								

								if ( $istrue ) {

									//get rule customer based price
									$rule_cus_base_wsp_price = get_post_meta( $rule->ID, 'rcus_base_wsp_price', true );

									//get rule role base price
									$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

									if ( ! empty( $rule_cus_base_wsp_price ) ) {

										foreach ( $rule_cus_base_wsp_price as $rule_cus_price ) {

											if ( isset( $rule_cus_price['customer_name'] ) && $user->ID == $rule_cus_price['customer_name'] ) {

												if ( ( $cart_item['quantity'] >= $rule_cus_price['min_qty'] && $cart_item['quantity'] <= $rule_cus_price['max_qty'] ) 
												|| ( $cart_item['quantity'] >= $rule_cus_price['min_qty'] && '' == $rule_cus_price['max_qty'] )
												|| ( $cart_item['quantity'] >= $rule_cus_price['min_qty'] && 0 == $rule_cus_price['max_qty'] ) 
												|| ( '' == $rule_cus_price['min_qty'] && $cart_item['quantity'] <= $rule_cus_price['max_qty'] ) 
												|| ( 0 == $rule_cus_price['min_qty'] && $cart_item['quantity'] <= $rule_cus_price['max_qty'] )) {

														

													if ( 'fixed_price' == $rule_cus_price['discount_type'] ) {

														if ( 'incl' === $this->get_tax_price_display_mode() ) {
															$product_priceFix = wc_get_price_including_tax( $product, array(
																'qty'   => 1,
																'price' => $rule_cus_price['discount_value'],
															) );
														} else {
															$product_priceFix = wc_get_price_excluding_tax( $product, array(
																'qty'   => 1,
																'price' => $rule_cus_price['discount_value'],
															) );
														}

														$price              = wc_price($product_priceFix);
														$customer_discount1 = true;

													} elseif ( 'fixed_increase' == $rule_cus_price['discount_type'] ) {


														if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

															$newprice = 0;
															$newprice = $newprice + $rule_cus_price['discount_value'];
														} else {

															$newprice = $pro_price + $rule_cus_price['discount_value'];
														}

														
														$price              = wc_price($newprice);
														$customer_discount1 = true;

													} elseif ( 'fixed_decrease' == $rule_cus_price['discount_type'] ) {

														if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

															$newprice = 0;
															
														} else {

															$newprice = $pro_price - $rule_cus_price['discount_value'];
														}

														
														$price              = wc_price($newprice);
														$customer_discount1 = true;

													} elseif ( 'percentage_decrease' == $rule_cus_price['discount_type'] ) {

														if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

															$newprice = 0;
															
														} else {

															$percent_price = $pro_price * $rule_cus_price['discount_value'] / 100;

															$newprice = $pro_price - $percent_price;
														}

														

														$price              = wc_price($newprice);
														$customer_discount1 = true;

													} elseif ( 'percentage_increase' == $rule_cus_price['discount_type'] ) {

														if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

															$newprice = 0;
															
														} else {

															$percent_price = $pro_price * $rule_cus_price['discount_value'] / 100;

															$newprice = $pro_price + $percent_price;
														}

															 

														$price              = wc_price($newprice);
														$customer_discount1 = true;

													}
												} else {
													$rule_applied_price_not_changed = true;
												}
											}
										}
									}

									// Rule Role Based Pricing
									// chcek if there is customer specific pricing then role base pricing will not work.
									if ( ! $customer_discount1 && !$rule_applied_price_not_changed) {

										if ( ! empty( $rule_role_base_wsp_price ) ) {

											foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

												if ( isset( $rule_role_price['user_role'] ) && ( 'everyone' == $rule_role_price['user_role'] || $role[0] == $rule_role_price['user_role'] )) {

													if ( ( $cart_item['quantity'] >= $rule_role_price['min_qty'] && $cart_item['quantity'] <= $rule_role_price['max_qty'] ) 
													|| ( $cart_item['quantity'] >= $rule_role_price['min_qty'] && '' == $rule_role_price['max_qty'] )
													|| ( $cart_item['quantity'] >= $rule_role_price['min_qty'] && 0 == $rule_role_price['max_qty'] ) 
													|| ( '' == $rule_role_price['min_qty'] && $cart_item['quantity'] <= $rule_role_price['max_qty'] ) 
													|| ( 0 == $rule_role_price['min_qty'] && $cart_item['quantity'] <= $rule_role_price['max_qty'] )) {

															

														if ( 'fixed_price' == $rule_role_price['discount_type'] ) {

															if ( 'incl' === $this->get_tax_price_display_mode() ) {
																$product_priceFix = wc_get_price_including_tax( $product, array(
																	'qty'   => 1,
																	'price' => $rule_role_price['discount_value'],
																) );
															} else {
																$product_priceFix = wc_get_price_excluding_tax( $product, array(
																	'qty'   => 1,
																	'price' => $rule_role_price['discount_value'],
																) );
															}

															$price = wc_price($product_priceFix);

														} elseif ( 'fixed_increase' == $rule_role_price['discount_type'] ) {

															if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

																$newprice = 0;
																$newprice = $newprice + $rule_role_price['discount_value'];
																
															} else {

																$newprice = $pro_price + $rule_role_price['discount_value'];
															}


															
															$price = wc_price($newprice);

														} elseif ( 'fixed_decrease' == $rule_role_price['discount_type'] ) {

															if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

																$newprice = 0;
																
																
															} else {

																$newprice = $pro_price- $rule_role_price['discount_value'];
															}


															
															$price = wc_price($newprice);

														} elseif ( 'percentage_decrease' == $rule_role_price['discount_type'] ) {

															if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

																$newprice = 0;
																
																
															} else {

																$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

																$newprice = $pro_price - $percent_price;
															}

															$price = wc_price($newprice);

														} elseif ( 'percentage_increase' == $rule_role_price['discount_type'] ) {

															if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

																$newprice = 0;
																
																
															} else {

																$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

																$newprice = (float) $pro_price + (float) $percent_price;
															}

															$price = wc_price($newprice);

														}
													} else {
														$rule_applied_price_not_changed = true;
													}
												}
											}
										}
									}
								}

								if ($customer_discount1 || $role_discount1 || $rule_applied_price_not_changed) {
									break;
								}
							}
						}
					}

				} elseif ( !is_user_logged_in() ) {

					//Guest user
					// User is not logged in
					if ( isset( $this->addify_wsp_discount_price['guest'] ) ) {

						if ('sale' == $this->addify_wsp_discount_price['guest'] && !empty(get_post_meta( $product->get_id(), '_sale_price', true ))) {

							$pro_price = get_post_meta( $product->get_id(), '_sale_price', true );

						} elseif ('regular' == $this->addify_wsp_discount_price['guest'] && !empty(get_post_meta( $product->get_id(), '_regular_price', true ))) {

							$pro_price = get_post_meta( $product->get_id(), '_regular_price', true );

						} else {
							$pro_price = get_post_meta( $product->get_id(), '_price', true );
						}
							
					} else {

						$pro_price = get_post_meta( $product->get_id(), '_price', true );
					}

						// Role Based Pricing for guest
					if ( true ) {

						// get role base price
						$role_base_wsp_price = get_post_meta( $product_id, '_role_base_wsp_price', true );

						if ( ! empty( $role_base_wsp_price ) ) {

							foreach ( $role_base_wsp_price as $role_price ) {

								if (isset($role_price['user_role']) && ( 'everyone' == $role_price['user_role'] || 'guest' == $role_price['user_role'] )) {

									if (( $cart_item['quantity'] >= $role_price['min_qty'] && $cart_item['quantity'] <= $role_price['max_qty'] ) 
										|| ( $cart_item['quantity'] >= $role_price['min_qty'] && '' == $role_price['max_qty'] )
										|| ( $cart_item['quantity'] >= $role_price['min_qty'] && 0 == $role_price['max_qty'] ) 
										|| ( '' == $role_price['min_qty'] && $cart_item['quantity'] <= $role_price['max_qty'] ) 
										|| ( 0 == $role_price['min_qty'] && $cart_item['quantity'] <= $role_price['max_qty'] )
									) {


										if ('fixed_price' == $role_price['discount_type'] ) {

											if ( 'incl' === $this->get_tax_price_display_mode() ) {
												$product_priceFix = wc_get_price_including_tax( $product, array(
													'qty' => 1,
													'price' => $role_price['discount_value'],
												) );
											} else {
												$product_priceFix = wc_get_price_excluding_tax( $product, array(
													'qty' => 1,
													'price' => $role_price['discount_value'],
												) );
											}

											$price         = wc_price($product_priceFix);
											$role_discount = true;

										} elseif ('fixed_increase' == $role_price['discount_type'] ) {

											if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

												$newprice = 0;
												$newprice = $newprice + $role_price['discount_value'];
													
													
											} else {

												$newprice = $pro_price + $role_price['discount_value'];
											}


												
											$price         = wc_price($newprice);
											$role_discount = true;

										} elseif ('fixed_decrease' == $role_price['discount_type'] ) {

											if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

												$newprice = 0;
													
													
													
											} else {

												$newprice = $pro_price - $role_price['discount_value'];
											}


												
											$price         = wc_price($newprice);
											$role_discount = true;

										} elseif ('percentage_decrease' == $role_price['discount_type'] ) {


											if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

												$newprice = 0;
																										
											} else {

												$percent_price = $pro_price * $role_price['discount_value'] / 100;

												$newprice = $pro_price - $percent_price;
											}
												

											$price         = wc_price($newprice);
											$role_discount = true;

										} elseif ('percentage_increase' == $role_price['discount_type'] ) {


											if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

												$newprice = 0;
																										
											} else {

												$percent_price = $pro_price * $role_price['discount_value'] / 100;

												$newprice = $pro_price + $percent_price;
											}
												

											$price         = wc_price($newprice);
											$role_discount = true;

										}

									} else {
										$rule_applied_price_not_changed = true;
									}
								}
							}
						}

						// Rules - guest users
						if ( false == $role_discount &&  false == $rule_applied_price_not_changed) {



							if ( empty( $this->allfetchedrules ) ) {

								echo '';

							} else {

								$all_rules = $this->allfetchedrules;

							}

							if ( ! empty( $all_rules ) ) {

								foreach ( $all_rules as $rule ) {


									$istrue = false;

									$applied_on_all_products = get_post_meta( $rule->ID, 'wsp_apply_on_all_products', true );
									$products                = get_post_meta( $rule->ID, 'wsp_applied_on_products', true );
									$categories              = get_post_meta( $rule->ID, 'wsp_applied_on_categories', true );

									if ( 'yes' == $applied_on_all_products ) {
										$istrue = true;
									} elseif ( ! empty( $products ) && ( in_array( $product_id, $products ) || in_array( $parent_id, $products ) ) ) {
										$istrue = true;
									}

									if (!empty($categories)) {
										foreach ( $categories as $cat ) {

											if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $product_id ) ) || ( has_term( $cat, 'product_cat', $parent_id ) ) )) {

												$istrue = true;
											} 
										}
									}

										

									if ( $istrue ) {

										//get rule role base price for guest
										$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

										if ( ! $customer_discount1 ) {

											if ( ! empty( $rule_role_base_wsp_price ) ) {

												foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

													if (isset($rule_role_price['user_role']) && ( 'everyone' == $rule_role_price['user_role'] || 'guest' == $rule_role_price['user_role'] )) {

														if (( $cart_item['quantity'] >= $rule_role_price['min_qty'] && $cart_item['quantity'] <= $rule_role_price['max_qty'] ) 
															|| ( $cart_item['quantity'] >= $rule_role_price['min_qty'] && '' == $rule_role_price['max_qty'] )
															|| ( $cart_item['quantity'] >= $rule_role_price['min_qty'] && 0 == $rule_role_price['max_qty'] ) 
															|| ( '' == $rule_role_price['min_qty'] && $cart_item['quantity'] <= $rule_role_price['max_qty'] ) 
															|| ( 0 == $rule_role_price['min_qty'] && $cart_item['quantity'] <= $rule_role_price['max_qty'] )
														) {

																	

															if ('fixed_price' == $rule_role_price['discount_type'] ) {

																if ( 'incl' === $this->get_tax_price_display_mode() ) {
																	$product_priceFix = wc_get_price_including_tax( $product, array(
																		'qty'   => 1,
																		'price' => $rule_role_price['discount_value'],
																	) );
																} else {
																	$product_priceFix = wc_get_price_excluding_tax( $product, array(
																		'qty'   => 1,
																		'price' => $rule_role_price['discount_value'],
																	) );
																}
																$role_discount = true;
																$price         = wc_price($product_priceFix);

															} elseif ('fixed_increase' == $rule_role_price['discount_type'] ) {

																if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

																	$newprice = 0;
																	$newprice = $newprice + $rule_role_price['discount_value'];
																															
																} else {

																	$newprice = $pro_price + $rule_role_price['discount_value'];
																}

																$role_discount = true;
																$price         = wc_price($newprice);

															} elseif ('fixed_decrease' == $rule_role_price['discount_type'] ) {

																if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

																	$newprice = 0;
																		
																															
																} else {

																	$newprice = $pro_price - $rule_role_price['discount_value'];
																}

																$role_discount = true;  
																$price         = wc_price($newprice);

															} elseif ('percentage_decrease' == $rule_role_price['discount_type'] ) {


																if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

																	$newprice = 0;
																		
																															
																} else {

																	$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

																	$newprice = $pro_price - $percent_price;
																}

																$role_discount = true;

																$price = wc_price($newprice);
 

															} elseif ('percentage_increase' == $rule_role_price['discount_type'] ) {


																if (empty($pro_price) || ( !empty($pro_price) && 0 == $pro_price )) {

																	$newprice = 0;
																		
																															
																} else {

																	$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

																	$newprice = $pro_price + $percent_price;
																}


																$role_discount = true;

																$price = wc_price($newprice);


																	
															}
														} else {
															$rule_applied_price_not_changed = true;
														}
													}
												}
											}
										}
									}

									if ($role_discount || $rule_applied_price_not_changed) {
										break;
									}
								}
							}
						}
					}
					
				}   
			}
			if ( !empty( floatval( $newprice ) ) ) {

				if ( 'incl' == $this->get_tax_price_display_mode() ) {
					$product_price = wc_get_price_including_tax( $product, array(
						'qty'   => 1,
						'price' => $newprice,
					) );
				} else {
					$product_price = wc_get_price_excluding_tax( $product, array(
						'qty'   => 1,
						'price' => $newprice,
					) );
				}

				

				$price = wc_price( $product_price );
			}
			return $price;  
		}

		public function wsp_validate_min_max_qty( $csppdata, $product_id, $qty = 1, $variation_id = 0 ) {

			$user               = wp_get_current_user();
			$role               = ( array ) $user->roles;
			$current_role       = current( $user->roles );
			$quantity           = 0;
			$customer_discount  = false;
			$role_discount      = false;
			$customer_discount1 = false;
			$role_discount1     = false;
			$first_min_qty      = '';
			$max_qty            = '';
			$parent_id          = 0;
			$oqty               = 0;

			

			if ( 0 == $variation_id ) {

				$targeted_id = $product_id;
				$pro_id      = $product_id;

			} else {

				//Variable Product
				$targeted_id = $variation_id;
				$pro_id      = $variation_id;
			}


			//Add to cart via link, if add to cart is hiden
			if ( ! empty( $this->wsp_enable_hide_price_feature ) && 'yes' == $this->wsp_enable_hide_price_feature && 
				'yes' == $this->wsp_hide_cart_button ) {


				// For Guest Users
				if ( ! empty( $this->wsp_enable_for_guest ) && 'yes' == $this->wsp_enable_for_guest ) {

					if ( ! is_user_logged_in() ) {

						if ( ! empty( $this->wsp_hide_products ) ) {

							if ( ( in_array( $pro_id, $this->wsp_hide_products ) || in_array( $product_id, $this->wsp_hide_products ) ) ) {

								$csppdata      = false;
								$error_message = esc_html__('This product can not be added to cart.', 'addify_wholesale_prices');
								$this->wsp_wc_add_notice( $error_message );
								
								return $csppdata;
								
							}
						}


						if ( ! empty( $this->wsp_hide_categories )) {
							foreach ( $this->wsp_hide_categories as $cat ) {
								if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $pro_id ) ) || ( has_term( $cat, 'product_cat', $product_id ) ) )) {
									
									$csppdata      = false;
									$error_message = esc_html__('This product can not be added to cart.', 'addify_wholesale_prices');
									$this->wsp_wc_add_notice( $error_message );
									
									return $csppdata;

								}
							}
						}


					}

				}

				//For registered users
				if ( is_user_logged_in() ) {

						// get Current User Role
						$curr_user      = wp_get_current_user();
						$user_data      = get_user_meta( $curr_user->ID );
						$curr_user_role = $curr_user->roles[0];

					if ( !empty($this->wsp_hide_user_role) && in_array( $curr_user_role, $this->wsp_hide_user_role ) ) {
						if ( ! empty( $this->wsp_hide_products ) ) {

								
							if ( ( in_array( $pro_id, $this->wsp_hide_products ) || in_array( $product_id, $this->wsp_hide_products ) ) ) {

								$csppdata      = false;
								$error_message = esc_html__('This product can not be added to cart.', 'addify_wholesale_prices');
								$this->wsp_wc_add_notice( $error_message );
									
								return $csppdata;
									
							}
						}


						if ( ! empty( $this->wsp_hide_categories )) {
							foreach ( $this->wsp_hide_categories as $cat ) {
								if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $pro_id ) ) || ( has_term( $cat, 'product_cat', $product_id ) ) )) {
										
									$csppdata      = false;
									$error_message = esc_html__('This product can not be added to cart.', 'addify_wholesale_prices');
									$this->wsp_wc_add_notice( $error_message );
										
									return $csppdata;

								}
							}
						}
					}


				}


			}

			foreach ( WC()->cart->get_cart() as $cart_item ) {

				if ( 'variation' === $cart_item['data']->get_type() ) {

					if ( $variation_id === $cart_item['data']->get_id() ) {
						$oqty = $cart_item['quantity'];
						break;
					}
					
				} elseif ( $product_id === $cart_item['data']->get_id() ) {


						$oqty = $cart_item['quantity'];
						break;
				}
			}

			// Displaying the quantity if targeted product is in cart
			if ( ! empty( $oqty ) ) {
				
				$old_qty = $oqty;
			} else {
				$old_qty = 0;
			}
			
			$total_quantity = $old_qty + $qty;


			if ( is_user_logged_in() ) {

				// get customer specifc price
				$cus_base_wsp_price = get_post_meta( $pro_id, '_cus_base_wsp_price', true );

				// get role base price
				$role_base_wsp_price = get_post_meta( $pro_id, '_role_base_wsp_price', true );

				if ( ! empty( $cus_base_wsp_price ) ) {

					$n                = 1;
					$customer_matched = false;
					foreach ( $cus_base_wsp_price as $cus_price ) {
						
						if ( isset( $cus_price['customer_name'] ) && $user->ID == $cus_price['customer_name'] ) {

							$customer_matched = true;
							
							if ( '' != $cus_price['discount_value'] && 0 != $cus_price['discount_value'] ) {

								if ( '' != $cus_price['min_qty'] || 0 != $cus_price['min_qty'] ) {

										$min_qty = intval( $cus_price['min_qty'] );
									if ( 1==$n) {
										$first_min_qty = $min_qty;
										++$n;
									}
										$customer_discount = true;

								} else {
									$first_min_qty = '';
								}

								if ( '' != $cus_price['max_qty']) {
									$max_qty           = intval( $cus_price['max_qty'] );
									$customer_discount = true;
									
								} else {
									$max_qty = '';
								}
							}
						}   
					}

					if ( $customer_matched ) {
						if ( '' != $first_min_qty && $total_quantity < $first_min_qty ) {
							$csppdata      = false;
							$error_message = sprintf( $this->addify_wsp_min_qty_error_msg, $first_min_qty );
							$this->wsp_wc_add_notice( $error_message );
						
							return $csppdata;

						} elseif ( '' != $max_qty && ( 0 != $max_qty && $total_quantity > $max_qty ) ) {

							$csppdata      = false;
							$error_message = sprintf( $this->addify_wsp_max_qty_error_msg, $max_qty );
							$this->wsp_wc_add_notice( $error_message );
						
							return $csppdata;

						} else {
							$customer_discount = true;
							return true;
							
						}
					}
					
				}

				// Role Based Pricing
				// chcek if there is customer specific pricing then role base pricing will not work.
				if ( ! $customer_discount ) {

					if ( ! empty( $role_base_wsp_price ) ) {
						$n = 1;
						foreach ( $role_base_wsp_price as $role_price ) {

							if ( isset( $role_price['user_role'] ) && ( 'everyone' == $role_price['user_role'] ||  $role[0] == $role_price['user_role'] )) {

								if ( '' != $role_price['discount_value'] || 0 != $role_price['discount_value'] ) {

									if ( '' != $role_price['min_qty'] && 0 != $role_price['min_qty'] ) {
											$min_qty = intval( $role_price['min_qty'] );
										if ( 1==$n) {
											$first_min_qty = $min_qty;
											++$n;
										}
											$role_discount = true;

									} else {
										$first_min_qty = '';
									}

									if ( '' != $role_price['max_qty']) {
										$max_qty       = intval( $role_price['max_qty'] );
										$role_discount = true;
										
									} else {
										$max_qty = '';
									}
								}
							}
						}

						if ( '' != $first_min_qty && $total_quantity < $first_min_qty ) {
							$csppdata      = false;
							$error_message = sprintf( $this->addify_wsp_min_qty_error_msg, $first_min_qty );
							$this->wsp_wc_add_notice( $error_message );
							
							return $csppdata;

						} elseif ( '' != $max_qty && 0 != $max_qty && $total_quantity > $max_qty ) {

							$csppdata      = false;
							$error_message = sprintf( $this->addify_wsp_max_qty_error_msg, $max_qty );
							$this->wsp_wc_add_notice( $error_message );
							
							return $csppdata;

						} else {

							$customer_discount = true;
							return true;
							
						}

						
					}

					   
				}


				//Rules
				if ( false == $customer_discount && false == $role_discount ) {

					if ( empty( $this->allfetchedrules ) ) {

						echo '';

					} else {

						$all_rules = $this->allfetchedrules;

					}


					if ( ! empty( $all_rules ) ) {
						foreach ( $all_rules as $rule ) {

							$istrue = false;

							$applied_on_all_products = get_post_meta( $rule->ID, 'wsp_apply_on_all_products', true );
							$products                = get_post_meta( $rule->ID, 'wsp_applied_on_products', true );
							$categories              = get_post_meta( $rule->ID, 'wsp_applied_on_categories', true );

							if ( 'yes' == $applied_on_all_products ) {
								$istrue = true;
							} elseif ( ! empty( $products ) && ( in_array( $pro_id, $products ) || in_array( $product_id, $products ) ) ) {
								$istrue = true;
							}

							if (!empty($categories)) {
								foreach ( $categories as $cat ) {

									if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $pro_id ) ) || ( has_term( $cat, 'product_cat', $product_id ) ) )) {

										$istrue = true;
									} 
								}
							}

							

							if ( $istrue ) {

							

								// get Rule customer specifc price
								$rule_cus_base_wsp_price = get_post_meta( $rule->ID, 'rcus_base_wsp_price', true );

								// get role base price
								$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );


								if ( ! empty( $rule_cus_base_wsp_price ) ) {
									$n = 1;
									foreach ( $rule_cus_base_wsp_price as $rule_cus_price ) {

										if ( $user->ID == $rule_cus_price['customer_name'] ) {

											if ( '' != $rule_cus_price['discount_value'] || 0 != $rule_cus_price['discount_value'] ) {

												if ( '' != $rule_cus_price['min_qty'] && 0 != $rule_cus_price['min_qty'] ) {
													$min_qty = intval( $rule_cus_price['min_qty'] );

													if ( 1==$n) {
														$first_min_qty = $min_qty;
														++$n;
													}

													$customer_discount1 = true;
												} else {
													$first_min_qty = '';
												}

												if ( '' != $rule_cus_price['max_qty'] ) {
															$max_qty            = intval( $rule_cus_price['max_qty'] );
															$customer_discount1 = true;
												} else {
													$max_qty = '';
												}
												
											}
										}
									}

									if ( '' != $first_min_qty && $total_quantity < $first_min_qty ) {
											$csppdata      = false;
											$error_message = sprintf( $this->addify_wsp_min_qty_error_msg, $first_min_qty );
											$this->wsp_wc_add_notice( $error_message );
											return $csppdata;

									} elseif ( '' != $max_qty && 0 != $max_qty && $total_quantity > $max_qty ) {

										$csppdata      = false;
										$error_message = sprintf( $this->addify_wsp_max_qty_error_msg, $max_qty );
										$this->wsp_wc_add_notice( $error_message );
										return $csppdata;

									} else {
										$customer_discount1 = false;
										return true;
									}
								}

								// Role Based Pricing
								// chcek if there is customer specific pricing then role base pricing will not work.
								if ( ! $customer_discount1 ) {

									
									if ( ! empty( $rule_role_base_wsp_price ) ) {
										$n = 1;
										foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

											if ( 'everyone' == $rule_role_price['user_role'] || $role[0] == $rule_role_price['user_role'] ) {

												if ( '' != $rule_role_price['discount_value'] || 0 != $rule_role_price['discount_value'] ) {

													if ( '' != $rule_role_price['min_qty'] || 0 != $rule_role_price['min_qty'] ) {
														$min_qty = intval( $rule_role_price['min_qty'] );

														if ( 1==$n) {
															$first_min_qty = $min_qty;
															++$n;
														}

													} else {
														$first_min_qty = '';
													}

													if ( '' != $rule_role_price['max_qty']  ) {
																$max_qty = intval( $rule_role_price['max_qty'] );
													} else {
														$max_qty = '';
													}
													
												}
											}
										}

										if ( '' != $first_min_qty && $total_quantity < $first_min_qty ) {
												$csppdata      = false;
												$error_message = sprintf( $this->addify_wsp_min_qty_error_msg, $first_min_qty );
												$this->wsp_wc_add_notice( $error_message );
												return $csppdata;

										} elseif ( '' != $max_qty && 0 != $max_qty && $total_quantity > $max_qty ) {

											$csppdata      = false;
											$error_message = sprintf( $this->addify_wsp_max_qty_error_msg, $max_qty );
											$this->wsp_wc_add_notice( $error_message );
											return $csppdata;

										} else {
											return true;
										}
									}
								}
							}
						}
					}
				}

			} elseif ( !is_user_logged_in()) {

				//guest
				



					// get role base price
					$role_base_wsp_price = get_post_meta( $pro_id, '_role_base_wsp_price', true );

					// Role Based Pricing
					// chcek if there is customer specific pricing then role base pricing will not work.
				if ( true ) {

					if ( ! empty( $role_base_wsp_price ) ) {
						$n = 1;
						foreach ( $role_base_wsp_price as $role_price ) {

								
							if ( isset( $role_price['user_role'] ) && ( 'everyone' == $role_price['user_role'] || 'guest' == $role_price['user_role'] )) {

								if ( '' != $role_price['discount_value'] || 0 != $role_price['discount_value'] ) {

									if ( '' != $role_price['min_qty'] || 0 != $role_price['min_qty'] ) {
											$min_qty = intval( $role_price['min_qty'] );
										if ( 1==$n) {
											$first_min_qty = $min_qty;
											++$n;
										}
											$role_discount1 = true;

									} else {
										$first_min_qty = '';
									}

									if ( '' != $role_price['max_qty']  ) {
										$max_qty        = intval( $role_price['max_qty'] );
										$role_discount1 = true;
											
									} else {
										$max_qty = '';
									}
								}
							}
						}

						if ( '' != $first_min_qty && $total_quantity < $first_min_qty ) {
							$csppdata      = false;
							$error_message = sprintf( $this->addify_wsp_min_qty_error_msg, $first_min_qty );
							$this->wsp_wc_add_notice( $error_message );
								
							return $csppdata;

						} elseif ( '' != $max_qty && 0 != $max_qty && $total_quantity > $max_qty ) {

							$csppdata      = false;
							$error_message = sprintf( $this->addify_wsp_max_qty_error_msg, $max_qty );
							$this->wsp_wc_add_notice( $error_message );
								
							return $csppdata;

						} else {
							$role_discount1 = false;
							return true;
								
						}

							
					}
					


					// Rules - guest users
					if ( false == $role_discount1 ) {

						if ( empty( $this->allfetchedrules ) ) {

							echo '';

						} else {

							$all_rules = $this->allfetchedrules;

						}

						if ( ! empty( $all_rules ) ) {
							foreach ( $all_rules as $rule ) {

								$istrue = false;

								$applied_on_all_products = get_post_meta( $rule->ID, 'wsp_apply_on_all_products', true );
								$products                = get_post_meta( $rule->ID, 'wsp_applied_on_products', true );
								$categories              = get_post_meta( $rule->ID, 'wsp_applied_on_categories', true );

								if ( 'yes' == $applied_on_all_products ) {
									$istrue = true;
								} elseif ( ! empty( $products ) && ( in_array( $pro_id, $products ) || in_array( $product_id, $products ) ) ) {
									$istrue = true;
								}

								if (!empty($categories)) {
									foreach ( $categories as $cat ) {

										if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $pro_id ) ) || ( has_term( $cat, 'product_cat', $product_id ) ) ) ) {

											$istrue = true;
										} 
									}
								}

									


								if ( $istrue ) {

									// get role base price
									$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

										

									// Role Based Pricing
									// chcek if there is customer specific pricing then role base pricing will not work.
									if ( true ) {

										if ( ! empty( $rule_role_base_wsp_price ) ) {
											$n = 1;
											foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

												if ('everyone' == $rule_role_price['user_role'] || 'guest' == $rule_role_price['user_role'] ) {

													if ( '' != $rule_role_price['discount_value'] || 0 != $rule_role_price['discount_value'] ) {

														if ( '' != $rule_role_price['min_qty'] || 0 != $rule_role_price['min_qty'] ) {
															$min_qty = intval( $rule_role_price['min_qty'] );

															if ( 1==$n) {
																$first_min_qty = $min_qty;
																++$n;
															}

														} else {
															$first_min_qty = '';
														}

														if ( '' != $rule_role_price['max_qty'] ) {
																	$max_qty = intval( $rule_role_price['max_qty'] );
														} else {
															$max_qty = '';
														}
															
													}
												}
											}

											if ( '' != $first_min_qty && $total_quantity < $first_min_qty ) {
													$csppdata      = false;
													$error_message = sprintf( $this->addify_wsp_min_qty_error_msg, $first_min_qty );
													$this->wsp_wc_add_notice( $error_message );
													return $csppdata;

											} elseif ( '' != $max_qty && 0 != $max_qty &&$old_qty + $qty > $max_qty ) {

												$csppdata      = false;
												$error_message = sprintf( $this->addify_wsp_max_qty_error_msg, $max_qty );
												$this->wsp_wc_add_notice( $error_message );
												return $csppdata;

											} else {
												return true;
											}
										}
									}
								}
							}
						}
					}
				}
				
			}

			return $csppdata;
		}

		public function wsp_update_cart_quantity_validation( $passed, $cart_item_key, $values, $qty ) {

			$user               = wp_get_current_user();
			$role               = ( array ) $user->roles;
			$current_role       = current( $user->roles );
			$quantity           = 0;
			$customer_discount  = false;
			$role_discount      = false;
			$customer_discount1 = false;
			$role_discount1     = false;

			if ( 0 == $values['variation_id'] ) {

				$product_id = $values['product_id'];
				$parent_id  = 0;
			} else {

				$product_id = $values['variation_id'];
				$parent_id  = $values['product_id'];

			}

			$pro = wc_get_product( $product_id );

			if ( is_user_logged_in() ) {

				// get customer specifc price
				$cus_base_wsp_price = get_post_meta( $product_id, '_cus_base_wsp_price', true );

				// get role base price
				$role_base_wsp_price = get_post_meta( $product_id, '_role_base_wsp_price', true );

				if ( ! empty( $cus_base_wsp_price ) ) {
					$n = 1;
					foreach ( $cus_base_wsp_price as $cus_price ) {

						if ( isset( $cus_price['customer_name'] ) && $user->ID == $cus_price['customer_name'] ) {

							if ( '' != $cus_price['discount_value'] || 0 != $cus_price['discount_value'] ) {

								if ( '' != $cus_price['min_qty'] || 0 != $cus_price['min_qty'] ) {
										$min_qty = intval( $cus_price['min_qty'] );
									if ( 1==$n) {
										$first_min_qty = $min_qty;
										++$n;
									}
										$customer_discount = true;
								} else {
										$min_qty = '';
								}

								if ( '' != $cus_price['max_qty'] || 0 != $cus_price['max_qty'] ) {
									$max_qty           = intval( $cus_price['max_qty'] );
									$customer_discount = true;
								} else {
									$max_qty = '';
								}

								
							}
						}
					}

					if ( ( '' != $first_min_qty && $qty < $first_min_qty ) || ( '' != $max_qty && $qty > $max_qty ) ) {
						$passed        = false;
						$arr           = array(
							'%pro' => $pro->get_title(),
							'%min' => $first_min_qty,
							'%max' => $max_qty,
						);
						$word          = $this->addify_wsp_update_cart_error_msg;
						$error_message = strtr( $word, $arr );

						$this->wsp_wc_add_notice( $error_message );
						return $passed;

					} else {
						$customer_discount = false;
					}
				}


				// Role Based Pricing
				// chcek if there is customer specific pricing then role base pricing will not work.
				if ( !$customer_discount ) {

					if ( ! empty( $role_base_wsp_price ) ) {
						$n = 1;
						foreach ( $role_base_wsp_price as $role_price ) {

							if ( isset( $role_price['user_role'] ) && ( 'everyone' == $role_price['user_role'] ||  $role[0] == $role_price['user_role'] )) {

								if ( '' != $role_price['discount_value'] || 0 != $role_price['discount_value'] ) {

									if ( '' != $role_price['min_qty'] || 0 != $role_price['min_qty'] ) {
											$min_qty = intval( $role_price['min_qty'] );
										if ( 1==$n) {
											$first_min_qty = $min_qty;
											++$n;
										}
											$role_discount = true;
									} else {
											$min_qty = '';
									}

									if ( '' != $role_price['max_qty'] || 0 != $role_price['max_qty'] ) {
										$max_qty       = intval( $role_price['max_qty'] );
										$role_discount = true;
									} else {
										$max_qty = '';
									}

									
								}
							}
						}

						if ( ( '' != $first_min_qty && $qty < $first_min_qty ) || ( '' != $max_qty && $qty > $max_qty ) ) {
							$passed        = false;
							$arr           = array(
								'%pro' => $pro->get_title(),
								'%min' => $first_min_qty,
								'%max' => $max_qty,
							);
							$word          = $this->addify_wsp_update_cart_error_msg;
							$error_message = strtr( $word, $arr );

							$this->wsp_wc_add_notice( $error_message );
							return $passed;

						} else {
							$role_discount = false;
						}
					}
					   
				}

				//Rules
				if ( false == $customer_discount && false == $role_discount ) {

					if ( empty( $this->allfetchedrules ) ) {

						echo '';

					} else {

						$all_rules = $this->allfetchedrules;

					}

					if ( ! empty( $all_rules ) ) {

						foreach ( $all_rules as $rule ) {

							$istrue = false;

							


							$applied_on_all_products = get_post_meta( $rule->ID, 'wsp_apply_on_all_products', true );
							$products                = get_post_meta( $rule->ID, 'wsp_applied_on_products', true );
							$categories              = get_post_meta( $rule->ID, 'wsp_applied_on_categories', true );

							if ( 'yes' == $applied_on_all_products ) {
								$istrue = true;
							} elseif ( ! empty( $products ) && ( in_array( $product_id, $products ) || in_array( $parent_id, $products ) ) ) {
								$istrue = true;
							}

							if (!empty($categories)) {
								foreach ( $categories as $cat ) {

									if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $product_id ) ) || ( has_term( $cat, 'product_cat', $parent_id ) ) ) ) {

										$istrue = true;
									} 
								}
							}

							


							if ($istrue) {


								// get Rule customer specifc price
								$rule_cus_base_wsp_price = get_post_meta( $rule->ID, 'rcus_base_wsp_price', true );

								// get role base price
								$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );


								if ( ! empty( $rule_cus_base_wsp_price ) ) {
									$n =1;
									foreach ( $rule_cus_base_wsp_price as $rule_cus_price ) {

										if ( $user->ID == $rule_cus_price['customer_name'] ) {

											if ( '' != $rule_cus_price['discount_value'] || 0 != $rule_cus_price['discount_value'] ) {

												if ( '' != $rule_cus_price['min_qty'] || 0 != $rule_cus_price['min_qty'] ) {
													$min_qty = intval( $rule_cus_price['min_qty'] );
													if ( 1==$n) {
														$first_min_qty = $min_qty;
														++$n;
													}
													$customer_discount1 = true;
												} else {
													$min_qty = '';
												}

												if ( '' != $rule_cus_price['max_qty'] || 0 != $rule_cus_price['max_qty'] ) {
													$max_qty            = intval( $rule_cus_price['max_qty'] );
													$customer_discount1 = true;
												} else {
														$max_qty = '';
												}

												
											}
										}
									}


									if ( ( '' != $first_min_qty && $qty < $first_min_qty ) || ( '' != $max_qty && $qty > $max_qty ) ) {
												$passed                            = false;
												$arr                               = array(
													'%pro' => $pro->get_title(),
													'%min' => $first_min_qty,
													'%max' => $max_qty,
												);
																	$word          = $this->addify_wsp_update_cart_error_msg;
																	$error_message = strtr( $word, $arr );

																	$this->wsp_wc_add_notice( $error_message );
																	return $passed;

									} else {
										$customer_discount1 = false;
									}
								}

								// Role Based Pricing
								// chcek if there is customer specific pricing then role base pricing will not work.
								if ( !$customer_discount1 ) {

									
									if ( ! empty( $rule_role_base_wsp_price ) ) {
										$n =1;
										foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

											if ( 'everyone' == $rule_role_price['user_role'] ||  $role[0] == $rule_role_price['user_role'] ) {

												if ( '' != $rule_role_price['discount_value'] || 0 != $rule_role_price['discount_value'] ) {

													if ( '' != $rule_role_price['min_qty'] || 0 != $rule_role_price['min_qty'] ) {
														$min_qty = intval( $rule_role_price['min_qty'] );
														if ( 1==$n) {
															$first_min_qty = $min_qty;
															++$n;
														}
													} else {
														$min_qty = '';
													}

													if ( '' != $rule_role_price['max_qty'] || 0 != $rule_role_price['max_qty'] ) {
														$max_qty = intval( $rule_role_price['max_qty'] );
													} else {
															$max_qty = '';
													}

													
												}
											}
										}


										if ( ( '' != $first_min_qty && $qty < $first_min_qty ) || ( '' != $max_qty && $qty > $max_qty ) ) {
													$passed                            = false;
													$arr                               = array(
														'%pro' => $pro->get_title(),
														'%min' => $first_min_qty,
														'%max' => $max_qty,
													);
																		$word          = $this->addify_wsp_update_cart_error_msg;
																		$error_message = strtr( $word, $arr );

																		$this->wsp_wc_add_notice( $error_message );
																		return $passed;

										} else {
											return $passed;
										}
									}
								}
							}
						}
					}

				}

			} elseif ( !is_user_logged_in() ) {

				//Guest
				


					// get role base price
					$role_base_wsp_price = get_post_meta( $product_id, '_role_base_wsp_price', true );

					// Role Based Pricing
					// chcek if there is customer specific pricing then role base pricing will not work.
				if ( true ) {

					if ( ! empty( $role_base_wsp_price ) ) {
						$n = 1;
						foreach ( $role_base_wsp_price as $role_price ) {

							if ( isset( $role_price['user_role'] ) && ( 'everyone' == $role_price['user_role'] || 'guest' == $role_price['user_role'] )) {

								if ( '' != $role_price['discount_value'] || 0 != $role_price['discount_value'] ) {

									if ( '' != $role_price['min_qty'] || 0 != $role_price['min_qty'] ) {
											$min_qty = intval( $role_price['min_qty'] );
										if ( 1==$n) {
											$first_min_qty = $min_qty;
											++$n;
										}
											$role_discount = true;
									} else {
											$min_qty = '';
									}

									if ( '' != $role_price['max_qty'] || 0 != $role_price['max_qty'] ) {
										$max_qty       = intval( $role_price['max_qty'] );
										$role_discount = true;
									} else {
										$max_qty = '';
									}
								}
							}
						}

						if ( ( '' != $first_min_qty && $qty < $first_min_qty ) || ( '' != $max_qty && $qty > $max_qty ) ) {
							$passed        = false;
							$arr           = array(
								'%pro' => $pro->get_title(),
								'%min' => $first_min_qty,
								'%max' => $max_qty,
							);
							$word          = $this->addify_wsp_update_cart_error_msg;
							$error_message = strtr( $word, $arr );

							$this->wsp_wc_add_notice( $error_message );
							return $passed;

						} else {
							$role_discount = false;
						}
					}
				}


				if ( !$role_discount ) {

					if ( empty( $this->allfetchedrules ) ) {

						echo '';

					} else {

						$all_rules = $this->allfetchedrules;

					}

					if ( ! empty( $all_rules ) ) {
						foreach ( $all_rules as $rule ) {

							$istrue = false;

							$applied_on_all_products = get_post_meta( $rule->ID, 'wsp_apply_on_all_products', true );
							$products                = get_post_meta( $rule->ID, 'wsp_applied_on_products', true );
							$categories              = get_post_meta( $rule->ID, 'wsp_applied_on_categories', true );

							if ( 'yes' == $applied_on_all_products ) {
								$istrue = true;
							} elseif ( ! empty( $products ) && ( in_array( $product_id, $products ) || in_array( $parent_id, $products ) ) ) {
								$istrue = true;
							}

							if (!empty($categories)) {
								foreach ( $categories as $cat ) {

									if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $product_id ) ) || ( has_term( $cat, 'product_cat', $parent_id ) ) ) ) {

										$istrue = true;
									} 
								}
							}

								


							if ( $istrue ) {

								// get role base price
								$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

								// Role Based Pricing
								// chcek if there is customer specific pricing then role base pricing will not work.
								if ( true ) {

										
									if ( ! empty( $rule_role_base_wsp_price ) ) {
										$n =1;
										foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

											if ( 'everyone' == $rule_role_price['user_role'] || 'guest' == $rule_role_price['user_role'] ) {

												if ( '' != $rule_role_price['discount_value'] || 0 != $rule_role_price['discount_value'] ) {

													if ( '' != $rule_role_price['min_qty'] || 0 != $rule_role_price['min_qty'] ) {
														$min_qty = intval( $rule_role_price['min_qty'] );
														if ( 1==$n) {
															$first_min_qty = $min_qty;
															++$n;
														}
													} else {
														$min_qty = '';
													}

													if ( '' != $rule_role_price['max_qty'] || 0 != $rule_role_price['max_qty'] ) {
														$max_qty = intval( $rule_role_price['max_qty'] );
													} else {
															$max_qty = '';
													}

														
												}
											}
										}


										if ( ( '' != $first_min_qty && $qty < $first_min_qty ) || ( '' != $max_qty && $qty > $max_qty ) ) {
													$passed                            = false;
													$arr                               = array(
														'%pro' => $pro->get_title(),
														'%min' => $first_min_qty,
														'%max' => $max_qty,
													);
																		$word          = $this->addify_wsp_update_cart_error_msg;
																		$error_message = strtr( $word, $arr );

																		$this->wsp_wc_add_notice( $error_message );
																		return $passed;

										} else {
											return $passed;
										}
									}
								}
							}
						}
					}
				}
				
			}
			

			return $passed;
		}

		public function wsp_update_cart_quantity_validation_block_minimum( $value, $product, $cart_item ) {
			
			if (empty($cart_item)) {
				return;               
			}

			$user               = wp_get_current_user();
			$role               = ( array ) $user->roles;
			$current_role       = current( $user->roles );
			$quantity           = 0;
			$customer_discount  = false;
			$role_discount      = false;
			$customer_discount1 = false;
			$role_discount1     = false;
			$customer_matched   = false;
			// $first_min_qty = '';
			// $max_qty = '';

			if ( isset( $cart_item['variation_id'] ) && 0 != $cart_item['variation_id'] ) {
				$product_id = $cart_item['variation_id'];
				$parent_id  = $cart_item['product_id'];
				
			} else {
				$product_id = $cart_item['product_id'];
				$parent_id  = 0;
			}

			$qty = isset( $cart_item['quantity'] ) ? $cart_item['quantity'] : 1;

			$pro = wc_get_product( $product_id );

			if ( is_user_logged_in() ) {

				// get customer specifc price
				$cus_base_wsp_price = get_post_meta( $product_id, '_cus_base_wsp_price', true );

				// get role base price
				$role_base_wsp_price = get_post_meta( $product_id, '_role_base_wsp_price', true );
				if ( ! empty( $cus_base_wsp_price ) ) {
					$n = 1;
					foreach ( $cus_base_wsp_price as $cus_price ) {

						if ( isset( $cus_price['customer_name'] ) && $user->ID == $cus_price['customer_name'] ) {

							$customer_matched = true;

							if ( '' != $cus_price['discount_value'] || 0 != $cus_price['discount_value'] ) {

								if ( '' != $cus_price['min_qty'] || 0 != $cus_price['min_qty'] ) {
										$min_qty = intval( $cus_price['min_qty'] );
									if ( 1==$n) {
										$first_min_qty = $min_qty;
										++$n;
									}
										$customer_discount = true;
								} else {
										$first_min_qty = '';
								}

								if ( '' != $cus_price['max_qty'] || 0 != $cus_price['max_qty'] ) {
									$max_qty           = intval( $cus_price['max_qty'] );
									$customer_discount = true;
								} else {
									$max_qty = '';
								}

								
							}
						}
					}

					if ($customer_matched) {
						if ( ( '' != $first_min_qty && $qty < $first_min_qty ) || ( '' != $max_qty && $qty > $max_qty ) ) {
							$value         = false;
							$arr           = array(
								'%pro' => $pro->get_title(),
								'%min' => $first_min_qty,
								'%max' => $max_qty,
							);
							$word          = $this->addify_wsp_update_cart_error_msg;
							$error_message = strtr( $word, $arr );

							$this->wsp_wc_add_notice( $error_message );
							if (!empty($first_min_qty)) {
								return $first_min_qty;
							}

						} 
					}
				}

				// Role Based Pricing
				// chcek if there is customer specific pricing then role base pricing will not work.
				if ( !$customer_discount ) {

					if ( ! empty( $role_base_wsp_price ) ) {
						$rule_matched = false;
						$n            = 1;
						foreach ( $role_base_wsp_price as $role_price ) {

							if ( isset( $role_price['user_role'] ) && ( 'everyone' == $role_price['user_role'] ||  $role[0] == $role_price['user_role'] )) {

								if ( '' != $role_price['discount_value'] || 0 != $role_price['discount_value'] ) {

									$rule_matched = true;

									if ( '' != $role_price['min_qty'] || 0 != $role_price['min_qty'] ) {
											$min_qty = intval( $role_price['min_qty'] );
										if ( 1==$n) {
											$first_min_qty = $min_qty;
											++$n;
										}
											$role_discount = true;
									} else {
											$min_qty = '';
									}

									if ( '' != $role_price['max_qty'] || 0 != $role_price['max_qty'] ) {
										$max_qty       = intval( $role_price['max_qty'] );
										$role_discount = true;
									} else {
										$max_qty = '';
									}

									
								}
							}
						}
						if ($rule_matched) {
							if ( ( '' != $first_min_qty && $qty < $first_min_qty ) || ( '' != $max_qty && $qty > $max_qty ) ) {
								$value         = false;
								$arr           = array(
									'%pro' => $pro->get_title(),
									'%min' => $first_min_qty,
									'%max' => $max_qty,
								);
								$word          = $this->addify_wsp_update_cart_error_msg;
								$error_message = strtr( $word, $arr );

								$this->wsp_wc_add_notice( $error_message );
								if ($first_min_qty) {
									return $first_min_qty;
								}
							} else {
								$role_discount = true;
							}
						} else {
							$role_discount = false;
						}
					}
					   
				}

				//Rules
				if ( false == $customer_discount && false == $role_discount ) {

					if ( empty( $this->allfetchedrules ) ) {

						echo '';

					} else {

						$all_rules = $this->allfetchedrules;

					}

					if ( ! empty( $all_rules ) ) {

						foreach ( $all_rules as $rule ) {

							$istrue = false;

							


							$applied_on_all_products = get_post_meta( $rule->ID, 'wsp_apply_on_all_products', true );
							$products                = get_post_meta( $rule->ID, 'wsp_applied_on_products', true );
							$categories              = get_post_meta( $rule->ID, 'wsp_applied_on_categories', true );

							if ( 'yes' == $applied_on_all_products ) {
								$istrue = true;
							} elseif ( ! empty( $products ) && ( in_array( $product_id, $products ) || in_array( $parent_id, $products ) ) ) {
								$istrue = true;
							}

							if (!empty($categories)) {
								foreach ( $categories as $cat ) {

									if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $product_id ) ) || ( has_term( $cat, 'product_cat', $parent_id ) ) ) ) {

										$istrue = true;
									} 
								}
							}

							


							if ($istrue) {


								// get Rule customer specifc price
								$rule_cus_base_wsp_price = get_post_meta( $rule->ID, 'rcus_base_wsp_price', true );

								// get role base price
								$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

								$customer_matched = true;

								if ( ! empty( $rule_cus_base_wsp_price ) ) {
									$n =1;
									foreach ( $rule_cus_base_wsp_price as $rule_cus_price ) {

										if ( $user->ID == $rule_cus_price['customer_name'] ) {

											$customer_matched = true;

											if ( '' != $rule_cus_price['discount_value'] || 0 != $rule_cus_price['discount_value'] ) {

												if ( '' != $rule_cus_price['min_qty'] || 0 != $rule_cus_price['min_qty'] ) {
													$min_qty = intval( $rule_cus_price['min_qty'] );
													if ( 1==$n) {
														$first_min_qty = $min_qty;
														++$n;
													}
													$customer_discount1 = true;
												} else {
													$min_qty = '';
												}

												if ( '' != $rule_cus_price['max_qty'] || 0 != $rule_cus_price['max_qty'] ) {
													$max_qty            = intval( $rule_cus_price['max_qty'] );
													$customer_discount1 = true;
												} else {
														$max_qty = '';
												}

												
											}
										}
									}

									if ($customer_matched) {
										if ( ( '' != $first_min_qty && $qty < $first_min_qty ) ) {
													$value                             = false;
													$arr                               = array(
														'%pro' => $pro->get_title(),
														'%min' => $first_min_qty,
														'%max' => $max_qty,
													);
																		$word          = $this->addify_wsp_update_cart_error_msg;
																		$error_message = strtr( $word, $arr );

																		$this->wsp_wc_add_notice( $error_message );
													if (!empty($first_min_qty)) {
														return $first_min_qty;
													}

										} else {
											$customer_discount1 = true;
										}
									} else {
										$customer_discount1 = false;
									}
								}

								// Role Based Pricing
								// chcek if there is customer specific pricing then role base pricing will not work.
								if ( !$customer_discount1 ) {

									
									if ( ! empty( $rule_role_base_wsp_price ) ) {
										$n =1;
										foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

											if ( 'everyone' == $rule_role_price['user_role'] ||  $role[0] == $rule_role_price['user_role'] ) {

												if ( '' != $rule_role_price['discount_value'] || 0 != $rule_role_price['discount_value'] ) {

													if ( '' != $rule_role_price['min_qty'] || 0 != $rule_role_price['min_qty'] ) {
														$min_qty = intval( $rule_role_price['min_qty'] );
														if ( 1==$n) {
															$first_min_qty = $min_qty;
															++$n;
														}
													} else {
														$min_qty = '';
													}

													if ( '' != $rule_role_price['max_qty'] || 0 != $rule_role_price['max_qty'] ) {
														$max_qty = intval( $rule_role_price['max_qty'] );
													} else {
															$max_qty = '';
													}

													
												}
											}
										}

										if ( ( '' != $first_min_qty && $qty < $first_min_qty ) || ( '' != $max_qty && $qty > $max_qty ) ) {
													$value                             = false;
													$arr                               = array(
														'%pro' => $pro->get_title(),
														'%min' => $first_min_qty,
														'%max' => $max_qty,
													);
																		$word          = $this->addify_wsp_update_cart_error_msg;
																		$error_message = strtr( $word, $arr );

																		$this->wsp_wc_add_notice( $error_message );
													if (!empty($first_min_qty) ) {
														return $first_min_qty;
													}

										}
									}
								}
							}
						}
					}

				}

			} elseif ( !is_user_logged_in() ) {

				//Guest
				


					// get role base price
					$role_base_wsp_price = get_post_meta( $product_id, '_role_base_wsp_price', true );

					// Role Based Pricing
					// chcek if there is customer specific pricing then role base pricing will not work.
				if ( true ) {

					if ( ! empty( $role_base_wsp_price ) ) {
						$n = 1;
						foreach ( $role_base_wsp_price as $role_price ) {

							if ( isset( $role_price['user_role'] ) && ( 'everyone' == $role_price['user_role'] || 'guest' == $role_price['user_role'] )) {

								if ( '' != $role_price['discount_value'] || 0 != $role_price['discount_value'] ) {

									if ( '' != $role_price['min_qty'] || 0 != $role_price['min_qty'] ) {
											$min_qty = intval( $role_price['min_qty'] );
										if ( 1==$n) {
											$first_min_qty = $min_qty;
											++$n;
										}
											$role_discount = true;
									} else {
											$min_qty = '';
									}

									if ( '' != $role_price['max_qty'] || 0 != $role_price['max_qty'] ) {
										$max_qty       = intval( $role_price['max_qty'] );
										$role_discount = true;
									} else {
										$max_qty = '';
									}
								}
							}
						}

						if ( ( '' != $first_min_qty && $qty < $first_min_qty ) || ( '' != $max_qty && $qty > $max_qty ) ) {
							$value         = false;
							$arr           = array(
								'%pro' => $pro->get_title(),
								'%min' => $first_min_qty,
								'%max' => $max_qty,
							);
							$word          = $this->addify_wsp_update_cart_error_msg;
							$error_message = strtr( $word, $arr );

							$this->wsp_wc_add_notice( $error_message );
							if (!empty($first_min_qty)) {
								return $first_min_qty;
							}

						} else {
							$role_discount = false;
						}
					}
				}


				if ( !$role_discount ) {

					if ( empty( $this->allfetchedrules ) ) {

						echo '';

					} else {

						$all_rules = $this->allfetchedrules;

					}

					if ( ! empty( $all_rules ) ) {
						foreach ( $all_rules as $rule ) {

							$istrue = false;

							$applied_on_all_products = get_post_meta( $rule->ID, 'wsp_apply_on_all_products', true );
							$products                = get_post_meta( $rule->ID, 'wsp_applied_on_products', true );
							$categories              = get_post_meta( $rule->ID, 'wsp_applied_on_categories', true );

							if ( 'yes' == $applied_on_all_products ) {
								$istrue = true;
							} elseif ( ! empty( $products ) && ( in_array( $product_id, $products ) || in_array( $parent_id, $products ) ) ) {
								$istrue = true;
							}

							if (!empty($categories)) {
								foreach ( $categories as $cat ) {

									if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $product_id ) ) || ( has_term( $cat, 'product_cat', $parent_id ) ) ) ) {

										$istrue = true;
									} 
								}
							}

								


							if ( $istrue ) {

								// get role base price
								$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

								// Role Based Pricing
								// chcek if there is customer specific pricing then role base pricing will not work.
								if ( true ) {

										
									if ( ! empty( $rule_role_base_wsp_price ) ) {
										$n =1;
										foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

											if ( 'everyone' == $rule_role_price['user_role'] || 'guest' == $rule_role_price['user_role'] ) {

												if ( '' != $rule_role_price['discount_value'] || 0 != $rule_role_price['discount_value'] ) {

													if ( '' != $rule_role_price['min_qty'] || 0 != $rule_role_price['min_qty'] ) {
														$min_qty = intval( $rule_role_price['min_qty'] );
														if ( 1==$n) {
															$first_min_qty = $min_qty;
															++$n;
														}
													} else {
														$min_qty = '';
													}

													if ( '' != $rule_role_price['max_qty'] || 0 != $rule_role_price['max_qty'] ) {
														$max_qty = intval( $rule_role_price['max_qty'] );
													} else {
															$max_qty = '';
													}

														
												}
											}
										}


										if ( ( '' != $first_min_qty && $qty < $first_min_qty ) || ( '' != $max_qty && $qty > $max_qty ) ) {
													$value                             = false;
													$arr                               = array(
														'%pro' => $pro->get_title(),
														'%min' => $first_min_qty,
														'%max' => $max_qty,
													);
																		$word          = $this->addify_wsp_update_cart_error_msg;
																		$error_message = strtr( $word, $arr );

																		$this->wsp_wc_add_notice( $error_message );
													if (!empty($first_min_qty)) {
								return $first_min_qty;
													}

										} else {
											return $value;
										}
									
									}
								}
							}
						}
					}
				}
				
			}

			return $value;
		}

		public function wsp_update_cart_quantity_validation_block_maximum( $value, $product, $cart_item ) {

			if (!empty($cart_item)) {
		
			 

			$user               = wp_get_current_user();
			$role               = ( array ) $user->roles;
			$current_role       = current( $user->roles );
			$quantity           = 0;
			$customer_discount  = false;
			$role_discount      = false;
			$customer_discount1 = false;
			$role_discount1     = false;
			$customer_matched   = false;

				if ( isset( $cart_item['variation_id'] ) && 0 != $cart_item['variation_id'] ) {
					$product_id = $cart_item['variation_id'];
					$parent_id  = $cart_item['product_id'];
			
				} else {
					$product_id = $cart_item['product_id'];
					$parent_id  = 0;
				}
			$qty = isset( $cart_item['quantity'] ) ? $cart_item['quantity'] : 1;

			$pro = wc_get_product( $product_id );

				if ( is_user_logged_in() ) {

					// get customer specifc price
					$cus_base_wsp_price = get_post_meta( $product_id, '_cus_base_wsp_price', true );

					// get role base price
					$role_base_wsp_price = get_post_meta( $product_id, '_role_base_wsp_price', true );

					if ( ! empty( $cus_base_wsp_price ) ) {
						$n = 1;
						foreach ( $cus_base_wsp_price as $cus_price ) {

							if ( isset( $cus_price['customer_name'] ) && $user->ID == $cus_price['customer_name'] ) {

								$customer_matched = true;

								if ( '' != $cus_price['discount_value'] || 0 != $cus_price['discount_value'] ) {

									if ( '' != $cus_price['min_qty'] || 0 != $cus_price['min_qty'] ) {
										$min_qty = intval( $cus_price['min_qty'] );
										if ( 1==$n) {
											$first_min_qty = $min_qty;
											++$n;
										}
										$customer_discount = true;
									} else {
										$min_qty = '';
									}

									if ( '' != $cus_price['max_qty'] || 0 != $cus_price['max_qty'] ) {
										$max_qty           = intval( $cus_price['max_qty'] );
										$customer_discount = true;
									} else {
										$max_qty = '';
									}

								
								}
							}
						}

						if ($customer_matched) {

							if ( ( '' != $first_min_qty && $qty < $first_min_qty ) || ( '' != $max_qty && $qty > $max_qty ) ) {
								$value         = false;
								$arr           = array(
									'%pro' => $pro->get_title(),
									'%min' => $first_min_qty,
									'%max' => $max_qty,
								);
								$word          = $this->addify_wsp_update_cart_error_msg;
								$error_message = strtr( $word, $arr );

								$this->wsp_wc_add_notice( $error_message );
								if (!empty($max_qty)) {
									return $max_qty;
								}
							}
						}
					}


					// Role Based Pricing
					// chcek if there is customer specific pricing then role base pricing will not work.
					if ( !$customer_discount ) {

						if ( ! empty( $role_base_wsp_price ) ) {
							$rule_matched = false;
							$n            = 1;
							foreach ( $role_base_wsp_price as $role_price ) {

								if ( isset( $role_price['user_role'] ) && ( 'everyone' == $role_price['user_role'] ||  $role[0] == $role_price['user_role'] )) {

									if ( '' != $role_price['discount_value'] || 0 != $role_price['discount_value'] ) {

										$rule_matched = true;

										if ( '' != $role_price['min_qty'] || 0 != $role_price['min_qty'] ) {
											$min_qty = intval( $role_price['min_qty'] );
											if ( 1==$n) {
												$first_min_qty = $min_qty;
												++$n;
											}
											$role_discount = true;
										} else {
											$min_qty = '';
										}

										if ( '' != $role_price['max_qty'] || 0 != $role_price['max_qty'] ) {
											$max_qty       = intval( $role_price['max_qty'] );
											$role_discount = true;
										} else {
											$max_qty = '';
										}

									
									}
								}
							}

							if ($rule_matched) {

								if ( ( '' != $first_min_qty && $qty < $first_min_qty ) || ( '' != $max_qty && $qty > $max_qty ) ) {

									$value         = false;
									$arr           = array(
										'%pro' => $pro->get_title(),
										'%min' => $first_min_qty,
										'%max' => $max_qty,
									);
									$word          = $this->addify_wsp_update_cart_error_msg;
									$error_message = strtr( $word, $arr );

									$this->wsp_wc_add_notice( $error_message );
									if ($max_qty) {
										return $max_qty;
									}
								} else {
									$role_discount = true;
								}
							} else {
								$role_discount = false;
							}
						}
					   
					}

					//Rules
					if ( false == $customer_discount && false == $role_discount ) {

						if ( empty( $this->allfetchedrules ) ) {

							echo '';

						} else {

							$all_rules = $this->allfetchedrules;

						}

						if ( ! empty( $all_rules ) ) {

							foreach ( $all_rules as $rule ) {

								$istrue = false;

							


								$applied_on_all_products = get_post_meta( $rule->ID, 'wsp_apply_on_all_products', true );
								$products                = get_post_meta( $rule->ID, 'wsp_applied_on_products', true );
								$categories              = get_post_meta( $rule->ID, 'wsp_applied_on_categories', true );

								if ( 'yes' == $applied_on_all_products ) {
									$istrue = true;
								} elseif ( ! empty( $products ) && ( in_array( $product_id, $products ) || in_array( $parent_id, $products ) ) ) {
									$istrue = true;
								}

								if (!empty($categories)) {
									foreach ( $categories as $cat ) {

										if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $product_id ) ) || ( has_term( $cat, 'product_cat', $parent_id ) ) ) ) {

											$istrue = true;
										} 
									}
								}

							


								if ($istrue) {


									// get Rule customer specifc price
									$rule_cus_base_wsp_price = get_post_meta( $rule->ID, 'rcus_base_wsp_price', true );

									// get role base price
									$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

									


									if ( ! empty( $rule_cus_base_wsp_price ) ) {
										$n                =1;
										$customer_matched = false;
										foreach ( $rule_cus_base_wsp_price as $rule_cus_price ) {

											if ( $user->ID == $rule_cus_price['customer_name'] ) {

												$customer_matched = true;

												if ( '' != $rule_cus_price['discount_value'] || 0 != $rule_cus_price['discount_value'] ) {

													if ( '' != $rule_cus_price['min_qty'] || 0 != $rule_cus_price['min_qty'] ) {
														$min_qty = intval( $rule_cus_price['min_qty'] );
														if ( 1==$n) {
															$first_min_qty = $min_qty;
															++$n;
														}
														$customer_discount1 = true;
													} else {
														$min_qty = '';
													}

													if ( '' != $rule_cus_price['max_qty'] || 0 != $rule_cus_price['max_qty'] ) {
														$max_qty            = intval( $rule_cus_price['max_qty'] );
														$customer_discount1 = true;
													} else {
														$max_qty = '';
													}

												
												}
											}
										}

										if ($customer_matched) {
											if ( ( '' != $first_min_qty && $qty < $first_min_qty ) || ( '' != $max_qty && $qty > $max_qty ) ) {
													$value                             = false;
													$arr                               = array(
														'%pro' => $pro->get_title(),
														'%min' => $first_min_qty,
														'%max' => $max_qty,
													);
																		$word          = $this->addify_wsp_update_cart_error_msg;
																		$error_message = strtr( $word, $arr );

																		$this->wsp_wc_add_notice( $error_message );
													if (!empty($max_qty)) {
														return $max_qty;
													}

											} else {
												$customer_discount1 = true;
											}
										} else {
											$customer_discount1 = false;
										}
									}

									// Role Based Pricing
									// chcek if there is customer specific pricing then role base pricing will not work.
									if ( !$customer_discount1 ) {

									
										if ( ! empty( $rule_role_base_wsp_price ) ) {
											$n =1;
											foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

												if ( 'everyone' == $rule_role_price['user_role'] ||  $role[0] == $rule_role_price['user_role'] ) {

													if ( '' != $rule_role_price['discount_value'] || 0 != $rule_role_price['discount_value'] ) {

														if ( '' != $rule_role_price['min_qty'] || 0 != $rule_role_price['min_qty'] ) {
															$min_qty = intval( $rule_role_price['min_qty'] );
															if ( 1==$n) {
																$first_min_qty = $min_qty;
																++$n;
															}
														} else {
															$min_qty = '';
														}

														if ( '' != $rule_role_price['max_qty'] || 0 != $rule_role_price['max_qty'] ) {
															$max_qty = intval( $rule_role_price['max_qty'] );
														} else {
															$max_qty = '';
														}

													
													}
												}
											}


											if ( ( '' != $first_min_qty && $qty < $first_min_qty ) || ( '' != $max_qty && $qty > $max_qty ) ) {
													$value                             = false;
													$arr                               = array(
														'%pro' => $pro->get_title(),
														'%min' => $first_min_qty,
														'%max' => $max_qty,
													);
																		$word          = $this->addify_wsp_update_cart_error_msg;
																		$error_message = strtr( $word, $arr );

																		$this->wsp_wc_add_notice( $error_message );
													if (!empty($max_qty) ) {
														return $max_qty;
													}

											}
										}
									}
								}
							}
						}

					}

				} elseif ( !is_user_logged_in() ) {

					//Guest
				


					// get role base price
					$role_base_wsp_price = get_post_meta( $product_id, '_role_base_wsp_price', true );

					// Role Based Pricing
					// chcek if there is customer specific pricing then role base pricing will not work.
					if ( true ) {

						if ( ! empty( $role_base_wsp_price ) ) {
							$n = 1;
							foreach ( $role_base_wsp_price as $role_price ) {

								if ( isset( $role_price['user_role'] ) && ( 'everyone' == $role_price['user_role'] || 'guest' == $role_price['user_role'] )) {

									if ( '' != $role_price['discount_value'] || 0 != $role_price['discount_value'] ) {

										if ( '' != $role_price['min_qty'] || 0 != $role_price['min_qty'] ) {
											$min_qty = intval( $role_price['min_qty'] );
											if ( 1==$n) {
												$first_min_qty = $min_qty;
												++$n;
											}
											$role_discount = true;
										} else {
											$min_qty = '';
										}

										if ( '' != $role_price['max_qty'] || 0 != $role_price['max_qty'] ) {
											$max_qty       = intval( $role_price['max_qty'] );
											$role_discount = true;
										} else {
											$max_qty = '';
										}
									}
								}
							}

							if ( ( '' != $first_min_qty && $qty < $first_min_qty ) || ( '' != $max_qty && $qty > $max_qty ) ) {
								$value         = false;
								$arr           = array(
									'%pro' => $pro->get_title(),
									'%min' => $first_min_qty,
									'%max' => $max_qty,
								);
								$word          = $this->addify_wsp_update_cart_error_msg;
								$error_message = strtr( $word, $arr );

								$this->wsp_wc_add_notice( $error_message );
								if (!empty($max_qty)) {
									return $max_qty;
								}

							} else {
								$role_discount = false;
							}
						}
					}


					if ( !$role_discount ) {

						if ( empty( $this->allfetchedrules ) ) {

							echo '';

						} else {

							$all_rules = $this->allfetchedrules;

						}

						if ( ! empty( $all_rules ) ) {
							foreach ( $all_rules as $rule ) {

								$istrue = false;

								$applied_on_all_products = get_post_meta( $rule->ID, 'wsp_apply_on_all_products', true );
								$products                = get_post_meta( $rule->ID, 'wsp_applied_on_products', true );
								$categories              = get_post_meta( $rule->ID, 'wsp_applied_on_categories', true );

								if ( 'yes' == $applied_on_all_products ) {
									$istrue = true;
								} elseif ( ! empty( $products ) && ( in_array( $product_id, $products ) || in_array( $parent_id, $products ) ) ) {
									$istrue = true;
								}

								if (!empty($categories)) {
									foreach ( $categories as $cat ) {

										if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $product_id ) ) || ( has_term( $cat, 'product_cat', $parent_id ) ) ) ) {

											$istrue = true;
										} 
									}
								}

								


								if ( $istrue ) {

									// get role base price
									$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

									// Role Based Pricing
									// chcek if there is customer specific pricing then role base pricing will not work.
									if ( true ) {

										
										if ( ! empty( $rule_role_base_wsp_price ) ) {
											$n =1;
											foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

												if ( 'everyone' == $rule_role_price['user_role'] || 'guest' == $rule_role_price['user_role'] ) {

													if ( '' != $rule_role_price['discount_value'] || 0 != $rule_role_price['discount_value'] ) {

														if ( '' != $rule_role_price['min_qty'] || 0 != $rule_role_price['min_qty'] ) {
															$min_qty = intval( $rule_role_price['min_qty'] );
															if ( 1==$n) {
																$first_min_qty = $min_qty;
																++$n;
															}
														} else {
															$min_qty = '';
														}

														if ( '' != $rule_role_price['max_qty'] || 0 != $rule_role_price['max_qty'] ) {
															$max_qty = intval( $rule_role_price['max_qty'] );
														} else {
															$max_qty = '';
														}

														
													}
												}
											}


											if ( ( '' != $first_min_qty && $qty < $first_min_qty ) || ( '' != $max_qty && $qty > $max_qty ) ) {
													$value                             = false;
													$arr                               = array(
														'%pro' => $pro->get_title(),
														'%min' => $first_min_qty,
														'%max' => $max_qty,
													);
																		$word          = $this->addify_wsp_update_cart_error_msg;
																		$error_message = strtr( $word, $arr );

																		$this->wsp_wc_add_notice( $error_message );
													if (!empty($max_qty)) {
								return $max_qty;
													}

											}
									
										}
									}
								}
							}
						}
					}
				
				}
			}
			
			return $value;
		}



		public function af_wsp_custom_range_price( $price, $product ) {


			$prices = $price;
			if (is_single()) {
				if ( !empty( $price ) && (float) $price < $product->get_regular_price()  ) {
					$final_price_with_html = '<del class="af-wsp-strike-regular-price" >' . wc_price($product->get_regular_price()) . '</del><span class="final_price">' . wc_price((float) $price ) . '</span>';
					
				} else {
					$final_price_with_html = '<span class="final_price">' . wc_price($product->get_regular_price()) . '</span>';
				}
				?>
			<div style="display:none;" data-product_id="<?php echo esc_attr($product->get_id()); ?>" class="af-wsp-regular-price-html af-wsp-regular-price-html<?php echo esc_attr($product->get_id()); ?>">
				<?php echo wp_kses(wc_price( !empty($price) ? (float) $price : $product->get_regular_price()), wp_kses_allowed_html('post')); ?>
			</div>
			<div style="display: none;" data-product_id="<?php echo esc_attr($product->get_id()); ?>" class="af-wsp-regular-price-sale-price-html af-wsp-regular-price-sale-price-html<?php echo esc_attr($product->get_id()); ?>">
				<?php echo wp_kses($final_price_with_html, wp_kses_allowed_html('post')); ?>
			</div>
					<?php
			}

			if (is_shop() || is_category() || is_product() || is_tag() || is_archive() ) {

				$user               = wp_get_current_user();
				$role               = ( array ) $user->roles;
				$current_role       = current( $user->roles );
				$customer_discount  = false;
				$role_discount      = false;
				$customer_discount1 = false;
				$role_discount1     = false;

				if ( is_user_logged_in() ) {

					if ( !empty( $this->addify_wsp_discount_price[ $current_role ] ) ) {

						if ($this->addify_wsp_discount_price[ $current_role ] && 'sale' == $this->addify_wsp_discount_price[ $current_role ] && !empty(get_post_meta( $product->get_id(), '_sale_price', true ))) {

							$pro_price = get_post_meta( $product->get_id(), '_sale_price', true );

						} elseif ('regular' == $this->addify_wsp_discount_price[ $current_role ] && !empty(get_post_meta( $product->get_id(), '_regular_price', true ))) {

							$pro_price = get_post_meta( $product->get_id(), '_regular_price', true );

						} else {

							$pro_price = get_post_meta( $product->get_id(), '_price', true );
						}

					} else {

						$pro_price = get_post_meta( $product->get_id(), '_price', true );
					}
					

					$pro_price = '' != $pro_price ?$pro_price :0;



					// get customer specifc price
					$cus_base_wsp_price = get_post_meta( $product->get_id(), '_cus_base_wsp_price', true );
		
					// get role base price
					$role_base_wsp_price = get_post_meta( $product->get_id(), '_role_base_wsp_price', true );

					// get customer base price

					if ( ! empty( $cus_base_wsp_price ) ) {

						foreach ( $cus_base_wsp_price as $cus_price ) {

							if ( isset( $cus_price['customer_name'] ) && $user->ID == $cus_price['customer_name'] ) {

								if ( '' != $cus_price['discount_value'] || 0 != $cus_price['discount_value'] ) {

									if ( 'fixed_price' == $cus_price['discount_type']  ) {
										$prices = $cus_price['discount_value'];
										return $prices;
									} 

									if ( 'fixed_increase' == $cus_price['discount_type'] ) {

										$newprice = $pro_price + $cus_price['discount_value'];

										$prices = $newprice;
										return $prices;
									}

									if ( 'fixed_decrease' == $cus_price['discount_type'] ) {

										$newprice = $pro_price - $cus_price['discount_value'];

										$prices = $newprice;
										return $prices;

									} 

									if ( 'percentage_decrease' == $cus_price['discount_type'] ) {

										$percent_price = $pro_price * $cus_price['discount_value'] / 100;

										$newprice = $pro_price - $percent_price;

										$prices = $newprice;
										return $prices;

									} elseif ( 'percentage_increase' == $cus_price['discount_type'] ) {

										$percent_price = $pro_price * $cus_price['discount_value'] / 100;

										$newprice = $pro_price + $percent_price;

										$prices = $newprice;
										return $prices;

									} 
								} else {
									$prices = $price;
								}
							}
						}
					} else {
						$prices = $price;
					}


					// Role Based Pricing
					// chcek if there is customer specific pricing then role base pricing will not work.
					if ( ! $customer_discount ) {

						if ( ! empty( $role_base_wsp_price ) ) {

							foreach ( $role_base_wsp_price as $role_price ) {

								if ( isset( $role_price['user_role'] ) && ( 'everyone' == $role_price['user_role'] ||  $role[0] == $role_price['user_role'] )) {

	
									if ( 'fixed_price' == $role_price['discount_type']  ) {
									$prices = $role_price['discount_value'];
									return $prices;
									} 

									if ( 'fixed_increase' == $role_price['discount_type'] ) {

										$newprice = $pro_price + $role_price['discount_value'];

										$prices = $newprice;
										return $prices;
									}

									if ( 'fixed_decrease' == $role_price['discount_type'] ) {

										$newprice = $pro_price - $role_price['discount_value'];

										$prices = $newprice;
										return $prices;

									} 

									if ( 'percentage_decrease' == $role_price['discount_type'] ) {

										$percent_price = $pro_price * $role_price['discount_value'] / 100;

										$newprice = $pro_price - $percent_price;

										$prices = $newprice;

										return $prices;

									} elseif ( 'percentage_increase' == $role_price['discount_type'] ) {

										$percent_price = $pro_price * $role_price['discount_value'] / 100;

										$newprice = $pro_price + $percent_price;

										$prices = $newprice;
										return $prices;

									} 
								} else {
									$prices = $price;
								}
							}
						} else {
							$prices = $price;
						}
					}


					// Rules
					if ( true ) {

						if ( empty( $this->allfetchedrules ) ) {

							echo '';

						} else {

							$all_rules = $this->allfetchedrules;

						}

						if ( ! empty( $all_rules ) ) {

							foreach ( $all_rules as $rule ) {

								$istrue = false;

								$applied_on_all_products = get_post_meta( $rule->ID, 'wsp_apply_on_all_products', true );
								$products                = get_post_meta( $rule->ID, 'wsp_applied_on_products', true );
								$categories              = get_post_meta( $rule->ID, 'wsp_applied_on_categories', true );

								if ( 'yes' == $applied_on_all_products ) {
									$istrue = true;
								} elseif ( ! empty( $products ) && ( in_array( $product->get_id(), $products ) || in_array( $product->get_parent_id(), $products ) ) ) {
									$istrue = true;
								}

								if (!empty($categories)) {
									foreach ( $categories as $cat ) {

										if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $product->get_id() ) ) || ( has_term( $cat, 'product_cat', $product->get_parent_id() ) ) ) ) {

											$istrue = true;
										} 
									}
								}

								if ( $istrue ) {

									// get Rule customer specifc price
									$rule_cus_base_wsp_price = get_post_meta( $rule->ID, 'rcus_base_wsp_price', true );

									// get role base price
									$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

								

									$customer_discount = false;

									if ( ! empty( $rule_cus_base_wsp_price ) ) {
										foreach ( $rule_cus_base_wsp_price as $rule_cus_price ) {

											if ( $user->ID == $rule_cus_price['customer_name'] ) {

												if ( '' != $rule_cus_price['discount_value'] || 0 != $rule_cus_price['discount_value'] ) {

													if ( 'fixed_price' == $rule_cus_price['discount_type'] ) {
														$prices = $rule_cus_price['discount_value'];
														return $prices;
													} elseif ( 'fixed_increase' == $rule_cus_price['discount_type'] ) {

														$newprice = $pro_price + $rule_cus_price['discount_value'];

														$prices = $newprice;
														return $prices;
													} elseif ( 'fixed_decrease' == $rule_cus_price['discount_type'] ) {

														$newprice = $pro_price - $rule_cus_price['discount_value'];

														$prices = $newprice;
														return $prices;

													} elseif ( 'percentage_decrease' == $rule_cus_price['discount_type'] ) {

														$percent_price = $pro_price * $rule_cus_price['discount_value'] / 100;

														$newprice = $pro_price - $percent_price;

														$prices = $newprice;
														return $prices;

													} elseif ( 'percentage_increase' == $rule_cus_price['discount_type'] ) {


														$percent_price = $pro_price * $rule_cus_price['discount_value'] / 100;

														$newprice = $pro_price + $percent_price;

														$prices = $newprice;
														return $prices;

													} else {

															$prices = $rule_cus_price['discount_value'];
													}
												} else {

													$prices = $price;
												}
											}
										}

									} else {
										$prices = $price;
									}

									// Role Based Pricing
									// chcek if there is customer specific pricing then role base pricing will not work.
									if ( true ) {

									
										if ( ! empty( $rule_role_base_wsp_price ) ) {
											foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

												if ( 'everyone' == $rule_role_price['user_role'] || $role[0] == $rule_role_price['user_role'] ) {

													if ( '' != $rule_role_price['discount_value'] || 0 != $rule_role_price['discount_value'] ) {

														if ( 'fixed_price' == $rule_role_price['discount_type'] ) {
															$prices = $rule_role_price['discount_value'];
															return $prices;
														} elseif ( 'fixed_increase' == $rule_role_price['discount_type'] ) {

															$newprice = $pro_price + $rule_role_price['discount_value'];

															$prices = $newprice;
															return $prices;
														} elseif ( 'fixed_decrease' == $rule_role_price['discount_type'] ) {


															$newprice = $pro_price - $rule_role_price['discount_value'];

															$prices = $newprice;
															return $prices;

														} elseif ( 'percentage_decrease' == $rule_role_price['discount_type'] ) {


															$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

															$newprice = $pro_price - $percent_price;

															$prices = $newprice;
															return $prices;

														} elseif ( 'percentage_increase' == $rule_role_price['discount_type'] ) {

															$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

															$newprice = $pro_price + $percent_price;

															$prices = $newprice;
															return $prices;

														} else {

																$prices = $rule_role_price['discount_value'];
														}
													} else {

														$prices = $price;
													}
												}
											}
										} else {

											$prices = $price;
										}

									}
								}
							}
						}
					}

				} else {

					//Not logged in users

					// Role Based Pricing for guest
					// chcek if there is customer specific pricing then role base pricing will not work.
					if ( !is_user_logged_in() ) {

						$pro_price = get_post_meta( $product->get_id(), '_price', true );

						if ( isset( $this->addify_wsp_discount_price['guest'] ) ) {

							if ('sale' == $this->addify_wsp_discount_price['guest'] && !empty(get_post_meta( $product->get_id(), '_sale_price', true ))) {

								$pro_price = get_post_meta( $product->get_id(), '_sale_price', true );

							} elseif ('regular' == $this->addify_wsp_discount_price['guest'] && !empty(get_post_meta( $product->get_id(), '_regular_price', true ))) {

								$pro_price = get_post_meta( $product->get_id(), '_regular_price', true );

							}

						} 

						$pro_price = '' != $pro_price ?$pro_price :0;

						// get role base price
						$role_base_wsp_price = get_post_meta( $product->get_id(), '_role_base_wsp_price', true );
					
						if ( ! empty( $role_base_wsp_price ) ) {

							foreach ( $role_base_wsp_price as $role_price ) {

								if ( isset( $role_price['user_role'] ) && ( 'everyone' == $role_price['user_role'] || 'guest' == $role_price['user_role'] )) {

									if ( '' != $role_price['discount_value'] || 0 != $role_price['discount_value'] ) {

										if ( 'fixed_price' == $role_price['discount_type']  ) {
											$prices = $role_price['discount_value'];
											return $prices;
										} 

										if ( 'fixed_increase' == $role_price['discount_type'] ) {

											$newprice = $pro_price + $role_price['discount_value'];

											$prices = $newprice;
											return $prices;
										}

										if ( 'fixed_decrease' == $role_price['discount_type'] ) {


											$newprice = $pro_price - $role_price['discount_value'];

											$prices = $newprice;
											return $prices;

										} 

										if ( 'percentage_decrease' == $role_price['discount_type'] ) {


											$percent_price = $pro_price * $role_price['discount_value'] / 100;

											$newprice = $pro_price - $percent_price;

											$prices = $newprice;

											return $prices;

										} elseif ( 'percentage_increase' == $role_price['discount_type'] ) {


											$percent_price = $pro_price * $role_price['discount_value'] / 100;

											$newprice = $pro_price + $percent_price;

											$prices = $newprice;
											return $prices;

										} 
									} else {

										$prices = $price;
									}
								}
							}
						} else {

							$prices = $price;
						}

					} else {

						$prices = $price;
					}




					// Rules - guest users
					if ( true ) {

						if ( empty( $this->allfetchedrules ) ) {

							echo '';

						} else {

							$all_rules = $this->allfetchedrules;

						}

						if ( ! empty( $all_rules ) ) {
							foreach ( $all_rules as $rule ) {

								$istrue = false;

								$applied_on_all_products = get_post_meta( $rule->ID, 'wsp_apply_on_all_products', true );
								$products                = get_post_meta( $rule->ID, 'wsp_applied_on_products', true );
								$categories              = get_post_meta( $rule->ID, 'wsp_applied_on_categories', true );

								if ( 'yes' == $applied_on_all_products ) {
									$istrue = true;
								} elseif ( ! empty( $products ) && ( in_array( $product->get_id(), $products ) || in_array( $product->get_parent_id(), $products ) ) ) {
									$istrue = true;
								}

								if (!empty($categories)) {
									foreach ( $categories as $cat ) {

										if ( !empty( $cat) && ( ( has_term( $cat, 'product_cat', $product->get_id() ) ) || ( has_term( $cat, 'product_cat', $product->get_parent_id() ) ) ) ) {

											$istrue = true;
										} 
									}
								}

								


								if ( $istrue ) {

									// get role base price
									$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

									// Role Based Pricing
								

									
									if ( ! empty( $rule_role_base_wsp_price ) ) {
										foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

											if ( 'everyone' == $rule_role_price['user_role'] || 'guest' == $rule_role_price['user_role'] ) {

												if ( '' != $rule_role_price['discount_value'] || 0 != $rule_role_price['discount_value'] ) {

													if ( 'fixed_price' == $rule_role_price['discount_type'] ) {
														$prices = $rule_role_price['discount_value'];
														return $prices;
													} elseif ( 'fixed_increase' == $rule_role_price['discount_type'] ) {

														$newprice = $pro_price + $rule_role_price['discount_value'];

														$prices = $newprice;
														return $prices;
													} elseif ( 'fixed_decrease' == $rule_role_price['discount_type'] ) {

														$newprice = $pro_price - $rule_role_price['discount_value'];

														$prices = $newprice;
														return $prices;

													} elseif ( 'percentage_decrease' == $rule_role_price['discount_type'] ) {

														$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

														$newprice = $pro_price - $percent_price;

														$prices = $newprice;
														return $prices;

													} elseif ( 'percentage_increase' == $rule_role_price['discount_type'] ) {


														$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

														$newprice = $pro_price + $percent_price;

														$prices = $newprice;
														return $prices;

													} else {

														$prices = $rule_role_price['discount_value'];
													}
												} else {

													$prices = $price;
												}
											}
										}
									} else {

										$prices = $price;
									}

								
								}
							}
						}
					}






				}


			}

			return $prices;
		}


		public function wsp_wc_add_notice( $string, $type = 'error' ) {

			global $woocommerce;
			if ( version_compare( $woocommerce->version, 2.1, '>=' ) ) {
				wc_add_notice( $string, $type );
			} else {
				$woocommerce->add_error( $string );
			}
		}


		public function af_wsp_template_font_family( $font_family ) {

			?>

				<style>

					.af_wsp_list_div,.responsive,.af_wsp_card_div{
						font-family: <?php echo esc_attr($font_family); ?>
					}

				</style>

			<?php
		}
		
		public function af_wsp_display_selected_template( $selected_template ) {

			$diplay_table = 'none';
			$diplay_card  = 'none';
			$diplay_list  = 'none';

			if ('table' == $selected_template) {
				$diplay_table = '';
			} elseif ('card' == $selected_template) {
				$diplay_card = '';
			} elseif ('list' == $selected_template) {
				$diplay_list = '';
			}
			?>

			<style>

					.pricing_table{
						display : <?php echo esc_attr($diplay_table); ?>
					}

					.af_wsp_card_div{
						display : <?php echo esc_attr($diplay_card); ?>
					}

					.af_wsp_list_div{
						display : <?php echo esc_attr($diplay_list); ?>
					}

				</style>

				<?php
		}

		public function af_wsp_table_border( $border_color ) {

			?>

				<style>

					div.responsive table {
						border-collapse: collapse;
/*						border: 2px solid <?php //echo esc_attr($border_color); ?>;*/

					}
					div.responsive table.tab_bor th, table.tab_bor td {

						border: 1px solid <?php echo esc_attr($border_color); ?>;
						text-align:center

					}

				</style>

			<?php
		}

		public function af_wsp_odd_row_color( $af_odd_row_color ) {

			?>

				<style>

					table:not( .has-background ) tbody td {

						background-color: initial;

					}

					table.tab_bor tbody tr:nth-child(odd) {

						background-color: <?php echo esc_attr($af_odd_row_color); ?>;

					}

				</style>

			<?php
		}

		public function af_wsp_odd_row_text_color( $af_odd_row_color ) {

			?>

				<style>

					table.tab_bor tbody tr:nth-child(odd) {

						color: <?php echo esc_attr($af_odd_row_color); ?>;

					}

				</style>

			<?php
		}

		public function af_wsp_even_row_color( $af_even_row_color ) {

			?>

				<style>

					table:not( .has-background ) tbody tr:nth-child(2n) td {

						background-color: initial;

					}

					table.tab_bor tbody tr:nth-child(even) {

						background-color: <?php echo esc_attr($af_even_row_color); ?>;

					}

				</style>

			<?php
		}

		public function af_wsp_even_row_text_color( $af_even_row_color ) {

			?>

				<style>


					table.tab_bor tbody tr:nth-child(even) {

						color: <?php echo esc_attr($af_even_row_color); ?>;

					}

				</style>

			<?php
		}

		public function af_wsp_table_row_font_size( $af_table_row_font_size ) {


			?>

				<style>

					table.tab_bor tbody tr {

						font-size: <?php echo esc_attr($af_table_row_font_size); ?>px;

					}

				</style>

			<?php
		}


		public function af_wsp_list_border_color( $border_color ) {
			?>
			
			<style>
				.af_wsp_list_box{
					border: 1px solid <?php echo esc_attr($border_color); ?>;
				}
			</style>
			<?php
		}

		public function af_wsp_list_background_color( $background_color ) {
			?>
			
			<style>
				.af_wsp_list_box{
					background-color: <?php echo esc_attr($background_color); ?>;
				}
			</style>
			<?php
		}

		public function af_wsp_list_text_color( $text_color ) {
			?>
			
			<style>
				.af_wsp_list_box{
					color: <?php echo esc_attr($text_color); ?>;
				}
			</style>
			<?php
		}

		public function af_wsp_selected_list_background_color( $background_color ) {
			?>
			
			<style>
				.af_wsp_selected_list{
					background-color: <?php echo esc_attr($background_color); ?>;
				}
			</style>
			<?php
		}

		public function af_wsp_selected_list_text_color( $text_color ) {
			?>
			
			<style>
				.af_wsp_selected_list{
					color: <?php echo esc_attr($text_color); ?>;
				}
			</style>
			<?php
		}

		public function af_wsp_card_border_color( $border_color ) {
			?>
			
			<style>
				.af_wsp_inner_small_box{
					border: 1px solid <?php echo esc_attr($border_color); ?>;
				}
			</style>
			<?php
		}

		public function af_wsp_card_text_color( $text_color ) {
			?>
			
			<style>
				.af_wsp_inner_small_box{
					color:<?php echo esc_attr($text_color); ?>;
				}
			</style>
			<?php
		}

		public function af_wsp_card_backgrorund_color( $background_color ) {
			?>
			
			<style>
				.af_wsp_inner_small_box{
					background-color: <?php echo esc_attr($background_color); ?>;
				}
			</style>
			<?php
		}

		public function af_wsp_card_selected_border_color( $border_color ) {
			?>
			
			<style>
				.af_wsp_selected_card{
					border: 2px solid <?php echo esc_attr($border_color); ?>;
				}
			</style>
			<?php
		}

		public function af_wsp_enable_sale_tag() {
			?>
			
			<style>
				.afwsp_sale_tag{
					display:none
				}
			</style>
			<?php
		}

		public function af_wsp_sale_tag_background_color( $background_color ) {
			?>
			
			<style>
				.afwsp_sale_tag{
					background-color: <?php echo esc_attr($background_color); ?>;

				}
			</style>
			<?php
		}

		public function af_wsp_sale_tag_text_color( $text_color ) {
			?>
			
			<style>
				.afwsp_sale_tag{
					color: <?php echo esc_attr($text_color); ?>;

				}
			</style>
			<?php
		}
		
		public function wsp_replace_loop_add_to_cart_link( $html, $product ) {

			$cart_txt       = $html;
			$adf_product_id = $product->get_id();

			if ($product->is_type('variable')) {

				return $cart_txt;
			}

			if ( ! empty( $this->wsp_enable_hide_price_feature ) && 'yes' == $this->wsp_enable_hide_price_feature && 
				'yes' == $this->wsp_hide_cart_button ) {

				// For Guest Users
				if ( ! empty( $this->wsp_enable_for_guest ) && 'yes' == $this->wsp_enable_for_guest ) {

					if ( ! is_user_logged_in() ) {

						if ( ! empty( $this->wsp_hide_products ) ) {

							if ( in_array( $product->get_id(), (array) $this->wsp_hide_products ) ) {

								if ( ! empty( get_option('wsp_cart_button_text')) ) {

									$cart_txt = '<a href="' . esc_url( $this->wsp_cart_button_link ) . '" rel="nofollow" class="button add_to_cart_button wp-element-button">' . esc_html(get_option('wsp_cart_button_text')) . '</a>';

								} else {
									$cart_txt = '';
								}
								?>
								<style>
									.woocommerce-variation-price,
									<?php echo '.post-' . esc_html( $adf_product_id); ?> .ast-on-card-button.add_to_cart_button,
									<?php echo '.post-' . esc_html( $adf_product_id); ?> .wrap-quickview-button .quick-view{ display: none !important;}
								</style>
								<?php
							}
						}


						if ( ! empty( $this->wsp_hide_categories )) {
							foreach ( $this->wsp_hide_categories as $cat ) {
								if ( has_term( $cat, 'product_cat', $product->get_id() ) ) {
									
									if ( ! empty( get_option('wsp_cart_button_text')) ) {

										$cart_txt = '<a href="' . esc_url( $this->wsp_cart_button_link ) . '" rel="nofollow" class="button add_to_cart_button wp-element-button">' . esc_html(get_option('wsp_cart_button_text')) . '</a>';

									} else {
										$cart_txt = '';
									}

									?>
									<style>
										.woocommerce-variation-price,
										<?php echo '.post-' . esc_html( $adf_product_id); ?> .ast-on-card-button.add_to_cart_button,
										<?php echo '.post-' . esc_html( $adf_product_id); ?> .wrap-quickview-button .quick-view{ display: none !important;}
									</style>
									<?php

								}
							}
						}


					}

				}


				// For Registered Users
				if ( ! empty( $this->wsp_enable_hide_pirce_registered ) && 'yes' == $this->wsp_enable_hide_pirce_registered ) {

					if ( is_user_logged_in() ) {

						// get Current User Role
						$curr_user      = wp_get_current_user();
						$user_data      = get_user_meta( $curr_user->ID );
						$curr_user_role = $curr_user->roles[0];

						if ( !empty($this->wsp_hide_user_role) && in_array( $curr_user_role, $this->wsp_hide_user_role ) ) {
							if ( ! empty( $this->wsp_hide_products ) ) {

								if ( in_array( $product->get_id(), (array) $this->wsp_hide_products ) ) {

									if ( ! empty( get_option('wsp_cart_button_text')) ) {

										$cart_txt = '<a href="' . esc_url( $this->wsp_cart_button_link ) . '" rel="nofollow" class="button add_to_cart_button wp-element-button">' . esc_html(get_option('wsp_cart_button_text')) . '</a>';

									} else {
										$cart_txt = '';
									}
									?>
									<style>
										.woocommerce-variation-price,
										<?php echo '.post-' . esc_html( $adf_product_id); ?> .ast-on-card-button.add_to_cart_button,
										<?php echo '.post-' . esc_html( $adf_product_id); ?> .wrap-quickview-button .quick-view{ display: none !important;}
									</style>
									<?php
								}
							}


							if ( ! empty( $this->wsp_hide_categories )) {
								foreach ( $this->wsp_hide_categories as $cat ) {
									if ( has_term( $cat, 'product_cat', $product->get_id() ) ) {
										
										if ( ! empty( get_option('wsp_cart_button_text')) ) {

											$cart_txt = '<a href="' . esc_url( $this->wsp_cart_button_link ) . '" rel="nofollow" class="button add_to_cart_button wp-element-button">' . esc_html(get_option('wsp_cart_button_text')) . '</a>';

										} else {
											$cart_txt = '';
										}

										?>
										<style>
											.woocommerce-variation-price,
											<?php echo '.post-' . esc_html( $adf_product_id); ?> .ast-on-card-button.add_to_cart_button,
											<?php echo '.post-' . esc_html( $adf_product_id); ?> .wrap-quickview-button .quick-view{ display: none !important;}
										</style>
										<?php
									}
								}
							}
						}


					}

				}

			}

			return $cart_txt;
		}

		public function wsp_product_cart_page_block( $is_purchasable, $product ) {

			$is_purchasable =  true;

			$cart_txt = $is_purchasable;

			// if ($product->is_type('variable')) {

			//  return $cart_txt;
			// }

			if (is_cart()) {
				if ( ! empty( $this->wsp_enable_hide_price_feature ) && 'yes' == $this->wsp_enable_hide_price_feature && 
					'yes' == $this->wsp_hide_cart_button ) {

					// For Guest Users
					if ( ! empty( $this->wsp_enable_for_guest ) && 'yes' == $this->wsp_enable_for_guest ) {

						if ( ! is_user_logged_in() ) {

							if ( ! empty( $this->wsp_hide_products ) ) {

								if ( in_array( $product->get_id(), (array) $this->wsp_hide_products ) ) {

									if ( ! empty( get_option('wsp_cart_button_text')) ) {

										$cart_txt = '<a href="' . esc_url( $this->wsp_cart_button_link ) . '" rel="nofollow" class="button add_to_cart_button">' . esc_html(get_option('wsp_cart_button_text')) . '</a>';
										$cart_txt = false;

									} else {
										$cart_txt = false;
									}
									
								}
							}


							if ( ! empty( $this->wsp_hide_categories )) {
								foreach ( $this->wsp_hide_categories as $cat ) {
									if ( has_term( $cat, 'product_cat', $product->get_id() ) ) {
										
										if ( ! empty( get_option('wsp_cart_button_text')) ) {

											$cart_txt = '<a href="' . esc_url( $this->wsp_cart_button_link ) . '" rel="nofollow" class="button add_to_cart_button">' . esc_html(get_option('wsp_cart_button_text')) . '</a>';
											$cart_txt = false;

										} else {
											$cart_txt = false;
										}

									}
								}
							}


						}

					}


					// For Registered Users
					if ( ! empty( $this->wsp_enable_hide_pirce_registered ) && 'yes' == $this->wsp_enable_hide_pirce_registered ) {

						if ( is_user_logged_in() ) {

							// get Current User Role
							$curr_user      = wp_get_current_user();
							$user_data      = get_user_meta( $curr_user->ID );
							$curr_user_role = $curr_user->roles[0];

							if ( !empty($this->wsp_hide_user_role) && in_array( $curr_user_role, $this->wsp_hide_user_role ) ) {
								if ( ! empty( $this->wsp_hide_products ) ) {

									if ( in_array( $product->get_id(), (array) $this->wsp_hide_products ) ) {

										if ( ! empty( get_option('wsp_cart_button_text')) ) {

											$cart_txt = '<a href="' . esc_url( $this->wsp_cart_button_link ) . '" rel="nofollow" class="button add_to_cart_button">' . esc_html(get_option('wsp_cart_button_text')) . '</a>';
											$cart_txt = false;

										} else {
											$cart_txt = false;
										}
										
									}
								}


								if ( ! empty( $this->wsp_hide_categories )) {
									foreach ( $this->wsp_hide_categories as $cat ) {
										if ( has_term( $cat, 'product_cat', $product->get_id() ) ) {
											
											if ( ! empty( get_option('wsp_cart_button_text')) ) {

												$cart_txt = '<a href="' . esc_url( $this->wsp_cart_button_link ) . '" rel="nofollow" class="button add_to_cart_button">' . esc_html(get_option('wsp_cart_button_text')) . '</a>';
												$cart_txt = false;

											} else {
												$cart_txt = '';
												$cart_txt = false;
											}

										}
									}
								}
							}


						}

					}

				}
			}

			return $cart_txt;
		}

		public function wsp_hide_add_cart_product_page() {

			global $user, $product;
			$current_theme = wp_get_theme();
			$parent_theme  = $current_theme->parent();

			if ( ! empty( $this->wsp_enable_hide_price_feature ) && 'yes' == $this->wsp_enable_hide_price_feature && 
				'yes' == $this->wsp_hide_cart_button ) {

				// For Guest Users
				if ( ! empty( $this->wsp_enable_for_guest ) && 'yes' == $this->wsp_enable_for_guest ) {

					if ( ! is_user_logged_in() ) {

						if ( ! empty( $this->wsp_hide_products ) ) {

							if ( in_array( $product->get_id(), (array) $this->wsp_hide_products ) ) {

								if ( 'variable' == $product->get_type() ) {

									remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
									add_action( 'woocommerce_single_variation', array( $this, 'wsp_custom_button_replacement' ), 30 );

								} elseif ($current_theme->get('Name') === 'Astra' || ( $parent_theme && $parent_theme->get('Name') === 'Astra' ) || $current_theme->get('Name') === 'Twenty Twenty-Four' || $current_theme->get('Name') === 'Twenty Twenty-Five' ) {

									?>
										<style type="text/css">
											.summary form .single_add_to_cart_button{
												display: none!important;
											}
											.wp-block-add-to-cart-form.wc-block-add-to-cart-form form button{
												display: none!important;
											}
											.button.add_to_cart_button.wp-element-button{
												grid-column: none!important;
											}
											.wp-block-woocommerce-add-to-cart-form .quantity .qty{
												width: 4.631em!important;
												padding: 0!important;
											}
										</style>
										<?php
									add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'wsp_custom_button_replacement' ), 30 );
								} else {
									remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
									add_action( 'woocommerce_single_product_summary', array( $this, 'wsp_custom_button_replacement' ), 30 );
								}
								
							}
						}


						if ( ! empty( $this->wsp_hide_categories )) {
							foreach ( $this->wsp_hide_categories as $cat ) {
								if ( has_term( $cat, 'product_cat', $product->get_id() ) ) {
									
									if ( 'variable' == $product->get_type() ) {

										remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
										add_action( 'woocommerce_single_variation', array( $this, 'wsp_custom_button_replacement' ), 30 );

									} elseif ($current_theme->get('Name') === 'Astra' || ( $parent_theme && $parent_theme->get('Name') === 'Astra' ) || $current_theme->get('Name') === 'Twenty Twenty-Four' || $current_theme->get('Name') === 'Twenty Twenty-Five' ) {
										?>
											<style type="text/css">
												.summary form .single_add_to_cart_button{
													display: none!important;
												}
												.wp-block-add-to-cart-form.wc-block-add-to-cart-form form button{
														display: none!important;
													}
												.button.add_to_cart_button.wp-element-button{
													grid-column: none!important;
												}
												.wp-block-woocommerce-add-to-cart-form .quantity .qty{
													width: 4.631em!important;
													padding: 0!important;
												}
											</style>
											<?php
										add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'wsp_custom_button_replacement' ), 30 );
									} else {
										remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
										add_action( 'woocommerce_single_product_summary', array( $this, 'wsp_custom_button_replacement' ), 30 );
									}

								}
							}
						}


					}

				}


				// For Registered Users
				if ( ! empty( $this->wsp_enable_hide_pirce_registered ) && 'yes' == $this->wsp_enable_hide_pirce_registered ) {

					if ( is_user_logged_in() ) {

						// get Current User Role
						$curr_user      = wp_get_current_user();
						$user_data      = get_user_meta( $curr_user->ID );
						$curr_user_role = $curr_user->roles[0];

						if ( !empty($this->wsp_hide_user_role) && in_array( $curr_user_role, $this->wsp_hide_user_role ) ) {
							if ( ! empty( $this->wsp_hide_products ) ) {

								if ( in_array( $product->get_id(), (array) $this->wsp_hide_products ) ) {

									if ( 'variable' == $product->get_type() ) {

										remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
										add_action( 'woocommerce_single_variation', array( $this, 'wsp_custom_button_replacement' ), 30 );

									} elseif ($current_theme->get('Name') === 'Astra' || ( $parent_theme && $parent_theme->get('Name') === 'Astra' ) || $current_theme->get('Name') === 'Twenty Twenty-Four' || $current_theme->get('Name') === 'Twenty Twenty-Five' ) {
										?>
											<style type="text/css">
												.summary form .single_add_to_cart_button{
													display: none!important;
												}
												.wp-block-add-to-cart-form.wc-block-add-to-cart-form form button{
														display: none!important;
													}
													.button.add_to_cart_button.wp-element-button{
														grid-column: none!important;
													}
													.wp-block-woocommerce-add-to-cart-form .quantity .qty{
														width: 4.631em!important;
														padding: 0!important;
													}
											</style>
											<?php
										add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'wsp_custom_button_replacement' ), 30 );
									} else {
										remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
										add_action( 'woocommerce_single_product_summary', array( $this, 'wsp_custom_button_replacement' ), 30 );
									}
									
								}
							}


							if ( ! empty( $this->wsp_hide_categories )) {
								foreach ( $this->wsp_hide_categories as $cat ) {
									if ( has_term( $cat, 'product_cat', $product->get_id() ) ) {
										
										if ( 'variable' == $product->get_type() ) {

											remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
											add_action( 'woocommerce_single_variation', array( $this, 'wsp_custom_button_replacement' ), 30 );

										} elseif ($current_theme->get('Name') === 'Astra' || ( $parent_theme && $parent_theme->get('Name') === 'Astra' ) || $current_theme->get('Name') === 'Twenty Twenty-Four' || $current_theme->get('Name') === 'Twenty Twenty-Five' ) {

											?>
												<style type="text/css">
													.summary form .single_add_to_cart_button{
														display: none!important;
													}
													.wp-block-add-to-cart-form.wc-block-add-to-cart-form form button{
														display: none!important;
													}
													.button.add_to_cart_button.wp-element-button{
														grid-column: none!important;
													}
													.wp-block-woocommerce-add-to-cart-form .quantity .qty{
														width: 4.631em!important;
														padding: 0!important;
													}
												</style>
												<?php
											add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'wsp_custom_button_replacement' ), 30 );

										} else {
											remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
											add_action( 'woocommerce_single_product_summary', array( $this, 'wsp_custom_button_replacement' ), 30 );
										}

									}
								}
							}
						}


					}

				}




			}
		}

		public function wsp_custom_button_replacement() {

			if ( ! empty( get_option('wsp_cart_button_text')) ) {

				echo '<a href="' . esc_url( $this->wsp_cart_button_link ) . '" rel="nofollow" class="button add_to_cart_button wp-element-button">' . esc_html(get_option('wsp_cart_button_text')) . '</a>';

			} else {
				$cart_txt = '';
			}
		}

		public function get_tax_price_display_mode() {
			// Check if the WooCommerce cart is initialized
			if ( wc()->cart ) {
				// Check if the customer exists and if they are VAT exempt
				if ( wc()->cart->get_customer() && wc()->cart->get_customer()->get_is_vat_exempt() ) {
					return 'excl';
				}
			}
			// Return the default WooCommerce tax display setting if conditions are not met
			return get_option( 'woocommerce_tax_display_cart' );
		}
	}

	new Front_Addify_Wholesale_Prices();

}

