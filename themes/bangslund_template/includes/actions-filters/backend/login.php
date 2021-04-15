<?php
// Changes the link of the login logo to the blog url
add_filter('login_headerurl', 'change_login_logo_url_to_blog_url');
// Add a custom logo to the login page if one is selected
add_action('login_head', 'add_theme_logo_to_login_page');

/**
 * Setting up the backend to use the custom admin image if there is one.
 * If the user hasn't uploaded a custom image, the default wp logo will be used
 */
function add_theme_logo_to_login_page() {

    $backend_theme_logo = get_option('theme_backend_logo');

    if( $backend_theme_logo ) :

        // Get the attachment id of the custom image
        $attachment_id = get_attachment_id_by_guid( $backend_theme_logo );

        $attachment_image_array = wp_get_attachment_image_src($attachment_id, 'medium');

        ?>

        <style>
            body.login #login h1 a {
                background: url('<?php echo $attachment_image_array[0]; ?>') no-repeat scroll center top transparent;
                height: <?php echo $attachment_image_array[2]; ?>px;
                width: <?php echo $attachment_image_array[1]; ?>px;
            }
        </style>

    <?php endif;
};

/**
 * Changes the link of the login logo to the blog url
 *
 * @return string|void
 */
 function change_login_logo_url_to_blog_url() {
     return get_bloginfo('url');
 }