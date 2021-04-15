<section class="logo-section pt-4">
    <div class="container-fluid">
        <div class="col">
            <div class="row">
                <?php
                // check if the repeater field has rows of data
                if( have_rows('logos') ):

                    // loop through the rows of data
                    while ( have_rows('logos') ) : the_row();

                        // display a sub field value
                        $logo = get_sub_field('logo');
                        echo '<div class="col-md-2 col-6 logo-item">';
                            echo '<a target="_blank" href="'.get_sub_field('website').'" class="">';
                                echo '<img class="w-100" src="'.$logo['url'].'" title="'.$logo['title'].'" alt="'.$logo['title'].'">';
                            echo '</a>';
                        echo '</div>';
                    
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>
</section>