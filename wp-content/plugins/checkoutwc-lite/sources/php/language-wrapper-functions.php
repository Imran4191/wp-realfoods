<?php
/**
 * These are wrapper language functions for referencing other translation domains within CFW
 *
 * This prevents Poedit confusion: https://glueckpress.com/6651/excluding-text-domains/
 *
 * poedit automatically looks for __(), _e(), esc_html__(), etc
 * and it doesn't parse domain
 * so putting a thin wrapper around these functions let's you ignore any string you want while perserving the functionality
 *
 * @package CheckoutWC/Language
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Wrapper for __() gettext function.
 *
 * @param  string $text     Translatable text string.
 * @param  string $domain Text domain, default: default.
 * @return string Translated string
 */
function cfw__( $text, $domain = 'default' ) {
	return __( $text, $domain ); // phpcs:ignore
}

function cfw_notranslate__( $text, $domain = 'default' ) { // phpcs:ignore
	return $text;
}

/**
 * @param string $text Translatable text string.
 * @param string $domain Text domain, default: default.
 *
 * @return string
 */
function cfw_esc_attr__( $text, $domain = 'default' ) {
	return  esc_attr__( $text, $domain ); // phpcs:ignore
}

/**
 * @param string $text Translatable text string.
 * @param string $domain Text domain, default: default.
 *
 * @return string
 */
function cfw_esc_html__( $text, $domain = 'default' ) {
	return esc_html__( $text, $domain ); // phpcs:ignore
}

/**
 * @param string $text Translatable text string.
 * @param string $domain Text domain, default: default.
 */
function cfw_e( $text, $domain = 'default' ) {
	echo __( $text, $domain ); // phpcs:ignore
}

/**
 * @param string $text Translatable text string.
 * @param string $domain Text domain, default: default.
 */
function cfw_esc_attr_e( $text, $domain = 'default' ) {
	echo esc_attr__( $text, $domain ); // phpcs:ignore
}

/**
 * @param string $text Translatable text string.
 * @param string $domain Text domain, default: default.
 */
function cfw_esc_html_e( $text, $domain = 'default' ) {
	echo esc_html( translate( $text, $domain ) ); // phpcs:ignore
}

/**
 * @param string $text Translatable text string.
 * @param string $context Context for translation.
 * @param string $domain Text domain, default: default.
 *
 * @return string
 */
function cfw_x( $text, $context, $domain = 'default' ) {
	return _x( $text, $context, $domain ); // phpcs:ignore
}

/**
 * @param string $text Translatable text string.
 * @param string $context Context for translation.
 * @param string $domain Text domain, default: default.
 */
function cfw_ex( $text, $context, $domain = 'default' ) {
	echo _x( $text, $context, $domain ); // phpcs:ignore
}

/**
 * @param string $text Translatable text string.
 * @param string $context Context for translation.
 * @param string $domain Text domain, default: default.
 *
 * @return string|void
 */
function cfw_esc_attr_x( $text, $context, $domain = 'default' ) {
	return esc_attr( translate_with_gettext_context( $text, $context, $domain ) ); // phpcs:ignore
}

/**
 * @param string $text Translatable text string.
 * @param string $context Context for translation.
 * @param string $domain Text domain, default: default.
 *
 * @return string
 */
function cfw_esc_html_x( $text, $context, $domain = 'default' ) {
	return esc_html( translate_with_gettext_context( $text, $context, $domain ) ); // phpcs:ignore
}

/**
 * @param string $single Single form of the text.
 * @param string $plural Plural form of the text.
 * @param int    $number Number of items.
 * @param string $domain Text domain, default: default.
 *
 * @return string
 */
function cfw_n( $single, $plural, $number, $domain = 'default' ) {
	return _n( $single, $plural, $number, $domain = 'default' ); // phpcs:ignore
}

/**
 * @param string $single Single form of the text.
 * @param string $plural Plural form of the text.
 * @param int    $number Number of items.
 * @param string $context Context for translation.
 * @param string $domain Text domain, default: default.
 *
 * @return string
 */
function cfw_nx( $single, $plural, $number, $context, $domain = 'default' ) {
	return _nx( $single, $plural, $number, $context, $domain = 'default' ); // phpcs:ignore
}
