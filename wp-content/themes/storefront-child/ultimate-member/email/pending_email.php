<?php

   include get_stylesheet_directory() . '/email-templates-images.php';
?>

<div style="background-color: #ebebec; width: 100%;" class="email_template">
    <table class="wrapper" width="100%">
        <tbody>
            <tr>
                <td class="wrapper-inner" align="center" style="background-color: #ebebec; padding: 25px 0;">
                    <table class="main" align="center" style="width:600px; max-width:600px;background:#fff">
                        <tbody>
                            <tr>
                                <td class="main-content">

                                    <table width="100%" style="max-width: 600px;background:#fff;">
                                        <tbody>
                                            <tr>
                                                <td class="header" style="background-color: #fff; color: #ffffff; font-family: Raleway, sans-serif;">
                                                    <table width="100%" cellpadding="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="header" style="background-color: #fff; color: #ffffff; font-family: Helvetica, Arial, sans-serif !important;padding:0;">
                                                                    <table width="100%" cellpadding="0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td width="100%" style="padding:0px">
                                                                                    <img src="<?php echo $images['pending_email'] ?>" width="100%">
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 0;">
                                                                    <table width="100%" cellpadding="0" style="background: #fff;">
                                                                        <tbody>
                                                                            <tr style="background: #fff; padding: 0 20px;">
                                                                                <td style="text-align: left;">
                                                                                    <a 
                                                                                    target="_blank" 
                                                                                    href="{site_url}/faq"
                                                                                    style="text-align: center; padding-left: 25px; color: #878787; font-size: 14px; font-family: Helvetica, Arial, sans-serif !important; margin: 0;text-transform: uppercase; text-decoration: none !important;">
                                                                                        <?php echo __("FAQs"); ?>
                                                                                    </a>
                                                                                </td>
                                                                                <td style=" text-align: center;">
                                                                                    <a target="_blank" href="{site_url}" style="text-align: center; color: #878787; font-size: 14px; font-family: Helvetica, Arial, sans-serif !important; margin: 0;text-transform: uppercase; text-decoration: none !important;">
                                                                                        <?php echo __("SHOP"); ?>
                                                                                    </a>
                                                                                    <span style="color: #000;font-size: 14px; font-family: Helvetica, Arial, sans-serif !important;margin-left:5px;">
                                                                                    </span>
                                                                                </td>
                                                                                <td style=" text-align: right;">
                                                                                    <a target="_blank" href="{site_url}/login" style="text-align: center; padding-right: 25px; color: #878787; font-size: 14px; font-family: Helvetica, Arial, sans-serif !important; margin: 0;text-transform: uppercase; text-decoration: none !important;">
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

                                    <table width="100%" style="max-width: 600px;background:#fff;">
                                        <tbody>
                                            <tr>
                                                <td style="padding: 30px 25px; text-align: center; background-color: white;">
                                                
                                                        <h3 style="font-family: Helvetica, Arial, sans-serif !important; color: #878787; font-size: 20px; text-align: left; font-weight: bold; text-transform: uppercase;">
                                                            <?php echo __("Dear {display_name},"); ?> 
                                                          
                                                        </h3>
 
                                                        <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important;">

                                                        <?php echo __("Thank you for signing up for our {user_role} account at Rosita Real Foods. We are thrilled to welcome you to our community and look forward to serving your needs! "); ?>

                                                        </p>
                                                        <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important;">
                                                            <?php echo __("We are currently reviewing your account details to ensure that we provide you with the most suitable offerings and support tailored to your unique requirements. This process is part of our commitment to maintaining a secure and efficient service for all our members."); ?>
                                                        </p>
                                                     
                                                   
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding: 30px 25px; text-align: center; background-color: white;">
                                                
                                                  <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important;">
                                                    <?php echo __("What Happens Next? "); ?>
                                                  </p>

                                                    <ul style="padding: 0 60px;">
                                                        <li style="color: #000; text-align: left; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important;">
                                                            <span style="color: #878787;">
                                                                <?php echo __("Review Process: Our team is carefully reviewing your application. This process typically takes [1-2 business days], as we verify the information provided and ensure compliance with our guidelines. "); ?>
                                                            </span>
                                                        </li>
                                                        <li style="color: #000; text-align: left; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important;">
                                                            <span style="color: #878787;"><?php echo __("Notification: Once the review is complete, you will receive an email notification regarding the status of your account. This will confirm whether your account has been approved or if there are any further steps required. "); ?></span>
                                                        </li>
                                                    
                                                    </ul>
                                                     
                                                </td>  
                                         
                                            </tr>

                                            <tr>
                                                <td style="padding: 30px 25px; text-align: center; background-color: white;">
                                                
                                                  <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important;">
                                                    <?php echo __("In the Meantime:"); ?>
                                                  </p>

                                                    <ul style="padding: 0 60px;">
                                                        <li style="color: #000; text-align: left; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important;">
                                                            <span style="color: #878787;">
                                                                <?php echo __("    Feel free to explore our website and familiarise yourself with our range of high-quality real food supplements available at Rosita Real Foods. "); ?>
                                                            </span>
                                                        </li>
                                                        <li style="color: #000; text-align: left; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important;">
                                                            <span style="color: #878787;">
                                                            <?php echo __("Should you have any questions or require immediate assistance, our customer support team is here to help."); ?>
                                                            </span>
                                                        </li>
                                                    
                                                    </ul>  
                                                   
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td style="padding: 30px 25px; text-align: center; background-color: white;">
                                                    <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important;">
                                                        <?php echo __("We appreciate your patience and understanding as we complete this essential step in setting up your {user_role} account. Your trust and security are our top priorities, and we are committed to ensuring a seamless experience for you."); ?>
                                                    </p>

                                                    <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important;">
                                                        <?php echo __("Thank you for choosing Rosita Real Foods. We’re excited to have you with us and look forward to supporting you every step of the way. "); ?>
                                                    </p>
                                                </td>
                                            </tr>
                                           
                                            <tr>
                                                <td style="padding: 30px 25px; text-align: center; background-color: white;">
                                                    <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important;">
                                                        <?php echo __("Warm regards,"); ?>
                                                    </p>
                                                    <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important;">
                                                        <?php echo __("Chrissy"); ?>
                                                    </p>
                                                </td>
                                            </tr>
                                              <tr>
                                                <td style="padding: 30px 25px; text-align: center; background-color: white;">
                                                    <p style="text-align: left; color: #878787; margin-top: 25px; font-family: Helvetica, Arial, sans-serif !important;">
                                                            <?php echo __(" Please do not reply to this email, as this inbox is not monitored."); ?><br>
                                                           

                                                    </p>
                                                    <p style="text-align: left; color: #878787; margin-top: 25px; font-family: Helvetica, Arial, sans-serif !important;">
                                                            
                                                           If you need assistance, kindly contact us using this 
                                                           <a href="{site_url}/contact" target="_blank">link </a>
                                                            or the button below.

                                                     </p>


                                                <table width="100%" cellpadding="0" align="center" style="margin-top: 25px;">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="margin-bottom: 2.5rem; text-transform: uppercase; font-family: Helvetica, Arial, sans-serif !important; font-weight: bold; padding: 15px; display: block; width: 450px; margin: 0 auto; background-color: #00b1aa; text-align: center; border-radius: 5px;">
                                                                        <a style="color: #ffffff; text-decoration: none;" href="{site_url}/contact" target="_blank"><?php echo __("CUSTOMER SUPPORT"); ?></a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>


                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>

                                    <table width="100%" style=" max-width: 600px; background: #fff; font-family: Helvetica, Arial, sans-serif !important;">
                                      <tbody>
                                        <tr>
                                            <td>
                                            <img
                                            src="<?php echo $images['strip']; ?>"
                                            width="100%"
                                            />
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
									
                                   {custom_email_footer}
                                   
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</div>
