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
	<?php
	$image_id               = get_post_thumbnail_id();
	$image_path             = wp_get_attachment_image_src( $image_id, 'courtyard-800x500', true );
	$image_alt              = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
	$alt 					= !empty( $image_alt ) ? $image_alt : the_title_attribute( 'echo=0' ) ;
	?>

	<?php if( has_post_thumbnail() ) : ?>
		<figure>
			<img src="<?php echo esc_url( $image_path[0] ); ?>" alt="<?php echo esc_attr( $alt ); ?>" title="<?php the_title_attribute(); ?>" />
		</figure>
	<?php endif; ?>

	<div class="pt-content-wrap<?php if( !has_post_thumbnail() ) { echo ' pt-content-wrap-border'; } ?>">
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title pt-single-post-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
				the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'courtyard' ),
					'after'  => '</div>',
				) );
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
