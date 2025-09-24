<?php

/**
 * Automatic import executed by cron
 *
 * @link              https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since             2.44.0
 * @package           FG_Magento_to_WooCommerce
 */

ignore_user_abort(true);

if ( isset($_SERVER['REQUEST_URI']) || !empty($_POST) || defined('DOING_AJAX') || defined('DOING_CRON') ) {
	die();
}

define('DOING_CRON', true); // Tell WordPress we are doing the CRON task

$_SERVER["HTTP_USER_AGENT"] = 'PHP'; // To avoid notices from other plugins

if ( !defined('ABSPATH') ) {
	// Set up WordPress environment
	require_once( dirname( __FILE__ ) . '/../../../wp-load.php' );
	require_once( dirname( __FILE__ ) . '/../../../wp-admin/includes/admin.php' );
	$cron = new FG_Magento_to_WooCommerce_Cron();
	$cron->run();
}

/**
 * Cron class
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @author     Frédéric GILLES
 */
class FG_Magento_to_WooCommerce_Cron {

	/**
	 * Run the import
	 */
	public function run() {
		$this->set_current_user_to_admin();
		
		$actions = array('update', 'import');
		foreach ( $actions as $action ) {
			$this->do_action($action);
		}
		
		echo "IMPORT COMPLETED\n";
	}
	
	/**
	 * Set the current user to the first admin user (to get the administrator capabilities)
	 */
	private function set_current_user_to_admin() {
		$admin_users = get_users(array(
			'role__in' => 'administrator',
			'orderby' => 'ID',
		));
		if ( !empty($admin_users) ) {
			wp_set_current_user($admin_users[0]->ID);
		}
	}
	
	/**
	 * Do an action
	 * 
	 * @param string $action Action
	 */
	private function do_action($action) {
		global $fgm2wcp;

		echo esc_html($action) . "...\n";
		$time_start = date('Y-m-d H:i:s');
		$fgm2wcp->display_admin_notice("=== START $action $time_start ===");

		echo $fgm2wcp->dispatch($action);

		$time_end = date('Y-m-d H:i:s');
		$fgm2wcp->display_admin_notice("=== END $action $time_end ===\n");
	}

}
