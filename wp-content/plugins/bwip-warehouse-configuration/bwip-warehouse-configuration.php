<?php
/**
 * Plugin Name: Bwip Warehouse Configuration
 * Description: A plugin to create connection with warehouse to send order, receive order response and receive stock update.
 * Version: 1.0
 * Author: BWIP Holdings LTD
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action('admin_menu', 'warehouse_configuration_menu');
function warehouse_configuration_menu() {
    add_menu_page(
        'Warehouse Order', // Page title
        'Warehouse Grid', // Menu title
        'manage_options', // Capability
        'warehouse-order-grid', // Menu slug
        'display_warehouse_order_grid', // Function to display the dashboard
        'dashicons-admin-generic', // Icon URL (optional)
        6 // Position (optional)
    );
    add_options_page(
        'Warehouse Configuration', // page_title
        'Warehouse Configuration', // menu title
        'manage_options', // capability
        'warehouse_configuration', // options page slug
        'warehouse_configuration_page' // callback function
    );
    add_options_page(
        'Add Tracking', // page_title
        'Add Tracking', // menu title
        'manage_options', // capability
        'add_tracking', // options page slug
        'add_tracking' // callback function
    );
}

// Add manage stock option to product
add_action('woocommerce_product_options_stock_status', 'add_manage_stock_update_option');
function add_manage_stock_update_option() {
    global $post;
    $manage_stock_update = get_post_meta($post->ID, 'manage_stock_update', true);
    ?>
    <p class="form-field">
        <label for="manage_stock_update">Disable Stock Update</label>
        <input type="checkbox" name="manage_stock_update" id="manage_stock_update" value="1" <?php checked($manage_stock_update, 1); ?>>
        <span class="description">Disable stock update for this product</span>
    </p>
    <?php
}

// Save manage stock option
add_action('woocommerce_process_product_meta', 'save_manage_stock_update_option');
function save_manage_stock_update_option($post_id) {
    $manage_stock_update = isset($_POST['manage_stock_update']) ? 1 : 0;
    update_post_meta($post_id, 'manage_stock_update', $manage_stock_update);
}

// Function to add tracking to order using order number
function add_tracking() {
    if (isset($_POST['submit'])) {
        $order_number = isset($_POST['order_number']) ? sanitize_text_field($_POST['order_number']) : '';
        $currentOrderTrackingNumber = isset($_POST['tracking_number']) ? sanitize_text_field($_POST['tracking_number']) : '';
        $currentOrderTrackingLink = isset($_POST['tracking_link']) ? sanitize_text_field($_POST['tracking_link']) : '';
        
        $instance = new WT_Advanced_Order_Number();
        $order_id = $instance->wt_order_id_from_order_number($order_number);
        $currentOrder = wc_get_order($order_id);
        if (!$currentOrder) {
            wp_redirect(admin_url('options-general.php?page=add_tracking&error=404'));
            exit;
        }
        $order_status = $currentOrder->get_status();
        if ($order_status == 'completed') {
            wp_redirect(admin_url('options-general.php?page=add_tracking&error=100'));
            exit;
        } else if ($order_status != 'processing') {
            wp_redirect(admin_url('options-general.php?page=add_tracking&error=400'));
            exit;
        }
        $warehouse_data = unserialize($currentOrder->get_meta('warehouse_data'));

        if (get_current_blog_id()==1) {
            $new_warehouse_data = array(
                'filename' => $warehouse_data['filename'],
                'warehouse_name' => 'uk_warehouse',
                'order_sent' => 1,
                'created_at' => $warehouse_data['created_at'],
                'tracking_number' => $currentOrderTrackingNumber,
                'response_from_warehouse' => $currentOrderTrackingLink
            );
            $currentOrder->update_meta_data('warehouse_data', serialize($new_warehouse_data));
            $currentOrder->update_meta_data('_tracking_number', $currentOrderTrackingNumber);
            $currentOrder->update_status('completed');
            $currentOrder->save();
        } else if (get_current_blog_id()==2) {
            $new_warehouse_data = array(
                'filename' => $warehouse_data['filename'],
                'warehouse_name' => 'nz_warehouse',
                'order_sent' => 1,
                'created_at' => $warehouse_data['created_at'],
                'tracking_number' => $currentOrderTrackingNumber
            );
            $currentOrder->update_meta_data('warehouse_data', serialize($new_warehouse_data));
            $currentOrder->update_meta_data('_tracking_number', $currentOrderTrackingNumber);
            $currentOrder->update_status('completed');
            $currentOrder->save();
        } else if (get_current_blog_id()==3) {
            $responseData = '<ORDER_NR>'.$orderId.'</ORDER_NR>
                            <TRACKTRACE_NR>'.$currentOrderTrackingNumber.'</TRACKTRACE_NR>
                            <TRACKTRACE_URL>'.$currentOrderTrackingLink.'</TRACKTRACE_URL>';
            $new_warehouse_data = array(
                'filename' => $warehouse_data['filename'],
                'warehouse_name' => 'au_warehouse',
                'order_sent' => 1,
                'created_at' => $warehouse_data['created_at'],
                'tracking_number' => $currentOrderTrackingNumber,
                'response_from_warehouse' => $currentOrderTrackingLink,
                'response_filename' => $orderId,
                'response_file_content' => $responseData,
            );
            $currentOrder->update_meta_data('warehouse_data', serialize($new_warehouse_data));
            $currentOrder->update_meta_data('_tracking_number', $currentOrderTrackingNumber);
            $currentOrder->update_status('completed');
            $currentOrder->save();
        } else if (get_current_blog_id()==4) {
            $new_warehouse_data = array(
                'filename' => $warehouse_data['filename'],
                'warehouse_name' => 'eu_warehouse',
                'order_sent' => 1,
                'created_at' => $warehouse_data['created_at'],
                'tracking_number' => $currentOrderTrackingNumber
            );
            $currentOrder->update_meta_data('warehouse_data', serialize($new_warehouse_data));
            $currentOrder->update_meta_data('_tracking_number', $currentOrderTrackingNumber);
            $currentOrder->update_status('completed');
            $currentOrder->save();
        }
        wp_redirect(admin_url('options-general.php?page=add_tracking&success=1'));
        exit;
    }
    ?>
    <style>
        .wrap {
            margin: 20px;
        }
        h4 {
            font-size: 20px;
        }
        .container {
            display: flex;
            flex-direction: column;
        }
        .row {
            display: flex;
            flex-direction: row;
            margin-bottom: 10px;
            align-items: center;
        }
        label {
            margin-right: 10px;
            width: 150px;
        }
    </style>
    <div class="wrap">
        <h4>Add Tracking Details</h4>
        <?php if($_GET['error']) : ?>
            <?php if($_GET['error']==404) : ?>
                <div class="notice notice-error is-dismissible"><p>Order not found.</p></div>
            <?php elseif($_GET['error']==100) : ?>
                <div class="notice notice-error is-dismissible"><p>Order already completed.</p></div>
            <?php elseif($_GET['error']==400) : ?>
                <div class="notice notice-error is-dismissible"><p>Order not in processing state.</p></div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if($_GET['success'] && $_GET['success']=1) : ?>
            <div class="notice notice-success is-dismissible"><p>Tracking number added successfully.</p></div>
        <?php endif; ?>
        <form method="post">
            <div class="container">
                <div class="row">
                    <label for="order_number">Order Number*:</label>
                    <input type="text" name="order_number" id="order_number" required>
                </div>
                <br>
                <div class="row">
                    <label for="tracking_number">Tracking Number*:</label>
                    <input type="text" name="tracking_number" id="tracking_number" required>
                </div>
                <br>
                <div class="row">
                    <label for="tracking_link">Tracking Link:</label>
                    <input type="text" name="tracking_link" id="tracking_link">
                </div>
                <br>
                <div class="row">
                    <input type="submit" name="submit" value="Submit">
                </div>
            </div>
        </form>
    </div>
    <?php
}

// Function to display warehouse order grid
function display_warehouse_order_grid() {
    $order_id = isset($_GET['order_id']) ? sanitize_text_field($_GET['order_id']) : null;
    if ($order_id) { 
        $order = wc_get_order($order_id);
        $serialized_data = $order->get_meta('warehouse_data');
        $data = unserialize($serialized_data);
        $warehouse_name = ['au_warehouse' => __('Quantium'),'eu_warehouse' => __('T-Logistics'),'nz_warehouse' => __('Supply Chain Solutions'),'uk_warehouse' => __('CCL Logistics')];
    ?>
        <div class="wrap">
            <div id="warehouse-order" class="warehouse-order-grid">
                <h1>Warehouse Order View</h1>
                <div class="approved">
                    <h1>Warehouse Information</h1>
                    <br>
                    <br>
                    <div>
                        <strong>Order ID:</strong>
                        <span><?php echo esc_html($order->get_order_number()); ?></span>
                    </div>
                    <br>
                    <div>
                        <strong>Filename:</strong>
                        <span><?php echo isset($data['filename']) ? esc_html($data['filename']) : ''; ?></span>
                    </div>
                    <br>
                    <div>
                        <strong>Warehouse Name:</strong>
                        <span><?php echo isset($data['warehouse_name']) ? esc_html($warehouse_name[$data['warehouse_name']]) : ''; ?></span>
                    </div>
                    <br>
                    <div>
                        <strong>Created At:</strong>
                        <span><?php echo isset($data['created_at']) ? $data['created_at'] : ''; ?></span>
                    </div>
                    <br>
                    <div>
                        <strong>Tracking Number:</strong>
                        <span><?php echo isset($data['tracking_number']) ? $data['tracking_number'] : ''; ?></span>
                    </div>
                    <br>
                    <div>
                        <strong>Response:</strong>
                        <?php if(isset($data['response_from_warehouse'])) : ?>
                            <textarea rows="35" cols="70"><?php echo $data['response_from_warehouse']; ?></textarea>
                        <?php else : ?>
                            <span>Pending - No response from warehouse for this order yet.</span>
                        <?php endif; ?>
                    </div>
                    <?php if (get_current_blog_id()==1 || get_current_blog_id()==3) : ?>
                    <br>
                    <div>
                        <strong>Response Filename:</strong>
                        <span><?php echo isset($data['response_filename']) ? $data['response_filename'] : 'Pending - No response from warehouse for this order yet.' ?></span>
                    </div>
                    <br>
                    <div>
                        <strong>Response File Content:</strong>
                        <?php if(isset($data['response_file_content'])) : ?>
                            <textarea rows="35" cols="70"><?php echo $data['response_file_content']; ?></textarea>
                        <?php else : ?>
                            <span>Pending - No response from warehouse for this order yet.</span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php } else {
        $warehouse_name = ['au_warehouse' => __('Quantium'),'eu_warehouse' => __('T-Logistics'),'nz_warehouse' => __('Supply Chain Solutions'),'uk_warehouse' => __('CCL Logistics')];
        $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
        $orders_per_page = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

        $args = array(
            'meta_key'    => 'warehouse_data',
            'meta_value'  => '',
            'compare'     => '!=',
            'limit'       => $orders_per_page,
            'paged'       => $paged,
        );

        $warehouse_orders = wc_get_orders($args);
        $total_orders = wc_get_orders(array_merge($args, ['limit' => -1, 'paged' => 1]));
        $total_pages = ceil(count($total_orders) / $orders_per_page);
    ?>
    <div class="wrap">
        <div id="warehouse-order" class="warehouse-order-grid">
            <h1>Warehouse Order</h1>
            <div class="approved">
                <h1>Warehouse Order Grid</h1>
                <form method="get" action="" style="text-align: right; margin-bottom: 20px; font-size: 14px;">
                    <input type="hidden" name="page" value="warehouse-order-grid">
                    <label for="limit">Orders per page:</label>
                    <select name="limit" id="limit" onchange="this.form.submit()">
                        <option value="10" <?php selected( $orders_per_page, 10 ); ?>>10</option>
                        <option value="20" <?php selected( $orders_per_page, 20 ); ?>>20</option>
                        <option value="50" <?php selected( $orders_per_page, 50 ); ?>>50</option>
                        <option value="100" <?php selected( $orders_per_page, 100 ); ?>>100</option>
                    </select>
                </form>
                <table class="wp-list-table widefat fixed striped table-view-list payment-report">
                    <tr>
                        <th>Order ID</th>
                        <th>Filename</th>
                        <th>Warehouse Name</th>
                        <th>Tracking Number</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($warehouse_orders as $order) : ?>
                        <?php
                            $currentOrder = wc_get_order($order->get_id());
                            $serialized_data = $currentOrder->get_meta('warehouse_data');
                            $data = unserialize($serialized_data);
                            $filename = isset($data['filename']) ? $data['filename'] : '';
                            $warehouse = isset($data['warehouse_name']) ? $warehouse_name[$data['warehouse_name']] : '';
                            $tracking_number = isset($data['tracking_number']) ? $data['tracking_number'] : '';
                            $created_at = isset($data['created_at']) ? $data['created_at'] : '';
                        ?>
                        <tr>
                            <td><?php echo esc_html($currentOrder->get_order_number()); ?></td>
                            <td><?php echo esc_html($filename); ?></td>
                            <td><?php echo esc_html($warehouse); ?></td>
                            <td><?php echo esc_html($tracking_number); ?></td>
                            <td><?php echo esc_html($created_at); ?></td>
                            <td><a href="<?php echo admin_url('admin.php') . '?page=warehouse-order-grid&order_id='.$order->get_id(); ?>">View</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <div class="tablenav">
                    <?php
                    echo paginate_links(array(
                        'base'    => add_query_arg('paged', '%#%'),
                        'format'  => '',
                        'current' => max(1, $paged),
                        'total'   => $total_pages,
                    ));
                    ?>
                </div>
                <style>
                    .tablenav {
                        margin-top: 30px;
                        text-align: center;
                    }
                    .page-numbers {
                        font-size: 14px;
                        padding: 10px 15px;
                        background: #fff;
                        color: #000;
                        margin: 0 5px;
                        text-decoration: none;
                    }
                    .page-numbers.current {
                        background: #ccc;
                    }
                    a.page-numbers:hover {
                        text-decoration: underline;
                    }
                </style>
            </div>
        </div>
    </div>
<?php }
}

if (get_current_blog_id()==3) {
    add_action('rest_api_init', function () {
        register_rest_route('v1', '/bwip/auwarehouse', array(
            'methods' => 'POST',
            'callback' => 'ship_confirm_callback',
            'permission_callback' => '__return_true',
        ));
    });

    function ship_confirm_callback(WP_REST_Request $request) {
        $log_file_path = ABSPATH . 'logs/getorderresponse-AU.log';
        $log_data = ['Date and Time of Execution is : '.date("Y-m-d H:i:s")];
        $log_data[] = 'Checking order response from '.$store.' Warehouse';
        $log_data[] = '';
        file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
        $log_data = array();

        $headers = $request->get_headers();
        if (isset($headers['authorization'][0])) {
            $token = $headers['authorization'][0];
        } else if (isset($headers['Authorization'][0])) {
            $token = $headers['Authorization'][0];
        } else {
            $token = '';
        }

        $token = explode(' ', $token);
        if ($token[1] != get_option('woo_access_key')) {
            return new WP_REST_Response(array(
                'Status' => 'Access Denied',
            ), 200);
        }
        $log_data[] = 'Authorized';

        $postData = file_get_contents('php://input');
        $xml=simplexml_load_string($postData);
        $log_data[] = $postData;
        foreach ($xml->ConfirmationHeader as $currentOrder) {
            $currentOrderArr = (array)$currentOrder;
            $orderId = isset($currentOrderArr['OrderID']) ? $currentOrderArr['OrderID'] : '';
            $currentOrderTrackingLink = isset($currentOrderArr['TrackingURL']) ? $currentOrderArr['TrackingURL'] : '';
        }
        foreach ($xml->ConfirmationDetail->ShipmentDetail->ShipmentLine as $confirmationDetail) {
            $confirmationDetailArr = (array)$confirmationDetail;
            $currentOrderTrackingNumber = isset($confirmationDetailArr['TrackingNumber']) ? $confirmationDetailArr['TrackingNumber'] : '';
        }

        try {
            $processingOrderIdsInSystem = [];
            $args = array(
                'status' => 'processing',
                'limit' => -1,
            );
            $processingOrders = wc_get_orders($args);
            foreach ($processingOrders as $_currentOrder) {
                $processingOrderIdsInSystem[] = $_currentOrder->get_order_number();
            }

            if(in_array($orderId, $processingOrderIdsInSystem)){
                if($currentOrderTrackingNumber != ''){
                    $log_data[] = "Current Order ID => #".$orderId;
                    $log_data[] = "Current Order Tracking Number => ".$currentOrderTrackingNumber;
                    $log_data[] = "Current Order Tracking Link => ".$currentOrderTrackingLink;

                    $instance = new WT_Advanced_Order_Number();
                    $order_id = $instance->wt_order_id_from_order_number($orderId);
                    $currentOrder = wc_get_order($order_id);

                    $responseData = '<ORDER_NR>'.$orderId.'</ORDER_NR>
                                        <TRACKTRACE_NR>'.$currentOrderTrackingNumber.'</TRACKTRACE_NR>
                                        <TRACKTRACE_URL>'.$currentOrderTrackingLink.'</TRACKTRACE_URL>';
                    $warehouse_data = unserialize($currentOrder->get_meta('warehouse_data'));
                    $new_warehouse_data = array(
                        'filename' => $warehouse_data['filename'],
                        'warehouse_name' => 'au_warehouse',
                        'order_sent' => 1,
                        'created_at' => $warehouse_data['created_at'],
                        'tracking_number' => $currentOrderTrackingNumber,
                        'response_from_warehouse' => $currentOrderTrackingLink,
                        'response_filename' => $orderId,
                        'response_file_content' => $responseData,
                    );
                    $currentOrder->update_meta_data('warehouse_data', serialize($new_warehouse_data));
                    $currentOrder->update_meta_data('_tracking_number', $currentOrderTrackingNumber);
                    $currentOrder->update_status('completed');
                    $currentOrder->save();

                    $log_data[] = "Shipment created successfully for Order #".$orderId." and is complete now. Tracking number is => ".$currentOrderTrackingNumber." and Tracking link is ".$currentOrderTrackingLink;

                    $info[] = array('Status' => 'Success', 'Message' => 'Order '.$orderId.' Successfully updated');
                }
            } else {
                $info[] = array('Status' => 'Failed', "Error" => 'Order Not Found');
            }
        } catch (Exception $e) {
            $log_data[] = $e->getMessage();
            $info[] = array('Status' => 'Failed', "Error" => $e->getMessage());
        }
        
        $log_data[] = '';
        file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
        return new WP_REST_Response($info, 200);
    }

    add_action('woocommerce_after_product_object_save', 'send_product_to_warehouse', 10, 1);

    function send_product_to_warehouse($product) {
        $log_file_path = ABSPATH . 'logs/product-sync.log';
        $log_data[] = 'Product creating or updating';
        static $saved_products = [];

        // Add the product ID to the list if it's not already there
        if ($product->get_sku() && !in_array($product->get_id(), $saved_products)) {
            $saved_products[] = $product->get_id();

            // Register shutdown action to log SKU only once after all save actions are done
            add_action('shutdown', function() use ($product) {
                $log_file_path = ABSPATH . 'logs/product-sync.log';
                $log_data[] = 'Product sync initiated';
                $sku = $product->get_sku();
                if ($product->get_date_created() && $product->get_date_created()->date('Y-m-d H:i:s') === $product->get_date_modified()->date('Y-m-d H:i:s')) {
                    $log_data[] = 'Product with SKU '.$sku.' is being created.';
                    $transaction_type = 'NEW';
                } else {
                    $log_data[] = 'Product with SKU '.$sku.' is being updated.';
                    $transaction_type = 'UPDATE';
                }

                $xml_data = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                <Product>
                    <TransactionType>'.$transaction_type.'</TransactionType>
                    <ProductHeader>
                        <SKU>'.$sku.'</SKU>
                        <ProductName>'.$product->get_name().'</ProductName>
                        <MerchantID>AGT</MerchantID>
                        <WarehouseID>QSAUSF</WarehouseID>
                    </ProductHeader>
                    <ProductDetail>
                        <AlternateSKU>'.$sku.'</AlternateSKU>
                        <UPC/>
                        <ShelfLifeInDays>90</ShelfLifeInDays>
                        <CycleCountFrequencyInDays>30</CycleCountFrequencyInDays>
                        <LotControl>F</LotControl>
                        <InventoryControl>FEFO</InventoryControl>
                        <TemperatureControl>Room</TemperatureControl>
                        <ExpirationDateControl>Y</ExpirationDateControl>
                        <InspectionFlag>N</InspectionFlag>
                        <InboundShelfLifeInDays>180</InboundShelfLifeInDays>
                        <Dimensions>
                            <Length>1</Length>
                            <Width>1</Width>
                            <Height>1</Height>
                            <Weight>1</Weight>
                        </Dimensions>
                        <UNCode/>
                        <Attribute5>Y</Attribute5>
                    </ProductDetail>
                    <UOMDetail>
                        <UOM>
                            <UnitUOM>EA</UnitUOM>
                            <Length>1</Length>
                            <Width>1</Width>
                            <Height>1</Height>
                            <Weight>1</Weight>
                            <GrossWeight>1</GrossWeight>
                            <ConversionFactor>1</ConversionFactor>
                        </UOM>
                    </UOMDetail>
                </Product>';

                /*API data mapping*/
                $headers = array(
                    "Authorization: ".get_option('quantium_access_key'),
                    "Content-Type: application/xml",
                );
                
                $requestUrl=get_option('product_sync_url');

                $xmlRequest = $xml_data;

                $ch = curl_init($requestUrl);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlRequest);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result = curl_exec($ch);

                $resultArr = simplexml_load_string($result);
                foreach ($resultArr->Response as $response) {
                    $responseArr = (array)$response;
                    $responseCode = $responseArr['ResponseCode'];
                    $responseStatus = $responseArr['Status'];
                }

                if ($responseCode=='Success') {
                    $log_data[] = 'Product "'.$product->get_name().' - '.$product->get_sku().'" Synced To Warehouse';
                } else {
                    $log_data[] = 'Product "'.$product->get_name().' - '.$product->get_sku().'"  Couldn\'t Synced To Warehouse';
                    $log_data[] = $result;
                    $log_data[] = $xmlRequest;
                }
                $log_data[] = '';
                file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
            });
        }
        $log_data[] = '';
        file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
    }
}

