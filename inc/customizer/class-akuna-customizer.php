<?php

/**
 * akuna Customizer Class
 *
 * @package  akuna
 * @since    1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('akuna_Customizer')) :

    /**
     * The akuna Customizer class
     */
    class akuna_Customizer
    {
        /**
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct()
        {
            add_action('customize_register', array($this, 'customize_register'), 10);
            add_action('customize_register', array($this, 'edit_default_customizer_settings'), 99);
            add_filter('kirki/fields', array($this, 'akuna_kirki_fields'));
            add_action('wp_enqueue_scripts', array($this, 'add_customizer_css'), 130);
            add_action('init', array($this, 'default_theme_mod_values'), 10);
        }

        /**
         * Returns an array of the desired default akuna Options
         *
         * @return array
         */
        public function get_akuna_default_setting_values()
        {
            return apply_filters(
                'akuna_setting_default_values',
                $args = array(
                    'akuna_heading_color'           => '#131315',
                    'akuna_text_color'              => '#43454b',
                    'akuna_accent_color'            => '#dd9933',
                    'akuna_hero_heading_color'      => '#000000',
                    'akuna_hero_text_color'         => '#000000',
                    'akuna_header_background_color' => '#ffffff',
                    'akuna_header_text_color'       => '#43454b',
                    'akuna_header_link_color'       => '#78986a',
                    'akuna_footer_background_color' => '#5a6054',
                    'akuna_footer_heading_color'    => '#ffffff',
                    'akuna_footer_text_color'       => '#ffffff',
                    'akuna_footer_link_color'       => '#dd9933',
                    'akuna_button_background_color' => '#78986a',
                    'akuna_button_border_px'        => '1',
                    'akuna_button_border_color'     => '#78986a',
                    'akuna_button_text_color'       => '#ffffff',
                    'akuna_button_alt_background_color' => '#5a6054',
                    'akuna_button_alt_border_color' => '#5a6054',
                    'akuna_button_alt_text_color'   => '#ffffff',
                    'background_color'              => '#dbe7d7',
                )
            );
        }

        /**
         * Adds a value to each akuna setting if one isn't already present.
         *
         * @uses get_akuna_default_setting_values()
         */
        public function default_theme_mod_values()
        {
            foreach ($this->get_akuna_default_setting_values() as $mod => $val) {
                add_filter('theme_mod_' . $mod, array($this, 'get_theme_mod_value'), 10);
            }
        }

        /**
         * Get theme mod value.
         *
         * @param string $value Theme modification value.
         * @return string
         */
        public function get_theme_mod_value($value)
        {
            $key = substr(current_filter(), 10);

            $set_theme_mods = get_theme_mods();

            if (isset($set_theme_mods[$key])) {
                return $value;
            }

            $values = $this->get_akuna_default_setting_values();

            return isset($values[$key]) ? $values[$key] : $value;
        }

        /**
         * Set Customizer setting defaults.
         * These defaults need to be applied separately as child themes can filter akuna_setting_default_values
         *
         * @param  object $wp_customize the Customizer object.
         * @uses   get_akuna_default_setting_values()
         */
        public function edit_default_customizer_settings($wp_customize)
        {
            foreach ($this->get_akuna_default_setting_values() as $mod => $val) {
                $wp_customize->get_setting($mod)->default = $val;
            }
        }

        /**
         * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         * @since  1.0.0
         */
        public function customize_register($wp_customize)
        {

            // Move background color setting alongside background image.
            $wp_customize->get_control('background_color')->section  = 'background_image';
            $wp_customize->get_control('background_color')->priority = 20;

            // Change background image section title & priority.
            $wp_customize->get_section('background_image')->title    = __('Background', 'akuna');
            $wp_customize->get_section('background_image')->priority = 30;

            // Selective refresh.
            if (function_exists('add_partial')) {
                $wp_customize->get_setting('blogname')->transport        = 'postMessage';
                $wp_customize->get_setting('blogdescription')->transport = 'postMessage';

                $wp_customize->selective_refresh->add_partial(
                    'custom_logo',
                    array(
                        'selector'        => '.site-branding',
                        'render_callback' => array($this, 'get_site_logo'),
                    )
                );

                $wp_customize->selective_refresh->add_partial(
                    'blogname',
                    array(
                        'selector'        => '.site-title.beta a',
                        'render_callback' => array($this, 'get_site_name'),
                    )
                );

                $wp_customize->selective_refresh->add_partial(
                    'blogdescription',
                    array(
                        'selector'        => '.site-description',
                        'render_callback' => array($this, 'get_site_description'),
                    )
                );
            }

            /**
             * Hero slider section
             */

            $wp_customize->add_section('image_slider', array(
                'title'       => __('Hero Image Slider', 'akuna'),
                'priority'    => 50,
                'description' => __('Customize your website\'s hero section.', 'akuna'),
            ));

            /**
             * Shop section
             */

            $wp_customize->add_section('akuna_shop_page', array(
                'title'       => __('Shop Page', 'akuna'),
                'panel'       => 'woocommerce',
                'priority'    => 20,
                'description' => __('Customize your shop page.', 'akuna'),
            ));

            /**
             * Color panel
             */
            $wp_customize->add_panel('colors', array(
                'title'       => __('Colors'),
                'description' => __('Customize your website\'s colors scheme.', 'akuna'),
                'priority'    => 40,
            ));

            /**
             * Header section
             */
            $wp_customize->add_section(
                'akuna_header',
                array(
                    'title'       => __('Header', 'akuna'),
                    'panel'       => 'colors',
                    'priority'    => 25,
                    'description' => __('Customize the look & feel of your website header.', 'akuna'),
                )
            );

            $wp_customize->add_setting('akuna_header_background_color');
            $wp_customize->add_setting('akuna_header_text_color');
            $wp_customize->add_setting('akuna_header_link_color');

            /**
             * Footer section
             */
            $wp_customize->add_section(
                'akuna_footer',
                array(
                    'title'       => __('Footer', 'akuna'),
                    'panel' => 'colors',
                    'priority'    => 30,
                    'description' => __('Customize the look & feel of your website footer.', 'akuna'),
                )
            );

            $wp_customize->add_setting('akuna_footer_background_color');
            $wp_customize->add_setting('akuna_footer_heading_color');
            $wp_customize->add_setting('akuna_footer_text_color');
            $wp_customize->add_setting('akuna_footer_link_color');

            /**
             * Typography section
             */
            $wp_customize->add_section(
                'akuna_typography',
                array(
                    'title'    => __('Typography', 'akuna'),
                    'panel' => 'colors',
                    'priority' => 35,
                )
            );

            $wp_customize->add_setting('akuna_heading_color');
            $wp_customize->add_setting('akuna_text_color');
            $wp_customize->add_setting('akuna_accent_color');
            $wp_customize->add_setting('akuna_hero_heading_color');
            $wp_customize->add_setting('akuna_hero_text_color');

            /**
             * Buttons section
             */
            $wp_customize->add_section(
                'akuna_buttons',
                array(
                    'title'       => __('Buttons', 'akuna'),
                    'panel' => 'colors',
                    'priority'    => 40,
                    'description' => __('Customize the look & feel of your website buttons.', 'akuna'),
                )
            );

            $wp_customize->add_setting('akuna_button_border_px');
            $wp_customize->add_setting('akuna_button_background_color');
            $wp_customize->add_setting('akuna_button_border_color');
            $wp_customize->add_setting('akuna_button_text_color');
            $wp_customize->add_setting('akuna_button_alt_background_color');
            $wp_customize->add_setting('akuna_button_alt_border_color');
            $wp_customize->add_setting('akuna_button_alt_text_color');
        }

        /**
         * Add field to each settings.
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         * @since  1.0.0
         */
        public function akuna_kirki_fields($fields)
        {
            /**
             * Heading Color
             */
            $fields[] = array(
                'type'        => 'color',
                'settings'    => 'akuna_heading_color',
                'label'       => esc_html__('Heading color', 'akuna'),
                'section'     => 'akuna_typography',
                'priority'    => 20,
                'description' => esc_html__('Heading color for your theme', 'akuna'),
                'default'     => apply_filters('akuna_default_heading_color', '#484c51'),
            );

            /**
             * Text Color
             */
            $fields[] = array(
                'type'        => 'color',
                'settings'    => 'akuna_text_color',
                'label'       => esc_html__('Text color', 'akuna'),
                'section'     => 'akuna_typography',
                'priority'    => 30,
                'description' => esc_html__('Text color for your theme', 'akuna'),
                'default'     => apply_filters('akuna_default_text_color', '#43454b'),
            );

            /**
             * Accent Color
             */
            $fields[] = array(
                'type'        => 'color',
                'settings'    => 'akuna_accent_color',
                'label'       => esc_html__('Link / accent color', 'akuna'),
                'section'     => 'akuna_typography',
                'priority'    => 40,
                'description' => esc_html__('Accent or link color for your theme', 'akuna'),
                'default'     => apply_filters('akuna_default_accent_color', '#7f54b3'),
            );

            /**
             * Hero heading color
             */
            $fields[] = array(
                'type'        => 'color',
                'settings'    => 'akuna_hero_heading_color',
                'label'       => esc_html__('Hero heading color', 'akuna'),
                'section'     => 'akuna_typography',
                'priority'    => 50,
                'description' => esc_html__('Heading color for the hero banner.', 'akuna'),
                'default'     => apply_filters('akuna_default_hero_heading_color', '#000000'),
            );

            /**
             * Hero text color
             */
            $fields[] = array(
                'type'        => 'color',
                'settings'    => 'akuna_hero_text_color',
                'label'       => esc_html__('Hero text color', 'akuna'),
                'section'     => 'akuna_typography',
                'priority'    => 60,
                'description' => esc_html__('Text color for the hero banner.', 'akuna'),
                'default'     => apply_filters('akuna_default_hero_text_color', '#000000'),
            );

            /**
             * Header background color
             */
            $fields[] = array(
                'type'        => 'color',
                'settings'    => 'akuna_header_background_color',
                'label'       => esc_html__('Background color', 'akuna'),
                'section'     => 'akuna_header',
                'priority'    => 10,
                'description' => esc_html__('Background color for the header.', 'akuna'),
                'default'     => apply_filters('akuna_default_header_background_color', '#ffffff'),
                'choices'     => [
                    'alpha' => true,
                ],
            );

            /**
             * Header text color
             */
            $fields[] = array(
                'type'        => 'color',
                'settings'    => 'akuna_header_text_color',
                'label'       => esc_html__('Text color', 'akuna'),
                'section'     => 'akuna_header',
                'priority'    => 20,
                'description' => esc_html__('Text color in the header.', 'akuna'),
                'default'     => apply_filters('akuna_default_header_text_color', '#9aa0a7'),
            );

            /**
             * Header link color
             */
            $fields[] = array(
                'type'        => 'color',
                'settings'    => 'akuna_header_link_color',
                'label'       => esc_html__('Link color', 'akuna'),
                'section'     => 'akuna_header',
                'priority'    => 30,
                'description' => esc_html__('Link color in the header.', 'akuna'),
                'default'     => apply_filters('akuna_default_header_link_color', '#d5d9db'),
            );

            /**
             * Footer background color
             */
            $fields[] = array(
                'type'        => 'color',
                'settings'    => 'akuna_footer_background_color',
                'label'       => esc_html__('Background color', 'akuna'),
                'section'     => 'akuna_footer',
                'priority'    => 10,
                'description' => esc_html__('Background color for the footer.', 'akuna'),
                'default'     => apply_filters('akuna_default_footer_background_color', '#f0f0f0'),
                'choices'     => [
                    'alpha' => true,
                ],
            );

            /**
             * Footer heading color
             */
            $fields[] = array(
                'type'        => 'color',
                'settings'    => 'akuna_footer_heading_color',
                'label'       => esc_html__('Heading color', 'akuna'),
                'section'     => 'akuna_footer',
                'priority'    => 20,
                'description' => esc_html__('Heading color in the footer.', 'akuna'),
                'default'     => apply_filters('akuna_default_footer_heading_color', '#494c50'),
            );

            /**
             * Footer text color
             */
            $fields[] = array(
                'type'        => 'color',
                'settings'    => 'akuna_footer_text_color',
                'label'       => esc_html__('Text color', 'akuna'),
                'section'     => 'akuna_footer',
                'priority'    => 30,
                'description' => esc_html__('Text color in the footer.', 'akuna'),
                'default'     => apply_filters('akuna_default_footer_text_color', '#61656b'),
            );

            /**
             * Footer link color
             */
            $fields[] = array(
                'type'        => 'color',
                'settings'    => 'akuna_footer_link_color',
                'label'       => esc_html__('Link color', 'akuna'),
                'section'     => 'akuna_footer',
                'priority'    => 40,
                'description' => esc_html__('Link color in the footer.', 'akuna'),
                'default'     => apply_filters('akuna_default_footer_link_color', '#2c2d33'),
            );

            /**
             * Button border px
             */
            $fields[] = array(
                'type'        => 'slider',
                'settings'    => 'akuna_button_border_px',
                'label'       => esc_html__('Border thickness (px)', 'kirki'),
                'section'     => 'akuna_buttons',
                'priority'    => 5,
                'default'     => 1,
                'choices'     => [
                    'min'  => 0,
                    'max'  => 10,
                    'step' => 1,
                ],
            );

            /**
             * Button background color
             */
            $fields[] = array(
                'type'        => 'color',
                'settings'    => 'akuna_button_background_color',
                'label'       => esc_html__('Background color', 'akuna'),
                'section'     => 'akuna_buttons',
                'priority'    => 10,
                'description' => esc_html__('Background color for the main button.', 'akuna'),
                'default'     => apply_filters('akuna_default_button_background_color', '#96588a'),
                'choices'     => [
                    'alpha' => true,
                ],
            );

            /**
             * Button border color
             */
            $fields[] = array(
                'type'        => 'color',
                'settings'    => 'akuna_button_border_color',
                'label'       => esc_html__('Border color', 'akuna'),
                'section'     => 'akuna_buttons',
                'priority'    => 20,
                'description' => esc_html__('Border color for the main button.', 'akuna'),
                'default'     => apply_filters('akuna_default_button_border_color', '#ffffff'),
            );

            /**
             * Button text color
             */
            $fields[] = array(
                'type'        => 'color',
                'settings'    => 'akuna_button_text_color',
                'label'       => esc_html__('Text color', 'akuna'),
                'section'     => 'akuna_buttons',
                'priority'    => 30,
                'description' => esc_html__('Text color for the main button.', 'akuna'),
                'default'     => apply_filters('akuna_default_button_text_color', '#ffffff'),
            );

            /**
             * Button alt background color
             */
            $fields[] = array(
                'type'        => 'color',
                'settings'    => 'akuna_button_alt_background_color',
                'label'       => esc_html__('Alternate button background color', 'akuna'),
                'section'     => 'akuna_buttons',
                'priority'    => 40,
                'description' => esc_html__('Background color for the alternate button.', 'akuna'),
                'default'     => apply_filters('akuna_default_button_alt_background_color', '#2c2d33'),
                'choices'     => [
                    'alpha' => true,
                ],
            );

            /**
             * Button alt border color
             */
            $fields[] = array(
                'type'        => 'color',
                'settings'    => 'akuna_button_alt_border_color',
                'label'       => esc_html__('Alternate button border color', 'akuna'),
                'section'     => 'akuna_buttons',
                'priority'    => 50,
                'description' => esc_html__('Border color for the alternate button.', 'akuna'),
                'default'     => apply_filters('akuna_default_button_alt_border_color', '#2c2d33'),
            );

            /**
             * Button alt text color
             */
            $fields[] = array(
                'type'        => 'color',
                'settings'    => 'akuna_button_alt_text_color',
                'label'       => esc_html__('Alternate button text color', 'akuna'),
                'section'     => 'akuna_buttons',
                'priority'    => 60,
                'description' => esc_html__('Text color for the alternate button.', 'kirki'),
                'default'     => apply_filters('akuna_default_button_alt_text_color', '#ffffff'),
            );

            /**
             * Hero Image slider
             */
            $fields[] = array(
                'type'        => 'repeater',
                'label'       => esc_html__('Customize Your Hero Section', 'kirki'),
                'settings'    => 'slider_settings',
                'section'     => 'image_slider',
                'priority'    => 10,
                'row_label' => [
                    'type'  => 'field',
                    'value' => esc_html__('Image Slider Settings', 'kirki'),
                    'field' => 'heading_text',
                ],
                'button_label' => esc_html__('Add new item', 'kirki'),
                'fields' => [
                    'heading_text' => [
                        'type'        => 'text',
                        'label'       => esc_html__('Heading Text', 'kirki'),
                        'description' => esc_html__('This will be the heading text', 'kirki'),
                        'default'     => '',
                    ],
                    'sub_heading_text' => [
                        'type'        => 'textarea',
                        'label'       => esc_html__('Sub Heading Text', 'kirki'),
                        'description' => esc_html__('This will be the sub-heading text', 'kirki'),
                        'default'     => '',
                    ],
                    'button_text' => [
                        'type'        => 'text',
                        'label'       => esc_html__('Button Text', 'kirki'),
                        'description' => esc_html__('This will be the button text', 'kirki'),
                        'default'     => '',
                    ],
                    'button_page_link' => [
                        'type'        => 'dropdown-pages',
                        'description' => esc_html__('This will be the link to page', 'kirki'),
                        'default'     => '',
                    ],
                    'background_img' => [
                        'type'        => 'image',
                        'label'       => esc_html__('Link URL', 'kirki'),
                        'description' => esc_html__('This will be the background image', 'kirki'),
                        'default'     => '',
                    ],
                ]
            );

            /**
             * Shop page's banner image
             */
            $fields[] = array(
                'type'        => 'image',
                'settings'    => 'image_setting_url',
                'label'       => esc_html__('Shop page banner', 'kirki'),
                'description' => esc_html__('The page banner will be displayed on top of the shop page.', 'kirki'),
                'section'     => 'akuna_shop_page',
                'default'     => '',
            );

            /**
             * Shop page's product list
             */
            $fields[] = array(
                'type'        => 'repeater',
                'label'       => esc_html__('Product to display by category', 'kirki'),
                'settings'    => 'products_list_settings',
                'section'     => 'akuna_shop_page',
                'priority'    => 10,
                'row_label' => [
                    'type'  => 'field',
                    'value' => esc_html__('Products List Settings', 'kirki'),
                    'field' => 'product_category',
                ],
                'button_label' => esc_html__('Add new item', 'kirki'),
                'fields' => [
                    'product_category' => [
                        'type'        => 'select',
                        'label'       => esc_html__('Product category', 'kirki'),
                        'description' => esc_html__('Choose product category to display on your shop page', 'kirki'),
                        'default'     => '_self',
                        'choices'     => Kirki\Util\Helper::get_terms('product_cat'),
                    ],
                ]
            );

            return $fields;
        }

        /**
         * Get all of the akuna theme mods.
         *
         * @return array $akuna_theme_mods The akuna Theme Mods.
         */
        public function get_akuna_theme_mods()
        {
            $akuna_theme_mods = array(
                'background_color'            => akuna_get_content_background_color(),
                'accent_color'                => get_theme_mod('akuna_accent_color'),
                'hero_heading_color'          => get_theme_mod('akuna_hero_heading_color'),
                'hero_text_color'             => get_theme_mod('akuna_hero_text_color'),
                'header_background_color'     => get_theme_mod('akuna_header_background_color'),
                'header_link_color'           => get_theme_mod('akuna_header_link_color'),
                'header_text_color'           => get_theme_mod('akuna_header_text_color'),
                'footer_background_color'     => get_theme_mod('akuna_footer_background_color'),
                'footer_link_color'           => get_theme_mod('akuna_footer_link_color'),
                'footer_heading_color'        => get_theme_mod('akuna_footer_heading_color'),
                'footer_text_color'           => get_theme_mod('akuna_footer_text_color'),
                'text_color'                  => get_theme_mod('akuna_text_color'),
                'heading_color'               => get_theme_mod('akuna_heading_color'),
                'button_background_color'     => get_theme_mod('akuna_button_background_color'),
                'button_border_px'            => get_theme_mod('akuna_button_border_px'),
                'button_border_color'         => get_theme_mod('akuna_button_border_color'),
                'button_text_color'           => get_theme_mod('akuna_button_text_color'),
                'button_alt_background_color' => get_theme_mod('akuna_button_alt_background_color'),
                'button_alt_border_color'     => get_theme_mod('akuna_button_alt_border_color'),
                'button_alt_text_color'       => get_theme_mod('akuna_button_alt_text_color'),
            );

            return apply_filters('akuna_theme_mods', $akuna_theme_mods);
        }

        /**
         * Get Customizer css.
         *
         * @see get_akuna_theme_mods()
         * @return array $styles the css
         */
        public function get_css()
        {
            $akuna_theme_mods = $this->get_akuna_theme_mods();
            $darken_factor    = apply_filters('akuna_darken_factor', -25);

            $styles = '
            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                color: ' . $akuna_theme_mods['heading_color'] . ';
            }

            body,
            button,
            input,
            textarea {
                color: ' . $akuna_theme_mods['text_color'] . ';
            }

            input[type="text"],
            input[type="number"],
            input[type="email"],
            input[type="tel"],
            input[type="url"],
            input[type="password"],
            input[type="search"],
            textarea,
            .input-text {
                color: ' . $akuna_theme_mods['text_color'] . ';
            }

            ul.products li.product .price {
                color: ' . $akuna_theme_mods['text_color'] . ';
            }

            div.quantity button.plus,
            div.quantity button.minus {
                color: ' . $akuna_theme_mods['text_color'] . ';
            }

            div.quantity {
                border: solid 1px ' . $akuna_theme_mods['button_border_color'] . ';
            }

            .header-cart .widget_shopping_cart .product_list_widget li a.remove {
                background-color: ' . $akuna_theme_mods['accent_color'] . ';
            }

            .site-footer a:hover {
                color: ' . $akuna_theme_mods['accent_color'] . ';
            }

            .site-footer a:after {
                background-color: ' . $akuna_theme_mods['accent_color'] . ';
            }

            a {
                color: ' . $akuna_theme_mods['header_link_color'] . ';
            }

            .site-header {
                background-color: ' . $akuna_theme_mods['header_background_color'] . ';
            }

            .site-footer {
                background-color: ' . $akuna_theme_mods['footer_background_color'] . ';
            }

            button,
            input[type="button"],
            input[type="reset"],
            input[type="submit"],
            .button,
            .added_to_cart {
                background-color: ' . $akuna_theme_mods['button_background_color'] . ';
                border-color: ' . $akuna_theme_mods['button_border_color'] . ';
            }

            button.cta,
            button.alt,
            input[type="button"].cta,
            input[type="button"].alt,
            input[type="reset"].cta,
            input[type="reset"].alt,
            input[type="submit"].cta,
            input[type="submit"].alt,
            .button.cta,
            .button.alt,
            .added_to_cart.cta,
            .added_to_cart.alt {
                background-color: ' . $akuna_theme_mods['button_alt_background_color'] . ';
                border-color: ' . $akuna_theme_mods['button_alt_border_color'] . ';
            }

            .header-cart .widget_shopping_cart p.total {
                border-bottom: 1px solid ' . $akuna_theme_mods['button_alt_border_color'] . ';
            }
            .header-cart .widget_shopping_cart .product_list_widget li {
                border-bottom: 1px solid ' . $akuna_theme_mods['button_alt_border_color'] . ';
            }

            button:hover,
            input[type="button"]:hover,
            input[type="reset"]:hover,
            input[type="submit"]:hover,
            .button:hover,
            .added_to_cart:hover {
                background-color: ' . akuna_adjust_color_brightness($akuna_theme_mods['button_background_color'], $darken_factor) . ';
            }

            button.cta:hover,
            button.alt:hover,
            input[type="button"].cta:hover,
            input[type="button"].alt:hover,
            input[type="reset"].cta:hover,
            input[type="reset"].alt:hover,
            input[type="submit"].cta:hover,
            input[type="submit"].alt:hover,
            .button.cta:hover,
            .button.alt:hover,
            .added_to_cart.cta:hover,
            .added_to_cart.alt:hover {
                background-color: ' . akuna_adjust_color_brightness($akuna_theme_mods['button_alt_background_color'], $darken_factor) . ';
            }

            .secondary-navigation .menu a:hover {
                color: ' . akuna_adjust_color_brightness($akuna_theme_mods['button_background_color'], $darken_factor) . ';
            }

            body.page-template-default,
            body.single-product,
            body.woocommerce-cart,
            body.woocommerce-checkout {
                background-color: ' . $akuna_theme_mods['background_color'] . ';
            }

            .akuna-product-attr {
                background-color: ' . $akuna_theme_mods['button_background_color'] . ';
            }
            
            .akuna-loop-product__title {
                color: ' . $akuna_theme_mods['button_background_color'] . ';
            }
            
            .rating-average .rating-box {
                background-color: ' . $akuna_theme_mods['button_background_color'] . ';
            }
            .rating-snapshot .bar-container .bar {
                background-color: ' . $akuna_theme_mods['button_background_color'] . ';
            }
            
            .woocommerce-message,
            .woocommerce-info,
            .woocommerce-error,
            .woocommerce-noreviews,
            p.no-comments {
                background-color: ' . $akuna_theme_mods['button_background_color'] . ';
            }
            
            ul.checkout-bar li.visited::after,
            ul.checkout-bar::before {
                background-color: ' . $akuna_theme_mods['button_background_color'] . ';
            }
            
            .woocommerce-checkout .checkout-bar li.active::after {
                background-color: ' . $akuna_theme_mods['button_background_color'] . ';
            }
            
            #payment
            .payment_methods
            li.wc_payment_method
            > input[type="radio"]:first-child:checked
            + label:before,
            #payment
            .payment_methods
            li.woocommerce-PaymentMethod
            > input[type="radio"]:first-child:checked
            + label:before,
            #shipping_method > li > input[type="radio"]:first-child:checked + label:before {
                background-color: ' . $akuna_theme_mods['button_background_color'] . ';
            }
            
            .cat-nav-container {
                background-color: ' . $akuna_theme_mods['button_background_color'] . ';
            }
            
            .header-cart .widget_shopping_cart .product_list_widget li > a:hover {
                color: ' . $akuna_theme_mods['button_background_color'] . ';
            }
        	';

            return apply_filters('akuna_customizer_css', $styles);
        }

        /**
         * Add CSS in <head> for styles handled by the theme customizer
         *
         * @since 1.0.0
         * @return void
         */
        public function add_customizer_css()
        {
            wp_add_inline_style('akuna-style', $this->get_css());
        }

        /**
         * Get site logo.
         *
         * @since 1.0.0
         * @return string
         */
        public function get_site_logo()
        {
            return akuna_site_title_or_logo(false);
        }

        /**
         * Get site name.
         *
         * @since 1.0.0
         * @return string
         */
        public function get_site_name()
        {
            return get_bloginfo('name', 'display');
        }

        /**
         * Get site description.
         *
         * @since 1.0.0
         * @return string
         */
        public function get_site_description()
        {
            return get_bloginfo('description', 'display');
        }

        /**
         * Check if current page is using the Homepage template.
         *
         * @since 1.0.0
         * @return bool
         */
        public function is_homepage_template()
        {
            $template = get_post_meta(get_the_ID(), '_wp_page_template', true);

            if (!$template || 'template-homepage.php' !== $template || !has_post_thumbnail(get_the_ID())) {
                return false;
            }

            return true;
        }
    }

endif;

return new akuna_Customizer();
