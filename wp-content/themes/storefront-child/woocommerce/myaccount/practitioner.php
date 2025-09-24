<?php
    defined( 'ABSPATH' ) || exit;
    $current_user = wp_get_current_user();
    $role = $current_user->roles[0];
    $currency = get_woocommerce_currency_symbol();
?>
<div class="account-header-wrapper practitioner">
    <section class="account-header">
        <h2><?php echo __('Practitioner Information'); ?></h2>
    </section>
    <div class="account-intro">
        <div class="content-main">
            <div class="row">
                <div class="col-8 offset-2 col-md-4 offset-md-0 offset-lg-1 col-lg-3 offset-xl-2 col-xl-2">
                    <div class="avatar-image">
                        <img src="<?php echo get_theme_file_uri()?>/assets/images/Account_Practitioner.svg" alt="Account avatar" class="customer-avatar practitioner-avatar">
                    </div>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-7 col-xl-6">
                    <div class="account-intro--main">
                        <?php if($role=='um_practitioner') : ?>
                            <p><?php echo __('As a practitioner you will get 20% off all products, you can also encourage your clients to register as a Practitioner client and they will benefit from a 10% discount. They can do this by using your name and your 4 digit reference code below. As an added bonus you receive a 10% commission on their orders, T&C\'s apply.', 'storefrontchild'); ?></p>
                            <p><?php echo __('Please note commission is paid out once it reaches '.$currency.'50.00', 'storefrontchild'); ?></p>
                        <?php elseif ($role=='um_practitioner-client') : ?>
                            <p><?php echo __('You are currently a registered member of our Practitioner Program.', 'storefrontchild'); ?></p>
                        <?php else : ?>
                            <h3><?php echo __('Join The Program', 'storefrontchild'); ?></h3>
                            <p>
                                <?php echo __('You are not currently a registered member of our Practitioner Program. If you would like to hear more about this service, to register as a qualified healthcare practitioner or to talk with us first hand please choose one of the options below.', 'storefrontchild'); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="account-content-wrapper">
    <div class="content-main">
        <div class="row">
            <div class="col-xl-8 offset-xl-2 customer-account-practitioner">
                <?php if($role=='um_practitioner') : ?>
                    <?php if(isset($_GET['client']) && $_GET['client']!='') : ?>
                        <?php
                            $client_id = rtrim($_GET['client'], '/');
                            $client = get_user_by('ID', $client_id);
                            $client_practitioner_id = get_user_meta($client_id, 'practitioner_code', true);
                        ?>
                        <?php if($client && $client_practitioner_id==$current_user->ID) : ?>
                            <?php if(isset($_GET['order']) && $_GET['order']!='') : ?>
                                <?php
                                    $order_id = rtrim($_GET['order'], '/');
                                    $order = wc_get_order($order_id);
                                ?>
                                <?php if(!$order) : ?>
                                    <div class="message info"><i class="fas fa-exclamation-triangle"></i><span><?php echo __('Order data not found.', 'storefrontchild'); ?></span></div>
                                <?php else : ?>
                                    <?php $order_items = $order->get_items(); ?>
                                    <div class="row">
                                        <div class="practitioner-accounts practitioner-clients col-xs-12">
                                            <div class="block">
                                                <div class="block-title">
                                                    <strong><?php echo $client->first_name." ".$client->last_name."'s Order ".$order->get_order_number(); ?></strong>
                                                </div>
                                                <div class="table-wrapper practitioner-clients-history sales-orders-list">
                                                    <table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table" id="my-orders-table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" class="col name"><?php echo __('Product Name', 'storefrontchild'); ?></th>
                                                                <th scope="col" class="col sku"><?php echo __('SKU', 'storefrontchild'); ?></th>
                                                                <th scope="col" class="col qty"><?php echo __('Quantity', 'storefrontchild'); ?></th>
                                                                <th scope="col" class="col sales"><?php echo __('Line Total', 'storefrontchild'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($order_items as $item) : ?>
                                                                <?php $product = $item->get_product(); ?>
                                                                <tr>
                                                                    <td data-th="Product Name" class="col name"><?php echo $item->get_name(); ?></td>
                                                                    <td data-th="SKU" class="col sku"><?php echo $product->get_sku(); ?></td>
                                                                    <td data-th="Quantity" class="col qty"><?php echo $item->get_quantity(); ?></td>
                                                                    <td data-th="Line Total" class="col sales"><?php echo $currency.round($item->get_total(), 2) ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php else : ?>
                                <?php
                                    $client_orders = get_posts(array(
                                        'numberposts' => -1,
                                        'meta_query'  => array(
                                            'relation' => 'AND', // Use 'AND' for multiple meta queries
                                            array(
                                                'key'     => '_customer_user',
                                                'value'   => $client_id,
                                                'compare' => '='
                                            ),
                                            array(
                                                'key'     => 'practitioner_id',
                                                'value'   => $current_user->ID,
                                                'compare' => '='
                                            ),
                                        ),
                                        'post_type'   => 'shop_order',
                                        'post_status' => 'wc-completed',
                                    ));
                                    $total_sales = 0;
                                ?>
                                <div class="row">
                                    <div class="practitioner-accounts practitioner-clients col-xs-12">
                                        <div class="block">
                                            <div class="block-title">
                                                <strong><?php echo $client->first_name.' '.$client->last_name; ?>'s Orders</strong>
                                            </div>
                                            <?php if(!count($client_orders)) : ?>
                                                <div class="message info"><i class="fas fa-exclamation-triangle"></i><span><?php echo __('This client does not have any order yet.', 'storefrontchild'); ?></span></div>
                                            <?php else : ?>
                                                <div class="table-wrapper practitioner-clients-history sales-orders-list">
                                                    <table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table" id="my-orders-table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" class="col number"><?php echo __('Order No.', 'storefrontchild'); ?></th>
                                                                <th scope="col" class="col status"><?php echo __('Order Status', 'storefrontchild'); ?></th>
                                                                <th scope="col" class="col items"><?php echo __('No. Items', 'storefrontchild'); ?></th>
                                                                <th scope="col" class="col sales"><?php echo __('Order Total', 'storefrontchild'); ?></th>
                                                                <th scope="col" class="col date"><?php echo __('Order Date', 'storefrontchild'); ?></th>
                                                                <th scope="col" class="col actions"><?php echo __('View', 'storefrontchild'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($client_orders as $row) : ?>
                                                                <?php $order = wc_get_order($row->ID); ?>
                                                                <tr>
                                                                    <td data-th="Order No." class="col name"><?php echo $order->get_order_number(); ?></td>
                                                                    <td data-th="Order Status" class="col status"><?php echo wc_get_order_status_name($order->get_status()); ?></td>
                                                                    <td data-th="No. Items" class="col items"><?php echo $order->get_item_count(); ?></td>
                                                                    <td data-th="Order Total" class="col sales"><?php echo $currency.$order->get_total(); ?></td>
                                                                    <td data-th="Order Date" class="col date"><?php echo $order->get_date_created()->date('d/m/Y'); ?></td>
                                                                    <td data-th="View" class="col actions"><a href="<?php echo wc_get_endpoint_url( 'practitioner/?client='.$client_id.'&order='.$order->ID); ?>" class="action view"><img src="<?php echo get_theme_file_uri()?>/assets/images/eye.svg" alt="View Orders"></a></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php else : ?>
                            <div class="message info"><i class="fas fa-exclamation-triangle"></i><span><?php echo __('There is something wrong with client id. Please contact customer support.', 'storefrontchild'); ?></span></div>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php
                            $practitioner_id = $current_user->ID;
                            $practitioner_client_users = get_users(array(
                                'role' => 'um_practitioner-client',
                                'meta_key'    => 'practitioner_code',
                                'meta_value'  => $practitioner_id,
                            ));
                            $commission = get_option('practitioner_commission_rate') ? get_option('practitioner_commission_rate') : 10;
                            $customer_orders = get_posts(array(
                                'numberposts' => -1,
                                'meta_key'    => 'practitioner_id',
                                'meta_value'  => $practitioner_id,
                                'post_type'   => 'shop_order',
                                'post_status' => 'wc-completed',
                            ));
                            $to_be_paid = 0;
                            $amount_paid = 0;
                            foreach ($customer_orders as $customer_order) {
                                $order = wc_get_order($customer_order->ID);
                                if ($order->get_meta('practitioner_paid')==0) {
                                    $to_be_paid += $order->get_total();
                                } else {
                                    $amount_paid += $order->get_total();
                                }
                            }
                        ?>
                        <div class="row">
                            <div class="practitioner-accounts col-xs-12 col-sm-6">
                                <div class="block">
                                    <div class="block-title"><strong><?php echo __('Your Information', 'storefrontchild'); ?></strong></div>
                                    <div class="practitioner-info">
                                        <p><strong><?php echo __('Practitioner Name:', 'storefrontchild'); ?></strong> <?php echo $current_user->first_name.' '.$current_user->last_name; ?></p>
                                        <p><strong><?php echo __('Unique Code:', 'storefrontchild'); ?></strong> <?php echo $practitioner_id; ?></p>
                                        <p><strong><?php echo __('Number of Clients:', 'storefrontchild'); ?></strong> <?php echo count($practitioner_client_users); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="practitioner-accounts col-xs-12 col-sm-6">
                                <div class="block">
                                    <div class="block-title"><strong><?php echo __('Your Commission', 'storefrontchild'); ?></strong></div>
                                    <div class="practitioner-info">
                                        <p><strong><?php echo __('Total Paid:', 'storefrontchild'); ?></strong> <?php echo $currency.ROUND(($amount_paid/100)*$commission, 2); ?></p>
                                        <p><strong><?php echo __('To Be Paid:', 'storefrontchild'); ?></strong> <?php echo $currency.ROUND(($to_be_paid/100)*$commission, 2); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="practitioner-accounts practitioner-clients col-xs-12">
                                <div class="block">
                                    <div class="block-title">
                                        <strong><?php echo __('Your Clients', 'storefrontchild'); ?></strong>
                                    </div>
                                    <?php if(!count($practitioner_client_users)) : ?>
                                        <div class="message info empty"><span><?php echo __('You do not have any clients yet.', 'storefrontchild'); ?></span></div>
                                    <?php else : ?>
                                        <div class="table-wrapper practitioner-clients-history sales-orders-list">
                                            <table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table" id="my-orders-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="col name"><?php echo __('Name', 'storefrontchild'); ?></th>
                                                        <th scope="col" class="col orders"><?php echo __('No. Orders', 'storefrontchild'); ?></th>
                                                        <th scope="col" class="col sales"><?php echo __('Total Sales', 'storefrontchild'); ?></th>
                                                        <th scope="col" class="col actions"><?php echo __('View', 'storefrontchild'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($practitioner_client_users as $user) : ?>
                                                        <?php
                                                            $status = get_user_meta($user->ID, 'account_status', true);
                                                            if ($status === 'awaiting_admin_review') { continue; }
                                                            $customer_orders = get_posts(array(
                                                                'numberposts' => -1,
                                                                'meta_query'  => array(
                                                                    'relation' => 'AND', // Use 'AND' for multiple meta queries
                                                                    array(
                                                                        'key'     => '_customer_user',
                                                                        'value'   => $user->ID,
                                                                        'compare' => '='
                                                                    ),
                                                                    array(
                                                                        'key'     => 'practitioner_id',
                                                                        'value'   => $practitioner_id,
                                                                        'compare' => '='
                                                                    ),
                                                                ),
                                                                'post_type'   => 'shop_order',
                                                                'post_status' => 'wc-completed',
                                                            ));
                                                            $total_sales = 0;
                                                            foreach ($customer_orders as $customer_order) {
                                                                $order = wc_get_order($customer_order->ID);
                                                                $total_sales += $order->get_total();
                                                            }
                                                        ?>
                                                        <tr>
                                                            <td data-th="Name" class="col name"><?php echo $user->first_name.' '.$user->last_name; ?></td>
                                                            <td data-th="No. Orders" class="col orders"><?php echo count($customer_orders); ?></td>
                                                            <td data-th="Total Sales" class="col sales"><?php echo $currency.$total_sales; ?></td>
                                                            <td data-th="View" class="col actions"><a href="<?php echo wc_get_endpoint_url( 'practitioner/?client='.$user->ID); ?>" class="action view"><img src="<?php echo get_theme_file_uri()?>/assets/images/eye.svg" alt="View Orders"></a></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php elseif ($role=='um_practitioner-client') : ?>
                    <?php
                        $practitioner_id = get_user_meta($current_user->ID, 'practitioner_code', true);
                        $practitioner = get_user_by('ID', $practitioner_id);
                    ?>
                    <div class="practitioner-accounts">
                        <div class="block">
                            <div class="block-title"><strong><?php echo __('Your Practitioner\'s Information', 'storefrontchild'); ?></strong></div>
                            <div class="practitioner-info">
                                <p><strong><?php echo __('Practitioner\'s Name:', 'storefrontchild'); ?></strong> <?php echo $practitioner->first_name.' '.$practitioner->last_name; ?></p>
                                <p><strong><?php echo __('Unique Code:', 'storefrontchild'); ?></strong> <?php echo $practitioner_id; ?></p>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="practitioner-accounts">
                        <div class="block">
                            <div class="block-title"><strong><?php echo __('Register with Rosita Real Foods', 'storefrontchild'); ?></strong></div>
                            <div class="practitioner-link">
                                <div>
                                    <p><?php echo __('If you would like to join our practitioners program and are a qualified health care practitioner,
                                        please click here.', 'storefrontchild'); ?></p>
                                </div>
                                <div><a class="btn btn-green btn-default btn-green-inverse practitioner-register"
                                    href="/my-account/practitioner-register" type="button"><span><?php echo __('Register', 'storefrontchild'); ?></span></a></div>
                            </div>
                        </div>
                        <div class="block">
                            <div class="block-title"><strong><?php echo __('Link your account', 'storefrontchild'); ?></strong></div>
                            <div class="practitioner-link">
                                <div>
                                    <p><?php echo __('If you are an existing client of one of our practitioners and would like to link your account,
                                        please click here', 'storefrontchild'); ?></p>
                                </div>
                                <div><a class="btn btn-green btn-default btn-green-inverse practitioner-link" href="/my-account/practitioner-clientlink"
                                    type="button"><span><?php echo __('Link', 'storefrontchild'); ?></span></a></div>
                            </div>
                        </div>
                        <div class="block">
                            <div class="block-title"><strong><?php echo __('Contact us', 'storefrontchild'); ?></strong></div>
                            <div class="practitioner-link">
                                <div>
                                    <p><?php echo __('If you have any questions about our program and it\'s benefits, please click here.', 'storefrontchild'); ?></p>
                                </div>
                                <div><a class="btn btn-green btn-default btn-green-inverse practitioner-contact" href="/contact"
                                    type="button"><span><?php echo __('Contact Us', 'storefrontchild'); ?></span></a></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>