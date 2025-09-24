<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
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

defined( 'ABSPATH' ) || exit;

$text_align = is_rtl() ? 'right' : 'left';

do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>

<table class="email-items" width="100%">
        <thead>
            <tr>
                <th class="item-info" style="background-color: #08456b; color: #ffffff; font-family: Helvetica, Arial, sans-serif; font-size: 1.2rem; font-weight: lighter; text-align: left; padding: 5px 20px;">
                    <?= /* @escapeNotVerified */  __('Items'); ?>
                </th>
                <th class="item-qty" style="background-color: #08456b; color: #ffffff; font-family: Helvetica, Arial, sans-serif; font-size: 1.2rem; font-weight: lighter; padding: 5px 20px;">
                    <?= /* @escapeNotVerified */  __('Qty'); ?>
                </th>
                <th class="item-price" style="background-color: #08456b; color: #ffffff; font-family: Helvetica, Arial, sans-serif; font-size: 1.2rem; font-weight: lighter; padding: 5px 20px;">
                    <?= /* @escapeNotVerified */  __('Price'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
		<?php
			echo wc_get_email_order_items( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$order,
				array(
					'show_sku'      => $sent_to_admin,
					'show_image'    => false,
					'image_size'    => array( 32, 32 ),
					'plain_text'    => $plain_text,
					'sent_to_admin' => $sent_to_admin,
				)
			);
			?>
        </tbody>
        <tfoot class="order-totals">
		<?php 
			$padding1 = '5px 10px'; $padding2 = '5px 20px';
			$bgcolor='';
			 echo wp_kses_post( $total['label'] );

			if ( wp_kses_post( $total['label'] ) == 'Subtotal:') { $padding1 = '10px 10px 10px 20px'; $padding2 = '10px 20px 10px 20px'; }
			if ( wp_kses_post( $total['label'] ) == 'Grand Total:') { $padding1 = '10px 10px 12px 20px; border-right:0 !important;color: white !important'; 

			$padding2 = '10px 20px 10px 20px; color: white !important;border-right:0 !important;'; 
			$bgcolor="bgcolor='#6D6E72'"; }
		 ?>
			<?php
			$item_totals = $order->get_order_item_totals();


				if ( $item_totals ) {
					$i = 0;
					foreach ( $item_totals as $total ) {
						$i++;
						?>
						<tr>
							<?php if ( wp_kses_post( $total['label'] ) == 'Grand Total:'): ?>
								<th colspan="2" scope="row" bgcolor="#6D6E72" style="color:#fff; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size:15px; text-align: right; padding: <?php echo $padding1; ?>;"><?php echo wp_kses_post( $total['label'] ); ?></th>
								<td align='right' bgcolor="#6D6E72"  style="color:#fff; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:15px; text-align: right; padding: 10px 20px;"<?php echo $bgcolor; ?>>
								<?php echo wp_kses_post( $total['value'] ); ?>
							<?php else: ?>
								<th colspan="2" scope="row" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size:15px; text-align: right; padding: <?php echo $padding1; ?>;" <?php echo $bgcolor; ?>><?php echo wp_kses_post( $total['label'] ); ?></th>
								<td align='right' style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:15px; text-align: right; padding: 10px 20px;"<?php echo $bgcolor; ?>>
								<?php echo wp_kses_post( $total['value'] ); ?>
							<?php endif; ?>
							
							</td>
						</tr>
						<?php
					}
				}?>
        </tfoot>
    </table>

<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>