function warehouse_configuration_page() { ?>
    <div class="wrap">
        <h1>Warehouse Configuration</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('warehouse-configuration-field'); // warehouse-configuration-field is the register_setting option group
                do_settings_sections('warehouse_configuration'); // warehouse_configuration is options page slug
                submit_button();
            ?>
        </form>
    </div>
<?php }

add_action('admin_init', 'warehouse_configuration_page_init');

function warehouse_configuration_page_init() {
    // Register a new setting for "warehouse_configuration" page
    // First parameter 'warehouse-configuration-field' is a group name (used in settings_fields function call)
    register_setting('warehouse-configuration-field', 'exception_email');
    register_setting('warehouse-configuration-field', 'hostname');
    register_setting('warehouse-configuration-field', 'port');
    register_setting('warehouse-configuration-field', 'username');
    register_setting('warehouse-configuration-field', 'password');
    register_setting('warehouse-configuration-field', 'dispatch_path');
    register_setting('warehouse-configuration-field', 'order_response');
    register_setting('warehouse-configuration-field', 'stock_path');
    register_setting('warehouse-configuration-field', 'tracking_link');
    register_setting('warehouse-configuration-field', 'tracking_hostname');
    register_setting('warehouse-configuration-field', 'tracking_port');
    register_setting('warehouse-configuration-field', 'tracking_username');
    register_setting('warehouse-configuration-field', 'tracking_password');
    register_setting('warehouse-configuration-field', 'quantium_access_key');
    register_setting('warehouse-configuration-field', 'send_order_url');
    register_setting('warehouse-configuration-field', 'get_stock_url');
    register_setting('warehouse-configuration-field', 'product_sync_url');
    register_setting('warehouse-configuration-field', 'woo_access_key');

    add_settings_section(
        'warehouse_details', // id
        'Warehouse Details', // title
        'warehouse_details_callback', // callback function to display the section
        'warehouse_configuration' // options page slug
    );
    add_settings_field(
        'exception_email', // id
        'Send Exception Email To', // title
        'text_input_callback', // callback function
        'warehouse_configuration', // options page slug
        'warehouse_details', // section id where you want this field to appear
        array('exception_email') // args
    );

    if (get_current_blog_id()!=3) {
        add_settings_field(
            'hostname', // id
            'Hostname', // title
            'text_input_callback', // callback function
            'warehouse_configuration', // options page slug
            'warehouse_details', // section id where you want this field to appear
            array('hostname') // args
        );
        add_settings_field(
            'port', // id
            'Port Number', // title
            'text_input_callback', // callback function
            'warehouse_configuration', // options page slug
            'warehouse_details', // section id where you want this field to appear
            array('port') // args
        );
        add_settings_field(
            'username', // id
            'Username', // title
            'text_input_callback', // callback function
            'warehouse_configuration', // options page slug
            'warehouse_details', // section id where you want this field to appear
            array('username') // args
        );
        add_settings_field(
            'password', // id
            'Password', // title
            'password_input_callback', // callback function
            'warehouse_configuration', // options page slug
            'warehouse_details', // section id where you want this field to appear
            array('password') // args
        );
        add_settings_field(
            'dispatch_path', // id
            'Dispatch Order Path', // title
            'text_input_callback', // callback function
            'warehouse_configuration', // options page slug
            'warehouse_details', // section id where you want this field to appear
            array('dispatch_path') // args
        );
        add_settings_field(
            'order_response', // id
            'Order Response Path', // title
            'text_input_callback', // callback function
            'warehouse_configuration', // options page slug
            'warehouse_details', // section id where you want this field to appear
            array('order_response') // args
        );
        add_settings_field(
            'stock_path', // id
            'Stock Path', // title
            'text_input_callback', // callback function
            'warehouse_configuration', // options page slug
            'warehouse_details', // section id where you want this field to appear
            array('stock_path') // args
        );
        add_settings_field(
            'tracking_link', // id
            'Tracking Link', // title
            'text_input_callback', // callback function
            'warehouse_configuration', // options page slug
            'warehouse_details', // section id where you want this field to appear
            array('tracking_link') // args
        );
    }

    if (get_current_blog_id()==1) {
        add_settings_field(
            'tracking_hostname', // id
            'Tracking FTP Hostname', // title
            'text_input_callback', // callback function
            'warehouse_configuration', // options page slug
            'warehouse_details', // section id where you want this field to appear
            array('tracking_hostname') // args
        );
        add_settings_field(
            'tracking_port', // id
            'Tracking FTP Port number', // title
            'text_input_callback', // callback function
            'warehouse_configuration', // options page slug
            'warehouse_details', // section id where you want this field to appear
            array('tracking_port') // args
        );
        add_settings_field(
            'tracking_username', // id
            'Tracking FTP Username', // title
            'text_input_callback', // callback function
            'warehouse_configuration', // options page slug
            'warehouse_details', // section id where you want this field to appear
            array('tracking_username') // args
        );
        add_settings_field(
            'tracking_password', // id
            'Tracking FTP Password', // title
            'password_input_callback', // callback function
            'warehouse_configuration', // options page slug
            'warehouse_details', // section id where you want this field to appear
            array('tracking_password') // args
        );
    }

    if (get_current_blog_id()==3) {
        add_settings_field(
            'quantium_access_key', // id
            'Warehouse API access key', // title
            'text_input_callback', // callback function
            'warehouse_configuration', // options page slug
            'warehouse_details', // section id where you want this field to appear
            array('quantium_access_key') // args
        );
        add_settings_field(
            'send_order_url', // id
            'Send Order Endpoint', // title
            'text_input_callback', // callback function
            'warehouse_configuration', // options page slug
            'warehouse_details', // section id where you want this field to appear
            array('send_order_url') // args
        );
        add_settings_field(
            'get_stock_url', // id
            'Get Stock Endpoint', // title
            'text_input_callback', // callback function
            'warehouse_configuration', // options page slug
            'warehouse_details', // section id where you want this field to appear
            array('get_stock_url') // args
        );
        add_settings_field(
            'product_sync_url', // id
            'Product Sync Endpoint', // title
            'text_input_callback', // callback function
            'warehouse_configuration', // options page slug
            'warehouse_details', // section id where you want this field to appear
            array('product_sync_url') // args
        );
        add_settings_field(
            'woo_access_key', // id
            'WOO API access key', // title
            'text_input_callback', // callback function
            'warehouse_configuration', // options page slug
            'warehouse_details', // section id where you want this field to appear
            array('woo_access_key') // args
        );
    }
}

