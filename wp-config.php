<?php

define( 'WP_CACHE', false ); // Added by WP Rocket
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

 /*===============================================
 =          Cookie Login Error           =
 ===============================================*/
 define('COOKIE_DOMAIN', $_SERVER['HTTP_HOST'] );


// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "brandbyhand_dk_db4" );


/** MySQL database username */
define( 'DB_USER', "brandbyhan" );


/** MySQL database password */
define( 'DB_PASSWORD', "7w9Qmzq%" );


/** MySQL hostname */
define( 'DB_HOST', "mysql14.123hotel.dk" );


/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );


/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

$table_prefix = 'wp_';


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'IAdaDNZb$sjv)ODpB7s6U,;;|[~wurq>[|<XN3T{pvb}[Yy2l^MY!YB$:q!f4rp*' );

define( 'SECURE_AUTH_KEY',  'TT??_QP(@B0EedI339>1bG~m!0[VdcVh?P(=Q6X.7*x&${ZjiuU0I99??HL2i5>b' );

define( 'LOGGED_IN_KEY',    '7^oLjo,92t+ROK%Fr.<[LsgGJFwQD,Dd*KW2e]uOj%-&zr+w|>`(ox}y?%;F1sR$' );

define( 'NONCE_KEY',        'W5iJ&rGecCLyYf,<:=Pfj}QTC(Q7hKlJLgJ{KqB@DY<GB|j!u,jMXZ(3J)f}P&:e' );

define( 'AUTH_SALT',        '`8jVB0v.-`3yoO(|U=G!P}8|G.XfNZC}m&#nTbz/ Q>u!ZSoG|3DhEzpfWLS`hBx' );

define( 'SECURE_AUTH_SALT', ',Xslz!#+|#r4!nu3z.4?-|tNCwJU2qaG_d+ZjIz0)/6`}Kp[-Yje-xs3KU]{1l%u' );

define( 'LOGGED_IN_SALT',   'kjBX)Nqt|@tSOCQ,(_ms6lnx_FI179fhPqVQ5>pf2|D6=wVglt:[KwFsH_{<s0#{' );

define( 'NONCE_SALT',       '@R4j5T%F3]v21gRD/Hx(i*];Y<_0.%K/9OdTivQa[-(IXI>+,ZWpKfig/[3fjZmX' );


/* Set environment */
if('5.103.120.186' == $_SERVER['REMOTE_ADDR'] || '5.57.48.78' == $_SERVER['REMOTE_ADDR'] || '5.57.50.200' == $_SERVER['REMOTE_ADDR']) {
	define('ENVIRONMENT', 'DEVELOPMENT');
} else{
	define('ENVIRONMENT', 'PRODUCTION');
}

// If dev environment
if(ENVIRONMENT == 'DEVELOPMENT') {
	define('WP_DEBUG', true); // Allow debug
define( 'WP_CACHE', false ); // Added by WP Rocket
	define('DONOTCACHEPAGE', true); // Disallow cache
} else {
	define('WP_DEBUG', true);
}

/*KINT debugging*/
if(file_exists('kint.phar')){
	include 'kint.phar';
	Kint\Renderer\RichRenderer::$folder = true; //show kint on bottom instead of where its called
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
