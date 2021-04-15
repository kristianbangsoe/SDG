<section class="featured-section pt-4 py-5 <?=get_sub_field('background_color')?> ">
    <div class="container-fluid py-0 py-md-5 my-0 my-md-5 ">
        <div class="row">
        <?php 
        switch (get_sub_field('select_content_type')) {
            case 'news':
                include __DIR__ . '/feeds/news.php';
                break;
            case 'events':
                include __DIR__ . '/feeds/events.php';
                break;
            case 'projects':
                include __DIR__ . '/feeds/projects.php';
                break;
            default:
                include __DIR__ . '/feeds/news.php';
                break;
        }

        ?>
        </div>
    </div>
</section>