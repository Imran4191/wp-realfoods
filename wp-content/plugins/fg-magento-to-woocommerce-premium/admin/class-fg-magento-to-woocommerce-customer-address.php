<?php
/**
 * Customer address class
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      1.0.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
 */

if ( !class_exists('FG_Magento_to_WooCommerce_Customer_Address', false) ) {

	/**
	 * Address class
	 *
	 * @package    FG_Magento_to_WooCommerce_Premium
	 * @subpackage FG_Magento_to_WooCommerce_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Magento_to_WooCommerce_Customer_Address {

		private $plugin;
		
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
		 * Get the customer address data
		 * 
		 * @param int $entity_id Entity ID
		 * @return array Address data
		 */
		public function get_customer_address($entity_id) {
			$address = array();
			$address['entity_id'] = $entity_id;
			if ( version_compare($this->plugin->magento_version, '2', '<') ) {
				// Magento 1
				$other_fields = $this->plugin->get_attribute_values($entity_id, $this->plugin->customer_address_type_id, array(
					'street',
					'firstname',
					'lastname',
					'company',
					'city',
					'country_id',
					'region',
					'region_id',
					'postcode',
					'telephone',
				));
				$address = array_merge($address, $other_fields);
			} else {
				// Magento 2+
				$address = $this->get_customer_address_entity($entity_id);
			}

			// Address fields
			if ( isset($address['street']) ) {
				list($address['address1'], $address['address2']) = $this->split_address($address['street']);
			}

			// Region code
			$address['region'] = '';
			if ( isset($address['region_id']) && !empty($address['region_id']) ) {
				$region_code = $this->get_region_code($address['region_id']);
				if ( !empty($region_code) ) {
					$address['region'] = $region_code;
				}
			}
			return $address;
		}
		
		/**
		 * Get the customer address entity (Magento 2)
		 * 
		 * @since 2.34.0
		 * 
		 * @param int $entity_id Entity ID
		 * @return array Address data
		 */
		public function get_customer_address_entity($entity_id) {
			$address = array();
			$prefix = $this->plugin->plugin_options['prefix'];

			$sql = "
				SELECT a.entity_id, a.street, a.firstname, a.lastname, a.company, a.city, a.country_id, a.region, a.region_id, a.postcode, a.telephone
				FROM {$prefix}customer_address_entity a
				WHERE a.entity_id = '$entity_id'
				LIMIT 1
			";
			$result = $this->plugin->magento_query($sql);
			if ( isset($result[0]) ) {
				$address = $result[0];
			}
			return $address;
		}
		
		/**
		 * Split the address into address1 and address2
		 * 
		 * @param string $address
		 * @return array[address1, address2]
		 */
		public function split_address($address) {
			$address_lines = explode("\n", $address);
			$address1 = isset($address_lines[0])? $address_lines[0]: '';
			$address2 = isset($address_lines[1])? $address_lines[1]: '';
			return array($address1, $address2);
		}
		
		/**
		 * Get the region code
		 * 
		 * @param int $region_id Magento region ID
		 * @return string Region code
		 */
		public function get_region_code($region_id) {
			$region_code = '';
			$prefix = $this->plugin->plugin_options['prefix'];

			$sql = "
				SELECT r.code
				FROM {$prefix}directory_country_region r
				WHERE r.region_id = '$region_id'
				LIMIT 1
			";
			$result = $this->plugin->magento_query($sql);
			if ( isset($result[0]['code']) ) {
				$region_code = $result[0]['code'];
			}
			return $region_code;
		}
		
		/**
		 * Get the region code
		 * 
		 * @since 1.12.1
		 * 
		 * @param int $region_name Magento region name
		 * @return string Region code
		 */
		public function get_region_code_from_name($region_name) {
			$region_code = '';
			$prefix = $this->plugin->plugin_options['prefix'];

			$sql = "
				SELECT r.code
				FROM {$prefix}directory_country_region r
				WHERE r.default_name = '$region_name'
				LIMIT 1
			";
			$result = $this->plugin->magento_query($sql);
			if ( isset($result[0]['code']) ) {
				$region_code = $result[0]['code'];
			}
			return $region_code;
		}
		
	}
}
