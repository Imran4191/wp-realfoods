<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Wt_Pklist_Language_Switcher_IPC' ) ) {
	class Wt_Pklist_Language_Switcher_IPC {
		private static $instance = null;
		public $locale           = '';
		public function __construct( ) {

			$this->locale      = get_locale();
			add_action( 'wt_pklist_language_switcher_for_invoice', array( $this, 'switch_document_language' ), 10, 3 );
			add_action( 'wt_pklist_language_switcher_for_packinglist', array( $this, 'switch_document_language' ), 10, 3 );
			add_action( 'wt_pklist_language_switcher_for_creditnote', array( $this, 'switch_document_language' ), 10, 3 );
		}

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new Wt_Pklist_Language_Switcher_IPC();
			}
			return self::$instance;
		}

		public function switch_document_language( $lang, $template_type, $order_id ) {
			$this->locale = $lang;
			add_filter( 'locale', array( $this, 'plugin_locale' ), 10, 2 );
			add_filter( 'plugin_locale', array( $this, 'plugin_locale' ), 10, 2 );
			add_filter( 'theme_locale', array( $this, 'plugin_locale' ), 10, 2 );
			$this->reload_plugin_text_domains();
			switch_to_locale( $this->locale );
		}

		public function reload_plugin_text_domains() {
			unload_textdomain( 'woocommerce' );
			unload_textdomain( 'print-invoices-packing-slip-labels-for-woocommerce' );
			unload_textdomain( 'wt_woocommerce_invoice_addon' );

			WC()->load_plugin_textdomain();
			$this->translations();

			unload_textdomain( 'default' );
			load_default_textdomain( $this->locale );
		}

		public function plugin_locale( $locale, $domain = '' ) {
			$locale = $this->locale;
			return $locale;
		}

		public function translations() {
			$locale = $this->determine_locale();
			$dir    = trailingslashit( WP_LANG_DIR );

			$textdomains = array(
				'print-invoices-packing-slip-labels-for-woocommerce' => array(
					'root_folder_name' => 'print-invoices-packing-slip-labels-for-woocommerce',
					'file_name_prefix' => 'print-invoices-packing-slip-labels-for-woocommerce',
				),
				'wt_woocommerce_invoice_addon' => array(
					'root_folder_name' => 'wt-woocommerce-invoice-addon',
					'file_name_prefix' => 'wt_woocommerce_invoice_addon',
				),
			);

			/**
			 * Frontend/global Locale. Looks in:
			 *
			 *      - WP_LANG_DIR/print-invoices-packing-slip-labels-for-woocommerce/print-invoices-packing-slip-labels-for-woocommerce-LOCALE.mo
			 *      - WP_LANG_DIR/plugins/print-invoices-packing-slip-labels-for-woocommerce-LOCALE.mo
			 *      - print-invoices-packing-slip-labels-for-woocommerce/languages/print-invoices-packing-slip-labels-for-woocommerce-LOCALE.mo (which if not found falls back to:)
			 *      - WP_LANG_DIR/plugins/print-invoices-packing-slip-labels-for-woocommerce-LOCALE.mo
			 */
			foreach ( $textdomains as $textdomain => $textdomain_arr ) {
				unload_textdomain( $textdomain );

				if(file_exists($dir . $textdomain_arr['root_folder_name'] . '/' . $textdomain_arr['file_name_prefix'] . '-' . $locale . '.mo')){
					load_textdomain( $textdomain, $dir . $textdomain_arr['root_folder_name'] . '/' . $textdomain_arr['file_name_prefix'] . '-' . $locale . '.mo' );
				}

				if( file_exists($dir . 'plugins/' . $textdomain_arr['file_name_prefix'] . '-' . $locale . '.mo') ){
					load_textdomain( $textdomain, $dir . 'plugins/' . $textdomain_arr['file_name_prefix'] . '-' . $locale . '.mo' );
				}
				
				load_plugin_textdomain( $textdomain, false, $textdomain_arr['root_folder_name'] . '/languages' );
			}
		}

		public function determine_locale() {
			if ( function_exists( 'determine_locale' ) ) { // WP5.0+
				$locale = determine_locale();
			} else {
				$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
			}

			return apply_filters( 'plugin_locale', $locale, 'wt_woocommerce_invoice_addon' );
		}
	}
    new Wt_Pklist_Language_Switcher_IPC();
}