function warehouse_details_callback() {
    echo 'Warehouse Details:';
}

function text_input_callback($args) {
    $option = get_option($args[0]);
    echo "<input type='text' name='{$args[0]}' value='{$option}' style='width: 50%;' />";
}
function password_input_callback($args) {
    $option = get_option($args[0]);
    echo "<input type='password' name='{$args[0]}' value='{$option}' style='width: 50%;' />";
}



// Send order to warehouse
function sendorder_cron_function() {
    if (get_current_blog_id()==1) {
        send_order_uk('UK');
    } else if (get_current_blog_id()==2) {
        send_order_nz('NZ');
    } else if (get_current_blog_id()==3) {
        send_order_au('AU');
    } else if (get_current_blog_id()==4) {
        send_order_eu('EU');
    }
}
add_action('sendorder_cron', 'sendorder_cron_function');

function send_order_uk($store) {
    $log_file_path = ABSPATH . 'logs/sendorder-'.$store.'.log';
    $log_data = ['Date and Time of Execution is : '.date("Y-m-d H:i:s")];
    $log_data[] = 'Checking processing orders for '.$store.' Warehouse';
    $file_directory = ABSPATH . 'wp-content/warehouse/uk/orders/'.date('Ymd').'/';
    $args = array(
        'status' => 'processing',
        'limit' => -1,
    );
    $processingOrders = wc_get_orders($args);
    foreach ($processingOrders as $_currentOrder) {
        $serialized_data = $_currentOrder->get_meta('warehouse_data');
        $data = unserialize($serialized_data);
        if(is_array($data) && $data['order_sent'] == 1){
            $log_data[] = 'Order #'.$_currentOrder->get_order_number().' already sent to '.$store.' Warehouse';
        } else {
            $log_data[] = 'Exporting order #'.$_currentOrder->get_order_number().' in XML file ...';

            if(!file_exists($file_directory)){
                mkdir($file_directory,0777,true);
            }
        
            $currentFilename = "ORDERIMPORT_".$_currentOrder->get_order_number().date("_Ymd-Hi").".xml";
        
            $incrementId = $_currentOrder->get_order_number();
            $orderCreatedAt = $_currentOrder->get_date_created()->date("Y/m/d");
            $shippingAddress = $_currentOrder->get_address('shipping');
            $companyName = ($shippingAddress['company'] != '') ? ' - '.$shippingAddress['company'] : '';
            $customerShippingName = $shippingAddress['first_name']." ".$shippingAddress['last_name'].$companyName;
            $streetOne = $shippingAddress['address_1'];
            $streetTwo = $shippingAddress['address_2'];
            $postCode = $shippingAddress['postcode'];
            $city = $shippingAddress['city'];
            $state = $shippingAddress['state'];
            $countryCode = $shippingAddress['country'];
            $phoneNumber = $shippingAddress['phone'];
            preg_match_all("![+]?\d+!", $phoneNumber, $phoneNumberMatches);
            $phoneNumber = isset($phoneNumberMatches[0]) ? implode('', $phoneNumberMatches[0]) : $phoneNumber;
            $customerEmail = $_currentOrder->get_billing_email();
            $deliveryNotes = ($_currentOrder->get_customer_note() != '') ? $_currentOrder->get_customer_note() : '';
            $shippingMethod = $_currentOrder->get_shipping_method();
            $shippingCarrier = substr($shippingMethod, 0, 3);
            if ($shippingCarrier=='Roy') {
                $shippingCarrier = 'RM';
            }
        
            $lineNumber = 1;
            $orderItems = $_currentOrder->get_items();
            $xmlLineItem = '';
            foreach ($orderItems as $orderItem) {
                $product = $orderItem->get_product();
                if($product){
                    $itemSku = $product->get_sku();
                } else {
                    $itemSku = '';
                }
                $itemName = $orderItem->get_name();
                $itemQty = $orderItem->get_quantity();
                $lineItemCost = $orderItem->get_total();
                $perItemCost = $_currentOrder->get_item_total($orderItem);
                $xmlLineItem .= '<Line>
                                        <Number>'.$lineNumber.'</Number>
                                        <StockCode>'.$itemSku.'</StockCode>
                                        <StockName>'.$itemName.'</StockName>
                                        <BatchRef/>
                                        <Qty>'.$itemQty.'</Qty>
                                        <SalePrice>'.$perItemCost.'</SalePrice>
                                    </Line>
                                    ';
                $lineNumber++;
            }

            $xmlStart = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>                               
                        <Orders>
                            <Order>
                                <Header>
                                    <OrderNo>'.$incrementId.'</OrderNo>
                                    <Date>'.$orderCreatedAt.'</Date>
                                    <DeliveryDate>'.$orderCreatedAt.'</DeliveryDate>
                                    <CustomerNo/>
                                    <DeliveryName>'.$customerShippingName.'</DeliveryName>
                                    <DeliveryAddress1>'.$streetOne.'</DeliveryAddress1>
                                    <DeliveryAddress2>'.$streetTwo.'</DeliveryAddress2>
                                    <DeliveryAddress3>'.$city.'</DeliveryAddress3>
                                    <DeliveryAddress4>'.$state.'</DeliveryAddress4>
                                    <DeliveryPostCode>'.$postCode.'</DeliveryPostCode>
                                    <Country>'.$countryCode.'</Country>
                                    <Notes>'.$deliveryNotes.'</Notes>
                                    <Carrier>'.$shippingCarrier.'</Carrier>
                                    <ShipMethod>'.$shippingMethod.'</ShipMethod>
                                    <EmailAddress>'.$customerEmail.'</EmailAddress>
                                    <ContactTelNo>'.$phoneNumber.'</ContactTelNo>
                                    <ContactMobileNo/>
                                    <OrderValue>'.$_currentOrder->get_total().'</OrderValue>
                                </Header>
                                <Lines>
                                    ';
            $xmlEnd = '</Lines>
                </Order>
            </Orders>';

            file_put_contents($file_directory.$currentFilename, $xmlStart.$xmlLineItem.$xmlEnd);

            $uploadStatus = uploadOrderFileOnFTP($currentFilename, $file_directory.$currentFilename);
        
            if($uploadStatus === true){
                $warehouse_data = array(
                    'filename' => $currentFilename,
                    'warehouse_name' => 'uk_warehouse',
                    'order_sent' => 1,
                    'created_at' => date("Y-m-d H:i:s")
                );
                $serialized_data = serialize($warehouse_data);
                $_currentOrder->update_meta_data('warehouse_data', $serialized_data);
                $_currentOrder->save();
            }

            $log_data[] = 'Order #'.$_currentOrder->get_order_number().' exported successfully';
        }
    }
    $log_data[] = 'Date and Time of Completion is : '.date("Y-m-d H:i:s");
    $log_data[] = '';
    file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
}

function send_order_nz($store) {
    $log_file_path = ABSPATH . 'logs/sendorder-'.$store.'.log';
    $log_data = ['Date and Time of Execution is : '.date("Y-m-d H:i:s")];
    $log_data[] = 'Checking processing orders for '.$store.' Warehouse';
    $file_directory = ABSPATH . 'wp-content/warehouse/nz/orders/'.date('Ymd').'/';
    $args = array(
        'status' => 'processing',
        'limit' => -1,
    );
    $processingOrders = wc_get_orders($args);
    foreach ($processingOrders as $_currentOrder) {
        $serialized_data = $_currentOrder->get_meta('warehouse_data');
        $data = unserialize($serialized_data);
        if(is_array($data) && $data['order_sent'] == 1){
            $log_data[] = 'Order #'.$_currentOrder->get_order_number().' already sent to '.$store.' Warehouse';
        } else {
            $log_data[] = 'Exporting order #'.$_currentOrder->get_order_number().' in XML file ...';

            if(!file_exists($file_directory)){
                mkdir($file_directory,0777,true);
            }

            $shipping_address = $_currentOrder->get_address('shipping');
            $companyName = (!empty($shipping_address['company'])) ? substr($shipping_address['company'], 0, 22) .' - ' : '';
            $streetOne = (!empty($shipping_address['address_1'])) ? $companyName.$shipping_address['address_1'] : '';
            $streetTwo = (!empty($shipping_address['address_2'])) ? $shipping_address['address_2'] : '';
            $postcode = $shipping_address['postcode'];
            $city = $shipping_address['city'];
            $state = $shipping_address['state'];
            $country = $shipping_address['country'];
            $customer_email = $_currentOrder->get_billing_email();
            $delivery_notes = ($_currentOrder->get_customer_note() != '') ? $_currentOrder->get_customer_note() : '';
            
            $contents = [];
            foreach ($_currentOrder->get_items() as $item) {
                $product = $item->get_product();
                $sku = $product->get_sku();
                $qty = $item->get_quantity();
                $product_type = $product->get_type();
            
                // Simple product
                if ($product_type == 'simple') {
                    $contents[] = [
                        'order_number' => $_currentOrder->get_order_number(),
                        'customer_order_number' => '',
                        'sku' => $sku,
                        'qty' => $qty,
                        'cust_number' => '0',
                        'delname' => $shipping_address['first_name'] . ' ' . $shipping_address['last_name'],
                        'deladdr1' => $streetOne,
                        'deladdr2' => ($streetTwo != '') ? $streetTwo. ' , ' .$postcode : $postcode,
                        'deladdr3' => $city,
                        'deladdr4' => ($state != '') ? $state. ' , ' .$country : $country,
                        'instructions' => $delivery_notes,
                        'requireddate' => '',
                        'deliveryconfirmemail' => $customer_email
                    ];
                }
                // Variable product (configurable or bundle)
                elseif ($product_type == 'variable') {
                    foreach ($item->get_children() as $child_id) {
                        $variation = wc_get_product($child_id);
                        $sku = $variation->get_sku();
                        $qty = $item->get_quantity();
            
                        $contents[] = [
                            'order_number' => $_currentOrder->get_order_number(),
                            'customer_order_number' => '',
                            'sku' => $sku,
                            'qty' => $qty,
                            'cust_number' => '0',
                            'delname' => $shipping_address['first_name'] . ' ' . $shipping_address['last_name'],
                            'deladdr1' => $streetOne,
                            'deladdr2' => ($streetTwo != '') ? $streetTwo. ' , ' .$postcode : $postcode,
                            'deladdr3' => $city,
                            'deladdr4' => ($state != '') ? $state. ' , ' .$country : $country,
                            'instructions' => $delivery_notes,
                            'requireddate' => '',
                            'deliveryconfirmemail' => $customer_email
                        ];
                    }
                }
            }

            $currentFilename = "ORDERIMPORT_".$_currentOrder->get_order_number().date("_Ymd-Hi").".csv";
            $file = fopen($file_directory.$currentFilename,"w");
            fputcsv($file, ["OrderNumber","Customer Order Number","SKU","QTY","CUSTNUMBER","DELNAME","DELADDR1","DELADDR2","DELADDR3","DELADDR4","INSTRUCTIONS","REQUIREDDATE","DELIVERYCONFIRMEMAIL"]);
            
            foreach($contents as $content){
                $content = str_replace('"', '', $content);
                fputcsv($file, $content);
            }

            fclose($file);

            $uploadStatus = uploadOrderFileOnFTP($currentFilename, $file_directory.$currentFilename);
        
            if($uploadStatus === true){
                $warehouse_data = array(
                    'filename' => $currentFilename,
                    'warehouse_name' => 'nz_warehouse',
                    'order_sent' => 1,
                    'created_at' => date("Y-m-d H:i:s")
                );
                $serialized_data = serialize($warehouse_data);
                $_currentOrder->update_meta_data('warehouse_data', $serialized_data);
                $_currentOrder->save();
            }

            $log_data[] = 'Order #'.$_currentOrder->get_order_number().' exported successfully';
        }
    }
    $log_data[] = 'Date and Time of Completion is : '.date("Y-m-d H:i:s");
    $log_data[] = '';
    file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
}

