<?php
require_once( __DIR__ . '/bwip-classes/ultimatemember-fields.php' );
require_once( __DIR__ . '/bwip-classes/ultimatemember-query.php' );
UM()->classes['query'] = new Bwipultimatememberquery();
require_once( __DIR__ . '/includes/shortcodes.php' );

if (!defined('STOREFRONT_CHILD_PATH')) {
    define('STOREFRONT_CHILD_PATH', get_stylesheet_directory());
}

function storefronchild_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'parent-style' ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'storefronchild_theme_enqueue_styles' );

// Add CSS and JS files
function rrf_enqueue_css_js_files() {
    wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css2?family=Raleway&family=Roboto&display=swap');
    wp_enqueue_style('fontawesome', '//use.fontawesome.com/releases/v5.1.0/css/all.css');
    wp_enqueue_style('bootstrap', get_theme_file_uri('/assets/css/bootstrap.css'), NULL, '5.3.2', 'all');
    wp_enqueue_style('rrf', get_theme_file_uri('/assets/css/rrf.css'), NULL, '1.0.1', 'all');
    wp_enqueue_style('liezl_css', get_theme_file_uri('/assets/css/liezl.css'), NULL, '1.3.3', 'all');
    wp_enqueue_style('nayem_css', get_theme_file_uri('/assets/css/nayem.css'), NULL, '1.1.6', 'all');
    wp_enqueue_style('imran_css', get_theme_file_uri('/assets/css/imran.css'), NULL, '1.0.9', 'all');
    wp_enqueue_style('jerico_css', get_theme_file_uri('/assets/css/jerico.css'), NULL, '1.1.0', 'all');
    wp_enqueue_style('ron', get_theme_file_uri('/assets/css/ron.css'), NULL, '1.0.13', 'all');
    wp_enqueue_script('bootstrap', get_theme_file_uri('/assets/js/bootstrap.js'), NULL, '5.3.2', true);
    wp_enqueue_script('rrf', get_theme_file_uri('/assets/js/rrf.js'), NULL, '1.2.8', true);
    wp_enqueue_script('sticky_sidebar', get_theme_file_uri('/assets/js/sticky_sidebar.min.js'), NULL, '1.0.0', true);
    wp_enqueue_script('jquery_validate', get_theme_file_uri('/assets/js/jquery.validate.min.js'), NULL, '1.0.0', true);
    wp_enqueue_script('google-recapthca-api-v2', 'https://www.google.com/recaptcha/api.js', NULL, '2.0', true);
}
add_action('wp_enqueue_scripts', 'rrf_enqueue_css_js_files');

// Hide Item and Items text beside minicart
function storefront_cart_link() {
    if ( ! storefront_woo_cart_available() ) {
        return;
    }
    ?>
        <a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'storefrontchild' ); ?>">
            <span class="count"><?php echo wp_kses_data( sprintf( _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'storefrontchild' ), WC()->cart->get_cart_contents_count() ) ); ?></span>
        </a>
    <?php
}

// BWIPIT-2770
// override the rendering of the fields for the register form
remove_action( 'um_main_register_fields', 'um_add_register_fields', 100, 1 );
function rrf_add_register_fields( $args ) {
    UM()->classes['fields'] = new Bwipultimatememberfields();
    echo UM()->fields()->display( 'register', $args );
}
add_action( 'um_main_register_fields', 'rrf_add_register_fields', 100, 1 );

// BWIPIT-1772
function add_custom_placeholder_for_account_approve_email($placeholders) {
    $placeholders[] = '{site_email_logo}';
    $placeholders[] = '{site_email_footer_logo}';
    return $placeholders;
}
add_filter( 'um_template_tags_patterns_hook', 'add_custom_placeholder_for_account_approve_email' );

function add_replace_custom_placeholder_for_account_approve_email($replace_placeholders){
    $replace_placeholders[] = get_option('site_email_logo');
    $replace_placeholders[] = get_option('site_email_footer_logo');
    return $replace_placeholders;
}
add_filter( 'um_template_tags_replaces_hook', 'add_replace_custom_placeholder_for_account_approve_email' );

//Add forgot password link to login form
function modify_login_form_middle_defaults($content, $args) {
    $content .= '<span id="toggle-password" class="eye-open"></span><a class="action remind" href="' . wp_lostpassword_url() . '"><span>Forgotten Your Password?</span></a>';
    return $content;
}

add_filter("login_form_middle", "modify_login_form_middle_defaults",  10,  2);

// BWIPIT-2812
add_action( 'um_after_user_is_approved', 'remove_pensioner_id', 10, 1 );
function remove_pensioner_id( $user_id ) {
    $userdata  = get_userdata( $user_id );
	if ( in_array('um_pensioner', $userdata->roles) ){
        $key = 'pensioner_identification';
        $upload_dir = wp_upload_dir();
        $um_uploads_url = $upload_dir['basedir'] . '/ultimatemember/' . $user_id . '/';

        $pensioner_id_file = get_user_meta($user_id, $key, true);
        if($pensioner_id_file) {
            $pensioner_id_file = $um_uploads_url . $pensioner_id_file;
            $result = unlink($pensioner_id_file);
        }

        $original_file_data = get_user_meta($user_id, $key . '_metadata', true);
        if($original_file_data) {
            $temp_file = parse_url($original_file_data['name'], PHP_URL_PATH);
            $temp_file = get_home_path() . $temp_file;
            $result = unlink($temp_file);
        }

        delete_user_meta( $user_id, $key );
        delete_user_meta( $user_id, $key . '_metadata' );
    }
}

function get_full_country_name($short_code) {
    if (!class_exists('WC_Countries')) {
        return null;
    }
    $countries = WC()->countries->get_countries();
    if (isset($countries[$short_code])) {
        return $countries[$short_code];
    }

    return null;
}

add_filter( 'woocommerce_account_menu_items', 'add_remove_change_my_account_links',  9999 );
function add_remove_change_my_account_links( $items ) {
    // Remove the My Account links
    unset( $items['downloads'] );
    unset( $items['customer-logout'] );
    unset( $items['wishlist'] );
    unset( $items['payment-methods'] );
    unset( $items['sumo-subscriptions'] );

    //Change the My Account Menu Title
    $items['dashboard'] = __( 'My Account', 'storefrontchild' );
    $items['orders'] = __( 'My Order', 'storefrontchild' );
    $items['edit-address'] = __( 'Address Book', 'storefrontchild' );
    $items['edit-account'] = __( 'Account Information', 'storefrontchild' );

    // Add new links
    $items['quickorder'] = __( 'Quick Order', 'storefrontchild' );
    $items['customer-support'] = __( 'Customer Support', 'storefrontchild' );
    $items['practitioner'] = __( 'Practitioner Info', 'storefrontchild' );
    $items['delete-account'] = __( 'Delete Account', 'storefrontchild' );

    // Define the priority for each menu item
    $priorities = array(
        'dashboard'          =>  1,
        'edit-account'       =>  2,
        'edit-address'       =>  3,
        'orders'             =>  4,
        'subscriptions'       =>  5,
        'quickorder'         =>  6,
        'customer-support'   =>  7,
        'practitioner'       =>  8,
        'delete-account'     =>  9,
    );

    // Sort the items based on the defined priorities
    uksort( $items, function( $a, $b ) use ( $priorities ) {
        $a_priority = $priorities[$a] ?? PHP_INT_MAX;
        $b_priority = $priorities[$b] ?? PHP_INT_MAX;

        return $a_priority - $b_priority;
    });

    return $items;
}

// Set the URL for the custom menu item
add_filter( 'woocommerce_get_endpoint_url', 'set_custom_endpoint_url',  10,  4 );
function set_custom_endpoint_url( $url, $endpoint, $value, $permalink ) {
    if ( 'quickorder' === $endpoint ) {
        $url = '/quickorder';
    } elseif ( 'customer-support' === $endpoint ) {
        $url = '/contact';
    }
    return $url;
}

// Add custom endpoint for Newsletter
function add_custom_endpoint() {
    add_rewrite_endpoint( 'newsletter-subscription', EP_ROOT | EP_PAGES );
}
add_action( 'init', 'add_custom_endpoint' );


function custom_query_vars( $vars ) {
    $vars[] = 'newsletter-subscription';
    return $vars;
}
add_filter( 'query_vars', 'custom_query_vars', 0 );


function custom_endpoint_content() {
    wc_get_template( 'myaccount/newsletter-subscription.php' );
}
add_action( 'woocommerce_account_newsletter-subscription_endpoint', 'custom_endpoint_content' );

function custom_endpoint_title( $title, $id = null ) {
    global $wp;
    if ( is_account_page() && isset( $wp->query_vars['newsletter-subscription'] ) ) {
        $title = __('Newsletter Subscription', 'storefrontchild');
    }
    return $title;
}
add_filter( 'storefront_page_title', 'custom_endpoint_title', 10, 2 );

function flush_rewrite_rules_if_needed() {
    global $wp_rewrite;

    $rules = $wp_rewrite->wp_rewrite_rules();
    $custom_endpoint = 'newsletter-subscription/';

    if ( ! isset( $rules[$custom_endpoint] ) ) {
        add_custom_endpoint(); // Register custom endpoints
        flush_rewrite_rules();  // Flush the rules
    }
}
add_action( 'init', 'flush_rewrite_rules_if_needed', 20 );

function isSubscribed($email, $listId, $apiKey) {
    $url = 'https://a.klaviyo.com/api/lists/'.$listId.'/relationships/profiles/?filter=equals(email,"'.$email.'")';

    $headers = array(
        'Authorization' => 'Klaviyo-API-Key ' . $apiKey,
        'Accept' => 'application/json',
        'Revision' => '2024-07-15',
    );

    $response = wp_remote_get($url, array(
        'headers' => $headers,
    ));

    $responseData = json_decode(wp_remote_retrieve_body($response), true);
    if (!empty($responseData) && isset($responseData['data']) && isset($responseData['data'][0]) && isset($responseData['data'][0]['id'])) {
        return true;
    } 
    return false;
}

//BWIPIT-2774
function must_exist_practitioner_code($args){
    if( isset($args['role_radio']) && $args['role_radio'] == 'um_practitioner-client') {
        $user_id = isset($args['practitioner_code']) ? trim($args['practitioner_code']) : '';
        if( $user_id ) {
            $user = get_userdata($user_id);
            if( $user ) {
                $account_status = get_user_meta($user_id, 'account_status', true);
                if( $account_status != 'approved' ){
                    UM()->form()->add_error( 'practitioner_code', __('The Practitioner\'s Unique Reference Code is not recognized.', 'storefrontchild') );
                } else {
                    if( isset($args['practitioners_name']) && $args['practitioners_name'] != $user->display_name ){
                        UM()->form()->add_error( 'practitioners_name', __('The Practitioner\'s Name does not match the Practitioner\'s Unique Reference Code.', 'storefrontchild') );
                    }
                }
            } else {
                UM()->form()->add_error( 'practitioner_code', __('The Practitioner\'s Unique Reference Code is not recognized.', 'storefrontchild') );
            }
        } else {
            UM()->form()->add_error( 'practitioner_code', __('Please enter the Practitioner\'s Unique Reference Code.', 'storefrontchild') );
        }
    }
}
add_action('um_submit_form_errors_hook_', 'must_exist_practitioner_code', 999, 1);

//BWIPIT-2773
if ( ! function_exists( 'um_email_locate_template' ) ) {
	/**
	 * Locate a template and return the path for inclusion.
	 */
	function um_email_locate_template( $template_name ) {
		$blog_id = is_multisite() ? '/' . get_current_blog_id() : '';

		$template = locate_template(
			array(
				trailingslashit( 'ultimate-member/email' . $blog_id ) . $template_name . '.php',
				trailingslashit( 'ultimate-member/email' ) . $template_name . '.php',
			)
		);

		if ( ! $template ) {
			$template = wp_normalize_path( STYLESHEETPATH . '/ultimate-member/email/' . $template_name . '.php' );
		}

		return apply_filters( 'um_locate_email_template', $template, $template_name );
	}
}

function um_email_notification_approval_custom_emails( $emails ) {
	// approval custom email templates.
	$approval_custom_emails = array(
		'practitioner_approved_email' => array(
			'key'            => 'practitioner_approved_email',
			'title'          => __( 'Practitioner Approval Email', 'um-verified' ),
			'description'    => __( 'Send a notification to Practitioner type user when account is approved', 'um-verified' ),
			'recipient'      => 'user',
			'default_active' => true,
			'subject'        => 'Your Practitioner account is approved on {site_name}',
			'body'           => 'We have reviewed your registration request and found it sufficient. Congratulations your account is now approved.',
		),
        'pensioner_approved_email' => array(
			'key'            => 'pensioner_approved_email',
			'title'          => __( 'Pensioner Approval Email', 'um-verified' ),
			'description'    => __( 'Send a notification to Pensioner type user when account is approved', 'um-verified' ),
			'recipient'      => 'user',
			'default_active' => true,
			'subject'        => 'Your Pensioner account is approved on {site_name}',
			'body'           => 'We have reviewed your registration request and found it sufficient. Congratulations your account is now approved.',
		),
	);

	foreach ( $approval_custom_emails as $slug => $custom_email ) {
		// Default settings.
		if ( ! UM()->options()->get( $slug . '_on' ) ) {
			UM()->options()->update( $slug . '_on', empty( $custom_email['default_active'] ) ? 0 : 1 );
			UM()->options()->update( $slug . '_sub', $custom_email['subject'] );
		}

		// Template file.
		$located = um_email_locate_template( $slug );
		if ( ! file_exists( $located ) ) {
			wp_mkdir_p( dirname( $located ) );
			file_put_contents( $located, $custom_email['body'] );
		}

		$emails[ $slug ] = $custom_email;
	}

	return $emails;
}
add_filter( 'um_email_notifications', 'um_email_notification_approval_custom_emails' );



