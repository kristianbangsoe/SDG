<?php
add_action('admin_init', 'remove_unnecessary_admin_pages');
add_action('admin_menu', 'add_custom_admin_pages');

/**
 * Removing unnecessary admin pages which are not used for the theme.
 */
function remove_unnecessary_admin_pages() {
    if (!defined( 'DOING_AJAX' ) || !DOING_AJAX) {
        remove_submenu_page('themes.php', 'theme-editor.php');
        remove_menu_page('edit-comments.php');
    }
}

/**
 * Adds custom pages to the backend navigation
 */
function add_custom_admin_pages() {
    // Adds a logo page to the navigation under "appearance"
    add_theme_page('Logos', 'Logos', 'administrator', 'logos', function() {
        if(isset($_POST['submit'])) {
            // Form has been submitted, save the settings meta. Input will be escaped by WP
            update_option("theme_logo", $_POST['theme_logo']);
            update_option("theme_backend_logo", $_POST['theme_backend_logo']);
        }

        require_once __DIR__ . '/../../../module-templates/backend/theme_logo_upload.php';
    });

    // Adds a analytics page to the navigation under "settings"
//    add_options_page('Analytics', 'Analytics', 'manage_options', 'edit-analytics', function() {
//        if(isset($_POST['submit'])) {
//            // Form has been submitted, save the settings meta. Input will be escaped by WP
//            update_option("theme_analytics", $_POST['theme_analytics']);
//        }
//
//        require_once __DIR__ . '/../../../module-templates/backend/analytics.php';
//    });

}