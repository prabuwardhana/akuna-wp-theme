<?php

/**
 * akuna WooCommerce Class
 *
 * @package  akuna
 * @since    2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('akuna_WooCommerce')) :
    class akuna_WooCommerce
    {
        /**
         * Setup class.
         *
         * @since 1.0.0
         */
        public function __construct()
        {
            add_action('after_setup_theme', array($this, 'woocommerce_setup'));
            add_filter('body_class', array($this, 'woocommerce_body_class'));
            add_action('wp_footer', array($this, 'quantity_plus_minus'));
            add_action('wp_enqueue_scripts', array($this, 'woocommerce_scripts'), 20);
            add_filter('woocommerce_output_related_products_args', array($this, 'related_products_args'));
            add_filter('woocommerce_product_thumbnails_columns', array($this, 'thumbnail_columns'));
            add_filter('woocommerce_breadcrumb_defaults', array($this, 'change_breadcrumb_delimiter'));

            // Instead of loading Core CSS files, we only register the font families.
            add_filter('woocommerce_enqueue_styles', '__return_empty_array');
            add_filter('wp_enqueue_scripts', array($this, 'add_core_fonts'), 130);
        }

        /**
         * Sets up theme defaults and registers support for various WooCommerce features.
         *
         * Note that this function is hooked into the after_setup_theme hook, which
         * runs before the init hook. The init hook is too late for some features, such
         * as indicating support for post thumbnails.
         *
         * @since 1.0.0
         * @return void
         */
        public function woocommerce_setup()
        {
            add_theme_support(
                'woocommerce',
                apply_filters(
                    'akuna_woocommerce_args',
                    array(
                        'single_image_width'    => 416,
                        'thumbnail_image_width' => 324,
                        'product_grid'          => array(
                            'default_columns' => 3,
                            'default_rows'    => 4,
                            'min_columns'     => 1,
                            'max_columns'     => 6,
                            'min_rows'        => 1,
                        ),
                    )
                )
            );

            add_theme_support('wc-product-gallery-zoom');
            add_theme_support('wc-product-gallery-lightbox');
            add_theme_support('wc-product-gallery-slider');

            /**
             * Add 'akuna_woocommerce_setup' action.
             *
             * @since  1.0.0
             */
            do_action('akuna_woocommerce_setup');
        }

        /**
         * Add CSS in <head> to register WooCommerce Core fonts.
         *
         * @since 1.0.0
         * @return void
         */
        public function add_core_fonts()
        {
            $fonts_url = plugins_url('/woocommerce/assets/fonts/');
            wp_add_inline_style(
                'akuna-woocommerce-style',
                '@font-face {
				font-family: star;
				src: url(' . $fonts_url . 'star.eot);
				src:
					url(' . $fonts_url . 'star.eot?#iefix) format("embedded-opentype"),
					url(' . $fonts_url . 'star.woff) format("woff"),
					url(' . $fonts_url . 'star.ttf) format("truetype"),
					url(' . $fonts_url . 'star.svg#star) format("svg");
				font-weight: 400;
				font-style: normal;
			}
			@font-face {
				font-family: WooCommerce;
				src: url(' . $fonts_url . 'WooCommerce.eot);
				src:
					url(' . $fonts_url . 'WooCommerce.eot?#iefix) format("embedded-opentype"),
					url(' . $fonts_url . 'WooCommerce.woff) format("woff"),
					url(' . $fonts_url . 'WooCommerce.ttf) format("truetype"),
					url(' . $fonts_url . 'WooCommerce.svg#WooCommerce) format("svg");
				font-weight: 400;
				font-style: normal;
			}'
            );
        }

        /**
         * Add WooCommerce specific classes to the body tag
         *
         * @param  array $classes css classes applied to the body tag.
         * @return array $classes modified to include 'woocommerce-active' class
         */
        public function woocommerce_body_class($classes)
        {
            $classes[] = 'woocommerce-active';

            return $classes;
        }

        /**
         * WooCommerce specific scripts & stylesheets
         *
         * @since 1.0.0
         */
        public function woocommerce_scripts()
        {
            global $akuna_version;

            $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

            wp_enqueue_style('akuna-woocommerce-style', get_template_directory_uri() . '/assets/css/woocommerce/woocommerce_.css', array('akuna-style', 'akuna-icons'), $akuna_version);
            wp_style_add_data('akuna-woocommerce-style', 'rtl', 'replace');

            wp_register_script('akuna-header-cart', get_template_directory_uri() . '/assets/js/woocommerce/header-cart' . $suffix . '.js', array(), $akuna_version, true);
            wp_enqueue_script('akuna-header-cart');

            wp_enqueue_script('akuna-handheld-footer-bar', get_template_directory_uri() . '/assets/js/footer.min.js', array(), $akuna_version, true);

            if (is_product()) {
                wp_register_script('akuna-sticky-add-to-cart', get_template_directory_uri() . '/assets/js/sticky-add-to-cart' . $suffix . '.js', array(), $akuna_version, true);
            }
        }

        /**
         * Related Products Args
         *
         * @param  array $args related products args.
         * @since 1.0.0
         * @return  array $args related products args
         */
        public function related_products_args($args)
        {
            $args = apply_filters(
                'akuna_related_products_args',
                array(
                    'posts_per_page' => 3,
                    'columns'        => 3,
                )
            );

            return $args;
        }

        /**
         * Product gallery thumbnail columns
         *
         * @return integer number of columns
         * @since  1.0.0
         */
        public function thumbnail_columns()
        {
            $columns = 4;

            if (!is_active_sidebar('sidebar-1')) {
                $columns = 5;
            }

            return intval(apply_filters('akuna_product_thumbnail_columns', $columns));
        }

        /**
         * Remove the breadcrumb delimiter
         *
         * @param  array $defaults The breadcrumb defaults.
         * @return array           The breadcrumb defaults.
         * @since 1.0.0
         */
        public function change_breadcrumb_delimiter($defaults)
        {
            $defaults['delimiter']   = '<span class="breadcrumb-separator"> / </span>';
            $defaults['wrap_before'] = '<div class="akuna-breadcrumb"><div class="col-full"><nav class="woocommerce-breadcrumb" aria-label="' . esc_attr__('breadcrumbs', 'akuna') . '">';
            $defaults['wrap_after']  = '</nav></div></div>';
            return $defaults;
        }

        public function quantity_plus_minus()
        {
            // To run this on the single product page
            if (!is_product() && !is_cart()) return;
?>
            <script type='text/javascript'>
                jQuery(function($) {
                    if (!String.prototype.getDecimals) {
                        String.prototype.getDecimals = function() {
                            var num = this,
                                match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                            if (!match) {
                                return 0;
                            }
                            return Math.max(0, (match[1] ? match[1].length : 0) - (match[2] ? +match[2] : 0));
                        }
                    }
                    // Quantity "plus" and "minus" buttons
                    $(document.body).on('click', '.plus, .minus', function() {
                        var $qty = $(this).closest('.quantity').find('.qty'),
                            currentVal = parseFloat($qty.val()),
                            max = parseFloat($qty.attr('max')),
                            min = parseFloat($qty.attr('min')),
                            step = $qty.attr('step');

                        // Format values
                        if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
                        if (max === '' || max === 'NaN') max = '';
                        if (min === '' || min === 'NaN') min = 0;
                        if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

                        // Change the value
                        if ($(this).is('.plus')) {
                            if (max && (currentVal >= max)) {
                                $qty.val(max);
                            } else {
                                $qty.val((currentVal + parseFloat(step)).toFixed(step.getDecimals()));
                            }
                        } else {
                            if (min && (currentVal <= min)) {
                                $qty.val(min);
                            } else if (currentVal > 0) {
                                $qty.val((currentVal - parseFloat(step)).toFixed(step.getDecimals()));
                            }
                        }

                        // Trigger change event
                        $qty.trigger('change');
                    });
                });
            </script>
<?php
        }
    }
endif;

return new akuna_WooCommerce();
