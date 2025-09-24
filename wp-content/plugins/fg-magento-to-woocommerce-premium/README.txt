=== FG Magento to WooCommerce Premium ===
Contributors: Kerfred
Plugin Uri: https://www.fredericgilles.net/fg-magento-to-woocommerce/
Tags: magento, woocommerce, import, importer, convert magento to wordpress, migrate magento to wordpress, migration, migrator, converter, wpml, dropshipping
Requires at least: 4.5
Tested up to: 6.4.1
Stable tag: 3.37.5
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=fred%2egilles%40free%2efr&lc=FR&item_name=fg-magento-to-woocommerce&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted

A plugin to migrate categories, products, images, users, customers, orders and CMS from Magento to WooCommerce

== Description ==

This plugin migrates product categories, products, images, users, customers, orders, coupons and CMS from Magento to WooCommerce.

It has been tested with **Magento versions 1.3 to 2.4** and the latest version of WordPress. It is compatible with multisite installations.

Major features include:

* migrates the product categories
* migrates the product categories images
* migrates the products
* migrates the products tags
* migrates the product thumbnails
* migrates the product images galleries
* migrates the product stocks
* migrates the product attributes
* migrates the product options
* migrates the product variations
* migrates the grouped products
* migrates the Up Sell, Cross Sell and related products
* migrates the downloadable products
* migrates the CMS
* migrates the users
* migrates the customers
* authenticate the users and the customers in WordPress with their Magento passwords
* migrates the orders
* migrates the ratings and reviews
* migrates the discount coupons
* migrates the SEO meta data
* migrates the tax classes
* SEO: redirects the Magento URLs
* SEO: Import meta data (browser title, description, keywords)
* multisites/multistores: Option to choose which website/store to import
* update the already imported products stocks and orders
* compatible with Magento Enterprise Edition
* ability to run the import automatically from the cron (for dropshipping for example)
* WP CLI support

No need to subscribe to an external web site.

= Add-ons =

The Premium version allows the use of add-ons that enhance functionality:

* Multilingual with WPML
* Move Magento order numbers
* Move Magento customer groups
* Move Magento manufacturers
* Move Magento product options as add-ons
* Move Magento costs
* Move Magento custom order statuses
* Move Magento bundle products
* Move Magento wish lists
* Move Magento tiered prices
* Move Magento AW Blog

== Installation ==

1.  Install the plugin in the Admin => Plugins menu => Add New => Upload => Select the zip file => Install Now
2.  Activate the plugin in the Admin => Plugins menu
3.  Run the importer in Tools > Import > Magento
4.  Configure the plugin settings. You can find the Magento database parameters in the Magento file app/etc/local.xml<br />
    Hostname = host<br />
    Port     = 3306 (standard MySQL port)<br />
    Database = dbname<br />
    Username = username<br />
    Password = password<br />

== Automatic import from cron ==

In the crontab, add this row to run the import every day at 0:00:
0 0 * * * php /path/to/wp/wp-content/plugins/fg-magento-to-woocommerce-premium/cron_import.php >>/dev/null

== WP CLI Usage ==

wp import-magento empty              Empty the imported data | empty all : Empty all the WordPress data
wp import-magento import             Import the data
wp import-magento update             Update the data
wp import-magento test_database      Test the database connection

== Translations ==
* English (default)
* French (fr_FR)
* German (de_DE)
* Brazilian (pt_BR)
* other can be translated

== Changelog ==

= 3.37.5 =
* Fixed: URLs with special characters were not redirected

= 3.37.4 =
* Fixed: Emails about orders were sent to customers
* Fixed: Wrong old order ID stored in the order meta data

= 3.37.3 =
* Fixed: Deprecated: Creation of dynamic property FG_Magento_to_WooCommerce_Customer_Address::$plugin is deprecated

= 3.37.2 =
* Fixed: Deprecated: trim(): Passing null to parameter #1 ($string) of type string is deprecated
* Fixed: Deprecated: Creation of dynamic property FG_Magento_to_WooCommerce_Product_Variations::$min_variation_price is deprecated

= 3.37.1 =
* Fixed: Number of orders equals 0 if HPOS is used without compatibility mode
* Tested with WordPress 6.4.1

= 3.37.0 =
* New: redirect URLs with pattern /view/id/

= 3.36.2 =
* Fixed: Tax not displayed on the order line item

= 3.36.1 =
* Fixed: Tax not displayed on the order line item
* Fixed: Update the order status compatible with HPOS

= 3.36.0 =
* New: Compatibility with WooCommerce HPOS
* New: Import the customer order note
* Fixed: [ERROR] Error:SQLSTATE[42S02]: Base table or view not found: 1146 Table 'catalog_product_website' doesn't exist
* Tested with WordPress 6.3.2

= 3.35.1 =
* Fixed: Avoid duplicates between 1.2 and 12 for example
* Fixed: Variations not set in translated languages
* Fixed: Wrong sort order of the product attributes
* Tested with WordPress 6.3.1

= 3.35.0 =
* New: Redirect the URLs ending with .html

= 3.34.2 =
* Fixed: Notice: Trying to access array offset on value of type null with WP-CLI
* Tested with WordPress 6.3

= 3.34.1 =
* Fixed: Out of stock product shows as in stock

= 3.34.0 =
* New: Import the meta title and meta description to Rank Math SEO

= 3.33.1 =
* Fixed: Notice: Undefined variable: order_id
* Tested with WordPress 6.2.2

= 3.33.0 =
* New: Update the WooCommerce Customers screen

= 3.32.1 =
* Tested with WordPress 6.2

= 3.32.0 =
* New: Add an option to import the product thumbnail into the product gallery
* Change: Replace the option "Don't include the first image into the product gallery" by "Import the first image into the product gallery"

= 3.31.0 =
* New: Add the hook "fgm2wc_guess_image_filename_potential_keys"
* New: Add the hook "fgm2wc_guess_image_filename"
* New: Compatibility with PHP 8.2
* Fixed: Notice: Undefined index: image

