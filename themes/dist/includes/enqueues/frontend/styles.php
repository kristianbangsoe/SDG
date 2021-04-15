<?php
/**
 * Last modified 30/10/2018 by Daniela
 * Register and load any stylesheets your themes frontend requires.
 * I have removed jquery.bxslider as we do not use it often
 * Remember to use the min file when you go live with the project
 */
add_action('wp_enqueue_scripts', function () {
    
    wp_enqueue_style('bootstrap-4-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css');

    wp_enqueue_style( 'frontend-css', get_template_directory_uri() . "/css/frontend.css", array(), filemtime( plugin_dir_path( __FILE__ )));
    

    //wp_enqueue_style( 'table-css', "https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css", array(), '1.0.0');
    
});