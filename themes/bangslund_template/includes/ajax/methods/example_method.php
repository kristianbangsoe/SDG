<?php
/**
 * Created by PhpStorm.
 * User: Daniela
 * Date: 30/10/2018
 * Time: 11:29 AM
 */

//example of the function
function example_method(){
    $responseBodyJson = [];

   //your code in here
    $responseBodyJson['test_from_the_methdod'] = 'test';
    $responseBodyJson['post_data_sent'] = $_POST;

    //send back the responseBodyJson to frontend
    //it will be send tot the call_back function
    echo json_encode($responseBodyJson);
    die();
}