<div class="title-section col-md-3 mb-4 ">
    <h2><?=get_sub_field('title');?></h2>
    <div class="divider"></div> 
    <div><?=get_sub_field('description');?></div>
    <a class="btn btn-primary mt-2" href="/projects">Se alle projekter</a>
</div>
<div class="col-md-9">
    <?php    
        $post_objects = get_sub_field('select_post_objects');
        if( $post_objects ): ?>
            <div class="arrow-controls d-flex mb-3">
                <a class="carousel-control-prev arrow-control mr-3" href="#feature-carusel-<?=get_row_index();?>" role="button" data-slide="prev">
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-prev arrow-control" href="#feature-carusel-<?=get_row_index();?>" role="button" data-slide="next">
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <div id="feature-carusel-<?=get_row_index();?>" class="carousel-feature carousel slide" >
                
                <div class="carousel-inner">
       
                <div class='carousel-item active'>
                    <div class="row">
                        
                    
                <?php 
                    $row_index = 0;
                    foreach( $post_objects as $post): // variable must be called $post (IMPORTANT) ?>
                    <?php 
                    $row_index++;
                    setup_postdata($post); 
                    
                    
                    $category_id = get_field('main_goal');
                    
                    // get_the_date('Y')
                    
                    if($row_index%4 == 0) {
                      echo $row_index > 0 ? "</div></div>" : ""; // close div if it's not the first
                      if($row_index == 1){
                        echo "<div class='carousel-item active'><div class='row'>";
                      }else{
                        echo "<div class='carousel-item'><div class='row'>";
                      }
                     }
                     $sdg_logo = get_field('logo', 'user_' . $post->post_author);
                    ?>
                        <div class="col-md-4 card-item project-item ">   
                            <a class="d-block bg-white" href="<?php the_permalink(); ?>">
                                <i class="goal-size-1 goal-<?=get_field('sdg_id', 'category_'.$category_id);?>"></i>   
                                <img class="w-100 item-cover" src="<?=get_the_post_thumbnail_url(NULL,'medium')?>" alt="<?php the_title(); ?>">
                                <div class="divider w-100 my-0"></div>
                                <div class="py-3 d-flex flex-column justify-content-between">
                                    <div class="card-details d-flex mb-2 color-green"><?= get_cat_name( $category_id );?></div>
                                    <h4 class="excerpt"><?php excerpt(10, get_the_title()); ?></h4>
                                    <div class="mt-3 mb-2 d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                           
                                            <p class="mb-0 item-company"><?= get_field('name', 'user_' . $post->post_author)?></p>
                                        
                                        </div>
                                        <i class="sdg-icon sdg-arrow"></i>
                                    </div>
                                </div>
                                
                            </a>
                        </div>
                   
                <?php endforeach; ?>
            
            <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
                </div>
            </div>
        <?php endif;
    ?>
</div>