<?php

function networks_posttype() {
    register_post_type( 'networks',
        // CPT Options
        array(
            'labels' => array(
                'name'          => __( 'Network', 'textdomain' ),
                'singular_name' => __( 'Network', 'textdomain' )
            ),
            'public'      => true,
            'has_archive' => true,
            'show_in_rest' => true,
            'menu_icon'   => 'dashicons-admin-site-alt3',
            'taxonomies'=> array('category'),
            'supports' => array('custom-fields')
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'networks_posttype' );

// Registrer custom table columns
add_filter( 'manage_networks_posts_columns', 'set_custom_edit_network_columns' );
add_action( 'manage_networks_posts_custom_column' , 'custom_network_column', 10, 2 );

function set_custom_edit_network_columns($columns) {
    unset( $columns['title'] );
    unset( $columns['date'] );
    unset( $columns['categories'] );
    $columns['name'] = __( 'Title', 'wordpress' );
    $columns['type'] = __( 'Type', 'wordpress' );
    $columns['categories'] = __( 'Kategorier', 'wordpress' );

    return $columns;
}

function custom_network_column( $column, $post_id ) {
    
    if ($column == 'name') { 
        echo get_field('name', $post_id);
    }

    if ($column == 'type') { 
        
        echo get_field('type', $post_id)['label'];
    }

}