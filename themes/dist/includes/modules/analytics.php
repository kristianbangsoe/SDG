<?php
/**
 * Function that prints the tracking code inserted in the theme settings
 * Strips the slashes that were added when inserting the code to the
 * database
 */
function get_header_analytics_tracking_code() {
    //get value without p tags
    $tracking_code_header = get_field('header_analytics_script', 'option', false);

    if($tracking_code_header) {
        return stripslashes($tracking_code_header)."\n";
    }
    return '';
}

function get_body_analytics_tracking_code() {
    //get value without p tags
    $tracking_code_body = get_field('analytics_script_body', 'option', false);

    if($tracking_code_body) {
        return stripslashes($tracking_code_body)."\n";
    }
    return '';
}


function get_footer_analytics_tracking_code() {
    //get value without p tags
    $tracking_code_footer = get_field('footer_scripts', 'option', false);

    if($tracking_code_footer) {
        return stripslashes($tracking_code_footer)."\n";
    }    
    return '';
}