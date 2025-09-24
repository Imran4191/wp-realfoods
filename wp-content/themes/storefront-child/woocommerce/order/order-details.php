<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.5.0
 *
 * @var bool $show_downloads Controls whether the downloads table should be rendered.
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if ( ! $order ) {
	return;
}

$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();

if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>
<ul class="items order-links" id="detailsTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="item-tab" data-bs-toggle="tab" data-bs-target="#item-tab-pane" type="button" role="tab" aria-controls="item-tab-pane" aria-selected="true"><?php echo __('Items Ordered', 'storefrontchild'); ?></button>
    </li>
	<?php if($order->get_status()=='processing' || $order->get_status()=='completed') : ?>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="invoice-tab" data-bs-toggle="tab" data-bs-target="#invoice-tab-pane" type="button" role="tab" aria-controls="invoice-tab-pane" aria-selected="false"><?php echo __('Invoices', 'storefrontchild'); ?></button>
    </li>
	<?php endif; ?>
	<?php if($order->get_status()=='completed') : ?>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="shipment-tab" data-bs-toggle="tab" data-bs-target="#shipment-tab-pane" type="button" role="tab" aria-controls="shipment-tab-pane" aria-selected="false"><?php echo __('Order Shipments', 'storefrontchild'); ?></button>
    </li>
	<?php endif; ?>
