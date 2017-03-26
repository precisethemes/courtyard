<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Courtyard
 */

get_header(); ?>

<div class="container">
	<div class="row">
		<div id="primary" class="pt-primary-wrap <?php echo esc_attr( courtyard_primary_sidebar() ); ?>">
			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'courtyard' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'courtyard' ); ?></p>

					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</div><!-- #primary -->

		<?php courtyard_sidebar_select(); ?>

	</div><!-- .row -->
</div><!-- .container -->

<?php get_footer();
