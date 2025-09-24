<?php
global $product;

$product_testing_content = $product->get_attribute('Testing Content');
$product_testing_tab = $product->get_attribute('Testing Tab');


echo $product_testing_content;
echo $product_testing_tab;

?>

