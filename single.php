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

				courtyard_navigation();

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