= 3.30.0 =
* New: Import the small image or the thumbnail image if the product image is not set
* Tested with WordPress 6.1.1

= 3.29.2 =
* Fixed: Categories images imported even when we skip the media
* Fixed: Categories lost in the product when updating the product (Magento EE)

= 3.29.1 =
* Tested with WordPress 6.1

= 3.29.0 =
* Fixed: Images inside the product description were not imported
* Tweak: Shorten the filenames if the option "Import the media with duplicate names" is selected
* Tested with WordPress 6.0.3

= 3.28.4 =
* Fixed: Wrong related products from Magento EE
* Fixed: Notice: Undefined index: backorders
* Tested with WordPress 6.0.1

= 3.28.3 =
* Fixed: Wrong tax rate when importing products with tax

= 3.28.2 =
* Fixed: Wrong progress bar when updating products with WP-CLI

= 3.28.1 =
* Fixed: Wrong products updated from Magento EE
* Fixed: Current user deleted when removing previously imported data

= 3.28.0 =
* Fixed: The widget "Filter Products by Attribute" was empty on the front-end
* Fixed: Extra HTML code in the products description
* Fixed: Fatal error: Uncaught ArgumentCountError: Too few arguments to function FG_Magento_to_WooCommerce_Admin::build_product_post() during Update
* Tested with WordPress 6.0

= 3.27.0 =
* New: Update the product categories

= 3.26.2 =
* Fixed: Extra HTML code in the product categories description

= 3.26.1 =
* Fixed: Some products were not imported (from Magento EE)

= 3.26.0 =
* Tweak: Refactoring
* Fixed: [ERROR] Error:SQLSTATE[42S22]: Column not found: 1054 Unknown column 'pi.value' in 'field list'
* Fixed: Notice: Trying to access array offset on value of type int
* Fixed: Duplicate products (from Magento EE)
* Fixed: Duplicate categories (from Magento EE)
* Fixed: Products imported with wrong SKU (from Magento EE)
* Fixed: Products imported with wrong categories (from Magento EE)
* Fixed: Products imported with wrong stock (from Magento EE)

= 3.25.0 =
* New: Add the WordPress path in the Debug Info
* New: Add the hook "fgm2wc_pre_pre_import"
* New: Add the hook "fgm2wc_product_types"

= 3.24.2 =
* Fixed: Tax not displayed in the order items
* Tested with WordPress 5.9.3

= 3.24.1 =
* Fixed: Category images with an absolute path were not imported

= 3.24.0 =
* New: Compatible with Magento EE (Enterprise Edition)
* Fixed: [ERROR] Error:SQLSTATE[42S22]: Column not found: 1054 Unknown column 's.page_id' in 'on clause'
* Fixed: [ERROR] Error:SQLSTATE[42S22]: Column not found: 1054 Unknown column 'pei.entity_id' in 'on clause'
* Tested with WordPress 5.9.2

= 3.23.1 =
* Fixed: Images of CMS articles were not imported
* Tested with WordPress 5.9.1

= 3.23.0 =
* New: Don't delete the theme's customizations (WP 5.9) when removing all WordPress content
* Tested with WordPress 5.9

= 3.22.0 =
* New: Add a spinner during importing data, updating data, emptying WordPress content and saving parameters
* Tested with WordPress 5.8.3

= 3.21.2 =
* Fixed: Magento 2.4 users were not authenticated
* Tested with Magento 2.4

= 3.21.1 =
* Fixed: Error 404 when an enabled product has the same slug as a disabled product

= 3.21.0 =
* New: Add the German translations
* Fixed: PHP Notice: Trying to access array offset on value of type bool

= 3.20.4 =
* Fixed: Variations having a stock were considered as out of stock
* Tested with WordPress 5.8.2

= 3.20.3 =
* Fixed: Variable products whose all variations have no stock were considered as in stock

= 3.20.2 =
* Fixed: [ERROR] Error:SQLSTATE[42S02]: Base table or view not found: 1146 Table 'magento19.o' doesn't exist
* Tested with WordPress 5.8.1

= 3.20.1 =
* Fixed: Some variations not assigned to the attributes

= 3.20.0 =
* New: Update the customers
* Fixed: Tax not displayed in the order items

= 3.19.1 =
* Fixed: Stocks were not updated if the option "Update the products stocks only" is not selected

= 3.19.0 =
* New: Add the hook "fgm2wc_get_order_items"

= 3.18.3 =
* Fixed: Avoid duplicating the images if they are already imported

= 3.18.2 =
* Fixed: Some variables were not escaped before displaying
* Fixed: Products included in grouped products were duplicated during the update
* Tested with WordPress 5.8

= 3.18.1 =
* Fixed: [ERROR] Error:SQLSTATE[42S02]: Base table or view not found: 1146 Table 'eav_attribute_label' doesn't exist

= 3.18.0 =
* New: Add an option to update only the products stock
* Change: Manage the stock if "Manage stock" is not set in Magento

= 3.17.7 =
* Fixed: During the import by cron or by WP CLI, the admin user could be wrong
* Fixed: When an attribute was both in uppercase and in lowercase, only one attribute was kept in the product attributes and variations

= 3.17.6 =
* Fixed: Products with no tax class must have their tax status set to None
* Tested with WordPress 5.7.2

= 3.17.5 =
* Fixed: Customers not imported when their email is not valid

= 3.17.4 =
* Fixed: Images not imported for the Magento sites that require the cookie "__cfduid"

= 3.17.3 =
* Fixed: Tax not displayed in the order items

= 3.17.2 =
* Tested with WordPress 5.7.1

= 3.17.1 =
* Fixed: Product categories relationships lost when updating the products
* Tested with WordPress 5.7

= 3.17.0 =
* New: Update all the products data
* Tweak: Remove the "wp_insert_post" that consumes a lot of CPU and memory
* Tweak: Refactoring

