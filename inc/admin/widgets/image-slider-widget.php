<?php

/**
 * Image Slider Widget section.
 */
class courtyard_image_slider_widget extends WP_Widget
{
    function __construct()
    {
        $widget_ops = array('classname' => 'pt-image-slider-section', 'description' => esc_html__('Display some pages as image slider.', 'courtyard'));
        $control_ops = array('width' => 200, 'height' => 250);
        parent::__construct(false, $name = esc_html__('PT: Hero Image Slider', 'courtyard'), $widget_ops, $control_ops);
    }

    function form($instance)
    {
        $instance = wp_parse_args(
            (array)$instance, array(
                'title' => '',
            )
        );
        ?>
        <div class="pt-image-slider">
            <div class="pt-admin-input-wrap">
                <p><?php esc_html_e('This widget displays all pages of Hero Image Slider Template.', 'courtyard'); ?></p>
                <p>
                    <em><?php esc_html_e('Tip: to rearrange the image slider order, edit each image slider page and add a value in Page Attributes > Order', 'courtyard'); ?></em>
                </p>
            </div><!-- .pt-admin-input-wrap -->

            <div class="pt-admin-input-wrap">
                <label
                    for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title', 'courtyard'); ?></label>
                <input type="text" id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>"
                       value="<?php echo esc_attr($instance['title']); ?>"
                       placeholder="<?php esc_attr_e('Title', 'courtyard'); ?>">
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
        return $instance;
    }

    function widget($args, $instance) {
        ob_start();
        extract($args);

        $title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
        $get_featured_pages = new WP_Query(array(
            'no_found_rows' => true,
            'post_status' => 'publish',
            'posts_per_page' => intval(5),
            'post_type' => array('page'),
            'orderby' => array('menu_order' => 'ASC', 'date' => 'DESC'),
            'meta_query' => array(
                array(
                    'key' => '_wp_page_template',
                    'value' => 'page-templates/template-image-slider.php'
                )
            )
        ));
        $countPosts = intval( $get_featured_pages->post_count );

        $data_attr = '';
        if ( $this->id == courtyard_fetch_first_frontpage_widget_id() ) {
            $data_attr = 'data-slider_id = "'.esc_attr( $this->id ).'"';
        }

        echo $args['before_widget']; ?>

        <div class="swiper-container pt-hero-image-slider" <?php echo $data_attr; ?>>
        
            <div class="swiper-wrapper">

                <?php if ($get_featured_pages->have_posts()) : ?>
                    <?php while ($get_featured_pages->have_posts()) : $get_featured_pages->the_post();
                        $image_id = get_post_thumbnail_id();
                        $image_path = wp_get_attachment_image_src($image_id, 'courtyard-1920x1080', true);
                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                        $alt = !empty( $image_alt ) ? $image_alt : the_title_attribute( 'echo=0' ) ;
                        ?>

                        <?php if (has_post_thumbnail()) : ?>

                            <div class="swiper-slide">
                                <div class="pt-hero-image-slide">
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
                                                                <h1><?php the_title(); ?></h1>
                                                            </header>

                                                            <article class="animated fadeInUp">
                                                                <p><?php echo wp_trim_words(get_the_excerpt(), 12, ''); ?></p>
                                                                <a class="transition5" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php esc_html_e(get_theme_mod('courtyard_blog_read_more_text', esc_html__('Discover', 'courtyard'))); ?></a>
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
                <?php endif; ?>

            </div><!-- .swiper-wrapper -->

            <?php if ( $countPosts > 1 ) : ?>

            <nav class="pt-hero-slider-nav">
                <i class="pt-arrow-left transition35"></i>
                <i class="pt-arrow-right transition35"></i>
            </nav><!-- .pt-services-more -->

            <?php endif; ?>

            <i class="pt-arrow-down bounce transition5"></i>
        </div><!-- .pt-image-slider-section -->

        <div class="pt-hero-scroll-to"></div>

        <?php echo $args['after_widget'];
        ob_end_flush();
    }
}