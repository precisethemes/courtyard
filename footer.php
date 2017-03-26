<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Courtyard
 */

?>

	<div class="pt-footer-wrapper">
		<?php if ( is_active_sidebar( 'courtyard_footer_sidebar_1' ) || is_active_sidebar( 'courtyard_footer_sidebar_2' ) || is_active_sidebar( 'courtyard_footer_sidebar_3' ) || is_active_sidebar( 'courtyard_footer_sidebar_4' ) ) : ?>
			<?php get_sidebar('footer'); ?>
		<?php endif; ?>

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="container">
				<div class="row">
					<div class="site-info">
						<?php do_action( 'courtyard_footer' ); ?>
					</div><!-- .site-info -->
				</div><!-- .container -->
			</div><!-- .row -->

		</footer><!-- #colophon -->
	</div>

<?php wp_footer(); ?>

<?php if ( get_theme_mod( 'courtyard_footer_go_to_top', '1') == 1 ) : ?>
	<span id="back-to-top" class="transition5">
		<span class="back-to-top-text transition5">
			<?php esc_html_e( 'Back to Top', 'courtyard' ); ?>
		</span>
		<a class="transition35"><i class="fa fa-angle-up"></i></a>
	</span><!-- #back-to-top -->
<?php endif; ?>

</body>
</html>
