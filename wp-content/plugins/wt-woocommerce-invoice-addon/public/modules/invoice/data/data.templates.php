<?php
$template_arr_pro=array(
	array(
		'id'=>'template_premium_1',
		'title'=>__('Premium Layout 1', 'wt_woocommerce_invoice_addon'),
		'preview_img'=>'template1.png',
		'version' => 'pro',
		'pro_template_path' => plugin_dir_path(__FILE__),
		'pro_template_url' => WT_PKLIST_INVOICE_ADDON_PLUGIN_URL.'public/modules/invoice/data/',
	),
	array(
		'id'=>'template_premium_2',
		'title'=>__('Premium Layout 2', 'wt_woocommerce_invoice_addon'),
		'preview_img'=>'template2.png',
		'version' => 'pro',
		'pro_template_path' => plugin_dir_path(__FILE__),
		'pro_template_url' => WT_PKLIST_INVOICE_ADDON_PLUGIN_URL.'public/modules/invoice/data/',
	),
	array(
		'id'=>'template_premium_3',
		'title'=>__('Premium Layout 3', 'wt_woocommerce_invoice_addon'),
		'preview_img'=>'template3.png',
		'version' => 'pro',
		'pro_template_path' => plugin_dir_path(__FILE__),
		'pro_template_url' => WT_PKLIST_INVOICE_ADDON_PLUGIN_URL.'public/modules/invoice/data/',
	),
);

$template_arr = array_merge($template_arr_pro, $template_arr);