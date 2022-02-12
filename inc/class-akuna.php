<?php

/**
 * akuna Class
 *
 * @since    1.0.0
 * @package  akuna
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('akuna')) :

    /**
     * The main akuna class
     */
    class akuna
    {
        /**
         * Setup class.
         *
         * @since 1.0.0
         */
        public function __construct()
        {
            add_action('after_setup_theme', array($this, 'setup_theme'));
            add_action('widgets_init', array($this, 'widgets_init'));
            add_action('wp_enqueue_scripts', array($this, 'scripts'), 10);
            add_action('wp_enqueue_scripts', array($this, 'child_scripts'), 30); // After WooCommerce.
            add_filter('body_class', array($this, 'body_classes'));
            add_filter('wp_page_menu_args', array($this, 'page_menu_args'));
            add_filter('navigation_markup_template', array($this, 'navigation_markup_template'));
        }

        /**
         * Sets up theme defaults and registers support for various WordPress features.
         *
         * Note that this function is hooked into the after_setup_theme hook, which
         * runs before the init hook. The init hook is too late for some features, such
         * as indicating support for post thumbnails.
         */
        public function setup_theme()
        {
            $this->akuna_localisation();
            $this->akuna_theme_support();

            /**
             * Register menu locations.
             */
            register_nav_menus(
                apply_filters(
                    'akuna_register_nav_menus',
                    array(
                        'primary'     => __('Primary Menu', 'akuna'),
                        'secondary'   => __('Secondary Menu', 'akuna'),
                    )
                )
            );
        }

        protected function akuna_localisation()
        {
            /*
			 * Load Localisation files.
			 *
			 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
			 */

            // Loads wp-content/languages/themes/akuna-it_IT.mo.
            load_theme_textdomain('akuna', trailingslashit(WP_LANG_DIR) . 'themes');

            // Loads wp-content/themes/child-theme-name/languages/it_IT.mo.
            load_theme_textdomain('akuna', get_stylesheet_directory() . '/languages');

            // Loads wp-content/themes/akuna/languages/it_IT.mo.
            load_theme_textdomain('akuna', get_template_directory() . '/languages');
        }

        protected function akuna_theme_support()
        {
            /**
             * Add default posts and comments RSS feed links to head.
             */
            add_theme_support('automatic-feed-links');

            /*
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#Post_Thumbnails
			 */
            add_theme_support('post-thumbnails');

            /**
             * Enable support for site logo.
             */
            add_theme_support(
                'custom-logo',
                apply_filters(
                    'akuna_custom_logo_args',
                    array(
                        'height'      => 110,
                        'width'       => 470,
                        'flex-width'  => true,
                        'flex-height' => true,
                    )
                )
            );

            /*
			 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
			 * to output valid HTML5.
			 */
            add_theme_support(
                'html5',
                apply_filters(
                    'akuna_html5_args',
                    array(
                        'search-form',
                        'comment-form',
                        'comment-list',
                        'gallery',
                        'caption',
                        'widgets',
                        'style',
                        'script',
                    )
                )
            );

            /**
             * Setup the WordPress core custom background feature.
             */
            add_theme_support(
                'custom-background',
                apply_filters(
                    'akuna_custom_background_args',
                    array(
                        'default-color' => apply_filters('akuna_default_background_color', 'ffffff'),
                        'default-image' => '',
                    )
                )
            );

            /**
             *  Add support for the Site Logo plugin and the site logo functionality in JetPack
             *  https://github.com/automattic/site-logo
             *  http://jetpack.me/
             */
            add_theme_support(
                'site-logo',
                apply_filters(
                    'akuna_site_logo_args',
                    array(
                        'size' => 'full',
                    )
                )
            );

            /**
             * Declare support for title theme feature.
             */
            add_theme_support('title-tag');

            /**
             * Declare support for selective refreshing of widgets.
             */
            add_theme_support('customize-selective-refresh-widgets');

            /**
             * Add support for Block Styles.
             */
            add_theme_support('wp-block-styles');

            /**
             * Add support for full and wide align images.
             */
            add_theme_support('align-wide');

            /**
             * Add support for editor styles.
             */
            add_theme_support('editor-styles');

            /**
             * Add support for editor font sizes.
             */
            add_theme_support(
                'editor-font-sizes',
                array(
                    array(
                        'name' => __('Small', 'akuna'),
                        'size' => 14,
                        'slug' => 'small',
                    ),
                    array(
                        'name' => __('Normal', 'akuna'),
                        'size' => 16,
                        'slug' => 'normal',
                    ),
                    array(
                        'name' => __('Medium', 'akuna'),
                        'size' => 23,
                        'slug' => 'medium',
                    ),
                    array(
                        'name' => __('Large', 'akuna'),
                        'size' => 26,
                        'slug' => 'large',
                    ),
                    array(
                        'name' => __('Huge', 'akuna'),
                        'size' => 37,
                        'slug' => 'huge',
                    ),
                )
            );

            /**
             * Add support for responsive embedded content.
             */
            add_theme_support('responsive-embeds');
        }

        /**
         * Register widget area.
         *
         * @link https://codex.wordpress.org/Function_Reference/register_sidebar
         */
        public function widgets_init()
        {
            $sidebar_args['sidebar'] = array(
                'name'        => __('Sidebar', 'akuna'),
                'id'          => 'sidebar-1',
                'description' => '',
            );

            $rows    = intval(apply_filters('akuna_footer_widget_rows', 1));
            $regions = intval(apply_filters('akuna_footer_widget_columns', 4));

            for ($row = 1; $row <= $rows; $row++) {
                for ($region = 1; $region <= $regions; $region++) {
                    $footer_n = $region + $regions * ($row - 1); // Defines footer sidebar ID.
                    $footer   = sprintf('footer_%d', $footer_n);

                    if (1 === $rows) {
                        /* translators: 1: column number */
                        $footer_region_name = sprintf(__('Footer Column %1$d', 'akuna'), $region);

                        /* translators: 1: column number */
                        $footer_region_description = sprintf(__('Widgets added here will appear in column %1$d of the footer.', 'akuna'), $region);
                    } else {
                        /* translators: 1: row number, 2: column number */
                        $footer_region_name = sprintf(__('Footer Row %1$d - Column %2$d', 'akuna'), $row, $region);

                        /* translators: 1: column number, 2: row number */
                        $footer_region_description = sprintf(__('Widgets added here will appear in column %1$d of footer row %2$d.', 'akuna'), $region, $row);
                    }

                    $sidebar_args[$footer] = array(
                        'name'        => $footer_region_name,
                        'id'          => sprintf('footer-%d', $footer_n),
                        'description' => $footer_region_description,
                    );
                }
            }

            $sidebar_args = apply_filters('akuna_sidebar_args', $sidebar_args);

            foreach ($sidebar_args as $sidebar => $args) {
                $widget_tags = array(
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<span class="gamma widget-title">',
                    'after_title'   => '</span>',
                );

                /**
                 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
                 *
                 * 'akuna_sidebar_widget_tags'
                 *
                 * 'akuna_footer_1_widget_tags'
                 * 'akuna_footer_2_widget_tags'
                 * 'akuna_footer_3_widget_tags'
                 * 'akuna_footer_4_widget_tags'
                 */
                $filter_hook = sprintf('akuna_%s_widget_tags', $sidebar);
                $widget_tags = apply_filters($filter_hook, $widget_tags);

                if (is_array($widget_tags)) {
                    register_sidebar($args + $widget_tags);
                }
            }
        }

        /**
         * Enqueue scripts and styles.
         *
         * @since  1.0.0
         */
        public function scripts()
        {
            global $akuna_version;

            /**
             * Styles
             */
            wp_enqueue_style('akuna-style', get_template_directory_uri() . '/style.css', '', $akuna_version);

            wp_enqueue_style('akuna-icons', get_template_directory_uri() . '/assets/css/base/icons.css', '', $akuna_version);

            /**
             * Fonts
             */
            wp_enqueue_style('akuna-fonts', $this->google_fonts(), array(), $akuna_version);

            /**
             * Scripts
             */
            $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

            wp_enqueue_script('akuna-navigation', get_template_directory_uri() . '/assets/js/navigation.min.js', array(), $akuna_version, true);

            if (has_nav_menu('handheld')) {
                $akuna_l10n = array(
                    'expand'   => __('Expand child menu', 'akuna'),
                    'collapse' => __('Collapse child menu', 'akuna'),
                );

                wp_localize_script('akuna-navigation', 'akunaScreenReaderText', $akuna_l10n);
            }

            if (is_page_template('template-homepage.php') && has_post_thumbnail()) {
                wp_enqueue_style('akuna-slider-style', get_template_directory_uri() . '/assets/css/base/slider.css', '', $akuna_version);
                wp_enqueue_script('akuna-slider-script', get_template_directory_uri() . '/assets/js/slider' . $suffix . '.js', array(), $akuna_version, true);
            }

            if (is_singular() && comments_open() && get_option('thread_comments')) {
                wp_enqueue_script('comment-reply');
            }
        }

        /**
         * Register Google fonts.
         *
         * @since 1.0.0
         * @return string Google fonts URL for the theme.
         */
        public function google_fonts()
        {
            $google_fonts = apply_filters(
                'akuna_google_font_families',
                array(
                    'poppins' => 'Poppins:ital,wght@0,300;0,400;0,600;0,700;0,900;1,300;1,400',
                )
            );

            $query_args = array(
                'family'  => implode('|', $google_fonts),
                'display' => rawurlencode('swap'),
                'subset'  => rawurlencode('latin,latin-ext'),
            );

            $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');

            return $fonts_url;
        }

        /**
         * Enqueue child theme stylesheet.
         * A separate function is required as the child theme css needs to be enqueued _after_ the parent theme
         * primary css and the separate WooCommerce css.
         *
         * @since  1.0.0
         */
        public function child_scripts()
        {
            if (is_child_theme()) {
                $child_theme = wp_get_theme(get_stylesheet());
                wp_enqueue_style('akuna-child-style', get_stylesheet_uri(), array(), $child_theme->get('Version'));
            }
        }

        /**
         * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
         *
         * @param array $args Configuration arguments.
         * @return array
         */
        public function page_menu_args($args)
        {
            $args['show_home'] = true;
            return $args;
        }

        /**
         * Adds custom classes to the array of body classes.
         *
         * @param array $classes Classes for the body element.
         * @return array
         */
        public function body_classes($classes)
        {
            // Adds a class to blogs with more than 1 published author.
            if (is_multi_author()) {
                $classes[] = 'group-blog';
            }

            // Add class if align-wide is supported.
            if (current_theme_supports('align-wide')) {
                $classes[] = 'akuna-align-wide';
            }

            return $classes;
        }

        /**
         * Custom navigation markup template hooked into `navigation_markup_template` filter hook.
         */
        public function navigation_markup_template()
        {
            $template  = '<nav id="post-navigation" class="navigation %1$s" role="navigation" aria-label="' . esc_html__('Post Navigation', 'akuna') . '">';
            $template .= '<h2 class="screen-reader-text">%2$s</h2>';
            $template .= '<div class="nav-links">%3$s</div>';
            $template .= '</nav>';

            return apply_filters('akuna_navigation_markup_template', $template);
        }
    }
endif;

return new akuna();
