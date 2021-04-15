<?php 
// Registrer custom table columns
add_filter( 'manage_users_columns', 'set_custom_edit_users_columns' );
add_filter( 'manage_users_custom_column' , 'custom_users_column', 10, 3 );

function set_custom_edit_users_columns($columns) {

    $columns['status'] = __( 'Status', 'wordpress' );
    $columns['type'] = __( 'Type', 'wordpress' );

    return $columns;
}

function custom_users_column($value, $column_name, $user_id ) {
    
    if ($column_name == 'status') { 
        return get_field('user_status', 'user_'.$user_id)['label'];
    }

    if ($column_name == 'type') { 

        return get_field('company_type', 'user_'.$user_id)['label'];
    }

}