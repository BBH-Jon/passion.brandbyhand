<?php
/*-------------- Control panel hook -------------*/
add_action('wp_dashboard_setup', 'bbh_dashboard_hook');
function apicall() {
    $url = "https://brandbyhand.byhand.nu/wp-json/acf/v3/globalapi";

    $client = curl_init($url);
    curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
    $response = curl_exec($client);
    $results = json_decode($response);
    return $results;
}

function bbh_dashboard_hook() {
    global $wp_meta_boxes;
    $results = apicall();

    if ($results) {
      foreach ($results as $result) {
          if ($result === 'rest_no_route') return;
          $id = $result->id;
          $title = $result->acf->title;
          $content = $result->acf->textbox;
          wp_add_dashboard_widget($id, $title, function() use ( $content ) {
                 bbh_content( $content);
          });
      }
    }
}

function bbh_content($content) {
    echo $content;
}

/*-------------- Remove menu items -------------*/
add_action( 'admin_menu', 'bbh_remove_menus' );

function bbh_remove_menus() {
  remove_menu_page( 'edit-comments.php' );
}


/*-------------- Remove editor from pages -------------*/
add_action( 'admin_head', 'bbh_remove_content_editor', 11 );

function bbh_remove_content_editor() {
    // This will remove support for post thumbnails on ALL Post Types
    remove_post_type_support('page', 'editor');
}


/*-------------- Change login logo url -------------*/
add_filter( 'login_headerurl', 'custom_loginlogo_url' );

function custom_loginlogo_url($url) {
    return $_SERVER['SERVER_NAME'];
}


/*-------------- Remove toolbar nodes -------------*/
add_action( 'admin_bar_menu', 'bbh_remove_nodes', 999 );

function bbh_remove_nodes( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'comments' );
}

/*-------------- Move Yoast SEO metabox to low priority -------------*/
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');

function yoasttobottom() {
    return 'low';
}

/*-------------- Remove meta boxes -------------*/
add_action( 'after_setup_theme','bbh_remove_metaboxes' );

function bbh_remove_metaboxes() {
    remove_action('add_meta_boxes', 'generate_add_footer_widget_meta_box'); // Footer widgets
    remove_action( 'add_meta_boxes', 'generate_add_de_meta_box' ); // Deactivate elements
    remove_action('add_meta_boxes', 'generate_add_page_builder_meta_box' ); // Page builder integration
}

/*-------------- Remove layout meta box -------------*/
add_action( 'add_meta_boxes', 'bbh_remove_layout_meta_box', 999 );

function bbh_remove_layout_meta_box() {
    $post_types = get_post_types();
    foreach ( $post_types as $post_type ) :
        remove_meta_box('generate_layout_options_meta_box', $post_type, 'normal');
    endforeach;
}

/*-------------- Update image sizes -------------*/
//Use small for mobile, medium for tablet(1024), and large for desktop
add_action( 'after_setup_theme', 'bbh_image_sizes' );
function bbh_image_sizes(){
    add_image_size( 'small', '420', '9999', false );

    update_option( 'medium_size_w', 1024 );
    update_option( 'medium_size_h', 9999 );
    update_option( 'medium_crop', 0 );

    update_option( 'large_size_w', 1920 );
    update_option( 'large_size_h', 9999 );
    update_option( 'large_crop', 0 );

}
//Unset unused sizes
function remove_default_image_sizes( $sizes) {
    unset( $sizes['medium_large']);
    unset( $sizes['1536x1536']);
    unset( $sizes['2048x2048']);
    return $sizes;
    add_filter('intermediate_image_sizes_advanced', 'remove_default_image_sizes');
}

// disable other image sizes
function disableimage_sizes() {

	remove_image_size('1536x1536'); // disable any other added image sizes
	remove_image_size('2048x2048'); // disable images added via set_post_thumbnail_size()

}
add_action('init', 'disableimage_sizes');
// remove medium_large in it own way
add_filter( 'intermediate_image_sizes', function( $sizes )
{
    return array_filter( $sizes, function( $val )
    {
        return 'medium_large' !== $val; // Filter out 'medium_large'
    } );
} );
/*----------- delete original image after resizing is complete  -----------*/
function replace_uploaded_image($image_data) {
// if there is no large image : return
if (!isset($image_data['sizes']['large'])) return $image_data;

// paths to the uploaded image and the large image
$upload_dir = wp_upload_dir();
$uploaded_image_location = $upload_dir['basedir'] . '/' .$image_data['file'];
$large_image_location = $upload_dir['path'] . '/'.$image_data['sizes']['large']['file'];

// delete the uploaded image
unlink($uploaded_image_location);

// rename the large image
rename($large_image_location,$uploaded_image_location);

// update image metadata and return them
$image_data['width'] = $image_data['sizes']['large']['width'];
$image_data['height'] = $image_data['sizes']['large']['height'];
unset($image_data['sizes']['large']);

return $image_data;
}

