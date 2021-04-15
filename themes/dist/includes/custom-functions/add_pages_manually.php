<?php
/**
 * Created by PhpStorm.
 * User: Daniela P.
 * Date: 30/10/18
 * Time: 14:08
 */
//this code runs on everyload
//you can delete the include form functions.php when you are done developing

//array of pages
//this will be used to check if the page exists as well
$array_pages = array(
    //example of how to add a page to array

    array(
        'page_title' => 'Front page',
        //leave empty if content is empty
        'page_content' => 'This is the front page',
        //leave empty if it does not uses a template
        'page_template' => 'page-templates/front-page.php'
    )
);

$array_pages_count = count($array_pages);
if (is_admin()) {
//if there are any pages to add
    if ($array_pages_count > 0) {
        for ($i = 0; $i < $array_pages_count; $i++) {

            $new_page_title = $array_pages[$i]['page_title'];
            $new_page_content = $array_pages[$i]['page_content'];
            $new_page_template = $array_pages[$i]['page_template']; //ex. template-custom.php. Leave blank if you don't want a custom page template.

            //don't change the code below, unless you know what you're doing
            $page_check = get_page_by_title($new_page_title);

            //if page does not exists
            if (!isset($page_check->ID)) {
                $new_page = array(
                    'post_type' => 'page',
                    'post_title' => $new_page_title,
                    'post_content' => $new_page_content,
                    'post_status' => 'publish',
                    'post_author' => 1
                );
                $new_page_id = wp_insert_post($new_page);
                if (!empty($new_page_template)) {
                    $a = update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
                }
            }
        }
    }
}


//set template for the Private policy page default from WP
$new_page_title = 'Privacy Policy';
$new_page_template = 'page-templates/privacy-policy.php'; //ex. template-custom.php. Leave blank if you don't want a custom page template.

//don't change the code below, unless you know what you're doing
$page_check = get_page_by_title($new_page_title);
//if page does not exists
if (isset($page_check->ID)) {
    $page_id = $page_check->ID;
    if (!empty($new_page_template)) {
        $a = update_post_meta($page_id, '_wp_page_template', $new_page_template);
    }
}