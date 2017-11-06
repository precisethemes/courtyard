<?php

/**
 * Logo Widget section.
 */
class Courtyard_Logo_Widget extends WP_Widget {
    function __construct() {
        $widget_ops = array('classname' => 'pt-logo-section', 'description' => esc_html__('Show your business patner logo.', 'courtyard'), 'customize_selective_refresh' => true, );
        $control_ops = array('width' => 200, 'height' => 250);
        parent::__construct(false, $name = esc_html__('PT: Logo', 'courtyard'), $widget_ops, $control_ops);
    }

    function form($instance) {
        $defaults = array();
        $defaults['title'] = '';
        $defaults['sub_title'] = '';
        $defaults['number'] = 3;
        for ( $num =0; $num < $defaults['number'] ; $num++ ) {
            $defaults['logo_title_'. $num] = '';
            $defaults['logo_url_'. $num] = '';
            $defaults['logo_'. $num] = '';
        }
        $defaults['background_color'] = '';

        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>

        <div class="pt-logo">
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
                            for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e('Number', 'courtyard'); ?></label>
                </div><!-- .pt-admin-input-label -->

                <div class="pt-admin-input-holder">
                    <input type="number" min="1" max="5" id="<?php echo $this->get_field_id('number'); ?>"
                           name="<?php echo $this->get_field_name('number'); ?>"
                           value="<?php echo esc_attr($instance['number']); ?>" >
                    <p>
                        <em><?php esc_html_e('Tip: Enter number to upload the number of logo ( default 3 ) and save it then enter the data in respective field.', 'courtyard'); ?></em>
                    </p>
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

            <hr/>

            <?php for ( $num =0; $num < $instance['number']; $num++ ) { ?>

                <div class="pt-admin-input-wrap">
                    <div class="pt-admin-input-label">
                        <label
                                for="<?php echo $this->get_field_id('logo_'.$num); ?>"><?php esc_html_e('Logo', 'courtyard'); ?></label>
                    </div><!-- .pt-admin-input-label -->

                    <div class="pt-admin-input-holder">
                        <div class="media-uploader" id="<?php echo $this->get_field_id( 'logo_'.$num ); ?>">
                            <div class="custom_media_preview">
                                <?php if ( '' != $instance['logo_'. $num] ) :
                                    $image_src = wp_get_attachment_image_src( $instance['logo_'. $num], 'full' ); ?>
                                    <span class="delete_media_image">X</span>
                                    <img class="custom_media_preview_default" src="<?php echo esc_url( $image_src[0] ); ?>" style="max-width:100%;" />
                                <?php endif; ?>
                            </div>
                            <input type="hidden" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'logo_'. $num ); ?>" name="<?php echo $this->get_field_name( 'logo_'. $num ); ?>" value="<?php echo absint( $instance['logo_'. $num] ); ?>" />
                            <button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'logo_'. $num ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'courtyard' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'courtyard' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'courtyard' ); ?></button>
                            <p><em><?php esc_html_e('Recommended size 400 x 260', 'courtyard'); ?></em></p>
                        </div>
                    </div><!-- .pt-admin-input-holder -->
                </div><!-- .pt-admin-input-wrap -->

                <div class="pt-admin-input-wrap">
                    <div class="pt-admin-input-label">
                        <label
                                for="<?php echo $this->get_field_id('logo_title_'.$num); ?>"><?php esc_html_e('Title', 'courtyard'); ?></label>
                    </div><!-- .pt-admin-input-label -->

                    <div class="pt-admin-input-holder">
                        <input type="text" id="<?php echo $this->get_field_id('logo_title_'.$num); ?>"
                               name="<?php echo $this->get_field_name('logo_title_'.$num); ?>"
                               value="<?php echo esc_attr($instance['logo_title_'.$num]); ?>"
                               placeholder="<?php esc_attr_e('Title', 'courtyard'); ?>">
                    </div><!-- .pt-admin-input-holder -->
                </div><!-- .pt-admin-input-wrap -->

                <div class="pt-admin-input-wrap">
                    <div class="pt-admin-input-label">
                        <label
                                for="<?php echo $this->get_field_id('logo_url_'.$num); ?>"><?php esc_html_e('URL', 'courtyard'); ?></label>
                    </div><!-- .pt-admin-input-label -->

