<?php
// BWIPIT-2733
function track_order_form_shortcode() {
  $track_order_template = STOREFRONT_CHILD_PATH . '/shortcode-templates/trackorder.php';
  ob_start();
  if ( file_exists($track_order_template) ) {
    include($track_order_template);
  } else {
    echo 'Template file not found.';
  }
  return ob_get_clean();
}
add_shortcode('track_order_form', 'track_order_form_shortcode');