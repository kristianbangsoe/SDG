<?php /* Template Name: Create account */ 
get_header();
session_start();

// $userdata = array(
// 	'user_login'       =>  'myname',
// 	'user_pass'        =>  'mypass',
// 	'user_email'       =>  'myemail@me.you',
// 	'user_registered'  =>  date_i18n( 'Y-m-d H:i:s', time() ),
// 	'role'             =>  'editor'
// 	);
	
// $user_id = wp_insert_user( $userdata );

$errorsEmail = isset($_SESSION['errors']['email']) ? $_SESSION['errors']['email'] : null;
$errorsPassword = isset($_SESSION['errors']['password']) ? $_SESSION['errors']['password'] : null;
$errorsVat = isset($_SESSION['errors']['vat']) ? $_SESSION['errors']['vat'] : null;

//$vatObj = cvrapi('28010176', 'dk');
//var_dump($_SESSION['errors']);


?>


<div id="create-account" class="pb-5 pt-4" style="--hero-image: url('<?=the_post_thumbnail_url()?>')">
	<div class="container-fluid px-5">
		<div class="row">
			<div class="col-md-3 mx-auto">
				<h1 class="h2 pt-5 mb-3"><?=__('Create an account','wordpress')?></h1>

				<form action="<?php echo admin_url( 'admin-post.php' ) ?>" method="post">
				<input type="hidden" name="action" value="signup_form_data"/>
					<div class="form-group">
						<label for="inputVat"><?= __('VAT / CVR number','wordpress'); ?></label>
						<input type="vat" name="vat" placeholder="Insert your vatnumber" class="form-control <?= isset($errorsVat) ? 'is-invalid': ''?>" id="inputVat" >
						<?php echo '<div class="invalid-feedback">' . $errorsVat .' </div>';?>
					</div>
					<div class="form-group">
						<label for="inputEmail"><?= __('Email address','wordpress'); ?></label>
						<input type="email" name="email" placeholder="E-mail" class="form-control <?= isset($errorsEmail) ? 'is-invalid': ''?>" id="inputEmail" >
						<?php echo '<div class="invalid-feedback">' . $errorsEmail .' </div>';?>
					</div>
					<div class="form-group">
						<label for="inputPassword"><?= __('Password','wordpress'); ?></label>
						<input type="password" name="password" placeholder="Password" class="form-control <?= isset($errorsPassword) ? 'is-invalid': ''?>" id="inputPassword">
						<?php echo '<div class="invalid-feedback">'. $errorsPassword .' </div>';?>
					</div>
					<div class="form-group form-check">
						<input type="checkbox" name="remember" class="form-check-input" id="checkTerms">
						<label class="form-check-label" for="checkTerms"><?= __('Remember me','wordpress'); ?></label>
					</div>
					<button type="submit" class="btn btn-primary"><?=__('Submit','wordpress')?></button>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="primary">
	<div id="content" role="main">
	</div><!-- #content -->
</div><!-- #primary -->
<?php

//var_dump($vatObj);


get_footer();