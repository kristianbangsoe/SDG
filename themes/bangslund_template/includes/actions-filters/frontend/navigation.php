<?php
add_filter('wp_nav_menu', 'add_first_and_last', 10, 2);

/**
 * Adds classes to first and last items in navigation
 * @param $output
 * @param $args
 * @return mixed
 */
function add_first_and_last($output, $args) {
    if (is_object($args->walker)) {
        // If we are using a custom walker, do not apply below logic.
        return $output;
    }
    $output = preg_replace('/class="menu-item/', 'class="first-menu-item menu-item', $output, 1);
    if (substr_count($output, 'class="menu-item') == 0) {
        $output = preg_replace('/first-menu-item/', 'first-menu-item last-menu-item', $output, 1);
        return $output;
    }
    $output = substr_replace($output, 'class="last-menu-item menu-item', strripos($output, 'class="menu-item'), strlen('class="menu-item'));
    return $output;
}