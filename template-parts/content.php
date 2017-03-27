<?php
/**
 * Template part for displaying posts.
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
		<?php if ( is_singular() ) : ?>
			<figure>
				<img src="<?php echo esc_url( $image_path[0] ); ?>" alt="<?php echo esc_attr( $alt ); ?>" title="<?php the_title_attribute(); ?>" />
			</figure>
		<?php else : ?>
			<figure>
				<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">
					<img src="<?php echo esc_url( $image_path[0] ); ?>" alt="<?php echo esc_attr( $alt ); ?>" title="<?php the_title_attribute(); ?>" />
				</a>
			</figure>
	<?php
		endif;
	endif;
	?>

	<div class="pt-content-wrap<?php if( !has_post_thumbnail() ) { echo ' pt-content-wrap-border'; } ?>">
		<header class="entry-header">
			<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title pt-single-post-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) :

				if ( is_single() ) :
				?>
				<div class="entry-meta pt-single-entry-meta">
					<?php courtyard_posted_one(); ?>
				</div><!-- .entry-meta -->

				<?php else : ?>
					<div class="entry-meta">
						<?php courtyard_posted_one(); ?>
					</div><!-- .entry-meta -->
				<?php
				endif;
			endif;
			?>
		</header><!-- .entry-header -->

		<?php if ( is_singular() ) : ?>

			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->

		<?php else: ?>

			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->

			<?php if ( get_theme_mod( 'courtyard_blog_show_read_more', '1' ) == 1 ) : ?>
				<div class="read-more clearfix">
					<a class="button post-button transition5" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php esc_html_e( get_theme_mod( 'courtyard_blog_read_more_text','Read More' ) ); ?></a>
				</div>
			<?php endif; ?>

		<?php endif; ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'courtyard' ),
				'after'  => '</div>',
			) );
		?>

		<?php if ( is_singular() ) : ?>
		<footer class="entry-footer">
			<?php courtyard_entry_footer(); ?>
		</footer><!-- .entry-footer -->
		<?php endif; ?>
	</div>
</article><!-- #post-## -->
