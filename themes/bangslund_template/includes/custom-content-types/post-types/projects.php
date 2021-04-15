<?php
function create_posttype() {
    register_post_type( 'projects',
        // CPT Options
        array(
            'labels' => array(
                'name'          => __( 'Projects', 'textdomain' ),
                'singular_name' => __( 'Project', 'textdomain' )
            ),
            'public'      => true,
            'has_archive' => true,
            'menu_icon'   => 'dashicons-universal-access-alt',
            'taxonomies'=> array('author'),
            'show_in_rest' => true,
            'taxonomies'=> array('category'),
            'supports' => array('custom-fields', 'title', 'editor', 'author', 'thumbnail', 'excerpt'),
            'rewrite' => array(
                'slug' => 'projects',
                'feeds' => false
            ),
            'capability_type' => 'projects',
			'capabilities' => array(
				'publish_posts' => 'publish_projects',
				'edit_posts' => 'edit_projects',
				'edit_others_posts' => 'edit_others_projects',
				'delete_posts' => 'delete_projects',
				'delete_others_posts' => 'delete_others_projects',
				'read_private_posts' => 'read_private_projects',
				'edit_post' => 'edit_project',
				'delete_post' => 'delete_project',
                'read_post' => 'read_project',
                'upload_files' => 'upload_files',
                'edit_published_posts' => 'edit_published_projects'
			),
            //'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );


function mycustomname_links($post_link, $post) {
    if($post->post_type === 'projects') {
        return home_url('projects/' . $post->ID . '/');
    }
    else{
        return $post_link;
    }
}
add_filter('post_type_link', 'mycustomname_links', 1, 3);


function mycustomname_rewrites_init(){
    add_rewrite_rule('projects/([0-9]+)?$', 'index.php?post_type=projects&p=$matches[1]', 'top');
}
add_action('init', 'mycustomname_rewrites_init');