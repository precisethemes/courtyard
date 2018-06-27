<?php
/**
 * Services Widget section.
 */
class courtyard_service_widget extends WP_Widget {
    function __construct() {
        $widget_ops = array( 'classname' => 'pt-service-section', 'description' => esc_html__( 'Display some pages as services.', 'courtyard' ), 'customize_selective_refresh' => true, );
        $control_ops = array( 'width' => 200, 'height' =>250 );
        parent::__construct( false, $name = esc_html__( 'PT: Services', 'courtyard' ), $widget_ops, $control_ops);
    }

    function form( $instance ) {
        $instance = wp_parse_args(
            (array) $instance, array(
                'title'             => '',
                'sub_title'         => '',
                'service_limit'     => '8',
                'button_text'       => esc_html__('View All Services','courtyard'),
                'button_url'        => '#',
                'background_color'  => '',
            )
        );
        ?>

        <div class="pt-services">
            <div class="pt-admin-input-wrap">
                <p><?php esc_html_e('This widget displays all pages related to Single Service Template.', 'courtyard'); ?></p>
                <p><em><?php esc_html_e('Tip: to rearrange the services order, edit each service page and add a value in Page Attributes > Order', 'courtyard'); ?></em></p>
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
                    for="<?php echo $this->get_field_id('service_limit'); ?>"><?php esc_html_e('Count', 'courtyard'); ?></label>
                </div><!-- .pt-admin-input-label -->

                <div class="pt-admin-input-holder">
                    <input type="number" min="1" max="10" id="<?php echo $this->get_field_id('service_limit'); ?>"
                       name="<?php echo $this->get_field_name('service_limit'); ?>"
                       value="<?php echo esc_attr($instance['service_limit']); ?>">
                    <p><em><?php esc_html_e('Number of services to display.', 'courtyard'); ?></em></p>
                </div><!-- .pt-admin-input-holder -->

                <div class="clear"></div>
            </div><!-- .pt-admin-input-wrap -->

            <div class="pt-admin-input-wrap">
                <div class="pt-admin-input-label">
                    <label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php esc_html_e( 'Button Text', 'courtyard' ); ?></label>
                </div><!-- .pt-admin-input-label -->

                <div class="pt-admin-input-holder">
                    <input type="text" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" value="<?php echo esc_attr( $instance['button_text'] ); ?>" placeholder="<?php echo esc_attr( 'View All', 'courtyard' ); ?>">
                </div><!-- .pt-admin-input-holder -->

                <div class="clear"></div>
            </div><!-- .pt-admin-input-wrap -->

            <div class="pt-admin-input-wrap">
                <div class="pt-admin-input-label">
                    <label for="<?php echo $this->get_field_id( 'button_url' ); ?>"><?php esc_html_e( 'Button URL', 'courtyard' ); ?></label>
                </div><!-- .pt-admin-input-label -->

                <div class="pt-admin-input-holder">
                    <input type="text" id="<?php echo $this->get_field_id( 'button_url' ); ?>" name="<?php echo $this->get_field_name( 'button_url' ); ?>" value="<?php echo esc_attr( $instance['button_url'] ); ?>" placeholder="<?php echo esc_attr( 'http://precisethemes.com', 'courtyard' ); ?>">
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
        </div><!-- .pt-services -->
    <?php }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title']             = sanitize_text_field( $new_instance['title'] );
        $instance['service_limit']     = absint( $new_instance['service_limit'] );
        $instance['background_color']  = sanitize_text_field( $new_instance['background_color'] );
        $instance['button_text']       = sanitize_text_field( $new_instance['button_text'] );
        $instance['button_url']        = esc_url_raw( $new_instance['button_url'] );

