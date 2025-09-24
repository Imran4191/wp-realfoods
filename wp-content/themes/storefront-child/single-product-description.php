<?php
global $product;
$product_name = $product->get_name();

$product_desc = $product->get_attribute('Product Description');

echo $product_desc;

?>

    