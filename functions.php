<?php

/**
 * akuna functions
 *
 * @package akuna
 */

/**
 * Assign the akuna version to a var
 */
$theme         = wp_get_theme('akuna');
$akuna_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (!isset($content_width)) {
    $content_width = 980; /* pixels */
}

$akuna = (object) array(
    'version'    => $akuna_version,
);

require 'inc/akuna-functions.php';
require 'inc/akuna-template-hooks.php';
require 'inc/akuna-template-functions.php';
