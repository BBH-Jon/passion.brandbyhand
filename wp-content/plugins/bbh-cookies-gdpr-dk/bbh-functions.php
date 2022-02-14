<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * bbh_Functions File Doc Comment
 *
 * @category bbh_Functions
 * @package   bbh-gdpr-tracking
 * @author    Gaspar Nemes
 */

function bbh_gdpr_get_plugin_directory_url(){
    return plugin_dir_url( __FILE__ );
}

add_filter( 'plugin_action_links', 'bbh_gdpr_plugin_settings_link', 10, 2 );

function bbh_gdpr_plugin_settings_link( $links, $file ) {
    if ( $file == plugin_basename(dirname(__FILE__) . '/bbh-gdpr.php') ) {
        /*
         * Insert the settings page link at the beginning
         */
        $in = '<a href="options-general.php?page=bbh-gdpr">' . __('Settings','bbh-gdpr') . '</a>';
        array_unshift($links, $in);

    }
    return $links;
}