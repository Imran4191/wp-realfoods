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
                                 <h1 style="color:#ffffff; font-size:30px; font-weight:300; line-height:150%; margin:0; text-align:center; padding: 2rem 0;">Your renewal order is complete</h1>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                     <table width="100%" style="max-width: 600px; text-align: center; background: #fff;">
                        <tr>
                           <td>
                                <?php /* translators: %s: Customer first name */ ?>
                                <p style="text-align: left;"><?php printf( esc_html__( 'Hi %s,', 'woocommerce-subscriptions' ), esc_html( $order->get_billing_first_name() ) ); ?></p>
                                <p style="text-align: left;"><?php esc_html_e( 'We have finished processing your subscription renewal order.', 'woocommerce-subscriptions' ); ?></p>
                                                                <br/>
                                <?php
                                    do_action( 'woocommerce_subscriptions_email_order_details', $order, $sent_to_admin, $plain_text, $email );

                                    do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

                                    do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

                                    /**
                                     * Show user-defined additional content - this is set in each email's settings.
                                     */
                                    if ( $additional_content ) {
                                        echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
                                    }
                                ?>
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
                     <?php do_action( 'woocommerce_email_footer' ); ?>
            </table>
         </td>
      </tr>
   </table>
   </td>
   </tr>
   </table>
</div>


