<?php

$bgImage = get_sub_field('background_image');

?>
<section class="image-box-section pt-md-5 bg-gray">
    <div class="container-fluid py-md-5 py-0 my-md-5 my-0 px-0 px-md-auto">
        <div class="col-lg-11 mx-auto px-0 px-md-auto pb-md-5 mb-md-3">
            <img class="col-lg-9 ml-5 pl-0 left-offset bg-shadow mt-n5 d-md-block d-none" src="<?= $bgImage['url'] ?>" alt="">
            <div class="title-section ml-auto bg-shadow bg-white p-md-5 px-3 py-5 col-md-8 col-lg-6 col-xl-4 mb-md-5">
                <div class="p-3">
                    <h2 class="h2 font-weight-bold"><?= get_sub_field('title'); ?></h2>
                    <div class="divider"></div>
                    <div class="h5 description font-weight-light"><?= get_sub_field('description'); ?></div>
                    <div class="mb-5">
                        <!-- Begin Mailchimp Signup Form -->

                        <div id="mc_embed_signup">
                            <form action="https://bangslund.us4.list-manage.com/subscribe/post?u=2c34f83f305df8c80a96ff7d2&amp;id=6ba6a87232" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="needs-validation" target="_blank" novalidate>
                                <div id="form-row">
                                    <div class="form-group">
                                        <label for="mce-FNAME">First Name</span>
                                        </label>
                                        <input type="text" value="" name="FNAME" class="form-control" id="mce-FNAME" required>
                                        <div class="invalid-feedback">Indtast dit navn.</div>

                                    </div>
                                    <div class="form-group">
                                        <label for="mce-EMAIL">Email Address
                                        </label>
                                        <input type="email" value="" name="EMAIL" class="form-control" id="mce-EMAIL" required>
                                        <div class="invalid-feedback"><?= __('Intast venligst en gyldig email', 'sdg') ?></div>

                                    </div>
                                    <div id="mce-responses" class="clear">
                                        <div class="response" id="mce-error-response" style="display:none"></div>
                                        <div class="response" id="mce-success-response" style="display:none"></div>
                                    </div> <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                                    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_2c34f83f305df8c80a96ff7d2_6ba6a87232" tabindex="-1" value=""></div>
                                    <div class="clear">
                                        <input type="submit" value="TILMELD DIG NU" name="subscribe" id="mc-embedded-subscribe" class="button btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--End mc_embed_signup-->
                    </div>
                </div>
            </div>
        </div>

        <div style="background-image: url('<?= get_sub_field('background_image') ?>');"></div>
    </div>
</section>

<!--End mc_embed_signup-->


