<?php
/**
 * Plugin Name: WooCommerce PDF Invoice
 * Description: Generates a PDF invoice for WooCommerce orders.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include the TCPDF library
if (!class_exists('TCPDF')) {
    require_once(plugin_dir_path(__FILE__) . 'tcpdf/tcpdf.php');
}

// Add action to display the button in the admin order details page
add_action('add_meta_boxes', 'wc_pdf_invoice_add_meta_box');
function wc_pdf_invoice_add_meta_box() {
    add_meta_box(
        'woocommerce-pdf-invoice',
        __('PDF Invoice', 'woocommerce'),
        'wc_pdf_invoice_meta_box_callback',
        '',
        'side',
        'high'
    );
}

function wc_pdf_invoice_meta_box_callback($post) {
    $order = wc_get_order($post->ID);
    if ($order && ($order->get_status()=='processing' || $order->get_status()=='completed')) {
        echo '<a href="' . admin_url('admin-ajax.php?action=generate_pdf_invoice&order_id=' . $post->ID) . '" class="button button-primary" target="_blank">' . __('Download PDF Invoice', 'woocommerce') . '</a>';
    } else {
        echo '<p>' . __('The invoice can only be generated for orders with the status Processing or Completed.', 'woocommerce') . '</p>';
    }
}

// Add action to handle the PDF generation
add_action('wp_ajax_generate_pdf_invoice', 'wc_pdf_invoice_generate_pdf');
add_action('wp_ajax_nopriv_generate_pdf_invoice', 'wc_pdf_invoice_generate_pdf');

function wc_pdf_invoice_generate_pdf() {
    if (!isset($_GET['order_id'])) {
        return;
    }

    $order_id = intval($_GET['order_id']);
    $order = wc_get_order($order_id);

    if (!$order) {
        return;
    }

    // Create new PDF document
    $pdf = new TCPDF();

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Rosita Real Foods');
    $pdf->SetTitle('Rosita_Real_Foods_Invoice_' . $order->get_order_number());
    $pdf->SetSubject('Invoice');
    $pdf->SetKeywords('TCPDF, PDF, invoice, WooCommerce');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Generate HTML content with table layout
    $html = '
    <table style="width: 100%; border: none; padding: 10px;">
        <tbody style="border: none;">
            <tr style="border: none;">
                <td colspan="4" style="text-align: center; padding-bottom: 20px; border: none;">
                    <img src="' . get_option('invoice_logo') . '" alt="Rosita Real Foods" width="125" />
                </td>
            </tr>
            <tr>
                <td colspan="2" style="font-size: 24px; font-weight: bold; padding-bottom: 20px;">TAX INVOICE</td>
            </tr>
            <tr>
                <td style="width:50%;vertical-align:top;padding:10px;"><strong>Billing Address:</strong><br/>' . nl2br($order->get_formatted_billing_address()) . '</td>
                <td style="width: 25%; vertical-align: top; padding: 10px;"><strong>Invoice Date:</strong><br/> ' . date('F j, Y', strtotime($order->get_date_created())) . '<br/>
                    <strong>Invoice Number:</strong><br/> ' . $order->get_order_number() . '<br/>
                    <strong>Order Number:</strong><br/> ' . $order->get_order_number() . '
                </td>
                <td style="width: 25%; vertical-align: top; padding: 10px;">' . get_option('invoice_store_details') . '
                    <br/>
                    <strong>VAT Number:</strong><br/> ' . get_option('vat_number') . '
                </td>
            </tr>
        </tbody>
    </table>
    <br/>
    <br/>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr>
                <th colspan="2" style="border-bottom: 1px solid #000; padding: 10px; text-align: left;">Items</th>
                <th style="border-bottom: 1px solid #000; padding: 10px; text-align: center;">Qty</th>
                <th style="border-bottom: 1px solid #000; padding: 10px; text-align: right;">Unit Price</th>
                <th style="border-bottom: 1px solid #000; padding: 10px; text-align: right;">VAT</th>
                <th style="border-bottom: 1px solid #000; padding: 10px; text-align: right;">Discount</th>
                <th style="border-bottom: 1px solid #000; padding: 10px; text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($order->get_items() as $item) {
        $product = $item->get_product();
        $html .= '
            <tr>
                <td colspan="2" style="border-bottom: 1px solid #000; padding: 10px;">' . $product->get_name() . '</td>
                <td style="border-bottom: 1px solid #000; padding: 10px; text-align: center;">' . $item->get_quantity() . '</td>
                <td style="border-bottom: 1px solid #000; padding: 10px; text-align: right;">' . wc_price($item->get_total() / $item->get_quantity()) . '</td>
                <td style="border-bottom: 1px solid #000; padding: 10px; text-align: right;">' . wc_price($item->get_total_tax()) . '</td>
                <td style="border-bottom: 1px solid #000; padding: 10px; text-align: right;">' . wc_price($item->get_subtotal() - $item->get_total()) . '</td>
                <td style="border-bottom: 1px solid #000; padding: 10px; text-align: right;">' . wc_price($item->get_total()) . '</td>
            </tr>';
    }

    $html .= '
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="border: none;"></td>
                <td colspan="2" style="border-bottom: 1px solid #000; padding: 10px; text-align: right;">SUBTOTAL</td>
                <td style="border-bottom: 1px solid #000; padding: 10px; text-align: right;">' . wc_price($order->get_subtotal()) . '</td>
            </tr>
            <tr>
                <td colspan="4" style="border: none;"></td>
                <td colspan="2" style="border-bottom: 1px solid #000; padding: 10px; text-align: right;">Discount</td>
                <td style="border-bottom: 1px solid #000; padding: 10px; text-align: right;">' . wc_price($order->get_discount_total()) . '</td>
            </tr>
            <tr>
                <td colspan="4" style="border: none;"></td>
                <td colspan="2" style="border-bottom: 1px solid #000; padding: 10px; text-align: right;">SHIPPING & HANDLING</td>
                <td style="border-bottom: 1px solid #000; padding: 10px; text-align: right;">' . wc_price($order->get_shipping_total()) . '</td>
            </tr>
            <tr>
                <td colspan="4" style="border: none;"></td>
                <td colspan="2" style="border-bottom: 1px solid #000; padding: 10px; text-align: right;">VAT</td>
                <td style="border-bottom: 1px solid #000; padding: 10px; text-align: right;">' . wc_price($order->get_total_tax()) . '</td>
            </tr>
            <tr>
                <td colspan="4" style="border: none;"></td>
                <td colspan="2" style="border: none; padding: 10px; text-align: right;"><strong>GRAND TOTAL</strong></td>
                <td style="border: none; padding: 10px; text-align: right;"><strong>' . wc_price($order->get_total()) . '</strong></td>
            </tr>
        </tfoot>
    </table>
    <br/>
    <br/>';
    $html .= get_option('invoice_account_details');

    // Minify the html content to avoid TCPDF error
    $html = preg_replace('/\s+/', ' ', $html);

    // Add content to the PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Output the PDF as a download
    $pdf->Output('Rosita_Real_Foods_Invoice_' . $order->get_order_number() . '.pdf', 'D');

    exit;
}

// Add the button to the customer order details page
// add_action('woocommerce_view_order', 'wc_pdf_invoice_add_view_order_button', 20);
// function wc_pdf_invoice_add_view_order_button($order_id) {
//     echo '<a href="' . admin_url('admin-ajax.php?action=generate_pdf_invoice&order_id=' . $order_id) . '" class="button" target="_blank">' . __('Download PDF Invoice', 'woocommerce') . '</a>';
// }
