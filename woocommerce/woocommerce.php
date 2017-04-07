<?php
/**
 * Woocommerce Compatibility 
 *
 * @package Courtyard
 */


if ( !class_exists('WooCommerce') )
    return;

/**
 * Declare support
 */
function courtyard_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'courtyard_woocommerce_support' );

/**
 * Add and remove actions
 */
function courtyard_woo_actions() {
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

    add_action('woocommerce_before_main_content', 'courtyard_wrapper_start', 10);
    add_action('woocommerce_after_main_content', 'courtyard_wrapper_end', 10);
    add_action( 'woocommerce_sidebar', 'courtyard_woocommerce_sidebar', 20 ); 
}
add_action('wp','courtyard_woo_actions');

/**
 * Theme wrappers
 */
function courtyard_wrapper_start() {
    echo '<div class="container">';
    echo    '<div class="row"><div id="primary" class="pt-primary-wrap '.esc_attr( courtyard_primary_sidebar() ).'">';
    echo        '<div class="pt-content-wrap pt-content-wrap-border">';
}

function courtyard_wrapper_end() {
    echo            '</div>';
    echo        '</div>';
}
// define the woocommerce_sidebar callback 
function courtyard_woocommerce_sidebar( ) { 
    courtyard_sidebar_select();
    echo    '</div>';
    echo '</div>';
};