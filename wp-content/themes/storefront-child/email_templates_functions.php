<?php

    include 'email-templates-images.php';

function add_custom_placeholder_for_email_assets($placeholders) {
    $placeholders[] = '{welcome_email_header_logo}';
    $placeholders[] = '{password_reset_header_image}';
    

    return $placeholders;
}

function replace_custom_placeholder_for_email_assets($replace_placeholders){
   
    $images_asset_url = get_stylesheet_directory_uri() . '/assets/images/';

    $welcome_header_logo = $images_asset_url . 'welcome.jpg';
    $reset_pw_header_image = $images_asset_url . 'password-reset.jpg';
  

    $replace_placeholders[] = $welcome_header_logo;
    $replace_placeholders[] = $reset_pw_header_image;
    return $replace_placeholders;
}


// Add custom email header to Ultimate Member welcome email
function my_custom_email_header_placeholder($patterns) {
    $patterns[] = '{custom_email_header}';
    return $patterns;
}

function my_custom_email_header_replace($replace) {
    $replace[] = '<tr>
        <td class="header" style="background-color: #08456b; color: #ffffff; font-family: Helvetica, Arial, sans-serif;">
            <table width="100%" cellpadding="25px">
                <tbody>
                <tr>
                    <td width="50%" style="padding:25px">
                        <h2 style="margin: 0; color: #ffffff; font-family: Helvetica, Arial, sans-serif; font-size: 30px;">Welcome
                        </h2>
                    </td>
                    <td width="50%" align="right" valign="middle" style="padding:25px">
                        <a class="logo" href="https://www.rositarealfoods.co.uk/">
                            <img width="148" height="52" src="'.get_stylesheet_directory_uri().'/assets/images/logo_email.png" alt="Rosita Real Foods" border="0">
                        </a>
                    </td>
                </tr>
            </tbody>
            </table>
        </td>
    </tr>';
    return $replace;
}

function pw_reset_header($patterns) {
    $patterns[] = '{reset_pw_header}';
    return $patterns;
}

function pw_reset_header_replace($replace) {
    $replace[] = '<table width="100%" style="max-width: 600px;background:#fff;">
                                <tbody>
                                    <tr>
                                        <td class="header" style="background-color: #fff; color: #ffffff; font-family: Raleway, sans-serif;">
                                            <table width="100%" cellpadding="25px">
                                              <tbody>
                                                        <tr>
                                                        
                                                            <td class="header" style="background-color: #fff; color: #ffffff; font-family: Helvetica, Arial, sans-serif !important;padding:0;">
                                                                <table width="100%" cellpadding="25px">
                                                                    <tbody><tr>
                                                                        <td width="100%" style="padding:0px">
                                                                            <img src="{password_reset_header_image}" width="100%" "="">
                                                                        </td>
                                                                    </tr>
                                                                    
                                                                    </tbody>
                                                                </table>               
                                                            </td>
                                                            </tr>
                                                            <tr>
                                                            <td style="padding: 0;">
                                                                    <table width="100%" cellpadding="25px" style="background:
                                                                            #fff;">
                                                                        <tbody>
                                                                        <tr style="background: #fff; padding: 0 20px;">
                                                                            <td style="text-align: left;">
                                                                                <a 
                                                                                target="_blank" 
                                                                                href="{site_url}/faq"
                                                                                style="text-align: center; padding-left: 25px; color: #878787; font-size: 14px; font-family: Helvetica, Arial, sans-serif !important; margin: 0;text-transform: uppercase; text-decoration: none !important;">
                                                                                    FAQs
                                                                                </a>
                                                                            </td>
                                                                            <td style=" text-align: center;">
                                                                                
                                                                                <a target="_blank" href="{site_url}" style="text-align: center; color: #878787; font-size: 14px; font-family: Helvetica, Arial, sans-serif !important; margin: 0;text-transform: uppercase; text-decoration: none !important;">
                                                                                    SHOP
                                                                                    </a>
                                                                                    <span style="color: #000;font-size: 14px; font-family: Helvetica, Arial, sans-serif !important;margin-left:5px;">
                                                                                    </span>
                                                                            </td>
                                                                            <td style=" text-align: right;">
                                                                    
                                                                            <a target="_blank" href="{site_url}/login" style="text-align: center; padding-right: 25px; color: #878787; font-size: 14px; font-family: Helvetica, Arial, sans-serif !important; margin: 0;text-transform: uppercase; text-decoration: none !important;">
                                                                                LOGIN</a><span style="color: #000;font-size: 14px; font-family: Helvetica, Arial, sans-serif !important;margin-left:5px;"></span>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                            </td>                   
                                                        </tr>
                                                </tbody>
                                            </table>
                                            
                                        </td>
                                    </tr>
                                    
                                    
                                </tbody>
                    </table>';
    return $replace;
}
// Add custom email footer to  email

