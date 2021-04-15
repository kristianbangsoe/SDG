<?php
/**
 * Gets the id of an attachment by the attachment guid
 *
 * @param string $guid
 * @return int attachment_id|null
 */
function get_attachment_id_by_guid($guid) {
    global $wpdb;
    $attachment_id = $wpdb->get_row($wpdb->prepare("SELECT ID FROM ".$wpdb->prefix."posts WHERE guid = %s", $guid));

    if(isset($attachment_id) && $attachment_id->ID){
        return (int)$attachment_id->ID;
    }
    return null;
}

/**
 * Get the current theme logo via wp_get_attachment_image_src
 *
 * @param string $size Optional, default is 'full'.
 * @param bool $icon Optional, default is false. Whether it is an icon.
 * @return bool|array Returns an array (url, width, height), or false, if no image is available.
 */
function get_theme_logo($size='full', $icon = false) {
    $attachment_id = get_attachment_id_by_guid(get_option("theme_logo"));
    return wp_get_attachment_image_src($attachment_id, $size, $icon);
}


function excerpt($limit, $title) {
    $excerpt = explode(' ', $title, $limit);
    if (count($excerpt)>=$limit) {
      array_pop($excerpt);
      $excerpt = implode(" ",$excerpt).'...';
    } else {
      $excerpt = implode(" ",$excerpt);
    }	
    $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
    echo $excerpt;
  }