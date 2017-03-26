<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package courtyard
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses courtyard_header_style()
 */
function courtyard_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'courtyard_custom_header_args', array(
		'width'                => 2000,
		'height'               => 500,
		'flex-height'          => true,
		'header-text'          => true,
		'video'                => true,
		'header-text'          => false,
	) ) );
}
add_action( 'after_setup_theme', 'courtyard_custom_header_setup' );

/*--------------------------------------------------------------------------------------------------*/

/**
 * Filter the get_header_image_tag() for option of adding the link back to home page option
 */
function courtyard_header_image_markup( $html, $header, $attr ) {
	$output = '';
	$header_image = get_header_image();

	if( ! empty( $header_image ) ) {

		if ( get_theme_mod( 'courtyard_header_image_link_activate', 0 ) == 1 ) {
			$output .= '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">';
		}

		$output .= '<div class="header-image-wrap"><img src="' . esc_url( $header_image ) . '" class="header-image" width="' . get_custom_header()->width . '" height="' .  get_custom_header()->height . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"></div>';

		if ( get_theme_mod( 'courtyard_header_image_link_activate', 0 ) == 1 ) {
			$output .= '</a>';
		}
	}

	return $output;
}

function courtyard_header_image_markup_filter() {
	add_filter( 'get_header_image_tag', 'courtyard_header_image_markup', 10, 3 );
}
add_action( 'courtyard_header_image_markup_render','courtyard_header_image_markup_filter' );

/*--------------------------------------------------------------------------------------------------*/

// Video Header introduced in WordPress 4.7
if ( ! function_exists( 'courtyard_the_custom_header_markup' ) ) {
	/**
	* Displays the optional custom media headers.
	*/
	function courtyard_the_custom_header_markup() {
		if ( function_exists('the_custom_header_markup') ) {
			do_action( 'courtyard_header_image_markup_render' );
			the_custom_header_markup();
		} else {
			$header_image = get_header_image();
			if( ! empty( $header_image ) ) {
				if ( get_theme_mod( 'courtyard_header_image_link_activate', 0 ) == 1 ) { ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<?php } ?>
				<div class="header-image-wrap"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></div>
				<?php if ( get_theme_mod( 'courtyard_header_image_link_activate', 0 ) == 1 ) { ?>
					</a>
				<?php
				}
			}
		}
	}
}