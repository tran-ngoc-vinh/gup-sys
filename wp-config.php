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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'gup_sys1' );

/** MySQL database username */
define( 'DB_USER', 'gup_sys1' );

/** MySQL database password */
define( 'DB_PASSWORD', '123456789' );

/** MySQL hostname */
define( 'DB_HOST', 'gup-sys1-web.c8bwsaqlxbq6.ap-northeast-1.rds.amazonaws.com' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ']6FLk{H5_ET|Nn;|.Ehi*<q~-+3u;RC+J)D85O7Qdvz0X7E v2PIJ7;QSFKZOkLR' );
define( 'SECURE_AUTH_KEY',  '/RM]AT=l5E=MuXO!zw;)Gv,.sw6I3zxPD]-b(r NlOby:c4pOm%mM8yK^pCb4EmL' );
define( 'LOGGED_IN_KEY',    '&I323<VMt%pOA.6QUJr|YlCqPPf@CewAhtdO]=WB?b1<eKBA%Q;Ha+_ywBXS6PmP' );
define( 'NONCE_KEY',        ':_VH=npg/t^lVuWm^*;4t*JL14>s<RH`]%x$-_>E ^{pN$Vo#%+c}Am$seloTR!l' );
define( 'AUTH_SALT',        'stm7fTo2mses&1WmRJQhztrL}lALku7 eM:CJHSb^eyFY_Oi+xeel<yHzpy[FMMt' );
define( 'SECURE_AUTH_SALT', 'p&3I1fID5T.`g!!ig)SZ$CE05lB1j5gr!3oi17|j[{u7qw|}Bw5)~K@YM-/P9f+0' );
define( 'LOGGED_IN_SALT',   'OUpp*`>NfOS1ob~9$tuzh3eR!,8&Kn!iD0myQ,X1m_i51$Zak`%H,:]r$L]t8y +' );
define( 'NONCE_SALT',       '$#oR~i*S$jb>w~,CieQ!bXWn<hCJ./Uk^[*{~awU~@gr<Q5}q+rQmJBa!vT%i/O`' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