= 3.16.0 =
* New: Import the products sort order
* Fixed: [ERROR] Error:SQLSTATE[42000]: Syntax error or access violation: when selecting "All web sites"

 = 3.15.0 =
* New: Add the parent product ID as an argument in the hook "fgm2wc_post_insert_variation"
* Tested with WordPress 5.6.2
* Tested with WooCommerce 5

= 3.14.1 =
* Fixed: The customers without a first name or a last name (the companies for example) were not imported

= 3.14.0 =
* New: Update the data by WP CLI
* Fixed: Options not saved when clicking on the Update button
* Fixed: [ERROR] Error:SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'OR c.website_id IS NULL)
* Tested with WordPress 5.6.1

= 3.13.1 =
* Fixed: Images inserted in the post content with width and height = 0 when the option "Don't generate the thumbnails" is selected
* Fixed: Fatal error: Uncaught TypeError: Unsupported operand types: string + float with PHP8

= 3.13.0 =
* New: Add documentation about WP CLI
* Fixed: Plugin and add-ons not displayed in the debug informations on Windows

= 3.12.0 =
* New: Add WP-CLI support
* Fixed: WordPress database error: [Column "download_count" cannot be null]
* Fixed: WordPress database error: [Column "access_granted" cannot be null]
* Fixed: Plugin and add-ons not shown on the Debug Info tab if the plugins are not installed in the standard plugins directory

= 3.11.2 =
* Fixed: JQuery Migrate warning: jQuery.fn.load() is deprecated
* Tested with WordPress 5.6

= 3.11.1 
* Fixed: Notice: Undefined index: description

= 3.11.0 =
* New: Ability to change the default import timeout by adding `define('IMPORT_TIMEOUT', 7200);` in the wp-config.php file
* Fixed: Character " not displayed in the settings
* Tested with WordPress 5.5.3

= 3.10.1 =
* Fixed: Wrong count of imported customers

= 3.10.0 =
* New: Check if we need the AW Blog add-on
* New: Add the function get_imported_magento_posts()

= 3.9.1 =
* Fixed: Reviews not counting

= 3.9.0 =
* New: Option to import products from all web sites
* Fixed: Progress bar at 0% if the site is in https and the WordPress general settings are in http

= 3.8.2 =
* Fixed: Notice: Trying to get property 'taxonomy' of non-object in /wp-content/plugins/wordpress-seo/src/builders/indexable-hierarchy-builder.php
* Fixed: Notice: Trying to get property 'parent' of non-object in /wp-content/plugins/wordpress-seo/src/builders/indexable-hierarchy-builder.php
* Tested with WordPress 5.5.1

= 3.8.1 =
* Fixed: Null prices for downloadable products

= 3.8.0 =
* New: Import the country of manufacture as an attribute

= 3.7.0 =
* Compatible with WordPress 5.5
* Fixed: Timezone was not the same between the start and the end time in the logs

= 3.6.0 =
* New: Add an option to not generate the images thumbnails
* New: Make the max_allowed_packet human readable
* Change: Set the default media timeout to 20 seconds
* Fixed: Products not updated if "Import" was clicked before "Update"
* Fixed: Import counter exceeds 100% when we click multiple times on the import button
* Fixed: Import counter reset to 0 when the partial import options were changed

= 3.5.0 =
* New: Import the product category thumbnails

= 3.4.1 =
* Fixed: Variation prices were null

= 3.4.0 =
* New: Don't add a prefix to the attribute slug if the attribute name is not too long
* New: Add the hooks "fgm2wc_pre_create_attribute_taxonomy" and "fgm2wc_taxonomy_pre_import_product_attribute"

= 3.3.0 =
* New: Import the boolean attributes as "Yes" or "No" in the current language
* New: Add the hook "fgm2wc_get_attributes_sql"
* New: Remove the custom field "country_of_manufacture"

= 3.2.0 =
* New: Add the hook "fgm2wc_post_get_full_product"
* Fixed: Hebrew variations were assigned to "Any" attribute value

= 3.1.3 =
* Fixed: Warning: preg_match(): Unknown modifier '2'

= 3.1.2 =
* Fixed: Notice: Trying to access array offset on value of type int

= 3.1.1 =
* Fixed: Wrong attribute values imported

= 3.1.0 =
* New: Add the hooks "fgm2wc_get_product_attributes_sql" and "fgm2wc_args_pre_create_woocommerce_product_attribute"
* New: Display the PHP errors in the logs

= 3.0.0 =
* New: Add an help tab
* New: Add a debug info tab

= 2.99.2 =
* New: Add the hook "fgm2wc_get_order_address_sql"

= 2.99.1 =
* Fixed: Product stocks not updated

= 2.99.0 =
* New: Add the hooks "fgm2wc_get_users_sql", "fgm2wc_get_customers_sql" and "fgm2wc_get_orders_sql"
* Performance improvements
* Tested with WordPress 5.4.2

= 2.98.1 =
* Fixed: Deprecated function update_woocommerce_term_meta

= 2.98.0 =
* New: Add the hook "fgm2wc_post_save_option_variations"
* Fixed: Change the types of the product attributes parameters to string

= 2.97.0 =
* New: Import the disabled child products as "disabled" variations

= 2.96.2 =
* Tweak: Increase the maximum number of values to 300 for the regular attributes

= 2.96.1 =
* Fixed: Sale price was set as current price even if the sale period is ended

= 2.96.0 =
* New: Use the config backorder status
* Fixed: Products on backorder had the status "out of stock"

= 2.95.2 =
* Fixed: Import hangs on PHP installations where the function "exif_read_data" is not available

= 2.95.1 =
* Fixed: Wrong sale price if the variation sale price is different from the main product sale price

= 2.95.0 =
* New: Check if we need the Tiered Prices add-on
* New: Add the hook "fgm2wc_product_images_subdirectory"
* Fixed: Wrong stock status

