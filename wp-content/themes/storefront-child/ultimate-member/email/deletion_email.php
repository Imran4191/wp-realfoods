<?php

 include get_stylesheet_directory() . '/email-templates-images.php';
/**
 * Template for the "Account Deleted Email".
 * Whether to send the user an email when his account is deleted.
 *
 * This template can be overridden by copying it to {your-theme}/ultimate-member/email/deletion_email.php
 *
 * @version 2.6.1
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div style="background-color: #ebebec; width: 100%;">
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
                                                                                    <img src="<?php echo $images['account-deletion'] ?>" width="100%">
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

                                    <table width="100%" style="background: #fff; font-family: Helvetica, Arial, sans-serif !important;">
                                        <tbody>
                                            <tr>
                                                <td style="padding: 30px 25px; text-align: center; background-color: white;">
												
														<p style="font-family: Helvetica, Arial, sans-serif !important; text-align: left; font-size: 16px; color: #878787;"> 
															<?php echo __("We are sorry to see you go."); ?>
														</p>
														<p style="font-family: Helvetica, Arial, sans-serif !important; text-align: left; font-size: 16px; color: #878787;"> 
															<?php echo __("Based on your request, we have now successfully deleted or anonymised your personal data from our website."); ?>
														</p>

														<p style="font-family: Helvetica, Arial, sans-serif !important; text-align: left; margin-bottom: 20px; font-size: 16px; color: #878787;"> 
															<?php echo __("If you have questions regarding this email or if you did not request this, please contact our customer support."); ?>
														</p>
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
