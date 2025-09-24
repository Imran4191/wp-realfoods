<?php
/**
 * Plugin Name: Bwip Table Rate Shipping
 * Description: A custom table rate shipping method for WooCommerce.
 * Version: 1.0
 * Author: Bwip
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Automattic\WooCommerce\Internal\DataStores\Orders\CustomOrdersTableController;

/**
 * Create shipping table
 */
function create_shipping_table() {
    global $wpdb;
    if (is_multisite()) {
        $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
        foreach ($blog_ids as $blog_id) {
            switch_to_blog($blog_id);
            $charset_collate = $wpdb->get_charset_collate();
            $table_name = $wpdb->prefix . 'bwip_table_rate';
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                id INT(11) NOT NULL AUTO_INCREMENT,
                dest_country_id VARCHAR(4) NOT NULL DEFAULT '0',
                dest_region VARCHAR(30) NOT NULL DEFAULT '*',
                dest_city VARCHAR(30) NOT NULL DEFAULT '*',
                dest_zip VARCHAR(10) NOT NULL DEFAULT '*',
                dest_zip_to VARCHAR(10) NOT NULL DEFAULT '*',
                condition_name VARCHAR(20) NOT NULL,
                condition_from_value DECIMAL(12,2) NOT NULL DEFAULT '0.00',
                condition_to_value DECIMAL(12,2) NOT NULL DEFAULT '0.00',
                price DECIMAL(12,2) NOT NULL DEFAULT '0.00',
                cost DECIMAL(12,2) NOT NULL DEFAULT '0.00',
                shipping_method VARCHAR(255) NOT NULL,
                discounts VARCHAR(255) NULL,
                PRIMARY KEY  (id),
                UNIQUE KEY idx_bwip_table_rate (dest_country_id, dest_region, dest_city, dest_zip, condition_name, condition_from_value, condition_to_value, shipping_method)
            ) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
            restore_current_blog();
        }
    } else {
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'bwip_table_rate';
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id INT(11) NOT NULL AUTO_INCREMENT,
            dest_country_id VARCHAR(4) NOT NULL DEFAULT '0',
            dest_region VARCHAR(30) NOT NULL DEFAULT '*',
            dest_city VARCHAR(30) NOT NULL DEFAULT '*',
            dest_zip VARCHAR(10) NOT NULL DEFAULT '*',
            dest_zip_to VARCHAR(10) NOT NULL DEFAULT '*',
            condition_name VARCHAR(20) NOT NULL,
            condition_from_value DECIMAL(12,2) NOT NULL DEFAULT '0.00',
            condition_to_value DECIMAL(12,2) NOT NULL DEFAULT '0.00',
            price DECIMAL(12,2) NOT NULL DEFAULT '0.00',
            cost DECIMAL(12,2) NOT NULL DEFAULT '0.00',
            shipping_method VARCHAR(255) NOT NULL,
            discounts VARCHAR(255) NULL,
            PRIMARY KEY  (id),
            UNIQUE KEY idx_bwip_table_rate (dest_country_id, dest_region, dest_city, dest_zip, condition_name, condition_from_value, condition_to_value, shipping_method)
        ) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
}
create_shipping_table();

/**
 * Include your shipping file.
 */
function bwip_include_shipping_method() {
    require_once 'bwip-class-shipping-method.php';
}
add_action('woocommerce_shipping_init', 'bwip_include_shipping_method');

/**
 * Add Your shipping method class in the shipping list
 */
function bwip_add_shipping_method($methods) {
    $methods[] = 'Bwip_Shipping_Method';
    return $methods;
}
add_filter('woocommerce_shipping_methods', 'bwip_add_shipping_method');

// Restrict shipping method based on admin approval
add_action('show_user_profile', 'shipping_restriction_show_user_profile_fields');
add_action('edit_user_profile', 'shipping_restriction_show_user_profile_fields');
add_action('personal_options_update', 'shipping_restriction_save_user_profile_fields');
add_action('edit_user_profile_update', 'shipping_restriction_save_user_profile_fields');

function shipping_restriction_show_user_profile_fields($user) {
    ?>
    <h3><?php _e('Customer Collection Shipping Method Availability', 'woocommerce'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="restricted_shipping_method_enabled"><?php _e('Enable Customer Collection Shipping Method'); ?></label></th>
            <td>
                <input type="checkbox" name="restricted_shipping_method_enabled" id="restricted_shipping_method_enabled" value="1" <?php checked(get_the_author_meta('restricted_shipping_method_enabled', $user->ID), 1); ?> />
                <span class="description"><?php _e('Enable customer collection shipping method for this user.', 'woocommerce'); ?></span>
            </td>
        </tr>
    </table>
    <?php
}

function shipping_restriction_save_user_profile_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    update_user_meta($user_id, 'restricted_shipping_method_enabled', $_POST['restricted_shipping_method_enabled']);
}

