<?php
function create_news_cpt() {
    $cpt = 'news';
    $cpt_singular = 'Nyhed';
    $cpt_plural = 'Nyheder';

    $labels = array(
        'add_new_item' => __('Tilføj ny '.$cpt_singular,'bbh'),
        'add_new' => __( 'Tilføj ny','bbh'),
        'all_items' => __('Alle '.$cpt_plural ,'bbh'),
        'edit_item' => __('Rediger '.$cpt_singular,'bbh'),
        'name' => __($cpt_singular,'bbh'),
        'name_admin_bar' => __($cpt_singular,'bbh'),
        'new_item' => __('Ny '.$cpt_singular,'bbh'),
        'not_found' => __('Ingen '.$cpt_singular.' fundet','bbh'),
        'not_found_in_trash' => __('Ingen '.$cpt_plural .' fundet i papirkurv','bbh'),
        'parent_item_colon' => __('Forældre '.$cpt_singular,'bbh'),
        'search_items' => __('Søg '.$cpt_plural ,'bbh'),
        'view_item' => __('Se '.$cpt_singular,'bbh'),
        'view_items' => __('Se '.$cpt_plural ,'bbh'),
        'menu_name' => __($cpt_plural, 'bbh')
    );
    $args = array(
        'labels' => $labels,
        'supports' => array( 'editor', 'thumbnail', 'title' ),
        'taxonomies' => array('category'),
        'menu_icon' => 'https://developer.wordpress.org/resource/dashicons/#admin-comments',
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 20,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'hierarchical' => true,
    'exclude_from_search' => false,
    'show_in_rest' => true,
    'publicly_queryable' => true,
    'capability_type' => 'post',
    );
    register_post_type($cpt, $args);
}
add_action( 'init', 'create_news_cpt', 0 );


function create_ebook_cpt() {
    $cpt = 'ebook';
    $cpt_singular = 'E-book';
    $cpt_plural = 'E-books';

    $labels = array(
        'add_new_item' => __('Tilføj ny '.$cpt_singular,'bbh'),
        'add_new' => __( 'Tilføj ny','bbh'),
        'all_items' => __('Alle '.$cpt_plural ,'bbh'),
        'edit_item' => __('Rediger '.$cpt_singular,'bbh'),
        'name' => __($cpt_singular,'bbh'),
        'name_admin_bar' => __($cpt_singular,'bbh'),
        'new_item' => __('Ny '.$cpt_singular,'bbh'),
        'not_found' => __('Ingen '.$cpt_singular.' fundet','bbh'),
        'not_found_in_trash' => __('Ingen '.$cpt_plural .' fundet i papirkurv','bbh'),
        'parent_item_colon' => __('Forældre '.$cpt_singular,'bbh'),
        'search_items' => __('Søg '.$cpt_plural ,'bbh'),
        'view_item' => __('Se '.$cpt_singular,'bbh'),
        'view_items' => __('Se '.$cpt_plural ,'bbh'),
        'menu_name' => __($cpt_plural, 'bbh')
    );
    $args = array(
        'labels' => $labels,
        'supports' => array( 'editor', 'thumbnail', 'title' ),
        'taxonomies' => array('category'),
        'menu_icon' => 'https://developer.wordpress.org/resource/dashicons/#admin-comments',
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 20,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'hierarchical' => true,
    'exclude_from_search' => false,
    'show_in_rest' => true,
    'publicly_queryable' => true,
    'capability_type' => 'post',
    );
    register_post_type($cpt, $args);
}
add_action( 'init', 'create_ebook_cpt', 0 );
