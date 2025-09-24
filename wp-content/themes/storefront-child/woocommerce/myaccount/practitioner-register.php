<?php
defined( 'ABSPATH' ) || exit;
UM()->user()->set();
$role = UM()->user()->get_role();
$user_id = UM()->user()->id;
$account_status = get_user_meta($user_id, 'account_status', true);
$show_form = $role !== 'um_practitioner';

$message_when_not_show_form = __('There was an error. Please contact us.');
if( !$show_form ) {
    if ($account_status === 'awaiting_admin_review') {
        $message_when_not_show_form = __('Your Practitioner registration is under admin review.');
    } elseif ($account_status === 'rejected') {
        $message_when_not_show_form = __('Your Practitioner registration has been declined. Please contact us.');
    } elseif ($account_status === 'approved'){
        $message_when_not_show_form = __('You are already a practitioner. If you have trouble accessing your account, please contact us.');
    }
}
?>
<div class="account-header-wrapper">
  <section class="account-header customer_account_index" style="">
    <h1><?php echo __('Practitioner Registration | Rosita Real Foods'); ?></h1>
  </section>
  <div class="account-intro">
    <div class="page-main">
      <div class="row"></div>
      <?php if( $show_form ): ?>
      <div class="row">
        <div
          class="col-sm-8 col-sm-offset-2 col-md-4 offset-md-0 offset-lg-1 col-lg-3 offset-xl-2 col-xl-2">
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
                <form action="" id="practitioner-registration" method="post" enctype="multipart/form-data" class="form-create-account">
                    <input type="hidden" name="role" value="practitioner">
                    <?php wp_nonce_field('practitionerregistration_nonceaction', 'practitionerregistration_nonce'); ?>
                    <fieldset class="fieldset create address row">
                        <legend class="legend"><span><?php echo __('Company Information'); ?></span></legend>
                        <div class="col-sm-12 col-md-6 field company">
                            <label for="practitioner_company" class="label"><span><?php echo __('Company'); ?></span></label>
                            <div class="control">
                                <input type="text" name="practitioner_company" id="practitioner_company" value="" title="Company" class="input-text " autocomplete="off"></div>
                            </div>
                        <div class="col-sm-12 col-md-6 field key_position">
                            <label for="key_position" class="label"><span><?php echo __('Position'); ?></span></label>
                            <div class="control">
                                <input type="text" name="key_position" id="key_position" value=""
                                    title="Position" class="input-text" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 field taxvat">
                            <label class="label" for="taxvat"><span><?php echo __('Tax/VAT number'); ?></span></label>
                            <div class="control">
                                <input type="text" id="taxvat" name="taxvat" value="" title="Tax/VAT number" class="input-text validate-alphanum" autocomplete="off"
                                    minlength="7">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 field website_url"><label for="website_url"
                                class="label"><span><?php echo __('Website URL'); ?></span></label>
                            <div class="control">
                                <input type="text" name="website_url" id="website_url" value="" title="Website URL" class="input-text validate-url" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-12 field required telephone">
                            <label for="telephone" class="label"><span><?php echo __('PhoneNumber'); ?></span></label>
                            <div class="control">
                                <input type="text" name="telephone" minlength="9" id="telephone"
                                    value="" title="Phone Number" class="input-text required-entry" autocomplete="off" aria-required="true">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 field street required"><label for="billing_address_1" class="label"><span><?php echo __('Address Line 1'); ?></span></label>
                            <div class="control">
                                <input type="text" name="billing_address_1" value="" title="Address Line 1" id="billing_address_1" class="input-text required-entry" autocomplete="off"
                                    aria-required="true">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 field additional"><label class="label"
                                for="billing_address_2"><span><?php echo __('Address Line 2'); ?></span></label>
                            <div class="control"><input type="text" name="billing_address_2" value="" title="Address Line 2"
                                    placeholder="Apartment/Unit" id="billing_address_2" class="input-text " autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 field required">
                            <label for="city" class="label"><span><?php echo __('City'); ?></span></label>
                            <div class="control">
                                <input type="text" name="billing_city" value="" title="City" class="input-text required-entry" id="city" autocomplete="off" aria-required="true">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 field region"><label for="billing_state"
                                class="label"><span><?php echo __('State/Province'); ?></span></label>
                            <div class="control"><select id="billing_state" name="billing_state" title="State/Province"
                                    class="validate-select" style="display:none;" aria-required="true" defaultvalue=""
                                    disabled="">
                                    <option value=""><?php echo __('Please select a region, state or province.'); ?></option>
                                </select> <input type="text" id="billing_state" name="billing_state" value="" title="State/Province"
                                    class="input-text" style="" autocomplete="off" aria-required="true"></div>
                        </div>
                        <div class="col-sm-12 col-md-6 field zip required"><label for="billing_postcode"
                                class="label"><span><?php echo __('Postcode'); ?></span></label>
                            <div class="control"><input type="text" name="billing_postcode" value="" title="Postcode" id="billing_postcode"
                                    class="input-text validate-zip-international required-entry" autocomplete="off"
                                    aria-required="true"></div>
                        </div>
                        <div class="col-sm-12 col-md-6 field country required"><label for="billing_country"
                                class="label"><span><?php echo __('Country'); ?></span></label>
                            <div class="control"><select name="billing_country" id="billing_country" class="input-text required-entry"
                                    title="Country" aria-required="true">
                                    <option value=""> </option>
                                    <option>Bosnia & Herzegovina</option>
                                    <option>Georgia</option>
                                    <option>Gibraltar</option>
                                    <option>Guernsey</option>
                                    <option>Hong Kong SAR China</option>
                                    <option>Indonesia</option>
                                    <option>Isle of Man</option>
                                    <option>Jersey</option>
                                    <option>Jordan</option>
                                    <option>Kuwait</option>
                                    <option>Mauritius</option>
                                    <optio-n">Philippines</option>
                                    <option>Singapore</option>
                                    <option>Switzerland</option>
                                    <option>Taiwan</option>
                                    <option>United Arab Emirates</option>
                                    <option selected="selected">United Kingdom</option>
                                    <option>United States</option>
                                </select></div>
                        </div>
                    </fieldset>
                    <fieldset class="fieldset create account account-type-fieldset additional in row">
                        <legend class="legend"><span><?php echo __('Practitioner Information'); ?></span></legend>
                        <div class="col-sm-12 col-md-6 field practitioner_type required">
                            <label for="practitioner_type" class="label"><span><?php echo __('Please Select your practitioner
                                    type'); ?></span></label>
                            <div class="control">
                                <select name="practitioner_type" id="practitioner_type"
                                    class="input-text required-entry other" data-other="practitioner_type_other">
                                    <option value=""><?php echo __('Please Select'); ?></option>
                                    <option value="Aroma Therapist">Aroma Therapist</option>
                                    <option value="Chiropractor / Osteopath">Chiropractor / Osteopath</option>
                                    <option value="Colonic Hydrotherapist">Colonic Hydrotherapist</option>
                                    <option value="Dentist">Dentist</option>
                                    <option value="Herbalist">Herbalist</option>
                                    <option value="Herbalist">Herbalist</option>
                                    <option value="Herbalist">Herbalist</option>
                                    <option value="Massage Therapist">Massage Therapist</option>
                                    <option value="Medical Doctor">Medical Doctor</option>
                                    <option value="Nutritionist / Naturopath">Nutritionist / Naturopath</option>
                                    <option value="Personal Trainer (including biosig)">Personal Trainer (including biosig)</option>
                                    <option value="Pharmacist (including chemist)">Pharmacist (including chemist)</option>
                                    <option value="Reiki & Chinese Medicine">Reiki & Chinese Medicine</option>
                                    <option value="Reflexologist">Reflexologist</option>
                                    <option value="Functional Diagnostic Nutrition">Functional Diagnostic Nutrition</option>
                                    <option value="Functional Medicine Practitioner">Functional Medicine Practitioner</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 field practitioner_type_other required">
                            <label for="practitioner_type_other" class="label"><span><?php echo __('Practitioner type
                                    (other)'); ?></span></label>
                            <div class="control">
                                <input type="text" name="practitioner_type_other" value="" id="practitioner_type_other"
                                    class="input-text required-entry" disabled="">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 field practitioner_qualification required">
                            <label for="practitioner_qualification" class="label"><span><?php echo __('Level Of
                                    Qualification'); ?></span></label>
                            <div class="control">
                                <select name="practitioner_qualification" id="practitioner_qualification"
                                    class="input-text required-entry other" data-other="practitioner_qual_other">
                                    <option value=""><?php echo __('Please Select'); ?></option>
                                    <option>Student</option>
                                    <option>Certificate</option>
                                    <option>Diploma</option>
                                    <option>Degree</option>
                                    <option>Masters</option>
                                    <option>PHD</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 field practitioner_qual_other required">
                            <label for="practitioner_qual_other" class="label"><span><?php echo __('Practitioner qualification
                                    (other)'); ?></span></label>
                            <div class="control">
                                <input type="text" name="practitioner_qual_other" value="" id="practitioner_qual_other"
                                    class="input-text required-entry" disabled="">
                            </div>
                        </div>
                        <div class="col-sm-12 field practitioner_certificate required">
                            <label for="practitioner_certificate" class="label"><span><?php echo __('Practitioner
                                    Certificate'); ?></span></label>
                            <div class="control">
                                <input type="file" name="practitioner_certificate" value=""
                                    id="practitioner_certificate" class="input-text required-entry">
                            </div>
                        </div>
                        <div class="col-sm-12 field practitioner_associations ">
                            <label for="practitioner_associations" class="label"><span><?php echo __('Please list the professional
                                    associations you belong to'); ?></span></label>
                            <div class="control">
                                <textarea name="practitioner_associations" id="practitioner_associations"
                                    class="input-text " rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12 field practitioner_description required">
                            <label for="practitioner_description" class="label"><span><?php echo __('Describe your company or
                                    practice'); ?></span></label>
                            <div class="control">
                                <textarea name="practitioner_description" id="practitioner_description"
                                    class="input-text required-entry" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12 field practitioner_how_long required">
                            <label for="practitioner_how_long" class="label"><span><?php echo __('How long have you been in
                                    business?'); ?></span></label>
                            <div class="control radio">
                                <div class="radio-main radio before"><input data-error="#practitioner_how_long-errortxt"
                                        id="practitioner_how_long-186"
                                        class="radio required-entry"
                                        type="radio"
                                        name="practitioner_how_long"><span class="rosita-input-box"></span><label
                                        for="practitioner_how_long-186">Under 1 Year</label></div>
                                <div class="radio-main radio before"><input
                                        id="practitioner_how_long-187"
                                        class="radio required-entry"
                                        type="radio"
                                        name="practitioner_how_long"><span class="rosita-input-box"></span><label
                                        for="practitioner_how_long-187">1-2 Years</label></div>
                                <div class="radio-main radio before"><input id="practitioner_how_long-188"
                                        class="radio required-entry"
                                        type="radio"
                                        name="practitioner_how_long"><span class="rosita-input-box"></span><label
                                        for="practitioner_how_long-188">2-5 Years</label></div>
                                <div class="radio-main radio before"><input id="practitioner_how_long-189"
                                        class="radio required-entry"
                                        type="radio"
                                        name="practitioner_how_long"><span class="rosita-input-box"></span><label
                                        for="practitioner_how_long-189">5-10 Years</label></div>
                                <div class="radio-main radio before"><input id="practitioner_how_long-190"
                                        class="radio required-entry"
                                        type="radio"
                                        name="practitioner_how_long"><span class="rosita-input-box"></span><label
                                        for="practitioner_how_long-190">Over 10 Years</label></div>
                            </div>
                            <div id="practitioner_how_long-errortxt" class="custom-error"></div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-5 field practitioner_how_many ">
                            <label for="practitioner_how_many" class="label"><span><?php echo __('How many practitioners does your
                                    practice have?'); ?></span></label>
                            <div class="control">
                                <select name="practitioner_how_many" id="practitioner_how_many" class="input-text ">
                                    <option value=""><?php echo __('Please Select'); ?></option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10+</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-7 field practitioner_annual required">
                            <label for="practitioner_annual" class="label"><span><?php echo __('What is your anticipated annual order
                                    volume from Functional Self in £?'); ?></span></label>
                            <div class="control">
                                <select name="practitioner_annual" id="practitioner_annual"
                                    class="input-text required-entry">
                                    <option value=""><?php echo __('Please Select'); ?></option>
                                    <option>0-500</option>
                                    <option>501-2000</option>
                                    <option>2001-5000</option>
                                    <option>5001-10000</option>
                                    <option>10000+</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-6 field practitioner_num_clients required">
                            <label for="practitioner_num_clients" class="label"><span><?php echo __('Number of unique clients you see
                                    each week'); ?></span></label>
                            <div class="control">
                                <select name="practitioner_num_clients" id="practitioner_num_clients"
                                    class="input-text required-entry">
                                    <option value=""><?php echo __('Please Select'); ?></option>
                                    <option>1-5</option>
                                    <option>6-10</option>
                                    <option>11-15</option>
                                    <option>16-20</option>
                                    <option>20+</option>
                                </select>
                            </div>
                        </div>
                        <legend class="legend payment_information" style="clear: left;"><span><?php echo __('Payment Information'); ?></span>
                        </legend>
                        <div class="col-sm-12 field payment_details required">
                            <label for="payment_details" class="label"><span><?php echo __('Payment Options'); ?></span></label>
                            <div class="control radio">
                                <div class="radio-main radio before"><input id="payment_details-bank-transfer" data-fieldgroup="bank-details" data-error="#payment_details-errortxt"
                                        class="radio required-entry payment-details"
                                        type="radio"
                                        value="Bank Transfer"
                                        name="payment_details"><span class="rosita-input-box"></span><label
                                        for="payment_details-bank-transfer">Bank Transfer</label></div>
                                <div class="radio-main radio before"><input id="payment_details-paypal" data-fieldgroup="paypal" data-error="#payment_details-errortxt"
                                        class="radio required-entry payment-details"
                                        type="radio"
                                        value="Paypal"
                                        name="payment_details"><span class="rosita-input-box"></span><label
                                        for="payment_details-paypal">PayPal</label></div>
                            </div>
                            <div id="payment_details-errortxt" class="custom-error"></div>
                        </div>
                        <div class="col-sm-12 col-md-4 field account_name required bank-details">
                            <label for="account_name" class="label"><span><?php echo __('Account Name'); ?></span></label>
                            <div class="control">
                                <input type="text" name="account_name" value="" id="account_name"
                                    class="input-text required-entry">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 field sort_code required bank-details">
                            <label for="sort_code" class="label"><span><?php echo __('Sort Code'); ?></span></label>
                            <div class="control">
                                <input type="text" name="sort_code" value="" id="sort_code"
                                    class="input-text required-entry">
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4 field bank_account required bank-details">
                            <label for="bank_account" class="label"><span><?php echo __('Bank Account Number'); ?></span></label>
                            <div class="control">
                                <input type="text" name="bank_account" value="" id="bank_account"
                                    class="input-text required-entry">
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-6 field paypal_account required paypal">
                            <label for="paypal_account" class="label"><span><?php echo __('PayPal Account Email'); ?></span></label>
                            <div class="control">
                                <input type="email" name="paypal_account" value="" id="paypal_account"
                                    class="input-text required-entry">
                            </div>
                        </div>
                    </fieldset>
                    <div class="col-sm-12">
                        <div class="actions-toolbar">
                            <div class="primary"><button type="submit" class="action submit primary"
                                    title="Register with Rosita Real Foods"><span><?php echo __('Register with Rosita Real
                                        Foods'); ?></span></button></div>
                            <div class="secondary"><a class="action back"
                                    href="/my-account/practitioner"><span><?php echo __('Back'); ?></span></a></div>
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
      $('#practitioner-registration').validate({
        rules: 
        {
            telephone: {
                required: true,
            },
            billing_address_1: {
                required: true,
            },
            billing_city: {
                required: true,
            },
            billing_postcode: {
                required: true,
            },
            billing_country: {
                required: true,
            },
            billing_state: {
                required: {
                    depends: function(element) {
                        return $("#billing_country").val() == 'United States' || $("#billing_country").val() == 'Switzerland';
                    }
                }
            },
            practitioner_type: {
                required: true,
            },
            practitioner_type_other: {
                required: {
                    depends: function(element) {
                        return $("#practitioner_type").val() == 'Other';
                    }
                }
            },
            practitioner_qualification: {
                required: true,
            },
            practitioner_qual_other: {
                required: {
                    depends: function(element) {
                        return $("#practitioner_qualification").val() == 'Other';
                    }
                }
            },
            practitioner_certificate: {
                required: true,
            },
            practitioner_description: {
                required: true,
            },
            practitioner_how_long: {
                required: true,
            },
            practitioner_annual: {
                required: true,
            },
            practitioner_num_clients: {
                required: true,
            },
            payment_details: {
                required: true,
            },
            account_name: {
                required: {
                    depends: function(element) {
                        return $("#payment_details").val() == 'Bank Transfer';
                    }
                }
            },
            sort_code: {
                required: {
                    depends: function(element) {
                        return $("#payment_details").val() == 'Bank Transfer';
                    }
                }
            },
            bank_account: {
                required: {
                    depends: function(element) {
                        return $("#payment_details").val() == 'Bank Transfer';
                    }
                }
            },
            paypal_account: {
                required: {
                    depends: function(element) {
                        return $("#payment_details").val() == 'Paypal';
                    }
                }
            },
        },
        messages: {
            telephone: {
                required: 'Phone number is required.',
            },
            billing_address_1: {
                required: 'Address Line 1 is required.',
            },
            billing_city: {
                required: 'City is required.',
            },
            billing_postcode: {
                required: 'Postcode is required.',
            },
            billing_country: {
                required: 'Country is required.',
            },
            billing_state: {
                required: 'State is requiredfor the selected country.',
            },
            practitioner_type: {
                required: 'Practitioner Type is required.',
            },
            practitioner_type_other: {
                required: 'Practitioner Other Type is required.',
            },
            practitioner_qualification: {
                required: 'Practitioner Qualification is required.',
            },
            practitioner_qual_other: {
                required: 'Practitioner Other Qualification is required.',
            },
            practitioner_certificate: {
                required: 'Pracitioner Certificate is required.',
            },
            practitioner_description: {
                required: 'Practitioner Description is required.',
            },
            practitioner_how_long: {
                required: 'How long have you been in business is required.',
            },
            practitioner_annual: {
                required: 'Anticipated annual order volume is required.',
            },
            practitioner_num_clients: {
                required: 'Number of unique clients is required.',
            },
            payment_details: {
                required: 'Payment Details is required.',
            },
            account_name: {
                required: 'Account Name is required.',
            },
            sort_code: {
                required: 'Sort Code is required.',
            },
            bank_account: {
                required: 'Bank Account is required.',
            },
            paypal_account: {
                required: 'Paypal Account is required.',
            },
        },
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).html(error)
            } else {
                error.insertAfter(element);
            }
        }
      });

      $('#practitioner-registration').submit(function(e) {
        e.preventDefault();
        if (!$(this).valid()){
          return false;
        }

        $('#pr-loading').addClass('show');
        $('#processing-feedback').hide();

        var formData = new FormData(this); // 'this' refers to the form element
        formData.append('action', 'practitionerregistration_action'); // Action for WordPress hook

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

      $('.other').change(function() {
        let other_el = $(`#${$(this).data('other')}`);
        if ($(this).val() === 'Other') {
            $(other_el).prop('disabled', false);
            $(other_el).focus();
        } else {
            $(other_el).val('');
            $(other_el).prop('disabled', true);
        }
      });

      $('.payment-details').on('click',function() {
        let fieldgroup = $(this).data('fieldgroup');
        if ($(this).val() === 'Bank Transfer') {
            $('form#practitioner-registration .field.bank-details').show();

            $('form#practitioner-registration .field.paypal').hide();
            $('form#practitioner-registration .field.paypal input[type="text"]').val('');
        } else if($(this).val() === 'Paypal') {
            $('form#practitioner-registration .field.paypal').show();

            $('form#practitioner-registration .field.bank-details').hide();
            $('form#practitioner-registration .field.bank-details input[type="text"]').val('');
        }
      });

    });
  })(jQuery);
</script>