<?php 
add_action( 'admin_post_nopriv_create_account', 'create_account' );
add_action( 'admin_post_create_account', 'create_account' );
function create_account() {

    $errors['errors_con'] = [];
    session_start();
    $vatObj = null;


    $user_membership = isset( $_POST['membership']) ? $_POST['membership'] : 1;
    $user_firstname = isset( $_POST['firstname']) ? $_POST['firstname'] :'';
    $user_lastname = isset( $_POST['lastname']) ? $_POST['lastname'] :'';
    $user_phone = isset( $_POST['phone']) ? $_POST['phone'] :'';
    $user_country = isset( $_POST['country']) ? $_POST['country'] :'';
    $user_city = isset( $_POST['city']) ? $_POST['city'] :'';
    $user_zip = isset( $_POST['zip']) ? $_POST['zip'] :'';
    $user_address = isset( $_POST['address']) ? $_POST['address'] :'';
    // Company, Gov, NGO fields
    $user_company = isset( $_POST['company']) ? $_POST['company'] :'';
    $user_cvr = isset( $_POST['cvr']) ? $_POST['cvr'] :'';
    $user_ean = isset( $_POST['ean']) ? $_POST['ean'] :'';
    $user_company_phone = isset( $_POST['company-phone']) ? $_POST['company-phone'] :'';
    $user_invoice_email = isset( $_POST['invoice-email']) ? $_POST['invoice-email'] :'';
    

    switch ($user_membership) {
        case 1:
            # Student
            $user_membership = 'student';
            break;
        case 2:
            # Private
            $user_membership = 'private';
            break;
        case 3:
            # Company / Goverment
            $user_membership = 'business';
            break;
        case 4:
            # NGO
            $user_membership = 'ngo';
            break;
        default:
            # Fallback on student
            $user_membership = 'student';
            break;
    }


    if (isset($_POST['password']) && $_POST['password'] !== ''){
        $password = $_POST['password'];

        if (strlen($password) < 5) {
            $errors['errors_con']['password'] = __('Make a stronger password','sdg');
        }
    }else{
        $errors['errors_con']['password'] = __('Make a password','sdg');
    }
    
    if (isset($_POST['email']) && $_POST['email'] !== ''){
        $email = $_POST['email'];
        if (email_exists($email) != false) {
            $errors['errors_con']['email'] = __('This email is already taken. Forgot your password?','sdg');
        }
    }else{
        $errors['errors_con']['email'] = __('Please type your email','sdg');
    }
    
    if ($user_country > 249 || $user_country < 0) {
        $errors['errors_con']['country'] = __('Ugyldigt land','sdg');
    }
   
    if ($errors['errors_con'] == []){

        wp_create_user( $email, $password, $email);
        $creds = array();
        $creds['user_login'] = $email;
        $creds['user_password'] = $password;
        $creds['remember'] = true;

    
        $user = wp_signon( $creds, false );
        
        $userID = $user->ID;
        
        update_field('phone', $user_phone, 'user_'.$userID);

        $values = array(
            'by'	=>	$user_city,
            'postnummer'	=>	$user_zip,
            'address'	=>	$user_address,
            'countries' => $user_country
        );
        
        update_field('addresse', $values, 'user_'.$userID);

        update_field('cvr_nr', $user_cvr, 'user_'.$userID);
        
        //update_field('description_2', $user_industrydesc, 'user_'.$userID);
         
        //update_field('company_type', $user_companytype, 'user_'.$userID);

        update_field('name', $user_firstname . ' ' . $user_lastname, 'user_'.$userID);

        update_field('company_email', $user_invoice_email, 'user_'.$userID);
        update_field('ean', $user_ean, 'user_'.$userID);
        update_field('company_phone', $user_company_phone, 'user_'.$userID);
        
        update_field('user_status', 2, 'user_'.$userID);

        global $wpdb;
        $data = [ 'user_status' => 2 ]; // Set status to in-active (2)
        $where = [ 'ID' => $userID ]; // WHERE ID is = to current.
        $wpdb->update( $wpdb->prefix . 'users', $data, $where ); // Update the value
       
        $user->set_role( $user_membership );
        wp_set_current_user( $userID, $email );
        wp_set_auth_cookie( $userID, true, false );
        do_action( 'wp_login', $email );
        
        header('Location: /sign-up/?'. $email );  

    }else{
        $_SESSION['errors'] = $errors['errors_con'];
        header('Location: /sign-up/?'. $email);  
    }
    
}
