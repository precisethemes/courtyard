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
    // adding the WooCommerce plugin support
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
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
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

    add_action('woocommerce_before_main_content', 'courtyard_wrapper_start', 10);
    add_action('woocommerce_after_main_content', 'courtyard_wrapper_end', 10);
    add_action( 'woocommerce_sidebar', 'courtyard_woocommerce_sidebar', 20 ); 
    add_action( 'woo_custom_breadcrumb', 'courtyard_woocommerce_breadcrumb' );

    add_filter( 'woocommerce_breadcrumb_defaults', 'my_woocommerce_breadcrumbs' );
}
add_action('wp','courtyard_woo_actions');

/**
 * WooCommerce Breadcrum before theme wrappers
 */
function courtyard_woocommerce_breadcrumb(){
    echo '<div class="container">';
    echo '<div class="row">';
    echo '<div class="col-md-12">';
    woocommerce_breadcrumb();
    echo '</div>';
    echo '</div>';
    echo '</div>';

}

function my_woocommerce_breadcrumbs() {
    $delimiter = get_theme_mod( 'courtyard_breadcrumbs_sep', '/' );
    if ( $delimiter == '' ) {
        $delimiter    = '/'; // delimiter between crumbs
    }
    $home_title       = esc_html__('Home', 'courtyard');
    return array(
        'delimiter'   => '<li class="pt-breadcrumbs-delimiter">'.$delimiter.'</li>',
        'wrap_before' => '<ul class="pt-breadcrumbs-items">',
        'wrap_after'  => '</ul>',
        'before'      => '<li>',
        'after'       => '</li>',
        'home'        => $home_title,
    );
}

/**
 * Theme wrappers
 */
function courtyard_wrapper_start() {

    do_action('woo_custom_breadcrumb');

    echo '<div class="container">';
    echo    '<div class="row"><div id="primary" class="pt-primary-wrap '.esc_attr( courtyard_woocommerce_primary_sidebar_class() ).'">';
    echo        '<div class="pt-content-wrap pt-content-wrap-border">';
}

function courtyard_wrapper_end() {
    echo            '</div>';
    echo        '</div>';
}
// define the woocommerce_sidebar callback 
function courtyard_woocommerce_sidebar( ) { 
    courtyard_woocommerce_sidebar_select();
    echo    '</div>';
    echo '</div>';
};

/*---------------------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'courtyard_woocommerce_sidebar_layout_class' ) ) :
/**
 * Generate layout class for sidebar based on customizer and post meta settings for woocommerce pages.
 */
function courtyard_woocommerce_sidebar_layout_class() {
    global $post;

    $layout = get_theme_mod( 'courtyard_woocommerce_shop_sidebar', 'right_sidebar' );


    // Front page displays in Reading Settings
    $page_for_posts = get_option('page_for_posts');

    // Get Layout meta
    if($post) {
        $layout_meta = get_post_meta( $post->ID, 'page_specific_layout', true );
    }
    // Home page if Posts page is assigned
    if( is_home() && !( is_front_page() ) ) {
        $queried_id = get_option( 'page_for_posts' );
        $layout_meta = get_post_meta( $queried_id, 'page_specific_layout', true );

        if( $layout_meta != 'default_layout' && $layout_meta != '' ) {
            $layout = get_post_meta( $queried_id, 'page_specific_layout', true );
        }
    }

    elseif( is_page() ) {
        $layout = get_theme_mod( 'courtyard_woocommerce_shop_sidebar', 'right_sidebar' );
        if( $layout_meta != 'default_layout' && $layout_meta != '' ) {
            $layout = get_post_meta( $post->ID, 'page_specific_layout', true );
        }
    }

    elseif( is_single() ) {
        $layout = get_theme_mod( 'courtyard_woocommerce_product_sidebar', 'right_sidebar' );
        if( $layout_meta != 'default_layout' && $layout_meta != '' ) {
            $layout = get_post_meta( $post->ID, 'page_specific_layout', true );
        }
    }

    return $layout;
}
endif;

/*--------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'courtyard_woocommerce_primary_sidebar_class' ) ) :
/**
 * Select and show sidebar based on post meta and WooCommerce customizer default settings
 */
function courtyard_woocommerce_primary_sidebar_class() {
    $layout = courtyard_woocommerce_sidebar_layout_class();
    
    if ( $layout == "right_sidebar" ) {
        $classes = 'col-md-8';
    } elseif ( $layout == "left_sidebar" ) {
        $classes = 'col-md-8 pull-right';
    } elseif ( $layout == "no_sidebar_full_width" ) {
        $classes = 'col-md-12';
    }
    return esc_html( $classes );
}
endif;

/*--------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'courtyard_woocommerce_secondary_sidebar_class' ) ) :
/**
 * Select and show sidebar based on post meta and customizer default settings
 */
function courtyard_woocommerce_secondary_sidebar_class() {
    $layout = courtyard_woocommerce_sidebar_layout_class();
    
    if ( $layout == "right_sidebar" ) {
        $classes = 'col-md-4 ';
    } elseif ( $layout == "left_sidebar" ) {
        $classes = 'col-md-4 pull-left';
    } elseif ( $layout == "no_sidebar_full_width" ) {
        $classes = 'col-md-12';
    }
    return esc_html( $classes );
}
endif;

/*--------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'courtyard_woocommerce_sidebar_select' ) ) :
/**
 * Select and show sidebar based on post meta and WooCommerce customizer default settings
 */
function courtyard_woocommerce_sidebar_select() {
    $layout = courtyard_woocommerce_sidebar_layout_class();
    if( $layout != "no_sidebar_full_width" ) {
        if ( $layout == "right_sidebar" || $layout = "left_sidebar" || $layout = "default_layout" ) {
            echo '<div class="'.esc_attr( courtyard_woocommerce_secondary_sidebar_class() ).'">';
            get_sidebar();
            echo '</div>';
        }
    }
}
endif;

/*--------------------------------------------------------------------------------------------------*/
/**
 * WooCommerce Cart Icon in Primary Menu
 */
function pt_woo_cart_icon( $items, $args ) {
    if ( $args->theme_location == 'primary' ) {
        if( class_exists( 'WooCommerce' ) ) :
            $items .= '<a class="pt-cart"></a>';
        endif;
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'pt_woo_cart_icon', 10, 2 );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;

   ob_start();
    ?>
    <a class="pt-cart" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><i class="fa fa-shopping-cart"></i><?php if( WC()->cart->get_cart_contents_count() >= 1 ) { ?><span class="pt-cart-value"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'courtyard'), $woocommerce->cart->cart_contents_count);?></span><?php } ?></a>
    <?php

   $fragments['a.pt-cart'] = ob_get_clean();

   return $fragments;
}
add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
