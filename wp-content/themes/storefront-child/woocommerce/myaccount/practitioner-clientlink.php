<?php
defined( 'ABSPATH' ) || exit;
UM()->user()->set();
$role = UM()->user()->get_role();
$show_form = false;
$message_when_not_show_form = __('There was an error. Please contact us.');
if( $role == 'um_practitioner-client' ) {
  $show_form = false;
  $message_when_not_show_form = __('You are already a Practitioner Client. If you have trouble accessing your account, please contact us.');
} elseif( $role == 'um_practitioner-client' ) {
  $show_form = false;
  $message_when_not_show_form = ___('You are already a Practitioner');
}else{
  $show_form = true;
}
?>
<div class="account-header-wrapper">
  <section class="account-header customer_account_index" style="">
    <h1><?php echo __('Practitioner Client Registration | Rosita Real Foods'); ?></h1>
  </section>
  <div class="account-intro">
    <div class="page-main">
      <div class="row"></div>
      <?php if( $show_form ): ?>
      <div class="row">
        <div
          class="col-sm-8 offset-sm-2 col-md-4 offset-md-0 offset-lg-1 col-lg-3 offset-xl-2 col-xl-2">
          <div class="avatar-image"><img src="<?php echo get_theme_file_uri()?>/assets/images/Account_Practitioner.svg" alt="Account avatar"
              class="customer-avatar"></div>
        </div>
        <div class="col-sm-12 col-md-8 col-lg-7 col-xl-6">
          <div class="account-intro--main">
            <h3><?php echo __('Join The Program'); ?></h3>
            <p><?php echo __('You are not currently a registered member of our Practitioner Program. If you would like to hear more
              about this service, to register as a qualified healthcare practitioner or to talk with us first hand
              please choose one of the options below.'); ?></p>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<section class="account-content-wrapper">
  <div class="page-main">
    <div class="row">
      <div class="col-xl-8 offset-xl-2 customer-account-edit-form">
      <div id="processing-feedback"></div>
        <?php if( $show_form ): ?>
        <form action="" id="practitioner-client-registration" method="post" enctype="multipart/form-data"
          class="form-create-account" novalidate="novalidate">
          <fieldset class="fieldset create address row">
          <?php wp_nonce_field('practitionerclientregistration_nonceaction', 'practitionerclientregistration_nonce'); ?>
            <legend class="legend prac-heading"><span><?php echo __('Practitioner\'s Information'); ?></span></legend>
            <div class="col-sm-12 col-md-5 col-lg-7 field practitioners_name required"><label for="practitioners_name"
                class="label"><span><?php echo __('Practitioner\'s name.'); ?></span></label>
              <div class="control"><input type="text" name="practitioners_name" id="practitioners_name"
                  class="input-text required-entry" autocomplete="off" aria-required="true"></div>
            </div>
            <div class="col-sm-12 col-md-7 col-lg-5 field practitioner_code required"><label for="practitioner_code"
                class="label"><span><?php echo __('Practitioner\'s reference code.'); ?></span></label>
              <div class="control"><input type="text" name="practitioner_code" id="practitioner_code"
                  class="input-text required-entry" autocomplete="off" aria-required="true"></div>
            </div>
          </fieldset>
          <div class="mobile-row">
            <div class="col-sm-12">
              <div class="actions-toolbar">
                <div class="primary"><button type="submit" class="action submit primary"
                    title="<?php echo __('Register with Rosita Real Foods'); ?>"><span><?php echo __('Register with Rosita Real Foods'); ?></span></button></div>
                <div class="secondary"><a class="action back" href="/my-account/practitioner"><span><?php echo __('Back'); ?></span></a>
                </div>
              </div>
            </div>
          </div>
        </form>
        <?php else: ?>
          <div class="notify-practitioner">
            <p><?php echo $message_when_not_show_form; ?></p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<div id="pr-loading"><img src="<?php echo get_theme_file_uri()?>/assets/images/spinner.gif" alt="Loading..." /></div>
<script>
  (function($) {
    $(document).ready(function() {

      $('#practitioner-client-registration').validate({
        rules: 
        {
          practitioners_name: {
              required: true,
          },
          practitioner_code: {
              required: true,
          },
        },
        messages: 
        {
          practitioners_name: {
              required: "Please enter Practitioner's name",
          },
          practitioner_code: {
              required: "Please enter Practitioner's code",
          },
        }
      });
    });

    $('#practitioner-client-registration').submit(function(e) {
        e.preventDefault();
        if (!$(this).valid()){
          return false;
        }

        $('#pr-loading').addClass('show');
        $('#processing-feedback').hide();

        var formData = new FormData(this); // 'this' refers to the form element
        formData.append('action', 'practitionerclientregistration_action'); // Action for WordPress hook

        $.ajax({
            url: `${window.location.origin}/wp-admin/admin-ajax.php`,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if(response.success) {
                    $('#processing-feedback').html('<p>' + response.message + '</p>');
                } else {
                    $('#processing-feedback').html('<p class="error-notif">' + response.message + '</p>');
                }
            },
            error: function(error) {
                $('#processing-feedback').html('<p class="error-notif">There was an error processing your request. Please contact us <a href="https://rositarealfoods.zendesk.com/hc/en-us/categories/115000420953-Contact-Us">Here</a>.</p>');
            },
            complete: function() {
                $('#processing-feedback').show();
                $('#pr-loading').removeClass('show');
            }
        });
      });

  })(jQuery);
</script>