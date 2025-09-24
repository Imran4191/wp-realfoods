<?php 

if ( ! defined( 'ABSPATH' ) ) { 
	exit; // restict for direct access
}

if ( !class_exists( 'Admin_Addify_Wholesale_Prices' ) ) {

	class Admin_Addify_Wholesale_Prices extends Addify_Wholesale_Prices {

		public $addify_wsp_discount_price;

		public $allfetchedrules;

		public $fatched_cats;

		public function __construct() {

			add_action( 'admin_enqueue_scripts', array( $this, 'afwsp_admin_assets' ) );
			add_action( 'admin_menu', array( $this, 'afwholesaleprice_submenu_link' ) );
			add_action('admin_init', array( $this, 'afwsp_options' ));

			//Product Level
			// Create the custom tab
			add_filter( 'woocommerce_product_data_tabs', array( $this, 'create_wsp_tab' ) );
			// Add the custom fields
			add_action( 'woocommerce_product_data_panels', array( $this, 'display_wsp_fields' ) );
			// Save the custom fields
			add_action( 'woocommerce_process_product_meta', array( $this, 'save_wsp_fields' ) );

			// For Variable Products
			add_action( 'woocommerce_product_after_variable_attributes', array( $this, 'wsp_variable_fields' ), 10, 3 );
			add_action( 'woocommerce_save_product_variation', array( $this, 'wsp_save_custom_field_variations' ), 10, 2 );

			// Rule Based
			add_action( 'add_meta_boxes', array( $this, 'wsp_add_custom_meta_box' ) );
			add_action( 'save_post_af_wholesale_price', array( $this, 'wsp_add_custom_meta_save' ) );

			add_action( 'wp_ajax_wspsearchUsers', array( $this, 'wspsearchUsers' ) );
			add_action( 'wp_ajax_wspsearchProducts', array( $this, 'wspsearchProducts' ) );

			//Admin Order
			add_action( 'woocommerce_ajax_add_order_item_meta', array( $this, 'wsp_update_order_prices_on_admin_ajax' ), 99, 3 );
			//add_action( 'save_post', array($this, 'wsp_change_order_item_prices'), 11, 1 );

			add_filter( 'woocommerce_json_search_found_customers', array( $this, 'af_filter_woocommerce_json_search_found_customers' ), 10, 1 ); 

			if (!empty(get_option('addify_wsp_discount_price'))) {
				$this->addify_wsp_discount_price = get_option( 'addify_wsp_discount_price');    
			} else {
				$this->addify_wsp_discount_price = '';
			}


			if (isset($_POST['afwholesale_save_hide_price']) && '' != $_POST['afwholesale_save_hide_price']) {
				include_once ABSPATH . 'wp-includes/pluggable.php';
				if (!empty($_REQUEST['afwholesaleprice_nonce_field'])) {

						$retrieved_nonce = sanitize_text_field($_REQUEST['afwholesaleprice_nonce_field']);
				} else {
						$retrieved_nonce = 0;
				}

				if (!wp_verify_nonce($retrieved_nonce, 'afwholesaleprice_nonce_action')) {

					die('Failed security check');
				}
				$this->afwholesale_save_data();
				add_action('admin_notices', array( $this, 'afwholesale_author_admin_notice' ));

				
			}
			
			add_filter( 'woocommerce_product_export_column_names', array( $this, 'afwsp_add_export_column' ));
			add_filter( 'woocommerce_product_export_product_default_columns', array( $this, 'afwsp_add_export_column' ));
			
			add_filter( 'woocommerce_product_export_product_column__cus_base_wsp_price', array( $this, 'afwsp_add_export_data_customer_base' ), 10, 2 );
			add_filter( 'woocommerce_product_export_product_column__role_base_wsp_price', array( $this, 'afwsp_add_export_data_role_base' ), 10, 2 );
					
			
			add_action( 'all_admin_notices', array( $this, 'afwholesaleprice_display_tabs' ), 5 );

			add_action('wp_loaded', array( $this, 'afwsp_import_prices_cb' ) );

			add_action('wp_ajax_afwsp_export_file_contents_to_csv', array( $this, 'afwsp_export_file_contents_to_csv' ));

			add_action('wp_ajax_afwsp_string_to_json_for_csv', array( $this, 'afwsp_string_to_json_for_csv' ));
		}

		public function afwsp_string_to_json_for_csv() {

			if ( empty( $_POST['nonce'] ) || !wp_verify_nonce( sanitize_text_field( $_POST['nonce']), 'afwsp-ajax-nonce' ) ) {
					print 'Sorry, your nonce did not verify.';
					exit;
			}
	
			if ( !current_user_can('manage_options') ) {        
	
				die('Your are not allowed to manage options');
	
			}
			$data = ( ! empty( $_POST['data'] ) ) ? wc_clean( sanitize_text_field( wp_unslash( $_POST['data'] ) ) ) : array();
			
			
			$data = (array) json_decode( $data );
			
			$string = array();

			
			foreach ($data as $productId => $productDetails) {
				foreach ($productDetails as  $line) {
					$customer_email = '';
					if (isset($line->customer_id)) {
						$user_info = get_userdata($line->customer_id);
						if ($user_info) {
							$customer_email = $user_info->user_email;
							
						}
					}
					
					$line_array = array(
						'ID'                         => $line->id,
						'SKU'                        => $line->sku,
						'Name'                       => $line->product_name,
						'User Role'                  => isset($line->user_role) ? $line->user_role : '',
						'Customer Email'             => $customer_email,
						'Quantity From (min qty)'    => $line->min_qty,
						'Quantity To (max qty)'      => $line->max_qty,
						'Adjustment / Discount Type' => $line->discount_type,
						'Discount Price/Value'       => $line->discount_value,
						'Replace Original Price'     => isset($line->replace_original) && '' != $line->replace_original? $line->replace_original : 'no',
					);
					$string[]   = $line_array;
				}
			}
			echo wp_json_encode( $string );
			exit();
		}

		public function afwsp_export_file_contents_to_csv() {

			if ( empty( $_POST['nonce'] ) || !wp_verify_nonce( sanitize_text_field(  $_POST['nonce']), 'afwsp-ajax-nonce' ) ) {
				print 'Sorry, your nonce did not verify.';
				exit;
			}
		
			if ( !current_user_can('manage_options') ) {        
		
				die('Your are not allowed to manage options');
		
			}
		
			if ( isset($_POST['offset']) ) {
				
				$data    = array();
				$offset  = isset( $_POST['offset'] ) ? sanitize_text_field( $_POST['offset'] ) : '0';
				$all_ids = get_posts(
					array(
						'post_type'      => array( 'product', 'product_variation' ),
						'posts_per_page' => 500,
						'post_status'    => 'publish',
						'fields'         => 'ids',
						'offset'         => $offset,
					)
				);
		
				if (!empty($all_ids)) { 
		
					foreach ( $all_ids as $value ) {
		
						$pres_pro_id = $value;
						$index       = 0;
		
						if ('product_variation'== get_post_type($pres_pro_id)) {
							$product_variation = new WC_Product_Variation( $pres_pro_id );
							$variation_name    = $product_variation->get_name();
							$product_name      = '"' . $variation_name . '"';
						} else {
							$name         = get_the_title($pres_pro_id);
							$product_name = '"' . $name . '"';
						}
						$product_sku = get_post_meta($pres_pro_id, '_sku', true );
		
		
						$role_based_prices     = (array) get_post_meta($pres_pro_id, '_role_base_wsp_price', true);
						$customer_based_prices = (array) get_post_meta($pres_pro_id, '_cus_base_wsp_price', true);
						
						foreach ($role_based_prices as $role_price) {
							if ( !is_array($role_price) ) {
								continue;
							}

								$data[ $value ][ $index ] = array(
									'id'               => '"' . $pres_pro_id . '"',
									'sku'              => '"' . $product_sku . '"',
									'product_name'     => $product_name,
									'user_role'        => $role_price['user_role'],
									'discount_type'    => $role_price['discount_type'],
									'discount_value'   => $role_price['discount_value'],
									'min_qty'          => $role_price['min_qty'],
									'max_qty'          => $role_price['max_qty'],
									'replace_original' => isset($role_price['replace_orignal_price'])?( $role_price['replace_orignal_price'] ):'no',
								);
								++$index;
						}
							
						foreach ($customer_based_prices as $customer_price) {
							if ( !is_array($customer_price) ) {
								continue;
							}
							$data[ $value ][ $index ] = array(
								'id'               => '"' . $pres_pro_id . '"',
								'sku'              => '"' . $product_sku . '"',
								'product_name'     => $product_name,
								'customer_id'      => $customer_price['customer_name'],
								'discount_type'    => $customer_price['discount_type'],
								'discount_value'   => $customer_price['discount_value'],
								'min_qty'          => $customer_price['min_qty'],
								'max_qty'          => $customer_price['max_qty'],
								'replace_original' => isset($role_price['replace_orignal_price'])?( $role_price['replace_orignal_price'] ):'no',
							);
							++$index;
						}
						
					}
					
					$passed_offset = $offset + 500;
					$response      = array(
						'status' => 'continue',
						'data'   => $data,
						'offset' => $passed_offset,
					);
					wp_send_json( $response );
		
				} else {
		
					$response = array(
						'status' => 'finish',
						'text'   => __( 'All done! Close.', 'addify-stock-manager' ),
					);
					wp_send_json( $response );
				}
			}
		}
		
		public function afwsp_add_export_column( $columns ) {

			// column slug => column name
			$columns['_cus_base_wsp_price']  = 'Customer Based Wholesale Pricing';
			$columns['_role_base_wsp_price'] = 'User Role Based Wholesale Pricing';

			return $columns;
		}
		
		
		public function afwsp_add_export_data_customer_base( $value, $product ) { 
			
			$value = serialize($product->get_meta( '_cus_base_wsp_price', true, 'edit' ));
			return $value;
		}

		public function afwsp_add_export_data_role_base( $value, $product ) {
			$value = serialize($product->get_meta( '_role_base_wsp_price', true, 'edit' ));
			return $value;
		}
		

		public function af_filter_woocommerce_json_search_found_customers( $found_customers ) { 

				
			$af_customer = '';

			if (!empty(array_filter($found_customers))) {

				preg_match('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/', current($found_customers), $matches);

				if (isset($matches[0])) {
					$user        = get_user_by( 'email', $matches[0] );
					$af_customer = $user->ID;
				} else {
					$af_customer = 'guest';
				}

			} else {

				$af_customer = 'guest';

			}

				setcookie('af_user_cookie', $af_customer, strtotime('+1 day'));

				return $found_customers; 
		}


		public function afwsp_admin_assets() {

			setcookie('af_user_cookie', 'guest', strtotime('+1 day'));

			$af_wsp_current_screen = get_current_screen();

			if ( $af_wsp_current_screen && ( in_array($af_wsp_current_screen->id, $this-> get_screen_tab_id() ) )) {
				
				wp_enqueue_style( 'addify_wsp_admin_css', plugins_url( '/assets/css/addify_wsp_admin_css.css', __FILE__ ), false, '1.0.0');
				wp_enqueue_script( 'addify_wsp_admin_js', plugins_url( '/assets/js/addify_wsp_admin_js.js', __FILE__ ), false, '1.0.0' );
				$wsp_data = array(
					'admin_url' => admin_url('admin-ajax.php'),
					'nonce'     => wp_create_nonce('afwsp-ajax-nonce'),
				);
				wp_localize_script( 'addify_wsp_admin_js', 'wsp_php_vars', $wsp_data );
				//select2 css and js
				wp_enqueue_script('jquery');
				wp_enqueue_style( 'addify_ps-select2-css', plugins_url( '/assets/css/select2.css', __FILE__ ), false, '1.0' );
				// wp_enqueue_style( 'addify_ps-select2-bscss', 'https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2-bootstrap.css', false, '1.0' );
				wp_enqueue_script( 'addify_ps-select2-js', plugins_url( '/assets/js/select2.js', __FILE__ ), false, '1.0');
				wp_enqueue_script( 'media-upload' );
				wp_enqueue_media();
			}
		}

		public function get_screen_tab_id() {
			$tabs = array( 'edit-af_wholesale_price', 'af_wholesale_price', 'woocommerce_page_wsp-hide-pirce', 'woocommerce_page_addify-wsp-import-price', 'woocommerce_page_addify-wsp-settings', 'product' );
			return $tabs;
		}

		public function create_wsp_tab( $tabs ) {
			$tabs['addify_wsp_customer'] = array(
				'label'    => esc_html__( 'Wholesale Prices(By Customers)', 'addify_wholesale_prices' ),
				'target'   => 'addify_wsp_panel_customer',
				'class'    => array( 'addify_wsp_tab', 'show_if_simple' ),
				'priority' => 80,
			);

			$tabs['addify_wsp_role'] = array(
				'label'    => esc_html__( 'Wholesale Prices(By User Roles)', 'addify_wholesale_prices' ),
				'target'   => 'addify_wsp_panel_role',
				'class'    => array( 'addify_wsp_tab', 'show_if_simple' ),
				'priority' => 80,
			);
			return $tabs;
		}

		public function display_wsp_fields() {


			global $post;

			$cus_base_wsp_price   = get_post_meta($post->ID, '_cus_base_wsp_price', true);
			$role_base_wsp_prices = get_post_meta( $post->ID, '_role_base_wsp_price', true );
			wp_nonce_field('wsp_nonce_action', 'wsp_nonce_field');

			require ADDIFY_WSP_PLUGINDIR . 'afwsp_product_level.php';
		}

		public function wsp_variable_fields( $loop, $variation_data, $variation ) {

			$cus_base_wsp_prices  = get_post_meta( $variation->ID, '_cus_base_wsp_price', true );
			$role_base_wsp_prices = get_post_meta( $variation->ID, '_role_base_wsp_price', true );
			wp_nonce_field( 'wsp_nonce_action', 'wsp_nonce_field' );

			include ADDIFY_WSP_PLUGINDIR . 'afwsp_product_level_variable_product.php';
		}

		public function save_wsp_fields( $post_id ) {

			$product = wc_get_product( $post_id );

			if ( 'variable' != $product->get_type() ) {


				//Customer base wholesale prices
				if ( isset( $_POST['cus_base_wsp_price'] ) ) {

					if ( ! empty( $_REQUEST['wsp_nonce_field'] ) ) {

						$retrieved_nonce = sanitize_text_field( $_REQUEST['wsp_nonce_field'] );
					} else {
						$retrieved_nonce = 0;
					}

					if ( ! wp_verify_nonce( $retrieved_nonce, 'wsp_nonce_action' ) ) {

							die( 'Failed security check' );
					}

					$cus_base_wsp_price = sanitize_meta( '', $_POST['cus_base_wsp_price'], '' );


					foreach ($cus_base_wsp_price as $key => $value) {
						if (!isset($value['discount_value']) || '' == $value['discount_value'] ) {
							$cus_base_wsp_price[ $key ]['discount_value'] = 0;
						}
						if (!isset($value['min_qty']) || '' == $value['min_qty']  || '0' == $value['min_qty'] ) {
							$cus_base_wsp_price[ $key ]['min_qty'] = 1;
						}
						if (!isset($value['max_qty']) || '' == $value['max_qty'] ) {
							$cus_base_wsp_price[ $key ]['max_qty'] = 0;
						}
					}
					
				} else {
					$cus_base_wsp_price = '';
				}


				if ( ! empty( $cus_base_wsp_price ) ) {
					

					$product->update_meta_data( '_cus_base_wsp_price', $cus_base_wsp_price );
				} else {

					$product->delete_meta_data( '_cus_base_wsp_price' );
				}


				//Role base wholesale prices
				if ( isset( $_POST['role_base_wsp_prices'] ) ) {

					if ( ! empty( $_REQUEST['wsp_nonce_field'] ) ) {

						$retrieved_nonce = sanitize_text_field( $_REQUEST['wsp_nonce_field'] );
					} else {
						$retrieved_nonce = 0;
					}

					if ( ! wp_verify_nonce( $retrieved_nonce, 'wsp_nonce_action' ) ) {

							die( 'Failed security check' );
					}

					$role_base_wsp_prices = sanitize_meta( '', $_POST['role_base_wsp_prices'], '' );


					foreach ($role_base_wsp_prices as $key => $value) {
						if (!isset($value['discount_value']) || '' == $value['discount_value'] ) {
							$role_base_wsp_prices[ $key ]['discount_value'] = 0;
						}
						if (!isset($value['min_qty']) || '' == $value['min_qty']  || '0' == $value['min_qty'] ) {
							$role_base_wsp_prices[ $key ]['min_qty'] = 1;
						}
						if (!isset($value['max_qty']) || '' == $value['max_qty'] ) {
							$role_base_wsp_prices[ $key ]['max_qty'] = 0;
						}
					}

				} else {
					$role_base_wsp_prices = '';
				}


				if ( ! empty( $role_base_wsp_prices ) ) {

					$product->update_meta_data( '_role_base_wsp_price', $role_base_wsp_prices );
				} else {

					$product->delete_meta_data( '_role_base_wsp_price' );
				}

				$product->save();



			}
		}

		public function wsp_save_custom_field_variations( $variation_id, $i ) {

			if ( isset( $_POST['cus_base_wsp_price'][ $variation_id ] ) ) {

				if ( ! empty( $_REQUEST['wsp_nonce_field'] ) ) {

					$retrieved_nonce = sanitize_text_field( $_REQUEST['wsp_nonce_field'] );
				} else {
					$retrieved_nonce = 0;
				}

				if ( ! wp_verify_nonce( $retrieved_nonce, 'wsp_nonce_action' ) ) {

					die( 'Failed security check' );
				}

				$cus_base_wsp_price = sanitize_meta( '', $_POST['cus_base_wsp_price'][ $variation_id ], '' );


				foreach ($cus_base_wsp_price as $key => $value) {
					if (!isset($value['discount_value']) || '' == $value['discount_value']) {
						$cus_base_wsp_price[ $key ]['discount_value'] = 0;
					}
					if (!isset($value['min_qty']) || '' == $value['min_qty'] || '0' == $value['min_qty'] ) {
						$cus_base_wsp_price[ $key ]['min_qty'] = 1;
					}
					if (!isset($value['max_qty']) || '' == $value['max_qty'] ) {
						$cus_base_wsp_price[ $key ]['max_qty'] = 0;
					}
				}
				

			} else {
				$cus_base_wsp_price = '';
			}

			if ( '' != $cus_base_wsp_price ) {
				update_post_meta( $variation_id, '_cus_base_wsp_price', $cus_base_wsp_price );
			} else {
				update_post_meta( $variation_id, '_cus_base_wsp_price', '' );
			}

			//role base
			if ( isset( $_POST['role_base_wsp_prices'][ $variation_id ] ) ) {

				$role_base_wsp_prices = sanitize_meta( '', $_POST['role_base_wsp_prices'][ $variation_id ], '' );

				foreach ($role_base_wsp_prices as $key => $value) {
					if (!isset($value['discount_value']) || '' == $value['discount_value']) {
						$role_base_wsp_prices[ $key ]['discount_value'] = 0;
					}
					if (!isset($value['min_qty']) || '' == $value['min_qty'] || '0' == $value['min_qty'] ) {
						$role_base_wsp_prices[ $key ]['min_qty'] = 1;
					}
					if (!isset($value['max_qty']) || '' == $value['max_qty'] ) {
						$role_base_wsp_prices[ $key ]['max_qty'] = 0;
					}
				}
				


			} else {
				$role_base_wsp_prices = '';
			}

			if ( '' != $role_base_wsp_prices ) {
				update_post_meta( $variation_id, '_role_base_wsp_price', $role_base_wsp_prices );
			} else {
				update_post_meta( $variation_id, '_role_base_wsp_price', '' );
			}
		}

		public function wsp_add_custom_meta_box() {

			add_meta_box( 'wsp-meta-box', esc_html__( 'Rule Details', 'addify_wholesale_prices' ), array( $this, 'wsp_meta_box_callback' ), 'af_wholesale_price', 'normal', 'high', null );
		}

		public function af_wsp_get_all_categories() {

			$af_wsp_product_categories = get_terms(
				'product_cat'
			);
		
			$af_wsp_category_ids = array();
		
			if ( ! empty( $af_wsp_product_categories ) && ! is_wp_error( $af_wsp_product_categories ) ) {
				foreach ( $af_wsp_product_categories as $category ) {
					$af_wsp_category_id = $category->term_id;
		
					$af_wsp_category_ids[] = $af_wsp_category_id;
				}
			}
		
			return $af_wsp_category_ids;
		}

		public function wsp_meta_box_callback() {

			global $post;
			wp_nonce_field( 'wsp_nonce_action', 'wsp_nonce_field' );

			$rcus_base_wsp_price  = get_post_meta( $post->ID, 'rcus_base_wsp_price', true );
			$rrole_base_wsp_price = get_post_meta( $post->ID, 'rrole_base_wsp_price', true );

			$af_wsp_categories = $this->af_wsp_get_all_categories();
			

			include ADDIFY_WSP_PLUGINDIR . 'afwsp_rule_level.php';
		}

		public function wsp_add_custom_meta_save( $post_id ) {

			// Fail if we're doing an auto save
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

// For custom post type:
$exclude_statuses = array(
	'auto-draft',
	'trash',
);

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

			if (!current_user_can('edit_post', $post_id) || in_array(get_post_status($post_id), $exclude_statuses) || is_ajax() || 'untrash' === $action) {
			return;
			}

			if ( isset( $_POST['wsp_rules'] ) ) {

				if ( ! empty( $_REQUEST['wsp_nonce_field'] ) ) {

					$retrieved_nonce = sanitize_text_field( $_REQUEST['wsp_nonce_field'] );
				} else {
					$retrieved_nonce = 0;
				}

				if ( ! wp_verify_nonce( $retrieved_nonce, 'wsp_nonce_action' ) ) {

					die( 'Failed security check' );
				}
			}

			remove_action( 'save_post_af_wholesale_price', array( $this, 'wsp_add_custom_meta_save' ) );

			if ( isset( $_POST['wsp_rule_priority'] ) ) {
				wp_update_post(
					array(
						'ID'         => intval( $post_id ),
						'menu_order' => sanitize_text_field( $_POST['wsp_rule_priority'] ),
					)
				);
			}

			add_action( 'save_post_af_wholesale_price', array( $this, 'wsp_add_custom_meta_save' ) );

			if ( isset( $_POST['wsp_apply_on_all_products'] ) ) {
				update_post_meta( $post_id, 'wsp_apply_on_all_products', sanitize_text_field( $_POST['wsp_apply_on_all_products'] ) );
			} else {
				delete_post_meta( $post_id, 'wsp_apply_on_all_products', '' );
			}

			if ( isset( $_POST['wsp_applied_on_products'] ) ) {
				update_post_meta( $post_id, 'wsp_applied_on_products', sanitize_meta( '', $_POST['wsp_applied_on_products'], '' ) );
			} else {
				delete_post_meta( $post_id, 'wsp_applied_on_products' );
			}

			if ( isset( $_POST['wsp_applied_on_categories'] ) ) {
				update_post_meta( $post_id, 'wsp_applied_on_categories', sanitize_meta( '', $_POST['wsp_applied_on_categories'], '' ) );
			} else {
				delete_post_meta( $post_id, 'wsp_applied_on_categories' );
			}

			if ( isset( $_POST['rcus_base_wsp_price'] ) ) {
				$rcus_base_wsp_price = sanitize_meta( '', $_POST['rcus_base_wsp_price'], '' );
				foreach ($rcus_base_wsp_price as $key => $value) {
					if (!isset($value['discount_value']) || '' == $value['discount_value']) {
						$rcus_base_wsp_price[ $key ]['discount_value'] = 0;
					}
					if (!isset($value['min_qty']) || '' == $value['min_qty'] || '0' == $value['min_qty'] ) {
						$rcus_base_wsp_price[ $key ]['min_qty'] = 1;
					}
					if (!isset($value['max_qty']) || '' == $value['max_qty'] ) {
						$rcus_base_wsp_price[ $key ]['max_qty'] = 0;
					}
				}
				update_post_meta( $post_id, 'rcus_base_wsp_price', $rcus_base_wsp_price );
			} else {
				delete_post_meta( $post_id, 'rcus_base_wsp_price' );
			}

			if ( isset( $_POST['rrole_base_wsp_price'] ) ) {
				$rrole_base_wsp_price = sanitize_meta( '', $_POST['rrole_base_wsp_price'], '' );
				foreach ($rrole_base_wsp_price as $key => $value) {
					if (!isset($value['discount_value']) || '' == $value['discount_value'] ) {
						$rrole_base_wsp_price[ $key ]['discount_value'] = 0;
					}
					if (!isset($value['min_qty']) || '' == $value['min_qty'] || '0' == $value['min_qty']) {
						$rrole_base_wsp_price[ $key ]['min_qty'] = 1;
					}
					if (!isset($value['max_qty']) || '' == $value['max_qty']) {
						$rrole_base_wsp_price[ $key ]['max_qty'] = 0;
					}
				}
				update_post_meta( $post_id, 'rrole_base_wsp_price', $rrole_base_wsp_price );
			} else {
				delete_post_meta( $post_id, 'rrole_base_wsp_price' );
			}
		}

		public function wspsearchUsers() {

			if ( isset( $_POST['nonce'] ) && '' != $_POST['nonce'] ) {

				$nonce = sanitize_text_field( $_POST['nonce'] );
			} else {
				$nonce = 0;
			}

			if ( isset( $_POST['q'] ) && '' != $_POST['q'] ) {

				if ( ! wp_verify_nonce( $nonce, 'afwsp-ajax-nonce' ) ) {

					die( 'Failed ajax security check!' );
				}

				$pro = sanitize_text_field( $_POST['q'] );

			} else {

				$pro = '';

			}

			$data_array  = array();
			$users       = new WP_User_Query(
				array(
					'search'         => '*' . esc_attr( $pro ) . '*',
					'search_columns' => array(
						'user_login',
						'user_nicename',
						'user_email',
						'user_url',
					),
				)
			);
			$users_found = $users->get_results();

			if ( ! empty( $users_found ) ) {

				foreach ( $users_found as $proo ) {

					$title        = $proo->display_name . '(' . $proo->user_email . ')';
					$data_array[] = array( $proo->ID, $title );
				}
			}

			echo json_encode( $data_array );

			die();
		}

		public function wspsearchProducts() {

			if ( isset( $_POST['nonce'] ) && '' != $_POST['nonce'] ) {

				$nonce = sanitize_text_field( $_POST['nonce'] );
			} else {
				$nonce = 0;
			}

			if ( isset( $_POST['q'] ) && '' != $_POST['q'] ) {

				if ( ! wp_verify_nonce( $nonce, 'afwsp-ajax-nonce' ) ) {

					die( 'Failed ajax security check!' );
				}

				$pro = sanitize_text_field( $_POST['q'] );

			} else {

				$pro = '';

			}

			$data_array = array();
			$args       = array(
				'post_type'   => array( 'product' ),
				'post_status' => 'publish',
				'numberposts' => -1,
				's'           => $pro,
			);
			$pros       = get_posts( $args );

			if ( ! empty( $pros ) ) {

				foreach ( $pros as $proo ) {

					$title        = ( mb_strlen( $proo->post_title ) > 50 ) ? mb_substr( $proo->post_title, 0, 49 ) . '...' : $proo->post_title;
					$data_array[] = array( $proo->ID, $title ); // array( Post ID, Post Title )
				}
			}

			echo json_encode( $data_array );

			die();
		}

		public function afwsp_settings_page() {

			if ( isset( $_GET['tab'] ) ) {  
				$active_tab = sanitize_text_field($_GET['tab']);  
			} else {
				$active_tab = 'tab_one';
			}
			?>
				<div class="wrap addify_apnu_main_wrap">

					<?php settings_errors(); ?> 

					<ul class="subsubsub">  
					
						<li><a href="admin.php?page=addify-wsp-settings&tab=tab_one" class=" <?php echo esc_attr($active_tab) == 'tab_one' ? 'current' : ''; ?>"><?php echo esc_html__('General Settings', 'addify_wholesale_prices'); ?></a> |  </li>

						<li><a href="admin.php?page=addify-wsp-settings&tab=tab_two" class=" <?php echo esc_attr($active_tab) == 'tab_two' ? 'current' : ''; ?>"><?php echo esc_html__('Pricing Template Settings', 'addify_wholesale_prices'); ?></a> | </li>

						<li><a href="admin.php?page=addify-wsp-settings&tab=tab_three" class="<?php echo esc_attr($active_tab) == 'tab_three' ? 'current' : ''; ?>"><?php echo esc_html__('Price Settings', 'addify_wholesale_prices'); ?></a> </li>

						<!-- <a href="edit.php?post_type=af_wholesale_price&page=addify-wsp-settings&tab=tab_four" class="nav-tab <?php echo esc_attr($active_tab) == 'tab_four' ? 'nav-tab-active' : ''; ?>"><?php //echo esc_html__('ShortCode', 'addify_wholesale_prices'); ?></a>  -->
						
					</ul>
					<br class="clear">

					<form method="post" action="options.php"> 
						<?php
						if ( 'tab_one' == $active_tab ) {  
							settings_fields( 'addify-wsp-setting-group-1' );
							do_settings_sections( 'addify-wsp-1' );
						}

						if ( 'tab_two' == $active_tab ) {  
							settings_fields( 'addify-wsp-setting-group-2' );
							do_settings_sections( 'addify-wsp-2' );
						}

						if ( 'tab_three' == $active_tab ) {  
							settings_fields( 'addify-wsp-setting-group-3' );
							do_settings_sections( 'addify-wsp-3' );
						}

						if ( 'tab_four' == $active_tab ) {  
							settings_fields( 'addify-wsp-setting-group-4' );
							do_settings_sections( 'addify-wsp-4' );
						}

						
						?>
						<?php submit_button(esc_html__('Save Settings', 'addify_wholesale_prices' ), 'primary', 'afwholesale_save_settings'); ?>
					</form> 

				</div>
			<?php 
		}

		public function afwsp_options() {

			$this->wsp_load();

			//Tab 1
			add_settings_section(  
				'page_1_section',
				'',
				array( $this, 'addify_wsp_page_1_section_callback' ), 
				'addify-wsp-1'  
			);

			add_settings_field (   
				'addify_wsp_enable_table', 
				esc_html__('Enable Tiered Pricing Template', 'addify_wholesale_prices'),  
				array( $this, 'addify_wsp_enable_table_callback' ), 
				'addify-wsp-1', 
				'page_1_section', 
				array(  
					esc_html__('Enable tiered pricing template(table/list/card) on the product page.', 'addify_wholesale_prices'),
				)  
			);  
			register_setting(  
				'addify-wsp-setting-group-1',  
				'addify_wsp_enable_table',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			// add_settings_field (   
			//  'addify_wsp_table_position', 
			//  esc_html__('Tiered Pricing Table Position', 'addify_wholesale_prices'),  
			//  array($this, 'addify_wsp_table_position_callback'), 
			//  'addify-wsp-1', 
			//  'page_1_section', 
			//  array(  
			//      esc_html__('Tiered pricing table position on the product page.', 'addify_wholesale_prices'),
			//  )  
			// );  
			// register_setting(  
			//  'addify-wsp-setting-group-1',  
			//  'addify_wsp_table_position'  
			// );

			add_settings_field (   
				'addify_wsp_enfore_min_max_qty', 
				esc_html__('Enforce Min & Max Quantity', 'addify_wholesale_prices'),  
				array( $this, 'addify_wsp_enfore_min_max_qty_callback' ), 
				'addify-wsp-1', 
				'page_1_section', 
				array(  
					esc_html__('If this option is enabled, the user will not be allowed to add to cart beyond the minimum and maximum quantity.', 'addify_wholesale_prices'),
				)  
			);  
			register_setting(  
				'addify-wsp-setting-group-1',  
				'addify_wsp_enfore_min_max_qty',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field (   
				'addify_wsp_disable_coupon', 
				esc_html__('Disable Coupon', 'addify_wholesale_prices'),  
				array( $this, 'addify_wsp_disable_coupon_callback' ), 
				'addify-wsp-1', 
				'page_1_section', 
				array(  
					esc_html__('If this option is enabled, then coupon will be disabled if cart contains product on which price rule applied.', 'addify_wholesale_prices'),
				)  
			);  
			register_setting(  
				'addify-wsp-setting-group-1',  
				'addify_wsp_disable_coupon',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_min_qty_error_msg', 
				esc_html__('Min Qty Error Message', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_min_qty_error_msg_callback' ),
				'addify-wsp-1',
				'page_1_section',
				array(
					wp_kses_post('This message will be used when user add quantity less than minimum qty set. Use "%u" for number of quantity.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-1',  
				'addify_wsp_min_qty_error_msg',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_max_qty_error_msg', 
				esc_html__('Max Qty Error Message', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_max_qty_error_msg_callback' ),
				'addify-wsp-1',
				'page_1_section',
				array(
					wp_kses_post('This message will be used when user add quantity greater than maximum qty set. Use "%u" for number of quantity.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-1',  
				'addify_wsp_max_qty_error_msg',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_update_cart_error_msg', 
				esc_html__('Update Cart Error Message', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_update_cart_error_msg_callback' ),
				'addify-wsp-1',
				'page_1_section',
				array(
					wp_kses_post('This message will be used when user update product in cart. Use "%pro" for Product Name, "%min" for Minimum Quantity and "%max" for Maximum Quantity.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-1',  
				'addify_wsp_update_cart_error_msg',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);


			//Tab 2
			add_settings_section(  
				'page_1_section',
				'',
				array( $this, 'addify_wsp_page_2_section_callback' ), 
				'addify-wsp-2'  
			);
			
			add_settings_field(   
				'addify_wsp_pricing_design_type', 
				esc_html__('Wholesale Pricing Design', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_pricing_design_type_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Select the wholesale pricing design template.', 'addify_wholesale_prices'),
				)
				);  
				register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_pricing_design_type',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			

			add_settings_field(   
				'addify_wsp_enable_template_heading', 
				esc_html__('Enable Template Heading', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_enable_template_heading_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Enable the heading for template.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_enable_template_heading',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				) 
			);

			add_settings_field(   
				'addify_wsp_template_heading_text', 
				esc_html__('Template Heading Text', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_template_heading_text_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Enter template heading text.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_template_heading_text',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_template_heading_text_font_size', 
				esc_html__('Template Heading Font Size', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_template_heading_text_font_size_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Enter font size for template heading, by default theme values will be inherited.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_template_heading_text_font_size',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_enable_template_icon', 
				esc_html__('Enable Template Icon', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_enable_template_icon_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Enable the icon for template.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_enable_template_icon',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_template_icon', 
				esc_html__('Upload Template Icon', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_template_icon_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Upload the icon for template. Leave it blank to use default icon.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_template_icon',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_template_font_family', 
				esc_html__('Enter Font Family for Template', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_template_font_family_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__("Specify the font family for the template text, or leave it blank to use the website's default font family.", 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_template_font_family',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			


			add_settings_field(   
				'addify_wsp_table_header_color', 
				esc_html__('Table Header Color', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_table_header_color_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Choose table header background color.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_table_header_color',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_table_header_text_color', 
				esc_html__('Table Header Text Color', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_table_header_text_color_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Choose table header text color.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_table_header_text_color',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_table_odd_rows_color', 
				esc_html__('Table Odd Rows Color', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_table_odd_rows_color_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Choose table odd rows background color.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_table_odd_rows_color',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_table_odd_rows_text_color', 
				esc_html__('Table Odd Rows Text Color', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_table_odd_rows_text_color_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Choose table odd rows text color.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_table_odd_rows_text_color',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_table_even_rows_color', 
				esc_html__('Table Even Rows Color', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_table_even_rows_color_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Choose table even rows background color.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_table_even_rows_color',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);


			add_settings_field(   
				'addify_wsp_table_even_rows_text_color', 
				esc_html__('Table Even Rows Text Color', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_table_even_rows_text_color_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Choose table even rows text color.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_table_even_rows_text_color',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);


			add_settings_field(   
				'addify_wsp_enable_table_border', 
				esc_html__('Enable Table Border', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_enable_table_border_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Enable if do you want to use table border as a separator.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_enable_table_border',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_table_border_color', 
				esc_html__('Table Border Color', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_table_border_color_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Choose table border color.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_table_border_color',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_table_header_font_size', 
				esc_html__('Table Header Font Size', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_table_header_font_size_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Font size for table header, by default theme values will be inherited.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_table_header_font_size',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_table_rows_font_size', 
				esc_html__('Table Rows Font Size', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_table_rows_font_size_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Font size for table rows, by default theme values will be inherited.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_table_rows_font_size',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			//list fields

			add_settings_field(   
				'addify_wsp_list_border_color', 
				esc_html__('List Border Color', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_list_border_color_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Choose list border color.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_list_border_color',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_list_background_color', 
				esc_html__('List Background Color', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_list_background_color_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Choose list background color.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_list_background_color',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_list_text_color', 
				esc_html__('List Text Color', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_list_text_color_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Choose list text color.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_list_text_color',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);


			add_settings_field(   
				'addify_wsp_selected_list_background_color', 
				esc_html__('Selected List Background Color', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_selected_list_background_color_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Choose selected list background color.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_selected_list_background_color',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_selected_list_text_color', 
				esc_html__('Selected List Text Color', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_selected_list_text_color_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Choose selected list text color.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_selected_list_text_color',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			//card fields
			add_settings_field(   
				'addify_wsp_card_border_color', 
				esc_html__('Card Border Color', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_card_border_color_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Choose card border color.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_card_border_color',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_card_background_color', 
				esc_html__('Card Background Color', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_card_background_color_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Choose card background color.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_card_background_color',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_card_text_color', 
				esc_html__('Card Text Color', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_card_text_color_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Choose card text color.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_card_text_color',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);


			add_settings_field(   
				'addify_wsp_selected_card_border_color', 
				esc_html__('Selected Card Border Color', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_selected_card_border_color_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Choose selected card border color.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_selected_card_border_color',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);


			add_settings_field(   
				'addify_wsp_enable_card_sale_tag', 
				esc_html__('Enable Sale Tag', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_enable_card_sale_tag_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Enable sale tag for card.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_enable_card_sale_tag',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			add_settings_field(   
				'addify_wsp_sale_tag_background_color', 
				esc_html__('Sale Tag Background Color', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_sale_tag_background_color_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Choose sale tag background color.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_sale_tag_background_color',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			

			add_settings_field(   
				'addify_wsp_sale_tag_text_color', 
				esc_html__('Sale Tag Text Color', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_sale_tag_text_color_callback' ),
				'addify-wsp-2',
				'page_1_section',
				array(
					esc_html__('Choose sale tag text color.', 'addify_wholesale_prices'),
				)
			);  
			register_setting(  
				'addify-wsp-setting-group-2',  
				'addify_wsp_sale_tag_text_color',
				array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);


			//Tab 3
			add_settings_section(  
				'page_1_section',
				'',
				array( $this, 'addify_wsp_page_3_section_callback' ), 
				'addify-wsp-3'  
			);

			add_settings_field(   
				'addify_wsp_discount_price', 
				esc_html__('Price setting by user role', 'addify_wholesale_prices'),
				array( $this, 'addify_wsp_discount_price_callback' ),
				'addify-wsp-3',
				'page_1_section',
				array()
			);  
			register_setting(  
				'addify-wsp-setting-group-3',  
				'addify_wsp_discount_price'
				// array(
				//  'type' => 'string',
				//  'sanitize_callback' => 'sanitize_text_field',
				// )
			);
		}


		//Tab 1
		public function addify_wsp_page_1_section_callback() { 
			?>
			<p><?php echo esc_html__('Manage wholesale prices plugin general settings from here.', 'addify_wholesale_prices'); ?></p>
			<?php 
		}

		public function addify_wsp_enable_table_callback( $args ) {  
			?>
			<input type="checkbox" id="addify_wsp_enable_table" name="addify_wsp_enable_table" value="yes" <?php echo checked('yes', esc_attr( get_option('addify_wsp_enable_table'))); ?> >
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_table_position_callback( $args ) {  
			?>
			<select name="addify_wsp_table_position" id="addify_wsp_table_position">
				<option value="before_add_to_cart" <?php echo selected('before_add_to_cart', esc_attr( get_option('addify_wsp_table_position'))); ?>><?php esc_html_e('Before Add to Cart', 'addify_wholesale_prices'); ?></option>
				<option value="product_tab" <?php echo selected('product_tab', esc_attr( get_option('addify_wsp_table_position'))); ?>><?php esc_html_e('Tab', 'addify_wholesale_prices'); ?></option>
			</select>
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_enfore_min_max_qty_callback( $args ) {  
			?>
			<input type="checkbox" id="addify_wsp_enfore_min_max_qty" name="addify_wsp_enfore_min_max_qty" value="yes" <?php echo checked('yes', esc_attr( get_option('addify_wsp_enfore_min_max_qty'))); ?> >
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}
		
		public function addify_wsp_disable_coupon_callback( $args ) {
			?>
			<input type="checkbox" id="addify_wsp_disable_coupon" name="addify_wsp_disable_coupon" value="yes" <?php echo checked('yes', esc_attr( get_option('addify_wsp_disable_coupon'))); ?> >
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php  
		}

		public function addify_wsp_min_qty_error_msg_callback( $args ) {  
			get_option('addify_wsp_min_qty_error_msg') && '' != get_option('addify_wsp_min_qty_error_msg')? get_option('addify_wsp_min_qty_error_msg'):update_option( 'addify_wsp_min_qty_error_msg', 'Kindly enter quantity greater than %u.' );
			?>
			<input type="text"  name="addify_wsp_min_qty_error_msg" id="addify_wsp_min_qty_error_msg" class="login_title2" value="<?php echo esc_attr(get_option('addify_wsp_min_qty_error_msg')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_max_qty_error_msg_callback( $args ) {  
			get_option('addify_wsp_max_qty_error_msg') && '' != get_option('addify_wsp_max_qty_error_msg')? get_option('addify_wsp_max_qty_error_msg'):update_option( 'addify_wsp_max_qty_error_msg', 'Kindly enter quantity less than %u.' );

			?>
			<input type="text"  name="addify_wsp_max_qty_error_msg" id="addify_wsp_max_qty_error_msg" class="login_title2" value="<?php echo esc_attr(get_option('addify_wsp_max_qty_error_msg')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_update_cart_error_msg_callback( $args ) {  
			get_option('addify_wsp_update_cart_error_msg') && '' != get_option('addify_wsp_update_cart_error_msg')? get_option('addify_wsp_update_cart_error_msg'):update_option( 'addify_wsp_update_cart_error_msg', 'Kindly enter value between %min and  %max.' );

			?>
			<input type="text"  name="addify_wsp_update_cart_error_msg" id="addify_wsp_update_cart_error_msg" class="login_title2" value="<?php echo esc_attr(get_option('addify_wsp_update_cart_error_msg')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}



		//Tab 2
		public function addify_wsp_page_2_section_callback() { 
			?>
			<?php 
		}

		
		public function addify_wsp_pricing_design_type_callback( $args ) {  
			if (!get_option('addify_wsp_pricing_design_type')) {
				update_option('addify_wsp_pricing_design_type', 'table');
			}
			?>
			<select name="addify_wsp_pricing_design_type" id="addify_wsp_pricing_design_type">
				<option value="table" <?php selected( get_option('addify_wsp_pricing_design_type'), 'table' ); ?>>Table</option>
				<option value="list" <?php selected( get_option('addify_wsp_pricing_design_type'), 'list' ); ?>>List</option>
				<option value="card" <?php selected( get_option('addify_wsp_pricing_design_type'), 'card' ); ?>>Card</option>
			</select>
			<p class="description"><?php echo esc_attr($args[0]); ?></p>
			<img class='afwsp_table_img' src="<?php echo esc_url(ADDIFY_WSP_URL . 'assets/img/table.png'); ?>" style='display:none'/>
			<img class='afwsp_card_img' src="<?php echo esc_url(ADDIFY_WSP_URL . 'assets/img/card.png'); ?>" style='display:none'/>
			<img class='afwsp_list_img' src="<?php echo esc_url(ADDIFY_WSP_URL . 'assets/img/list.png'); ?>" style='display:none'/>
			<?php      
		}

		public function addify_wsp_enable_template_heading_callback( $args ) {  
			?>
			<input type="checkbox" id="addify_wsp_enable_template_heading" name="addify_wsp_enable_template_heading" value="yes" <?php echo checked('yes', esc_attr( get_option('addify_wsp_enable_template_heading'))); ?> >
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}
		
		public function addify_wsp_template_heading_text_callback( $args ) { 
			if (!get_option('addify_wsp_template_heading_text') || '' == get_option('addify_wsp_template_heading_text')) {
				update_option('addify_wsp_template_heading_text', 'Select your Deal');
			} 
			?>
			<input type="text"  name="addify_wsp_template_heading_text" id="addify_wsp_template_heading_text" value="<?php echo esc_attr(get_option('addify_wsp_template_heading_text')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_template_heading_text_font_size_callback( $args ) {  
			if (!get_option('addify_wsp_template_heading_text_font_size') || '' == get_option('addify_wsp_template_heading_text_font_size')) {
				update_option('addify_wsp_template_heading_text_font_size', '28');
			} 
			?>
			<input type="text"  name="addify_wsp_template_heading_text_font_size" id="addify_wsp_template_heading_text_font_size" value="<?php echo esc_attr(get_option('addify_wsp_template_heading_text_font_size')); ?>" />px
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}
		
		public function addify_wsp_enable_template_icon_callback( $args ) {  
			?>
			<input type="checkbox" id="addify_wsp_enable_template_icon" name="addify_wsp_enable_template_icon" value="yes" <?php echo checked('yes', esc_attr( get_option('addify_wsp_enable_template_icon'))); ?> >
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_template_font_family_callback( $args ) {  
			?>
			<input type="text"  name="addify_wsp_template_font_family" id="addify_wsp_template_font_family" value="<?php echo esc_attr(get_option('addify_wsp_template_font_family')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}
		

		public function addify_wsp_template_icon_callback( $args ) {  
			$image = get_option( 'addify_wsp_template_icon' );
			?>
			<div id='addify_wsp_template_icon'>
				<div >
					<img id="afwsp_selected_image_display" src="<?php echo esc_url( $image ); ?>" width="50" />
				</div>		
				<input type="hidden" value="<?php echo esc_url( $image ); ?>" name="addify_wsp_template_icon" id="afwsp_template_icon">
				<input  type="button" name="addify_wsp_template_icon" id="upload-image-btn" class="button-secondary" value="<?php echo esc_html__( 'Upload Image', 'addify_wholesale_prices' ); ?>">
				<input type="button" name="addify_wsp_template_icon" id="remove_image_upload" style="height: 30px;" value="<?php echo esc_html__( 'Remove Image', 'addify_wholesale_prices' ); ?>" > 		
				<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			</div>
			<?php      
		}
		
		//table template settings
		public function addify_wsp_table_header_color_callback( $args ) { 
			if (!get_option('addify_wsp_table_header_color')) {
				update_option('addify_wsp_table_header_color', '#FFFFFF');
			}
			?>
			<input type="color"  name="addify_wsp_table_header_color" class="afwsp_table_row" id="addify_wsp_table_header_color" value="<?php echo esc_attr(get_option('addify_wsp_table_header_color')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_table_odd_rows_color_callback( $args ) {  
			if (!get_option('addify_wsp_table_odd_rows_color')) {
				update_option('addify_wsp_table_odd_rows_color', '#FFFFFF');
			}
			?>
			<input type="color"  name="addify_wsp_table_odd_rows_color" class="afwsp_table_row" id="addify_wsp_table_odd_rows_color" value="<?php echo esc_attr(get_option('addify_wsp_table_odd_rows_color')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_table_even_rows_color_callback( $args ) { 
			if (!get_option('addify_wsp_table_even_rows_color')) {
				update_option('addify_wsp_table_even_rows_color', '#FFFFFF');
			} 
			?>
			<input type="color"  name="addify_wsp_table_even_rows_color" class="afwsp_table_row" id="addify_wsp_table_even_rows_color" value="<?php echo esc_attr(get_option('addify_wsp_table_even_rows_color')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_table_header_text_color_callback( $args ) {  
			if (!get_option('addify_wsp_table_header_text_color')) {
				update_option('addify_wsp_table_header_text_color', '#000000');
			} 
			?>
			<input type="color"  name="addify_wsp_table_header_text_color" class="afwsp_table_row" id="addify_wsp_table_header_text_color" value="<?php echo esc_attr(get_option('addify_wsp_table_header_text_color')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_table_odd_rows_text_color_callback( $args ) {  
			if (!get_option('addify_wsp_table_odd_rows_text_color')) {
				update_option('addify_wsp_table_odd_rows_text_color', '#000000');
			} 
			?>
			<input type="color"  name="addify_wsp_table_odd_rows_text_color" class="afwsp_table_row" id="addify_wsp_table_odd_rows_text_color" value="<?php echo esc_attr(get_option('addify_wsp_table_odd_rows_text_color')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_table_even_rows_text_color_callback( $args ) {  
			if (!get_option('addify_wsp_table_even_rows_text_color')) {
				update_option('addify_wsp_table_even_rows_text_color', '#000000');
			} 
			?>
			<input type="color"  name="addify_wsp_table_even_rows_text_color" class="afwsp_table_row" id="addify_wsp_table_even_rows_text_color" value="<?php echo esc_attr(get_option('addify_wsp_table_even_rows_text_color')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_enable_table_border_callback( $args ) {  
			if (!get_option('addify_wsp_enable_table_border')) {
				update_option('addify_wsp_enable_table_border', 'yes');
			} 

			?>
			<input type="checkbox" id="addify_wsp_enable_table_border" class="afwsp_table_row" name="addify_wsp_enable_table_border" value="yes" <?php echo checked('yes', esc_attr( get_option('addify_wsp_enable_table_border'))); ?> >
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}
		
		public function addify_wsp_table_border_color_callback( $args ) { 
			if (!get_option('addify_wsp_table_border_color')) {
				update_option('addify_wsp_table_border_color', '#CFCFCF');
			} 

			?>
			<input type="color"  name="addify_wsp_table_border_color" class="afwsp_table_row" id="addify_wsp_table_border_color" value="<?php echo esc_attr(get_option('addify_wsp_table_border_color')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_table_header_font_size_callback( $args ) {  
			if (!get_option('addify_wsp_table_header_font_size') || '' == get_option('addify_wsp_table_header_font_size')) {
				update_option('addify_wsp_table_header_font_size', '18');
			} 
			?>
			<input type="text"  name="addify_wsp_table_header_font_size" class="afwsp_table_row" id="addify_wsp_table_header_font_size" value="<?php echo esc_attr(get_option('addify_wsp_table_header_font_size')); ?>" />px
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_table_rows_font_size_callback( $args ) {  
			if (!get_option('addify_wsp_table_rows_font_size') || '' == get_option('addify_wsp_table_rows_font_size')) {
				update_option('addify_wsp_table_rows_font_size', '16');
			} 

			?>
			<input type="text"  name="addify_wsp_table_rows_font_size" class="afwsp_table_row" id="addify_wsp_table_rows_font_size" value="<?php echo esc_attr(get_option('addify_wsp_table_rows_font_size')); ?>" />px
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		//list template settings
		
		public function addify_wsp_list_border_color_callback( $args ) {  
			if (!get_option('addify_wsp_list_border_color')) {
				update_option('addify_wsp_list_border_color', '#95B0EE');
			} 

			?>
			<input type="color"  name="addify_wsp_list_border_color" class="afwsp_list_row" id="addify_wsp_list_border_color" value="<?php echo esc_attr(get_option('addify_wsp_list_border_color')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_list_background_color_callback( $args ) { 
			if (!get_option('addify_wsp_list_background_color')) {
				update_option('addify_wsp_list_background_color', '#FFFFFF');
			}  
			?>
			<input type="color"  name="addify_wsp_list_background_color" class="afwsp_list_row" id="addify_wsp_list_background_color" value="<?php echo esc_attr(get_option('addify_wsp_list_background_color')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}
		public function addify_wsp_list_text_color_callback( $args ) { 
			if (!get_option('addify_wsp_list_text_color')) {
				update_option('addify_wsp_list_text_color', '#000000');
			}  
			?>
			<input type="color"  name="addify_wsp_list_text_color" class="afwsp_list_row" id="addify_wsp_list_text_color" value="<?php echo esc_attr(get_option('addify_wsp_list_text_color')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_selected_list_background_color_callback( $args ) { 
			if (!get_option('addify_wsp_selected_list_background_color')) {
				update_option('addify_wsp_selected_list_background_color', '#DFEBFF');
			}   
			?>
			<input type="color"  name="addify_wsp_selected_list_background_color" class="afwsp_list_row" id="addify_wsp_selected_list_background_color" value="<?php echo esc_attr(get_option('addify_wsp_selected_list_background_color')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}
		public function addify_wsp_selected_list_text_color_callback( $args ) {  
			if (!get_option('addify_wsp_selected_list_text_color')) {
				update_option('addify_wsp_selected_list_text_color', '#000000');
			}  
			?>
			<input type="color"  name="addify_wsp_selected_list_text_color" class="afwsp_list_row" id="addify_wsp_selected_list_text_color" value="<?php echo esc_attr(get_option('addify_wsp_selected_list_text_color')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		//card settings
		
		public function addify_wsp_card_border_color_callback( $args ) {  
			if (!get_option('addify_wsp_card_border_color')) {
				update_option('addify_wsp_card_border_color', '#A3B39E');
			}  
			?>
			<input type="color"  name="addify_wsp_card_border_color" class="afwsp_card_row" id="addify_wsp_card_border_color" value="<?php echo esc_attr(get_option('addify_wsp_card_border_color')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_card_background_color_callback( $args ) {  
			if (!get_option('addify_wsp_card_background_color')) {
				update_option('addify_wsp_card_background_color', '#FFFFFF');
			}  
			?>
			<input type="color"  name="addify_wsp_card_background_color" class="afwsp_card_row" id="addify_wsp_card_background_color" value="<?php echo esc_attr(get_option('addify_wsp_card_background_color')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_card_text_color_callback( $args ) {  
			if (!get_option('addify_wsp_card_text_color')) {
				update_option('addify_wsp_card_text_color', '#000000');
			}  
			?>
			<input type="color"  name="addify_wsp_card_text_color" class="afwsp_card_row" id="addify_wsp_card_text_color" value="<?php echo esc_attr(get_option('addify_wsp_card_text_color')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_selected_card_border_color_callback( $args ) {  
			if (!get_option('addify_wsp_selected_card_border_color')) {
				update_option('addify_wsp_selected_card_border_color', '#27CA34');
			}  
			?>
			<input type="color"  name="addify_wsp_selected_card_border_color" class="afwsp_card_row" id="addify_wsp_selected_card_border_color" value="<?php echo esc_attr(get_option('addify_wsp_selected_card_border_color')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_enable_card_sale_tag_callback( $args ) {  
			?>
			<input type="checkbox" id="addify_wsp_enable_card_sale_tag" class="afwsp_card_row" name="addify_wsp_enable_card_sale_tag" value="yes" <?php echo checked('yes', esc_attr( get_option('addify_wsp_enable_card_sale_tag'))); ?> >
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}

		public function addify_wsp_sale_tag_background_color_callback( $args ) { 
			if (!get_option('addify_wsp_sale_tag_background_color')) {
				update_option('addify_wsp_sale_tag_background_color', '#FF0000');
			}   
			?>
			<input type="color"  name="addify_wsp_sale_tag_background_color" class="afwsp_card_row" id="addify_wsp_sale_tag_background_color" value="<?php echo esc_attr(get_option('addify_wsp_sale_tag_background_color')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}
		public function addify_wsp_sale_tag_text_color_callback( $args ) {  
			if (!get_option('addify_wsp_sale_tag_text_color')) {
				update_option('addify_wsp_sale_tag_text_color', '#FFFFFF');
			}  
			?>
			<input type="color"  name="addify_wsp_sale_tag_text_color" class="afwsp_card_row" id="addify_wsp_sale_tag_text_color" value="<?php echo esc_attr(get_option('addify_wsp_sale_tag_text_color')); ?>" />
			<p class="description"> <?php echo esc_attr($args[0]); ?> </p>
			<?php      
		}


		//Tab 3
		public function addify_wsp_page_3_section_callback() { 
			?>
			<p><?php echo esc_html__('Choose on which price wholesale tiered pricing should be applied i.e product regular price or sale price.', 'addify_wholesale_prices'); ?></p>
			<?php 
		}

		public function addify_wsp_discount_price_callback() { 
			$roles        = get_editable_roles();
			$roles_values = get_option('addify_wsp_discount_price');
			?>
			<table class="addify-table-optoin">
				<tbody>
			<?php
			foreach ( $roles as $key => $value ) { 

				$radio = isset( $roles_values[ $key ] ) ? $roles_values[ $key ] : '';
				?>
				
				<tr class="addify-option-field">
					<th>
						<div class="option-head">
							<b><?php echo esc_attr(translate_user_role( $value['name'], 'default' )); ?></b>
						</div>
					</th>
					<td>
						<input type="radio" value="regular" name="addify_wsp_discount_price[<?php echo esc_html( $key ); ?>]" <?php echo checked('regular', $radio); ?> ><?php echo esc_html__('Regular Price', 'addify_wholesale_prices'); ?>
						<input type="radio" value="sale" name="addify_wsp_discount_price[<?php echo esc_html( $key ); ?>]" <?php echo checked('sale', $radio); ?> ><?php echo esc_html__('Sale Price', 'addify_wholesale_prices'); ?>
					</td>
				</tr>
				
				<?php
			}
			$radio = isset( $roles_values['guest'] ) ? $roles_values['guest'] : '';
			?>
				<tr class="addify-option-field">
					<th>
						<div class="option-head">
							<b><?php echo esc_html__( 'Guest', 'addify_wholesale_prices' ); ?></b>
						</div>
					</th>
					<td>
						<input type="radio" value="regular" name="addify_wsp_discount_price[guest]" <?php echo checked('regular', $radio); ?> ><?php echo esc_html__('Regular Price', 'addify_wholesale_prices'); ?>
						<input type="radio" value="sale" name="addify_wsp_discount_price[guest]" <?php echo checked('sale', $radio); ?> ><?php echo esc_html__('Sale Price', 'addify_wholesale_prices'); ?>
					</td>
				</tr>
			</tbody>
				</table>
			
			<?php
		}

		public function wsp_load() {

			// get Rules
			$args = array(
				'post_type'   => 'af_wholesale_price',
				'post_status' => 'publish',
				'orderby'     => 'menu_order',
				'order'       => 'ASC',
				'numberposts' => -1,
			// 'suppress_filters' => true,
			);

			$all_new_rules = get_posts( $args );

			foreach ( $all_new_rules as $rule ) {

				if ( ! empty( get_post_meta( $rule->ID, 'wsp_applied_on_products', true ) ) ) {
					$products = get_post_meta( $rule->ID, 'wsp_applied_on_products', true );
				} else {
					$products = array();
				}

				$pri_pros = array();

				$new_array = array();

				
				$new_array = array_unique( array_merge( $products, $pri_pros ) );


				$rule->ProductsSession = $new_array;
				$all_new_rules_new[]   = $rule;

				$this->allfetchedrules = $all_new_rules_new;

				$categories = get_post_meta( $rule->ID, 'wsp_applied_on_categories', true );

				if (!empty($categories)) {

					$this->fatched_cats = $categories;
				} else {

					$this->fatched_cats = array();
				}

				

				
			}
		}


		public function wsp_update_order_prices_on_admin_ajax( $item_id, $item, $order ) {

			$customer_discount  = false;
			$role_discount      = false;
			$customer_discount1 = false;

			// Loop through order items
			foreach ( $order->get_items() as $item_id => $item ) {

				$item_data = $item->get_data(); // The item data
				$taxes     = array();

				foreach ( $item_data['taxes'] as $key_tax => $values ) {
					if ( ! empty( $values ) ) {
						foreach ( $values as $key => $tax_price ) {
							$taxes[ $key_tax ][ $key ] = floatval($tax_price);
						}
					}
				}

				$new_line_subtotal  = floatval( $item_data['subtotal'] );
				$new_line_subt_tax  = floatval( $item_data['subtotal_tax'] );
				$new_line_total     = floatval( $item_data['total'] );
				$new_line_total_tax = floatval( $item_data['total_tax'] );


				if (!empty($_COOKIE['af_user_cookie']) && 'guest' != $_COOKIE['af_user_cookie']) {

					$user_id = sanitize_text_field($_COOKIE['af_user_cookie']);
				} else {
					$user_id = 0;
				}

				if (0 != $item_data['variation_id']) {

					$product_id = $item_data['variation_id'];
					$parent_id  = $item_data['product_id'];

				} else {

					$product_id = $item_data['product_id'];
					$parent_id  = 0;

				}


				$user_meta = get_userdata($user_id);


				$role = $user_meta->roles; //array of roles the user is part of.

				if (!empty($role)) {

					$user_role = $role[0];
				} else {

					$user_role = 'guest';
				}
			   


				// get customer specifc price
				$cus_base_wsp_price = get_post_meta( $product_id, '_cus_base_wsp_price', true );

				// get role base price
				$role_base_wsp_price = get_post_meta( $product_id, '_role_base_wsp_price', true );

				if ( 0 != $user_id ) {

					// $this->addify_wsp_discount_price;
					//For registered users

					if ('sale' == $this->addify_wsp_discount_price[ $user_role ] && !empty(get_post_meta( $product_id, '_sale_price', true ))) {

						$pro_price = get_post_meta( $product_id, '_sale_price', true );

					} elseif ('regular' == $this->addify_wsp_discount_price[ $user_role ] && !empty(get_post_meta( $product_id, '_regular_price', true ))) {

						$pro_price = get_post_meta( $product_id, '_regular_price', true );

					} else {

						$pro_price = get_post_meta( $product_id, '_price', true );
					}


					if ( ! empty( $cus_base_wsp_price )) {

						foreach ( $cus_base_wsp_price as $cus_price ) {

							if ( isset( $cus_price['customer_name'] ) && $user_id == $cus_price['customer_name'] ) {


								if ( ( $item_data['quantity'] >= $cus_price['min_qty'] && $item_data['quantity'] <= $cus_price['max_qty'] ) 
								|| ( $item_data['quantity'] >= $cus_price['min_qty'] && '' == $cus_price['max_qty'] )
								|| ( $item_data['quantity'] >= $cus_price['min_qty'] && 0 == $cus_price['max_qty'] ) 
								|| ( '' == $cus_price['min_qty'] && $item_data['quantity'] <= $cus_price['max_qty'] ) 
								|| ( 0 == $cus_price['min_qty'] && $item_data['quantity'] <= $cus_price['max_qty'] )) {


									if ( 'fixed_price' == $cus_price['discount_type'] ) {

										$new_line_subtotal = floatval($cus_price['discount_value']*$item_data['quantity']);
										$new_line_total    = floatval($cus_price['discount_value']*$item_data['quantity']);

										$customer_discount = true;

									} elseif ( 'fixed_increase' == $cus_price['discount_type'] ) {

										$newprice = $pro_price + $cus_price['discount_value'];
										
										$new_line_subtotal = floatval($newprice*$item_data['quantity']);
										$new_line_total    = floatval($newprice*$item_data['quantity']);


										$customer_discount = true;

									} elseif ( 'fixed_decrease' == $cus_price['discount_type'] ) {

										$newprice = $pro_price - $cus_price['discount_value'];
										
										$new_line_subtotal = floatval($newprice*$item_data['quantity']);
										$new_line_total    = floatval($newprice*$item_data['quantity']);

										$customer_discount = true;

									} elseif ( 'percentage_decrease' == $cus_price['discount_type'] ) {

										$percent_price = $pro_price * $cus_price['discount_value'] / 100;

										$newprice          = $pro_price - $percent_price;
										$new_line_subtotal = floatval($newprice*$item_data['quantity']);
										$new_line_total    = floatval($newprice*$item_data['quantity']);
										
										$customer_discount = true;

									} elseif ( 'percentage_increase' == $cus_price['discount_type'] ) {

										$percent_price = $pro_price * $cus_price['discount_value'] / 100;

										$newprice = $pro_price + $percent_price;

										$new_line_subtotal = floatval($newprice*$item_data['quantity']);
										$new_line_total    = floatval($newprice*$item_data['quantity']);

										$customer_discount = true;

									}



								}


							}
						}

					}


					// Role Based Pricing
					// chcek if there is customer specific pricing then role base pricing will not work.
					if ( ! $customer_discount ) {

						if ( ! empty( $role_base_wsp_price ) ) {

							foreach ( $role_base_wsp_price as $role_price ) {

								if ( isset( $role_price['user_role'] ) && $user_role == $role_price['user_role'] ) {

									if ( ( $item_data['quantity'] >= $role_price['min_qty'] && $item_data['quantity'] <= $role_price['max_qty'] ) 
									|| ( $item_data['quantity'] >= $role_price['min_qty'] && '' == $role_price['max_qty'] )
									|| ( $item_data['quantity'] >= $role_price['min_qty'] && 0 == $role_price['max_qty'] ) 
									|| ( '' == $role_price['min_qty'] && $item_data['quantity'] <= $role_price['max_qty'] ) 
									|| ( 0 == $role_price['min_qty'] && $item_data['quantity'] <= $role_price['max_qty'] )) {


										if ( 'fixed_price' == $role_price['discount_type'] ) {

											$new_line_subtotal = floatval($role_price['discount_value']*$item_data['quantity']);
											$new_line_total    = floatval($role_price['discount_value']*$item_data['quantity']);

											$role_discount = true;

										} elseif ( 'fixed_increase' == $role_price['discount_type'] ) {

											$newprice = $pro_price + $role_price['discount_value'];
											
											$new_line_subtotal = floatval($newprice*$item_data['quantity']);
											$new_line_total    = floatval($newprice*$item_data['quantity']);


											$role_discount = true;

										} elseif ( 'fixed_decrease' == $role_price['discount_type'] ) {

											$newprice = $pro_price - $role_price['discount_value'];
											
											$new_line_subtotal = floatval($newprice*$item_data['quantity']);
											$new_line_total    = floatval($newprice*$item_data['quantity']);

											$role_discount = true;

										} elseif ( 'percentage_decrease' == $role_price['discount_type'] ) {

											$percent_price = $pro_price * $role_price['discount_value'] / 100;

											$newprice          = $pro_price - $percent_price;
											$new_line_subtotal = floatval($newprice*$item_data['quantity']);
											$new_line_total    = floatval($newprice*$item_data['quantity']);
											
											$role_discount = true;

										} elseif ( 'percentage_increase' == $role_price['discount_type'] ) {

											$percent_price = $pro_price * $role_price['discount_value'] / 100;

											$newprice = $pro_price + $percent_price;

											$new_line_subtotal = floatval($newprice*$item_data['quantity']);
											$new_line_total    = floatval($newprice*$item_data['quantity']);

											$role_discount = true;

										}

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

								$istrue     = false;
								$istrue_cat = false;

								$applied_on_all_products = get_post_meta( $rule->ID, 'wsp_apply_on_all_products', true );

								if ( 'yes' == $applied_on_all_products ) {
									$istrue = true;
								} elseif ( ! empty( $rule->ProductsSession ) && ( in_array( $product_id, $rule->ProductsSession ) || in_array( $parent_id , $rule->ProductsSession) ) ) {
									$istrue = true;
								}

								foreach ( $this->fatched_cats as $cat ) {

									if ( !empty( $cat) && has_term( $cat, 'product_cat', $parent_id ) ) {

										$istrue_cat = true;
									}
								}

								if ( $istrue || $istrue_cat ) {

									//get rule customer based price
									$rule_cus_base_wsp_price = get_post_meta( $rule->ID, 'rcus_base_wsp_price', true );

									//get rule role base price
									$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );



									if ( ! empty( $rule_cus_base_wsp_price ) ) {

										foreach ( $rule_cus_base_wsp_price as $rule_cus_price ) {

											if ( isset( $rule_cus_price['customer_name'] ) && $user_id == $rule_cus_price['customer_name'] ) {


												if ( ( $item_data['quantity'] >= $rule_cus_price['min_qty'] && $item_data['quantity'] <= $rule_cus_price['max_qty'] ) 
												|| ( $item_data['quantity'] >= $rule_cus_price['min_qty'] && '' == $rule_cus_price['max_qty'] )
												|| ( $item_data['quantity'] >= $rule_cus_price['min_qty'] && 0 == $rule_cus_price['max_qty'] ) 
												|| ( '' == $rule_cus_price['min_qty'] && $item_data['quantity'] <= $rule_cus_price['max_qty'] ) 
												|| ( 0 == $rule_cus_price['min_qty'] && $item_data['quantity'] <= $rule_cus_price['max_qty'] )) {


													if ( 'fixed_price' == $rule_cus_price['discount_type'] ) {

														$new_line_subtotal = floatval($rule_cus_price['discount_value']*$item_data['quantity']);
														$new_line_total    = floatval($rule_cus_price['discount_value']*$item_data['quantity']);

														$customer_discount1 = true;

													} elseif ( 'fixed_increase' == $rule_cus_price['discount_type'] ) {

														$newprice = $pro_price + $rule_cus_price['discount_value'];
														
														$new_line_subtotal = floatval($newprice*$item_data['quantity']);
														$new_line_total    = floatval($newprice*$item_data['quantity']);


														$customer_discount1 = true;

													} elseif ( 'fixed_decrease' == $rule_cus_price['discount_type'] ) {

														$newprice = $pro_price - $rule_cus_price['discount_value'];
														
														$new_line_subtotal = floatval($newprice*$item_data['quantity']);
														$new_line_total    = floatval($newprice*$item_data['quantity']);

														$customer_discount1 = true;

													} elseif ( 'percentage_decrease' == $rule_cus_price['discount_type'] ) {

														$percent_price = $pro_price * $rule_cus_price['discount_value'] / 100;

														$newprice          = $pro_price - $percent_price;
														$new_line_subtotal = floatval($newprice*$item_data['quantity']);
														$new_line_total    = floatval($newprice*$item_data['quantity']);
														
														$customer_discount1 = true;

													} elseif ( 'percentage_increase' == $rule_cus_price['discount_type'] ) {

														$percent_price = $pro_price * $rule_cus_price['discount_value'] / 100;

														$newprice = $pro_price + $percent_price;

														$new_line_subtotal = floatval($newprice*$item_data['quantity']);
														$new_line_total    = floatval($newprice*$item_data['quantity']);

														$customer_discount1 = true;

													}



												}


											}

										}
									}

									// Rule Role Based Pricing
									// chcek if there is customer specific pricing then role base pricing will not work.
									if ( ! $customer_discount1 ) {

										
										if ( ! empty( $rule_role_base_wsp_price ) ) {

											foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

												if ( isset( $rule_role_price['user_role'] ) && ( 'everyone' == $rule_role_price['user_role'] || $user_role == $rule_role_price['user_role'] ) ) {

													if ( ( $item_data['quantity'] >= $rule_role_price['min_qty'] && $item_data['quantity'] <= $rule_role_price['max_qty'] ) 
													|| ( $item_data['quantity'] >= $rule_role_price['min_qty'] && '' == $rule_role_price['max_qty'] )
													|| ( $item_data['quantity'] >= $rule_role_price['min_qty'] && 0 == $rule_role_price['max_qty'] ) 
													|| ( '' == $rule_role_price['min_qty'] && $item_data['quantity'] <= $rule_role_price['max_qty'] ) 
													|| ( 0 == $rule_role_price['min_qty'] && $item_data['quantity'] <= $rule_role_price['max_qty'] )) {


														if ( 'fixed_price' == $rule_role_price['discount_type'] ) {

															$new_line_subtotal = floatval($rule_role_price['discount_value']*$item_data['quantity']);
															$new_line_total    = floatval($rule_role_price['discount_value']*$item_data['quantity']);


														} elseif ( 'fixed_increase' == $rule_role_price['discount_type'] ) {

															$newprice = $pro_price + $rule_role_price['discount_value'];
															
															$new_line_subtotal = floatval($newprice*$item_data['quantity']);
															$new_line_total    = floatval($newprice*$item_data['quantity']);



														} elseif ( 'fixed_decrease' == $rule_role_price['discount_type'] ) {

															$newprice = $pro_price - $rule_role_price['discount_value'];
															
															$new_line_subtotal = floatval($newprice*$item_data['quantity']);
															$new_line_total    = floatval($newprice*$item_data['quantity']);


														} elseif ( 'percentage_decrease' == $rule_role_price['discount_type'] ) {

															$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

															$newprice          = $pro_price - $percent_price;
															$new_line_subtotal = floatval($newprice*$item_data['quantity']);
															$new_line_total    = floatval($newprice*$item_data['quantity']);
															

														} elseif ( 'percentage_increase' == $rule_role_price['discount_type'] ) {

															$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

															$newprice = $pro_price + $percent_price;

															$new_line_subtotal = floatval($newprice*$item_data['quantity']);
															$new_line_total    = floatval($newprice*$item_data['quantity']);

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









				} else {

					//Guest Users
					//For registered users
					if ('sale' == $this->addify_wsp_discount_price['guest'] && !empty(get_post_meta( $product_id, '_sale_price', true ))) {

						$pro_price = get_post_meta( $product_id, '_sale_price', true );

					} elseif ('regular' == $this->addify_wsp_discount_price['guest'] && !empty(get_post_meta( $product_id, '_regular_price', true ))) {

						$pro_price = get_post_meta( $product_id, '_regular_price', true );

					} else {

						$pro_price = get_post_meta( $product_id, '_price', true );
					}

					// Role Based Pricing for guest
					if ( true ) {

						// get role base price
						$role_base_wsp_price = get_post_meta( $product_id, '_role_base_wsp_price', true );
						
						if ( ! empty( $role_base_wsp_price ) ) {

							foreach ( $role_base_wsp_price as $role_price ) {

								if ( isset( $role_price['user_role'] ) && 'guest' == $role_price['user_role'] ) {

									if ( ( $item_data['quantity'] >= $role_price['min_qty'] && $item_data['quantity'] <= $role_price['max_qty'] ) 
									|| ( $item_data['quantity'] >= $role_price['min_qty'] && '' == $role_price['max_qty'] )
									|| ( $item_data['quantity'] >= $role_price['min_qty'] && 0 == $role_price['max_qty'] ) 
									|| ( '' == $role_price['min_qty'] && $item_data['quantity'] <= $role_price['max_qty'] ) 
									|| ( 0 == $role_price['min_qty'] && $item_data['quantity'] <= $role_price['max_qty'] )) {


										if ( 'fixed_price' == $role_price['discount_type'] ) {

											$new_line_subtotal = floatval($role_price['discount_value']*$item_data['quantity']);
											$new_line_total    = floatval($role_price['discount_value']*$item_data['quantity']);

											$role_discount = true;

										} elseif ( 'fixed_increase' == $role_price['discount_type'] ) {

											$newprice = $pro_price + $role_price['discount_value'];
											
											$new_line_subtotal = floatval($newprice*$item_data['quantity']);
											$new_line_total    = floatval($newprice*$item_data['quantity']);


											$role_discount = true;

										} elseif ( 'fixed_decrease' == $role_price['discount_type'] ) {

											$newprice = $pro_price - $role_price['discount_value'];
											
											$new_line_subtotal = floatval($newprice*$item_data['quantity']);
											$new_line_total    = floatval($newprice*$item_data['quantity']);

											$role_discount = true;

										} elseif ( 'percentage_decrease' == $role_price['discount_type'] ) {

											$percent_price = $pro_price * $role_price['discount_value'] / 100;

											$newprice          = $pro_price - $percent_price;
											$new_line_subtotal = floatval($newprice*$item_data['quantity']);
											$new_line_total    = floatval($newprice*$item_data['quantity']);
											
											$role_discount = true;

										} elseif ( 'percentage_increase' == $role_price['discount_type'] ) {

											$percent_price = $pro_price * $role_price['discount_value'] / 100;

											$newprice = $pro_price + $percent_price;

											$new_line_subtotal = floatval($newprice*$item_data['quantity']);
											$new_line_total    = floatval($newprice*$item_data['quantity']);

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

									$istrue     = false;
									$istrue_cat = false;

									$applied_on_all_products = get_post_meta( $rule->ID, 'wsp_apply_on_all_products', true );

									if ( 'yes' == $applied_on_all_products ) {
										$istrue = true;
									} elseif ( ! empty( $rule->ProductsSession ) && ( in_array( $product_id, $rule->ProductsSession ) || in_array( $parent_id , $rule->ProductsSession) ) ) {
										$istrue = true;
									}


									foreach ( $this->fatched_cats as $cat ) {

										if ( !empty( $cat) && has_term( $cat, 'product_cat', $parent_id ) ) {

											$istrue_cat = true;
										}
									}

									if ( $istrue || $istrue_cat ) {

										//get rule role base price for guest
										$rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

										if ( ! empty( $rule_role_base_wsp_price ) ) {

											foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

												if ( isset( $rule_role_price['user_role'] ) && ( 'everyone' == $rule_role_price['user_role'] || 'guest' == $rule_role_price['user_role'] ) ) {

													if ( ( $item_data['quantity'] >= $rule_role_price['min_qty'] && $item_data['quantity'] <= $rule_role_price['max_qty'] ) 
													|| ( $item_data['quantity'] >= $rule_role_price['min_qty'] && '' == $rule_role_price['max_qty'] )
													|| ( $item_data['quantity'] >= $rule_role_price['min_qty'] && 0 == $rule_role_price['max_qty'] ) 
													|| ( '' == $rule_role_price['min_qty'] && $item_data['quantity'] <= $rule_role_price['max_qty'] ) 
													|| ( 0 == $rule_role_price['min_qty'] && $item_data['quantity'] <= $rule_role_price['max_qty'] )) {


														if ( 'fixed_price' == $rule_role_price['discount_type'] ) {

															$new_line_subtotal = floatval($rule_role_price['discount_value']*$item_data['quantity']);
															$new_line_total    = floatval($rule_role_price['discount_value']*$item_data['quantity']);


														} elseif ( 'fixed_increase' == $rule_role_price['discount_type'] ) {

															$newprice = $pro_price + $rule_role_price['discount_value'];
																
															$new_line_subtotal = floatval($newprice*$item_data['quantity']);
															$new_line_total    = floatval($newprice*$item_data['quantity']);



														} elseif ( 'fixed_decrease' == $rule_role_price['discount_type'] ) {

															$newprice = $pro_price - $rule_role_price['discount_value'];
																
															$new_line_subtotal = floatval($newprice*$item_data['quantity']);
															$new_line_total    = floatval($newprice*$item_data['quantity']);


														} elseif ( 'percentage_decrease' == $rule_role_price['discount_type'] ) {

															$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

															$newprice          = $pro_price - $percent_price;
															$new_line_subtotal = floatval($newprice*$item_data['quantity']);
															$new_line_total    = floatval($newprice*$item_data['quantity']);
																

														} elseif ( 'percentage_increase' == $rule_role_price['discount_type'] ) {

															$percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

															$newprice = $pro_price + $percent_price;

															$new_line_subtotal = floatval($newprice*$item_data['quantity']);
															$new_line_total    = floatval($newprice*$item_data['quantity']);

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






				}

				// Update Order item prices
				
				$item->set_subtotal($new_line_subtotal);
				$item->set_subtotal_tax($new_line_subt_tax);
				$item->set_total($new_line_total);
				$item->set_total_tax($new_line_total_tax);
				$item->set_taxes($taxes);
				// Save the updated data
				$item->save();


			}




			$order->calculate_totals();
		}


		public function wsp_hide_price_page() {

			$af_wsp_categories = $this->af_wsp_get_all_categories();

			require ADDIFY_WSP_PLUGINDIR . 'wsp_hide_price.php';
		}

		public function afwsp_import_prices_template() {
			require ADDIFY_WSP_PLUGINDIR . 'afwsp_import_prices.php';
		}

		public function afwholesale_author_admin_notice() {
			?>
			<div class="updated notice notice-success is-dismissible">
				<p><?php echo esc_html__('Settings saved successfully.', 'addify_wholesale_prices'); ?></p>
			</div>
			<?php
		}

		public function afwholesale_save_data() {


			global $wp;

			if (!empty($_POST)) {

				if (!empty($_REQUEST['afwholesaleprice_nonce_field'])) {

						$retrieved_nonce = sanitize_text_field($_REQUEST['afwholesaleprice_nonce_field']);
				} else {
						$retrieved_nonce = 0;
				}

				if (!wp_verify_nonce($retrieved_nonce, 'afwholesaleprice_nonce_action')) {

					die('Failed security check');
				}

				if (!isset($_POST['wsp_enable_hide_pirce'])) {

					update_option('wsp_enable_hide_pirce', '');
				}

				if (!isset($_POST['wsp_enable_hide_pirce_guest'])) {

					update_option('wsp_enable_hide_pirce_guest', '');
				}

				if (!isset($_POST['wsp_enable_hide_pirce_registered'])) {

					update_option('wsp_enable_hide_pirce_registered', '');
				}

				if (!isset($_POST['wsp_hide_cart_button'])) {

					update_option('wsp_hide_cart_button', '');
				}

				if (!isset($_POST['wsp_hide_price'])) {

					update_option('wsp_hide_price', '');
				}

				if (!isset($_POST['wsp_hide_products'])) {

					update_option('wsp_hide_products', serialize( array() ) );
				}

				if (!isset($_POST['wsp_hide_user_role'])) {

					update_option('wsp_hide_user_role', serialize( array() ) );
				}

				if (!isset($_POST['wsp_hide_categories'])) {

					update_option('wsp_hide_categories', serialize( array() ) );
				}
				

				foreach ($_POST as $key => $value) {

					if ('afwholesale_save_hide_price' != $key) {

						if ('wsp_hide_user_role' == $key || 'wsp_hide_products' == $key || 'wsp_hide_categories' == $key) {

							update_option(esc_attr($key), serialize(sanitize_meta('', $value, '')));

						} else {
							update_option(esc_attr($key), esc_attr($value));
						}
					}
				}
			}
		}


		public function afwholesaleprice_display_tabs() {
			global $post, $typenow;
			$screen = get_current_screen();


			if ( $screen && in_array( $screen->id, $this->afwholesaleprice_get_tab_screen_ids(), true ) ) {

				$tabs = array(
					'af_wholesale_price'      => array(
						'title' => __( 'Rules', 'addify_wholesale_prices' ),
						'url'   => admin_url( 'edit.php?post_type=af_wholesale_price' ),
					),                  
					'wsp-hide-pirce'          => array(
						'title' => __( 'Hide Price', 'addify_wholesale_prices' ),
						'url'   => admin_url( 'admin.php?page=wsp-hide-pirce' ),
					),
					'addify-wsp-import-price' => array(
						'title' => __( 'Import / Export Prices', 'addify_wholesale_prices' ),
						'url'   => admin_url( 'admin.php?page=addify-wsp-import-price' ),
					),
					'addify-wsp-settings'     => array(
						'title' => __( 'Settings', 'addify_wholesale_prices' ),
						'url'   => admin_url( 'admin.php?page=addify-wsp-settings' ),
					),

				);

				if ( is_array( $tabs ) ) {
					?>
					<div class="wrap woocommerce">
						<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
							<?php
							$current_tab = $this->afwholesaleprice_get_current_tab();
							foreach ( $tabs as $id => $tab_data ) {
								$class = $id === $current_tab ? array( 'nav-tab', 'nav-tab-active' ) : array( 'nav-tab' );
								printf( '<a href="%1$s" class="%2$s">%3$s</a>', esc_url( $tab_data['url'] ), implode( ' ', array_map( 'sanitize_html_class', $class ) ), esc_html( $tab_data['title'] ) );
							}
							?>
						</h2>
					</div>
					<?php
				}
			}
		}


		public function afwholesaleprice_get_tab_screen_ids() {
			$tabs_screens = array(
				'af_wholesale_price',
				'edit-af_wholesale_price',
				'woocommerce_page_addify-wsp-settings',
				'woocommerce_page_wsp-hide-pirce',
				'woocommerce_page_addify-wsp-import-price',
			);
			return $tabs_screens;
		}

		public function afwholesaleprice_get_current_tab() {
			$screen = get_current_screen();

			switch ( $screen->id ) {
				case 'af_wholesale_price':
				case 'edit-af_wholesale_price':
					return 'af_wholesale_price';
				case 'woocommerce_page_addify-wsp-settings':
					return 'addify-wsp-settings';
				case 'woocommerce_page_wsp-hide-pirce':
					return 'wsp-hide-pirce';
				case 'woocommerce_page_addify-wsp-import-price':
					return 'addify-wsp-import-price';
			}
		}

		public function afwholesaleprice_submenu_link() {
			
			global $pagenow, $typenow;

			if ( ( 'edit.php' === $pagenow && 'af_wholesale_price' === $typenow )
				|| ( 'post.php' === $pagenow && isset( $_GET['post'] ) && 'af_wholesale_price' === get_post_type( sanitize_text_field( $_GET['post'] ) ) )
			) {
				remove_submenu_page( 'woocommerce', 'wsp-hide-pirce' );
				remove_submenu_page( 'woocommerce', 'addify-wsp-settings' );
				remove_submenu_page( 'woocommerce', 'addify-wsp-import-price' );

			} elseif ( ( 'admin.php' === $pagenow && isset( $_GET['page'] ) && 'addify-wsp-settings' === sanitize_text_field( $_GET['page'] ) )
			) {
				remove_submenu_page( 'woocommerce', 'edit.php?post_type=af_wholesale_price' );
				remove_submenu_page( 'woocommerce', 'wsp-hide-pirce' );
				remove_submenu_page( 'woocommerce', 'addify-wsp-import-price' );

				add_submenu_page(
					'woocommerce',
					esc_html__( 'Wholesale Prices', 'addify_wholesale_prices' ),
					esc_html__( 'Wholesale Prices', 'addify_wholesale_prices' ),
					'manage_options',
					'addify-wsp-settings',
					array( $this, 'afwsp_settings_page' )
				);
			} elseif ( ( 'admin.php' === $pagenow && isset( $_GET['page'] ) && 'addify-wsp-import-price' === sanitize_text_field( $_GET['page'] ) )
			) {
				remove_submenu_page( 'woocommerce', 'edit.php?post_type=af_wholesale_price' );
				remove_submenu_page( 'woocommerce', 'wsp-hide-pirce' );
				remove_submenu_page( 'woocommerce', 'addify-wsp-settings' );

				add_submenu_page(
					'woocommerce',
					esc_html__( 'Wholesale Prices', 'addify_wholesale_prices' ),
					esc_html__( 'Wholesale Prices', 'addify_wholesale_prices' ),
					'manage_options',
					'addify-wsp-import-price',
					array( $this, 'afwsp_import_prices_template' )
				);
			} elseif ( ( 'admin.php' === $pagenow && isset( $_GET['page'] ) && 'wsp-hide-pirce' === sanitize_text_field( $_GET['page'] ) )
			) {
				remove_submenu_page( 'woocommerce', 'edit.php?post_type=af_wholesale_price' );
				remove_submenu_page( 'woocommerce', 'addify-wsp-settings' );
				remove_submenu_page( 'woocommerce', 'addify-wsp-import-price' );


				add_submenu_page(
					'woocommerce',
					esc_html__( 'Wholesale Prices', 'addify_wholesale_prices' ),
					esc_html__( 'Wholesale Prices', 'addify_wholesale_prices' ),
					'manage_options',
					'wsp-hide-pirce',
					array( $this, 'wsp_hide_price_page' )
				);
			} else {
				remove_submenu_page( 'woocommerce', 'edit.php?post_type=af_wholesale_price' );
				remove_submenu_page( 'woocommerce', 'wsp-hide-pirce' );
				remove_submenu_page( 'woocommerce', 'addify-wsp-import-price' );


				add_submenu_page(
					'woocommerce',
					esc_html__( 'Wholesale Prices', 'addify_wholesale_prices' ),
					esc_html__( 'Wholesale Prices', 'addify_wholesale_prices' ),
					'manage_options',
					'addify-wsp-settings',
					array( $this, 'afwsp_settings_page' )
				);
	
				
				
				
			}
		}

		//prices import

		public function afwsp_import_prices_cb() {

			if ( !empty( $_POST['afwsp_import_prices'] ) ) {

				$retrieved_nonce = isset( $_REQUEST['afwsp_import_nonce_field'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['afwsp_import_nonce_field'] ) ) : '';

				if ( ! wp_verify_nonce( $retrieved_nonce, 'afwsp_import_action' ) ) {
					die( esc_html__('Security Violated.', 'addify_wholesale_prices') );
				}

				$response = include_once ADDIFY_WSP_PLUGINDIR . '/afwsp_import_prices_function.php';

				if ( $response ) {
					add_action('admin_notices', array( $this, 'afwsp_import_success_notice' ) );
				}
			}
		}

		public function afwsp_import_success_notice() {
			?>
			<div class="updated notice notice-success is-dismissible">
				<p><?php echo esc_html__('Prices imported successfully.', 'addify_wholesale_prices'); ?></p>
			</div>
			<?php
		}
	}

	new Admin_Addify_Wholesale_Prices();

}