add_action('add_meta_boxes', 'wc_available_shipping_meta_box');
function wc_available_shipping_meta_box() {
    if (class_exists('Automattic\WooCommerce\Internal\DataStores\Orders\CustomOrdersTableController')) {
        $screen = (wc_get_container()->get(CustomOrdersTableController::class)->custom_orders_table_usage_is_enabled() ? wc_get_page_screen_id('shop-order') : 'shop_order');
    } else {
        $screen = 'shop_order';
    }
    add_meta_box(
        'bwip-shipping-method',
        __('Available Shipping Method', 'woocommerce'),
        'wc_available_shipping_meta_box_callback',
        $screen,
        'side',
        'high'
    );
}

function wc_available_shipping_meta_box_callback($post) {
    $order = wc_get_order($post->ID);
    $address = array(
        'country'   => $order->get_shipping_country(),
        'state'     => $order->get_shipping_state(),
        'postcode'  => $order->get_shipping_postcode(),
        'city'      => $order->get_shipping_city(),
        'address'   => $order->get_shipping_address_1(),
        'address_2' => $order->get_shipping_address_2(),
    );

    $package = array(
        'destination' => $address,
        'contents'    => array(),
        'contents_cost' => 0,
        'applied_coupons' => array(),
        'user'        => array(
            'ID' => $order->get_user_id(),
        ),
    );

    foreach ($order->get_items() as $item_id => $item) {
        $product = $item->get_product();
        if (!$product) {
            continue;
        }
        $package['contents'][] = array(
            'key'          => $item_id,
            'product_id'   => $product->get_id(),
            'variation_id' => $product->get_type() === 'variation' ? $product->get_id() : 0,
            'quantity'     => $item->get_quantity(),
            'data'         => $product,
        );
        $package['contents_cost'] += $item->get_total();
    }

    $shipping_methods = WC()->shipping->get_shipping_methods();
    $available_rates = calculate_shipping($post->ID, $package);

    // $package['rates'] = array();
    // foreach ($shipping_methods as $method) {
    //     if ($method->supports('shipping-zones')) {
    //         $zones = WC_Shipping_Zones::get_zones();
    //         foreach ($zones as $zone) {
    //             $zone_shipping_methods = $zone['shipping_methods'];
    //             foreach ($zone_shipping_methods as $zone_method) {
    //                 if ($zone_method->id === $method->id && $zone_method->is_enabled()) {
    //                     $zone_method->calculate_shipping($package);
    //                     $available_rates = array_merge($available_rates, $zone_method->get_rates_for_package($package));
    //                 }
    //             }
    //         }
    //     }
    // }

    echo '<div class="order_data_column">';
    if (!empty($available_rates)) {
        echo '<ul>';
        foreach ($available_rates as $rate_id => $rate) {
            $tax = 0;
            foreach ($rate->taxes as $tax_rate_id => $tax_amount) {
                $tax = $tax_amount;
            }
            echo '<li>' . $rate->label . ' - <strong>VAT exclusive: ' . $rate->cost . '</strong> - <strong>VAT: ' . $tax . '</strong></li>';
        }
        echo '</ul>';
    } else {
        echo '<p>' . __('No shipping rates available.', 'your-text-domain') . '</p>';
    }
    echo '</div>';
}

