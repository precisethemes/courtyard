<?php
/**
 * @package Courtyard
 */

/**
 * Convert hexdec color string to rgb(a) string
 */
function courtyard_hex2rgba( $color, $opacity = false ) {

	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if( empty( $color ) )
		return $default;

	//Sanitize $color if "#" is provided
	if ( $color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	//Check if color has 6 or 3 characters and get values
	if ( strlen( $color ) == 6 ) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}

	//Convert hexadec to rgb
	$rgb =  array_map( 'hexdec', $hex );

	//Check if opacity is set(rgba or rgb)
	if( $opacity ){
		if( abs( $opacity ) > 1 )
			$opacity = 1.0;
		$output = 'rgba( '.implode( ",",$rgb ).','.$opacity.' )';
	} else {
		$output = 'rgb( '.implode( ",",$rgb ).' )';
	}

	//Return rgb(a) color string
	return $output;
}

/**
 * Generate darker color
 * Source: http://stackoverflow.com/questions/3512311/how-to-generate-lighter-darker-color-with-php
 */
function courtyard_darkcolor($hex, $steps) {
	// Steps should be between -255 and 255. Negative = darker, positive = lighter
	$steps = max(-255, min(255, $steps));

	// Normalize into a six character long hex string
	$hex = str_replace('#', '', $hex);
	if (strlen($hex) == 3) {
		$hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
	}

	// Split into three parts: R, G and B
	$color_parts = str_split($hex, 2);
	$return = '#';

	foreach ($color_parts as $color) {
		$color   = hexdec($color); // Convert to decimal
		$color   = max(0,min(255,$color + $steps)); // Adjust color
		$return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
	}

	return $return;
}

add_action( 'wp_head', 'courtyard_custom_style' );
/**
 * Hooks the Custom Internal CSS to head section
 */
