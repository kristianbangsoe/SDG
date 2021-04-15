<?php

/**
 * The template for displaying Author Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 * <i class="goal-size-1 goal-<?= get_field('sdg_id', 'category_' . $category_id); ?>"></i>
 */

get_header();


$author = get_user_by('slug', get_query_var('author_name'));
$user_id = $author->ID;
$user = get_user_meta($author->ID);
$name = $user['name'][0];
$website = $user['website'][0];
$nice_website = preg_replace("#^[^:/.]*[:/]+#i", "", $website);
$cvr = $user['cvr_nr'][0];
$phone = isset($user['phone'][0]) ? $user['phone'][0] : __('Number not submitted', 'wordpress');
$logo = wp_get_attachment_image_src($user['logo'][0], 'large')[0];

if (!isset($logo, $name)) :
    header('Location: ' . get_site_url());
endif;

$name = $user['name'][0];
$description = get_field('description_2', 'user_' . $user_id);
$description = preg_replace("/\<h1(.*)\>(.*)\<\/h1\>/", "<h2$1>$2</h2>", $description); //remove <h1>
$first_name = $user['first_name'][0];
$last_name = $user['last_name'][0];
$email = get_the_author_meta('user_email');
$addresse = get_field('addresse', 'user_' . $user_id);

//print_r(get_user_meta($author->ID));

$author_posts = get_posts(array(
    'author'      =>  $author->ID,
    'numberposts' => -1, // Number of recent posts thumbnails to display
    'post_status' => 'publish', // Show only the published posts
    'post_type'   => 'projects',
    'orderby'     => 'date',
    'order'       => 'DESC'
));
?>

<section class="hero-section">
    <div class="container-fluid">
        <div class="col px-0 px-sm-auto">
            <div style="--hero-image: url('<?= the_post_thumbnail_url() ?>')" class="bg-image">
                <div style="height: 250px;" class="hero-wrapper  py-5 px-4 px-md-5 ">
                </div>
            </div>
        </div>
    </div>
</section>
<section class="profile mb-5">
    <div class="container ">
        <div class="row profile-header mb-4">
            <div class="col-12 ">
                <h1 class="mb-2"><?= $name ?></h1>
                <a class="text-uppercase" href="<?= $website ?>"><?= $nice_website ?></a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 ">
                <div class="box-shadow ">
                    <ul class="nav tab-section" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><?= __('About us', 'wordpress') ?></a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                        </li>
                    </ul>
                    <div class="tab-content p-5" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <?= $description ?>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <p>hello 2</p>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <p>hello 3</p>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <h3 class="mb-4"><?= __('Current projects', 'wordpress') ?></h3>

                    <?php
                    if ($author_posts) : 
                        $row_index = 0;

                        foreach ($author_posts as $post) :  // variable must be called $post (IMPORTANT)
                            setup_postdata($post);
                            $category_id = get_field('main_goal');
                            $categories = get_the_category();
                            foreach ($categories as $key => $category) {
                                $category_name = $category->name . ' | ';
                            }
                        ?>
                            <div class=" card-item project-item box-shadow ">
                                <a class="d-flex bg-white" href="<?php the_permalink(); ?>">
                                   
                                    <div class="d-flex">
                                        <img class="item-cover" src="<?= get_the_post_thumbnail_url(NULL, 'medium') ?>" alt="<?php the_title(); ?>">
                                        <div class="p-3 d-flex flex-column">
                                            <div class="card-details d-flex mb-2 color-green"><?= $category_name ?></div>
                                            <h4 class="excerpt"><?php excerpt(15, get_the_title()); ?></h4>
                                            <p class="mb-0 mt-2"><?php excerpt(15, get_the_excerpt()); ?></p>
                                        </div>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-center align-items-center">
                                        <i class="sdg-icon sdg-arrow mr-4"></i>
                                    </div>
                                    
                                </a>
                            </div>
                        <?php endforeach;
                        wp_reset_postdata();
                    endif;?>
                </div>
            </div>
                <div class="col-lg-4">

                    <div class="bg-white box-shadow default-col p-5">
                        <img class="profile-logo" src="<?= $logo ?>" alt="<?= $name ?>">
                        <address class="profile-contact mt-4 ">
                            <h3 class="mb-3"><?= __('Contact information', 'wordpress') ?></h3>
                            <div class="contact-item d-flex justify-content-between">
                                <p class="contact-title"><?= __('E-mail:', 'wordpress') ?></p>
                                <p><a href="mailto:<?= $email ?>"><?= $email ?></a></p>
                            </div>
                            <?php if ($phone) : ?>
                                <div class="contact-item d-flex justify-content-between">
                                    <p class="contact-title"><?= __('Phone:', 'wordpress') ?></p>
                                    <p><a href="tel:+45<?= $phone ?>">+45 <?= $phone ?></a></p>
                                </div>
                            <?php endif; ?>
                            <?php if ($website) : ?>
                                <div class="contact-item d-flex justify-content-between">
                                    <p class="contact-title"><?= __('Website', 'wordpress') ?></p>
                                    <p><a href="<?= $website ?>"><?= $nice_website ?></a></p>
                                </div>
                            <?php endif; ?>
                            <?php if ($cvr) : ?>
                                <div class="contact-item d-flex justify-content-between">
                                    <p class="contact-title"><?= __('CVR Nr.', 'wordpress') ?></p>
                                    <p><a target="_blank" href="https://datacvr.virk.dk/data/visenhed?enhedstype=virksomhed&id=<?= $cvr ?>"><?= $cvr ?></a></p>
                                </div>
                            <?php endif; ?>
                            <?php if ($addresse['address'] && $addresse['postnummer'] && $addresse['by']) : ?>
                                <div class="contact-item">
                                    <p class="contact-title mb-2"><?= __('Address:', 'wordpress') ?></p>
                                    <p><?= $addresse['address'] . ', ' . $addresse['postnummer'] . ' ' . $addresse['by'] ?></p>
                                </div>
                            <?php endif; ?>
                        </address>
                        <div class="profile-some mt-3">
                            <?php
                            if (have_rows('sociale_medier', 'user_' . $user_id)) :
                                echo '<p class="some-title">' . __('Social media', 'wordpress') . ':</p>';
                                echo '<ul class="d-flex">';
                                while (have_rows('sociale_medier', 'user_' . $user_id)) : the_row();
                                    echo '<li><a href="' . get_sub_field('link') . '"><i class="fa fa-' . get_sub_field('type') . '"></i></a></li>';
                                endwhile;
                                echo '</ul>';
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<?php 
//localhost:3000/wp-content/themes/dist
    include_once get_template_directory_uri() .'/module-templates/frontend/default-section/newsletter.php';
?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>