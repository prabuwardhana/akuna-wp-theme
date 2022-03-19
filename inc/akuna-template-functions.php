<?php

/**
 * akuna template functions.
 *
 * @package akuna
 */

if (!function_exists('akuna_header_container')) {
    /**
     * The header container
     */
    function akuna_header_container()
    {
        echo '<div class="header-container">';
    }
}

if (!function_exists('akuna_header_container_close')) {
    /**
     * The header container close
     */
    function akuna_header_container_close()
    {
        echo '</div>';
    }
}

if (!function_exists('akuna_primary_navigation_wrapper')) {
    /**
     * The primary navigation wrapper
     */
    function akuna_primary_navigation_wrapper()
    {
        echo '<div class="akuna-primary-navigation header-item">';
    }
}

if (!function_exists('akuna_primary_navigation_wrapper_close')) {
    /**
     * The primary navigation wrapper close
     */
    function akuna_primary_navigation_wrapper_close()
    {
        echo '</div>';
    }
}

if (!function_exists('akuna_primary_navigation')) {
    /**
     * Display Primary Navigation
     *
     * @since  1.0.0
     */
    function akuna_primary_navigation()
    {
?>
        <!-- #site-navigation -->
        <div class="menu-mobile-toggle">
            <svg height="32px" id="menu-btn" viewBox="0 0 32 32">
                <path fill="black" d="M4,10h24c1.104,0,2-0.896,2-2s-0.896-2-2-2H4C2.896,6,2,6.896,2,8S2.896,10,4,10z M28,14H4c-1.104,0-2,0.896-2,2s0.896,2,2,2h24c1.104,0,2-0.896,2-2S29.104,14,28,14z M28,22H4c-1.104,0-2,0.896-2,2s0.896,2,2,2h24c1.104,0,2-0.896,2-2S29.104,22,28,22z" />
            </svg>
        </div>
        <?php
        wp_nav_menu(
            array(
                'theme_location'  => 'primary',
                'container_class' => 'primary-navigation',
            )
        );
    }
}

if (!function_exists('akuna_secondary_nav_container')) {
    /**
     * The header container
     */
    function akuna_secondary_nav_container()
    {
        echo '<div class="cat-nav-container">';
    }
}

if (!function_exists('akuna_secondary_nav_container_close')) {
    /**
     * The header container close
     */
    function akuna_secondary_nav_container_close()
    {
        echo '</div>';
    }
}

if (!function_exists('akuna_secondary_navigation')) {
    /**
     * Display Secondary Navigation
     *
     * @since  1.0.0
     * @return void
     */
    function akuna_secondary_navigation()
    {
        wp_nav_menu(
            array(
                'theme_location'  => 'secondary',
                'container_class' => 'secondary-navigation',
            )
        );
    }
}

if (!function_exists('akuna_page_navigation')) {
    /**
     * Display Page Navigation
     *
     * @since  1.0.0
     * @return void
     */
    function akuna_page_navigation($theParent, $testArray)
    {
        if ($theParent or $testArray) :
        ?>
            <div class="cat-nav-container">
                <div class="secondary-navigation">
                    <ul class="menu">
                        <li class="page-links__title">
                            <a href="<?php echo get_permalink($theParent); ?>">
                                <?php
                                echo get_the_title($theParent);
                                ?>
                            </a>
                        </li>
                        <?php
                        if ($theParent) {
                            $findChildrenOf = $theParent;
                        } else {
                            $findChildrenOf = get_the_ID();
                        }

                        wp_list_pages(array(
                            'title_li' => NULL,
                            'child_of' => $findChildrenOf,
                            'sort_column' => 'menu_order'
                        ));
                        ?>
                    </ul>
                </div>
            </div>
        <?php
        endif;
    }
}

if (!function_exists('akuna_site_branding')) {
    /**
     * Site branding wrapper and display
     *
     * @since  1.0.0
     */
    function akuna_site_branding()
    {
        ?>
        <div class="site-branding header-item">
            <?php akuna_site_title_or_logo(); ?>
        </div>
        <?php
    }
}

