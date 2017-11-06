<?php

/**
 * Social Profiles Widget section.
 */
class Courtyard_Social_Icons_Widget extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'pt-social-icons-section', 'description' => esc_html__('Social Icons.', 'courtyard'), 'customize_selective_refresh' => true, );
        $control_ops = array('width' => 200, 'height' => 250);
        parent::__construct(false, $name = esc_html__('PT: Social Icons', 'courtyard'), $widget_ops, $control_ops);
    }

    function form($instance) {
        $instance = wp_parse_args(
            (array)$instance, array(
                'title' => '',
                'background_color'  => '',
            )
        );
        ?>

        <div class="pt-social-icons">
            <div class="pt-admin-input-wrap">
                <p>
                    <em><?php esc_html_e('Tip: This widget is used to display social icons for that you have to set social profile links through Appearance-> Customize-> Social-> Social Profiles.', 'courtyard'); ?></em>
                </p>
            </div><!-- .pt-admin-input-wrap -->

            <div class="pt-admin-input-wrap">
                <div class="pt-admin-input-label">
                    <label
                    for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title', 'courtyard'); ?></label>
                </div><!-- .pt-admin-input-label -->

                <div class="pt-admin-input-holder">
                    <input type="text" id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>"
                       value="<?php echo esc_attr($instance['title']); ?>"
                       placeholder="<?php esc_attr_e('Title', 'courtyard'); ?>">
                </div><!-- .pt-admin-input-holder -->

                <div class="clear"></div>
            </div><!-- .pt-admin-input-wrap -->

            <div class="pt-admin-input-wrap">

                <div class="pt-admin-input-label">
                    <label
                    for="<?php echo $this->get_field_id('background_color'); ?>"><?php esc_html_e('Color', 'courtyard'); ?></label>
                </div><!-- .pt-admin-input-label -->

                <div class="pt-admin-input-holder">
                    <input type="text" id="<?php echo $this->get_field_id('background_color'); ?>"
                        class="pt-color-picker"
                        name="<?php echo $this->get_field_name('background_color'); ?>"
                        value="<?php echo esc_attr($instance['background_color']); ?>">
                    <p><em><?php esc_html_e('Choose the background color for the widget section.', 'courtyard'); ?></em></p>
                </div><!-- .pt-admin-input-holder -->

                <div class="clear"></div>
 
            </div><!-- .pt-admin-input-wrap -->

        </div><!-- .pt-social-icons -->
    <?php }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['background_color'] = sanitize_text_field($new_instance['background_color']);

        return $instance;
    }

    function widget($args, $instance) {
        ob_start();
        extract($args);
        
        $title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
        $background_color = isset($instance['background_color']) ? $instance['background_color'] : null;
        $pt_social_icons = json_decode( get_theme_mod('courtyard_repeatable_social_icons',''), true);

        $inline_style = '';

        if ($background_color != '') {
            $inline_style = ' style="background-color:' . esc_attr($background_color) . '"';
        }

        echo $args['before_widget']; ?>

        <div class="pt-widget-section" <?php echo $inline_style; ?>>

            <div class="pt-social-icons-sec">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <?php if (!empty($title)) : ?>
                                <header>
                                    <h2 class="widget-title"><?php echo esc_html($title); ?></h2>
                                </header>
                            <?php endif; ?>

                            <?php if ( '' != $pt_social_icons ) : ?>

                                <div class="pt-social-icons">
                                    <ul>
                                        <?php foreach ($pt_social_icons as $key => $value) {
                                            if( '' != $pt_social_icons[$key]['pt_social_url'] ) { ?>
                                                <li class="transition5"><a href="<?php echo esc_url( $pt_social_icons[$key]['pt_social_url'] );?>" target="_blank"><i class="fa <?php echo esc_attr( $pt_social_icons[$key]['pt_social_icon'] );?>"></i></a></li>
                                        <?php } } ?>
                                    </ul>
                                </div><!-- .pt-social-icons -->

                            <?php endif; ?>

                        </div><!-- .col-md-12 -->
                    </div><!-- .row -->
                </div><!-- .container -->
            </div><!-- .pt-social-icons-sec -->

        </div><!-- .pt-widget-section -->

        <?php echo $args['after_widget'];
        ob_end_flush();
    }
}