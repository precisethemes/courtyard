<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Courtyard
 */

get_header(); ?>

<div class="container">
	<div class="row">
		<div id="primary" class="pt-primary-wrap <?php echo esc_attr( courtyard_primary_sidebar() ); ?>">

			<?php
			if ( have_posts() ) : ?>

				<header class="page-header">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="archive-description">', '</div>' );
					?>
				</header><!-- .page-header -->

				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_format() );

				endwhile;

				?>

				<div class="pt-pagination-nav">
					<?php echo paginate_links(); ?>
				</div><!-- .pt-pagination-nav -->

				<?php

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif; ?>

		</div><!-- #primary -->

	<?php courtyard_sidebar_select(); ?>
	
	</div><!-- .row -->
</div><!-- .container -->

<?php get_footer();
