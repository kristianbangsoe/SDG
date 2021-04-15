<?php /* Template Name: Network */ ?>

<?php get_header();

?>
<section class="hero-section" >
    <div class="container-fluid">
        <div class="col px-0 px-sm-auto">
            <div style="--hero-image: url('<?=the_post_thumbnail_url()?>')" class="bg-image" >
                <div style="height: 400px;" class="hero-wrapper text-white py-5 px-4 px-md-5 d-flex align-items-center">
                    <div class="w-100 fadeInUp text-center">
                       
                            <h1 class="hero_title">
                                <?=get_the_title()?>
                            </h1>
                            <div class="tagline h5 my-4 font-weight-light">
                                <?=get_sub_field('description')?>
                            </div>
                            <div class="d-flex flex-md-row flex-column pt-4">
                                <?php if (get_sub_field('button_1_link') != '') {
                                   echo '<a class="btn mr-md-3 mr-0  btn-primary" href="'.get_sub_field('button_1_link').'">'.get_sub_field('button_1_text').'</a>';
                                }
                                if (get_sub_field('button_2_link') != '') {
                                    echo '<a class="btn mr-md-3 mr-0 mt-md-0 mt-3 btn-bordered" href="'.get_sub_field('button_2_link').'">'.get_sub_field('button_2_text').'</a>';
                                }?>
                            </div>
                   
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="networks" class="pb-5 pt-4 pt-5">
<?php    
        $recent_posts = get_posts(array(
            'numberposts' => -1, // Number of recent posts thumbnails to display
            'post_status' => 'publish', // Show only the published posts
            'post_type'   => 'networks',
            'orderby'     => 'date',
            'order'       => 'DESC'
        ));

        if( $recent_posts ): ?>
            <div class="container">
                <div class="row">
                <div class="col-10 mx-auto mb-5">
                    <div class="float-left selector-item search btn-group">
                        <select class="select-input form-control">
                            <option value="0">Select SDG</option>
                        </select>
                        <select class="type-input ml-2 form-control">
                            <option value="0">Vælg virksomhedstype</option>
                            <option value="1">Company</option>
                            <option value="2">Organisation</option>
                            <option value="3">NGO</option>
                            <option value="4">Funding</option>
                            <option value="5">Municipality</option>
                            <option value="6">Person</option>
                        </select>
                    </div>
                </div>    
                <div class="col-10 mx-auto">
                        <table data-toggle="table">
                        <thead>
                            <tr>
                                <th data-sortable="true" data-field="name">Name</th>
                                <th data-sortable="true" data-field="type">Type</th>
                                <th data-field="sdg">SGD's</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $row_index = 0;

                            foreach($recent_posts as $post) :  // variable must be called $post (IMPORTANT)
                                setup_postdata($post); 
                                
                                $name = get_field('name');
                                $phone = get_field('phone_number');
                                $address = get_field('address');
                                $type = get_field('type');
                                $email = get_field('email');
                                $website = get_field('website');
                                $description = get_field('description');
                                $categories = get_the_category();
                                $category_array = [];
                                $category_array_2 = [];
                                $i = 0;
                                foreach( $categories as $category) :
                                    $cat_id = get_field('sdg_id', get_term($category->term_id));
                                    $category_array_2 [$i]['name'] = $category->name;
                                    $category_array_2 [$i]['id'] = $cat_id;
                                    array_push($category_array, $category->term_id);
                                    
                                    $i++;
                                endforeach;
                                $category_implode = implode(',', $category_array);
                                $category_implode = json_encode($category_array);
                            ?>
                                <tr class="network-item" data-type="<?=$type['value']?>" data-category-ids="<?= $category_implode?>">
                                    <td class="network-name" ><a  href="#"><?=$name?></a></td>
                                    <td><?=$type['label']?></td>
                                    <td class="network-categories">
                                    <?php 
                                        
                                        foreach( $category_array_2 as $category_2 => $value) :
                                            $cat_name = $value['name'];
                                            $sdgImageId = $value['id'] ?>
                                            <i data-toggle="tooltip" data-placement="bottom" title="<?=$cat_name?>" data-sdg-id="<?=$sdgImageId?>" class="mr-2 sdg-badge badge-4 goal-<?=$sdgImageId?>"></i>
                                        <?php
                                        endforeach;
                                    ?>
                                    <div class="network-modal">
                                            <i class="close-network fas fa-times"></i>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h2><?=$name?></h2>
                                                    <div class="divider"></div>
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <p><strong><?= __('Type','wordpress')?>: </strong><?=$type['label']?></p>
                                                    <p><strong><?= __('Phone number','wordpress')?>: </strong><a href="tel:<?=$phone?>"><?=$phone?></a></p>
                                                    <p><strong><?= __('Address','wordpress')?>:</strong></p>
                                                    <p><?=$address?></p>
                                                    <p><a href="<?=$website?>" target="_blank" rel="noopener noreferrer"><?= __('Go to website','wordpress')?></a></p>

                                                    <p><strong><?= __("SDG's","wordpress")?>:</strong></p>
                                                    <div class="d-flex mb-4">
                                                        <?php 
                                                            foreach( $categories as $category) :
                                                                $name = $category->name;
                                                                $sdgImageId = get_field('sdg_id', get_term($category->term_id)); ?>
                                                                <i data-toggle="tooltip" data-placement="bottom" title="<?=$name?>" data-sdg-id="<?=$sdgImageId?>" class="mr-2 sdg-badge badge-4 goal-<?=$sdgImageId?>"></i>
                                                            <?php
                                                            endforeach;
                                                        ?>
                                                    </div>
                                                    
                                                </div>

                                                <div class="col-lg-6 col-12">
                                                    <p><strong><?= __("Description","wordpress")?>:</strong></p>
                                                    <p><?=$description?></p>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; wp_reset_postdata(); ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif;
    ?>
    
</div>

<?php
get_footer();