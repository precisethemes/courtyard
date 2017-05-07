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
			$post_name = $post->post_name;
			$widget_id = sprintf("pt_widget_area_%s", esc_html( $post_name ));
			if ( is_active_sidebar( $widget_id ) ) :
		 		dynamic_sidebar( $widget_id );
			endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();
