<?php

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

if( !class_exists( 'Wt_Pdf_Blocks_Pay_later_Payment_Method' ) && class_exists( 'Wf_Woocommerce_Packing_List_Invoice_Pro' ) &&  class_exists( 'Wf_Woocommerce_Packing_List_Pay_Later_Payment' ) ) {
	final class Wt_Pdf_Blocks_Pay_later_Payment_Method extends AbstractPaymentMethodType {

		private $gateway;
		protected $name = 'wf_pay_later';// your payment gateway name

		public function initialize() {
			$this->settings = get_option( 'woocommerce_wf_pay_later_settings', array() );
			$this->gateway  = new Wf_Woocommerce_Packing_List_Pay_Later_Payment();
		}

		/**
		 * To check the pay later payment gateway is active
		 *
		 * @since 1.4.0 - Added a filter to restrict the user from accessing the paylater option
		 * @return boolean
		 */
		public function is_active() {
			return $this->gateway->is_available();
		}

		public function get_payment_method_script_handles() {

			wp_register_script(
				'wf_pay_later-blocks-integration',
				WT_PDF_BLOCKS_URL . 'build/pay-later/index.js',
				array(
					'wc-blocks-registry',
					'wc-settings',
					'wp-element',
					'wp-html-entities',
					'wp-i18n',
				),
				null,
				true
			);
			if ( function_exists( 'wp_set_script_translations' ) ) {
				wp_set_script_translations( 'wf_pay_later-blocks-integration' );

			}
			return array( 'wf_pay_later-blocks-integration' );
		}

		public function get_payment_method_data() {
			return array(
				'title'       => $this->gateway->title,
				'description' => $this->gateway->description,
			);
		}
	}
}
