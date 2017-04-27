<?php
/**
 * The sidebar containing the main footer widgets area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Courtyard
 */
?>

<?php
//Set widget areas classes based on user choice
$widget_areas = get_theme_mod('courtyard_footer_widget_area_layout', '1by4_1by4_1by4_1by4');
if ($widget_areas == '1by4_1by4_1by4_1by4') {
    $cols = 'col-md-3 col-sm-6 col-sx-12';
} elseif ($widget_areas == '1by3_1by3_1by3') {
    $cols = 'col-md-4 col-sm-6 col-sx-12';
} elseif ($widget_areas == '1by2_1by2') {
    $cols = 'col-md-6 col-sm-6 col-sx-12';
} else {
    $cols = 'col-md-12';
}
?>

<div id="footer-widgets" class="footer-widgets" role="complementary">
    <div class="container">
        <div class="row">
            <?php do_action('courtyard_before_footer_sidebar'); ?>
            <?php if (is_active_sidebar('courtyard_footer_sidebar_1')) : ?>
                <div class="sidebar-column <?php echo esc_attr($cols); ?>">
                    <?php dynamic_sidebar('courtyard_footer_sidebar_1'); ?>
                </div>
            <?php endif; ?>
            <?php if (is_active_sidebar('courtyard_footer_sidebar_2')) : ?>
                <div class="sidebar-column <?php echo esc_attr($cols); ?>">
                    <?php dynamic_sidebar('courtyard_footer_sidebar_2'); ?>
                </div>
            <?php endif; ?>
            <?php if (is_active_sidebar('courtyard_footer_sidebar_3')) : ?>
                <div class="sidebar-column <?php echo esc_attr($cols); ?>">
                    <?php dynamic_sidebar('courtyard_footer_sidebar_3'); ?>
                </div>
            <?php endif; ?>
            <?php if (is_active_sidebar('courtyard_footer_sidebar_4')) : ?>
                <div class="sidebar-column <?php echo esc_attr($cols); ?>">
                    <?php dynamic_sidebar('courtyard_footer_sidebar_4'); ?>
                </div>
            <?php endif; ?>
            <?php do_action('courtyard_after_footer_sidebar'); ?>
        </div><!-- .container -->
    </div><!-- .row -->
</div><!-- #secondary -->
