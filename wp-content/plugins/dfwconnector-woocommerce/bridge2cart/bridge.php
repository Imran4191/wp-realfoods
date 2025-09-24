<?php

interface DFW_Platform_Actions {

	/**
	 * ProductUpdateAction
	 *
	 * @param array $a2cData Data
	 *
	 * @return mixed
	 */
	public function productUpdateAction( array $a2cData );

	/**
	 * SendEmailNotifications
	 *
	 * @param array $a2cData Data
	 *
	 * @return mixed
	 */
	public function sendEmailNotifications( array $a2cData );

	/**
	 * GetPlugins
	 *
	 * @return mixed
	 */
	public function getPlugins();

	/**
	 * TriggerEvents
	 *
	 * @param array $a2cData Data
	 *
	 * @return mixed
	 */
	public function triggerEvents( array $a2cData );

	/**
	 * SetMetaData
	 *
	 * @param array $a2cData Data
	 *
	 * @return mixed
	 */
	public function setMetaData( array $a2cData );

	/**
	 * GetTranslations
	 *
	 * @param array $a2cData Data
	 *
	 * @return mixed
	 */
	public function getTranslations( array $a2cData );

	/**
	 * SetOrderNotes
	 *
	 * @param array $a2cData Data
	 *
	 * @return mixed
	 */
	public function setOrderNotes( array $a2cData );

	/**
	 * GetActiveModules
	 *
	 * @param array $a2cData Data
	 *
	 * @return mixed
	 */
	public function getActiveModules( array $a2cData );

	/**
	 * GetImagesUrls
	 *
	 * @param array $a2cData Data
	 *
	 * @return mixed
	 */
	public function getImagesUrls( array $a2cData );

	/**
	 * OrderUpdate
	 *
	 * @param array $a2cData Data
	 *
	 * @return mixed
	 */
	public function orderUpdate( array $a2cData );

	/**
	 * Category Add
	 *
	 * @param array $data Data
	 *
	 * @return mixed
	 */
	public function categoryAdd( array $data );

	/**
	 * Category Update
	 *
	 * @param array $data Data
	 *
	 * @return mixed
	 */
	public function categoryUpdate( array $data );

	/**
	 * Category Update
	 *
	 * @param array $data Data
	 *
	 * @return mixed
	 */
	public function categoryDelete( array $data );

	/**
	 * Get Request
	 *
	 * @return null|WP_REST_Request
	 */
	public function getRequest();

	/**
	 * Set Request
	 *
	 * @param WP_REST_Request $request Request
	 */
	public function setRequest( WP_REST_Request $request );
}

abstract class DFW_DatabaseLink {

	protected static $_maxRetriesToConnect = 5;

	protected static $_sleepBetweenAttempts = 2;

	protected $_config = null;

	protected $_request = null;

	private $_databaseHandle = null;

	protected $_insertedId = 0;

	protected $_affectedRows = 0;


	/**
	 * Constructor
	 *
	 * @param DFW_Config_Adapter $config Config adapter
	 * @return DFW_DatabaseLink
	 */
	public function __construct( $config ) {
		$this->_config = $config;
		$this->_request = $config->getRequest();
	}

	/**
	 * Destructor
	 *
	 * @return void
	 */
	public function __destruct() {
		$this->_releaseHandle();
	}

	/**
	 * TryToConnect
	 *
	 * @return bool|resource|wpdb
	 */
	private function _tryToConnect() {
		$triesCount = self::$_maxRetriesToConnect;

		$link = null;

		while ( ! $link ) {
			if ( ! $triesCount -- ) {
				break;
			}

			$link = $this->_connect();
			if ( ! $link ) {
				sleep( self::$_sleepBetweenAttempts );
			}
		}

		if ( $link ) {
			$this->_afterConnect( $link );

			return $link;
		} else {
			return false;
		}
	}

	/**
	 * GetDatabaseHandle
	 * Database handle getter
	 *
	 * @return bool|resource|wpdb|null
	 */
	final protected function _getDatabaseHandle() {
		if ( $this->_databaseHandle ) {
			return $this->_databaseHandle;
		}

		$this->_databaseHandle = $this->_tryToConnect();

		if ( $this->_databaseHandle ) {
			return $this->_databaseHandle;
		} else {
			exit( esc_html( $this->_errorMsg( 'Can not connect to DB' ) ) );
		}
	}

	/**
	 * ReleaseHandle
	 * Close DB handle and set it to null; used in reconnect attempts
	 *
	 * @return void
	 */
	final protected function _releaseHandle() {
		if ( $this->_databaseHandle ) {
			$this->_closeHandle( $this->_databaseHandle );
		}

		$this->_databaseHandle = null;
	}

	/**
	 * ErrorMsg
	 * Format error message
	 *
	 * @param string $error Raw error message
	 * @return string
	 */
	final protected function _errorMsg( $error ) {
		$className = get_class( $this );

		return '[$className] MySQL Query Error: $error';
	}

	/**
	 * Query
	 *
	 * @param string  $sql       SQL query
	 * @param integer $fetchType Fetch type
	 * @param array   $extParams Extended params
	 * @return array
	 */
	final public function query( $sql, $fetchType, $extParams ) {
		if ( $extParams['set_names'] ) {
			$this->_dbSetNames( $extParams['set_names'] );
		}

		return $this->_query( $sql, $fetchType, $extParams['fetch_fields'] );
	}

	/**
	 * Connect
	 *
	 * @return boolean|null|resource
	 */
	abstract protected function _connect();

	/**
	 * Additional database handle manipulations - e.g. select DB
	 *
	 * @param stdClass $handle DB Handle
	 * @return void
	 */
	abstract protected function _afterConnect( $handle );

	/**
	 * Close DB handle
	 *
	 * @param stdClass $handle DB Handle
	 * @return void
	 */
	abstract protected function _closeHandle( $handle );

	/**
	 * LocalQuery
	 *
	 * @param string $sql sql query
	 * @return array
	 */
	abstract public function localQuery( $sql );

	/**
	 * Query
	 *
	 * @param string  $sql         Sql query
	 * @param integer $fetchType   Fetch Type
	 * @param boolean $fetchFields Fetch fields metadata
	 * @return array
	 */
	abstract protected function _query( $sql, $fetchType, $fetchFields = false );

	/**
	 * GetLastInsertId
	 *
	 * @return string|integer
	 */
	public function getLastInsertId() {
		return $this->_insertedId;
	}

	/**
	 * GetAffectedRows
	 *
	 * @return integer
	 */
	public function getAffectedRows() {
		return $this->_affectedRows;
	}

	/**
	 * DB SetNames
	 *
	 * @param string $charset Charset
	 * @return void
	 */
	abstract protected function _dbSetNames( $charset );

}

/**
 * Class DFW_Mysqli
 */
class DFW_Mysqli extends DFW_DatabaseLink {

	/**
	 * Connect
	 *
	 * @return bool|resource|wpdb|null
	 */
	protected function _connect() {
		global $wpdb;

		if ( ! $wpdb ) {
			require_wp_db();
		}

		if ( empty( $wpdb->dbh ) || empty( $wpdb->dbh->client_info ) ) {
			$wpdb->db_connect( false );
		}

		return $wpdb;
	}

	/**
	 * AfterConnect
	 *
	 * @param mysqli $handle DB Handle
	 * @return void
	 */
	protected function _afterConnect( $handle ) {
	}

	/**
	 * LocalQuery
	 *
	 * @inheritdoc
	 */
	public function localQuery( $sql ) {
		/**
		 * Handle
		 *
		 * @var wpdb $databaseHandle Handle
		 */
		$databaseHandle = $this->_getDatabaseHandle();

		$res = $databaseHandle->get_results( $databaseHandle->prepare($sql), ARRAY_A );

		if ( is_bool( $res ) ) {
			return $res;
		}

		return $res;
	}

	/**
	 * Query
	 *
	 * @inheritdoc
	 */
	protected function _query( $sql, $fetchType, $fetchFields = false ) {
		$result = array(
			'result'        => null,
			'message'       => '',
			'fetchedFields' => '',
		);

		$fetchMode = ARRAY_A;
		switch ( $fetchType ) {
			case 3:
				$fetchMode = OBJECT;
				break;
			case 2:
				$fetchMode = ARRAY_N;
				break;
			case 1:
				$fetchMode = ARRAY_A;
				break;
			default:
				break;
		}

		/**
		 * Handle
		 *
		 * @var wpdb $databaseHandle Handle
		 */
		$databaseHandle = $this->_getDatabaseHandle();

		$res = $databaseHandle->get_results( $databaseHandle->prepare($sql), $fetchMode );

		if ( '' != ( $databaseHandle->last_error ) ) {
			$result['message'] = $this->_errorMsg( $databaseHandle->last_error );

			return $result;
		}

		$this->_affectedRows = $databaseHandle->rows_affected;
		$this->_insertedId   = $databaseHandle->insert_id;

		if ( is_bool( $res ) ) {
			$result['result'] = $res;

			return $result;
		}

		if ( $fetchFields && $res ) {
			$columnInfo = $databaseHandle->__get('col_info');
			$fetchedFields = [];

			foreach ( $columnInfo as $field) {
				$fetchedFields[] = $field;
			}

			$result['fetchedFields'] = $fetchedFields;
		}

		$result['result'] = $res;

		return $result;
	}

	/**
	 * DB SetNames
	 *
	 * @inheritdoc
	 */
	protected function _dbSetNames( $charset ) {
		/**
		 * Handle
		 *
		 * @var wpdb $databaseHandle Handle
		 */
		$databaseHandle = $this->_getDatabaseHandle();

		$databaseHandle->set_charset( $databaseHandle->dbh, $charset );
	}

	/**
	 * CloseHandle
	 *
	 * @param wpdb $handle DB Handle
	 * @return void
	 */
	protected function _closeHandle( $handle ) {
		$handle->close();
	}

}

class DFW_Config_Adapter implements DFW_Platform_Actions {

	public $host                = 'localhost';

	public $port                = null;

	public $sock                = null;

	public $username            = 'root';

	public $password            = '';

	public $dbname              = '';

	public $tblPrefix           = '';

	public $timeZone            = null;

	public $cartType                 = 'Wordpress';

	public $cartId                   = '';

	public $imagesDir                = '';

	public $categoriesImagesDir      = '';

	public $productsImagesDir        = '';

	public $manufacturersImagesDir   = '';

	public $categoriesImagesDirs     = '';

	public $productsImagesDirs       = '';

	public $manufacturersImagesDirs  = '';

	public $languages   = array();

	public $cartVars    = array();

	public $request = null;


	/**
	 * Create
	 *
	 * @param WP_REST_Request $request Request
	 *
	 * @return mixed
	 */
	public function create( WP_REST_Request $request ) {
		$cartType  = $this->cartType;
		$className = 'DFW_Config_Adapter_' . $cartType;

		$obj           = new $className($request);
		$obj->cartType = $cartType;

		return $obj;
	}

	/**
	 * ProductUpdateAction
	 *
	 * @param array $a2cData Data
	 *
	 * @return mixed
	 */
	public function productUpdateAction( array $a2cData ) {
		return array( 'error' => 'Action is not supported', 'data' => false );
	}

	/**
	 * SendEmailNotifications
	 *
	 * @param array $a2cData Data
	 *
	 * @return mixed
	 */
	public function sendEmailNotifications( array $a2cData ) {
		return array( 'error' => 'Action is not supported', 'data' => false );
	}

	/**
	 * TriggerEvents
	 *
	 * @param array $a2cData Data
	 *
	 * @return mixed
	 */
	public function triggerEvents( array $a2cData ) {
		return array( 'error' => 'Action is not supported', 'data' => false );
	}

