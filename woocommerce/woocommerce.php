<?php
/**
 * WooCommerce Compatibility
 *
 * @package Courtyard Pro
 */

if( !class_exists( 'WooCommerce' ) )
    return;

/*----------------------------------------------------------------------
# WooCommerce Support Declare
-------------------------------------------------------------------------*/
if ( !function_exists( 'courtyard_woocommerce_support' ) ) {
    function courtyard_woocommerce_support() {
        add_theme_support( 'woocommerce' );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
    }
}
add_action( 'after_setup_theme', 'courtyard_woocommerce_support' );

/*----------------------------------------------------------------------
# WooCommerce Add, Remove and Filter Actions
-------------------------------------------------------------------------*/
if ( !function_exists( 'courtyard_woocommerce_actions' ) ) {
    function courtyard_woocommerce_actions() {

        // Remove Hook Action
        remove_action( 'woocommerce_before_main_content',           'woocommerce_breadcrumb',                   20 );
        remove_action( 'woocommerce_before_main_content',           'woocommerce_output_content_wrapper',       10 );
        remove_action( 'woocommerce_before_shop_loop',              'woocommerce_result_count',                 20 );
        remove_action( 'woocommerce_after_main_content',            'woocommerce_output_content_wrapper_end',   10 );
        remove_action( 'woocommerce_sidebar',                       'woocommerce_get_sidebar',                  10 );
        remove_action( 'woocommerce_after_single_product_summary',  'woocommerce_upsell_display',               15 );

        // Add Custom Hook Action
        add_action( 'woocommerce_before_main_content',              'action_courtyard_wc_before_main_content', 10, 2 );
        add_action( 'woocommerce_after_main_content',               'action_courtyard_wc_after_main_content',  10, 2 );
        add_action( 'woocommerce_after_single_product_summary',     'action_courtyard_wc_upsell_limit',        10, 2 );

        // WooCommerce Hook Filters
        add_filter( 'woocommerce_breadcrumb_defaults',              'filter_courtyard_wc_breadcrumb_defaults',       10, 1 );
        add_filter( 'woocommerce_output_related_products_args',     'filter_courtyard_wc_related_products_args',     10, 1 );
        add_filter( 'woocommerce_product_thumbnails_columns',       'filter_courtyard_wc_product_thumbnails_cols',   10, 1 );
        add_filter( 'loop_shop_per_page',                           'filter_courtyard_wc_shop_per_page',             10, 1 );
        add_filter( 'woocommerce_cross_sells_total',                'filter_courtyard_wc_cross_sells_total',         10, 1 );
        add_filter( 'woocommerce_add_to_cart_fragments',            'filter_courtyard_wc_add_to_cart_fragments',     10, 1 );
        add_filter( 'wp_nav_menu_items',                            'filter_courtyard_wc_menu_cart_icon',            10, 2 );

    }
}
add_action( 'wp','courtyard_woocommerce_actions' );

/*--------------------------------------------------------------
# Before Main Content
--------------------------------------------------------------*/
if ( !function_exists( 'action_courtyard_wc_before_main_content' ) ) {
    function action_courtyard_wc_before_main_content() {
        woocommerce_breadcrumb();
        ?>
        <div class="container">
        <div class="row">
        <div id="primary" class="pt-primary-wrap <?php echo esc_attr( courtyard_woocommerce_primary_sidebar_class() ); ?>">
        <div class="pt-content-wrap pt-content-wrap-border">
        <?php
    }
}

/*--------------------------------------------------------------
# After Main Content
--------------------------------------------------------------*/
if ( !function_exists( 'action_courtyard_wc_after_main_content' ) ) {
    function action_courtyard_wc_after_main_content() { ?>
        </div><!-- .pt-content-wrap -->
        </div><!-- #primary -->
        <?php
        courtyard_woocommerce_sidebar_select();
        ?>
        </div><!-- .row -->
        </div><!-- .container -->
        <?php
    }
}

