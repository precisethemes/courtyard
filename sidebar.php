<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Courtyard
 */
if ( ! is_active_sidebar( 'pt_sidebar' ) ) {
   return;
}
?>

<aside id="secondary" role="complementary">
	<?php echo courtyard_related_pages_listing(); ?>
   	<?php dynamic_sidebar( 'pt_sidebar' ); ?>
</aside><!-- #secondary -->