	/**
	 * GetPlugins
	 *
	 * @return mixed
	 */
	public function getPlugins() {
		return array( 'error' => 'Action is not supported', 'data' => false );
	}

	/**
	 * SetMetaData
	 *
	 * @inheritDoc
	 */
	public function setMetaData( array $a2cData ) {
		return array( 'error' => 'Action is not supported', 'data' => false );
	}

	/**
	 * GetTranslations
	 *
	 * @inheritDoc
	 */
	public function getTranslations( array $a2cData ) {
		return array( 'error' => 'Action is not supported', 'data' => false );
	}

	/**
	 * SetOrderNotes
	 *
	 * @inheritDoc
	 */
	public function setOrderNotes( array $a2cData ) {
		return array( 'error' => 'Action is not supported', 'data' => false );
	}

	/**
	 * GetActiveModules
	 *
	 * @inheritDoc
	 */
	public function getActiveModules( array $a2cData ) {
		return array( 'error' => 'Action is not supported', 'data' => false );
	}

	/**
	 * GetImagesUrls
	 *
	 * @inheritDoc
	 */
	public function getImagesUrls( array $a2cData ) {
		return array( 'error' => 'Action is not supported', 'data' => false );
	}

	/**
	 * OrderUpdate
	 *
	 * @param array $a2cData Data
	 *
	 * @inheritDoc
	 */
	public function orderUpdate( array $a2cData ) {
		return array( 'error' => 'Action is not supported', 'data' => false );
	}

	/**
	 * Category Add
	 *
	 * @param array $data Data
	 *
	 * @return mixed
	 */
	public function categoryAdd( array $data ) {
		return array( 'error' => 'Action is not supported', 'data' => false );
	}

	/**
	 * Category Update
	 *
	 * @param array $data Data
	 *
	 * @return mixed
	 */
	public function categoryUpdate( array $data ) {
		return array( 'error' => 'Action is not supported', 'data' => false );
	}

	/**
	 * Category Delete
	 *
	 * @param array $data Data
	 *
	 * @return mixed
	 */
	public function categoryDelete( array $data ) {
		return array( 'error' => 'Action is not supported', 'data' => false );
	}

	/**
	 * Get Card ID string from request parameters
	 *
	 * @return string
	 */
	protected function _getRequestCartId() {
		$request = $this->getRequest();
		$parameters = $request->get_params();

		return isset( $parameters['cart_id'] ) ? sanitize_text_field( $parameters['cart_id'] ) : '';
	}

	/**
	 * GetAdapterPath
	 *
	 * @param string $cartType
	 * @return string
	 */
	public function getAdapterPath( $cartType ) {
		return DFWBC_STORE_BASE_DIR . DFWBC_BRIDGE_DIRECTORY_NAME . DIRECTORY_SEPARATOR . 'app' .
			DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'config_adapter' . DIRECTORY_SEPARATOR . $cartType . '.php';
	}

	/**
	 * SetHostPort
	 *
	 * @param $source
	 */
	public function setHostPort( $source ) {
		$source = trim( $source );

		if ( '' == $source ) {
			$this->host = 'localhost';

			return;
		}

		if ( false !== strpos( $source, '.sock' ) ) {
			$socket = ltrim( $source, 'localhost:' );
			$socket = ltrim( $socket, '127.0.0.1:' );

			$this->host = 'localhost';
			$this->sock = $socket;

			return;
		}

		$conf = explode( ':', $source );

		if ( isset( $conf[0] ) && isset( $conf[1] ) ) {
			$this->host = $conf[0];
			$this->port = $conf[1];
		} elseif ( '/' == $source[0] ) {
			$this->host = 'localhost';
			$this->port = $source;
		} else {
			$this->host = $source;
		}
	}

	/**
	 * Connect
	 *
	 * @return false|DFW_Mysqli
	 */
	public function connect() {
		return new DFW_Mysqli( $this );
	}

	/**
	 * GetCartVersionFromDb
	 *
	 * @param string $field     Field
	 * @param string $tableName Table name
	 * @param string $where     Where
	 *
	 * @return string
	 */
	public function getCartVersionFromDb( $field, $tableName, $where ) {
		global $wpdb;

		$version      = '';
		$globalTables = [ 'users', 'usermeta', 'blogs', 'blogmeta', 'signups', 'site', 'sitemeta', 'sitecategories', 'registration_log' ];

		if ( in_array( $tableName, $globalTables ) ) {
			$tblPrefix = isset( $wpdb->base_prefix ) ? $wpdb->base_prefix : $this->tblPrefix;
		} else {
			$tblPrefix = $this->tblPrefix;
		}

		$link = $this->connect();

		if ( ! $link ) {
			return '[ERROR] MySQL Query Error: Can not connect to DB';
		}

		$result = $link->localQuery( '
			SELECT ' . $field . ' AS version
			FROM ' . $tblPrefix . $tableName . '
			WHERE ' . $where );

		if ( is_array( $result ) && isset( $result[0]['version'] ) ) {
			$version = $result[0]['version'];
		}

		return $version;
	}

	/**
	 * Get Request
	 *
	 * @return null|WP_REST_Request
	 */
	public function getRequest() {
		return $this->request;
	}

	/**
	 * Set Request
	 *
	 * @param WP_REST_Request $request Request
	 */
	public function setRequest( WP_REST_Request $request ) {
		$this->request = $request;
	}
}

class DFW_Bridge {

	/**
	 * DFW_DatabaseLink
	 *
	 * @var DFW_DatabaseLink|null
	 */
	protected $_link  = null; //mysql connection link

	public $config    = null; //config adapter

	/**
	 * Request
	 *
	 * @var WP_REST_Request $request Request
	 */
	public $request;

	/**
	 * Bridge constructor
	 *
	 * DFW_Bridge constructor.
	 *
	 * @param DFW_Config_Adapter $config  Config
	 * @param WP_REST_Request    $request Request
	 */
	public function __construct( DFW_Config_Adapter $config, WP_REST_Request $request ) {
		$this->config  = $config;
		$this->request = $request;

		if ( $this->getAction() != 'savefile' ) {
			$this->_link = $this->config->connect();
		}
	}

	/**
	 * GetTablesPrefix
	 *
	 * @return mixed
	 */
	public function getTablesPrefix() {
		return $this->config->tblPrefix;
	}

	/**
	 * Get Request
	 *
	 * @return WP_REST_Request
	 */
	public function getRequest() {
		return $this->request;
	}

	/**
	 * GetLink
	 *
	 * @return DFW_DatabaseLink|null
	 */
	public function getLink() {
		return $this->_link;
	}

	/**
	 * GetAction
	 *
	 * @return mixed|string
	 */
	private function getAction() {
		$action = $this->request->get_param( 'action' );

		if ( null !== $action ) {
			return str_replace( '.', '', sanitize_text_field( $action ) );
		}

		return '';
	}

	/**
	 * Run
	 *
	 * @return mixed|string
	 */
	public function run() {
		$action = $this->getAction();
		$request = $this->getRequest();
		$parameters = $request->get_params();
		$postParameters = $request->get_body_params();

		if ( 'checkbridge' == $action ) {
			if ( DFWBC_BRIDGE_ENABLE_ENCRYPTION ) {
				return ['message' => 'BRIDGE_OK', 'key_id' => DFWBC_BRIDGE_PUBLIC_KEY_ID, 'bridge_version' => DFWBC_BRIDGE_VERSION];
			} else {
				return 'BRIDGE_OK';
			}
		}

		if ( isset( $parameters['token'] ) ) {
			return 'ERROR: Field token is not correct';
		}

		if ( empty( $postParameters ) ) {
			return 'BRIDGE INSTALLED.<br /> Version: ' . DFWBC_BRIDGE_VERSION;
		}

		if ( 'update' == $action ) {
			$this->_checkPossibilityUpdate();
		}

		$className = 'DFW_Bridge_Action_' . ucfirst( $action );
		if ( ! class_exists( $className ) ) {
			return 'ACTION_DO_NOT EXIST' . PHP_EOL;
		}

		$actionObj = new $className();
		@$actionObj->cartType = @$this->config->cartType;
		$res = $actionObj->Perform( $this );
		$this->_destroy();

		return $res;
	}

	/**
	 * Destroy
	 */
	private function _destroy() {
		$this->_link = null;
	}

	/**
	 * CheckPossibilityUpdate
	 *
	 * @return string
	 */
	private function _checkPossibilityUpdate() {
		if ( ! is_writable( __DIR__ ) ) {
			return 'ERROR_BRIDGE_DIR_IS_NOT_WRITABLE';
		}

		if ( ! is_writable( __FILE__ ) ) {
			return 'ERROR_BRIDGE_IS_NOT_WRITABLE';
		}
	}

	/**
	 * Remove php comments from string
	 *
	 * @param string $str String
	 */
	public static function removeComments( $str ) {
		$result        = '';
		$commentTokens = array( T_COMMENT, T_DOC_COMMENT );
		$tokens        = token_get_all( $str );

		foreach ( $tokens as $token ) {
			if ( is_array( $token ) ) {
				if ( in_array( $token[0], $commentTokens ) ) {
					continue;
				}

				$token = $token[1];
			}

			$result .= $token;
		}

		return $result;
	}

	/**
	 * ParseDefinedConstants
	 *
	 * @param sting   $str        String
	 * @param string  $constNames Const Names
	 * @param boolean $onlyString Only String
	 *
	 * @return array
	 */
	public static function parseDefinedConstants( $str, $constNames = '\w+', $onlyString = true ) {
		$res     = array();
		$pattern = '/define\s*\(\s*[\'"](' . $constNames . ')[\'"]\s*,\s*' . ( $onlyString ? '[\'"]' : '' ) . '(.*?)' . ( $onlyString ? '[\'"]' : '' ) . '\s*\)\s*;/';

		preg_match_all( $pattern, $str, $matches );

		if ( isset( $matches[1] ) && isset( $matches[2] ) ) {
			foreach ( $matches[1] as $key => $constName ) {
				$res[ $constName ] = $matches[2][ $key ];
			}
		}

		return $res;
	}
}

/**
 * Class DFW_Config_Adapter_Wordpress
 */
class DFW_Config_Adapter_Wordpress extends DFW_Config_Adapter {

	const ERROR_CODE_SUCCESS = 0;
	const ERROR_CODE_ENTITY_NOT_FOUND = 1;
	const ERROR_CODE_INTERNAL_ERROR = 2;

	private $_multiSiteEnabled = false;

	private $_pluginName = '';

