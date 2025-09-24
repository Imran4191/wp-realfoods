<?php
    $tax_type 		= Wf_Woocommerce_Packing_List::get_option('woocommerce_wf_generate_for_taxstatus');
    $tax_type = in_array('in_tax', $tax_type) ? 'incl_tax' : 'excl_type';
    $all_attr = array(
        'tax_type'      => $tax_type,
        'discount_type' => 'before_discount',
        'p_meta'        => '',
        'p_attr'        => '',
        'oi_meta'       => '',
    );
    if(class_exists('Wf_Woocommerce_Packing_List_Template_Load')){
        $all_attr = Wf_Woocommerce_Packing_List_Template_Load::load_template_element_attributes('invoice');
    }
?>
<!-- DC ready -->
<style type="text/css">
body, html{font-family:"Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;}
.clearfix::after{ display:block; clear:both; content:""; }

.wfte_invoice-main{ color:#202020; font-size:12px; font-weight:400; box-sizing:border-box; width:100%; height:auto; }
.wfte_invoice-main *{ box-sizing:border-box;}
.template_footer{color:#202020; font-size:12px; font-weight:400; box-sizing:border-box; padding:30px 0px; height:auto;}
.template_footer *{ box-sizing:border-box;}

.wfte_row{ width:100%; display:block; }
.wfte_sub_row{ width:100%; display:block; }
.wfte_col-1{ width:100%; display:block;}
.wfte_col-2{ width:50%; display:block;}
.wfte_col-3{ width:33%; display:block;}
.wfte_col-4{ width:25%; display:block;}
.wfte_col-6{ width:30%; display:block;}
.wfte_col-7{ width:69%; display:block;}

.float_left{ float:left; }
.float_right{ float:right; }

.wfte_company_logo_img_box{ margin-bottom:10px; }
.wfte_company_logo_img{ width:150px; max-width:100%; }
.wfte_doc_title{ color:#23a8f9; font-size:30px; font-weight:bold; height:auto; width:100%; line-height:22px;}
.wfte_invoice_data div span:first-child, .wfte_extra_fields span:first-child{ font-weight:bold; }
.wfte_invoice_data{ line-height:16px; font-size:12px; }

.wfte_address-field-header{ font-weight:bold; font-size:12px; color:#000; padding:3px; padding-left:0px;}
.wfte_addrss_field_main{ padding-top:15px;}

.wfte_received_seal{ position:absolute; z-index:10; margin-top:90px; margin-left:0px; width:130px; border-radius:5px; font-size:22px; height:40px; line-height:28px; border:solid 5px #00ccc5; color:#00ccc5; font-weight:900; text-align:center; transform:rotate(-45deg); opacity:.5; }

.wfte_product_table{ width:100%; border-collapse:collapse; margin:0px; }
.wfte_product_table_head th{ height:36px; padding:0px 5px; font-size:.75rem; text-align:left; line-height:10px; border-bottom:solid 1px #D7DBDF; font-family:"Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;}
.wfte_product_table_head_product{width: 30%;}
.wfte_product_table_body td, .wfte_payment_summary_table_body td{ font-size:12px; line-height:15px;}
.wfte_product_table_body td{ padding:10px 5px; border-bottom:solid 1px #dddee0;}
.wfte_product_table_body .product_td b{ font-weight:normal; }
.product_td b{line-height: 15px;} 

.wfte_payment_summary_table{ margin-bottom:10px; }
.wfte_payment_summary_table .wfte_left_column{ width:60%; }
.wfte_payment_summary_table_body .wfte_right_column{ text-align:left; }
.wfte_payment_summary_table_body td{ padding:5px 5px; border:none;}
.wfte_table_head_color{ color:#2e2e2e; }

.wfte_product_table_payment_total td{ font-size:13px; color:#000; height:28px; border-top:solid 1px #D7DBDF;}
.wfte_product_table_payment_total td:nth-child(3){ font-weight:bold; }
.wfte_product_table_payment_total td.wfte_left_column{border: none;}
.wfte_product_table_category_row td{ padding:10px 5px;}

.wfte_signature{ width:100%; height:auto; min-height:60px; padding:5px 0px;}
.wfte_signature_label{ font-size:12px; }
.wfte_image_signature_box{ display:inline-block;}
.wfte_return_policy{width:100%; height:auto; border-bottom:solid 1px #dfd5d5; padding:5px 0px; margin-top:5px; }
.wfte_footer{width:100%; height:auto; padding:5px 0px; margin-top:5px;font-size: 12px;}

/* for mPdf */
.wfte_invoice_data{ border:solid 0px #fff; }
.wfte_invoice_data td, .wfte_extra_fields td{ font-size:12px; padding:0px; font-family:"Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif; line-height:14px;}
.wfte_invoice_data tr td:nth-child(1), .wfte_extra_fields tr td:nth-child(1){ font-weight:bold; }
</style>
<div class="wfte_rtl_main wfte_invoice-main wfte_invoice_pro_main wfte_adc_main" style="padding-top:30px; padding-right:30px; padding-bottom:30px; padding-left:30px; margin-top: 0px; margin-bottom:0px; margin-left:0px; margin-right:0px;">
    <div class="wfte_row wfte_adc_row clearfix">
        <div class="wfte_col-3 float_left">
            <div class="wfte_company_logo wfte_template_element" data-hover-id="company_logo">
                <div class="wfte_company_logo_img_box">
                    <img src="[wfte_company_logo_url]" class="wfte_company_logo_img">
                </div>
                <div class="wfte_company_name wfte_hidden"> [wfte_company_name]</div>
                <div class="wfte_company_logo_extra_details">__[]__</div>
            </div>
        </div>
        <div class="wfte_col-3 float_left">
            <div class="wfte_from_address wfte_template_element" data-hover-id="from_address">
                <div class="wfte_address-field-header wfte_from_address_label">__[]__</div>
                <div class="wfte_from_address_val">
                    [wfte_from_address]
                </div>
            </div>
        </div>
        <div class="wfte_col-3 float_right">
            <div class="wfte_doc_title wfte_template_element" data-hover-id="doc_title">__[INVOICE]__</div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="wfte_row wfte_adc_row clearfix" style="padding-top: 15px;">
        <div class="wfte_col-1 float_left wfte_text_left">
        </div>
    </div>
    <div class="wfte_row wfte_adc_row clearfix">
        <div class="wfte_col-3 float_left">
            
        </div>
        <div class="wfte_col-3 float_left" style="height: 1px;">
        </div>
        <div class="wfte_col-3 float_right">
            
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="wfte_row wfte_adc_row clearfix" style="padding-top: 15px;">
        <div class="wfte_col-1 float_left wfte_text_left">
        </div>
    </div>
    <div class="wfte_row wfte_adc_row clearfix">
        <div class="wfte_col-3 float_left">
            <div class="wfte_billing_address wfte_template_element" data-hover-id="billing_address">
                <div class="wfte_address-field-header wfte_billing_address_label">__[Bill to]__</div>
                <div class="wfte_billing_address_val">
                    [wfte_billing_address]
                </div>
            </div>
            <div class="wfte_invoice_data">
                <div class="wfte_email wfte_template_element" data-hover-id="email">
                    <span class="wfte_email_label wfte_order_fields_label">__[]__</span>
                    <span class="wfte_email_val wfte_order_fields_val">[wfte_email]</span>
                </div>
                <div class="wfte_tel wfte_template_element" data-hover-id="tel">
                    <span class="wfte_tel_label wfte_order_fields_label">__[]__ </span>
                    <span class="wfte_tel_val wfte_order_fields_val">[wfte_tel]</span>
                </div>
            </div>
        </div>
        <div class="wfte_col-3 float_left">
            <div class="wfte_shipping_address wfte_template_element wfte_hidden" data-hover-id="shipping_address">
                <div class="wfte_address-field-header wfte_shipping_address_label">__[Ship to]__</div>
                <div class="wfte_shipping_address_val">
                    [wfte_shipping_address]
                </div>
            </div>
        </div>
        <div class="wfte_col-3 float_right">
            <div class="wfte_invoice_data">
                <div class="wfte_invoice_number wfte_template_element" data-hover-id="invoice_number" style="font-size: 20px;">
                    <span class="wfte_invoice_number_label wfte_order_fields_label">__[Invoice no:]__ </span> 
                    <span class="wfte_invoice_number_val wfte_order_fields_val">[wfte_invoice_number]</span>
                </div>
                <div class="wfte_invoice_date wfte_hidden wfte_template_element" data-invoice_date-format="m-d-Y" data-hover-id="invoice_date">
                    <span class="wfte_invoice_date_label wfte_order_fields_label">__[Invoice date:]__ </span> 
                    <span class="wfte_invoice_date_val wfte_order_fields_val">[wfte_invoice_date]</span>
                </div>
                <div class="wfte_order_number wfte_hidden wfte_template_element" data-hover-id="order_number">
                    <span class="wfte_order_number_label wfte_order_fields_label">__[Order no:]__ </span> 
                    <span class="wfte_order_number_val wfte_order_fields_val">[wfte_order_number]</span>
                </div>
                <div class="wfte_order_date wfte_template_element" data-order_date-format="m-d-Y" data-hover-id="order_date">
                    <span class="wfte_order_date_label wfte_order_fields_label">__[Order date:]__ </span> 
                    <span class="wfte_order_date_val wfte_order_fields_val">[wfte_order_date]</span>
                </div>
                <div class="wfte_ssn_number wfte_hidden wfte_template_element" data-hover-id="ssn_number">
                    <span class="wfte_ssn_number_label wfte_order_fields_label">__[SSN:]__ </span> 
                    <span class="wfte_ssn_number_val wfte_order_fields_val">[wfte_ssn_number]</span>
                </div>
                <div class="wfte_vat_number wfte_hidden wfte_template_element" data-hover-id="vat_number">
                    <span class="wfte_vat_number_label wfte_order_fields_label">__[VAT:]__ </span> 
                    <span class="wfte_vat_number_val wfte_order_fields_val">[wfte_vat_number]</span>
                </div>
                <div class="wfte_tracking_number wfte_hidden wfte_template_element" data-hover-id="tracking_number">
                    <span class="wfte_tracking_number_label">__[Tracking no:]__ </span>
                    <span class="wfte_tracking_number_val">[wfte_tracking_number]</span>
                </div>
                <div class="wfte_shipping_method wfte_hidden wfte_template_element" data-hover-id="shipping_method">
                    <span class="wfte_shipping_method_label">__[Shipping Method:]__ </span>
                    <span class="wfte_shipping_method_val">[wfte_shipping_method]</span>
                </div>
                <div class="wfte_product_table_payment_method wfte_template_element" data-hover-id="product_table_payment_method">
                    <span class="wfte_product_table_payment_method_label">__[Payment method:]__ </span>
                    <span class="wfte_product_table_payment_method_val">[wfte_product_table_payment_method]</span>
                </div>
                <div class="wfte_order_item_meta">[wfte_order_item_meta]</div>
                [wfte_extra_fields]
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="wfte_row wfte_adc_row clearfix">
        <div class="wfte_col-2 float_left">
        </div>
        <div class="wfte_col-2 float_right">
            <div class="wfte_received_seal wfte_hidden wfte_template_element" data-hover-id="received_seal"><span class="wfte_received_seal_text">__[RECEIVED]__</span>[wfte_received_seal_extra_text]</div>
        </div>
    </div>
    <div class="wfte_row wfte_adc_row clearfix" style="padding-top: 15px;">
        <div class="wfte_col-1 float_left wfte_text_left">
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="wfte_row wfte_adc_row clearfix">
        <div class="wfte_col-1">
            <table class="wfte_product_table wfte_side_padding_table wfte_template_element" data-hover-id="product_table">
                <thead class="wfte_product_table_head wfte_table_head_color wfte_product_table_head_bg">
                    <tr>
                        <th class="wfte_product_table_head_serial_no wfte_product_table_head_bg wfte_table_head_color" col-type="serial_no">__[S.NO]__</th>
                        <th class="wfte_product_table_head_image wfte_product_table_head_bg wfte_table_head_color" col-type="-image" data-img-width="40px" data-img-height="40px">__[Image]__</th>
                        <th class="wfte_product_table_head_sku wfte_product_table_head_bg wfte_table_head_color" col-type="-sku" data-col-value-font-size="12px" data-col-value-font-weight="normal">__[SKU]__</th>
                        <th class="wfte_product_table_head_product wfte_product_table_head_bg wfte_table_head_color" col-type="product" data-col-value-font-size="12px" data-col-value-font-weight="bold" data-p-meta="<?php esc_attr_e($all_attr['p_meta']); ?>" data-p-attr="<?php esc_attr_e($all_attr['p_attr']); ?>" data-oi-meta="<?php esc_attr_e($all_attr['oi_meta']); ?>">__[Product]__</th>
                        <th class="wfte_product_table_head_quantity wfte_product_table_head_bg wfte_table_head_color wfte_text_center" col-type="quantity" data-col-value-font-size="12px" data-col-value-font-weight="normal">__[Quantity]__</th>
                        <th class="wfte_product_table_head_price wfte_product_table_head_bg wfte_table_head_color" col-type="price" data-col-value-font-size="12px" data-col-value-font-weight="normal" data-tax-type="<?php esc_attr_e($all_attr['tax_type']); ?>" data-discount-type="before_discount">__[Price]__</th>
                        <th class="wfte_product_table_head_total_price wfte_product_table_head_bg wfte_table_head_color" col-type="total_price" data-col-value-font-size="12px" data-col-value-font-weight="normal" data-tax-type="<?php esc_attr_e($all_attr['tax_type']); ?>" data-discount-type="before_discount">__[Total price]__</th>
                        <th class="wfte_product_table_head_tax_items wfte_product_table_head_bg wfte_table_head_color" col-type="-tax_items" data-ind-tax-display-option="amount" data-col-value-font-size="12px" data-col-value-font-weight="normal" data-discount-type="before_discount">[wfte_product_table_tax_item_column_label]</th>
                        <th class="wfte_product_table_head_tax wfte_product_table_head_bg wfte_table_head_color" col-type="-tax" data-total-tax-display-option="amount" data-col-value-font-size="12px" data-col-value-font-weight="normal" data-discount-type="before_discount">__[Total tax]__</th>
                    </tr>
                </thead>
                <tbody class="wfte_product_table_body wfte_table_body_color">
                </tbody>
            </table>
            <table class="wfte_payment_summary_table wfte_product_table wfte_side_padding_table">
                <tbody class="wfte_payment_summary_table_body wfte_table_body_color">
                    <tr class="wfte_payment_summary_table_row">
                        <td colspan="3"></td>
                    </tr>
                    <tr class="wfte_payment_summary_table_row wfte_product_table_subtotal wfte_template_element" data-hover-id="product_table_subtotal" data-row-type="wfte_product_table_subtotal" data-tax-type="<?php esc_attr_e($all_attr['tax_type']); ?>" data-discount-type="before_discount">
                        <td class="wfte_left_column"></td>
                        <td class="wfte_product_table_subtotal_label wfte_text_left">__[Subtotal]__</td>
                        <td class="wfte_right_column wfte_text_left">[wfte_product_table_subtotal]</td>
                    </tr>
                    <tr class="wfte_payment_summary_table_row wfte_product_table_shipping wfte_template_element" data-hover-id="product_table_shipping" data-row-type="wfte_product_table_shipping" data-tax-type="<?php esc_attr_e($all_attr['tax_type']); ?>" data-shipping-type="amount_label">
                        <td class="wfte_left_column"></td>
                        <td class="wfte_product_table_shipping_label wfte_text_left">__[Shipping]__</td>
                        <td class="wfte_right_column wfte_text_left">[wfte_product_table_shipping]</td>
                    </tr>
                    <tr class="wfte_payment_summary_table_row wfte_product_table_cart_discount wfte_hidden wfte_template_element" data-hover-id="product_table_cart_discount" data-row-type="wfte_product_table_cart_discount" data-tax-type="<?php esc_attr_e($all_attr['tax_type']); ?>">
                        <td class="wfte_left_column"></td>
                        <td class="wfte_product_table_cart_discount_label wfte_text_left">__[Cart discount]__</td>
                        <td class="wfte_right_column wfte_text_left">[wfte_product_table_cart_discount]</td>
                    </tr>
                    <tr class="wfte_payment_summary_table_row wfte_product_table_order_discount wfte_hidden wfte_template_element" data-hover-id="product_table_order_discount" data-row-type="wfte_product_table_order_discount" data-tax-type="<?php esc_attr_e($all_attr['tax_type']); ?>">
                        <td class="wfte_left_column"></td>
                        <td class="wfte_product_table_order_discount_label wfte_text_left">__[Order discount]__</td>
                        <td class="wfte_right_column wfte_text_left">[wfte_product_table_order_discount]</td>
                    </tr>
                    <tr data-row-type="wfte_tax_items" class="wfte_payment_summary_table_row wfte_product_table_tax_item wfte_hidden wfte_template_element" data-hover-id="product_table_tax_item" data-ind-tax-type="tot-combined-tax">
                        <td class="wfte_left_column"></td>
                        <td class="wfte_product_table_tax_item_label wfte_text_left">[wfte_product_table_tax_item_label]</td>
                        <td class="wfte_right_column wfte_text_left">[wfte_product_table_tax_item]</td>
                    </tr>
                    <tr class="wfte_payment_summary_table_row wfte_product_table_total_tax wfte_template_element" data-hover-id="product_table_total_tax" data-row-type="wfte_product_table_total_tax" data-tot-tax-type="tot-combined-tax">
                        <td class="wfte_left_column"></td>
                        <td class="wfte_product_table_total_tax_label wfte_text_left">__[Total tax]__</td>
                        <td class="wfte_right_column wfte_text_left">[wfte_product_table_total_tax]</td>
                    </tr>
                    <tr class="wfte_payment_summary_table_row wfte_product_table_fee wfte_hidden wfte_template_element" data-hover-id="product_table_fee" data-row-type="wfte_product_table_fee" data-tax-type="<?php esc_attr_e($all_attr['tax_type']); ?>">
                        <td class="wfte_left_column"></td>
                        <td class="wfte_product_table_fee_label wfte_text_left">__[Fee]__</td>
                        <td class="wfte_right_column wfte_text_left">[wfte_product_table_fee]</td>
                    </tr>
                    <tr class="wfte_payment_summary_table_row wfte_product_table_total_weight wfte_template_element wfte_hidden" data-hover-id="product_table_total_weight" data-row-type="wfte_product_table_total_weight">
                        <td class="wfte_left_column"></td>
                        <td class="product_table_total_weight_label wfte_text_left">__[Total weight]__</td>
                        <td class="wfte_right_column wfte_text_left">[wfte_product_table_total_weight]</td>
                    </tr>
                    <tr class="wfte_payment_summary_table_row wfte_product_table_total_qty wfte_template_element wfte_hidden" data-hover-id="product_table_total_qty" data-row-type="wfte_product_table_total_qty">
                        <td class="wfte_left_column"></td>
                        <td class="product_table_total_qty_label wfte_text_left">__[Total quantity]__</td>
                        <td class="wfte_right_column wfte_text_left">[wfte_product_table_total_qty]</td>
                    </tr>
                    <tr class="wfte_payment_summary_table_row wfte_product_table_coupon wfte_hidden wfte_template_element" data-hover-id="product_table_coupon" data-row-type="wfte_product_table_coupon">
                        <td class="wfte_left_column"></td>
                        <td class="wfte_product_table_coupon_label wfte_text_left">__[Coupon used]__</td>
                        <td class="wfte_right_column wfte_text_left">[wfte_product_table_coupon]</td>
                    </tr>
                    <tr class="wfte_payment_summary_table_row wfte_product_table_additional_info wfte_hidden wfte_template_element" data-hover-id="product_table_additional_info" data-row-type="wfte_product_table_additional_info">
                        <td class="wfte_left_column"></td>
                        <td class="wfte_product_table_additional_info_label wfte_text_left">[wfte_product_table_additional_info_label]</td>
                        <td class="wfte_right_column wfte_text_left">[wfte_product_table_additional_info_value]</td>
                    </tr>
                    <tr class="wfte_payment_summary_table_row wfte_product_table_payment_total wfte_template_element" data-hover-id="product_table_payment_total" data-row-type="wfte_product_table_payment_total" data-tax-type="incl_tax">
                        <td class="wfte_left_column"></td>
                        <td class="wfte_product_table_payment_total_label wfte_text_left">__[Total]__</td>
                        <td class="wfte_product_table_payment_total_val wfte_right_column wfte_text_left">[wfte_product_table_payment_total]</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="wfte_row wfte_adc_row clearfix" style="padding-top: 15px;">
        <div class="wfte_col-1 float_left wfte_text_left">
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="wfte_row wfte_adc_row wfte_padding_left_right clearfix" style="margin-top:20px;"> 
        <div class="wfte_col-2 float_left">
            <div class="wfte_invoice_data">
                <div class="wfte_payment_link wfte_hidden wfte_template_element" data-hover-id="payment_link">
                    <a href="[wfte_payment_link]" target="_blank"><span class="wfte_payment_link_label">__[Pay Now]__ </span></a>
                </div>
            </div>
        </div>
        <div class="wfte_col-4 float_left"></div>
        <div class="wfte_col-4 float_right">
            <div class="wfte_signature wfte_hidden wfte_text_right wfte_template_element" data-hover-id="signature">
                <img src="[wfte_signature_url]" class="wfte_image_signature" style="margin-bottom:15px;">
                <div class="wfte_manual_signature wfte_hidden" style="height:60px; width:150px;"></div>
                <div class="wfte_signature_label">__[Signature]__</div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="wfte_row wfte_adc_row clearfix">
        <div class="wfte_col-1 float_left">
            <div class="wfte_invoice_data">
                <div class="wfte_customer_note wfte_template_element" data-hover-id="customer_note">
                    <span class="wfte_customer_note_label wfte_order_fields_label">__[Customer note:]__ </span> 
                    <span class="wfte_customer_note_val wfte_order_fields_val">[wfte_customer_note]</span>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="wfte_row wfte_adc_row wfte_padding_left_right clearfix" style="margin-top:20px;"> 
        <div class="wfte_col-2 float_left" style="height:1px;">
        </div>
        <div class="wfte_col-4 float_left"></div>
        <div class="wfte_col-4 float_right">
            <div class="wfte_invoice_data">
                <div class="wfte_qrcode wfte_template_element wfte_hidden" data-hover-id="qrcode">
                    <img src="[wfte_qrcode_url]" class="wfte_img_qrcode">
                </div>
                <div class="wfte_barcode wfte_hidden wfte_template_element" data-hover-id="barcode">
                    <img src="[wfte_barcode_url]" class="wfte_img_barcode">
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="wfte_row wfte_adc_row clearfix">
        <div class="wfte_col-1">
            <div class="wfte_return_policy wfte_hidden clearfix wfte_template_element" data-hover-id="return_policy">
                [wfte_return_policy]
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="template_footer clearfix">
    <div class="wfte_col-1">
        <div class="wfte_footer clearfix wfte_template_element" data-hover-id="footer">
            [wfte_footer]
        </div>
    </div>
</div>