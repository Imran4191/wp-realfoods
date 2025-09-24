<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<div class="account-header-wrapper edit-account">
    <section class="account-header customer_account_edit">
        <h2><?php echo __('My Account Details', 'storefrontchild'); ?></h2>
    </section>
</div>
<div class="account-intro">
    <div class="content-main">
        <div class="row">
            <div class="col-8 offset-2 col-sm-4 offset-sm-0 offset-lg-1 col-lg-3 offset-xl-2 col-xl-2">
                <div class="avatar-image">
                    <img src="<?php echo get_theme_file_uri()?>/assets/images/account_icon.svg" class="customer-avatar">
                </div>
            </div>
            <div class="col-sm-12 col-lg-7 col-xl-6">
                <div class="account-intro-main">
                    <h3><?php echo __('About your information', 'storefrontchild'); ?></h3>
                    <p><?php echo __('This is the home for all your main contact information and account settings. Make sure you upload a square shaped image of yourself to truly personalise your Rosita experience.', 'storefrontchild'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="account-content-wrapper">
    <div class="content-main">
        <div class="row">
            <div class="col-xl-8 offset-xl-2 account-edit-form">
                <form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >
                    <input type="hidden" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" />
                    <div class="fieldset info row">
                        <div class="col-12">
                            <legend class="legend"><span><?php echo __('Your Details', 'storefrontchild'); ?></span></legend>
                        </div>
                        <?php do_action( 'woocommerce_edit_account_form_start' ); ?>
                        <div class="col-12 col-md-4 col-xl-2">
                            <div class="field field-name-prefix ">
                                <label class="label" for="prefix"><span><?php echo __('Prefix', 'storefrontchild'); ?></span></label> 
                                <div class="control">
                                    <?php $prefix_array=['Mr','Mrs','Ms','Miss','Dr','Prof']; ?>
                                    <select id="prefix" name="Prefix" title="Prefix" class="rrf-select">
                                        <option value=""></option>
                                        <?php foreach($prefix_array as $prefix) { ?>
                                            <option value="<?php echo $prefix; ?>" <?php if($user->Prefix == $prefix) { echo 'selected'; } ?>><?php echo $prefix; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-xl-5">
                            <div class="field field-name-firstname required">
                                <label class="label" for="account_first_name"><span><?php echo __('First Name', 'storefrontchild'); ?></span></label> 
                                <div class="control">
                                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" required="true" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-xl-5">
                            <div class="field field-name-lastname required">
                                <label class="label" for="account_last_name"><span><?php echo __('Last Name', 'storefrontchild'); ?></span></label> 
                                <div class="control">
                                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" required="true" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-7 col-xl-8">
                            <div class="field field-email required">
                                <label class="label" for="account_email"><span><?php echo __('Email', 'storefrontchild'); ?></span></label> 
                                <div class="control">
                                    <input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" required="true" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-5 col-xl-4 field date field-dob">
                            <label class="label" for="dob"><span><?php echo __('Date of Birth', 'storefrontchild'); ?></span></label> 
                            <div class="control customer-dob">
                                <input type="date" name="dob" id="dob" value="<?php echo esc_attr( $user->dob ); ?>" class="dob">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="field field-current-password">
                                <label class="label" for="password_current"><span><?php echo __('Current password', 'storefrontchild'); ?></span></label> 
                                <div class="control">
                                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="field field-new-password">
                                <label class="label" for="password_1"><span><?php echo __('New password', 'storefrontchild'); ?></span></label> 
                                <div class="control">
                                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="field field-confirm-password">
                                <label class="label" for="password_2"><span><?php echo __('Confirm new password', 'storefrontchild'); ?></span></label> 
                                <div class="control">
                                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
                                </div>
                            </div>
                        </div>

                        <?php do_action( 'woocommerce_edit_account_form' ); ?>
                    </div>

                    <div class="actions-toolbar">
                        <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
                        <button type="submit" class="action save primary with-chevron-small woocommerce-Button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="save_account_details" value="<?php esc_attr_e( 'Save my changes', 'storefrontchild' ); ?>"><span><?php esc_html_e( 'Save my changes', 'storefrontchild' ); ?></span></button>
                        <input type="hidden" name="action" value="save_account_details" />
                    </div>

                    <?php do_action( 'woocommerce_edit_account_form_end' ); ?>
                </form>
                <?php do_action( 'woocommerce_after_edit_account_form' ); ?>
            </div>
        </div>
    </div>
</section>
<?php
defined( 'ABSPATH' ) || exit;
UM()->user()->set();
$role = UM()->user()->get_role();
$user_id = UM()->user()->id;
$account_status = get_user_meta($user_id, 'account_status', true);
$show_form = $role == 'um_practitioner';
?>

<?php if( $show_form ): ?>
    <section class="account-content-wrapper">
        <div class="content-main">
            <div class="row">
                <div class="col-xl-8 offset-xl-2 account-edit-form">
                    <form action="" id="practitioner-registration" method="post" enctype="multipart/form-data" class="form-create-account">
                        <input type="hidden" name="role" value="practitioner">
                        <input type="hidden" name="account_status" value="<?php echo $account_status; ?>">
                        <?php wp_nonce_field('practitionerregistration_nonceaction', 'practitionerregistration_nonce'); ?>
                        <fieldset class="fieldset create account account-type-fieldset additional in row">
                            <legend class="legend"><span><?php echo __('Practitioner Information'); ?></span></legend>
                            <div class="col-sm-12 col-md-6 field practitioner_type required">
                                <label for="practitioner_type" class="label"><span><?php echo __('Please Select your practitioner
                                        type'); ?></span></label>
                                <div class="control">
                                    <?php $type_options = array("Aroma Therapist","Chiropractor / Osteopath","Colonic Hydrotherapist","Dentist","Herbalist","Massage Therapist","Medical Doctor","Nutritionist / Naturopath","Personal Trainer (including biosig)","Pharmacist (including chemist)","Reiki & Chinese Medicine","Reflexologist","Functional Diagnostic Nutrition","Functional Medicine Practitioner","Other"); ?>
                                    <?php
                                        $user_id = get_current_user_id();
                                        $meta_value = get_user_meta($user_id, 'practitioner_type', true);
                                    ?>
                                    <select name="practitioner_type" id="practitioner_type"
                                        class="input-text required-entry other" data-other="practitioner_type_other">
                                        <option value=""><?php echo __('Please Select'); ?></option>
                                        <?php foreach ($type_options as $value) : ?>
                                            <option value="<?php echo $value; ?>" <?php if($meta_value==$value) echo 'selected'; ?> ><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 field practitioner_type_other required">
                                <label for="practitioner_type_other" class="label"><span><?php echo __('Practitioner type
                                        (other)'); ?></span></label>
                                <div class="control">
                                    <input type="text" name="practitioner_type_other" value="<?php echo get_user_meta($user_id, 'practitioner_type_other', true); ?>" id="practitioner_type_other"
                                        class="input-text required-entry" disabled="">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 field practitioner_qualification required">
                                <label for="practitioner_qualification" class="label"><span><?php echo __('Level Of
                                        Qualification'); ?></span></label>
                                <div class="control">
                                    <?php $qualifications_options = array("Student","Certificate","Diploma","Degree","Masters","PHD","Other"); ?>
                                    <?php $meta_value = get_user_meta($user_id, 'practitioner_qualification', true); ?>
                                    <select name="practitioner_qualification" id="practitioner_qualification"
                                        class="input-text required-entry other" data-other="practitioner_qual_other">
                                        <option value=""><?php echo __('Please Select'); ?></option>
                                        <?php foreach ($qualifications_options as $value) : ?>
                                            <option value="<?php echo $value; ?>" <?php if($meta_value==$value) echo 'selected'; ?> ><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 field practitioner_qual_other required">
                                <label for="practitioner_qual_other" class="label"><span><?php echo __('Practitioner qualification
                                        (other)'); ?></span></label>
                                <div class="control">
                                    <input type="text" name="practitioner_qual_other" value="<?php echo get_user_meta($user_id, 'practitioner_qual_other', true); ?>" id="practitioner_qual_other"
                                        class="input-text required-entry" disabled="">
                                </div>
                            </div>
                            <?php $certificate_file = get_user_meta($user_id, 'practitioner_certificate', true); ?>
                            <div class="col-sm-12 field practitioner_certificate <?php if (empty($certificate_file)) echo 'required'; ?>">
                                <label for="practitioner_certificate" class="label"><span><?php echo __('Practitioner
                                        Certificate'); ?></span></label>
                                <div class="control">
                                    <input type="hidden" name="practitioner_certificate_prev" id="practitioner_certificate_prev" value="<?php echo $certificate_file; ?>">
                                    <input type="file" name="practitioner_certificate" value="<?php echo get_user_meta($user_id, 'practitioner_certificate', true); ?>"
                                        id="practitioner_certificate" class="input-text <?php if (empty($certificate_file)) echo 'required-entry'; ?>">
                                    <?php if (!empty($certificate_file)) {
                                        echo '<p>Uploaded file: ' . $certificate_file . '</p>';
                                    } ?>
                                </div>
                            </div>
                            <div class="col-sm-12 field practitioner_associations ">
                                <label for="practitioner_associations" class="label"><span><?php echo __('Please list the professional
                                        associations you belong to'); ?></span></label>
                                <div class="control">
                                    <textarea name="practitioner_associations" id="practitioner_associations"
                                        class="input-text " rows="5"><?php echo esc_attr( get_user_meta($user_id, 'practitioner_associations', true)) ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 field practitioner_description required">
                                <label for="practitioner_description" class="label"><span><?php echo __('Describe your company or
                                        practice'); ?></span></label>
                                <div class="control">
                                    <textarea name="practitioner_description" id="practitioner_description"
                                        class="input-text required-entry" rows="5"><?php echo esc_attr( get_user_meta($user_id, 'practitioner_description', true)) ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 field practitioner_how_long required">
                                <label for="practitioner_how_long" class="label"><span><?php echo __('How long have you been in
                                        business?'); ?></span></label>
                                <?php $how_long_options = array("Under 1 Year","1-2 Years","2-5 Years","5-10 Years","Over 10 Years"); ?>
                                <?php $meta_value = get_user_meta($user_id, 'practitioner_how_long', true); ?>
                                <div class="control">
                                    <select name="practitioner_how_long" id="practitioner_how_long" class="input-text ">
                                        <option value=""><?php echo __('Please Select'); ?></option>
                                        <?php foreach ($how_long_options as $value) : ?>
                                            <option value="<?php echo $value; ?>" <?php if($meta_value==$value) echo 'selected'; ?> ><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div id="practitioner_how_long-errortxt" class="custom-error"></div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-5 field practitioner_how_many ">
                                <?php $numbers_options = array(1,2,3,4,5,6,7,8,9,"10+"); ?>
                                <?php $meta_value = get_user_meta($user_id, 'practitioner_how_many', true); ?>
                                <label for="practitioner_how_many" class="label"><span><?php echo __('How many practitioners does your
                                        practice have?'); ?></span></label>
                                <div class="control">
                                    <select name="practitioner_how_many" id="practitioner_how_many" class="input-text ">
                                        <option value=""><?php echo __('Please Select'); ?></option>
                                        <?php foreach ($numbers_options as $value) : ?>
                                            <option value="<?php echo $value; ?>" <?php if($meta_value==$value) echo 'selected'; ?> ><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-7 field practitioner_annual required">
                                <label for="practitioner_annual" class="label"><span><?php echo __('What is your anticipated annual order
                                        volume from Functional Self in £?'); ?></span></label>
                                <?php $annual_options = array("0-500","501-2000","2001-5000","5001-10000","10000+"); ?>
                                <?php $meta_value = get_user_meta($user_id, 'practitioner_annual', true); ?>
                                <div class="control">
                                    <select name="practitioner_annual" id="practitioner_annual"
                                        class="input-text required-entry">
                                        <option value=""><?php echo __('Please Select'); ?></option>
                                        <?php foreach ($annual_options as $value) : ?>
                                            <option value="<?php echo $value; ?>" <?php if($meta_value==$value) echo 'selected'; ?> ><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6 field practitioner_num_clients required">
                                <label for="practitioner_num_clients" class="label"><span><?php echo __('Number of unique clients you see
                                        each week'); ?></span></label>
                                <?php $num_clients_options = array("1-5","6-10","11-15","16-20","20+"); ?>
                                <?php $meta_value = get_user_meta($user_id, 'practitioner_num_clients', true); ?>
                                <div class="control">
                                    <select name="practitioner_num_clients" id="practitioner_num_clients"
                                        class="input-text required-entry">
                                        <option value=""><?php echo __('Please Select'); ?></option>
                                        <?php foreach ($num_clients_options as $value) : ?>
                                            <option value="<?php echo $value; ?>" <?php if($meta_value==$value) echo 'selected'; ?> ><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <legend class="legend payment_information" style="clear: left;"><span><?php echo __('Payment Information'); ?></span>
                            </legend>
                            <div class="col-sm-12 field payment_details required">
                                <div class="col-md-4">
                                    <label for="payment_details" class="label"><span><?php echo __('Payment Options'); ?></span></label>
                                    <?php $payment_options = array("Bank Transfer","Paypal"); ?>
                                    <?php $payment_details_value = get_user_meta($user_id, 'payment_details', true); ?>
                                    <div class="control">
                                        <select name="payment_details" id="payment_details" class="input-text required-entry">
                                            <option value=""><?php echo __('Please Select'); ?></option>
                                            <?php foreach ($payment_options as $value) : ?>
                                                <option value="<?php echo $value; ?>" <?php if($payment_details_value==$value) echo 'selected'; ?> ><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div id="payment_details-errortxt" class="custom-error"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 field account_name required bank-details" style="<?php if($payment_details_value=='Bank Transfer') echo 'display: block;'; ?>">
                                <label for="account_name" class="label"><span><?php echo __('Account Name'); ?></span></label>
                                <div class="control">
                                    <input type="text" name="account_name" value="<?php echo esc_attr( get_user_meta($user_id, 'account_name', true)) ?>" id="account_name"
                                        class="input-text required-entry" >
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 field sort_code required bank-details" style="<?php if($payment_details_value=='Bank Transfer') echo 'display: block;'; ?>">
                                <label for="sort_code" class="label"><span><?php echo __('Sort Code'); ?></span></label>
                                <div class="control">
                                    <input type="text" name="sort_code" value="<?php echo esc_attr( get_user_meta($user_id, 'sort_code', true)) ?>" id="sort_code"
                                        class="input-text required-entry" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 field bank_account required bank-details" style="<?php if($payment_details_value=='Bank Transfer') echo 'display: block;'; ?>">
                                <label for="bank_account" class="label"><span><?php echo __('Bank Account Number'); ?></span></label>
                                <div class="control">
                                    <input type="text" name="bank_account" value="<?php echo esc_attr( get_user_meta($user_id, 'bank_account', true)) ?>" id="bank_account"
                                        class="input-text required-entry" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6 field paypal_account required paypal" style="<?php if($payment_details_value=='Paypal') echo 'display: block;'; ?>">
                                <label for="paypal_account" class="label"><span><?php echo __('PayPal Account Email'); ?></span></label>
                                <div class="control">
                                    <input type="email" name="paypal_account" value="<?php echo esc_attr( get_user_meta($user_id, 'paypal_account', true)) ?>" id="paypal_account"
                                        class="input-text required-entry">
                                </div>
                            </div>
                        </fieldset>
                        
                        <div class="actions-toolbar">
                            <div class="primary"><button type="submit" class="action submit primary save-practitioner"
                                    title="Save Practitioner"><span><?php echo __('Save My Changes'); ?></span></button></div>
                        </div>
                        <div id="processing-feedback"></div>
                        
                    </form>
                <?php endif; ?>
                <div id="pr-loading"><img src="<?php echo get_theme_file_uri()?>/assets/images/spinner.gif" alt="Loading..." /></div>
            </div>
        </div>
    </div>
</section>               
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
                required: {
                    depends: function(element) {
                        return $("#practitioner_certificate_prev").val() == '';
                    }
                }
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
                    $('#processing-feedback').html('<p style="color:#05b1a9;font-size:20px;text-align:center;">Your changes are updated now</p>');
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

      $('#payment_details').on('change',function() {
        let fieldgroup = $(this).data('fieldgroup');
        if ($(this).val() === 'Bank Transfer') {
            $('form#practitioner-registration .field.bank-details').show();
            $('form#practitioner-registration .field.bank-details input[type="text"]').prop('disabled', false);

            $('form#practitioner-registration .field.paypal').hide();
            //$('form#practitioner-registration .field.paypal input[type="text"]').val('');
            $('form#practitioner-registration .field.paypal input[type="text"]').prop('disabled', true);
        } else if($(this).val() === 'Paypal') {
            $('form#practitioner-registration .field.paypal').show();
            $('form#practitioner-registration .field.paypal input[type="text"]').prop('disabled', false);

            $('form#practitioner-registration .field.bank-details').hide();
            //$('form#practitioner-registration .field.bank-details input[type="text"]').val('');
            $('form#practitioner-registration .field.bank-details input[type="text"]').prop('disabled', true);
        }
      });

    });
  })(jQuery);
</script>