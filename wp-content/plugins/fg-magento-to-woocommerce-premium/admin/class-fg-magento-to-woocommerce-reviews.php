<?php
/**
 * Reviews class
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      2.10.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
 */

if ( !class_exists('FG_Magento_to_WooCommerce_Reviews', false) ) {

	/**
	 * Reviews class
	 *
	 * @package    FG_Magento_to_WooCommerce_Premium
	 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Magento_to_WooCommerce_Reviews {

		private $plugin;
		private $not_approved_status; // ID of the "Not Approved" status
		
		/**
		 * Initialize the class and set its properties.
		 *
		 * @param    object    $plugin       Admin plugin
		 */
		public function __construct( $plugin ) {

			$this->plugin = $plugin;

		}

		/**
		 * Reset the Magento last imported review ID
		 *
		 */
		public function reset_reviews() {
			update_option('fgm2wc_last_magento_review_id', 0);
		}
		
		/**
		 * Import the Magento product reviews
		 *
		 */
		public function import_reviews() {
			
			if ( isset($this->plugin->premium_options['skip_reviews']) && $this->plugin->premium_options['skip_reviews'] ) {
				return;
			}
			
			if ( $this->plugin->import_stopped() ) {
				return;
			}
			
			$message = __('Importing reviews...', $this->plugin->get_plugin_name());
			if ( defined('WP_CLI') ) {
				$progress_cli = \WP_CLI\Utils\make_progress_bar($message, $this->get_reviews_count());
			} else {
				$this->plugin->log($message);
			}
			$imported_reviews_count = 0;
			
			$customers = $this->plugin->get_imported_magento_customers();
			$imported_products_in_all_languages = $this->plugin->get_imported_magento_products();
			$products_ids = array_key_exists($this->plugin->default_language, $imported_products_in_all_languages)? $imported_products_in_all_languages[$this->plugin->default_language] : array();
			$this->status_list = $this->get_review_statuses();
			
			do {
				if ( $this->plugin->import_stopped() ) {
					return;
				}
				$reviews = $this->get_reviews($this->plugin->chunks_size);
				$reviews_count = count($reviews);

				foreach ( $reviews as $review ) {
					// Increment the Magento last imported review ID
					update_option('fgm2wc_last_magento_review_id', $review['review_id']);
					
					$product_id = array_key_exists($review['product_id'], $products_ids)? $products_ids[$review['product_id']]: 0;
					if ( $product_id != 0 ) {
						$user_id = array_key_exists($review['customer_id'], $customers)? $customers[$review['customer_id']]: 0;
						$content = '<h3>' . $review['title'] . '</h3>' . $review['detail'];
						$status = $this->get_comment_status($review['status_id']);
						$comment = array(
							'comment_post_ID'		=> $product_id,
							'comment_author'		=> $review['nickname'],
							'comment_author_email'	=> '',
							'comment_content'		=> $content,
							'comment_type'			=> 'review',
							'user_id'				=> $user_id,
							'comment_author_IP'		=> '',
							'comment_date'			=> $review['created_at'],
							'comment_approved'		=> $status,
						);
						$comment_id = wp_insert_comment($comment);
						if ( !empty($comment_id) ) {
							$imported_reviews_count++;
							$rating = $this->get_average_rating($review['review_id']);
							if ( $rating != 0 ) {
								add_comment_meta($comment_id, 'rating', $rating, true);
							}
						}
					}
				}
				$this->plugin->progressbar->increment_current_count($reviews_count);
				
				if ( defined('WP_CLI') ) {
					$progress_cli->tick($this->plugin->chunks_size);
				}
			} while ( ($reviews != null) && ($reviews_count > 0) );
			
			if ( defined('WP_CLI') ) {
				$progress_cli->finish();
			}
			
			$this->plugin->display_admin_notice(sprintf(_n('%d review imported', '%d reviews imported', $imported_reviews_count, $this->plugin->get_plugin_name()), $imported_reviews_count));
		}
		
		/**
		 * Get the Magento review statuses
		 */
		private function get_review_statuses() {
			$reviews_statuses = array();
			
			$prefix = $this->plugin->plugin_options['prefix'];
			$sql = "
				SELECT s.status_id, s.status_code
				FROM {$prefix}review_status s
			";
			$result = $this->plugin->magento_query($sql);
			foreach ( $result as $row ) {
				$reviews_statuses[$row['status_id']] = $row['status_code'];
				if ( $row['status_code'] == 'Not Approved' ) {
					$this->not_approved_status = $row['status_id']; // Store the "Not approved" status ID
				}
			}

			return $reviews_statuses;
		}
		
		/**
		 * Get the Magento product reviews
		 *
		 * @param int $limit Number of reviews max
		 * @return array of product reviews
		 */
		private function get_reviews($limit) {
			$product_reviews = array();
			
			$review_entity_id = $this->get_product_review_entity_id();
			$last_magento_review_id = (int)get_option('fgm2wc_last_magento_review_id'); // to restore the import where it left

			$prefix = $this->plugin->plugin_options['prefix'];
			$sql = "
				SELECT r.review_id, r.created_at, r.entity_pk_value AS product_id, r.status_id, rd.store_id, rd.title, rd.detail, rd.nickname, rd.customer_id
				FROM {$prefix}review r
				LEFT JOIN {$prefix}review_detail rd ON rd.review_id = r.review_id
				WHERE r.entity_id = $review_entity_id -- Get only the product reviews
				AND r.review_id > '$last_magento_review_id'
				AND r.status_id != {$this->not_approved_status}
				ORDER BY r.review_id
				LIMIT $limit
			";
			$product_reviews = $this->plugin->magento_query($sql);

			return $product_reviews;
		}
		
		/**
		 * Get the review entity ID of the term "product"
		 * 
		 * @return int Entity ID
		 */
		private function get_product_review_entity_id() {
			$review_entity_id = 0;
			
			$prefix = $this->plugin->plugin_options['prefix'];
			$sql = "
				SELECT re.entity_id
				FROM {$prefix}review_entity re
				WHERE re.entity_code = 'product'
			";
			$result = $this->plugin->magento_query($sql);
			if ( isset($result[0]) ) {
				$review_entity_id = $result[0]['entity_id'];
			}
			
			return $review_entity_id;
		}
		
		/**
		 * Get the comment status of a Magento review status
		 * 
		 * @param int $review_status_id Magento review status ID
		 */
		private function get_comment_status($review_status_id) {
			return isset($this->status_list[$review_status_id]) && ($this->status_list[$review_status_id] == 'Approved')? 1 : 0;
		}
		
		/**
		 * Get the average rating of a review
		 * 
		 * @param int $review_id Review ID
		 * @return float Average rating (between 0 and 5)
		 */
		private function get_average_rating($review_id) {
			$rating = 0;
			
			$prefix = $this->plugin->plugin_options['prefix'];
			$sql = "
				SELECT ROUND(AVG(r.value)) AS avg_rating
				FROM {$prefix}rating_option_vote r
				WHERE r.review_id = $review_id
			";
			$result = $this->plugin->magento_query($sql);
			if ( isset($result[0]) ) {
				$rating = $result[0]['avg_rating'];
			}
			
			return $rating;
		}
		
		/**
		 * Update the number of total elements found in Magento
		 * 
		 * @param int $count Number of total elements
		 * @return int Number of total elements
		 */
		public function get_total_elements_count($count) {
			if ( !isset($this->plugin->premium_options['skip_reviews']) || !$this->plugin->premium_options['skip_reviews'] ) {
				$count += $this->get_reviews_count();
			}
			return $count;
		}
		
		/**
		 * Get the number of reviews
		 * 
		 */
		private function get_reviews_count() {
			$count = 0;
			$prefix = $this->plugin->plugin_options['prefix'];

			$sql = "
				SELECT COUNT(*) AS nb
				FROM {$prefix}review r
				LEFT JOIN {$prefix}review_detail rd ON rd.review_id = r.review_id
				LEFT JOIN {$prefix}review_status s ON s.status_id = r.status_id
				WHERE s.status_code != 'Not Approved'
			";
			
			$result = $this->plugin->magento_query($sql);
			if ( isset($result[0]['nb']) ) {
				$count = $result[0]['nb'];
			}
			return $count;
		}
		
	}
}
