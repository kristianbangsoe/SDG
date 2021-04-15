<?php
/**
 * Register and load any stylesheets your themes backend requires.
 */
add_action('admin_init', function ()
{
    wp_enqueue_style('thickbox'); // Used for media uploader

    wp_enqueue_style( 'backend-css', get_template_directory_uri() . "/css/backend.css", array(), '1.0.2');
});