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
                'background_color'  => '#ffffff',
            )
        );
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
        $instance['background_color']  = sanitize_text_field( $new_instance['background_color'] );
        return $instance;
    }

    function widget( $args, $instance ) {
        ob_start();
        extract($args);

        global $post;
        $pt_page_id         = isset( $instance['page_id'] ) ? $instance['page_id'] : '';
        $background_color   = isset( $instance['background_color'] ) ? $instance['background_color'] : '#ffffff';

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
                    $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                    $alt = !empty( $image_alt ) ? $image_alt : the_title_attribute( 'echo=0' ) ;
                    $inline_img_style = 'style="background:url(' . esc_url($custom_image) . ') no-repeat;"';
                    ?>

                    <div class="pt-about-wrap" <?php echo $inline_img_style; ?>>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-7 col-sm-7 col-md-push-5 col-sm-push-5">
                                    <div class="pt-about-col">
                                        <article class="pt-about-cont" <?php echo $inline_style; ?>>
                                            <div class="pt-about-cont-holder">
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