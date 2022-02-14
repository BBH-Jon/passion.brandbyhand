<?php

/*
Plugin Name: Brand by Hand - Pagebuilder
Plugin URI: PLUGIN_URL
Description: This plugin adds a column field to ACF as well as styling to the backend
Version: 2.6.2
Author: Brand by Hand
Author URI: https://brandbyhand.dk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

// check if class already exists
if( !class_exists('acf_plugin_columns') ) :

// require WP updates file
require_once('assets/update/wp-updates-plugin.php');
new WPUpdatesPluginUpdater_1705( 'http://wp-updates.com/api/2/plugin', plugin_basename(__FILE__));

define('BBH_PAGEBUILDER_VERSION', '2.6.2');

class acf_plugin_columns {

	/*
	*  __construct
	*
	*  This function will setup the class functionality
	*
	*  @type	function
	*  @date	17/02/2016
	*  @since	2.5.2
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function __construct() {

		// vars
		$this->settings = array(
			'version'	=> BBH_PAGEBUILDER_VERSION,
			'url'		=> plugin_dir_url( __FILE__ ),
			'path'		=> plugin_dir_path( __FILE__ ),
			'this_acf_version'	=> 0,
			'min_acf_version'	=> '5.4.0',
		);
		// check for ACF and min version
		add_action( 'admin_init', array($this, 'acf_checker'), 11);


		// set text domain
		// https://codex.wordpress.org/Function_Reference/load_plugin_textdomain
		load_plugin_textdomain( 'acf-columns', false, plugin_basename( dirname( __FILE__ ) ) . '/lang' );


		// include field
		add_action('acf/include_field_types', 	array($this, 'include_field_types')); // v5
		add_action('acf/register_fields', 		array($this, 'include_field_types')); // v4

		// enqueue scripts and styles
		add_action( 'acf/field_group/admin_head', array($this, 'bbh_acf_collapse_enqueue'), 11 );

	}

	function acf_checker() {

		if ( !class_exists('acf') ) {
			$this->kill_plugin();
		} else {
			$this->settings['this_acf_version'] = acf()->settings['version'];
			if ( version_compare( $this->settings['this_acf_version'], $this->settings['min_acf_version'], '<' ) ) {
				$this->kill_plugin();
			}
		}
	}

	function kill_plugin() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
		add_action( 'admin_notices', array($this, 'acf_dependent_plugin_notice') );
	}

	function acf_dependent_plugin_notice() {
		echo '<div class="error"><p>' . sprintf( __('%1$s requires ACF PRO v%2$s or higher to be installed and activated.', 'acf_column'), $this->settings['plugin'], $this->settings['min_acf_version']) . '</p></div>';
	}

	/*
	*  Load the javascript and CSS files on the ACF admin pages
	*/
	function bbh_acf_collapse_enqueue() {

		if ( class_exists('acf') ) {

			if ( version_compare( $this->settings['this_acf_version'], $this->settings['min_acf_version'], '>=' ) ||
				!acf_get_setting('pro') == 1 && ( class_exists('acf_plugin_repeater') || class_exists('acf_plugin_flexible_content') )
				) {

				$url = $this->settings['url'];
				$version = $this->settings['version'];

				// Localize the script
				$translation_array = array(
					'reorder'		=> __( 'Reorder Layout', 'acf-admin-flex-collapse' ),
					'delete'		=> __( 'Delete Layout', 'acf-admin-flex-collapse' ),
					'copy'			=> __( 'Duplicate Layout', 'acf-admin-flex-collapse' ),
					'addnew'		=> __( 'Add New Layout', 'acf-admin-flex-collapse' ),
					'toggle'		=> __( 'Click to toggle', 'acf-admin-flex-collapse' ),
					'collapseAll'	=> __( 'Collapse all Layouts', 'acf-admin-flex-collapse' ),
					'expandAll'		=> __( 'Expand all Layouts', 'acf-admin-flex-collapse' )
				);

				if ( version_compare(acf()->settings['version'], '5.7.0', '>=' ) ) {
					wp_register_style (
						'acf_admin_flex_collapse_css',
						"{$url}assets/css/acf-flexible-collapse.css",
						false,
						$version
					);
					wp_register_script(
						'acf_admin_flex_collapse_script',
						"{$url}assets/js/acf-flexible-collapse.js",
						false,
						$version
					);
				}

				wp_localize_script( 'acf_admin_flex_collapse_script', 'acf_flex_collapse', $translation_array );

				wp_enqueue_style( 'acf_admin_flex_collapse_css' );
				wp_enqueue_script( 'acf_admin_flex_collapse_script' );
			}
		}
	}


	/*
	*  include_field_types
	*
	*  This function will include the field type class
	*
	*  @type	function
	*  @date	17/02/2016
	*  @since	1.0.0
	*
	*  @param	$version (int) major ACF version. Defaults to false
	*  @return	n/a
	*/

	function include_field_types( $version = false ) {

		// support empty $version
		if( !$version ) $version = 4;


		// include
		include_once('fields/acf-columns-v' . $version . '.php');

	}


}
// Add styles and js init
function acf_admin_enqueue() {
	global $post;
	global $current_screen;


	if($current_screen->id == 'upload'){
		return;
	}
	if($current_screen->id == 'acf-field-group'){
		return;
	}
	if($current_screen->post_type == 'acf-field-group'){
		return;
	}
	if($current_screen->id == 'comment'){
		return;
	}

	// enqueue plugin jQuery
	wp_register_script( 'bbh-pagebuilder-js', plugin_dir_url(__FILE__) . 'assets/js/input.js', array('jquery'), BBH_PAGEBUILDER_VERSION, true );

	$desc = is_dir(STYLESHEETPATH . '/include/flexible-content/descriptions');
	$images = is_dir(STYLESHEETPATH . '/include/flexible-content/images');


	// get welcome file path
	if(file_exists(STYLESHEETPATH . '/include/flexible-content/welcome/welcome.php')):
		$welcomePath = get_stylesheet_directory_uri() . '/include/flexible-content/welcome/';
		$welcome     = get_stylesheet_directory_uri() . '/include/flexible-content/welcome/welcome.php';
	elseif(file_exists(STYLESHEETPATH . '/include/flexible-content/welcome/welcome.html')):
		$welcomePath = get_stylesheet_directory_uri() . '/include/flexible-content/welcome/';
		$welcome     = get_stylesheet_directory_uri() . '/include/flexible-content/welcome/welcome.html';
	else:
		$welcomePath = plugin_dir_url(__FILE__) . 'assets/templates/welcome/';
		$welcome     = plugin_dir_url(__FILE__) . 'assets/templates/welcome/welcome.php';
	endif;


	if($desc && $images){
	 	$oldVersion = 5.7;
		$versionCheck = acf()->settings['version'];
		$versionCheck = substr($versionCheck, 0, 4);

		if (preg_match('^\d+\.\d{2,2}$^', $versionCheck)) {
			$oldVersion = preg_replace('/\./', '.0', $oldVersion);
			$oldVersion = floatval($oldVersion);
		}


		$scriptPath = '/inc/layouts/js/layouts.js';

		add_action('acf/render_field/type=flexible_content', 'bbh_build_popup');
		wp_register_script( 'bbh_pagebuilder_layouts-js', plugin_dir_url(__FILE__) . $scriptPath, array('jquery'), filemtime( plugin_dir_path(__FILE__) . $scriptPath), true );
		wp_enqueue_script('bbh_pagebuilder_layouts-js');
	}


	// Localize the script with new data
	$translation_array = array(
		'markup'      => '<div class="layout-info"><div class="layout-inner"></div></div>',
		'themepath'   => get_stylesheet_directory_uri(),
		'welcomepath' => $welcomePath,
		'welcomefile' => $welcome,
	);
	wp_localize_script( 'bbh-pagebuilder-js', 'layout_material', $translation_array );

	// Enqueued script with localized data.
	wp_enqueue_script( 'bbh-pagebuilder-js' );

	// enqueue stylesheet
	wp_enqueue_style( 'bbh-pagebuilder-styles', plugin_dir_url(__FILE__) . 'assets/css/input.css', array(), BBH_PAGEBUILDER_VERSION, false);


}