/*--------------------------------------------------------------
# Upshell Products
--------------------------------------------------------------*/
if ( !function_exists( 'action_courtyard_wc_upsell_limit' ) ) {
    function action_courtyard_wc_upsell_limit() {
        woocommerce_upsell_display(
            esc_attr( get_theme_mod( 'courtyard_pro_woocommerce_upsell_product_number', 4 )),
            esc_attr( get_theme_mod( 'courtyard_pro_woocommerce_upsell_product_per_row', 4 ))
        );
    }
}
/*--------------------------------------------------------------
# Related Products Args
--------------------------------------------------------------*/
if ( !function_exists( 'filter_courtyard_wc_related_products_args' ) ) {
    function filter_courtyard_wc_related_products_args( $args ) {
        $related_product_number     = get_theme_mod( 'courtyard_pro_woocommerce_related_product_number', 4 );
        $related_product_per_row    = get_theme_mod( 'courtyard_pro_woocommerce_related_product_per_row', 4 );
        $args['posts_per_page']     = absint( $related_product_number );
        $args['columns']            = absint( $related_product_per_row );

        return $args;
    }
}

/*--------------------------------------------------------------
# Product gallery thumbnail columns
--------------------------------------------------------------*/
if ( !function_exists( 'filter_courtyard_wc_product_thumbnails_cols' ) ) {
    function filter_courtyard_wc_product_thumbnails_cols() {
        $columns = 4;
        return intval( $columns );
    }
}

/*--------------------------------------------------------------
# Products per page
--------------------------------------------------------------*/
if ( !function_exists( 'filter_courtyard_wc_shop_per_page' ) ) {
    function filter_courtyard_wc_shop_per_page() {
        // Default number of products if < WooCommerce 3.3.
        if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.3', '<' ) ) {
            $number = 12;
        }
        return absint( $number );
    }
}

if ( !function_exists( 'filter_courtyard_wc_menu_cart_icon' ) ) {
    function filter_courtyard_wc_menu_cart_icon( $items, $args ) {
        if ( $args->theme_location == 'primary' ) {
            if( class_exists( 'WooCommerce' ) ) :
                $items .= '<a class="pt-cart"></a>';
            endif;
        }
        return $items;
    }
}


/*--------------------------------------------------------------
# Ajax Cart Update
--------------------------------------------------------------*/
if ( !function_exists( 'filter_courtyard_wc_add_to_cart_fragments' ) ) {
    function filter_courtyard_wc_add_to_cart_fragments( $fragments ) {
        global $woocommerce;

        ob_start();
        ?>
        <a class="pt-cart" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><i class="fa fa-shopping-cart"></i><?php if( WC()->cart->get_cart_contents_count() >= 1 ) { ?><span class="pt-cart-value"><?php echo $woocommerce->cart->cart_contents_count; ?></span><?php } ?></a>
        <?php

        $fragments['a.pt-cart'] = ob_get_clean();

        return $fragments;
    }
}

/*--------------------------------------------------------------
# WooCommerce Breadcrumbs
--------------------------------------------------------------*/
if ( !function_exists( 'filter_courtyard_wc_breadcrumb_defaults' ) ) {
    function filter_courtyard_wc_breadcrumb_defaults() {
        $delimiter = get_theme_mod( 'courtyard_breadcrumbs_sep', '/' );
        if ( $delimiter == '' ) {
            $delimiter    = '/'; // delimiter between crumbs
        }
        $home_title       = esc_html__('Home', 'courtyard');
        return array(
            'delimiter'   => '<li class="pt-breadcrumbs-delimiter">'.$delimiter.'</li>',
            'wrap_before' => '<div class="container"><div class="row"><div class="col-md-12"><ul class="pt-breadcrumbs-items">',
            'wrap_after'  => '</ul></div></div></div>',
            'before'      => '<li>',
            'after'       => '</li>',
            'home'        => $home_title,
        );
    }
}

/**
 * Register widget area related to WooCommerce.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
if ( ! function_exists( 'courtyard_woocommerce_widgets_init' ) ) :
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
add_action( 'widgets_init', 'courtyard_woocommerce_widgets_init' );

/*---------------------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'courtyard_woocommerce_sidebar_layout_class' ) ) :
    /**
     * Generate layout class for sidebar based on customizer and post meta settings for woocommerce pages.
     */
    function courtyard_woocommerce_sidebar_layout_class() {
        global $post;

        $layout = get_theme_mod( 'courtyard_woocommerce_blog_sidebar', 'right_sidebar' );

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
                echo '<aside id="secondary" role="complementary">';
                dynamic_sidebar('pt_sidebar');
                echo '</aside><!-- #secondary -->';
                echo '</div>';
            }
        }
    }
endif;

