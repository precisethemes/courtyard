<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Courtyard
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'pt-post-wrap' ); ?>>

	<?php echo courtyard_page_thumbnail(); ?>

	<div class="pt-content-wrap<?php if( !has_post_thumbnail() ) { echo ' pt-content-wrap-border'; } ?>">
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title pt-single-post-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
            <?php
            the_content();
            wp_link_pages(
                array(
                    'before'      => '<div class="page-links">' . __( 'Pages:', 'courtyard' ),
                    'after'       => '</div>',
                    'link_before' => '<span class="page-number">',
                    'link_after'  => '</span>',
                )
            );
            ?>
		</div><!-- .entry-content -->

		<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'courtyard' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
	</div>
</article><!-- #post-## -->
