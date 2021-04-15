<?php /* Template Name: About us */
get_header();  ?>

<section class="hero-section">
    <div class="container-fluid">
        <div class="col px-0 px-sm-auto">
            <div style="--hero-image: url('<?= the_post_thumbnail_url() ?>')" class="bg-image">
                <div style="height: 400px;" class="hero-wrapper text-white py-5 px-4 px-md-5 d-flex align-items-center">
                    <div class="w-100 fadeInUp text-center">

                        <h1 class="hero_title">
                            <?= get_the_title() ?>
                        </h1>
                        <div class="tagline h5 my-4 font-weight-light">
                            <?= get_sub_field('description') ?>
                        </div>
                        <div class="d-flex flex-md-row flex-column pt-4">
                            <?php if (get_sub_field('button_1_link') != '') {
                                echo '<a class="btn mr-md-3 mr-0  btn-primary" href="' . get_sub_field('button_1_link') . '">' . get_sub_field('button_1_text') . '</a>';
                            }
                            if (get_sub_field('button_2_link') != '') {
                                echo '<a class="btn mr-md-3 mr-0 mt-md-0 mt-3 btn-bordered" href="' . get_sub_field('button_2_link') . '">' . get_sub_field('button_2_text') . '</a>';
                            } ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


        <?php


        while (have_posts()) : the_post();
            the_content();
        endwhile;

        ?>


<?php
get_footer();
