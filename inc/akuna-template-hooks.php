<?php

/**
 * akuna hooks
 *
 * @package akuna
 */

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
