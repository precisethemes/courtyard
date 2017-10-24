<?php
/**
 * Functions to provide support for the One Click Demo Import plugin (wordpress.org/plugins/one-click-demo-import)
 *
 * @package Courtyard Pro
 */

/*Import content data*/
if ( ! function_exists( 'courtyard_import_files' ) ) :
    function courtyard_import_files() {
        return array(

            array(
                'import_file_name'             => 'Courtyard',
                'local_import_file'            => get_template_directory() . '/inc/demo-importer/demos/default/dummy-data/dummy-data.xml',
                'local_import_widget_file'     => get_template_directory() . '/inc/demo-importer/demos/default/dummy-data/dummy-widgets.wie',
                'local_import_customizer_file' => get_template_directory() . '/inc/demo-importer/demos/default/dummy-data/dummy-customizer.dat',
                'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately.', 'courtyard' ),
                'preview_url'                  => 'http://demo.precisethemes.com/courtyard/',
            ),

        );
    }
    add_filter( 'pt-ocdi/import_files', 'courtyard_import_files' );
endif;

/**
 * Create the homepage to hold the widgets, before the import
 */

if ( ! function_exists( 'courtyard_set_after_import_mods' ) ) :
    function courtyard_before_content_import( $selected_import ) {

        if ( 'Courtyard' === $selected_import['import_file_name'] ) {
            $homepage = array(
                'post_title'    => 'Home',
                'post_name'     => 'home',
                'post_type'     => 'page',
                'post_content'  => '',
                'post_status'   => 'publish',
            );

            wp_insert_post( $homepage );
            $front_page = get_page_by_title( 'Home' );
            update_post_meta( $front_page -> ID, '_wp_page_template', 'page-templates/template-front-page.php' );
        }
    }
    add_action( 'pt-ocdi/before_content_import', 'courtyard_before_content_import' );
endif;

/**
 * Define actions that happen after import
 */

if ( ! function_exists( 'courtyard_set_after_import_mods' ) ) :
    function courtyard_set_after_import_mods( $selected_import ) {

        if ( 'Courtyard' === $selected_import['import_file_name'] ) {

            //Assign the menu
            $primary_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
            set_theme_mod( 'nav_menu_locations' , array(
                    'primary' => $primary_menu->term_id,
                )
            );

            //Asign the static front page and the blog page
            $front_page = get_page_by_title( 'Home' );
            $blog_page  = get_page_by_title( 'Blog' );

            update_option( 'show_on_front', 'page' );
            update_option( 'page_on_front', $front_page -> ID );
            update_option( 'page_for_posts', $blog_page -> ID );
        }
    }
    add_action( 'pt-ocdi/after_import', 'courtyard_set_after_import_mods' );
endif;
