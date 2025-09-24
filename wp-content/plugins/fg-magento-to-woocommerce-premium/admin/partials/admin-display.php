<?php

/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wordpress.org/plugins/fg-magento-to-woocommerce/
 * @since      1.0.0
 *pr
 * @package    FG_Magento_to_WooCommerce
 * @subpackage FG_Magento_to_WooCommerce/admin/partials
 */
?>
<div id="fgm2wc_admin_page" class="wrap">
	<h1><?php print $data['title'] ?></h1>
	
	<p><?php print $data['description'] ?></p>
	
	<?php require('database-info.php'); ?>
	
	<?php require('tabs.php'); ?>
	<?php switch ( $data['tab'] ): ?>
<?php case 'help': ?>
	<?php require('help-instructions.tpl.php'); ?>
	<?php require('help-options.tpl.php'); ?>
	<?php break; ?>

<?php case 'debuginfo': ?>
	<?php require('debug-info.php'); ?>
	<?php break; ?>

<?php default: ?>
	<?php require('empty-content.php'); ?>
	
	<form id="form_import" method="post">

		<?php wp_nonce_field( 'parameters_form', 'fgm2wc_nonce' ); ?>

		<table class="form-table">
			<?php require('settings.php'); ?>
			<?php do_action('fgm2wc_post_display_settings_options'); ?>
			<?php require('behavior.php'); ?>
			<?php require('premium-features.php'); ?>
			
			<?php do_action('fgm2wc_post_display_behavior_options'); ?>
			<?php require('actions.php'); ?>
			<?php require('premium-actions.php'); ?>
			<?php require('progress-bar.php'); ?>
			<?php require('logger.php'); ?>
		</table>
	</form>
	
	<?php require('paypal-donate.php'); ?>
<?php endswitch; ?>	
	
</div>