= 2.94.1 =
* Fixed: Images not imported (regression from 2.94.0)

= 2.94.0 =
* New: Add the hook "fgm2wc_get_product_images"
* Fixed: Avoid the duplicate variations SKU
* Tweak: Add the subdirectory /catalog/product only for relative paths of images

= 2.93.1 =
* Tested with WordPress 5.4.1

= 2.93.0 =
* New: Check if we need the Wish Lists add-on

= 2.92.0 =
* Fixed: The stock management for each product was not managed exactly as in Magento

= 2.91.1 =
* Fixed: Notice: Trying to access array offset on value of type bool
* Tested with WordPress 5.4

= 2.91.0 =
* New: Add the hook "fgm2wc_get_other_customer_fields"
* Fixed: Logs not displayed

= 2.90.1 =
* Fixed: In multisite, when deleting the imported data, it deletes all the users from all sites

= 2.90.0 =
* New: Import the product tags from the tag table

= 2.89.1 =
* Fixed: Images not imported
* Tested with WooCommerce 4.0

= 2.89.0 =
* New: Add the hooks "fgm2wc_option_type" and "fgm2wc_post_create_woocommerce_option_value"
* Fixed: Warning: exif_read_data(): File not supported

= 2.88.0 =
* Tweak: Import the attribute labels in the main language
* Tweak: Add hooks useful for the Internationalization add-on

= 2.87.0 =
* New: Option to not import the disabled products categories

= 2.86.2 =
* Fixed: Wrong variation price when the attribute name contains double spaces
* Fixed: Wrong variation price when the super product attribute has a null price

= 2.86.1 =
* Fixed: Some JPEG images had a wrong orientation

= 2.86.0 =
* New: Import the country of manufacture as an attribute

= 2.85.1 =
* Fixed: Logs were not displayed due to mod_security

= 2.85.0 =
* New: Authenticate the users with the password_verify function (PHP ≥ 5.5)
* Fixed: Notice: date_default_timezone_set(): Timezone ID '' is invalid

= 2.84.0 =
* New: Allow to import the attributes translations (with the Internationalization add-on)
* New: Add the hook "fgm2wc_post_create_attribute_values"

= 2.83.0 =
* New: Import the "shipped" orders as completed

= 2.82.3 =
* Fixed: Users from Magento Enterprise were not authenticated
* Tested with WordPress 5.3.2

= 2.82.2 =
* Fixed: Product images were duplicated when importing a store different from the main one

= 2.82.1 =
* Fixed: Related products not imported

= 2.82.0 =
* New: Add the filter "fgm2wc_attribute_type"
* Fixed: Warning: Illegal string offset 'downloadable-files'
* Tested with WordPress 5.3.1

= 2.81.0 =
* New: Add the hooks "fgm2wc_get_products_sql", "fgm2wc_get_products" and "fgm2wc_get_products_count_sql"

= 2.80.1 =
* Fixed: Downloads not available in the user's account area

= 2.80.0 =
* New: Delete the Yoast SEO data when emptying all the WordPress content
* Tested with WordPress 5.2.4

= 2.79.3 =
* Fixed: Product variations with future dates were not visible

= 2.79.2 =
* Fixed: Attributes not set as variation if the Magento option has the same name as a Magento attribute
* Fixed: Wrong variation SKU

= 2.79.1 =
* Fixed: Users may be imported as duplicates if the import hangs

= 2.79.0 =
* Fixed: Logs were not displayed if the URL is wrong in the WordPress general settings

= 2.78.0 =
* New: Download the media even if they are redirected

= 2.77.1 =
* Fixed: Set the downloadable products as virtual to be able to use the Product Type filter

= 2.77.0 =
* New: Compatible with the new WooCommerce tax classes
* Change: Calculate the variations SKU by concatenating the product SKU and the option SKU
* Fixed: Set the variation as downloadable if the product is downloadable
* Fixed: Set the variation as virtual if the product is virtual
* Tweak: Recount only the attribute terms

= 2.76.0 =
* New: Compatible with the Argon2ID13 encrypted passwords (Magento 2.3) PHP 7.2+ is required.
* Fixed: [ERROR] Error:SQLSTATE[42S02]: Base table or view not found: 1146 Table 'core_store' doesn't exist

= 2.75.0 =
* New: Add the hooks "fgm2wc_pre_import_attribute", "fgm2wc_post_import_attributes", "fgm2wc_pre_import_product_attribute"

= 2.74.0 =
* Fixed: Orders were not imported on Magento 1.3.2.4
* Tested with Magento 2.3
* Tested with WordPress 5.2.3

= 2.73.0 =
* New: Translate the plugin in Brazilian (thanks to A. Costa)
* New: Import the product tags

= 2.72.1 =
* Fixed: Missing product attributes for downloadable products

= 2.72.0 =
* New: Import the tax classes
* New: Add the hook "fgm2wc_pre_import_products"

= 2.71.1 =
* Fixed: WordPress database error Illegal mix of collations

= 2.71.0 =
* New: Update the WooCommerce product meta lookup table

= 2.70.1 =
* Fixed: Some users with Russian characters were not imported
* Tested with WordPress 5.2.2

= 2.70.0 =
* New: Add an option to manage the stock or not. Used if the stock is not managed in Magento but the products must be in stock in WooCommerce

= 2.69.0 =
* New: Import the discounts in the orders and in the order items

= 2.68.2 =
* Fixed: Fatal error: Uncaught Error: Call to undefined method FG_Magento_to_WooCommerce_Downloadable_Products::get_plugin_name() 
* Fixed: Wrong path for the downloadable files when the uploads are not organized into month- and year-based folders

= 2.68.1 =
* Fixed: Don't import empty attributes

= 2.68.0 =
* Tweak: Unset the default product category when emptying WordPress content
* Tested with WordPress 5.2.1

