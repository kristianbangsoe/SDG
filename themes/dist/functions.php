<?php
/**
 * html24 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package html24
 */
/**
 * Requires all actions and filters
 */
require_once 'includes/actions-filters/backend/login.php';
require_once 'includes/actions-filters/backend/navigation.php';
require_once 'includes/actions-filters/backend/file_upload.php';
require_once 'includes/actions-filters/backend/theme_support.php';
require_once 'includes/actions-filters/backend/disable_heartbeat.php';
require_once 'includes/actions-filters/backend/hide_wp_version.php';

require_once 'includes/actions-filters/frontend/header.php';

/**
 * Requires AJAX related methods
 */
require_once 'includes/ajax/method_handler.php';

/**
 * Requires all WordPress plugins
 */
require_once 'includes/plugins/acf-config.php';

/**
 * Requires/enqueues all scripts and styles
 */
require_once 'includes/enqueues/backend/styles.php';
require_once 'includes/enqueues/backend/scripts.php';

require_once 'includes/enqueues/frontend/styles.php';
require_once 'includes/enqueues/frontend/scripts.php';

/**
 * Requires all methods
 */
require_once 'includes/modules/helpers.php';
require_once 'includes/modules/analytics.php';


//keep this file nice and organized
//do not add functions here but make a file for it and include it here
/**
 * Custom functions here
 */
require_once 'includes/custom-functions/user_function.php';

//include this only if you want to be able to use the function
//this will create a frontpage for you automatically when you start a new project
require_once 'includes/custom-functions/add_pages_manually.php';
require_once 'includes/custom-content-types/post-types/projects.php';

require_once 'includes/custom-content-types/post-types/events.php';
require_once 'includes/custom-content-types/post-types/user.php';
require_once 'includes/custom-content-types/post-types/courses.php';
require_once 'includes/custom-content-types/post-types/workshops.php';

require_once 'includes/custom-content-types/post-types/networks.php';



function wporg_simple_role_caps() {
    // Gets the simple_role role object.
    $subscriber = get_role( 'subscriber' );
 
    // Add a new capability.

    $subscriber->add_cap( 'publish_projects', false );
    $subscriber->add_cap( 'edit_projects', true ); 
    $subscriber->add_cap( 'edit_others_projects', false ); 
    $subscriber->add_cap( 'delete_projects', false ); 
    $subscriber->add_cap( 'delete_others_projects', false ); 
    $subscriber->add_cap( 'read_private_projects', false ); 
    $subscriber->add_cap( 'edit_project', true ); 
    $subscriber->add_cap( 'delete_project', false ); 
    $subscriber->add_cap( 'read_project', true ); 
    $subscriber->add_cap( 'upload_files', true );
    $subscriber->add_cap( 'edit_published_projects', false );


    $subscriber = get_role( 'administrator' );
 
    // Add a new capability.

    $subscriber->add_cap( 'publish_projects', true );
    $subscriber->add_cap( 'edit_projects', true ); 
    $subscriber->add_cap( 'edit_others_projects', true ); 
    $subscriber->add_cap( 'delete_projects', true ); 
    $subscriber->add_cap( 'delete_others_projects', true ); 
    $subscriber->add_cap( 'read_private_projects', true ); 
    $subscriber->add_cap( 'edit_project', true ); 
    $subscriber->add_cap( 'delete_project', true ); 
    $subscriber->add_cap( 'read_project', true ); 
    $subscriber->add_cap( 'upload_files', true );
    $subscriber->add_cap( 'edit_published_projects', true );
     
    
}
 
// Add simple_role capabilities, priority must be after the initial role definition.
add_action( 'init', 'wporg_simple_role_caps', 11 );



// Limit media library access
  
add_filter( 'ajax_query_attachments_args', 'wpb_show_current_user_attachments' );
 
function wpb_show_current_user_attachments( $query ) {
    $user_id = get_current_user_id();
    if ( $user_id && !current_user_can('activate_plugins') && !current_user_can('edit_others_posts
') ) {
        $query['author'] = $user_id;
    }
    return $query;
} 


// add_action('init', 'cng_author_base');
// function cng_author_base() {
//     global $wp_rewrite;
//     $author_slug = 'profile'; // change slug name
//     $wp_rewrite->author_base = $author_slug;
// }



$user = wp_get_current_user();
if ( in_array( 'subscriber', (array) $user->roles ) ) {
    remove_action("admin_color_scheme_picker", "admin_color_scheme_picker");

    // Diss allow H1 tags
    function my_format_TinyMCE( $in ) {
        $in['block_formats'] = "Paragraph=p; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6;Preformatted=pre";
        return $in;
    }

    add_filter( 'tiny_mce_before_init', 'my_format_TinyMCE' );
    // removes the `profile.php` admin color scheme options
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
}

// Generate random username

function my_random_string($args = array()){

    $defaults = array(  // Set some defaults for the function to use
        'characters'    => '0123456789',
        'length'        => 10,
        'before'        => '',
        'after'         => '',
        'echo'          => false
    );
    $args = wp_parse_args($args, $defaults);    // Parse the args passed by the user with the defualts to generate a final '$args' array

    if(absint($args['length']) < 1) // Ensure that the length is valid
        return;

    $characters_count = strlen($args['characters']);    // Check how many characters the random string is to be assembled from
    for($i = 0; $i <= $args['length']; $i++) :          // Generate a random character for each of '$args['length']'

        $start = mt_rand(0, $characters_count);
        $random_string = substr($args['characters'], $start, 1);

    endfor;

    $random_string = $args['before'] . $random_string . $args['after']; // Add the before and after strings to the random string

    if($args['echo']) : // Check if the random string shoule be output or returned
        echo $random_string;
    else :
        return $random_string;
    endif;

}

function additional_admin_color_schemes() {
    wp_admin_css_color( 'sdg', __( 'SDG' ),
        get_stylesheet_directory_uri().'/wp-content/themes/bangslund_template/dist/css/backend.css',
        [ '#E5E5E5', '#194a6b', '#d35a24', '#f26a2c' ]
    );
}
add_action( 'admin_init', 'additional_admin_color_schemes' );

function set_default_admin_color($user_id) {
    $args = array(
      'ID' => $user_id,
      'admin_color' => 'sdg'
    );
    wp_update_user( $args );
  }
  add_action('user_register', 'set_default_admin_color');

