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