= 2.67.1 =
* Fixed: Grouped products children not imported in extra languages
* Fixed: Up-sells and Cross-sells relations not imported in extra languages
* Fixed: Regression from 2.66.2: Product URLs not imported

= 2.67.0 =
* Tweak: Code refactoring
* Fixed: Missing translations
* Tested with WordPress 5.2

= 2.66.2 =
* Fixed: Regression from 2.66.0: the simple products were not linked to their grouped products

= 2.66.1 =
* Fixed: Price = 0 for some product bundles

= 2.66.0 =
* Tweak: Can manage the imported products in different languages (required for the WPML add-on)
* Tested with WordPress 5.1.1

= 2.65.1 =
* Fixed: Line breaks were removed in the product description
* Tested with WordPress 5.1

= 2.65.0 =
* New: Add the fgm2wc_get_other_fields hook

= 2.64.5 =
* Fixed: Prevent negative stock values
* Fixed: Notice: Undefined index: status

= 2.64.4 =
* Fixed: Duplicated order items

= 2.64.3 =
* Fixed: When running the import in cron, the categories were not assigned to the products

= 2.64.2 =
* Fixed: Products imported with null prices if super attributes are used

= 2.64.1 =
* Fixed: Product sorting by popularity didn't work

= 2.64.0 =
* New: Check if we need the Product Bundles add-on
* Tested with WordPress 5.0.3

= 2.63.1 =
* Fixed: Products without title were not imported

= 2.63.0 =
* New: Add the "bundle" product type (used by the Product Bundles add-on)

= 2.62.0 =
* Fixed: Don't import the downloadable files if "Skip media" is selected
* Fixed: Warning: A non-numeric value encountered
* Fixed: Some NGINX servers were blocking the images downloads
* Fixed: Downloadable files not transferred due to a duplication of the site URL
* Fixed: Options stocks not imported
* Fixed: Products with options displayed as "out of stock"
* Tested with WordPress 5.0.2

= 2.61.0 =
* Tested with WordPress 5.0

= 2.60.2 =
* Fixed: Workaround to WooCommerce bug that doesn't process well the attributes containing "pa_"
 
= 2.60.1 =
* Fixed: Regression from 2.59.2: when used with WPML, the translations were not imported

= 2.60.0 =
* New: Add an option to not import the disabled products

= 2.59.4 =
* Fixed: Images not imported because of a missing starting slash

= 2.59.3 =
* Fixed: Some category images were not imported

= 2.59.2 =
* Fixed: Children of grouped products may be imported as duplicates

= 2.59.1 =
* Fixed: Notice: Undefined index: type_id

= 2.59.0 =
* New: Option to not import the customers who didn't make any order

= 2.58.0 =
* New: Generate the audio and video meta data (ID3 tag, featured image)
* Fixed: Notice: Trying to get property of non-object in woocommerce/includes/wc-attribute-functions.php on line 172
* Fixed: Set the price = 0 for the bundle products
* Fixed: Set manage_stock = no for the bundle products

= 2.57.5 =
* Fixed: Some product option values were not sorted correctly

= 2.57.4 =
* Fixed: Sort the product option values by title if they don't have a sort order value

= 2.57.3 =
* Fixed: Some Magento 2 product stocks were not updated

= 2.57.2 =
* Fixed: Some Magento 2 product stocks were not imported
* Fixed: Sort the product option values alphabetically if they don't have a sort order value
* Tweak: Cache some database results to increase import speed

= 2.57.1 =
* Fixed: Don't remove the WooCommerce pages associations when we delete only the imported data

= 2.57.0 =
* New: Support the Bengali alphabet
* Fixed: Wrong products pagination with out of stock products

= 2.56.1 =
* Fixed: Stock not imported and products not set as variable with some databases

= 2.56.0 =
* New: Import the downloadable product permissions
* New: Import the download limit with the downloaded products
* Fixed: Orders show pa_xxx when the attributes are skipped

= 2.55.2 =
* Fixed: Regression from 2.55.1: products not imported on Magento < 2

= 2.55.1 =
* Fixed: Products may be imported as duplicates

= 2.55.0 =
* New: Add a hook to be able to import the orders costs of goods

= 2.54.0 =
* New: Add the shipping tax amount in the tax column on the order screen
* Fixed: The shipping tax amount was counted twice in the order

= 2.53.0 =
* New: Allow Arabic characters

= 2.52.0 =
* New: Compatibility with the wholesale price feature of the Customer Groups add-on
* Fixed: Warning: Illegal string offset 'region'
* Fixed: Warning: Cannot assign an empty string to a string offset
* Tested with WordPress 4.9.8

= 2.51.0 =
* New: Import the Magento related products as up-sells

= 2.50.1 =
* Fixed: WordPress database error: [Cannot truncate a table referenced in a foreign key constraint (`wp_wc_download_log`, CONSTRAINT `fk_wc_download_log_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `wp_woocommerce_downloadable_product_permission)]

= 2.50.0 =
* Fixed: All the order comments were not imported
* Fixed: Empty the WooCommerce wc_download_log and woocommerce_downloadable_product_permissions tables upon database emptying
* Change: Wording of the label "Remove only previously imported data"
* Tested with WordPress 4.9.7

= 2.49.0 =
* New: Add an option to import the customers and orders from all stores or from the selected store only

= 2.48.3 =
* Fixed: The downloadable files with relative URLs were not downloaded

= 2.48.2 =
* Fixed: Order statuses containing uppercase characters were imported as Pending
* Tested with WordPress 4.9.6

= 2.48.1 =
* Fixed: The tax amount was not displayed in the order item rows
* Fixed: The order items corresponding to a missing downloadable file were not imported

= 2.48.0 =
* New: Import the datetime product attributes

= 2.47.0 =
* New: Import the downloads in the orders

= 2.46.2 =
* Fixed: Some variations were incomplete (due to the crc32() function that can return negative numbers)
* Fixed: Remove extra "-" in the SKU
* Tweak: Delete the wc_var_prices transient when emptying WordPress data
* Tested with WordPress 4.9.5