</ul>
<div class="tab-content order-details-items" id="detailsTabContent">
    <div class="tab-pane fade show active" id="item-tab-pane" role="tabpanel" aria-labelledby="item-tab" tabindex="0">
		<div class="order-details-items">
			<div class="order-title"><strong><?php echo __('Items Ordered', 'storefrontchild'); ?></strong> </div>
			<div class="table-wrapper order-items">
				<table class="data table table-order-items">
					<thead>
						<tr>
							<th class="col name"><?php echo __('Product Name', 'storefrontchild'); ?></th>
							<th class="col price"><?php echo __('Price', 'storefrontchild'); ?></th>
							<th class="col qty"><?php echo __('Qty', 'storefrontchild'); ?></th>
							<th class="col subtotal"><?php echo __('Subtotal', 'storefrontchild'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $order_items as $item_id => $item ) : ?>
							<tr id="order-item-row">
								<td class="col name" data-th="Product Name">
									<strong class="product name product-item-name"><?php echo $item->get_name(); ?></strong>
								</td>
								<td class="col price" data-th="Price">
									<span class="cart-price"><?php echo wc_price($order->get_item_total($item, true, true), array('currency' => $order->get_order_currency())); ?></span>
								</td>
								<td class="col qty" data-th="Qty">
									<ul class="items-qty">
										<li class="item"><span class="title"><?php echo __('Ordered:', 'storefrontchild'); ?></span> <span class="content"><?php echo $item->get_quantity(); ?></span></li>
									</ul>
								</td>
								<td class="col price subtotal" data-th="Subtotal">
									<span class="cart-price"><?php echo $order->get_formatted_line_subtotal( $item ); ?></span>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr class="subtotal">
							<th colspan="3" class="mark" scope="row"><?php echo __('Subtotal', 'storefrontchild'); ?></th>
							<td class="amount" data-th="Subtotal" align="right"><span class="price"><?php echo $order->get_order_item_totals()['cart_subtotal']['value']; ?></span></td>
						</tr>
						<tr class="shipping">
							<th colspan="3" class="mark" scope="row"><?php echo __('Shipping & Handling', 'storefrontchild'); ?></th>
							<td class="amount" data-th="Shipping &amp; Handling" align="right"><span class="price"><?php echo get_woocommerce_currency_symbol() . round($order->get_shipping_total(), 2); ?></span></td>
						</tr>
						<tr class="totals-tax">
							<th colspan="3" class="mark" scope="row"><?php echo __('Includes VAT of', 'storefrontchild'); ?></th>
							<td class="amount" data-th="Includes VAT of"><span class="price"><?php echo get_woocommerce_currency_symbol() . round($order->get_total_tax(), 2); ?></span></td>
						</tr>
						<tr class="grand_total">
							<th colspan="3" class="mark" scope="row"> <strong style="color:#fff;"><?php echo __('Grand Total', 'storefrontchild'); ?></strong> </th>
							<td class="amount" data-th="Grand Total" align="right"><strong><span class="price"><?php echo $order->get_order_item_totals()['order_total']['value']; ?></span></strong></td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="actions-toolbar">
				<div class="secondary"><a class="action back" href="<?php echo wc_get_endpoint_url( 'orders' ); ?>"><span><?php echo __('Back', 'storefrontchild'); ?></span></a></div>
			</div>
		</div>
	</div>

	<?php if($order->get_status()=='processing' || $order->get_status()=='completed') : ?>
    <div class="tab-pane fade" id="invoice-tab-pane" role="tabpanel" aria-labelledby="invoice-tab" tabindex="0">
		<div class="order-details-items">
			<div class="order-title">
				<strong><?php echo wp_kses_post(sprintf(__('Invoice #%1$s', 'storefrontchild'), $order->get_order_number())); ?></strong>
				<?php echo '<a href="' . admin_url('admin-ajax.php?action=generate_pdf_invoice&order_id=' . $order_id) . '" class="button button-primary " target="_blank">' . __('Print Invoice', 'woocommerce') . '</a>'; ?>
			</div>
			<div class="table-wrapper order-items">
				<table class="data table table-order-items">
					<thead>
						<tr>
							<th class="col name"><?php echo __('Product Name', 'storefrontchild'); ?></th>
							<th class="col price"><?php echo __('Price', 'storefrontchild'); ?></th>
							<th class="col qty"><?php echo __('Qty Invoiced', 'storefrontchild'); ?></th>
							<th class="col subtotal"><?php echo __('Subtotal', 'storefrontchild'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $order_items as $item_id => $item ) : ?>
							<tr id="order-item-row">
								<td class="col name" data-th="Product Name">
									<strong class="product name product-item-name"><?php echo $item->get_name(); ?></strong>
								</td>
								<td class="col price" data-th="Price">
									<span class="cart-price"><?php echo wc_price($order->get_item_total($item, true, true), array('currency' => $order->get_order_currency())); ?></span>
								</td>
								<td class="col qty" data-th="Qty">
									<ul class="items-qty">
										<li class="item"><span class="content"><?php echo $item->get_quantity(); ?></span></li>
									</ul>
								</td>
								<td class="col price subtotal" data-th="Subtotal">
									<span class="cart-price"><?php echo $order->get_formatted_line_subtotal( $item ); ?></span>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr class="subtotal">
							<th colspan="3" class="mark" scope="row"><?php echo __('Subtotal', 'storefrontchild'); ?></th>
							<td class="amount" data-th="Subtotal" align="right"><span class="price"><?php echo $order->get_order_item_totals()['cart_subtotal']['value']; ?></span></td>
						</tr>
						<tr class="shipping">
							<th colspan="3" class="mark" scope="row"><?php echo __('Shipping & Handling', 'storefrontchild'); ?></th>
							<td class="amount" data-th="Shipping &amp; Handling" align="right"><span class="price"><?php echo get_woocommerce_currency_symbol() . round($order->get_shipping_total(), 2); ?></span></td>
						</tr>
						<tr class="totals-tax">
							<th colspan="3" class="mark" scope="row"><?php echo __('Includes VAT of', 'storefrontchild'); ?></th>
							<td class="amount" data-th="Includes VAT of"><span class="price"><?php echo get_woocommerce_currency_symbol() . round($order->get_total_tax(), 2); ?></span></td>
						</tr>
						<tr class="grand_total">
							<th colspan="3" class="mark" scope="row"> <strong style="color:#fff;"><?php echo __('Grand Total', 'storefrontchild'); ?></strong> </th>
							<td class="amount" data-th="Grand Total" align="right"><strong><span class="price"><?php echo $order->get_order_item_totals()['order_total']['value']; ?></span></strong></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<?php if($order->get_status()=='completed') : ?>
    <div class="tab-pane fade" id="shipment-tab-pane" role="tabpanel" aria-labelledby="shipment-tab" tabindex="0">
		<div class="order-details-items">
			<div class="order-title">
				<strong><?php echo wp_kses_post(sprintf(__('Shipment #%1$s', 'storefrontchild'), $order->get_order_number())); ?></strong>
			</div>
			<div class="table-wrapper order-items">
				<table class="data table table-order-items">
					<thead>
						<tr>
							<th class="col name"><?php echo __('Product Name', 'storefrontchild'); ?></th>
							<th class="col qty"><?php echo __('Qty Shipped', 'storefrontchild'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $order_items as $item_id => $item ) : ?>
							<tr id="order-item-row">
								<td class="col name" data-th="Product Name">
									<strong class="product name product-item-name"><?php echo $item->get_name(); ?></strong>
								</td>
								<td class="col qty" data-th="Qty">
									<ul class="items-qty">
										<li class="item"><span class="content"><?php echo $item->get_quantity(); ?></span></li>
									</ul>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>