// hook in styles and js
add_action('acf/input/admin_enqueue_scripts', 'acf_admin_enqueue', 99);


add_action('acf/render_field/type=flexible_content', 'test_function_1', 1, 1);
function test_function_1($field){
	echo '<div class="flexible-loader"><div class="spinner"></div></div>';
}

function acf_settings_custom_columns_style() {
	?>
	<style type="text/css">

		.acf-field-object-column tr[data-name="name"],
		.acf-field-object-column tr[data-name="instructions"],
		.acf-field-object-column tr[data-name="required"],
		/*.acf-field-object-column tr[data-name="conditional_logic"]*/ {
			display: none !important;
		}
		.flexible-loader{
			background-color: #F1F1F1;
			position: absolute;
			bottom: 0;
			right:  0;
			top: 0;
			left: 0;
			margin-left: -3px;
			margin-right: -3px;
			z-index: 4;
		}
		@-webkit-keyframes sk-scaleout {
		    0% { -webkit-transform: scale(0) }
		    100% {
		        -webkit-transform: scale(1.0);
		        opacity: 0;
		    }
		}

		@keyframes sk-scaleout {
		    0% {
		        -webkit-transform: scale(0);
		        transform: scale(0);
		    } 100% {
		        -webkit-transform: scale(1.0);
		        transform: scale(1.0);
		        opacity: 0;
		    }
		}
		.flexible-loader .spinner{
		    width: 40px;
		    height: 40px;
		    margin: auto;
		    background-color: #000000;
		    top: 80px;
		    border-radius: 100%;
		    -webkit-animation: sk-scaleout 1.0s infinite ease-in-out;
		    animation: sk-scaleout 1.0s infinite ease-in-out;
		    position: absolute;
		    left: 50%;
		    transition:  opacity .2s ease-out;
		    transform: translateX(-50%);
		    background-image: none;
		    opacity: 1;
		    background-size: 100%;
		    visibility: visible;
		}
		.flexible-loader.closing .spinner{
			opacity: 0;
		}

	</style>


	<?php
}

