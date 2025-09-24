<?php
/**
 * Customer invoice email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-invoice.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php include get_stylesheet_directory() . '/email-templates-images.php';  ?>
<table width="100%" style="max-width: 600px;background-color: #fff;">
    <tr>
        <td class="header" style='background-color: #08456b; color: #ffffff; font-family: Helvetica, Arial, sans-serif;'>
            <table width="100%" cellpadding="25px">
                <tr>
                    <td width="50%" style="padding:25px">
                        <h2 style='margin: 0; color: #ffffff; font-family: Helvetica, Arial, sans-serif; font-size: 30px;line-height: 33px;'>Invoice</h2>
                        <span style="float:left;color:#fff;font-family: Helvetica, Arial, sans-serif; font-weight: normal; font-size: 20px; display: block;">
                            <?php print('#'.$order->get_order_number()); ?>
                        </span>
                    <td width="50%" align="right" valign="middle" style="padding:25px">
                        <a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<img src="<?php echo $images['email-logo'] ?>" alt="Rosita Real Foods" width="125">
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr class="email-summary" style="background-color: white;">
        <td style="padding: 30px 25px; text-align: center; background-color: white;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;">
            <table class="order-details" width="100%">
                <tr>
                    <td class="address-details" width="50%" style="text-align: left;vertical-align: top;">
                        <h3 style="color: #000000; text-transform: uppercase; text-align: left;">Billing Info</h3>
                        <p style="text-align: left;font-size: 16px;margin:1em 0;">
							<?php echo $order->get_formatted_billing_address(); ?>
                            <br>
                            T: <?php echo $order->get_billing_phone(); ?>
						</p>
                    </td>
                </tr>
                <tr>
                    <td class="x_method-info" width="50%" style="text-align:left; font-size:14px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; vertical-align:top">
                        <h3 style="color:#000000; text-transform:uppercase; text-align:left; margin-top:1em">Payment Method</h3>
                        <dl class="x_payment-method">
                            <dt class="x_title" style="color: #878787;"><?php echo $order->get_payment_method_title(); ?></dt>
                            <?php if ( $order->get_payment_method() === 'bacs' ) : ?>
                                <?php echo do_shortcode('[xyz-ips snippet="bank-instruction"]'); ?>
                            <?php endif; ?>
                        </dl>
                    </td>
                </tr>
            </table>

        </td>
    </tr>

    <tr>
        <td style="background-color: #fff;padding-bottom: 20px;">
			<?php do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email ); ?>

        </td>
    </tr>
     <tr>
                                                <td style="padding: 30px 25px; text-align: center; background-color: white;">
                                                    <p style="text-align: left; color: #878787; margin-top: 25px; font-family: Helvetica, Arial, sans-serif !important;">
                                                            <?php echo __(" Please do not reply to this email, as this inbox is not monitored."); ?><br>
                                                           

                                                        </p>
                                                        <p style="text-align: left; color: #878787; margin-top: 25px; font-family: Helvetica, Arial, sans-serif !important;">
                                                            
                                                           If you need assistance, kindly contact us using this 
                                                           <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" target="_blank">link </a>
                                                            or the button below.

                                                        </p>
                                                        <table width="100%" cellpadding="0" align="center" style="margin-top: 25px;">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="margin-bottom: 2.5rem; text-transform: uppercase; font-family: Helvetica, Arial, sans-serif !important; font-weight: bold; padding: 15px; display: block; width: 450px; margin: 0 auto; background-color: #00b1aa; text-align: center; border-radius: 5px;">
                                                                        <a 
                                                                        style="color: #ffffff; text-decoration: none;" href="<?php echo esc_url( home_url( '/contact' ) ); ?> " target="_blank"><?php echo __("CUSTOMER SUPPORT"); ?></a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                </td>
                                    </tr>
    <tr style="background-color: white;">
         <td style="padding: 12px 25px 25px 25px; text-align: center; background-color: white; border-bottom: 4px solid #08456b;">
              <br>
            <img src="<?php echo $images['email-footer'] ?>" alt="Rosita Real Foods" width="125">
            <p style="text-align: center; font-family: Helvetica, Arial, sans-serif; color: #434343; font-size: 12px;">The highest quality, health-giving oils nature has to offer.</p>
        </td>
    </tr>
</table>