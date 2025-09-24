<?php
defined( 'ABSPATH' ) || die( 'Cannot access pages directly.' );

if ( ! defined( 'DFWBC_STORE_KEY' ) ) {
	define( 'DFWBC_STORE_KEY', 'DFW_store_key' );
}

class DFWBridgeConnector {
	const CART_ID         = 'Woocommerce';
	const BRIDGE_ACTION   = 'checkbridge';
	const BRIDGE_FOLDER   = 'bridge2cart';
	const BRIDGE_ENDPOINT = 'dfwconnector/v1/bridge-action';

	public $bridgeUrl = '';

	public $callbackUrl = '';

	public $publicKey = '';

	public $root = '';

	public $bridgePath = '';

	public $errorMessage = '';

	public $configFilePath = '/config.php';

	public function __construct() {
		$this->root       = realpath( WP_CONTENT_DIR . '/..' );
		$this->bridgePath = realpath( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . self::BRIDGE_FOLDER;
		$this->bridgeUrl  = get_home_url( null, rest_get_url_prefix(), 'rest' ) . DIRECTORY_SEPARATOR . self::BRIDGE_ENDPOINT;
	}

	/**
	 * GetBridgeUrl
	 *
	 * @return string
	 */
	public function getBridgeUrl() {
		return $this->bridgeUrl;
	}

	/**
	 * IsBridgeExist
	 *
	 * @return boolean
	 */
	public function isBridgeExist() {
		if ( is_dir( $this->bridgePath ) && file_exists( $this->bridgePath . '/bridge.php' ) && file_exists( $this->bridgePath . '/config.php' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * InstallBridge
	 *
	 * @return array
	 */
	public function installBridge() {
		if ( $this->isBridgeExist() ) {
			return $this->_checkBridge( true );
		} else {
			return [
				'success' => false,
				'message' => 'Bridge not exist. Please reinstall plugin',
				'custom'  => true,
			];
		}
	}

	/**
	 * UpdateToken
	 *
	 * @param string $token Token
	 *
	 * @return array
	 */
	public function updateToken( $token ) {
		$result = [
			'success' => false,
			'message' => 'Can\'t update Store Key',
		];

		$config = @fopen( $this->bridgePath . $this->configFilePath, 'w' );

		if ( ! $config ) {
			$result['message'] = 'Can\'t open config.php. Please check permissions';

			return $result;
		}

		$writed = fwrite( $config, "<?php if (!defined('DFWBC_TOKEN')) {define('DFWBC_TOKEN', '" . $token . "');}" );

		if ( false === $writed ) {
			$result['message'] = 'Can\'t save config.php. Please check permissions';

			return $result;
		}

		fclose( $config );

		return [
			'success' => true,
			'message' => 'Store Key updated successfully',
		];
	}

	/**
	 * GetStoreKey
	 *
	 * @return string
	 * @throws Exception
	 */
	public function getStoreKey() {
		$isMultiStore = function_exists( 'get_site_meta' );
		$storeKey     = $isMultiStore ? get_site_meta( 1, DFWBC_STORE_KEY, true ) : get_option( DFWBC_STORE_KEY );

		if ( ! $storeKey ) {
			$storeKey = self::generateStoreKey();
			if ( $isMultiStore ) {
				update_site_meta( 1, DFWBC_STORE_KEY, $storeKey );
			} else {
				update_option( DFWBC_STORE_KEY, $storeKey );
			}
		}

		preg_match( "/define\('(\w+)',\s*'([^']+)'\);/", file_get_contents( $this->bridgePath . $this->configFilePath ), $matches );

		if ( isset( $matches[2] ) && $matches[2] != $storeKey ) {
			$this->updateToken( $storeKey );
		}

		return $storeKey;
	}

	/**
	 * UpdateStoreKey
	 *
	 * @return string
	 * @throws Exception
	 */
	public function updateStoreKey() {
		$storeKey = self::generateStoreKey();
		function_exists( 'update_site_meta' ) ? update_site_meta( 1, DFWBC_STORE_KEY, $storeKey ) : update_option( DFWBC_STORE_KEY, $storeKey );

		return $storeKey;
	}

	/**
	 * GenerateStoreKey
	 *
	 * @return string
	 * @throws Exception
	 */
	public static function generateStoreKey() {
		$bytesLength = 256;

		if ( function_exists( 'random_bytes' ) ) {
			// available in PHP 7
			return md5( random_bytes( $bytesLength ) );
		}

		if ( function_exists( 'openssl_random_pseudo_bytes' ) ) {
			$bytes = openssl_random_pseudo_bytes( $bytesLength );
			if ( false !== $bytes ) {
				return md5( $bytes );
			}
		}

		if ( file_exists( '/dev/urandom' ) && is_readable( '/dev/urandom' ) ) {
			$frandom = fopen( '/dev/urandom', 'r' );
			if ( false !== $frandom ) {
				return md5( fread( $frandom, $bytesLength ) );
			}
		}

		$rand = '';
		for ( $i = 0; $i < $bytesLength; $i ++ ) {
			$rand .= chr( mt_rand( 0, 255 ) );
		}

		return md5( $rand );
	}

	/**
	 * Request
	 *
	 * @param string $storeKey Store Key
	 * @param bool   $isHttp   Store Key
	 *
	 * @return array|WP_Error
	 */
	protected function _request( $storeKey, $isHttp = false ) {
		$params  = [ 'store_root' => isset( $this->root ) ? $this->root : '' ];
		$data    = $this->_prepareUseHash( $storeKey, $params );
		$query   = http_build_query( $data['get'] );
		$headers = [
			'Accept-Language:*',
			'User-Agent:' . $this->_randomUserAgent(),
		];

		$url = $this->bridgeUrl . '?' . $query;

		if ( wp_http_supports( array( 'ssl' ) ) ) {
			$url = set_url_scheme( $url, 'https' );
		}

		if ( $isHttp ) {
			$url = set_url_scheme( $url, 'http' );
		}

		return wp_remote_post( $url,
			[
				'method'      => 'POST',
				'timeout'     => 30,
				'redirection' => 5,
				'blocking'    => true,
				'headers'     => $headers,
				'body'        => $data['post'],
				'cookies'     => [],
			] );

	}

	/**
	 * PrepareUseHash
	 *
	 * @param string     $storeKey Store Key
	 * @param array|null $params   Parameters
	 *
	 * @return array
	 */
	private function _prepareUseHash( $storeKey, array $params = null ) {
		$getParams = [
			'unique'         => md5( uniqid( mt_rand(), 1 ) ),
			'disable_checks' => 1,
			'cart_id'        => self::CART_ID,
		];

		if ( ! is_array( $params ) ) {
			$params = [];
		}

		$params['action']     = self::BRIDGE_ACTION;
		$params['cart_id']    = self::CART_ID;
		$params['store_root'] = rtrim( $this->root, DIRECTORY_SEPARATOR );

		ksort( $params, SORT_STRING );
		$params['a2c_sign'] = hash_hmac( 'sha256', http_build_query( $params ), $storeKey );

		return [
			'get'  => $getParams,
			'post' => $params,
		];
	}

	/**
	 * Get randomUserAgent
	 * Generate random User-Agent
	 *
	 * @return string
	 */
	private function _randomUserAgent() {
		$rand = mt_rand(1, 3);
		switch ($rand) {
			case 1:
				return 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:25.0) Gecko/2010' . mt_rand(10, 12) . mt_rand(10, 30) . ' Firefox/' . mt_rand(
						10,
						25
					) . '.0';

			case 2:
				return 'Mozilla/6.0 (Windows NT 6.2; WOW64; rv:16.0.1) Gecko/2012' . mt_rand(10, 12) . mt_rand(10, 30) . ' Firefox/' . mt_rand(
						10,
						16
					) . '.0.1';

			case 3:
				return 'Opera/10.' . mt_rand(10, 60) . ' (Windows NT 5.1; U; en) Presto/2.6.30 Version/10.60';
		}
	}

	/**
	 * CheckBridge
	 *
	 * @param bool $isCustom Custom Flag
	 *
	 * @return array
	 */
	protected function _checkBridge( $isCustom = false ) {
		$file = @fopen( $this->bridgePath . $this->configFilePath, 'r' );

		if ( $file ) {
			$content  = fread( $file, filesize( $this->bridgePath . $this->configFilePath ) );
			$storeKey = '';

			foreach ( explode( "\n", $content ) as $line ) {
				if ( preg_match( '/define\([\'|"]DFWBC_TOKEN[\'|"],[ ]*[\'|"](.*?)[\'|"]\)/s', $line, $matches ) ) {
					$storeKey = $matches[1];
					break;
				}
			}

			fclose( $file );
			$res = $this->_request( $storeKey );

			if ( is_wp_error( $res ) && strpos( $res->get_error_message(), 'cURL error' ) !== false ) {
				// try to http
				$res = $this->_request( $storeKey, true );
			}

			if ( strpos( $res['body'], 'BRIDGE_OK' ) !== false ) {
				$callbackRes = $this->_sendRequestToCallback( $storeKey );

				if ( is_wp_error( $callbackRes ) ) {
					return [
						'success' => false,
						'message' => $callbackRes->get_error_message(),
						'custom'  => $isCustom,
					];
				}

				return [
					'success' => true,
					'message' => 'Bridge install successfully',
					'custom'  => $isCustom,
				];
			}

			if ( is_wp_error( $res ) ) {
				return [
					'success' => false,
					'message' => 'Url:' . $this->bridgeUrl . PHP_EOL . $res->get_error_message(),
					'custom'  => $isCustom,
				];
			} else {
				return [
					'success' => false,
					'message' => 'Can\'t verify bridge url: ' . $this->bridgeUrl . '. Status code:' . wp_remote_retrieve_response_code( $res ),
					'custom'  => $isCustom,
				];
			}
		} else {
			$error = error_get_last();

			return [
				'success' => false,
				'message' => 'Url:' . $this->bridgeUrl . PHP_EOL . $error['message'],
				'custom'  => $isCustom,
			];
		}
	}

	/**
	 * SendRequestToCallback
	 *
	 * @param string $storeKey Store Key
	 *
	 * @return array|WP_Error
	 */
	private function _sendRequestToCallback( $storeKey ) {
		if ( $this->callbackUrl && $this->publicKey ) {
			if ( ! extension_loaded( 'openssl' ) ) {
				return new WP_Error( 'openssl_error', __( 'Open SSL PHP extension isn\'t available.' ) );
			}

			$pubKey = openssl_pkey_get_public( $this->publicKey );

			if ( ! ( $pubKey ) ) {
				return new WP_Error( 'openssl_error', __( 'Public Key isn\'t valid. Please rebuild plugin with valid Public Key.' ) );
			}

			$keyData = openssl_pkey_get_details( $pubKey );
			$userAgent = $this->_randomUserAgent();
			$headers = [
				'Accept-Language:*',
				'Content-Type:application/json',
				'User-Agent:' . $userAgent,
				'x-webhook-cart-id:' . self::CART_ID,
				'x-webhook-timestamp:' . time(),
			];

			$params['store_url']  = get_home_url();
			$params['store_key']  = $storeKey;
			$params['store_root'] = rtrim( isset( $this->root ) ? $this->root : '', DIRECTORY_SEPARATOR );
			$params['bridge_url'] = $this->getBridgeUrl();

			ksort( $params, SORT_STRING );
			$data = json_encode( $params );

			$len    = ( $keyData['bits'] / 8 - 11 );
			$data   = str_split( $data, $len );
			$result = '';

			foreach ( $data as $d ) {
				if ( openssl_public_encrypt( $d, $encrypted, $this->publicKey ) ) {
					$result .= $encrypted;
				} else {
					return new WP_Error( 'openssl_error', __( 'Open SSL encryption error' ) );
				}
			}

			$res = wp_remote_post( $this->callbackUrl,
				[
					'method'      => 'POST',
					'timeout'     => 30,
					'redirection' => 5,
					'httpversion' => '1.0',
					'sslverify'   => false,
					'blocking'    => true,
					'headers'     => $headers,
					'body'        => [ 'data' => base64_encode( $result ) ],
					'cookies'     => [],
				] );

			if ( is_array( $res ) && ! in_array( $res['response']['code'], [ 200, 201, 204 ] ) ) {
				return new WP_Error( 'callback_bad_request', __( $res['response']['message'] ) );
			} else {
				return $res;
			}
		}
	}

}
