<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package html24
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="utf-8">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    


    <!-- This script makes the HTML5 tags readable for IE -->
    <!--[if lt IE 9]> <script src="<?php bloginfo('template_directory'); ?>/js/plugins/html5shiv/html5shiv-printshiv.js"></script> <![endif]-->

    <?php wp_head(); ?>

    <!--    this will include the script that is added to Theme Settings -> Header-->
    <?php echo get_header_analytics_tracking_code(); ?>
    <link rel="manifest" crossorigin="use-credentials" href="manifest.json"/>
</head>

<body <?php body_class(); ?>>
    <div id="loading-screen">
        <div class="img-wrapper">
            <img src="/wp-content/themes/dist/img/sdg-circle.svg" alt="LOADING">
        </div>
    </div>
    <?php
    /*
 * Theme Settings > Header
 */
    echo get_body_analytics_tracking_code();
    ?>
    <div class="overlay"></div>
    <div id="page" class="site">
        <header>
            <div id="top-nav" class="py-1">
                <div class="container-fluid">
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <ul class="nav mr-2">
                               
                       
                                <?php
                                // get menu
                                // By location.
                                $menu_name = 'secondary';
                                $locations = get_nav_menu_locations();
                                $menu_id   = $locations[$menu_name];
                                $menu = wp_get_nav_menu_items($menu_id);

                                foreach ($menu as $item) {
                                    //var_dump($item);
                                    echo' <li class="nav-item">';
                                        echo' <a class="nav-link" targer="'.$item->target.'" href="'. $item->url .'">'.$item->title.'</a>';
                                    echo' </li>';
                                }
                                
                                ?>
                                <li class="nav-item">

                                    <?php
                                    if (is_user_logged_in()) : ?>
                                        <div class="dropdown dropleft pt-2 mx-2">
                                            <a class=" " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-user"></i> <?= __('My profile', 'wordpress') ?>
                                            </a>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="<?= admin_url('edit.php?post_type=projects') ?>"><?= __('Projects', 'wordpress') ?></a>
                                                <a class="dropdown-item" href="<?= admin_url('profile.php') ?>"><?= __('Edit profile', 'wordpress') ?></a>
                                                <a class="dropdown-item" href="<?= get_author_posts_url(get_current_user_id(), wp_get_current_user()->user_nicename) ?>"><?= __('Go to profile', 'wordpress') ?></a>
                                                <a class="dropdown-item" href="<?= wp_logout_url(get_home_url()) ?>"><?= __('Log out', 'wordpress') ?></a>
                                            </div>
                                        </div>

                                    <?php
                                    else :
                                        echo '<a class="nav-link" href="'. get_permalink().'wp-admin">'.__('Log ind','sdg').'</a>';
                                    endif;
                                    
                                    ?>
                                </li>
                                
                                <li class="nav-item">
                                <?= do_shortcode('[gtranslate]'); ?>
                                </li>
                                <li>
                                <?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>
                                </li>
                            </ul>
                            <!-- <div class="dropdown dropleft pt-2">
                                <a class=" " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    English
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="#">Dansk</a>
                                    <a class="dropdown-item" href="#">Deutsch</a>
                                    <a class="dropdown-item" href="#">Spanish</a>
                                </div>
                            </div> -->
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid bg-white">
                <div class="d-flex col px-auto px-md-0 py-md-4 py-2 justify-content-between">
                    <div class="logo">
                        <a href="<?= get_home_url() ?>"><img src="<?= get_field('logo', 'options'); ?>" alt="Logo"></a>
                    </div>

                    <div id="mobile-nav">
                        <div class="hamburger hamburger--arrowalt js-hamburger">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </div>

                    <nav id="navigation" class="ml-auto align-items-center ">
                        <?php wp_nav_menu(); ?>
                    </nav>

                    <div class="nav-cta">
                        <?php
                        // get menu
                        // By location.
                        $menu_name = 'primary';
                        $locations = get_nav_menu_locations();
                        $menu_id   = $locations[$menu_name];
                        $menu = wp_get_nav_menu_object($menu_id);
                        $cta_btn = get_field('cta_btn', $menu);
                        $link_obj = $cta_btn['link'];

                        if(isset($link_obj)){
                            echo '<a class="btn btn-lg btn-primary ml-3" target="'.$link_obj['target'].'" href="'. $link_obj['url'] .'">'.$link_obj['title'].'</a>';
                        }
                        ?>
                        
                    </div>

                </div>
            </div>


        </header>

        <div id="content" class="site-content">