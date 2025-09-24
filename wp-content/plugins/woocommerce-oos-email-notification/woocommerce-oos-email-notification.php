<?php
/**
 * Plugin Name: WooCommerce OOS Email Notification
 * Description: Sends an email to specified addresses when a WooCommerce product goes out of stock.
 * Version: 1.0
 * Author: Imran
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Create a new menu item in the WordPress admin
add_action('admin_menu', 'oos_email_notification_settings_menu');
function oos_email_notification_settings_menu() {
    add_options_page(
        'OOS Email Notification Settings', // Page title
        'OOS Email Notifications', // Menu title
        'manage_options', // Capability
        'oos-email-notification', // Menu slug
        'oos_email_notification_settings_page' // Callback function
    );
}

// Display the settings page form
function oos_email_notification_settings_page() {
    ?>
    <div class="wrap">
        <h1>Out of Stock Email Notification Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('oos_email_notification_settings_group'); // Settings group name
            do_settings_sections('oos-email-notification'); // Slug for the settings page
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Initialize settings
add_action('admin_init', 'oos_email_notification_settings_init');
function oos_email_notification_settings_init() {
    register_setting('oos_email_notification_settings_group', 'oos_notification_emails');
    
    add_settings_section(
        'oos_email_notification_section', // Section ID
        'Email Notification Settings', // Section title
        'oos_email_notification_section_callback', // Section callback function
        'oos-email-notification' // Slug for the settings page
    );

    add_settings_field(
        'oos_notification_emails', // Field ID
        'Out of Stock Notification Emails', // Field title
        'oos_notification_emails_callback', // Callback function
        'oos-email-notification', // Slug for the settings page
        'oos_email_notification_section' // Section ID
    );
}

// Callback for the section description
function oos_email_notification_section_callback() {
    echo 'Enter the email addresses (comma-separated) to be notified when a product goes out of stock.';
}

// Callback for the email field
function oos_notification_emails_callback() {
    $emails = get_option('oos_notification_emails', '');
    echo "<textarea name='oos_notification_emails' rows='5' cols='50' style='width: 100%;'>{$emails}</textarea>";
}

// Hook into WooCommerce when a product goes out of stock
add_action( 'woocommerce_product_set_stock_status', 'notify_on_oos', 10, 3 );

add_action( 'woocommerce_product_set_stock_status', 'notify_on_oos', 10, 3 );

function notify_on_oos( $product_id, $stock_status, $product ) {
    if ( $stock_status === 'outofstock' ) {
        // Get the list of emails from the settings
        $emails = get_option( 'oos_notification_emails', '' );

        if ( ! empty( $emails ) ) {
            $email_array = explode( ',', $emails );

            // Gather product details
            $product_name = $product->get_name();
            $product_sku = $product->get_sku() ? $product->get_sku() : 'N/A';
            $categories = wp_get_post_terms( $product_id, 'product_cat' );
            $category_names = wp_list_pluck( $categories, 'name' );
            $category_list = ! empty( $category_names ) ? implode( ', ', $category_names ) : 'Uncategorized';

            // Prepare the email content
            $subject = 'Product Out of Stock Notification';
            $message = sprintf(
                "<h3>This product is Out of Stock now.</h3>" .
                "<p><strong>Product Name:</strong> %s</p>" .
                "<p><strong>Product SKU:</strong> %s</p>" .
                "<p><strong>Category:</strong> %s</p>" .
                "<p><strong>Product URL:</strong> <a href='%s'>%s</a></p>",
                $product_name,
                $product_sku,
                $category_list,
                $product->get_permalink(),
                $product->get_permalink()
            );

            // Set email headers to send as HTML
            $headers = array('Content-Type: text/html; charset=UTF-8');
            // Send the email to each address
            foreach ( $email_array as $email ) {
                wp_mail( trim( $email ), $subject, $message );
            }
        }
    }
}

