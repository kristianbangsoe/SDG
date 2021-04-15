<section class="image-box-section pt-md-5 bg-gray">
    <div class="container-fluid py-md-5 py-0 my-0 my-md-5">
        <div class="col pb-md-5 pb-0 mb-md-3 mb-0 px-0 px-md-auto">
            <div class="title-section bg-shadow bg-white p-0 p-md-5 col-md-6  mb-5">
                <div class="p-3">
                    <h2 class="h2 font-weight-bold"><?=get_sub_field('title');?></h2>
                    <div class="divider"></div> 
                    <div class="h5 description font-weight-light"><?=get_sub_field('description');?></div>
                    <div class="mt-5">
                        <?php if (get_sub_field('button_link_1') != '') {
                            echo '<a class="btn mr-md-3 mb-3 mb-md-0 btn-primary" href="'.get_sub_field('button_link_1').'">'.get_sub_field('button_text_1').'</a>';
                        }
                        if (get_sub_field('button_link_2') != '') {
                            echo '<a class="btn mr-md-3 btn-bordered-2" href="'.get_sub_field('button_link_2').'">'.get_sub_field('button_text_2').'</a>';
                        }?>
                    </div>
                </div>
            </div>
            
            <img class="d-none d-md-block col-md-7 ml-5 offset-bg mt-n5" src="<?=get_sub_field('background_image')?>" alt="">

        </div>
        
        <div style="background-image: url('<?=get_sub_field('background_image')?>');"></div>
    </div>
</section>