function send_order_au($store) {
    $log_file_path = ABSPATH . 'logs/sendorder-'.$store.'.log';
    $log_data = ['Date and Time of Execution is : '.date("Y-m-d H:i:s")];
    $log_data[] = 'Checking processing orders for '.$store.' Warehouse';
    $file_directory = ABSPATH . 'wp-content/warehouse/au/orders/'.date('Ymd').'/';
    $args = array(
        'status' => 'processing',
        'limit' => -1,
    );
    $processingOrders = wc_get_orders($args);
    foreach ($processingOrders as $_currentOrder) {
        $serialized_data = $_currentOrder->get_meta('warehouse_data');
        $data = unserialize($serialized_data);
        if(is_array($data) && $data['order_sent'] == 1){
            $log_data[] = 'Order #'.$_currentOrder->get_order_number().' already sent to '.$store.' Warehouse';
        } else {
            $log_data[] = 'Exporting order #'.$_currentOrder->get_order_number().' in XML file ...';

            if(!file_exists($file_directory)){
                mkdir($file_directory,0777,true);
            }
        
            $currentFilename = "ORDERIMPORT_".$_currentOrder->get_order_number().date("_Ymd-Hi").".xml";
        
            $incrementId = $_currentOrder->get_order_number();
            $orderCreatedAt = $_currentOrder->get_date_created()->date("m/d/Y H:i:s");
            $shippingAddress = $_currentOrder->get_address('shipping');
            $companyName = ($shippingAddress['company'] != '') ? ' - '.$shippingAddress['company'] : '';
            $customerShippingName = $shippingAddress['first_name']." ".$shippingAddress['last_name'].$companyName;
            $streetOne = $shippingAddress['address_1'];
            $streetTwo = $shippingAddress['address_2'];
            $postCode = $shippingAddress['postcode'];
            $city = $shippingAddress['city'];
            $state = $shippingAddress['state'];
            $email = $_currentOrder->get_billing_email();
            $countryCode = $shippingAddress['country'];
            $country = WC()->countries->countries[$countryCode];
            $phoneNumber = $shippingAddress['phone'];
            preg_match_all("![+]?\d+!", $phoneNumber, $phoneNumberMatches);
            $phoneNumber = isset($phoneNumberMatches[0]) ? implode('', $phoneNumberMatches[0]) : $phoneNumber;
            $customerEmail = $_currentOrder->get_billing_email();
            $deliveryNotes = ($_currentOrder->get_customer_note() != '') ? $_currentOrder->get_customer_note() : '';
            $shippingMethod = $_currentOrder->get_shipping_method();
            if (strpos($shippingMethod, 'Express') !== false) {
                $shippingMethod = 'EPCX';
            } else {
                $shippingMethod = 'EPCL';
            }

            // Billing info
            $billingAddress = $_currentOrder->get_address('billing');
            $customerBillingName = $billingAddress['first_name']." ".$billingAddress['last_name'].$companyName;
            $billingstreetOne = $billingAddress['address_1'];
            $billingstreetTwo = $billingAddress['address_2'];
            $billingpostCode = $billingAddress['postcode'];
            $billingcity = $billingAddress['city'];
            $billingstate = $billingAddress['state'];
            $billingemail = $_currentOrder->get_billing_email();
            $billingcountryCode = $billingAddress['country'];
            $billingcountry = WC()->countries->countries[$billingcountryCode];
            $billingphoneNumber = $billingAddress['phone'];
            preg_match_all("![+]?\d+!", $billingphoneNumber, $billingphoneNumberMatches);
            $billingphoneNumber = isset($billingphoneNumberMatches[0]) ? implode('', $billingphoneNumberMatches[0]) : $billingphoneNumber;
        
            $lineNumber = 1;
            $orderItems = $_currentOrder->get_items();
            $xmlLineItem = '';
            foreach ($orderItems as $orderItem) {
                $product = $orderItem->get_product();
                if($product){
                    $itemSku = $product->get_sku();
                } else {
                    $itemSku = '';
                }
                $itemName = $orderItem->get_name();
                $itemQty = $orderItem->get_quantity();
                $lineItemCost = $orderItem->get_total();
                $perItemCost = $_currentOrder->get_item_total($orderItem);
                    $xmlLineItem .= '<ItemLine>
                    <LineNumber>'.$lineNumber.'</LineNumber>
                    <SKU>'.$itemSku.'</SKU>
                    <ProductName>'.$itemName.'</ProductName>
                    <Quantity>'.$itemQty.'</Quantity>
                    <InventoryStatus>OK</InventoryStatus>
                    <UnitUOM>EA</UnitUOM>
                    <LotNumber/>
                    <ItemBillingInformation>
                        <RetailPrice>'.$perItemCost.'</RetailPrice>
                        <Currency>'.$_currentOrder->get_currency().'</Currency>
                    </ItemBillingInformation>
                    <Attribute5>RRF</Attribute5>
                </ItemLine>';
                $lineNumber++;
            }

            $xmlStart = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>
            <DeliveryOrder>
                <TransactionType>NEW</TransactionType>
                <OrderHeader>
                    <OrderID>'.$_currentOrder->get_order_number().'</OrderID>
                    <AlternateOrderID>'.$_currentOrder->get_order_number().'</AlternateOrderID>
                    <MerchantID>AGT</MerchantID>
                    <WarehouseID>QSAUSF</WarehouseID>
                    <OrderType>Sales Orders</OrderType>
                    <DisplayableOrderDate>'.$orderCreatedAt.'</DisplayableOrderDate>
                    <Department>MG-RRF</Department>
                </OrderHeader>
                <OrderDetail>
                    <ShippingInformation>
                        <ShipToAddress>
                            <Name>'.stripCommasFromValue($customerShippingName).'</Name>
                            <AddressLine1>'.stripCommasFromValue($streetOne).'</AddressLine1>
                            <AddressLine2>'.stripCommasFromValue($streetTwo).'</AddressLine2>
                            <AddressLine3/>
                            <City>'.stripCommasFromValue($city).'</City>
                            <State>'.stripCommasFromValue($state).'</State>
                            <PostalCode>'.stripCommasFromValue($postCode).'</PostalCode>
                            <CountryName>'.$country.'</CountryName>
                            <CountryCode>'.$countryCode.'</CountryCode>
                            <ContactNo>'.$phoneNumber.'</ContactNo>
                            <Email>'.$email.'</Email>
                            <ShipToAttention>'.stripCommasFromValue($customerShippingName).'</ShipToAttention>
                        </ShipToAddress>
                        <Carrier>STARSHIPPIT</Carrier>
                        <ShippingMethod>'.stripCommasFromValue($shippingMethod).'</ShippingMethod>
                        <EarliestShipDate>'.date('m/d/Y H:i:s', strtotime($orderCreatedAt. ' + 1 days')).'</EarliestShipDate>
                        <LatestShipDate>'.date('m/d/Y H:i:s', strtotime($orderCreatedAt. ' + 1 days')).'</LatestShipDate>
                    </ShippingInformation>
                    <BillingInformation>
                        <BillToAddress>
                            <Name>'.stripCommasFromValue($customerBillingName).'</Name>
                            <AddressLine1>'.stripCommasFromValue($billingstreetOne).'</AddressLine1>
                            <AddressLine2>'.stripCommasFromValue($billingstreetTwo).'</AddressLine2>
                            <AddressLine3/>
                            <City>'.stripCommasFromValue($billingcity).'</City>
                            <State>'.stripCommasFromValue($billingstate).'</State>
                            <PostalCode>'.stripCommasFromValue($billingpostCode).'</PostalCode>
                            <CountryName>'.$billingcountry.'</CountryName>
                            <CountryCode>'.$billingcountryCode.'</CountryCode>
                            <ContactNo>'.$billingphoneNumber.'</ContactNo>
                            <Email>'.$billingemail.'</Email>
                        </BillToAddress>
                        <FreightCost>'.$_currentOrder->get_total().'</FreightCost>
                        <Currency>'.$_currentOrder->get_currency().'</Currency>
                    </BillingInformation>
                    <ItemDetail>
            ';
            $xmlEnd = '</ItemDetail>
                <Transportdetails/>
            </OrderDetail>
            </DeliveryOrder>';

            file_put_contents($file_directory.$currentFilename, $xmlStart.$xmlLineItem.$xmlEnd);

            /*API data mapping*/
            $headers = array(
                "Authorization: ".get_option('quantium_access_key'),
                "Content-Type: application/xml",
            );
            
            $requestUrl=get_option('send_order_url');

            $xmlRequest = $xmlStart.$xmlLineItem.$xmlEnd;

            $ch = curl_init($requestUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlRequest);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);

            $resultArr = simplexml_load_string($result);
            foreach ($resultArr->Response as $response) {
                $responseArr = (array)$response;
                $responseCode = $responseArr['ResponseCode'];
                $responseStatus = $responseArr['Status'];
            }

            if ($responseCode=='Success') {
                $warehouse_data = array(
                    'filename' => $currentFilename,
                    'warehouse_name' => 'au_warehouse',
                    'order_sent' => 1,
                    'created_at' => date("Y-m-d H:i:s")
                );
                $serialized_data = serialize($warehouse_data);
                $_currentOrder->update_meta_data('warehouse_data', $serialized_data);
                $_currentOrder->save();

                $log_data[] = 'Order #'.$_currentOrder->get_order_number().' exported successfully';
            } else {
                $log_data[] = 'Order #'.$_currentOrder->get_order_number().' is not Exported';
                $log_data[] = $result;
                $log_data[] = $xmlRequest;
            }
        }
    }
    $log_data[] = 'Date and Time of Completion is : '.date("Y-m-d H:i:s");
    $log_data[] = '';
    file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
}