function add_custom_placeholder_for_custom_approve_email($placeholders) {
    $placeholders[] = '{approval_custom_email_logo}';
    $placeholders[] = '{approval_custom_email_footer_logo}';
    $placeholders[] = '{customer_id}';
    $placeholders[] = '{custom_email_footer_bg_image}';
    $placeholders[] = '{custom_email_footer_fb_image}';
    $placeholders[] = '{custom_email_footer_twitter_image}';
    $placeholders[] = '{custom_email_footer_insta_image}';
    $placeholders[] = '{custom_email_footer_pinterest_image}';
    $placeholders[] = '{approval_custom_email_image_1}';
    $placeholders[] = '{approval_custom_email_image_2}';

    return $placeholders;
}
add_filter( 'um_template_tags_patterns_hook', 'add_custom_placeholder_for_custom_approve_email' );

function add_replace_custom_placeholder_for_custom_approve_email($replace_placeholders){
    $images_asset_url = get_bloginfo('stylesheet_directory') . '/assets/images/';
    
    $replace_placeholders[] = get_option('approval_custom_email_logo');
    $replace_placeholders[] = get_option('approval_custom_email_footer_logo');
    
    $user_id = um_user( 'ID' );
    $replace_placeholders[] = $user_id;
    
    $replace_placeholders[] = $images_asset_url . 'order-footer.png';
    $replace_placeholders[] = $images_asset_url . 'icon-facebook.png';
    $replace_placeholders[] = $images_asset_url . 'icon-twitter.png';
    $replace_placeholders[] = $images_asset_url . 'icon-insta.png';
    $replace_placeholders[] = $images_asset_url . 'icon-pinterest.png';
    
    // practitioner email
    $replace_placeholders[] = get_option('approval_custom_email_image_1');
    $replace_placeholders[] = get_option('approval_custom_email_image_2');

    return $replace_placeholders;
}
add_filter( 'um_template_tags_replaces_hook', 'add_replace_custom_placeholder_for_custom_approve_email' );


function send_custom_approval_email($user_id){
    $user = get_userdata($user_id);
    $user_role = $user->roles[0];
    
    if( in_array($user_role, ['um_practitioner','um_pensioner'])){
        $user_email = $user->user_email;
        $email_template = $user_role == 'um_practitioner' ? 'practitioner_approved_email' : 'pensioner_approved_email';
        
        $current_user_id = get_current_user_id();
        um_fetch_user( $user_id );
        
        UM()->mail()->send( $user_email, $email_template );
        if ($current_user_id) {
            um_fetch_user( $current_user_id );
        } else {
            um_reset_user();
        }
    }
}
add_action('um_after_user_is_approved', 'send_custom_approval_email', 10, 1);

add_action( 'um_before_email_notification_sending', 'um_before_email_rejected_sending', 10, 3 );

function um_before_email_rejected_sending( $email, $template, $args ) {

    if ( $template == 'rejected_email' ) {
        $user = get_user_by( 'email', $email );
        if ( ! empty( $user ) && isset( $user->ID )) {
            um_fetch_user( $user->ID );
        }
    }
    if ( $template == 'pending_email' ) {
        $user = get_user_by( 'email', $email );
        if ( ! empty( $user ) && isset( $user->ID )) {
            um_fetch_user( $user->ID );
        }
    }
}

function um_custom_change_keep_me_signed_in_text( $translated_text, $text, $domain ) {
    if ( 'ultimate-member' === $domain ) {
        switch ( $translated_text ) {
            case 'Keep me signed in':
                $translated_text = 'Remember Me'; // Change this to your custom text
                break;
        }
    }
    return $translated_text;
}
add_filter( 'gettext', 'um_custom_change_keep_me_signed_in_text', 20, 3 );

//Save Practitioner ID to Order Meta
add_action('woocommerce_checkout_create_order', 'save_practitioner_id_to_order_meta',  10,  2);
function save_practitioner_id_to_order_meta($order, $data) {
    $customer_id = $order->get_user_id();
    if ($customer_id !=  0) {
        $practitioner_id = get_user_meta($customer_id, 'practitioner_code', true);
        if ($practitioner_id) {
            $order->update_meta_data('practitioner_id', $practitioner_id);
            $order->update_meta_data('practitioner_paid', 0);
        }
    }
}

function send_practitioner_commission_notification_on_order_complete($order_id) {
    $order = wc_get_order($order_id);
    if (!$order) {
        return;
    }
    if ($order->get_meta('practitioner_id')) {
        $orders = get_posts(array(
            'numberposts' => -1,
            'meta_query'  => array(
                'relation' => 'AND',
                array(
                    'key'     => 'practitioner_id',
                    'value'   => $order->get_meta('practitioner_id'),
                    'compare' => '='
                ),
                array(
                    'key'     => 'practitioner_paid',
                    'value'   => 0,
                    'compare' => '='
                ),
            ),
            'post_type'   => 'shop_order',
            'post_status' => 'wc-completed',
        ));
        $order_total = 0;
        foreach ($orders as $item) {
            $orderData = wc_get_order($item->ID);
            $order_total += $orderData->get_total();
        }
        $commission = get_option('practitioner_commission_rate') ? get_option('practitioner_commission_rate') : 10;
        if(ROUND(($order_total/100)*$commission, 2) >= 50) {
            $email_to = get_option('practitioner_commission_threshold_email_to') ? get_option('practitioner_commission_threshold_email_to') : 'nayem@bwipholdings.com';
            $subject = 'Practitioner Pay Commission Threshold Reached';
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $body = '<html><body><p style="text-align: left; color: #000; font-family: Helvetica, Arial, sans-serif !important;">Hi,</p><p style="text-align: left; color: #000; font-family: Helvetica, Arial, sans-serif !important;">This is to inform you that some practitioner commission payments have reached the payout limit of '.get_woocommerce_currency_symbol().'50.00.</p><p style="text-align: left; color: #000; font-family: Helvetica, Arial, sans-serif !important;">Please review the report and initiate the necessary steps to arrange payment as soon as possible.</p><p style="text-align: left; color: #000; font-family: Helvetica, Arial, sans-serif !important;">Thanks</p></body></html>';
            wp_mail($email_to, $subject, $body, $headers);
        }
    }
}
add_action('woocommerce_order_status_completed', 'send_practitioner_commission_notification_on_order_complete');

//BWIPIT-2790
// Add custom endpoint for Delete Account
function add_delete_account_endpoint() {
    add_rewrite_endpoint( 'delete-account', EP_ROOT | EP_PAGES );
}
add_action( 'init', 'add_delete_account_endpoint' );


function delete_account_query_vars( $vars ) {
    $vars[] = 'delete-account';
    return $vars;
}
add_filter( 'query_vars', 'delete_account_query_vars', 0 );


function delete_account_endpoint_content() {
    wc_get_template( 'myaccount/delete-account.php' );
}
add_action( 'woocommerce_account_delete-account_endpoint', 'delete_account_endpoint_content' );

function delete_account_endpoint_title( $title, $id = null ) {
    global $wp;
    if ( is_account_page() && isset( $wp->query_vars['delete-account'] ) ) {
        $title = 'Delete Account';
    }
    return $title;
}
add_filter( 'storefront_page_title', 'delete_account_endpoint_title', 10, 2 );

// BWIPIT-2733
if ( ! function_exists( 'get_order_by_order_number' ) ) {
    function get_order_by_order_number($order_number) { 
        $args = [
            'limit' => 1,
            'orderby' => 'date',
            'order' => 'DESC',
            'meta_key' => '_order_number',
            'meta_value' => $order_number,
        ];
        $orders = wc_get_orders( $args );

        if ( !empty( $orders ) ) {
            return $orders[0]; // Get the first (and should be only) order from the results
        } else {
            return false;
        }
    }
}

function trackorder_ajaxaction(){
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    if ( wp_verify_nonce( $_POST['trackorder_nonce'], 'trackorder_nonceaction' ) ) {
        $order_number = $_POST['order_number'];
        $order_email = $_POST['order_email'];
        $order = get_order_by_order_number($order_number);
        if($order){
            $order = wc_get_order($order);
            if($order->get_billing_email() == $order_email){
                $order_data = [
                    'order_status' => ucfirst($order->get_status()),
                    'order_date' => $order->get_date_created()->date('j M Y'),
                    'order_number' => $order_number
                ];

                switch($order->get_status()){
                    case 'processing':
                        $order_data['status_mesage'] = [__('Your order and Payment have been received and we are processing your order. Your tracking link will be available shorty.')];
                        break;
                    case 'completed':
                        $order_data['status_mesage'] = [__('Your order has been completed and is now with our delivery team.')];
                        break;
                    case 'pending':
                        $order_data['status_mesage'] = [__('If your order is Pending it is because we are awaiting payment before it will be completed.'),__('If you are still to pay for this order please use the following link to complete your payment - ') . '<a href="https://rositarealfoods.zendesk.com/hc/en-us/sections/360000075235-Bank-Transfer-Details" target="_blank">' . __('Click Here') . '</a>'];
                        break;
                    case 'cancelled':
                        $order_data['status_mesage'] = [__('Your order has been cancelled either due to no payment being received or because the order has been refunded in full.'),__('If you have any questions about why this is cancelled please contact our customer service team - ') . '<a href="https://rositarealfoods.zendesk.com/hc/en-us/categories/115000420953-Contact-Us">' . __('here') . '</a>'];
                        break;
                }

                wp_send_json_success($order_data);
            } else {
                wp_send_json(array('success' => false, 'message' => __('Please enter valid email to track your order.')));
            }
        } else {
            wp_send_json(array('success' => false, 'message' => __('Please enter valid order number to track your order.')));
        }
    } else {
        echo 'Busted';
    }
    wp_die();
}
add_action('wp_ajax_track_order_action', 'trackorder_ajaxaction');
add_action('wp_ajax_nopriv_track_order_action', 'trackorder_ajaxaction');

// this function adds the page slug to the body tag class
// format: page-{slug} e.g. page-trackorder
function add_slug_body_class($classes) {
    global $post;
    $allowed_slugs = explode(",",get_option('slugs_to_body_class'));
    if (isset($post) && is_page() && in_array($post->post_name, $allowed_slugs) ) {
        $classes[] = 'page-' . $post->post_name;
    }
    $store = [1=>'store-uk', 2=>'store-nz', 3=>'store-au', 4=>'store-eu'];
    $classes[] = $store[get_current_blog_id()];
    return $classes;
}
add_filter('body_class', 'add_slug_body_class');

//BWIPIT-2789
// Add custom endpoint for Practitioner Info
function add_practitioner_info_endpoint() {
    add_rewrite_endpoint( 'practitioner', EP_ROOT | EP_PAGES );
}
add_action( 'init', 'add_practitioner_info_endpoint' );


function practitioner_info_query_vars( $vars ) {
    $vars[] = 'practitioner';
    return $vars;
}
add_filter( 'query_vars', 'practitioner_info_query_vars', 0 );


function practitioner_info_endpoint_content() {
    wc_get_template( 'myaccount/practitioner.php' );
}
add_action( 'woocommerce_account_practitioner_endpoint', 'practitioner_info_endpoint_content' );

function practitioner_info_endpoint_title( $title, $id = null ) {
    global $wp;
    if ( is_account_page() && isset( $wp->query_vars['practitioner'] ) ) {
        $title = 'Practitioner Info';
    }
    return $title;
}
add_filter( 'storefront_page_title', 'practitioner_info_endpoint_title', 10, 2 );

// Add custom endpoint for Practitioner Register
function add_practitioner_register_endpoint() {
    add_rewrite_endpoint( 'practitioner-register', EP_ROOT | EP_PAGES );
}
add_action( 'init', 'add_practitioner_register_endpoint' );


function practitioner_register_query_vars( $vars ) {
    $vars[] = 'practitioner-register';
    return $vars;
}
add_filter( 'query_vars', 'practitioner_register_query_vars', 0 );


function practitioner_register_endpoint_content() {
    wc_get_template( 'myaccount/practitioner-register.php' );
}
add_action( 'woocommerce_account_practitioner-register_endpoint', 'practitioner_register_endpoint_content' );

function practitioner_register_endpoint_title( $title, $id = null ) {
    global $wp;
    if ( is_account_page() && isset( $wp->query_vars['practitioner-register'] ) ) {
        $title = 'Practitioner Register';
    }
    return $title;
}
add_filter( 'storefront_page_title', 'practitioner_register_endpoint_title', 10, 2 );

