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

/**
 * Single Product Page
 *
 * @see akuna_single_product_cat()
 * @see akuna_single_product_attribute()
 * @see akuna_edit_post_link()
 * @see akuna_show_product_sale_featured()
 * @see akuna_product_review()
 * @see akuna_upsell_display()
 * @see akuna_template_loop_product_title()
 * @see akuna_single_product_pagination()
 * @see akuna_sticky_single_add_to_cart()
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('woocommerce_single_product_summary', 'akuna_single_product_cat', 6);
add_action('woocommerce_single_product_summary', 'akuna_single_product_attribute', 25);
add_action('woocommerce_single_product_summary', 'akuna_edit_post_link', 60);

add_action('woocommerce_before_single_product_summary', 'akuna_product_images_summary_wrapper', 5);
add_action('woocommerce_before_single_product_summary', 'akuna_product_images_wrapper', 10);
add_action('woocommerce_before_single_product_summary', 'akuna_show_product_sale_featured', 20);
add_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 30);
add_action('woocommerce_before_single_product_summary', 'akuna_product_images_wrapper_close', 40);
add_action('woocommerce_after_single_product_summary', 'akuna_product_images_summary_wrapper_close', 5);

add_action('woocommerce_after_single_product_summary', 'akuna_single_product_review', 15);
add_action('woocommerce_after_single_product_summary', 'akuna_upsell_display', 25);

add_action('woocommerce_shop_loop_item_title', 'akuna_template_loop_product_title', 10);

add_action('woocommerce_before_shop_loop_item_title', 'akuna_product_images_wrapper', 5);
add_action('woocommerce_before_shop_loop_item_title', 'akuna_template_loop_product_thumbnail', 10);
add_action('woocommerce_before_shop_loop_item_title', 'akuna_show_product_sale_featured', 20);
add_action('woocommerce_before_shop_loop_item_title', 'akuna_product_images_wrapper_close', 30);
add_action('akuna_after_footer', 'akuna_sticky_single_add_to_cart', 999);
