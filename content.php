<?php

/**
 * Template used to display post content.
 *
 * @package akuna
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php
    /**
     * Functions hooked into akuna_loop_post action.
     *
     * @hooked akuna_post_header          - 10
     * @hooked akuna_post_content         - 30
     * @hooked akuna_post_taxonomy        - 50
     */
    do_action('akuna_loop_post');
    ?>

</article><!-- #post-## -->