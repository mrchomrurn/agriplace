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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'agriplace' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '5@x/9d/|FMp{Ji8u:yc2t $RevEG_CM1h+><Fqpgg?KmOPmL7]E78}4)T h5|L ?' );
define( 'SECURE_AUTH_KEY',  '3uZ4mp(TUz72r30) T`zfq8Dk/Q0G+H}NuT<C5$WHB3`I#DRphI!*_dM,3b+s,a)' );
define( 'LOGGED_IN_KEY',    'DrC(IuKq!@>4`gYs 6Rf-c`eXr*7x0rY(Od6n%3M%XJcYVSIPrIMK%hQ2aUurPRq' );
define( 'NONCE_KEY',        'qc]6Qa [!5I&kCXl&d0,UG-!$7]U(,A^K~`1O2<>K+TbQQNXdi}Gn[j?nArM)-+A' );
define( 'AUTH_SALT',        'X?3S^~n5QjO+uJB9l>{J^rP/T2|qc1^Kd5bi2fkrVzL,8N2*?-L~?UwbVc#tYYvs' );
define( 'SECURE_AUTH_SALT', '_+LBCfHi 6#lk7bOh`U5@SKb~*aQ|?055.P.w^X(7c[N/@1=b|B;|BqN$kq{Yq7N' );
define( 'LOGGED_IN_SALT',   'EpJ}FhPI5T4C6N?^K[;C0 _73kj;TsHDzLsAxR:a--^1*?YhcAa2yW.:(J!y!10A' );
define( 'NONCE_SALT',       'Y0t5%iF=;.*F)qTkF0T?3C1}*x.<0d6#t;{8+EB10m!V@/Eny1.%usw2(C=;fmeb' );

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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
