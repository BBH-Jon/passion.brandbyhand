<?php
/**
 * Generate child theme functions and definitions
 *
 * @package Generate
 */

/*=================================================
=         Enqueue all files from folder           =
=================================================*/
// Standard files
foreach(glob(get_theme_file_path() . "/include/standards/*.php") as $file){
	require $file;
}
// Custom files
foreach(glob(get_theme_file_path() . "/include/functions/*.php") as $file){
	require $file;
}

add_action('admin_head', 'bbh_menu_style'); // admin_head is a hook bbh_menu_style is a function we are adding it to the hook
function bbh_menu_style() {
  echo '<style>
    #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, #adminmenu li.current a.menu-top, .folded #adminmenu li.wp-has-current-submenu, .folded #adminmenu li.current.menu-top, #adminmenu .wp-menu-arrow, #adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head{
        background: #4c5c64;
    }
	#adminmenu .wp-submenu a {
		color: rgba(240,246,252,.7);
	}
	.wp-core-ui .button-primary {
		background: #4c5c64;
		background-image: unset;
		border-color: #4c5c64;
	}
	.wp-core-ui .button-primary:hover {
		background: #4c5c64;
		border-color: #4c5c64;
	}
  </style>';
}

add_filter('wpforo_editor_settings', function($s){
   $s['tinymce']['content_style'] .= "body{background-color:#ccffcc; color:#000000;}";
   return $s;
});
