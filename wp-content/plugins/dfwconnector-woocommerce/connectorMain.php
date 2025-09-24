<?php
/*
Plugin Name: DataFeedWatch Connector
Description: DataFeedWatch enables merchants to optimize & manage product feeds on 2,000+ channels & marketplaces worldwide.
Version: 1.8.0
*/

/*
DataFeedWatch Connector is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

DataFeedWatch Connector is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with DataFeedWatch Connector. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

defined( 'ABSPATH' ) || die( 'Cannot access pages directly.' );
define( 'DFWBC_BRIDGE_IS_CUSTOM_OPTION_NAME', 'DFW_woocommerce_bridge_connector_is_custom' );
define( 'DFWBC_BRIDGE_IS_INSTALLED', 'DFW_woocommerce_bridge_connector_is_installed' );
define( 'DFWBC_STORE_KEY', 'DFW_store_key' );

if ( ! defined( 'DFWBC_STORE_BASE_DIR' ) ) {
	define( 'DFWBC_STORE_BASE_DIR', ABSPATH );
}

if ( ! defined( 'DFWBC_MIN_WOO_VERSION' ) ) {
	define( 'DFWBC_MIN_WOO_VERSION', '2.8.1' );
}

if ( ! function_exists( 'is_dfwbc_required_plugins_active' ) ) {
	include_once 'includes/dfw-bridge-connector-functions.php';
}

if ( ! is_dfwbc_required_plugins_active() ) {
	add_action( 'admin_notices', 'DFW_woocommerce_version_error' );

	if ( ! function_exists( 'deactivate_plugins' ) ) {
		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		deactivate_plugins( plugin_basename( __FILE__ ), false, false );
	}

	return;
}

require 'worker.php';
$DFWworker = new DFWBridgeConnector();
$storeKey  = $DFWworker->getStoreKey();

require_once $DFWworker->bridgePath . $DFWworker->configFilePath;

$isCustom  = get_option( DFWBC_BRIDGE_IS_CUSTOM_OPTION_NAME );
$bridgeUrl = $DFWworker->getBridgeUrl();

add_action( 'wp_ajax_DFWbridge_action',
	function () use ( $DFWworker, $storeKey ) {
	DFWbridge_action( $DFWworker, $storeKey );
	} );

/**
 * DFWbridge_action
 *
 * @param DFWBridgeConnector $DFWworker Worker
 * @param string             $storeKey  Store Key
 *
 * @throws Exception
 */
function DFWbridge_action( DFWBridgeConnector $DFWworker, $storeKey ) {
	if ( isset( $_REQUEST['connector_action'] ) ) {
		$action = sanitize_text_field( $_REQUEST['connector_action'] );

		switch ( $action ) {
			case 'installBridge':
				$data = [];
				update_option( DFWBC_BRIDGE_IS_INSTALLED, true );
				$status = $DFWworker->updateToken( $storeKey );

				if ( ! $status['success'] ) {
					break;
				}

				$status = $DFWworker->installBridge();
				$data   = [
					'storeKey'  => $storeKey,
					'bridgeUrl' => $DFWworker->getBridgeUrl(),
				];

				if ( $status['success'] ) {
					update_option( DFWBC_BRIDGE_IS_CUSTOM_OPTION_NAME, isset( $status['custom'] ) ? $status['custom'] : false );
					update_option( DFWBC_BRIDGE_IS_INSTALLED, true );
				}
				break;
			case 'removeBridge':
				update_option( DFWBC_BRIDGE_IS_INSTALLED, false );
				$status = [
					'success' => true,
					'message' => 'Bridge deleted',
				];
				$data   = [];
				delete_option( DFWBC_BRIDGE_IS_CUSTOM_OPTION_NAME );
				delete_option( DFWBC_BRIDGE_IS_INSTALLED );
				break;
			case 'updateToken':
				$storeKey = $DFWworker->updateStoreKey();
				$status   = $DFWworker->updateToken( $storeKey );
				$data     = [ 'storeKey' => $storeKey ];
		}//end switch

		echo json_encode( [ 'status' => $status, 'data' => $data ] );
		wp_die();
	}
}

/**
 * DFW_connector_plugin_action_links
 *
 * @param array  $links Links
 * @param string $file  File
 *
 * @return array
 */
