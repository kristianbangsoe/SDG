<?php /* Template Name: Sign-up */
get_header();
session_start();
$terms_and_conditions = get_field('terms_and_conditions','options')
?>

<section id="sign-up-form">
    <div class="container py-5 my-5">
        <div class="row">
            <form action="<?php echo admin_url( 'admin-post.php' ) ?>" method="post" id="create-account-form" class="col-md-7 mx-auto needs-validation"  novalidate>
                <input type="hidden" name="action" value="create_account"/>
                <div class="form-row">
                    <div class="col mb-3">
                        <h3><?= __('Personal information', 'sdg') ?></h3>
                    </div>
                </div>
                <div class="form-select mb-4">
                    <label for="membership"><?= __('Membership', 'sdg') ?></label>
                    <select name="membership" class="form-select form-control " id="membership" aria-describedby="membershipFeedback" required>
                        <option selected disabled value=""><?= __('Select a membership', 'sdg') ?></option>
                        <option value="1">Student name your price kr.</option>
                        <option value="2">Private 100 kr. Yealy</option>
                        <option value="3">Goverment / Business 295 kr. Quarterly</option>
                        <option value="4">NGO 145 kr. Quarterly</option>
                    </select>
                    <div id="membershipFeedback" class="invalid-feedback">
                        <?= __('Please select a membership', 'sdg') ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="firstname"><?= __('First name', 'sdg') ?></label>
                        <input name="firstname" type="text" class="form-control " id="firstname" autocomplete="given-name fname" aria-describedby="firstnameFeedback" required>
                        <div id="firstnameFeedback" class="invalid-feedback">
                            <?= __('Please provide your first name', 'sdg') ?>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastname"><?= __('Last name', 'sdg') ?></label>
                        <input name="lastname" type="text" class="form-control" id="lastname" autocomplete="lname family-name" aria-describedby="lastnameFeedback" required>
                        <div id="lastnameFeedback" class="invalid-feedback">
                            <?= __('Please provide your last name', 'sdg') ?>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="email"> <?= __('E-mail', 'sdg') ?></label>
                        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailFeedback" required>
                        <div id="emailFeedback" class="invalid-feedback">
                            <?= __('Please provide an email', 'sdg') ?>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3 form-select">
                        <label for="country"><?= __('Country', 'sdg') ?></label>
                        <select name="country" class="form-select form-control" autocomplete="country" id="countries_select" aria-describedby="countryFeedback" required>
                        </select>
                        <div id="countryFeedback" class="invalid-feedback">
                            <?= __('', 'sdg') ?>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="password"><?= __('Password', 'sdg') ?></label>
                        <input name="password" type="password" autocomplete="new-password" class="form-control" id="password" aria-describedby="passwordFeedback" required>
                        <div id="passwordFeedback" class="invalid-feedback">
                            <?= __('Please create a password', 'sdg') ?>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="repeatPassword"><?= __('Repeat Password', 'sdg') ?></label>
                        <input name="repeatPassword" type="password" class="form-control" id="repeatPassword" aria-describedby="repeatPasswordFeedback" required>
                        <div id="repeatPasswordFeedback" class="invalid-feedback">
                            <?= __('Please repeat password', 'sdg') ?>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    
                    <div class="form-group col-md-6 mb-3">
                        <label for="phone"><?= __('Phone', 'sdg') ?></label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div id="phonePrefix" class="input-group-text">+45</div>
                            </div>
                            <input type="text" name="phone" class="form-control" id="inlineFormInputGroup" id="phone" aria-describedby="phoneFeedback" pattern="^\d{8,11}$" min="8" max="12">
                            <div id="phoneFeedback" class="invalid-feedback">
                                <?= __('Please provide a valid phonenumber.', 'sdg') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="city"><?= __('City', 'sdg') ?></label>
                        <input name="city" type="text" class="form-control " id="city" autocomplete="city by" aria-describedby="cityFeedback" required>
                        <div id="cityFeedback" class="invalid-feedback">
                            <?= __('Please provide a valid city.', 'sdg') ?>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="zip"><?= __('Zip code', 'sdg') ?></label>
                        <input name="zip" type="text" class="form-control " id="zip" autocomplete="zip by" aria-describedby="zipFeedback" required>
                        <div id="zipFeedback" class="invalid-feedback">
                            <?= __('Please provide a valid zip code.', 'sdg') ?>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="address"><?= __('Address', 'sdg') ?></label>
                        <input name="address" type="text" class="form-control " id="address" autocomplete="address" aria-describedby="cityFeedback" required>
                        <div id="addressFeedback" class="invalid-feedback">
                            <?= __('Please provide a valid Address.', 'sdg') ?>
                        </div>
                    </div>
                </div>
                <div class="form-row company">
                    <div class="col mt-4 mb-3">
                        <h3><?= __('Company information', 'sdg') ?></h3>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="company"><?= __('Company name', 'sdg') ?></label>
                        <input name="company" type="text" class="form-control " id="company" aria-describedby="companyFeedback" required>
                        <div id="companyFeedback" class="invalid-feedback">
                            <?= __('Please provide your company name', 'sdg') ?>
                        </div>
                    </div>
                </div>
                <div class="form-row company">
                    <div class="col-md-6 mb-3">
                        <label for="cvr"><?= __('CVR', 'sdg') ?></label>
                        <input name="cvr" type="text" class="form-control " id="cvr" autocomplete="cvr cvr-nummer" aria-describedby="cvrFeedback" required>
                        <div id="cvrFeedback" class="invalid-feedback">
                            <?= __('Please provide a valid CVR-number', 'sdg') ?>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="ean"><?= __('EAN', 'sdg') ?></label>
                        <input name="ean" type="text" class="form-control " id="ean" autocomplete="ean ean-nummer" aria-describedby="eanFeedback" required>
                        <div id="eanFeedback" class="invalid-feedback">
                            <?= __('Please provide a valid EAN-number', 'sdg') ?>
                        </div>
                    </div>
                </div>
                <div class="form-row company">
                    <div class="col-md-6 mb-3">
                        <label for="company-phone"><?= __('Company phone', 'sdg') ?></label>
                        <input name="company-phone" type="text" class="form-control " id="company-phone" autocomplete="company-phone tel" aria-describedby="companyPhoneFeedback" required>
                        <div id="companyPhoneFeedback" class="invalid-feedback">
                            <?= __('Please provide a valid company phone', 'sdg') ?>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3 company">
                        <label for="invoice-email"><?= __('Invoice email', 'sdg') ?></label>
                        <input name="invoice-email" type="text" class="form-control " id="invoice-email" autocomplete="shipping email" aria-describedby="invoiceEmailFeedback" required>
                        <div id="invoiceEmailFeedback" class="invalid-feedback">
                            <?= __('Please provide a valid email', 'sdg') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input name="" class="form-check-input" type="checkbox" value="" id="invalidCheck3" aria-describedby="invalidCheck3Feedback" required>
                        <label class="form-check-label" for="invalidCheck3">    
                            <p><?= __('Agree to our ', 'sdg') ?><a href="<?=$terms_and_conditions['url']?>"><?= $terms_and_conditions['title']?></a></p>
                        </label>
                        <div id="invalidCheck3Feedback" class="invalid-feedback">
                            You must agree before submitting.
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit"><?= __('Go to payment', 'sdg') ?></button>
                <p><?=$_SESSION['errors']?></p>
            </form>
        </div>
    </div>
</section>


<?php
get_footer();
