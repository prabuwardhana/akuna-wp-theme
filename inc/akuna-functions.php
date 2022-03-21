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

/**
 * Get the content background color
 * Accounts for the akuna Designer and akuna Powerpack content background option.
 *
 * @since  1.0.0
 * @return string the background color
 */
function akuna_get_content_background_color()
{

    $bg_color = str_replace('#', '', get_theme_mod('background_color'));

    return '#' . $bg_color;
}

/**
 * Given an hex colors, returns an array with the colors components.
 *
 * @param  string $hex Hex color e.g. #111111.
 * @return bool        Array with color components (r, g, b).
 * @since  1.0.0
 */
function get_rgb_values_from_hex($hex)
{
    // Format the hex color string.
    $hex = str_replace('#', '', $hex);

    if (3 === strlen($hex)) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }

    // Get decimal values.
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    return array(
        'r' => $r,
        'g' => $g,
        'b' => $b,
    );
}

/**
 * Adjust a hex color brightness
 * Allows us to create hover styles for custom link colors
 *
 * @param  strong  $hex     Hex color e.g. #111111.
 * @param  integer $steps   Factor by which to brighten/darken ranging from -255 (darken) to 255 (brighten).
 * @param  float   $opacity Opacity factor between 0 and 1.
 * @return string           Brightened/darkened color (hex by default, rgba if opacity is set to a valid value below 1).
 * @since  1.0.0
 */
function akuna_adjust_color_brightness($hex, $steps, $opacity = 1)
{
    // Steps should be between -255 and 255. Negative = darker, positive = lighter.
    $steps = max(-255, min(255, $steps));

    $rgb_values = get_rgb_values_from_hex($hex);

    // Adjust number of steps and keep it inside 0 to 255.
    $r = max(0, min(255, $rgb_values['r'] + $steps));
    $g = max(0, min(255, $rgb_values['g'] + $steps));
    $b = max(0, min(255, $rgb_values['b'] + $steps));

    if ($opacity >= 0 && $opacity < 1) {
        return 'rgba(' . $r . ',' . $g . ',' . $b . ',' . $opacity . ')';
    }

    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return '#' . $r_hex . $g_hex . $b_hex;
}

/**
 * Get the product tag slug from the request URI
 * Accounts for the akuna Designer and akuna Powerpack content background option.
 *
 * @since  1.0.0
 * @return string the product tag slug
 */
function akuna_get_product_tag_slug()
{
    // Extract the product tag slug
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri_segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

    return array_pop($uri_segments);
}
