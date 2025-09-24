<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'O^{ 0KxMNlk,uB)3DGZD<^xm>FdR9${c-TJ=a~X[3uj|Ud/b)g*|}xa5n0*k6u9L' );
define( 'SECURE_AUTH_KEY',   's1(jfu)#+z*hj=VPOAg:A%d6.lfY!FQT5UQ#QpKaq11X4UG($<taN.gF/$P~$(x&' );
define( 'LOGGED_IN_KEY',     'P9=pcXp%60_^yDfZ%nN?3/{D%T?TjzM$6id+&!0;/8OO%&Qk1A*.H^,e?>e.f${[' );
define( 'NONCE_KEY',         'r?=q.7f_+g>C-ht>D(v[h@|kqw;9mv_M-T$bj[V$TFmrDCnJKi1hc^C/2N5lnSVl' );
define( 'AUTH_SALT',         'zj-/$+fmos~VpUtI)ME<qv/#zoSwuKAl@a6Be9{>]&MJ4=BsH2XKVYK!7<+|}4`H' );
define( 'SECURE_AUTH_SALT',  '*5T4hegiJ`V`ho$0E=mmDg)lQS:gaP*8Q{e,urCXE=5RQ|:V|&=x~w$Z~/nAH65&' );
define( 'LOGGED_IN_SALT',    '#%-Mcx%3p_yUFRLp|Yf#-M~[k:RVBlF:T/f@?3*<A,$}~;$sgc82GA641-_CZp7{' );
define( 'NONCE_SALT',        '1`W52](e>dF*O|^8ZsZW$s`:M 5M*2}8q>`f(T$1jG8v;D5WyH0)|r~Hi@~^AQFA' );
define( 'WP_CACHE_KEY_SALT', '|i.Q2FXnv+[%Z+FAaj%qwbhZohW]YE|lN@kz;Mfk8vRP!ENO9p//MpOy~nMQaS,~' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
    define( 'WP_DEBUG', true );
    define( 'WP_DEBUG_LOG', true );
    define( 'WP_DEBUG_DISPLAY', false );
    @ini_set( 'display_errors', 0);
}


define( 'WP_ALLOW_MULTISITE', true );
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', true );
$base = '/';
//define( 'DOMAIN_CURRENT_SITE', 'rrfwp.local' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
define( 'WP_MAX_MEMORY_LIMIT' , '512M' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
?>
