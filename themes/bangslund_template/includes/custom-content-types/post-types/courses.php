<?php
add_post_type_support( 'courses', 'thumbnail' );
function courses_posttype() {
register_post_type( 'courses',
// CPT Options
array(
    'labels' => array(
        'name'          => __( 'Courses', 'textdomain' ),
        'singular_name' => __( 'Course', 'textdomain' )
    ),
    'public'      => true,
    'has_archive' => true,
    'show_in_rest' => true,
    'menu_icon'   => 'dashicons-welcome-learn-more',
    'taxonomies'=> array('post_tag','category'),
)
);
}
// Hooking up our function to theme setup
add_action( 'init', 'courses_posttype' );