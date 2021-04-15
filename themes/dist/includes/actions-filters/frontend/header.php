<?php
add_filter( 'wp_title', 'add_site_description_to_title', 10, 2 );

/**
 * Creates a nicely formatted and more specific title element text
 */
function add_site_description_to_title($title, $sep) {
    if (is_feed()) {
        return $title;
    }
    // Add the site name.
    $title .= get_bloginfo( 'name' );
    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title = "$title $sep $site_description";
    }
    return $title;
}

if( !current_user_can('administrator') ) {
    show_admin_bar(false);
}


add_action( 'admin_post_nopriv_signup_form_data', 'signup_form_data' );
add_action( 'admin_post_signup_form_data', 'signup_form_data' );
function signup_form_data() {

    $errors['errors_con'] = [];
    session_start();
    $vatObj = null;

    if (isset($_POST['vat']) && $_POST['vat'] !== ''){
        $vat = $_POST['vat'];
        
        $vatObj = cvrapi($vat, 'dk');
        if(username_exists($vatObj->vat)){
            $errors['errors_con']['vat'] = __('This vat is already in use.','sdg');
        }
       
    }else{
        $errors['errors_con']['vat'] = __('Please insert your VAT/CVR number','sdg');
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
    
   
    if ($errors['errors_con'] == []){

        $user_vat = isset($vatObj['vat']) ? $vatObj['vat'] : '';
        $user_name = isset($vatObj['name']) ? $vatObj['name'] : '';
        $user_address = isset($vatObj['address']) ? $vatObj['address'] : '';
        $user_zipcode = isset($vatObj['zipcode']) ? $vatObj['zipcode'] : '';
        $user_city = isset($vatObj['city']) ? $vatObj['city'] : '';
        $user_employees = isset($vatObj['employees']) ? $vatObj['employees'] : '';
        $user_phone = isset($vatObj['phone']) ? $vatObj['phone'] : '';
        $user_industrydesc = isset($vatObj['industrydesc']) ? $vatObj['industrydesc'] : '';
        $user_companytype = isset($vatObj['companydesc']) ? $vatObj['companydesc'] : '';
        $user_startdate = isset($vatObj['startdate']) ? $vatObj['startdate'] : '';
        

        wp_create_user( $user_vat, $password, $email);
        $creds = array();
        $creds['user_login'] = $user_vat;
        $creds['user_password'] = $password;
        $creds['remember'] = true;
    
        $user = wp_signon( $creds, false );
        
        $userID = $user->ID;
        
        update_field('phone', $user_phone, 'user_'.$userID);

        $values = array(
            'by'	=>	$user_city,
            'postnummer'	=>	$user_zipcode,
            'address'	=>	$user_address,
        );
        
        update_field('addresse', $values, 'user_'.$userID);

        update_field('cvr_nr', $user_vat, 'user_'.$userID);
        
        update_field('description_2', $user_industrydesc, 'user_'.$userID);
         
        update_field('company_type', $user_companytype, 'user_'.$userID);

        update_field('name', $user_name, 'user_'.$userID);
        update_field('user_status', 2, 'user_'.$userID);

        global $wpdb;
        $data = [ 'user_status' => 2 ]; // Set status to pending (2)
        $where = [ 'ID' => $userID ]; // WHERE ID is = to current.
        $wpdb->update( $wpdb->prefix . 'users', $data, $where ); // Update the value
       

        wp_set_current_user( $userID, $user_vat );
        wp_set_auth_cookie( $userID, true, false );
        do_action( 'wp_login', $user_vat );
        
        header('Location: /create-account/?'. $email );  

    }else{
        $_SESSION['errors'] = $errors['errors_con'];
        header('Location: /create-account/?'. $email);  
    }
    
}



add_action( 'admin_post_nopriv_update_form', 'update_form_data' );
add_action( 'admin_post_update_form', 'update_form_data' );
function update_form_data() {
    
    update_field('name', 'crossing-borders.dk', 'user_' . get_current_user_id());
    
    header('Location: ' . get_site_url() .'/author/' . wp_get_current_user()->user_nicename);  
}



function cvrapi($vat, $country)
{
  // Strip all other characters than numbers
  $vat = preg_replace('/[^0-9]/', '', $vat);
  // Check whether VAT-number is invalid
  if(empty($vat) === true)
  {

    // Print error message
    return('Venligst angiv et CVR-nummer.');

  } else {

    // Start cURL
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, 'http://cvrapi.dk/api?vat=' . $vat . '&country=' . 'dk');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Fetching company information');

    // Parse result
    $result = curl_exec($ch);

    // Close connection when done
    curl_close($ch);

    // Return our decoded result
    return json_decode($result, 1);

  }
}



function acf_load_commune_field_choices($field ) {

    // create & initialize a curl session
    $curl = curl_init();

    // set our url with curl_setopt()
    curl_setopt($curl, CURLOPT_URL, "https://dawa.aws.dk/kommuner");

    // return the transfer as a string, also with setopt()
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    // curl_exec() executes the started curl session
    // $output contains the output string
    $output = curl_exec($curl);
    $choices = json_decode($output, true);

    $field['choices'] = array();

     
    // close curl resource to free up system resources
    // (deletes the variable made by curl_init)
    curl_close($curl);

    // loop through array and add to field 'choices'
    if( is_array($choices) ) {
        
        foreach( $choices as $choice ) {
            $field['choices'][$choice['kode']] = $choice['navn']; 
        }    
    }
    $choices = sort($field['choices']);
    $field['choices'][0] = __('Vælg kommune','sdg'); 
    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=commune', 'acf_load_commune_field_choices');


function acf_load_regions_field_choices($field) {

    // create & initialize a curl session
    $curl = curl_init();

    // set our url with curl_setopt()
    curl_setopt($curl, CURLOPT_URL, "https://dawa.aws.dk/regioner");

    // return the transfer as a string, also with setopt()
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    // curl_exec() executes the started curl session
    // $output contains the output string
    $output = curl_exec($curl);
    $choices = json_decode($output, true);

    $field['choices'] = array();

    
    // close curl resource to free up system resources
    // (deletes the variable made by curl_init)
    curl_close($curl);

    // loop through array and add to field 'choices'
    if( is_array($choices) ) {
        foreach( $choices as $choice ) {
            $field['choices'][$choice['dagi_id']] = $choice['navn']; 
        }    
    }
    $choices = sort($field['choices']);
    $field['choices'][0] = __('Vælg region','sdg'); 
    $field['choices'][1] = __('Hele danmark','sdg'); 
    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=regions', 'acf_load_regions_field_choices');



function acf_load_countries_field_choices($field) {

    // create & initialize a curl session
    $curl = curl_init();

    // set our url with curl_setopt()
    curl_setopt($curl, CURLOPT_URL, 'https://restcountries.eu/rest/v2/all?fields=name');

    // return the transfer as a string, also with setopt()
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    // curl_exec() executes the started curl session
    // $output contains the output string
    $output = curl_exec($curl);
    $choices = json_decode($output, true);

    $field['choices'] = array();

    
    // close curl resource to free up system resources
    // (deletes the variable made by curl_init)
    curl_close($curl);

    // loop through array and add to field 'choices'
    if( is_array($choices) ) {
        $i = 0;
        foreach( $choices as $choice ) {

            $field['choices'][$i] = $choice['name']; 
            $i++;
        }    
    }
    $choices = $field['choices'];
    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=countries', 'acf_load_countries_field_choices');


