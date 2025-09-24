<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);
$customer = new WC_Customer($current_user->ID);
$settings = get_option( 'klaviyo_settings' );
$listId = isset($settings['klaviyo_newsletter_list_id']) ? $settings['klaviyo_newsletter_list_id'] : '';
$apiKey = get_option('klaviyo_api_key');
?>

<div class="account-header-wrapper">
    <section class="account-header customer_dashboard">
        <h2><?php echo __('My Account', 'storefrontchild'); ?></h2>
    </section>
</div>
<?php if (isset($_GET['message'])) : ?>
	<?php $message = sanitize_text_field($_GET['message']); ?>
	<div class="page-messages">
		<div class="message success"><?php echo $message; ?></div>
	</div>
<?php endif; ?>
<div class="account-intro dashboard">
	<div class="content-main">
		<div class="row">
			<div class="col-8 offset-2 col-sm-4 offset-sm-0 offset-lg-1 col-lg-3 offset-xl-2 col-xl-2">
				<div class="avatar-image">
					<img src="<?php echo get_theme_file_uri()?>/assets/images/avatar.webp" class="customer-avatar">
				</div>
			</div>
			<div class="col-12 col-sm-8 col-lg-7 col-xl-6">
				<div class="account-intro-main">
					<h3><?php echo __('Hello ', 'storefrontchild'); ?><?php echo $current_user->first_name; ?></h3>
					<p><?php echo __('Here you have the ability to view a snapshot of your recent account activity and update your account information. Select a link below to view or edit information.', 'storefrontchild'); ?></p>
				</div>
			</div>
		</div>
	</div>
	<div class="content-main">
		<div class="row">
			<div class="account-header-additional col-xl-8 offset-xl-2">
				<div class="block block-dashboard-info">
					<div class="block-title"><strong><?php echo __('Account Information', 'storefrontchild'); ?></strong></div>
					<div class="block-content">
						<div class="box box-information">
							<strong class="box-title"><span><?php echo __('Contact Information', 'storefrontchild'); ?></span> <a class="action edit" href="<?php echo wc_get_endpoint_url( 'edit-account' ); ?>"><span><?php echo __('Edit', 'storefrontchild'); ?></span></a></strong> 
							<div class="box-content">
								<p><?php echo esc_html( $current_user->first_name.' '.$current_user->last_name ); ?><br><?php echo esc_html( $current_user->user_email ); ?><br></p>
							</div>
							<div class="box-actions"><a href="<?php echo wc_get_endpoint_url( 'edit-account' ); ?>" class="action change-password"><?php echo __('Change Password', 'storefrontchild'); ?></a></div>
						</div>
						<?php if(isset($settings['klaviyo_newsletter_list_id']) && $apiKey!='') : ?>
							<div class="box box-newsletter">
								<strong class="box-title tool-tip-parent newsletter">
									<span>
									<?php echo __('Newsletters', 'storefrontchild'); ?>
										<div class="tool-tip"><span class="tooltip-icon"><i class="fa fa-question-circle"></i></span> <span class="tool-tiptext"><?php echo __('This section relates to our regular education email and targeted information related to your health and fitness goals?.
											You may withdraw this consent at any time by following the Unsubscribe in the email, emailing us OR updating your Newsletter preferences in your My Account section when logged in.
											We will process your data in accordance with our <a href="/privacy-policy/">Privacy Policy</a>.', 'storefrontchild'); ?> </span>
										</div>
									</span>
									<a class="action edit" href="<?php echo wc_get_endpoint_url( 'newsletter-subscription' ); ?>"><span><?php echo __('Edit', 'storefrontchild'); ?></span></a>
								</strong>
								<div class="box-content">
									<?php if(isSubscribed($current_user->user_email, $listId, $apiKey)) : ?>
										<p><?php echo __('You subscribe to "General Subscription".', 'storefrontchild'); ?></p>
									<?php else : ?>
										<p><?php echo __('You don\'t subscribe to our newsletter.', 'storefrontchild'); ?></p>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<section class="account-content-wrapper">
    <div class="content-main">
        <div class="row">
            <div class="col-xl-8 offset-xl-2 customer-account-edit-form">
                <div class="block block-dashboard-addresses">
                    <div class="block-title"><strong><?php echo __('Main Addresses', 'storefrontchild')?></strong></div>
                    <div class="block-content">
                        <div class="box box-billing-address">
                            <strong class="box-title"><span><?php echo __('Default Billing Address', 'storefrontchild')?></span></strong> 
                            <div class="box-content">
                                <address>
									<?php if($customer->get_billing_first_name() && $customer->get_billing_country() && $customer->get_billing_postcode() && $customer->get_billing_city() && $customer->get_billing_address_1()) : ?>
										<?php echo $customer->get_billing_first_name().' '.$customer->get_billing_last_name(); ?>
										<?php if($customer->get_billing_company()) {echo '<br>'.$customer->get_billing_company();} ?>
										<?php if($customer->get_billing_address_1()) {echo '<br>'.$customer->get_billing_address_1();} ?>
										<?php if($customer->get_billing_address_2()) {echo '<br>'.$customer->get_billing_address_2();} ?>
										<?php if($customer->get_billing_city()) {echo '<br>'.$customer->get_billing_city();} ?>
										<?php if($customer->get_billing_state()) {echo ', '.$customer->get_billing_state();} ?>
										<?php if($customer->get_billing_postcode()) {echo '<br>'.$customer->get_billing_postcode();} ?>
										<?php if($customer->get_billing_country()) {echo '<br>'.get_full_country_name($customer->get_billing_country());} ?>
										<?php if($customer->get_billing_phone()) {echo '<br>T: '.$customer->get_billing_phone();} ?>
									<?php else : ?>
										<?php echo __('You have not set a default billing address.', 'storefrontchild')?>
									<?php endif?>
                                </address>
                            </div>
                        </div>
                        <div class="box box-shipping-address">
                            <strong class="box-title"><span><?php echo __('Default Shipping Address', 'storefrontchild')?></span></strong> 
                            <div class="box-content">
                                <address>
									<?php if($customer->get_shipping_first_name() && $customer->get_shipping_country() && $customer->get_shipping_postcode() && $customer->get_shipping_city() && $customer->get_shipping_address_1()) : ?>
										<?php echo $customer->get_shipping_first_name().' '.$customer->get_shipping_last_name(); ?>
										<?php if($customer->get_shipping_company()) {echo '<br>'.$customer->get_shipping_company();} ?>
										<?php if($customer->get_shipping_address_1()) {echo '<br>'.$customer->get_shipping_address_1();} ?>
										<?php if($customer->get_shipping_address_2()) {echo '<br>'.$customer->get_shipping_address_2();} ?>
										<?php if($customer->get_shipping_city()) {echo '<br>'.$customer->get_shipping_city();} ?>
										<?php if($customer->get_shipping_state()) {echo ', '.$customer->get_shipping_state();} ?>
										<?php if($customer->get_shipping_postcode()) {echo '<br>'.$customer->get_shipping_postcode();} ?>
										<?php if($customer->get_shipping_country()) {echo '<br>'.get_full_country_name($customer->get_shipping_country());} ?>
										<?php if($customer->get_shipping_phone()) {echo '<br>T: '.$customer->get_shipping_phone();} ?>
									<?php else : ?>
										<?php echo __('You have not set a default shipping address.', 'storefrontchild')?>
									<?php endif?>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="dashboard-bottom ">
    <div class="final-banner">
        <h4><?php echo __('Ancient techniques - modern values', 'storefrontchild')?></h4>
        <p><?php echo __('The highest quality, health-giving oils<br>nature has to offer.', 'storefrontchild')?></p>
        <div class="actions"><a href="/" class="btn btn-default btn-green"><?php echo __('Shop Now', 'storefrontchild')?></a></div>
    </div>
</div>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