= 2.46.1 =
* Fixed: Fatal error: Uncaught Error: Cannot use object of type WP_Error as array

= 2.46.0 =
* New: Allow the import of the Magento 2 brands (with the Brands add-on)
* Fixed: Media path was wrong on some Magento 2 sites

= 2.45.4 =
* Fixed: Notice: Undefined index: short_description
* Fixed: Notice: unserialize(): Error at offset 0 of 348 bytes

= 2.45.3 =
* Fixed: Media not imported for some Magento 2 sites
* Fixed: [ERROR] Error:SQLSTATE[42S02]: Base table or view not found: 1146 Table 'sales_flat_order' doesn't exist

= 2.45.2 =
* Fixed: Import only the customers from the selected web site

= 2.45.1 =
* Fixed: All the customers were imported and not only the ones from the selected store

= 2.45.0 =
* New: Import the media shortcodes like {{media url="filename.jpg"}}

= 2.44.1 =
* Fixed: It was not possible to import the "Admin" store
* Tested with WordPress 4.9.4

= 2.44.0 =
* New: Ability to run the import automatically from the cron (for dropshipping for example)
* Tweak: Use WP_IMPORTING

= 2.43.0 =
* New: Import the long attribute values as custom attributes

= 2.42.0 =
* New: Check if we need the Custom Order Statuses add-on
* New: Add a hook for the order statuses mapping

= 2.41.0 =
* New: Set the "Manage stock" checkbox according to the Magento "manage stock" value
* New: Put the stock status as "in stock" when the product stock is not managed
* Tested with WordPress 4.9.1

= 2.40.0 =
* New: Add some hooks for the Cost of Goods add-on

= 2.39.0 =
* New: Allow the import of the "Admin" web site and of the "Admin" store

= 2.38.3 =
* Fixed: Wrong attribute values imported

= 2.38.2 =
* Fixed: The passwords containing a backslash were not recognized
* Fixed: The variations were imported as simple products (Magento < 1.4)
* Tested with WordPress 4.9

= 2.38.1 =
* Fixed: The attributes and variations were not imported when defined as super attributes on Magento 1.3 and less
* Tested with WordPress 4.8.3

= 2.38.0 =
* New: Make the products visibility compatible with WooCommerce 3

= 2.37.1 =
* Fixed: Categories imported in wrong language

= 2.37.0 =
* New: Check if we need the Product Options add-on
* New: Sanitize the media file names

= 2.36.0 =
* New: Add some functions for the Product Options module
* Tested with WordPress 4.8.2

= 2.35.1 =
* Fixed: Categories with duplicated names were not imported

= 2.35.0 =
* Fixed: Security cross-site scripting (XSS) vulnerability in the Ajax importer

= 2.34.0 =
* New: Compatible with Magento 2.x
* Fixed: "[ERROR] Error:SQLSTATE[42S22]: Column not found: 1054 Unknown column 'p.website_id' in 'where clause'" for Magento < 1.4
* Fixed: CMS articles may be imported as duplicates
* Improvement: Import speed optimization

= 2.33.0 =
* New: Import the prices from the Magento super attributes
* Tested with WordPress 4.8.1

= 2.32.0 =
* New: Allow HTML in term descriptions
* New: Import the product categories meta data (title, description, keywords) to Yoast SEO

= 2.31.0 =
* New: Import the image caption in the media attachment page

= 2.30.1 =
* Fixed: Disabled child products were imported as variations

= 2.30.0 =
* New: Authenticate the imported users by their email

= 2.29.0 =
* New: Block the import if the URL field is empty and if the media are not skipped
* New: Add error messages and information

= 2.28.1 =
* Fixed: Customers may be incompletely imported if the import hangs
* Fixed: Users with passwords encrypted with 64 characters were not authentified with their Magento password

= 2.28.0 =
* New: Add the percentage in the progress bar
* New: Display the progress and the log when returning to the import page
* Change: Restyling the progress bar
* Fixed: Typo - replace "complete" by "completed"
* Fixed: Notice: Undefined index: data
* Tested with WordPress 4.8

= 2.27.0 =
* New: Import the attributes by batch
* New: Import the downloadable files of type "URL"
* New: Can import multiple downloadable files per product
* New: Create one variation per downloadable file if the Magento links can be purchased separately

= 2.26.2 =
* Fixed: Infinite loop during the customers import if some records in the customer_entity table have got no matching record in the customer_entity_varchar table
* Tested with WordPress 4.7.5

= 2.26.1 =
* Fixed: Some attributes and variations were not imported due to trailing spaces in attribute values
* Fixed: Error:SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'ORDER BY ov.store_id DESC
* Tested with WordPress 4.7.4

= 2.26.0 =
* New: Import the downloadable products

= 2.25.0 =
* New: Compatibility with WooCommerce 3.0: Grouped products are linked from the parent rather than the children. Children can be in more than one group.

= 2.24.1 =
* Fixed: Child products from grouped products are imported as duplicates
* Tweak: Code refactoring

= 2.24.0 =
* New: Import the coupons usages
* Fixed: Duplicated image in the product gallery

= 2.23.1 =
* Fixed: Some attributes and variations were not imported when using WPML

= 2.23.0 =
* New: Import the products visibility
* New: Import the child products of a grouped product even if they are not visible individually

= 2.22.1 =
* Fixed: The attributes options were not imported when their value is empty on the selected store

= 2.22.0 =
* New: Enable the attributes translations (with the WPML add-on)
* Fixed: Some prices of variable products shown as free
* Tweak: Clear WooCommerce transients when emptying WordPress content
* Tested with WordPress 4.7.3

= 2.21.5 =
* Fixed: Fatal error: Call to undefined method FG_Magento_to_WooCommerce_Orders::table_exists()

= 2.21.4 =
* Fixed: Fatal error: Call to undefined method FG_Magento_to_WooCommerce_Orders::table_exists()

