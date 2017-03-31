<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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
			if ( have_posts() ) :

				if ( is_home() && ! is_front_page() ) : ?>
					<header>
						<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
					</header>

				<?php
				endif;

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
					<?php
					the_posts_pagination( array(
						'mid_size' 				=> 4,
						'prev_text'          	=> __( '&laquo; Previous', 'courtyard' ),
		                'next_text'          	=> __( 'Next &raquo;', 'courtyard' ),
		                'before_page_number' 	=> '<span class="meta-nav screen-reader-text">' . __( 'Page', 'courtyard' ) . ' </span>',
					) );
					?>
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
