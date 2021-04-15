<?php
/**
 * Register and load any scripts your themes backend requires.
 */
add_action('admin_enqueue_scripts', function () {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');

    wp_enqueue_script( 'backend-js', get_template_directory_uri() . '/js/backend.js', array( 'jquery' ) );
});