        if ( current_user_can( 'unfiltered_html' ) )
            $instance['sub_title'] = $new_instance['sub_title'];
        else
            $instance['sub_title'] = wp_kses( trim( wp_unslash( $new_instance['sub_title'] ) ), wp_kses_allowed_html( 'post' ) );
        return $instance;
    }

    function widget( $args, $instance ) {
        ob_start();
        extract($args);

        global $post;
        $title              = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '');
        $sub_title          = isset( $instance['sub_title'] ) ? $instance['sub_title'] : '';
        $pt_service_limit   = isset( $instance['service_limit'] ) ? $instance['service_limit'] : '8';
        $button_text        = isset( $instance['button_text'] ) ? $instance['button_text'] : '';
        $button_url         = isset( $instance['button_url'] ) ? $instance['button_url'] : '';
        $background_color   = isset( $instance['background_color'] ) ? $instance['background_color'] : null;

        $get_featured_pages = new WP_Query( array(
            'post_status'           => 'publish',
            'posts_per_page'        => $pt_service_limit,
            'post_type'  			=> 'page',
            'meta_query' 			=> array(
                array(
                    'key'   => '_wp_page_template',
                    'value' => 'page-templates/template-services.php'
                )
            ),
            'orderby'               => array( 'menu_order' => 'ASC', 'date' => 'DESC' )
        ) );

        $countPosts = intval( $get_featured_pages->post_count );

        $inline_style = '';
        
        if ( $background_color != '') {
            $inline_style = ' style="background-color:' . esc_attr($background_color) . '"';
        }

        echo $args['before_widget']; ?>

        <div class="pt-widget-section" <?php echo $inline_style; ?>>

            <div class="pt-services-sec">
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

                        <?php if ( $get_featured_pages->have_posts() ) : ?>

                            <div class="col-md-12">
                                <div class="swiper-container pt-services-slider">
                                    <div class="swiper-wrapper">

                                        <?php while ($get_featured_pages->have_posts()) : $get_featured_pages->the_post();
                                            $image_id = get_post_thumbnail_id();
                                            $image_path = wp_get_attachment_image_src( $image_id, 'thumbnail', true );
                                            $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                                            $alt = !empty( $image_alt ) ? $image_alt : the_title_attribute( 'echo=0' ) ;
                                            $service_icon = get_post_meta($post->ID, 'service_icon', true);

                                            if (has_post_thumbnail()) {
                                                $service_class = 'service-thumbnail';
                                                $service_image_holder = '<img src="' . esc_url($image_path[0]) . '" alt="' . esc_attr($alt) . '" />';
                                            } else {
                                                $service_class = 'service-icon';
                                                $service_image_holder = '<i class="fa ' . esc_attr($service_icon) . '"></i>';;
                                            } ?>

                                            <div class="swiper-slide">
                                                <div class="pt-service-col">
                                                    <figure>
                                                        <?php if (has_post_thumbnail() || !empty($service_icon)) : ?>
                                                            <div class="<?php echo esc_attr($service_class); ?>">
                                                                <?php echo $service_image_holder; ?>
                                                            </div><!-- .thumbnail -->
                                                        <?php endif; ?>
                                                    </figure>

                                                    <article class="pt-service-cont">
                                                        <h3><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h3>

                                                        <p><?php echo wp_trim_words(get_the_excerpt(), 12, ''); ?></p>
                                                    </article><!-- .pt-service-cont -->
                                                </div><!-- .pt-service-col -->
                                            </div><!-- .swiper-slide -->

                                        <?php endwhile;

                                        // Reset Post Data
                                        wp_reset_postdata(); ?>

                                    </div><!-- .swiper-wrapper -->

                                    <?php if ( !empty( $button_text ) ) : ?>

                                        <div class="pt-more-arrow">
                                            <div class="pt-more-arrow-holder">
                                                <i class="pt-arrow-left transition35 hide-arrow<?php if ( ( $countPosts > 3 && $countPosts < 6 ) || ( $countPosts > 6 ) ){ echo ' '.esc_attr( 'hide-arrow' ); }?>"></i>
                                                <a href="<?php echo esc_url( $button_url ); ?>" class="transition35"><?php echo esc_html( $button_text ); ?></a>
                                                <i class="pt-arrow-right transition35 hide-arrow<?php if ( ( $countPosts > 3 && $countPosts < 6 ) || ( $countPosts > 6 ) ){ echo ' '.esc_attr( 'hide-arrow' ); }?>"></i>
                                            </div><!-- .pt-more-arrow-holder -->
                                        </div><!-- .pt-more-arrow -->

                                    <?php endif; ?>
                                </div><!-- .swiper-container -->
                            </div><!-- .col-md-12 -->
                        
                        <?php endif; ?>
                    </div><!-- .row -->
                </div><!-- .container -->
            </div><!-- .pt-services-sec -->

        </div><!-- .pt-widget-section -->

        <?php echo $args['after_widget'];
        ob_end_flush();
    }
}