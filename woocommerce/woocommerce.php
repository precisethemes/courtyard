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

if ( ! function_exists( 'courtyard_woocommerce_widgets_init' ) ) :
add_action( 'widgets_init', 'courtyard_woocommerce_widgets_init' );
/**
 * Register widget area related to WooCommerce.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function courtyard_woocommerce_widgets_init() {

    // Register sidebar for WooCommerce Pages
    $woocommerce_sidebar = get_theme_mod( 'courtyard_pro_woocommerce_new_sidebar_activate', '' );
    if ( '' != $woocommerce_sidebar ) {
        register_sidebar( array(
            'name'          => esc_html__( 'WooCommerce - Sidebar', 'courtyard' ),
            'id'            => 'pt_woocommerce_sidebar',
            'description'   => esc_html__( 'Add widgets in your WooCommerce sidebar of theme.', 'courtyard' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>'
        ) );
    }
}
endif;

/*---------------------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'courtyard_woocommerce_sidebar_layout_class' ) ) :
/**
 * Generate layout class for sidebar based on customizer and post meta settings for woocommerce pages.
 */
function courtyard_woocommerce_sidebar_layout_class() {
    global $post;

    $layout = get_theme_mod( 'courtyard_woocommerce_blog_sidebar', 'right_sidebar' );


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
        $layout = get_theme_mod( 'courtyard_woocommerce_blog_sidebar', 'right_sidebar' );
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
