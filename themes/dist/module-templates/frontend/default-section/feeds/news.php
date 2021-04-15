<div class="title-section col-md-3 mb-4 ">
    <h2><?=get_sub_field('title');?></h2>
    <div class="divider"></div> 
    <div><?=get_sub_field('description');?></div>
    <a class="btn btn-primary mt-2" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">Se alle nyheder</a>
</div>
<div class="col-md-9">
    <?php    
        $recent_posts = get_posts(array(
            'numberposts' => 12, // Number of recent posts thumbnails to display
            'post_status' => 'publish', // Show only the published posts
            'post_type'   => 'post',
            'orderby'     => 'date',
            'order'       => 'DESC'
        ));
        

        if( $recent_posts ): ?>
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

                    foreach($recent_posts as $post) :  // variable must be called $post (IMPORTANT)
                    
                    $row_index++;
                    setup_postdata($post); 
                    
                    $category_id = get_field('main_goal');
                    
                    if($row_index%4 == 0) {
                      echo $row_index > 0 ? "</div></div>" : ""; // close div if it's not the first
                      if($row_index == 1){
                        echo "<div class='carousel-item active'><div class='row'>";
                      }else{
                        echo "<div class='carousel-item'><div class='row'>";
                      }
                     }
                     $categories = get_the_category();
                     foreach ($categories as $key => $category) {
                        $category_name = $category->name . ' | ';
                     }
                    ?>
                        <div class="col-md-4 card-item project-item ">   
                            <a class="d-block bg-white" href="<?php the_permalink(); ?>">
                                <i class="goal-size-1 goal-<?=get_field('sdg_id', 'category_'.$category_id);?>"></i>   
                                <img class="w-100 item-cover" src="<?=get_the_post_thumbnail_url(NULL,'medium')?>" alt="<?php the_title(); ?>">
                                <div class="divider w-100 my-0"></div>
                                <div class="p-3 d-flex flex-column justify-content-between">
                                    <div class="card-details d-flex mb-2 color-green"><?= $category_name . get_the_date()?></div>
                                    <h4 class="excerpt"><?php excerpt(10, get_the_title()); ?></h4>
                                    <p class="mb-0 mt-2"><?php excerpt(15, get_the_excerpt()); ?></p>
                                    <div class="mb-2 d-flex justify-content-end">
                                     <i class="sdg-icon sdg-arrow"></i>
                                    </div>
                                </div>
                                
                            </a>
                        </div>
                    <?php endforeach; wp_reset_postdata(); ?>
                </div>
            </div>
        <?php endif;
    ?>
</div>