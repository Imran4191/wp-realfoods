<?php
/**
 * Customer completed subscription change email
 *
 * @author  Brent Shepherd
 * @package WooCommerce_Subscriptions/Templates/Emails
 * @version 1.0.0 - Migrated from WooCommerce Subscriptions v2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<?php 
   include get_stylesheet_directory() . '/email-templates-images.php';
   ?>
<div style="background-color: #ebebec; width: 100%;">
   <table class="wrapper" width="100%">
      <tr>
         <td class="wrapper-inner" align="center" style="background-color: #ebebec; padding: 25px 0;">
            <table class="main" align="center" style="width:600px; max-width:600px;background:#fff">
               <tr>
                  <td class="main-content">
                     <table width="100%" style="max-width: 600px;background:#fff;">
                        <tbody>
                           <tr>
                              <td class="header" style="background-color: #08456b; color: #ffffff; font-family: Raleway, sans-serif;">
                                 <h1 style="color:#ffffff; font-size:30px; font-weight:300; line-height:150%; margin:0; text-align:center; padding: 2rem 0;">Subscription Cancelled</h1>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                     <table width="100%" style="max-width: 600px; text-align: center; background: #fff;">
                        <tr>
                           <td>
                                <?php /* translators: $1: customer's billing first name and last name */ ?>
								<p><?php printf( esc_html__( 'A subscription belonging to %1$s has been cancelled. Their subscription\'s details are as follows:', 'woocommerce-subscriptions' ), esc_html( $subscription->get_formatted_billing_full_name() ) );?></p>

								<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
									<thead>
										<tr>
											<th class="td" scope="col" style="text-align:left;"><?php esc_html_e( 'Subscription', 'woocommerce-subscriptions' ); ?></th>
											<th class="td" scope="col" style="text-align:left;"><?php echo esc_html_x( 'Price', 'table headings in notification email', 'woocommerce-subscriptions' ); ?></th>
											<th class="td" scope="col" style="text-align:left;"><?php echo esc_html_x( 'Last Order Date', 'table heading', 'woocommerce-subscriptions' ); ?></th>
											<th class="td" scope="col" style="text-align:left;"><?php echo esc_html_x( 'End of Prepaid Term', 'table headings in notification email', 'woocommerce-subscriptions' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="td" width="1%" style="text-align:left; vertical-align:middle;">
												<a style="color:#08456b;" href="<?php echo esc_url( wcs_get_edit_post_link( $subscription->get_id() ) ); ?>">#<?php echo esc_html( $subscription->get_order_number() ); ?></a>
											</td>
											<td class="td" style="text-align:left; vertical-align:middle;">
												<?php echo wp_kses_post( $subscription->get_formatted_order_total() ); ?>
											</td>
											<td class="td" style="text-align:left; vertical-align:middle;">
												<?php
												$last_order_time_created = $subscription->get_time( 'last_order_date_created', 'site' );
												if ( ! empty( $last_order_time_created ) ) {
													echo esc_html( date_i18n( wc_date_format(), $last_order_time_created ) );
												} else {
													esc_html_e( '-', 'woocommerce-subscriptions' );
												}
												?>
											</td>
											<td class="td" style="text-align:left; vertical-align:middle;">
												<?php echo esc_html( date_i18n( wc_date_format(), $subscription->get_time( 'end', 'site' ) ) ); ?>
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
									</tbody>
								</table>
								<br/>
								<?php

								do_action( 'woocommerce_subscriptions_email_order_details', $subscription, $sent_to_admin, $plain_text, $email );

								do_action( 'woocommerce_email_customer_details', $subscription, $sent_to_admin, $plain_text, $email );

								/**
								 * Show user-defined additional content - this is set in each email's settings.
								 */
								if ( $additional_content ) {
									echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
								}
								?>
                           </td>
                        </tr>
                     </table>      
                     <?php do_action( 'woocommerce_email_footer' ); ?>
            </table>
         </td>
      </tr>
   </table>
   </td>
   </tr>
   </table>
</div>

