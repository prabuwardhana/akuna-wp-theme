<?php

/**
 * The template for displaying akuna shop pages.
 *
 * @package akuna
 */

get_header();

$query_var = get_query_var('product_tag');
?>

<div id="primary" class="content-area">

    <header class="entry-header">
        <?php
        $current_tags = get_term_by('slug', $query_var, 'product_tag', 'ARRAY_A');
        $thumbnail_id = absint(get_term_meta($current_tags["term_id"], 'thumbnail_id', true));
        $sized_image = image_downsize($thumbnail_id, 'woocommerce_thumbnail');

        if ($thumbnail_id) {
            $image = $sized_image[0];
        } else {
            $image = wc_placeholder_img_src();
        }

        ?>
        <div class="product-tag-banner-container">
            <div class="product-tag-img">
                <img src="<?php echo esc_url($image); ?>" />
            </div>
            <div class="product-tag-info">
                <div class="tag-name">
                    <h1><?php echo $current_tags['name'] ?></h1>
                </div>
                <div class="tag-description">
                    <p><?php echo $current_tags['description'] ?></p>
                </div>
            </div>
        </div>
    </header>

    <main id="main" class="site-main" role="main">
        <?php
        $query_args = array(
            'post_type'         => 'product',
            'orderby'           => 'date',
            'order'             => 'ASC',
            'post_status'       => 'publish',
        );

        // Theme_mod settings to check.
        $settings = get_theme_mod('products_list_settings');

        foreach ($settings as $setting) :
            $term = get_term_by('id', $setting['product_category'], 'product_cat', 'ARRAY_A');
        ?>
            <div id="<?php echo $term['slug'] ?>" class="product-list-container">
                <?php
                $query_args['tax_query'] = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => $term['slug'],
                    ),
                    array(
                        'taxonomy' => 'product_tag',
                        'field'    => 'slug',
                        'terms'    => $query_var,
                    ),
                );

                $products_list = new WP_Query($query_args);

                if ($products_list->have_posts()) {
                ?>
                    <div class="shop-term-description">
                        <h2><?php echo $term['name'] ?></h2>
                        <p><?php echo $term['description'] ?></p>
                    </div>
                <?php
                    woocommerce_product_loop_start();

                    while ($products_list->have_posts()) {
                        $products_list->the_post();

                        wc_get_template_part('content', 'product');
                    }

                    woocommerce_product_loop_end();
                }

                wp_reset_postdata();
                ?>
            </div>
        <?php endforeach; ?>
    </main><!-- #main -->

    <footer class="entry-footer">
        <div class="shop-featured-image">
            <img src="<?php echo get_theme_mod('image_setting_url', ''); ?>" />
        </div>
    </footer>
</div><!-- #primary -->

<?php
get_footer();
