<?php
/**
 * Template Name: Front Page
 *
 * @package Courtyard
 */

get_header(); ?>

	<div id="primary" class="content-area pt-front-page">
		<main id="main" class="site-main" role="main">
			
			<?php 
			global $post;
			$post_id = $post->ID;
			$widget_id = sprintf("courtyard_widget_area_%s", absint( $post_id ));
			if ( is_active_sidebar( $widget_id ) ) :
		 		dynamic_sidebar( $widget_id );
			endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();
