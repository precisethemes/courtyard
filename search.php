<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
					<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'courtyard' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header><!-- .page-header -->

				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'template-parts/content', 'search' );

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
