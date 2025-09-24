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
                                                         <img src="<?php echo $images['refund-header'] ?>" width="100%">
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
                            <tr class="email-information">
                            <td style="padding: 0px 25px; text-align: center; background-color: white;">
                                <p style="text-align: left; margin:1em 0; font-size: 16px; color: #878787; font-family: Helvetica, Arial, sans-serif !important;">This is an email to notify you of your refund with Rosita Real Foods</p>
                            <table class="order-details" width="100%" style="font-family: Helvetica, Arial, sans-serif !important;">
                                    <tr>
                                        <td class="address-details" width="50%" style="text-align: left;vertical-align: top;">
                                            <h3 style="color: #878787; text-transform: uppercase; padding-top: 20px; text-align: left; font-family: Helvetica, Arial, sans-serif !important;">Billing To</h3>
                                            <p style="text-align: left;margin:1em 0;font-size: 16px; color: #878787;">
                                            <?php echo $order->get_formatted_billing_address(); ?>
                                            <br>
                                            T: <?php echo $order->get_billing_phone(); ?>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="method-info" width="50%" valign="top" style="vertical-align:top; text-align: left;font-size: 14px;font-family: Helvetica, Arial, sans-serif !important;" >
                                            <h3 style="color: #878787; text-transform:uppercase; text-align:left; margin-top:1em">Payment Method</h3>
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
                    </table>
                    <table width="100%" style="background-color: #ffffff; max-width: 600px;">
                        <tr>
                        <td>
                        <table class="button" border="0" cellspacing="0" cellpadding="0" style="background-color: #05b1a9;" align="center">
                            <tr>
                                <td style="padding:0px 25px; text-align: center; background-color: white;">
                                    <table width="100%" cellpadding="0" align="center" style="margin:40px 0 15px; text-align: center; font-family: Helvetica, Arial, sans-serif !important;" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="margin-bottom: 2.5rem; text-transform: uppercase; font-family: Helvetica, Arial, sans-serif !important; font-weight: bold; padding: 15px; display: block; width: 450px; margin: 0 auto; background-color: #00b1aa; text-align: center; border-radius: 5px;">
                                                    <a style="color: #ffffff; text-decoration: none;" href="<?php echo esc_url( home_url( '/' ) ); ?>">SHOP OUR FULL RANGE OF HANDCRAFTED PRODUCTS   </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        </td>
                        </tr>
                         <tr>
                                                <td style=" text-align: center; background-color: white;padding: 0px 25px; ">
                                                    <p style="text-align: left; color: #878787; margin-top: 25px; font-family: Helvetica, Arial, sans-serif !important;">
                                                            <?php echo __(" Please do not reply to this email, as this inbox is not monitored."); ?><br>
                                                           

                                                        </p>
                                                        <p style="text-align: left; color: #878787; margin-top: 25px; font-family: Helvetica, Arial, sans-serif !important;">
                                                            
                                                           If you need assistance, kindly contact us using this 
                                                           <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" target="_blank">link </a>
                                                            or the button below.

                                                        </p>
                                                        <table width="100%" cellpadding="0" align="center" style="margin-top: 25px; margin-bottom:25px;">
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