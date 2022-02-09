<?php

/**
 * akuna functions.
 *
 * @package akuna
 */

if (!function_exists('akuna_is_woocommerce_activated')) {
    /**
     * Query WooCommerce activation
     */
    function akuna_is_woocommerce_activated()
    {
        return class_exists('WooCommerce') ? true : false;
    }
}

/**
 * Apply inline style to the akuna header.
 *
 * @uses get_header_image()
 * @since 1.0.0
 */
function akuna_header_styles()
{
    $is_header_image = get_header_image();
    $header_bg_image = '';

    if ($is_header_image) {
        $header_bg_image = 'url(' . esc_url($is_header_image) . ')';
    }

    $styles = array();

    if ('' !== $header_bg_image) {
        $styles['background-image'] = $header_bg_image;
    }

    $styles = apply_filters('akuna_header_styles', $styles);

    foreach ($styles as $style => $value) {
        echo esc_attr($style . ': ' . $value . '; ');
    }
}

/**
 * Call a shortcode function by tag name.
 *
 * @since  1.0.0
 *
 * @param string $tag     The shortcode whose function to call.
 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param array  $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
function akuna_do_shortcode($tag, array $atts = array(), $content = null)
{
    global $shortcode_tags;

    if (!isset($shortcode_tags[$tag])) {
        return false;
    }

    return call_user_func($shortcode_tags[$tag], $atts, $content, $tag);
}
