<?php
if ( ! defined( 'WPINC' ) ) {
    die;
}

if(!class_exists('WT_WC_Order_Item_Product_IPC') && class_exists('WC_Order_Item_Product')){
class WT_WC_Order_Item_Product_IPC extends WC_Order_Item_Product
{
    public $this_refund_item_id;
    public function __construct( $item = 0 ) {
        parent::__construct($item);
    }
}
}