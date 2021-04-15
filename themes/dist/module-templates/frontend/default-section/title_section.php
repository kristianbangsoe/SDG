<?php
/**
 * Created by PhpStorm.
 * User: Daniela P.
 * Date: 30/10/18
 * Time: 10:54
 */
?>

<?php
//get title
$pageTitle = get_the_title();

//get title from the backend
$newTitle = get_sub_field('title_section');

//check if the user decides to change the title of the page.
if(!empty($newTitle)){
    $pageTitle = $newTitle;
}
?>

<!--start title section markup -->
<section class="title_section py-5">
    <h1 class="text-center"><?= $pageTitle;?></h1>
</section>
<!--end title markup -->