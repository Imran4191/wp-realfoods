<?php
/**
 * Users authentication module
 * Authenticate the WooCommerce users using the imported Magento passwords
 *
 * @link       https://www.fredericgilles.net/fg-magento-to-woocommerce/
 * @since      1.0.0
 *
 * @package    FG_Magento_to_WooCommerce_Premium
 * @subpackage FG_Magento_to_WooCommerce_Premium/public
 */

if ( !class_exists('FG_Magento_to_WooCommerce_Users_Authenticate', false) ) {

	/**
	 * Users authentication class
	 *
	 * @package    FG_Magento_to_WooCommerce_Premium
	 * @subpackage FG_Magento_to_WooCommerce_Premium/public
	 * @author     Frédéric GILLES
	 */
	class FG_Magento_to_WooCommerce_Users_Authenticate {

		/**
		 * Authenticate a user using his Magento password
		 *
		 * @param WP_User $user User data
		 * @param string $username User login entered
		 * @param string $password Password entered
		 * @return WP_User User data
		 */
		public static function auth_signon($user, $username, $password) {
			
			if ( is_a($user, 'WP_User') ) {
				// User is already identified
				return $user;
			}
			
			if ( empty($username) || empty($password) ) {
				return $user;
			}
			
			$wp_user = get_user_by('login', $username); // Try to find the user by his login
			if ( !is_a($wp_user, 'WP_User') ) {
				$wp_user = get_user_by('email', $username); // Try to find the user by his email
				if ( !is_a($wp_user, 'WP_User') ) {
					// username not found in WP users
					return $user;
				}
			}
			
			// Get the imported magentopass
			$magentopass = get_user_meta($wp_user->ID, 'magentopass', true);
			if ( empty($magentopass) ) {
				return $user;
			}
			
			// Authenticate the user using the magento password
			if ( self::auth_magento($password, $magentopass) ) {
				// Update WP user password
				add_filter('send_password_change_email', '__return_false'); // Prevent an email to be sent
				wp_update_user(array('ID' => $wp_user->ID, 'user_pass' => $password));
				// To prevent the user to log in again with his Magento password once he has successfully logged in. The following times, his password stored in WordPress will be used instead.
				delete_user_meta($wp_user->ID, 'magentopass');
				
				return $wp_user;
			}
			
			return $user;
		}
		
		/**
		 * Magento user authentication
		 *
		 * @param string $username User login entered
		 * @param string $password Password entered
		 * @param string $magentopass Password stored in the WP usermeta table
		 * @return bool Is the Magento password good?
		 */
		private static function auth_magento($password, $magentopass) {
			$is_authentication_ok = false;
			if ( function_exists('password_verify') ) { // PHP >= 5.5
				$is_authentication_ok = password_verify($password, $magentopass);
			}
			if ( !$is_authentication_ok ) {
				list($hashed_magento_password, $salt, $version) = array_pad(explode(':', $magentopass), 3, '');
				$version = intval($version);
				$salted_password = $salt . stripslashes($password);

				switch ( $version ) {
					case 0: // MD5
						$is_authentication_ok = md5($salted_password) == $hashed_magento_password;
						if ( !$is_authentication_ok ) {
							// Magento Enterprise uses SHA256 without a version in the password field
							$is_authentication_ok = hash('sha256', $salted_password) == $hashed_magento_password;
						}
						break;
					
					case 1: // SHA256
						$is_authentication_ok = hash('sha256', $salted_password) == $hashed_magento_password;
						break;
					
					default: // ARGON2ID13
						if ( version_compare(PHP_VERSION, '7.2.0') >= 0) {
							$is_authentication_ok = self::getArgonHash($password, $salt) == $hashed_magento_password;
						} else {
							// Not supported if PHP < 7.2
							$is_authentication_ok = false;
						}
				}
			}
			return $is_authentication_ok;
		}
		
		/**
		 * Generate Argon2ID13 hash.
		 *
		 * @since 2.76.0
		 * 
		 * @param string $data
		 * @param string $salt
		 * @return string
		 * @throws \SodiumException
		 */
		private static function getArgonHash($data, $salt = '') {
			// Make the salt to have a correct size
			if ( strlen($salt) < SODIUM_CRYPTO_PWHASH_SALTBYTES ) {
				$salt = str_pad($salt, SODIUM_CRYPTO_PWHASH_SALTBYTES, $salt);
			} elseif ( strlen($salt) > SODIUM_CRYPTO_PWHASH_SALTBYTES ) {
				$salt = substr($salt, 0, SODIUM_CRYPTO_PWHASH_SALTBYTES);
			}
			return bin2hex(sodium_crypto_pwhash(
				SODIUM_CRYPTO_SIGN_SEEDBYTES,
				$data,
				$salt,
				SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
				SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE,
				SODIUM_CRYPTO_PWHASH_ALG_ARGON2ID13
			));
		}

	}
}
