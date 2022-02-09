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
            do_action('akuna_sidebar');
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