if (!function_exists('akuna_site_title_or_logo')) {
    /**
     * Display the site title or logo
     *
     * @since 1.0.0
     * @param bool $echo Echo the string or return it.
     * @return string
     */
    function akuna_site_title_or_logo($echo = true)
    {
        if (function_exists('the_custom_logo') && has_custom_logo()) {
            $logo = get_custom_logo();
            $html = is_home() ? '<h1 class="logo">' . $logo . '</h1>' : $logo;
        } else {
            $tag = is_home() ? 'h1' : 'div';

            $html = '<' . esc_attr($tag) . ' class="site-title"><a href="' . esc_url(home_url('/')) . '" rel="home">' . esc_html(get_bloginfo('name')) . '</a></' . esc_attr($tag) . '>';

            if ('' !== get_bloginfo('description')) {
                $html .= '<p class="site-description" style="display:none;">' . esc_html(get_bloginfo('description', 'display')) . '</p>';
            }
        }

        if (!$echo) {
            return $html;
        }

        echo $html;
    }
}

if (!function_exists('akuna_secondary_nav_container')) {
    /**
     * The header container
     */
    function akuna_secondary_nav_container()
    {
        echo '<div class="akuna-secondary-navigation">';
    }
}

if (!function_exists('akuna_secondary_nav_container_close')) {
    /**
     * The header container close
     */
    function akuna_secondary_nav_container_close()
    {
        echo '</div>';
    }
}

if (!function_exists('akuna_footer_widgets')) {
    /**
     * Display the footer widget regions.
     *
     * @since  1.0.0
     */
    function akuna_footer_widgets()
    {
        $rows    = intval(apply_filters('akuna_footer_widget_rows', 1));
        $regions = intval(apply_filters('akuna_footer_widget_columns', 4));

        for ($row = 1; $row <= $rows; $row++) :

            // Defines the number of active columns in this footer row.
            for ($region = $regions; 0 < $region; $region--) {
                if (is_active_sidebar('footer-' . esc_attr($region + $regions * ($row - 1)))) {
                    $columns = $region;
                    break;
                }
            }

            if (isset($columns)) :
        ?>
                <div class=<?php echo '"footer-widgets row-' . esc_attr($row) . ' col-' . esc_attr($columns) . ' fix"'; ?>>
                    <?php
                    for ($column = 1; $column <= $columns; $column++) :
                        $footer_n = $column + $regions * ($row - 1);

                        if (is_active_sidebar('footer-' . esc_attr($footer_n))) :
                    ?>
                            <div class="block footer-widget-<?php echo esc_attr($column); ?>">
                                <?php dynamic_sidebar('footer-' . esc_attr($footer_n)); ?>
                            </div>
                    <?php
                        endif;
                    endfor;
                    ?>
                </div><!-- .footer-widgets.row-<?php echo esc_attr($row); ?> -->
        <?php
                unset($columns);
            endif;
        endfor;
    }
}

if (!function_exists('akuna_credit')) {
    /**
     * Display the theme credit
     *
     * @since  1.0.0
     */
    function akuna_credit()
    {
        $links_output = '';

        if (apply_filters('akuna_privacy_policy_link', true) && function_exists('the_privacy_policy_link')) {
            $separator    = '<span role="separator" aria-hidden="true"></span>';
            $links_output = get_the_privacy_policy_link('', (!empty($links_output) ? $separator : '')) . $links_output;
        }

        $links_output = apply_filters('akuna_credit_links_output', $links_output);
        ?>
        <div class="site-info">
            <?php echo esc_html(apply_filters('akuna_copyright_text', $content = '&copy; ' . get_bloginfo('name') . ' ' . gmdate('Y'))); ?>

            <?php if (!empty($links_output)) { ?>
                <br />
                <?php echo wp_kses_post($links_output); ?>
            <?php } ?>
        </div><!-- .site-info -->
    <?php
    }
}

if (!function_exists('akuna_post_meta')) {
    /**
     * Display the post meta
     *
     * @since 1.0.0
     */
    function akuna_post_meta()
    {
        if ('post' !== get_post_type()) {
            return;
        }

        // Posted on.
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date('c')),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date('c')),
            esc_html(get_the_modified_date())
        );

        $output_time_string = sprintf('<a href="%1$s" rel="bookmark">%2$s</a>', esc_url(get_permalink()), $time_string);

        $posted_on = '
			<span class="posted-on">' .
            /* translators: %s: post date */
            sprintf(__('Posted on %s', 'akuna'), $output_time_string) .
            '</span>';

        // Author.
        $author = sprintf(
            '<span class="post-author">%1$s <a href="%2$s" class="url fn" rel="author">%3$s</a></span>',
            __('by', 'akuna'),
            esc_url(get_author_posts_url(get_the_author_meta('ID'))),
            esc_html(get_the_author())
        );

        // Comments.
        $comments = '';

        if (!post_password_required() && (comments_open() || 0 !== intval(get_comments_number()))) {
            $comments_number = get_comments_number_text(__('Leave a comment', 'akuna'), __('1 Comment', 'akuna'), __('% Comments', 'akuna'));

            $comments = sprintf(
                '<span class="post-comments">&mdash; <a href="%1$s">%2$s</a></span>',
                esc_url(get_comments_link()),
                $comments_number
            );
        }

        echo wp_kses(
            sprintf('%1$s %2$s %3$s', $posted_on, $author, $comments),
            array(
                'span' => array(
                    'class' => array(),
                ),
                'a'    => array(
                    'href'  => array(),
                    'title' => array(),
                    'rel'   => array(),
                ),
                'time' => array(
                    'datetime' => array(),
                    'class'    => array(),
                ),
            )
        );
    }
}

