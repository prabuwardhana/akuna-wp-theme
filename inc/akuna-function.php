<?php

/**
 * akuna functions.
 *
 * @package akuna
 */

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
