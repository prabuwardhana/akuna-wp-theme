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

add_action('akuna_footer', 'akuna_handheld_footer_bar', 999);

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
 * @see akuna_sticky_single_add_to_cart()
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
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

add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 5);
add_action('woocommerce_shop_loop_item_title', 'akuna_template_loop_product_title', 10);
add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 15);

add_action('woocommerce_before_shop_loop_item_title', 'akuna_product_images_wrapper', 5);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 6);
add_action('woocommerce_before_shop_loop_item_title', 'akuna_template_loop_product_thumbnail', 10);
add_action('woocommerce_before_shop_loop_item_title', 'akuna_show_product_sale_featured', 20);
add_action('woocommerce_before_shop_loop_item_title', 'akuna_product_images_wrapper_close', 30);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 40);
add_action('woocommerce_before_shop_loop_item_title', 'akuna_product_loop_below_image_wrapper', 50);
add_action('woocommerce_after_shop_loop_item_title', 'akuna_after_shop_loop_item_title_wrapper', 4);
add_action('woocommerce_after_shop_loop_item_title', 'akuna_template_loop_norating', 7);
add_action('woocommerce_after_shop_loop_item_title', 'akuna_after_shop_loop_item_title_wrapper_close', 15);
add_action('woocommerce_after_shop_loop_item', 'akuna_product_loop_below_image_wrapper_close', 15);
add_action('akuna_after_footer', 'akuna_sticky_single_add_to_cart', 999);

remove_action('woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating', 10);
remove_action('woocommerce_review_before', 'woocommerce_review_display_gravatar', 10);
add_action('akuna_woocommerce_reviews_summary', 'akuna_single_product_review_summary', 10);
add_action('woocommerce_review_before_comment_meta', 'akuna_review_header_wrapper', 10);
add_action('woocommerce_review_before_comment_meta', 'woocommerce_review_display_gravatar', 20);
add_action('woocommerce_review_meta', 'akuna_meta_rating_wrapper', 5);
add_action('woocommerce_review_meta', 'woocommerce_review_display_rating', 15);
add_action('woocommerce_review_meta', 'akuna_meta_rating_wrapper_close', 20);
add_action('woocommerce_review_meta', 'akuna_review_header_wrapper_close', 30);

add_filter('woocommerce_product_description_heading', '__return_null');

/**
 * Review Title
 *
 * @see akuna_review_header_text()
 * @see akuna_no_review_header_text()
 */
add_filter('woocommerce_reviews_title', 'akuna_review_header_text', 10, 3);
add_filter('gettext', 'akuna_no_review_header_text', 20, 3);
add_filter('ngettext', 'akuna_no_review_header_text', 20, 3);

/**
 * Related Product Title
 *
 * @see akuna_upsell_header_text()
 */
add_filter('gettext', 'akuna_upsell_header_text', 10, 3);
add_filter('ngettext', 'akuna_upsell_header_text', 10, 3);

/**
 * Header
 *
 * @see akuna_header_cart()
 */
add_action('akuna_header', 'akuna_header_cart', 80);

/**
 * Cart fragment
 *
 * @see akuna_cart_link_fragment()
 */
add_filter('woocommerce_add_to_cart_fragments', 'akuna_cart_link_fragment');

/**
 * Cart widget
 *
 * @see akuna_widget_shopping_cart_button_view_cart()
 * @see akuna_widget_shopping_cart_proceed_to_checkout()
 */
remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10);
remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20);
add_action('woocommerce_widget_shopping_cart_buttons', 'akuna_widget_shopping_cart_button_view_cart', 10);
add_action('woocommerce_widget_shopping_cart_buttons', 'akuna_widget_shopping_cart_proceed_to_checkout', 20);

/**
 * Cart Page
 *
 * @see akuna_cart_progress()
 * @see akuna_button_proceed_to_checkout()
 * @see akuna_quantity_plus_sign()
 * @see akuna_quantity_minus_sign()
 */
remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
add_action('woocommerce_before_cart', 'akuna_cart_progress');
add_action('woocommerce_after_quantity_input_field', 'akuna_quantity_plus_sign');
add_action('woocommerce_before_quantity_input_field', 'akuna_quantity_minus_sign');
add_action('woocommerce_proceed_to_checkout', 'akuna_button_proceed_to_checkout', 20);
add_action('woocommerce_proceed_to_checkout', 'akuna_coupon', 15);

/**
 * Checkout Page
 *
 * @see akuna_cart_progress()
 */
add_action('woocommerce_before_checkout_form', 'akuna_cart_progress', 5);
