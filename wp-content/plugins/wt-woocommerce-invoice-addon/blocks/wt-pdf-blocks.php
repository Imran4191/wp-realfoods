<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! defined( 'WT_PDF_BLOCKS_FILE' ) ) {
	define( 'WT_PDF_BLOCKS_FILE', __FILE__ );
}

if ( ! defined( 'WT_PDF_BLOCKS_MAIN_PATH' ) ) {
	define( 'WT_PDF_BLOCKS_MAIN_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'WT_PDF_BLOCKS_URL' ) ) {
	define( 'WT_PDF_BLOCKS_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'WT_PDF_BLOCKS_VERSION' ) ) {
	define( 'WT_PDF_BLOCKS_VERSION', '1.0.0' );
}

use Automattic\WooCommerce\StoreApi\Schemas\V1\CheckoutSchema;
use MailPoetVendor\Doctrine\ORM\Query\Expr\Func;

if ( ! class_exists( 'Wt_Pdf_Blocks' ) ) {

	class Wt_Pdf_Blocks {

		public $registered_blocks         = array();
		private $block_post_fields        = array();
		private $block_post_fields_schema = array();

		private $editor_script_handles   = array();
		private $frontend_script_handles = array();
		private $frontend_script_data    = array();

		public function __construct() {
			
			$this->check_pre_requisites_for_the_blocks();
		}

		public function check_pre_requisites_for_the_blocks() {

			if(	is_plugin_active( 'wt-woocommerce-invoice-addon/wt-woocommerce-invoice-addon.php' ) ||
				is_plugin_active( 'wt-woocommerce-shippinglabel-addon/wt-woocommerce-shippinglabel-addon.php' ) ||
				is_plugin_active( 'wt-woocommerce-proforma-addon/wt-woocommerce-proforma-addon.php')
			) {
				/**
				 *  Init the blocks
				 */
				add_action( 'woocommerce_blocks_loaded', array( $this, 'init' ) );

				/**
				 *  REST API POST data for modules.
				 *  Priority must be less than 10
				 */
				add_action( 'woocommerce_store_api_checkout_update_order_from_request', array( $this, 'store_api_request_data' ), 9, 2 );

				/**
				 *  Save the data from checkout
				 */
				add_action( 'woocommerce_store_api_checkout_update_order_from_request', array( $this, 'save_data' ), 10, 2 );
			}
		}

		public function get_packing_list_option() {
			$packing_list_value_arr = $this->add_checkout_fields();
			return $packing_list_value_arr;
		}

		public static function get_checkout_field_list() {
			/* built in checkout fields */
			$default_checkout_fields = Wf_Woocommerce_Packing_List::$default_additional_checkout_data_fields;

			/* list of user created items */
			$user_created_checkout_fields = Wf_Woocommerce_Packing_List::get_option( 'wf_additional_checkout_data_fields' );
			$user_created_checkout_fields = self::process_checkout_fields( $user_created_checkout_fields );

			return array_merge( $default_checkout_fields, $user_created_checkout_fields );
		}

		public function add_checkout_fields() {
			$fields = array();

			$user_selected_data_flds = Wf_Woocommerce_Packing_List::get_option( 'wf_invoice_additional_checkout_data_fields' );
			if ( is_array( $user_selected_data_flds ) && count( array_filter( $user_selected_data_flds ) ) > 0 ) {
				$data_flds                         = self::get_checkout_field_list();
				$priority_inc                      = 110; //110 is the last item(billing email priority so our fields will be after that.)
				$additional_checkout_field_options = Wf_Woocommerce_Packing_List::get_option( 'wt_additional_checkout_field_options' );
				foreach ( $user_selected_data_flds as $value ) {
					++$priority_inc;
					if ( isset( $data_flds[ $value ] ) ) {
						$add_data    = isset( $additional_checkout_field_options[ $value ] ) ? $additional_checkout_field_options[ $value ] : array();
						$is_required = (int) ( isset( $add_data['is_required'] ) ? $add_data['is_required'] : 0 );
						$placeholder = ( isset( $add_data['placeholder'] ) ? $add_data['placeholder'] : 'Enter ' . $data_flds[ $value ] );
						$title       = ( isset( $add_data['title'] ) && '' !== trim( $add_data['title'] ) ? $add_data['title'] : $data_flds[ $value ] );

						$fields[ 'billing_' . $value ] = array(
							'name'        => 'billing_' . $value,
							'type'        => 'text',
							'label'       => __( $title, 'woocommerce' ),
							'placeholder' => _x( $placeholder, 'placeholder', 'woocommerce' ),
							'required'    => $is_required,
							'class'       => array( 'form-row-wide', 'align-left' ),
							'clear'       => true,
							'priority'    => $priority_inc,
						);
					}
				}
			}
			return $fields;
		}

		/**
		* Checking an array is associative or not
		* @since 1.3.0
		* @param array $array input array
		* @return bool
		*/
		public static function is_assoc( array $array ) {
			// Keys of the array
			$keys = array_keys( $array );

			// If the array keys of the keys match the keys, then the array must
			// not be associative (e.g. the keys array looked like {0:0, 1:1...}).
			return array_keys( $keys ) !== $keys;
		}

		/**
		*
		* @since 1.3.0
		* @param array $array checkout field value unprocessed
		* @return array $array checkout field value processed
		*
		*/
		public static function process_checkout_fields( $arr ) {
			$arr = ! is_array( $arr ) ? array() : $arr;
			/* not associative array, That mean's old version,then convert it */
			if ( ! self::is_assoc( $arr ) && count( $arr ) > 0 ) {
				$arr_keys = array_map(
					function ( $vl ) {
						return self::process_checkout_key( $vl );
					},
					$arr
				);
				$arr      = array_combine( $arr_keys, $arr ); //creating an array
			}
			return $arr;
		}

		/**
		* Filtering unwanted characters from checkout field meta key
		* @since 1.3.0
		* @param string $meta_key meta key user input
		* @return string $meta_key processed meta key
		*/
		public static function process_checkout_key( $meta_key ) {
			return strtolower( preg_replace( '/[^A-Za-z]/', '_', $meta_key ) );
		}

		/**
		 *  Init the blocks
		 *  1. Set the registered blocks data
		 *  2. Include block integration class and hook integration.
		 *
		 *  Hooked into: `woocommerce_blocks_loaded`
		 */
		public function init() {

			// Checkout Custom fields compatibility with WC Checkout block
			if (class_exists( '\Automattic\WooCommerce\Blocks\Package' ) && interface_exists('\Automattic\WooCommerce\Blocks\Integrations\IntegrationInterface')) {
				$this->set_registered_blocks();

				// Include integration class file
				include_once WT_PDF_BLOCKS_MAIN_PATH . 'includes/class-wt-pdf-blocks-integration.php';
				add_action( 'woocommerce_blocks_checkout_block_registration', array( $this, 'register_checkout_blocks' ) );
				
				$this->register_api_endpoint_data();
			}

			/**
			 * Pay later payment gateway compatibility with WC checkout block
			 * 
			 * @since 1.4.0 - Restrict the user from accessing the pay later payment gateway
			 * 
			 */
			if ( class_exists( 'Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType' ) && class_exists( 'Wf_Woocommerce_Packing_List_Invoice_Pro' ) &&  class_exists( 'Wf_Woocommerce_Packing_List_Pay_Later_Payment' ) ) {
				require_once plugin_dir_path( __FILE__ ) . 'includes/class-wt-pdf-blocks-pay-later-payment-method.php';

				$restrict = false;
				$pay_later_role_access  = apply_filters( 'wt_pklist_alter_pay_later_role_access', array() );  
				$pay_later_role_access  = ( !is_array( $pay_later_role_access ) ? array() : $pay_later_role_access );
				if ( !empty( $pay_later_role_access ) ) {
					$user = wp_get_current_user();
					foreach ( $pay_later_role_access as $role ) { //checking access
						if ( in_array( $role, $user->roles ) ) { //any of the role present in the role array then restrict the access for the payment gateway
							$restrict = true;
							break;
						}
					}
				}

				if ( false === $restrict ) {
					// Hook the registration function to the 'woocommerce_blocks_payment_method_type_registration' action
					add_action(
						'woocommerce_blocks_payment_method_type_registration',
						function ( Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry $payment_method_registry ) {
							// Register an instance of Wt_Pdf_Blocks_Pay_later_Payment_Method
							$payment_method_registry->register( new Wt_Pdf_Blocks_Pay_later_Payment_Method() );
						}
					);
				}
			}
		}


		/**
		 *  Load registered blocks data.
		 *  Modules can hook their blocks data
		 *
		 */
		public function set_registered_blocks() {
			$registered_blocks = array();
			$registered_blocks['wt-inital-load'] = array(
				'block_dir'          => 'wt-initial-load', // Do not use underscore
				'post_fields'        => array(), // Field name and default values
				'post_fields_schema' => array(),
				'script_handles'     => array( 'frontend-css', 'frontend-js' ), // Script handles, Only add the scripts and styles available for the block.
			);
			if ( ! empty( $this->get_packing_list_option() ) ) {
				$post_fields                        = array_fill_keys( array_keys( $this->get_packing_list_option() ), '' );
				$post_schema_values                 = array_fill_keys(
					array_keys( $this->get_packing_list_option() ),
					array(
						'description' => '',
						'type'        => array( 'string', 'null' ),
						'readonly'    => true,
					)
				);
				$registered_blocks['custom-fields'] =
					array(
						'block_dir'          => 'custom-fields', // Do not use underscore
						'post_fields'        => $post_fields, // Field name and default values
						'post_fields_schema' => $post_schema_values,
						'script_handles'     => array( 'editor-js', 'editor-css', 'frontend-css', 'frontend-js' ), // Script handles, Only add the scripts and styles available for the block.
						'localize_handles'   => array(
							'params' => array(
								'custom_fields_arr' => json_encode( $this->get_packing_list_option() ),
							),
						),
					);
			}
			/**
			 *  Modules can register their blocks. This filter just enable the blocks. Blocks code must be present in the blocks directory.
			 *
			 *  Sample block data structure:
			 *
			 *      array(
			 *          'block_first' => array(
			 *              'block_dir' => 'block-first', // Do not use underscore
			 *              'post_fields' => array( 'field_a' => 'field_a_value', 'field_b' => '' ), // Field name and default values
			 *              'post_fields_schema' => array(
			 *                  'field_a'  => array(
			 *                      'description' => __( 'Field A', 'text-domain' ),
			 *                      'type'        => array( 'string', 'null' ),
			 *                      'readonly'    => true,
			 *                  ),
			 *                  'field_b'  => array(
			 *                      'description' => __( 'Field B', 'text-domain' ),
			 *                      'type'        => array( 'string', 'null' ),
			 *                      'readonly'    => true,
			 *                  )
			 *              ),
			 *              'script_handles' => array( 'editor-js', 'editor-css', 'frontend-css', 'frontend-js' ), // Script handles, Only add the scripts and styles available for the block.
			 *          ),
			 *      );
			 *
			 *
			 *
			 *  @param array    $registered_blocks      Blocks data array
			 */
			$this->registered_blocks = (array) apply_filters( 'wt_pdf_blocks_register', $registered_blocks );

			// Prepare `block_post_fields` and `block_post_fields_schema`
			foreach ( $this->registered_blocks as $block_data ) {

				if ( is_array( $block_data ) && isset( $block_data['block_dir'] ) ) {

					// Post field
					if ( isset( $block_data['post_fields'] ) && is_array( $block_data['post_fields'] ) ) {
						$this->block_post_fields = array_merge( $this->block_post_fields, $block_data['post_fields'] );
					}

					// Field schema
					if ( isset( $block_data['post_fields_schema'] ) && is_array( $block_data['post_fields_schema'] ) ) {
						$this->block_post_fields_schema = array_merge( $this->block_post_fields_schema, $block_data['post_fields_schema'] );
					}

					// Script handles
					if ( isset( $block_data['script_handles'] ) && is_array( $block_data['script_handles'] ) ) {

						// Editor
						if ( in_array( 'editor-js', $block_data['script_handles'] ) ) {
							$this->editor_script_handles[] = 'wt-pdf-blocks-' . $block_data['block_dir'] . '-editor';
						}

						// Frontend
						if ( in_array( 'frontend-js', $block_data['script_handles'] ) ) {
							$this->frontend_script_handles[] = 'wt-pdf-blocks-' . $block_data['block_dir'] . '-frontend';
						}
					}

					// Script data
					if ( isset( $block_data['script_data'] ) && is_array( $block_data['script_data'] ) ) {
						$this->frontend_script_data = array_merge( $this->frontend_script_data, $block_data['script_data'] );
					}
				}
			}
		}


		/**
		 *  Register checkout blocks
		 *  Hooked into: `woocommerce_blocks_checkout_block_registration`
		 */
		public function register_checkout_blocks( $integration_registry ) {
			if ( ! empty( $this->registered_blocks ) ) { // Blocks available
				$wt_pdf_blocks_integration                          = new Wt_Pdf_Blocks_Integration();
				$wt_pdf_blocks_integration->registered_blocks       = $this->registered_blocks;
				$wt_pdf_blocks_integration->editor_script_handles   = $this->editor_script_handles;
				$wt_pdf_blocks_integration->frontend_script_handles = $this->frontend_script_handles;
				$wt_pdf_blocks_integration->frontend_script_data    = $this->frontend_script_data;
				$integration_registry->register( $wt_pdf_blocks_integration );
			}
		}


		/**
		 *  Register data to checkout end point
		 */
		public function register_api_endpoint_data() {
			if ( function_exists( 'woocommerce_store_api_register_endpoint_data' ) ) {
				woocommerce_store_api_register_endpoint_data(
					array(
						'endpoint'        => CheckoutSchema::IDENTIFIER,
						'namespace'       => 'wt_pdf_blocks',
						'data_callback'   => array( $this, 'data_callback' ),
						'schema_callback' => array( $this, 'schema_callback' ),
						'schema_type'     => ARRAY_A,
					)
				);
			}
		}

		/**
		 * Callback function to register endpoint data for blocks.
		 *
		 * @return array
		 */
		public function data_callback() {
			return $this->block_post_fields;
		}

		/**
		 * Callback function to register schema for data.
		 *
		 * @return array
		 */
		public function schema_callback() {
			return $this->block_post_fields_schema;
		}

		/**
		 *  REST API POST data for modules.
		 *  Hooked into: woocommerce_store_api_checkout_update_order_from_request
		 *
		 *  @param WC_order     $order      Order object
		 *  @param array        $request    Array of request data
		 */
		public function store_api_request_data( $order, $request ) {

			$data_arr = isset( $request['extensions']['wt_pdf_blocks'] ) && is_array( $request['extensions']['wt_pdf_blocks'] ) ? $request['extensions']['wt_pdf_blocks'] : array();

			if ( ! empty( $data_arr ) ) {

				/**
				 *  Modules can hook and validate the data from checkout
				 *
				 *  @param array        $data_arr   Plugin data array
				 *  @param WC_order     $order      Order object
				 *  @param array        $request    Array of request data
				 */
				do_action( 'wt_pdf_blocks_validate_checkout_data', $data_arr, $order, $request );
			}
		}


		/**
		 *  Save data from checkout
		 *  Hooked into: woocommerce_store_api_checkout_update_order_from_request
		 *
		 *  @param WC_order     $order      Order object
		 *  @param array        $request    Array of request data
		 */
		public function save_data( $order, $request ) {

			$data_arr         = isset( $request['extensions']['wt_pdf_blocks'] ) && is_array( $request['extensions']['wt_pdf_blocks'] ) ? $request['extensions']['wt_pdf_blocks'] : array();
			$wt_custom_fields = array_keys( $this->get_packing_list_option() );

			if ( ! empty( $wt_custom_fields ) ) {
				foreach ( $wt_custom_fields as $wt_custom_field ) {
					if ( isset( $data_arr[ $wt_custom_field ] ) ) {
						Wt_Pklist_Common::update_order_meta( $order, $wt_custom_field, sanitize_text_field( $data_arr[ $wt_custom_field ] ) );
					}
				}
			}
			/**
			 *  Modules can hook and process the data from checkout
			 *
			 *  @param array        $data_arr   Plugin data array
			 *  @param WC_order     $order      Order object
			 *  @param array        $request    Array of request data
			 */
			do_action( 'wt_pdf_blocks_save_checkout_data', $data_arr, $order, $request );
		}
	}
	new Wt_Pdf_Blocks();
}
