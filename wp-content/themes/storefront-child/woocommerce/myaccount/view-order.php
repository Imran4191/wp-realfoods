<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

$notes = $order->get_customer_order_notes();
?>

<div class="account-header-wrapper order-history">
    <section class="account-header sales_order_details">
        <h2><?php echo __('My Order Information', 'storefrontchild'); ?></h2>
    </section>
</div>
<div class="account-intro">
    <div class="content-main">
        <div class="row">
            <div class="col-8 offset-2 col-sm-4 offset-sm-0 offset-lg-1 col-lg-3 offset-xl-2 col-xl-2">
                <div class="avatar-image">
                    <img src="<?php echo get_theme_file_uri()?>/assets/images/Previous_icon.svg" class="customer-avatar">
                </div>
            </div>
            <div class="col-sm-12 col-lg-7 col-xl-6">
                <div class="account-intro-main">
                    <h3><?php echo __('Review Or Re-order', 'storefrontchild'); ?></h3>
                    <p class="midium"><?php echo __("Want to review a previous order or perhaps just order the same thing again? All the details of the wonderful products you have ordered are below. Simply click on the 'view order' button, or the 'add to cart' button to order the same thing again. Remember you are able to have products delivered on a regular basis, just select the desired frequency on the product page.", "storefrontchild"); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="account-content-wrapper">
	<div class="content-main">
		<div class="row">
			<div class="col-xl-8 offset-xl-2 sales-order-view">
                <span class="order-status"><?php echo wc_get_order_status_name( $order->get_status() ); ?></span>
                <div class="order-date">
                    <span class="label"><?php echo __('Order Date:', 'storefrontchild'); ?></span>
                    <span><?php echo wc_format_datetime( $order->get_date_created(), 'd F Y' ); ?></span>
                </div>
                <div class="actions-toolbar order-actions-toolbar">
                    <div class="actions">
                        <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'order_again', $order->get_id() ) , 'woocommerce-order_again' ) ); ?>" class="action order"><span><?php echo __('Reorder', 'storefrontchild'); ?></span></a>
                        <?php if ($order->get_status()=='processing' || $order->get_status()=='completed') : ?>
                            <span class="print-invoice"><i class="fas fa-print"></i><?php echo '<a href="' . admin_url('admin-ajax.php?action=generate_pdf_invoice&order_id=' . $order_id) . '" class="button button-primary " target="_blank">' . __('Print Invoice', 'woocommerce') . '</a>'; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="block block-order-details-view">
                    <div class="block-title"><strong><?php echo __('Order Information', 'storefrontchild'); ?></strong></div>
                    <div class="order-increment-id">
                        <p style="font-weight: 700;margin-bottom: 25px;font-size: 18px;"><?php echo wp_kses_post(sprintf(__('Order #%1$s', 'storefrontchild'), $order->get_order_number())); ?></p>
                    </div>
                    <div class="block-content">
                        <div class="box box-order-shipping-address">
                            <strong class="box-title"><span><?php echo __('Shipping Address', 'storefrontchild'); ?></span></strong> 
                            <div class="box-content">
                                <address>
                                    <?php echo wp_kses_post( $order->get_formatted_shipping_address( esc_html__( 'N/A', 'woocommerce' ) ) ); ?>
                                    <?php if ( $order->get_shipping_phone() ) : ?>
                                        <p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_shipping_phone() ); ?></p>
                                    <?php endif; ?>
                                </address>
                            </div>
                        </div>
                        <div class="box box-order-shipping-method">
                            <strong class="box-title"><span><?php echo __('Shipping Method', 'storefrontchild'); ?></span></strong> 
                            <div class="box-content">
                                <p><?php echo wp_kses_post( $order->get_shipping_method() ); ?></p>
                            </div>
                        </div>
                        <div class="box box-order-billing-address">
                            <strong class="box-title"><span><?php echo __('Billing Address', 'storefrontchild'); ?></span></strong> 
                            <div class="box-content">
                                <address>
                                    <?php echo wp_kses_post( $order->get_formatted_billing_address( esc_html__( 'N/A', 'woocommerce' ) ) ); ?>
                                    <?php if ( $order->get_billing_phone() ) : ?>
                                        <p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_billing_phone() ); ?></p>
                                    <?php endif; ?>
                                </address>
                            </div>
                        </div>
                        <div class="box box-order-billing-method">
                            <strong class="box-title"><span><?php echo __('Payment Method', 'storefrontchild'); ?></span></strong> 
                            <div class="box-content">
                                <p><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php do_action( 'woocommerce_view_order', $order_id ); ?>
            </div>
        </div>
    </div>
</section>