// Add custom endpoint for Practitioner Client Linking
function add_practitioner_clientlink_endpoint() {
    add_rewrite_endpoint( 'practitioner-clientlink', EP_ROOT | EP_PAGES );
}
add_action( 'init', 'add_practitioner_clientlink_endpoint' );


function practitioner_clientlink_query_vars( $vars ) {
    $vars[] = 'practitioner-clientlink';
    return $vars;
}
add_filter( 'query_vars', 'practitioner_clientlink_query_vars', 0 );


function practitioner_clientlink_endpoint_content() {
    wc_get_template( 'myaccount/practitioner-clientlink.php' );
}
add_action( 'woocommerce_account_practitioner-clientlink_endpoint', 'practitioner_clientlink_endpoint_content' );

function practitioner_clientlink_endpoint_title( $title, $id = null ) {
    global $wp;
    if ( is_account_page() && isset( $wp->query_vars['practitioner-clientlink'] ) ) {
        $title = 'Practitioner Client Linking';
    }
    return $title;
}
add_filter( 'storefront_page_title', 'practitioner_clientlink_endpoint_title', 10, 2 );

function allowed_practitioner_meta(){
    return ['practitioner_company','key_position','taxvat','website_url','telephone','billing_address_1','billing_address_2','billing_city','billing_postcode','billing_country','billing_state','practitioner_type','practitioner_type_other','practitioner_qualification','practitioner_qual_other','practitioner_certificate','practitioner_associations','practitioner_description','practitioner_how_long','practitioner_how_many','practitioner_annual','practitioner_num_clients','payment_details','account_name','sort_code','bank_account','paypal_account'];
}

function practitionerregistration_ajaxaction(){
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $allowed_practitioner_meta = allowed_practitioner_meta();
    if ( wp_verify_nonce( $_POST['practitionerregistration_nonce'], 'practitionerregistration_nonceaction' ) ) {
        UM()->user()->set();
        $user_id = UM()->user()->id;
        if ( $user_id ){
            foreach($allowed_practitioner_meta as $meta){
                if(isset($_FILES[$meta])){
                    $file = $_FILES[$meta];
                    $upload_dir = wp_upload_dir();
                    $um_uploads_url = $upload_dir['basedir'] . '/ultimatemember/' . $user_id . '/';
                    if (!file_exists($um_uploads_url)) {
                        mkdir($um_uploads_url, 0777, true);
                    }
                    $file_name = $file['name'];
                    $file_name = preg_replace('/\s+/', '_', $file_name);
                    $file_path = $um_uploads_url . $file_name;
                    move_uploaded_file($file['tmp_name'], $file_path);
                    delete_user_meta($user_id, $meta);
                    update_user_meta($user_id, $meta, $file_name);
                } else if(isset($_POST[$meta])){
                    delete_user_meta($user_id, $meta);
                    update_user_meta($user_id, $meta, $_POST[$meta]);
                }
            }
            
            if(!isset($_POST['account_status'])){
                delete_user_meta($user_id, 'account_status');
                update_user_meta($user_id, 'account_status', 'awaiting_admin_review');
            }
            UM()->roles()->set_role( $user_id, 'um_practitioner' );

            wp_send_json(array('success' => true, 'message' => __('Thank you for registering as a Practitioner. We will review your application and will send an email for the feedback.')));
        } else {
            wp_send_json(array('success' => false, 'message' => __('Error processing your request. You should be logged in.')));
        }
    } else {
        echo 'Busted';
    }
    wp_die();
}
add_action('wp_ajax_practitionerregistration_action', 'practitionerregistration_ajaxaction');
add_action('wp_ajax_nopriv_practitionerregistration_action', 'practitionerregistration_ajaxaction');

function practitionerclientregistration_ajaxaction(){
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    if ( wp_verify_nonce( $_POST['practitionerclientregistration_nonce'], 'practitionerclientregistration_nonceaction' ) ) {
        $practitioner_id = $_POST['practitioner_code'];
        $user_id = UM()->user()->id;
        if( $user_id && $practitioner_id ) {
            $practitioner = get_userdata($practitioner_id);
            $practitioner_role = $practitioner->roles[0];
            if( $practitioner && $practitioner_role == 'um_practitioner') {
                $account_status = get_user_meta($practitioner_id, 'account_status', true);
                if( $account_status != 'approved' ){
                    wp_send_json(array('success' => false, 'message' => __('The Practitioner\'s Unique Reference Code is not recognized.', 'storefrontchild')));
                } else {
                    if( isset($_POST['practitioners_name']) && $_POST['practitioners_name'] != $practitioner->display_name ){
                        wp_send_json(array('success' => false, 'message' => __('The Practitioner\'s Name does not match the Practitioner\'s Unique Reference Code.', 'storefrontchild')));
                    } else { // process the application 
                        UM()->user()->set();
                        delete_user_meta($user_id, 'practitioner_code');
                        update_user_meta($user_id, 'practitioner_code', $_POST['practitioner_code']);

                        delete_user_meta($user_id, 'practitioners_name');
                        update_user_meta($user_id, 'practitioners_name', $_POST['practitioners_name']);

                        delete_user_meta($user_id, 'account_status');
                        update_user_meta($user_id, 'account_status', 'approved');
                        UM()->roles()->set_role( $user_id, 'um_practitioner-client' );

                        wp_send_json(array('success' => true, 'message' => __('Thank you for registering as a Practitioner Client.', 'storefrontchild')));
                    }
                }
            } else {
                wp_send_json(array('success' => false, 'message' => __('The Practitioner\'s Unique Reference Code is not recognized.', 'storefrontchild')));
            }
        } else {
            wp_send_json(array('success' => false, 'message' => __('Please enter the Practitioner\'s Unique Reference Code.', 'storefrontchild')));
        }
    } else {
        echo 'Busted';
    }
    wp_die();
}
add_action('wp_ajax_practitionerclientregistration_action', 'practitionerclientregistration_ajaxaction');
add_action('wp_ajax_nopriv_practitionerclientregistration_action', 'practitionerclientregistration_ajaxaction');

function my_orders_pagination_query( $args ) {
    if (isset($_GET['limit']) && is_numeric($_GET['limit'])) {
        $args['posts_per_page'] = $_GET['limit'];
    } else {
        $args['posts_per_page'] = 10;
    }
    return $args;
}
add_filter( 'woocommerce_my_account_my_orders_query', 'my_orders_pagination_query' );

// BWIPIT-2770-Sign-Up-Page-Email-Exist-Validation
function check_email_exist_on_signup($args, $form_data){
    $user_email = isset($args['user_email']) ? trim($args['user_email']) : '';
    if( $user_email ) {
        $email_exists = email_exists( $user_email );
        if( $email_exists && $form_data['mode'] == 'register' ) {
            UM()->form()->errors['user_email'] = __('This email address is already registered.', 'storefrontchild');
        }
    }
}
add_action( 'um_submit_form_errors_hook_', 'check_email_exist_on_signup', 99, 2 );

// Save customer meta data on account update
add_action( 'woocommerce_save_account_details', 'save_custom_account_field' );
function save_custom_account_field( $user_id ) {
    if ( isset( $_POST['dob'] ) ) {
        update_user_meta( $user_id, 'dob', $_POST['dob'] );
    }
    if ( isset( $_POST['Prefix'] ) ) {
        update_user_meta( $user_id, 'Prefix', $_POST['Prefix'] );
    }
}

// Change search result page title
function change_woocommerce_page_title($title) {
    if ( is_search() ) {
        $page_title = sprintf( __( 'Search results for: &ldquo;%s&rdquo;', 'storefrontchild' ), get_search_query() );
        if ( get_query_var( 'paged' ) ) {
            $page_title .= sprintf( __( '&nbsp;&ndash; Page %s', 'storefrontchild' ), get_query_var( 'paged' ) );
        }
    }
    return $page_title;
}
add_filter('woocommerce_page_title', 'change_woocommerce_page_title');

// BWIPIT-2733
// this function adds transparent-footer to body class
function add_transparent_footer_class_to_body($classes) {
    global $post;
    $allowed_slugs = explode(",",get_option('transparent_footer_pageslugs_body_class'));
    if ( in_array($post->post_name, $allowed_slugs) ) {
        $classes[] = 'transparent-footer';
    }
    return $classes;
}
add_filter('body_class', 'add_transparent_footer_class_to_body');

// Remove review section from tab
add_filter( 'woocommerce_product_tabs', 'remove_reviews_tab', 98 );
function remove_reviews_tab($tabs) {
    unset($tabs['reviews']);
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'remove_ques_tab' );
function remove_ques_tab($tabs) {
    unset($tabs['question_tab']);
    return $tabs;
}

// Add review section to product page
add_action( 'woocommerce_after_single_product_summary', 'your_theme_review_replacing_reviews_position');
function your_theme_review_replacing_reviews_position() {
    comments_template();
}

