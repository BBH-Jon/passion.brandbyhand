<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * bbh_GDPR_Actions File Doc Comment
 *
 * @category  bbh_GDPR_Actions
 * @package   bbh-gdpr-tracking
 * @author    Gaspar Nemes
 */

/**
 * bbh_GDPR_Actions Class Doc Comment
 *
 * @category Class
 * @package  bbh_GDPR_Actions
 * @author   Gaspar Nemes
 */
class bbh_GDPR_Actions {
	/**
	 * Global cariable used in localization
	 *
	 * @var array
	 */
	var $gdpr_loc_data;
	/**
	 * Construct
	 */
	function __construct() {
		$this->bbh_register_scripts();
		$this->bbh_register_ajax_actions();
		add_action( 'plugins_loaded', array( &$this, 'bbh_gdpr_load_textdomain' ) );
	}

	/**
	 * Register Front-end / Back-end scripts
	 *
	 * @return void
	 */
	public function bbh_register_scripts() {
		if ( is_admin() ) :
			add_action( 'admin_enqueue_scripts', array( &$this, 'bbh_gdpr_admin_scripts' ) );
		else :
			add_action( 'wp_enqueue_scripts', array( &$this, 'bbh_frontend_gdpr_scripts' ), 999 );
		endif;
	}

	/**
	 * Register global variables to head, AJAX, Form validation messages
	 *
	 * @param  string $ascript The registered script handle you are attaching the data for.
	 * @return void
	 */
	public function bbh_localize_script( $ascript ) {

		$this->gdpr_loc_data = array(
			'ajaxurl'								=>	admin_url( 'admin-ajax.php' ),
			'post_id'								=>	get_the_ID(),
			'plugin_dir'							=> 	plugins_url( basename( dirname( __FILE__ ) ) ),
			'is_page'								=>	is_page(),
			'is_single'								=>	is_single(),
			'current_user'							=>	get_current_user_id(),
		);
		wp_localize_script( $ascript, 'bbh_frontend_gdpr_scripts', $this->gdpr_loc_data );
	}

	/**
	 * Registe FRONT-END Javascripts and Styles
	 *
	 * @return void
	 */
	public function bbh_frontend_gdpr_scripts() {

		wp_enqueue_script( 'bbh_gdpr_frontend', plugins_url( basename( dirname( __FILE__ ) ) ) . '/dist/scripts/main.js', array( 'jquery' ), '1.0.6', true );
		wp_enqueue_style( 'bbh_gdpr_frontend', plugins_url( basename( dirname( __FILE__ ) ) ) . '/dist/styles/main.css', '', '1.0.6' );
		$this->bbh_localize_script( 'bbh_gdpr_frontend' );
	}
	/**
	 * Registe BACK-END Javascripts and Styles
	 *
	 * @return void
	 */
	public function bbh_gdpr_admin_scripts() {
		wp_enqueue_script( 'bbh_gdpr_backend', plugins_url( basename( dirname( __FILE__ ) ) ) . '/dist/scripts/admin.js', array( 'jquery' ), '1.0.6', true );
		wp_enqueue_style( 'bbh_gdpr_backend', plugins_url( basename( dirname( __FILE__ ) ) ) . '/dist/styles/admin.css', '', '1.0.6' );
	}

	/**
	 * Register AJAX actions for the plugin
	 */
	public function bbh_register_ajax_actions() {
		add_action( 'wp_ajax_bbh_gdpr_get_scripts', array( 'bbh_GDPR_Controller', 'bbh_gdpr_get_scripts' ) );
		add_action( 'wp_ajax_nopriv_bbh_gdpr_get_scripts', array( 'bbh_GDPR_Controller', 'bbh_gdpr_get_scripts' ) );
	}


	/**
	 * Load plugin textdomain.
	 *
	 */
	public function bbh_gdpr_load_textdomain() {
		load_plugin_textdomain( 'bbh-gdpr', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}
}
$bbh_gdpr_actions_provider = new bbh_GDPR_Actions();
