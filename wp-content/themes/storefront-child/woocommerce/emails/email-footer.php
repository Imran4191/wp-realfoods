<?php
/**
 * Email Footer
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 7.4.0
 */
include get_stylesheet_directory() . '/email-templates-images.php';
defined( 'ABSPATH' ) || exit;
?>

<table width="100%" style=" max-width: 600px; background: #fff; font-family: Helvetica, Arial, sans-serif !important; ">
    <tbody>
        <tr>
            <td class="header" style='background-image: url(<?php echo $images['email-footer-background']; ?>); background-size: cover; height: 196px; display: block; color: #ffffff; font-family: Helvetica, Arial, sans-serif !important;'>
                <table width="90%" cellpadding="25px" style="margin: 0 auto">
                    <tbody>
                        <tr>
                            <td width="35%" style="padding: 35px 25px 25px">
                                    <a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                    <img
                                        src="<?php echo $images['logo_email']; ?>"
                                        alt="Rosita"
                                        width="125"
                                    />
                                </a>
                            </td>
                            <td
                                class="footer-right"
                                width="65%"
                                align="right"
                                valign="middle"
                                style="padding: 35px 25px 25px"
                            >
                                <br />
                                <p
                                style="
                                    text-align: right;
                                    color: #fff;
                                    font-size: 12px;
                                    font-family: Helvetica, Arial, sans-serif !important;
                                    margin-top: 10px;
                                "
                                >
                                A CONSCIOUS VISION TO HELP PEOPLE THRIVE.
                                </p>
                                <table width="100%" cellpadding="25px" style="">
                                <tbody>
                                    <tr style="padding: 0">
                                    <td style="padding: 0 0px 0 20px">
                                        <a
                                        target="_blank"
                                        href="https://www.facebook.com/rositarealfoods/"
                                        style="margin: 0"
                                        >
                                        <img
                                            src="<?php echo $images['fb-icon']; ?>"
                                            alt="Rosita"
                                            width="30"
                                        /></a>
                                    </td>
                                    <td style="padding: 0 0px 0 20px">
                                        <a
                                        target="_blank"
                                        href="https://twitter.com/rositarealfoods/"
                                        style="margin: 0"
                                        >
                                        <img
                                            src="<?php echo $images['twitter-x-icon']; ?>"
                                            alt="Rosita"
                                            width="30"
                                        /></a>
                                    </td>
                                    <td style="padding: 0 0px 0 20px">
                                        <a
                                        target="_blank"
                                        href="https://www.instagram.com/rositarealfoods/?hl=en"
                                        style="margin: 0"
                                        >
                                        <img
                                            src="<?php echo $images['insta-icon']; ?>"
                                            alt="Rosita"
                                            width="30"
                                        /></a>
                                    </td>
                                    <td style="padding: 0 0px 0 20px">
                                        <a
                                        target="_blank"
                                        href="https://www.pinterest.co.uk/rositarealfoods/?eq=rosita%20real%20food&amp;etslf=5409"
                                        style="margin: 0"
                                        >
                                        <img
                                            src="<?php echo $images['pinterest-icon']; ?>"
                                            alt="Rosita"
                                            width="30"
                                        />
                                        </a>
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