function my_custom_email_footer_placeholder($patterns) {
    $patterns[] = '{custom_email_footer}';
    return $patterns;
}

function my_custom_email_footer_replace($replace) {
    global $images;
    $replace[] = '<table width="100%" style=" max-width: 600px; background: #fff; font-family: Helvetica, Arial, sans-serif !important; ">
                    <tbody>
                        <tr>
                        <td
                            class="header"
                            style="
                            background-color: #08456b;
                            background-size: contain;
                            height: 194px;
                            display: block;
                            color: #ffffff;
                            font-family: Helvetica, Arial, sans-serif !important;
                            "
                        >
                            <table width="90%" cellpadding="25px" style="margin: 0 auto">
                            <tbody>
                                <tr>
                                <td width="35%" style="padding: 35px 25px 25px">
                                    <a class="logo" href="{site_url}">
                                    <img
                                        src="'.$images['logo_email'].'"
                                        alt="Rosita"
                                        width="125"
                                    />
                                    </a>
                                </td>
                                <td
                                    class="footer-right"
                                    width="65%"
                                    align="right"
                                    valign="middle"
                                    style="padding: 35px 25px 25px"
                                >
                                    <br />
                                    <p
                                    style="
                                        text-align: right;
                                        color: #fff;
                                        font-size: 12px;
                                        font-family: Helvetica, Arial, sans-serif !important;
                                        margin-top: 10px;
                                    "
                                    >
                                    A CONSCIOUS VISION TO HELP PEOPLE THRIVE.
                                    </p>
                                    <table width="100%" cellpadding="25px" style="">
                                    <tbody>
                                        <tr style="padding: 0">
                                        <td style="padding: 0 0px 0 20px">
                                            <a
                                            target="_blank"
                                            href="https://www.facebook.com/rositarealfoods/"
                                            style="margin: 0"
                                            >
                                            <img
                                                src="'.$images['fb-icon'].'"
                                                alt="Rosita"
                                                width="30"
                                            /></a>
                                        </td>
                                        <td style="padding: 0 0px 0 20px">
                                            <a
                                            target="_blank"
                                            href="https://twitter.com/rositarealfoods/"
                                            style="margin: 0"
                                            >
                                            <img
                                                src="'.$images['twitter-x-icon'].'"
                                                alt="Rosita"
                                                width="30"
                                            /></a>
                                        </td>
                                        <td style="padding: 0 0px 0 20px">
                                            <a
                                            target="_blank"
                                            href="https://www.instagram.com/rositarealfoods/?hl=en"
                                            style="margin: 0"
                                            >
                                            <img
                                                src="'.$images['insta-icon'].'"
                                                alt="Rosita"
                                                width="30"
                                            /></a>
                                        </td>
                                        <td style="padding: 0 0px 0 20px">
                                            <a
                                            target="_blank"
                                            href="https://www.pinterest.co.uk/rositarealfoods/?eq=rosita%20real%20food&amp;etslf=5409"
                                            style="margin: 0"
                                            >
                                            <img
                                                src="'.$images['pinterest-icon'].'"
                                                alt="Rosita"
                                                width="30"
                                            />
                                            </a>
                                        </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </td>
                        </tr>
                    </tbody>
            </table>';
    return $replace;

}

function welcome_email_header($patterns) {
    $patterns[] = '{welcome_email_header}';
    return $patterns;
}

function welcome_email_header_replace($replace) {
    $replace[] = ' <tr>
                                                <td class="header" style="background-color: #fff; color: #ffffff; font-family: Raleway, sans-serif;">
                                                    <table width="100%" cellpadding="25px">
                                                        <tbody>
                                                            <tr>
                                                                <td class="header" style="background-color: #fff; color: #ffffff; font-family: Helvetica, Arial, sans-serif !important;padding:0;">
                                                                    <table width="100%" cellpadding="25px">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td width="100%" style="padding:0px">
                                                                                    <img src="{welcome_email_header_logo}"  width="100%">
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 0;">
                                                                     <table width="100%" cellpadding="25px" style="background:
                                                                            #fff;">
                                                                        <tbody>
                                                                        <tr style="background: #fff; padding: 0 20px;">
                                                                            <td style="text-align: left;">
                                                                                <a 
                                                                                target="_blank" 
                                                                                href="{site_url}/faq"
                                                                                style="text-align: center; padding-left: 25px; color: #878787; font-size: 14px; font-family: Helvetica, Arial, sans-serif !important; margin: 0;text-transform: uppercase; text-decoration: none !important;">
                                                                                    FAQs
                                                                                </a>
                                                                            </td>
                                                                            <td style=" text-align: center;">
                                                                                
                                                                                <a target="_blank" href="{site_url}" style="text-align: center; color: #878787; font-size: 14px; font-family: Helvetica, Arial, sans-serif !important; margin: 0;text-transform: uppercase; text-decoration: none !important;">
                                                                                    SHOP
                                                                                    </a>
                                                                                    <span style="color: #000;font-size: 14px; font-family: Helvetica, Arial, sans-serif !important;margin-left:5px;">
                                                                                    </span>
                                                                            </td>
                                                                            <td style=" text-align: right;">
                                                                    
                                                                            <a target="_blank" href="{site_url}/login" style="text-align: center; padding-right: 25px; color: #878787; font-size: 14px; font-family: Helvetica, Arial, sans-serif !important; margin: 0;text-transform: uppercase; text-decoration: none !important;">
                                                                                LOGIN</a><span style="color: #000;font-size: 14px; font-family: Helvetica, Arial, sans-serif !important;margin-left:5px;"></span>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>';
    return $replace;
}
add_filter('woocommerce_get_order_item_totals', 'custom_woocommerce_order_totals_label', 10, 3);