	/**
	 * DFW_Config_Adapter_Wordpress constructor.
	 */
	public function __construct( WP_REST_Request $request ) {
		$this->request = $request;
		$this->_tryLoadConfigs();

		$getActivePlugin = function ( array $cartPlugins ) {
			foreach ( $cartPlugins as $plugin ) {
				$cartId = $this->_getRequestCartId();

				if ( $cartId ) {
					if ( 'Woocommerce' == $cartId && false !== strpos( $plugin, 'woocommerce.php' ) ) {
						return 'woocommerce';
					} elseif ( 'WPecommerce' == $cartId && ( 0 === strpos( $plugin, 'wp-e-commerce' ) || 0 === strpos( $plugin, 'wp-ecommerce' ) ) ) {
						return 'wp-e-commerce';
					}
				} else {
					if ( strpos( $plugin, 'woocommerce.php' ) !== false ) {
						return 'woocommerce';
					} elseif ( strpos( $plugin, 'wp-e-commerce' ) === 0 || strpos( $plugin, 'wp-ecommerce' ) === 0 ) {
						return 'wp-e-commerce';
					}
				}
			};

			return false;
		};

		$activePlugin = false;
		$wpTblPrefix  = $this->tblPrefix;

		if ( $this->_multiSiteEnabled ) {
			$cartPluginsNetwork = $this->getCartVersionFromDb( 'meta_value',
				'sitemeta',
				'meta_key = \'active_sitewide_plugins\'' );

			if ( $cartPluginsNetwork ) {
				$cartPluginsNetwork = unserialize( $cartPluginsNetwork );
				$activePlugin       = $getActivePlugin( array_keys( $cartPluginsNetwork ) );
			}

			if ( false ===$activePlugin ) {
				$link = $this->connect();

				if ( $link ) {
					$blogs = $link->localQuery( 'SELECT blog_id FROM ' . $this->tblPrefix . 'blogs' );
					if ( $blogs ) {
						foreach ( $blogs as $blog ) {
							if ( $blog['blog_id'] > 1 ) {
								$this->tblPrefix = $this->tblPrefix . $blog['blog_id'] . '_';
							}

							$cartPlugins = $this->getCartVersionFromDb( 'option_value', 'options', 'option_name = \'active_plugins\'' );
							if ( $cartPlugins ) {
								$activePlugin = $getActivePlugin( unserialize( $cartPlugins ) );
							}

							if ( $activePlugin ) {
								break;
							} else {
								$this->tblPrefix = $wpTblPrefix;
							}
						}
					}
				} else {
					return '[ERROR] MySQL Query Error: Can not connect to DB';
				}
			}
		} else {
			$cartPlugins = $this->getCartVersionFromDb( 'option_value', 'options', 'option_name = \'active_plugins\'' );
			if ( $cartPlugins ) {
				$activePlugin = $getActivePlugin( unserialize( $cartPlugins ) );
			}
		}

		if ( 'woocommerce' == $activePlugin ) {
			$this->_setWoocommerceData();
		} elseif ( 'wp-e-commerce' == $activePlugin ) {
			$this->_setWpecommerceData();
		} else {
			return 'CART_PLUGIN_IS_NOT_DETECTED';
		}

		$this->_pluginName = $activePlugin;
		$this->tblPrefix   = $wpTblPrefix;

		if (isset($_POST['aelia_cs_currency'])) {
			unset($_POST['aelia_cs_currency']);
		}
	}

	/**
	 * SetWoocommerceData
	 */
	protected function _setWoocommerceData() {
		$this->cartId = 'Woocommerce';
		$version      = $this->getCartVersionFromDb( 'option_value', 'options', 'option_name = \'woocommerce_db_version\'' );

		if ( '' != $version ) {
			$this->cartVars['dbVersion'] = $version;
		}

		$this->cartVars['categoriesDirRelative'] = 'images/categories/';
		$this->cartVars['productsDirRelative']   = 'images/products/';
	}

	/**
	 * ResetGlobalVars
	 *
	 * @return void
	 */
	private function _resetGlobalVars() {
		foreach ( $GLOBALS as $varname => $value ) {
			global $$varname; //$$ is no mistake here

			$$varname = $value;
		}
	}

	/**
	 * SetWpecommerceData
	 */
	protected function _setWpecommerceData() {
		$this->cartId = 'Wpecommerce';
		$version      = $this->getCartVersionFromDb( 'option_value', 'options', 'option_name = \'wpsc_version\'' );
		if ( '' != $version ) {
			$this->cartVars['dbVersion'] = $version;
		} else {
			$filePath = DFWBC_STORE_BASE_DIR . 'wp-content' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'wp-shopping-cart' . DIRECTORY_SEPARATOR . 'wp-shopping-cart.php';
			if ( file_exists( $filePath ) ) {
				$conf = file_get_contents( $filePath );
				preg_match("/define\('WPSC_VERSION.*/", $conf, $match);
				if ( isset( $match[0] ) && ! empty( $match[0] ) ) {
					preg_match('/\d.*/', $match[0], $project);
					if ( isset( $project[0] ) && ! empty( $project[0] ) ) {
						$version = $project[0];
						$version = str_replace( array( ' ', '-', '_', '\'', ');', ')', ';' ), '', $version );
						if ( '' != $version ) {
							$this->cartVars['dbVersion'] = strtolower( $version );
						}
					}
				}
			}
		}

		if ( file_exists( DFWBC_STORE_BASE_DIR . 'wp-content' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'shopp' . DIRECTORY_SEPARATOR . 'Shopp.php' )
		|| file_exists( DFWBC_STORE_BASE_DIR . 'wp-content' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'wp-e-commerce' . DIRECTORY_SEPARATOR . 'editor.php' ) ) {
			$this->imagesDir              = 'wp-content' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'wpsc' . DIRECTORY_SEPARATOR;
			$this->categoriesImagesDir    = $this->imagesDir . 'category_images' . DIRECTORY_SEPARATOR;
			$this->productsImagesDir      = $this->imagesDir . 'product_images' . DIRECTORY_SEPARATOR;
			$this->manufacturersImagesDir = $this->imagesDir;
		} elseif ( file_exists( DFWBC_STORE_BASE_DIR . 'wp-content' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'wp-e-commerce' . DIRECTORY_SEPARATOR . 'wp-shopping-cart.php' ) ) {
			$this->imagesDir              = 'wp-content' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . '';
			$this->categoriesImagesDir    = $this->imagesDir . 'wpsc' . DIRECTORY_SEPARATOR . 'category_images' . DIRECTORY_SEPARATOR;
			$this->productsImagesDir      = $this->imagesDir;
			$this->manufacturersImagesDir = $this->imagesDir;
		} else {
			$this->imagesDir              = 'images' . DIRECTORY_SEPARATOR;
			$this->categoriesImagesDir    = $this->imagesDir;
			$this->productsImagesDir      = $this->imagesDir;
			$this->manufacturersImagesDir = $this->imagesDir;
		}
	}

	/**
	 * TryLoadConfigs
	 *
	 * @return boolean
	 */
	protected function _tryLoadConfigs() {
		global $wpdb;

		try {
			if ( defined( 'DB_NAME' ) && defined( 'DB_USER' ) && defined( 'DB_HOST' ) ) {
				$this->dbname   = DB_NAME;
				$this->username = DB_USER;
				$this->setHostPort( DB_HOST );
			} else {
				return false;
			}

			if ( defined( 'DB_PASSWORD' ) ) {
				$this->password = DB_PASSWORD;
			} elseif ( defined( 'DB_PASS' ) ) {
				$this->password = DB_PASS;
			} else {
				return false;
			}

			if ( defined( 'WP_CONTENT_DIR' ) ) {
				$this->imagesDir = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'uploads';
			} elseif ( defined( 'UPLOADS' ) ) {
				$this->imagesDir = UPLOADS;
			} else {
				$this->imagesDir = ABSPATH . DIRECTORY_SEPARATOR . 'wp-content' . DIRECTORY_SEPARATOR . 'uploads';
			}

			$this->_multiSiteEnabled = ( defined( 'MULTISITE' ) && MULTISITE === true );

			if ( $this->_multiSiteEnabled ) {
				if ( defined( 'WP_SITEURL' ) ) {
					$this->cartVars['wp_siteurl'] = WP_SITEURL;
				}

				if ( defined( 'WP_HOME' ) ) {
					$this->cartVars['wp_home'] = WP_HOME;
				}

				if ( defined( 'WP_CONTENT_URL' ) ) {
					$this->cartVars['wp_content_url'] = WP_CONTENT_URL;
				}
			} elseif ( defined( 'WP_CONTENT_URL' ) ) {
				$this->cartVars['wp_content_url'] = WP_CONTENT_URL;
			}

			if ( isset( $table_prefix ) ) {
				$this->tblPrefix = $table_prefix;
			} elseif ( isset( $wpdb->base_prefix ) ) {
				$this->tblPrefix = $wpdb->base_prefix;
			} elseif ( isset( $GLOBALS['table_prefix'] ) ) {
				$this->tblPrefix = $GLOBALS['table_prefix'];
			}
		} catch ( Exception $e ) {
			die( 'ERROR_READING_STORE_CONFIG_FILE' );
		}

		foreach ( get_defined_vars() as $key => $val ) {
			$GLOBALS[ $key ] = $val;
		}

		return true;
	}

	/**
	 * SendEmailNotifications
	 *
	 * @param array $a2cData Notifications data
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function sendEmailNotifications( array $a2cData ) {
		if ( 'woocommerce' === $this->_pluginName ) {
			return $this->_wcEmailNotification( $a2cData );
		} else {
			throw new Exception( 'Action is not supported' );
		}
	}

	/**
	 * WcEmailNotification
	 *
	 * @param array $a2cData Notifications data
	 *
	 * @return boolean
	 */
	private function _wcEmailNotification( array $a2cData ) {
		if ( function_exists( 'switch_to_blog' ) ) {
			switch_to_blog( $a2cData['store_id'] );
		}

		$emails = WC()->mailer()->get_emails();//init mailer

		foreach ( $a2cData['notifications'] as $notification ) {
			if ( isset( $notification['wc_class'] ) ) {
				if ( isset( $emails[ $notification['wc_class'] ] ) ) {
					call_user_func_array( array( $emails[ $notification['wc_class'] ], 'trigger' ), $notification['data'] );
				} else {
					return false;
				}
			} else {
				do_action( $notification['wc_action'], $notification['data'] );
			}
		}

		return true;
	}

	/**
	 * TriggerEvents
	 *
	 * @inheritDoc
	 * @return boolean
	 */
	public function triggerEvents( array $a2cData ) {
		if ( function_exists( 'switch_to_blog' ) ) {
			switch_to_blog( $a2cData['store_id'] );
		}

		foreach ( $a2cData['events'] as $event ) {
			if ( 'update' === $event['event'] ) {
				switch ( $event['entity_type'] ) {
					case 'product':
						$product = WC()->product_factory->get_product( $event['entity_id'] );
						if ( in_array( 'stock_status', $event['updated_meta'], true ) ) {
							do_action( 'woocommerce_product_set_stock_status', $product->get_id(), $product->get_stock_status(), $product );
						}

						if ( in_array( 'stock_quantity', $event['updated_meta'], true ) ) {
							do_action( 'woocommerce_product_set_stock', $product );
						}

						do_action( 'woocommerce_product_object_updated_props', $product, $event['updated_meta'] );
						break;
					case 'variant':
						$product = WC()->product_factory->get_product( $event['entity_id'] );
						if ( in_array( 'stock_status', $event['updated_meta'], true ) ) {
							do_action( 'woocommerce_variation_set_stock_status', $event['entity_id'], $product->get_stock_status(), $product );
						}

						if ( in_array( 'stock_quantity', $event['updated_meta'], true ) ) {
							do_action( 'woocommerce_variation_set_stock', $product );
						}

						do_action( 'woocommerce_product_object_updated_props', $product, $event['updated_meta'] );
						break;
					case 'order':
						$entity = WC()->order_factory->get_order( $event['entity_id'] );
						do_action( 'woocommerce_order_status_' . $event['status']['to'], $entity->get_id(), $entity );

						if ( isset( $event['status']['from'] ) ) {
							do_action( 'woocommerce_order_status_' . $event['status']['from'] . '_to_' . $event['status']['to'], $entity->get_id(), $entity );
							do_action( 'woocommerce_order_status_changed', $entity->get_id(), $event['status']['from'], $event['status']['to'], $entity );
						}
						break;
					case 'shipment':
						$entity = WC()->order_factory->get_order( $event['entity_id'] );
						$data = unserialize( $a2cData['metaData'], ['allowed_classes' => ['stdClass']] );

						if ( empty($data) ) {
							$entity->delete_meta_data( '_wc_shipment_tracking_items' );
						} else {
							$entity->update_meta_data( '_wc_shipment_tracking_items', $data );
						}

						$entity->save_meta_data();
						do_action( 'update_order_status_after_adding_tracking', $event['status'], $entity );
				}
			} elseif ( 'delete' === $event['event'] ) {
				switch ( $event['entity_type'] ) {
					case 'shipment':
						$entity = WC()->order_factory->get_order( $event['entity_id'] );

						foreach ( $event['tracking_info'] as $trackingInfo ) {
							$trackingProvider = $trackingInfo['tracking_provider'];
							$trackingNumber   = $trackingInfo['tracking_number'];

							// translators: %1$s is the tracking provider, %2$s is the tracking number
							$note = sprintf( __( 'Tracking info was deleted for tracking provider %1$s with tracking number %2$s',
								'woo-advanced-shipment-tracking' ),
								$trackingProvider,
								$trackingNumber );
							// Add the note
							$entity->add_order_note( $note );
						}
				}
			}
		}

		return true;
	}

