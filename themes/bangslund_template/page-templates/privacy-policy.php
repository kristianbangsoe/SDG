<?php /* Template Name: Privacy policy */
/**
 * Created by PhpStorm.
 * User: Daniela P.
 * Date: 30/10/18
 * Time: 14:03
 */?>
<?php
get_header();
$pageTitle = get_the_title();

?>
    <div class="container">
        <h1 class="my-5 text-uppercase"> <?php echo $pageTitle; ?></h1>

        <?php

        if (have_posts()) {
            while (have_posts()) {
                the_post();
                //
                // Post Content here
                //
                the_content();

            } // end while
        } // end if


        ?>
    </div>


<?php
get_footer();