                    <div class="pt-admin-input-holder">
                        <input type="text" id="<?php echo $this->get_field_id('logo_url_'.$num); ?>"
                               name="<?php echo $this->get_field_name('logo_url_'.$num); ?>"
                               value="<?php echo esc_attr($instance['logo_url_'.$num]); ?>"
                               placeholder="<?php esc_attr_e('URL', 'courtyard'); ?>">
                    </div><!-- .pt-admin-input-holder -->
                </div><!-- .pt-admin-input-wrap -->

                <hr/>

            <?php } ?>

        </div><!-- .pt-logo -->

    <?php }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['number'] = absint($new_instance['number']);
        for( $num=0; $num < $instance['number']; $num++ ) {
            $instance['logo_title_'. $num] = sanitize_text_field( $new_instance['logo_title_'. $num] );
            $instance['logo_url_'. $num] = esc_url_raw( $new_instance['logo_url_'. $num] );
            $instance['logo_'. $num] = absint( $new_instance['logo_'. $num] );
        }
        $instance['background_color'] = sanitize_text_field($new_instance['background_color']);

        if ( current_user_can( 'unfiltered_html' ) )
            $instance['sub_title'] = $new_instance['sub_title'];
        else
            $instance['sub_title'] = wp_kses( trim( wp_unslash( $new_instance['sub_title'] ) ), wp_kses_allowed_html( 'post' ) );
        return $instance;
    }

    function widget($args, $instance) {
        ob_start();
        extract($args);

        $title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
        $sub_title = isset($instance['sub_title']) ? $instance['sub_title'] : '';
        $background_color = isset($instance['background_color']) ? $instance['background_color'] : null;
        $number = isset($instance['number']) ? $instance['number'] : '5';
        $pt_logo_url = array();
        $pt_logo_title = array();
        $pt_logo = array();
        for( $num=0; $num < $number; $num++ ) {
            $pt_logo_url[]    = isset( $instance['logo_url_'. $num] ) ? $instance['logo_url_'. $num] : '';
            $pt_logo_title[]  = isset( $instance['logo_title_'. $num] ) ? $instance['logo_title_'. $num] : '';
            $pt_logo[]   = isset( $instance['logo_'. $num] ) ? $instance['logo_'. $num] : '';
        }

        $inline_style = '';

        if ($background_color != '') {
            $inline_style = ' style="background-color:' . esc_attr($background_color) . '"';
        }

        echo $args['before_widget']; ?>

    <div class="pt-widget-section" <?php echo $inline_style; ?>>

        <div class="pt-logo-sec">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php if ( !empty( $title ) || !empty( $sub_title ) ) : ?>
                            <header>
                                <?php if (!empty($title)) : ?>
                                    <h2 class="widget-title"><?php echo esc_html($title); ?></h2>
                                <?php endif; ?>

                                <?php if (!empty($sub_title)) : ?>
                                    <h4><?php echo wp_kses_post($sub_title); ?></h4>
                                <?php endif; ?>
                            </header>
                        <?php endif; ?>

                        <?php if ( !empty( $pt_logo ) ) : ?>
                            <div class="pt-logos-wrap">
                                <?php foreach ($pt_logo as $key => $value) {
                                    if ( '' != $pt_logo[$key] ) :
                                        $image_src = wp_get_attachment_image_src( $value, 'courtyard-400x260' ); ?>
                                        <div class="pt-logo-col transition5">
                                            <figure>
                                                <a href="<?php if( !empty( $pt_logo_url[$key] ) ) { echo esc_url( $pt_logo_url[$key] ); } else { echo '#'; } ?>" <?php if( !empty( $pt_logo_url[$key] ) ) { echo 'target="_blank"'; } ?>><img src="<?php echo esc_url( $image_src[0] ); ?>" alt="<?php echo esc_attr( $pt_logo_title[$key] ); ?>" /></a>
                                            </figure>
                                        </div><!-- .pt-logo-col -->
                                    <?php endif;
                                } ?>
                            </div><!-- .pt-logos-wrap -->
                        <?php endif; ?>
                    </div><!-- .col-md-12 -->
                </div><!-- .container -->
            </div><!-- .pt-logo-sec -->

        </div><!-- .pt-widget-section -->

        <?php echo $args['after_widget'];
        ob_end_flush();
    }
}