function send_order_eu($store) {
    $log_file_path = ABSPATH . 'logs/sendorder-'.$store.'.log';
    $log_data = ['Date and Time of Execution is : '.date("Y-m-d H:i:s")];
    $log_data[] = 'Checking processing orders for '.$store.' Warehouse';
    $file_directory = ABSPATH . 'wp-content/warehouse/eu/orders/'.date('Ymd').'/';
    $args = array(
        'status' => 'processing',
        'limit' => -1,
    );
    $processingOrders = wc_get_orders($args);
    foreach ($processingOrders as $_currentOrder) {
        $serialized_data = $_currentOrder->get_meta('warehouse_data');
        $data = unserialize($serialized_data);
        if(is_array($data) && $data['order_sent'] == 1){
            $log_data[] = 'Order #'.$_currentOrder->get_order_number().' already sent to '.$store.' Warehouse';
        } else {
            $log_data[] = 'Exporting order #'.$_currentOrder->get_order_number().' in XML file ...';

            if(!file_exists($file_directory)){
                mkdir($file_directory,0777,true);
            }

            $shippingAddress = $_currentOrder->get_address('shipping');
            $companyOrConsumer = ($shippingAddress['company'] != '') ? $shippingAddress['company'] : $shippingAddress['first_name']." ".$shippingAddress['last_name'];
            $contactPerson = $shippingAddress['first_name']." ".$shippingAddress['last_name'];
            $streetOne = $shippingAddress['address_1'];
            $streetTwo = $shippingAddress['address_2'];
            $postcode = $shippingAddress['postcode'];
            $city = $shippingAddress['city'];
            $countryCode = $shippingAddress['country'];
            $phoneNumber = $shippingAddress['phone'];
            $customerEmail = $_currentOrder->get_billing_email();
            $deliveryNotes = ($_currentOrder->get_customer_note() != '') ? trim(preg_replace('/\s+/', ' ', $_currentOrder->get_customer_note())) : '';
            $shippingMethod = str_replace("Select Shipping Method - ", "", $_currentOrder->get_shipping_method());
            $shippingMethodLowerCase = strtolower($shippingMethod);

            $shippingMethodCarrierServiceLevelMapping = [
                [
                    'shipping_method' => 'Customer Collection',
                    'carrier_id' => 'PICKUP',
                    'service_level' => 'COLLECT'
                ],
                [
                    'shipping_method' => 'DHL Parcel Economy',
                    'carrier_id' => 'DHP',
                    'service_level' => 'EUROPLUS'
                ],
                [
                    'shipping_method' => 'DHL Express',
                    'carrier_id' => 'DHL',
                    'service_level' => 'EXPRESS'
                ]
            ];

            $shippingMethodCarrierServiceLevelMappingArray = [];

            foreach ($shippingMethodCarrierServiceLevelMapping as $methodCarrierLevel) {
                $shippingMethodCarrierServiceLevelMappingArray[strtolower($methodCarrierLevel['shipping_method'])] = $methodCarrierLevel['carrier_id'].'---'.$methodCarrierLevel['service_level'];
            }

            $isShippingMappingExists = array_key_exists($shippingMethodLowerCase, $shippingMethodCarrierServiceLevelMappingArray);

            if($isShippingMappingExists){
                $dispatchCarrierAndServiceLevel = explode("---", $shippingMethodCarrierServiceLevelMappingArray[$shippingMethodLowerCase]);
                $carrier = $dispatchCarrierAndServiceLevel[0];
                $serviceLavel = $dispatchCarrierAndServiceLevel[1];
            }else{
                $carrier = strtoupper(trim(substr($shippingMethod, 0, 3)));
                $serviceLavel = strtoupper(trim(substr($shippingMethod, 3)));
            }

            if($countryCode == 'GB'){
                $intercom = 'DDU';
            }elseif ($countryCode == 'AD' || $countryCode =='MC' || $countryCode == 'NO' || $countryCode =='CH') {
                $intercom = 'DAP';
            }else{
                $intercom = 'CPT';
            }

            $contents = [];
            foreach ($_currentOrder->get_items() as $item_id => $item) {
                $product = $item->get_product();
                $sku = $product->get_sku();
                $qty = $item->get_quantity();
                $product_type = $product->get_type();
            
                // Simple product
                if ($product_type == 'simple') {
                    $contents[] = [
                        'a_ordernumber' => $_currentOrder->get_order_number(),
                        'b_reference' => '',
                        'c_order_date' => '',
                        'd_company-consumer_name' => convertHtmlSpecialCharToNormal($companyOrConsumer),
                        'e_contact_person' => convertHtmlSpecialCharToNormal($shippingAddress['first_name'] . ' ' . $shippingAddress['last_name']),
                        'f_adress' => convertHtmlSpecialCharToNormal($streetOne . ' ' . $streetTwo),
                        'g_adress_2' => '',
                        'h_postal_code' => convertHtmlSpecialCharToNormal($postcode),
                        'i_city' => convertHtmlSpecialCharToNormal($city),
                        'j_country_code' => $countryCode,
                        'k_phone_number' => $phoneNumber,
                        'l_email' => $customerEmail,
                        'm_article_code' => $sku,
                        'n_quantity' => $qty,
                        'o_article_desctipation' => convertHtmlSpecialCharToNormal($item->get_name()),
                        'p_' => '',
                        'q_' => '',
                        'r_' => '',
                        's_shipping_pack_instruction' => convertHtmlSpecialCharToNormal($deliveryNotes),
                        't_' => '',
                        'u_incoterm' => $intercom,
                        'v_carrier' => convertHtmlSpecialCharToNormal($carrier),
                        'w_service_level' => convertHtmlSpecialCharToNormal($serviceLavel),
                        'x_currency' => $_currentOrder->get_currency(),
                        'y_unit_value' => $_currentOrder->get_item_subtotal($item, true, true),
                    ];
                }
                // Variable product (configurable or bundle)
                elseif ($product_type == 'variable') {
                    foreach ($item->get_children() as $child_id) {
                        $variation = wc_get_product($child_id);
                        $sku = $variation->get_sku();
                        $qty = $item->get_quantity();
            
                        $contents[] = [
                            'a_ordernumber' => $_currentOrder->get_order_number(),
                            'b_reference' => '',
                            'c_order_date' => '',
                            'd_company-consumer_name' => convertHtmlSpecialCharToNormal($companyOrConsumer),
                            'e_contact_person' => convertHtmlSpecialCharToNormal($shippingAddress['first_name'] . ' ' . $shippingAddress['last_name']),
                            'f_adress' => convertHtmlSpecialCharToNormal($streetOne . ' ' . $streetTwo),
                            'g_adress_2' => '',
                            'h_postal_code' => convertHtmlSpecialCharToNormal($postcode),
                            'i_city' => convertHtmlSpecialCharToNormal($city),
                            'j_country_code' => $countryCode,
                            'k_phone_number' => $phoneNumber,
                            'l_email' => $customerEmail,
                            'm_article_code' => $sku,
                            'n_quantity' => $qty,
                            'o_article_desctipation' => convertHtmlSpecialCharToNormal($variation->get_name()),
                            'p_' => '',
                            'q_' => '',
                            'r_' => '',
                            's_shipping_pack_instruction' => convertHtmlSpecialCharToNormal($deliveryNotes),
                            't_' => '',
                            'u_incoterm' => $intercom,
                            'v_carrier' => convertHtmlSpecialCharToNormal($carrier),
                            'w_service_level' => convertHtmlSpecialCharToNormal($serviceLavel),
                            'x_currency' => $_currentOrder->get_currency(),
                            'y_unit_value' => $variation->get_price(),
                        ];
                    }
                }
            }

            $currentFilename = "ORDERIMPORT_".$_currentOrder->get_order_number().date("_Ymd-Hi").".csv";
            $file = fopen($file_directory.$currentFilename,"w");
            
            foreach($contents as $content){
                fputs($file, implode(';', $content)."\n");
            }

            fclose($file);

            $uploadStatus = uploadOrderFileOnFTP($currentFilename, $file_directory.$currentFilename);
        
            if($uploadStatus === true){
                $warehouse_data = array(
                    'filename' => $currentFilename,
                    'warehouse_name' => 'eu_warehouse',
                    'order_sent' => 1,
                    'created_at' => date("Y-m-d H:i:s")
                );
                $serialized_data = serialize($warehouse_data);
                $_currentOrder->update_meta_data('warehouse_data', $serialized_data);
                $_currentOrder->save();
            }

            $log_data[] = 'Order #'.$_currentOrder->get_order_number().' exported successfully';
        }
    }
    $log_data[] = 'Date and Time of Completion is : '.date("Y-m-d H:i:s");
    $log_data[] = '';
    file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
}

function uploadOrderFileOnFTP($currentFilename, $currentFileLocation){
    $hostname = get_option('hostname');
    $username = get_option('username');
    $password = get_option('password');
    $uploadDir = get_option('dispatch_path');

    $connectionId = ftp_connect($hostname);

    if (!$connectionId) {  
        $log_data[] = 'Connection Failed to '.$hostname;
        $log_data[] = '';
        file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);          
        throw new \Exception("Couldn't connect to {$hostname}");
    }

    $loginResult = ftp_login($connectionId, $username, $password);

    if (!$loginResult) {            
        throw new \Exception("You do not have access to this ftp server!");
    }

    ftp_pasv($connectionId, true);
    ftp_chdir($connectionId, $uploadDir);

    $remoteFile = $uploadDir.$currentFilename;
        
    $ftpReturn = ftp_nb_put($connectionId, $remoteFile, $currentFileLocation, FTP_BINARY, FTP_AUTORESUME);
    while(FTP_MOREDATA == $ftpReturn) {
        $ftpReturn = ftp_nb_continue($connectionId);
    }
    if($ftpReturn == FTP_FINISHED) {
        ftp_close($connectionId);
        return true;
    } else {                
        throw new Exception("Failed uploading file '" . $remoteFile . "'.");                
    }
    return false;
}

function convertHtmlSpecialCharToNormal($value){
    $result = str_replace(
        array('"', '&quot;', ';'), 
        array('', '', ' '), 
        $value
    );
    return transliterator_transliterate('Any-Latin; Latin-ASCII; [\u0080-\u7fff] remove', $result);
}

function stripCommasFromValue($value){
    $value = trim(preg_replace('/\s+/', ' ', $value));
    $value = iconv('utf-8', 'ascii//TRANSLIT', $value);
    return htmlspecialchars(str_replace(",", " ", $value));
}


// Get order response from warehouse
function get_order_response_cron_function() {
    if (get_current_blog_id()==1) {
        get_order_response_uk('UK');
    } else if (get_current_blog_id()==2) {
        get_order_response_nz('NZ');
    } else if (get_current_blog_id()==4) {
        get_order_response_eu('EU');
    }
}
add_action('get_order_response_cron', 'get_order_response_cron_function');

function get_order_response_uk($store) {
    $log_file_path = ABSPATH . 'logs/getorderresponse-'.$store.'.log';
    $log_data = ['Date and Time of Execution is : '.date("Y-m-d H:i:s")];
    $log_data[] = 'Checking order response from '.$store.' Warehouse';
    
    $cclHostname = get_option('tracking_hostname');
    $cclUsername = get_option('tracking_username');
    $cclPassword = get_option('tracking_password');
    $cclPortNumber = get_option('tracking_port');

    // Connect sftp
    $connection = ssh2_connect($cclHostname, $cclPortNumber);
    if (ssh2_auth_password($connection, $cclUsername, $cclPassword)) {
        $sftp = ssh2_sftp($connection);
        $log_data[] = 'Connected to '.$store.' Warehouse SFTP';
        $remote_directory = '/Users/'.$cclUsername.'/outbox2/';
        $files = scandir("ssh2.sftp://$sftp".$remote_directory);

        $processingOrderIdsInSystem = [];
        $args = array(
            'status' => 'processing',
            'limit' => -1,
        );
        $processingOrders = wc_get_orders($args);
        foreach ($processingOrders as $_currentOrder) {
            $processingOrderIdsInSystem[] = $_currentOrder->get_order_number();
        }

        $currentDayFileList = [];
        foreach ($files as $currentFile) {
            if(isset($currentFile) && ((strpos($currentFile, date("Ymd")) !== false) || (strpos($currentFile, date('Ymd',strtotime("-1 days"))) !== false) || (strpos($currentFile, date('Ymd',strtotime("-2 days"))) !== false) || (strpos($currentFile, date('Ymd',strtotime("-3 days"))) !== false))){
                $currentDayFileList[] = $currentFile;
            }
        }

        $log_data[] = 'Total files found in '.$store.' Warehouse : '.count($currentDayFileList);

        foreach ($currentDayFileList as $orderResponseFile) {
            $log_data[] = 'Reading file -> '.$orderResponseFile;
            $currentOrderResponse = file_get_contents("ssh2.sftp://$sftp".$remote_directory.$orderResponseFile);
            $currentCsvLines = explode("\n", $currentOrderResponse);
            //remove the first element from the array
            $currentCsvHead = str_getcsv(array_shift($currentCsvLines));

            foreach ($currentCsvLines as $currentCsvLine) {
                $currentLineInCsv = explode(",", $currentCsvLine);
                $orderId = isset($currentLineInCsv[0]) ? $currentLineInCsv[0] : '';
                $currentOrderTrackingNumber = isset($currentLineInCsv[2]) ? $currentLineInCsv[2] : '';
                $currentOrderTrackingLink = isset($currentLineInCsv[4]) ? $currentLineInCsv[4] : '';

                if(in_array($orderId, $processingOrderIdsInSystem) && $currentOrderTrackingNumber != ''){
                    $instance = new WT_Advanced_Order_Number();
                    $order_id = $instance->wt_order_id_from_order_number($orderId);
                    $currentOrder = wc_get_order($order_id);
                    $warehouse_data = unserialize($currentOrder->get_meta('warehouse_data'));
                    $new_warehouse_data = array(
                        'filename' => $warehouse_data['filename'],
                        'warehouse_name' => 'uk_warehouse',
                        'order_sent' => 1,
                        'created_at' => $warehouse_data['created_at'],
                        'tracking_number' => $currentOrderTrackingNumber,
                        'response_from_warehouse' => $currentOrderTrackingLink,
                        'response_filename' => $orderResponseFile,
                        'response_file_content' => $currentOrderResponse,
                    );
                    $currentOrder->update_meta_data('warehouse_data', serialize($new_warehouse_data));
                    $currentOrder->update_meta_data('_tracking_number', $currentOrderTrackingNumber);
                    $currentOrder->update_status('completed');
                    $currentOrder->save();
                    
                    $log_data[] = "Current Order ID => #".$orderId;
                    $log_data[] = "Current Order Tracking Number => ".$currentOrderTrackingNumber;
                    $log_data[] = "Current Order Tracking Link => ".$currentOrderTrackingLink;
                }
            }
            // Move file to transferred folder
            ssh2_sftp_rename($sftp, $remote_directory.$orderResponseFile, $remote_directory.'transferred/'.$orderResponseFile);
            $log_data[] = $orderResponseFile." <- File is transferred in -> transferred/".$orderResponseFile;
        }
    } else {
        $log_data[] = 'Connection to '.$store.' Warehouse failed';
    }

    $log_data[] = 'Date and Time of Completion is : '.date("Y-m-d H:i:s");
    $log_data[] = '';
    file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
}

