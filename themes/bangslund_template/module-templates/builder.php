<?php
/**
 * Created by PhpStorm.
 * User: Daniela Popescu
 * Date: 06/08/18
 * Time: 14:00
 */

// check if the flexible content field has rows of data
if( have_rows('page_builder') ):

    // loop through the rows of data
    while ( have_rows('page_builder') ) : the_row();

        switch( get_row_layout() ) {
            //case - the section inside page_builder
            case 'full_width_section':
                include __DIR__ . '/frontend/default-section/full_section.php';
                break;
            case 'faq_section':
                include __DIR__ . '/frontend/default-section/faq.php';
                break;
            case '2_columns_section':
                include __DIR__ . '/frontend/default-section/2_columns_section.php';
                break;
            case '3_columns_section':
                include __DIR__ . '/frontend/default-section/3_columns_section.php';
                break;
            case '4_columns_section':
                include __DIR__ . '/frontend/default-section/4_columns_section.php';
                break;
            case 'title_section':
                include __DIR__ . '/frontend/default-section/title_section.php';
                break;
            case 'hero_section':
                include __DIR__ . '/frontend/default-section/hero_section.php';
                break;
            case 'logo_section':
                include __DIR__ . '/frontend/default-section/logo_section.php';
                break;
            case 'overview_section':
                include __DIR__ . '/frontend/default-section/overview_section.php';
                break;
            case 'image_box_section':
                include __DIR__ . '/frontend/default-section/image_box_section.php';
                break;
            case 'featured_section':
                include __DIR__ . '/frontend/default-section/featured_section.php';
                break;
            case 'newsletter_section':
                include __DIR__ . '/frontend/default-section/newsletter.php';
                break;
            case 'pricing_plans':
                include __DIR__ . '/frontend/default-section/pricing-plans_section.php';
                break;    
            default:

        }

    endwhile;
endif;

//Remember:
// - you have to include the page builder on the templates. Look on page.php for inspiration
// - make sure the path is correct otherwise you will not see anything :)