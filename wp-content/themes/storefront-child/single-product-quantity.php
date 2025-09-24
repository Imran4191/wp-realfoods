<?php
global $product;
$product_name = $product->get_name();

$product_unit_qty = $product->get_attribute('unit_qty');
$product_unit_type = $product->get_attribute('unit_type');


?>

<div class="product-unit-wrapper">
  <h3 class="product-unit">
    <?php echo $product_unit_qty . ' ' . $product_unit_type; ?>
    </h3>
</div>