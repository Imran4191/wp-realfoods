<?php

   include get_stylesheet_directory() . '/email-templates-images.php';
?>

<div style="background-color: #ebebec; width: 100%" id="email_template">
  <table class="wrapper" width="100%">
    <tbody>
      <tr>
        <td class="wrapper-inner" align="center" style="background-color: #ebebec; padding: 25px 0">
          <table class="main" align="center" style="width: 600px; max-width: 600px; background: #fff">
            <tbody>
              <tr>
                <td class="main-content">
                  <table width="100%" style="max-width: 600px; background: #fff">
                    <tbody>
                      <tr>
                        <td class="header" style="background-color: #fff; color: #ffffff; font-family: Raleway, sans-serif">
                          <table width="100%" cellpadding="25px">
                            <tbody>
                              <tr>
                                <td class="header" style="background-color: #fff; color: #ffffff; font-family: Helvetica, Arial, sans-serif !important; padding: 0">
                                  <table width="100%" cellpadding="25px">
                                    <tbody>
                                      <tr>
                                        <td width="100%" style="padding: 0px">
                                          <img src="<?php echo $images['disapproved'] ?>" width="100%" />
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td style="padding: 0">
                                  <table width="100%" cellpadding="25px" style="background: #fff">
                                    <tbody>
                                      <tr style="background: #fff; padding: 0 20px">
                                        <td style="text-align: left">
                                          <a target="_blank" href="{site_url}/faq" style="text-align: center; padding-left: 25px; color: #878787; font-size: 14px; font-family: Helvetica, Arial, sans-serif !important; margin: 0; text-transform: uppercase; text-decoration: none !important">
                                            <?php echo __("FAQs"); ?>
                                          </a>
                                        </td>
                                        <td style="text-align: center">
                                          <a target="_blank" href="{site_url}" style="text-align: center; color: #878787; font-size: 14px; font-family: Helvetica, Arial, sans-serif !important; margin: 0; text-transform: uppercase; text-decoration: none !important">
                                            <?php echo __("SHOP"); ?>
                                          </a>
                                          <span style="color: #000; font-size: 14px; font-family: Helvetica, Arial, sans-serif !important; margin-left: 5px"></span>
                                        </td>
                                        <td style="text-align: right">
                                          <a target="_blank" href="{site_url}/login" style="text-align: center; padding-right: 25px; color: #878787; font-size: 14px; font-family: Helvetica, Arial, sans-serif !important; margin: 0; text-transform: uppercase; text-decoration: none !important">
                                            <?php echo __("LOGIN"); ?>
                                          </a>
                                          <span style="color: #000; font-size: 14px; font-family: Helvetica, Arial, sans-serif !important; margin-left: 5px"></span>
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

                  <table width="100%" style="max-width: 600px; background: #fff">
                    <tbody>
                      <tr>
                        <td style="padding: 30px 25px; text-align: center; background-color: white">
                          <h1 style="font-family: Helvetica, Arial, sans-serif !important; color: #878787; font-size: 20px; text-align: left; font-weight: bold; text-transform: uppercase">
                            <?php echo __("Dear {display_name}, "); ?>
                          </h1>
                          <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important">
                            <?php echo __("I hope this message finds you well. Our team has carefully reviewed your application and the documents provided as part of our verification process. "); ?>
                          </p>

                          <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important">
                            <?php echo __("Unfortunately, we regret to inform you that, at this time, we are unable to approve your account application. This decision is based on discrepancies or validation concerns with the details or certificates you have provided.  "); ?>
                            <br />
                          </p>

                          <p style="text-align: left; color: #878787; margin-top: 25px; font-family: Helvetica, Arial, sans-serif !important">
                            <?php echo __("What You Can Do Next: "); ?>
                            <br />
                          </p>
                          <ul style="padding: 0 30px; margin: 0">
                            <li style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important">
                              <span style="color: #878787">
                                <strong>
                                  <?php echo __("Review and Resubmit: "); ?>
                                </strong>
                                <?php echo __(" We kindly ask that you review the information and documents you have submitted. If you have an updated or valid certificate or if there was a mistake in your initial submission, please resubmit the correct details to us by responding to this email with the updated documents.  "); ?>
                              </span>
                            </li>
                          </ul>

                          <p style="text-align: left; color: #878787; margin-top: 25px; font-family: Helvetica, Arial, sans-serif !important">
                            <strong>
                              <?php echo __("We Are Here to Assist:"); ?>
                            </strong>
                            <?php echo __(" Our goal is to facilitate a smooth and straightforward application process. We understand that this news may be disappointing, but please rest assured that we are available to support you through the next steps. For further assistance, please feel free to simply reply to this email."); ?>
                          </p>
                          <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important">
                            <?php echo __("We value your interest in joining Rosita Real Foods and appreciate your understanding and cooperation in this matter. Thank you for your attention to this important update. We look forward to assisting you and hopefully welcoming you as an approved member of our {user_role} community. "); ?>
                          </p>
                        </td>
                      </tr>

                      <tr>
                        <td style="padding: 30px 25px; text-align: center; background-color: white">
                          <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important">
                            <?php echo __("Warm regards,"); ?>
                            <br />
                          </p>

                          <p style="text-align: left; color: #878787; font-family: Helvetica, Arial, sans-serif !important">
                            <?php echo __("Chrissy "); ?>
                            <br />
                          </p>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 30px 25px; text-align: center; background-color: white">
                          <p style="text-align: left; color: #878787; margin-top: 25px; font-family: Helvetica, Arial, sans-serif !important">
                            <?php echo __(" Please do not reply to this email, as this inbox is not monitored."); ?>
                            <br />
                          </p>
                          <p style="text-align: left; color: #878787; margin-top: 25px; font-family: Helvetica, Arial, sans-serif !important">
                            If you need assistance, kindly contact us using this
                            <a href="{site_url}/contact" target="_blank">link</a>
                             or the button below.
                          </p>

                          <table width="100%" cellpadding="0" align="center" style="margin-top: 25px">
                            <tbody>
                              <tr>
                                <td style="margin-bottom: 2.5rem; text-transform: uppercase; font-family: Helvetica, Arial, sans-serif !important; font-weight: bold; padding: 15px; display: block; width: 450px; margin: 0 auto; background-color: #00b1aa; text-align: center; border-radius: 5px">
                                  <a style="color: #ffffff; text-decoration: none" href="{site_url}/contact" target="_blank"><?php echo __("CUSTOMER SUPPORT"); ?></a>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>

                  <table width="100%" style="max-width: 600px; background: #fff; font-family: Helvetica, Arial, sans-serif !important">
                    <tbody>
                      <tr>
                        <td>
                          <img src="<?php echo $images['strip']; ?>" width="100%" />
                        </td>
                      </tr>
                    </tbody>
                  </table>

                  <table width="100%" style="max-width: 600px; background: #fff; font-family: Helvetica, Arial, sans-serif !important">
                    <tbody>
                      <tr>
                        <td>
                          <img src="<?php echo $images['nature']; ?>" width="100%" style="margin: 20px 0" />
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