function get_order_response_nz($store) {
    $log_file_path = ABSPATH . 'logs/getorderresponse-'.$store.'.log';
    $log_data = ['Date and Time of Execution is : '.date("Y-m-d H:i:s")];
    $log_data[] = 'Checking order response from '.$store.' Warehouse';
    
    $scsHostname = get_option('hostname');
    $scsUsername = get_option('username');
    $scsPassword = get_option('password');
    $scsOrderResponse = get_option('order_response');

    // Connect sftp
    $connectionId = @ftp_connect($scsHostname);
    if ((!$connectionId)) {   
        $log_data[] = 'Connection Failed';
        $log_data[] = '';
        file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);         
        throw new \Exception("Couldn't connect to {$scsHostname}");
    }

    $loginResult = @ftp_login($connectionId, $scsUsername, $scsPassword);

    if($loginResult) {
        $log_data[] = 'Connected to '.$store.' Warehouse SFTP';
        
        ftp_pasv($connectionId, true);
        ftp_chdir($connectionId, $scsOrderResponse);
        $currentDirListing = ftp_nlist($connectionId, $scsOrderResponse);

        $processingOrderIdsInSystem = [];
        $args = array(
            'status' => 'processing',
            'limit' => -1,
        );
        $processingOrders = wc_get_orders($args);
        foreach ($processingOrders as $_currentOrder) {
            $processingOrderIdsInSystem[] = $_currentOrder->get_order_number();
        }

        $uniqueOrderNumbers = [];
        foreach ($currentDirListing as $currentFile) {
            if($currentFile != "." && $currentFile != '..'){
                $_orderId = explode("_", $currentFile)[1];
                $uniqueOrderNumbers[$_orderId] = $currentFile;
            }
        }

        foreach ($uniqueOrderNumbers as $orderId => $orderResponseFile) {
            if(in_array($orderId, $processingOrderIdsInSystem)){
                // Read file from warehouse, change order status, add tracking number in that order and save response in DB.
                $filename = 'ftp://'.$scsUsername.':'.$scsPassword.'@'.$scsHostname.$scsOrderResponse.$orderResponseFile;
                $handle = fopen($filename, "r");
                $currentOrderResponse = fread($handle, filesize($filename));
                fclose($handle);

                $currentOrderResponseArray = simplexml_load_string($currentOrderResponse);
                $currentOrderTrackingNumber = (string) $currentOrderResponseArray->SALES_ORDER_STATUS->ORDER->ORDER_HEADER->TRACKTRACE_NR;

                if($currentOrderTrackingNumber != ''){
                    // Save Order response and tracking number
                    $instance = new WT_Advanced_Order_Number();
                    $order_id = $instance->wt_order_id_from_order_number($orderId);
                    $currentOrder = wc_get_order($order_id);
                    $warehouse_data = unserialize($currentOrder->get_meta('warehouse_data'));
                    $new_warehouse_data = array(
                        'filename' => $warehouse_data['filename'],
                        'warehouse_name' => 'nz_warehouse',
                        'order_sent' => 1,
                        'created_at' => $warehouse_data['created_at'],
                        'tracking_number' => $currentOrderTrackingNumber,
                        'response_from_warehouse' => $currentOrderResponse
                    );
                    $currentOrder->update_meta_data('warehouse_data', serialize($new_warehouse_data));
                    $currentOrder->update_meta_data('_tracking_number', $currentOrderTrackingNumber);
                    $currentOrder->update_status('completed');
                    $currentOrder->save();

                    $log_data[] = "Current Order ID => #".$orderId;
                    $log_data[] = "Current Order Tracking Number => ".$currentOrderTrackingNumber;
                    $log_data[] = "Order status changed to complete for Order #".$orderId;
                }
            }
        }
    } else {
        $log_data[] = 'Connection to '.$store.' Warehouse failed';
    }

    $log_data[] = 'Date and Time of Completion is : '.date("Y-m-d H:i:s");
    $log_data[] = '';
    file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
}

function get_order_response_eu($store) {
    $log_file_path = ABSPATH . 'logs/getorderresponse-'.$store.'.log';
    $log_data = ['Date and Time of Execution is : '.date("Y-m-d H:i:s")];
    $log_data[] = 'Checking order response from '.$store.' Warehouse';
    
    $tlogisticsHostname = get_option('hostname');
    $tlogisticsUsername = get_option('username');
    $tlogisticsPassword = get_option('password');
    $tlogisticsOrderResponse = get_option('order_response');

    // Connect sftp
    $connectionId = @ftp_connect($tlogisticsHostname);
    if ((!$connectionId)) {  
        $log_data[] = 'Connection Failed';
        $log_data[] = '';
        file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);          
        throw new \Exception("Couldn't connect to {$tlogisticsHostname}");
    }

    $loginResult = @ftp_login($connectionId, $tlogisticsUsername, $tlogisticsPassword);
    if($loginResult) {
        $log_data[] = 'Connected to '.$store.' Warehouse SFTP';
        
        ftp_pasv($connectionId, true);
        ftp_chdir($connectionId, $tlogisticsOrderResponse);
        $currentDirListing = ftp_nlist($connectionId, $tlogisticsOrderResponse);

        $processingOrderIdsInSystem = [];
        $args = array(
            'status' => 'processing',
            'limit' => -1,
        );
        $processingOrders = wc_get_orders($args);
        foreach ($processingOrders as $_currentOrder) {
            $processingOrderIdsInSystem[] = $_currentOrder->get_order_number();
        }

        $orderResponseFile = "Rosita_order_status_confirm_".date("Ymd").".xml";
        $filename = 'ftp://'.$tlogisticsUsername.':'.$tlogisticsPassword.'@'.$tlogisticsHostname.$tlogisticsOrderResponse.$orderResponseFile;
        $currentOrderResponse = file_get_contents($filename);

        $orderResponseArray = simplexml_load_string($currentOrderResponse);

        if(!file_exists(ABSPATH . 'exporteddata/linnworksstock/tlogistics/')){
            mkdir(ABSPATH . 'exporteddata/linnworksstock/tlogistics/',0777,true);
        }
        $file = fopen(ABSPATH . 'exporteddata/linnworksstock/tlogistics/rrfeu_thirdparty_order_update.csv','w');

        fputcsv($file, ['order_id', 'tracking_number', 'sku', 'qty']);

        foreach ($orderResponseArray->SALES_ORDER_STATUS->ORDER as $currentOrder) {
            $orderId = $currentOrder->ORDER_HEADER->ORDER_NR;
            $currentOrderTrackingNumber = $currentOrder->ORDER_HEADER->TRACKTRACE_NR;
            $currentOrderShipper = $currentOrder->ORDER_HEADER->SHIPPER;
            $shipStatus = $currentOrder->ORDER_HEADER->ORDER_STATUS;
            
            if(in_array($orderId, $processingOrderIdsInSystem)){
                if($shipStatus == 'SHIPPED'){
                    // Save Order response and tracking number in 'sk_manage_orders_csv' table
                    if ($currentOrderTrackingNumber != '') {
                        $trackingOrSelfPickup = $currentOrderTrackingNumber;
                    } else if ($currentOrderShipper == 'PICKUP') {
                        $trackingOrSelfPickup = "Pickup";
                    } else {
                        $trackingOrSelfPickup = "Manually processed";
                    }
                    
                    $instance = new WT_Advanced_Order_Number();
                    $order_id = $instance->wt_order_id_from_order_number((string)$orderId);
                    $order = wc_get_order($order_id);
                    $warehouse_data = unserialize($order->get_meta('warehouse_data'));
                    $new_warehouse_data = array(
                        'filename' => $warehouse_data['filename'],
                        'warehouse_name' => 'eu_warehouse',
                        'order_sent' => 1,
                        'created_at' => $warehouse_data['created_at'],
                        'tracking_number' => (string)$trackingOrSelfPickup,
                        'response_from_warehouse' => (string)$currentOrderResponse
                    );
                    $order->update_meta_data('warehouse_data', serialize($new_warehouse_data));
                    $order->update_meta_data('_tracking_number', (string)$trackingOrSelfPickup);
                    $order->update_status('completed');
                    $order->save();

                    $log_data[] = "Current Order ID => #".$orderId;
                    $log_data[] = "Current Order Tracking Number => ".$currentOrderTrackingNumber;
                    $log_data[] = "Order status changed to complete for Order #".$orderId;
                    
                }
            } else {   
                $log_data[] = "Third party order update";
                if($shipStatus == 'SHIPPED'){   
                    $log_data[] = $orderId;
                    if ($currentOrderTrackingNumber != '') {    
                        $trackingOrSelfPickup = $currentOrderTrackingNumber;    
                    } else if ($currentOrderShipper == 'PICKUP') {  
                        $trackingOrSelfPickup = "Pickup";   
                    } else {    
                        $trackingOrSelfPickup = "Manually processed";   
                    }
                    foreach ($currentOrder->ORDER_LINES->ORDER_LINE as $orderItem) {    
                        $content = [$orderId, $trackingOrSelfPickup, $orderItem->SKU, $orderItem->QTY_SHIPPED]; 
                        fputcsv($file, $content);   
                    }
                }
            }
        }

        fclose($file);
    } else {
        $log_data[] = 'Connection to '.$store.' Warehouse failed';
    }

    $log_data[] = 'Date and Time of Completion is : '.date("Y-m-d H:i:s");
    $log_data[] = '';
    file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
}


//Get Stock from warehouse
function get_stock_cron_function() {
    if (get_current_blog_id()==1) {
        get_stock_uk('UK');
    } else if (get_current_blog_id()==2) {
        get_stock_nz('NZ');
    } else if (get_current_blog_id()==3) {
        get_stock_au('AU');
    } else if (get_current_blog_id()==4) {
        get_stock_eu('EU');
    }
}
add_action('get_stock_cron', 'get_stock_cron_function');

