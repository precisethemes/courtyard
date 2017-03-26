<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Courtyard
 */
if ( ! is_active_sidebar( 'courtyard_sidebar' ) ) {
   return;
}
?>

<aside id="secondary" class="<?php echo esc_attr( courtyard_secondary_sidebar() ); ?>" role="complementary">
	<?php 
	if ( is_page_template( 'page-templates/template-rooms.php' ) ) {
		echo courtyard_related_rooms_lists(); 
	} ?>
   	<?php dynamic_sidebar( 'courtyard_sidebar' ); ?>
</aside><!-- #secondary -->
