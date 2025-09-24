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
                              <td class="header" style="background-color: #fff; color: #ffffff; font-family: Raleway, sans-serif;">
                                 <table width="100%" cellpadding="25px">
                                    <tbody>
                                       <tr>
                                          <td class="header" style="background-color: #fff; color: #ffffff; font-family: Helvetica, Arial, sans-serif !important;padding:0;">
                                             <table width="100%" cellpadding="25px">
                                                <tbody>
                                                   <tr>
                                                      <td width="100%" style="padding:0px">
                                                         <img src="<?php echo $images['order-confirmation'] ?>" width="100%">
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style="padding: 0;">
                                             <table width="100%" cellpadding="25px" style="background: #fff;">
                                                <tbody>
                                                   <tr style="background: #fff; padding: 0 20px;">
                                                      <td style="text-align: left;">
                                                         <a 
                                                            target="_blank" 
                                                            href="<?php echo esc_url( home_url( '/faq' ) ); ?>"
                                                            style="text-align: center; padding-left: 25px; color: #878787; font-size: 14px; font-family: Helvetica, Arial, sans-serif !important; margin: 0;text-transform: uppercase; text-decoration: none !important;">
                                                         <?php echo __("FAQs"); ?>
                                                         </a>
                                                      </td>
                                                      <td style=" text-align: center;">
                                                         <a target="_blank" href="<?php echo esc_url( home_url( '/' ) ); ?>" style="text-align: center; color: #878787; font-size: 14px; font-family: Helvetica, Arial, sans-serif !important; margin: 0;text-transform: uppercase; text-decoration: none !important;">
                                                         <?php echo __("SHOP"); ?>
                                                         </a>
                                                         <span style="color: #000;font-size: 14px; font-family: Helvetica, Arial, sans-serif !important;margin-left:5px;">
                                                         </span>
                                                      </td>
                                                      <td style=" text-align: right;">
                                                         <a target="_blank" href="<?php echo esc_url( home_url( '/login' ) ); ?>" style="text-align: center; padding-right: 25px; color: #878787; font-size: 14px; font-family: Helvetica, Arial, sans-serif !important; margin: 0;text-transform: uppercase; text-decoration: none !important;">
                                                         <?php echo __("LOGIN"); ?>
                                                         </a>
                                                         <span style="color: #000;font-size: 14px; font-family: Helvetica, Arial, sans-serif !important;margin-left:5px;"></span>
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
                     </table>
                     <table width="100%" style="max-width: 600px; text-align: center; background: #fff;">
                        <tr>
                           <td>
                              <?php $orderNumber = $order->get_order_number(); ?>
                              <?php echo '<span style="font-family: Helvetica, Arial, sans-serif !important; font-weight: normal; font-size: 20px; display: block; color:#05b1a9;">#' . $orderNumber . '</span>'; ?>
                           </td>
                        </tr>
                     </table>
                     <table width="100%" style="background-color: #ffffff; max-width: 600px;">
                        <tr>
                           	<td style="padding: 30px 25px; text-align: left; background-color: white;">
								<h3 style="text-align: left; font-family: Helvetica, Arial, sans-serif !important; font-size: 20px; color: #05b1a9;">Thank you for shopping with us, <?php echo $order->get_billing_first_name(); ?>!</h3>
								<p style="text-align: left; color: #878787;">
									We have received your order and you will receive an email shortly with your tracking details.
								</p>
								<p style="text-align: left; color: #878787;">
									Please use the following details along with your order number.
								</p>
								<?php if (is_user_logged_in()) : ?>
									<p style="text-align: left; color: #878787;">
                                    	You can also <a href="<?php echo esc_url( home_url( '/login' ) ); ?>" style="text-decoration:underline;">log in to your account</a> to view the order details.
                                  	</p>
								<?php endif; ?>
								<p style="text-align: left; color: #878787;">
									Our account details for bank transfer orders are:
								</p>
								<br>
								<?php echo do_shortcode('[xyz-ips snippet="bank-details"]'); ?>
								<?php if ( ! is_user_logged_in() ):?>
									<p style="font-family: Helvetica, Arial, sans-serif !important; padding-top: 15px; font-size: 14px; color: #878787; text-align: left;">To make your next order easier and quicker, create an account with us: </p>
									<br>
									<table width="100%" cellpadding="0" align="center">
										<tr>
											<td style="margin-bottom: 2.5rem; text-align: center; text-transform: uppercase; font-family: Helvetica, Arial, sans-serif !important; font-weight: bold; padding: 15px; display: block; width: 450px; margin: 0 auto; background-color: #00b1aa; text-align: center; border-radius: 5px;">
											<a style="color: #ffffff; text-decoration: none;" href="<?php echo esc_url( home_url( '/register' ) ); ?>"> CREATE AN ACCOUNT </a>
											</td>
										</tr>
									</table>
								<?php endif; ?>
								<h3 style="font-size: 16px; color: #878787; font-weight: bold; text-align: left; padding-top: 35px;">If you have any questions regarding this order, use the button below.</h3>
								<table width="100%" cellpadding="0" align="center" style="margin:40px 0 15px; text-align: center;" cellpadding="0" cellspacing="0">
									<tr>
									<td style="margin-bottom: 2.5rem; text-transform: uppercase; font-family: Helvetica, Arial, sans-serif !important; font-weight: bold; padding: 15px; display: block; width: 450px; margin: 0 auto; background-color: #00b1aa; text-align: center; border-radius: 5px;">
										<a style="color: #ffffff; text-decoration: none;" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">CONTACT US</a>
									</td>
									</tr>
								</table>
                           </td>
                        </tr>
                     </table>
                     <table width="100%" style="max-width: 600px; background:#fff;padding: 20px 25px; font-family: Helvetica, Arial, sans-serif !important; border-top: 1px solid #05b1a9; border-bottom: 1px solid #05b1a9;">
                        <tr class="email-summary">
                           <td style="padding: 0; color: #878787;">
                              <?php $orderNumber = $order->get_order_number(); ?>
                              <h1 style="margin: 0; color: #878787; padding: 0; font-weight:bold; text-align: left; font-size: 16px;">ORDER ID: <span class="no-link" style="font-weight:normal;"><?php echo $orderNumber; ?></span></h1>
                              <strong style="color: #878787;">Payment method: </strong>
                              <?php echo $order->get_payment_method_title(); ?>
                           </td>
                        </tr>
                     </table>
                     <table width="100%" style="max-width: 600px; background:#fff;padding: 20px 25px;margin-top: 5px; border-top: 1px solid #05b1a9; border-bottom: 1px solid #05b1a9; font-family: Helvetica, Arial, sans-serif !important;">
                        <tr>
                           <td>
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
                     </table>
                     <table width="100%" style="max-width: 600px; background: #fff; font-family: Helvetica, Arial, sans-serif !important;">
                        <tbody>
                           <tr>
                              <td>
                                 <img src="<?php echo $images['strip']; ?>" width="100%"/>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                     <table width="100%" style="max-width: 600px; background: #fff; font-family: Helvetica, Arial, sans-serif !important;">
                        <tbody>
                           <tr>
                              <td>
                                 <img src="<?php echo $images['nature']; ?>" width="100%" style="margin: 20px 0;">
                              </td>
                           </tr>
                        </tbody>
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