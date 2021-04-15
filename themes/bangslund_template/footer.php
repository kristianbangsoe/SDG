<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package html24
 */
?>

    </div><!-- #content -->
</div><!-- #page -->

<footer class="bg-gray py-5">
    <!--    this will include the script that is added to Settings-> Footer Analytics-->
    <?php echo get_footer_analytics_tracking_code(); ?>
    <?php wp_footer(); ?>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12 col-lg-3">
                <div class="logo-2">
                    <img src="<?=get_field('logo', 'options');?>" alt="Logo">
                    <address class="mt-3">
                        <?=get_field('address', 'options');?>
                    </address>
                </div>
            </div>
            
            <?php

            // check if the repeater field has rows of data
            if( have_rows('menu_tab', 'options') ):

                // loop through the rows of data
                while ( have_rows('menu_tab', 'options') ) : the_row();
                ?>
                    <div class="col-md-3 mt-md-0 mt-4 footer-nav-item">
                        <h2 class="h3 font-weight-bold"><?=get_sub_field('menu_tab_title')?></h2>
                        <div class="divider my-3"></div>
                        <ul>
                        <?php

                        // check if the repeater field has rows of data
                        if( have_rows('links', 'options') ):

                            // loop through the rows of data
                            while ( have_rows('links', 'options') ) : the_row();
                            $pageUrl = get_sub_field('select_page');
                            
                            ?>
                                <li class="mb-2"><a href="<?= get_permalink($pageUrl->ID)?>"><?= $pageUrl->post_title?></a></li>
                            <?php
                            endwhile;
                        endif;

                        ?>
                            
                        </ul>
                    </div>
                <?php
                endwhile;
            endif;
            ?>
        </div>
    </div>
</footer>
</body>
</html>