function courtyard_custom_style() {

	$theme_color = get_theme_mod( 'courtyard_theme_color', '#9b59b6' );

    if ( $theme_color == 'watermelon' ) {
        $theme_primary_color = '#ef717a';
    } elseif ( $theme_color == 'red' ) {
        $theme_primary_color = '#e74c3c';
    } elseif ( $theme_color == 'orange' ) {
        $theme_primary_color = '#e67e22';
    } elseif ( $theme_color == 'yellow' ) {
        $theme_primary_color = '#ffcd02';
    } elseif ( $theme_color == 'lime' ) {
        $theme_primary_color = '#a5c63b';
    } elseif ( $theme_color == 'green' ) {
        $theme_primary_color = '#2ecc71';
    } elseif ( $theme_color == 'mint' ) {
        $theme_primary_color = '#1abc9c';
    } elseif ( $theme_color == 'teal' ) {
        $theme_primary_color = '#3a6f81';
    } elseif ( $theme_color == 'sky-blue' ) {
        $theme_primary_color = '#00bcd4';
    } elseif ( $theme_color == 'blue' ) {
        $theme_primary_color = '#5065a1';
    } elseif ( $theme_color == 'purple' ) {
        $theme_primary_color = '#673ab7';
    } elseif ( $theme_color == 'pink' ) {
        $theme_primary_color = '#f47cc3';
    } elseif ( $theme_color == 'magenta' ) {
        $theme_primary_color = '#9b59b6';
    } elseif ( $theme_color == 'plum' ) {
        $theme_primary_color = '#5e345e';
    } elseif ( $theme_color == 'brown' ) {
        $theme_primary_color = '#5e4534';
    } else {
        $theme_primary_color = '#79302a';
    }

    // Custom Primary Color
    $custom_primary_color = get_theme_mod( 'courtyard_custom_primary_color', '');
	if ( $custom_primary_color != '' ) {
        $theme_primary_color = $custom_primary_color;
    }

    $primary_opacity = courtyard_hex2rgba($theme_primary_color);
	$theme_secondary_color    = courtyard_darkcolor($theme_primary_color, -30);

	// Custom Secondary Color
    $custom_secondary_color = get_theme_mod( 'courtyard_custom_secondary_color', '');
	if ( $custom_secondary_color != '' ) {
        $theme_secondary_color = $custom_secondary_color;
    }

	$custom = '';
	if( $custom_primary_color != '#673ab7' ) {
		// Primary Color
		$custom .= "a, .pt-logo .site-title a, .pt-menu li:hover > a, .pt-menu li.current-menu-item a, .pt-home-navbar li.current-menu-item a, .pt-home-navbar .pt-menu li li:hover > a, .pt-service-col .fa, .pt-service-col h3:hover a, .pt-room-cont h3:hover a, .pt-recent-posts-col:hover h3 a, pt-services-more a:hover, .pt-rooms-more a:hover, .pt-recent-posts-read-more a:hover, .pt-services-more .pt-arrow-left:hover, .pt-services-more .pt-arrow-right:hover, .pt-rooms-more .pt-arrow-left:hover, .pt-rooms-more .pt-arrow-right:hover, .pt-room-cont:hover h3 a, .pt-rooms-more a:hover, pt-recent-posts-col:hover h3 a, .pt-recent-posts-read-more a:hover, .entry-meta .posted-on a, .entry-meta .byline a, .entry-footer .edit-link a, .comments-area .comment-list a, .comment-respond .logged-in-as a, .pt-breadcrumbs .trail-items .trail-item a, .pt-footer-wrapper li a:hover, footer.site-footer a:hover, .pt-content-wrap .entry-title a:hover, .pt-content-wrap span.posted-on a:hover, .pt-content-wrap span.byline a:hover, .pt-content-wrap span.cat-links a:hover, .pt-content-wrap span.tags-links a:hover, .post-navigation .nav-links a:hover, .pt-breadcrumbs-items li a:hover, #secondary li a:hover { color: " . esc_attr( $theme_primary_color ) . "}"."\n";

		//Secondary Color
		$custom .= "a:hover, a:focus, a:active, .pt-logo .site-title:hover a, .pt-service-col .fa:hover { color: " . esc_attr( $theme_secondary_color ) . "}"."\n";

		// Background Color
		$custom .= ".pt-hero-image-cont article a:hover, .pt-hero-slider-nav .pt-arrow-left:hover, .pt-hero-slider-nav .pt-arrow-right:hover, .pt-hero-image-slider .pt-arrow-down:hover, .pt-room-col:hover p:before, .pt-recent-posts-read-more a:before, .pt-recent-posts-read-more:hover a:before, #back-to-top, #back-to-top a, .pt-room-col:hover p:before, .pt-room-cont .pt-arrow-right, .pt-holiday-package-read-more:hover, .pt-recent-posts-col .pt-blog-post-more-icon, button:hover, input[type='button']:hover, input[type='reset']:hover, input[type='submit']:hover, .pt-content-wrap .read-more a:hover, .pt-pagination-nav a:hover, .pt-pagination-nav .current:hover, .pt-pagination-nav .current, .tagcloud a:hover { background-color: " . esc_attr($theme_primary_color) . "}"."\n";

		// Background Secondary Color
		$custom .= "button:focus, input[type='button']:focus, input[type='reset']:focus, input[type='submit']:focus, button:active, input[type='button']:active, input[type='reset']:active, input[type='submit']:active { background-color: " . esc_attr($theme_secondary_color) . "}"."\n";

		// Border Color
		$custom .= "input[type='text']:focus, input[type='email']:focus, input[type='url']:focus, input[type='password']:focus, input[type='search']:focus, input[type='number']:focus, input[type='tel']:focus, input[type='range']:focus, input[type='date']:focus, input[type='month']:focus, input[type='week']:focus, input[type='time']:focus, input[type='datetime']:focus, input[type='datetime-local']:focus, input[type='color']:focus, textarea:focus { border-color: " . esc_attr($theme_primary_color) . "}"."\n";
	}

	if( !empty( $custom ) ) {
		echo '<!-- '.get_bloginfo('name').' Internal Styles -->';
	?>
		<style type="text/css"><?php echo $custom; ?></style>
	<?php
	}
}
