<?php 
    include get_stylesheet_directory() . '/email-templates-images.php';
    $order_id = $order->get_id();
    $orderNumber = $order->get_order_number();
    $order = wc_get_order($order_id);
    $serialized_data = $order->get_meta('warehouse_data');
    $data = unserialize($serialized_data);
    $trackingNumber = $data['tracking_number'];
    $siteId = get_current_blog_id();
    $tracking_link = '';
    if ($siteId==1 || $siteId==3) {
        $tracking_link = $data['response_from_warehouse'];
    } else if($siteId==2 || $siteId==4) {
        $tracking_link = get_option('tracking_link').$trackingNumber;
    }
?>

<div style="background-color: #ebebec; width: 100%;">
    <table class="wrapper" width="100%">
        <tr>
            <td class="wrapper-inner" align="center" style="background-color: #ebebec; padding: 25px 0;">
                <table class="main" align="center" style="width:600px; max-width:600px;background:#fff">
                    <tr>
                        <td class="main-content">
                                <table width="100%" style="max-width: 600px;background:#fff;">
                                    <tr>
                                        <td class="header" style='background-color: #fff; color: #ffffff; font-family: Raleway, sans-serif;'>
                                            <table width="100%" cellpadding="25px">
                                                <tr>   
                                                    <td class="header" style='background-color: #fff; color: #ffffff; font-family: Helvetica, Arial, sans-serif !important;padding:0;'>
                                                        <table width="100%" cellpadding="25px">
                                                            <tr>
                                                                <td width="100%" style="padding:0px">
                                                                    <img src="<?php echo $images['shipping-note'] ?>" width="100%">
                                                                </td>
                                                            </tr>
                                                            
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
                                            </table>
                                        </td>
                                    </tr>
                                    
                                     <tr>
                                        <td style="padding: 30px 25px; text-align: left; background-color: white;">
                                            <?php $storeName = get_bloginfo('name');?>
                                            <h1 style="font-family: Helvetica, Arial, sans-serif !important; font-size: 18px; font-weight: bold; color: #878787; text-transform: uppercase; text-align: center;">Thank you for shopping with <?php echo $storeName; ?></h1>

                                            <table width="100%" align="center">
                                                <tr>
                                                    <td width="50%" style="padding-right: 10px;">
                                                        <?php if($siteId==1): ?>
                                                            <img src="<?php echo $images['lemonpath'] ?>" alt="Lemonpath" border="0" width="215" style="width: 215px;"/>
                                                        <?php elseif($siteId==2): ?>
                                                            <img src="<?php echo $images['vertical-logistics'] ?>" alt="Lemonpath" border="0" width="215" style="width: 215px;"/>
                                                        <?php elseif($siteId==3): ?>
                                                            <img src="<?php echo $images['quantam-solutions'] ?>" alt="Lemonpath" border="0" width="215" style="width: 215px;"/>
                                                        <?php elseif($siteId==4): ?>
                                                            <img src="<?php echo $images['t-logistics'] ?>" alt="Lemonpath" border="0" width="215" style="width: 215px;"/>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if($siteId==1): ?>
                                                            <p style="text-align: left; color: #878787; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important;">
                                                                Your order <span class="no-link" style="color: #05b1a9;"> <?php echo $orderNumber;?></span> has now been despatched in partnership with Lemonpath Logistics.
                                                            </p>
                                                        <?php elseif($siteId==2): ?>
                                                            <p style="text-align: left; color: #878787; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important;">
                                                                Your order <span class="no-link" style="color: #05b1a9;"> <?php echo $orderNumber;?></span> has now been despatched in partnership with Vertical Logistics.
                                                            </p>
                                                        <?php elseif($siteId==3): ?>
                                                            <p style="text-align: left; color: #878787; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important;">
                                                                Your order <span class="no-link" style="color: #05b1a9;"> <?php echo $orderNumber;?></span> has now been despatched in partnership with Quantium Solutions Australia.
                                                            </p>
                                                        <?php elseif($siteId==4): ?>
                                                            <p style="text-align: left; color: #878787; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important;">
                                                                Your order <span class="no-link" style="color: #05b1a9;"> <?php echo $orderNumber;?></span> has now been despatched in partnership with T-Logistics.
                                                            </p>
                                                        <?php endif; ?>

                                                    </td>
                                                </tr>
                                            </table>

                                            <!-- <p style="text-align: left;">
                                                <?php if($siteId==1): ?>
                                                    <b style="text-align: left; color: #878787; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important;">If you require assistance, or have any questions about this delivery, please reply to this email or call: <a style="text-decoration:none; font-weight:bold;" href="tel:+44 (0) 20 7175 6500">+44 (0) 20 7175 6500</a></b>
                                                <?php else: ?>
                                                    <b style="text-align: left; color: #878787; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important;">If you require assistance, or have any questions about this delivery, please reply to this email</b>
                                                <?php endif; ?>
                                            </p> -->
                                            <p style="text-align: left; color: #878787; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important;">
                                                You can track your order by clicking on the tracking number shown, or by copying and pasting the link below into your browser window.
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            <table width="100%" style="background-color: #ffffff; max-width: 600px;">
                                 <tr>
                                   <td>
                                        <table class="shipment-track" width="100%">
                                            <thead>
                                                <tr>
                                                    <th align="center" style="font-family: Helvetica, Arial, sans-serif; padding: 10px; background-color: #08456b; color: #ffffff;">Your tracking information</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td align="center" style="font-family: Helvetica, Arial, sans-serif; font-size: 20px; background-color: #ffffff; padding: 25px;"><b>Tracking Number:</b> <a href="<?php echo $tracking_link;?>" style="color: #05b1a9;"><?php echo $trackingNumber;?></a></td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="font-family: Helvetica, Arial, sans-serif; background-color: #6d6e71; padding: 10px;"><a style="color: #ffffff;" href="<?php echo $tracking_link;?>"><?php echo $tracking_link;?></a></td>
                                                </tr>
                                            </tbody>
                                         </table>
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
                                  <tr class="email-information">
                                        <td style="background-color: #ffffff;  text-align: center;">
                                            <p style="color: #878787; font-size: 16px; font-family: Helvetica, Arial, sans-serif !important;">For more pure, naturally health packed products<br> please visit <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_url( home_url( '/' ) ); ?></a></p>
                                            <table width="100%" style="background: #fff;">
                                                <tr>
                                                <td><img src="<?php echo $images['strip']; ?>" width="100%"/></td>
                                                </tr>
                                            </table>
                                            <table width="100%" style="background: #fff;">
                                                <tr>
                                                <td><img src="<?php echo $images['nature']; ?>" width="100%" style="margin: 20px 0;"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                    <td class="header" style='background-image: url(<?php echo $images['email-footer-background']; ?>); background-size: contain; height: 196px; display: block; color: #ffffff; font-family: Helvetica, Arial, sans-serif !important;'>
                                            <table width="90%" cellpadding="25px" style="margin: 0 auto;">
                                                <tr>
                                                    <td width="35%" style="padding: 35px 25px 25px">
                                                        <a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                                            <img src="<?php echo $images['logo_email']; ?>" alt="Rosita" width="125">
                                                        </a>
                                                    </td>
                                                    <td class="footer-right" width="65%" align="right" valign="middle" style="padding: 35px 25px 25px">
                                                        <br>
                                                        <p style="text-align: right; color: #fff; font-size: 12px; font-family: Helvetica, Arial, sans-serif !important; margin-top: 10px;">A CONSCIOUS VISION TO HELP PEOPLE THRIVE.</p>
                                                        <table width="100%" cellpadding="25px" style="">
                                                            <tr style="padding:0;">
                                                                <td style=" padding: 0 0px 0 20px;">
                                                                    <a target="_blank" href="https://www.facebook.com/rositarealfoods/"  style="margin: 0;">
                                                                    <img src="<?php echo $images['fb-icon']; ?>" alt="Rosita" width="30"></a>
                                                                </td>
                                                                <td style=" padding: 0 0px 0 20px;">
                                                                
                                                                    <a target="_blank" href="https://twitter.com/rositarealfoods/" style="margin: 0;">
                                                                    <img src="<?php echo $images['twitter-x-icon']; ?>" alt="Rosita" width="30"></a>
                                                                </td>
                                                                <td style=" padding: 0 0px 0 20px;">
                                                                
                                                                    <a target="_blank" href="https://www.instagram.com/rositarealfoods/?hl=en" style="margin: 0;">
                                                                    <img src="<?php echo $images['insta-icon']; ?>" alt="Rosita" width="30"></a>

                                                                </td>
                                                                <td style=" padding: 0 0px 0 20px;">
                                                                
                                                                    <a target="_blank" href="https://www.pinterest.co.uk/rositarealfoods/?eq=rosita%20real%20food&etslf=5409" style="margin: 0;">
                                                                    <img src="<?php echo $images['pinterest-icon']; ?>" alt="Rosita" width="30"></a>

                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                        </table>
    
                                   
                                  
                             
                        </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>