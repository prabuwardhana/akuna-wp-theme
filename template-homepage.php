<?php

/**
 * The template for displaying the homepage.
 *
 * Template name: Homepage
 *
 * @package akuna
 */

get_header(); ?>

<div id="primary" class="content-area">
    <?php
    /**
     * Functions hooked in to akuna_homepage_hero
     *
     * @hooked akuna_homepage_content      - 10
     */
    do_action('akuna_homepage_before_main');
    ?>
    <main id="main" class="site-main" role="main">
        <?php
        /**
         * Functions hooked in to homepage action
         *
         * @hooked akuna_homepage_content      - 10
         */
        do_action('homepage');
        ?>
    </main><!-- #main -->
    <?php do_action('akuna_homepage_after_main'); ?>
</div><!-- #primary -->
<?php
get_footer();
