<?php

/**
 * The template for displaying all single projects
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bangslund
 */

// Get post author
$user_obj = get_userdata($post->post_author);
$user_obj->ID;

$user_meta = get_user_meta($user_obj->data->ID);
$sdg_logo = get_field('logo', 'user_' . $user_obj->ID);
$company_name = get_field('name', 'user_' . $user_obj->ID);
$description = get_field('description_2', 'user_' . $user_obj->ID);
$user_logo = $sdg_logo != null ? '<img id="aside-logo" src="' . $sdg_logo['url'] . '" alt="' . $sdg_logo['alt'] . '">' : $company_name;
$category_id = get_field('main_goal');
$sub_categories = get_field('related_goal');
$category = get_category($category_id);
$project_location = get_field('project_location');
$profil_image = get_field('profil_billede');
$sdg_addresse = get_field('addresse', 'user_' . $user_obj->ID);
get_header(); ?>
<pre> <?php// print_r($user_obj)?></pre>
<div id="sidebar-layout" class="bg-gray py-5">
    <section class="container">
        <div class="row">
            <article class="article-wrapper col-md-8 bg-white">
                <div class="bg-white">
                    <div id="slider-indicator" class="carousel slide row" data-ride="carousel">
                        <div class="carousel-indicators">
                            <?php
                            $images = get_field('billeder');
                            if ($images) : $i = 0; ?>
                                <?php foreach ($images as $image) : $i++; ?>
                                    <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" data-target="#slider-indicator" data-slide-to="<?= $i - 1 ?>" class="<?= $i == 1 ? 'active' : ''; ?>"></img>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <div class="carousel-inner">
                            <?php

                            if ($images) : $i = 0; ?>
                                <?php foreach ($images as $image) : $i++; ?>
                                    <div class="carousel-item <?= $i == 1 ? 'active' : ''; ?>">
                                        <img class="d-block w-100" src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                        <p><?php echo esc_html($image['caption']); ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <a class="carousel-control-prev" href="#slider-indicator" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#slider-indicator" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <div class="content px-4 py-5">
                        <?= the_content() ?>
                    </div>
                </div>
            </article>
            <aside class="sidebar col-md-4">
                <div class="bg-white h-100">
                    <div class="p-4">
                        <div>
                            <?= $user_logo ?>
                            <h2 class="aside-title mt-2 mb-1"><?= $company_name ?></h2>
                        </div>
                        <div>
                            <p class="mb-1">
                                <?= excerpt(25, strip_tags($user_meta['description'][0])); ?>
                                <?php //var_dump(get_user_meta( $user_obj->data->ID ));
                                ?>
                            </p>
                            <a target="_blank" class="mt-0" href="/author/<?= $user_obj->user_login ?>"><?= __('Læs mere', 'sdg') ?></a>
                        </div>
                        <div class="mt-3">
                            <p class="aside-small-title"><?= __('Projektets hovedmål', 'sdg') ?></p>
                            <a class="category-tag" href="/projekter/?category=<?= $category->slug; ?>"><?= $category->name; ?></a>
                        </div>
                        <div class="2">
                            <p class="aside-small-title"><?= __('Relaterede mål', 'sdg') ?></p>
                            <div>
                            <?php 
                            foreach ($sub_categories as $item) {
                                echo '<a class="category-tag" href="/projekter/?category='.$item->slug.'">'.$item->name.'</a>';
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 pt-0">
                        <div>
                            <h2 class="aside-title mt-2 mb-2"><?= __('Projekt information', 'sdg') ?></h2>
                            <div class="aside-list">
                                <div class=aside-list-item>
                                    <p class="text-bold"><?= __('Bevillingstype:','sdg')?></p>
                                    <p><?= get_field('bevillingstype')?></p>
                                </div>
                                <div class=aside-list-item>
                                    <p class="text-bold"><?= __('Projekt start:','sdg')?></p>
                                    <p><?= get_field('projekt_start')?></p>
                                </div>
                                <div class=aside-list-item>
                                    <p class="text-bold"><?= __('Projekt slut:','sdg')?></p>
                                    <p><?= get_field('projekt_slut')?></p>
                                </div>
                                <div class=aside-list-item>
                                    <p class="text-bold"><?= __('Ansøgningsrunde:','sdg')?></p>
                                    <p><?= get_field('ansogningsrunde')?></p>
                                </div>
                                <div class=aside-list-item>
                                    <p class="text-bold"><?= __('Kommune:','sdg')?></p>
                                    <p><?= $project_location['commune']['label']?></p>
                                </div>
                                <div class=aside-list-item>
                                    <p class="text-bold"><?= __('Bevilliget beløb:','sdg')?></p>
                                    <p><?= get_field('price')?></p>
                                </div>
                                <div class=aside-list-item>
                                    <p class="text-bold"><?= __('Samlet budget:','sdg')?></p>
                                    <p><?= get_field('budget')?></p>
                                </div>
                                <div class=aside-list-item>
                                    <p class="text-bold"><?= __('Lokal partner:','sdg')?></p>
                                    <p><?= get_field('partner')?></p>
                                </div>
                            </div>
                        </div>
                        <div class="my-4">
                            <p class="aside-small-title"><?= __('Projekt leder', 'sdg') ?></p>
                            <div class="aside-responsible">
                                <div>
                                    <img src="<?= $profil_image['sizes']['thumbnail']?>"  alt="<?=$profil_image['alt']?>">
                                </div>
                                <div>
                                    <p class="aside-responsible-name text-bold"><?= get_field('name')?></p>
                                    <p class="aside-responsible-title"><?= get_field('stilling')?></p>
                                    <p class="aside-responsible-email text-bold"><?= get_field('email')?></p>
                                    <p class="aside-responsible-phone text-bold"><?= get_field('telefon_nummer')?></p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php 
                                if( have_rows('dokumenter') ):

                                    // Loop through rows.
                                    while( have_rows('dokumenter') ) : the_row();
                                
                                        // Load sub field value.
                                        $sub_value = get_sub_field('dokument');
                                        //var_dump($sub_value['title']);
                                        echo '<a class="btn btn-lg btn-primary w-100 mb-2" target="_blank" href="'.$sub_value['url'].'">'. __('Hent dokumenter','sdg'). '</a>';
                                    // End loop.
                                    endwhile;
                                endif;
                            ?>
                            
                        </div>
                    </div>

                    
                    <div class="px-4 pt-4">
                        <div>
                            <h2 class="aside-title mt-2 mb-1"><?= __('Kontakt information', 'sdg') ?></h2>
                            <div class="aside-list">
                                <div class=aside-list-item>
                                    <p class="text-bold"><?= __('Addresse:','sdg')?></p>
                                    <p><?= $sdg_addresse['address'] .', '. $sdg_addresse['postnummer'] .' ' .$sdg_addresse['by']?></p>
                                </div>
                                <div class=aside-list-item>
                                    <p class="text-bold"><?= __('Email:','sdg')?></p>
                                    <p><?= $user_obj->user_email?></p>
                                </div>
                                <div class=aside-list-item>
                                    <p class="text-bold"><?= __('Telefon nummer:','sdg')?></p>
                                    <p><?= get_field('phone', 'user_' . $user_obj->ID);?></p>
                                </div>
                                <div class=aside-list-item>
                                    <p class="text-bold"><?= __('CVR nummer:','sdg')?></p>
                                    <p><?= get_field('cvr_nr', 'user_' . $user_obj->ID);?></p>
                                </div>
                                <iframe src="https://www.google.com/maps?q=[<?=$sdg_addresse['address'] .', '. $sdg_addresse['postnummer'] .' ' .$sdg_addresse['by']?>]&output=embed"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</div>
<?php
include_once get_template_directory_uri() .'/module-templates/frontend/default-section/newsletter.php';
get_footer();
