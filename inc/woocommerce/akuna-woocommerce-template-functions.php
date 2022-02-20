<?php

/**
 * WooCommerce Template Functions.
 *
 * @package akuna
 */

if (!function_exists('akuna_before_content')) {
    /**
     * Before Content
     * Wraps all WooCommerce content in wrappers which match the theme markup
     *
     * @since   1.0.0
     * @return  void
     */
    function akuna_before_content()
    {
?>
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
            <?php
        }
    }

    if (!function_exists('akuna_after_content')) {
        /**
         * After Content
         * Closes the wrapping divs
         *
         * @since   1.0.0
         * @return  void
         */
        function akuna_after_content()
        {
            ?>
            </main><!-- #main -->
        </div><!-- #primary -->

    <?php
        }
    }

    if (!function_exists('akuna_shop_messages')) {
        /**
         * akuna shop messages
         *
         * @since   1.0.0
         * @uses    akuna_do_shortcode
         */
        function akuna_shop_messages()
        {
            if (!is_checkout()) {
                echo wp_kses_post(akuna_do_shortcode('woocommerce_messages'));
            }
        }
    }

    if (!function_exists('akuna_sorting_wrapper')) {
        /**
         * Sorting wrapper
         *
         * @since   1.0.0
         * @return  void
         */
        function akuna_sorting_wrapper()
        {
            echo '<div class="akuna-sorting">';
        }
    }

    if (!function_exists('akuna_sorting_wrapper_close')) {
        /**
         * Sorting wrapper close
         *
         * @since   1.0.0
         * @return  void
         */
        function akuna_sorting_wrapper_close()
        {
            echo '</div>';
        }
    }

    if (!function_exists('akuna_single_product_cat')) {
        /**
         * Display single product category/categories list
         *
         * @since 1.0.0
         */
        function akuna_single_product_cat()
        {
            global $product;
    ?>
        <div class="akuna-single-product-cat">
            <?php echo wc_get_product_category_list($product->get_id()); ?>
        </div>
    <?php
        }
    }

    if (!function_exists('akuna_single_product_attribute')) {
        function akuna_single_product_attribute()
        {

            global $product;

            $attributes = $product->get_attributes();

            if (!$attributes) {

                return;
            }

            $display_result = '';


            foreach ($attributes as $attribute) {

                if ($attribute->get_variation()) {
                    continue;
                }

                $name = $attribute->get_name();

                if ($attribute->is_taxonomy()) {

                    $terms = wp_get_post_terms($product->get_id(), $name, 'all');

                    $tax = $terms[0]->taxonomy;

                    $object_taxonomy = get_taxonomy($tax);

                    if (isset($object_taxonomy->labels->singular_name)) {

                        $tax_label = $object_taxonomy->labels->singular_name;
                    } elseif (isset($object_taxonomy->label)) {

                        $tax_label = $object_taxonomy->label;

                        if (0 === strpos($tax_label, 'Product ')) {

                            $tax_label = substr($tax_label, 8);
                        }
                    }

                    $display_result .= $tax_label . ': ';

                    $tax_terms = array();

                    foreach ($terms as $term) {

                        $single_term = esc_html($term->name);

                        array_push($tax_terms, $single_term);
                    }

                    $display_result .= implode(', ', $tax_terms);
                } else {
                    $display_result .= esc_html(implode(', ', $attribute->get_options()));
                }
            }

            echo '<div class="akuna-product-attr">' . $display_result . '</div>';
        }
    }

    if (!function_exists('akuna_product_images_summary_wrapper')) {
        /**
         * Product image and summary wrapper
         *
         * @since 1.0.0
         */
        function akuna_product_images_summary_wrapper()
        {
            echo '<div class="akuna-product-image-summary">';
        }
    }

    if (!function_exists('akuna_product_images_summary_wrapper_close')) {
        /**
         * Product image and summary wrapper close
         *
         * @since 1.0.0
         */
        function akuna_product_images_summary_wrapper_close()
        {
            echo '</div>';
        }
    }

    if (!function_exists('akuna_product_images_wrapper')) {
        /**
         * Product image wrapper
         *
         * @since 1.0.0
         */
        function akuna_product_images_wrapper()
        {
            echo '<div class="akuna-product-image">';
        }
    }

    if (!function_exists('akuna_product_images_wrapper_close')) {
        /**
         * Product image wrapper close
         *
         * @since 1.0.0
         */
        function akuna_product_images_wrapper_close()
        {
            echo '</div>';
        }
    }

    if (!function_exists('akuna_show_product_sale_featured')) {
        /**
         * Display badges when product is on sale and or is featured
         *
         * @since 1.0.0
         */
        function akuna_show_product_sale_featured()
        {
            global $post, $product;
    ?>
        <div class="akuna-onsale-hot">
            <?php
            if ($product->is_on_sale()) {
                echo apply_filters('woocommerce_sale_flash', '<span class="akuna-onsale">' . esc_html__('Sale!', 'woocommerce') . '</span>', $post, $product);
            }
            if ($product->is_featured()) {
                echo apply_filters('woocommerce_sale_flash', '<span class="akuna-hot">' . esc_html__('Hot', 'woocommerce') . '</span>', $post, $product);
            }
            ?>
        </div>
    <?php
        }
    }

    if (!function_exists('akuna_single_product_review')) {
        /**
         * Display product review/s and review form
         *
         * @since 1.0.0
         */
        function akuna_single_product_review()
        {
    ?>
        <div class="akuna-product-review">
            <?php comments_template() ?>
        </div>
        </div>
    <?php
        }
    }

    if (!function_exists('akuna_meta_rating_wrapper')) {
        /**
         * Opening div for meta and rating
         *
         * @since 1.0.0
         */
        function akuna_meta_rating_wrapper()
        {
    ?>
        <div class="akuna-meta-rating-wrapper">
        <?php
        }
    }

    if (!function_exists('akuna_meta_rating_wrapper_close')) {
        /**
         * Closing div for meta and rating
         *
         * @since 1.0.0
         */
        function akuna_meta_rating_wrapper_close()
        {
        ?>
        </div>
    <?php
        }
    }

    if (!function_exists('akuna_review_header_wrapper')) {
        /**
         * Opening div for meta and rating
         *
         * @since 1.0.0
         */
        function akuna_review_header_wrapper()
        {
    ?>
        <div class="akuna-review-header-wrapper">
        <?php
        }
    }

    if (!function_exists('akuna_review_header_wrapper_close')) {
        /**
         * Closing div for meta and rating
         *
         * @since 1.0.0
         */
        function akuna_review_header_wrapper_close()
        {
        ?>
        </div>
    <?php
        }
    }

    if (!function_exists('akuna_upsell_display')) {
        /**
         * Upsells
         * Replace the default upsell function with our own which displays the correct number product columns
         *
         * @since   1.0.0
         * @return  void
         * @uses    woocommerce_upsell_display()
         */
        function akuna_upsell_display()
        {
            $columns = apply_filters('akuna_upsells_columns', 3);
            woocommerce_upsell_display(-1, $columns);
        }
    }

    if (!function_exists('akuna_template_loop_product_title')) {

        /**
         * Show the product title in the product loop. By default this is an H2.
         * 
         *  @since 1.0.0
         */
        function akuna_template_loop_product_title()
        {
            echo '<h2 class="' . esc_attr(apply_filters('woocommerce_product_loop_title_classes', 'akuna-loop-product__title')) . '">' . get_the_title() . '</h2>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }

    if (!function_exists('akuna_template_loop_product_thumbnail')) {

        /**
         * Get the product thumbnail for the loop.
         */
        function akuna_template_loop_product_thumbnail()
        {
            echo woocommerce_get_product_thumbnail('woocommerce_single');
        }
    }

    if (!function_exists('akuna_sticky_single_add_to_cart')) {
        /**
         * Sticky Add to Cart
         *
         * @since 1.0.0
         */
        function akuna_sticky_single_add_to_cart()
        {
            global $product;

            if (true !== get_theme_mod('akuna_sticky_add_to_cart')) {
                return;
            }

            if (!$product || !is_product()) {
                return;
            }

            $show = false;

            if ($product->is_purchasable() && $product->is_in_stock()) {
                $show = true;
            } elseif ($product->is_type('external')) {
                $show = true;
            }

            if (!$show) {
                return;
            }

            $params = apply_filters(
                'akuna_sticky_add_to_cart_params',
                array(
                    'trigger_class' => 'entry-summary',
                )
            );

            wp_localize_script('akuna-sticky-add-to-cart', 'akuna_sticky_add_to_cart_params', $params);

            wp_enqueue_script('akuna-sticky-add-to-cart');
    ?>
        <section class="akuna-sticky-add-to-cart">
            <div class="col-full">
                <div class="akuna-sticky-add-to-cart__content">
                    <?php echo wp_kses_post(woocommerce_get_product_thumbnail()); ?>
                    <div class="akuna-sticky-add-to-cart__content-product-info">
                        <span class="akuna-sticky-add-to-cart__content-title"><?php esc_html_e('You\'re viewing:', 'akuna'); ?> <strong><?php the_title(); ?></strong></span>
                        <span class="akuna-sticky-add-to-cart__content-price"><?php echo wp_kses_post($product->get_price_html()); ?></span>
                        <?php echo wp_kses_post(wc_get_rating_html($product->get_average_rating())); ?>
                    </div>
                    <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="akuna-sticky-add-to-cart__content-button button alt" rel="nofollow">
                        <?php echo esc_attr($product->add_to_cart_text()); ?>
                    </a>
                </div>
            </div>
        </section><!-- .akuna-sticky-add-to-cart -->
        <?php
        }
    }

    if (!function_exists('akuna_review_header_text')) {
        /**
         * Change default review header text
         *
         * @return string translated text
         */
        function akuna_review_header_text($translated, $text, $domain)
        {
            return 'Ratings and Reviews';
        }
    }

    if (!function_exists('akuna_review_header_text')) {
        /**
         * Change default review header text
         *
         * @return string translated text
         */
        function akuna_review_header_text($translated, $text, $domain)
        {
            return 'Ratings and Reviews';
        }
    }

    if (!function_exists('akuna_no_review_header_text')) {
        /**
         * Change default review header text
         *
         * @return string translated text
         */
        function akuna_no_review_header_text($translated, $text, $domain)
        {
            if (function_exists('is_product') && is_product() && $text == 'Reviews' && $domain == 'woocommerce') {
                $translated = esc_html__('Ratings and Reviews', $domain);
            }
            return $translated;
        }
    }

    if (!function_exists('akuna_upsell_header_text')) {
        /**
         * Change default related product header text
         *
         * @return string translated text
         */
        function akuna_upsell_header_text($translated, $text, $domain)
        {
            if (function_exists('is_product') && is_product() && $text === 'Related products' && $domain === 'woocommerce') {
                $translated = esc_html__('Discover more', $domain);
            }
            return $translated;
        }
    }

    if (!function_exists('akuna_product_search')) {
        /**
         * Display Product Search
         *
         * @since  1.0.0
         * @uses  akuna_is_woocommerce_activated() check if WooCommerce is activated
         * @return void
         */
        function akuna_product_search()
        {
            if (akuna_is_woocommerce_activated()) {
        ?>
            <div class="site-search">
                <?php the_widget('WC_Widget_Product_Search', 'title='); ?>
            </div>
        <?php
            }
        }
    }

    if (!function_exists('akuna_woo_cart_available')) {
        /**
         * Validates whether the Woo Cart instance is available in the request
         *
         * @since 1.0.0
         * @return bool
         */
        function akuna_woo_cart_available()
        {
            $woo = WC();
            return $woo instanceof \WooCommerce && $woo->cart instanceof \WC_Cart;
        }
    }

    if (!function_exists('akuna_handheld_footer_bar')) {
        /**
         * Display a menu intended for use on handheld devices
         *
         * @since 1.0.0
         */
        function akuna_handheld_footer_bar()
        {
            $links = array(
                'my-account' => array(
                    'priority' => 10,
                    'callback' => 'akuna_handheld_footer_bar_account_link',
                ),
                'search'     => array(
                    'priority' => 20,
                    'callback' => 'akuna_handheld_footer_bar_search',
                ),
                'cart'       => array(
                    'priority' => 30,
                    'callback' => 'akuna_handheld_footer_bar_cart_link',
                ),
            );

            if (did_action('woocommerce_blocks_enqueue_cart_block_scripts_after') || did_action('woocommerce_blocks_enqueue_checkout_block_scripts_after')) {
                return;
            }

            if (wc_get_page_id('myaccount') === -1) {
                unset($links['my-account']);
            }

            if (wc_get_page_id('cart') === -1) {
                unset($links['cart']);
            }

            $links = apply_filters('akuna_handheld_footer_bar_links', $links);
        ?>
        <div class="akuna-handheld-footer-bar">
            <ul class="columns-<?php echo count($links); ?>">
                <?php foreach ($links as $key => $link) : ?>
                    <li class="<?php echo esc_attr($key); ?>">
                        <?php
                        if ($link['callback']) {
                            call_user_func($link['callback'], $key, $link);
                        }
                        ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php
        }
    }

    if (!function_exists('akuna_handheld_footer_bar_search')) {
        /**
         * The search callback function for the handheld footer bar
         *
         * @since 1.0.0
         */
        function akuna_handheld_footer_bar_search()
        {
            echo '<a href="">' . esc_attr__('Search', 'akuna') . '</a>';
            akuna_product_search();
        }
    }

    if (!function_exists('akuna_handheld_footer_bar_cart_link')) {
        /**
         * The cart callback function for the handheld footer bar
         *
         * @since 1.0.0
         */
        function akuna_handheld_footer_bar_cart_link()
        {
            if (!akuna_woo_cart_available()) {
                return;
            }
    ?>
        <a class="footer-cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>"><?php esc_html_e('Cart', 'akuna'); ?>
            <span class="count"><?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?></span>
        </a>
    <?php
        }
    }

    if (!function_exists('akuna_handheld_footer_bar_account_link')) {
        /**
         * The account callback function for the handheld footer bar
         *
         * @since 1.0.0
         */
        function akuna_handheld_footer_bar_account_link()
        {
            echo '<a href="' . esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) . '">' . esc_attr__('My Account', 'akuna') . '</a>';
        }
    }

    if (!function_exists('akuna_cart_link')) {
        /**
         * Cart Link
         * Displayed a link to the cart including the number of items present and the cart total
         *
         * @return void
         * @since  1.0.0
         */
        function akuna_cart_link()
        {
            if (!akuna_woo_cart_available()) {
                return;
            }
    ?>
        <div class="cart-container">
            <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'akuna'); ?>">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 489 489" xml:space="preserve">
                    <path d="M440.1,422.7l-28-315.3c-0.6-7-6.5-12.3-13.4-12.3h-57.6C340.3,42.5,297.3,0,244.5,0s-95.8,42.5-96.6,95.1H90.3
		c-7,0-12.8,5.3-13.4,12.3l-28,315.3c0,0.4-0.1,0.8-0.1,1.2c0,35.9,32.9,65.1,73.4,65.1h244.6c40.5,0,73.4-29.2,73.4-65.1
		C440.2,423.5,440.2,423.1,440.1,422.7z M244.5,27c37.9,0,68.8,30.4,69.6,68.1H174.9C175.7,57.4,206.6,27,244.5,27z M366.8,462
		H122.2c-25.4,0-46-16.8-46.4-37.5l26.8-302.3h45.2v41c0,7.5,6,13.5,13.5,13.5s13.5-6,13.5-13.5v-41h139.3v41
		c0,7.5,6,13.5,13.5,13.5s13.5-6,13.5-13.5v-41h45.2l26.9,302.3C412.8,445.2,392.1,462,366.8,462z" />
                </svg>
                <span class="count">
                    <?php echo WC()->cart->get_cart_contents_count(); ?>
                </span>
            </a>
        </div>
        <?php
        }
    }

    if (!function_exists('akuna_header_cart')) {
        /**
         * Display Header Cart
         *
         * @since  1.0.0
         * @uses  akuna_is_woocommerce_activated() check if WooCommerce is activated
         * @return void
         */
        function akuna_header_cart()
        {
            if (akuna_is_woocommerce_activated()) {
        ?>
            <div class="header-cart-account header-item">
                <div class="header-account">
                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) ?>" title="<?php esc_attr_e('My Account', 'akuna'); ?>">
                        <svg width=" 24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="7" r="4" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M4 21V17C4 15.8954 4.89543 15 6 15H18C19.1046 15 20 15.8954 20 17V21" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
                <ul id="header-cart" class="header-cart menu">
                    <li>
                        <?php akuna_cart_link(); ?>
                    </li>
                    <li>
                        <?php the_widget('WC_Widget_Cart', 'title='); ?>
                    </li>
                </ul>
            </div>
        <?php
            }
        }
    }

    if (!function_exists('akuna_cart_link_fragment')) {
        /**
         * Cart Fragments
         * Ensure cart contents update when products are added to the cart via AJAX
         *
         * @param  array $fragments Fragments to refresh via AJAX.
         * @return array            Fragments to refresh via AJAX
         */
        function akuna_cart_link_fragment($fragments)
        {
            global $woocommerce;

            ob_start();
            akuna_cart_link();
            $fragments['div.cart-container'] = ob_get_clean();

            ob_start();
            akuna_handheld_footer_bar_cart_link();
            $fragments['a.footer-cart-contents'] = ob_get_clean();

            return $fragments;
        }
    }

    if (!function_exists('akuna_review_form')) {
        function akuna_review_form($comment_form)
        {
            $commenter    = wp_get_current_commenter();

            $fields = array(

                'author' =>
                '<div class="form-col-50">
                        <input id="author" name="author" type="text" class="form-control mb-30" value="' . esc_attr($commenter['comment_author']) . '" required="required" placeholder="Name*" />
                    </div>',

                'email' =>
                '<div class="form-col-50">
                        <input id="email" name="email" class="form-control mb-30" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" required="required" placeholder="Email*" />
                    </div>',

                'cookies' =>
                '<div class="form-col-100">
                        <p>
                            <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"> 
                            <label for="wp-comment-cookies-consent">Save my name, email, and website in this browser for the next time I comment.</label>
                        </p>
                    </div>'

            );

            $comment_form = array(

                'class_container' => 'akuna-form',
                'title_reply_before' => '<h3 class="mb-4">',
                'title_reply' => have_comments() ? esc_html__('Add a review', 'woocommerce') : sprintf(esc_html__('Be the first to review &ldquo;%s&rdquo;', 'woocommerce'), get_the_title()),
                'title_reply_after' => '</h3>',
                'class_submit' => 'btn mk-btn btn-3 mt-15 mb-30',
                'label_submit' => __('Submit Review'),
                'submit_field' => '<div class="form-col-100">%1$s %2$s</div>',
                'submit_button' => '<button type="submit" id="%2$s" class="%3$s">%4$s</button>',
                'fields' => apply_filters('comment_form_default_fields', $fields),
            );

            if (wc_review_ratings_enabled()) {
                $comment_form['comment_field'] .= '<div class="comment-form-rating"><label for="rating">' . esc_html__('Your rating', 'woocommerce') . (wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '') . '</label><select name="rating" id="rating" required>
                    <option value="">' . esc_html__('Rate&hellip;', 'woocommerce') . '</option>
                    <option value="5">' . esc_html__('Perfect', 'woocommerce') . '</option>
                    <option value="4">' . esc_html__('Good', 'woocommerce') . '</option>
                    <option value="3">' . esc_html__('Average', 'woocommerce') . '</option>
                    <option value="2">' . esc_html__('Not that bad', 'woocommerce') . '</option>
                    <option value="1">' . esc_html__('Very poor', 'woocommerce') . '</option>
                </select></div>';
            }

            $comment_form['comment_field'] .= '<div class="form-fields-container"><div class="form-col-100"><textarea id="comment" class="form-control mb-30" name="comment" rows="4" required="required" placeholder="Your review*"></textarea></div>';

            return $comment_form;
        }
    }

    if (!function_exists('akuna_widget_shopping_cart_button_view_cart')) {

        /**
         * Output the view cart button.
         */
        function akuna_widget_shopping_cart_button_view_cart()
        {
            echo '<a href="' . esc_url(wc_get_cart_url()) . '" class="button">' . esc_html__('View cart', 'akuna') . '</a>';
        }
    }

    if (!function_exists('akuna_widget_shopping_cart_proceed_to_checkout')) {

        /**
         * Output the proceed to checkout button.
         */
        function akuna_widget_shopping_cart_proceed_to_checkout()
        {
            echo '<a href="' . esc_url(wc_get_checkout_url()) . '" class="button checkout">' . esc_html__('Checkout', 'akuna') . '</a>';
        }
    }

    if (!function_exists('akuna_button_proceed_to_checkout')) {

        /**
         * Output the proceed to checkout button.
         */
        function akuna_button_proceed_to_checkout()
        {
        ?>
        <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="checkout-button button alt">
            <?php esc_html_e('Proceed To Checkout', 'woocommerce'); ?>
        </a>
<?php
        }
    }

    if (!function_exists('akuna_quantity_plus_sign')) {
        function akuna_quantity_plus_sign()
        {
            echo '<button type="button" class="plus" >+</button>';
        }
    }

    if (!function_exists('akuna_quantity_minus_sign')) {
        function akuna_quantity_minus_sign()
        {
            echo '<button type="button" class="minus" >-</button>';
        }
    }
