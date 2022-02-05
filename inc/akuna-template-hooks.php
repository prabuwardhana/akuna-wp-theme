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
