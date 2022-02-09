<?php

/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package akuna
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php wp_body_open(); ?>

    <?php do_action('akuna_before_site'); ?>

    <div id="page" class="hfeed site">
        <?php do_action('akuna_before_header'); ?>

        <header id="masthead" class="site-header" role="banner" style="<?php akuna_header_styles(); ?>">

            <?php
            /**
             * Functions hooked into akuna_header action
             *
             * @hooked akuna_header_container                 - 0
             * @hooked akuna_primary_navigation_wrapper       - 10
             * @hooked akuna_primary_navigation               - 30
             * @hooked akuna_primary_navigation_wrapper_close - 50
             * @hooked akuna_site_branding                    - 70
             * @hooked akuna_header_container_close           - 90
             */
            do_action('akuna_header');

            if (is_page_template('template-fullwidth-product.php')) {
                /**
                 * Functions hooked into akuna_header_secondary action
                 *
                 * @hooked akuna_secondary_nav_container       - 10
                 * @hooked akuna_secondary_navigation          - 30
                 * @hooked akuna_secondary_nav_container_close - 50
                 */
                do_action('akuna_header_secondary');
                if (is_front_page()) {
                    /**
                     * Functions hooked in to akuna_homepage_hero
                     *
                     * @hooked akuna_homepage_content      - 10
                     */
                    do_action('akuna_homepage_hero');
                }
            }
            ?>

        </header><!-- #masthead -->

        <?php
        do_action('akuna_before_content');
        ?>

        <div id="content" class="site-content" tabindex="-1">
            <div class="col-full">

                <?php
                /**
                 * Functions hooked in to akuna_homepage_hero
                 *
                 * @hooked akuna_shop_messages      - 15
                 */
                do_action('akuna_content_top');
