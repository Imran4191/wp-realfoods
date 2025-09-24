<?php

/**
 * The plugin bootstrap file
 *
 *
 * @link              https://rositarealfoods.com
 * @since             1.0.0
 * @package           Rosita
 *
 * @wordpress-plugin
 * Plugin Name:       Rosita
 * Plugin URI:        https://rositarealfoods.com
 * Description:       This plugin is for the site customization
 * Version:           1.0.0
 * Author:            BWIP Holdings Inc
 * Author URI:        https://rositarealfoods.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rosita
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ROSITA_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rosita-activator.php
 */
function activate_rosita() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rosita-activator.php';
	Rosita_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rosita-deactivator.php
 */
function deactivate_rosita() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rosita-deactivator.php';
	Rosita_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_rosita' );
register_deactivation_hook( __FILE__, 'deactivate_rosita' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rosita.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_rosita() {

	$plugin = new Rosita();
	$plugin->run();
	create_practitioner_table();
}
run_rosita();

function create_practitioner_table() {
    global $wpdb;
    if (is_multisite()) {
        $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
        foreach ($blog_ids as $blog_id) {
            switch_to_blog($blog_id);
            $charset_collate = $wpdb->get_charset_collate();
            $table_name = $wpdb->prefix . 'practitioner_payments';
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                practitioner_id mediumint(9) NOT NULL,
                amount_paid decimal(6,2) NOT NULL,
                date_paid datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                PRIMARY KEY  (id)
            ) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
            restore_current_blog();
        }
    } else {
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'practitioner_payments';
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            practitioner_id mediumint(9) NOT NULL,
            amount_paid decimal(6,2) NOT NULL,
            date_paid datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
}
