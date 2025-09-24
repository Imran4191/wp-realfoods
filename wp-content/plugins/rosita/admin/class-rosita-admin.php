<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rositarealfoods.com
 * @since      1.0.0
 *
 * @package    Rosita
 * @subpackage Rosita/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rosita
 * @subpackage Rosita/admin
 * @author     BWIP Holdings Inc <jerico@bwipholdings.com>
 */
class Rosita_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_filter( 'pre_user_query', array( &$this, 'filter_users_by_id' ) );

		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		add_action( 'show_user_profile', array( $this, 'add_custom_rosita_customer_fields' ), 200 );
		add_action( 'edit_user_profile', array( $this, 'add_custom_rosita_customer_fields' ), 200 );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rosita_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rosita_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rosita-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rosita_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rosita_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rosita-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Filter WP users by UM Status
	 *
	 * @param $query
	 * @return mixed
	 */
	public function filter_users_by_id( $query ) {
		global $wpdb, $pagenow;
		if ( is_admin() && 'users.php' === $pagenow && ! empty( $_REQUEST['user_id'] ) ) {

			$user_id = sanitize_key( $_REQUEST['user_id'] );
			$query->query_where = str_replace('WHERE 1=1',
				"WHERE 1=1 AND {$wpdb->users}.ID = {$user_id} ",
				$query->query_where
			);
		}

		return $query;
	}

	public function add_plugin_admin_menu() {
		// Add top-level menu page
		add_menu_page(
				'Rosita Plugin',           // Page title
				'Rosita',                  // Menu title
				'manage_options',          // Capability
				'rosita-top-level-menu',   // Menu slug
				array( $this, 'display_plugin_admin_dashboard' ), // Function to display the dashboard
				'dashicons-admin-generic', // Icon URL (optional)
				6                          // Position (optional)
		);

		// Add first sub-menu page
		add_submenu_page(
				'rosita-top-level-menu',   // Parent slug
				'Pensioner Customers',     // Page title
				'Pensioner Customers',     // Menu title
				'manage_options',          // Capability
				'rosita-pensioner-customers',     // Menu slug
				array( $this, 'display_pensioner_customers' ) // Function to display the page
		);

		// Add second sub-menu page
		add_submenu_page(
				'rosita-top-level-menu',   // Parent slug
				'Practitioner Customers',  // Page title
				'Practitioner Customers',  // Menu title
				'manage_options',          // Capability
				'rosita-practitioner-customers',     // Menu slug
				array( $this, 'display_practitioner_customers' ) // Function to display the page
		);

		//Practitioner Payment Report
		add_submenu_page(
			'rosita-top-level-menu',   // Parent slug
			'Practitioner Payment Report',  // Page title
			'Practitioner Payment Report',  // Menu title
			'manage_options',          // Capability
			'rosita-practitioner-payment-report',     // Menu slug
			array( $this, 'display_practitioner_payment_report' ) // Function to display the page
		);

		//Practitioner Payment Details
		add_submenu_page(
			'rosita-top-level-menu',   // Parent slug
			'Practitioner Payment Details',  // Page title
			'Practitioner Payment Details',  // Menu title
			'manage_options',          // Capability
			'rosita-practitioner-payment-details',     // Menu slug
			array( $this, 'display_practitioner_payment_details' ) // Function to display the page
		);

		//Practitioner Pay Commission
		add_submenu_page(
			'rosita-top-level-menu',   // Parent slug
			'Practitioner Pay Commission',  // Page title
			'Practitioner Pay Commission',  // Menu title
			'manage_options',          // Capability
			'rosita-practitioner-pay-commission',     // Menu slug
			array( $this, 'practitioner_pay_commission' ) // Function to display the page
		);
	}

	// Function to display the main dashboard
	public function display_plugin_admin_dashboard() {
			echo '<h1>Rosita Plugin Dashboard</h1>';
			// Dashboard content goes here
	}

	// Function to display the Pensioner Customers
	public function display_pensioner_customers() {
		$pensioner_users = get_users(['role' => 'um_pensioner']); // query um_pensioner
    ?>
		<div class="wrap">
			<div id="rosita-pensioners" class="rosita-custom-type-customers">
        <h1>Pensioners</h1>
				<div class="for-approval">
					<h1>Pending For Review and Approval</h1>
					<table class="wp-list-table widefat fixed striped table-view-list users">
							<tr>
									<th>ID</th>
									<th>Username</th>
									<th>Email</th>
									<th>Full Name</th>
									<th>Date Registered</th>
									<th>Actions</th>
									<!-- Add other columns as needed -->
							</tr>
							<?php foreach ($pensioner_users as $user) : ?>
							<?php if (!$this->isPending($user->ID)) { continue; } ?>
							<tr>
									<td><?php echo esc_html($user->ID); ?></td>
									<td><?php echo esc_html($user->user_login); ?></td>
									<td><?php echo esc_html($user->user_email); ?></td>
									<td><?php echo esc_html($user->display_name); ?></td>
									<td><?php echo date('Y-m-d', strtotime($user->user_registered)); ?></td>
									<td>
										<span><a href="<?php echo admin_url('user-edit.php') . '?user_id=' . $user->ID . '&wp_http_referer=/wp-admin/users.php?user_id=' . $user->ID; ?>" target="_blank">View Details</a></span>
										<span> | </span>
										<span><a href="<?php echo admin_url('users.php') . '?user_id=' . $user->ID; ?>" target="_blank">View From List</a></span>
									</td>
									<!-- Add other user data as needed -->
							</tr>
							<?php endforeach; ?>
					</table>
				</div>

				<div class="approved">
					<table class="wp-list-table widefat fixed striped table-view-list users">
							<tr><h1>Approved Pensioners</h1></tr>
							<tr>
									<th>ID</th>
									<th>Username</th>
									<th>Email</th>
									<th>Full Name</th>
									<th>Date Registered</th>
									<th>Action</th>
									<!-- Add other columns as needed -->
							</tr>
							<?php foreach ($pensioner_users as $user) : ?>
							<?php if ($this->isPending($user->ID)) { continue; } ?>
							<tr>
									<td><?php echo esc_html($user->ID); ?></td>
									<td><?php echo esc_html($user->user_login); ?></td>
									<td><?php echo esc_html($user->user_email); ?></td>
									<td><?php echo esc_html($user->display_name); ?></td>
									<td><?php echo date('Y-m-d', strtotime($user->user_registered)); ?></td>
									<td>
										<span><a href="<?php echo admin_url('user-edit.php') . '?user_id=' . $user->ID . '&wp_http_referer=/wp-admin/users.php?user_id=' . $user->ID; ?>" target="_blank">View Details</a></span>
										<span> | </span>
										<span><a href="<?php echo admin_url('users.php') . '?user_id=' . $user->ID; ?>" target="_blank">View From List</a></span>
									</td>
									<!-- Add other user data as needed -->
							</tr>
							<?php endforeach; ?>
					</table>
				</div>
			</div>
    </div>
    <?php
	}

	// Function to display the Practitioner Customers
	public function display_practitioner_customers() {

		$practitioner_users = get_users(['role' => 'um_practitioner']); // query um_practitioner
    ?>
    <div class="wrap">
			<div id="rosita-practioners" class="rosita-custom-type-customers">
        <h1>Practitioners</h1>
				<div class="for-approval">
					<h1>Pending For Review and Approval</h1>
					<table class="wp-list-table widefat fixed striped table-view-list users">
							<tr>
									<th>ID</th>
									<th>Username</th>
									<th>Email</th>
									<th>Full Name</th>
									<th>Date Registered</th>
									<th>Action</th>
									<!-- Add other columns as needed -->
							</tr>
							<?php foreach ($practitioner_users as $user) : ?>
							<?php if (!$this->isPending($user->ID)) { continue; } ?>
							<tr>
									<td><?php echo esc_html($user->ID); ?></td>
									<td><?php echo esc_html($user->user_login); ?></td>
									<td><?php echo esc_html($user->user_email); ?></td>
									<td><?php echo esc_html($user->display_name); ?></td>
									<td><?php echo date('Y-m-d', strtotime($user->user_registered)); ?></td>
									<td>
										<span><a href="<?php echo admin_url('user-edit.php') . '?user_id=' . $user->ID . '&wp_http_referer=/wp-admin/users.php?user_id=' . $user->ID; ?>" target="_blank">View Details</a></span>
										<span> | </span>
										<span><a href="<?php echo admin_url('users.php') . '?user_id=' . $user->ID; ?>" target="_blank">View From List</a></span>
									</td>
									<!-- Add other user data as needed -->
							</tr>
							<?php endforeach; ?>
					</table>
				</div>

				<div class="approved">
					<table class="wp-list-table widefat fixed striped table-view-list users">
							<tr><h1>Approved Practitioners</h1></tr>
							<tr>
									<th>ID</th>
									<th>Username</th>
									<th>Email</th>
									<th>Full Name</th>
									<th>Date Registered</th>
									<th>Action</th>
									<!-- Add other columns as needed -->
							</tr>
							<?php foreach ($practitioner_users as $user) : ?>
							<?php if ($this->isPending($user->ID)) { continue; } ?>
							<tr>
									<td><?php echo esc_html($user->ID); ?></td>
									<td><?php echo esc_html($user->user_login); ?></td>
									<td><?php echo esc_html($user->user_email); ?></td>
									<td><?php echo esc_html($user->display_name); ?></td>
									<td><?php echo date('Y-m-d', strtotime($user->user_registered)); ?></td>
									<td>
										<span><a href="<?php echo admin_url('user-edit.php') . '?user_id=' . $user->ID . '&wp_http_referer=/wp-admin/users.php?user_id=' . $user->ID; ?>" target="_blank">View Details</a></span>
										<span> | </span>
										<span><a href="<?php echo admin_url('users.php') . '?user_id=' . $user->ID; ?>" target="_blank">View From List</a></span>
									</td>
									<!-- Add other user data as needed -->
							</tr>
							<?php endforeach; ?>
					</table>
				</div>
			</div>
    </div>
    <?php
	}

	// Function to display the Practitioner Payment Report
	public function display_practitioner_payment_report() {
		$practitioner_users = get_users(['role' => 'um_practitioner']);
		$commission = get_option('practitioner_commission_rate') ? get_option('practitioner_commission_rate') : 10;
    ?>
    	<div class="wrap">
			<div id="rosita-practitioner" class="rosita-custom-type-customers">
        		<h1>Practitioner Payment Report</h1>
				<div class="approved">
					<h1>Pending Payment</h1>
					<table class="wp-list-table widefat fixed striped table-view-list payment-report">
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Customer Since</th>
							<th>Commission</th>
							<th>View Commission</th>
							<th>Action</th>
						</tr>
						<?php foreach ($practitioner_users as $user) : ?>
							<?php
								if ($this->isPending($user->ID)) { continue; }
								$customer_orders = get_posts(array(
									'numberposts' => -1,
									'meta_query'  => array(
										'relation' => 'AND', // Use 'AND' for multiple meta queries
										array(
											'key'     => 'practitioner_id',
											'value'   => $user->ID,
											'compare' => '='
										),
										array(
											'key'     => 'practitioner_paid',
											'value'   => 0,
											'compare' => '='
										),
									),
									'post_type'   => 'shop_order',
									'post_status' => 'wc-completed',
								));
								$order_total = 0;
								foreach ($customer_orders as $customer_order) {
									$order = wc_get_order($customer_order->ID);
									$order_total += $order->get_total();
								}
							?>
							<tr>
								<td><?php echo esc_html($user->ID); ?></td>
								<td><a href="<?php echo admin_url('user-edit.php') . '?user_id=' . $user->ID . '&wp_http_referer=/wp-admin/users.php?user_id=' . $user->ID; ?>" target="_blank"><?php echo esc_html($user->first_name.' '.$user->last_name); ?></a></td>
								<td><?php echo esc_html($user->user_email); ?></td>
								<td><?php echo esc_html(get_user_meta($user->ID, 'billing_phone', true)); ?></td>
								<td><?php echo date('Y-m-d', strtotime($user->user_registered)); ?></td>
								<td><?php echo get_woocommerce_currency_symbol().ROUND(($order_total/100)*$commission, 2); ?></td>
								<td>
									<a href="<?php echo admin_url('admin.php') . '?page=rosita-practitioner-payment-details&practitioner_id='.$user->ID; ?>" target="_blank">View Details</a>
								</td>
								<td>
									<?php if(ROUND(($order_total/100)*$commission, 2) > 0) : ?>
										<a href="<?php echo admin_url('admin.php') . '?page=rosita-practitioner-pay-commission&practitioner_id='.$user->ID; ?>">Pay Commission</a>
									<?php else : ?>
										Pay Commission
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
			</div>
    	</div>
    <?php }

	// Function to display the Practitioner Payment Details
	public function display_practitioner_payment_details() {
		$practitioner_id = isset($_GET['practitioner_id']) ? sanitize_text_field($_GET['practitioner_id']) : null;
		if (!$practitioner_id) {
			wp_redirect(admin_url('admin.php?page=rosita-practitioner-payment-report'));
			exit;
		}
		$practitioner_client_users = get_users(array(
			'role' => 'um_practitioner-client',
			'meta_key'    => 'practitioner_code',
			'meta_value'  => $practitioner_id,
		));
		$commission = get_option('practitioner_commission_rate') ? get_option('practitioner_commission_rate') : 10;
		$customer_orders = get_posts(array(
			'numberposts' => -1,
			'meta_key'    => 'practitioner_id',
			'meta_value'  => $practitioner_id,
			'post_type'   => 'shop_order',
			'post_status' => 'wc-completed',
		));
		$to_be_paid = 0;
		$amount_paid = 0;
		foreach ($customer_orders as $customer_order) {
			$order = wc_get_order($customer_order->ID);
			if ($order->get_meta('practitioner_paid')==0) {
				$to_be_paid += $order->get_total();
			} else {
				$amount_paid += $order->get_total();
			}
		}
    ?>
    	<div class="wrap">
			<div id="rosita-practitioner" class="rosita-custom-type-customers">
        		<h1>Practitioner Payment Details</h1>
				<div class="payment-details">
					<table class="wp-list-table widefat fixed striped">
						<tbody>
							<tr>
								<th>Unique Code:</th>
								<td><?php echo $practitioner_id; ?></td>
							</tr>
							<tr>
								<th>Commission To Be Paid:</th>
								<td>
									<strong><?php echo get_woocommerce_currency_symbol().ROUND(($to_be_paid/100)*$commission, 2); ?></strong>
									<?php if(ROUND(($to_be_paid/100)*$commission, 2) > 0) : ?>
										<a href="<?php echo admin_url('admin.php') . '?page=rosita-practitioner-pay-commission&practitioner_id='.$practitioner_id; ?>">Pay Commission</a>
									<?php endif; ?>
								</td>
							</tr>
							<tr>
								<th>Total Commission Paid:</th>
								<td><strong><?php echo get_woocommerce_currency_symbol().ROUND(($amount_paid/100)*$commission, 2); ?></strong></td>
							</tr>
						</tbody>
					</table>
				</div>
				<br>
				<div class="approved">
					<h2>Clients</h2>
					<?php if(!count($practitioner_client_users)) : ?>
						<div class="message info empty"><span>Practitioner does not have any clients.</span></div>
					<?php else : ?>
						<table class="wp-list-table widefat fixed striped table-view-list client">
							<tr>
								<th>Name</th>
								<th>No. Orders</th>
								<th>Total Sales</th>
							</tr>
							<?php foreach ($practitioner_client_users as $user) : ?>
								<?php
									if ($this->isPending($user->ID)) { continue; }
									$customer_orders = get_posts(array(
										'numberposts' => -1,
										'meta_query'  => array(
											'relation' => 'AND', // Use 'AND' for multiple meta queries
											array(
												'key'     => '_customer_user',
												'value'   => $user->ID,
												'compare' => '='
											),
											array(
												'key'     => 'practitioner_id',
												'value'   => $practitioner_id,
												'compare' => '='
											),
										),
										'post_type'   => 'shop_order',
										'post_status' => 'wc-completed',
									));
									$total_sales = 0;
								?>
								<div class="client-commission-details popup" id="commission-details-modal-<?php echo $user->ID; ?>" style="display: none">
									<div class="popup-content">
										<span class="popup-close">&times;</span>
										<h2 class="title">Commission Details</h2>
										<div class="table">
											<div class="column header">
												<div class="row">Order #</div>
												<div class="row">Order Subtotal</div>
												<div class="row">Commission</div>
											</div>
											<?php foreach ($customer_orders as $customer_order) : ?>
												<?php
													$order = wc_get_order($customer_order->ID);
													$order_total = $order->get_total();
													$total_sales += $order_total;
												?>
												<div class="column">
													<div class="row"><a href="<?php echo admin_url('post.php') . '?post='.$order->get_id().'&action=edit'; ?>" target="_blank"><?php echo $order->get_id(); ?></a></div>
													<div class="row"><?php echo get_woocommerce_currency_symbol().$order_total; ?></div>
													<div class="row"><?php echo get_woocommerce_currency_symbol().ROUND(($order_total/100)*$commission, 2); ?></div>
												</div>
											<?php endforeach; ?>
										</div>
									</div>
								</div>
								<tr>
									<td><a href="<?php echo admin_url('user-edit.php') . '?user_id=' . $user->ID . '&wp_http_referer=/wp-admin/users.php?user_id=' . $user->ID; ?>" target="_blank"><?php echo esc_html($user->first_name.' '.$user->last_name); ?></a></td>
									<td><a href="javascript:void(0)" class="commission-details" id="<?php echo $user->ID; ?>"><?php echo count($customer_orders); ?></a></td>
									<td><?php echo get_woocommerce_currency_symbol().$total_sales; ?></td>
								</tr>
							<?php endforeach; ?>
						</table>
					<?php endif; ?>
				</div>
				<br>
				<div class="approved">
					<h2>Commission Payments</h2>
					<?php
						global $wpdb;
						$table_name = $wpdb->prefix . 'practitioner_payments';
						$query = $wpdb->prepare("SELECT * FROM $table_name WHERE practitioner_id = %d", $practitioner_id);
						$payments = $wpdb->get_results($query);
					?>
					<?php if(!count($payments)) : ?>
						<div class="message info empty"><span>Practitioner does not have any commission payments.</span></div>
					<?php else : ?>
						<table class="wp-list-table widefat fixed striped table-view-list client">
							<tr>
								<th>Amount Paid</th>
								<th>Date</th>
							</tr>
							<?php foreach ($payments as $payment) : ?>
								<tr>
									<td><?php echo get_woocommerce_currency_symbol().$payment->amount_paid; ?></td>
									<td><?php echo $payment->date_paid; ?></td>
								</tr>
							<?php endforeach; ?>
						</table>
					<?php endif; ?>
				</div>
			</div>
    	</div>
    <?php }

	// Function to Pay Practitioner Commission
	public function practitioner_pay_commission() {
		$practitioner_id = isset($_GET['practitioner_id']) ? sanitize_text_field($_GET['practitioner_id']) : null;
		if (!$practitioner_id) {
			wp_redirect(admin_url('admin.php?page=rosita-practitioner-payment-report'));
			exit;
		}
		$commission = get_option('practitioner_commission_rate') ? get_option('practitioner_commission_rate') : 10;
		$customer_orders = get_posts(array(
			'numberposts' => -1,
			'meta_query'  => array(
				'relation' => 'AND', // Use 'AND' for multiple meta queries
				array(
					'key'     => 'practitioner_id',
					'value'   => $practitioner_id,
					'compare' => '='
				),
				array(
					'key'     => 'practitioner_paid',
					'value'   => 0,
					'compare' => '='
				),
			),
			'post_type'   => 'shop_order',
			'post_status' => 'wc-completed',
		));
		$amount_paid = 0;
		foreach ($customer_orders as $customer_order) {
			$order = wc_get_order($customer_order->ID);
			$amount_paid += $order->get_total();
			update_post_meta($customer_order->ID, 'practitioner_paid', 1, 0);
		}

		global $wpdb;
		$table_name = $wpdb->prefix . 'practitioner_payments';
		$data = array(
			'practitioner_id' => $practitioner_id,
			'amount_paid' => ROUND(($amount_paid/100)*$commission, 2),
			'date_paid' => date('Y-m-d H:i:s'),
		);
		$wpdb->insert($table_name, $data);
		if ($wpdb->last_error !== '') {
			wp_redirect(admin_url('admin.php?page=rosita-practitioner-payment-details&success=0&practitioner_id='.$practitioner_id));
		} else {
			wp_redirect(admin_url('admin.php?page=rosita-practitioner-payment-details&success=1&practitioner_id='.$practitioner_id));
		}
	}

	public function isPending($user_id) {
		// check if user is pending
		$status = get_user_meta($user_id, 'account_status', true);
		if ($status === 'awaiting_admin_review') {
			return true;
		}else {
			return false;
		}
	}

	public function add_custom_rosita_customer_fields($user){
		echo $this->display_rosita_custom_data($user);
	}

	public function display_rosita_custom_data($user) {
		$roles = $user->roles;
		$role = str_replace('um_', '', $roles[0]);
		$custom_data = $this->getCustomDataInfo();
		$html = '<div class="rosita-customer-custom-data">';
		foreach($custom_data as $section_name => $data){
			if($section_name != $role) continue;
			$html .= '<div class="' . $section_name . '-section' . '" style="margin-top:2rem;">';
			$html .= '<h1>' . $data['label'] . ' Info</h1>';
			$html .= '<table class="form-table"><tbody>';
				foreach ($data['fields'] as $key => $field) {
					$field_value = get_user_meta($user->ID, $key, true);
					$html .= '<tr><th><label for="' . $key . '">' . $field['label'] . '</label></th><td>';
					switch ($field['type']) {
						default:
						case 'text':
							$html .= '<input type="text" name="' . $key . '" id="' . $key . '" value="' .  esc_attr( $field_value ) . '" class="regular-text ltr" />';
							break;
						case 'email':
							$html .= '<input type="email" name="' . $key . '" id="' . $key . '" value="' .  esc_attr( $field_value ) . '" class="regular-text ltr" />';
							break;

						case 'textarea':
							$html .= '<textarea name="' . $key . '" id="' . $key . '" value="' .  esc_attr( $field_value ) . '" rows="5">' .  esc_attr( $field_value ) . '</textarea>';
							break;

						case 'select':
							$html .= '<select name="' . $key . '" id="' . $key . '" style="width: 25rem">';
							foreach ($field['options'] as $option_value) {
								$selected = $field_value == $option_value ? ' selected="selected"' : '';
								$html .= '<option ' . $selected . ' value="' . $option_value . '">' . $option_value . '</option>' ;
							}
							$html .= '</select>';
							break;

						case 'upload':
							if($field_value){
								$upload_dir = wp_upload_dir();
								$um_uploads_url = $upload_dir['baseurl'] . '/ultimatemember/' . $user->ID . '/';
								$uploaded_file = $um_uploads_url . $field_value;
								$original_file_data = get_user_meta($user->ID, $key . '_metadata', true);
								if (is_array($original_file_data)) {
									$html .= '<span>File: <a href="' . $uploaded_file . '">' . $original_file_data['original_name'] . '</a></span>';
								} else {
									$html .= '<span>File: <a href="' . $uploaded_file . '">Attachment</a></span>';
								}
							} else {
								$html .= '<span>File: None</span>';
							}
							break;
					}
					$html .= '</td></tr>';
				}
			$html .= '</tbody></table>';
			$html .= '</div>';
		}
		$html .= '</div>';
		return $html;
	}

	public function getCustomDataInfo(){
		return [
			'pensioner' => [
					'label' => 'Pensioner',
					'fields' => [
							'pensioner_identification' => ['label' => 'Pensioner Identification', 'type' => 'upload']
					]
			],
			'practitioner' => [
					'label' => 'Practitioner',
					'fields' => [
							'practitioner_company' => ['label' => 'Company', 'type' => 'text'],
							'key_position' => ['label' => 'Position', 'type' => 'text'],
							'taxvat' => ['label' => 'Tax/Vat Number', 'type' => 'text'],
							'website_url' => ['label' => 'Website Url', 'type' => 'text'],
							'practitioner_type' => [
									'label' => 'Practitioner Type', 
									'type' => 'select', 
									'options' => ['','Aroma Therapist','Chiropractor / Osteopath','Colonic Hydrotherapist','Dentist','Herbalist','Homeopath','Kinesiologist','Massage Therapist','Medical Doctor','Nutritionist / Naturopath','Personal Trainer (including biosig)','Pharmacist (including chemist)','Reiki & Chinese Medicine','Reflexologist','Functional Diagnostic Nutrition','Functional Medicine Practitioner','Other']
							],
							'practitioner_type_other' => ['label' => 'Practioner Type (Other)', 'type' => 'text'],
							'practitioner_qualification' => [
									'label' => 'Level Of Qualification',
									'type' => 'select',
									'options' => ['','Student','Certificate','Diploma','Degree','Masters','PHD','Other']
							],
							'practitioner_qual_other' => ['label' => 'Practioner QUalification (Other)', 'type' => 'text'],
							'practitioner_certificate' => ['label' => 'Practitioner Certificate', 'type' => 'upload'],
							'practitioner_associations' => ['label' => 'Please List The Professional Associations You Belong To', 'type' => 'textarea'],
							'practitioner_description' => ['label' => 'Describe Your Company Or Practice', 'type' => 'textarea'],
							'practitioner_how_long' => [
									'label' => 'How Long Have You Been In Business',
									'type' => 'select',
									'options' => ['','Under 1 Year', '1-2 Years', '2-5 Years', '5-10 Years', 'Over 10 Years']
							],
							'practitioner_how_many' => [
									'label' => 'How Many Practitioners Does Your Practice Have',
									'type' => 'select',
									'options' => ['','1', '2', '3', '4', '5', '6', '7', '8', '9', '10+']
							],
							'practitioner_annual' => [
									'label' => 'What Is Your Anticipated Annual Order Volume From Functional Self In £?',
									'type' => 'select',
									'options' => ['','0-500', '501-2000', '2001-5000', '5001-10000', '10000+']
							],
							'practitioner_num_clients' => [
									'label' => 'Number Of Unique Clients You See Each Week',
									'type' => 'select',
									'options' => ['','1-5', '6-10', '11-15', '16-20', '20+']
							],
							'payment_details' => [
									'label' => 'Payment Options',
									'type' => 'select',
									'options' => ['','Bank Transfer', 'Paypal']
							],
							'account_name' => ['label' => 'Bank Account Name', 'type' => 'text'],
							'sort_code' => ['label' => 'Sort Code', 'type' => 'text'],
							'bank_account' => ['label' => 'Bank Account Number', 'type' => 'text'],
							'paypal_account' => ['label' => 'Paypal Account', 'type' => 'email'],
					]
			],
			'practitioner-client' => [
					'label' => 'Practitioner Client',
					'fields' => [
							'practitioners_name' => ['label' => 'Practitioner\'s Name', 'type' => 'text'],
							'practitioner_code' => ['label' => 'Practitioner\'s Unique Reference Code', 'type' => 'text']
					]
			],
		];
	}
}
