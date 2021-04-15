<?php
/**
 * Created by PhpStorm.
 * User: Daniela P.
 * Date: 30/10/18
 * Time: 13:38
 */

function current_user_roles(){
    $user = wp_get_current_user();
    $userRoles = $user->roles;
    //this return an array
    return $userRoles;
}

function current_user_id(){
    $user = wp_get_current_user();
    $userId = $user-> ID;
    return $userId;
}


function is_user_in_role( $user_id, $role  ) {
    //if id was not sent stop the function
    if(empty($user_id)){
        return 'user id was not sent';
    }

    //get user info
    $useInfo = get_userdata($user_id);
    //get user role
    $userRoles = $useInfo -> roles;
    //if user_id is empty return all roles
    if(empty($role)) return $userRoles;

    //returns true if the user has the role sent, false otherwise
    return in_array( $role,$userRoles);
}

// Create user roles
add_role( 'student', 'Student', get_role( 'subscriber' )->capabilities );
add_role( 'private', 'Private', get_role( 'subscriber' )->capabilities );
add_role( 'business', 'Business | Goverment', get_role( 'subscriber' )->capabilities );
add_role( 'ngo', 'NGO', get_role( 'subscriber' )->capabilities );

