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
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '5qRkhXpjJpKZHWL8NkdvKJb2CN68yVtaj+Uq0qtLMud1PRpZ3ay8gG5/B1bYDJLyYC9bxhERfvMwASsKTPic1Q==');
define('SECURE_AUTH_KEY',  'QJAhTDWGARnIybp+MqoVrO1HRpI+/3rKrWRxsvno6SabSQ6njbG8W87sefWhNvnOuZV8MYQMy9r35fJZVdBdUw==');
define('LOGGED_IN_KEY',    'Nfyrm9nLeSpbAB1eFc2PuVIgdyLzO5+JRlPLdHA7CI5TkDx0Yofa3bO0VafoGHcCAWsw8mYh9NXg9Bkw5TqrGw==');
define('NONCE_KEY',        'SokyTyaWc+REl3L4pr9lJwfLgB6kupHDljR4cq7LR/peBsi1XHCxwyfKeimfPirJaCZFzvlIK5dscMhkG0WSIA==');
define('AUTH_SALT',        'fH0tONJrG7nY9fm6ku9BUXDzfQ4YaROcUifge5CIcZ75ul+xM1fo7q84oJ+GwkdQMH7wFC2mOgZByrlXW32fAg==');
define('SECURE_AUTH_SALT', 'k7fnLz+vsmXEF7Ay8G/2AyFZeUHwUIBEkSRl0jwrNGjI4l8FR0UpoXUULFAcBRNMjumN99XJhEuDztZ98DKzRA==');
define('LOGGED_IN_SALT',   'v+KyKlNQMMyTYnoHiJQWZ5DYRw1Sn6kPWj8nxP2y0Lksav5ChTrZ2vuBjncEMN48CwBeuL3nt2imK/fsMWPupg==');
define('NONCE_SALT',       'MElEYF3KxkDWeJJ4u2+KNjwctVHs7qNjIcCx/jO1PJz79qDRFzkjBV4NtvFuh/ikxiNQG8MgSsRcxD+2IxPWOg==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