function calculate_shipping($order_id, $package = array()) {
    global $wpdb;
    $order = wc_get_order($order_id);
    $shipping_method = 'bwip-shipping-method';
    $settings = get_option('woocommerce_' . $shipping_method . '_settings');
    $customer_id = $order->get_user_id();

    $shippingData = [];
    $postcode = ltrim($package['destination']['postcode'], '0');
    $country = $package['destination']['country'];
    $state = $package['destination']['state'];
    $city = $package['destination']['city'];
    $condition_name = $settings['table_rate_condition'];
    $weight = 0;
    foreach ($package['contents'] as $item_id => $values) {
        $_product = $values['data'];
        $weight += $_product->get_weight() * $values['quantity'];
    }

    if (!ctype_digit($postcode)) {
        $zipSearchString = " AND '{$postcode}' LIKE dest_zip";
    } else {
        $zipSearchString = " AND {$postcode} >= dest_zip AND {$postcode} <= dest_zip_to";
    }
    $zoneWhere = '';
    $bind = [];
    for ($j = 0; $j < 8; $j++) {
        switch ($j) {
            case 0:
                $zoneWhere = "dest_country_id = '{$country}' AND dest_region = '{$state}' AND STRCMP(LOWER(dest_city),LOWER('{$city}'))= 0 " . $zipSearchString;
                break;
            case 1:
                $zoneWhere = "dest_country_id = '{$country}' AND dest_region = '{$state}' AND dest_city='*' " . $zipSearchString;
                break;
            case 2:
                $zoneWhere = "dest_country_id = '{$country}' AND dest_region = '{$state}' AND STRCMP(LOWER(dest_city),LOWER('{$city}'))= 0 AND dest_zip ='*'";
                break;
            case 3:
                $zoneWhere = "dest_country_id = '{$country}' AND dest_region = '*' AND STRCMP(LOWER(dest_city),LOWER('{$city}'))= 0 AND dest_zip ='*'";
                break;
            case 4:
                $zoneWhere = "dest_country_id = '{$country}' AND dest_region = '*' AND dest_city ='*' " . $zipSearchString;
                break;
            case 5:
                $zoneWhere = "dest_country_id = '{$country}' AND dest_region = '{$state}'  AND dest_city ='*' AND dest_zip ='*'";
                break;
            case 6:
                $zoneWhere = "dest_country_id = '{$country}' AND dest_region = '*' AND dest_city ='*' AND dest_zip ='*'";
                break;
            case 7:
                $zoneWhere = "dest_country_id = '*' AND dest_region = '*' AND dest_city ='*' AND dest_zip ='*'";
                break;
        }

        $query = $wpdb->prepare(
            "SELECT shipping_method, price, cost, discounts FROM {$wpdb->prefix}bwip_table_rate WHERE $zoneWhere AND condition_name = '{$condition_name}' AND condition_from_value < {$weight} AND condition_to_value >= {$weight}"
        );

        $results = $wpdb->get_results($query);

        if (!empty($results)) {
            foreach ($results as $data) {
                $method = strtolower(str_replace(' ', '-', $data->shipping_method));
                $shippingData[$method] = $data;
            }
            break;
        }
    }

    $available_rates = [];
    $i = 1;
    foreach ($shippingData as $shippingMethod) {
        $shippingPrice = $shippingMethod->price;
        $shippingDiscount = 0;
        $shippingDiscountTxt = $shippingMethod->discounts;
        $subTotal = $order->get_subtotal();
        if ($shippingMethod->price > 0 && $shippingDiscountTxt != "") {
            if (is_string($shippingDiscountTxt)) {
                $shippingDiscountArray = explode('-', $shippingDiscountTxt);
                if (is_array($shippingDiscountArray)) {
                    $discPercent = [];
                    foreach ($shippingDiscountArray as $disTxt) {
                        if (is_string($disTxt) && $disTxt != '') {
                            $disTxtArray = explode(':', str_replace('"', '', $disTxt));
                            if (isset($disTxtArray[0]) && isset($disTxtArray[1])) {
                                $orderAmount = (float) $disTxtArray[0];
                                $percentage  = (float) $disTxtArray[1];
                                if ($orderAmount > 0 && $percentage > 0 && $subTotal >= $orderAmount) {
                                    $discPercent[] = $percentage;
                                }
                            }
                        }
                    }
                    if (!empty($discPercent)) {
                        $percentage = max($discPercent);
                        $shippingDiscount = round(($shippingPrice * $percentage / 100), 2);
                    }
                }
            }
        }
        $shippingCost = $shippingPrice + $shippingMethod->cost - $shippingDiscount;

        $tax_rates = WC_Tax::get_rates(get_option('woocommerce_shipping_tax_class'));
        $taxes = WC_Tax::calc_shipping_tax($shippingCost, $tax_rates);

        $restricted_shipping_method_title = $settings['restricted_method'];
        $restricted_shipping_method_enabled = get_user_meta($customer_id, 'restricted_shipping_method_enabled', true);
        if ($restricted_shipping_method_title == $shippingMethod->shipping_method) {
            if ($restricted_shipping_method_enabled != 1) {
                continue;
            } else {
                $rate_id = $shipping_method . '-' . $i;
                $rate_label = $shippingMethod->shipping_method;
                $rate_cost = $shippingCost;

                $available_rates[] = new WC_Shipping_Rate(
                    $rate_id,
                    $rate_label,
                    $rate_cost,
                    $taxes,
                    $shipping_method
                );
            }
        } else {
            $rate_id = $shipping_method . '-' . $i;
            $rate_label = $shippingMethod->shipping_method;
            $rate_cost = $shippingCost;

            $available_rates[] = new WC_Shipping_Rate(
                $rate_id,
                $rate_label,
                $rate_cost,
                $taxes,
                $shipping_method
            );
        }
        $i++;
    }
    return $available_rates;
}

// Add custom CSS to hide the meta box by default
add_action('admin_head', function() {
    echo '<style>
        #bwip-shipping-method {
            display: none;
        }
    </style>';
});

function bwip_shipping_enqueue_scripts() {
    wp_enqueue_script(
        'bwip-shipping-js',
        plugin_dir_url(__FILE__) . 'bwip-shipping.js',
        array('jquery'),
        '1.0',
        true
    );
}
add_action('admin_enqueue_scripts', 'bwip_shipping_enqueue_scripts');
