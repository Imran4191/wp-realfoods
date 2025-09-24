<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();
$customer = new WC_Customer($customer_id);

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'Billing address', 'woocommerce' ),
			'shipping' => __( 'Shipping address', 'woocommerce' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __( 'Billing address', 'woocommerce' ),
		),
		$customer_id
	);
}

$oldcol = 1;
$col    = 1;
?>
<div class="account-header-wrapper address-book">
    <section class="account-header customer_address_index" style="">
        <h1>My Saved Addresses</h1>
    </section>
    <div class="account-intro">
        <div class="container">
            <div class="row"></div>
            <div class="row">
                <div class="col-8 offset-2 col-sm-4 offset-sm-0 col-md-offset-1 col-md-3 offset-lg-2 col-lg-2">
                    <?php 
                        $image_url = get_stylesheet_directory_uri() . '/assets/images/Address_icon.svg'; // Dynamic image URL 
                    ?>
                    <div class="avatar-image"><img src="<?php echo $image_url ?>" alt="" class="customer-avatar"></div>
                </div>
                <div class="col-12 col-sm-8 col-md-7 col-lg-6">
                    <div class="account-intro--main">
                        <h3>My Online Black Book</h3>
                        <p>Most of us when shopping have multiple addresses we generally use, be it your home address, workplace or even friends and family. Here you can quickly and easily add or edit as many addresses as you like to help you with your shopping experience.</p>
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
               <div class="block-title">
                    <strong>Main Addresses</strong>
                    <br>
                <p>If you wish to change your default billing or shipping address, please add a new address to your address book first.</p>
                </div>
               <div class="block-content">
                        <div class="box box-billing-address">
                            <strong class="box-title">
                                <span><?php echo __('Default Billing Address', 'storefrontchild')?></span>
                                <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', 'billing' ) ); ?>" class="action edit"><span><?php echo $customer->get_billing_first_name() ? esc_html__( 'Edit', 'woocommerce' ) : esc_html__( 'Add', 'woocommerce' ); ?></span></a>
                            </strong> 
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
                            <strong class="box-title">
                                <span><?php echo __('Default Shipping Address', 'storefrontchild')?></span>
                                <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', 'shipping' ) ); ?>" class="action edit"><span><?php echo $customer->get_shipping_first_name() ? esc_html__( 'Edit', 'woocommerce' ) : esc_html__( 'Add', 'woocommerce' ); ?></span></a>
                            </strong> 
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

