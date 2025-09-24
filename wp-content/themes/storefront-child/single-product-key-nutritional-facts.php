<?php
global $product;
$product_name = $product->get_name();

$product_desc = $product->get_attribute('Key Nutritional Facts');
?>

    <?php echo $product_desc; ?>