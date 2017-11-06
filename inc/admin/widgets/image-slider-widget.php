<?php

/**
 * Image Slider Widget section.
 */
class courtyard_image_slider_widget extends WP_Widget
{
    function __construct()
    {
        $widget_ops = array('classname' => 'pt-image-slider-section', 'description' => esc_html__('Display some pages as image slider.', 'courtyard'), 'customize_selective_refresh' => true, );
        $control_ops = array('width' => 200, 'height' => 250);
        parent::__construct(false, $name = esc_html__('PT: Hero Image Slider', 'courtyard'), $widget_ops, $control_ops);
    }

    function form($instance)
    {
        $instance = wp_parse_args(
            (array)$instance, array(
                'title' => '',
                'slide_no' => '3',
                'scroll_down' => '1',
            )
        );
        $activate_bounce = $instance['scroll_down'] ? 'checked="checked"' : '';
        ?>
        <div class="pt-image-slider">
            <div class="pt-admin-input-wrap">
                <p><?php esc_html_e('This widget displays pages of Hero Image Slider Template.', 'courtyard'); ?></p>
                <p>
                    <em><?php esc_html_e('Tip: to rearrange the image slider order, edit each image slider page and add a value in Page Attributes > Order', 'courtyard'); ?></em>
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
                            for="<?php echo $this->get_field_id('slide_no'); ?>"><?php esc_html_e('Count', 'courtyard'); ?></label>
                </div><!-- .pt-admin-input-label -->

                <div class="pt-admin-input-holder">
                    <input type="number" min="1" max="5" id="<?php echo $this->get_field_id('slide_no'); ?>"
                           name="<?php echo $this->get_field_name('slide_no'); ?>"
                           value="<?php echo esc_attr($instance['slide_no']); ?>">
                    <p><em><?php esc_html_e('Number of slides to display.', 'courtyard'); ?></em></p>
                </div><!-- .pt-admin-input-holder -->

                <div class="clear"></div>

            </div><!-- .pt-admin-input-wrap -->

            <div class="pt-admin-input-wrap">
                <div class="pt-admin-input-label">
                    <label
                            for="<?php echo $this->get_field_id('scroll_down'); ?>"><?php esc_html_e('Scroll Down', 'courtyard'); ?></label>
                </div><!-- .pt-admin-input-label -->

                <div class="pt-admin-input-holder">
                    <input type="checkbox" <?php echo $activate_bounce; ?>
                           id="<?php echo $this->get_field_id('scroll_down'); ?>"
                           name="<?php echo $this->get_field_name('scroll_down'); ?>"
                           value="<?php echo esc_attr($instance['scroll_down']); ?>">
                    <p><em><?php esc_html_e('Uncheck to disable.', 'courtyard'); ?></em></p>
                </div><!-- .pt-admin-input-holder -->

                <div class="clear"></div>

            </div><!-- .pt-admin-input-wrap -->

            <div class="pt-admin-input-wrap">
                <p>
                    <em><?php esc_html_e('Info: only page have thumbnail will show in image slide.', 'courtyard'); ?></em>
                </p>
            </div><!-- .pt-admin-input-wrap -->

        </div><!-- .pt-image-slider -->
    <?php }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['slide_no'] = absint($new_instance['slide_no']);
        $instance['scroll_down'] = isset($new_instance['scroll_down']) ? 1 : 0;
        return $instance;
    }

    function widget($args, $instance) {
        ob_start();
        extract($args);

        global $post;
        $title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
        $pt_slide_limit = isset($instance['slide_no']) ? $instance['slide_no'] : '3';
        $pt_scroll_down = isset($instance['scroll_down']) ? $instance['scroll_down'] : '1';

        $get_featured_pages = new WP_Query( array(
            'post_status'           => 'publish',
            'posts_per_page'        => $pt_slide_limit,
            'post_type'  			=> 'page',
            'meta_query' 			=> array(
                array(
                    'key'   => '_wp_page_template',
                    'value' => 'page-templates/template-image-slider.php'
                )
            ),
            'orderby'               => array( 'menu_order' => 'ASC', 'date' => 'DESC' )
        ) );

        $countPosts = intval( $get_featured_pages->post_count );

        if ( $countPosts == 1 ) {
            $pt_slide_loop = 'false';
        } else {
            $pt_slide_loop = 'true';
        }

        $data_attr = '';
        if ( $this->id == courtyard_fetch_first_frontpage_widget_id() ) {
            $data_attr = 'data-slider_id = "'.esc_attr( $this->id ).'"';
        }

        echo $args['before_widget']; ?>

        <?php if ( $get_featured_pages->have_posts() ) : ?>

            <div class="swiper-container pt-hero-image-slider" <?php echo $data_attr; ?>>
                <div class="swiper-wrapper">

                    <?php while ($get_featured_pages->have_posts()) : $get_featured_pages->the_post();
                        $image_id = get_post_thumbnail_id();
                        $image_path = wp_get_attachment_image_src($image_id, 'courtyard-1920x1080', true);
                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                        $alt = !empty( $image_alt ) ? $image_alt : the_title_attribute( 'echo=0' ) ;
                        ?>

                        <?php if (has_post_thumbnail()) : ?>

                            <div class="swiper-slide">
                                <div class="pt-hero-image-slide" data-slide-loop="<?php echo esc_attr( $pt_slide_loop );?>">
                                    <figure>
                                        <img src="<?php echo esc_url( $image_path[0] ); ?>" alt="<?php echo esc_attr( $alt ); ?>" title="<?php the_title_attribute(); ?>" />
                                    </figure>

                                    <div class="pt-hero-image-cont-wrap">
                                        <div class="pt-hero-image-cont-holder">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="pt-hero-image-cont">
                                                            <header class="animated fadeInUp">
                                                                <h1><a class="transition5" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                                                            </header>

                                                            <article class="animated fadeInUp">
                                                                <p><?php echo wp_trim_words(get_the_excerpt(), 12, ''); ?></p>
                                                                <a class="transition5" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo esc_html__('Discover', 'courtyard'); ?></a>
                                                            </article>
                                                        </div><!-- .pt-hero-image-cont -->
                                                    </div><!-- .col-md-12 -->
                                                </div><!-- .row -->
                                            </div><!-- .container -->
                                        </div><!-- .pt-hero-image-cont-holder -->
                                    </div><!-- .pt-hero-image-cont-wrap -->
                                </div><!-- .pt-hero-image-slider -->
                            </div><!-- .swiper-slide -->

                        <?php endif; ?>
                    <?php endwhile;
                    // Reset Post Data
                    wp_reset_postdata(); ?>

                </div><!-- .swiper-wrapper -->

                <?php if ( $countPosts > 1 ) : ?>

                    <nav class="pt-hero-slider-nav">
                        <i class="pt-arrow-left transition35"></i>
                        <i class="pt-arrow-right transition35"></i>
                    </nav><!-- .pt-more-arrow -->

                <?php endif; ?>

                <?php if ( $pt_scroll_down == '1' ) : ?>

                    <i class="pt-arrow-down bounce transition5"></i>

                <?php endif; ?>
            </div><!-- .pt-image-slider-section -->

            <div class="pt-hero-scroll-to"></div>

        <?php endif; ?>

        <?php echo $args['after_widget'];
        ob_end_flush();
    }
}