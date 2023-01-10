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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'id20127641_wp_e1546e38c8ab6cae7cdeca3cc8b02e47' );

/** Database username */
define( 'DB_USER', 'id20127641_wp_e1546e38c8ab6cae7cdeca3cc8b02e47' );

/** Database password */
define( 'DB_PASSWORD', 'V#UWS$P+foEi8}zV' );

/** Database hostname */
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
define( 'AUTH_KEY',         'V!4p!poYdsx-<.mw$MT[o2k_TXSiHw54Okfv#fw2w*@c>3XOX]Q[6ccZ&S`;dE+Z' );
define( 'SECURE_AUTH_KEY',  'Z UIXW!!rA^J5)v5^?pnH,(`O2GZaJXr9;0+4fk!=#MDb<>E}Lcz*0)Ie4n89fH.' );
define( 'LOGGED_IN_KEY',    '=Nm)<CpU|f`pF<IDMl^&m+)Z}CKgXZecYp|%Z2}F~fU%vMp4)Sw4`Fke,4*z=YA/' );
define( 'NONCE_KEY',        '[[fAg:E7N&&9!mcu$N2S/+HHSW*WgtB.lA2!igmJ:DnU&B-.T#i%_owp+T+dqC&Y' );
define( 'AUTH_SALT',        'W2x:Nkt|691T-]KH=5JVFP&<w1.Q@&C@W1i 4d/ZzCLg6%`wOqo[Q[w~j9far)5{' );
define( 'SECURE_AUTH_SALT', 'Ih;2cciPj.gAQXFU?CR2bA5l2u3t{%q5~AD&%nF<ptQR<ZO{M?rZ{BDK;[.9^lP+' );
define( 'LOGGED_IN_SALT',   'SC2}<>8^>@Ast|kpIlg*sWHdw[+/*lKxKmL#eWl9Xrg99U~S|&?zep9]p,/V&4`J' );
define( 'NONCE_SALT',       '?J`Jagz&j,T{Ik2CoR]rX&w0PXI7M1Y(@sc:U98<M;5x$O!?G{24r9w<[W@Kk`<U' );

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
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