	/**
	 * SetMetaData
	 *
	 * @inheritDoc
	 * @return array
	 */
	public function setMetaData( array $a2cData ) {
		$response = [
			'error_code' => self::ERROR_CODE_SUCCESS,
			'error'      => null,
			'result'     => array(),
		];

		$reportError = function ( $e ) use ( $response ) {
			$response['error']      = $e->getMessage();
			$response['error_code'] = self::ERROR_CODE_INTERNAL_ERROR;

			return $response;
		};

		try {
			if ( function_exists( 'switch_to_blog' ) ) {
				switch_to_blog( $a2cData['store_id'] );
			}

			$id = (int) $a2cData['entity_id'];

			switch ( $a2cData['entity'] ) {
				case 'variant':
				case 'product':
					$entity = WC()->product_factory->get_product( $id );
					break;
				case 'order':
					$entity = WC()->order_factory->get_order( $id );
					break;
				case 'category':
					$entity = get_term( $id, 'product_cat' );
					break;
				case 'customer':
					$entity = new WC_Customer( $id );
					break;
			}

			if ( ! $entity ) {
				$response['error_code'] = self::ERROR_CODE_ENTITY_NOT_FOUND;
				$response['error']      = $a2cData['entity'];
			} elseif ( 'category' != $a2cData['entity'] ) {
				if ( isset( $a2cData['meta'] ) ) {
					foreach ( $a2cData['meta'] as $key => $value ) {
						$entity->add_meta_data( $key, $value, true );
					}
				}

				if ( isset( $a2cData['unset_meta'] ) ) {
					foreach ( $a2cData['unset_meta'] as $key ) {
						$entity->delete_meta_data( $key );
					}
				}

				if ( isset( $a2cData['meta'] ) || isset( $a2cData['unset_meta'] ) ) {
					$entity->save();

					if ( isset( $a2cData['meta'] ) ) {
						global $wpdb;
						$wpdb->set_blog_id( $a2cData['store_id'] );
						$keys = implode( '\', \'', $wpdb->_escape( array_keys( $a2cData['meta'] ) ) );

						switch ( $a2cData['entity'] ) {
							case 'product':
							case 'order':
								$qRes = $wpdb->get_results(
									$wpdb->prepare('
										SELECT pm.meta_id, pm.meta_key, pm.meta_value
										FROM ' . $wpdb->postmeta . ' AS pm
										WHERE pm.post_id = %d
										AND pm.meta_key IN (\'%s\')',
										$id,
										$keys
									)
								);
								break;

							case 'customer':
								$qRes = $wpdb->get_results(
									$wpdb->prepare( '
										SELECT um.umeta_id AS \'meta_id\', um.meta_key, um.meta_value
										FROM ' . $wpdb->usermeta . ' AS um
										WHERE um.user_id = %d
										AND um.meta_key IN (\'%s\')',
										$id,
										$keys
									)
								);

								break;
						}

						$response['result']['meta'] = $qRes;
					}

					if ( isset( $a2cData['unset_meta'] ) ) {
						foreach ( $a2cData['unset_meta'] as $key ) {
							$response['result']['removed_meta'][ $key ] = ! (bool) $entity->get_meta( $key );
						}
					}
				}
			} else {
				if ( isset( $a2cData['meta'] ) ) {
					global $wpdb;

					foreach ( $a2cData['meta'] as $key => $value ) {
						add_term_meta( $id, $key, $value );
					}

					$wpdb->set_blog_id( $a2cData['store_id'] );
					$keys = implode( '\', \'', $wpdb->_escape( array_keys( $a2cData['meta'] ) ) );

					$qRes = $wpdb->get_results(
						$wpdb->prepare( '
							SELECT tm.meta_id, tm.meta_key, tm.meta_value
							FROM ' . $wpdb->termmeta . ' AS tm
							WHERE tm.term_id = %d
							AND tm.meta_key IN (\'%s\')',
							$id,
							$keys
						)
					);

					$response['result']['meta'] = $qRes;
				}

				if ( isset( $a2cData['unset_meta'] ) ) {
					foreach ( $a2cData['unset_meta'] as $key ) {
						delete_term_meta( $id, $key );

						$response['result']['removed_meta'][ $key ] = ! (bool) get_term_meta( $id, $key );
					}
				}
			}
		} catch ( Exception $e ) {
			return $reportError( $e );
		} catch ( Throwable $e ) {
			return $reportError( $e );
		}

		return $response;
	}

	/**
	 * GetTranslations
	 *
	 * @inheritDoc
	 * @return array
	 */
	public function getTranslations( array $a2cData ) {
		$response = [
			'error_code' => self::ERROR_CODE_SUCCESS,
			'error'      => null,
			'result'     => array(),
		];

		$reportError = function ( $e ) use ( $response ) {
			$response['error']      = $e->getMessage();
			$response['error_code'] = self::ERROR_CODE_INTERNAL_ERROR;

			return $response;
		};

		try {
			if ( function_exists( 'switch_to_blog' ) ) {
				switch_to_blog( $a2cData['store_id'] );
			}

			foreach ( $a2cData['strings'] as $key => $stringData ) {
				$response['result'][ $key ] = call_user_func('__', $stringData['id'], $stringData['domain'] );
			}
		} catch ( Exception $e ) {
			return $reportError( $e );
		} catch ( Throwable $e ) {
			return $reportError( $e );
		}

		return $response;
	}

	/**
	 * SetOrderNotes
	 *
	 * @inheritDoc
	 * @return array
	 */
	public function setOrderNotes( array $a2cData ) {
		$response = array(
			'error_code' => self::ERROR_CODE_SUCCESS,
			'error'      => null,
			'result'     => array(),
		);

		$reportError = function ( $e ) use ( $response ) {
			$response['error']      = $e->getMessage();
			$response['error_code'] = self::ERROR_CODE_INTERNAL_ERROR;

			return $response;
		};

		$getAdminId = function () {
			global $wpdb;

			$wpUserSearch = $wpdb->get_results( 'SELECT ID FROM ' . $wpdb->users . ' ORDER BY ID' );
			$adminId      = false;

			foreach ( $wpUserSearch as $userId ) {
				$currentUser = get_userdata( $userId->ID );

				if ( ! empty( $currentUser->user_level ) && $currentUser->user_level >= 8 ) {//levels 8, 9 and 10 are admin
					$adminId = $userId->ID;
					break;
				}
			}

			return $adminId;
		};

		try {
			if ( function_exists( 'switch_to_blog' ) ) {
				switch_to_blog( $a2cData['store_id'] );
			}

			$order = WC()->order_factory->get_order( (int) $a2cData['order_id'] );

			if ( ! $order ) {
				$response['error_code'] = self::ERROR_CODE_ENTITY_NOT_FOUND;
				$response['error']      = 'Entity not found';
			} else {
				if ( empty( $a2cData['from'] ) ) {
					/* translators: %s: new order status */
					$transition_note = sprintf( __( 'Order status set to %s.', 'woocommerce' ), wc_get_order_status_name( $a2cData['to'] ) );

					if ( empty( $a2cData['added_by_user'] ) ) {
						$order->add_order_note( $transition_note );
					} else {
						$adminId = $getAdminId();

						if ( $adminId ) {
							wp_set_current_user( $adminId );
						}

						$order->add_order_note( $transition_note, 0, true );
					}
				} else {
					/* translators: 1: old order status 2: new order status */
					$transition_note = sprintf( __( 'Order status changed from %1$s to %2$s.', 'woocommerce' ),
						wc_get_order_status_name( $a2cData['from'] ),
						wc_get_order_status_name( $a2cData['to'] ) );

					if ( empty( $a2cData['added_by_user'] ) ) {
						$order->add_order_note( $transition_note );
					} else {
						$adminId = $getAdminId();

						if ( $adminId ) {
							wp_set_current_user( $adminId );
						}

						$order->add_order_note( $transition_note, 0, true );
					}
				}
			}
		} catch ( Exception $e ) {
			return $reportError( $e );
		} catch ( Throwable $e ) {
			return $reportError( $e );
		}

		return $response;
	}

	/**
	 * GetImagesUrls
	 *
	 * @param array $a2cData
	 *
	 * @return array
	 */
	public function getImagesUrls( array $a2cData ) {
		$response = array(
			'error_code' => self::ERROR_CODE_SUCCESS,
			'error'      => null,
			'result'     => array(),
		);

		$reportError = function ( $e ) use ( $response ) {
			$response['error']      = $e->getMessage();
			$response['error_code'] = self::ERROR_CODE_INTERNAL_ERROR;

			return $response;
		};

		try {
			foreach ( $a2cData as $imagesCollection ) {
				if ( function_exists( 'switch_to_blog' ) ) {
					switch_to_blog( $imagesCollection['store_id'] );
				}

				$images = array();
				foreach ( $imagesCollection['ids'] as $id ) {
					$images[ $id ] = wp_get_attachment_url( $id );
				}

				$response['result'][ $imagesCollection['store_id'] ] = array( 'images' => $images );
			}
		} catch ( Exception $e ) {
			return $reportError( $e );
		} catch ( Throwable $e ) {
			return $reportError( $e );
		}

		return $response;
	}

	/**
	 * GetPlugins
	 *
	 * @return array
	 */
	public function getPlugins() {
		$response = array(
			'error_code' => self::ERROR_CODE_SUCCESS,
			'error'      => null,
			'result'     => array(),
		);

		$reportError = function ( $e ) use ( $response ) {
			$response['error']      = $e->getMessage();
			$response['error_code'] = self::ERROR_CODE_INTERNAL_ERROR;

			return $response;
		};

		try {
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
				$response['result']['plugins'] = get_plugins();
			} else {
				$response['result']['plugins'] = get_plugins();
			}
		} catch ( Exception $e ) {
			return $reportError( $e );
		} catch ( Throwable $e ) {
			return $reportError( $e );
		}

		return $response;
	}

	/**
	 * OrderUpdate
	 *
	 * @param array $a2cData Data
	 *
	 * @return array
	 */
	public function orderUpdate( array $a2cData ) {
		$response = array(
			'error_code' => self::ERROR_CODE_SUCCESS,
			'error'      => null,
			'result'     => array(),
		);

		$reportError = function ( $e ) use ( $response ) {
			$response['error']      = $e->getMessage();
			$response['error_code'] = self::ERROR_CODE_INTERNAL_ERROR;

			return $response;
		};

		try {
			foreach ( get_defined_vars() as $key => $val ) {
				$GLOBALS[ $key ] = $val;
			}

			$this->_resetGlobalVars();

			if ( function_exists( 'switch_to_blog' ) ) {
				switch_to_blog( $a2cData['order']['store_id'] );
			}

			$entity = WC()->order_factory->get_order( $a2cData['order']['id'] );

			if ( isset( $a2cData['order']['notify_customer'] ) && false === $a2cData['order']['notify_customer'] ) {
				$disableEmails = function () {
					return false;
				};

				add_filter( 'woocommerce_email_enabled_customer_completed_order', $disableEmails, 100, 0 );
				add_filter( 'woocommerce_email_enabled_customer_invoice', $disableEmails, 100, 0 );
				add_filter( 'woocommerce_email_enabled_customer_note', $disableEmails, 100, 0 );
				add_filter( 'woocommerce_email_enabled_customer_on_hold_order', $disableEmails, 100, 0 );
				add_filter( 'woocommerce_email_enabled_customer_processing_order', $disableEmails, 100, 0 );
				add_filter( 'woocommerce_email_enabled_customer_refunded_order', $disableEmails, 100, 0 );
			}

			if ( isset( $a2cData['order']['status']['id'] ) ) {
				$entity->set_status( $a2cData['order']['status']['id'],
					isset( $a2cData['order']['status']['transition_note'] ) ? $a2cData['order']['status']['transition_note'] : '',
					true );
			}

			if ( isset( $a2cData['order']['completed_date'] ) ) {
				$entity->set_date_completed( $a2cData['order']['completed_date'] );
			}

			if ( isset( $a2cData['order']['admin_comment'] ) ) {
				wp_set_current_user( $a2cData['order']['admin_comment']['admin_user_id'] );
				$entity->add_order_note( $a2cData['order']['admin_comment']['text'], 1 );
			}

			if ( isset( $a2cData['order']['customer_note'] ) ) {
				$entity->set_customer_note( $a2cData['order']['customer_note'] );
			}

			if ( isset( $a2cData['order']['admin_private_comment'] ) ) {
				wp_set_current_user( $a2cData['order']['admin_private_comment']['admin_user_id'] );
				$entity->add_order_note( $a2cData['order']['admin_private_comment']['text'], 0, true );
			}

			$entity->save();

			$response['result'] = true;
		} catch ( Exception $e ) {
			return $reportError( $e );
		} catch ( Throwable $e ) {
			return $reportError( $e );
		}

		return $response;
	}

	/**
	 * Category Add
	 *
	 * @param array $a2cData Data
	 *
	 * @return array
	 */
	public function categoryAdd( array $a2cData ) {
		$response = array(
			'error_code' => self::ERROR_CODE_SUCCESS,
			'error'      => null,
			'result'     => array(),
		);

		$reportError = function ($e) use ($response) {
			$response['error'] = $e->getMessage();
			$response['error_code'] = self::ERROR_CODE_INTERNAL_ERROR;

			return $response;
		};

		try {
			$args = array_merge(
				$a2cData,
				[
					'action'                   => 'add-tag',
					'taxonomy'                 => 'product_cat',
					'post_type'                => 'product',
					'display_type'             => '',
					'product_cat_thumbnail_id' => '',
				]
			);
			$wpmlParams = ['icl_tax_product_cat_language', 'icl_trid', 'icl_translation_of'];
			$checkParams = array_intersect_key($args, array_flip($wpmlParams));

			if (empty($checkParams) || isset($_POST['skipValidate'])) {
				return wp_insert_term($args['tag-name'], 'product_cat', $args);
			}

			$postParams = array_merge($_POST, array_intersect_key($args, array_flip($wpmlParams)));
			$postParams['skipValidate'] = true;
			ksort($postParams, SORT_STRING);
			unset($postParams['a2c_sign']);
			$postParams['a2c_sign'] = hash_hmac('sha256', http_build_query($postParams), DFWBC_TOKEN);
			$url = ( isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

			// Add Post Params for WPML
			$res = wp_remote_post(
				$url,
				[
					'method'      => 'POST',
					'timeout'     => 60,
					'redirection' => 5,
					'httpversion' => '1.0',
					'blocking'    => true,
					'headers'     => [
						'Accept-Language:*',
						'User-Agent:' . sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] ),
					],
					'body'        => $postParams,
					'cookies'     => [],
				]
			);
			$data = json_decode($res['body'], true);

			if (is_string($data)) {
				$data = json_decode($data, true);
			}

			return $data['data'];
		} catch (Exception $e) {
			return $reportError($e);
		} catch (Throwable $e) {
			return $reportError($e);
		}
	}

	/**
	 * Category Update
	 *
	 * @param array $a2cData Data
	 *
	 * @return array
	 */
	public function categoryUpdate(array $a2cData) {
		$response = array(
			'error_code' => self::ERROR_CODE_SUCCESS,
			'error'      => null,
			'result'     => array(),
		);

		$reportError = function ($e) use ($response) {
			$response['error'] = $e->getMessage();
			$response['error_code'] = self::ERROR_CODE_INTERNAL_ERROR;

			return $response;
		};

		try {
			$args = array_merge(
				$a2cData,
				array(
					'action'   => 'editedtag',
					'taxonomy' => 'product_cat',
				)
			);

			if (isset($args['icl_tax_product_cat_language'])) {
				$sitepress = WPML\Container\make( '\SitePress' );
				$sitepress->switch_lang($args['icl_tax_product_cat_language']);
			}

			wp_update_term($args['tag_ID'], 'product_cat', $args);
			$response['result'] = true;
		} catch (Exception $e) {
			return $reportError($e);
		} catch (Throwable $e) {
			return $reportError($e);
		}

		return $response;
	}

	/**
	 * Category Delete
	 *
	 * @param array $a2cData Data
	 *
	 * @return array
	 */
	public function categoryDelete(array $a2cData) {
		$response = array(
			'error_code' => self::ERROR_CODE_SUCCESS,
			'error'      => null,
			'result'     => array(),
		);

		$reportError = function ($e) use ($response) {
			$response['error'] = $e->getMessage();
			$response['error_code'] = self::ERROR_CODE_INTERNAL_ERROR;

			return $response;
		};

		try {
			if (isset($a2cData['icl_tax_product_cat_language'])) {
				$sitepress = WPML\Container\make( '\SitePress' );
				$sitepress->switch_lang($a2cData['icl_tax_product_cat_language']);
			}

			wp_delete_term( $a2cData['entity_id'], 'product_cat' );
			$response['result'] = true;
		} catch (Exception $e) {
			return $reportError($e);
		} catch (Throwable $e) {
			return $reportError($e);
		}

		return $response;
	}

  /**
   * Send Return Emails
   *
   * @param array $a2cData Data
   *
   * @return array
   */
  public function sendReturnEmails(array $a2cData)
  {
    $response = array(
      'error_code' => self::ERROR_CODE_SUCCESS,
      'error' => null,
      'result' => array()
    );

    $reportError = function ($e) use ($response) {
      $response['error'] = $e->getMessage();
      $response['error_code'] = self::ERROR_CODE_INTERNAL_ERROR;

      return $response;
    };

    try {
      if (function_exists('switch_to_blog')) {
        switch_to_blog($a2cData['store_id']);
      }

      if ($a2cData['plugin'] === 'woocommerce-refund-and-exchange-lite') {
        if ($a2cData['is_comment']) {
          $customer_email = WC()->mailer()->emails['wps_rma_order_messages_email'];
          $customer_email->trigger($a2cData['data']['msg'], [], $a2cData['data']['to'], $a2cData['order_id']);
        } else {
          if (!$a2cData['is_update_method'] || $a2cData['return_status'] === 'pending') {
            do_action('wps_rma_refund_req_email', $a2cData['order_id']);
          }

          if ($a2cData['return_status'] === 'complete') {
            do_action('wps_rma_refund_req_accept_email', $a2cData['order_id']);
          } elseif ($a2cData['return_status'] === 'cancel') {
            do_action('wps_rma_refund_req_cancel_email', $a2cData['order_id']);
          }
        }
      }
    } catch (Exception $e) {
      return $reportError($e);
    } catch (Throwable $e) {
      return $reportError($e);
    }

    return $response;
  }

	/**
	 * Get Request
	 *
	 * @return null|WP_REST_Request
	 */
	public function getRequest() {
		return $this->request;
	}

	/**
	 * Set Request
	 *
	 * @param WP_REST_Request $request Request
	 */
	public function setRequest( WP_REST_Request $request ) {
		$this->request = $request;
	}
}

/**
 * Class DFW_Bridge_Action_Send_Notification
 */
class DFW_Bridge_Action_Send_Notification {

