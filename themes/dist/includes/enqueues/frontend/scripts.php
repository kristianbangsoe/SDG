<?php
/**
 * Last modified 30/10/2018 by Daniela
 * Register and load any scripts your themes frontend requires.
 * I have removed jquery.bxslider as we do not use it often
 * !!!!! Remember to add the forth parameter to true so the link will be added in the footer!!!!!
 * Remember to use the min file when you go live with the project
 */
add_action('wp_enqueue_scripts', function () {

    wp_enqueue_script('pooper.js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js', array(), null, true);

    wp_enqueue_script('fontawesome', 'https://kit.fontawesome.com/aeff03dac8.js', array(), null, true);

    wp_enqueue_script('fontawesome', 'https://kit.fontawesome.com/aeff03dac8.js', array(), null, true);

    // wp_enqueue_script('waypoints', 'https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js', array(), null, true);
    // wp_enqueue_script('infinite', 'https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/shortcuts/infinite.js', array(), null, true);

  

    wp_enqueue_script('bootstrap-4-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js', array(), null, true);
    //wp_enqueue_script('bootstrap-table', 'https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js', array(), null, true);
    
    wp_enqueue_script( 'frontend-js', get_template_directory_uri() . '/js/frontend.js', array( 'jquery'), '1.0.1', true );



    // We add the admin url into a variable and into the frontend-js file
    //Use "AjaxMethodsUrl" as link in do_ajax method
    //eg: do_ajax(AjaxMethodsUrl, data, callback);
    wp_localize_script('frontend-js', 'RootUrl', array( 'url' => get_template_directory_uri()));

    wp_localize_script('frontend-js', 'AjaxMethodsUrl',  admin_url( 'admin-ajax.php' ));
});