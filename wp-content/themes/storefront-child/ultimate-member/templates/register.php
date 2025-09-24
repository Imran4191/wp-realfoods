<?php
/**
 * Template for the register page
 *
 * This template can be overridden by copying it to yourtheme/ultimate-member/templates/register.php
 *
 * Page: "Register"
 *
 * @version 2.7.0
 *
 * @var string $mode
 * @var int    $form_id
 * @var array  $args
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_user_logged_in() ) {
	um_reset_user();
}
?>

<div class="um <?php echo esc_attr( $this->get_class( $mode ) ); ?> um-<?php echo esc_attr( $form_id ); ?>">
	<div class="um-form" data-mode="<?php echo esc_attr( $mode ); ?>">
		<form method="post" action="">
			<?php
			/** This action is documented in includes/core/um-actions-profile.php */
			do_action( 'um_before_form', $args );
			/** This action is documented in includes/core/um-actions-profile.php */
			do_action( "um_before_{$mode}_fields", $args );
			/** This action is documented in includes/core/um-actions-profile.php */
			do_action( "um_main_{$mode}_fields", $args );
			/** This action is documented in includes/core/um-actions-profile.php */
			do_action( 'um_after_form_fields', $args ); // should add here the captcha
			/** This action is documented in includes/core/um-actions-profile.php */
			do_action( "um_after_{$mode}_fields", $args );
			/** This action is documented in includes/core/um-actions-profile.php */
			do_action( 'um_after_form', $args );
			?>
		</form>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function ($) {

		let accounttype = $('.customer-account-type label.um-field-radio input[type="radio"]:checked').val();
		let showshipping = $('#rosita-customer-registration input[type="checkbox"][name="different_billing_shipping[]"]').is(':checked');
		toggle_displays(accounttype, showshipping);

		function toggle_displays(role, show_shipping) {
			
			let role_sections_permission = {
				'um_retail' : {
					'allowed' : [],
					'disallowed' : ['customer-pensioner-information','customer-practitioner-information','customer-practitioner-client-information','practitioner-payment-information']
				},
				'um_pensioner' : {
					'allowed' : ['customer-pensioner-information'],
					'disallowed' : ['customer-practitioner-information','customer-practitioner-client-information','practitioner-payment-information']
				},
				'um_practitioner' : {
					'allowed' : ['customer-practitioner-information','practitioner-payment-information'],
					'disallowed' : ['customer-pensioner-information','customer-practitioner-client-information']
				},
				'um_practitioner-client' : {
					'allowed' : ['customer-practitioner-client-information'],
					'disallowed' : ['customer-pensioner-information','customer-practitioner-information','practitioner-payment-information']
				},
				'um_reseller' : {
					'allowed' : [],
					'disallowed' : ['customer-pensioner-information','customer-practitioner-information','customer-practitioner-client-information','practitioner-payment-information']
				}
			};

			current_role_permission = role_sections_permission[role] || false;

			if( current_role_permission ) {
				let allowed_section = current_role_permission.allowed;
				
				$(allowed_section).each(function(index, section_name){
					$('#rosita-customer-registration .' + section_name).show();
					$('#rosita-customer-registration .' + section_name + '-header').show();
				});

				let disallowed_section = current_role_permission.disallowed;
				
				$(disallowed_section).each(function(index, section_name){
					$('#rosita-customer-registration .' + section_name).hide();
					$('#rosita-customer-registration .' + section_name + '-header').hide();
				});

				if(show_shipping){
					$('#rosita-customer-registration .customer-shipping-information-header').show();
					$('#rosita-customer-registration .customer-shipping-information').show();
				}else{
					$('#rosita-customer-registration .customer-shipping-information-header').hide();
					$('#rosita-customer-registration .customer-shipping-information').hide();
				}

			}

		}

		$('.customer-account-type label.um-field-radio input[type="radio"]').on('click', function () {
			let account_type = $(this).val();
			let show_shipping = $('#rosita-customer-registration input[type="checkbox"][name="different_billing_shipping[]"]').is(':checked');
			toggle_displays(account_type, show_shipping);

			if(account_type == 'um_reseller') {
				// redirect to another page for reseller registration
				window.location.href = '/reseller';
			};
			
		});

		$('#rosita-customer-registration input[type="checkbox"][name="different_billing_shipping[]"]').on('click',function(){
			let account_type = $('.customer-account-type label.um-field-radio input[type="radio"]:checked').val();
			let show_shipping = $(this).is(':checked');
			toggle_displays(account_type, show_shipping);
		});

		

	});
</script>