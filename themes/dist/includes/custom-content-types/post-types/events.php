<?php
add_post_type_support( 'events', 'thumbnail' );
function events_posttype() {
register_post_type( 'events',
// CPT Options
array(
    'labels' => array(
        'name'          => __( 'Events', 'textdomain' ),
        'singular_name' => __( 'Event', 'textdomain' )
    ),
    'public'      => true,
    'has_archive' => true,
    'menu_icon'   => 'dashicons-calendar-alt',
    'taxonomies'=> array('post_tag','category'),
    'supports' => array('custom-fields', 'title', 'editor', 'author', 'thumbnail', 'excerpt'),
)
);
}
// Hooking up our function to theme setup
add_action( 'init', 'events_posttype' );