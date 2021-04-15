
<section class="overview-section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col py-5">
                    <?php if(get_sub_field('title') != ''): ?>
                    <div class="row">
                        <div class="title-section col-md-5 h5 mb-4 font-weight-light">
                            <h2><?=get_sub_field('title');?></h2>
                            <div class="divider"></div> 
                            <p><?=get_sub_field('description');?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="row">
                        <?php
                        // check if the repeater field has rows of data
                        if( have_rows('overview_boxes') ):

                            // loop through the rows of data

                            while ( have_rows('overview_boxes') ) : the_row();

                                $image = get_sub_field('background_image');
                                $has_image = $image != '' ? '' : 'image-bg'; 
                                
                                $button_colour = get_sub_field('background_color') == 'card-green' && $has_image != '' ? 'btn-secondary' : 'btn-primary'; 
                                $title = get_sub_field('title') ? '<h2>' . get_sub_field('title') . '</h2>' : '';
                                $desc = get_sub_field('description') ?  '<p>'.get_sub_field('description') .'</p>' : '';
                                $bg_image = $image != '' ? 'style="background-image: url('.$image['sizes']['medium_large'].');"' : '';
                                $link = get_sub_field('link');
                        ?>
                            <div class="<?= $has_image ?> col-md-6 col-lg-4 mb-4 mb-lg-4 pb-3">
                                <div <?= $bg_image ?> class="card d-flex   <?=get_sub_field('background_color')?> ">
                                    <div class="<?=$image == '' ? '' : 'blur'; ?> d-flex flex-column p-5 justify-content-between h-100">
                                        <div>
                                            <?= $title; ?>
                                            <?= $desc; ?>
                                        </div>
                                        <div>
                                            <?php if ($link) {
                                                echo '<a target="'.$link['target'].'" class="btn mt-2 '.$button_colour.'" href="'.$link['url'].'">'. $link['title'].'</a>';
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            endwhile;
                        endif;
                        ?>
                    </div>
            </div>
        </div>
    </div>
</section>