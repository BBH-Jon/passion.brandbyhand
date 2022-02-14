<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * 	Contributors: moove agency, gaspar.nemes, Brand by Hand
 *  Plugin Name: Brand by Hand - Cookies GDPR
 *  Description: GDPR is an EU wide legislation that specifies how user data should be handled. This plugin has settings that can assist you with GDPR cookie compliance requirements.
 *  Version: 1.0.6
 *  Author: Brand by Hand
 *  Author URI: https://www.brandbyhand.dk
 *  License: GPLv2
 *  Text Domain: bbh-gdpr
 */

register_activation_hook( __FILE__ , 'bbh_gdpr_activate' );
register_deactivation_hook( __FILE__ , 'bbh_gdpr_deactivate' );


/**
 * Functions on plugin activation, create relevant pages and defaults for settings page.
 */

function bbh_gdpr_activate() {

}



/**
 * Function on plugin deactivation. It removes the pages created before.
 */
function bbh_gdpr_deactivate() {
    //$option_name = bbh_GDPR_Content::bbh_gdpr_get_option_name();
    // update_option( $option_name, array() );
}

include_once( dirname( __FILE__ ).DIRECTORY_SEPARATOR.'bbh-view.php' );
include_once( dirname( __FILE__ ).DIRECTORY_SEPARATOR.'bbh-content.php' );
include_once( dirname( __FILE__ ).DIRECTORY_SEPARATOR.'bbh-options.php' );
include_once( dirname( __FILE__ ).DIRECTORY_SEPARATOR.'bbh-controller.php' );
include_once( dirname( __FILE__ ).DIRECTORY_SEPARATOR.'bbh-actions.php' );
include_once( dirname( __FILE__ ).DIRECTORY_SEPARATOR.'bbh-functions.php' );
