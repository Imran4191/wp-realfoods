<?php
/**
 * Users class
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      1.0.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
 */

if ( !class_exists('FG_Magento_to_WooCommerce_Users', false) ) {

	/**
	 * Users class
	 *
	 * @package    FG_Magento_to_WooCommerce_Premium
	 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Magento_to_WooCommerce_Users {
		
		private $plugin;
		private $users = array();

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 * @param    object    $plugin       Admin plugin
		 */
		public function __construct( $plugin ) {

			$this->plugin = $plugin;

		}

		/**
		 * Delete all users except the current user
		 *
		 */
		public function delete_users($action) {
			global $wpdb;
			
			$sql_queries = array();

			$current_user = get_current_user_id();
			
			if ( $action == 'all' ) {
				
				// Delete all users except the current user
				if ( is_multisite() ) {
					$blogusers = get_users(array('exclude' => $current_user));
					foreach ( $blogusers as $user ) {
						wp_delete_user($user->ID);
					}
				} else { // monosite (quicker)
					$sql_queries[] = <<<SQL
-- Delete User meta
DELETE FROM $wpdb->usermeta
WHERE user_id != '$current_user'
SQL;

				$sql_queries[] = <<<SQL
-- Delete Users
DELETE FROM $wpdb->users
WHERE ID != '$current_user'
SQL;

					// Execute SQL queries
					if ( count($sql_queries) > 0 ) {
						foreach ( $sql_queries as $sql ) {
							$wpdb->query($sql);
						}
					}
				}
				$this->reset_users_autoincrement();
				
			} else {
				
				// Delete only the imported users
				
				if ( is_multisite() ) {
					$users = array_merge($this->plugin->get_imported_magento_users() , $this->plugin->get_imported_magento_customers());
					foreach ( $users as $user_id ) {
						if ( $user_id != $current_user ) {
							wp_delete_user($user_id);
						}
					}
					
				} else {
					// Truncate the temporary table
					$sql_queries[] = <<<SQL
TRUNCATE {$wpdb->prefix}fg_data_to_delete;
SQL;

					// Insert the imported users IDs in the temporary table
					$sql_queries[] = <<<SQL
INSERT IGNORE INTO {$wpdb->prefix}fg_data_to_delete (`id`)
SELECT user_id FROM $wpdb->usermeta
WHERE meta_key LIKE '_fgm2wc_%'
AND user_id != '$current_user'
SQL;

					$sql_queries[] = <<<SQL
-- Delete Users and user metas
DELETE u, um
FROM $wpdb->users u
LEFT JOIN $wpdb->usermeta um ON um.user_id = u.ID
INNER JOIN {$wpdb->prefix}fg_data_to_delete del
WHERE u.ID = del.id;
SQL;

					// Execute SQL queries
					if ( count($sql_queries) > 0 ) {
						foreach ( $sql_queries as $sql ) {
							$wpdb->query($sql);
						}
					}
				}
			}
			wp_cache_flush();
			
			// Reset the Magento last imported user ID
			update_option('fgm2wc_last_user_id', 0);
			update_option('fgm2wc_last_magento_customer_id', 0);

			$this->plugin->display_admin_notice(__('Users deleted', $this->plugin->get_plugin_name()));
		}

		/**
		 * Reset the wp_users autoincrement
		 */
		private function reset_users_autoincrement() {
			global $wpdb;
			
			$sql = "SELECT IFNULL(MAX(ID), 0) + 1 FROM $wpdb->users";
			$max_id = $wpdb->get_var($sql);
			$sql = "ALTER TABLE $wpdb->users AUTO_INCREMENT = $max_id";
			$wpdb->query($sql);
		}
		
		/**
		 * Import all the users
		 * 
		 */
		public function import_users() {
			
			if ( isset($this->plugin->premium_options['skip_users']) && $this->plugin->premium_options['skip_users'] ) {
				return;
			}
			
			if ( $this->plugin->import_stopped() ) {
				return;
			}
			
			$message = __('Importing users...', $this->plugin->get_plugin_name());
			if ( defined('WP_CLI') ) {
				$progress_cli = \WP_CLI\Utils\make_progress_bar($message, $this->get_users_count());
			} else {
				$this->plugin->log($message);
			}
			$imported_users_count = 0;
			
			// Hook for other actions
			do_action('fgm2wcp_pre_import_users', $this->users);
			
			do {
				if ( $this->plugin->import_stopped() ) {
					return;
				}
				$users = $this->get_users($this->plugin->chunks_size);
				$users_count = count($users);
				foreach ( $users as &$user ) {
					// Increment the Magento last imported user ID
					update_option('fgm2wc_last_user_id', $user['user_id']);
					
					// Check if the user is administrator or not
					$role = $this->is_admin($user['user_id'])? 'administrator': 'subscriber';
					$user_id = $this->plugin->add_user($user['firstname'], $user['lastname'], $user['username'], $user['email'], $user['password'], $user['user_id'], $user['created'], $role);
					if ( !is_wp_error($user_id) ) {
						$imported_users_count++;
						$user['new_id'] = $user_id;
						// Link between the Magento ID and the WordPress user ID
						add_user_meta($user_id, 'magento_user_id', $user['user_id'], true);
						do_action('fgm2wcp_post_add_user', $user_id, $user);
					}
				}
				
				// Hook for other actions
				do_action('fgm2wcp_post_import_users', $users);
				
				$this->plugin->progressbar->increment_current_count($users_count);
				
				if ( defined('WP_CLI') ) {
					$progress_cli->tick($this->plugin->chunks_size);
				}
			} while ( ($users != null) && ($users_count > 0) );
			
			if ( defined('WP_CLI') ) {
				$progress_cli->finish();
			}
			
			$this->plugin->display_admin_notice(sprintf(_n('%d user imported', '%d users imported', $imported_users_count, $this->plugin->get_plugin_name()), $imported_users_count));
		}
		
		/**
		 * Get all the Magento users
		 * 
		 * @param int $limit Number of users max
		 * @return array Users
		 */
		protected function get_users($limit=1000) {
			$users = array();
			$prefix = $this->plugin->plugin_options['prefix'];
			$last_user_id = (int)get_option('fgm2wc_last_user_id'); // to restore the import where it left
			$sql = "
				SELECT u.user_id, u.firstname, u.lastname, u.email, u.username, u.password, u.created
				FROM {$prefix}admin_user u
				WHERE u.user_id > '$last_user_id'
				AND u.is_active = 1
				ORDER BY u.user_id
				LIMIT $limit
			";
			$sql = apply_filters('fgm2wc_get_users_sql', $sql);
			$result = $this->plugin->magento_query($sql);
			foreach ( $result as $row ) {
				$users[$row['user_id']] = $row;
			}
			return $users;
		}
		
		/**
		 * Test if the user is an administrator
		 * 
		 * @param int $user_id User ID
		 * @return bool User is admin?
		 */
		private function is_admin($user_id) {
			$prefix = $this->plugin->plugin_options['prefix'];
			$role_table = version_compare($this->plugin->magento_version, '2', '<')? 'admin_role' : 'authorization_role';
			$sql = "
				SELECT role_id
				FROM {$prefix}{$role_table}
				WHERE user_id = '$user_id'
			";
			$result = $this->plugin->magento_query($sql);
			return count($result) > 0;
		}
		
		/**
		 * Update the number of total elements found in Magento
		 * 
		 * @since 2.0.0
		 * 
		 * @param int $count Number of total elements
		 * @return int Number of total elements
		 */
		public function get_total_elements_count($count) {
			if ( !isset($this->plugin->premium_options['skip_users']) || !$this->plugin->premium_options['skip_users'] ) {
				$count += $this->get_users_count();
			}
			return $count;
		}

		/**
		 * Get the number of Magento users
		 * 
		 * @since 2.0.0
		 * 
		 * @return int Number of users
		 */
		private function get_users_count() {
			$prefix = $this->plugin->plugin_options['prefix'];
			$sql = "
				SELECT COUNT(*) AS nb
				FROM {$prefix}admin_user u
				WHERE u.is_active = 1
			";
			$result = $this->plugin->magento_query($sql);
			$users_count = isset($result[0]['nb'])? $result[0]['nb'] : 0;
			return $users_count;
		}

	}
}
