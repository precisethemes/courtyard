<?php

/**
 * Social Profiles Widget section.
 */
class Courtyard_Social_Icons_Widget extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'pt-social-icons-section', 'description' => esc_html__('Social Icons.', 'courtyard'));
        $control_ops = array('width' => 200, 'height' => 250);
        parent::__construct(false, $name = esc_html__('PT: Social Icons', 'courtyard'), $widget_ops, $control_ops);
    }

    function form($instance) {
        $instance = wp_parse_args(
            (array)$instance, array(
                'title' => '',
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

        </div><!-- .pt-social-icons -->
    <?php }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = sanitize_text_field($new_instance['title']);

        return $instance;
    }

    function widget($args, $instance) {
        ob_start();
        extract($args);
        
        $title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');

        $pt_social_icons = json_decode( get_theme_mod('courtyard_repeatable_social_icons',''), true);

        echo $args['before_widget'] = str_replace('<section', '<section', $args['before_widget']); ?>

        <div class="pt-social-icons-sec">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <header>
                            <?php if (!empty($title)) : ?>
                                <h2 class="widget-title"><?php echo esc_html($title); ?></h2>
                            <?php endif; ?>

                        </header>
                    </div><!-- .col-md-12 -->
                    <?php if ( '' != $pt_social_icons ) : ?>
                        <div class="col-md-12">
                            <div class="pt-social-icons clearfix">
                                <ul>
                                    <?php foreach ($pt_social_icons as $key => $value) {
                                        if( '' != $pt_social_icons[$key]['pt_social_url'] ) { ?>
                                            <li><a href="<?php echo esc_url( $pt_social_icons[$key]['pt_social_url'] );?>"><i class="fa <?php echo esc_attr( $pt_social_icons[$key]['pt_social_icon'] );?>"></i></a></li>
                                    <?php } } ?>
                                </ul>
                            </div><!-- .pt-social-icons -->
                        </div><!-- .col-md-12 -->
                    <?php endif; ?>
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .pt-social-icons-sec -->

        <?php echo $args['after_widget'];
        ob_end_flush();
    }
}