	/**
	 * Perform
	 *
	 * @param DFW_Bridge $bridge
	 */
	public function Perform( DFW_Bridge $bridge ) {
		$response = array(
			'error'   => false,
			'code'    => null,
			'message' => null,
		);

		$request = $bridge->getRequest();
		$parameters = $request->get_params();

		$cartId = sanitize_text_field( $parameters['cartId'] );

		try {
			switch ( $cartId ) {
				case 'Woocommerce':
					$msgClasses = sanitize_text_field( $parameters['data_notification']['msg_classes'] );
					$callParams = sanitize_text_field( $parameters['data_notification']['msg_params'] );
					$storeId    = sanitize_text_field( $parameters['data_notification']['store_id'] );
					if ( function_exists( 'switch_to_blog' ) ) {
						switch_to_blog( $storeId );
					}

					$emails = wc()->mailer()->get_emails();
					foreach ( $msgClasses as $msgClass ) {
						if ( isset( $emails[ $msgClass ] ) ) {
							call_user_func_array( array( $emails[ $msgClass ], 'trigger' ), $callParams[ $msgClass ] );
						}
					}

					return json_encode( $response );
			}
		} catch ( Exception $e ) {
			$response['error']   = true;
			$response['code']    = $e->getCode();
			$response['message'] = $e->getMessage();

			return json_encode( $response );
		}
	}

}

/**
 * Class DFW_Bridge_Action_Savefile
 */
class DFW_Bridge_Action_Savefile {

	protected $_imageType = null;

	protected $_mageLoaded = false;

	/**
	 * Perform
	 *
	 * @param $bridge
	 */
	public function Perform( DFW_Bridge $bridge ) {
		$request = $bridge->getRequest();
		$parameters = $request->get_params();

		$source      = esc_url_raw( $parameters['src'] );
		$destination = sanitize_text_field( $parameters['dst'] );
		$width       = (int) sanitize_key( $parameters['width'] );
		$height      = (int) sanitize_key( $parameters['height'] );

		return $this->_saveFile( $source, $destination, $width, $height );
	}