add_filter('wp_generate_attachment_metadata','replace_uploaded_image');

/*-------------- remove wp shortlink -------------*/
add_filter('after_setup_theme', 'bbh_remove_shortlink');
function bbh_remove_shortlink() {
    // remove HTML meta tag
    remove_action('wp_head', 'wp_shortlink_wp_head', 10);
    // remove HTTP header
    remove_action( 'template_redirect', 'wp_shortlink_header', 11);
}
/*----------- disable wp lazyload -----------*/
add_filter('wp_lazy_loading_enabled', '__return_false');


/*=============================================
      = Add button checkbox to link modal =
===============================================*/
add_action( 'after_wp_tiny_mce', 'bbh_tinymce_button_checkbox');
function bbh_tinymce_button_checkbox(){
  ?>
  <script>
    var originalWpLink;
    // Ensure both TinyMCE, underscores and wpLink are initialized
    if ( typeof tinymce !== 'undefined' && typeof _ !== 'undefined' && typeof wpLink !== 'undefined' ) {
      // Ensure the #link-options div is present, because it's where we're appending our checkbox.
      if ( tinymce.$('#link-options').length ) {
        // Append our checkbox HTML to the #link-options div, which is already present in the DOM.
        tinymce.$('#link-options').append(<?php echo json_encode( '<div class="link-nofollow"><label><span></span><input type="checkbox" id="wp-link-class" />Show link as button (with border)</label></div>' ); ?>);
        // Clone the original wpLink object so we retain access to some functions.
        originalWpLink = _.clone( wpLink );
        wpLink.addClass = tinymce.$('#wp-link-class');
        // Override the original wpLink object to include our custom functions.
        wpLink = _.extend( wpLink, {
          /**
           * Fetch attributes for the generated link based on
           * the link editor form properties.
           *
           * In this case, we're calling the original getAttrs()
           * function, and then including our own behavior.
           */
          getAttrs: function() {
            var attrs = originalWpLink.getAttrs();
            attrs.class = wpLink.addClass.prop( 'checked' ) ? 'bbh-btn' : false;
            return attrs;
          },
          /**
           * Build the link's HTML based on attrs when inserting
           * into the text editor.
           *
           * In this case, we're completely overriding the existing
           * function.
           */
          buildHtml: function( attrs ) {
            var html = '<a href="' + attrs.href + '"';
            if ( attrs.target ) {
              html += ' target="' + attrs.target + '"';
            }
            if ( attrs.class ) {
              html += ' class="' + attrs.class + '"';
            }
            return html + '>';
          },
          /**
           * Set the value of our checkbox based on the presence
           * of the rel='nofollow' link attribute.
           *
           * In this case, we're calling the original mceRefresh()
           * function, then including our own behavior
           */
          mceRefresh: function( searchStr, text ) {
            originalWpLink.mceRefresh( searchStr, text );
            var editor = window.tinymce.get( window.wpActiveEditor )
            if ( typeof editor !== 'undefined' && ! editor.isHidden() ) {
              var linkNode = editor.dom.getParent( editor.selection.getNode(), 'a[href]' );
              if ( linkNode ) {
                wpLink.addClass.prop( 'checked', 'bbh-btn' === editor.dom.getAttrib( linkNode, 'class' ) );
              }
            }
          }
        });
      }
    }
  </script>
  <style>
  #wp-link #link-options .link-nofollow {
    padding: 3px 0 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  #wp-link #link-options .link-nofollow label span {
    width: 83px;
  }
  .has-text-field #wp-link .query-results {
    top: 223px !important;
  }
    input#wp-link-class {
        margin-right: 9px;
    }
    #wp-link .query-results {
        top: 206px;
    }

  </style>
  <?php
};


/*=============================================
          = Add wysiwyg editor styles =
===============================================*/

add_action( 'admin_init', 'bbh_custom_editor_style' );
function bbh_custom_editor_style() {
    add_editor_style( get_stylesheet_directory_uri() . '/assets/scss/wysiwyg.css' );
}

/*=============================================
          = Admin wyiwyg stylesheet =
===============================================*/
function bbh_custom_editor_styles() {
	add_editor_style('/assets/scss/wywisyg.css');
}

add_action('init', 'bbh_custom_editor_styles');