function move_woocommerce_success_message() {
    ?>
    <script>
    jQuery(document).ready(function($) {
        var $successMessage = jQuery('.wc-block-components-notice-banner.is-success');
        var $targetLocation = jQuery('.entry-header');

        if ($successMessage.length && $targetLocation.length) {
            $successMessage.insertAfter($targetLocation);
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'move_woocommerce_success_message');

add_action( 'woocommerce_update_cart_action_cart_updated', function( $cart_updated ) {
    if ( $cart_updated ) {
        wc_clear_notices();
        wc_add_notice( 'Shopping cart updated' );
    }
}, 10, 1 );
function move_woocommerce_error_message() {
    ?>
    <script>
    jQuery(document).ready(function($) {
        var $successMessage = jQuery('.wc-block-components-notice-banner.is-error');
        var $targetLocation = jQuery('.entry-header');

        if ($successMessage.length && $targetLocation.length) {
            $successMessage.insertAfter($targetLocation);
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'move_woocommerce_error_message');

// -BWIPIT-2839-email-templates-1

require get_stylesheet_directory() . '/email_templates_functions.php';

add_filter( 'um_template_tags_patterns_hook', 'add_custom_placeholder_for_email_assets', 10, 1 );
add_filter( 'um_template_tags_replaces_hook', 'replace_custom_placeholder_for_email_assets', 10, 1 );

add_filter('um_template_tags_patterns_hook', 'my_custom_email_header_placeholder', 10, 1);
add_filter('um_template_tags_replaces_hook', 'my_custom_email_header_replace', 10, 1);


add_filter('um_template_tags_patterns_hook', 'my_custom_email_footer_placeholder', 10, 1);
add_filter('um_template_tags_replaces_hook', 'my_custom_email_footer_replace', 10, 1);

add_filter('um_template_tags_patterns_hook', 'pw_reset_header', 10, 1);
add_filter('um_template_tags_replaces_hook', 'pw_reset_header_replace', 10, 1);


add_filter('um_template_tags_patterns_hook', 'custom_display_site_name_placeholder', 10, 1);
add_filter('um_template_tags_replaces_hook', 'get_site_blog_name_replace', 10, 1);

add_filter( 'woocommerce_billing_fields', 'custom_reorder_billing_fields', 10, 1 );
function custom_reorder_billing_fields( $fields ) {
    if ( isset( $fields['billing_country'] )) {
        $fields['billing_phone']['priority'] = 30;
    }

    return $fields;
}
add_filter('woocommerce_default_address_fields', 'custom_address_fields_priority', 10, 1);
function custom_address_fields_priority($fields) {
    $fields['phone']['priority'] = 30;
    $fields['phone']['required'] = true;
    $fields['country']['priority'] = 70;
    $fields['city']['priority'] = 80;
    return $fields;
}

add_filter('um_template_tags_patterns_hook', 'user_role_placeholder', 10, 1);
add_filter('um_template_tags_replaces_hook', 'replace_user_role_placeholder', 10, 1);



function custom_reviews_shortcode() {
    ob_start();
    comments_template('/woocommerce/single-product-reviews.php');
    return ob_get_clean();
}
add_shortcode('custom_reviews', 'custom_reviews_shortcode');

//Redirect to login page if user is not logged in
add_action('template_redirect', 'redirect_to_login');
function redirect_to_login() {
    if (!is_user_logged_in() && is_page('my-account')) {
        wp_redirect(home_url('/login'));
        exit();
    }
}

function key_nutritional_facts_shortcode() {
    ob_start();
    include(get_stylesheet_directory() . '/single-product-key-nutritional-facts.php');
    return ob_get_clean();
}
add_shortcode('key_nutritional_facts', 'key_nutritional_facts_shortcode');

function testing_section__shortcode() {
    ob_start();
    include(get_stylesheet_directory() . '/single-product-testing-section.php');
    return ob_get_clean();
}
add_shortcode('testing_section', 'testing_section__shortcode');

function product_description__shortcode() {
    ob_start();
    include(get_stylesheet_directory() . '/single-product-description.php');
    return ob_get_clean();
}
add_shortcode('product_description', 'product_description__shortcode');

function product_more_info__shortcode() {
    ob_start();
    include(get_stylesheet_directory() . '/single-product-more-product-info-tabs.php');
    return ob_get_clean();
}
add_shortcode('product_more_info', 'product_more_info__shortcode');

function product_quantity__shortcode() {
    ob_start();
    include(get_stylesheet_directory() . '/single-product-quantity.php');
    return ob_get_clean();
}
add_shortcode('single_product_quantity', 'product_quantity__shortcode');


add_filter('um_email_send_notification', 'my_custom_email_filter', 10, 2);

function my_custom_email_filter($send, $args) {
    // Check if the email key is 'account_approved_email'
    if ($args['key'] == 'account_approved_email') {
        $user_id = $args['user_id'];
        $user = get_userdata($user_id);
        $user_roles = $user->roles;

        // Check if the user role is 'um_test'
        if (in_array('um_test', $user_roles)) {
            // Prevent the email from being sent
            return false;
        }
    }

    // Allow the email to be sent
    return $send;
}

// -BWIPIT-2853-forgot-password-page
// -Password Reset validation using Email Address only
 add_action( 'um_reset_password_errors_hook', "um_021522_reset_password_error" );

 function um_021522_reset_password_error( $args ){

    foreach ( $args as $key => $val ) {
        if ( strstr( $key, 'username_b' ) ) {
            $user = trim( sanitize_text_field( $val ) );
        }
    }

    if ( username_exists( $user ) ) {
        UM()->form()->add_error( 'username_b', __( 'Please provide your email address', 'ultimate-member' ) );
    }

    if (isset($user)) {
        $username_b = $user;

        // Add your custom validation here
        if (!filter_var($username_b, FILTER_VALIDATE_EMAIL)) {
            UM()->form()->add_error('username_b', 'Please enter a valid email address');
        }

    }
 }
// -Update the validation message for the reset password page
add_filter("gettext_ultimate-member","um_021522_change_reset_password_labels", 10, 3);

function um_021522_change_reset_password_labels( $translation, $text, $domain ){
 
    if( "To reset your password, please enter your email address or username below." == $text ){
        $translation = "To reset your password, please enter your email address below.";
    }else if( "Enter your username or email" == $text ){
        $translation = "Enter your email address";
    }else if( "Please provide your username or email" == $text ){
        $translation = "Please provide your email address";
    }

    return $translation;
}

//Override the email authentication error message
add_filter('authenticate', 'override_email_authentication_error_message', 20, 3);

function override_email_authentication_error_message($user, $username, $password) {
    if (is_wp_error($user)) {
        $error_codes = $user->get_error_codes();
        if (in_array('invalid_email', $error_codes)) {
            $user = new WP_Error('invalid_email', 'Invalid email address. Please try again.');
        }
    }
    return $user;
}

//Add recaptcha to comment form for non-logged in users
add_action('comment_form_after_fields', 'add_recaptcha_to_comment_form');
function add_recaptcha_to_comment_form() {
    echo '<div class="google-captcha not-loogedin">
        <div class="g-recaptcha" data-sitekey="'.UM()->options()->get( 'g_recaptcha_sitekey' ).'"></div>
        <div class="captcha-error"></div>
    </div>';
}

//add_action('woocommerce_before_checkout_form', 'custom_adjust_cart_before_checkout');
add_action('template_redirect', 'custom_adjust_cart_before_checkout');

function custom_adjust_cart_before_checkout() {
    $sku_to_add = 'ROSITACHILLED';
    $product_to_add_id = wc_get_product_id_by_sku($sku_to_add);
    if (!$product_to_add_id) {
        return;
    }

    $chilled_sku = array();
    $attribute_slug = 'pa_chilled_packaging';
    $args = array('limit' => -1, 'status' => 'publish');
    $products = wc_get_products($args);
    foreach ($products as $product) {
        $terms = wp_get_post_terms($product->get_id(), $attribute_slug, array('fields' => 'names'));
        if (!is_wp_error($terms) && in_array('Yes', $terms)) {
            $chilled_sku[] = $product->get_sku();
        }
    }
    $hasChilled = false;
    $chilledQty = 0;
    $itemId = null;
    
    foreach (WC()->cart->get_cart() as $item_key => $item) {
        if ($item['data']->get_sku() == $sku_to_add) {
            $hasChilled = true;
            $itemId = $item_key;
            continue;
        }
        

        if ($item['data']->get_sku() == 'Bundle_RRF_EVCLOLx3-857605004007') {
            $chilledQty += round(($item['quantity'] * 3) / 2);
        } else if (in_array($item['data']->get_sku(), $chilled_sku) && $item['data']->get_sku() != 'Bundle_RRF_EVCLOLx3-857605004007') {
            $chilledQty += round($item['quantity'] / 2);
        }
    }
    if ($chilledQty == 0) {
        if ($itemId != 0) {
            WC()->cart->remove_cart_item($itemId);
        }
    } else {
        if ($hasChilled) {
    
            WC()->cart->set_quantity($itemId, $chilledQty);
            WC()->cart->calculate_totals();
        } else {
            WC()->cart->add_to_cart($product_to_add_id, $chilledQty);
        }
    }
}

function custom_cart_item_quantity_field($product_quantity, $cart_item_key, $cart_item) {
    if ($cart_item['data']->get_sku() == 'ROSITACHILLED') {
        $product_quantity = str_replace('input-text qty text', 'input-text qty text disabled-quantity', $product_quantity);
    }
    return $product_quantity;
}
add_filter('woocommerce_cart_item_quantity', 'custom_cart_item_quantity_field', 10, 3);

function custom_cart_css() {
    if (is_cart()) {
        ?>
        <style>
            .disabled-quantity {
                pointer-events: none;
                background-color: #eee;
                opacity: 0.5;
            }
        </style>
        <?php
    }
}
add_action('wp_head', 'custom_cart_css');


function storefrontchild_load_textdomain() {
    load_child_theme_textdomain( 'storefrontchild', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'storefrontchild_load_textdomain' );

function custom_prevent_checkout_for_specific_sku() {
    if ( ! WC()->cart->is_empty() ) {
        $only_rositachilled = true;
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            if ( $cart_item['data']->get_sku() !== 'ROSITACHILLED' ) {
                $only_rositachilled = false;
                break;
            }
        }
        if ($only_rositachilled) {
            wc_add_notice( __( 'You can not order only Rosita Thermal Packaging". Please add another product to proceed with checkout.', 'storefrontchild' ), 'error' );
            remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
        }
    }
}
add_action( 'woocommerce_check_cart_items', 'custom_prevent_checkout_for_specific_sku' );

// Quick Orders Shortcode
add_shortcode( 'quickorders', 'display_quickorders' );
function display_quickorders($atts){
	$nos  = array_map('intval', explode(",",$atts["ids"]));
	$args = array(
		'post_type' => 'product',
        'orderby'  => 'post__in',
		'post__in'  => $nos,
		'post_status' => 'publish'
	);

	$string = '';
	$query = new WP_Query( $args );
	if( $query->have_posts() ){
		$string .= '<ul class="quickproducts products columns-4">';
		while( $query->have_posts() ){
			$query->the_post();
			$product = wc_get_product($query->post->ID);
            $setimage = get_the_post_thumbnail();
            $currency_symbol = get_woocommerce_currency_symbol();
            $stk = ($product->is_in_stock()) ? "" : "nostock";
            $buynow = ($product->is_in_stock()) ? '<button type="submit" id="product-addtocart-button" class="button alt">
             <span class="button-text-wrapper"> <span>Buy Now</span>
              <span class="woocommerce-Price-amount amount">
              <bdi>
              <span class="woocommerce-Price-currencySymbol">'. $currency_symbol .'</span>'. number_format($product->get_price(), 2) .'
              </bdi>
              </span>
              </span></button>' : '<a href="' . get_post_permalink() .'" class="cwgnostock "><span>Notify me when in stock</span></a>';
			
			$string .= '<li class="product type-product has-post-thumbnail quicks product-'. $product->id .'">';
			$string .= '<div class="contwrap"><a href="' . get_post_permalink() .'" class="image">' . $setimage .'</a><div class="qtitle"><h4 class="main_text_color">'.get_the_title().'</h4>';
			$string .= '</div>';
			$string .= '<form action="' . esc_url( $product->add_to_cart_url() ) . '" class="cart" method="post" enctype="multipart/form-data">';
			$string .= '<div class="wqty '.$stk.'"><span class="qlabel">Quantity</span>';
			$string .= '<input class="minus" type="button" value="-">';
			$string .= woocommerce_quantity_input( array(), $product, false );
			$string .= '<input class="plus" type="button" value="+"></div>';
			$string .= $buynow;
			$string .= '</form>';
			$string .= '<div class="product-info-instock"><a class="more-product-info" href="' . get_post_permalink() .'">More product info</a> ';
			$string .= '<div class="product-info-stock-sku">';
			$string .= ($product->is_in_stock()) ? "<div class='stock available' title='Availability'><span>In stock</span>" : "<div class='stock unavailable' title='Availability'><span>Out of stock</span>";
            $string .= '</div></div></div>';
			$string .= do_shortcode( '[xyz-ips snippet="tier-price"]' );
			$string .= '</li>';
		}
		$string .= '</ul>';
	}
	wp_reset_postdata();
	return $string;
}

//Make same net price for all country
if(get_current_blog_id()==4) {
    add_filter( 'woocommerce_adjust_non_base_location_prices', '__return_false' );
}

function modify_cfw_totals_html_to_include_vat( $totals_html ) {
    if ( wc_tax_enabled() && WC()->cart->display_prices_including_tax() ) {
        $site_id = get_current_blog_id();
        if($site_id == 1 || $site_id == 4){
            $includes_vat_row = '<tr class="includes-vat"><th>' . esc_html__( 'Includes VAT of', 'woocommerce' ) . '</th><td>' . WC()->cart->get_cart_tax() . '</td></tr>';
        }else{
            $includes_vat_row = '<tr class="includes-vat"><th>' . esc_html__( 'Includes GST of', 'woocommerce' ) . '</th><td>' . WC()->cart->get_cart_tax() . '</td></tr>';
        }
        $shipping_pos = strrpos( $totals_html, '<tr class="woocommerce-shipping-totals' );

        if ( $shipping_pos !== false ) {
            $end_of_row_pos = strpos( $totals_html, '</tr>', $shipping_pos );
            if ( $end_of_row_pos !== false ) {
                $totals_html = substr_replace( $totals_html, $includes_vat_row, $end_of_row_pos + 5, 0 ); // +5 to move past the </tr> tag.
            }
        }
    }

    return $totals_html;
}
add_filter( 'cfw_totals_html', 'modify_cfw_totals_html_to_include_vat', 10, 1 );
function get_tier_pricing($product_id){
    if (class_exists('Front_Addify_Wholesale_Prices')) {
        $tier_pricing = new Front_Addify_Wholesale_Prices();
        $product = wc_get_product($product_id);
        $user               = wp_get_current_user();
        $role               = ( array ) $user->roles;
        $current_role       = current( $user->roles );
        $customer_discount  = false;
        $role_discount      = false;
        $customer_discount1 = false;
        $table_data         = '';
        if ( ! empty( $tier_pricing->wsp_enable_hide_price_feature ) && 'yes' == $tier_pricing->wsp_enable_hide_price_feature && 'yes' == $tier_pricing->wsp_enable_hide_price ) {
            if ( ! empty( $tier_pricing->wsp_enable_for_guest ) && 'yes' == $tier_pricing->wsp_enable_for_guest ) {
                if ( ! is_user_logged_in() ) {
                    if ( ! empty( $tier_pricing->wsp_hide_products ) ) {
                        if ( in_array( $product->get_id(), (array) $tier_pricing->wsp_hide_products ) ) {
                            if ( ! empty( $tier_pricing->wsp_enable_hide_price ) && 'yes' == $tier_pricing->wsp_enable_hide_price ) {
                                return;
                            }
                            
                        }
                    }

                    if ( ! empty( $tier_pricing->wsp_hide_categories ) && ! empty( $tier_pricing->wsp_enable_hide_price ) && 'yes' == $tier_pricing->wsp_enable_hide_price ) {
                        foreach ( $tier_pricing->wsp_hide_categories as $cat ) {
                            if ( has_term( $cat, 'product_cat', $product->get_id() ) ) {
                            
                                return;
                            }
                        }
                    }
                }
            }
            // For Registered Users
            if ( ! empty( $tier_pricing->wsp_enable_hide_pirce_registered ) && 'yes' == $tier_pricing->wsp_enable_hide_pirce_registered ) {
                if ( is_user_logged_in() ) {

                    // get Current User Role
                    $curr_user      = wp_get_current_user();
                    $user_data      = get_user_meta( $curr_user->ID );
                    $curr_user_role = $curr_user->roles[0];

                    if ( !empty($tier_pricing->wsp_hide_user_role) && in_array( $curr_user_role, $tier_pricing->wsp_hide_user_role ) ) {

                        if ( in_array( $product->get_id(), (array) $tier_pricing->wsp_hide_products ) ) {

                            if ( ! empty( $tier_pricing->wsp_enable_hide_price ) && 'yes' == $tier_pricing->wsp_enable_hide_price ) {

                                return;
                            }
                        } 
                        if ( ! empty( $tier_pricing->wsp_hide_categories ) && ! empty( $tier_pricing->wsp_enable_hide_price ) && 'yes' == $tier_pricing->wsp_enable_hide_price ) {

                            foreach ( $tier_pricing->wsp_hide_categories as $cat ) {
                                if ( has_term( $cat, 'product_cat', $product->get_id() ) ) {
                                    return;
                                }
                            }
                        }
                    }
                }
            }
        } //End Hide Price
        //Products other than variable product
        // get customer specifc price
        $cus_base_wsp_price = get_post_meta( $product->get_id(), '_cus_base_wsp_price', true );
        // get role base price
        $role_base_wsp_price = get_post_meta( $product->get_id(), '_role_base_wsp_price', true );
        if ('yes' == $tier_pricing->addify_wsp_enable_table_border) {
            $tier_pricing->af_wsp_table_border($tier_pricing->addify_wsp_table_border_color);
        }
        if (!empty($tier_pricing->addify_wsp_table_odd_rows_color)) {
            $tier_pricing->af_wsp_odd_row_color($tier_pricing->addify_wsp_table_odd_rows_color);
        }
        if (!empty($tier_pricing->addify_wsp_table_even_rows_color)) {
            $tier_pricing->af_wsp_even_row_color($tier_pricing->addify_wsp_table_even_rows_color);
        }
        if (!empty($tier_pricing->addify_wsp_table_rows_font_size)) {
            $tier_pricing->af_wsp_table_row_font_size($tier_pricing->addify_wsp_table_rows_font_size);
        }
        if ( 'variable' != $product->get_type() ) {
            if ( is_user_logged_in() ) {
                if ( isset( $tier_pricing->addify_wsp_discount_price[ $current_role ] ) ) {

                    if ($tier_pricing->addify_wsp_discount_price[ $current_role ] && 'sale' == $tier_pricing->addify_wsp_discount_price[ $current_role ] && !empty(get_post_meta( $product->get_id(), '_sale_price', true ))) {

                        $pro_price = get_post_meta( $product->get_id(), '_sale_price', true );

                    } elseif ('regular' == $tier_pricing->addify_wsp_discount_price[ $current_role ] && !empty(get_post_meta( $product->get_id(), '_regular_price', true ))) {

                        $pro_price = get_post_meta( $product->get_id(), '_regular_price', true );

                    }

                } else {

                    $pro_price = get_post_meta( $product->get_id(), '_price', true );
                }
                if ( ! empty( $cus_base_wsp_price )  ) {
                   foreach ( $cus_base_wsp_price as $cus_price ) {
                        if ( isset( $cus_price['customer_name'] ) && $user->ID == $cus_price['customer_name'] ) {
                            if ( '' != $cus_price['discount_value'] || 0 != $cus_price['discount_value'] ) {                                           
                                //Fixed Price
                                if ( 'fixed_price' == $cus_price['discount_type'] ) {
                                    $newprice = wc_get_price_to_display( $product, array(
                                        'qty'   => 1,
                                        'price' => $cus_price['discount_value'],
                                    ) );
                                                
                                    $table_data .= '<div class="item"> Buy' . $cus_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $cus_price['discount_value'].'</span>%</strong> </div>';

                                    $customer_discount = true;

                                                
                                } elseif ( 'fixed_increase' == $cus_price['discount_type'] ) {

                                    $newprice = $pro_price + $cus_price['discount_value'];

                                    $newprice1 = wc_get_price_to_display( $product, array(
                                        'qty'   => 1,
                                        'price' => $newprice,
                                    ) );

                                    $table_data .= '<div class="item"> Buy' . $cus_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $cus_price['discount_value'].'</span>%</strong> </div>';

                                    $customer_discount = true;
                                } elseif ( 'fixed_decrease' == $cus_price['discount_type'] ) {

                                    $newprice = $pro_price - $cus_price['discount_value'];

                                    $newprice1 = wc_get_price_to_display( $product, array(
                                        'qty'   => 1,
                                        'price' => $newprice,
                                    ) );

                                    $table_data .= '<div class="item"> Buy' . $cus_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $cus_price['discount_value'].'</span>%</strong> </div>';

                                    $customer_discount = true;
                                } elseif ( 'percentage_decrease' == $cus_price['discount_type'] ) {

                                    $percent_price = $pro_price * $cus_price['discount_value'] / 100;

                                    $newprice = $pro_price - $percent_price;

                                    $newprice1 = wc_get_price_to_display( $product, array(
                                        'qty'   => 1,
                                        'price' => $newprice,
                                    ) );

                                    $table_data .= '<div class="item"> Buy ' . $cus_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent"> '. $cus_price['discount_value'].'</span>%</strong> </div>';

                                    $customer_discount = true;

                                } elseif ( 'percentage_increase' == $cus_price['discount_type'] ) {

                                    $percent_price = $pro_price * $cus_price['discount_value'] / 100;

                                    $newprice = $pro_price + $percent_price;

                                    $newprice1 = wc_get_price_to_display( $product, array(
                                        'qty'   => 1,
                                        'price' => $newprice,
                                    ) );

                                    $table_data .= '<div class="item"> Buy' . $cus_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $cus_price['discount_value'].'</span>%</strong> </div>';

                                    $customer_discount = true;
                                }
                                            


                            }
                        }
                    }
                } //End Customer Base
                //User Role Base Pricing
                //chcek if there is customer base pricing then User role base pricing will not work.

                if ( ! $customer_discount ) {
                    if ( ! empty( $role_base_wsp_price )  ) {
                        foreach ( $role_base_wsp_price as $role_price ) {
                            if ( isset( $role_price['user_role'] ) && ( 'everyone' == $role_price['user_role'] || $role[0] == $role_price['user_role'] )) {
                                if ( '' != $role_price['discount_value'] || 0 != $role_price['discount_value'] ) {
                                    //Fixed Price
                                    if ( 'fixed_price' == $role_price['discount_type'] ) {

                                        $newprice = wc_get_price_to_display( $product, array(
                                            'qty'   => 1,
                                            'price' => $role_price['discount_value'],
                                        ) );
                                                    
                                        $table_data .= '<div class="item"> Buy' . $role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $role_price['discount_value'].'</span>%</strong> </div>';

                                        $role_discount = true;

                                                    
                                    } elseif ( 'fixed_increase' == $role_price['discount_type'] ) {

                                        $newprice = $pro_price + $role_price['discount_value'];

                                        $newprice1 = wc_get_price_to_display( $product, array(
                                            'qty'   => 1,
                                            'price' => $newprice,
                                        ) );

                                        $table_data .= '<div class="item"> Buy' . $role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $role_price['discount_value'].'</span>%</strong> </div>';

                                        $role_discount = true;

                                                    


                                    } elseif ( 'fixed_decrease' == $role_price['discount_type'] ) {

                                        $newprice = $pro_price - $role_price['discount_value'];

                                        $newprice1 = wc_get_price_to_display( $product, array(
                                            'qty'   => 1,
                                            'price' => $newprice,
                                        ) );

                                        $table_data .= '<div class="item"> Buy' . $role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $role_price['discount_value'].'</span>%</strong> </div>';

                                        $role_discount = true;
 
                                    } elseif ( 'percentage_decrease' == $role_price['discount_type'] ) {

                                        $percent_price = $pro_price * $role_price['discount_value'] / 100;

                                        $newprice = $pro_price - $percent_price;

                                        $newprice1 = wc_get_price_to_display( $product, array(
                                            'qty'   => 1,
                                            'price' => $newprice,
                                        ) );

                                        $table_data .= '<div class="item"> Buy ' . $role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent"> '. $role_price['discount_value'].'</span>%</strong> </div>';

                                        $role_discount = true;

                                                    



                                    } elseif ( 'percentage_increase' == $role_price['discount_type'] ) {

                                        $percent_price = $pro_price * $role_price['discount_value'] / 100;

                                        $newprice = $pro_price + $percent_price;

                                        $newprice1 = wc_get_price_to_display( $product, array(
                                            'qty'   => 1,
                                            'price' => $newprice,
                                        ) );

                                        $table_data .= '<div class="item"> Buy' . $role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $role_price['discount_value'].'</span>%</strong> </div>';

                                        $role_discount = true;
                                    }


                                }
                            }

                        }

                    }
                }
                //End Product Level Pricing

                //Start Global Rules
                if ( false == $customer_discount && false == $role_discount ) {

                    if ( empty( $tier_pricing->allfetchedrules ) ) {

                        echo '';

                    } else {

                        $all_rules = $tier_pricing->allfetchedrules;

                    }

                    if ( ! empty( $all_rules ) ) {

                        foreach ( $all_rules as $rule ) {

                            $istrue = false;
                            

                            $applied_on_all_products = get_post_meta($rule->ID, 'wsp_apply_on_all_products', true);
                            $products                = get_post_meta($rule->ID, 'wsp_applied_on_products', true);
                            $categories              = get_post_meta($rule->ID, 'wsp_applied_on_categories', true);

                            if ('yes' == $applied_on_all_products ) {
                                $istrue = true;
                            } elseif (! empty($products) && ( in_array($product->get_id(), $products) || in_array($product->get_parent_id(), $products) ) ) {
                                $istrue = true;
                            }
                                        
                            if (!empty($categories)) {
                                foreach ( $categories as $cat ) {

                                    if ( !empty( $cat) && ( has_term( $cat, 'product_cat', $product->get_id() ) ) || ( has_term( $cat, 'product_cat', $product->get_parent_id() ) ) ) {

                                        $istrue = true;
                                    } 
                                }
                            }
                            if ( $istrue ) {

                                // get rule customer base price
                                $rule_cus_base_wsp_price = get_post_meta( $rule->ID, 'rcus_base_wsp_price', true );

                                // get rule role base price
                                $rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

                                if ( ! empty( $rule_cus_base_wsp_price )  ) {
                                    foreach ( $rule_cus_base_wsp_price as $rule_cus_price ) {

                                        if ( $user->ID == $rule_cus_price['customer_name'] ) {

                                            if ( '' != $rule_cus_price['discount_value'] || 0 != $rule_cus_price['discount_value'] ) {


                                                //Fixed Price
                                                if ( 'fixed_price' == $rule_cus_price['discount_type'] ) {

                                                    $newprice = wc_get_price_to_display( $product, array(
                                                        'qty'   => 1,
                                                        'price' => $rule_cus_price['discount_value'],
                                                    ) );
                                                                
                                                    $table_data .= '<div class="item"> Buy' . $rule_cus_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $rule_cus_price['discount_value'].'</span>%</strong> </div>';

                                                    $customer_discount1 = true;

                                                                
                                                } elseif ( 'fixed_increase' == $rule_cus_price['discount_type'] ) {

                                                    $newprice = $pro_price + $rule_cus_price['discount_value'];

                                                    $newprice1 = wc_get_price_to_display( $product, array(
                                                        'qty'   => 1,
                                                        'price' => $newprice,
                                                    ) );

                                                    $table_data .= '<div class="item"> Buy' . $rule_cus_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $rule_cus_price['discount_value'].'</span>%</strong> </div>';

                                                    $customer_discount1 = true;

                                                                


                                                } elseif ( 'fixed_decrease' == $rule_cus_price['discount_type'] ) {

                                                    $newprice = $pro_price - $rule_cus_price['discount_value'];

                                                    $newprice1 = wc_get_price_to_display( $product, array(
                                                        'qty'   => 1,
                                                        'price' => $newprice,
                                                    ) );

                                                    $table_data .= '<div class="item"> Buy' . $rule_cus_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $rule_cus_price['discount_value'].'</span>%</strong> </div>';

                                                    $customer_discount1 = true;

                                                } elseif ( 'percentage_decrease' == $rule_cus_price['discount_type'] ) {

                                                    $percent_price = $pro_price * $rule_cus_price['discount_value'] / 100;

                                                    $newprice = $pro_price - $percent_price;

                                                    $newprice1 = wc_get_price_to_display( $product, array(
                                                        'qty'   => 1,
                                                        'price' => $newprice,
                                                    ) );

                                                    $table_data .= '<div class="item"> Buy ' . $rule_cus_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent"> '. $rule_cus_price['discount_value'].'</span>%</strong> </div>';

                                                    $customer_discount1 = true;

                                                } elseif ( 'percentage_increase' == $rule_cus_price['discount_type'] ) {

                                                    $percent_price = $pro_price * $rule_cus_price['discount_value'] / 100;

                                                    $newprice = $pro_price + $percent_price;

                                                    $newprice1 = wc_get_price_to_display( $product, array(
                                                        'qty'   => 1,
                                                        'price' => $newprice,
                                                    ) );

                                                    $table_data .= '<div class="item"> Buy' . $rule_cus_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $rule_cus_price['discount_value'].'</span>%</strong> </div>';

                                                    $customer_discount1 = true;

                                                }
                                            }
                                        }

                                    }

                                } //End rule customer base pricing.

                                //Start rule role base pricing.
                                //chcek if there is rule customer base pricing then rule role base pricing will not work.

                                if ( ! $customer_discount1 ) {

                                    if ( ! empty( $rule_role_base_wsp_price ) ) {

                                        

                                        foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

                                            if ( 'everyone' == $rule_role_price['user_role'] || $role[0] == $rule_role_price['user_role'] ) { 

                                                if ( '' != $rule_role_price['discount_value'] || 0 != $rule_role_price['discount_value'] ) {


                                                    //Fixed Price
                                                    if ( 'fixed_price' == $rule_role_price['discount_type'] ) {

                                                        $newprice = wc_get_price_to_display( $product, array(
                                                            'qty'   => 1,
                                                            'price' => $rule_role_price['discount_value'],
                                                        ) );
                                                                    
                                                        $table_data .= '<div class="item"> Buy' . $rule_role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $rule_role_price['discount_value'].'</span>%</strong> </div>';


                                                                    
                                                    } elseif ( 'fixed_increase' == $rule_role_price['discount_type'] ) {

                                                        $newprice = $pro_price + $rule_role_price['discount_value'];

                                                        $newprice1 = wc_get_price_to_display( $product, array(
                                                            'qty'   => 1,
                                                            'price' => $newprice,
                                                        ) );

                                                        $table_data .= '<div class="item"> Buy' . $rule_role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $rule_role_price['discount_value'].'</span>%</strong> </div>';


                                                                    


                                                    } elseif ( 'fixed_decrease' == $rule_role_price['discount_type'] ) {

                                                        $newprice = $pro_price - $rule_role_price['discount_value'];

                                                        $newprice1 = wc_get_price_to_display( $product, array(
                                                            'qty'   => 1,
                                                            'price' => $newprice,
                                                        ) );

                                                        $table_data .= '<div class="item"> Buy' . $rule_role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $rule_role_price['discount_value'].'</span>%</strong> </div>';

                                                    } elseif ( 'percentage_decrease' == $rule_role_price['discount_type'] ) {

                                                        $percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

                                                        $newprice = $pro_price - $percent_price;

                                                        $newprice1 = wc_get_price_to_display( $product, array(
                                                            'qty'   => 1,
                                                            'price' => $newprice,
                                                        ) );

                                                        $table_data .= '<div class="item"> Buy ' . $rule_role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent"> '. $rule_role_price['discount_value'].'</span>%</strong> </div>';


                                                    } elseif ( 'percentage_increase' == $rule_role_price['discount_type'] ) {

                                                        $percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

                                                        $newprice = $pro_price + $percent_price;

                                                        $newprice1 = wc_get_price_to_display( $product, array(
                                                            'qty'   => 1,
                                                            'price' => $newprice,
                                                        ) );


                                                        $table_data .= '<div class="item"> Buy' . $rule_role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $rule_role_price['discount_value'].'</span>%</strong> </div>';

                                                    }


                                                }
                                            }

                                        }
                                    }
                                }

                            }

                        }
                    }


                }

            } elseif ( !is_user_logged_in() ) {
                if ( isset( $tier_pricing->addify_wsp_discount_price['guest'] ) ) {

                    if ('sale' == $tier_pricing->addify_wsp_discount_price['guest'] && !empty(get_post_meta( $product->get_id(), '_sale_price', true ))) {

                        $pro_price = get_post_meta( $product->get_id(), '_sale_price', true );

                    } elseif ('regular' == $tier_pricing->addify_wsp_discount_price['guest'] && !empty(get_post_meta( $product->get_id(), '_regular_price', true ))) {

                        $pro_price = get_post_meta( $product->get_id(), '_regular_price', true );

                    }
                        
                } else {

                    $pro_price = get_post_meta( $product->get_id(), '_price', true );
                }
                        // Role Based Pricing for guest
                if ( true ) {

                    // get role base price for guest
                    $role_base_wsp_price = get_post_meta( $product->get_id(), '_role_base_wsp_price', true );
                    if ( ! empty( $role_base_wsp_price )  ) {
                        foreach ( $role_base_wsp_price as $role_price ) {

                            if ( isset( $role_price['user_role'] ) && ( 'everyone' == $role_price['user_role'] || 'guest' == $role_price['user_role'] )) {

                                if ( '' != $role_price['discount_value'] || 0 != $role_price['discount_value'] ) {
                                    //Fixed Price
                                    if ( 'fixed_price' == $role_price['discount_type'] ) {
                                                        
                                        $table_data .= '<div class="item"> Buy' . $role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $role_price['discount_value'].'</span>%</strong> </div>';

                                        $role_discount = true;

                                                        
                                    } elseif ( 'fixed_increase' == $role_price['discount_type'] ) {

                                        $newprice = $pro_price + $role_price['discount_value'];

                                        $table_data .= '<div class="item"> Buy' . $role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $role_price['discount_value'].'</span>%</strong> </div>';

                                        $role_discount = true;

                                    } elseif ( 'fixed_decrease' == $role_price['discount_type'] ) {

                                        $newprice = $pro_price - $role_price['discount_value'];

                                        $table_data .= '<div class="item"> Buy' . $role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $role_price['discount_value'].'</span>%</strong> </div>';

                                        $role_discount = true;

                                    } elseif ( 'percentage_decrease' == $role_price['discount_type'] ) {

                                        $percent_price = $pro_price * $role_price['discount_value'] / 100;

                                        $newprice = $pro_price - $percent_price;

                                        $table_data .= '<div class="item"> Buy ' . $role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent"> '. $role_price['discount_value'].'</span>%</strong> </div>';

                                        $role_discount = true;

                                    } elseif ( 'percentage_increase' == $role_price['discount_type'] ) {

                                        $percent_price = $pro_price * $role_price['discount_value'] / 100;

                                        $newprice = $pro_price + $percent_price;

                                        $table_data .= '<div class="item"> Buy' . $role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $role_price['discount_value'].'</span>%</strong> </div>';

                                        $role_discount = true;                                                       
                                    }

                                }
                            }
                        }
                    }
                    //Rules - guest users
                    if ( false == $role_discount  ) {


                        if ( empty( $tier_pricing->allfetchedrules ) ) {

                            echo '';

                        } else {

                            $all_rules = $tier_pricing->allfetchedrules;

                        }

                        if ( ! empty( $all_rules ) ) {

                            foreach ( $all_rules as $rule ) {



                                $istrue = false;
                                    

                                $applied_on_all_products = get_post_meta($rule->ID, 'wsp_apply_on_all_products', true);
                                $products                = get_post_meta($rule->ID, 'wsp_applied_on_products', true);
                                $categories              = get_post_meta($rule->ID, 'wsp_applied_on_categories', true);

                                if ('yes' == $applied_on_all_products ) {
                                    $istrue = true;
                                } elseif (! empty($products) && ( in_array($product->get_id(), $products) || in_array($product->get_parent_id(), $products) ) ) {
                                    $istrue = true;
                                }

                                                
                                if (!empty($categories)) {
                                    foreach ( $categories as $cat ) {

                                        if ( !empty( $cat) && ( has_term( $cat, 'product_cat', $product->get_id() ) ) || ( has_term( $cat, 'product_cat', $product->get_parent_id() ) ) ) {

                                            $istrue = true;
                                        } 
                                    }
                                }

                                    

                                if ( $istrue ) {


                                    //get rule role base price for guest
                                    $rule_role_base_wsp_price = get_post_meta( $rule->ID, 'rrole_base_wsp_price', true );

                                    if ( ! empty( $rule_role_base_wsp_price ) ) {

                                            

                                        foreach ( $rule_role_base_wsp_price as $rule_role_price ) {

                                            if ('everyone' == $rule_role_price['user_role'] || 'guest' == $rule_role_price['user_role'] ) {

                                                if ( '' != $rule_role_price['discount_value'] || 0 != $rule_role_price['discount_value'] ) {


                                                    //Fixed Price
                                                    if ( 'fixed_price' == $rule_role_price['discount_type'] ) {
                                                                        
                                                        $table_data .= '<div class="item"> Buy' . $rule_role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $rule_role_price['discount_value'].'</span>%</strong> </div>';
                                 
                                                    } elseif ( 'fixed_increase' == $rule_role_price['discount_type'] ) {

                                                        $newprice = $pro_price + $rule_role_price['discount_value'];

                                                        $table_data .= '<div class="item"> Buy' . $rule_role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $rule_role_price['discount_value'].'</span>%</strong> </div>';

                                                    } elseif ( 'fixed_decrease' == $rule_role_price['discount_type'] ) {

                                                        $newprice = $pro_price - $rule_role_price['discount_value'];

                                                        $table_data .= '<div class="item"> Buy' . $rule_role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $rule_role_price['discount_value'].'</span>%</strong> </div>';

                                                    } elseif ( 'percentage_decrease' == $rule_role_price['discount_type'] ) {

                                                        $percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

                                                        $newprice = $pro_price - $percent_price;

                                                        $table_data .= '<div class="item"> Buy ' . $rule_role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent"> '. $rule_role_price['discount_value'].'</span>%</strong> </div>';

                                                    } elseif ( 'percentage_increase' == $rule_role_price['discount_type'] ) {

                                                        $percent_price = $pro_price * $rule_role_price['discount_value'] / 100;

                                                        $newprice = $pro_price + $percent_price;

                                                        $table_data .= '<div class="item"> Buy ' . $rule_role_price['min_qty'] . '<strong class="extratext"></strong> <strong class="benefit">and save<span class="percent">'. $rule_role_price['discount_value'].'</span>%</strong> </div>';


                                                    }

                                                }
                                            }
                                        }
                                    }
                                                

                                }

                            }
                        }

                    }

                }
                
            }                    
        }
        
        if (!empty($table_data)) {
            $data = $table_data;
                echo wp_kses_post ($data );
        }   
    }
}
// -bugfix/BWIPIT-2894-thank-you-page-validation-message-content

add_filter( 'woocommerce_process_login_errors', 'custom_login_validation', 10, 3 );
function custom_login_validation( $validation_error, $username, $password ) {
    if ( ! is_email( $username ) ) {
        $validation_error->add( 'username_error', __( 'Please enter a valid email address.', 'woocommerce' ) );
    }
    return $validation_error;
}
//Don't let user to visit a page if they are logged in
add_action('template_redirect', 'redirect_logged_in_users');
function redirect_logged_in_users() {
    if ( is_page('login') && is_user_logged_in() ) {
        wp_redirect( home_url('/my-account/') );
        exit;
    }
}
add_action( 'login_form_logout', 'logout_redirection' );
function logout_redirection() {

  $user = wp_get_current_user();
  wp_logout();

  if ( ! empty( $_REQUEST[ 'redirect_to' ] ) ) {
    $redirect_to = $requested_redirect_to = $_REQUEST[ 'redirect_to' ];
  } else {
    $redirect_to = 'wp-login.php?loggedout=true';
    $requested_redirect_to = '';
  }

  $redirect_to = apply_filters( 'logout_redirect', $redirect_to, $requested_redirect_to, $user );
  wp_safe_redirect( $redirect_to );
  exit;
  
}

add_action( 'um_registration_complete', 'set_billing_shipping', 10, 2 );
function set_billing_shipping( $user_id, $args ){
    update_user_meta( $user_id, "billing_first_name", $args['first_name'] );
    update_user_meta( $user_id, "billing_last_name", $args['last_name'] );
    update_user_meta( $user_id, "billing_phone", $args['telephone'] );
    update_user_meta( $user_id, "billing_country", $args['billing_country'] );

    update_user_meta( $user_id, "shipping_first_name", $args['first_name'] );
    update_user_meta( $user_id, "shipping_last_name", $args['last_name'] );
    update_user_meta( $user_id, "shipping_phone", $args['telephone'] );
    //update_user_meta( $user_id, "shipping_email", $args['user_email'] );
    if ( ! empty( $args['shipping_country'] ) && ! empty( $args['shipping_address_1'] ) && ! empty( $args['shipping_city'] ) && ! empty( $args['shipping_postcode'] ) && ! empty( $args['shipping_state'] ) ){
        update_user_meta( $user_id, "shipping_country", $args['shipping_country'] );
        update_user_meta( $user_id, "shipping_address_1", $args['shipping_address_1'] );
        update_user_meta( $user_id, "shipping_address_2", $args['shipping_address_2'] );
        update_user_meta( $user_id, "shipping_city", $args['shipping_city'] );
        update_user_meta( $user_id, "shipping_postcode", $args['shipping_postcode'] );
        update_user_meta( $user_id, "shipping_state", $args['shipping_state'] );
    } else {
        update_user_meta( $user_id, "shipping_country", $args['billing_country'] );
        update_user_meta( $user_id, "shipping_address_1", $args['billing_address_1'] );
        update_user_meta( $user_id, "shipping_address_2", $args['billing_address_2'] );
        update_user_meta( $user_id, "shipping_city", $args['billing_city'] );
        update_user_meta( $user_id, "shipping_postcode", $args['billing_postcode'] );
        update_user_meta( $user_id, "shipping_state", $args['billing_state'] );
    }

    UM()->user()->remove_cache( $user_id );
}
add_filter('woocommerce_address_to_edit', 'custom_add_default_address_checkboxes', 10, 2);

function custom_add_default_address_checkboxes($address, $load_address) {
    // Checkbox for setting the current address as the default billing address
    $address['set_default_billing'] = array(
        'type'        => 'checkbox',
        'label'       => '<span class="checkbox-text"> USE AS MY DEFAULT BILLING ADDRESS</span>',
        'class'       => array('form-row-wide'),
        'required'    => false,
        'priority'    => 110,
    );

    // Checkbox for setting the current address as the default shipping address
    $address['set_default_shipping'] = array(
        'type'        => 'checkbox',
        'label'       => '<span class="checkbox-text"> USE AS MY DEFAULT SHIPPING ADDRESS</span>',
        'class'       => array('form-row-wide'),
        'required'    => false,
        'priority'    => 111,
    );

    return $address;
}

add_action('woocommerce_customer_save_address', 'custom_handle_default_address_selection', 10, 2);

function custom_handle_default_address_selection($user_id, $load_address) {
    // Handling the default billing address
    $url = $_SERVER['REQUEST_URI'];
    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);
    $address_number = $params['address-book'];

    $path = $url_components['path'];
    $path_parts = explode('/', trim($path, '/'));
    $address_type = end($path_parts);
    if($address_number){
        if (isset($_POST['set_default_billing']) && $_POST['set_default_billing'] == '1') {
            $fields = array(
                'first_name', 'last_name', 'company', 'address_1', 'address_2',
                'city', 'postcode', 'country', 'state', 'email', 'phone'
            );
            foreach ($fields as $field) {
                $billing_field = 'billing_' . $field;
                $value_field = $address_number. '_' . $field;

                $field_val = sanitize_text_field($_POST[$value_field]);
                update_user_meta($user_id, $billing_field, $field_val);
            }
        }

        // Handling the default shipping address
        if (isset($_POST['set_default_shipping']) && $_POST['set_default_shipping'] == '1') {
            $fields = array(
                'first_name', 'last_name', 'company', 'address_1', 'address_2',
                'city', 'postcode', 'country', 'state'
            );
            foreach ($fields as $field) {
                $shipping_field = 'shipping_' . $field;
                $value_field = $address_number. '_' . $field;

                $field_val = sanitize_text_field($_POST[$value_field]);
                update_user_meta($user_id, $shipping_field, $field_val);
            }
        }
    }else{
        if (isset($_POST['set_default_billing']) && $_POST['set_default_billing'] == '1') {        
            $fields = array(
                'first_name', 'last_name', 'company', 'address_1', 'address_2',
                'city', 'postcode', 'country', 'state', 'email', 'phone'
            );
            foreach ($fields as $field) {
                $billing_field = 'billing_' . $field;
                $value_field = $address_type. '_' . $field;

                $field_val = sanitize_text_field($_POST[$value_field]);
                update_user_meta($user_id, $billing_field, $field_val);
            }
        }
        if (isset($_POST['set_default_shipping']) && $_POST['set_default_shipping'] == '1') {
            $fields = array(
                'first_name', 'last_name', 'company', 'address_1', 'address_2',
                'city', 'postcode', 'country', 'state'
            );
            foreach ($fields as $field) {
                $shipping_field = 'shipping_' . $field;
                $value_field = $address_type. '_' . $field;

                $field_val = sanitize_text_field($_POST[$value_field]);
                update_user_meta($user_id, $shipping_field, $field_val);
            }
        }
    }


}
add_filter('woocommerce_shipping_fields', 'custom_modify_shipping_fields', 20, 1);
function custom_modify_shipping_fields($fields) {
    if(isset($fields['shipping_phone'])) {
        $fields['shipping_phone']['label'] = __('Phone', 'storefrontchild');
    }

    return $fields;
}

add_filter( 'send_retrieve_password_email', 'send_retrieve_password_email_custom', 10, 3 );

function send_retrieve_password_email_custom( $true, $user_login, $user_data ) {

    um_fetch_user( $user_data->ID );
    UM()->user()->password_reset();

    return false;
}

function send_completed_order_email_to_admin($order_id) {
    if (!$order_id) {
        return;
    }

    $order = wc_get_order($order_id);
    if (!$order) {
        return;
    }

    $admin_email = get_option('shipment_email_copy');
    $mailer = WC()->mailer();
    $store_name = [1 => 'UK', 2 => 'NZ', 3 => 'AU', 4 => 'EU'];
    $subject = 'Your Rosita Real Foods '.$store_name[get_current_blog_id()].' order is now complete';
    $headers = array('Content-Type: text/html; charset=UTF-8');

    // Get the email content
    ob_start();
    wc_get_template('emails/customer-completed-order.php', array('order' => $order));
    $message = ob_get_clean();

    // Send the email
    wp_mail($admin_email, $subject, $message, $headers);
}

add_action('woocommerce_order_status_completed', 'send_completed_order_email_to_admin', 10, 1);

// -bugfix/BWIPIT-3018-dont-translate-view-cart-pdp

add_filter( 'gettext', 'change_update_basket_text', 20, 3 );

function change_update_basket_text( $translated_text, $text, $domain ) {
    if ( 'woocommerce' === $domain && 'Update cart' === $text ) {
        $translated_text = $text;
    }
    return $translated_text;
}

add_filter( 'gettext', 'change_view_cart_text', 20, 3 );

function change_view_cart_text( $translated_text, $text, $domain ) {
    if ( 'woocommerce' === $domain && 'View cart' === $text ) {
        $translated_text = $text;
    }
    return $translated_text;
}

add_filter( 'gettext', 'keep_cart_text', 999, 3 );
add_filter( 'ngettext', 'keep_cart_text_plural', 999, 5 );

function keep_cart_text( $translated_text, $text, $domain ) {
    if ( 'woocommerce' === $domain && '%s has been added to your cart.' === $text ) {
        $translated_text = $text;
    }
    return $translated_text;
}

function keep_cart_text_plural( $translated_text, $single, $plural, $number, $domain ) {
   
     if ( 'woocommerce' === $domain ) {
        if ( $number == 1 && '%s has been added to your cart.' === $single ) {
            $translated_text = $single;
        } elseif ( $number != 1 && '%s have been added to your cart.' === $plural ) {
            $translated_text = $plural;
        }
    }
    return $translated_text;
}
// -end bugfix/BWIPIT-3018-dont-translate-view-cart-pdp

add_action( 'woocommerce_subscription_status_cancelled', 'sendCustomerCancellationEmail' );
function sendCustomerCancellationEmail( $subscription ) {
    $customer_email = $subscription->get_billing_email();
    $wc_emails = WC()->mailer()->get_emails();
    $wc_emails['WCS_Email_Cancelled_Subscription']->recipient = $customer_email;
    $wc_emails['WCS_Email_Cancelled_Subscription']->trigger( $subscription );
}


//Add product on renewal schedule
add_filter('wcs_renewal_order_created', 'add_product_to_renewal_order', 10, 2);

function add_product_to_renewal_order($renewal_order_id, $subscription) {
    // Get the renewal order object
    $renewal_order = wc_get_order($renewal_order_id);

    if (get_current_blog_id()!=1 && get_current_blog_id()!=4) {
        $sku_to_add = 'ROSITACHILLED';
        $product_id = wc_get_product_id_by_sku($sku_to_add);
    	
    	$sku_1 = '857605004007'; //Liver Oil (EVCLO) Liquid
        $sku_2 = '857605004021'; // Ratfish Liver Oil (RFLO) 50ml

        
    	$chilledQty = 0;
        $chilledQtyInOrder = 0;

        if ($renewal_order) {
            $product = wc_get_product($product_id);
    	
    		$product_1_or_2_in_order = false;
            $product_already_in_order = false;

    		foreach ($renewal_order->get_items() as $item) {
                if ($item->get_product()->get_sku() == $sku_1 || $item->get_product()->get_sku() == $sku_2) {
                    $product_1_or_2_in_order = true;
    				$chilledQty += round($item['quantity'] / 2);
                }
                if ($item->get_product()->get_sku() == $sku_to_add) {
                    $product_already_in_order = true;
                    $chilledQtyInOrder = $item['quantity'];
                }
            }
    		
            // If the chilled packging product is not already in the order, add it
            if ($product_1_or_2_in_order && (!$product_already_in_order || $chilledQtyInOrder!=$chilledQty)) {
                $qty_to_add = $chilledQty - $chilledQtyInOrder;
                $renewal_order->add_product($product, $qty_to_add);
                $renewal_order->calculate_totals();
                $renewal_order->save();
            }
        }
    }
    
	return $renewal_order;
}

add_action('woocommerce_update_product', 'update_renewal_subscriptions_on_product_update', 10, 1);

function update_renewal_subscriptions_on_product_update($product_id) {
    $product = wc_get_product($product_id);
    if (!$product) {
        return;
    }
	$stock_quantity = $product->get_stock_quantity();

    if ($stock_quantity > 0) {
        $args = [
            'subscription_status' => 'on-hold',
            'product_id' => $product_id,
        ];

        $subscriptions = wcs_get_subscriptions($args);

        foreach ($subscriptions as $subscription) {
            if ($subscription->has_status('on-hold')) {
				// Add a note to the subscription
				$subscription->add_order_note(__('Product '.$product->get_sku().' is back in stock. Attempting to activate the subscription.', 'storefrontchild'));
				$subscription->update_status('active', __('Subscription renewed after product restocked.', 'storefrontchild'));
                $stock_quantity--;
			}

			if ($stock_quantity <= 0) {
                break;
            }
        }
    } else {
		$args = [
            'subscription_status' => 'active',
            'product_id' => $product_id,
        ];

        $subscriptions = wcs_get_subscriptions($args);

        foreach ($subscriptions as $subscription) {
            if ($subscription->has_status('active')) {
                // Add a note to the subscription
                $subscription->add_order_note(__('Product '.$product->get_sku().' is out of stock. Putting the subscription on hold for now.', 'storefrontchild'));
                $subscription->update_status('on-hold', __('Subscription will be on hold until product restocked.', 'storefrontchild'));

                $to = get_option('admin_email');
                $subject = 'Renewal Product Out of Stock';
                $body = 'Product '.$product->get_sku().' is out of stock. Subscription ID '.$subscription->get_id().' is now on-hold. Please check product stock.';
                $headers = array('Content-Type: text/html; charset=UTF-8');
        
                wp_mail($to, $subject, $body, $headers);
            }
        }
	}
}


//Update upgrade/downgrade/crossgrade text
remove_filter( 'woocommerce_cart_item_subtotal', array( 'WC_Subscriptions_Switcher', 'add_cart_item_switch_direction' ), 10, 3 );

function custom_add_cart_item_switch_direction( $product_subtotal, $cart_item, $cart_item_key ) {

	if ( ! empty( $cart_item['subscription_switch'] ) ) {

		switch ( $cart_item['subscription_switch']['upgraded_or_downgraded'] ) {
			case 'downgraded':
				$direction = _x( 'Update Subscription', 'a switch type', 'woocommerce-subscriptions' );
				break;
			case 'upgraded':
				$direction = _x( 'Update Subscription', 'a switch type', 'woocommerce-subscriptions' );
				break;
			default:
				$direction = _x( 'Update Subscription', 'a switch type', 'woocommerce-subscriptions' );
			break;
		}

		// translators: %1: product subtotal, %2: HTML span tag, %3: direction (upgrade, downgrade, crossgrade), %4: closing HTML span tag
		$product_subtotal = sprintf( _x( '%1$s %2$s(%3$s)%4$s', 'product subtotal string', 'woocommerce-subscriptions' ), $product_subtotal, '<span class="subscription-switch-direction">', $direction, '</span>' );

	}

	return $product_subtotal;
}

add_filter( 'woocommerce_cart_item_subtotal', 'custom_add_cart_item_switch_direction', 10, 3 );

// BWIPIT-3069

function add_guest_body_class($classes) {
   
    $order_id = get_query_var('order-received');

    if ($order_id) {
       
        $order = wc_get_order($order_id);

        if ($order) {
           
            $billing_email = $order->get_billing_email();

           
            $user = get_user_by('email', $billing_email);

            if (!$user || !is_user_member_of_blog($user->ID, get_current_blog_id())) {
                
                $classes[] = 'guest-checkout';
            }
        }
    }

    return $classes;
}
add_filter('body_class', 'add_guest_body_class');

add_filter( 'wcs_view_subscription_actions', 'customize_subscription_cancel_button_text', 10, 2 );

function customize_subscription_cancel_button_text( $actions, $subscription ) {
    // Check if the cancel action exists
    if ( isset( $actions['cancel'] ) ) {
        // Change the cancel button text
        $actions['cancel']['name'] = __( 'Cancel subscription', 'woocommerce-subscriptions' );
    }

    return $actions;
}
function manipulate_woocommerce_email_sending($email_class){
    remove_action('woocommerce_order_status_on-hold_to_processing_notification', array($email_class->emails['WC_Email_Customer_Processing_Order'], 'trigger'));
}
add_action('woocommerce_email', 'manipulate_woocommerce_email_sending');

function custom_wc_get_star_rating_html( $html, $rating, $count ) {
    $full_stars = floor( $rating );
    $half_star = $rating - $full_stars;
    $stars_html = '<div class="custom-star-rating" data-rate="' . $rating . '">';

    for ( $i = 1; $i <= 5; $i++ ) {
        if ( $i <= $full_stars ) {
            // Full star
            $fill_color = '#00b1aa';
        } elseif ( $i == $full_stars + 1 && $half_star > 0 ) {
            // Partial star
            $fill_color = 'url(#partial-fill)';
        } else {
            // Empty star
            $fill_color = 'none';
        }

        $stars_html .= '<span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="24" viewBox="0 0 24 24" fill="' . $fill_color . '" stroke="#00b1aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <defs>
                                    <linearGradient id="partial-fill">
                                        <stop offset="' . ($half_star * 100) . '%" stop-color="#00b1aa" />
                                        <stop offset="' . ($half_star * 100) . '%" stop-color="transparent" />
                                    </linearGradient>
                                </defs>
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                            </svg>
                        </span>';
    }

    $stars_html .= '</div>';

    return $stars_html;
}

add_filter( 'woocommerce_product_get_star_rating_html', 'custom_wc_get_star_rating_html', 10, 3 );

function custom_wc_get_rating_html( $html, $rating, $count ) {
    
    $star_rating_html = custom_wc_get_star_rating_html( '', $rating, $count );
    $custom_html = '<div class="custom-rating">' . $star_rating_html . '</div>';
    
    return $custom_html;
}

add_filter( 'woocommerce_product_get_rating_html', 'custom_wc_get_rating_html', 10, 3 );

function add_cart_page_link_after_checkout_button( $front ) {
    if ( WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) {
        $cart_page_url = wc_get_cart_url();
        $cart_link_text = __( 'View and edit cart', 'storefrontchild' );
        echo '<a href="' . esc_url( $cart_page_url ) . '" class="fkcart-cart-page-link">' . esc_html( $cart_link_text ) . '</a>';
    }
}

add_action( 'fkcart_after_checkout_button', 'add_cart_page_link_after_checkout_button', 20 );

add_filter( 'lostpassword_url',  'wdm_lostpassword_url', 10, 0 );
function wdm_lostpassword_url() {
    return site_url('/password-reset/');
}

function add_title_body_class( $classes ) {
    global $post;

    if ( isset( $post ) ) {
        $classes[] = $post->post_type . '-' . $post->post_name;

        if ( $post->post_type === 'product' ) {
            // Get the product object
            $product = wc_get_product( $post->ID );

            if ( $product && $product->is_on_sale() ) {
                $classes[] = 'sale';
            }
        }
    }

    return $classes;
}

add_filter( 'body_class', 'add_title_body_class' );

add_filter('woocommerce_account_menu_items','wt_removed_un_wanted_my_account_tabs',100,1);
function wt_removed_un_wanted_my_account_tabs( $items ) {
   if( isset($items['wt-smart-coupon']) ) unset( $items['wt-smart-coupon'] );

   return $items;
}

function disable_zoom_mobile() {
    if (wp_is_mobile()) {
        remove_theme_support('wc-product-gallery-zoom');
    }
}
add_action('wp', 'disable_zoom_mobile');

//Add api for n8n
add_action('rest_api_init', function() {
    // Register SEO Title
    register_meta('post', 'rank_math_title', [
        'object_subtype' => 'post',
        'type' => 'string',
        'single' => true,
        'sanitize_callback' => 'sanitize_text_field',
        'show_in_rest' => [
            'schema' => [
                'type' => 'string',
                'description' => 'RankMath SEO Title',
                'context' => ['view', 'edit']
            ],
            'permission_callback' => function() {
                return current_user_can('edit_posts');
            }
        ]
    ]);

    // Register Meta Description
    register_meta('post', 'rank_math_description', [
        'object_subtype' => 'post',
        'type' => 'string',
        'single' => true,
        'sanitize_callback' => 'sanitize_text_field',
        'show_in_rest' => [
            'schema' => [
                'type' => 'string',
                'description' => 'RankMath SEO Description',
                'context' => ['view', 'edit']
            ],
            'permission_callback' => function() {
                return current_user_can('edit_posts');
            }
        ]
    ]);

    // Register Focus Keywords
    register_meta('post', 'rank_math_focus_keyword', [
        'object_subtype' => 'post',
        'type' => 'string',
        'single' => true,
        'sanitize_callback' => 'sanitize_text_field',
        'show_in_rest' => [
            'schema' => [
                'type' => 'string',
                'description' => 'RankMath Focus Keyword',
                'context' => ['view', 'edit']
            ],
            'permission_callback' => function() {
                return current_user_can('edit_posts');
            }
        ]
    ]);
});

add_action('init', function () {
    if (is_user_logged_in() && !is_user_member_of_blog()) {
        wp_logout();
        wp_redirect(wp_login_url());
        exit;
    }
});

add_filter('authenticate', function ($user, $username, $password) {
    if (is_wp_error($user) || empty($username)) {
        return $user;
    }

    // Detect if input is email or username
    if (is_email($username)) {
        $user_data = get_user_by('email', $username);
    } else {
        $user_data = get_user_by('login', $username);
    }

    if (!$user_data || !is_user_member_of_blog($user_data->ID)) {
        return new WP_Error('not_allowed', __('Invalid credentials. Please check your details or sign up if you don’t have an account.'));
    }

    return $user;
}, 30, 3);

add_action("um_submit_form_register","um_custom_field_validation");
function um_custom_field_validation( $post_form ){
    
    // Trigger error when the Passcode field is empty
    if(  isset( $post_form['practitioner_type'] ) && empty( $post_form['practitioner_type'] ) ){
        UM()->form()->add_error('practitioner_type', __( 'Please Select Your Practitioner Type is required', 'ultimate-member' ) );
    }
    if(  isset( $post_form['practitioner_qualification'] ) && empty( $post_form['practitioner_qualification'] ) ){
        UM()->form()->add_error('practitioner_qualification', __( 'Level of Qualification is required', 'ultimate-member' ) );
    }
    if(  isset( $post_form['practitioner_certificate'] ) && empty( $post_form['practitioner_certificate'] ) ){
        UM()->form()->add_error('practitioner_certificate', __( 'This field is required', 'ultimate-member' ) );
    }
    if(  isset( $post_form['practitioner_how_long'] ) && empty( $post_form['practitioner_how_long'] ) ){
        UM()->form()->add_error('practitioner_how_long', __( 'How Long Have You Been In Business? is required', 'ultimate-member' ) );
    }
    if(  isset( $post_form['practitioner_annual'] ) && empty( $post_form['practitioner_annual'] ) ){
        UM()->form()->add_error('practitioner_annual', __( 'What is Your Anticipated Annual Order Volume From Functional Self  is required', 'ultimate-member' ) );
    }
    if(  isset( $post_form['practitioner_num_clients'] ) && empty( $post_form['practitioner_num_clients'] ) ){
        UM()->form()->add_error('practitioner_num_clients', __( 'Number of Unique Clients You See Each Week is required', 'ultimate-member' ) );
    }
    if(  isset( $post_form['payment_details'] ) && empty( $post_form['payment_details'] ) ){
        UM()->form()->add_error('payment_details', __( 'Payment Options is required', 'ultimate-member' ) );
    }
    if(  isset( $post_form['practitioners_name'] ) && empty( $post_form['practitioners_name'] ) ){
        UM()->form()->add_error('practitioners_name', __( 'Practioners Name is required', 'ultimate-member' ) );
    }
    if(  isset( $post_form['practitioner_code'] ) && empty( $post_form['practitioner_code'] ) ){
        UM()->form()->add_error('practitioner_code', __( 'Practitioners Unique Reference Code is required', 'ultimate-member' ) );
    }
    if(  isset( $post_form['pensioner_identification'] ) && empty( $post_form['pensioner_identification'] ) ){
        UM()->form()->add_error('pensioner_identification', __( 'Pensioner Identification is required', 'ultimate-member' ) );
    }
    if(  isset( $post_form['practitioner_description'] ) && empty( $post_form['practitioner_description'] ) ){
        UM()->form()->add_error('practitioner_description', __( 'Describe your company or practice is required', 'ultimate-member' ) );
    }
    if(  isset( $post_form['shipping_address_1'] ) && empty( $post_form['shipping_address_1'] ) ){
        UM()->form()->add_error('shipping_address_1', __( 'Address line 1 is required', 'ultimate-member' ) );
    }
    if(  isset( $post_form['shipping_city'] ) && empty( $post_form['shipping_city'] ) ){
        UM()->form()->add_error('shipping_city', __( 'City is required', 'ultimate-member' ) );
    }
    if(  isset( $post_form['shipping_postcode'] ) && empty( $post_form['shipping_postcode'] ) ){
        UM()->form()->add_error('shipping_postcode', __( 'Post Code  is required', 'ultimate-member' ) );
    }
    if(  isset( $post_form['shipping_country'] ) && empty( $post_form['shipping_country'] ) ){
        UM()->form()->add_error('shipping_country', __( 'Country is required', 'ultimate-member' ) );
    }
     
}

add_action( 'transition_post_status', 'send_publish_webhook', 10, 3 );

function send_publish_webhook( $new_status, $old_status, $post ) {
    // Only fire on FIRST transition to "publish" for standard posts
    if ( 'publish' !== $new_status || 'publish' === $old_status || 'post' !== $post->post_type ) {
        return;
    }

    // Author data
    $author = get_userdata( $post->post_author );

    $payload = [
        'id'             => $post->ID,
        'title'          => $post->post_title,
        'author'         => $author ? $author->display_name : null,
        'author_email'   => $author ? $author->user_email : null,
        'url'            => get_permalink( $post ),
        'date_gmt'       => $post->post_date_gmt,
        'content'        => apply_filters( 'the_content', $post->post_content ),
        'featured_image' => get_the_post_thumbnail_url( $post, 'full' ),
    ];

    // Add Rank Math focus keyword(s)
    $keywords = get_post_meta( $post->ID, '_rank_math_focus_keyword', true );
    if ( empty( $keywords ) ) {
        $keywords = get_post_meta( $post->ID, 'rank_math_focus_keyword', true );
    }
    $payload['focus_keywords'] = $keywords ?: null;

    // Send async webhook
    wp_remote_post(
        'https://auto.bwipholdings.com/webhook/published',
        [
            'headers'  => [ 'Content-Type' => 'application/json' ],
            'body'     => wp_json_encode( $payload ),
            'timeout'  => 5,
            'blocking' => false,
        ]
    );
}

// Helper function to validate English-only input
function bwip_validate_english_only_fields($fields, $location = 'checkout') {
    $allowed_pattern = '/^[\x00-\x7F]+$/';
    foreach ($fields as $field_key => $field_label) {
        if (!empty($_POST[$field_key]) && !preg_match($allowed_pattern, $_POST[$field_key])) {
            $message = "Please enter only English letters in the $field_label field.";
            if ($location === 'account') {
                wc_add_notice($message, 'error');
            } else {
                wc_add_notice(__($message, 'woocommerce'), 'error');
            }
        }
    }
}

// Validate at checkout (billing + shipping)
add_action('woocommerce_checkout_process', function() {
    $fields = [
        'billing_first_name' => 'Billing First Name',
        'billing_last_name'  => 'Billing Last Name',
        'billing_address_1'  => 'Billing Address Line 1',
        'billing_address_2'  => 'Billing Address Line 2',
        'billing_city'       => 'Billing City',
        'billing_company'    => 'Billing Company',
        'shipping_first_name' => 'Shipping First Name',
        'shipping_last_name'  => 'Shipping Last Name',
        'shipping_address_1'  => 'Shipping Address Line 1',
        'shipping_address_2'  => 'Shipping Address Line 2',
        'shipping_city'       => 'Shipping City',
        'shipping_company'    => 'Shipping Company',
    ];
    bwip_validate_english_only_fields($fields, 'checkout');
});

add_action('wp_footer', function () {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const englishRegex = /^[\x00-\x7F]*$/;
            const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], textarea');

            function validateField(input) {
                if (!englishRegex.test(input.value)) {
                    input.setCustomValidity("Please enter only English letters.");
                    input.reportValidity();
                    input.style.border = "1px solid red";
                    // Disable the submit button
                    const form = input.closest('form');
                    const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = true;
                    }
                    return false;
                } else {
                    input.setCustomValidity("");
                    input.style.border = "";
                    // Enable the submit button
                    const form = input.closest('form');
                    const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = false;
                    }
                    return true;
                }
            }

            // Initial validation for pre-filled values
            inputs.forEach(input => {
                validateField(input);
                input.addEventListener('input', () => validateField(input));
            });

            // Handle form submissions
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    let isValid = true;

                    inputs.forEach(input => {
                        const valid = validateField(input);
                        if (!valid) {
                            input.reportValidity(); // Triggers the popup message
                            if (isValid) {
                                input.focus(); // Focus only the first invalid field
                            }
                            isValid = false;
                        }
                    });

                    if (!isValid) {
                        e.preventDefault(); // Stop submission
                    }
                });
            });
        });
    </script>
    <?php
});
add_action('woocommerce_customer_save_address', 'custom_address_update_notice', 20, 2);
function custom_address_update_notice( $user_id, $load_address ) {
    if ( ! is_admin() ) {
        wc_add_notice( __( 'Your address has been updated successfully.', 'storefrontchild' ), 'success' );
    }
}