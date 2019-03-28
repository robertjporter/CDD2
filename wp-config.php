<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'spriteshards');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'sA*O;gddbtEE>0]&oIWEySbu0sK0Eb?hc*:eb7lXwbN@o$nMZ}Z/Cx#g}mEVV3iC');
define('SECURE_AUTH_KEY',  ' (&:8cJ>:1tLOL.9%p;5qR9Ce+nKTpuR9KtQi*Ykzl{d5D^@dYZ#;/<E)W_6yd0Y');
define('LOGGED_IN_KEY',    'go?xo@QBVUFA Rq^^b(A_IlbqhM{U.7<C361[NDwtRlT <3P7@lK!1[tDVpd<</m');
define('NONCE_KEY',        'SbD@4U3{_75S2{{<xRjW=^vgsl4=uRK6XV2|(ea-x/FC@K.={du+,n9xj{Q5DEYO');
define('AUTH_SALT',        'RxO8{*_d=af):Zs,gex]||K c~C{%X,t4#}%or,(aUD>`HTIiyk6qYf0#[1Xt$c2');
define('SECURE_AUTH_SALT', ']P0]wj_[m)d&eR;RJ5zp0_]C[ %Seg,Qd[:XDVR7X_7X_,!t9Vg]Ac./LsGvX?4G');
define('LOGGED_IN_SALT',   '!53!.9VdJ@yCnKYm}i}}B6F~54/c340qT(ajNt%9sEcuc]cO;=/sff(ZDT8R>8VP');
define('NONCE_SALT',       'Iqp(~Ae3t;1.j{_:> NuBy82wlhA7|k@j)-0d~_yC6!et#OqS(kZS&_7MliCI|lU');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