if (!function_exists('akuna_post_header')) {
    /**
     * Display the post header with a link to the single post
     *
     * @since 1.0.0
     */
    function akuna_post_header()
    {
    ?>
        <header class="entry-header">
            <?php

            /**
             * Functions hooked into akuna_post_header_before action.
             *
             * @hooked akuna_post_meta - 10
             */
            do_action('akuna_post_header_before');

            if (is_single()) {
                the_title('<h1 class="entry-title">', '</h1>');
            } else {
                the_title(sprintf('<h2 class="alpha entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>');
            }

            do_action('akuna_post_header_after');
            ?>
        </header><!-- .entry-header -->
    <?php
    }
}

if (!function_exists('akuna_post_thumbnail')) {
    /**
     * Display post thumbnail
     *
     * @var $size thumbnail size. thumbnail|medium|large|full|$custom
     * @uses has_post_thumbnail()
     * @uses the_post_thumbnail
     * @param string $size the post thumbnail size.
     * @since 1.0.0
     */
    function akuna_post_thumbnail($size = 'full')
    {
        if (has_post_thumbnail()) {
            the_post_thumbnail($size);
        }
    }
}

if (!function_exists('akuna_post_content')) {
    /**
     * Display the post content with a link to the single post
     *
     * @since 1.0.0
     */
    function akuna_post_content()
    {
    ?>
        <div class="entry-content">
            <?php

            /**
             * Functions hooked into akuna_post_content_before action.
             *
             * @hooked akuna_post_thumbnail - 10
             */
            do_action('akuna_post_content_before');

            the_content(
                sprintf(
                    /* translators: %s: post title */
                    __('Continue reading %s', 'akuna'),
                    '<span class="screen-reader-text">' . get_the_title() . '</span>'
                )
            );

            do_action('akuna_post_content_after');

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . __('Pages:', 'akuna'),
                    'after'  => '</div>',
                )
            );
            ?>
        </div><!-- .entry-content -->
    <?php
    }
}

if (!function_exists('akuna_post_taxonomy')) {
    /**
     * Display the post taxonomies
     *
     * @since 1.0.0
     */
    function akuna_post_taxonomy()
    {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list(__(', ', 'akuna'));

        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list('', __(', ', 'akuna'));
    ?>

        <aside class="entry-taxonomy">
            <?php if ($categories_list) : ?>
                <div class="cat-links">
                    <?php echo esc_html(_n('Category:', 'Categories:', count(get_the_category()), 'akuna')); ?> <?php echo wp_kses_post($categories_list); ?>
                </div>
            <?php endif; ?>

            <?php if ($tags_list) : ?>
                <div class="tags-links">
                    <?php echo esc_html(_n('Tag:', 'Tags:', count(get_the_tags()), 'akuna')); ?> <?php echo wp_kses_post($tags_list); ?>
                </div>
            <?php endif; ?>
        </aside>

    <?php
    }
}

if (!function_exists('akuna_paging_nav')) {
    /**
     * Display navigation to next/previous set of posts when applicable.
     */
    function akuna_paging_nav()
    {
        global $wp_query;

        $args = array(
            'type'      => 'list',
            'next_text' => _x('Next', 'Next post', 'akuna'),
            'prev_text' => _x('Previous', 'Previous post', 'akuna'),
        );

        the_posts_pagination($args);
    }
}

if (!function_exists('akuna_post_nav')) {
    /**
     * Display navigation to next/previous post when applicable.
     */
    function akuna_post_nav()
    {
        $args = array(
            'next_text' => '<span class="screen-reader-text">' . esc_html__('Next post:', 'akuna') . ' </span>%title',
            'prev_text' => '<span class="screen-reader-text">' . esc_html__('Previous post:', 'akuna') . ' </span>%title',
        );
        the_post_navigation($args);
    }
}

