<?php 
defined( 'ABSPATH' ) || exit;
define( 'BREEZE_ADVANCED_CACHE', true );
if ( is_admin() ) { return; }
if ( ! @file_exists( '/Users/imran/Local Sites/rrfwp/app/public/wp-content/plugins/breeze/breeze.php' ) ) { return; }
$domain = strtolower( stripslashes( $_SERVER['HTTP_HOST'] ) );
if ( substr( $domain, -3 ) == ':80' ) {
	$domain = substr( $domain, 0, -3 );
} elseif ( substr( $domain, -4 ) == ':443' ) {
	$domain = substr( $domain, 0, -4 );
}
$site_url = $domain;
function breeze_fetch_configuration_data( $site_url ) {
	$config = array();
	switch ( $site_url ) {
	case 'au.rrfwp.local':
		$config['config_path'] = '/Users/imran/Local Sites/rrfwp/app/public/wp-content/breeze-config/breeze-config-3.php';
		$config['blog_id']=3;
		break;
	case 'rrfwp.local':
		$config['config_path'] = '/Users/imran/Local Sites/rrfwp/app/public/wp-content/breeze-config/breeze-config-1.php';
		$config['blog_id']=1;
		break;
	case 'nz.rrfwp.local':
		$config['config_path'] = '/Users/imran/Local Sites/rrfwp/app/public/wp-content/breeze-config/breeze-config.php';
		$config['blog_id']=2;
		break;
	case 'eu.rrfwp.local':
		$config['config_path'] = '/Users/imran/Local Sites/rrfwp/app/public/wp-content/breeze-config/breeze-config.php';
		$config['blog_id']=4;
		break;
	}
	return $config;
}
function breeze_get_subsite_from_url( $url ) {
	$parsed_url    = parse_url( $url );
	$domain        = strtolower( $parsed_url['host'] );
	$path          = trim( $parsed_url['path'] ?? '', '/' );
	$path_segments = array();
	if ( ! empty( $path ) ) {
		$path_segments = explode( '/', $path );
	}
	if ( ':80' === substr( $domain, -3 ) ) {
		$domain = substr( $domain, 0, -3 );
	} elseif ( ':443' === substr( $domain, -4 ) ) {
		$domain = substr( $domain, 0, -4 );
	}
	$site_url = '';
	if ( count( $path_segments ) >= 2 ) {
		$site_url       = $domain . '/' . $path_segments[0] . '/' . $path_segments[1];
		$subsite_config = breeze_fetch_configuration_data( $site_url );

		if ( $subsite_config ) {
			return $subsite_config;
		}
	}
	if ( count( $path_segments ) >= 1 ) {
		$site_url       = $domain . '/' . $path_segments[0];
		$subsite_config = breeze_fetch_configuration_data( $site_url );
		if ( $subsite_config ) {
			return $subsite_config;
		}
	}
	$site_url       = $domain;
	$subsite_config = breeze_fetch_configuration_data( $site_url );
	if ( $subsite_config ) {
		return $subsite_config;
	}

	return '';
}

$config = breeze_fetch_configuration_data( $site_url );
if ( 
 empty( $config ) && 
 false === filter_var( SUBDOMAIN_INSTALL, FILTER_VALIDATE_BOOLEAN ) && 
 true === filter_var( MULTISITE, FILTER_VALIDATE_BOOLEAN ) && 
 false === strpos( $site_url, "robots.txt") && 
 false === strpos( $site_url, "favicon.ico") && 
 false === strpos( $site_url, "wp-cron.php")
 ) {
	$xplode = explode( "/", $site_url);
	if(isset($xplode[0])){
		$config   = breeze_fetch_configuration_data( $domain );
	}
}
if ( empty( $config ) || ! isset( $config['config_path'] ) || ! @file_exists( $config['config_path'] ) ) { return; }
$breeze_temp_config = include $config['config_path'];
if ( isset( $config['blog_id'] ) ) { $breeze_temp_config['blog_id'] = $config['blog_id']; }
$GLOBALS['breeze_config'] = $breeze_temp_config; unset( $breeze_temp_config );
if ( empty( $GLOBALS['breeze_config'] ) || empty( $GLOBALS['breeze_config']['cache_options']['breeze-active'] ) ) { return; }
if ( @file_exists( '/Users/imran/Local Sites/rrfwp/app/public/wp-content/plugins/breeze/inc/cache/execute-cache.php' ) ) {
	include_once '/Users/imran/Local Sites/rrfwp/app/public/wp-content/plugins/breeze/inc/cache/execute-cache.php';
}
