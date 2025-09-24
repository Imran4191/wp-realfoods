<?php
/*
Plugin Name: Bwip Stock Manager
Description: A plugin to manage and display all products in the admin with pagination and filtering options.
Version: 1.1
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class BwipStockManager {

    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_scripts'));
    }

    public function add_admin_menu() {
        add_menu_page(
            'Stock Manager',
            'Stock Manager',
            'manage_options',
            'bwip-stock-manager',
            array($this, 'render_stock_manager_page'),
            'dashicons-chart-area',
            55
        );
    }

    public function render_stock_manager_page() {
        // Check user capabilities
        if (!current_user_can('manage_options')) {
            return;
        }

        // Filter variables
        $filter_name = isset($_GET['filter_name']) ? sanitize_text_field($_GET['filter_name']) : '';
        $filter_sku = isset($_GET['filter_sku']) ? sanitize_text_field($_GET['filter_sku']) : '';
        $limit = isset($_GET['limit']) ? absint($_GET['limit']) : 20;

        // Get products with filters
        $paged = isset($_GET['paged']) ? absint($_GET['paged']) : 1;
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $limit,
            'paged' => $paged,
            's' => $filter_name,
        );

        if (!empty($filter_sku)) {
            $args['meta_query'] = array(
                array(
                    'key' => '_sku',
                    'value' => $filter_sku,
                    'compare' => 'LIKE',
                ),
            );
        }

        $products = new WP_Query($args);
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Products Stock Manager', 'bwip-stock-manager'); ?></h1>

            <!-- Filter Form -->
            <form method="get" action="">
                <input type="hidden" name="page" value="bwip-stock-manager" />
                <label for="filter_name"><?php esc_html_e('Product Name:', 'bwip-stock-manager'); ?></label>
                <input type="text" name="filter_name" id="filter_name" value="<?php echo esc_attr($filter_name); ?>" />

                <label for="filter_sku"><?php esc_html_e('SKU:', 'bwip-stock-manager'); ?></label>
                <input type="text" name="filter_sku" id="filter_sku" value="<?php echo esc_attr($filter_sku); ?>" />

                <label for="limit"><?php esc_html_e('Per page:', 'bwip-stock-manager'); ?></label>
                <select name="limit" id="limit">
                    <option value="20" <?php selected($limit, 20); ?>>20</option>
                    <option value="50" <?php selected($limit, 50); ?>>50</option>
                    <option value="100" <?php selected($limit, 100); ?>>100</option>
                </select>

                <input type="submit" class="button" value="<?php esc_attr_e('Filter', 'bwip-stock-manager'); ?>" />
            </form>

            <table class="wp-list-table widefat striped">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Product Name', 'bwip-stock-manager'); ?></th>
                        <th><?php esc_html_e('SKU', 'bwip-stock-manager'); ?></th>
                        <th><?php esc_html_e('Status', 'bwip-stock-manager'); ?></th>
                        <th><?php esc_html_e('Total Qty', 'bwip-stock-manager'); ?></th>
                        <th><?php esc_html_e('Avaialbe Qty', 'bwip-stock-manager'); ?></th>
                        <th><?php esc_html_e('Qty to Ship', 'bwip-stock-manager'); ?></th>
                        <th><?php esc_html_e('Stock Status', 'bwip-stock-manager'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($products->have_posts()) : ?>
                        <?php $pendingProcessingSkuWithQty = $this->getShipToOrderSkuQty(); ?>
                        <?php while ($products->have_posts()) : $products->the_post(); ?>
                            <?php
                                $product = wc_get_product(get_the_ID());
                                $qtyToShip = 0;
                                if(isset($pendingProcessingSkuWithQty[$product->get_sku()])){
                                    $qtyToShip = $pendingProcessingSkuWithQty[$product->get_sku()];
                                }
                            ?>
                            <tr>
                                <td><a href="<?php echo esc_url(get_edit_post_link(get_the_ID())); ?>"><?php the_title(); ?></a></td>
                                <td><?php echo esc_html($product->get_sku()); ?></td>
                                <td><?php echo esc_html($product->is_in_stock() ? 'Enabled' : 'Disabled'); ?></td>
                                <td><?php echo esc_html($product->get_stock_quantity() + $qtyToShip); ?></td>
                                <td><?php echo esc_html($product->get_stock_quantity()); ?></td>
                                <td><?php echo esc_html($qtyToShip); ?></td>
                                <td><?php echo esc_html($product->is_in_stock() ? 'In Stock' : 'Out of Stock'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5"><?php esc_html_e('No products found.', 'bwip-stock-manager'); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="pagination">
                <?php
                    $this->pagination($products, $limit);
                ?>
            </div>
        </div>
        <?php
        wp_reset_postdata();
    }

    private function pagination($query, $limit) {
        $big = 999999999; // an unlikely integer
        $args = array(
            'base' => add_query_arg('paged', '%#%'),
            'format' => '?paged=%#%',
            'current' => max(1, isset($_GET['paged']) ? absint($_GET['paged']) : 1),
            'total' => $query->max_num_pages,
            'prev_text' => __('« Previous', 'bwip-stock-manager'),
            'next_text' => __('Next »', 'bwip-stock-manager'),
            'add_args' => array(
                'filter_name' => isset($_GET['filter_name']) ? sanitize_text_field($_GET['filter_name']) : '',
                'filter_sku' => isset($_GET['filter_sku']) ? sanitize_text_field($_GET['filter_sku']) : '',
                'limit' => $limit,
            ),
        );
        echo paginate_links($args);
    }

    public function register_scripts() {
        wp_enqueue_style('bwip-stock-manager-css', plugins_url('assets/css/style.css', __FILE__));
    }

    public function getShipToOrderSkuQty(){
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
}

new BwipStockManager();
