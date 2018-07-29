<?php
/**
 * About Widget section.
 */
class Courtyard_About_Widget extends WP_Widget {
    function __construct() {
        $widget_ops = array( 'classname' => 'pt-about-section', 'description' => esc_html__( 'Show a single page.', 'courtyard' ), 'customize_selective_refresh' => true, );
        $control_ops = array( 'width' => 200, 'height' =>250 );
        parent::__construct( false, $name = esc_html__( 'PT: About', 'courtyard' ), $widget_ops, $control_ops);
    }

    function form( $instance ) {
        $instance = wp_parse_args(
            (array) $instance, array(
                'title'             => '',
                'page_id'           => '',
                'featured_image'    => '0',
                'container_width'   => 'half',
                'text_align'        => 'text-left',
                'background_color'  => '#ffffff',
            )
        );
        $featured_image     = $instance['featured_image'] ? 'checked="checked"' : '';
        $container_width    = $instance['container_width'];
        $text_align         = $instance['text_align'];
        ?>

        <div class="pt-about">
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
                    for="<?php echo $this->get_field_id('page_id'); ?>"><?php esc_html_e('Page', 'courtyard'); ?></label>
                </div><!-- .pt-admin-input-label -->

                <div class="pt-admin-input-holder">
                    <?php wp_dropdown_pages( array(
                        'show_option_none'  => '',
                        'name'              => $this->get_field_name( 'page_id' ),
                        'selected'          => absint( $instance['page_id'] )
                    ) );
                    ?>
                </div><!-- .pt-admin-input-holder -->

                <div class="clear"></div>
            </div><!-- .pt-admin-input-wrap -->

            <div class="pt-admin-input-wrap">
                <div class="pt-admin-input-label">
                    <label
                            for="<?php echo $this->get_field_id('featured_image'); ?>"><?php esc_html_e('Featured Image', 'courtyard'); ?></label>
                </div><!-- .pt-admin-input-label -->

                <div class="pt-admin-input-holder">
                    <input type="checkbox" <?php echo $featured_image; ?>
                           id="<?php echo $this->get_field_id('featured_image'); ?>"
                           name="<?php echo $this->get_field_name('featured_image'); ?>"
                           value="<?php echo esc_attr($instance['featured_image']); ?>">
                    <p><em><?php esc_html_e('Check to hide page featured image as background of container.', 'courtyard'); ?></em></p>
                </div><!-- .pt-admin-input-holder -->

                <div class="clear"></div>
            </div><!-- .pt-admin-input-wrap -->

            <div class="pt-admin-input-wrap">
                <div class="pt-admin-input-label">
                    <label
                            for="<?php echo $this->get_field_id('container_width'); ?>"><?php esc_html_e('Container Width', 'courtyard'); ?></label>
                </div><!-- .pt-admin-input-label -->

                <div class="pt-admin-input-holder">
                    <select id="<?php echo $this->get_field_id('container_width'); ?>" name="<?php echo $this->get_field_name('container_width'); ?>">
                        <option value="half" <?php selected( $container_width, 'half' ); ?>><?php esc_html_e('Half', 'courtyard'); ?></option>
                        <option value="full" <?php selected( $container_width, 'full' ); ?>><?php esc_html_e('Full', 'courtyard'); ?></option>
                    </select>
                </div><!-- .pt-admin-input-holder -->

                <div class="clear"></div>
            </div><!-- .pt-admin-input-wrap -->

            <div class="pt-admin-input-wrap">
                <div class="pt-admin-input-label">
                    <label
                            for="<?php echo $this->get_field_id('text_align'); ?>"><?php esc_html_e('Text Alignment', 'courtyard'); ?></label>
                </div><!-- .pt-admin-input-label -->

                <div class="pt-admin-input-holder">
                    <select id="<?php echo $this->get_field_id('text_align'); ?>" name="<?php echo $this->get_field_name('text_align'); ?>">
                        <option value="text-left" <?php selected( $text_align, 'text-left' ); ?>><?php esc_html_e('Left', 'courtyard'); ?></option>
                        <option value="text-center" <?php selected( $text_align, 'text-center' ); ?>><?php esc_html_e('Center', 'courtyard'); ?></option>
                        <option value="text-right" <?php selected( $text_align, 'text-right' ); ?>><?php esc_html_e('Right', 'courtyard'); ?></option>
                    </select>
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
                    <p><em><?php esc_html_e('Choose the background color for the widget content section.', 'courtyard'); ?></em></p>
                </div><!-- .pt-admin-input-holder -->

                <div class="clear"></div>
            </div><!-- .pt-admin-input-wrap -->
        </div><!-- .pt-about -->
    <?php }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title']             = sanitize_text_field( $new_instance['title'] );
        $instance['page_id']           = absint( $new_instance['page_id'] );
        $instance['featured_image']    = isset($new_instance['featured_image']) ? 1 : 0;
        $instance['container_width']   = $new_instance['container_width'];
        $instance['text_align']        = $new_instance['text_align'];
        $instance['background_color']  = sanitize_text_field( $new_instance['background_color'] );
        return $instance;
    }

    function widget( $args, $instance ) {
        ob_start();
        extract($args);

        $pt_page_id         = isset( $instance['page_id'] ) ? $instance['page_id'] : '';
        $background_color   = isset( $instance['background_color'] ) ? $instance['background_color'] : '#ffffff';
        $featured_image     = !empty($instance['featured_image']) ? 'true' : 'false';
        $container_width    = isset($instance['container_width']) ? $instance['container_width'] : 'half';
        $text_align         = isset($instance['text_align']) ? $instance['text_align'] : 'text-left';

        $get_featured_pages = new WP_Query( array(
            'post_status'           => 'publish',
            'post_type'             =>  array( 'page' ),
            'page_id'               => $pt_page_id,
        ) );

        $inline_style = '';

        if ( $background_color != '') {
            $inline_style = 'style="background-color:' . esc_attr($background_color) . ';"';
        }

        echo $args['before_widget']; ?>

        <div class="pt-widget-section">

            <?php if ( $get_featured_pages->have_posts() && !empty( $pt_page_id ) ) : ?>

                <?php while ($get_featured_pages->have_posts()) : $get_featured_pages->the_post();
                    $custom_image = get_template_directory_uri() . '/inc/admin/images/courtyard-default.png';
                    $image_id = get_post_thumbnail_id();
                    $image_path = wp_get_attachment_image_src( $image_id, 'courtyard-1920x1080', true );
                    if ( has_post_thumbnail() ) {
                        $custom_image = $image_path[0];
                    }
                    $inline_img_style = 'style="background:url(' . esc_url($custom_image) . ') no-repeat;"';
                    ?>

                    <div class="pt-about-wrap" <?php if( $featured_image == 'false' ) { echo $inline_img_style;} ?>>
                        <div class="container">
                            <div class="row">
                                <div class="<?php if ( $container_width == 'half' ) { echo esc_attr('col-md-7 col-sm-7 col-md-push-5 col-sm-push-5'); } else { echo esc_attr( 'col-md-12 col-sm-12' ); }?>">
                                    <div class="pt-about-col">
                                        <article class="pt-about-cont" <?php echo $inline_style; ?>>
                                            <div class="pt-about-cont-holder <?php echo esc_attr( $text_align ); ?>">
                                                <header>
                                                    <h3><?php the_title(); ?></h3>
                                                </header>

                                                <?php
                                                the_content();
                                                wp_link_pages(
                                                    array(
                                                        'before'      => '<div class="page-links">' . __( 'Pages:', 'courtyard' ),
                                                        'after'       => '</div>',
                                                        'link_before' => '<span class="page-number">',
                                                        'link_after'  => '</span>',
                                                    )
                                                );
                                                ?>
                                                
                                            </div><!-- .pt-about-cont-holder -->
                                        </article><!-- .pt-about-cont -->
                                    </div><!-- .pt-about-col -->
                                </div><!-- .col-md-12 -->
                            </div><!-- .row -->
                        </div><!-- .container -->
                    </div><!-- .pt-about-wrap -->

                <?php endwhile;

                // Reset Post Data
                wp_reset_postdata(); ?>

            <?php endif; ?>

        </div><!-- .pt-widget-section -->

        <?php echo $args['after_widget'];
        ob_end_flush();
    }
}