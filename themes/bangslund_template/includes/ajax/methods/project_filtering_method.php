<?php
/**
 * Created by PhpStorm.
 * User: Daniela
 * Date: 30/10/2018
 * Time: 11:29 AM
 */

//example of the function
function project_filtering_method(){

    
    $sdg_category = $_POST['sdg_category'] != 0 ? $_POST['sdg_category'] : -1;
    $location = $_POST['kommune'];
    $company_type = str_replace(' ', '', $_POST['company_type']);
    $search_term = $_POST['search'];
    $post_amount = $_POST['post_amount'];
    

    if ($_POST['sdg_category'] != 0) {
       $tax_query = [
            [
                'taxonomy' => 'category',
                'terms' => $sdg_category,
                'include_children' => true // Remove if you need posts from term 7 child terms
            ],
        ];
    }else{
        $tax_query = [];
    }

    if ($_POST['kommune'] != 0) {
        if (strpos($location, 'region') !== false) {
            $location = str_replace('region_', '', $location );
            $query = array(
                'relation'		=> 'AND',
                array(
                    'key'	 	=> 'regions',
                    'value'	  	=> $location,
                    'compare' 	=> '===',
                ),
            );
    
        }elseif (strpos($location, 'commune') !== false) {
            $location = str_replace('commune_', '', $location );
            $query = array(
                'relation'		=> 'AND',
                array(
                    'key'	 	=> 'commune',
                    'value'	  	=> $location,
                    'compare' 	=> '===',
                ),
            );
            
        }
    }else{
        $query = [];
    }
    
    
    if ($post_amount == 2) {
        $startfrom = 0;
    }else{
        $startfrom = $post_amount;
    }

    $get_all_posts = get_posts(array(
        'posts_per_page' => $post_amount,
        'offset' => $startfrom, 
        'post_status' => 'publish', // Show only the published posts
        'post_type'   => 'projects',
        'orderby'     => 'date',
        's' => $search_term,
        'order'       => 'DESC',
        'meta_query'	=> $query,
        'tax_query' => $tax_query,
        
    ));
    $results = [];

    if ($get_all_posts && !empty($get_all_posts)) : 
        $formatted_posts['posts'] = [];
        foreach($get_all_posts as $post):

            if ( isset($post->ID) ) {
            
                $author = get_userdata($post->post_author);
                $user_company = get_field('company_type', 'user_'. $author->ID);
                $user_label = str_replace(' ', '', $user_company['label']);
                $project_location = get_field('project_location', $post->ID);
                $company_validate = urlencode($user_label) === urlencode($company_type) ? true : false;
                $image = get_the_post_thumbnail_url($post->ID, 'medium');
                $sdg_logo = get_field('logo', 'user_' . $post->post_author);
                $title =  wp_html_excerpt( $post->post_title, 75, '&#8230;' );
                $category_id = get_field('main_goal', $post->ID);
                $sdg_id = get_field('sdg_id', 'category_'.$category_id);
                if($company_type == '0'){
                   
                    $results['post_items'][$post->ID] = [
                        'post_title' => $title,
                        'post_excerpt' => $post->post_excerpt,
                        'post_date' => $post->post_date,
                        'post_url' => get_permalink($post->ID),
                        'post_id' => $post->ID,
                        'post_image' => $image,
                        'post_type' => $post->post_type,
                        'post_company' => $user_company['label'],
                        'post_company_logo' => $sdg_logo['url'],
                        'post_company_name' => get_field('name', 'user_'. $author->ID),
                        'post_category' => get_the_category($post->ID),
                        'post_category_id' => $sdg_id,
                        'post_location' => $project_location,
                    ];
                
                }else{
                    if ($company_validate == true) {

                        $results['post_items'][$post->ID] = [
                            'post_title' => $title,
                            'post_excerpt' => $post->post_excerpt,
                            'post_date' => $post->post_date,
                            'post_url' => get_permalink($post->ID),
                            'post_id' => $post->ID,
                            'post_image' => $image,
                            'post_type' => $post->post_type,
                            'post_company' => $user_company['label'],
                            'post_company_logo' => $sdg_logo['url'],
                            'post_company_name' => get_field('name', 'user_'. $author->ID),
                            'post_category' => get_the_category($post->ID),
                            'post_location' => $project_location,
                        ];
                    }
                    
                }
            
            }else{
                $results['post_items'] = false;
            }
                
        endforeach;

        $results['post_items'] = $results['post_items'] == [] ? false : $results['post_items'];
        echo json_encode($results);
        

    else: 
        $results['post_items'] = 'undefined';
        echo json_encode($results);
    endif;
   //send back the responseBodyJson to frontend
    //it will be send tot the call_back function
    
    die();
}