=== WooCommerce PDF Invoices, Packing Slips and Credit Notes (Pro) ===
Contributors: Webtoffee
Version: 1.4.0
Tags: woocommerce invoice, woocommerce invoice generator, woocommerce send invoice, woocommerce invoice email, woocommerce receipt plugin, woocommerce vat invoice, woocommerce pdf invoices, woocommerce custom invoice, Packinglist, Invoice printing, Credit note, Wordpress
Requires at least: 3.0.1
Requires PHP: 5.6
Tested up to: 6.4
Stable tag: 1.4.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WooCommerce PDF Invoices, Packing Slips and Credit Notes (Pro)

== Description ==

== Screenshots ==

== Installation ==

1. Upload `wt-woocommerce-invoice-addon` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

= 1.4.0 2024-03-14 =
* [Fix] - Resolved the error message "Uncaught Error: Interface" that occurred upon activating the plugin
* [Tweak] -Implemented user role restrictions to display the "Pay Later" payment gateway on the checkout page
* [Enhancement] - Updated the license manager with EDD updater functionality
* [Compatibility] - Tested OK with WooCommerce v8.6.1

= 1.3.0 2024-02-13 =
* [Tweak] - Hide the shipping address if it is empty
* [Tweak] - Hide the shipping address if order has the only local pickup as the shipping option
* [Enhancement] - WooCommerce Checkout block compatibility - Custom fields
* [Enhancement] - WooCommerce Checkout block compatibility - Paylater payment gateway
* [Compatibility] - Tested OK with WooCommerce v8.5.2

= 1.2.0 2024-01-17 =
* [Enhancement] - Added a filter to sort the category names when the group by category option is checked in the invoice and packing slip settings page
* [Enhancement] - Filter to alter the print and download document button label in email, my account order listing, and my account order details page
* [Enhancement] - Sync the Address format in the document with the WC formatted address
* [Compatibility] - Tested OK with WooCommerce v8.5.1

= 1.1.0 2023-12-11 =
* [Fix] - Remove str_contains() to avoid the PHP lower version error
* [Tweak] - Templates of invoices, packing slips, and credit notes are improved
* [Tweak] - Display the value of the checkout field added using this plugin on the order details page
* [Tweak] - Weight - Hide if it is 0 or not available
* [Enhancement] - Multi-language compatibility
* [Enhancement] - Option to skip to print the virtual items and back order items on the packing slip product table
* [Enhancement] - Display YITH gift card details on the invoice when applied to the order
* [Compatibility] - Tested OK with WooCommerce v8.3.1

= 1.0.6 2023-11-13 =
* [Fix] - Tax classes placeholder was shown even if there is no tax applied on the order
* [Add] - Added an option to show the vendor address on the vendor’s order documents if the dokan multi vendor plugin is active
* [Add] - Added an option to customize the credit note PDF document name
* [Enhancement] - Showed the deleted/imported products on the documents
* [Enhancement] - Updated the UI of invoice number format and credit note number format settings
* [Compatibility] - Added the compatibility with the WebToffee Email decorator and Kadence Email decorator plugins
* [Compatibility] - Tested okay with WordPress v6.4.1
* [Compatibility] - Tested okay with WooCommerce v8.2.2

= 1.0.5 2023-09-21 =
* [Compatibility] - Tested okay with WordPress v6.3.1
* [Compatibility] - Tested okay with WooCommerce v8.1.1

= 1.0.4 2023-09-06 =
* [Fix] - wf_pklist_alter_shipping_from_address filter is not working properly in invoice basic template with invoice add-on
* [Fix] - The value for order meta was not showing on the invoice when the ACF plugin was active
* [Fix] - Compatibility fatal error with the Kadence email customizer plugin
* [Fix] - Value not displayed when adding product meta as a separate column in the product table using the customizer add-on
* [Fix] - Plugin update check through the license manager
* [Fix] - Changing the file name for the packing slip
* [Fix] - Show the value for the regular price and regular total price column in the invoice and the packing slip when working with customizer add-on
* [Fix] - Updated and fixed the German translation issue
* [Tweak] - Added the support to show the value for the discount price column added through the customizer add-on
* [Enhancement] - The user can add product attributes as a separate column in the product table using the customizer add-on
* [Enhancement] - Displaying the bundle product depends on the packaging type and the bundle product display option in the packing slip
* [Enhancement] - Improved the translation
* [Compatibility] - Tested okay with the customizer add-on v1.0.1
* [Compatibility] - Tested okay with WordPress v6.3.1
* [Compatibility] - Tested okay with WooCommerce v8.0.3

= 1.0.3 2023-07-07 =
* [Tweak] - Added customer note, VAT, and SSN as separate placeholders in the templates
* [Tweak] - Added Save and Activate button in the Invoice, Packing slip, and Credit note customizer
* [Enhancement] - Optimized loading time when bulk printing the documents
* [Enhancement] - Icons to identify whether an invoice or packing slip is already printed or downloaded
* [Enhancement] - Added compatibility with WooCommerce High-Performance Order Storage (HPOS) Table feature
* [Enhancement] - Moved the default order meta fields such as email, phone number, customer note, VAT, and SSN from the Settings page to the Customizer
* [Enhancement] - Added compatibility with Customizer for WooCommerce PDF Invoices add-on (Pro) by WebToffee
* [Compatibility] - Tested OK with WooCommerce v7.8.2

= 1.0.2 2023-03-06 =
* [Fix] - CRITICAL Uncaught Error: Access to an undeclared static property of $return_dummy_invoice_number variable
* [Fix] - The order meta option in the packing slip - advanced tab could not be saved
* [Fix] - Unable to hide the tax items column in product table
* [Tweak] - Notify the user when using the basic template in the pro-add-on or when using the premium template in the basic plugin
* [Compatibility] - Compatibility with WooCommerce upto v7.4.1

= 1.0.1 =
* [Fix] - Added the placeholder for the payment received a stamp for the premium invoice templates
* [Fix] - SKU Based sorting was not working properly when SKUs are numerical order
* [Tweak] - Added a filter to use the billing address as the shipping address or hide the shipping address field when the shipping address is empty
* [Enhancement] - Added an option to create the credit notes for the chosen orders statuses only if the respective order has any refund
* [Enhancement] - Added an option to create credit notes manually from the order details page if the order has any refund
* [Compatibility] - Added the compatibility of the print node add-on from v1.0.4
* [Compatibility] - with WC v7.3.0

= 1.0.0 =
* Initial version

== Upgrade Notice ==

= 1.4.0 =
* [Fix] - Resolved the error message "Uncaught Error: Interface" that occurred upon activating the plugin
* [Tweak] -Implemented user role restrictions to display the "Pay Later" payment gateway on the checkout page
* [Enhancement] - Updated the license manager with EDD updater functionality
* [Compatibility] - Tested OK with WooCommerce v8.6.1