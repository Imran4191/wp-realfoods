<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
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

$page_title = ( 'billing' === $load_address ) ? esc_html__( 'Billing address', 'woocommerce' ) : esc_html__( 'Shipping address', 'woocommerce' );

do_action( 'woocommerce_before_edit_account_address_form' ); ?>




<?php if ( ! $load_address ) : ?>
	<?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>
    <div class="account-header-wrapper address-book">
    <section class="account-header customer_address_index" style="">
        <h1>Edit Addresses</h1>
    </section>
    <div class="account-intro">
        <div class="container">
            <div class="row"></div>
            <div class="row">
                <div class="col-8 offset-2 col-sm-4 offset-sm-0 col-md-offset-1 col-md-3 offset-lg-2 col-lg-2">
                    <?php 
                        $image_url = get_stylesheet_directory_uri() . '/assets/images/Address_icon.svg'; // Dynamic image URL 
                    ?>
                    <div class="avatar-image"><img src="<?php echo $image_url ?>" alt="" class="customer-avatar"></div>
                </div>
                <div class="col-12 col-sm-8 col-md-7 col-lg-6">
                    <div class="account-intro--main">
                        <h3>My Online Black Book</h3>
                        <p>Most of us when shopping have multiple addresses we generally use, be it your home address, workplace or even friends and family. Here you can quickly and easily add or edit as many addresses as you like to help you with your shopping experience.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

	<form class="address-edit-form" method="post">

		<h3><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title, $load_address ); ?></h3><?php // @codingStandardsIgnoreLine ?>

		<div class="woocommerce-address-fields">
			<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>

			<div class="woocommerce-address-fields__field-wrapper">
				<?php
				foreach ( $address as $key => $field ) {
					woocommerce_form_field( $key, $field, wc_get_post_data_by_key( $key, $field['value'] ) );
				}
				?>
			</div>

			<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>

			<p>
				<button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="save_address" value="<?php esc_attr_e( 'Save address', 'woocommerce' ); ?>"><span><?php esc_html_e( 'Save address', 'woocommerce' ); ?></span></button>
				<?php wp_nonce_field( 'woocommerce-edit_address', 'woocommerce-edit-address-nonce' ); ?>
				<input type="hidden" name="action" value="edit_address" />
			</p>
            <div class="back-to-address-book">
                <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', '', wc_get_page_permalink( 'myaccount' ) ) ); ?>">Back
                </a>
            </div>
		</div>

	</form>
    

<?php endif; ?>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>
