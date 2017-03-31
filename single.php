<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Courtyard
 */

get_header(); 

?>

<div class="container">
	<div class="row">
		<div id="primary" class="pt-primary-wrap <?php echo esc_attr( courtyard_primary_sidebar() ); ?>">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', get_post_format() );

				// Previous/next post navigation.
				if ( get_theme_mod( 'courtyard_post_nex_prev_article', '1' ) == 1) :
					the_post_navigation( array(
						'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next Post &rarr;', 'courtyard' ) . '</span> ' .
							'<span class="screen-reader-text">' . __( 'Next post:', 'courtyard' ) . '</span> ',
						'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( '&larr; Previous Post', 'courtyard' ) . '</span> ' .
							'<span class="screen-reader-text">' . __( 'Previous post:', 'courtyard' ) . '</span> ',
					) );
				endif;

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</div><!-- #primary -->

	<?php courtyard_sidebar_select(); ?>
	</div><!-- .row -->
</div><!-- .container -->

<?php get_footer();
