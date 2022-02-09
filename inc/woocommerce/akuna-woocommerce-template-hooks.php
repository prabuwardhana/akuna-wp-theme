<?php

/**
 * akuna WooCommerce hooks
 *
 * @package akuna
 */

/**
 * Archive Page Layout
 *
 * @see  akuna_before_content()
 * @see  akuna_after_content()
 * @see  akuna_shop_messages()
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
add_action('woocommerce_before_main_content', 'akuna_before_content', 10);
add_action('woocommerce_after_main_content', 'akuna_after_content', 10);
add_action('akuna_content_top', 'akuna_shop_messages', 15);

add_action('woocommerce_after_shop_loop', 'akuna_sorting_wrapper', 9);
add_action('woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10);
add_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 20);
add_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 30);
add_action('woocommerce_after_shop_loop', 'akuna_sorting_wrapper_close', 31);

add_action('woocommerce_before_shop_loop', 'akuna_sorting_wrapper', 9);
add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10);
add_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
add_action('woocommerce_before_shop_loop', 'akuna_woocommerce_pagination', 30);
add_action('woocommerce_before_shop_loop', 'akuna_sorting_wrapper_close', 31);