	/**
	 * SaveFile
	 *
	 * @param $source
	 * @param $destination
	 * @param $width
	 * @param $height
	 * @param $local
	 * @return string
	 */
	public function _saveFile( $source, $destination, $width, $height ) {
		$extensions = [
			'3g2',
			'3gp',
			'7z',
			'aac',
			'accdb',
			'accde',
			'accdr',
			'accdt',
			'ace',
			'adt',
			'adts',
			'afa',
			'aif',
			'aifc',
			'aiff',
			'alz',
			'amv',
			'apk',
			'arc',
			'arj',
			'ark',
			'asf',
			'avi',
			'b1',
			'b6z',
			'ba',
			'bh',
			'bmp',
			'cab',
			'car',
			'cda',
			'cdx',
			'cfs',
			'cpt',
			'csv',
			'dar',
			'dd',
			'dgc',
			'dif',
			'dmg',
			'doc',
			'docm',
			'docx',
			'dot',
			'dotx',
			'drc',
			'ear',
			'eml',
			'eps',
			'f4a',
			'f4b',
			'f4p',
			'f4v',
			'flv',
			'gca',
			'genozip',
			'gifv',
			'ha',
			'hki',
			'ice',
			'iso',
			'jar',
			'kgb',
			'lha',
			'lzh',
			'lzx',
			'm2ts',
			'm2v',
			'm4a',
			'm4p',
			'm4v',
			'mid',
			'midi',
			'mkv',
			'mng',
			'mov',
			'mp2',
			'mp3',
			'mp4',
			'mpe',
			'mpeg',
			'mpg',
			'mpv',
			'mts',
			'mxf',
			'nsv',
			'ogg',
			'ogv',
			'pak',
			'partimg',
			'pdf',
			'pea',
			'phar',
			'pim',
			'pit',
			'pot',
			'potm',
			'potx',
			'ppam',
			'pps',
			'ppsm',
			'ppsx',
			'ppt',
			'pptm',
			'pptx',
			'psd',
			'pst',
			'pub',
			'qda',
			'qt',
			'rar',
			'rk',
			'rm',
			'rmvb',
			'roq',
			'rtf',
			's7z',
			'sda',
			'sea',
			'sen',
			'sfx',
			'shk',
			'sit',
			'sitx',
			'sldm',
			'sldx',
			'sqx',
			'svi',
			'tar',
			'bz2',
			'gz',
			'lz',
			'xz',
			'zst',
			'tbz2',
			'tgz',
			'tif',
			'tiff',
			'tlz',
			'tmp',
			'ts',
			'txt',
			'txz',
			'uca',
			'uha',
			'viv',
			'vob',
			'vsd',
			'vsdm',
			'vsdx',
			'vss',
			'vssm',
			'vst',
			'vstm',
			'vstx',
			'war',
			'wav',
			'wbk',
			'webm',
			'wim',
			'wks',
			'wma',
			'wmd',
			'wms',
			'wmv',
			'wmz',
			'wp5',
			'wpd',
			'xar',
			'xla',
			'xlam',
			'xlm',
			'xls',
			'xlsm',
			'xlsx',
			'xlt',
			'xltm',
			'xltx',
			'xp3',
			'xps',
			'yuv',
			'yz1',
			'zip',
			'zipx',
			'zoo',
			'zpaq',
			'zz',
			'png',
			'jpeg',
			'jpg',
			'gif',
			'',
		];
		preg_match( '/\.[\w]+$/', $destination, $fileExtension );
		$fileExtension = isset( $fileExtension[0] ) ? $fileExtension[0] : '';

		if ( ! in_array( str_replace( '.', '', $fileExtension ), $extensions ) ) {
			return 'ERROR_INVALID_FILE_EXTENSION';
		}

		if ( ! preg_match( '/^https?:\/\//i', $source ) ) {
			$result = $this->_createFile( $source, $destination );
		} else {
			$result = $this->_saveFileCurl( $source, $destination );
		}

		if ( 'OK' != $result ) {
			return $result;
		}

		$destination = DFWBC_STORE_BASE_DIR . $destination;

		if ( 0 != $width && 0 != $height ) {
			$this->_scaled2( $destination, $width, $height );
		}

		return $result;
	}

	/**
	 * LoadImage
	 *
	 * @param         $filename
	 * @param boolean $skipJpg
	 * @return boolean|resource
	 */
	private function _loadImage( $filename, $skipJpg = true ) {
		$imageInfo = @getimagesize( $filename );
		if ( false === $imageInfo ) {
			return false;
		}

		$this->_imageType = $imageInfo[2];

		switch ( $this->_imageType ) {
			case IMAGETYPE_JPEG:
				$image = imagecreatefromjpeg( $filename );
				break;
			case IMAGETYPE_GIF:
				$image = imagecreatefromgif( $filename );
				break;
			case IMAGETYPE_PNG:
				$image = imagecreatefrompng( $filename );
				break;
			default:
				return false;
		}

		if ( $skipJpg && ( IMAGETYPE_JPEG == $this->_imageType ) ) {
			return false;
		}

		return $image;
	}

	/**
	 * SaveImage
	 *
	 * @param         $image
	 * @param         $filename
	 * @param integer $imageType
	 * @param integer $compression
	 * @return boolean
	 */
	private function _saveImage( $image, $filename, $imageType = IMAGETYPE_JPEG, $compression = 85 ) {
		$result = true;
		if ( IMAGETYPE_JPEG == $imageType ) {
			$result = imagejpeg( $image, $filename, $compression );
		} elseif ( IMAGETYPE_GIF == $imageType ) {
			$result = imagegif( $image, $filename );
		} elseif ( IMAGETYPE_PNG == $imageType ) {
			$result = imagepng( $image, $filename );
		}

		imagedestroy( $image );

		return $result;
	}

	/**
	 * CreateFile
	 *
	 * @param string $source      Source
	 * @param string $destination Destination
	 *
	 * @return string
	 */
	private function _createFile( $source, $destination ) {
		if ( $this->_createDir( dirname( $destination ) ) !== false ) {
			$body = base64_decode( $source );
			if ( false === $body || false === file_put_contents( $destination, $body ) ) {
				return '[BRIDGE ERROR] File save failed!';
			}

			return 'OK';
		}

		return '[BRIDGE ERROR] Directory creation failed!';
	}

	/**
	 * SaveFileCurl
	 *
	 * @param $source
	 * @param $destination
	 * @return string
	 */
	private function _saveFileCurl( $source, $destination ) {
		$source = $this->_escapeSource( $source );
		if ( $this->_createDir( dirname( $destination ) ) !== false ) {
			$headers = [
				'Accept-Language:*',
				'User-Agent: "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1"',
			];

			$dst = @fopen( $destination, 'wb' );
			if ( false === $dst ) {
				return '[BRIDGE ERROR] Can\'t create  $destination!';
			}

			$request = wp_remote_get( $source,
				[
					'method'      => 'GET',
					'timeout'     => 60,
					'redirection' => 5,
					'httpversion' => '1.0',
					'blocking'    => true,
					'stream'      => true,
					'filename'    => $destination,
					'headers'     => $headers,
					'cookies'     => [],
				] );

			if ( wp_remote_retrieve_response_code( $request ) != 200 ) {
				return '[BRIDGE ERROR] Bad response received from source, HTTP code wp_remote_retrieve_response_code($request)!';
			}

			return 'OK';
		} else {
			return '[BRIDGE ERROR] Directory creation failed!';
		}
	}

	/**
	 * EscapeSource
	 *
	 * @param $source
	 * @return mixed
	 */
	private function _escapeSource( $source ) {
		return str_replace( ' ', '%20', $source );
	}

