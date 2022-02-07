<?php

/**
 * Template used to display post content on single pages.
 *
 * @package akuna
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php
    do_action('akuna_single_post_top');

    /**
     * Functions hooked into akuna_single_post add_action
     *
     * @hooked akuna_post_header          - 10
     * @hooked akuna_post_content         - 30
     * @hooked akuna_post_taxonomy        - 30
     */
    do_action('akuna_single_post');

    /**
     * Functions hooked in to akuna_single_post_bottom action
     *
     * @hooked akuna_edit_post_link   - 10
     * @hooked akuna_post_taxonomy    - 30
     * @hooked akuna_post_nav         - 50
     * @hooked akuna_display_comments - 70
     */
    do_action('akuna_single_post_bottom');
    ?>

</article><!-- #post-## -->