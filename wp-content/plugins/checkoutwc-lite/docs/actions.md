# Hooks

- [Actions](#actions)
- [Filters](#filters)

## Actions

### `cfw_angelleye_paypal_ec_is_express_checkout`

*Hook for when PayPal for WooCommerce is in express checkout mode*


**Changelog**

Version | Description
------- | -----------
`6.0.0` | 

Source: ./includes/Compatibility/Gateways/PayPalForWooCommerce.php, line 92

### `cfw_amazon_payment_gateway_found`

*Fires after amazon gateway is found*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this->wc_gateway` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./includes/Compatibility/Gateways/AmazonPayV1.php, line 83

### `cfw_enqueue_scripts`

*Fires after script setup*


**Changelog**

Version | Description
------- | -----------
`5.0.0` | 

Source: ./includes/Managers/AssetManager.php, line 172

### `cfw_load_template_assets`

*Fires to trigger Templates to load their assets*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Managers/AssetManager.php, line 179

### `cfw_acr_handle_meta`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$fields['cfw_meta_fields']` |  | 

Source: ./includes/Features/AbandonedCartRecovery.php, line 865

### `cfw_checkout_order_review_tab`

*Outputs order review step content*


**Changelog**

Version | Description
------- | -----------
`4.0.0` | 

Source: ./includes/Features/OrderReviewStep.php, line 72

### `cfw_order_bump_added_to_cart`

*Action hook to run after an order bump is added to the cart*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$bump_id` | `int` | The ID of the order bump

**Changelog**

Version | Description
------- | -----------
`8.0.0` | 

Source: ./includes/Features/OrderBumps.php, line 261

### `cfw_after_delivery_method`

*Fires after the delivery method radio buttons are rendered.*


**Changelog**

Version | Description
------- | -----------
`7.3.0` | 

Source: ./includes/Features/LocalPickup.php, line 191

### `cfw_delivery_method_changed`

*Fires when delivery method changes*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$parsed_data['cfw_delivery_method']` |  | 

**Changelog**

Version | Description
------- | -----------
`7.3.2` | 

Source: ./includes/Features/LocalPickup.php, line 285

### `cfw_before_admin_page_header`

*Fires before the admin page header*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this` | `\Objectiv\Plugins\Checkout\Admin\Pages\AbandonedCartRecovery` | The AbandonedCartRecovery instance.

**Changelog**

Version | Description
------- | -----------
`7.0.0` | 

Source: ./includes/Admin/Pages/AbandonedCartRecovery.php, line 212

### `cfw_after_admin_page_header`

*Fires after the admin page header*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this` | `\Objectiv\Plugins\Checkout\Admin\Pages\AbandonedCartRecovery` | The AbandonedCartRecovery instance.

**Changelog**

Version | Description
------- | -----------
`7.0.0` | 

Source: ./includes/Admin/Pages/AbandonedCartRecovery.php, line 252

### `cfw_before_admin_page_header`

*The admin page wrap*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this` |  | 

**Changelog**

Version | Description
------- | -----------
`1.0.0` | 

Source: ./includes/Admin/Pages/PickupLocations.php, line 194

### `cfw_after_admin_page_header`

*The admin page wrap*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this` |  | 

**Changelog**

Version | Description
------- | -----------
`1.0.0` | 

Source: ./includes/Admin/Pages/PickupLocations.php, line 194

### `cfw_before_admin_page_header`

*Fires before the admin page header*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this` | `\Objectiv\Plugins\Checkout\Admin\Pages\OrderBumps` | The OrderBumps instance.

**Changelog**

Version | Description
------- | -----------
`7.0.0` | 

Source: ./includes/Admin/Pages/OrderBumps.php, line 160

### `cfw_after_admin_page_header`

*Fires after the admin page header*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this` | `\Objectiv\Plugins\Checkout\Admin\Pages\AbandonedCartRecovery` | The AbandonedCartRecovery instance.

**Changelog**

Version | Description
------- | -----------
`7.0.0` | 

Source: ./includes/Admin/Pages/OrderBumps.php, line 200

### `cfw_before_admin_page_header`

*Fires before the admin page header*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this` | `\Objectiv\Plugins\Checkout\Admin\Pages\LocalPickupAdmin` | The LocalPickupAdmin instance.

**Changelog**

Version | Description
------- | -----------
`7.0.0` | 

Source: ./includes/Admin/Pages/LocalPickupAdmin.php, line 115

### `cfw_after_admin_page_header`

*Fires after the admin page header*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this` | `\Objectiv\Plugins\Checkout\Admin\Pages\AbandonedCartRecovery` | The AbandonedCartRecovery instance.

**Changelog**

Version | Description
------- | -----------
`7.0.0` | 

Source: ./includes/Admin/Pages/LocalPickupAdmin.php, line 155

### `cfw_before_admin_page_header`

*The admin page wrap*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this` |  | 

**Changelog**

Version | Description
------- | -----------
`1.0.0` | 

Source: ./includes/Admin/Pages/PageAbstract.php, line 69

### `cfw_after_admin_page_header`

*The admin page wrap*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this` |  | 

**Changelog**

Version | Description
------- | -----------
`1.0.0` | 

Source: ./includes/Admin/Pages/PageAbstract.php, line 69

### `cfw_checkout_update_order_review`

*Fires when updating CheckoutWC order review*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`isset($_POST['post_data']) ? wp_unslash($_POST['post_data']) : ''` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./includes/Action/UpdateCheckoutAction.php, line 72

### `cfw_update_checkout_after_customer_save`

*Fires after customer address data has been updated. This is where we do cart updates*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`isset($_POST['post_data']) ? wp_unslash($_POST['post_data']) : ''` |  | 

**Changelog**

Version | Description
------- | -----------
`7.0.0` | 

Source: ./includes/Action/UpdateCheckoutAction.php, line 152

### `cfw_after_update_checkout_calculated`

*Fires after shipping and totals calculated during update_checkout refresh*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`isset($_POST['post_data']) ? wp_unslash($_POST['post_data']) : ''` |  | 
`$was_free_shipping_available_pre_cart_update` |  | 

**Changelog**

Version | Description
------- | -----------
`9.0.0` | 

Source: ./includes/Action/UpdateCheckoutAction.php, line 189

### `cfw_before_process_checkout`

*Fires before checkout is processed in complete order action*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Action/CompleteOrderAction.php, line 56

### `cfw_before_update_side_cart_action`

*Fires before updating the side cart.*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$cart_data` | `array` | The cart data.

**Changelog**

Version | Description
------- | -----------
`6.0.6` | 

Source: ./includes/Action/UpdateSideCart.php, line 38

### `cfw_before_order_bump_add_to_cart`

*Add to cart*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this` |  | 

Source: ./includes/Model/Bumps/BumpAbstract.php, line 154

### `cfw_order_bump_add_to_cart_product_type_{$product_type}`

*Fires before order bump is added to the cart*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$product_id` | `int` | The product ID
`$quantity` | `int` | The quantity
`$variation_id` | `int` | The variation ID
`$variation_data` | `array` | The variation data
`$metadata` | `array` | The metadata
`$product` | `\WC_Product` | The product

**Changelog**

Version | Description
------- | -----------
`9.0.0` | 

Source: ./includes/Model/Bumps/BumpAbstract.php, line 185

### `cfw_before_order_bump_add_to_cart`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this` |  | 

Source: ./includes/Model/Bumps/SpecificProductsBump.php, line 128

### `cfw_order_bump_add_to_cart_product_type_{$product_type}`

*Fires before order bump is added to the cart*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$product_id` | `int` | The product ID
`$quantity` | `int` | The quantity
`$variation_id` | `int` | The variation ID
`$variation_data` | `array` | The variation data
`$metadata` | `array` | The metadata
`$product` | `\WC_Product` | The product

**Changelog**

Version | Description
------- | -----------
`9.0.0` | 

Source: ./includes/Model/Bumps/SpecificProductsBump.php, line 191

### `cfw_template_load_before_{$template_name}_{$template_piece_name}`

*Fires before template is output*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Model/Template.php, line 201

### `cfw_template_load_after_{$template_name}_{$template_piece_name}`

*Fires after template has been echoed out*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Model/Template.php, line 214

### `cfw_after_modal_variable_product_form`

*Action after modal order bump variable product form.*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$variable_product` | `\WC_Product` | 

**Changelog**

Version | Description
------- | -----------
`8.2.18` | 

Source: ./includes/API/GetVariationFormAPI.php, line 140

### `cfw_before_plugin_data_upgrades`

*Init*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this->db_version` |  | 

Source: ./includes/DatabaseUpdatesManager.php, line 70

### `cfw_after_plugin_data_upgrades`

*Fires after plugin data upgrades.*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this->db_version` |  | 

**Changelog**

Version | Description
------- | -----------
`5.0.0` | 

Source: ./includes/DatabaseUpdatesManager.php, line 98

### `cfw_acr_activate`

*Action: cfw_acr_activate*

Fires when the plugin is activated.


**Changelog**

Version | Description
------- | -----------
`8.0.0` | 

Source: ./includes/DatabaseUpdatesManager.php, line 428

### `cfw_checkout_loaded_pre_head`

*Fires before document start*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/Redirect.php, line 180

### `cfw_before_header`

*Fires before header is output*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/Redirect.php, line 205

### `cfw_custom_header`

*Fires when custom header is hooked*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/Redirect.php, line 213

### `cfw_after_header`

*Fires after header is output*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/Redirect.php, line 223

### `cfw_wp_head`

*Fires after wp_head()*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/Redirect.php, line 240

### `cfw_custom_footer`

*Fires when custom footer is hooked*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/Redirect.php, line 293

### `cfw_wp_footer`

*Fires after wp_footer() is called*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/Redirect.php, line 308

### `cfw_template_after_init_order_pay`

*Fires when order pay page is initted*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$global_template_parameters` | `array` | The global template parameters

**Changelog**

Version | Description
------- | -----------
`8.1.6` | 

Source: ./includes/Loaders/LoaderAbstract.php, line 234

### `cfw_checkout_loaded_pre_head`

*Fires after the thank you page is initiated*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/LoaderAbstract.php, line 290

### `cfw_template_before_load`

*Fires before template pieces are loaded*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$template_file` | `string` | The template file

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/LoaderAbstract.php, line 313

### `cfw_template_after_load`

*Fires after template pieces are loaded*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$template_file` | `string` | The template file

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/LoaderAbstract.php, line 325

### `cfw_output_fieldset`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$account_checkout_fields` |  | 
`'account'` |  | 

Source: ./sources/php/functions.php, line 62

### `cfw_output_fieldset`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`cfw_get_shipping_checkout_fields()` |  | 
`'shipping'` |  | 

Source: ./sources/php/functions.php, line 104

### `cfw_output_fieldset`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$billing_checkout_fields` |  | 
`'billing'` |  | 

Source: ./sources/php/functions.php, line 132

### `cfw_output_fieldset`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$billing_fields_in_common` |  | 
`'billing'` |  | 

Source: ./sources/php/functions.php, line 132

### `cfw_output_fieldset`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$unique_fields` |  | 
`'billing_unique'` |  | 

Source: ./sources/php/functions.php, line 195

### `cfw_after_shipping_methods`

*Fires after shipping methods in table*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 503

### `cfw_get_payment_methods_html`

*Fires before payment methods html is fetched*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 517

### `cfw_payment_methods_ul_start`

*Fires at start of payment methods UL*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 548

### `cfw_payment_gateway_list_{$gateway->id}_alternate`

*Fires after payment method LI to allow alternate / additional output*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array($count)` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 669

### `cfw_payment_methods_ul_end`

*Fires after bottom of payment methods UL*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 683

### `cfw_cart_html_table_start`

*Fires at start of cart table*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 751

### `cfw_cart_item_after_data`

*Fires after cart item data output*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$item->get_raw_item()` |  | 
`$item->get_item_key()` |  | 
`$item` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 825

### `cfw_before_cart_item_subtotal`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$item` |  | 

Source: ./sources/php/functions.php, line 758

### `cfw_after_cart_item_row`

*Fires after cart item row <tr/> is outputted*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$item->get_raw_item()` |  | 
`$item->get_item_key()` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 846

### `cfw_order_item_after_data`

*Fires after cart item data output*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$item->get_raw_item()` |  | 
`$item->get_item_key()` |  | 
`$item` | `\Objectiv\Plugins\Checkout\Model\OrderItem` | Order item object

**Changelog**

Version | Description
------- | -----------
`7.1.3` | 

Source: ./sources/php/functions.php, line 907

### `cfw_before_cart_item_subtotal`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$item` |  | 

Source: ./sources/php/functions.php, line 867

### `cfw_side_cart_item_after_data`

*Fires after cart item data output*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$item->get_raw_item()` |  | 
`$item->get_item_key()` |  | 
`$item` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1011

### `cfw_before_cart_item_subtotal`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$item` |  | 

Source: ./sources/php/functions.php, line 955

### `cfw_side_cart_item_after_columns`

*Fires after cart item columns*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$item` | `\Objectiv\Plugins\Checkout\Model\CartItem` | Cart item

**Changelog**

Version | Description
------- | -----------
`7.9.3` | 

Source: ./sources/php/functions.php, line 1030

### `cfw_before_cart_summary_totals`

*Fires at start of cart summary totals table*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1265

### `cfw_after_cart_summary_totals`

*Fires at end of cart summary totals table before </table> tag*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1288

### `cfw_before_payment_method_heading`

*Fires above the payment method heading*


**Changelog**

Version | Description
------- | -----------
`5.1.1` | 

Source: ./sources/php/functions.php, line 1365

### `cfw_checkout_before_payment_methods`

*Fires after payment methods heading and before transaction are encrypted statement*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1390

### `cfw_checkout_after_payment_methods`

*Fires at end of payment methods container before </div> tag*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1439

### `cfw_checkout_before_billing_address`

*Fires before billing address radio group is output*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1453

### `cfw_after_same_as_shipping_address_label`

*Fires after same as shipping address label*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1509

### `cfw_start_billing_address_container`

*Fires before billing address inside billing address container*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1533

### `cfw_end_billing_address_container`

*Fires after billing address inside billing address container*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1542

### `cfw_start_billing_address_container`

*Fires before billing address inside billing address container*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1558

### `cfw_end_billing_address_container`

*Fires after billing address inside billing address container*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1567

### `cfw_checkout_after_billing_address`

*Fires after billing address*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1578

### `cfw_before_breadcrumb_navigation`

*Fires before breadcrumb navigation is output*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1975

### `cfw_after_breadcrumb_navigation`

*Fires after breadcrumb navigation is output*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1995

### `cfw_cart_updated`

*Fires after the cart is updated*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$cart_updated` | `bool` | Whether the cart was updated
`$context` | `string` | The context of the cart update

**Changelog**

Version | Description
------- | -----------
`6.1.7` | 

Source: ./sources/php/functions.php, line 2522

### `cfw_after_modal_order_bump_variable_product_form`

*Action after modal order bump variable product form.*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$variable_product` | `\WC_Product` | 
`$bump` | `\Objectiv\Plugins\Checkout\Interfaces\BumpInterface` | 

**Changelog**

Version | Description
------- | -----------
`8.2.18` | 

Source: ./sources/php/functions.php, line 4226

### `cfw_after_modal_order_bump_regular_product_form`

*Action after modal order bump regular product form.*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$product` | `\WC_Product` | 
`$bump` | `\Objectiv\Plugins\Checkout\Interfaces\BumpInterface` | 

**Changelog**

Version | Description
------- | -----------
`8.2.18` | 

Source: ./sources/php/functions.php, line 4301

### `cfw_init_ab_tests`

*Load AB tests here*


**Changelog**

Version | Description
------- | -----------
`8.2.8` | 

Source: ./sources/php/init.php, line 270

### `cfw_do_plugin_activation`


Source: ./sources/php/init.php, line 1054

### `cfw_do_plugin_deactivation`


Source: ./sources/php/init.php, line 1061

### `cfw_permissioned_init`

*Permissioned Init*

This hook runs on init if CheckoutWC is enabled and the license is valid, or the current user is an admin


**Changelog**

Version | Description
------- | -----------
`8.2.11` | 

Source: ./sources/php/init.php, line 1123

### `cfw_after_cart_summary`

*Fires after cart summary before closing </div> tag*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/template-functions.php, line 143

### `cfw_before_print_notices`

*Fires before printing notices*


**Changelog**

Version | Description
------- | -----------
`9.0.0` | 

Source: ./sources/php/template-functions.php, line 265

### `cfw_payment_request_buttons`

*Hook for adding payment request buttons*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/template-functions.php, line 290

### `cfw_after_payment_request_buttons`

*Hook for adding payment request buttons separator*


**Changelog**

Version | Description
------- | -----------
`7.0.0` | 

Source: ./sources/php/template-functions.php, line 299

### `cfw_before_customer_info_account_details`

*Fires before account details on customer info tab*


**Changelog**

Version | Description
------- | -----------
`7.0.0` | 

Source: ./sources/php/template-functions.php, line 349

### `cfw_after_customer_info_account_details`

*Fires before account details on customer info tab*


**Changelog**

Version | Description
------- | -----------
`7.0.0` | 

Source: ./sources/php/template-functions.php, line 362

### `cfw_before_enhanced_login_prompt`

*Fires before enhanced login prompt*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/template-functions.php, line 388

### `cfw_after_enhanced_login_prompt`

*Fires after enhanced login prompt*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 421

### `cfw_checkout_after_email`

*Fires after email field output*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/template-functions.php, line 453

### `cfw_checkout_before_customer_info_address`

*Fires before customer info address module*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 604

### `cfw_checkout_before_shipping_address`

*Fires before shipping address*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 615

### `cfw_checkout_before_billing_address`

*Fires before billing address*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 622

### `cfw_after_customer_info_address_heading`

*Fires after customer info address heading*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 666

### `cfw_after_customer_info_shipping_address_heading`

*Fires after customer info address shipping heading*


**Changelog**

Version | Description
------- | -----------
`4.0.4` | 

Source: ./sources/php/template-functions.php, line 674

### `cfw_after_customer_info_billing_address_heading`

*Fires after customer info address billing heading*


**Changelog**

Version | Description
------- | -----------
`4.0.4` | 

Source: ./sources/php/template-functions.php, line 681

### `cfw_start_billing_address_container`

*Fires before billing address inside billing address container*


**Changelog**

Version | Description
------- | -----------
`4.0.4` | 

Source: ./sources/php/template-functions.php, line 693

### `cfw_end_billing_address_container`

*Fires before billing address inside billing address container*


**Changelog**

Version | Description
------- | -----------
`4.0.4` | 

Source: ./sources/php/template-functions.php, line 702

### `cfw_start_shipping_address_container`

*Fires before shipping address inside shipping address container*


**Changelog**

Version | Description
------- | -----------
`4.0.4` | 

Source: ./sources/php/template-functions.php, line 711

### `cfw_end_shipping_address_container`

*Fires after shipping address inside shipping address container*


**Changelog**

Version | Description
------- | -----------
`4.0.4` | 

Source: ./sources/php/template-functions.php, line 720

### `cfw_checkout_after_shipping_address`

*Fires after shipping address*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 732

### `cfw_checkout_after_billing_address`

*Fires after billing address*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 739

### `cfw_checkout_after_customer_info_address`

*Fires at the bottom of customer info address module after closing </div>*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 750

### `cfw_checkout_before_customer_info_tab_nav`

*Fires before customer info tab navigation container*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 809

### `cfw_checkout_after_customer_info_tab_nav`

*Fires after customer info tab navigation container*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 827

### `cfw_checkout_before_payment_method_tab_nav`

*Fires before payment method tab navigation container*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 843

### `cfw_checkout_after_payment_method_tab_nav`

*Fires after payment method tab navigation container*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 868

### `cfw_checkout_before_shipping_method_tab_nav`

*Fires before shipping method tab navigation container*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 939

### `cfw_checkout_after_shipping_method_tab_nav`

*Fires after shipping method tab navigation container*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 956

### `cfw_before_payment_methods_block`

*Fires before payment methods block*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$object` |  | 
`$show_title` |  | 

**Changelog**

Version | Description
------- | -----------
`7.2.7` | 

Source: ./sources/php/template-functions.php, line 973

### `cfw_after_payment_methods_block`

*Fires after the payment methods block*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$object` |  | 
`$show_title` |  | 

**Changelog**

Version | Description
------- | -----------
`7.2.7` | 

Source: ./sources/php/template-functions.php, line 982

### `cfw_after_payment_information_address_heading`

*Fires after the billing address heading on the payment tab*


**Changelog**

Version | Description
------- | -----------
`5.3.2` | 

Source: ./sources/php/template-functions.php, line 1023

### `cfw_checkout_after_payment_tab_billing_address`

*Fires after payment method tab billing address*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 1047

### `cfw_output_fieldset`

*Payment method tab order notes*

This also handles any custom fields attached to order notes area

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->checkout()->get_checkout_fields('order')` |  | 

Source: ./sources/php/template-functions.php, line 1055

### `cfw_checkout_before_payment_method_terms_checkbox`

*Fires before payment method terms and conditions output*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 1084

### `cfw_checkout_before_payment_method_tab_nav`

*Fires before payment method tab navigation container*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 1102

### `cfw_payment_nav_place_order_button`

*Payment method tab nav*

Includes previous tab and place order buttons


Source: ./sources/php/template-functions.php, line 1094

### `cfw_checkout_after_payment_method_tab_nav`

*Fires after payment method tab navigation container*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 1130

### `cfw_payment_nav_place_order_button`

*Order review tab nav*

Includes previous tab and place order buttons


Source: ./sources/php/template-functions.php, line 1138

### `cfw_checkout_after_payment_method_tab_nav`

*Fires after payment method tab navigation container*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 1163

### `cfw_after_cart_html`

*After cart html table output*


**Changelog**

Version | Description
------- | -----------
`4.3.4` | 

Source: ./sources/php/template-functions.php, line 1186

### `cfw_before_coupon_module`

*Fires before coupon module*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$mobile` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 1200

### `cfw_after_coupon_module`

*Fires after coupon module*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 1211

### `cfw_after_thank_you_order_updates_text`

*Fires after the order updates text is output*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` |  | 

**Changelog**

Version | Description
------- | -----------
`7.2.7` | 

Source: ./sources/php/template-functions.php, line 1511

### `cfw_before_thank_you_customer_information`

*Fires before thank you customer information output (after Information heading)*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 1588

### `cfw_checkout_customer_info_tab`

*Outputs customer info tab content*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 1885

### `cfw_checkout_shipping_method_tab`

*Outputs customer info tab content*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 1899

### `cfw_checkout_payment_method_tab`

*Outputs customer info tab content*


**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 1913

### `cfw_thank_you_before_main_container`

*Fires before <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/thank-you.php, line 6

### `cfw_thank_you_main_container_start`

*Fires at top of <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/thank-you.php, line 16

### `cfw_thank_you_before_order_review`

*Fires at top of #order_review on thank you page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/thank-you.php, line 31

### `cfw_thank_you_content`

*Fires before <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object
`$order_statuses` | `array` | The order statuses we are progressing through
`$show_downloads` | `bool` | Whether to show downloads section
`$downloads` | `array` | The downloads

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/thank-you.php, line 38

### `cfw_thank_you_after_order_review`

*Fires at the end of <main> container on thank you page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/thank-you.php, line 63

### `cfw_thank_you_cart_summary`

*Fires in cart summary sidebar container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/thank-you.php, line 75

### `cfw_thank_you_main_container_end`

*Fires at the bottom of <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/thank-you.php, line 89

### `cfw_thank_you_after_main_container`

*Fires after <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/thank-you.php, line 100

### `cfw_checkout_before_main_container`

*Fires before <main> container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->checkout()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/content.php, line 6

### `cfw_checkout_main_container_start`

*Fires at the beginning of the <main> container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/content.php, line 16

### `cfw_checkout_before_order_review_container`

*Fires before the #order_review container inside the checkout form*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/content.php, line 37

### `cfw_checkout_before_order_review`

*Fires at the top of the #order_review container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/content.php, line 47

### `cfw_checkout_tabs`

*Fires in the #order_review container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/content.php, line 56

### `cfw_checkout_after_order_review`

*Fires at the bottom of the #order_review container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/content.php, line 65

### `cfw_checkout_after_order_review_container`

*Fires after the #order_review container inside the checkout form*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/content.php, line 75

### `cfw_checkout_cart_summary`

*Fires inside the cart summary sidebar container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/content.php, line 86

### `cfw_checkout_after_cart_summary_container`

*Fires after inside the cart summary sidebar container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/content.php, line 96

### `cfw_checkout_form`

*Fires to allow standard CheckoutWC form to be replaced.*

Only fires when cfw_replace_form is true


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/content.php, line 106

### `cfw_checkout_main_container_end`

*Fires at the bottom of <main> container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->checkout()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/content.php, line 118

### `cfw_checkout_after_main_container`

*Fires after the <main> container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->checkout()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/content.php, line 128

### `cfw_before_footer`

*Fires at the top of footer*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/footer.php, line 15

### `cfw_footer_content`

*Hook to output footer content*


**Changelog**

Version | Description
------- | -----------
`8.0.0` | 

Source: ./templates/futurist/footer.php, line 22

### `cfw_after_footer`

*Fires at the bottom of footer*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/footer.php, line 29

### `cfw_order_pay_before_main_container`

*Fires before <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/order-pay.php, line 6

### `cfw_order_pay_main_container_start`

*Fires at top of <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/order-pay.php, line 16

### `cfw_order_pay_before_order_review`

*Fires at top of #order_review on order pay page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/order-pay.php, line 31

### `cfw_order_pay_content`

*Fires in #order_review container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object
`$call_receipt_hook` | `bool` | Whether to call receipt hook
`$available_gateways` | `array` | The available gateways
`$order_button_text` | `string` | The text to use for the place order button

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/order-pay.php, line 38

### `cfw_order_pay_after_order_review`

*Fires at bottom of #order_review on order pay page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/order-pay.php, line 50

### `cfw_order_pay_cart_summary`

*Fires in cart summary sidebar container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/order-pay.php, line 62

### `cfw_order_pay_main_container_end`

*Fires at bottom of <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/order-pay.php, line 76

### `cfw_order_pay_after_main_container`

*Fires after <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/futurist/order-pay.php, line 87

### `cfw_before_footer`

*Fires at the top of footer*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/functions.php, line 45

### `cfw_footer_content`

*Hook to output footer content*


**Changelog**

Version | Description
------- | -----------
`8.0.0` | 

Source: ./templates/copify/functions.php, line 52

### `cfw_after_footer`

*Fires at the bottom of footer*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/functions.php, line 59

### `cfw_thank_you_before_main_container`

*Fires before <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/thank-you.php, line 6

### `cfw_thank_you_main_container_start`

*Fires at top of <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/thank-you.php, line 16

### `cfw_thank_you_before_order_review`

*Fires at top of #order_review on thank you page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/thank-you.php, line 31

### `cfw_thank_you_content`

*Fires before <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object
`$order_statuses` | `array` | The order statuses we are progressing through
`$show_downloads` | `bool` | Whether to show downloads section
`$downloads` | `array` | The downloads

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/thank-you.php, line 38

### `cfw_thank_you_after_order_review`

*Fires at the end of <main> container on thank you page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/thank-you.php, line 63

### `cfw_thank_you_cart_summary`

*Fires in cart summary sidebar container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/thank-you.php, line 75

### `cfw_thank_you_main_container_end`

*Fires at the bottom of <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/thank-you.php, line 89

### `cfw_thank_you_after_main_container`

*Fires after <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/thank-you.php, line 100

### `cfw_checkout_before_main_container`

*Fires before <main> container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->checkout()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/content.php, line 6

### `cfw_checkout_main_container_start`

*Fires at the beginning of the <main> container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/content.php, line 18

### `cfw_checkout_before_order_review_container`

*Fires before the #order_review container inside the checkout form*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/content.php, line 41

### `cfw_checkout_before_order_review`

*Fires at the top of the #order_review container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/content.php, line 51

### `cfw_checkout_tabs`

*Fires in the #order_review container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/content.php, line 60

### `cfw_checkout_after_order_review`

*Fires at the bottom of the #order_review container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/content.php, line 69

### `cfw_checkout_after_order_review_container`

*Fires after the #order_review container inside the checkout form*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/content.php, line 79

### `cfw_checkout_cart_summary`

*Fires inside the cart summary sidebar container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/content.php, line 90

### `cfw_checkout_after_cart_summary_container`

*Fires after inside the cart summary sidebar container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/content.php, line 100

### `cfw_checkout_form`

*Fires to allow standard CheckoutWC form to be replaced.*

Only fires when cfw_replace_form is true


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/content.php, line 110

### `cfw_checkout_main_container_end`

*Fires at the bottom of <main> container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->checkout()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/content.php, line 124

### `cfw_checkout_after_main_container`

*Fires after the <main> container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->checkout()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/content.php, line 136

### `cfw_order_pay_before_main_container`

*Fires before <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/order-pay.php, line 6

### `cfw_order_pay_main_container_start`

*Fires at top of <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/order-pay.php, line 16

### `cfw_order_pay_before_order_review`

*Fires at top of #order_review on order pay page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/order-pay.php, line 31

### `cfw_order_pay_content`

*Fires in #order_review container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object
`$call_receipt_hook` | `bool` | Whether to call receipt hook
`$available_gateways` | `array` | The available gateways
`$order_button_text` | `string` | The text to use for the place order button

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/order-pay.php, line 38

### `cfw_order_pay_after_order_review`

*Fires at bottom of #order_review on order pay page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/order-pay.php, line 50

### `cfw_order_pay_cart_summary`

*Fires in cart summary sidebar container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/order-pay.php, line 62

### `cfw_order_pay_main_container_end`

*Fires at bottom of <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/order-pay.php, line 76

### `cfw_order_pay_after_main_container`

*Fires after <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/copify/order-pay.php, line 87

### `cfw_thank_you_before_main_container`

*Fires before <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/thank-you.php, line 6

### `cfw_thank_you_main_container_start`

*Fires at top of <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/thank-you.php, line 16

### `cfw_thank_you_before_order_review`

*Fires at top of #order_review on thank you page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/thank-you.php, line 31

### `cfw_thank_you_content`

*Fires before <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object
`$order_statuses` | `array` | The order statuses we are progressing through
`$show_downloads` | `bool` | Whether to show downloads section
`$downloads` | `array` | The downloads

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/thank-you.php, line 38

### `cfw_thank_you_after_order_review`

*Fires at the end of <main> container on thank you page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/thank-you.php, line 63

### `cfw_thank_you_cart_summary`

*Fires in cart summary sidebar container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/thank-you.php, line 75

### `cfw_thank_you_main_container_end`

*Fires at the bottom of <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/thank-you.php, line 89

### `cfw_thank_you_after_main_container`

*Fires after <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/thank-you.php, line 100

### `cfw_checkout_before_main_container`

*Fires before <main> container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->checkout()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/content.php, line 6

### `cfw_checkout_main_container_start`

*Fires at the beginning of the <main> container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/content.php, line 16

### `cfw_checkout_before_order_review_container`

*Fires before the #order_review container inside the checkout form*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/content.php, line 37

### `cfw_checkout_before_order_review`

*Fires at the top of the #order_review container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/content.php, line 47

### `cfw_checkout_tabs`

*Fires in the #order_review container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/content.php, line 56

### `cfw_checkout_after_order_review`

*Fires at the bottom of the #order_review container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/content.php, line 65

### `cfw_checkout_after_order_review_container`

*Fires after the #order_review container inside the checkout form*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/content.php, line 75

### `cfw_checkout_cart_summary`

*Fires inside the cart summary sidebar container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/content.php, line 86

### `cfw_checkout_after_cart_summary_container`

*Fires after inside the cart summary sidebar container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/content.php, line 96

### `cfw_checkout_form`

*Fires to allow standard CheckoutWC form to be replaced.*

Only fires when cfw_replace_form is true


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/content.php, line 106

### `cfw_checkout_main_container_end`

*Fires at the bottom of <main> container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->checkout()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/content.php, line 118

### `cfw_checkout_after_main_container`

*Fires after the <main> container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->checkout()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/content.php, line 128

### `cfw_before_footer`

*Fires at the top of footer*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/footer.php, line 15

### `cfw_footer_content`

*Hook to output footer content*


**Changelog**

Version | Description
------- | -----------
`8.0.0` | 

Source: ./templates/default/footer.php, line 22

### `cfw_after_footer`

*Fires at the bottom of footer*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/footer.php, line 29

### `cfw_order_pay_before_main_container`

*Fires before <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/order-pay.php, line 6

### `cfw_order_pay_main_container_start`

*Fires at top of <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/order-pay.php, line 16

### `cfw_order_pay_before_order_review`

*Fires at top of #order_review on order pay page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/order-pay.php, line 31

### `cfw_order_pay_content`

*Fires in #order_review container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object
`$call_receipt_hook` | `bool` | Whether to call receipt hook
`$available_gateways` | `array` | The available gateways
`$order_button_text` | `string` | The text to use for the place order button

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/order-pay.php, line 38

### `cfw_order_pay_after_order_review`

*Fires at bottom of #order_review on order pay page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/order-pay.php, line 50

### `cfw_order_pay_cart_summary`

*Fires in cart summary sidebar container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/order-pay.php, line 62

### `cfw_order_pay_main_container_end`

*Fires at bottom of <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/order-pay.php, line 76

### `cfw_order_pay_after_main_container`

*Fires after <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/default/order-pay.php, line 87

### `cfw_thank_you_before_main_container`

*Fires before <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/thank-you.php, line 6

### `cfw_thank_you_main_container_start`

*Fires at top of <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/thank-you.php, line 16

### `cfw_thank_you_before_order_review`

*Fires at top of #order_review on thank you page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/thank-you.php, line 31

### `cfw_thank_you_content`

*Fires before <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object
`$order_statuses` | `array` | The order statuses we are progressing through
`$show_downloads` | `bool` | Whether to show downloads section
`$downloads` | `array` | The downloads

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/thank-you.php, line 38

### `cfw_thank_you_after_order_review`

*Fires at the end of <main> container on thank you page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/thank-you.php, line 63

### `cfw_thank_you_cart_summary`

*Fires in cart summary sidebar container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/thank-you.php, line 75

### `cfw_thank_you_main_container_end`

*Fires at the bottom of <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/thank-you.php, line 89

### `cfw_thank_you_after_main_container`

*Fires after <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/thank-you.php, line 100

### `cfw_checkout_before_main_container`

*Fires before <main> container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->checkout()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/content.php, line 6

### `cfw_checkout_main_container_start`

*Fires at the beginning of the <main> container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/content.php, line 18

### `cfw_checkout_before_order_review_container`

*Fires before the #order_review container inside the checkout form*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/content.php, line 40

### `cfw_checkout_before_order_review`

*Fires at the top of the #order_review container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/content.php, line 50

### `cfw_checkout_tabs`

*Fires in the #order_review container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/content.php, line 59

### `cfw_checkout_after_order_review`

*Fires at the bottom of the #order_review container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/content.php, line 68

### `cfw_checkout_after_order_review_container`

*Fires after the #order_review container inside the checkout form*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/content.php, line 78

### `cfw_checkout_cart_summary`

*Fires inside the cart summary sidebar container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/content.php, line 89

### `cfw_checkout_after_cart_summary_container`

*Fires after inside the cart summary sidebar container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/content.php, line 99

### `cfw_checkout_form`

*Fires to allow standard CheckoutWC form to be replaced.*

Only fires when cfw_replace_form is true


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/content.php, line 109

### `cfw_checkout_main_container_end`

*Fires at the bottom of <main> container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->checkout()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/content.php, line 123

### `cfw_checkout_after_main_container`

*Fires after the <main> container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->checkout()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/content.php, line 135

### `cfw_before_footer`

*Fires at the top of footer*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/footer.php, line 15

### `cfw_footer_content`

*Hook to output footer content*


**Changelog**

Version | Description
------- | -----------
`8.0.0` | 

Source: ./templates/glass/footer.php, line 22

### `cfw_after_footer`

*Fires at the bottom of footer*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/footer.php, line 29

### `cfw_order_pay_before_main_container`

*Fires before <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/order-pay.php, line 6

### `cfw_order_pay_main_container_start`

*Fires at top of <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/order-pay.php, line 16

### `cfw_order_pay_before_order_review`

*Fires at top of #order_review on order pay page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/order-pay.php, line 31

### `cfw_order_pay_content`

*Fires in #order_review container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object
`$call_receipt_hook` | `bool` | Whether to call receipt hook
`$available_gateways` | `array` | The available gateways
`$order_button_text` | `string` | The text to use for the place order button

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/order-pay.php, line 38

### `cfw_order_pay_after_order_review`

*Fires at bottom of #order_review on order pay page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/order-pay.php, line 50

### `cfw_order_pay_cart_summary`

*Fires in cart summary sidebar container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/order-pay.php, line 62

### `cfw_order_pay_main_container_end`

*Fires at bottom of <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/order-pay.php, line 76

### `cfw_order_pay_after_main_container`

*Fires after <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/glass/order-pay.php, line 87

### `cfw_before_footer`

*Fires at the top of footer*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/functions.php, line 46

### `cfw_footer_content`

*Hook to output footer content*


**Changelog**

Version | Description
------- | -----------
`8.0.0` | 

Source: ./templates/groove/functions.php, line 53

### `cfw_after_footer`

*Fires at the bottom of footer*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/functions.php, line 60

### `cfw_thank_you_before_main_container`

*Fires before <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/thank-you.php, line 6

### `cfw_thank_you_main_container_start`

*Fires at top of <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/thank-you.php, line 16

### `cfw_thank_you_before_order_review`

*Fires at top of #order_review on thank you page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/thank-you.php, line 31

### `cfw_thank_you_content`

*Fires before <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object
`$order_statuses` | `array` | The order statuses we are progressing through
`$show_downloads` | `bool` | Whether to show downloads section
`$downloads` | `array` | The downloads

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/thank-you.php, line 38

### `cfw_thank_you_after_order_review`

*Fires at the end of <main> container on thank you page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/thank-you.php, line 63

### `cfw_thank_you_cart_summary`

*Fires in cart summary sidebar container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/thank-you.php, line 75

### `cfw_thank_you_main_container_end`

*Fires at the bottom of <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/thank-you.php, line 89

### `cfw_thank_you_after_main_container`

*Fires after <main> container on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/thank-you.php, line 100

### `cfw_checkout_before_main_container`

*Fires before <main> container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->checkout()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/content.php, line 6

### `cfw_checkout_main_container_start`

*Fires at the beginning of the <main> container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/content.php, line 18

### `cfw_checkout_before_order_review_container`

*Fires before the #order_review container inside the checkout form*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/content.php, line 41

### `cfw_checkout_before_order_review`

*Fires at the top of the #order_review container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/content.php, line 51

### `cfw_checkout_tabs`

*Fires in the #order_review container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/content.php, line 60

### `cfw_checkout_after_order_review`

*Fires at the bottom of the #order_review container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/content.php, line 69

### `cfw_checkout_after_order_review_container`

*Fires after the #order_review container inside the checkout form*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/content.php, line 79

### `cfw_checkout_cart_summary`

*Fires inside the cart summary sidebar container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/content.php, line 90

### `cfw_checkout_after_cart_summary_container`

*Fires after inside the cart summary sidebar container*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/content.php, line 100

### `cfw_checkout_form`

*Fires to allow standard CheckoutWC form to be replaced.*

Only fires when cfw_replace_form is true


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/content.php, line 110

### `cfw_checkout_main_container_end`

*Fires at the bottom of <main> container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->checkout()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/content.php, line 122

### `cfw_checkout_after_main_container`

*Fires after the <main> container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->checkout()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/content.php, line 132

### `cfw_order_pay_before_main_container`

*Fires before <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/order-pay.php, line 6

### `cfw_order_pay_main_container_start`

*Fires at top of <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/order-pay.php, line 16

### `cfw_order_pay_before_order_review`

*Fires at top of #order_review on order pay page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/order-pay.php, line 31

### `cfw_order_pay_content`

*Fires in #order_review container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object
`$call_receipt_hook` | `bool` | Whether to call receipt hook
`$available_gateways` | `array` | The available gateways
`$order_button_text` | `string` | The text to use for the place order button

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/order-pay.php, line 38

### `cfw_order_pay_after_order_review`

*Fires at bottom of #order_review on order pay page*


**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/order-pay.php, line 50

### `cfw_order_pay_cart_summary`

*Fires in cart summary sidebar container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/order-pay.php, line 62

### `cfw_order_pay_main_container_end`

*Fires at bottom of <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/order-pay.php, line 76

### `cfw_order_pay_after_main_container`

*Fires after <main> container on order pay page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./templates/groove/order-pay.php, line 87

## Filters

### `cfw_disable_woocommerce_gift_cards_compatibility`

*Filter whether to disable CheckoutWC WooCommerce Gift Cards compatibility class*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

**Changelog**

Version | Description
------- | -----------
`5.3.5` | 

Source: ./includes/Compatibility/Plugins/WooCommerceGiftCards.php, line 13

### `cfw_compatibility_woocommerce_gift_cards_field_label`

*Filter CheckoutWC WooCommerce Gift Cards field label*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`cfw_esc_attr__('Enter your code&hellip;', 'woocommerce-gift-cards')` |  | 

**Changelog**

Version | Description
------- | -----------
`6.0.7` | 

Source: ./includes/Compatibility/Plugins/WooCommerceGiftCards.php, line 60

### `cfw_compatibility_woocommerce_gift_cards_field_placeholder`

*Filter CheckoutWC WooCommerce Gift Cards field placeholder*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`cfw_esc_attr__('Enter your code&hellip;', 'woocommerce-gift-cards')` |  | 

**Changelog**

Version | Description
------- | -----------
`6.0.7` | 

Source: ./includes/Compatibility/Plugins/WooCommerceGiftCards.php, line 68

### `cfw_compatibility_woocommerce_gift_cards_heading_text`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`cfw_esc_html__('Have a gift card?', 'woocommerce-gift-cards')` |  | 

Source: ./includes/Compatibility/Plugins/WooCommerceGiftCards.php, line 96

### `cfw_hide_optional_fiscal_code`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

Source: ./includes/Compatibility/Plugins/Fattureincloud.php, line 43

### `cfw_klaviyo_output_hook`

*Where to output Klaviyo checkboxes*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'cfw_checkout_before_payment_method_tab_nav'` |  | 

**Changelog**

Version | Description
------- | -----------
`5.1.2` | 

Source: ./includes/Compatibility/Plugins/Klaviyo.php, line 19

### `cfw_active_campaign_checkbox_hook`

*Filters hook to render Active Campaign checkbox output*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'cfw_checkout_before_payment_method_tab_nav'` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./includes/Compatibility/Plugins/ActiveCampaign.php, line 16

### `cfw_suppress_add_to_cart_notices`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

Source: ./includes/Compatibility/Plugins/WooCommerceCore.php, line 164

### `cfw_suppress_add_to_cart_notices`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

Source: ./includes/Compatibility/Plugins/WooCommerceCore.php, line 196

### `cfw_highlighted_countries`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('highlighted_countries')` |  | 

Source: ./includes/Compatibility/Plugins/WooCommerceCore.php, line 224

### `cfw_template_tab_container_el`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'order_review'` |  | 

Source: ./includes/Compatibility/Plugins/MixPanel.php, line 36

### `cfw_template_payment_method_el`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'cfw-payment-method'` |  | 

Source: ./includes/Compatibility/Plugins/MixPanel.php, line 37

### `cfw_payment_gateway_{$kp->id}_content`

*Filters whether to show custom klarna payment box HTML*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$kp->has_fields() || $kp->get_description()` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./includes/Compatibility/Gateways/KlarnaPayment.php, line 95

### `cfw_payment_gateway_field_html_{$kp->id}`

*Filters klarna payment gateway output*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$field_html` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./includes/Compatibility/Gateways/KlarnaPayment.php, line 123

### `cfw_wcpay_payment_requests_ignore_shipping_phone`

*Filters whether to override Stripe payment request button heights*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

**Changelog**

Version | Description
------- | -----------
`5.3.3` | 

Source: ./includes/Compatibility/Gateways/WooCommercePayments.php, line 17

### `cfw_payment_gateway_{$kp->id}_content`

*Filters whether to show custom klarna payment box HTML*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$kp->has_fields() || $kp->get_description()` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./includes/Compatibility/Gateways/KlarnaPayment3.php, line 103

### `cfw_payment_gateway_field_html_{$kp->id}`

*Filters klarna payment gateway output*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$field_html` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./includes/Compatibility/Gateways/KlarnaPayment3.php, line 132

### `cfw_billing_address_heading`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('Billing address', 'checkout-wc')` |  | 

Source: ./includes/Compatibility/Gateways/PayPalForWooCommerce.php, line 178

### `cfw_amazon_suppress_shipping_field_validation`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

Source: ./includes/Compatibility/Gateways/AmazonPayV1.php, line 266

### `cfw_amazon_suppress_shipping_field_validation`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

Source: ./includes/Compatibility/Gateways/AmazonPayLegacy.php, line 247

### `cfw_show_klarna_checkout_express_button`

*Whether to show the Klarna Checkout button*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

**Changelog**

Version | Description
------- | -----------
`7.1.7` | 

Source: ./includes/Compatibility/Gateways/KlarnaCheckout.php, line 83

### `cfw_stripe_payment_requests_ignore_shipping_phone`

*Filters whether to override Stripe payment request button heights*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

**Changelog**

Version | Description
------- | -----------
`4.3.3` | 

Source: ./includes/Compatibility/Gateways/Stripe.php, line 20

### `cfw_stripe_compat_override_request_btn_height`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

Source: ./includes/Compatibility/Gateways/Stripe.php, line 81

### `cfw_square_payment_requests_ignore_shipping_phone`

*Filters whether to override Stripe payment request button heights*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

**Changelog**

Version | Description
------- | -----------
`4.3.3` | 

Source: ./includes/Compatibility/Gateways/Square.php, line 16

### `cfw_address_field_priorities`

*Filter address field priorities*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this->priorities` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./includes/AddressFieldsAugmenter.php, line 54

### `cfw_enable_fullname_field`

*Filter whether to enable full name field*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'yes' === SettingsManager::instance()->get_setting('use_fullname_field') && is_cfw_page()` |  | 

**Changelog**

Version | Description
------- | -----------
`7.1.0` | 

Source: ./includes/AddressFieldsAugmenter.php, line 103

### `cfw_enable_discrete_address_1_fields`

*Filter whether to enable discreet address 1 fields*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'yes' === SettingsManager::instance()->get_setting('enable_discreet_address_1_fields') && is_cfw_page()` |  | 

**Changelog**

Version | Description
------- | -----------
`7.1.0` | 

Source: ./includes/AddressFieldsAugmenter.php, line 112

### `cfw_non_floating_label_field_types`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array('checkbox', 'radio')` |  | 

Source: ./includes/FormFieldAugmenter.php, line 121

### `cfw_form_field_append_optional_to_placeholder`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`isset($args['suppress_optional_suffix'])` |  | 
`$key` |  | 

Source: ./includes/FormFieldAugmenter.php, line 145

### `cfw_select_field_options`

*Filters the select field options for edge cases*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$args['options']` |  | 
`$args` | `array` | The field arguments
`$key` | `string` | The field key

**Changelog**

Version | Description
------- | -----------
`7.4.0` | 

Source: ./includes/FormFieldAugmenter.php, line 163

### `cfw_checkbox_like_field_types`

*The field type that are like checkboxes*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this->checkbox_like_field_types` |  | 

**Changelog**

Version | Description
------- | -----------
`7.0.10` | 

Source: ./includes/FormFieldAugmenter.php, line 276

### `cfw_replace_form`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

Source: ./includes/Managers/AssetManager.php, line 117

### `cfw_thank_you_page_map_address`

*Filter thank you page map address*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$order->get_address('shipping')` |  | 
`$order` | `\WC_Order` | The order

**Changelog**

Version | Description
------- | -----------
`5.3.9` | 

Source: ./includes/Managers/AssetManager.php, line 192

### `cfw_parsley_locale`

*Filter Parsley validation service locale*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$locale` | `string` | Parsley validation service locale

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Managers/AssetManager.php, line 333

### `cfw_event_object`

*Filter cfw_event_object array*

Localized data available via DataService

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array(
    'data' => array_merge_recursive(AssetManager::get_data(), array('login_form' => cfw_get_login_form_html(), 'lost_password_form' => cfw_get_lost_password_form_html())),
    /**
     * Filter TypeScript compatibility classes and params
     *
     * @param array $compatibility TypeScript compatibility classes and params
     *
     * @since 3.0.0
     *
     */
    'compatibility' => apply_filters(array()),
    'settings' => array(
        'base_country' => WC()->countries->get_base_country(),
        'parsley_locale' => $this->get_parsley_locale(),
        // required for parsley localization
        'user_logged_in' => is_user_logged_in(),
        'login_allowed_at_checkout' => cfw_is_login_at_checkout_allowed(),
        /**
         * Filter whether to validate required registration
         *
         * @param bool $validate_required_registration Validate required registration
         *
         * @since 3.0.0
         *
         */
        'validate_required_registration' => apply_filters(true),
        'default_address_fields' => array_keys(WC()->countries->get_default_address_fields()),
        /**
         * Filter whether to enable zip autocomplete
         *
         * @param bool $enable_zip_autocomplete Enable zip autocomplete
         *
         * @since 2.0.0
         *
         */
        'enable_zip_autocomplete' => (bool) apply_filters(true),
        /**
         * Filter whether to disable email domain validation
         *
         * @param bool $disable_email_domain_validation Disable email domain validation
         *
         * @since 8.2.26
         */
        'disable_email_domain_validation' => (bool) apply_filters(false),
        /**
         * Filter whether to enable field peristence with Garlic.js
         *
         * @param bool $cfw_enable_field_persistence Enable field persistence
         *
         * @since 7.1.10
         *
         */
        'enable_field_persistence' => (bool) apply_filters(true),
        /**
         * Filter whether to disable cart quantity prompt
         *
         * @param bool $disable_cart_quantity_prompt Disable cart quantity prompt
         *
         * @since 8.2.19
         */
        'disable_cart_quantity_prompt' => apply_filters(false),
        /**
         * Filter whether to check create account by default
         *
         * @param bool $check_create_account_by_default Check create account by default
         *
         * @since 3.0.0
         *
         */
        'check_create_account_by_default' => (bool) apply_filters(true),
        /**
         * Filter whether to check whether an existing account matches provided email address
         *
         * @param bool $enable_account_exists_check Enable account exists check when billing email field changed
         *
         * @since 5.3.7
         *
         */
        'enable_account_exists_check' => apply_filters(!is_user_logged_in()),
        'needs_shipping_address' => WC()->cart && WC()->cart->needs_shipping_address(),
        'show_shipping_tab' => cfw_show_shipping_tab(),
        'enable_map_embed' => PlanManager::can_access_feature('enable_map_embed'),
        'disable_auto_open_login_modal' => SettingsManager::instance()->get_setting('disable_auto_open_login_modal') === 'yes',
        'disable_domain_autocomplete' => SettingsManager::instance()->get_setting('disable_domain_autocomplete') === 'yes',
        /**
         * Filter whether to load tabs
         *
         * @param bool $load_tabs Load tabs
         *
         * @since 3.0.0
         *
         */
        'load_tabs' => apply_filters(cfw_is_checkout()),
        'is_checkout_pay_page' => is_checkout_pay_page(),
        'is_order_received_page' => is_order_received_page(),
        /**
         * Filter list of billing country restrictions for Google Maps address autocomplete
         *
         * @param array $address_autocomplete_billing_countries List of country restrictions for Google Maps address autocomplete
         *
         * @since 3.0.0
         *
         */
        'address_autocomplete_billing_countries' => apply_filters(array()),
        'is_registration_required' => WC()->checkout()->is_registration_required(),
        /**
         * Filter whether to automatically generate password for new accounts
         *
         * @param bool $registration_generate_password Automatically generate password for new accounts
         *
         * @since 3.0.0
         *
         */
        'registration_generate_password' => SettingsManager::instance()->get_setting('registration_style') !== 'woocommerce',
        'thank_you_shipping_address' => false,
        'shipping_countries' => $shipping_countries,
        'allowed_countries' => $allowed_countries,
        /**
         * Filter whether to enable discrete address 1 fields
         *
         * @param boolean $discrete_address_1_fields Whether to enable discrete address 1 fields
         *
         * @since 7.0.17
         */
        'enable_discreet_address_1_fields' => apply_filters('yes' === SettingsManager::instance()->get_setting('enable_discreet_address_1_fields')),
        /**
         * Filter whether to enable fullname field
         *
         * @param boolean $enable_fullname_field Whether to enable fullname field
         *
         * @since 7.0.17
         */
        'use_fullname_field' => apply_filters('yes' === SettingsManager::instance()->get_setting('use_fullname_field')),
        'trust_badges' => SettingsManager::instance()->get_setting('new_trust_badges'),
        'trust_badges_display' => SettingsManager::instance()->get_setting('trust_badge_position'),
        /**
         * Filters whether to link cart items to products
         *
         * @param bool $link_cart_items Link cart items to products
         *
         * @since 1.0.0
         *
         */
        'link_items' => apply_filters(SettingsManager::instance()->get_setting('cart_item_link') === 'enabled'),
        'enable_cart_editing' => SettingsManager::instance()->get_setting('enable_cart_editing') === 'yes',
        'show_item_remove_button' => SettingsManager::instance()->get_setting('show_item_remove_button') === 'yes',
        'enable_one_page_checkout' => SettingsManager::instance()->get_setting('enable_one_page_checkout') === 'yes',
        /**
         * Filters whether to show cart item discount on cart item
         *
         * @param bool $show_cart_item_discount Show cart item discount on cart item
         *
         * @since 2.0.0
         *
         */
        'show_item_discount' => apply_filters(SettingsManager::instance()->get_setting('show_side_cart_item_discount') === 'yes'),
        /**
         * Filter intl-tel-input preferred countries
         *
         * @param array $phone_field_preferred_countries List of preferred countries
         *
         * @since 8.2.22
         */
        'phone_field_highlighted_countries' => (array) apply_filters(SettingsManager::instance()->get_setting('highlighted_countries')),
        'store_policies' => $store_policies,
        'ship_to_billing_address_only' => wc_ship_to_billing_address_only(),
        'max_after_checkout_bumps' => $max_after_checkout_bumps < 0 ? 999 : $max_after_checkout_bumps,
        /**
         * Filter list of field persistence service excludes
         *
         * @param array $field_persistence_excludes List of field persistence service excludes
         *
         * @since 3.0.0
         *
         */
        'field_persistence_excludes' => apply_filters(array(
            'input[type="button"]',
            'input[type="file"]',
            'input[type="hidden"]',
            'input[type="submit"]',
            'input[type="reset"]',
            '#cfw-promo-code',
            '.cfw-create-account-checkbox',
            'input[name="payment_method"]',
            'input[name="paypal_pro-card-number"]',
            'input[name="paypal_pro-card-cvc"]',
            'input[name="wc-authorize-net-aim-account-number"]',
            'input[name="wc-authorize-net-aim-csc"]',
            'input[name="paypal_pro_payflow-card-number"]',
            'input[name="paypal_pro_payflow-card-cvc"]',
            'input[name="paytrace-card-number"]',
            'input[name="paytrace-card-cvc"]',
            'input[id="stripe-card-number"]',
            'input[id="stripe-card-cvc"]',
            'input[name="creditCard"]',
            'input[name="cvv"]',
            'input.wc-credit-card-form-card-number',
            'input[name="wc-authorize-net-cim-credit-card-account-number"]',
            'input[name="wc-authorize-net-cim-credit-card-csc"]',
            'input.wc-credit-card-form-card-cvc',
            'input.js-sv-wc-payment-gateway-credit-card-form-account-number',
            'input.js-sv-wc-payment-gateway-credit-card-form-csc',
            '.wc-braintree-payment-type',
            // payment plugins braintree
            'input.shipping_method',
            '#order_comments',
            'input[name^="tocheckoutcw"]',
            '#_sumo_pp_enable_order_payment_plan',
            '.gift-certificate-show-form input',
            '.cfw_order_bump_check',
            '#shipping_fetchify_search',
            '#billing_fetchify_search',
            '[data-persist="false"]',
        )),
    ),
    'messages' => array(
        /**
         * Filter the invalid phone number error message
         *
         * @param string $invalid_phone_number_message Invalid phone number error message
         *
         * @since 5.3.5
         */
        'invalid_phone_message' => apply_filters(__('Please enter a valid phone number.', 'checkout-wc')),
        /**
         * Filter the invalid fullname error message
         *
         * @param string $invalid_fullname_message Invalid fullname error message
         *
         * @since 6.2.4
         */
        'invalid_full_name_message' => apply_filters(__('Please enter your first and last name.', 'checkout-wc')),
        'shipping_address_label' => __('Shipping address', 'checkout-wc'),
        'quantity_prompt_message' => __('Please enter a new quantity:', 'checkout-wc'),
        'cvv_tooltip_message' => __('3-digit security code usually found on the back of your card. American Express cards have a 4-digit code located on the front.', 'checkout-wc'),
        'delete_confirm_message' => __('Are you sure you want to remove this item from your cart?', 'checkout-wc'),
        'account_already_registered_notice' => cfw_apply_filters('woocommerce_registration_error_email_exists', cfw__('An account is already registered with your email address. <a href="#" class="showlogin">Please log in.</a>', 'woocommerce'), ''),
        'generic_field_validation_error_message' => cfw__('%s is a required field.', 'woocommerce'),
        'update_checkout_error' => cfw__('There was a problem checking out. Please try again. If the problem persists, please get in touch with us so we can assist.', 'woocommerce'),
        'invalid_postcode' => __('Please enter a valid postcode / ZIP.', 'checkout-wc'),
        'pickup_label' => __('Pickup', 'checkout-wc'),
        'update_cart_item_variation_button' => cfw__('Update', 'woocommerce'),
        'ok_button_label' => cfw__('Add to cart', 'woocommerce'),
        'cancel_button_label' => cfw__('Cancel', 'woocommerce'),
        /**
         * Filter the fetchify search placeholder
         *
         * @param string $fetchify_default_placeholder Fetchify search placeholder
         *
         * @since 8.2.3
         */
        'fetchify_default_placeholder' => apply_filters(__('Start with post/zip code or street', 'checkout-wc')),
        'shipping_methods_heading' => apply_filters(esc_html__('Shipping method', 'checkout-wc')),
        'no_shipping_methods_notice' => apply_filters('<div class="cfw-alert cfw-alert-error"><div class="message">' . wpautop(cfw_esc_html__('There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce')) . '</div></div>'),
    ),
    'checkout_params' => array(
        'ajax_url' => WC()->ajax_url(),
        'wc_ajax_url' => \WC_AJAX::get_endpoint('%%endpoint%%'),
        'update_order_review_nonce' => wp_create_nonce('update-order-review'),
        'apply_coupon_nonce' => wp_create_nonce('apply-coupon'),
        'remove_coupon_nonce' => wp_create_nonce('remove-coupon'),
        'option_guest_checkout' => get_option('woocommerce_enable_guest_checkout'),
        'checkout_url' => \WC_AJAX::get_endpoint('checkout'),
        'is_checkout' => is_checkout() && empty($wp->query_vars['order-pay']) && !isset($wp->query_vars['order-received']) ? 1 : 0,
        'debug_mode' => defined('WP_DEBUG') && WP_DEBUG,
        // phpcs:disable WordPress.Security.NonceVerification.Missing
        'cfw_debug_mode' => isset($_GET['cfw-debug']),
        // phpcs:enable WordPress.Security.NonceVerification.Missing
        'i18n_checkout_error' => cfw_esc_attr__('Error processing checkout. Please try again.', 'woocommerce'),
        'dist_path' => CFW_PATH_ASSETS,
        'is_rtl' => is_rtl(),
    ),
    'runtime_params' => array('runtime_email_matched_user' => false),
)` |  | 

**Changelog**

Version | Description
------- | -----------
`1.0.0` | 

Source: ./includes/Managers/AssetManager.php, line 360

### `cfw_typescript_compatibility_classes_and_params`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array()` |  | 

Source: ./includes/Managers/AssetManager.php, line 389

### `cfw_validate_required_registration`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

Source: ./includes/Managers/AssetManager.php, line 405

### `cfw_enable_zip_autocomplete`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

Source: ./includes/Managers/AssetManager.php, line 416

### `cfw_disable_email_domain_validation`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

Source: ./includes/Managers/AssetManager.php, line 424

### `cfw_enable_field_persistence`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

Source: ./includes/Managers/AssetManager.php, line 434

### `cfw_disable_cart_quantity_prompt`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

Source: ./includes/Managers/AssetManager.php, line 443

### `cfw_check_create_account_by_default`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

Source: ./includes/Managers/AssetManager.php, line 453

### `cfw_enable_account_exists_check`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`!is_user_logged_in()` |  | 

Source: ./includes/Managers/AssetManager.php, line 463

### `cfw_load_tabs`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`cfw_is_checkout()` |  | 

Source: ./includes/Managers/AssetManager.php, line 478

### `cfw_address_autocomplete_billing_countries`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array()` |  | 

Source: ./includes/Managers/AssetManager.php, line 490

### `cfw_enable_discrete_address_1_fields`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'yes' === SettingsManager::instance()->get_setting('enable_discreet_address_1_fields')` |  | 

Source: ./includes/Managers/AssetManager.php, line 513

### `cfw_enable_fullname_field`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'yes' === SettingsManager::instance()->get_setting('use_fullname_field')` |  | 

Source: ./includes/Managers/AssetManager.php, line 522

### `cfw_link_cart_items`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('cart_item_link') === 'enabled'` |  | 

Source: ./includes/Managers/AssetManager.php, line 535

### `cfw_show_cart_item_discount`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('show_side_cart_item_discount') === 'yes'` |  | 

Source: ./includes/Managers/AssetManager.php, line 548

### `cfw_phone_field_highlighted_countries`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('highlighted_countries')` |  | 

Source: ./includes/Managers/AssetManager.php, line 557

### `cfw_field_data_persistence_excludes`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array(
    'input[type="button"]',
    'input[type="file"]',
    'input[type="hidden"]',
    'input[type="submit"]',
    'input[type="reset"]',
    '#cfw-promo-code',
    '.cfw-create-account-checkbox',
    'input[name="payment_method"]',
    'input[name="paypal_pro-card-number"]',
    'input[name="paypal_pro-card-cvc"]',
    'input[name="wc-authorize-net-aim-account-number"]',
    'input[name="wc-authorize-net-aim-csc"]',
    'input[name="paypal_pro_payflow-card-number"]',
    'input[name="paypal_pro_payflow-card-cvc"]',
    'input[name="paytrace-card-number"]',
    'input[name="paytrace-card-cvc"]',
    'input[id="stripe-card-number"]',
    'input[id="stripe-card-cvc"]',
    'input[name="creditCard"]',
    'input[name="cvv"]',
    'input.wc-credit-card-form-card-number',
    'input[name="wc-authorize-net-cim-credit-card-account-number"]',
    'input[name="wc-authorize-net-cim-credit-card-csc"]',
    'input.wc-credit-card-form-card-cvc',
    'input.js-sv-wc-payment-gateway-credit-card-form-account-number',
    'input.js-sv-wc-payment-gateway-credit-card-form-csc',
    '.wc-braintree-payment-type',
    // payment plugins braintree
    'input.shipping_method',
    '#order_comments',
    'input[name^="tocheckoutcw"]',
    '#_sumo_pp_enable_order_payment_plan',
    '.gift-certificate-show-form input',
    '.cfw_order_bump_check',
    '#shipping_fetchify_search',
    '#billing_fetchify_search',
    '[data-persist="false"]',
)` |  | 

Source: ./includes/Managers/AssetManager.php, line 570

### `cfw_invalid_phone_validation_error_message`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('Please enter a valid phone number.', 'checkout-wc')` |  | 

Source: ./includes/Managers/AssetManager.php, line 620

### `cfw_invalid_full_name_validation_error_message`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('Please enter your first and last name.', 'checkout-wc')` |  | 

Source: ./includes/Managers/AssetManager.php, line 629

### `cfw_fetchify_search_placeholder`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('Start with post/zip code or street', 'checkout-wc')` |  | 

Source: ./includes/Managers/AssetManager.php, line 650

### `cfw_shipping_method_heading`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Shipping method', 'checkout-wc')` |  | 

Source: ./includes/Managers/AssetManager.php, line 651

### `cfw_side_cart_event_object`

*Filter cfw_event_object array*

Localized data available via DataService

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array('data' => AssetManager::get_data(), 'settings' => array(
    // required for parsley localization
    'user_logged_in' => is_user_logged_in(),
    /**
     * Filter whether to auto open the side cart on add to cart
     *
     * @param bool $disable_side_cart_auto_open Disable side cart auto open
     *
     * @since 7.1.5
     *
     */
    'disable_side_cart_auto_open' => (bool) apply_filters(SettingsManager::instance()->get_setting('shake_floating_cart_button') === 'yes'),
    'enable_floating_cart_button' => SettingsManager::instance()->get_setting('enable_floating_cart_button') === 'yes',
    /**
     * Filter whether to disable cart quantity prompt
     *
     * @param bool $disable_cart_quantity_prompt Disable cart quantity prompt
     *
     * @since 8.2.19
     */
    'disable_cart_quantity_prompt' => apply_filters(false),
    'enable_side_cart_suggested_products' => SettingsManager::instance()->get_setting('enable_side_cart_suggested_products') === 'yes',
    /**
     * Filter whether to automatically generate password for new accounts
     *
     * @param string $additional_side_cart_trigger_selectors CSS selector for additional side cart open buttons / links
     *
     * @since 5.4.0
     *
     */
    'additional_side_cart_trigger_selectors' => apply_filters(false),
    /**
     * Filters whether to link cart items to products
     *
     * @param bool $link_cart_items Link cart items to products
     *
     * @since 1.0.0
     *
     */
    'link_items' => apply_filters(SettingsManager::instance()->get_setting('cart_item_link') === 'enabled'),
    'show_item_remove_button' => SettingsManager::instance()->get_setting('show_item_remove_button') === 'yes',
    /**
     * Filters whether to show cart item discount on cart item
     *
     * @param bool $show_cart_item_discount Show cart item discount on cart item
     *
     * @since 2.0.0
     *
     */
    'show_item_discount' => apply_filters(SettingsManager::instance()->get_setting('show_side_cart_item_discount') === 'yes'),
    'cart_icon_url' => SideCart::get_cart_icon_file_url(),
    'coupons_enabled' => wc_coupons_enabled() && SettingsManager::instance()->get_setting('enable_promo_codes_on_side_cart') === 'yes',
    'enable_continue_shopping_btn' => apply_filters(SettingsManager::instance()->get_setting('enable_side_cart_continue_shopping_button') === 'yes'),
    'enable_side_cart_payment_buttons' => SettingsManager::instance()->get_setting('enable_side_cart_payment_buttons') === 'yes',
    /**
     * Filters whether to show shipping and tax totals in side cart
     *
     * @param bool $show_total Whether to show shipping and tax totals in side cart
     *
     * @since 7.7.0
     */
    'side_cart_show_total' => apply_filters(SettingsManager::instance()->get_setting('enable_side_cart_totals') === 'yes'),
    'wc_get_pay_buttons' => cfw_get_function_output('wc_get_pay_buttons'),
    'enable_free_shipping_progress_bar' => SettingsManager::instance()->get_setting('enable_free_shipping_progress_bar') === 'yes',
    'suggested_products_heading' => $suggested_products_heading,
    'max_bumps' => $max_bumps < 0 ? 999 : $max_bumps,
    'enable_ajax_add_to_cart' => SettingsManager::instance()->get_setting('enable_ajax_add_to_cart') === 'yes',
    'checkout_page_url' => wc_get_checkout_url(),
    'enable_free_shipping_progress_bar_at_checkout' => SettingsManager::instance()->get_setting('enable_free_shipping_progress_bar_at_checkout') === 'yes',
), 'messages' => array(
    'quantity_prompt_message' => __('Please enter a new quantity:', 'checkout-wc'),
    'delete_confirm_message' => __('Are you sure you want to remove this item from your cart?', 'checkout-wc'),
    'view_cart' => cfw__('View cart', 'woocommerce'),
    'update_cart_item_variation_button' => cfw__('Update', 'woocommerce'),
    'ok_button_label' => cfw__('Add to cart', 'woocommerce'),
    'cancel_button_label' => cfw__('Cancel', 'woocommerce'),
    /**
     * Filters promo code button label
     *
     * @param string $promo_code_button_label Promo code button label
     *
     * @since 3.0.0
     */
    'promo_code_button_label' => apply_filters(esc_attr__('Apply', 'checkout-wc')),
    /**
     * Filters promo code toggle link text
     *
     * @param string $promo_code_toggle_link_text Filters promo code toggle link text
     *
     * @since 3.0.0
     */
    'promo_code_toggle_link_text' => apply_filters(__('Have a promo code? Click here.', 'checkout-wc')),
    /**
     * Filters promo code label
     *
     * @param string $promo_code_label Promo code label
     *
     * @since 3.0.0
     */
    'promo_code_label' => apply_filters(__('Promo Code', 'checkout-wc')),
    /**
     * Filters promo code placeholder
     *
     * @param string $promo_code_placeholder Promo code placeholder
     *
     * @since 3.0.0
     */
    'promo_code_placeholder' => apply_filters(__('Enter Promo Code', 'checkout-wc')),
    'remove_item_label' => __('Remove this item', 'woocommerce'),
    'proceed_to_checkout_label' => __('Proceed to checkout', 'woocommerce'),
    'continue_shopping_label' => __('Continue shopping', 'woocommerce'),
    'edit_cart_variation_label' => __('Edit', 'woocommerce'),
), 'checkout_params' => array(
    'ajax_url' => WC()->ajax_url(),
    'wc_ajax_url' => \WC_AJAX::get_endpoint('%%endpoint%%'),
    'update_side_cart_nonce' => wp_create_nonce('cfw-update-side-cart'),
    'apply_coupon_nonce' => wp_create_nonce('apply-coupon'),
    'remove_coupon_nonce' => wp_create_nonce('remove-coupon'),
    'checkout_url' => \WC_AJAX::get_endpoint('checkout'),
    'is_checkout' => is_checkout() && empty($wp->query_vars['order-pay']) && !isset($wp->query_vars['order-received']) ? 1 : 0,
    'debug_mode' => defined('WP_DEBUG') && WP_DEBUG,
    // phpcs:disable WordPress.Security.NonceVerification.Missing
    'cfw_debug_mode' => isset($_GET['cfw-debug']),
    // phpcs:enable WordPress.Security.NonceVerification.Missing
    'dist_path' => CFW_PATH_ASSETS,
    'is_rtl' => is_rtl(),
), 'runtime_params' => array())` |  | 

**Changelog**

Version | Description
------- | -----------
`1.0.0` | 

Source: ./includes/Managers/AssetManager.php, line 699

### `cfw_disable_side_cart_auto_open`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('shake_floating_cart_button') === 'yes'` |  | 

Source: ./includes/Managers/AssetManager.php, line 725

### `cfw_disable_cart_quantity_prompt`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

Source: ./includes/Managers/AssetManager.php, line 735

### `cfw_additional_side_cart_trigger_selectors`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

Source: ./includes/Managers/AssetManager.php, line 746

### `cfw_link_cart_items`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('cart_item_link') === 'enabled'` |  | 

Source: ./includes/Managers/AssetManager.php, line 756

### `cfw_show_cart_item_discount`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('show_side_cart_item_discount') === 'yes'` |  | 

Source: ./includes/Managers/AssetManager.php, line 767

### `cfw_side_cart_enable_continue_shopping_button`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('enable_side_cart_continue_shopping_button') === 'yes'` |  | 

Source: ./includes/Managers/AssetManager.php, line 770

### `cfw_side_cart_show_total`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('enable_side_cart_totals') === 'yes'` |  | 

Source: ./includes/Managers/AssetManager.php, line 780

### `cfw_promo_code_apply_button_label`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_attr__('Apply', 'checkout-wc')` |  | 

Source: ./includes/Managers/AssetManager.php, line 804

### `cfw_promo_code_toggle_link_text`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('Have a promo code? Click here.', 'checkout-wc')` |  | 

Source: ./includes/Managers/AssetManager.php, line 813

### `cfw_promo_code_label`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('Promo Code', 'checkout-wc')` |  | 

Source: ./includes/Managers/AssetManager.php, line 822

### `cfw_promo_code_placeholder`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('Enter Promo Code', 'checkout-wc')` |  | 

Source: ./includes/Managers/AssetManager.php, line 831

### `cfw_checkout_data`

*Filter extra data available to JavaScript*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array('cart' => array('needsPayment' => WC()->cart->needs_payment(), 'items' => cfw_get_cart_items_data(), 'totals' => cfw_get_cart_totals_data(), 'actions' => cfw_get_cart_actions_data(), 'notices' => cfw_get_function_output('cfw_wc_print_notices', !is_checkout()), 'shipping' => cfw_get_cart_shipping_data()), 'bumps' => cfw_get_order_bumps_data())` |  | 

**Changelog**

Version | Description
------- | -----------
`8.0.0` | 

Source: ./includes/Managers/AssetManager.php, line 863

### `cfw_updates_manager_home_url`

*Filters the home URL.*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$url` | `string` | The complete home URL including scheme and path.
`$path` | `string` | Path relative to the home URL. Blank string if no path is specified.
`$orig_scheme` | `string\|null` | Scheme to give the home URL context. Accepts 'http', 'https',<br>'relative', 'rest', or null.
`$blog_id` | `int\|null` | Site ID, or null for the current site.

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Managers/UpdatesManager.php, line 165

### `cfw_custom_css_properties`

*Filter the CSS custom property overrides*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array('--cfw-body-background-color' => $body_background_color, '--cfw-body-text-color' => $body_text_color, '--cfw-body-font-family' => $body_font, '--cfw-heading-font-family' => $heading_font, '--cfw-header-background-color' => $active_template->supports('header-background') ? $header_background_color : $body_background_color, '--cfw-header-bottom-margin' => strtolower($header_background_color) !== strtolower($body_background_color) ? '2em' : false, '--cfw-footer-background-color' => $active_template->supports('footer-background') ? $footer_background_color : $body_background_color, '--cfw-footer-top-margin' => '#ffffff' !== strtolower($footer_background_color) ? '2em' : false, '--cfw-cart-summary-background-color' => $active_template->supports('summary-background') ? $summary_bg_color : false, '--cfw-cart-summary-mobile-background-color' => $summary_mobile_bg_color, '--cfw-cart-summary-text-color' => $active_template->supports('summary-background') ? $summary_text_color : false, '--cfw-cart-summary-link-color' => $summary_link_color, '--cfw-header-text-color' => $header_text_color, '--cfw-footer-text-color' => $footer_text_color, '--cfw-body-link-color' => $body_link_color, '--cfw-buttons-primary-background-color' => $primary_button_bg_color, '--cfw-buttons-primary-text-color' => $primary_button_text_color, '--cfw-buttons-primary-hover-background-color' => $primary_button_hover_bg_color, '--cfw-buttons-primary-hover-text-color' => $primary_button_hover_text_color, '--cfw-buttons-secondary-background-color' => $secondary_button_bg_color, '--cfw-buttons-secondary-text-color' => $secondary_button_text_color, '--cfw-buttons-secondary-hover-background-color' => $secondary_button_hover_bg_color, '--cfw-buttons-secondary-hover-text-color' => $secondary_button_hover_text_color, '--cfw-cart-summary-item-quantity-background-color' => $cart_item_background_color, '--cfw-cart-summary-item-quantity-text-color' => $cart_item_text_color, '--cfw-breadcrumb-completed-text-color' => $breadcrumb_completed_text_color, '--cfw-breadcrumb-current-text-color' => $breadcrumb_current_text_color, '--cfw-breadcrumb-next-text-color' => $breadcrumb_next_text_color, '--cfw-breadcrumb-completed-accent-color' => $breadcrumb_completed_accent_color, '--cfw-breadcrumb-current-accent-color' => $breadcrumb_current_accent_color, '--cfw-breadcrumb-next-accent-color' => $breadcrumb_next_accent_color, '--cfw-logo-url' => "url({$logo_url})")` |  | 

**Changelog**

Version | Description
------- | -----------
`5.0.0` | 

Source: ./includes/Managers/StyleManager.php, line 97

### `cfw_enable_smartystreets_integration`

*Whether to enable Smarty integration*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

**Changelog**

Version | Description
------- | -----------
`5.2.1` | 

Source: ./includes/Features/SmartyStreets.php, line 29

### `cfw_unsubscribe_successful_message`

*Filter the message shown when a user unsubscribes from cart reminder emails.*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('You have been unsubscribed from our cart reminder emails.', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`9.0.0` | 

Source: ./includes/Features/AbandonedCartRecovery.php, line 72

### `cfw_acr_track_cart_without_emails`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('acr_simulate_only') === 'yes'` |  | 

Source: ./includes/Features/AbandonedCartRecovery.php, line 213

### `cfw_acr_cart_meta`

*Filter the meta fields to be tracked for abandoned carts.*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array()` |  | 

**Changelog**

Version | Description
------- | -----------
`8.2.7` | 

Source: ./includes/Features/AbandonedCartRecovery.php, line 335

### `cfw_cart_table_styles`

*Filter the cart table styles*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$styles` | `array` | 

**Changelog**

Version | Description
------- | -----------
`8.0.0` | 

Source: ./includes/Features/AbandonedCartRecovery.php, line 653

### `cfw_fetchify_address_autocomplete_countries`

*Filter list of shipping country restrictions for Google Maps address autocomplete*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Features/FetchifyAddressAutocomplete.php, line 38

### `cfw_fetchify_address_autocomplete_enable_geolocation`

*Filter whether to enable geolocation*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

**Changelog**

Version | Description
------- | -----------
`5.3.2` | 

Source: ./includes/Features/FetchifyAddressAutocomplete.php, line 50

### `cfw_fetchify_address_autocomplete_default_country`

*Filter Fetchify address autocomplete default country*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'gbr'` |  | 

**Changelog**

Version | Description
------- | -----------
`5.3.2` | 

Source: ./includes/Features/FetchifyAddressAutocomplete.php, line 59

### `cfw_breadcrumb_review_step_label`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Review', 'checkout-wc')` |  | 

Source: ./includes/Features/OrderReviewStep.php, line 67

### `cfw_google_maps_compatibility_mode`

*Whether to enable Google Maps compatibility mode*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

**Changelog**

Version | Description
------- | -----------
`4.3.7` | 

Source: ./includes/Features/GoogleAddressAutocomplete.php, line 34

### `cfw_google_maps_language_code`

*Filter Google Maps language code*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$language` |  | 

**Changelog**

Version | Description
------- | -----------
`4.3.7` | 

Source: ./includes/Features/GoogleAddressAutocomplete.php, line 49

### `cfw_address_autocomplete_shipping_countries`

*Filter list of shipping country restrictions for Google Maps address autocomplete*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Features/GoogleAddressAutocomplete.php, line 86

### `cfw_google_address_autocomplete_type`

*Filter Google address autocomplete type*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'geocode|establishment'` |  | 

**Changelog**

Version | Description
------- | -----------
`7.3.0` | 

Source: ./includes/Features/GoogleAddressAutocomplete.php, line 95

### `cfw_order_bump_get_price_context`

*Filter the context for the bump price*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'cart'` |  | 
`$cart_item` | `array` | The cart item
`$bump` | `\Objectiv\Plugins\Checkout\Interfaces\BumpInterface` | The bump

**Changelog**

Version | Description
------- | -----------
`8.1.6` | 

Source: ./includes/Features/OrderBumps.php, line 402

### `cfw_order_bump_get_price_context`

*Filter the context for the bump price*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'cart'` |  | 
`$cart_item` | `array` | The cart item
`$bump` | `\Objectiv\Plugins\Checkout\Interfaces\BumpInterface` | The bump

**Changelog**

Version | Description
------- | -----------
`8.1.6` | 

Source: ./includes/Features/OrderBumps.php, line 583

### `cfw_display_bump`

*Filter whether to display the bump*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$display_bump` | `bool` | Whether to display the bump
`$bump` |  | 
`'complete_order'` |  | 

**Changelog**

Version | Description
------- | -----------
`8.0.0` | 

Source: ./includes/Features/OrderBumps.php, line 620

### `cfw_allow_order_bump_coupons`

*Filter whether to allow order bump coupons*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 
`$values['_cfw_order_bump_id']` |  | 

**Changelog**

Version | Description
------- | -----------
`8.2.14` | 

Source: ./includes/Features/OrderBumps.php, line 679

### `cfw_allow_international_phone_field_country_dropdown`

*Filter to allow the country dropdown to be disabled*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

**Changelog**

Version | Description
------- | -----------
`5.3.5` | 

Source: ./includes/Features/InternationalPhoneField.php, line 44

### `cfw_international_phone_field_placeholder_mode`

*Filter international phone field placeholder mode*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'aggressive'` |  | 

**Changelog**

Version | Description
------- | -----------
`8.2.19` | 

Source: ./includes/Features/InternationalPhoneField.php, line 52

### `cfw_hide_optional_fields_behind_links`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 
`'address_2'` |  | 

Source: ./includes/Features/HideOptionalAddressFields.php, line 33

### `cfw_hide_optional_fields_behind_links`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 
`'company'` |  | 

Source: ./includes/Features/HideOptionalAddressFields.php, line 40

### `cfw_local_pickup_option_label`

*Filters the local pickup option label*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$pickup_option_label` | `string` | The pickup option label

**Changelog**

Version | Description
------- | -----------
`7.3.1` | 

Source: ./includes/Features/LocalPickup.php, line 98

### `cfw_local_pickup_shipping_option_label`

*Filters the local pickup shipping option label*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$ship_option_label` | `string` | The shipping option label

**Changelog**

Version | Description
------- | -----------
`7.3.1` | 

Source: ./includes/Features/LocalPickup.php, line 113

### `cfw_local_pickup_disable_shipping_option`

*Filters whether the shipping option should be disabled*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this->settings_getter->get_setting('enable_pickup_ship_option') !== 'yes'` |  | 

**Changelog**

Version | Description
------- | -----------
`8.1.6` | 

Source: ./includes/Features/LocalPickup.php, line 122

### `cfw_local_pickup_disable_pickup_option`

*Filters whether the pickup option should be disabled*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

**Changelog**

Version | Description
------- | -----------
`8.1.6` | 

Source: ./includes/Features/LocalPickup.php, line 131

### `cfw_estimated_pickup_time`

*Filters the pickup location estimated time*

NOTE: Use cfw_pickup_times to extend the list of available pickup times

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`self::get_pickup_times()[$pickup_time] ?? ''` |  | 
`$pickup_location->ID` |  | 

**Changelog**

Version | Description
------- | -----------
`7.5.0` | 

Source: ./includes/Features/LocalPickup.php, line 224

### `cfw_copy_pickup_details_to_order_notes`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

Source: ./includes/Features/LocalPickup.php, line 548

### `cfw_local_pickup_use_google_address_link`

*Whether to link the local pickup address to Google Maps for directions*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

**Changelog**

Version | Description
------- | -----------
`7.3.2` | 

Source: ./includes/Features/LocalPickup.php, line 589

### `cfw_local_pickup_thank_you_address`

*Filter the local pickup address shown to customers on the thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$address` | `string` | The local pickup address shown to customers
`$raw_address` |  | 
`$order` |  | 

**Changelog**

Version | Description
------- | -----------
`7.3.2` | 

Source: ./includes/Features/LocalPickup.php, line 602

### `cfw_order_updates_heading`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('Pickup instructions', 'checkout-wc')` |  | 
`$order` |  | 

Source: ./includes/Features/LocalPickup.php, line 621

### `cfw_pickup_instructions_text`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`get_post_meta($location, 'cfw_pl_instructions', true)` |  | 
`$order` |  | 

Source: ./includes/Features/LocalPickup.php, line 633

### `cfw_pickup_times`

*Filters the pickup times*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array('1h' => __('Usually ready in 1 hour.', 'checkout-wc'), '2h' => __('Usually ready in 2 hours.', 'checkout-wc'), '4h' => __('Usually ready in 4 hours.', 'checkout-wc'), '24h' => __('Usually ready in 24 hours.', 'checkout-wc'), '24d' => __('Usually ready in 2-4 days.', 'checkout-wc'), '5d' => __('Usually ready in 5+ days.', 'checkout-wc'))` |  | 

**Changelog**

Version | Description
------- | -----------
`7.3.0` | 

Source: ./includes/Features/LocalPickup.php, line 731

### `cfw_trust_badges_output_action`

*Filter the action to output the trust badges*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$action` | `string` | The action to output the trust badges
`$position` | `string` | The position of the trust badges

**Changelog**

Version | Description
------- | -----------
`9.0.0` | 

Source: ./includes/Features/TrustBadges.php, line 44

### `cfw_cart_edit_redirect_suppress_notice`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

Source: ./includes/Features/CartEditingAtCheckout.php, line 50

### `cfw_disable_side_cart`

*Disable side cart if filter is set*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

**Changelog**

Version | Description
------- | -----------
`7.2.0` | 

Source: ./includes/Features/SideCart.php, line 32

### `cfw_side_cart_free_shipping_threshold`

*Filters the free shipping threshold amount*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`cfw_apply_filters('woocommerce_product_get_price', $threshold, $dummy_product)` |  | 

**Changelog**

Version | Description
------- | -----------
`8.1.12` | 

Source: ./includes/Features/SideCart.php, line 282

### `cfw_side_cart_shipping_bar_data_exclude_discounts`

*Filters whether to exclude discounts from the subtotal when calculating the free shipping bar*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

**Changelog**

Version | Description
------- | -----------
`7.10.2` | 

Source: ./includes/Features/SideCart.php, line 296

### `cfw_shipping_bar_data`

*Filters the free shipping data when a free shipping coupon is applied*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$data` | `array` | 

**Changelog**

Version | Description
------- | -----------
`7.0.5` | 

Source: ./includes/Features/SideCart.php, line 331

### `cfw_shipping_bar_data`

*Filters the free shipping data when a threshold is set*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$data` | `array` | 

**Changelog**

Version | Description
------- | -----------
`7.0.5` | 

Source: ./includes/Features/SideCart.php, line 349

### `cfw_shipping_bar_data`

*Filters the free shipping data when no packages are available*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$data` | `array` | 

**Changelog**

Version | Description
------- | -----------
`7.0.5` | 

Source: ./includes/Features/SideCart.php, line 364

### `cfw_shipping_bar_data`

*Filters the free shipping data when no free shipping methods are available*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$data` | `array` | 

**Changelog**

Version | Description
------- | -----------
`7.0.5` | 

Source: ./includes/Features/SideCart.php, line 417

### `cfw_shipping_bar_data`

*Filters the free shipping data*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$data` | `array` | 

**Changelog**

Version | Description
------- | -----------
`7.0.5` | 

Source: ./includes/Features/SideCart.php, line 433

### `cfw_side_cart_free_shipping_progress_bar_free_shipping_message`

*Filter the message displayed when the cart qualifies for free shipping.*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$free_shipping_message` | `string` | 

**Changelog**

Version | Description
------- | -----------
`7.3.0` | 

Source: ./includes/Features/SideCart.php, line 461

### `cfw_side_cart_free_shipping_progress_bar_amount_remaining_message_format`

*Filter the message format for the amount remaining for free shipping*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$amount_remaining_message` | `string` | 

**Changelog**

Version | Description
------- | -----------
`7.3.0` | 

Source: ./includes/Features/SideCart.php, line 475

### `checkoutwc_cart_shortcode_additional_classes`

*Filters additional classes for the cart icon shortcode*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array()` |  | 

**Changelog**

Version | Description
------- | -----------
`8.2.18` | 

Source: ./includes/Features/SideCart.php, line 560

### `cfw_side_cart_icon`

*Filters the side cart icon*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`ob_get_clean()` |  | 
`$context` | `string` | The calling context
`$additional_class` | `string` | Additional classes for the cart icon

**Changelog**

Version | Description
------- | -----------
`8.2.19` | 

Source: ./includes/Features/SideCart.php, line 622

### `cfw_side_cart_icon_file_path`

*The path to the side cart icon file*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$path` | `string` | The path to the side cart icon file

**Changelog**

Version | Description
------- | -----------
`8.2.7` | 

Source: ./includes/Features/SideCart.php, line 666

### `cfw_side_cart_icon_file_contents`

*The contents of the side cart icon file*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$contents` |  | 

**Changelog**

Version | Description
------- | -----------
`8.2.7` | 

Source: ./includes/Features/SideCart.php, line 684

### `cfw_side_cart_icon_file_url`

*The path to the side cart icon file*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`(string) $url` |  | 

**Changelog**

Version | Description
------- | -----------
`8.2.7` | 

Source: ./includes/Features/SideCart.php, line 704

### `cfw_disable_cart_variation_editing`

*Filters whether to disable cart variation editing*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 
`$cart_item` | `array` | The cart item
`$cart_item_key` | `string` | The cart item key
`'side_cart'` |  | 

**Changelog**

Version | Description
------- | -----------
`8.0.0` | 

Source: ./includes/Features/SideCart.php, line 728

### `cfw_run_woocommerce_cart_actions`

*Filter to enable or disable the WooCommerce cart actions*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

**Changelog**

Version | Description
------- | -----------
`8.0.0` | 

Source: ./includes/Features/SideCart.php, line 771

### `cfw_side_cart_free_shipping_progress_bar_free_shipping_message`

*Filter the message displayed when the cart qualifies for free shipping.*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$free_shipping_message` | `string` | 

**Changelog**

Version | Description
------- | -----------
`7.3.0` | 

Source: ./includes/Features/SideCart.php, line 809

### `cfw_side_cart_free_shipping_progress_bar_amount_remaining_message_format`

*Filter the message format for the amount remaining for free shipping*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$amount_remaining_message` | `string` | 

**Changelog**

Version | Description
------- | -----------
`7.3.0` | 

Source: ./includes/Features/SideCart.php, line 823

### `cfw_selected_tab`

*Filters the selected_tab*

Represents the currently selected tab in a user interface.

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`empty($_GET[$this->_selected_tab_query_arg]) ? $this->_default_tab : sanitize_text_field($_GET[$this->_selected_tab_query_arg])` |  | 

**Changelog**

Version | Description
------- | -----------
`9.0.0` | 

Source: ./includes/Admin/TabNavigation.php, line 135

### `cfw_restricted_post_types_count_args`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$args` |  | 

**Changelog**

Version | Description
------- | -----------
`5.0.0` | 

Source: ./includes/Admin/Pages/AbandonedCartRecovery.php, line 12

### `cfw_restricted_post_types_count_args`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$args` |  | 

**Changelog**

Version | Description
------- | -----------
`5.0.0` | 

Source: ./includes/Admin/Pages/OrderBumps.php, line 13

### `cfw_detected_gateways`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array()` |  | 

Source: ./includes/Admin/Pages/ExpressCheckout.php, line 51

### `cfw_do_admin_bar`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`current_user_can('manage_options') && (SettingsManager::instance()->get_setting('hide_admin_bar_button') !== 'yes' || is_cfw_page())` |  | 

Source: ./includes/Admin/Pages/PageAbstract.php, line 258

### `cfw_admin_page_data`

*Filter the admin page data*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array()` |  | 

**Changelog**

Version | Description
------- | -----------
`9.0.0` | 

Source: ./includes/Admin/Pages/PageAbstract.php, line 324

### `cfw_admin_integrations_checkbox_fields`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array()` |  | 

Source: ./includes/Admin/Pages/Integrations.php, line 44

### `cfw_active_theme_color_settings`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array()` |  | 

Source: ./includes/Admin/Pages/Appearance.php, line 280

### `cfw_theme_color_settings`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$color_settings` |  | 

Source: ./includes/Admin/Pages/Appearance.php, line 188

### `cfw_enable_editable_admin_shipping_phone_field`

*Filter whether to enable editable shipping phone field in admin*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Admin/ShippingPhoneController.php, line 21

### `cfw_session_expired_target_element`

*Filters which element to update with session expired notice*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'form.woocommerce-checkout'` |  | 

**Changelog**

Version | Description
------- | -----------
`5.2.0` | 

Source: ./includes/Action/UpdateCheckoutAction.php, line 47

### `cfw_update_checkout_redirect`

*Filters whether to redirect the checkout page during refresh*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./includes/Action/UpdateCheckoutAction.php, line 169

### `cfw_update_payment_methods`

*Filters payment methods during update_checkout refresh*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`cfw_get_payment_methods()` |  | 

**Changelog**

Version | Description
------- | -----------
`4.0.2` | 

Source: ./includes/Action/UpdateCheckoutAction.php, line 198

### `cfw_email_exists`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`email_exists($email)` |  | 
`$email` |  | 

Source: ./includes/Action/AccountExistsAction.php, line 43

### `cfw_failed_login_error_message`

*Filters failed login error message*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$user->get_error_message() ? $user->get_error_message() : $alt_message` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Action/LogInAction.php, line 57

### `cfw_failed_login_error_message`

*Filters failed login error message*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$validation_error->get_error_message()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Action/LogInAction.php, line 68

### `cfw_add_to_cart_redirect`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$redirect` |  | 
`$product_id` |  | 

Source: ./includes/Action/AddToCartAction.php, line 54

### `cfw_remove_coupon_response`

*Filters remove coupon action response object*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array('result' => $result, 'html' => $output, 'coupon' => $coupon)` |  | 

**Changelog**

Version | Description
------- | -----------
`3.14.0` | 

Source: ./includes/Action/RemoveCouponAction.php, line 49

### `cfw_email_domain_valid`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`checkdnsrr($email_domain . '.', 'MX')` |  | 
`$email_domain` |  | 
`$email_address` |  | 

**Changelog**

Version | Description
------- | -----------
`5.4.0` | 

Source: ./includes/Action/ValidateEmailDomainAction.php, line 5

### `cfw_smarty_address_validation_address`

*Filter the address before it's sent to SmartyStreets*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$address` | `array` | The address to be sent to SmartyStreets

**Changelog**

Version | Description
------- | -----------
`7.10.3` | 

Source: ./includes/Action/SmartyStreetsAddressValidationAction.php, line 142

### `cfw_smarty_use_zip4`

*Filter whether to use the zip4 code*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

**Changelog**

Version | Description
------- | -----------
`8.2.26` | 

Source: ./includes/Action/SmartyStreetsAddressValidationAction.php, line 257

### `cfw_cart_thumb_width`

*Filter cart thumbnail width*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`60` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/CartImageSizeAdder.php, line 10

### `cfw_cart_thumb_height`

*Filter cart thumbnail height*

0 indicates auto height

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`0` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/CartImageSizeAdder.php, line 19

### `cfw_crop_cart_thumbs`

*Filter whether to crop cart thumbnails*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/CartImageSizeAdder.php, line 30

### `cfw_display_bump`

*Filter whether to display the bump*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$display_bump` | `bool` | Whether to display the bump
`$this` |  | 
`$location` |  | 

**Changelog**

Version | Description
------- | -----------
`8.0.0` | 

Source: ./includes/Model/Bumps/BumpAbstract.php, line 413

### `cfw_order_bump_get_price`

*Filter the order bump price.*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$price - $discount_value` |  | 
`$context` | `string` | The context of the price.
`$this` |  | 

**Changelog**

Version | Description
------- | -----------
`5.0.0` | 

Source: ./includes/Model/Bumps/BumpAbstract.php, line 546

### `cfw_order_bump_captured_revenue`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$new_revenue` |  | 
`$this` |  | 

Source: ./includes/Model/Bumps/BumpAbstract.php, line 600

### `cfw_hide_bump_if_offer_product_in_cart`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

Source: ./includes/Model/Bumps/AllProductsBump.php, line 18

### `cfw_is_cart_bump_valid`

*Filters whether bump is valid in the cart*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->cart->get_cart_contents_count() > $this->quantity_of_product_in_cart($this->offer_product)` |  | 
`$this` |  | 

**Changelog**

Version | Description
------- | -----------
`7.5.0` | 

Source: ./includes/Model/Bumps/AllProductsBump.php, line 32

### `cfw_hide_bump_if_offer_product_in_cart`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

Source: ./includes/Model/Bumps/CategoriesBump.php, line 18

### `cfw_is_cart_bump_valid`

*Filters whether the bump is valid*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$this->cart_contains_normal_product_of_categories()` |  | 
`$this` |  | 

**Changelog**

Version | Description
------- | -----------
`7.5.0` | 

Source: ./includes/Model/Bumps/CategoriesBump.php, line 38

### `cfw_hide_bump_if_offer_product_in_cart`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

Source: ./includes/Model/Bumps/SpecificProductsBump.php, line 25

### `cfw_is_cart_bump_valid`

*Filters whether the bump is valid*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$result` |  | 
`$this` |  | 

**Changelog**

Version | Description
------- | -----------
`6.3.0` | 

Source: ./includes/Model/Bumps/SpecificProductsBump.php, line 119

### `cfw_order_bump_upsell_quantity_to_replace`

*The max number of items that upsell can replace (-1 is unlimited)*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`-1` |  | 
`$this` |  | 

**Changelog**

Version | Description
------- | -----------
`7.6.1` | 

Source: ./includes/Model/Bumps/SpecificProductsBump.php, line 162

### `cfw_cart_item_row_class`

*Filter the item row class*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$woocommerce_filtered_cart_item_row_class` | `string` | The filtered row class
`$item` |  | 

**Changelog**

Version | Description
------- | -----------
`8.0.0` | 

Source: ./includes/Model/CartItem.php, line 46

### `cfw_disable_cart_editing`

*Filters whether to disable cart editing*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('enable_cart_editing') !== 'yes' || $quantity_args['readonly'] === true` |  | 
`$item` |  | 
`$key` |  | 

**Changelog**

Version | Description
------- | -----------
`7.1.7` | 

Source: ./includes/Model/CartItem.php, line 59

### `cfw_disable_cart_variation_editing`

*Filters whether to disable cart variation editing*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('allow_checkout_cart_item_variation_changes') !== 'yes' || empty($item['variation_id'])` |  | 
`$item` |  | 
`$key` |  | 
`is_checkout() ? 'checkout' : 'side_cart'` |  | 

**Changelog**

Version | Description
------- | -----------
`8.0.0` | 

Source: ./includes/Model/CartItem.php, line 71

### `cfw_cart_item_data_expanded`

*Filter whether to display cart item data in the expanded format.*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('cart_item_data_display') === 'woocommerce'` |  | 

**Changelog**

Version | Description
------- | -----------
`5.0.0` | 

Source: ./includes/Model/CartItem.php, line 144

### `cfw_order_item_thumbnail`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$item_product ? $item_product->get_image('cfw_cart_thumb') : ''` |  | 
`$item` | `array\|\WC_Order_Item` | 

Source: ./includes/Model/OrderItem.php, line 23

### `cfw_order_item_row_class`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`''` |  | 
`$item` | `array\|\WC_Order_Item` | 

Source: ./includes/Model/OrderItem.php, line 23

### `cfw_cart_item_data_expanded`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('cart_item_data_display') === 'woocommerce'` |  | 

Source: ./includes/Model/OrderItem.php, line 103

### `cfw_acr_carts`

*Filter the carts for the abandoned cart recovery report table.*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$carts` | `array` | The carts.
`'table'` |  | 

**Changelog**

Version | Description
------- | -----------
`8.2.28` | 

Source: ./includes/API/AbandonedCartsAPI.php, line 48

### `cfw_acr_carts`

*Filter the carts for the abandoned cart recovery report stats dashboard.*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$carts` | `array` | The carts.
`'dashboard-stats'` |  | 

**Changelog**

Version | Description
------- | -----------
`8.2.28` | 

Source: ./includes/API/AbandonedCartRecoveryReportAPI.php, line 54

### `cfw_load_checkout_template`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`cfw_is_checkout()` |  | 

Source: ./includes/Loaders/Content.php, line 33

### `cfw_load_order_pay_template`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`is_checkout_pay_page()` |  | 

Source: ./includes/Loaders/Content.php, line 75

### `cfw_load_order_received_template`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`is_order_received_page()` |  | 

Source: ./includes/Loaders/Content.php, line 111

### `cfw_load_checkout_template`

*Filters whether to load checkout template*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`cfw_is_checkout()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/Redirect.php, line 22

### `cfw_body_classes`

*Filter CheckoutWC specific body classes*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$css_classes` | `array` | The body css classes

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/Redirect.php, line 47

### `cfw_load_order_pay_template`

*Filters whether to load order pay template*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`is_checkout_pay_page()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/Redirect.php, line 75

### `cfw_body_classes`

*Filter CheckoutWC specific body classes*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$css_classes` | `array` | The body css classes

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/Redirect.php, line 95

### `cfw_load_order_received_template`

*Filters whether to load order received template*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`is_order_received_page()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/Redirect.php, line 126

### `cfw_body_classes`

*Filter CheckoutWC specific body classes*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$css_classes` | `array` | The body css classes

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/Redirect.php, line 150

### `cfw_blocked_style_handles`

*Filters blocked stylesheet handles*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/Redirect.php, line 252

### `cfw_blocked_script_handles`

*Filters blocked script handles*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/Redirect.php, line 271

### `cfw_template_global_params`

*Filters global template parameters available to templates*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/LoaderAbstract.php, line 66

### `cfw_template_global_params`

*Filters global template parameters available to templates*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array('call_receipt_hook' => false, 'order_button_text' => cfw_apply_filters('woocommerce_pay_order_button_text', cfw__('Pay for order', 'woocommerce')), 'available_gateways' => array())` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/LoaderAbstract.php, line 84

### `cfw_template_global_params`

*Filters global template parameters available to templates*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/Loaders/LoaderAbstract.php, line 255

### `cfw_trust_badge_thumb_width`

*Filter cart thumbnail width*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`110` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/TrustBadgeImageSizeAdder.php, line 10

### `cfw_trust_badge_thumb_height`

*Filter cart thumbnail height*

0 indicates auto height

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`0` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/TrustBadgeImageSizeAdder.php, line 19

### `cfw_crop_trust_badge_thumbs`

*Filter whether to crop cart thumbnails*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./includes/TrustBadgeImageSizeAdder.php, line 30

### `cfw_disable_tracking_checkin`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 
`$home_url` |  | 

Source: ./includes/Stats/StatCollection.php, line 246

### `cfw_legacy_suppress_php_errors_output`

*Legacy Error Suppression*

In CheckoutWC 4.x and prior, we accidentally turned off display errors for all sites

In order to avoid issues with warnings now showing up after update, we are keeping this behavior but putting it behind a filter

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`!defined('WP_DEBUG') || !WP_DEBUG` |  | 

Source: ./includes/PhpErrorOutputSuppressor.php, line 13

### `cfw_pre_output_fieldset_field_args`

*Filters fieldset field args*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$field` | `array` | Field args
`$key` | `string` | Field key

**Changelog**

Version | Description
------- | -----------
`7.0.0` | 

Source: ./sources/php/functions.php, line 37

### `cfw_get_account_checkout_fields`

*Filters shipping address checkout fields*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$checkout->get_checkout_fields('account')` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 70

### `cfw_get_shipping_checkout_fields`

*Filters shipping address checkout fields*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`(array) WC()->checkout()->get_checkout_fields('shipping')` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 93

### `cfw_get_billing_checkout_fields`

*Filters billing address checkout fields*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`(array) WC()->checkout()->get_checkout_fields('billing')` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 116

### `cfw_unique_billing_fields`

*Filter billing fields down to only unique fields that aren't also shipping fields*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$unique_fields` |  | 

Source: ./sources/php/functions.php, line 167

### `cfw_ship_to_label`

*Filters ship to label in review pane*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$ship_to_label` | `string` | Ship to label

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 206

### `cfw_get_shipping_details_address`

*Filters review pane shipping address*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`cfw_get_posted_address_fields(wc_ship_to_billing_address_only() ? 'billing' : 'shipping')` |  | 
`$checkout` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 223

### `cfw_get_review_pane_shipping_address`

*Filters review pane formatted shipping address*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$formatted_address` | `string` | Formatted shipping address

**Changelog**

Version | Description
------- | -----------
`7.3.0` | 

Source: ./sources/php/functions.php, line 239

### `cfw_get_review_pane_billing_address`

*Filters review pane billing address*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`cfw_get_posted_address_fields()` |  | 
`$checkout` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 260

### `cfw_available_shipping_methods`

*Filters available shipping methods*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$package['rates']` |  | 
`$package` | `array` | Package data
`$i` |  | 

**Changelog**

Version | Description
------- | -----------
`8.0.0` | 

Source: ./sources/php/functions.php, line 329

### `cfw_available_shipping_methods`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$package['rates']` |  | 
`$package` |  | 
`$i` |  | 

Source: ./sources/php/functions.php, line 433

### `cfw_ensure_selected_payment_method`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

Source: ./sources/php/functions.php, line 533

### `cfw_show_gateway_{$gateway->id}`

*Filters whether to show gateway in list of gateways*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 564

### `cfw_gateway_order_button_text`

*Filters gateway order button text*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$gateway->order_button_text` |  | 
`$gateway` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 573

### `cfw_get_gateway_icons`

*Filters gateway order button text*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$gateway->get_icon()` |  | 
`$gateway` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 583

### `cfw_payment_method_li_class`

*Filters whether to show gateway in list of gateways*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`"wc_payment_method cfw-radio-reveal-li {$is_active_class} payment_method_{$gateway->id}"` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 564

### `cfw_payment_gateway_{$gateway->id}_content`

*Filters whether to show gateway content*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$gateway->has_fields() || $gateway->get_description()` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 623

### `cfw_payment_gateway_field_html_{$gateway->id}`

*Filters gateway payment field output HTML*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$field_html` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 653

### `cfw_show_review_order_before_cart_contents_hook`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

Source: ./sources/php/functions.php, line 722

### `cfw_link_cart_items`

*Filters whether to link cart items to products*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('cart_item_link') === 'enabled'` |  | 

**Changelog**

Version | Description
------- | -----------
`1.0.0` | 

Source: ./sources/php/functions.php, line 726

### `cfw_get_checkout_item_summary_table_container_classes`

*Filters the classes that are added to the checkout cart summary container*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array('cfw-cart-table', 'cfw-module')` |  | 

**Changelog**

Version | Description
------- | -----------
`6.3.0` | 

Source: ./sources/php/functions.php, line 735

### `cfw_show_cart_item_discount`

*Filters whether to show cart item discount on cart item*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('show_cart_item_discount') === 'yes'` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 795

### `cfw_cart_item_discount`

*Filters whether to show cart item discount on cart item*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$price` |  | 
`$item->get_raw_item()` |  | 
`$item->get_product()` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 795

### `cfw_items_summary_table_html`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$return` |  | 
`'checkout'` |  | 

Source: ./sources/php/functions.php, line 702

### `cfw_link_cart_items`

*Filters whether to link cart items to products*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('cart_item_link') === 'enabled'` |  | 

**Changelog**

Version | Description
------- | -----------
`1.0.0` | 

Source: ./sources/php/functions.php, line 887

### `cfw_order_cart_html`

*Filters order cart HTML output*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array($return)` |  | 
`'CheckoutWC 5.4.0'` |  | 
`'cfw_items_summary_table_html'` |  | 

**Changelog**

Version | Description
------- | -----------
`1.0.0` | 

Source: ./sources/php/functions.php, line 933

### `cfw_items_summary_table_html`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$return` |  | 
`'order'` |  | 

Source: ./sources/php/functions.php, line 943

### `cfw_side_cart_link_item`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 
`$item` |  | 

Source: ./sources/php/functions.php, line 955

### `cfw_show_cart_item_discount`

*Filters whether to show cart item discount on cart item*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('show_side_cart_item_discount') === 'yes'` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 981

### `cfw_cart_item_discount`

*Filters whether to show cart item discount on cart item*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$price` |  | 
`$item->get_raw_item()` |  | 
`$item->get_product()` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 981

### `cfw_items_summary_table_html`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$return` |  | 
`'side_cart'` |  | 

Source: ./sources/php/functions.php, line 946

### `cfw_cart_item_data_expanded`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('cart_item_data_display') === 'woocommerce'` |  | 

Source: ./sources/php/functions.php, line 1049

### `cfw_cart_totals_shipping_label`

*Filters cart totals shipping label*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`cfw_esc_html__('Shipping', 'woocommerce')` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1094

### `cfw_shipping_total_address_required_text`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`cfw_esc_html__('Enter your address to view shipping options.', 'woocommerce')` |  | 

Source: ./sources/php/functions.php, line 1137

### `cfw_shipping_total_not_available_text`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('No shipping methods available', 'checkout-wc')` |  | 

Source: ./sources/php/functions.php, line 1150

### `cfw_no_shipping_method_selected_message`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`''` |  | 

Source: ./sources/php/functions.php, line 1154

### `cfw_shipping_free_text`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`cfw__('Free!', 'woocommerce')` |  | 

Source: ./sources/php/functions.php, line 1163

### `cfw_cart_totals_shipping_label`

*Filters cart totals shipping label*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`cfw_esc_html__('Shipping', 'woocommerce')` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 1217

### `cfw_template_cart_el`

*Filters order totals element ID*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'cfw-totals-list'` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1252

### `cfw_order_totals_html`

*Filters order totals HTML*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`ob_get_clean()` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1299

### `cfw_place_order_button_container_classes`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array('place-order')` |  | 

Source: ./sources/php/functions.php, line 1334

### `cfw_payment_method_heading`

*Filters payment methods heading*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Payment', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1376

### `cfw_transactions_encrypted_statement`

*Filters payment methods transactions are encrypted statement*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('All transactions are secure and encrypted.', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1402

### `cfw_no_payment_required_text`

*Filters no payment required text*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Your order is free. No payment is required.', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1424

### `cfw_default_billing_address_radio_selection`

*Filters default billing address radio selection*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'same_as_shipping'` |  | 

**Changelog**

Version | Description
------- | -----------
`8.2.28` | 

Source: ./sources/php/functions.php, line 1460

### `cfw_billing_address_same_as_shipping_label`

*Filters the label for the same as shipping address radio*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('Same as shipping address', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`9.0.0` | 

Source: ./sources/php/functions.php, line 1469

### `cfw_billing_address_different_address_label`

*Filters the label for the different billing address radio*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('Use a different billing address', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`9.0.0` | 

Source: ./sources/php/functions.php, line 1477

### `cfw_force_display_billing_address`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('force_different_billing_address') === 'yes'` |  | 

Source: ./sources/php/functions.php, line 1493

### `cfw_thank_you_shipment_tracking_header`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`"<h4>{$tracking_item['formatted_tracking_provider']} {$label_suffix}</h4>"` |  | 
`$tracking_item['formatted_tracking_provider']` |  | 

Source: ./sources/php/functions.php, line 1643

### `cfw_thank_you_shipment_tracking_link`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`"<p><a class=\"tracking-number\" target=\"_blank\" href=\"{$tracking_item['formatted_tracking_link']}\">{$tracking_item['tracking_number']}</a></p>"` |  | 
`$tracking_item['formatted_tracking_link']` |  | 
`$tracking_item['tracking_number']` |  | 

Source: ./sources/php/functions.php, line 1655

### `cfw_thank_you_tracking_numbers`

*Filter to handle custom shipment tracking links output on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`''` |  | 
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 1664

### `cfw_maybe_output_tracking_numbers`

*Filter tracking numbers output on thank you page*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$output` |  | 
`$order` | `\WC_Order` | The order object

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 1679

### `cfw_show_return_to_cart_link`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

Source: ./sources/php/functions.php, line 1695

### `cfw_return_to_cart_link_url`

*Filter return to cart link URL*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`wc_get_cart_url()` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1699

### `cfw_return_to_cart_link_text`

*Filter return to cart link text*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Return to cart', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1709

### `cfw_return_to_cart_link`

*Filter return to cart link*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`sprintf('<a href="%s" class="cfw-prev-tab">« %s</a>', esc_attr($return_to_cart_link_url), $return_to_cart_link_text)` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 1719

### `cfw_continue_to_shipping_method_label`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Continue to shipping', 'checkout-wc')` |  | 

Source: ./sources/php/functions.php, line 1756

### `cfw_continue_to_shipping_button`

*Filter continue to shipping method button*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`sprintf('<a href="javascript:" data-tab="#cfw-shipping-method" class="%s"><span class="cfw-button-text">%s</span></a>', esc_attr(join(' ', $new_classes)), $continue_to_shipping_method_label)` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 1758

### `cfw_continue_to_payment_method_label`

*Filter continue to payment method button label*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$args['label']` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 1788

### `cfw_continue_to_payment_button`

*Filter continue to payment method button*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`sprintf('<a href="javascript:" data-tab="#cfw-payment-method" class="%s"><span class="cfw-button-text">%s</span></a>', esc_attr(join(' ', $args['classes'])), $continue_to_payment_method_label)` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 1798

### `cfw_continue_to_order_review_label`

*Filter continue to order review button label*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Review order', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 1810

### `cfw_continue_to_order_review_button`

*Filter continue to order review button*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`sprintf('<a href="javascript:" data-tab="#cfw-order-review" class="cfw-primary-btn cfw-next-tab cfw-continue-to-order-review-btn">%s</a>', $continue_to_order_review_label)` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 1820

### `cfw_return_to_customer_info_label`

*Filter return to customer information tab label*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Return to information', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 1832

### `cfw_return_to_customer_information_link`

*Filter return to customer information tab link*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`sprintf('<a href="javascript:" data-tab="#cfw-customer-info" class="cfw-prev-tab cfw-return-to-information-btn">« %s</a>', $return_to_customer_info_label)` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 1842

### `cfw_return_to_shipping_method_label`

*Filter return to shipping method tab label*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Return to shipping', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 1854

### `cfw_return_to_shipping_method_link`

*Filter return to shipping method tab link*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`sprintf('<a href="javascript:" data-tab="#cfw-shipping-method" class="cfw-prev-tab cfw-return-to-shipping-btn">« %s</a>', $return_to_shipping_method_label)` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 1864

### `cfw_return_to_payment_method_label`

*Filter return to payment method tab label*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Return to payment', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 1876

### `cfw_return_to_payment_method_link`

*Filter return to payment method tab link*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`sprintf('<a href="javascript:" data-tab="#cfw-payment-method" class="cfw-prev-tab cfw-return-to-payment-btn">« %s</a>', $return_to_payment_method_label)` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 1886

### `cfw_show_customer_information_tab`

*Filters whether to show customer information tab*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 1901

### `cfw_breadcrumb_cart_url`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`wc_get_cart_url()` |  | 

Source: ./sources/php/functions.php, line 1925

### `cfw_breadcrumb_cart_label`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`cfw_esc_html__('Cart', 'woocommerce')` |  | 

Source: ./sources/php/functions.php, line 1935

### `cfw_breadcrumbs`

*Filters breadcrumbs*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$default_breadcrumbs` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 1958

### `cfw_{$context}_main_container_classes`

*Filters main container classes*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`join(' ', $classes)` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 2040

### `cfw_is_checkout`

*Filter cfw_is_checkout()*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`function_exists('is_checkout') && is_checkout() && !is_order_received_page() && !is_checkout_pay_page()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 2068

### `cfw_is_checkout_pay_page`

*Filter is_checkout_pay_page()*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`function_exists('is_checkout_pay_page') && is_checkout_pay_page() && cfw_get_active_template()->supports('order-pay') && PlanManager::can_access_feature('enable_order_pay')` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 2088

### `cfw_is_order_received_page`

*Filter is_order_received_page()*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`function_exists('is_order_received_page') && is_order_received_page() && cfw_get_active_template()->supports('order-received') && PlanManager::can_access_feature('enable_thank_you_page')` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 2109

### `cfw_template_redirect_priority`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`11` |  | 

Source: ./sources/php/functions.php, line 2236

### `cfw_get_logo_attachment_id`

*Filters header logo attachment ID*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`SettingsManager::instance()->get_setting('logo_attachment_id', array(cfw_get_active_template()->get_slug()))` |  | 

**Changelog**

Version | Description
------- | -----------
`8.2.23` | 

Source: ./sources/php/functions.php, line 2280

### `cfw_header_home_url`

*Filters header logo / title link URL*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`get_home_url()` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/functions.php, line 2293

### `cfw_header_blog_name`

*Filters header logo / title link URL*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`get_bloginfo('name')` |  | 

**Changelog**

Version | Description
------- | -----------
`5.3.0` | 

Source: ./sources/php/functions.php, line 2303

### `cfw_express_pay_separator_text`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('Or', 'checkout-wc')` |  | 

Source: ./sources/php/functions.php, line 2404

### `cfw_cart_item_quantity_min_value`

*Filters cart item minimum quantity*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$args['min_value']` |  | 
`$cart_item` | `array` | The cart item
`$cart_item_key` | `string` | The cart item key

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 2574

### `cfw_cart_item_quantity_step`

*Filters cart item quantity step*

Determines how much to increment or decrement by

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$args['step']` |  | 
`$cart_item` | `array` | The cart item
`$cart_item_key` | `string` | The cart item key

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 2586

### `cfw_disable_side_cart_item_quantity_control`

*Filters whether to disable side cart item quantity control*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 
`$cart_item` | `array` | The cart item
`$cart_item_key` | `string` | The cart item key

**Changelog**

Version | Description
------- | -----------
`8.0.0` | 

Source: ./sources/php/functions.php, line 2611

### `cfw_cart_item_quantity_max_value`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$product->get_max_purchase_quantity()` |  | 
`$cart_item` |  | 
`$cart_item_key` |  | 

Source: ./sources/php/functions.php, line 2676

### `cfw_cart_quantity_input_has_override`

*Filters whether the cart quantity input has been overridden*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$woocommerce_core_cart_quantity !== $product_quantity` |  | 
`$cart_item_key` |  | 

**Changelog**

Version | Description
------- | -----------
`8.2.18` | 

Source: ./sources/php/functions.php, line 2694

### `cfw_get_woocommerce_notices`

*Filters WooCommerce notices before display*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->session->get('wc_notices', array())` |  | 

**Changelog**

Version | Description
------- | -----------
`8.2.23` | 

Source: ./sources/php/functions.php, line 2705

### `cfw_get_suggested_products`

*Filter suggested products*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$cross_sells` | `\WC_Product[]` | The suggested products

**Changelog**

Version | Description
------- | -----------
`9.0.0` | 

Source: ./sources/php/functions.php, line 2900

### `cfw_get_suggested_products`

*Filter suggested products*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$cross_sells` | `array` | 
`$limit` | `int` | 
`$random_fallback` | `bool` | 

**Changelog**

Version | Description
------- | -----------
`8.0.0` | 

Source: ./sources/php/functions.php, line 2913

### `cfw_cart_item_discount`

*Filters the discount HTML for a cart item*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$discount_html` | `string` | The discount HTML
`$item->get_raw_item()` |  | 
`$item->get_product()` |  | 

**Changelog**

Version | Description
------- | -----------
`4.0.0` | 

Source: ./sources/php/functions.php, line 3473

### `cfw_cart_totals_shipping_label`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`cfw_esc_html__('Shipping', 'woocommerce')` |  | 

Source: ./sources/php/functions.php, line 3637

### `cfw_get_cart_actions_data`

*Filters the cart actions data*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array(
    /**
     * Fires at start of cart table
     *
     * @since 2.0.0
     */
    'cfw_cart_html_table_start' => cfw_get_action_output('cfw_cart_html_table_start'),
    /**
     * After cart html table output
     *
     * @since 4.3.4
     */
    'cfw_after_cart_html' => cfw_get_action_output('cfw_after_cart_html'),
    /**
     * Fires at end of coupon module before closing </div> tag
     *
     * @since 2.0.0
     */
    'cfw_coupon_module_end' => cfw_get_action_output('cfw_coupon_module_end'),
    /**
     * Fires before shipping methods heading
     *
     * @since 2.0.0
     */
    'cfw_checkout_before_shipping_methods' => cfw_get_action_output('cfw_checkout_before_shipping_methods'),
    /**
     * Fires after shipping method heading
     *
     * @since 2.0.0
     */
    'cfw_after_shipping_method_heading' => cfw_get_action_output('cfw_after_shipping_method_heading'),
    /**
     * Fires after shipping methods
     *
     * @since 2.0.0
     */
    'cfw_checkout_after_shipping_methods' => cfw_get_action_output('cfw_checkout_after_shipping_methods'),
    'woocommerce_review_order_before_shipping' => has_action('woocommerce_review_order_before_shipping') ? '<table id="cfw-before-shipping">' . cfw_get_action_output('woocommerce_review_order_before_shipping') . '</table>' : '',
    'woocommerce_review_order_after_shipping' => has_action('woocommerce_review_order_after_shipping') ? '<table id="cfw-after-shipping">' . cfw_get_action_output('woocommerce_review_order_after_shipping') . '</table>' : '',
)` |  | 

**Changelog**

Version | Description
------- | -----------
`9.0.0` | 

Source: ./sources/php/functions.php, line 3646

### `cfw_review_pane_contact_value`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->checkout()->get_value('billing_email')` |  | 

Source: ./sources/php/functions.php, line 3718

### `cfw_payment_method_address_review_shipping_method`

*Filters chosen shipping methods label*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$chosen_shipping_methods_labels` | `string` | The chosen shipping methods

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/functions.php, line 3881

### `cfw_login_modal_last_password_link`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`sprintf('<a id="cfw_lost_password_trigger" href="#cfw_lost_password_form_wrap" class="cfw-small">%s</a>', cfw_esc_html__('Lost your password?', 'woocommerce'))` |  | 

Source: ./sources/php/functions.php, line 4029

### `cfw_deactivation_form_fields`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array()` |  | 

Source: ./sources/php/deactivation-survey.php, line 7

### `cfw_ab_test_url_parameter`

*Filters the URL parameter for loading AB tests by URL*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'cfw_ab_test'` |  | 

**Changelog**

Version | Description
------- | -----------
`8.2.8` | 

Source: ./sources/php/ab-testing-api.php, line 43

### `cfw_replace_form`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

Source: ./sources/php/template-hooks.php, line 40

### `cfw_replace_form`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

Source: ./sources/php/template-hooks.php, line 49

### `cfw_show_order_summary_link_text`

*Filters show order summary link label*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Show order summary', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 100

### `cfw_show_order_summary_hide_link_text`

*Filters hide order summary link label*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Hide order summary', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/template-functions.php, line 117

### `cfw_wc_print_notices`

*Filters WooCommerce notices before display*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->session->get('wc_notices', array())` |  | 

**Changelog**

Version | Description
------- | -----------
`8.2.19` | 

Source: ./sources/php/template-functions.php, line 195

### `cfw_customer_information_heading`

*Filters customer info tab heading*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Information', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 314

### `cfw_order_review_tab_heading`

*Filters order review tab heading*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('Order review', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 333

### `cfw_already_have_account_text`

*Filters already have account text*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Already have an account with us?', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 398

### `cfw_login_faster_text`

*Filters login faster text*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Log in.', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 410

### `cfw_hide_email_field_for_logged_in_users`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`true` |  | 

Source: ./sources/php/template-functions.php, line 441

### `cfw_create_account_site_name`

*Filters create account checkbox site name*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`get_bloginfo('name')` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 511

### `cfw_create_account_checkbox_label`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Create %s shopping account.', 'checkout-wc')` |  | 

Source: ./sources/php/template-functions.php, line 526

### `cfw_account_creation_statement`

*Filters create account statement*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('If you do not have an account, we will create one for you.', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 532

### `cfw_welcome_back_name`

*Filters welcome back statement customer name*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`wp_get_current_user()->display_name` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 553

### `cfw_welcome_back_email`

*Filters welcome back statement customer email*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`wp_get_current_user()->user_email` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 561

### `cfw_welcome_back_text`

*Filters welcome back statement*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$welcome_back_text` | `string` | Welcome back statement
`$welcome_back_name` |  | 
`$welcome_back_email` |  | 

**Changelog**

Version | Description
------- | -----------
`7.1.10` | 

Source: ./sources/php/template-functions.php, line 572

### `cfw_show_logout_link`

*Filters whether to show logout link*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 580

### `cfw_billing_shipping_address_heading`

*Filters billing and shipping address heading*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Billing and Shipping address', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 634

### `cfw_billing_address_heading`

*Filters billing address heading*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Billing address', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 644

### `cfw_shipping_address_heading`

*Filters shipping address heading*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Shipping address', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`2.0.0` | 

Source: ./sources/php/template-functions.php, line 654

### `cfw_show_shipping_tab`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->cart && WC()->cart->needs_shipping() && SettingsManager::instance()->get_setting('skip_shipping_step') !== 'yes'` |  | 

Source: ./sources/php/template-functions.php, line 768

### `cfw_show_shipping_total`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->cart->needs_shipping() && wc_shipping_enabled() && WC()->cart->get_cart_contents() && count(WC()->shipping()->get_packages()) > 0` |  | 

Source: ./sources/php/template-functions.php, line 781

### `cfw_billing_address_heading`

*Filters billing address heading on payment method tab*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Billing address', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/template-functions.php, line 1012

### `cfw_billing_address_description`

*Filters billing address description*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Select the address that matches your card or payment method.', 'checkout-wc')` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/template-functions.php, line 1033

### `cfw_form_attributes`

*The form attributes*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$attributes` |  | 
`$id` | `bool\|mixed` | 

Source: ./sources/php/template-functions.php, line 1251

### `cfw_thank_you_heading_icon`

*Filters thank you page heading icon*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" fill="none" stroke-width="2" class="cfw-checkmark"><path class="checkmark__circle" d="M25 49c13.255 0 24-10.745 24-24S38.255 1 25 1 1 11.745 1 25s10.745 24 24 24z"></path><path class="checkmark__check" d="M15 24.51l7.307 7.308L35.125 19"></path></svg>'` |  | 
`$order` |  | 

**Changelog**

Version | Description
------- | -----------
`5.4.0` | 

Source: ./sources/php/template-functions.php, line 1333

### `cfw_thank_you_title`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('Order %s', 'checkout-wc')` |  | 

Source: ./sources/php/template-functions.php, line 1352

### `cfw_thank_you_subtitle`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('Thank you %s!', 'checkout-wc')` |  | 

Source: ./sources/php/template-functions.php, line 1365

### `cfw_thank_you_status_icon_{$order_status}`

*Filters thank you status icon class*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`'fa fa-chevron-circle-right'` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/template-functions.php, line 1437

### `cfw_order_updates_heading`

*Thank you page order updates section*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('Order updates', 'checkout-wc')` |  | 
`$order` | `\WC_Order` | 

Source: ./sources/php/template-functions.php, line 1493

### `cfw_order_updates_text`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('You’ll get shipping and delivery updates by email.', 'checkout-wc')` |  | 
`$order` |  | 

Source: ./sources/php/template-functions.php, line 1509

### `cfw_billing_shipping_address_heading`

*This action is documented earlier in this file*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('Billing and Shipping address', 'checkout-wc')` |  | 

Source: ./sources/php/template-functions.php, line 1614

### `cfw_shipping_address_heading`

*This action is documented earlier in this file*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Shipping address', 'checkout-wc')` |  | 

Source: ./sources/php/template-functions.php, line 1621

### `cfw_billing_address_heading`

*This action is documented earlier in this file*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Billing address', 'checkout-wc')` |  | 

Source: ./sources/php/template-functions.php, line 1637

### `cfw_thank_you_continue_shopping_text`

*Filters thank you page continue shopping button text*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`cfw_esc_html__('Continue shopping', 'woocommerce')` |  | 

**Changelog**

Version | Description
------- | -----------
`3.0.0` | 

Source: ./sources/php/template-functions.php, line 1671

### `cfw_get_checkout_tabs`

*Filters the checkout tabs*

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array('cfw-customer-info' => array('label' => apply_filters(esc_html__('Information', 'checkout-wc')), 'classes' => array(), 'priority' => 20, 'enabled' => cfw_show_customer_information_tab(), 'display_callback' => function () {
    /**
     * Outputs customer info tab content
     *
     * @since 2.0.0
     */
    do_action();
}), 'cfw-shipping-method' => array('label' => apply_filters(esc_html__('Shipping', 'checkout-wc')), 'classes' => array(), 'priority' => 30, 'enabled' => true, 'display_callback' => function () {
    /**
     * Outputs customer info tab content
     *
     * @since 2.0.0
     */
    do_action();
}), 'cfw-payment-method' => array('label' => apply_filters(WC()->cart->needs_payment() ? esc_html__('Payment', 'checkout-wc') : esc_html__('Review', 'checkout-wc')), 'classes' => array('woocommerce-checkout-payment'), 'priority' => 40, 'enabled' => true, 'display_callback' => function () {
    /**
     * Outputs customer info tab content
     *
     * @since 2.0.0
     */
    do_action();
}))` |  | 

**Changelog**

Version | Description
------- | -----------
`7.0.0` | 

Source: ./sources/php/template-functions.php, line 1868

### `cfw_breadcrumb_customer_info_label`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Information', 'checkout-wc')` |  | 

Source: ./sources/php/template-functions.php, line 1879

### `cfw_breadcrumb_shipping_label`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`esc_html__('Shipping', 'checkout-wc')` |  | 

Source: ./sources/php/template-functions.php, line 1894

### `cfw_breadcrumb_payment_label`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`WC()->cart->needs_payment() ? esc_html__('Payment', 'checkout-wc') : esc_html__('Review', 'checkout-wc')` |  | 

Source: ./sources/php/template-functions.php, line 1908

### `cfw_empty_side_cart_heading`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`__('Your Cart is Empty', 'checkout-wc')` |  | 

Source: ./sources/php/template-functions.php, line 1974

### `cfw_replace_form`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

Source: ./templates/futurist/content.php, line 32

### `cfw_replace_form`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

Source: ./templates/copify/content.php, line 36

### `cfw_replace_form`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

Source: ./templates/default/content.php, line 32

### `cfw_replace_form`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

Source: ./templates/glass/content.php, line 35

### `cfw_groove_cart_summary_classes`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array('col-lg-5')` |  | 

Source: ./templates/groove/thank-you.php, line 73

### `cfw_replace_form`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`false` |  | 

Source: ./templates/groove/content.php, line 36

### `cfw_groove_cart_summary_classes`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array('col-lg-5')` |  | 

Source: ./templates/groove/content.php, line 88

### `cfw_groove_cart_summary_classes`

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`array('col-lg-5')` |  | 

Source: ./templates/groove/order-pay.php, line 60


<p align="center"><a href="https://github.com/pronamic/wp-documentor"><img src="https://cdn.jsdelivr.net/gh/pronamic/wp-documentor@main/logos/pronamic-wp-documentor.svgo-min.svg" alt="Pronamic WordPress Documentor" width="32" height="32"></a><br><em>Generated by <a href="https://github.com/pronamic/wp-documentor">Pronamic WordPress Documentor</a> <code>1.2.0</code></em><p>

