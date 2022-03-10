<?php

/**
 * The template for displaying akuna shop pages.
 *
 * @package akuna
 */

get_header(); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php
        $query_args = array(
            'post_type'         => 'product',
            'orderby'           => 'date',
            'order'             => 'ASC',
            'post_status'       => 'publish',
            // 'meta_query' => array(
            //     'relation' => 'AND',
            //     array(
            //         'key'           => '_sale_price',
            //         'value'         => 0,
            //         'compare'       => '>',
            //         'type'          => 'numeric'
            //     ),
            //     array(
            //         'key'           => '_regular_price',
            //         'value'         => 0,
            //         'compare'       => '>',
            //         'type'          => 'numeric'
            //     )
            // ),
            // 'post__in'       => wc_get_featured_product_ids(),
        );
        ?>
        <div class="product-list-container">
            <?php
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => 'accessories',
                ),
            );

            $recent_products = new WP_Query($query_args);
            $terms = $recent_products->get('tax_query')[0]['terms'];

            if ($recent_products->have_posts()) {
            ?>
                <div class="shop-term-description">
                    <h2><?php echo ucwords($terms) ?></h2>
                    <p><?php echo category_description(get_term_by('slug', $terms, 'product_cat')->term_id) ?></p>
                </div>
            <?php
                woocommerce_product_loop_start();
                while ($recent_products->have_posts()) {
                    $recent_products->the_post();
                    wc_get_template_part('content', 'product');
                }
                woocommerce_product_loop_end();
            }

            wp_reset_postdata();
            ?>
        </div>
        <div class="product-list-container">
            <?php
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => 'tshirts',
                ),
            );

            $recent_products = new WP_Query($query_args);
            $terms = $recent_products->get('tax_query')[0]['terms'];

            if ($recent_products->have_posts()) {
            ?>
                <div class="shop-term-description">
                    <h2><?php echo ucwords($terms) ?></h2>
                    <p><?php echo category_description(get_term_by('slug', $terms, 'product_cat')->term_id) ?></p>
                </div>
            <?php
                woocommerce_product_loop_start();
                while ($recent_products->have_posts()) {
                    $recent_products->the_post();
                    wc_get_template_part('content', 'product');
                }
                woocommerce_product_loop_end();
            }

            wp_reset_postdata();
            ?>
        </div>
    </main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();
