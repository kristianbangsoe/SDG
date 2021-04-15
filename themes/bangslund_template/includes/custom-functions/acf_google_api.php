<?php
/**
 * Created by PhpStorm.
 * User: Daniela P.
 * Date: 30/10/18
 * Time: 15:37
 */



//use this too inlcude your google api key
//this allows you to use Google Map ACF field
// remember to inlclude the script in includes/enqueues/frontend/scripts.php
function my_acf_init() {

    acf_update_setting('google_api_key', 'xxx');
}

add_action('acf/init', 'my_acf_init');