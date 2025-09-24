<?php

   include get_stylesheet_directory() . '/email-templates-images.php';
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
                                        
                                        <table width="100%" style="background: #fff; font-family: Helvetica, Arial, sans-serif !important;">
                                            <tr>
                                                <td style="padding: 30px 25px; text-align: left; background-color: white;">
                                                    <p
                                                        style="text-align: left; color: #878787; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important; margin: 0 0 0.5em;">
                                                        Your practitioner account has been approved! You should now see practitioner pricing once
                                                        you log back in to our website.
                                                    </p>
                                                    <table cellpadding="0" align="center" style="margin-top: 20px;">
                                                        <tr>
                                                            <td
                                                                style="margin-bottom: 2.5rem; text-transform: uppercase; font-family: Helvetica, Arial, sans-serif !important; font-weight: bold; padding: 15px; display: block; width: 450px; margin: 0 auto; background-color: #00b1aa; text-align: center; border-radius: 5px; padding-top: 15px; padding-bottom: 15px;">
                                                                <a style="color: #ffffff; text-decoration: none;" href="{site_url}/login">LOG IN TO YOUR ACCOUNT</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <br>
                                                    <p
                                                        style="text-align: left; color: #878787; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important; margin: 0 0 1.5em;">
                                                        Can't remember your password? You can reset it by clicking the link below:
                                                    </p>
                                                    <table cellpadding="0" align="center" style="margin-top: 10px;">
                                                        <tr>
                                                            <td
                                                                style="margin-bottom: 2.5rem; text-transform: uppercase; font-family: Helvetica, Arial, sans-serif !important; font-weight: bold; padding: 15px; display: block; width: 450px; margin: 0 auto; background-color: #00b1aa; text-align: center; border-radius: 5px;">
                                                                <a style="color: #ffffff; text-decoration: none;"
                                                                    href="{site_url}/password-reset">Forgot Password</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <br><br>
                                                    <h3 style="text-align: left; color: #878787; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important; margin: 0 0 0.5em;">PRACTITIONER CLIENT ACCESS</h3>
                                                    <p
                                                        style="text-align: left; color: #878787; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important; margin: 0 0 0.5em; margin: 0 0 0.5em;">
                                                        To connect your clients to your practitioner account, follow the simple steps below:
                                                    </p>
                                                    <br>
                                                    <p
                                                        style="font-weight: bold; padding:0; margin: 0; text-align: left; color: #878787; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important; margin: 0 0 0.5em; margin: 0 0 0.5em;">
                                                        1. If your client is new to Rosita Real Foods:</p>
                                                    <p
                                                        style="text-align: left; color: #878787; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important; margin: 0 0 0.5em;">
                                                        - Your client will first need to register as a practitioner client on our <a
                                                            href="{site_url}/register">sign up page</a>. After this is done, go
                                                        to step 2.
                                                    </p>
                                                    <br>
                                                    <p
                                                        style="font-weight: bold; padding:0; margin: 0; text-align: left; color: #878787; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important; margin: 0 0 0.5em; margin: 0 0 0.5em;">
                                                        2. If your client is an existing Rosita Real Foods customer:</p>
                                                    <p
                                                        style="text-align: left; color: #878787; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important; margin: 0 0 0.5em;">
                                                        - After logging in to their account, please ask your client to go to “My Account”. Then, on
                                                        the “Practitioner Info” tab, they can select “Link Account”. Here, they should enter your
                                                        Name and Practitioner Code which is below.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>

                                        <table width="100%" style="max-width: 600px; font-family: Helvetica, Arial, sans-serif !important;">
                                            <tr class="email-summary">
                                                <td style="padding: 10px 25px 25px 10px;  background-color: white;">
                                                    <h3
                                                        style="text-align: center; color: #878787; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important;">
                                                        Your Practitioner Name: {display_name}</h3>
                                                    <h3
                                                        style="text-align: center; color: #878787; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important;">
                                                        Your Code: {customer_id}</h3>
                                                </td>
                                            </tr>
                                        </table>

                                        <table width="100%" style="background: #fff; font-family: Helvetica, Arial, sans-serif !important;">
                                            <tr>
                                                <td style="padding: 0px 0px; text-align: left; background-color: white;">
                                                    <p
                                                        style="text-align: center; color: #878787; padding: 0px 25px; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important; margin: 0 0 0.5em;">
                                                        If the account has been successfully linked, you can log in and go to the “My Account”
                                                        section and select “Practitioner Info”. Your clients that are linked to your account will be
                                                        shown, and you can also see what they have ordered.
                                                    </p>
                                                    <p
                                                        style="text-align: left; color: #878787; padding: 0px 25px; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important; margin: 0 0 0.5em;">
                                                        If you have any queries or issues please <a href="{site_url}/contact">get back in
                                                            touch.</a><br>
                                                        We look forward to working with you.
                                                    </p>
                                                   <p
                                                        style="text-align: left; color: #878787; padding: 0px 25px; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important; margin: 0 0 0.5em;">
                                                        Please do not reply to this email, as this inbox is not monitored.
                                                    </p>
                                                     <p
                                                        style="text-align: left; color: #878787; padding: 0px 25px; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important; margin: 0 0 0.5em;">
                                                       
                                         
                                                           If you need assistance, kindly contact us using this 
                                                           <a href="{site_url}/contact" target="_blank">link </a>
                                                            or the button below.
                                                    </p>
                                                    <table width="100%" cellpadding="0" align="center" style="margin-top: 25px; margin-bottom:25px;">
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