= 2.21.3 =
* Fixed: Notice: Undefined index: name

= 2.21.2 =
* Fixed: The coupons had got trailing zeros

= 2.21.1 =
* Fixed: With Magento 1.4: [ERROR] Error:SQLSTATE[42S02]: Base table or view not found: 1146 Table 'sales_order_varchar' doesn't exist
* Fixed: With Magento 1.4: [ERROR] Error:SQLSTATE[42S02]: Base table or view not found: 1146 Table 'sales_order_entity' doesn't exist
* Fixed: With Magento 1.4: Notice: Undefined index: firstname
* Fixed: With Magento 1.4: Notice: Undefined index: lastname
* Fixed: With Magento 1.4: Orders shipping and billing addresses not imported

= 2.21.0 =
* New: Migrates the discount coupons

= 2.20.3 =
* Fixed: Term meta data not deleted when we delete the imported data only
* Fixed: Orders were not imported when importing all the languages with the WPML add-on

= 2.20.2 =
* Fixed: Users whose nicename is longer than 50 characters were not imported
* Fixed: Users whose login is longer than 60 characters were not imported
* Fixed: Avoid hangs due to orders with thousands of notes

= 2.20.1 =
* Fixed: Display 0 products and 0 orders the first time we click on the "Test the database connection" button

= 2.20.0 =
* New: Update the lists of websites and stores when clicking on "Test the database connection"
* New: Remove the button "Refresh the lists of websites and stores"

= 2.19.0 =
* New: Import the redirects from the url_path field
* New: Import the redirects from the Magento Enterprise Edition
* Tested with WordPress 4.7.2

= 2.18.1 =
* Change: Import the Manufacturer's Suggested Retail Price as the regular price instead of the sale price

= 2.18.0 =
* New: Add an option to import the Special Price or the Manufacturer's Suggested Retail Price

= 2.17.0 =
* New: Import the products Up Sell and Cross Sell
* New: Import the length, width and height as shipping attributes
* Fixed: The option names were imported instead of the option labels
* Tweak: Code refactoring

= 2.16.2 =
* Fixed: All the orders were imported and not only the ones from the selected store

= 2.16.1 =
* Fixed: Magento 1.4.0.x order notes not imported
* Tested with WordPress 4.7

= 2.16.0 =
* New: Multiwebsites: Add an option to choose which web site to import

= 2.15.2 =
* Fixed: Magento 1.4.0.x orders not imported

= 2.15.1 =
* Fixed: Existing images attached to imported products were removed when deleting the imported data

= 2.15.0 =
* New: Set the virtual and downloadable attributes
* Fixed: The child products which are visible individually were not imported

= 2.14.8 =
* Fixed: Wrong progress bar color

= 2.14.7 =
* Fixed: The progress bar didn't move during the first import
* Fixed: The log window was empty during the first import

= 2.14.6 =
* Fixed: The "IMPORT COMPLETE" message was still displayed when the import was run again

= 2.14.5 =
* Fixed: Database passwords containing "<" were not accepted
* Tweak: Code refactoring

= 2.14.4 =
* Fixed: Attributes with decimal values were not imported

= 2.14.3 =
* Fixed: Missing product attribute values if the WordPress site was already containing some categories

= 2.14.2 =
* Fixed: Wrong number of product categories displayed
* Fixed: Manufacturers not imported when the WPML add-on is active

= 2.14.1 =
* Fixed: Extra attribute value added in the product when both the Magento attribute and attribute option have the same value
* Fixed: Long attribute values were missing if another attribute values have the same first 29 characters
* Tweak: If the import is blocked, stop sending AJAX requests

= 2.14.0 =
* New: Authorize the connections to Web sites that use invalid SSL certificates
* Fixed: Some attributes containing commas were not imported

= 2.13.0 =
* New: Option to delete only the new imported data
* Fixed: WordPress database error when SKU contains quotes

= 2.12.3 =
* Fixed: MySQL 5.7 incompatibility: [ERROR] Error:SQLSTATE[HY000]: General error: 3065 Expression #1 of ORDER BY clause is not in SELECT list, references column 'gv.position' which is not in SELECT list; this is incompatible with DISTINCT
* Fixed: MySQL 5.7 incompatibility: [ERROR] Error:SQLSTATE[HY000]: General error: 3065 Expression #1 of ORDER BY clause is not in SELECT list, references column 'o.sort_order' which is not in SELECT list; this is incompatible with DISTINCT

= 2.12.2 =
* Fixed: Some images were duplicated in the product gallery

= 2.12.1 =
* Fixed: Product variations were not displayed on the front-end when the option "Hide out of stock items from the catalog" is selected and when the stock is not managed at the variation level
* Fixed: Review link broken

= 2.12.0 =
* New: Allow the manufacturers import
* New: Display the needed add-ons during the database testing and before importing
* Fixed: Wrong number of comments displayed
* Tested with WordPress 4.6.1

= 2.11.0 =
* New: Display the number of data found in the Magento database before importing
* Fixed: Variations with spaces were not imported

= 2.10.0 =
* New: Import the Magento ratings and reviews

= 2.9.1 =
* Fixed: Column not found: 1054 Unknown column 'otv.stock' in 'field list'
* Fixed: Only the first value of the product attributes was imported

= 2.9.0 =
* New: Import the product variations stocks
* Fixed: Some product variations were not imported on multistore sites
* Fixed: The product attributes containing "&" were imported without SKU and price
* Fixed: Regular prices were wrong for product variations when they have got a sale price
* Tested with WordPress 4.6

= 2.8.0 =
* New: Import the order items SKU
* New: Import the order comments
* Fixed: Remove notices which were displayed if some customer data were missing
* Fixed: The attributes and variations were not imported when the import was stopped and resumed

= 2.7.1 =
* Fixed: Some links could not be redirected correctly
* Fixed: Attributes and product attributes were not displayed
* Fixed: Notice: Undefined index: attribute_code
* Fixed: Notice: Undefined index: value

