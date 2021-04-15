<?php
//$ = get_sub_field('') != '' :  : '';
$title = get_sub_field('title') != '' ? '<div class="row"><div class="col-md-6 mx-auto">' . get_sub_field('title') . '</div></div>' : '';
?>

<section class="pricing-plans py-5">
    <div class="container-fluid py-5 mb-5">
        <?= $title ?>

        <?php
        if( have_rows('plans') ):
            echo '<div class="row my-5 pt-5">';            
                while ( have_rows('plans') ) : the_row(); 
                $button = get_sub_field('button');
                $billing = get_sub_field('billing');
                $hightlight = get_sub_field('hightlight') == 1 ? 'true' : 'false';
                
                switch ($billing ) {
                    case '0':
                        $billing = '<span class="price">'. get_sub_field('price') .' '. __(' kr.','sdg') .'</span><span class="ml-3">/ ' . __('Monthly','sdg') . '</span>';
                        break;
                    case '1':
                        $billing = '<span class="price">'. get_sub_field('price') .' '. __(' kr.','sdg') .'</span><span class="ml-3">/ ' . __('Quarter','sdg') . '</span>';
                        break;
                    case '2':
                        $billing = '<span class="price">'. get_sub_field('price') .' '. __(' kr.','sdg') .'</span><span class="ml-3">/ ' . __('Yealy','sdg') . '</span>';
                        break;
                    default:
                        $billing = '<span class="price">'. get_sub_field('price') .' '. __(' kr.','sdg') .'</span><span class="ml-3">/ ' . __('Name your price','sdg') . '</span>';
                        break;
                }
                echo '<div data-highlight="'.$hightlight.'" class="plan plan- px-2 col-md-3">';
                    echo '<div class="plan-wrapper bg-gray p-5 d-flex flex-column justify-content-between">';
                        echo '<div class="plan-content-wrapper ">';
                            echo '<div class="plan-price mb-2">';
                                echo '<p class="plan-title h3 mb-4">'. get_sub_field('title') .'</p>';
                                echo '<div class="text-center">' .$billing . '</div>';
                            echo '</div>';  
                            echo '<div class="plan-content mt-4">';
                                if( have_rows('benefits') ):
                                    echo '<ul>';
                                    while ( have_rows('benefits') ) : the_row(); 
                                        echo '<li><i class="fas fa-check-circle"></i> '. get_sub_field('benefit') .'</li>';
                                    endwhile;
                                    echo '</ul>';
                                endif;
                            echo '</div>';
                        echo '</div>';
                        echo '<a class="btn btn-link mb-2" href="#pricing-table">'. __('Learn more','sdg').'</a>';
                        echo ' <a class="btn btn-primary" target="'.$button['target'].'" href="'.$button['url'].'">'.$button['title'].'</a>';
                    echo '</div>';
                echo '</div>';
                endwhile;
            echo '</div>';
        endif;
        ?>        
    </div>
</section>