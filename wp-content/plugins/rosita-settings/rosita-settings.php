<?php
/**
 * Plugin Name: Rosita Settings
 * Description: Develop by BWIP to handle global site settings.
 * Version: 1.0
 * Author: BWIP Holdings Inc
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

add_action('admin_menu', 'rosita_settings_plugin_menu');
function rosita_settings_plugin_menu() {
    add_options_page(
        'Rosita Global Settings', // browser tab title
        'Rosita Settings', // menu title
        'manage_options', // capability
        'rosita_settings', // options page slug
        'rosita_settings_page' // callback function
    );
}

function rosita_settings_page() {
    ?>
    <div class="wrap">
    <h1>Rosita Global Settings</h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('rosita-plugin-settings'); // rosita-plugin-settings is the register_setting option group
        do_settings_sections('rosita_settings'); // rosita_settings is options page slug
        submit_button();
        ?>
    </form>
    </div>
    <?php
}

add_action('admin_init', 'rosita_settings_page_init');

function rosita_settings_page_init() {
    // register a new setting for "rosita_settings" page
    // - first parameter 'rosita-plugin-settings' is a group name (used in settings_fields function call)
    register_setting('rosita-plugin-settings', 'registration_form_id');
    register_setting('rosita-plugin-settings', 'enabled');
    register_setting('rosita-plugin-settings', 'label');
    register_setting('rosita-plugin-settings', 'retail_type_image');
    register_setting('rosita-plugin-settings', 'pensioner_type_image');
    register_setting('rosita-plugin-settings', 'practitioner_type_image');
    register_setting('rosita-plugin-settings', 'practitionerclient_type_image');
    register_setting('rosita-plugin-settings', 'reseller_type_image');
    register_setting('rosita-plugin-settings', 'registration_newsletter_subscription_text');
    register_setting('rosita-plugin-settings', 'registration_email_tooltip');
    register_setting('rosita-plugin-settings', 'site_email_logo');
    register_setting('rosita-plugin-settings', 'site_email_footer_logo');
    register_setting('rosita-plugin-settings', 'klaviyo_api_key');
    register_setting('rosita-plugin-settings', 'approval_custom_email_logo');
    register_setting('rosita-plugin-settings', 'approval_custom_email_image_1');
    register_setting('rosita-plugin-settings', 'approval_custom_email_image_2');
    register_setting('rosita-plugin-settings', 'approval_custom_email_footer_logo');
    register_setting('rosita-plugin-settings', 'practitioner_commission_rate');
    register_setting('rosita-plugin-settings', 'practitioner_commission_threshold_email_to');
    register_setting('rosita-plugin-settings', 'trackorder_search_url');
    register_setting('rosita-plugin-settings', 'slugs_to_body_class');
    register_setting('rosita-plugin-settings', 'transparent_footer_pageslugs_body_class');
    register_setting('rosita-plugin-settings', 'uploadfields_with_custom_file_extension_list');
    register_setting('rosita-plugin-settings', 'custom_file_extension_list');
    register_setting('rosita-plugin-settings', 'bank_details');
    register_setting('rosita-plugin-settings', 'vat_number');
    register_setting('rosita-plugin-settings', 'invoice_logo');
    register_setting('rosita-plugin-settings', 'invoice_account_details');
    register_setting('rosita-plugin-settings', 'invoice_store_details');
    register_setting('rosita-plugin-settings', 'shipment_email_copy');

    add_settings_section(
        'rosita_plugin_settings_section_general', // id
        'General Settings', // title
        'rosita_plugin_settings_section_general_cb', // callback function to display the section
        'rosita_settings' // options page slug
    );
    
    add_settings_section(
        'rosita_plugin_settings_section_signupform', // id
        'Sign Up Form', // title
        'rosita_plugin_settings_section_signupform_cb', // callback function to display the section
        'rosita_settings' // options page slug
    );

    add_settings_section(
        'rosita_plugin_settings_section_email_images', // id
        'Custom Images Used In Emails', // title
        'rosita_plugin_settings_section_custom_email_images_cb', // callback function to display the section
        'rosita_settings' // options page slug
    );

    add_settings_section(
      'rosita_plugin_settings_section_sample', // id
      'Sample Section', // title
      'rosita_plugin_settings_section_sample_cb', // callback function to display the section
      'rosita_settings' // options page slug
    );

    add_settings_field(
        'registration_form_id', // id
        'Registration Form ID', // title
        'signupform_registration_field', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_signupform', // section id where you want this field to appear
        array('registration_form_id') // args
    );

    add_settings_field(
        'retail_type_image', // id
        'Retail Type Image', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_signupform', // section id where you want this field to appear
        array('retail_type_image') // args
    );

    add_settings_field(
        'pensioner_type_image', // id
        'Pensioner Type Image', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_signupform', // section id where you want this field to appear
        array('pensioner_type_image') // args
    );

    add_settings_field(
        'practitioner_type_image', // id
        'Practitioner Type Image', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_signupform', // section id where you want this field to appear
        array('practitioner_type_image') // args
    );

    add_settings_field(
        'practitionerclient_type_image', // id
        'Practitioner Client Type Image', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_signupform', // section id where you want this field to appear
        array('practitionerclient_type_image') // args
    );

    add_settings_field(
        'reseller_type_image', // id
        'Reseller Type Image', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_signupform', // section id where you want this field to appear
        array('reseller_type_image') // args
    );

    add_settings_field(
        'uploadfields_with_custom_file_extension_list', // id
        'Upload Fields With Custom File Extensions', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_signupform', // section id where you want this field to appear
        array('uploadfields_with_custom_file_extension_list') // args
    );

    add_settings_field(
        'custom_file_extension_list', // id
        'Custom File Extension List', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_signupform', // section id where you want this field to appear
        array('custom_file_extension_list') // args
    );

    add_settings_field(
        'registration_newsletter_subscription_text', // id
        'Newsletter Subscription Text', // title
        'rosita_textarea_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_signupform', // section id where you want this field to appear
        array('registration_newsletter_subscription_text') // args
    );

    add_settings_field(
        'site_email_logo', // id
        'Sitewide Email Logo Url', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_general', // section id where you want this field to appear
        array('site_email_logo') // args
    );

    add_settings_field(
        'site_email_footer_logo', // id
        'Sitewide Email Footer Logo Url', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_general', // section id where you want this field to appear
        array('site_email_footer_logo') // args
    );

    add_settings_field(
        'registration_email_tooltip', // id
        'Email Tooltip Text', // title
        'rosita_textarea_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_signupform', // section id where you want this field to appear
        array('registration_email_tooltip') // args
    );

    add_settings_field(
        'enabled', // id
        'Enabled', // title
        'rosita_checkbox_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_sample', // section id where you want this field to appear
        array('enabled') // args
    );

    add_settings_field(
        'label', // id
        'Label', // title
        'rosita_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_sample', // section id section id where you want this field to appear
        array('label') // args
    );

    add_settings_field(
        'klaviyo_api_key', // id
        'Klaviyo API Key', // title
        'rosita_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_general', // section id section id where you want this field to appear
        array('klaviyo_api_key') // args
    );

    add_settings_field(
        'approval_custom_email_logo', // id
        'Approval Custom Email Logo Url', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_email_images', // section id where you want this field to appear
        array('approval_custom_email_logo') // args
    );

    add_settings_field(
        'approval_custom_email_image_1', // id
        'Custom Approval Email Image 1', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_email_images', // section id where you want this field to appear
        array('approval_custom_email_image_1') // args
    );

    add_settings_field(
        'approval_custom_email_image_2', // id
        'Custom Approval Email Image 2', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_email_images', // section id where you want this field to appear
        array('approval_custom_email_image_2') // args
    );

    add_settings_field(
        'approval_custom_email_footer_logo', // id
        'Approval Custom Email Footer Logo Url', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_email_images', // section id where you want this field to appear
        array('approval_custom_email_footer_logo') // args
    );

    add_settings_field(
        'practitioner_commission_rate', // id
        'Practitioner Commission Rate', // title
        'rosita_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_general', // section id section id where you want this field to appear
        array('practitioner_commission_rate') // args
    );

    add_settings_field(
        'practitioner_commission_threshold_email_to', // id
        'Practitioner Commission Threshold Email To', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_general', // section id section id where you want this field to appear
        array('practitioner_commission_threshold_email_to') // args
    );
  
    add_settings_field(
        'trackorder_search_url', // id
        'Track Order Search Result Url', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_general', // section id where you want this field to appear
        array('trackorder_search_url') // args
    );

    add_settings_field(
        'slugs_to_body_class', // id
        'Add Page Slugs That Needs There Slugs Added To Body Class', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_general', // section id where you want this field to appear
        array('slugs_to_body_class') // args
    );

    add_settings_field(
        'transparent_footer_pageslugs_body_class', // id
        'Add Page Slugs That Use Transparent Footer', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_general', // section id where you want this field to appear
        array('transparent_footer_pageslugs_body_class') // args
    );

    add_settings_field(
        'bank_details', // id
        'Bank Details', // title
        'rosita_textarea_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_general', // section id where you want this field to appear
        array('bank_details') // args
    );

    add_settings_field(
        'vat_number', // id
        'Vat Number', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_general', // section id where you want this field to appear
        array('vat_number') // args
    );

    add_settings_field(
        'invoice_logo', // id
        'Invoice Logo Url', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_general', // section id where you want this field to appear
        array('invoice_logo') // args
    );

    add_settings_field(
        'invoice_account_details', // id
        'Inovice Account Details', // title
        'rosita_textarea_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_general', // section id where you want this field to appear
        array('invoice_account_details') // args
    );

    add_settings_field(
        'invoice_store_details', // id
        'Inovice Store Details', // title
        'rosita_textarea_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_general', // section id where you want this field to appear
        array('invoice_store_details') // args
    );

    add_settings_field(
        'shipment_email_copy', // id
        'Shipment Email Copy To', // title
        'rosita_wide_text_input_callback', // callback function
        'rosita_settings', // options page slug
        'rosita_plugin_settings_section_general', // section id where you want this field to appear
        array('shipment_email_copy') // args
    );
}

function rosita_plugin_settings_section_general_cb() {
    echo 'General Site Settings:';
}

function rosita_plugin_settings_section_custom_email_images_cb() {
    echo 'Custom Images Used In Emails:';
}

function rosita_plugin_settings_section_signupform_cb() {
    echo 'Enter your settings below:';
}

function rosita_plugin_settings_section_sample_cb(){
    echo 'This is the sample section header text/description.';
}

function signupform_registration_field($args) {
  $option = get_option($args[0]);
  echo "<input type='text' name='{$args[0]}' value='{$option}' /><p>Registration Form ID must match with the form_id in the Registration page shortcode.</p>";
}

function rosita_wide_text_input_callback($args) {
    $option = get_option($args[0]);
    echo "<input type='text' name='{$args[0]}' value='{$option}' style='width: 50%;' />";
}

function rosita_textarea_input_callback($args) {
    $option = get_option($args[0]);
    echo "<textarea name='{$args[0]}' rows='5' cols='50' style='width: 100%;'>{$option}</textarea>";
}

function rosita_text_input_callback($args) {
    $option = get_option($args[0]);
    echo "<input type='text' name='{$args[0]}' value='{$option}' />";
}

function rosita_checkbox_input_callback($args) {
    $option = get_option($args[0]);
    $checked = ($option === 'on') ? 'checked' : '';
    echo "<input type='checkbox' name='{$args[0]}' {$checked} />";
}