= 2.7.0 =
* New: Redirect the Magento URLs
* Tweak: Limit the number of variations to import
* Tweak: Optimize the product options import
* Fixed: Notice: Undefined index: password_hash

= 2.6.3 =
* Fixed: Variable products whose children have a null price, had got a null price
* Fixed: Notice: Undefined index: url_key

= 2.6.2 =
* Fixed: WordPress database error: [You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'xxx' yyy' LIMIT 1' at line 4

= 2.6.1 =
* Fixed: Wrong number of CMS articles was displayed

= 2.6.0 =
* New: Option to not import the products categories

= 2.5.2 =
* New: Add the hook fgm2wc_post_insert_order
* Change: Rename the Update button to "Update stocks and orders status"

= 2.5.1 =
* Fixed: Allow bad characters like "²" in the attribute names

= 2.5.0 =
* New: Import the SKU and the attributes in the order items

= 2.4.1 =
* Fixed: the store ID was not set during stock and orders update

= 2.4.0 =
* Fixed: CMS pages from all languages were imported
* Fixed: Notice: Undefined index: name
* Tweak: Refactor some functions to allow multilingual import by the WPML addon

= 2.3.0 =
* New: Add a button to update the already imported products stocks and orders
* New: Add the hook fgm2wc_pre_insert_product
* Fixed: PHP Notice: Object of class WP_Error could not be converted to int
* Fixed: Notice: Undefined index: url_key

= 2.2.0 =
* New: Import the product featured images
* New: Multistore: Add an option to choose which store to import
* Change: Remove the Paypal Donate button

= 2.1.0 =
* Fixed: Recount the terms after the products import
* Fixed: Display an error message when the process hangs
* Tweak: Increase the speed of counting the terms
* Tweak: Don't reimport the product attributes if they have already been imported
* Tweak: Don't reimport the product options if they have already been imported
* Tested with WordPress 4.5.3

= 2.0.0 =
* New: Run the import in AJAX
* New: Add a progress bar
* New: Add a logger frame to see the logs in real time
* New: Ability to stop the import
* New: Compatible with PHP 7
* New: Compatible with WooCommerce 2.6.0

= 1.13.4 =
* Fixed: The products without stock were not imported

= 1.13.3 =
* Fixed: Set the type of Magento multiselect attributes to "select"
* Fixed: Some attribute option IDs were imported as attribute values in addition to their text value

= 1.13.2 =
* Fixed: Products belonging to several bundles were imported as duplicates

= 1.13.1 =
* Fixed: Some descriptions were not imported correctly

= 1.13.0 =
* New: Import the boolean attributes
* Tested with WordPress 4.5.2

= 1.12.1 =
* Fixed: Attributes with value 0 were not imported
* Fixed: Compatibility issues with Magento 1.3
* Tested with WordPress 4.5.1

= 1.12.0 =
* New: Migrate the SEO meta data
* New: Add option to import the meta keywords as tags
* Tested with WordPress 4.5

= 1.11.0 =
* New: Import the free text attributes

= 1.10.2 =
* Fixed: Notice: Undefined index: short_description
* Fixed: Column 'post_excerpt' cannot be null

= 1.10.1 =
* Fixed: Products not imported. Error: "WordPress database error Column 'post_content' cannot be null"

= 1.10.0 =
* New: Import the grouped products
* New: Import the product options and their variations

= 1.9.1 =
* Tested with WordPress 4.4.2

= 1.9.0 =
* New: Add the min and max variation prices to the postmeta data for the variable products

= 1.8.4 =
* Tested with WordPress 4.4.1

= 1.8.3 =
* Fixed: Attributes not visible on front were not imported

= 1.8.2 =
* Fixed: Fatal error: Call to undefined function add_term_meta()

= 1.8.1 =
* Fixed: Better clean the taxonomies cache

= 1.8.0 =
* New: Add the option to not import the attributes
* Tweak: Optimize the termmeta table

= 1.7.0 =
* Tweak: Use the WordPress 4.4 term metas
* Fixed: WordPress database error: [Column 'order_item_name' cannot be null]

= 1.6.1 =
* Tested with WordPress 4.4

= 1.6.0 =
* New: Compatibility with Magento 1.3
* New: Support the accented Greek characters

= 1.5.0 =
* New: Add a link to the FAQ in the connection error message

= 1.4.0 =
* New: Add an Import link on the plugins list page
* Tweak: Code refactoring

= 1.3.1 =
* Fixed: Refresh the display of the product categories
* Fixed: Notice: Undefined property: FG_Magento_to_WooCommerce_Product_Attributes::$global_tax_rate
* Fixed: Notice: Undefined index: postcode
* Fixed: Error: 1054 Unknown column 'e.store_id' in 'where clause'

= 1.3.0 =
* New: Migrates all the attributes and not only the ones used in variations
* Fixed: Notice: Undefined index: url_key
* Tweak: Speed optimization for the variation import

= 1.2.1 =
* Fixed: Duplicate images
* Fixed: Avoid a double slash in the media filename
* Fixed: Error:SQLSTATE[42000]: Syntax error or access violation
* Fixed: Notice: Undefined index: region_id
* Fixed: Notice: Undefined index: region
* Fixed: Notice: Undefined index: company
* Fixed: Import the original category name instead of the translation

= 1.2.0 =
* New: Compatible with Magento 1.4 to 1.9
* New: Support the table prefix
* New: Import the product attributes
* New: Import the product variations
* Fixed: Don't import the child products as single products

= 1.1.0 =
* New: Migrates the users
* New: Migrates the users passwords
* New: Migrate the customers
* New: Authenticate the users and the customers in WordPress with their Magento passwords
* New: Migrate the orders

= 1.0.1 =
* Tested with WordPress 4.3.1

= 1.0.0 =
* Initial version: Import Magento product categories, products, images and CMS
