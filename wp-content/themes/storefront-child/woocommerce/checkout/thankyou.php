<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-order">

	<?php
	if ( $order ) :

		//do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

            <section class="checkout-success-header">
                <div class="checkout-success-hero">
                    <img src="<?php echo get_theme_file_uri()?>/assets/images/thank_you.webp" alt="Thank you">
                    <h2><?php echo __('Your order is now being processed', 'storefrontchild'); ?></h2>
                </div>
            </section>
            <div class="checkout-success page-main">
                <p class="thank-msg"><?php echo ($order->payment_method == 'bacs') ? 'Thanks for your order. Please use the following details to complete your order via Bank transfer.' : 'Thanks for you order. We will send you an email once it\'s dispatched so you know when your health benefiting products will be arriving.'?></p>
                <div class="thankyou-page row">
                    <div class="sa-left col-lg-6">
                        <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id()) :?>
                            <p><?php echo sprintf(__('Your order number is: <a href="%1$s" class="order-number"><strong>#%2$s</strong></a>.', 'storefrontchild'), $order->get_view_order_url(), $order->get_order_number()); ?></p>
                        <?php  else :?>
                            <p><?php echo sprintf(__('Your order number is: <span>#%1$s</span>.', 'storefrontchild'), $order->get_order_number()); ?></p>
                        <?php endif;?>

                        <p>Email address used: <strong><?php echo $order->get_billing_email(); ?></strong></p>

                        <?php if ($order->payment_method == 'bacs') : ?>
                            <p><?php echo sprintf(__('Your order total is: <strong>%1$s</strong>.', 'storefrontchild'), $order->get_formatted_order_total()); ?></p>
                            <div class="bank-details">
                                <?php echo get_option('bank_details'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if(is_user_logged_in()): ?>
                            <span><?php echo __('In the meantime, check out your profile page!', 'storefrontchild') ?></span>
                            <p style="padding: 2.5rem 0;"><?php echo __('On this page you can view your collected points*, any orders, change your preferences and more.
                                You will also now be able to view additional product information on each product page.', 'storefrontchild') ?></p>
                            <a class="btn btn-default btn-green with-chevron checkout-sucees-btn" style="width: 100%;" href="<?php echo wc_get_page_permalink('myaccount');?>"><span><?php echo __("Take me to my profile"); ?></span></a>
                        <?php else: ?>
                            <?php
                                do_action( 'woocommerce_before_thankyou', $order->get_id() );
                            ?>
                        <?php endif; ?>
                    </div>
                    <div class="sa-right col-lg-6">
                        <img src="<?php echo get_theme_file_uri()?>/assets/images/macbook.webp"  alt="Macbook"/>
                    </div>
                </div>
            </div>

		<?php endif; ?>

	<?php else : ?>

		<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>

	<?php endif; ?>

</div>
