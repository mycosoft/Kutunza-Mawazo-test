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
define( 'DB_NAME', 'u730763858_fb2a7' );

/** Database username */
define( 'DB_USER', 'u730763858_Wf2Yc' );

/** Database password */
define( 'DB_PASSWORD', 'G1elo0gEWG' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

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
define( 'AUTH_KEY',          'I;YnPH*j81(BGcCDG7IO$g,bxPBV-N{%B87-TTi #KNvO}9I]qV136j|Tw>T?[Y ' );
define( 'SECURE_AUTH_KEY',   'T5XY8N:7E*kL,fNj0HBHS6<)#ikyFJz=+r{]7uL,7A#X5dVC`Cth)Gw!SS6DBCIx' );
define( 'LOGGED_IN_KEY',     'Z$V5ih0ujx8)cFmqNf( Gwr4S-}JDcX<W]%veAVM(lX:ubK6s,-ZmsOag-Zv--K$' );
define( 'NONCE_KEY',         '8$W>gO2B^>wt9`#L0&#6V#0rSyl.jJSvBW-Yo~X#4[Matcx(>;_im<Z`ck5MwNk/' );
define( 'AUTH_SALT',         'n53y*Z!g9$Vw_eM*p-T6,~$3axzqSF o@d`EUILg;M.71^zqfKm6W]14Ep>-YV{^' );
define( 'SECURE_AUTH_SALT',  'PG6no;@Dws%|BA&0==PCH#d.8n)F<re6#^z;Mt7wxv_I;%f!E^xD7iWf#dM4,O=|' );
define( 'LOGGED_IN_SALT',    ':oS?mT^3n%1!L8Qs+OhgN4z,C5)c%NV8Q1`bziex:uJrQ9p@MeDF(PO1xoz2ke)2' );
define( 'NONCE_SALT',        'JO+&$XsQ&_E>J?=/0!E [P.8juj<oM_(h1~^V&Fi5O(z7X<z3xDw=!|1;?_/?AW^' );
define( 'WP_CACHE_KEY_SALT', 'yz&uX&H,y?20t|jHee]!;oNbED.}JX{VlBIlD&;7tWklNphMLcoG7,;jR+<%v$mm' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */



define( 'FS_METHOD', 'direct' );
define( 'WP_AUTO_UPDATE_CORE', false );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
