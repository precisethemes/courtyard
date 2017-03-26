<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Courtyard
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/html">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="site">
	
	<header class="pt-header">
		<div class="pt-navbar transition5<?php if( is_front_page() ) { echo ' pt-home-navbar'; } ?>">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-sm-8 col-xs-9">
						<div class="pt-logo<?php if( is_home() || is_front_page() ) { echo ' pt-front-page-logo'; } ?> transition5">
							<h1>
								<i class="pt-primary-logo">
									<?php courtyard_the_custom_logo(); ?>
								</i>

								<?php if ( is_front_page() && get_theme_mod( 'courtyard_secondary_logo', 0 ) != '' ) : ?>

								<a class="pt-secondary-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
									<img src="<?php echo esc_url( get_theme_mod( 'courtyard_secondary_logo' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
								</a>

								<?php endif; ?>

								<?php $screen_reader = 'screen-reader-text';
								if ( get_theme_mod( 'courtyard_site_title_activate', '1' ) == 1 ) {
									$screen_reader = '';
								}
								?>
								<span class="site-title <?php echo esc_attr( $screen_reader ); ?>">
									<a class="transition35" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
										<?php bloginfo( 'name' ); ?>
									</a>
								</span>
							</h1>

							<?php if ( get_theme_mod( 'courtyard_site_tagline_activate', '1' ) == 1 ) :
								$description = get_bloginfo( 'description', 'display' );
								if ( $description || is_customize_preview() ) : ?>
									<p class="site-description"><?php echo esc_html( $description ); /* WPCS: xss ok. */ ?></p>
								<?php
								endif;
							endif; ?>

						</div><!-- .pt-logo -->
					</div><!-- .col-md-4 -->

					<div class="col-md-8 col-sm-4 col-xs-3">
						<nav class="pt-menu-wrap transition5">
							<div class="pt-menu-sm transition35">
								<i class="fa fa-bars"></i>

								<nav class="pt-menu-sm-wrap transition5">
									<i class="fa fa-close"></i>

									<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
									</nav>
								</div>

								<div class="pt-menu">
									<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
							</div>
						</nav><!-- .pt-menu -->
					</div><!-- .col-md-8 -->
				</div><!-- .row -->
			</div><!-- .container -->
		</div>

		<div class="pt-header-sep<?php if( is_front_page() ) { echo ' pt-header-sep-hide'; } ?> transition5"></div>

		<?php //endif; ?>

		<?php courtyard_the_custom_header_markup(); ?>

		<?php if( ! is_front_page() && ! is_home() ) :

			courtyard_display_breadcrumbs();
			
		endif; ?>

	</header>
