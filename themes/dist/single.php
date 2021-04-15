<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bangslund
 */

get_header(); ?>

<?php
include __DIR__ . '/module-templates/builder.php';
?>

<?php
get_sidebar();
get_footer();