<?php
/**
 * Newsletter Subscription page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/newsletter-subscription.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

defined( 'ABSPATH' ) || exit;

$current_user = wp_get_current_user();
$email = $current_user->user_email;
require_once ABSPATH . 'wp-content/plugins/klaviyo/includes/blocks/StoreApi.php';
$storeApi = new WCK\Blocks\StoreApi();
$settings = get_option( 'klaviyo_settings' );
$listId = isset($settings['klaviyo_newsletter_list_id']) ? $settings['klaviyo_newsletter_list_id'] : '';
$apiKey = get_option('klaviyo_api_key');
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['is_subscribed'])) {
		$customer = new WC_Customer($current_user->ID);
	    $country = $customer->get_billing_country() ? $customer->get_billing_country() : '';
	    $phone = $customer->get_billing_phone() ? $customer->get_billing_phone() : '';

	    if (!empty($email)) {
	        // Attempt to subscribe the user to the Klaviyo list
	        $storeApi->send_consent_event($email, $phone, $country, 0, 1);
	        $redirectUrl = add_query_arg(array('message' => 'We have saved your subscription.'), wc_get_endpoint_url( 'my-account' ));
		    wp_redirect($redirectUrl);
		    exit;
	    }
	} else {
        $url = 'https://a.klaviyo.com/api/profile-subscription-bulk-delete-jobs/';

        $headers = array(
            'Authorization' => 'Klaviyo-API-Key ' . $apiKey,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Revision' => '2024-07-15',
        );

        $body = json_encode(array(
            "data" => array(
                "type" => "profile-subscription-bulk-delete-job",
                "attributes" => array(
                    "profiles" => array(
                        "data" => array(
                            array(
                                "type" => "profile",
                                "attributes" => array(
                                    "email" => $email
                                )
                            )
                        )
                    )
                ),
                "relationships" => array(
                    "list" => array(
                        "data" => array(
                            "type" => "list",
                            "id" => $listId
                        )
                    )
                )
            )
        ));

        $response = wp_remote_post($url, array(
            'headers' => $headers,
            'body' => $body,
        ));
		$redirectUrl = add_query_arg(array('message' => 'We have removed your newsletter subscription.'), wc_get_endpoint_url( 'my-account' ));
	    wp_redirect($redirectUrl);
	    exit;
	}
}
?>

<div class="account-header-wrapper newsletter">
    <section class="account-header newsletter">
        <h2><?php echo __('Newsletter Subscription', 'storefrontchild'); ?></h2>
    </section>
</div>
<div class="account-intro">
    <div class="content-main">
        <div class="row">
            <div class="col-8 offset-2 col-sm-4 offset-sm-0 offset-lg-1 col-lg-3 offset-xl-2 col-xl-2">
                <div class="avatar-image">
                    <img src="<?php echo get_theme_file_uri()?>/assets/images/avatar.webp" class="customer-avatar">
                </div>
            </div>
            <div class="col-sm-12 col-lg-7 col-xl-6">
                <div class="account-intro-main">
                    <h3><?php echo __('Hello ', 'storefrontchild'); ?><?php echo $current_user->first_name; ?></h3>
                    <p><?php echo __('Here you have the ability to view a snapshot of your recent account activity and update your account information. Select a link below to view or edit information.', 'storefrontchild'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="account-content-wrapper">
    <div class="content-main">
        <div class="row">
            <div class="col-xl-8 offset-xl-2 newsletter-edit-form">
                <form class="form form-newsletter-manage" method="post">
                    <fieldset class="fieldset">
                        <div class="label">
                            <legend class="legend"><span><?php echo __('Your Newsletter Subscription', 'storefrontchild'); ?></span></legend>
                        </div>
                        <div class="field choice">
                            <label for="subscription" class="checkbox">
                            	<?php if(isSubscribed($email, $listId, $apiKey) || isset($_POST['is_subscribed'])) : ?>
                                	<input type="checkbox" name="is_subscribed" id="subscription" value="1" title="General Subscription" checked="checked">
                                <?php else : ?>
                                	<input type="checkbox" name="is_subscribed" id="subscription" value="1" title="General Subscription">
                                <?php endif; ?>
                                <span class="rosita-input-box"></span>
                                <span class="agree-text"><?php echo __('Yes, I would like to receive promotions, special deals and the latest on real-food nutrition from Rosita Real Foods. <br>You may withdraw this consent at any time. Your privacy is important to us, see our <a href="/privacy-policy/"> privacy policy </a> for further information.', 'storefrontchild'); ?> </span>
                            </label>
                        </div>
                    </fieldset>
                    <fieldset class="fieldset">
                        <div class="actions-toolbar">
                            <div class="primary"><button type="submit" title="Save" class="action save primary with-chevron-small"><span><?php echo __('Save subscription', 'storefrontchild'); ?></span></button></div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</section>