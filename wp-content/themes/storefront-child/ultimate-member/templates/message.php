<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

//BWIPIT-2770
$role = $_REQUEST['um_role'];
$message_status = $_REQUEST['message'];
$roles_with_pending_message = ['um_practitioner', 'um_pensioner'];
?>
<div class="um <?php echo esc_attr( $this->get_class( $mode ) ); ?> um-<?php echo esc_attr( $form_id ); ?>">

	<div class="um-postmessage">
		<?php
		// translators: %s: The message after registration process based on a role data and user status after registration
		printf( __( '%s', 'ultimate-member' ), $this->custom_message ); ?>

    <?php if ( in_array($role, $roles_with_pending_message) && $message_status == 'pending' && $mode == 'register'): ?>
      <div class="rosita-homepage-link">
        <a href="<?php echo get_home_url(); ?>">Return to Homepage</a>
      </div>
    <?php endif; ?>
	</div>
</div>
