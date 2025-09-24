<?php

/**
 * This code implements the HkDevMaintenanceMode plugin's REST API disabling functionality.
 * It restricts access to the REST API for unauthenticated users.
 * 
 */

if (!defined('ABSPATH')) die();  // exit if accessed directly

//Disable REST API info from head and headers
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');
remove_action('template_redirect', 'rest_output_link_header', 11);


//Disable REST API
if ( version_compare(get_bloginfo('version'), '4.7', '>=') ) {
	add_filter('rest_authentication_errors', 'disable_wp_rest_api');
} else {
	disable_wp_rest_api_legacy();
}


function disable_wp_rest_api($access) {
    // If a user is logged in, let them pass.
	if ( !is_user_logged_in() && !disable_wp_rest_api_allow_access() ) {
		$message = apply_filters('disable_wp_rest_api_error', __('REST API restricted to authenticated users.', 'hkdev-maintenance-mode'));
		return new WP_Error('rest_login_required', $message, array('status' => rest_authorization_required_code()));
	}
	return $access;
}

function disable_wp_rest_api_allow_access() {
	
	$post_var   = apply_filters('disable_wp_rest_api_post_var', false);
	$server_var = apply_filters('disable_wp_rest_api_server_var', false);
	
	if (!empty($post_var)) {
		if (is_array($post_var)) {
			foreach($post_var as $var) {
				if (isset($_POST[$var]) && !empty($_POST[$var])) return true;
			}
		} else {
			if (isset($_POST[$post_var]) && !empty($_POST[$post_var])) return true;
		}
	}
	
	if (!empty($server_var)) {
		if (is_array($server_var)) {
			foreach($server_var as $var) {
				if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] === $var) return true;
			}
		} else {
			if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] === $server_var) return true;
		}
	}
	
	return false;
}

function disable_wp_rest_api_legacy() {
    // REST API 1.x
    add_filter('json_enabled', '__return_false');
    add_filter('json_jsonp_enabled', '__return_false');
    // REST API 2.x
    add_filter('rest_enabled', '__return_false');
    add_filter('rest_jsonp_enabled', '__return_false');
}

