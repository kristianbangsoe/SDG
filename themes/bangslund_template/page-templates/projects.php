<?php /* Template Name: Projekter */
get_header();

$args = array(
    'type'                     => 'projects',
    'child_of'                 => 1,
    'parent'                   => '',
    'orderby'                  => 'name',
    'order'                    => 'ASC',
    'hide_empty'               => 0,
    'hierarchical'             => 1,
    'pad_counts'               => false
);
$categories = get_categories($args);

if (isset($_GET['category'])) {

    $selectedCat = $_GET['category'];
    $selectedCatObj = get_category_by_slug($selectedCat);
    $presel = get_field('sdg_id', get_term($selectedCatObj->term_id));
}


?>

<section class="hero-section hero-2">

    <div class="col px-0 px-sm-auto">
        <div style="--hero-image: url('<?= get_the_post_thumbnail_url($post, 'large') ?>')" class="bg-image">
            <div class="hero-wrapper container-fluid text-white pt-5  d-flex align-items-center">
                <div class="row">
                    <div class="col-lg-12 col-md-8 col-12 pb-5 mt-5 fadeInUp">
                        <h1 class="hero_title mt-5 h2">
                            <?= get_the_title() ?>
                        </h1>
                        <?php if (get_the_excerpt() == null) : ?>
                            <div class="tagline h5 my-4 font-weight-light">
                                <?= get_the_excerpt() ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<section id="project-feed-container">
    <div class="container-fluid">
        <div class="bg-sceondary position-relative mb-5 mt-n5 pb-4 pt-5">
            <div class="row">
                <div class="col">
                    <div class="px-5">
                        <form id="project_filtering">
                            <div class="form-row">
                                <div class="form-group mr-4">
                                    <label for="inputMunicipality"><?= __('Region / Kommune', 'sdg') ?></label>
                                    <select id="inputMunicipality" class="form-control">
                                        <option value="0"><?= __('Vis alle områder', 'sdg') ?></option>
                                        <optgroup label="<?= __('Regioner', 'sdg') ?>">
                                            <?php
                                            // Get regions as first items
                                            // $regions = reg();
                                            $regField = get_field_object('regions', 'options');
                                            $regChoices = $regField['choices'];

                                            foreach ($regChoices as $key => $value) {
                                                if ($key !== 0) {
                                                    echo '<option value="region_' . $key . '">' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        </optgroup>
                                        <optgroup label="<?= __('Kommuner', 'sdg') ?>">
                                            <?php
                                            // Get communes
                                            //$commune = com();
                                            $comField = get_field_object('field_5efb8ecc9f9c9', 'options');
                                            $comChoices = $comField['choices'];
                                            foreach ($comChoices as $key => $value) {
                                                if ($key !== 0) {

                                                    echo '<option value="commune_' . $key . '">' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                    </select>
                                </div>
                                <div class="form-group mr-4">
                                    <label for="inputSdg"><?= __('Vælg verdensmål', 'sdg') ?></label>
                                    <select id="inputSdg" class="form-control">
                                        <?php

                                        if (!isset($selectedCat)) {
                                            echo '<option value="0" selected>' . __('Viser alle', 'sdg') . '</option>';
                                        } else {
                                            echo '<option value="0">' . __('Viser alle', 'sdg') . '</option>';
                                        }
                                        foreach ($categories as $category) {
                                            $url = get_term_link($category);
                                            $term = get_queried_object($category);
                                            $sdgImageId = get_field('sdg_id', get_term($category->cat_ID));
                                            // var_dump($sdgImageId);
                                            if ($presel == $sdgImageId) {
                                                echo '<option selected value="' . $category->cat_ID . '">' . $category->name . '</option>';
                                            } else {
                                                echo '<option value="' . $category->cat_ID . '">' . $category->name . '</option>';
                                            }
                                        ?>


                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group mr-4">
                                    <label for="inputCompanyType"><?= __('Vælg virksomheds type', 'sdg') ?></label>
                                    <select name="company_type" id="inputCompanyType" class="form-control">
                                        <option value="0"><?= __('Vis alle typer', 'sdg') ?></option>
                                        <?php
                                        if (have_rows('company_types', 'options')) :
                                            while (have_rows('company_types', 'options')) : the_row();
                                                $sub_value = get_sub_field('virksomheds_type');

                                                echo '<option value="' . $sub_value . '">' . $sub_value . '</option>';
                                            endwhile;
                                        else :
                                        endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputsSearch"><?= __('Søg', 'sdg') ?></label>
                                    <input type="search" placeholder="<?= __('Søg efter navn, mål…', 'sdg') ?>" class="form-control" id="inputsSearch">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div id="projects_feed" class="row">
            <!--CONTENT APPENDS HERE-->
        </div>
    </div>
    <div id="buttom-hit" class="container">
        <div class="d-flex flex-column row">
            <img class="content-spinner" src="/wp-content/themes/dist/img/sdg-circle.svg" alt="LOADING">
            <div class="no_results pb-3 col">
                <p class="response-1"><?= __('Der er desværre ingen projekter der matcher dine søgekriterier', 'sdg') ?></p>
                <p class="response-2"><?= __('Der er desværre ikke flere projekter at se :-(', 'sdg') ?></p>

            </div>
        </div>
    </div>
</section>

<?php
get_footer();
