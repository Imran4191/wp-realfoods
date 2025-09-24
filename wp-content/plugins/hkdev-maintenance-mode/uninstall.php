<?php

// exit if accessed directly
if (!defined('ABSPATH')) die();


// Make sure uninstallation is triggered
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

 //Uninstall - removing plugin options
 function hkdev_delete_plugin() {
    /* global $wpdb;
    $table_unrestricted_ips = $wpdb->prefix . 'hkdev_mm_unrestricted_ips';
    $table_access_keys      = $wpdb->prefix . 'hkdev_mm_access_keys';

    $wpdb->query("DROP TABLE IF EXISTS $table_unrestricted_ips");
    $wpdb->query("DROP TABLE IF EXISTS $table_access_keys"); */

    delete_option('hkdev_mm');
}

hkdev_delete_plugin();