<div class="trackorder">
  <div class="tracking-order-wrapper">
    <div class="page-main">
      <div class="row">
        <div class="col-sm-8 col-lg-6 offset-lg-3 offset-sm-2">
          <div class="guest-track-order-form-wrapper">
            <form class="form guest-track-order-form" id="guest-track-order-form" method="post"
              action="" novalidate="novalidate">
              <?php wp_nonce_field('trackorder_nonceaction', 'trackorder_nonce'); ?>
              <fieldset class="fieldset guest-track-order">
                <h3><span>TRACK</span> My Order</h3>
                <p>To track your order please enter your Order Number and Email in the box below and press the "TRACK MY ORDER".
                </p>
                <p>This information was sent to you in your order confirmation email.</p>
                <div class="field field-name-order_number required">
                  <div class="control"><label for="order-number">Order Number<span class="required">*</span></label> <input
                      type="text" placeholder="Found in your order confirmation email."
                      class="minimum-length-10 maximum-length-10" id="order_number" name="order_number"
                      data-validate="{required:true, 'validate-length':true}" value=""
                      data-msg-validate-length="The order number length should be equal to 10 characters." aria-required="true">
                  </div>
                </div>
                <div class="field field-name-order_email required">
                  <div class="control"><label for="order-number">Email<span class="required">*</span></label> <input
                      type="email" placeholder="Email you used during checkout." class="validate-email" id="order_email"
                      name="order_email" data-validate="{required:true, 'validate-email':true}" value="" aria-required="true">
                  </div>
                </div>
                <div class="actions-toolbar">
                  <div class="primary"><button type="submit" title="TRACK MY ORDER" class="action submit primary"><span>TRACK MY
                        ORDER</span></button></div>
                </div>
              </fieldset>
            </form>
            <div class="block" id="track-order-result">
              <div class="block-title">
                <h2><strong id="block-title">Track Order Result</strong></h2>
                <div class="block-content">
                  <div id="spinner">
                    <img src="<?php echo get_theme_file_uri()?>/assets/images/spinner.gif" alt="Loading..." />
                  </div>
                  <div class="result-content">
                    <p id="order_number"><span class="label">Order Number: </span><span class="value"></span></p>
                    <p id="order_date"><span class="label">Order Date: </span><span class="value"></span></p>
                    <p id="order_status"><span class="label">Status: </span><span class="value"></span></p>
                    <div class="status_message"></div>
                  </div>
                  <div class="error-messages"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  (function($) {
    $(document).ready(function() {
      $('#guest-track-order-form').validate({
        rules: {
          order_number: {
            required: true,
          },
          order_email: {
            required: true,
            email: true
          }
        },
        messages: {
          order_number: {
            required: "Please enter your order number."
          },
          order_email: {
            required: "Please enter your email.",
            email: "Please enter a valid email."
          }
        }
      });

      $('#guest-track-order-form').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission
        if (!$(this).valid()){
          return false;
        }

        $('#track-order-result').show();
        $('#spinner').show();
        $('.result-content').hide();
        $('.error_messagest').hide();
        $('#order_number .value').text('');
        $('#order_date .value').text('');
        $('#order_status .value').text('');
        $('.status_message').html('');
        $('.error-messages').html('');

        var formData = new FormData(this); // 'this' refers to the form element
        formData.append('action', 'track_order_action'); // Action for WordPress hook

        $.ajax({
            url: `${window.location.origin}/wp-admin/admin-ajax.php`,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    $('#order_number .value').text(response.data.order_number);
                    $('#order_date .value').text(response.data.order_date);
                    $('#order_status .value').text(response.data.order_status);
                    $(response.data.status_mesage).each(function( index, value ) {
                      $('.status_message').append('<p>' + value + '</p>');
                    });
                    $('.result-content').show();
                } else {
                  $('.result-content').hide();
                  $('.error-messages').html(response.message);
                  $('.error-messages').show();
                }
            },
            error: function(error) {
              $('.result-content').hide();
              $('.error-messages').html('<p>There was an error processing your request. Please contact us <a href="https://rositarealfoods.zendesk.com/hc/en-us/categories/115000420953-Contact-Us">Here</a>.</p>');
            },
            complete: function() {
              $('#spinner').hide();
            }
        });
      });
    });
  })(jQuery);
</script>