<?php
/**
 * We add this functionality to disable the WP Heartbeat API so it doesn't
 * overloads the traffic on the server.
 *
 * (From Wordpress 3.6)
 */

add_action( 'init', 'stop_heartbeat', 1 );
function stop_heartbeat() {
    wp_deregister_script('heartbeat');
}