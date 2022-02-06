<?php

/**
 * The template for displaying full width pages without page title.
 *
 * Template Name: Full width Without Title
 *
 * @package akuna
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php
        while (have_posts()) :
            the_post();

            do_action('akuna_page_no_title');

        endwhile; // End of the loop.
        ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php

get_footer();
