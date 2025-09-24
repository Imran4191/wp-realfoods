<?php
/**
 * My Subscriptions section on the My Account page
 *
 * @author   Prospress
 * @category WooCommerce Subscriptions/Templates
 * @version  1.0.0 - Migrated from WooCommerce Subscriptions v2.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="woocommerce_account_subscriptions">
	<div class="account-header-wrapper order-history subscription-history">
		<section class="account-header sales_order_details">
			<h2><?php echo __('My Subscriptions', 'storefrontchild'); ?></h2>
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
						<h3><?php echo __('My Subscriptions', 'storefrontchild'); ?></h3>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if ( ! empty( $subscriptions ) ) : ?>
	<table class="my_account_subscriptions my_account_orders woocommerce-orders-table woocommerce-MyAccount-subscriptions shop_table shop_table_responsive woocommerce-orders-table--subscriptions">

	<thead>
		<tr>
			<th class="subscription-id order-number woocommerce-orders-table__header woocommerce-orders-table__header-order-number woocommerce-orders-table__header-subscription-id"><span class="nobr"><?php esc_html_e( 'Subscription', 'woocommerce-subscriptions' ); ?></span></th>
			<th class="subscription-status order-status woocommerce-orders-table__header woocommerce-orders-table__header-order-status woocommerce-orders-table__header-subscription-status"><span class="nobr"><?php esc_html_e( 'Status', 'woocommerce-subscriptions' ); ?></span></th>
			<th class="subscription-next-payment order-date woocommerce-orders-table__header woocommerce-orders-table__header-order-date woocommerce-orders-table__header-subscription-next-payment"><span class="nobr"><?php echo esc_html_x( 'Next payment', 'table heading', 'woocommerce-subscriptions' ); ?></span></th>
			<th class="subscription-total order-total woocommerce-orders-table__header woocommerce-orders-table__header-order-total woocommerce-orders-table__header-subscription-total"><span class="nobr"><?php echo esc_html_x( 'Total', 'table heading', 'woocommerce-subscriptions' ); ?></span></th>
			<th class="subscription-actions order-actions woocommerce-orders-table__header woocommerce-orders-table__header-order-actions woocommerce-orders-table__header-subscription-actions">&nbsp;</th>
		</tr>
	</thead>

	<tbody>
	<?php /** @var WC_Subscription $subscription */ ?>
	<?php foreach ( $subscriptions as $subscription_id => $subscription ) : ?>
		<tr class="order woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $subscription->get_status() ); ?>">
			<td class="subscription-id order-number woocommerce-orders-table__cell woocommerce-orders-table__cell-subscription-id woocommerce-orders-table__cell-order-number" data-title="<?php esc_attr_e( 'ID', 'woocommerce-subscriptions' ); ?>">
				<a href="<?php echo esc_url( $subscription->get_view_order_url() ); ?>"><?php echo esc_html( sprintf( _x( '#%s', 'hash before order number', 'woocommerce-subscriptions' ), $subscription->get_order_number() ) ); ?></a>
				<?php do_action( 'woocommerce_my_subscriptions_after_subscription_id', $subscription ); ?>
			</td>
			<td class="subscription-status order-status woocommerce-orders-table__cell woocommerce-orders-table__cell-subscription-status woocommerce-orders-table__cell-order-status" data-title="<?php esc_attr_e( 'Status', 'woocommerce-subscriptions' ); ?>">
				<?php echo esc_attr( wcs_get_subscription_status_name( $subscription->get_status() ) ); ?>
			</td>
			<td class="subscription-next-payment order-date woocommerce-orders-table__cell woocommerce-orders-table__cell-subscription-next-payment woocommerce-orders-table__cell-order-date" data-title="<?php echo esc_attr_x( 'Next Payment', 'table heading', 'woocommerce-subscriptions' ); ?>">
				<?php echo esc_attr( $subscription->get_date_to_display( 'next_payment' ) ); ?>
				<?php if ( ! $subscription->is_manual() && $subscription->has_status( 'active' ) && $subscription->get_time( 'next_payment' ) > 0 ) : ?>
				<br/><small><?php echo esc_attr( $subscription->get_payment_method_to_display( 'customer' ) ); ?></small>
				<?php endif; ?>
			</td>
			<td class="subscription-total order-total woocommerce-orders-table__cell woocommerce-orders-table__cell-subscription-total woocommerce-orders-table__cell-order-total" data-title="<?php echo esc_attr_x( 'Total', 'Used in data attribute. Escaped', 'woocommerce-subscriptions' ); ?>">
				<?php echo wp_kses_post( $subscription->get_formatted_order_total() ); ?>
			</td>
			<td class="subscription-actions order-actions woocommerce-orders-table__cell woocommerce-orders-table__cell-subscription-actions woocommerce-orders-table__cell-order-actions">
				<a href="<?php echo esc_url( $subscription->get_view_order_url() ) ?>" class="woocommerce-button button view"><?php echo esc_html_x( 'View', 'view a subscription', 'woocommerce-subscriptions' ); ?></a>
				<?php do_action( 'woocommerce_my_subscriptions_actions', $subscription ); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>

	</table>
	<?php
		$subscriptions = wcs_get_users_subscriptions( $current_user_id );
		$total_subscriptions = count( $subscriptions );
	?>
	<div class="order-grid-toolbar toolbar bottom">
		<div class="pager">
			<?php
				$items_per_page = isset($_GET['limit']) && is_numeric($_GET['limit']) ? absint($_GET['limit']) : 10;
				$start_item = ($current_page - 1) * $items_per_page + 1;
				$end_item = min($start_item + $items_per_page - 1, $total_subscriptions);
				$total_items = $total_subscriptions;
			?>
			<p class="toolbar-amount">
				<?php if ( 1 < $max_num_pages ) : ?>
					<span class="toolbar-number"><?php echo 'Items '.$start_item.' to '.$end_item.' of '. $total_items. ' total'; ?></span>
				<?php else : ?>
					<span class="toolbar-number"><?php echo  $start_item.' Item'; ?></span>
				<?php endif; ?>
			</p>
			<?php if ( 1 < $max_num_pages ) : ?>
				<div class="pages">
					<ul class="items pages-items" aria-labelledby="paging-label">
						<?php if ( 1 !== $current_page ) : ?>
							<li class="item pages-item-previous"><a class="page action previous" href="<?php echo esc_url( add_query_arg( 'limit', $items_per_page, wc_get_endpoint_url( 'subscriptions', $current_page - 1 ) ) ); ?>" title="Previous"><i class="fas fa-chevron-left"></i></a></li>
						<?php endif; ?>
						<?php
						$start_page = max( 1, $current_page - 1 );
						$end_page = min( $start_page + 2, $max_num_pages );
						if ( $start_page > 1 ) :
						?>
							<li class="item">
								<a href="<?php echo esc_url( add_query_arg( 'limit', $items_per_page, wc_get_endpoint_url( 'subscriptions', 1 ) ) ); ?>" class="page"><span>1</span></a>
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
									<a href="<?php echo esc_url( add_query_arg( 'limit', $items_per_page, wc_get_endpoint_url( 'subscriptions', $i ) ) ); ?>" class="page"><span><?php echo $i; ?></span></a>
								</li>
							<?php endif; ?>
						<?php } ?>
						<?php if ( $end_page < $max_num_pages ) : ?>
							<?php if ( $end_page < $max_num_pages - 1 ) : ?>
								<li class="item">
									<span class="page">...</span>
								</li>
							<?php endif; ?>
							<li class="item">
								<a href="<?php echo esc_url( add_query_arg( 'limit', $items_per_page, wc_get_endpoint_url( 'orders', $max_num_pages ) ) ); ?>" class="page"><span><?php echo $max_num_pages; ?></span></a>
							</li>
						<?php endif; ?>
						<?php if ( intval( $max_num_pages ) !== $current_page ) : ?>
							<li class="item pages-item-next"><a class="page action next" href="<?php echo esc_url( add_query_arg( 'limit', $items_per_page, wc_get_endpoint_url( 'subscriptions', $current_page + 1 ) ) ); ?>" title="Next"><i class="fas fa-chevron-right"></i></a></li>
						<?php endif; ?>
					</ul>
				</div>
			<?php endif; ?>
			
		</div>
	</div>
	<?php else : ?>
		<p class="no_subscriptions woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
			<?php if ( 1 < $current_page ) :
				printf( esc_html__( 'You have reached the end of subscriptions. Go to the %sfirst page%s.', 'woocommerce-subscriptions' ), '<a href="' . esc_url( wc_get_endpoint_url( 'subscriptions', 1 ) ) . '">', '</a>' );
			else :
				esc_html_e( 'You have no active subscriptions.', 'woocommerce-subscriptions' );
				?>
				<a class="woocommerce-Button button" href="<?php echo esc_url(get_home_url() ); ?>">
					<?php esc_html_e( 'Browse products', 'woocommerce-subscriptions' ); ?>
				</a>
			<?php
		endif; ?>
		</p>

	<?php endif; ?>

</div>
