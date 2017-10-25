/**
 * File customize-preview.js.
 *
 * Instantly live-update customizer settings in the preview for improved user experience.
 */

( function( $ ) {

	//Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	/* Shows a live preview of changing the breadcrumbs delimeter. */
	wp.customize( 'courtyard_breadcrumbs_sep', function( value ) {
		value.bind( function( to ) {
			$( '.pt-breadcrumbs .pt-breadcrumbs-items .pt-breadcrumbs-delimiter' ).text( to ) ;
		});
	});

	/* Shows a live preview of changing the readmore text. */
	wp.customize( 'courtyard_blog_read_more_text', function( value ) {
		value.bind( function( to ) {
			$( '.pt-content-wrap .pt-read-more a' ).text( to ) ;
		});
	});

} )( jQuery );