if (!function_exists('akuna_post_header')) {
    /**
     * Display the post header with a link to the single post
     *
     * @since 1.0.0
     */
    function akuna_post_header()
    {
    ?>
        <header class="entry-header">
            <?php

            /**
             * Functions hooked in to akuna_post_header_before action.
             *
             * @hooked akuna_post_meta - 10
             */
            do_action('akuna_post_header_before');

            if (is_single()) {
                the_title('<h1 class="entry-title">', '</h1>');
            } else {
                the_title(sprintf('<h2 class="alpha entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>');
            }

            do_action('akuna_post_header_after');
            ?>
        </header><!-- .entry-header -->
    <?php
    }
}

if (!function_exists('akuna_post_content')) {
    /**
     * Display the post content with a link to the single post
     *
     * @since 1.0.0
     */
    function akuna_post_content()
    {
    ?>
        <div class="entry-content">
            <?php

            /**
             * Functions hooked in to akuna_post_content_before action.
             *
             * @hooked akuna_post_thumbnail - 10
             */
            do_action('akuna_post_content_before');

            the_content(
                sprintf(
                    /* translators: %s: post title */
                    __('Continue reading %s', 'akuna'),
                    '<span class="screen-reader-text">' . get_the_title() . '</span>'
                )
            );

            do_action('akuna_post_content_after');

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . __('Pages:', 'akuna'),
                    'after'  => '</div>',
                )
            );
            ?>
        </div><!-- .entry-content -->
    <?php
    }
}

if (!function_exists('akuna_edit_post_link')) {
    /**
     * Display the edit link
     *
     * @since 1.0.0
     */
    function akuna_edit_post_link()
    {
        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __('Edit <span class="screen-reader-text">%s</span>', 'akuna'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ),
            '<div class="edit-link">',
            '</div>'
        );
    }
}

if (!function_exists('akuna_display_comments')) {
    /**
     * akuna display comments
     *
     * @since  1.0.0
     */
    function akuna_display_comments()
    {
        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || 0 !== intval(get_comments_number())) :
            comments_template();
        endif;
    }
}

if (!function_exists('akuna_page_header')) {
    /**
     * Display the page header
     *
     * @since 1.0.0
     */
    function akuna_page_header()
    {
        if (is_front_page() && is_page_template('template-fullwidth.php')) {
            return;
        }

    ?>
        <header class="entry-header">
            <?php
            akuna_post_thumbnail('full');
            ?>
        </header><!-- .entry-header -->
    <?php
    }
}

if (!function_exists('akuna_page_content')) {
    /**
     * Display the post content
     *
     * @since 1.0.0
     */
    function akuna_page_content()
    {
    ?>
        <div class="entry-content">
            <?php the_content(); ?>
            <?php
            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . __('Pages:', 'akuna'),
                    'after'  => '</div>',
                )
            );
            ?>
        </div><!-- .entry-content -->
    <?php
    }
}

if (!function_exists('akuna_hero_image_slider')) {
    /**
     * Display the page header without the featured image
     *
     * @since 1.0.0
     */
    function akuna_hero_image_slider()
    {
        // Theme_mod settings to check.
        $settings = get_theme_mod('slider_settings');
    ?>
        <section class="entry-header">
            <div class="slider">
                <?php foreach ($settings as $setting) : ?>
                    <div class="slide active">
                        <img src="<?php echo esc_url($setting['background_img']) ?>" alt="<?php echo $setting['heading_text'] ?>">
                        <div class="info">
                            <h2><?php echo $setting['heading_text'] ?></h2>
                            <p><?php echo $setting['sub_heading_text'] ?></p>
                            <a href="<?php echo esc_url(get_page_link($setting['button_page_link'])); ?>" class="button alt">
                                <?php echo $setting['button_text'] ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (count($settings) > 1) : ?>
                    <div class="navigation">
                        <i class="fas fa-chevron-left prev-btn"></i>
                        <i class="fas fa-chevron-right next-btn"></i>
                    </div>
                    <div class="navigation-visibility">
                        <?php foreach ($settings as $setting) : ?>
                            <div class="slide-icon"></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif ?>
            </div>
        </section><!-- .entry-header -->
<?php
    }
}

if (!function_exists('akuna_homepage_content')) {
    /**
     * Display homepage content
     * Hooked into the `homepage` action in the homepage template
     *
     * @since  1.0.0
     * @return  void
     */
    function akuna_homepage_content()
    {
        while (have_posts()) {
            the_post();

            get_template_part('content', 'homepage');
        } // end of the loop.
    }
}