function get_stock_uk($store) {
    $log_file_path = ABSPATH . 'logs/getstock-'.$store.'.log';
    $log_data = ['Date and Time of Execution is : '.date("Y-m-d H:i:s")];
    $log_data[] = 'Checking stock from '.$store.' Warehouse';
    
    $cclHostname = get_option('hostname');
    $cclUsername = get_option('username');
    $cclPassword = get_option('password');
    $cclStockUpdate = get_option('stock_path');

    $connectionId = @ftp_connect($cclHostname);
    if ((!$connectionId)) {
        $log_data[] = 'Connection Failed';
        $log_data[] = '';
        file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
        throw new \Exception("Couldn't connect to {$cclHostname}");
    }

    $loginResult = @ftp_login($connectionId, $cclUsername, $cclPassword);
    if($loginResult) {
        ftp_pasv($connectionId, true);
        ftp_chdir($connectionId, $cclStockUpdate);
        
        $stockUpdateFilename = 'CCLRRFSTOCK.csv';
        $filename = 'ftp://'.$cclUsername.':'.$cclPassword.'@'.$cclHostname.$cclStockUpdate.$stockUpdateFilename;
        $stockUpdateCsvArray = array();
        $handle = fopen($filename, "r");

        if (($stockUpdateFileContent = fopen($filename, 'r')) === false)
        {
            $log_data[] = 'There was an error loading the CSV file.';
            $log_data[] = '';
            file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
            throw new Exception('There was an error loading the CSV file.');
        } else {
            while (($stockUpdateCsvLine = fgetcsv($stockUpdateFileContent, 1000)) !== false)
            {
                $stockUpdateCsvArray[] = $stockUpdateCsvLine;
            }

            fclose($handle);
        }
        
        $log_data[] = 'Start stock update for UK Warehouse.';

        $pendingProcessingSkuWithQty = getPendingProcessingOrderSkuQty();
        $stockarray = array();
        foreach ($stockUpdateCsvArray as $currentProduct) {
            $currentSKU = $currentProduct[0];
            try {
                $currentProductId = wc_get_product_id_by_sku($currentSKU);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e){
                $currentProductId = '';
            }
            if($currentProductId){
                $currentStock = $currentProduct[1]-$currentProduct[2];
                $qtyToShip = $currentProduct[3];

                $allocatedStock = $qtyToShip;
                $availableQTY = $currentProduct[4];
                if ($availableQTY < 0) {
                    $availableQTY = 0;
                    $currentStock = $qtyToShip;
                }
                
                $bbeDate = '';
                if(isset($currentProduct[5]) && $availableQTY > 0){
                    $bbeDate = $currentProduct[5];
                }
                
                if (array_key_exists($currentSKU, $stockarray)){
                    $stockarray[$currentSKU][0] = $stockarray[$currentSKU][0]+$currentStock;
                    $stockarray[$currentSKU][1] = $stockarray[$currentSKU][1]+$allocatedStock;
                    $stockarray[$currentSKU][2] = $stockarray[$currentSKU][2]+$availableQTY;
                    if ($stockarray[$currentSKU][3]) {
                    	if(strtotime($stockarray[$currentSKU][3])>strtotime($bbeDate)){
	                    	$stockarray[$currentSKU][3] = $bbeDate;
	                    }
                    } else {
                    	$stockarray[$currentSKU][3] = $bbeDate;
                    }
                    $stockarray[$currentSKU][4] = $currentProductId;
                } else {
                    $stockarray[$currentSKU][] = $currentStock;
                    $stockarray[$currentSKU][] = $allocatedStock;
                    $stockarray[$currentSKU][] = $availableQTY;
                    $stockarray[$currentSKU][] = $bbeDate;
                    $stockarray[$currentSKU][] = $currentProductId;
                }
            }
        }
        
        // Stock update code here
        $warehouseSkus = array();
        foreach ($stockarray as $newcurrentSKU => $currentSKU) {  
            $warehouseSkus[] = $newcurrentSKU;
            $currentProductId = $currentSKU[4];
            $availableQTY = $currentSKU[2];
            $log_data[] = 'SKU : '.$newcurrentSKU.' Available QTY : '.$availableQTY;
            
            $disableUpdate = get_post_meta($currentProductId, 'manage_stock_update', true) ? get_post_meta($currentProductId, 'manage_stock_update', true) : 0;
            if ($disableUpdate!=0) {
                $log_data[] = 'Stock update disabled for SKU : '.$newcurrentSKU;
            }
            if ($currentProductId != null && $disableUpdate==0) {
                $availableQTY = $currentSKU[2];
                $totalQty = $currentSKU[0];
                $qtyToShip = $currentSKU[1];
                $bbe_Date = $currentSKU[3];
                $websiteQtyToShip = 0;

                if(isset($pendingProcessingSkuWithQty[$newcurrentSKU])){
                    $websiteQtyToShip = $pendingProcessingSkuWithQty[$newcurrentSKU];
                }
                if ($websiteQtyToShip > $currentSKU[1]) {
                    $qtyToShip = $websiteQtyToShip;
                }

                $availableQTY = $totalQty - $qtyToShip;
                if ($availableQTY < 0) {
                    $availableQTY = 0;
                    $totalQty = $qtyToShip;
                }
                
                // Log for QTY
                $log_data[] = "Product ID => ".$currentProductId;
                $log_data[] = "AVAILABLE QTY => ".$availableQTY;
                $log_data[] = "QTY to SHIP => ".$qtyToShip;
                $log_data[] = "Total QTY => ".$totalQty;
                
                if(($availableQTY > 0)){
                    $log_data[] = "In Stock";
                }else{
                    $log_data[] = "Out of Stock";
                }
                // Log for QTY

                $minSaleQty = get_post_meta($currentProductId, 'min_quantity', true) ? get_post_meta($currentProductId, 'min_quantity', true) : 1;
                $stockIsAvailable = ($availableQTY >= $minSaleQty) ? 1 : 0;

                //Woo update product stock and status
                $product = wc_get_product($currentProductId);
                if($product){
                    $product->set_stock_quantity($availableQTY);
                    $product->set_stock_status($stockIsAvailable ? 'instock' : 'outofstock');
                    $product->save();
                }
                
            }
        }

        $skuCollection = wc_get_products(array('status' => 'publish', 'limit' => -1));
        foreach ($skuCollection as $item) {
            $currentSKU = $item->get_sku();
            if (!in_array($currentSKU, $warehouseSkus)) {
                try {
                    $currentProductId = wc_get_product_id_by_sku($currentSKU);
                } catch (\Magento\Framework\Exception\NoSuchEntityException $e){
                    $currentProductId = '';
                }
                $currentStock = 0;
                $disableUpdate = get_post_meta($currentProductId, 'manage_stock_update', true) ? get_post_meta($currentProductId, 'manage_stock_update', true) : 0;
                if ($disableUpdate!=0) {
                    $log_data[] = 'Stock update disabled for SKU : '.$currentSKU;
                }

                if($currentProductId && $disableUpdate==0){
                    $log_data[] = 'SKU : '.$currentSKU.' Available QTY : '.$currentStock;

                    $qtyToShip = 0;

                    if(isset($pendingProcessingSkuWithQty[$currentSKU])){
                        $qtyToShip = $pendingProcessingSkuWithQty[$currentSKU];
                    }
                    
                    $totalQty = 0;
                    $availableQTY = $totalQty - $qtyToShip;
                    if ($availableQTY < 0) {
                        $availableQTY = 0;
                        $totalQty = $qtyToShip;
                    }
                    
                    // Log for QTY
                    $log_data[] = "Product ID => ".$currentProductId;
                    $log_data[] = "AVAILABLE QTY => ".$availableQTY;
                    $log_data[] = "QTY to SHIP => ".$qtyToShip;
                    $log_data[] = "Total QTY => ".$totalQty;
                    // Log for QTY

                    $stockIsAvailable = ($availableQTY > 0) ? 1 : 0;

                    //Woo update product stock and status
                    $product = wc_get_product($currentProductId);
                    if($product){
                        $product->set_stock_quantity($availableQTY);
                        $product->set_stock_status($stockIsAvailable ? 'instock' : 'outofstock');
                        $product->save();
                    }
                }
            }
        }
    } else {
        $log_data[] = 'Connection to '.$store.' Warehouse failed';
    }
    $log_data[] = 'Date and Time of Completion is : '.date("Y-m-d H:i:s");
    $log_data[] = '';
    file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
}

function get_stock_nz($store) {
    $log_file_path = ABSPATH . 'logs/getstock-'.$store.'.log';
    $log_data = ['Date and Time of Execution is : '.date("Y-m-d H:i:s")];
    $log_data[] = 'Checking stock from '.$store.' Warehouse';

    $stockUpdateFilename = "RRF-SOH-".date("d-m-Y").".csv";
    $filepath = ABSPATH.'stock/scs/'.$stockUpdateFilename;
    $stockUpdateCsvArray = array();

    if (($stockUpdateFileContent = fopen($filepath, "r")) === false)
    {
        $log_data[] = 'There was an error loading the CSV file.';
        $log_data[] = '';
        file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
        throw new Exception('There was an error loading the CSV file.');
    } else {
        while (($stockUpdateCsvLine = fgetcsv($stockUpdateFileContent, 1000)) !== false)
        {
            $stockUpdateCsvArray[] = $stockUpdateCsvLine;
        }

        fclose($stockUpdateFileContent);
    }

    $log_data[] = 'Start stock update for '.$store.' Warehouse.';

    $pendingProcessingSkuWithQty = getPendingProcessingOrderSkuQty();

    // Stock update code here
    $warehouseSkus = array();
    foreach ($stockUpdateCsvArray as $currentProduct) {
        $currentSKU = $currentProduct[0];
        $warehouseSkus[] = $currentSKU;
        try {
            $currentProductId = wc_get_product_id_by_sku($currentSKU);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e){
            $currentProductId = '';
        }

        $currentStock = $currentProduct[6];

        if($currentProductId){
            $log_data[] = 'SKU : '.$currentSKU.' Available QTY : '.$currentStock;
            $disableUpdate = get_post_meta($currentProductId, 'manage_stock_update', true) ? get_post_meta($currentProductId, 'manage_stock_update', true) : 0;
            if ($disableUpdate==0) {
                $qtyToShip = $currentProduct[3];
                $totalQty = $currentStock + $qtyToShip;

                if(isset($pendingProcessingSkuWithQty[$currentSKU]) && $pendingProcessingSkuWithQty[$currentSKU] > $qtyToShip){
                    $qtyToShip = $pendingProcessingSkuWithQty[$currentSKU];
                }
                
                $availableQTY = $totalQty - $qtyToShip;
                if ($availableQTY < 0) {
                    $availableQTY = 0;
                    $totalQty = $qtyToShip;
                }

                if($currentSKU == "ROSITACHILLED"){
                    $currentStock = 10000;
                    $availableQTY = 10000 + $qtyToShip;
                    $totalQty = 10000;
                }
                
                // Log for QTY
                $log_data[] = "Product ID => ".$currentProductId;
                $log_data[] = "AVAILABLE QTY => ".$availableQTY;
                $log_data[] = "QTY to SHIP => ".$qtyToShip;
                $log_data[] = "Total QTY => ".$totalQty;
                
                if(($availableQTY > 0)){
                    $log_data[] = "In Stock";
                }else{
                    $log_data[] = "Out of Stock";
                }
                // Log for QTY

                $minSaleQty = get_post_meta($currentProductId, 'min_quantity', true) ? get_post_meta($currentProductId, 'min_quantity', true) : 1;
                $stockIsAvailable = ($availableQTY >= $minSaleQty) ? 1 : 0;

                //Woo update product stock and status
                $product = wc_get_product($currentProductId);
                if($product){
                    $product->set_stock_quantity($availableQTY);
                    $product->set_stock_status($stockIsAvailable ? 'instock' : 'outofstock');
                    $product->save();
                }
            } else {
                $log_data[] = 'Stock update disabled for SKU : '.$currentSKU;
            }
        }
    }

    $skuCollection = wc_get_products(array('status' => 'publish', 'limit' => -1));
    foreach ($skuCollection as $item) {
        $currentSKU = $item->get_sku();
        if (!in_array($currentSKU, $warehouseSkus)) {
            try {
                $currentProductId = wc_get_product_id_by_sku($currentSKU);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e){
                $currentProductId = '';
            }
            $currentStock = 0;
            $disableUpdate = get_post_meta($currentProductId, 'manage_stock_update', true) ? get_post_meta($currentProductId, 'manage_stock_update', true) : 0;
            if ($disableUpdate!=0) {
                $log_data[] = 'Stock update disabled for SKU : '.$currentSKU;
            }

            if($currentProductId && $disableUpdate==0){
                $log_data[] = 'SKU : '.$currentSKU.' Available QTY : '.$currentStock;
                
                $qtyToShip = 0;

                if(isset($pendingProcessingSkuWithQty[$currentSKU])){
                    $qtyToShip = $pendingProcessingSkuWithQty[$currentSKU];
                }
                
                $totalQty = 0;
                $availableQTY = $totalQty - $qtyToShip;
                if ($availableQTY < 0) {
                    $availableQTY = 0;
                    $totalQty = $qtyToShip;
                }
                
                // Log for QTY
                $log_data[] = "Product ID => ".$currentProductId;
                $log_data[] = "AVAILABLE QTY => ".$availableQTY;
                $log_data[] = "QTY to SHIP => ".$qtyToShip;
                $log_data[] = "Total QTY => ".$totalQty;
                // Log for QTY

                $stockIsAvailable = ($availableQTY > 0) ? 1 : 0;

                //Woo update product stock and status
                $product = wc_get_product($currentProductId);
                if($product){
                    $product->set_stock_quantity($availableQTY);
                    $product->set_stock_status($stockIsAvailable ? 'instock' : 'outofstock');
                    $product->save();
                }
            }
        }
    }

    $destinationDir = ABSPATH.'stock/scs/processed/';
    if (!file_exists($destinationDir)) {
        mkdir($destinationDir, 0755, true);
    }

    // Define the new file path
    $destinationPath = $destinationDir . $stockUpdateFilename;

    // Move the file
    if (rename($filepath, $destinationPath)) {
        $log_data[] = 'File moved to processed folder.';
    } else {
        $log_data[] = 'Failed to move the file to processed folder.';
    }

    $log_data[] = 'Date and Time of Completion is : '.date("Y-m-d H:i:s");
    $log_data[] = '';
    file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
}