function DFW_connector_plugin_action_links( array $links, $file ) {
	plugin_basename( dirname( __FILE__ ) . '/connectorMain.php' ) == $file;

	if ( $file ) {
		$links[] = '<a href="' . admin_url( 'admin.php?page=DFW_connector-config' ) . '">' . __( 'Settings' ) . '</a>';
	}

	return $links;
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'DFW_connector_plugin_action_links', 10, 2 );

/**
 * Register routes.
 *
 * @since 1.5.0
 */
function DFW_rest_api_register_routes() {
	if ( isset( $GLOBALS['woocommerce'] ) || isset( $GLOBALS['wpec'] ) ) {
		include_once 'includes/class-dfw-bridge-connector-rest-api-controller.php';

		// v1
		$restApiController = new DFW_Bridge_Connector_V1_REST_API_Controller();
		$restApiController->register_routes();
	}
}

add_action( 'rest_api_init', 'DFW_rest_api_register_routes' );

/**
 * DFW_connector_config
 *
 * @return bool
 * @throws Exception
 */
function DFW_connector_config() {
	global $DFWworker;
	include_once $DFWworker->bridgePath . $DFWworker->configFilePath;
	$storeKey  = $DFWworker->getStoreKey();
	$isCustom  = get_option( DFWBC_BRIDGE_IS_CUSTOM_OPTION_NAME );
	$bridgeUrl = $DFWworker->getBridgeUrl();
	preg_match( "/define\( ?'(\w+)',\s*'([^']+)' ?\);/", file_get_contents( $DFWworker->bridgePath . '/bridge.php' ), $matches );
	$bridgeVersion = $matches[2];
	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'connector-css', plugins_url( 'css/style.css', __FILE__ ) , [], $theme_version );
	wp_enqueue_style( 'connector-css-dfw', plugins_url( 'css/dfw-style.css', __FILE__ ) , [], $theme_version );
	wp_enqueue_script( 'connector-js', plugins_url( 'js/scripts.js', __FILE__ ), [ 'jquery' ], $theme_version );
	wp_enqueue_script( 'connector-js', plugins_url( 'js/scripts.js', __FILE__ ), [], $theme_version );
	wp_localize_script( 'connector-js', 'DFWAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
	wp_enqueue_script( 'connector-js-dfw', plugins_url( 'js/dfw-scripts.js', __FILE__ ), [], $theme_version );

	$showButton = 'install';
	if ( get_option( DFWBC_BRIDGE_IS_CUSTOM_OPTION_NAME ) ) {
		$showButton = 'uninstall';
	}

	$cartName       = 'WooCommerce';
	$sourceCartName = 'WooCommerce';
	$sourceCartName = strtolower( str_replace( ' ', '-', trim( $sourceCartName ) ) );
	$referertext    = 'Connector: ' . $sourceCartName . ' to ' . $cartName . ' module';

	include 'settings.phtml';

	return true;
}

/**
 * DFW_connector_uninstall
 */
function DFW_connector_uninstall() {
	delete_option( DFWBC_BRIDGE_IS_CUSTOM_OPTION_NAME );
	delete_option( DFWBC_BRIDGE_IS_INSTALLED );
	function_exists( 'delete_site_meta' ) ? delete_site_meta( 1, DFWBC_STORE_KEY ) : delete_option( DFWBC_STORE_KEY );
}

/**
 * DFW_connector_activate
 */
function DFW_connector_activate() {
	update_option( DFWBC_BRIDGE_IS_INSTALLED, true );
}

/**
 * DFW_connector_deactivate
 */
function DFW_connector_deactivate() {
	update_option( DFWBC_BRIDGE_IS_INSTALLED, false );
}

/**
 * DFW_connector_load_menu
 */
function DFW_connector_load_menu() {
	add_submenu_page( 'plugins.php',
		__( 'DataFeedWatch Connector' ),
		__( 'DataFeedWatch Connector' ),
		'manage_options',
		'DFW_connector-config',
		'DFW_connector_config' );
}

register_activation_hook( __FILE__, 'DFW_connector_activate' );
register_uninstall_hook( __FILE__, 'DFW_connector_uninstall' );
register_deactivation_hook( __FILE__, 'DFW_connector_deactivate' );

add_action( 'admin_menu', 'DFW_connector_load_menu' );
