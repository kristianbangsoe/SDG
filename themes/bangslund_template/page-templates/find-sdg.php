<?php /* Template Name: Find SDG */ ?>

<?php get_header(); ?>

<div id="find-sdg" class="pb-5 pt-4">
<?php
       $args = array(
       'type'                     => 'projects',
       'child_of'                 => 1,
       'parent'                   => '',
       'orderby'                  => 'id',
       'order'                    => 'ASC',
       'hide_empty'               => 0,
       'hierarchical'             => 1,
       'pad_counts'               => false );
       $categories = get_categories($args);

   ?>
    <div class="half-circle-menu">
        <div class="center-circle">
            <div class="categories">
                <div class="sdg-wrapper">
                    
                    <p class="sdg-title"><?= the_title();?></p>
                    <div class="sdg-description"><?= the_content();?></div>
                </div>
                <a class="btn btn-primary" href="<?=get_field('projects_slug')?>"><?= __('Se projekter','sdg')?></a>
            </div>
            <?php   
                foreach ($categories as $category) {
                    $url = get_term_link($category);
                    $term = get_queried_object($category);
                    $sdgImageId = get_field('sdg_id', get_term($category->cat_ID));
                    $sdgColor = get_field('color', get_term($category->cat_ID));
                    // var_dump($sdgImageId);
                    $sdgImageId = $sdgImageId < 10 ? '0' . $sdgImageId : $sdgImageId;
                    ?>
                    <a style="background-color: <?=$sdgColor?>; background-image: url('https://raw.githubusercontent.com/UNStats/FIS4SDGs/master/globalResources/sdgIcons1000x1000/TGG_Icon_Color_<?=$sdgImageId?>.png'); " class="little-circle" data-href="?category=<?php echo $category->slug;?>" target="blank" data-id="<?=$sdgImageId?>"
                    data-color="<?=$sdgColor?>" data-name="<?= $category->name; ?>" data-description="<?= $category->description; ?>"></a>
                    
                    <?php
                } 
            ?>
        </div>
    </div>
</div>

<?php
get_footer();