function get_stock_au($store) {
    $log_file_path = ABSPATH . 'logs/getstock-'.$store.'.log';
    $log_data = ['Date and Time of Execution is : '.date("Y-m-d H:i:s")];
    $log_data[] = 'Checking stock from '.$store.' Warehouse';

    //Generate Stock Report
    $file_directory = ABSPATH . 'wp-content/reports/';
    if(!file_exists($file_directory)){
        mkdir($file_directory,0777,true);
    }
    $filename = 'Live Stock Report - RRF AU.csv';
    $fp = fopen($file_directory.$filename, 'w');
    fputcsv($fp, array('sku', 'code', 'qty', 'available_qty', 'ship_qty', 'stock_status'));
    
    $headers = array(
        "Authorization: ".get_option('quantium_access_key'),
        "Content-Type: application/xml",
    );
    
    $requestUrl=get_option('get_stock_url');

    $xmlStart = '<?xml version="1.0" encoding="utf-8"?>                               
                    <item_balance>                              
                        <client_code>AGT</client_code>                          
                        <warehouse_id>QSAUSF</warehouse_id>                         
                        <item_numbers>';
    $xmlEnd = '</item_numbers>
                    <include_attributes>Y</include_attributes>
                    <attribute1></attribute1>
                    <attribute2></attribute2>
                    <attribute3></attribute3>
                    <attribute4></attribute4>
                    <attribute5>RRF</attribute5>
                    <attribute6></attribute6>
                    <attribute7></attribute7>
                    <attribute8></attribute8>
                    <attribute9></attribute9>
                    <attribute10></attribute10>
                    <attribute11></attribute11>
                    <pagination>
                        <limit>10</limit>
                        <page>1</page>
                    </pagination>
                </item_balance>';

    $i = 0; $j = 0; $skulist = '';

    $pendingProcessingSkuWithQty = getPendingProcessingOrderSkuQty();
    $skuCollection = wc_get_products(array('status' => 'publish', 'limit' => -1));
    foreach($skuCollection as $item){
        $i++; $j++;
        $skulist .= '<item_number>'.$item->get_sku().'</item_number>';
        
        if ($i==10 || $j==count($skuCollection)) {
            $xmlRequest = $xmlStart.$skulist.$xmlEnd;
            
            $ch = curl_init($requestUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlRequest);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            //print_r($result);
            
            try {
                $resultArr = simplexml_load_string($result);
                foreach ($resultArr->response as $response) {
                    $responseArr = (array)$response;
                    if (isset($responseArr['item_number']) && isset($responseArr['available_qty'])) {
                        $currentSKU = (string)$responseArr['item_number'];
                        try {
                            $currentProductId = wc_get_product_id_by_sku($currentSKU);
                        } catch (\Magento\Framework\Exception\NoSuchEntityException $e){
                            $currentProductId = '';
                            $log_data[] = 'Product "'.$responseArr['item_number'].'" stock does not updated';
                        }
                        $currentStock = $responseArr['actual_qty'];

                        if($currentProductId){
                            $disableUpdate = get_post_meta($currentProductId, 'manage_stock_update', true) ? get_post_meta($currentProductId, 'manage_stock_update', true) : 0;
                            if ($disableUpdate==0) {
                                $log_data[] = 'SKU : '.$currentSKU.' Available QTY : '.$responseArr['available_qty'].' Total QTY : '.$currentStock.' Allocated QTY : '.$responseArr['allocated_qty'];
                                
                                $qtyToShip = 0;

                                if(isset($pendingProcessingSkuWithQty[$currentSKU])){
                                    $qtyToShip = $pendingProcessingSkuWithQty[$currentSKU];
                                }

                                if ($currentStock <= $qtyToShip) {
                                    $availableQTY = 0;
                                    $currentStock = $qtyToShip;
                                } else {
                                    if ($qtyToShip > $responseArr['allocated_qty']) {
                                        $availableQTY = $responseArr['available_qty'] + $responseArr['allocated_qty'] - $qtyToShip;
                                    } else {
                                        $availableQTY = $responseArr['available_qty'];
                                        $qtyToShip = $responseArr['allocated_qty'];
                                    }
                                    if ($availableQTY < 0) {
                                        $currentStock = $qtyToShip;
                                    } else {
                                        $currentStock = $availableQTY + $qtyToShip;
                                    }
                                }

                                if($currentSKU == "FSCHILLED"){
                                    $currentStock = 10000;
                                    $availableQTY = 10000 + $qtyToShip;
                                    $totalQty = 10000;
                                }
                                
                                $log_data[] = "Product ID => ".$currentProductId;
                                $log_data[] = "AVAILABLE QTY => ".$availableQTY;
                                $log_data[] = "SCS QTY => ".$currentStock;
                                $log_data[] = "QTY to SHIP => ".$qtyToShip;
                                
                                if(($availableQTY > 0)){
                                    $log_data[] = "In Stock";
                                }else{
                                    $log_data[] = "Out of Stock";
                                }
                                // Log for QTY

                                $minSaleQty = get_post_meta($currentProductId, 'min_quantity', true) ? get_post_meta($currentProductId, 'min_quantity', true) : 1;
                                $stockIsAvailable = ($availableQTY >= $minSaleQty) ? 1 : 0;

                                //Woo update product stock and status
                                $product = wc_get_product($currentProductId);
                                if($product){
                                    $product->set_stock_quantity($availableQTY);
                                    $product->set_stock_status($stockIsAvailable ? 'instock' : 'outofstock');
                                    $product->save();
                                }

                                $log_data[] = 'Product "'.$responseArr['item_number'].'" stock updated';

                                //Generate Stock Report
                                fputcsv($fp, array($currentSKU, 'austore', $currentStock, $availableQTY, $qtyToShip, $stockIsAvailable));
                            } else {
                                $log_data[] = 'Stock update disabled for SKU : '.$currentSKU;
                            }    
                        }
                    }
                }
            } catch (Exception $e) {
                $log_data[] = 'Error in response';
            }

            $skulist = ''; $i = 0;
        }
    }

    //Generate Stock Report
    fclose($fp);
    
    $log_data[] = 'Date and Time of Completion is : '.date("Y-m-d H:i:s");
    $log_data[] = '';
    file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
}

function get_stock_eu($store) {
    $log_file_path = ABSPATH . 'logs/getstock-'.$store.'.log';
    $log_data = ['Date and Time of Execution is : '.date("Y-m-d H:i:s")];
    $log_data[] = 'Checking stock from '.$store.' Warehouse';
    
    $cclHostname = get_option('hostname');
    $cclUsername = get_option('username');
    $cclPassword = get_option('password');
    $cclStockUpdate = get_option('stock_path');

    $connectionId = @ftp_connect($cclHostname);
    if ((!$connectionId)) {
        $log_data[] = 'Connection Failed';
        $log_data[] = '';
        file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
        throw new \Exception("Couldn't connect to {$cclHostname}");
    }

    $loginResult = @ftp_login($connectionId, $cclUsername, $cclPassword);
    if($loginResult) {
        ftp_pasv($connectionId, true);
        ftp_chdir($connectionId, $cclStockUpdate);
        
        $stockUpdateFilename = "Rosita_stock_overview.csv";
        $filename = 'ftp://'.$cclUsername.':'.$cclPassword.'@'.$cclHostname.$cclStockUpdate.$stockUpdateFilename;
        $stockUpdateCsvArray = array();
        $handle = fopen($filename, "r");
        if (($stockUpdateFileContent = fopen($filename, 'r')) === false)
        {
            $log_data[] = 'There was an error loading the CSV file.';
            $log_data[] = '';
            file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
            throw new Exception('There was an error loading the CSV file.');
        } else {
            while (($stockUpdateCsvLine = fgetcsv($stockUpdateFileContent, 1000, ";")) !== false)
            {
                $stockUpdateCsvArray[] = $stockUpdateCsvLine;
            }

            fclose($handle);
        }
        
        $log_data[] = 'Start stock update for UK Warehouse.';

        $pendingProcessingSkuWithQty = getPendingProcessingOrderSkuQty();
        $stockarray = array();
        foreach ($stockUpdateCsvArray as $currentProduct) {
            $currentSKU = $currentProduct[0];
            try {
                $currentProductId = wc_get_product_id_by_sku($currentSKU);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e){
                $currentProductId = '';
            }
            if($currentProductId){
                $currentSKU = $currentProduct[0];
                $currentStock = $currentProduct[3];
                
                $qtyToShip = $currentProduct[4];

                $allocatedStock = $qtyToShip;
                $availableQTY = $currentStock - $allocatedStock;
                if ($availableQTY < 0) {
                    $availableQTY = 0;
                    $currentStock = $qtyToShip;
                }
                
                $bbeDate = '';
                if(isset($currentProduct[7]) && $availableQTY > 0){
                    $bbeDate = $currentProduct[7];
                }
                
                if (array_key_exists($currentSKU, $stockarray)){
                    $stockarray[$currentSKU][0] = $stockarray[$currentSKU][0]+$currentStock;
                    $stockarray[$currentSKU][1] = $stockarray[$currentSKU][1]+$allocatedStock;
                    $stockarray[$currentSKU][2] = $stockarray[$currentSKU][2]+$availableQTY;
                    if ($stockarray[$currentSKU][3]) {
                    	if(strtotime($stockarray[$currentSKU][3])>strtotime($bbeDate)){
	                    	$stockarray[$currentSKU][3] = $bbeDate;
	                    }
                    } else {
                    	$stockarray[$currentSKU][3] = $bbeDate;
                    }
                    $stockarray[$currentSKU][4] = $currentProductId;
                } else {
                    $stockarray[$currentSKU][] = $currentStock;
                    $stockarray[$currentSKU][] = $allocatedStock;
                    $stockarray[$currentSKU][] = $availableQTY;
                    $stockarray[$currentSKU][] = $bbeDate;
                    $stockarray[$currentSKU][] = $currentProductId;
                }
            }
        }
        
        // Stock update code here
        $warehouseSkus = array();
        foreach ($stockarray as $newcurrentSKU => $currentSKU) {  
            $warehouseSkus[] = $newcurrentSKU;
            $currentProductId = $currentSKU[4];
            $availableQTY = $currentSKU[2];
            $log_data[] = 'SKU : '.$newcurrentSKU.' Available QTY : '.$availableQTY;
            
            $disableUpdate = get_post_meta($currentProductId, 'manage_stock_update', true) ? get_post_meta($currentProductId, 'manage_stock_update', true) : 0;
            if ($disableUpdate!=0) {
                $log_data[] = 'Stock update disabled for SKU : '.$newcurrentSKU;
            }
            if ($currentProductId != null && $disableUpdate==0) {
                $availableQTY = $currentSKU[2];
                $totalQty = $currentSKU[0];
                $qtyToShip = $currentSKU[1];
                $bbe_Date = $currentSKU[3];
                $websiteQtyToShip = 0;

                if(isset($pendingProcessingSkuWithQty[$newcurrentSKU])){
                    $websiteQtyToShip = $pendingProcessingSkuWithQty[$newcurrentSKU];
                }
                if ($websiteQtyToShip > $currentSKU[1]) {
                    $qtyToShip = $websiteQtyToShip;
                }

                $availableQTY = $totalQty - $qtyToShip;
                if ($availableQTY < 0) {
                    $availableQTY = 0;
                    $totalQty = $qtyToShip;
                }
                if($newcurrentSKU == "ROSITACHILLED"){
                    $availableQTY = 10000 - $qtyToShip;
                    $totalQty = 10000;
                }
                
                // Log for QTY
                $log_data[] = "Product ID => ".$currentProductId;
                $log_data[] = "AVAILABLE QTY => ".$availableQTY;
                $log_data[] = "QTY to SHIP => ".$qtyToShip;
                $log_data[] = "Total QTY => ".$totalQty;
                
                if(($availableQTY > 0)){
                    $log_data[] = "In Stock";
                }else{
                    $log_data[] = "Out of Stock";
                }
                // Log for QTY

                $minSaleQty = get_post_meta($currentProductId, 'min_quantity', true) ? get_post_meta($currentProductId, 'min_quantity', true) : 1;
                $stockIsAvailable = ($availableQTY >= $minSaleQty) ? 1 : 0;

                //Woo update product stock and status
                $product = wc_get_product($currentProductId);
                if($product){
                    $product->set_stock_quantity($availableQTY);
                    $product->set_stock_status($stockIsAvailable ? 'instock' : 'outofstock');
                    $product->save();
                }
            }
        }

        $skuCollection = wc_get_products(array('status' => 'publish', 'limit' => -1));
        foreach ($skuCollection as $item) {
            $currentSKU = $item->get_sku();
            if (!in_array($currentSKU, $warehouseSkus)) {
                try {
                    $currentProductId = wc_get_product_id_by_sku($currentSKU);
                } catch (\Magento\Framework\Exception\NoSuchEntityException $e){
                    $currentProductId = '';
                }
                $currentStock = 0;
                $disableUpdate = get_post_meta($currentProductId, 'manage_stock_update', true) ? get_post_meta($currentProductId, 'manage_stock_update', true) : 0;
                if ($disableUpdate!=0) {
                    $log_data[] = 'Stock update disabled for SKU : '.$currentSKU;
                }

                if($currentProductId && $disableUpdate==0){
                    $log_data[] = 'SKU : '.$currentSKU.' Available QTY : '.$currentStock;

                    $qtyToShip = 0;

                    if(isset($pendingProcessingSkuWithQty[$currentSKU])){
                        $qtyToShip = $pendingProcessingSkuWithQty[$currentSKU];
                    }
                    
                    $totalQty = 0;
                    $availableQTY = $totalQty - $qtyToShip;
                    if ($availableQTY < 0) {
                        $availableQTY = 0;
                        $totalQty = $qtyToShip;
                    }
                    
                    // Log for QTY
                    $log_data[] = "Product ID => ".$currentProductId;
                    $log_data[] = "AVAILABLE QTY => ".$availableQTY;
                    $log_data[] = "Total QTY => ".$totalQty;
                    $log_data[] = "QTY to SHIP => ".$qtyToShip;
                    // Log for QTY

                    $stockIsAvailable = ($availableQTY > 0) ? 1 : 0;

                    //Woo update product stock and status
                    $product = wc_get_product($currentProductId);
                    if($product){
                        $product->set_stock_quantity($availableQTY);
                        $product->set_stock_status($stockIsAvailable ? 'instock' : 'outofstock');
                        $product->save();
                    }
                }
            }
        }
    } else {
        $log_data[] = 'Connection to '.$store.' Warehouse failed';
    }
    $log_data[] = 'Date and Time of Completion is : '.date("Y-m-d H:i:s");
    $log_data[] = '';
    file_put_contents($log_file_path, implode("\n", $log_data), FILE_APPEND | LOCK_EX);
}


function getPendingProcessingOrderSkuQty(){
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
