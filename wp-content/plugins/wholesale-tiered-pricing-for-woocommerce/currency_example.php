<?php
$active_currency = get_woocommerce_currency();
$base_currency   = get_option( 'woocommerce_currency' );
if ( ! empty( $role_price['replace_orignal_price'] ) && 'yes' == $role_price['replace_orignal_price'] ) {

	$converted_amount = apply_filters('wc_aelia_cs_convert', $role_price['discount_value'], $base_currency, $active_currency);
	
	$prices = '<ins class="highlight">' . wc_price( $converted_amount ) . '</ins>';
} else {

	$converted_amount = apply_filters('wc_aelia_cs_convert', $role_price['discount_value'], $base_currency, $active_currency);

	$prices = '<del class="strike">' . wc_price( $pro_price ) . '</del><ins class="highlight">' . wc_price( $converted_amount ) . '</ins>';
}
