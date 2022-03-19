<?php

/**
 * The template used for displaying page content in template-homepage.php
 *
 * @package akuna
 */

?>

<?php
// $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
?>

<div class="col-full">
    <?php
    /**
     * Functions hooked in to akuna_page add_action
     *
     * @hooked akuna_page_content         - 10
     */
    do_action('akuna_homepage');
    ?>
</div> <!-- homepage content -->