add_action('acf/input/admin_head', 'acf_settings_custom_columns_style');


/*======================================================
=            TinyMCE / WYSIWYG editor hooks            =
======================================================*/
/*----------  Remove buttons from row 1  ----------*/
add_filter( 'mce_buttons', 'acf_columns_filter_tinymce_buttons' );
function acf_columns_filter_tinymce_buttons( $buttons ) {

	// add color to top bar after formatselect
	$listPos = array_search('formatselect', $buttons);
	array_splice( $buttons, $listPos+1, 0, "forecolor" );
	// add underline
	$listPos = array_search('italic', $buttons);
	array_splice( $buttons, $listPos+1, 0, "underline" );

	$remove = array('wp_more');
  	return array_diff( $buttons, $remove );
}

add_filter( 'mce_buttons_2', 'acf_columns_filter_tinymce_buttons2' );
function acf_columns_filter_tinymce_buttons2( $buttons ) {
	$remove = array('forecolor');
	return array_diff( $buttons, $remove );
}

//custom button
function add_container_button() {
if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
 return;
if ( get_user_option('rich_editing') == 'true') {
 add_filter('mce_external_plugins', 'add_container_plugin');
 add_filter('mce_buttons_3', 'register_container_button');
}
}
add_action('init', 'add_container_button');


function register_container_button($buttons) {
array_push($buttons, "|", "brandbyhand_container");
return $buttons;
}

function add_container_plugin($plugin_array) {
$plugin_array['brandbyhand_container'] = plugin_dir_url( __FILE__ ) . '/assets/js/input.js';;
return $plugin_array;
}


/*=============================================
=            Translate acf backend            =
=============================================*/

if(file_exists(dirname( __FILE__ ) . '/assets/translation/translate_da_DK.php')):
	include(dirname( __FILE__ ) . '/assets/translation/translate_da_DK.php');
