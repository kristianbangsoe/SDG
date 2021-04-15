<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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