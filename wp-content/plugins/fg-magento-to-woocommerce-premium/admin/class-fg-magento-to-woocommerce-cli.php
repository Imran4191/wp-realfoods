<?php
/**
 * WP CLI module
 *
 * Run commands by WP CLI
 * 
 * @link       https://www.fredericgilles.net/magento-to-woocommerce/
 * @since      3.12.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
 */

if ( !class_exists('FG_Magento_to_WooCommerce_WPCLI', false) ) {

	/**
	 * Import Magento to WooCommerce using WP CLI
	 *
	 * @package    FG_Magento_to_WooCommerce_Premium
	 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Magento_to_WooCommerce_WPCLI {

		private $plugin;
		
		/**
		 * Initialize the class and set its properties.
		 *
		 * @param object $plugin Admin plugin
		 */
		public function __construct( $plugin ) {
			$this->plugin = $plugin;
			ini_set('display_errors', true); // Display the errors that may happen (ex: Allowed memory size exhausted)
			if ( !defined('WP_ADMIN') ) {
				define('WP_ADMIN', true); // To execute the actions done when is_admin() (ex: Register Types post types)
			}
			$this->plugin->init();
			$this->plugin->set_local_timezone();
		}
		
		/**
		 * Test the database connection
		 */
		public function test_database() {
			$this->dispatch('test_database');
		}
		
		/**
		 * Empty the imported data | empty all : Empty all the WordPress data
		 * 
		 * [<all>]
		 * : Empty all the WordPress content
		 * 
		 * @subcommand empty
		 */
		public function empty_wp_content($args) {
			$_POST['empty_action'] = isset($args[0]) && ($args[0] == 'all')? 'all' : '';
			$this->plugin->empty_log_file();
			$this->dispatch('empty');
		}
		
		/**
		 * Import the data
		 */
		public function import() {
			$this->dispatch('import');
		}
		
		/**
		 * Update the data
		 * 
		 * @since 3.14.0
		 */
		public function update() {
			$this->dispatch('update');
		}
		
		/**
		 * Dispatch an action
		 * 
		 * @param string $action Action to run
		 */
		private function dispatch($action) {
			$this->set_current_user();
			
			$result = $this->plugin->dispatch($action);
			if ( isset($result['status']) && ($result['status'] == 'Error') ) {
				WP_CLI::error($result['message']);
			} else {
				$success_message = isset($result['message'])? $result['message'] : '';
				WP_CLI::success($success_message);
			}
		}
		
		/**
		 * Set the current user if not set
		 */
		private function set_current_user() {
			$user_id = get_current_user_id();
			if ( $user_id == 0 ) {
				// Get the first admin user
				$admin_users = get_users(array(
					'role__in' => 'administrator',
					'orderby' => 'ID',
				));
				if ( !empty($admin_users) ) {
					wp_set_current_user($admin_users[0]->ID);
				}
			}
		}

	}
}