endif;


/*=============================================
  = Render popup serverside instead of js =
===============================================*/
function bbh_build_popup($field) {
	// get welcome file path
	if(file_exists(STYLESHEETPATH . '/include/flexible-content/welcome/welcome.php')):
		$welcomePath = STYLESHEETPATH . '/include/flexible-content/welcome/welcome.php';
		$welcome     = get_stylesheet_directory_uri() . '/include/flexible-content/welcome/welcome.php';
	elseif(file_exists(STYLESHEETPATH . '/include/flexible-content/welcome/welcome.html')):
		$welcomePath = STYLESHEETPATH . '/include/flexible-content/welcome/welcome.html';
		$welcome     = get_stylesheet_directory_uri() . '/include/flexible-content/welcome/welcome.html';
	else:
		$welcomePath = plugin_dir_path(__FILE__) . 'assets/templates/welcome/welcome.php';
		$welcome     = plugin_dir_url(__FILE__) . 'assets/templates/welcome/welcome.php';
	endif;

	$descBase = get_stylesheet_directory_uri() . '/include/flexible-content/descriptions/';
	$descPath = STYLESHEETPATH . '/include/flexible-content/descriptions/';
	$imgBase = get_stylesheet_directory_uri() . '/include/flexible-content/images/';
	$imgPath = STYLESHEETPATH . '/include/flexible-content/images/';
	?>
	<div class="bbh-popup-overlay" data-key="<?php echo $field['_name'] ?>"></div>
	<div class="bbh-popup flex_content" data-key="<?php echo $field['_name'] ?>"  data-field-key="<?php echo $field['key']; ?>">
		<div class="popup-wrap">
			<div class="bbh-layout-menu">
				<div class="layout-menu-heading">
					<h3><?php _e('Vælg en sektion', 'bbh'); ?></h3>
				</div>
				<ul>
					<?php if (isset($field['layouts'])): ?>
						<?php foreach ($field['layouts'] as $key => $value): ?>
							<li>
								<a href="#" data-layout="<?php echo $value['name']; ?>" data-min="<?php echo $value['min'] ?>" data-max="<?php echo $value['max'] ?>"><?php echo $value['label'] ?></a>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
			<div class="layout-info">
				<div class="window-controls">
					<span class="modal-info layout-picker-info">
						<span class="dashicons-info active" data-layout="welcome-message"></span>
					</span>
					<span class="media-modal-close layout-picker-close">
						<span class="media-modal-icon"></span>
					</span>
				</div>
				<div class="layout-inner">
					<div class="single-layout welcome-message" data-layout="welcome-message">
						<div class="layout-description">
							<?php if (file_exists($welcomePath)): ?>
								<?php include($welcomePath); ?>
							<?php endif; ?>
						</div>
					</div>
					<?php if (isset($field['layouts'])): ?>

						<?php foreach ($field['layouts'] as $key => $value): ?>
							<div class="single-layout <?php echo $value['name']; ?>" data-layout="<?php echo $value['name']; ?>">
								<div class="layout-title">
									<h3 class="general-title"><?php _e('Tilføj sektionen', 'bbh'); ?>:</h3>
									<h3 class="layout-name"><?php echo $value['label'] ?></h3>
								</div>
								<div class="layout-description">
									<?php if (file_exists($descPath.$value['name'].'.php')): ?>
										<?php include($descPath.$value['name'].'.php'); ?>
									<?php endif; ?>
								</div>
								<div class="layout-image">
									<?php if (file_exists($imgPath.$value['name'].'.png')): ?>
										<img src="<?php echo $imgBase.$value['name'].'.png' ?>" alt="">
									<?php endif; ?>

								</div>
								<div class="add-layout">
									<a class="add-layout-button button-primary" href="" data-layout="<?php echo $value['name'] ?>"><?php _e('Tilføj sektion', 'bbh'); ?></a>
								</div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php
};



// initialize
new acf_plugin_columns();


// class_exists check
endif;
