<?php 
$headline = get_sub_field('headline') == '' ? '':'<h1 class="hero_title">' . get_sub_field('headline') . '</h1>';
$description = get_sub_field('description') == '' ? '' : '<div class="tagline h5 my-4 font-weight-light">'.get_sub_field('description') . '</div>' ;
$button = get_sub_field('button_1_link');

$button_2 = get_sub_field('button_2_link');
$full_width = get_sub_field('full_width') == true ? '' : 'container-fluid';
$align_center = get_sub_field('content_center') == false ? '' : 'justify-content-center mx-auto text-center align-items-center';
?>
<section class="hero-section">
    <div class="<?=$full_width?>">
        <div class="col px-0 px-sm-auto">
            <div style="--hero-image: url('<?=get_sub_field('background_image')?>')" class="bg-image" >
                <div class="hero-wrapper text-white px-4 px-md-5 ">
                    <div class="row">
                       <div class="<?=$align_center?> col-lg-6 col-md-8 col-12 fadeInUp">
                        <?php 
                            
                            echo $headline;
                            echo $description;


                            if ($button_2 && $button) {
                                echo '<div class="'.$align_center.' d-flex flex-md-row flex-column pt-4">';
                                    if ($button['url'] !== '') {
                                    echo '<a class="btn mr-md-3 mr-0  btn-primary" target="'.$button['target'].'" href="'.$button['url'].'">'.$button['title'].'</a>';
                                    }
                                    if ($button_2['url'] != '') {
                                        echo '<a class="btn mr-md-3 mr-0 mt-md-0 mt-3 btn-bordered" target="'.$button_2['target'].'" href="'.$button_2['url'].'">'.$button_2['title'].'</a>';
                                    }
                                echo '</div>';
                            }
                           ?>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>