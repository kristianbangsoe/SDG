<?php
add_filter('wp_handle_upload_prefilter', 'remove_special_characters_on_file_upload' );

/**
 * Strip special characters from uploaded file names
 * Attempt to convert danish special characters before stripping them
 */
function remove_special_characters_on_file_upload($file)
{
    // Get lowercased filename
    $filename = mb_strtolower($file['name']);

    // Convert spaces to undercores (collapse multiple spaces to a single underscore)
    $filename = preg_replace("/[\s]+/u", "-", $filename);

    // Convert danish special characters
    $filename = preg_replace("/[æ]/u", "ae", $filename);
    $filename = preg_replace("/[ø]/u", "oe", $filename);
    $filename = preg_replace("/[å]/u", "aa", $filename);

    // Strip remaining special characters
    $filename = preg_replace("/[^a-z0-9\._-]/u", "_", $filename);

    $file['name'] = $filename;

    return $file;
}