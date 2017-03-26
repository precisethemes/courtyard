<?php
/**
 * courtyard functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package courtyard
 */

if ( ! function_exists( 'courtyard_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function courtyard_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on courtyard, use a find and replace
	 * to change 'courtyard' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'courtyard', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Custom Image Crop
	 */
    add_image_size( 'courtyard-400x260', 400, 260, true );
	add_image_size( 'courtyard-400x300', 400, 300, true );
    add_image_size( 'courtyard-600x450', 600, 450, true );
    add_image_size( 'courtyard-800x500', 800, 500, true );
    add_image_size( 'courtyard-1920x1080', 1920, 1080, true );

    // Header Image Size
    define( 'HEADER_IMAGE_WIDTH', apply_filters( 'courtyard_header_image_width', 1920 ) );
    define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'courtyard_header_image_height', 300 ) );

    /*
	 * Enable support for custom logo.
	 *
	 */
	add_theme_support( 'custom-logo', array(
		'flex-height' => true,
		'flex-width' => true,
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'courtyard' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'courtyard_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	/**
	 * WooCommerce Support
	 */
	add_theme_support( 'woocommerce' );
}
endif;
add_action( 'after_setup_theme', 'courtyard_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function courtyard_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'courtyard_content_width', 640 );
}
add_action( 'after_setup_theme', 'courtyard_content_width', 0 );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/admin/customizer/customizer.php';

/**
 * Customizer Styles
 */
require get_template_directory() . '/inc/admin/customizer/customizer-styles.php';

/**
 * Metabox Custom function
 */
require get_template_directory() . '/inc/admin/meta-boxes/class-meta-box.php';

/**
 * Load theme custom widgets and register custom widget sidebar.
 */
require get_template_directory() . '/inc/admin/widgets/widgets.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load courtyard extra/custom functions file
 */
require get_template_directory() . '/inc/functions.php';

/**
 * Load woocommerce functions file
 */
require get_template_directory() . '/woocommerce/woocommerce.php';
