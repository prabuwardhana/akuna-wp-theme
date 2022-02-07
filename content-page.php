<?php

/**
 * The template used for displaying page content in page.php
 *
 * @package akuna
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    /**
     * Functions hooked into akuna_page add_action
     *
     * @hooked akuna_page_header          - 10
     * @hooked akuna_page_content         - 30
     * @hooked akuna_edit_post_link       - 50
     */
    do_action('akuna_page');
    ?>
</article><!-- #post-## -->