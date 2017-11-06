<?php

/**
 * Video Widget section.
 */
class courtyard_video_widget extends WP_Widget
{
    function __construct()
    {
        $widget_ops = array('classname' => 'pt-video-section', 'description' => esc_html__('Display video from Youtube,Vimeo etc.', 'courtyard'), 'customize_selective_refresh' => true, );
        $control_ops = array('width' => 200, 'height' => 250);
        parent::__construct(false, $name = esc_html__('PT: Video', 'courtyard'), $widget_ops, $control_ops);
    }

    function form($instance)
    {
        $instance = wp_parse_args(
            (array)$instance, array(
                'title' => '',
                'sub_title' => '',
                'background_color' => '',
                'video_url' => '',
            )
        );
        ?>
        <div class="pt-video">
            <div class="pt-admin-input-wrap">
                <p>
                    <em><?php esc_html_e('This widget displays videos related to Youtube, Video etc.', 'courtyard'); ?></em>
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
                    for="<?php echo $this->get_field_id('sub_title'); ?>"><?php esc_html_e('Sub Title', 'courtyard'); ?></label>
                </div><!-- .pt-admin-input-label -->

                <div class="pt-admin-input-holder">
                    <textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('sub_title'); ?>"
                    name="<?php echo $this->get_field_name('sub_title'); ?>"
                    placeholder="<?php esc_attr_e('Short description', 'courtyard'); ?>"><?php echo esc_textarea($instance['sub_title']); ?></textarea>
                </div><!-- .pt-admin-input-holder -->

                <div class="clear"></div>

            </div><!-- .pt-admin-input-wrap -->

            <div class="pt-admin-input-wrap">

                <div class="pt-admin-input-label">
                    <label
                    for="<?php echo $this->get_field_id('video_url'); ?>"><?php esc_html_e('Video', 'courtyard'); ?></label>
                </div><!-- .pt-admin-input-label -->

                <div class="pt-admin-input-holder">
                    <input type="text" id="<?php echo $this->get_field_id('video_url'); ?>"
                       name="<?php echo $this->get_field_name('video_url'); ?>"
                       value="<?php echo esc_attr($instance['video_url']); ?>">
                    <p><em><?php esc_html_e('Enter the complete video URL.', 'courtyard'); ?></em></p>
                </div><!-- .pt-admin-input-holder -->

                <div class="clear"></div>

            </div><!-- .pt-admin-input-wrap -->

            <div class="pt-admin-input-wrap">

                <div class="pt-admin-input-label">
                    <label
                    for="<?php echo $this->get_field_id('background_color'); ?>"><?php esc_html_e('Color', 'courtyard'); ?></label>
                </div><!-- .pt-admin-input-label -->

                <div class="pt-admin-input-holder">
                    <input type="text" id="<?php echo $this->get_field_id('background_color'); ?>" class="pt-color-picker"
                       name="<?php echo $this->get_field_name('background_color'); ?>"
                       value="<?php echo esc_attr($instance['background_color']); ?>">
                       <p><em><?php esc_html_e('Choose the background color for the widget section.', 'courtyard'); ?></em></p>
                </div><!-- .pt-admin-input-holder -->

                <div class="clear"></div>

            </div><!-- .pt-admin-input-wrap -->

        </div><!-- .pt-video -->
    <?php }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['background_color'] = sanitize_text_field($new_instance['background_color']);
        $instance['video_url'] = esc_url_raw($new_instance['video_url']);

        if ( current_user_can( 'unfiltered_html' ) )
            $instance['sub_title'] = $new_instance['sub_title'];
        else
            $instance['sub_title'] = wp_kses( trim( wp_unslash( $new_instance['sub_title'] ) ), wp_kses_allowed_html( 'post' ) );
        
        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['pt-video-section']))
            delete_option('pt-video-section');
        return $instance;
    }

    function widget($args, $instance)
    {
        ob_start();
        extract($args);

        $title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
        $background_color = isset($instance['background_color']) ? $instance['background_color'] : null;
        $sub_title = isset($instance['sub_title']) ? $instance['sub_title'] : '';
        $video_url = isset($instance['video_url']) ? $instance['video_url'] : '';

        $inline_style = '';
        
        if ( $background_color != '') {
            $inline_style = ' style="background-color:' . esc_attr($background_color) . '"';
        }

        echo $args['before_widget']; ?>

        <div class="pt-widget-section" <?php echo $inline_style; ?>>

            <div class="pt-video-sec">
                <div class="container">
                    <div class="row">
                        <?php if ( !empty( $title ) || !empty( $sub_title ) ) : ?>
                            <div class="col-md-12">
                                <header>
                                    <?php if (!empty($title)) : ?>
                                        <h2 class="widget-title"><?php echo esc_html($title); ?></h2>
                                    <?php endif; ?>

                                    <?php if (!empty($sub_title)) : ?>
                                        <h4><?php echo wp_kses_post($sub_title); ?></h4>
                                    <?php endif; ?>

                                </header>
                            </div><!-- .col-md-12 -->
                        <?php endif; ?>

                        <?php if (!empty($video_url)) : ?>
                            <div class="col-md-12">
                                <div class="pt-video-col">
                                    <?php echo wp_oembed_get($video_url); ?>
                                </div><!-- .pt-video-col -->
                            </div><!-- .col-md-12 -->
                        <?php endif; ?>

                    </div><!-- .row -->
                </div><!-- .container -->
            </div><!-- .pt-video-sec -->

        </div><!--. pt-widget-section -->

        <?php echo $args['after_widget'];
        ob_end_flush();
    }
}