	/**
	 * CreateDir
	 *
	 * @param $dir
	 * @return boolean
	 */
	private function _createDir( $dir ) {
		if ( defined( 'WP_CONTENT_DIR' ) ) {
			$uploadsPath = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'uploads';
		} elseif ( defined( 'UPLOADS' ) ) {
			$uploadsPath = UPLOADS;
		} else {
			$uploadsPath = DFWBC_STORE_BASE_DIR . DIRECTORY_SEPARATOR . 'wp-content' . DIRECTORY_SEPARATOR . 'uploads';
		}

		$dirParts    = explode( '/', str_replace( $uploadsPath, '', $dir ) );
		$uploadsPath = rtrim( $uploadsPath, DIRECTORY_SEPARATOR ) . DIRECTORY_SEPARATOR;

		foreach ( $dirParts as $item ) {
			if ( '' == $item ) {
				continue;
			}

			$uploadsPath .= $item . DIRECTORY_SEPARATOR;

			if ( ! is_dir( $uploadsPath ) ) {
				$res = @mkdir( $uploadsPath, 0755 );

				if ( ! $res ) {
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * Scaled2 method optimizet for prestashop
	 *
	 * @param $destination
	 * @param $destWidth
	 * @param $destHeight
	 * @return string
	 */
	private function _scaled2( $destination, $destWidth, $destHeight ) {
		$method = 0;

		$sourceImage = $this->_loadImage( $destination, false );

		if ( false === $sourceImage ) {
			return 'IMAGE NOT SUPPORTED';
		}

		$sourceWidth  = imagesx( $sourceImage );
		$sourceHeight = imagesy( $sourceImage );

		$widthDiff  = $destWidth / $sourceWidth;
		$heightDiff = $destHeight / $sourceHeight;

		if ( $widthDiff > 1 && $heightDiff > 1 ) {
			$nextWidth  = $sourceWidth;
			$nextHeight = $sourceHeight;
		} else {
			if ( intval( $method ) == 2 || ( intval( $method ) == 0 && $widthDiff > $heightDiff ) ) {
				$nextHeight = $destHeight;
				$nextWidth  = intval( ( $sourceWidth * $nextHeight ) / $sourceHeight );
				$destWidth  = ( ( intval( $method ) == 0 ) ? $destWidth : $nextWidth );
			} else {
				$nextWidth  = $destWidth;
				$nextHeight = intval( $sourceHeight * $destWidth / $sourceWidth );
				$destHeight = ( intval( $method ) == 0 ? $destHeight : $nextHeight );
			}
		}

		$borderWidth  = intval( ( $destWidth - $nextWidth ) / 2 );
		$borderHeight = intval( ( $destHeight - $nextHeight ) / 2 );

		$destImage = imagecreatetruecolor( $destWidth, $destHeight );

		$white = imagecolorallocate( $destImage, 255, 255, 255 );
		imagefill( $destImage, 0, 0, $white );

		imagecopyresampled( $destImage, $sourceImage, $borderWidth, $borderHeight, 0, 0, $nextWidth, $nextHeight, $sourceWidth, $sourceHeight );
		imagecolortransparent( $destImage, $white );

		return $this->_saveImage( $destImage, $destination, $this->_imageType, 100 ) ? 'OK' : 'CAN\'T SCALE IMAGE';
	}

}

/**
 * Class DFW_Bridge_Action_Query
 */
class DFW_Bridge_Action_Query {

	/**
	 * Extract extended query params from post and request
	 */
	public static function requestToExtParams( array $parameters ) {
		return array(
			'fetch_fields' => ( isset( $parameters['fetchFields'] ) && ( intval( $parameters['fetchFields'] ) == 1 ) ),
			'set_names'    => isset( $parameters['set_names'] ) ? sanitize_text_field( $parameters['set_names'] ) : false,
		);
	}

	/**
	 * SetSqlMode
	 *
	 * @param DFW_Bridge $bridge Bridge Instance
	 *
	 * @return boolean|array
	 */
	public static function setSqlMode( DFW_Bridge $bridge ) {
		$sqlSettings = $bridge->getRequest()->get_param( 'sql_settings' );

		if ($sqlSettings) {
			try {
				if (isset($sqlSettings['sql_modes'])) {
					if ( DFWBC_BRIDGE_ENABLE_ENCRYPTION ) {
						$query = 'SET SESSION SQL_MODE=' . DFW_decrypt( $sqlSettings['sql_modes'], true );
					} else {
						$query = 'SET SESSION SQL_MODE=' . base64_decode( DFW_swapLetters( $sqlSettings['sql_modes'] ) );
					}

					$bridge->getLink()->localQuery($query);
				}

				if (isset($sqlSettings['sql_variables'])) {
					if ( DFWBC_BRIDGE_ENABLE_ENCRYPTION ) {
						$query = DFW_decrypt( $sqlSettings['sql_variables'], true );
					} else {
						$query = base64_decode( DFW_swapLetters( $sqlSettings['sql_variables'] ) );
					}

					$bridge->getLink()->localQuery($query);
				}
			} catch (Throwable $exception) {
				if ( DFWBC_BRIDGE_ENABLE_ENCRYPTION ) {
					return DFW_encrypt(
						serialize(
							[
								'error'         => $exception->getMessage(),
								'query'         => $query,
								'failedQueryId' => 0,
							]
						)
					);
				} else {
					return base64_encode(
						serialize(
							[
								'error'         => $exception->getMessage(),
								'query'         => $query,
								'failedQueryId' => 0,
							]
						)
					);
				}
			}
		}

		return true;
	}

	/**
	 * Perform
	 *
	 * @param DFW_Bridge $bridge Bridge instance
	 * @return boolean
	 */
	public function Perform( DFW_Bridge $bridge ) {
		$request = $bridge->getRequest();
		$parameters = $request->get_params();

		if ( isset( $parameters['query'] ) && isset( $parameters['fetchMode'] ) ) {

			if ( DFWBC_BRIDGE_ENABLE_ENCRYPTION ) {
				$query = DFW_decrypt(sanitize_text_field( $parameters['query'] ) , true);
			} else {
				$query = base64_decode(DFW_swapLetters( sanitize_text_field( $parameters['query'] ) ) );
			}

			$fetchMode = (int) $parameters['fetchMode'];

			if ( ! self::setSqlMode( $bridge ) ) {
				return false;
			}

			$res = $bridge->getLink()->query( $query, $fetchMode, self::requestToExtParams($parameters) );

			if ( is_array( $res['result'] ) || is_bool( $res['result'] ) ) {
				$result = serialize( array(
					'res'           => $res['result'],
					'fetchedFields' => @$res['fetchedFields'],
					'insertId'      => $bridge->getLink()->getLastInsertId(),
					'affectedRows'  => $bridge->getLink()->getAffectedRows(),
				) );

				if ( DFWBC_BRIDGE_ENABLE_ENCRYPTION ) {
					return DFW_encrypt( $result );
				} else {
					return base64_encode( $result );
				}
			} else {
				if ( DFWBC_BRIDGE_ENABLE_ENCRYPTION ) {
					return DFW_encrypt( serialize( ['error' => $res['message'], 'query' => $query, 'failedQueryId' => 0] ) );
				} else {
					return base64_encode( $res['message'] );
				}
			}
		} else {
			return false;
		}
	}

}

class DFW_Bridge_Action_Platform_Action {

	/**
	 * Perform
	 *
	 * @param DFW_Bridge $bridge
	 */
	public function Perform( DFW_Bridge $bridge ) {
		global $wpdb;
		$request = $bridge->getRequest();
		$parameters = $request->get_params();

		if ( empty( $wpdb->dbh ) || empty( $wpdb->dbh->client_info ) ) {
			$wpdb->db_connect( false );
		}

		if ( isset( $parameters['platform_action'], $parameters['data'] ) && $parameters['platform_action'] && method_exists( $bridge->config,
				$parameters['platform_action'] ) ) {
			$response = array( 'error' => null, 'data' => null );

			try {
				if ( DFWBC_BRIDGE_ENABLE_ENCRYPTION ) {
					$data = json_decode( DFW_decrypt( $parameters['data'], true ), true );
				} else {
					$data = json_decode( base64_decode( DFW_swapLetters( $parameters['data'] ) ), true );
				}

				$response['data'] = $bridge->config->{sanitize_text_field( $parameters['platform_action'] )}( $data );
			} catch ( Exception $e ) {
				$response['error']['message'] = $e->getMessage();
				$response['error']['code']    = $e->getCode();
			} catch ( Throwable $e ) {
				$response['error']['message'] = $e->getMessage();
				$response['error']['code']    = $e->getCode();
			}

			return json_encode( $response );
		} else {
			return json_encode( array( 'error' => array( 'message' => 'Action is not supported' ), 'data' => null ) );
		}
	}

}

/**
 * Class DFW_Bridge_Action_Phpinfo
 */
class DFW_Bridge_Action_Phpinfo {


	/**
	 * Perform
	 *
	 * @param DFW_Bridge $bridge
	 */
	public function Perform( DFW_Bridge $bridge ) {
		return phpinfo();
	}

}

class DFW_Bridge_Action_Multiquery {

	protected $_lastInsertIds = array();
	protected $_result        = array();

	/**
	 * Perform
	 *
	 * @param DFW_Bridge $bridge
	 * @return boolean|null
	 */
	public function Perform( DFW_Bridge $bridge ) {
		$request = $bridge->getRequest();
		$parameters = $request->get_params();

		if ( isset( $parameters['queries'] ) && isset( $parameters['fetchMode'] ) ) {
			wp_raise_memory_limit( 'admin' );

			if ( DFWBC_BRIDGE_ENABLE_ENCRYPTION ) {
				$queries = json_decode( DFW_decrypt( sanitize_text_field( $parameters['queries'] ), true) );
			} else {
				$queries = json_decode( base64_decode( DFW_swapLetters( sanitize_text_field( $parameters['queries'] ) ) ) );
			}

			$count   = 0;

			if ( ! DFW_Bridge_Action_Query::setSqlMode( $bridge ) ) {
				return false;
			}

			foreach ( $queries as $queryId => $query ) {
				if ( $count ++ > 0 ) {
					$query = preg_replace_callback( '/_A2C_LAST_\{([a-zA-Z0-9_\-]{1,32})\}_INSERT_ID_/', array( $this, '_replace' ), $query );
					$query = preg_replace_callback( '/A2C_USE_FIELD_\{([\w\d\s\-]+)\}_FROM_\{([a-zA-Z0-9_\-]{1,32})\}_QUERY/',
						array( $this, '_replaceWithValues' ),
						$query );
				}

				$res = $bridge->getLink()->query( $query, (int) $parameters['fetchMode'], DFW_Bridge_Action_Query::requestToExtParams($parameters) );
				if ( is_array( $res['result'] ) || is_bool( $res['result'] ) ) {
					$queryRes = array(
						'res'           => $res['result'],
						'fetchedFields' => @$res['fetchedFields'],
						'insertId'      => $bridge->getLink()->getLastInsertId(),
						'affectedRows'  => $bridge->getLink()->getAffectedRows(),
					);

					$this->_result[ $queryId ]        = $queryRes;
					$this->_lastInsertIds[ $queryId ] = $queryRes['insertId'];
				} else {
					$data['error']         = $res['message'];
					$data['failedQueryId'] = $queryId;
					$data['query']         = $query;

					if ( DFWBC_BRIDGE_ENABLE_ENCRYPTION ) {
						return DFW_encrypt( serialize( $data ) );
					} else {
						return base64_encode( serialize( $data ) );
					}
				}
			}

			if ( DFWBC_BRIDGE_ENABLE_ENCRYPTION ) {
				return DFW_encrypt( serialize( $this->_result ) );
			} else {
				return base64_encode( serialize( $this->_result ) );
			}
		} else {
			return false;
		}
	}

	/**
	 * Replace
	 *
	 * @param $matches
	 *
	 * @return mixed
	 */
	protected function _replace( $matches ) {
		return $this->_lastInsertIds[ $matches[1] ];
	}

	/**
	 * ReplaceWithValues
	 *
	 * @param $matches
	 *
	 * @return string
	 */
	protected function _replaceWithValues( $matches ) {
		$values = array();
		if ( isset( $this->_result[ $matches[2] ]['res'] ) ) {
			foreach ( $this->_result[ $matches[2] ]['res'] as $row ) {
				if ( null === $row[ $matches[1] ] ) {
					$values[] = $row[ $matches[1] ];
				} else {
					$values[] = addslashes( $row[ $matches[1] ] );
				}
			}
		}

		return '\'' . implode( '\', \'', array_unique( $values ) ) . '\'';
	}

}

/**
 * Class DFW_Bridge_Action_Getconfig
 */
class DFW_Bridge_Action_Getconfig {

	/**
	 * ParseMemoryLimit
	 *
	 * @param $val
	 * @return integer
	 */
	private function parseMemoryLimit( $val ) {
		$valInt = (int) $val;
		$last   = strtolower( $val[ strlen( $val ) - 1 ] );

		switch ( $last ) {
			case 'g':
				$valInt *= 1024;
			//case giga
			case 'm':
				$valInt *= 1024;
			//case mega
			case 'k':
				$valInt *= 1024;
			//case kilo
		}

		return $valInt;
	}

	/**
	 * GetMemoryLimit
	 *
	 * @return mixed
	 */
	private function getMemoryLimit() {
		$memoryLimit = trim( @ini_get( 'memory_limit' ) );

		if ( strlen( $memoryLimit ) === 0 ) {
			$memoryLimit = '0';
		}

		return $this->parseMemoryLimit( $memoryLimit );
	}

	/**
	 * IsZlibSupported
	 *
	 * @return boolean
	 */
	private function isZlibSupported() {
		return function_exists( 'gzdecode' );
	}

	/**
	 * Perform
	 *
	 * @param $bridge
	 */
	public function Perform( DFW_Bridge $bridge ) {
		try {
			$timeZone = date_default_timezone_get();
		} catch ( Exception $e ) {
			$timeZone = 'UTC';
		}

		$result = array(
			'images'        => array(
				'imagesPath'               => $bridge->config->imagesDir, // path to images folder - relative to store root
				'categoriesImagesPath'     => $bridge->config->categoriesImagesDir,
				'categoriesImagesPaths'    => $bridge->config->categoriesImagesDirs,
				'productsImagesPath'       => $bridge->config->productsImagesDir,
				'productsImagesPaths'      => $bridge->config->productsImagesDirs,
				'manufacturersImagesPath'  => $bridge->config->manufacturersImagesDir,
				'manufacturersImagesPaths' => $bridge->config->manufacturersImagesDirs,
			),
			'languages'     => $bridge->config->languages,
			'baseDirFs'     => DFWBC_STORE_BASE_DIR,    // filesystem path to store root
			'bridgeVersion' => DFWBC_BRIDGE_VERSION,
			'bridgeKeyId'   => defined('DFWBC_BRIDGE_PUBLIC_KEY_ID') ? DFWBC_BRIDGE_PUBLIC_KEY_ID : '',
			'databaseName'  => $bridge->config->dbname,
			'cartDbPrefix'  => $bridge->config->tblPrefix,
			'memoryLimit'   => $this->getMemoryLimit(),
			'zlibSupported' => $this->isZlibSupported(),
			'cartVars'      => $bridge->config->cartVars,
			'time_zone'     => isset($bridge->config->timeZone) ? $bridge->config->timeZone : $timeZone,
		);

		if ( DFWBC_BRIDGE_ENABLE_ENCRYPTION ) {
			return DFW_encrypt( serialize( $result ) );
		} else {
			return ( serialize( $result ) );
		}
	}

}

/**
 * Class DFW_Bridge_Action_GetShipmentProviders
 */
class DFW_Bridge_Action_GetShipmentProviders {

	/**
	 * Perform
	 *
	 * @param DFW_Bridge $bridge
	 *
	 * @return false|string
	 */
	public function Perform( DFW_Bridge $bridge ) {
		$response = array( 'error' => null, 'data' => null );

		switch ( $bridge->config->cartType ) {
			case 'Wordpress':
				if ( 'Woocommerce' === $bridge->config->cartId ) {
					if ( class_exists( 'WC_Shipment_Tracking_Actions' ) ) {
						try {
							$st   = new WC_Shipment_Tracking_Actions();
							$res  = $st->get_providers();
							$data = array();

							foreach ( $res as $country => $providers ) {
								foreach ( $providers as $providerName => $url ) {
									$data[ sanitize_title( $providerName ) ] = array(
										'name'    => $providerName,
										'country' => $country,
										'url'     => $url,
									);
								}
							}

							$response['data'] = $data;
						} catch ( Exception $e ) {
							$response['error']['message'] = $e->getMessage();
							$response['error']['code']    = $e->getCode();
						}
					} else {
						$response['error']['message'] = 'File does not exist';
					}
				} else {
					$response['error']['message'] = 'Action is not supported';
				}
				break;
			default:
				$response['error']['message'] = 'Action is not supported';
		}

		return json_encode( $response );
	}

}

/**
 * Class DFW_Bridge_Action_CreateRefund
 */
class DFW_Bridge_Action_CreateRefund {

	/**
	 * Check request key
	 *
	 * @param string $requestKey Request Key
	 * @return boolean
	 */
	private function _checkRequestKey( $requestKey ) {
		$request = wp_remote_post( DFWBC_BRIDGE_CHECK_REQUEST_KEY_LINK,
			[
				'method'      => 'POST',
				'timeout'     => 60,
				'redirection' => 5,
				'httpversion' => '1.0',
				'sslverify'   => false,
				http_build_query( array( 'request_key' => $requestKey, 'store_key' => DFWBC_TOKEN ) ),
			] );

		if ( wp_remote_retrieve_response_code( $request ) != 200 ) {
			return '[BRIDGE ERROR] Bad response received from source, HTTP code wp_remote_retrieve_response_code($request)!';
		}

		try {
			$res = json_decode( $request['body'] );
		} catch ( Exception $e ) {
			return false;
		}

		return isset( $res->success ) && $res->success;
	}

	/**
	 * Perform
	 *
	 * @param DFW_Bridge $bridge
	 * @return void
	 */
	public function Perform( DFW_Bridge $bridge ) {
		$response = array( 'error' => null, 'data' => null );
		$request = $bridge->getRequest();
		$parameters = $request->get_params();

		if ( ! isset( $parameters['request_key'] ) || ! $this->_checkRequestKey( sanitize_text_field( $parameters['request_key'] ) ) ) {
			$response['error']['message'] = 'Not authorized';
			echo json_encode( $response );

			return;
		}

		$orderId           = $parameters['order_id'];
		$isOnline          = $parameters['is_online'];
		$refundMessage     = isset( $parameters['refund_message'] ) ? sanitize_text_field( $parameters['refund_message'] ) : '';
		$itemsData         = json_decode( sanitize_text_field( $parameters['items'] ), true );
		$totalRefund       = isset( $parameters['total_refund'] ) ? (float) $parameters['total_refund'] : null;
		$shippingRefund    = isset( $parameters['shipping_refund'] ) ? (float) $parameters['shipping_refund'] : null;
		$adjustmentRefund  = isset( $parameters['adjustment_refund'] ) ? (float) $parameters['adjustment_refund'] : null;
		$restockItems      = isset( $parameters['restock_items'] ) ? filter_var( $parameters['restock_items'], FILTER_VALIDATE_BOOLEAN ) : false;
		$sendNotifications = isset( $parameters['send_notifications'] ) ? filter_var( $parameters['send_notifications'], FILTER_VALIDATE_BOOLEAN ) : false;

		try {
			switch ( $bridge->config->cartType ) {
				case 'Wordpress':
					if ( 'Woocommerce' ===$bridge->config->cartId ) {
						$order = wc_get_order( $orderId );

						if ( $isOnline ) {
							if ( WC()->payment_gateways() ) {
								$paymentGateways = WC()->payment_gateways->payment_gateways();
							}

							if ( ! ( isset( $paymentGateways[ $order->payment_method ] ) && $paymentGateways[ $order->payment_method ]->supports( 'refunds' ) ) ) {
								throw new Exception( 'Order payment method does not support refunds' );
							}
						}

						$refund = wc_create_refund( array(
							'amount'         => ! is_null( $totalRefund ) ? (float) $totalRefund : $order->get_remaining_refund_amount(),
							'reason'         => $refundMessage,
							'order_id'       => $orderId,
							'line_items'     => $itemsData,
							'refund_payment' => false, // dont repay refund immediately for better error processing
							'restock_items'  => $restockItems,
						) );

						if ( is_wp_error( $refund ) ) {
							$response['error']['code']    = $refund->get_error_code();
							$response['error']['message'] = $refund->get_error_message();
						} elseif ( ! $refund ) {
							$response['error']['message'] = 'An error occurred while attempting to create the refund';
						}

						if ( $response['error'] ) {
							echo json_encode( $response );

							return;
						}

						if ( $isOnline ) {
							if ( WC()->payment_gateways() ) {
								$paymentGateways = WC()->payment_gateways->payment_gateways();
							}

							if ( isset( $paymentGateways[ $order->payment_method ] ) && $paymentGateways[ $order->payment_method ]->supports( 'refunds' ) ) {
								try {
									$result = $paymentGateways[ $order->payment_method ]->process_refund( $orderId,
										$refund->get_refund_amount(),
										$refund->get_refund_reason() );
								} catch ( Exception $e ) {
									$refund->delete( true ); // delete($force_delete = true)
									throw $e;
								}

								if ( is_wp_error( $result ) ) {
									$refund->delete( true );
									$response['error']['code']    = $result->get_error_code();
									$response['error']['message'] = $result->get_error_message();
								} elseif ( ! $result ) {
									$refund->delete( true );
									$response['error']['message'] = 'An error occurred while attempting to repay the refund using the payment gateway API';
								} else {
									$response['data']['refunds'][] = $refund->get_id();
								}
							} else {
								$refund->delete( true );
								$response['error']['message'] = 'Order payment method does not support refunds';
							}
						}
					} else {
						$response['error']['message'] = 'Action is not supported';
					}
					break;

				default:
					$response['error']['message'] = 'Action is not supported';
			}
		} catch ( Exception $e ) {
			unset( $response['data'] );
			$response['error']['message'] = $e->getMessage();
			$response['error']['code']    = $e->getCode();
		}

		return json_encode( $response );

	}

}

/**
 * Class DFW_Bridge_Action_Batchsavefile
 */
class DFW_Bridge_Action_Batchsavefile extends DFW_Bridge_Action_Savefile {


	/**
	 * Perform
	 *
	 * @param DFW_Bridge $bridge
	 */
	public function Perform( DFW_Bridge $bridge ) {
		$result = array();
		$request = $bridge->getRequest();
		$parameters = $request->get_params();

		if (isset($parameters['files'])) {

			foreach ( $parameters['files'] as $fileInfo ) {
				$result[ $fileInfo['id'] ] = $this->_saveFile( sanitize_text_field( $fileInfo['source'] ),
					sanitize_text_field( $fileInfo['target'] ),
					(int) $fileInfo['width'],
					(int) $fileInfo['height'] );
			}
		}

		return serialize( $result );
	}

}

/**
 * Class DFW_Bridge_Action_Basedirfs
 */
class DFW_Bridge_Action_Basedirfs {


	/**
	 * Perform
	 *
	 * @param DFW_Bridge $bridge
	 */
	public function Perform( DFW_Bridge $bridge ) {
		echo esc_html(DFWBC_STORE_BASE_DIR);
	}

}

define( 'DFWBC_BRIDGE_VERSION', '148' );
define( 'DFWBC_BRIDGE_CHECK_REQUEST_KEY_LINK', 'http://app.api2cart.com/request/key/check' );
define( 'DFWBC_BRIDGE_DIRECTORY_NAME', basename( getcwd() ) );
define( 'DFWBC_BRIDGE_PUBLIC_KEY', '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAndLPC2eTueiF49tZSUv8
zQ1zFohojUZTzNPH5ftzz9WbZFZ0xrtKoiER71dlXaUExbGmV7A0RGpCElRvvb2O
am2oCAO8jRaJj7C7MdgYl0x+uYroNhMlsF19HYsIOBeLi8wU6kQMBjFMEIJhxL8P
PtVRDclPWWc+BHqleRaBuF01MOpgUuBWiB1KIzWSdc59NOGtUPhRYACb8Qv+6cS/
JBfM9UrvuJEv/wmT8Mb7C1kvNnFODb+f4BpyMdW12R9qfXDkJkcKjQRebkqNUoSF
YvaSBckBJA+kB7vldrpuOF7TKyvSv0YHnttx6YXE5Fy8Os/CgCQymiWT3slTpvve
mQIDAQAB
-----END PUBLIC KEY-----
' );
define( 'DFWBC_BRIDGE_PUBLIC_KEY_ID', 'b1f597f561759975d54588f777966a8e' );
define( 'DFWBC_BRIDGE_ENABLE_ENCRYPTION', extension_loaded('openssl') );

DFW_show_error( 0 );

require_once 'config.php';

if ( ! defined( 'DFWBC_TOKEN' ) ) {
	die( 'ERROR_TOKEN_NOT_DEFINED' );
}

if ( strlen( DFWBC_TOKEN ) !== 32 ) {
	die( 'ERROR_TOKEN_LENGTH' );
}

function DFW_show_error( $status ) {
	if ( $status ) {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG && defined( 'WP_DEBUG_DISPLAY' ) && WP_DEBUG_DISPLAY ) {
			if ( substr( phpversion(), 0, 1 ) >= 5 ) {
				error_reporting( E_ALL & ~E_STRICT );
				return;
			} else {
				error_reporting( E_ALL );
				return;
			}
		}
	}

	error_reporting( 0 );
}

/**
 * DFW_exceptions_error_handler
 *
 * @param $severity
 * @param $message
 * @param $filename
 * @param $lineno
 *
 * @throws ErrorException
 */
function DFW_exceptions_error_handler( $severity, $message, $filename, $lineno ) {
	if ( error_reporting() === 0 ) {
		return;
	}

	if ( strpos( $message, 'Declaration of' ) === 0 ) {
		return;
	}

	if ( error_reporting() & $severity ) {
		throw new ErrorException( $message, 0, $severity, $filename, $lineno );
	}
}

set_error_handler( 'DFW_exceptions_error_handler' );

/**
 * DFW_getPHPExecutable
 *
 * @return boolean|mixed|string
 */
function DFW_getPHPExecutable() {
	$paths   = explode( PATH_SEPARATOR, getenv( 'PATH' ) );
	$paths[] = PHP_BINDIR;
	foreach ( $paths as $path ) {
		// we need this for XAMPP (Windows)
		if ( isset( $_SERVER['WINDIR'] ) && strstr( $path, 'php.exe' ) && file_exists( $path ) && is_file( $path ) ) {
			return $path;
		} else {
			$phpExecutable = $path . DIRECTORY_SEPARATOR . 'php' . ( isset( $_SERVER['WINDIR'] ) ? '.exe' : '' );
			if ( file_exists( $phpExecutable ) && is_file( $phpExecutable ) ) {
				return $phpExecutable;
			}
		}
	}

	return false;
}


/**
 * DFW_swapLetters
 *
 * @param $input
 *
 * @return string
 */
function DFW_swapLetters( $input ) {
	$default = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
	$custom  = 'ZYXWVUTSRQPONMLKJIHGFEDCBAzyxwvutsrqponmlkjihgfedcba9876543210+/';

	return strtr( $input, $default, $custom );
}

/**
 * DFW_encrypt
 *
 * @param string $data Data to encrypt
 *
 * @return string
 */
function DFW_encrypt( $data ) {
	if ( DFWBC_BRIDGE_ENABLE_ENCRYPTION ) {
		$len = 2048/8 - 42;
		$data = str_split( gzcompress( $data ), $len );
		$result = '';

		foreach ( $data as $d ) {
			if ( openssl_public_encrypt( $d, $encrypted, DFWBC_BRIDGE_PUBLIC_KEY, OPENSSL_PKCS1_OAEP_PADDING ) ) {
				$result .= $encrypted;
			} else {
				throw new Exception( __( 'ERROR_ENCRYPT', 'woocommerce' ) );
			}
		}

		return bin2hex( $result );
	} else {
		return base64_encode( $data );
	}
}

/**
 *  DFW_decrypt
 *
 * @param string $data    Data to decrypt
 * @param false  $encoded decode data flag
 *
 * @return false|mixed|string
 */
function DFW_decrypt( $data, $encoded = false ) {
	if ( DFWBC_BRIDGE_ENABLE_ENCRYPTION ) {
		if ( $encoded ) {
			$data = @hex2bin( $data );

			if ( empty( $data ) ) {
				throw new Exception( __( 'ERROR_INVALID_HEXDECIMAL_VALUE', 'woocommerce' ) );
			}
		}

		$data = str_split( $data, 256 );
		$result = '';

		foreach ( $data as $d ) {
			if ( openssl_public_decrypt( $d, $decrypted, DFWBC_BRIDGE_PUBLIC_KEY ) ) {
				$result .= $decrypted;
			} else {
				throw new Exception( __( 'ERROR_DECRYPT', 'woocommerce' ) );
			}
		}

		return gzuncompress( $result );
	} else {
		return $data;
	}
}