function custom_woocommerce_order_totals_label($total_rows, $order, $tax_display) {
    if (isset($total_rows['order_total']['label'])) {
        $total_rows['order_total']['label'] = __('Grand Total:', 'woocommerce');
    }

    return $total_rows;
}
add_filter('woocommerce_get_order_item_totals', 'add_vat_row_to_order_email_totals', 10, 3);

function add_vat_row_to_order_email_totals($total_rows, $order, $tax_display) {
    // Check if there are taxes applied to the order
    if ($order->get_total_tax() > 0) {
        $current_site_id = get_current_blog_id();
        $vat_or_gst_label = '';
        $vat_or_gst_amount = '';
        if ($current_site_id == 1 || $current_site_id == 4) {
            $vat_or_gst_label = __('Includes VAT of:', 'woocommerce');
        } elseif ($current_site_id == 2 || $current_site_id == 3) {
            $vat_or_gst_label = __('Includes GST of:', 'woocommerce');
        }

        $total_rows = array_merge(array_slice($total_rows, 0, -1), array(
            'vat' => array(
                'label' => __($vat_or_gst_label, 'woocommerce'),
                'value' => wc_price($order->get_total_tax(), array('currency' => $order->get_currency())),
            )
        ), array_slice($total_rows, -1));
    }

    return $total_rows;
}

add_filter('woocommerce_get_order_item_totals', 'custom_woocommerce_hide_tax_info_in_order_total', 10, 3);

function custom_woocommerce_hide_tax_info_in_order_total($totals, $order, $tax_display) {
    if (isset($totals['order_total'])) {
        $formatted_total = wc_price($order->get_total());
        $totals['order_total']['value'] = $formatted_total;
    }

    return $totals;
}
add_filter('woocommerce_get_order_item_totals', 'custom_woocommerce_hide_payment_method_in_order_total', 10, 3);

function custom_woocommerce_hide_payment_method_in_order_total($totals, $order, $tax_display) {
    if (isset($totals['payment_method'])) {
        unset($totals['payment_method']);
    }

    return $totals;
}
add_filter('woocommerce_get_order_item_totals', 'customize_email_order_totals_shipping_label', 10, 3);

function customize_email_order_totals_shipping_label($totals, $order, $tax_display) {
    if (isset($totals['shipping'])) {
        $shipping_total = $order->get_shipping_total();
        $shipping_tax = $order->get_shipping_tax();
        $shipping_with_tax = $shipping_total + $shipping_tax;
        $totals['shipping']['label'] = __('Shipping & Handling:', 'woocommerce');
        $totals['shipping']['value'] = wc_price($shipping_with_tax, array('currency' => $order->get_currency()));
    }

    return $totals;
}


function user_role_placeholder($patterns) {
    $patterns[] = '{user_role}';
    return $patterns;
}

function remove_um_and_capitalize($word) {
    if (strpos($word, 'um_') !== false) {
        $word = str_replace('um_', '', $word);
        $word = ucwords($word);
    }
    return $word;
}

function replace_user_role_placeholder($replace) {
   $user_id = um_user('ID');
    // $replace[] = get_user_meta( $user_id, 'role_radio', true );
    $user_info = get_userdata($user_id);
    $roles = is_array($user_info->roles) ? implode(', ', $user_info->roles) : 'No role';
    $replace[] = remove_um_and_capitalize($roles);
    
    return $replace;
}

function custom_display_site_name_placeholder($patterns) {
    $patterns[] = '{site_display_name}';
    return $patterns;
}

function get_site_blog_name_replace($replaces) {
    $site_blog_name = get_bloginfo('name');
    $replaces[] = $site_blog_name;
    return $replaces;
}




?>



