<?php

   include get_stylesheet_directory() . '/email-templates-images.php';
?>

<div style="background-color: #ebebec; width: 100%;" id="email_template">
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
                                                    <table width="100%" cellpadding="25px">
                                                        <tbody>
                                                            <tr>
                                                                <td class="header" style="background-color: #fff; color: #ffffff; font-family: Helvetica, Arial, sans-serif !important;padding:0;">
                                                                    <table width="100%" cellpadding="25px">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td width="100%" style="padding:0px">
                                                                                    <img src="<?php echo $images['welcome'] ?>" width="100%">
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
                                                
                                                        <h1 style="font-family: Helvetica, Arial, sans-serif !important; color: #878787; font-size: 20px; text-align: left; font-weight: bold; text-transform: uppercase;">
                                                            <?php echo __("Dear {display_name}, "); ?>
                                                        </h1>
                                                        <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important;">
                                                            <?php echo __("Great news! After careful review of your application and documentation, we are delighted to inform you that your {user_role} account has been officially approved. Welcome aboard! "); ?>
                                                        </p>
                                                    
                                                        <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important;">
                                                            <?php echo __("What’s Next? "); ?><br>
                                                        </p>
                                                      
                                                        <p style="text-align: left; color: #878787; margin-top: 25px; font-family: Helvetica, Arial, sans-serif !important;">
                                                            <?php echo __("If you have questions regarding your membership, please visit our customer support:"); ?><br>
                                                        </p>
                                                        <ul style="padding: 0 60px;">

                                                            <li style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important;">
                                                                <span style="color: #878787;">
                                                                  <?php echo __("    Access Your Account: You can now access your account by logging in with your credentials. Explore our range of high-quality real food supplements and save with your {user_role} status. "); ?>
                                                                </span>
                                                            </li>

                                                            <li style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important;">
                                                                <span style="color: #878787;">
                                                                  <?php echo __("    Stay Informed: Join our Rosita email list for the latest updates, news and insights!  "); ?>
                                                                </span>
                                                            </li>
                                                        </ul>

                                                        <p style="text-align: left; color: #878787; margin-top: 25px; font-family: Helvetica, Arial, sans-serif !important;">
                                                            <?php echo __("Need Assistance? "); ?><br>
                                                        </p>
                                                        <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important;">
                                                            <?php echo __("Our Customer Service Team is here to ensure your experience with us is seamless and rewarding. If you have any questions or need assistance navigating your new account, please don’t hesitate to reach out. Simply reply to this email and we will get back to you as soon as possible. "); ?>
                                                        </p>
                                                        <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important;">
                                                            <?php echo __("Thank you for choosing Rosita Real Foods. We’re thrilled to have you as a member of our {user_role} community and look forward to serving you. "); ?>
                                                        </p>

                                                </td>
                                            </tr>

                                            <tr>
                                              <td style="padding: 30px 25px; text-align: center; background-color: white;">
                                                <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important;">
                                                  <?php echo __("Warm regards,"); ?><br>
                                                  

                                                </p>

                                                <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important;">
                                                  <?php echo __("Chrissy "); ?><br>
                                                
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
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

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
