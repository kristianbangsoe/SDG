<?php
add_post_type_support( 'workshops', 'thumbnail' );
function workshops_posttype() {
register_post_type( 'workshops',
// CPT Options
array(
    'labels' => array(
        'name'          => __( 'Workshops', 'textdomain' ),
        'singular_name' => __( 'Workshop', 'textdomain' )
    ),
    'public'      => true,
    'has_archive' => true,
    'show_in_rest' => true,
    'menu_icon'   => 'dashicons-lightbulb',
    'taxonomies'=> array('post_tag','category'),
)
);
}
// Hooking up our function to theme setup
add_action( 'init', 'workshops_posttype' );