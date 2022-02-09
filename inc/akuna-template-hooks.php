<?php

/**
 * akuna hooks
 *
 * @package akuna
 */

/**
 * Header
 *
 * @see  akuna_primary_navigation()
 * @see  akuna_site_branding()
 * @see  akuna_secondary_navigation()
 */

add_action('akuna_header', 'akuna_header_container', 0);
add_action('akuna_header', 'akuna_primary_navigation_wrapper', 10);
add_action('akuna_header', 'akuna_primary_navigation', 30);
add_action('akuna_header', 'akuna_primary_navigation_wrapper_close', 50);
add_action('akuna_header', 'akuna_site_branding', 70);
add_action('akuna_header', 'akuna_header_container_close', 90);
add_action('akuna_header_secondary', 'akuna_secondary_nav_container', 10);
add_action('akuna_header_secondary', 'akuna_secondary_navigation', 30);
add_action('akuna_header_secondary', 'akuna_secondary_nav_container_close', 50);

/**
 * Footer
 *
 * @see  akuna_footer_widgets()
 * @see  akuna_credit()
 */
add_action('akuna_footer', 'akuna_footer_widgets', 10);
add_action('akuna_footer', 'akuna_credit', 30);

/**
 * Posts
 *
 * @see  akuna_post_header()
 * @see  akuna_post_meta()
 * @see  akuna_post_taxonomy()
 * @see  akuna_paging_nav()
 */
add_action('akuna_loop_post', 'akuna_post_header', 10);
add_action('akuna_loop_post', 'akuna_post_content', 30);
add_action('akuna_loop_post', 'akuna_post_taxonomy', 50);
add_action('akuna_loop_after', 'akuna_paging_nav', 10);
add_action('akuna_single_post', 'akuna_post_header', 10);
add_action('akuna_single_post', 'akuna_post_content', 30);
add_action('akuna_single_post_bottom', 'akuna_edit_post_link', 10);
add_action('akuna_single_post_bottom', 'akuna_post_taxonomy', 30);
add_action('akuna_single_post_bottom', 'akuna_post_nav', 50);
add_action('akuna_single_post_bottom', 'akuna_display_comments', 70);

/**
 * Homepage
 *
 * @see  akuna_homepage_content()
 */
add_action('homepage', 'akuna_homepage_content', 10);

/**
 * Homepage Page Template
 *
 * @see  akuna_hero_image_slider()
 * @see  akuna_page_content()
 */
add_action('akuna_homepage_hero', 'akuna_hero_image_slider', 10);
add_action('akuna_homepage', 'akuna_page_content', 10);

/**
 * Pages
 *
 * @see  akuna_page_header()
 * @see  akuna_page_content()
 * @see  akuna_edit_post_link()
 * @see  akuna_display_comments()
 */
add_action('akuna_page', 'akuna_page_header', 10);
add_action('akuna_page', 'akuna_page_content', 30);
add_action('akuna_page', 'akuna_edit_post_link', 50);
add_action('akuna_page_after', 'akuna_display_comments', 10);
add_action('akuna_product_page', 'akuna_page_content', 10);
add_action('akuna_product_page', 'akuna_edit_post_link', 30);
