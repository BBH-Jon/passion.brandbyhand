<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * bbh_GDPR_Options File Doc Comment
 *
 * @category bbh_GDPR_Options
 * @package   bbh-gdpr-tracking
 * @author    Gaspar Nemes
 */

/**
 * bbh_GDPR_Options Class Doc Comment
 *
 * @category Class
 * @package  bbh_GDPR_Options
 * @author   Gaspar Nemes
 */
class bbh_GDPR_Options {
	/**
	 * Global options
	 *
	 * @var array
	 */
	private $options;
	/**
	 * Construct
	 */
	function __construct() {
		add_action( 'admin_menu', array( &$this, 'bbh_gdpr_admin_menu' ) );
	}

	/**
	 * bbh feed importer page added to settings
	 *
	 * @return  void
	 */
	public function bbh_gdpr_admin_menu() {
		add_options_page(
			'GDPR Cookie',
			'GDPR Cookie',
			'manage_options',
			'bbh-gdpr',
			array( &$this, 'bbh_gdpr_settings_page' )
		);
	}
	/**
	 * Settings page registration
	 *
	 * @return void
	 */
	public function bbh_gdpr_settings_page() {
		$data = array();
		$view_cnt = new bbh_GDPR_View();
		echo $view_cnt->load( 'bbh.admin.settings.settings_page', $data );
	}

}
$bbh_gdpr_options = new bbh_GDPR_Options();
