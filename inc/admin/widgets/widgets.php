<?php
/**
 * Courtyard Theme Widgets.
 *
 * @package Courtyard
 */

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function courtyard_widgets_init() {

    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'courtyard' ),
        'id'            => 'pt_sidebar',
        'description'   => esc_html__( 'Add widgets in your sidebar of theme.', 'courtyard' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>'
    ) );

    //Register widget areas for the Courtyard Front Page template
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-templates/template-front-page.php',
    ));
    foreach($pages as $page){
        register_sidebar( array(
            'name'          => sprintf( esc_html__( /* Translators: %s: Page Name */ 'Front Page - %s', 'courtyard' ), esc_html( $page->post_title ) ),
            'id'            => 'pt_widget_area_' . esc_html( $page->post_name ),
            'description'   => sprintf(  /* Translators: %s: Page Name */ esc_html__( 'Drag and drop our all custom widgets to build content awesome for the page: %s', 'courtyard' ), esc_html( $page->post_title ) ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>'
        ) );
    }

    //Footer widget areas
    $widget_areas = get_theme_mod('courtyard_footer_widget_area_layout', '1by4_1by4_1by4_1by4');
    if ($widget_areas == '1by4_1by4_1by4_1by4') {
        $cols_divider = '4';
    } elseif ($widget_areas == '1by3_1by3_1by3') {
        $cols_divider = '3';
    } elseif ($widget_areas == '1by2_1by2') {
        $cols_divider = '2';
    } else {
        $cols_divider = '1';
    }
    for ($i=1; $i<=$cols_divider; $i++) {
        register_sidebar( array(
            'name'          => sprintf( /* Translators: %d: widget number */ esc_html__( 'Footer %d', 'courtyard' ), $i ) ,
            'id'            => 'courtyard_footer_sidebar_' . $i,
            'description'   => sprintf( /* Translators: %d: widget number */ esc_html__( 'Add widgets in your footer widget area %d.', 'courtyard' ), $i ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
    }

    register_widget( "courtyard_service_widget" );
    register_widget( "courtyard_recent_posts_widget" );
    register_widget( "courtyard_image_slider_widget" );
    register_widget( "courtyard_packages_widget" );
    register_widget( "courtyard_rooms_widget" );
    register_widget( "courtyard_video_widget" );
    register_widget( "Courtyard_About_Widget" );
    register_widget( "Courtyard_Social_Icons_Widget" );
    register_widget( "Courtyard_Logo_Widget" );
    register_widget( "Courtyard_Testimonials_Widget" );

}
add_action( 'widgets_init', 'courtyard_widgets_init' );

/**************************************************************************************/

require get_template_directory() . '/inc/admin/widgets/services-widget.php';
require get_template_directory() . '/inc/admin/widgets/recent-posts-widget.php';
require get_template_directory() . '/inc/admin/widgets/image-slider-widget.php';
require get_template_directory() . '/inc/admin/widgets/packages-widget.php';
require get_template_directory() . '/inc/admin/widgets/rooms-widget.php';
require get_template_directory() . '/inc/admin/widgets/video-widget.php';
require get_template_directory() . '/inc/admin/widgets/about-widget.php';
require get_template_directory() . '/inc/admin/widgets/social-icon-widget.php';
require get_template_directory() . '/inc/admin/widgets/logo-widget.php';
require get_template_directory() . '/inc/admin/widgets/testimonial-widget.php';
