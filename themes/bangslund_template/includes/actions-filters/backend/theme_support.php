<?php
add_action( 'after_setup_theme', 'set_theme_support' );

/**
 * Configures the theme support
 */
function set_theme_support() {
    
    // Register the primary menu
    register_nav_menu( 'primary', 'Main Navigation');
    
    // Adds theme support for post thumbnails
    add_theme_support( 'post-thumbnails' );

    // Localisation Support for string translating
    load_theme_textdomain('SDG', get_template_directory() . '/languages');
    add_post_type_support( 'page', 'excerpt' );

    // Register the primary menu
    register_nav_menu( 'secondary', 'Top navigation');
    
}