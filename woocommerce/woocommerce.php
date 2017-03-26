<?php
/**
 * Woocommerce Compatibility 
 *
 * @package Courtyard
 */


if ( !class_exists('WooCommerce') )
    return;

/**
 * Add and remove actions
 */
function courtyard_woo_actions() {
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
    add_action('woocommerce_before_main_content', 'courtyard_wrapper_start', 10);
    add_action('woocommerce_after_main_content', 'courtyard_wrapper_end', 10);
    add_action('woocommerce_sidebar', 'courtyard_sidebar_wrapper_end', 20);
}
add_action('wp','courtyard_woo_actions');

/**
 * Theme wrappers
 */
function courtyard_wrapper_start() {
    echo '<div class="container"><div class="row"><div id="primary" class="pt-primary-wrap '.esc_attr( courtyard_primary_sidebar() ).'"><div class="pt-content-wrap pt-content-wrap-border">';
}

function courtyard_wrapper_end() {
    echo '</div></div>';
}
function courtyard_sidebar_wrapper_end() {
    echo '</div></div>';
}
