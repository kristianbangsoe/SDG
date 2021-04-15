<?php
/* Template Name: Sign-up-flow */
get_header();

$args = array(
    'type'                     => 'projects',
    'child_of'                 => 1,
    'parent'                   => '',
    'orderby'                  => 'id',
    'order'                    => 'ASC',
    'hide_empty'               => 0,
    'hierarchical'             => 1,
    'pad_counts'               => false
);
$categories = get_categories($args);



?>

<form class="sign-up" method="GET" action="/sign-up/step-2">
    <div id="step-1" class="step active">
        <div class="container">
            <div class="row my-5">
                <div class="col-md-9 mx-auto my-5">
                    <h1 class="h3 mb-4 mt-5 pt-5"><?= __('Trin 1 af 3: Opprettelse','sdg')?></h1>
                    <label class="mb-4" for="username"><?= __('Hvem er du af følgende?','sdg')?></label>
                    <div id="company-type-selector" class="radio-group">
                        <button class="company-type" data-company-type-id="1"><?= __('Virksomhed', 'sdg'); ?></button>
                        <button class="company-type" data-company-type-id="2"><?= __('Ikke-statslig organisation', 'sdg'); ?></button>
                        <button class="company-type" data-company-type-id="3"><?= __('Privatperson', 'sdg'); ?></button>
                        <button class="company-type" data-company-type-id="4"><?= __('Statslig administrativ enhed', 'sdg'); ?></button>
                        <div class="d-none">
                            <input type="radio" name="company-type" value="1">
                            <input type="radio" name="company-type" value="2">
                            <input type="radio" name="company-type" value="3">
                            <input type="radio" name="company-type" value="4">
                        </div>
                    </div>
                    <div class="pb-5 d-flex flex-column align-items-start mt-5">
                        <label for="username"><?= __('Fulde juridiske navn på <strong id="pre-sel"></strong>','sdg')?></label>
                        <input placeholder="Fulde navn" autocomplete="true" type="text" name="company" id="">
                    </div>
                    <div class="pb-5 d-flex flex-column align-items-start mt-5">
                        <label for="username"><?= __('Vælg det mål du finder mest vigtigt?','sdg')?></label>
                        <div class="mt-3" id="sdg-selection">
                        <?php 
                            
                            foreach ($categories as $category) {
                                $url = get_term_link($category);
                                $term = get_queried_object($category);
                                $sdgImageId = get_field('sdg_id', get_term($category->cat_ID));
                                $sdgColor = get_field('color', get_term($category->cat_ID));
                                // var_dump($sdgImageId);
                                if($sdgImageId != 17){
                                    echo '<img data-company-sdg-id="'.$sdgImageId.'" src="' . get_template_directory_uri() . '/img/icons/sdg-goals/sdg–' . $sdgImageId . '.png" alt="" />';
                                    echo '<input class="d-none" type="radio" name="company-sdg" value="'.$sdgImageId.'">';
                                }
                            } 

                        ?>
                        </div>
                    </div>
                    <div class="pb-5 d-flex flex-column align-items-start mt-5 select-group" >
                        <label for="reason"><?= __('Hvad vil du primært bruge platformen til','sdg')?></label>
                        <select name="reason" id="reason">
                            <option selected disabled hidden ><?= __('Klik her for at vælge','sdg')?></option>    
                            <option value="1"><?= __('Finde støtte i form af partnere','sdg')?></option>
                            <option value="2"><?= __('Støtte et formål','sdg')?></option>
                            <option value="3"><?= __('Networking','sdg')?></option>
                            <option value="4"><?= __('Andet','sdg')?></option>
                        </select>
                    </div>
                    <div class="pb-5 mt-4 d-flex justify-content-end">
              
                        <input class="btn btn-primary" type="submit" value="<?= __('Næste', 'sdg')?>">
              
                    </div>
                </div>
                
            </div>
            
        </div>
        
    </div>

</form>

<?php
//var_dump($vatObj);


get_footer();
