<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_orders', $has_orders ); 
$current_user = wp_get_current_user();
?>

<div class="account-header-wrapper order-history">
    <section class="account-header sales_order_history">
        <h2><?php echo __('My Previous Orders', 'storefrontchild'); ?></h2>
    </section>
</div>
<div class="account-intro">
    <div class="content-main">
        <div class="row">
            <div class="col-8 offset-2 col-sm-4 offset-sm-0 offset-lg-1 col-lg-3 offset-xl-2 col-xl-2">
                <div class="avatar-image">
                    <img src="<?php echo get_theme_file_uri()?>/assets/images/Previous_icon.svg" class="customer-avatar">
                </div>
            </div>
            <div class="col-sm-12 col-lg-7 col-xl-6">
                <div class="account-intro-main">
                    <h3><?php echo __('Review Or Re-order', 'storefrontchild'); ?></h3>
                    <p class="midium"><?php echo __("Want to review a previous order or perhaps just order the same thing again? All the details of the wonderful products you have ordered are below. Simply click on the 'view order' button, or the 'add to cart' button to order the same thing again. Remember you are able to have products delivered on a regular basis, just select the desired frequency on the product page.", "storefrontchild"); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>


<section class="account-content-wrapper">
	<div class="content-main">
		<div class="row">
			<div class="col-xl-8 offset-xl-2 sales-orders-list">
				<?php if ( $has_orders ) : ?>
					<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
						<thead>
							<tr>
								<th scope="col" class="col id"><?php echo __('Order #', 'storefrontchild'); ?></th>
								<th scope="col" class="col date"><?php echo __('Date', 'storefrontchild'); ?></th>
								<th scope="col" class="col shipping"><?php echo __('Ship To', 'storefrontchild'); ?></th>
								<th scope="col" class="col total"><?php echo __('Order Total', 'storefrontchild'); ?></th>
								<th scope="col" class="col status"><?php echo __('Status', 'storefrontchild'); ?></th>
								<th scope="col" class="col actions"><?php echo __('View Order', 'storefrontchild'); ?></th>
								<th scope="col" class="col actions"><?php echo __('Reorder', 'storefrontchild'); ?></th>
								<th scope="col" class="col actions"><?php echo __('Track Order', 'storefrontchild'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ( $customer_orders->orders as $customer_order ) {
								$order = wc_get_order( $customer_order );
								$item_count = $order->get_item_count() - $order->get_item_count_refunded();
								$shipping_address = $order->get_address('shipping');
								$ship_to_name = $shipping_address['first_name'] . ' ' . $shipping_address['last_name'];
								?>
								<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order">
									<td data-th="Order #" class="col id"><?php echo $order->get_order_number(); ?></td>
									<td data-th="Date" class="col date"><?php echo esc_html( wc_format_datetime( $order->get_date_created(), 'd/m/Y' ) ); ?></td>
									<td data-th="Ship To" class="col shipping"><?php echo $ship_to_name; ?></td>
									<td data-th="Order Total" class="col total"><span class="price"><?php echo $order->get_formatted_order_total(); ?></span></td>
									<td data-th="Status" class="col status"><?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></td>
									<td data-th="View Order" class="col actions"><a href="<?php echo wc_get_endpoint_url( 'view-order', $order->ID ); ?>" class="action view"><img src="<?php echo get_theme_file_uri()?>/assets/images/eye.svg" alt="View Order"></a></td>
									<td data-th="Reorder" class="col actions">
										<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'order_again', $order->get_id() ) , 'woocommerce-order_again' ) ); ?>" class="action reorder">
											<img src="<?php echo get_theme_file_uri(); ?>/assets/images/reorder.svg" alt="Reorder">
										</a>
									</td>
									<td data-th="Track Order" class="col actions">
										<!-- <a href="#" title="Track your order"><img src="<php echo get_theme_file_uri()?>/assets/images/track.svg" alt="Track your order"></a> -->
									</td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>

					<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

					<div class="order-grid-toolbar toolbar bottom">
						<div class="pager">
							<?php
								$items_per_page = isset($_GET['limit']) && is_numeric($_GET['limit']) ? absint($_GET['limit']) : 10;
								$start_item = ($current_page - 1) * $items_per_page + 1;
								$end_item = min($start_item + $items_per_page - 1, $customer_orders->total);
								$total_items = $customer_orders->total;
							?>
							<p class="toolbar-amount">
								<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
									<span class="toolbar-number"><?php echo wp_kses_post(sprintf(__('Items %1$s to %2$s of %3$s total', 'storefrontchild'), $start_item, $end_item, $total_items)); ?></span>
								<?php else : ?>
									<span class="toolbar-number"><?php echo wp_kses_post( sprintf( _n( '%1$s Item', '%1$s Items', 'storefrontchild' ), count($customer_orders->orders) ) ); ?></span>
								<?php endif; ?>
							</p>
							<div class="limiter">
								<strong class="limiter-label">Show</strong> 
								<select id="limiter" class="limiter-options" onchange="location = this.value;">
									<option value="<?php echo esc_url( wc_get_endpoint_url( 'orders' ) ); ?>" <?php selected( 10, $items_per_page ); ?>>10</option>
									<option value="<?php echo esc_url( add_query_arg( 'limit', 20, wc_get_endpoint_url( 'orders' ) ) ); ?>" <?php selected( 20, $items_per_page ); ?>>20</option>
									<option value="<?php echo esc_url( add_query_arg( 'limit', 50, wc_get_endpoint_url( 'orders' ) ) ); ?>" <?php selected( 50, $items_per_page ); ?>>50</option>
								</select>
								<span class="limiter-text">per page</span>
							</div>
							<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
								<div class="pages">
									<ul class="items pages-items" aria-labelledby="paging-label">
										<?php if ( 1 !== $current_page ) : ?>
											<li class="item pages-item-previous"><a class="page action previous" href="<?php echo esc_url( add_query_arg( 'limit', $items_per_page, wc_get_endpoint_url( 'orders', $current_page - 1 ) ) ); ?>" title="Previous"><i class="fas fa-chevron-left"></i></a></li>
										<?php endif; ?>
										<?php
										$start_page = max( 1, $current_page - 1 );
										$end_page = min( $start_page + 2, $customer_orders->max_num_pages );
										if ( $start_page > 1 ) :
										?>
											<li class="item">
												<a href="<?php echo esc_url( add_query_arg( 'limit', $items_per_page, wc_get_endpoint_url( 'orders', 1 ) ) ); ?>" class="page"><span>1</span></a>
											</li>
											<?php if ( $start_page > 2 ) : ?>
												<li class="item">
													<span class="page">...</span>
												</li>
											<?php endif; ?>
										<?php endif; ?>
										<?php for ( $i = $start_page; $i <= $end_page; $i++ ) { ?>
											<?php if ( $i == $current_page ) : ?>
												<li class="item current">
													<strong class="page"><span><?php echo $i; ?></span></strong>
												</li>
											<?php else : ?>
												<li class="item">
													<a href="<?php echo esc_url( add_query_arg( 'limit', $items_per_page, wc_get_endpoint_url( 'orders', $i ) ) ); ?>" class="page"><span><?php echo $i; ?></span></a>
												</li>
											<?php endif; ?>
										<?php } ?>
										<?php if ( $end_page < $customer_orders->max_num_pages ) : ?>
											<?php if ( $end_page < $customer_orders->max_num_pages - 1 ) : ?>
												<li class="item">
													<span class="page">...</span>
												</li>
											<?php endif; ?>
											<li class="item">
												<a href="<?php echo esc_url( add_query_arg( 'limit', $items_per_page, wc_get_endpoint_url( 'orders', $customer_orders->max_num_pages ) ) ); ?>" class="page"><span><?php echo $customer_orders->max_num_pages; ?></span></a>
											</li>
										<?php endif; ?>
										<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
											<li class="item pages-item-next"><a class="page action next" href="<?php echo esc_url( add_query_arg( 'limit', $items_per_page, wc_get_endpoint_url( 'orders', $current_page + 1 ) ) ); ?>" title="Next"><i class="fas fa-chevron-right"></i></a></li>
										<?php endif; ?>
									</ul>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php else : ?>
				<div class="message info"><i class="fas fa-exclamation-triangle"></i><span><?php echo __('You have placed no orders.', 'storefrontchild'); ?></span></div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
