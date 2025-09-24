<?php
/**
 * Woo Address Book
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address-book.php.
 *
 * HOWEVER, on occasion Woo Address Book will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @package WooCommerce Address Book/Templates
 * @version 1.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$wc_address_book = WC_Address_Book::get_instance();

$woo_address_book_customer_id           = get_current_user_id();
$woo_address_book_billing_address_book  = $wc_address_book->get_address_book( $woo_address_book_customer_id, 'billing' );
$woo_address_book_shipping_address_book = $wc_address_book->get_address_book( $woo_address_book_customer_id, 'shipping' );
?>
<section class="account-content-wrapper saved-address">
   <div class="content-main">
      <div class="row">
         <div class="col-xl-8 offset-xl-2 customer-account-edit-form">
		 	<div class="block block-dashboard-addresses">
			 	<div class="block-content">
					<?php
					if ( ! $type ) {
						if ( $wc_address_book->get_wcab_option( 'billing_enable' ) === true ) {
							$woo_address_book_billing_address = get_user_meta( $woo_address_book_customer_id, 'billing_address_1', true );

							// Hide the billing address book if there are no addresses to show and no ability to add new ones.
							$count_section = count( $woo_address_book_billing_address_book );
							$save_limit    = get_option( 'woo_address_book_billing_save_limit', 0 );

							if ( 1 == $save_limit && $count_section <= 1 ) {
								$hide_billing_address_book = true;
							} else {
								$hide_billing_address_book = false;
							}

							// Only display if primary addresses are set and not on an edit page.
							if ( ! empty( $woo_address_book_billing_address ) && ! $hide_billing_address_book ) {
								?>

								<div class="box box-billing-address" data-addresses='<?php echo $count_section; ?>' data-limit='<?php echo $save_limit; ?>'>
									<strong class="box-title">
										<span><?php echo __('Saved Billing Address', 'storefrontchild')?></span>
									</strong>
									<div class="addresses address-book">
										<?php

										foreach ( $woo_address_book_billing_address_book as $woo_address_book_name => $woo_address_book_fields ) {
											// Prevent default billing from displaying here.
											if ( 'billing' === $woo_address_book_name ) {
												continue;
											}

											$woo_address_book_address = apply_filters(
												'woocommerce_my_account_my_address_formatted_address',
												array(
													'first_name' => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_first_name', true ),
													'last_name'  => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_last_name', true ),
													'company'    => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_company', true ),
													'address_1'  => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_address_1', true ),
													'address_2'  => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_address_2', true ),
													'city'       => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_city', true ),
													'state'      => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_state', true ),
													'postcode'   => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_postcode', true ),
													'country'    => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_country', true ),
												),
												$woo_address_book_customer_id,
												$woo_address_book_name
											);

											$woo_address_book_formatted_address = WC()->countries->get_formatted_address( $woo_address_book_address );

											if ( $woo_address_book_formatted_address ) {
												?>

												<div class="wc-address-book-address">
													<address>
														<?php echo wp_kses( $woo_address_book_formatted_address, array( 'br' => array() ) ); ?>
														<?php 
															$phone_number = get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_phone', true );
															if($phone_number)
																echo '<br> ' . 'T: ' . $phone_number;
														?>
													</address>
													<div class="wc-address-book-meta">
														<a href="<?php echo esc_url( $wc_address_book->get_address_book_endpoint_url( $woo_address_book_name, 'billing' ) ); ?>" class="wc-address-book-edit"><?php echo esc_attr__( 'Edit', 'woo-address-book' ); ?></a>
														<a id="<?php echo esc_attr( $woo_address_book_name ); ?>" class="wc-address-book-delete"><?php echo esc_attr__( 'Delete', 'woo-address-book' ); ?></a>
														<a id="<?php echo esc_attr( $woo_address_book_name ); ?>" class="wc-address-book-make-primary"><?php echo esc_attr__( 'Make Default', 'woo-address-book' ); ?></a>
													</div>
												</div>

												<?php
											}
										}
										?>
									</div>
									<?php
										$wc_address_book->add_additional_address_button( 'billing' );
									?>
								</div>
								<?php
							}
						}

						if ( $wc_address_book->get_wcab_option( 'shipping_enable' ) === true ) {
							$woo_address_book_shipping_address = get_user_meta( $woo_address_book_customer_id, 'shipping_address_1', true );

							// Hide the billing address book if there are no addresses to show and no ability to add new ones.
							$count_section = count( $woo_address_book_shipping_address_book );
							$save_limit    = intval( get_option( 'woo_address_book_shipping_save_limit', 0 ) );

							if ( 1 == $save_limit && $count_section <= 1 ) {
								$hide_shipping_address_book = true;
							} else {
								$hide_shipping_address_book = false;
							}

							// Only display if primary addresses are set and not on an edit page.
							if ( ! empty( $woo_address_book_shipping_address ) && ! $hide_shipping_address_book ) {
								?>

								<div class="box box-billing-address" data-addresses='<?php echo esc_attr( $count_section ); ?>' data-limit='<?php echo esc_attr( $save_limit ); ?>'>

									<strong class="box-title shipping-title">
										<span><?php echo __('Saved Shipping Address', 'storefrontchild')?></span>
									</strong>

									<?php
									if ( ! wc_ship_to_billing_address_only() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) {
										echo '<div class="col2-set addresses address-book">';
									}

									foreach ( $woo_address_book_shipping_address_book as $woo_address_book_name => $woo_address_book_fields ) {

										// Prevent default shipping from displaying here.
										if ( 'shipping' === $woo_address_book_name ) {
											continue;
										}

										$woo_address_book_address = apply_filters(
											'woocommerce_my_account_my_address_formatted_address',
											array(
												'first_name' => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_first_name', true ),
												'last_name'  => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_last_name', true ),
												'company'    => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_company', true ),
												'address_1'  => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_address_1', true ),
												'address_2'  => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_address_2', true ),
												'city'       => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_city', true ),
												'state'      => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_state', true ),
												'postcode'   => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_postcode', true ),
												'country'    => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_country', true ),
												'phone'      => get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_phone', true ),
											),
											$woo_address_book_customer_id,
											$woo_address_book_name
										);

										$woo_address_book_formatted_address = WC()->countries->get_formatted_address( $woo_address_book_address );

										if ( $woo_address_book_formatted_address ) {
											?>
											<div class="wc-address-book-address">
												<address>
													<?php echo wp_kses( $woo_address_book_formatted_address, array( 'br' => array() ) ); ?>
													<?php 
														$phone_number = get_user_meta( $woo_address_book_customer_id, $woo_address_book_name . '_phone', true );
														if($phone_number)
															echo '<br> ' . 'T: ' . $phone_number;
													?>
												</address>
												<div class="wc-address-book-meta">
													<a href="<?php echo esc_url( $wc_address_book->get_address_book_endpoint_url( $woo_address_book_name, 'shipping' ) ); ?>" class="wc-address-book-edit"><?php echo esc_attr__( 'Edit', 'woo-address-book' ); ?></a>
													<a id="<?php echo esc_attr( $woo_address_book_name ); ?>" class="wc-address-book-delete"><?php echo esc_attr__( 'Delete', 'woo-address-book' ); ?></a>
													<a id="<?php echo esc_attr( $woo_address_book_name ); ?>" class="wc-address-book-make-primary"><?php echo esc_attr__( 'Make Default', 'woo-address-book' ); ?></a>
												</div>
											</div>
											<?php
										}
									}

									if ( ! wc_ship_to_billing_address_only() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) {
										echo '</div>';
									}
									?>
									<?php
										$wc_address_book->add_additional_address_button( 'shipping' );
									?>
								</div>
								<?php
							}
						}
					}?>
				</div>
			</div>
		 </div>
	  </div>
	</div>
</section>

