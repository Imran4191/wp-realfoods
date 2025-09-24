<?php
/**
 * Plugin Name: Bwip Reports
 * Description: A plugin to generate various reports.
 * Version: 1.0
 * Author: BWIP Holdings LTD
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function create_sales_report_table() {
    global $wpdb;
    $table_name = $wpdb->base_prefix . 'bwip_sales_report'; // Global table

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        order_id bigint(20) NOT NULL,
        sku varchar(255) NOT NULL,
        custID bigint(20) NOT NULL,
        firstname varchar(255) NOT NULL,
        lastname varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        customer_group varchar(255) NOT NULL,
        subscription varchar(255),
        increment_id varchar(255) NOT NULL,
        status varchar(50) NOT NULL,
        date_ordered datetime NOT NULL,
        store varchar(50) NOT NULL,
        shipping_postcode varchar(20),
        shipping_city varchar(100),
        delivery_country varchar(100),
        address1 varchar(255),
        address2 varchar(255),
        address3 varchar(255),
        product_name varchar(255) NOT NULL,
        product_type varchar(50) NOT NULL,
        brand varchar(255),
        qty_ordered int(11) NOT NULL,
        payment_method varchar(255),
        coupon_code varchar(255),
        discount_amount decimal(10,2),
        order_subtotal decimal(10,2),
        shipping_amount decimal(10,2),
        tax_percentage decimal(10,2),
        tax_amount decimal(10,2),
        original_price decimal(10,2),
        price_paid decimal(10,2),
        item_subtotal decimal(10,2),
        row_total decimal(10,2),
        total_order decimal(10,2),
        invoice_id varchar(255),
        shipment_id varchar(255),
        unit_weight decimal(10,2),
        total_weight decimal(10,2),
        shipping_description varchar(255),
        tracking_number varchar(255),
        currency varchar(10),
        phone varchar(20),
        company varchar(255),
        magento_customer_id bigint(20),
        PRIMARY KEY (id),
        UNIQUE KEY unique_order_sku (order_id, sku)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'create_sales_report_table');


function salesbysku_cron_function() {
    salesbysku();
}
add_action('salesbysku_cron', 'salesbysku_cron_function');

function salesbysku() {
    $file_directory = ABSPATH . 'wp-content/reports/';
    if(!file_exists($file_directory)){
        mkdir($file_directory,0777,true);
    }
    $filename = 'RRF_Sales_By_SKU_Daily.csv';
    $fp = fopen($file_directory.$filename, 'w');
    fputcsv($fp, array('Day', 'Store', 'SKU', 'Name', 'Status', 'Qty Ordered'));
    
    global $wpdb;
    $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
    $store = [1=>'UK', 2=>'NZ', 3=>'AU', 4=>'EU'];
    for($i = 0; $i < 90; $i++){
        $start_date = date('Y-m-d 00:00:00', strtotime('-'.$i.' days'));
        $end_date = date('Y-m-d 23:59:59', strtotime('-'.$i.' days'));
        foreach ($blog_ids as $blog_id) {
            switch_to_blog($blog_id);
            $args = array(
                'status' => array('wc-completed'),
                'limit' => -1,
                'type' => 'shop_order',
                'date_created' => $start_date.'...'.$end_date
            );
            $orders = wc_get_orders($args);
            $csvitems = [];
            foreach ($orders as $order) {
                $items = $order->get_items();
                foreach ($items as $item) {
                    $product_id = $item->get_product_id();
                    if($product_id == 0) continue;
                    $product = wc_get_product($product_id);
                    $sku = $product->get_sku();
                    $qty = $item->get_quantity();
                    $order_item_name = $item->get_name();
                    $date = $order->get_date_created();
                    $date = $date->date('d-M-Y');
                    if(array_key_exists($sku, $csvitems)) {
                        $csvitems[$sku]['qty'] += $qty;
                    } else {
                        $csvitems[$sku] = ['sku'=>$sku, 'qty'=>$qty, 'name'=>$order_item_name, 'date'=>$date];
                    };
                }
            }
            
            foreach ($csvitems as $row) {
                fputcsv($fp, [$row['date'], $store[$blog_id], $row['sku'], $row['name'], 'Complete', $row['qty']]);
            }
            restore_current_blog();
        }
    }
    fclose($fp);
}

function salesbysku_monthly_cron_function() {
    salesbysku_monthly();
}
add_action('salesbysku_monthly_cron', 'salesbysku_monthly_cron_function');

function salesbysku_monthly() {
    $file_directory = ABSPATH . 'wp-content/reports/';
    if(!file_exists($file_directory)){
        mkdir($file_directory,0777,true);
    }
    $filename = 'RRF_Sales_By_SKU_Monthly.csv';
    $fp = fopen($file_directory.$filename, 'w');
    fputcsv($fp, array('Day', 'Store', 'SKU', 'Name', 'Status', 'Qty Ordered'));
    
    global $wpdb;
    $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
    $store = [1=>'UK', 2=>'NZ', 3=>'AU', 4=>'EU'];
    for($i = 0; $i < 25; $i++){
        $start_date = date('Y-m-01 00:00:00', strtotime(date('Y-m-01' )." -".$i." months"));
        $end_date = date('Y-m-t 23:59:59', strtotime(date('Y-m-01' )." -".$i." months"));
        foreach ($blog_ids as $blog_id) {
            switch_to_blog($blog_id);
            $args = array(
                'status' => array('wc-completed'),
                'limit' => -1,
                'type' => 'shop_order',
                'date_created' => $start_date.'...'.$end_date
            );
            $orders = wc_get_orders($args);
            $csvitems = [];
            foreach ($orders as $order) {
                $items = $order->get_items();
                foreach ($items as $item) {
                    $product_id = $item->get_product_id();
                    if($product_id == 0) continue;
                    $product = wc_get_product($product_id);
                    $sku = $product->get_sku();
                    $qty = $item->get_quantity();
                    $order_item_name = $item->get_name();
                    $date = $order->get_date_created();
                    $date = $date->date('M-Y');
                    if(array_key_exists($sku, $csvitems)) {
                        $csvitems[$sku]['qty'] += $qty;
                    } else {
                        $csvitems[$sku] = ['sku'=>$sku, 'qty'=>$qty, 'name'=>$order_item_name, 'date'=>$date];
                    };
                }
            }
            
            foreach ($csvitems as $row) {
                fputcsv($fp, [$row['date'], $store[$blog_id], $row['sku'], $row['name'], 'Complete', $row['qty']]);
            }
            restore_current_blog();
        }
    }
    fclose($fp);
}

function export_stock_uk_cron_function() {
    export_stock_uk();
}
add_action('export_stock_uk_cron', 'export_stock_uk_cron_function');

function export_stock_uk() {
    $file_directory = ABSPATH . 'wp-content/reports/';
    if(!file_exists($file_directory)){
        mkdir($file_directory,0777,true);
    }
    $filename = 'Magento Stock Report: RRF UK ('.date("Y_m_d", strtotime("-1 days")).').csv';
    $fp = fopen($file_directory.$filename, 'w');
    fputcsv($fp, array('name', 'sku', 'code', 'qty', 'available_qty', 'ship_qty', 'stock_status','product_status'));

    $pendingProcessingSkuWithQty = getPendingProcessingOrderSkuQtyForStockReport();

    $products = wc_get_products(array('limit' => -1));
    foreach ($products as $product) {
        $sku = $product->get_sku();
        $name = $product->get_name();
        $code = 'ukstore';
        if(isset($pendingProcessingSkuWithQty[$sku])){
            $ship_qty = $pendingProcessingSkuWithQty[$sku];
        } else {
            $ship_qty = 0;
        }
        $qty = $product->get_stock_quantity() + $ship_qty;
        $available_qty = $product->get_stock_quantity();
        $stock_status = $product->get_stock_status()=='instock' ? 1 : 0;
        $product_status = $product->get_status()=='publish'?'Enabled':'Disabled';
        fputcsv($fp, array($name, $sku, $code, $qty, $available_qty, $ship_qty, $stock_status, $product_status));
    }
    fclose($fp);

    $to = 'stockfile@bwipholdings.com';
    $subject = 'Magento Stock Report: RRF UK';
    $body = '<h1>Magento Stock Report: RRF UK</h1> <br/>PFA.';
    $headers = 'Content-Type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'CC: grant@bwipholdings.com' . "\r\n";
    
    $attachments = array($file_directory.$filename);
    wp_mail($to, $subject, $body, $headers, $attachments);
}

function export_stock_nz_cron_function() {
    export_stock_nz();
}
add_action('export_stock_nz_cron', 'export_stock_nz_cron_function');

function export_stock_nz() {
    $file_directory = ABSPATH . 'wp-content/reports/';
    if(!file_exists($file_directory)){
        mkdir($file_directory,0777,true);
    }
    $filename = 'Magento Stock Report: RRF NZ ('.date("Y_m_d", strtotime("-1 days")).').csv';
    $fp = fopen($file_directory.$filename, 'w');
    fputcsv($fp, array('name', 'sku', 'code', 'qty', 'available_qty', 'ship_qty', 'stock_status','product_status'));

    $pendingProcessingSkuWithQty = getPendingProcessingOrderSkuQtyForStockReport();

    $products = wc_get_products(array('limit' => -1));
    foreach ($products as $product) {
        $sku = $product->get_sku();
        $name = $product->get_name();
        $code = 'nzstore';
        if(isset($pendingProcessingSkuWithQty[$sku])){
            $ship_qty = $pendingProcessingSkuWithQty[$sku];
        } else {
            $ship_qty = 0;
        }
        $qty = $product->get_stock_quantity() + $ship_qty;
        $available_qty = $product->get_stock_quantity();
        $stock_status = $product->get_stock_status()=='instock' ? 1 : 0;
        $product_status = $product->get_status()=='publish'?'Enabled':'Disabled';
        fputcsv($fp, array($name, $sku, $code, $qty, $available_qty, $ship_qty, $stock_status, $product_status));
    }
    fclose($fp);

    $to = 'stockfile@bwipholdings.com';
    $subject = 'Magento Stock Report: RRF NZ';
    $body = '<h1>Magento Stock Report: RRF NZ</h1> <br/>PFA.';
    $headers = 'Content-Type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'CC: grant@bwipholdings.com' . "\r\n";
    
    $attachments = array($file_directory.$filename);
    wp_mail($to, $subject, $body, $headers, $attachments);
}

function export_stock_au_cron_function() {
    export_stock_au();
}
add_action('export_stock_au_cron', 'export_stock_au_cron_function');

function export_stock_au() {
    $file_directory = ABSPATH . 'wp-content/reports/';
    if(!file_exists($file_directory)){
        mkdir($file_directory,0777,true);
    }
    $filename = 'Magento Stock Report: RRF AU ('.date("Y_m_d", strtotime("-1 days")).').csv';
    $fp = fopen($file_directory.$filename, 'w');
    fputcsv($fp, array('name', 'sku', 'code', 'qty', 'available_qty', 'ship_qty', 'stock_status','product_status'));

    $pendingProcessingSkuWithQty = getPendingProcessingOrderSkuQtyForStockReport();

    $products = wc_get_products(array('limit' => -1));
    foreach ($products as $product) {
        $sku = $product->get_sku();
        $name = $product->get_name();
        $code = 'austore';
        if(isset($pendingProcessingSkuWithQty[$sku])){
            $ship_qty = $pendingProcessingSkuWithQty[$sku];
        } else {
            $ship_qty = 0;
        }
        $qty = $product->get_stock_quantity() + $ship_qty;
        $available_qty = $product->get_stock_quantity();
        $stock_status = $product->get_stock_status()=='instock' ? 1 : 0;
        $product_status = $product->get_status()=='publish'?'Enabled':'Disabled';
        fputcsv($fp, array($name, $sku, $code, $qty, $available_qty, $ship_qty, $stock_status, $product_status));
    }
    fclose($fp);

    $to = 'stockfile@bwipholdings.com';
    $subject = 'Magento Stock Report: RRF AU';
    $body = '<h1>Magento Stock Report: RRF AU</h1> <br/>PFA.';
    $headers = 'Content-Type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'CC: grant@bwipholdings.com' . "\r\n";
    
    $attachments = array($file_directory.$filename);
    wp_mail($to, $subject, $body, $headers, $attachments);
}

function export_stock_eu_cron_function() {
    export_stock_eu();
}
add_action('export_stock_eu_cron', 'export_stock_eu_cron_function');

function export_stock_eu() {
    $file_directory = ABSPATH . 'wp-content/reports/';
    if(!file_exists($file_directory)){
        mkdir($file_directory,0777,true);
    }
    $filename = 'Magento Stock Report: RRF EU ('.date("Y_m_d", strtotime("-1 days")).').csv';
    $fp = fopen($file_directory.$filename, 'w');
    fputcsv($fp, array('name', 'sku', 'code', 'qty', 'available_qty', 'ship_qty', 'stock_status','product_status'));

    $pendingProcessingSkuWithQty = getPendingProcessingOrderSkuQtyForStockReport();

    $products = wc_get_products(array('limit' => -1));
    foreach ($products as $product) {
        $sku = $product->get_sku();
        $name = $product->get_name();
        $code = 'eustore';
        if(isset($pendingProcessingSkuWithQty[$sku])){
            $ship_qty = $pendingProcessingSkuWithQty[$sku];
        } else {
            $ship_qty = 0;
        }
        $qty = $product->get_stock_quantity() + $ship_qty;
        $available_qty = $product->get_stock_quantity();
        $stock_status = $product->get_stock_status()=='instock' ? 1 : 0;
        $product_status = $product->get_status()=='publish'?'Enabled':'Disabled';
        fputcsv($fp, array($name, $sku, $code, $qty, $available_qty, $ship_qty, $stock_status, $product_status));
    }
    fclose($fp);

    $to = 'stockfile@bwipholdings.com';
    $subject = 'Magento Stock Report: RRF EU';
    $body = '<h1>Magento Stock Report: RRF EU</h1> <br/>PFA.';
    $headers = 'Content-Type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'CC: grant@bwipholdings.com' . "\r\n";
    
    $attachments = array($file_directory.$filename);
    wp_mail($to, $subject, $body, $headers, $attachments);
}

function export_stock_cron_function() {
    export_stock();
}
add_action('export_stock_cron', 'export_stock_cron_function');

function export_stock() {
    $file_directory = ABSPATH . 'wp-content/reports/';
    if(!file_exists($file_directory)){
        mkdir($file_directory,0777,true);
    }
    $filename = 'Magento Stock Report: RRF.csv';
    $fp = fopen($file_directory.$filename, 'w');
    fputcsv($fp, array('name', 'sku', 'type', 'brand', 'store', 'qty', 'available_qty', 'ship_qty', 'stock_status','product_status'));
    
    global $wpdb;
    $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
    $store = [1=>'UK', 2=>'NZ', 3=>'AU', 4=>'EU'];
    foreach ($blog_ids as $blog_id) {
        switch_to_blog($blog_id);

        $pendingProcessingSkuWithQty = getPendingProcessingOrderSkuQtyForStockReport();
        $products = wc_get_products(array('limit' => -1));
        foreach ($products as $product) {
            $sku = $product->get_sku();
            $name = $product->get_name();
            $type = $product->get_type();
            $brand = $product->get_attribute('manufacturer') ? $product->get_attribute('manufacturer') : '';
            $code = $store[$blog_id];
            if(isset($pendingProcessingSkuWithQty[$sku])){
                $ship_qty = $pendingProcessingSkuWithQty[$sku];
            } else {
                $ship_qty = 0;
            }
            $qty = $product->get_stock_quantity() + $ship_qty;
            $available_qty = $product->get_stock_quantity();
            $stock_status = $product->get_stock_status()=='instock' ? 1 : 0;
            $product_status = $product->get_status()=='publish'?'Enabled':'Disabled';
            fputcsv($fp, array($name, $sku, $type, $brand, $code, $qty, $available_qty, $ship_qty, $stock_status, $product_status));
        }
        restore_current_blog();
    }
    fclose($fp);
}

function export_linnworks_stock_cron_function() {
    export_linnworks_stock();
}
add_action('export_linnworks_stock_cron', 'export_linnworks_stock_cron_function');

function export_linnworks_stock() {
    global $wpdb;
    $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
    foreach ($blog_ids as $blog_id) {
        switch_to_blog($blog_id);

        if ($blog_id==1) {
            $file_directory = ABSPATH . 'wp-content/reports/lemonpath/';
            if(!file_exists($file_directory)){
                mkdir($file_directory,0777,true);
            }
            $filename = "rrfuk_stock_overview_linnworks.csv";
        } else if ($blog_id==2) {
            $file_directory = ABSPATH . 'wp-content/reports/scs/';
            if(!file_exists($file_directory)){
                mkdir($file_directory,0777,true);
            }
            $filename = "rrfnz_stock_overview_linnworks.csv";
        } else if ($blog_id==3) {
            $file_directory = ABSPATH . 'wp-content/reports/quantium/';
            if(!file_exists($file_directory)){
                mkdir($file_directory,0777,true);
            }
            $filename = "rrfau_stock_overview_linnworks.csv";
        } else if ($blog_id==4) {
            $file_directory = ABSPATH . 'wp-content/reports/tlogistics/';
            if(!file_exists($file_directory)){
                mkdir($file_directory,0777,true);
            }
            $filename = "rrfeu_stock_overview_linnworks.csv";
        }
        $fp = fopen($file_directory.$filename, 'w');
        fputcsv($fp, array('ARTICLE_NR', ' QUANTITY'));
        
        $products = wc_get_products(array('limit' => -1));
        foreach ($products as $product) {
            $sku = $product->get_sku();
            $qty = $product->get_stock_quantity();
            fputcsv($fp, array($sku, $qty));
        }
        fclose($fp);

        restore_current_blog();
    }
}

function export_salesperday_cron_function() {
    export_salesperday();
}
add_action('export_salesperday_cron', 'export_salesperday_cron_function');

function export_salesperday() {
    $store = [1=>'UK', 2=>'NZ', 3=>'AU', 4=>'EU'];
    $storeName = $store[get_current_blog_id()];
    $file_directory = ABSPATH . 'wp-content/reports/';
    if(!file_exists($file_directory)){
        mkdir($file_directory,0777,true);
    }
    if (((int) date('H', time())) < 13) {
        $filename =  "New Magento Order History Report: RRF ".$storeName." (".date("Y_m_d").")_1.csv";
    } else {
        $filename =  "New Magento Order History Report: RRF ".$storeName." (".date("Y_m_d", strtotime("-1 days")).")_2.csv";
    }
    $fp = fopen($file_directory.$filename, 'w');
    fputcsv($fp, array('custID','firstname','lastname','email','Customer Group','orders #','Status','date ordered','store','shipping Postcode','shipping City','delivery country','sku','product name','qty ordered','Payment Method','Coupon Code','Discount Ammount','Subtotal(Purchased)','Total shipping and Handling','Tax Percent','Tax Amount','Price Paid','Row Total','Total order','Invoices','Shipments','Unit Weight','Total Weight','Shipping Information','Tracking Numbers'));
    
    for($i = 0; $i < 30; $i++){
        if (((int) date('H', time())) < 13) {
            $fromDate = date("Y-m-d 00:00:00", strtotime("-".$i." days"));
            $toDate = date("Y-m-d 11:59:59", strtotime("-".$i." days"));
        } else {
            $fromDate = date("Y-m-d 12:00:00", strtotime("-".$i." days"));
            $toDate = date("Y-m-d 23:59:59", strtotime("-".$i." days"));
        }
        
        $orders = wc_get_orders(array(
            'type' => 'shop_order',
            'limit' => -1,
            'date_created' => $fromDate.'...'.$toDate
        ));

        foreach($orders as $order) {
            $invoiceIncrementID = '';
            $shipmentIncrementID = '';
            if($order->get_status()=='completed'){
                $invoiceIncrementID = $shipmentIncrementID = $order->get_order_number();
            } elseif($order->get_status()=='processing'){
                $invoiceIncrementID = $order->get_order_number();
            }

            $serialized_data = $order->get_meta('warehouse_data');
            $data = unserialize($serialized_data);
            $trackingNumber = isset($data['tracking_number']) ? $data['tracking_number'] : '';

            $payment = $order->get_payment_method_title();
            $customerId = $order->get_customer_id();
            $customerFirstname = $order->get_billing_first_name();
            $customerLastname = $order->get_billing_last_name();
            $customerEmail = $order->get_billing_email();
            $incrementId = $order->get_order_number();
            $status = $order->get_status();
            $date = date('Y-m-d H:i:s', strtotime($order->get_date_created()));
            $customer_group='Not Looged In';
            if($customerId!=0){
                $customer = get_userdata($customerId);
                $user_role = $customer->roles[0];
            } else {
                $user_role = 'Not Looged In';
            }
            if($user_role=='um_practitioner'){
                $customer_group='Practitioner';
            }elseif($user_role=='um_reseller'){
                $customer_group='Reseller';
            }elseif($user_role=='um_practitioner-client'){
                $customer_group='Practitioner Client';
            }elseif($user_role=='customer'){
                $customer_group='General';
            }elseif($user_role=='um_pensioner'){
                $customer_group='Pensioner';
            }elseif($user_role=='um_retail'){
                $customer_group='Retail';
            } else {
                if($customerId!=0){
                    $customer_group='Not Assigned';
                }
            }
            $deliveryCountry = $order->get_shipping_country();
            $totalOrder = round($order->get_total(), 2);
            $shippingPostcode = $order->get_shipping_postcode();
            $shippingCity = $order->get_shipping_city();
            if(count($order->get_coupon_codes())>0){
                $couponCode = $order->get_coupon_codes()[0];
            }else{
                $couponCode = '';
            }
            $discountAmount = $order->get_discount_total();
            $subtotal = $order->get_subtotal();
            $shippingAmount = $order->get_shipping_total();
            $shippingDescription = $order->get_shipping_method();

            $taxpercentage = '';
            foreach($order->get_items('tax') as $item_id => $item) {
                $tax_rate_id = $item->get_rate_id();
                $tax_percent = WC_Tax::get_rate_percent($tax_rate_id);
                $taxpercentage = str_replace('%', '', $tax_percent);
            }
            
            $items = $order->get_items();
            foreach ($items as $item) {
                $product = $item->get_product();
                $sku = $product->get_sku();
                $name = $product->get_name();
                $qtyOrdered = $item->get_quantity();
                $item_subtotal = round($item->get_subtotal(), 2);
                $taxAmount = round($item->get_total_tax(), 2);
                $rowTotal = $item_subtotal+$taxAmount;
                $pricePaid = round($item->get_total() / $item->get_quantity(), 2);
                $unitWeight = $product->get_weight();
                $totalWeight = $unitWeight * $qtyOrdered;

                fputcsv($fp, array(
                    $customerId,
                    $customerFirstname,
                    $customerLastname,
                    $customerEmail,
                    $customer_group,
                    $incrementId,
                    $status,
                    $date,
                    $storeName,
                    $shippingPostcode,
                    $shippingCity,
                    $deliveryCountry,
                    $sku,
                    $name,
                    $qtyOrdered,
                    $payment,
                    $couponCode,
                    $discountAmount,
                    $subtotal,
                    $shippingAmount,
                    $taxpercentage,
                    $taxAmount,
                    $pricePaid,
                    $rowTotal,
                    $totalOrder,
                    $invoiceIncrementID,
                    $shipmentIncrementID,
                    $unitWeight,
                    $totalWeight,
                    $shippingDescription,
                    $trackingNumber
                ));
            }
        }
    }

    $to = 'grant@bwipholdings.com';
    $subject = 'New Magento Order History Report: RRF '.$storeName;
    $body = '<h1>New Magento Order History Report: RRF '.$storeName.'</h1> <br/>PFA.';
    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    $attachments = array($file_directory.$filename);
    wp_mail($to, $subject, $body, $headers, $attachments);
}

function export_salesbysku_cron_function() {
    export_salesbysku();
}
add_action('export_salesbysku_cron', 'export_salesbysku_cron_function');

function export_salesbysku() {
    $store = [1=>'UK', 2=>'NZ', 3=>'AU', 4=>'EU'];
    $storeName = $store[get_current_blog_id()];
    $file_directory = ABSPATH . 'wp-content/reports/';
    if(!file_exists($file_directory)){
        mkdir($file_directory,0777,true);
    }
    $filename =  "Magento Order History Report: RRF ".$storeName." (".date("Y_m_d", strtotime("-1 days")).").csv";
    $fp = fopen($file_directory.$filename, 'w');
    fputcsv($fp, array('custID','firstname','lastname','email','orders #','Status','date ordered','store','delivery country','sku','product name','qty ordered','Price Paid','Row Total','Total order'));
    
    for($i = 0; $i < 40; $i++){
        $fromDate = date("Y-m-d 00:00:00", strtotime("-".$i." days"));
        $toDate = date("Y-m-d 23:59:59", strtotime("-".$i." days"));
        
        $orders = wc_get_orders(array(
            'type' => 'shop_order',
            'limit' => -1,
            'date_created' => $fromDate.'...'.$toDate
        ));

        foreach($orders as $order) {
            $customerId = $order->get_customer_id();
            $customerFirstname = $order->get_billing_first_name();
            $customerLastname = $order->get_billing_last_name();
            $customerEmail = $order->get_billing_email();
            $incrementId = $order->get_order_number();
            $status = $order->get_status();
            $date = date('Y-m-d H:i:s', strtotime($order->get_date_created()));
            $deliveryCountry = $order->get_shipping_country();
            $totalOrder = round($order->get_total(), 2);
            $items = $order->get_items();

            foreach ($items as $item) {
                $product = $item->get_product();
                $sku = $product->get_sku();
                $name = $product->get_name();
                $qtyOrdered = $item->get_quantity();
                $item_subtotal = round($item->get_subtotal(), 2);
                $taxAmount = round($item->get_total_tax(), 2);
                $rowTotal = $item_subtotal+$taxAmount;
                $pricePaid = round($item->get_total() / $item->get_quantity(), 2);

                fputcsv($fp, array(
                    $customerId,
                    $customerFirstname,
                    $customerLastname,
                    $customerEmail,
                    $incrementId,
                    $status,
                    $date,
                    $storeName,
                    $deliveryCountry,
                    $sku,
                    $name,
                    $qtyOrdered,
                    $pricePaid,
                    $rowTotal,
                    $totalOrder
                ));
            }
        }
    }

    $to = 'stockfile@bwipholdings.com';
    $subject = 'Magento Order History Report: RRF '.$storeName;
    $body = '<h1>Magento Order History Report: RRF '.$storeName.'</h1> <br/>PFA.';
    $headers = 'Content-Type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'CC: grant@bwipholdings.com' . "\r\n";
    
    $attachments = array($file_directory.$filename);
    wp_mail($to, $subject, $body, $headers, $attachments);
}

function export_salesbysku_all_cron_function() {
    export_salesbysku_all();
}
add_action('export_salesbysku_all_cron', 'export_salesbysku_all_cron_function');

function export_salesbysku_all() {
    $file_directory = ABSPATH . 'wp-content/reports/';
    if(!file_exists($file_directory)){
        mkdir($file_directory,0777,true);
    }
    $filename =  "RRF_Sales_By_Order.csv";
    $fp = fopen($file_directory.$filename, 'w');
    fputcsv($fp, array('custID','firstname','lastname','email','orders #','Status','date ordered','store','delivery country','sku','product name','qty ordered','Price Paid','Row Total','Total order'));
    
    global $wpdb;
    $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
    $store = [1=>'UK', 2=>'NZ', 3=>'AU', 4=>'EU'];

    for($i = 0; $i < 540; $i++){
        $fromDate = date("Y-m-d 00:00:00", strtotime("-".$i." days"));
        $toDate = date("Y-m-d 23:59:59", strtotime("-".$i." days"));
        foreach ($blog_ids as $blog_id) {
            switch_to_blog($blog_id);
            $storeName = $store[$blog_id];
            $orders = wc_get_orders(array(
                'type' => 'shop_order',
                'limit' => -1,
                'status' => 'completed',
                'date_created' => $fromDate.'...'.$toDate
            ));

            foreach($orders as $order) {
                $customerId = $order->get_customer_id();
                $customerFirstname = $order->get_billing_first_name();
                $customerLastname = $order->get_billing_last_name();
                $customerEmail = $order->get_billing_email();
                $incrementId = $order->get_order_number();
                $status = $order->get_status();
                $date = date('Y-m-d H:i:s', strtotime($order->get_date_created()));
                $deliveryCountry = $order->get_shipping_country();
                $totalOrder = round($order->get_total(), 2);
                $items = $order->get_items();

                foreach ($items as $item) {
                    $product = $item->get_product();
                    $sku = $product->get_sku();
                    $name = $product->get_name();
                    $qtyOrdered = $item->get_quantity();
                    $item_subtotal = round($item->get_subtotal(), 2);
                    $taxAmount = round($item->get_total_tax(), 2);
                    $rowTotal = $item_subtotal+$taxAmount;
                    $pricePaid = round($item->get_total() / $item->get_quantity(), 2);

                    fputcsv($fp, array(
                        $customerId,
                        $customerFirstname,
                        $customerLastname,
                        $customerEmail,
                        $incrementId,
                        $status,
                        $date,
                        $storeName,
                        $deliveryCountry,
                        $sku,
                        $name,
                        $qtyOrdered,
                        $pricePaid,
                        $rowTotal,
                        $totalOrder
                    ));
                }
            }
            restore_current_blog();
        }
    }
}

function export_salesreport_cron_function() {
    export_salesreport();
}
add_action('export_salesreport_cron', 'export_salesreport_cron_function');

function export_salesreport() {
    global $wpdb;
    $table_name = $wpdb->base_prefix . 'bwip_sales_report';

    $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
    $store = [1=>'UK', 2=>'NZ', 3=>'AU', 4=>'EU'];
    
    for($i = 0; $i < 15; $i++){
        $fromDate = date("Y-m-d 00:00:00", strtotime("-".$i." days"));
        $toDate = date("Y-m-d 23:59:59", strtotime("-".$i." days"));
        foreach ($blog_ids as $blog_id) {
            switch_to_blog($blog_id);
            $storeName = $store[$blog_id];
            $orders = wc_get_orders(array(
                'type' => 'shop_order',
                'limit' => -1,
                'date_created' => $fromDate.'...'.$toDate
            ));

            foreach($orders as $order) {
                $invoiceIncrementID = '';
                $shipmentIncrementID = '';
                if($order->get_status()=='completed'){
                    $invoiceIncrementID = $shipmentIncrementID = $order->get_order_number();
                } elseif($order->get_status()=='processing'){
                    $invoiceIncrementID = $order->get_order_number();
                }
                $subscription = '';

                $serialized_data = $order->get_meta('warehouse_data');
                $data = unserialize($serialized_data);
                $trackingNumber = isset($data['tracking_number']) ? $data['tracking_number'] : '';

                $payment = $order->get_payment_method_title();
                $customerId = $order->get_customer_id();
                $customerFirstname = $order->get_billing_first_name();
                $customerLastname = $order->get_billing_last_name();
                $customerEmail = $order->get_billing_email();
                $incrementId = $order->get_order_number();
                $status = $order->get_status();
                $date = date('Y-m-d H:i:s', strtotime($order->get_date_created()));
                $customer_group='Not Looged In';
                if($customerId!=0){
                    $customer = get_userdata($customerId);
                    $user_role = $customer->roles[0];
                } else {
                    $user_role = 'Not Looged In';
                }
                if($user_role=='um_practitioner'){
                    $customer_group='Practitioner';
                }elseif($user_role=='um_reseller'){
                    $customer_group='Reseller';
                }elseif($user_role=='um_practitioner-client'){
                    $customer_group='Practitioner Client';
                }elseif($user_role=='customer'){
                    $customer_group='General';
                }elseif($user_role=='um_pensioner'){
                    $customer_group='Pensioner';
                }elseif($user_role=='um_retail'){
                    $customer_group='Retail';
                } else {
                    if($customerId!=0){
                        $customer_group='Not Assigned';
                    }
                }
                $deliveryCountry = $order->get_shipping_country();
                $totalOrder = round($order->get_total(), 2);
                $shippingPostcode = $order->get_shipping_postcode();
                $shippingCity = $order->get_shipping_city();
                $address1 = $order->get_shipping_address_1();
                $address2 = $order->get_shipping_address_2();
                $address3 = '';
                if(count($order->get_coupon_codes())>0){
                    $couponCode = $order->get_coupon_codes()[0];
                }else{
                    $couponCode = '';
                }
                $discountAmount = $order->get_discount_total();
                $order_subtotal = round($order->get_subtotal(), 2);
                $shippingAmount = $order->get_shipping_total();
                $shippingDescription = $order->get_shipping_method();
                $currency = $order->get_currency();
                $phone = $order->get_billing_phone();
                $company = $order->get_billing_company();
                $magento_customer_id = get_user_meta($customerId, 'magento_customer_id', true);

                $taxpercentage = '';
                foreach($order->get_items('tax') as $item_id => $item) {
                    $tax_rate_id = $item->get_rate_id();
                    $tax_percent = WC_Tax::get_rate_percent($tax_rate_id);
                    $taxpercentage = str_replace('%', '', $tax_percent);
                }
                
                $items = $order->get_items();
                foreach ($items as $item) {
                    $product = $item->get_product();
                    $sku = $product->get_sku();
                    $name = $product->get_name();
                    $type = $product->get_type();
                    $originalPrice = $product->get_regular_price();
                    $brand = $product->get_attribute('manufacturer') ? $product->get_attribute('manufacturer') : '';
                    $qtyOrdered = $item->get_quantity();
                    $item_subtotal = round($item->get_subtotal(), 2);
                    $taxAmount = round($item->get_total_tax(), 2);
                    $rowTotal = $item_subtotal+$taxAmount;
                    $pricePaid = round($item->get_total() / $item->get_quantity(), 2);
                    $unitWeight = $product->get_weight();
                    $totalWeight = $unitWeight * $qtyOrdered;

                    $result = $wpdb->query($wpdb->prepare("
                        INSERT INTO $table_name (
                            order_id, custID, firstname, lastname, email, customer_group, subscription, 
                            increment_id, status, date_ordered, store, shipping_postcode, shipping_city, 
                            delivery_country, address1, address2, address3, sku, product_name, product_type, 
                            brand, qty_ordered, payment_method, coupon_code, discount_amount, order_subtotal, 
                            shipping_amount, tax_percentage, tax_amount, original_price, price_paid, item_subtotal, 
                            row_total, total_order, invoice_id, shipment_id, unit_weight, total_weight, 
                            shipping_description, tracking_number, currency, phone, company, magento_customer_id
                        ) VALUES (
                            %d, %d, %s, %s, %s, %s, %s, 
                            %s, %s, %s, %s, %s, %s, 
                            %s, %s, %s, %s, %s, %s, %s, 
                            %s, %d, %s, %s, %f, %f, 
                            %f, %f, %f, %f, %f, %f, 
                            %f, %f, %s, %s, %f, %f, 
                            %s, %s, %s, %s, %s, %d
                        ) ON DUPLICATE KEY UPDATE 
                            custID = VALUES(custID),
                            firstname = VALUES(firstname),
                            lastname = VALUES(lastname),
                            email = VALUES(email),
                            customer_group = VALUES(customer_group),
                            subscription = VALUES(subscription),
                            increment_id = VALUES(increment_id),
                            status = VALUES(status),
                            date_ordered = VALUES(date_ordered),
                            store = VALUES(store),
                            shipping_postcode = VALUES(shipping_postcode),
                            shipping_city = VALUES(shipping_city),
                            delivery_country = VALUES(delivery_country),
                            address1 = VALUES(address1),
                            address2 = VALUES(address2),
                            address3 = VALUES(address3),
                            sku = VALUES(sku),
                            product_name = VALUES(product_name),
                            product_type = VALUES(product_type),
                            brand = VALUES(brand),
                            qty_ordered = VALUES(qty_ordered),
                            payment_method = VALUES(payment_method),
                            coupon_code = VALUES(coupon_code),
                            discount_amount = VALUES(discount_amount),
                            order_subtotal = VALUES(order_subtotal),
                            shipping_amount = VALUES(shipping_amount),
                            tax_percentage = VALUES(tax_percentage),
                            tax_amount = VALUES(tax_amount),
                            original_price = VALUES(original_price),
                            price_paid = VALUES(price_paid),
                            item_subtotal = VALUES(item_subtotal),
                            row_total = VALUES(row_total),
                            total_order = VALUES(total_order),
                            invoice_id = VALUES(invoice_id),
                            shipment_id = VALUES(shipment_id),
                            unit_weight = VALUES(unit_weight),
                            total_weight = VALUES(total_weight),
                            shipping_description = VALUES(shipping_description),
                            tracking_number = VALUES(tracking_number),
                            currency = VALUES(currency),
                            phone = VALUES(phone),
                            company = VALUES(company),
                            magento_customer_id = VALUES(magento_customer_id)
                    ", 
                        $order->get_id(),
                        $customerId,
                        $customerFirstname,
                        $customerLastname,
                        $customerEmail,
                        $customer_group,
                        $subscription,
                        $incrementId,
                        $status,
                        $date,
                        $storeName,
                        $shippingPostcode,
                        $shippingCity,
                        $deliveryCountry,
                        $address1,
                        $address2,
                        $address3,
                        $sku,
                        $name,
                        $type,
                        $brand,
                        $qtyOrdered,
                        $payment,
                        $couponCode,
                        $discountAmount,
                        $order_subtotal,
                        $shippingAmount,
                        $taxpercentage,
                        $taxAmount,
                        $originalPrice,
                        $pricePaid,
                        $item_subtotal,
                        $rowTotal,
                        $totalOrder,
                        $invoiceIncrementID,
                        $shipmentIncrementID,
                        $unitWeight,
                        $totalWeight,
                        $shippingDescription,
                        $trackingNumber,
                        $currency,
                        $phone,
                        $company,
                        $magento_customer_id
                    ));

                    if ($result === false) {
                        error_log("Database insert failed: " . $wpdb->last_error);
                    }
                }
            }
            restore_current_blog();
        }
    }

    // Generate CSV
    $file_directory = ABSPATH . 'wp-content/reports/';
    if(!file_exists($file_directory)){
        mkdir($file_directory,0777,true);
    }
    $filename =  "New Magento Order History Report: RRF.csv";
    $fp = fopen($file_directory.$filename, 'w');

    $columns = array(
        'custID',
        'magento_customer_id',
        'firstname',
        'lastname',
        'email',
        'customer_group',
        'subscription',
        'increment_id',
        'status',
        'date_ordered',
        'store',
        'shipping_postcode',
        'shipping_city',
        'delivery_country',
        'address1',
        'address2',
        'address3',
        'sku',
        'product_name',
        'product_type',
        'brand',
        'qty_ordered',
        'payment_method',
        'coupon_code',
        'discount_amount',
        'order_subtotal',
        'shipping_amount',
        'tax_percentage',
        'tax_amount',
        'original_price',
        'price_paid',
        'item_subtotal',
        'row_total',
        'total_order',
        'invoice_id',
        'shipment_id',
        'unit_weight',
        'total_weight',
        'shipping_description',
        'tracking_number',
        'currency',
        'phone',
        'company'
    );

    fputcsv($fp, $columns);

    // Fetch data from the table
    $results = $wpdb->get_results("SELECT " . implode(', ', $columns) . " FROM $table_name", ARRAY_A);

    // Write each row to the CSV
    foreach ($results as $row) {
        fputcsv($fp, $row);
    }

    fclose($fp);
}

function export_finance_report_cron_function() {
    export_finance_report();
}
add_action('export_finance_report_cron', 'export_finance_report_cron_function');

function export_finance_report() {
    $file_directory = ABSPATH . 'wp-content/reports/';
    if(!file_exists($file_directory)){
        mkdir($file_directory,0777,true);
    }
    $filename =  "finance_report.csv";
    $fp = fopen($file_directory.$filename, 'w');
    fputcsv($fp, array('Contact Name','Invoice #','Reference','Invoice Date','Invoice Due Date','SKU','Description','Qty','Unit Price - GST inclusive', 'Order Status', 'Shipping Fee'));

    global $wpdb;
    $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
    $store = [1=>'UK', 2=>'NZ', 3=>'AU', 4=>'EU'];

    for($i = 0; $i < 7; $i++){
        $fromDate = date("Y-m-d 00:00:00", strtotime("-".$i." days"));
        $toDate = date("Y-m-d 23:59:59", strtotime("-".$i." days"));
        foreach ($blog_ids as $blog_id) {
            switch_to_blog($blog_id);
            $storeName = $store[$blog_id];
            $orders = wc_get_orders(array(
                'type' => 'shop_order',
                'limit' => -1,
                'date_created' => $fromDate.'...'.$toDate
            ));

            foreach($orders as $order) {
                $customerFirstname = $order->get_billing_first_name();
                $customerLastname = $order->get_billing_last_name();
                $customerEmail = $order->get_billing_email();
                $status = $order->get_status();
                $shippingAmount = $order->get_shipping_total() + $order->get_shipping_tax();
                if($order->get_status()=='completed' || $order->get_status()=='processing'){
                $invoiceId = $order->get_order_number();
                }
                $invoiceDate = '';
                $payment_date = $order->get_date_paid();
                if ( $payment_date ) {
                $invoiceDate = $payment_date->date('Y-m-d H:i:s');
                }
                $reference = $order->get_meta('_transaction_id');
                $items = $order->get_items();

                foreach ($items as $item) {
                    $product = $item->get_product();
                    $sku = $product->get_sku();
                    $name = $product->get_name();
                    $qtyOrdered = $item->get_quantity();
                    $item_subtotal = $item->get_subtotal();
                    $taxAmount = $item->get_subtotal_tax();
                    $rowTotal = $item_subtotal+$taxAmount;
                    $pricePaid = round($rowTotal / $item->get_quantity(), 2);

                    fputcsv($fp, array(
                        $customerFirstname.' '.$customerLastname,
                        $invoiceId,
                        $reference,
                        $invoiceDate,
                        $invoiceDate,
                        $sku,
                        $name,
                        $qtyOrdered,
                        $pricePaid,
                        $status,
                        $shippingAmount
                    ));
                }
            }
            restore_current_blog();
        }
    }
}

function getPendingProcessingOrderSkuQtyForStockReport(){
    $processingOrderIdsInSystem = [];
    $args = array(
        'status' => array('processing', 'pending', 'on-hold'),
        'limit' => -1,
    );
    $pendingProcessingOrdersCollection = wc_get_orders($args);

    $pendingProcessingSkuWithQty = [];

    foreach ($pendingProcessingOrdersCollection as $currentOrder) {
        $orderedItems = $currentOrder->get_items();
        foreach ($orderedItems as $orderedItem) {
            $product = $orderedItem->get_product();
            if($product && $product->get_type() == 'simple'){
                if(isset($pendingProcessingSkuWithQty[$product->get_sku()])){
                    $pendingProcessingSkuWithQty[$product->get_sku()] += (int)$orderedItem->get_quantity();
                }else{
                    $pendingProcessingSkuWithQty[$product->get_sku()] = (int)$orderedItem->get_quantity();
                }
            }
        }
    }

    return $pendingProcessingSkuWithQty;
}

function woo_oos_products_report_cron_function() {
    woo_oos_products_report();
}
add_action('woo_oos_products_report_cron', 'woo_oos_products_report_cron_function');

function woo_oos_products_report() {
    $file_directory = ABSPATH . 'wp-content/reports/';
    if(!file_exists($file_directory)){
        mkdir($file_directory,0777,true);
    }
    $filename = 'RRF_Woo_OOS_Products_Report.csv';
    $fp = fopen($file_directory.$filename, 'w');
    $csv_headers = array(
        'SKU',
        'Product Name',
        'Store',
    );
    fputcsv($fp, $csv_headers);

    $subscriber_filename = 'RRF_Woo_OOS_Subscriber_Report.csv';
    $subscriber_fp = fopen($file_directory.$subscriber_filename, 'w');
    $subscriber_csv_headers = array(
        'SKU',
        'Product Name',
        'Subscriber Email',
        'Store',
    );
    fputcsv($subscriber_fp, $subscriber_csv_headers);
    
    global $wpdb;
    $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
    $store = [1=>'UK', 2=>'NZ', 3=>'AU', 4=>'EU'];

    foreach ($blog_ids as $blog_id) {
        switch_to_blog($blog_id);

        // Fetch out-of-stock products
        $products = wc_get_products([
            'status'       => 'publish',
            'limit'        => -1,
            'stock_status' => 'outofstock',
            'return'       => 'objects',
        ]);

        foreach ($products as $product) {
            fputcsv($fp, [
                $product->get_sku(),
                $product->get_name(),
                $store[$blog_id],
            ]);

            $main_obj = new CWG_Instock_API( $product->get_id(), 0 );
            $get_list_of_subscribers = $main_obj->get_list_of_subscribers();

            if ( is_array( $get_list_of_subscribers ) && ! empty( $get_list_of_subscribers ) ) {
                foreach ( $get_list_of_subscribers as $post_id ) {
                    $get_email = get_post_meta( $post_id, 'cwginstock_subscriber_email', true );
                    fputcsv($subscriber_fp, [
                        $product->get_sku(),
                        $product->get_name(),
                        $get_email,
                        $store[$blog_id],
                    ]);
                }
            }
        }

        restore_current_blog();
    }

    fclose($fp);
    fclose($subscriber_fp);
}

function woo_product_report_cron_function() {
    woo_product_report();
}
add_action('woo_product_report_cron', 'woo_product_report_cron_function');

function woo_product_report() {
    $file_directory = ABSPATH . 'wp-content/reports/';
    if(!file_exists($file_directory)){
        mkdir($file_directory,0777,true);
    }
    $filename = 'RRF_Woo_Product_Report.csv';
    $fp = fopen($file_directory.$filename, 'w');
    $csv_headers = array(
        'SKU',
        'Product Name',
        'Max Limit',
        'Min Limit',
        'Stock Update',
        'Status',
        'Store',
    );
    fputcsv($fp, $csv_headers);
    
    global $wpdb;
    $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
    $store = [1=>'UK', 2=>'NZ', 3=>'AU', 4=>'EU'];

    foreach ($blog_ids as $blog_id) {
        switch_to_blog($blog_id);

        $products = wc_get_products([
            'status'       => 'publish',
            'limit'        => -1,
            'return'       => 'objects',
        ]);

        foreach ($products as $product) {
            fputcsv($fp, [
                $product->get_sku(),
                $product->get_name(),
                get_post_meta($product->get_id(), 'max_quantity', true),
                get_post_meta($product->get_id(), 'min_quantity', true),
                get_post_meta($product->get_id(), 'manage_stock_update', true) ? 'Disabled' : 'Enabled',
                $product->get_stock_status(),
                $store[$blog_id],
            ]);
        }

        restore_current_blog();
    }

    fclose($fp);
}
