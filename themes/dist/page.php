<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package html24
 */

get_header(); ?>

<?php
include __DIR__ . '/module-templates/builder.php';

?>
<div class="container my-5 py-5">
   <div class="row">
        <div  class="col-md-6 mx-auto">

       <div style="font-size:14px; line-height: 24px;">
       <?php 


         while ( have_posts() ) : the_post();
         the_content();
         endwhile;

         ?>
       </div>
        </div>
   </div>
</div>

<?php
get_sidebar();
get_footer();