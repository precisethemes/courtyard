<?php

/**
 * Holiday Packages Widget section.
 */
class courtyard_packages_widget extends WP_Widget
{
    function __construct()
    {
        $widget_ops = array('classname' => 'pt-holiday-packages-section', 'description' => esc_html__('Display some pages as packages.', 'courtyard'));
        $control_ops = array('width' => 200, 'height' => 250);
        parent::__construct(false, $name = esc_html__('PT: Packages', 'courtyard'), $widget_ops, $control_ops);
    }

    function form($instance)
    {
        $instance = wp_parse_args(
            (array)$instance, array(
                'title' => '',
                'sub_title' => '',
                'background_color' => '',
            )
        );
        ?>

        <div class="pt-holiday-packages">
            <div class="pt-admin-input-wrap">
                <p><?php esc_html_e('This widget displays all pages related to Single Package Template.', 'courtyard'); ?></p>
                <p>
                    <em><?php esc_html_e('Tip: to rearrange the packages order, edit each packages page and add a value in Page Attributes > Order', 'courtyard'); ?></em>
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
                <label
                    for="<?php echo $this->get_field_id('sub_title'); ?>"><?php esc_html_e('Sub Title', 'courtyard'); ?></label>
                <textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('sub_title'); ?>"
                          name="<?php echo $this->get_field_name('sub_title'); ?>"
                          placeholder="<?php esc_attr_e('Short description', 'courtyard'); ?>"><?php echo esc_textarea($instance['sub_title']); ?></textarea>
            </div><!-- .pt-admin-input-wrap -->

            <div class="pt-admin-input-wrap">
                <label
                    for="<?php echo $this->get_field_id('background_color'); ?>"><?php esc_html_e('Background Color', 'courtyard'); ?></label>
                <input type="text" id="<?php echo $this->get_field_id('background_color'); ?>" class="pt-color-picker"
                       name="<?php echo $this->get_field_name('background_color'); ?>"
                       value="<?php echo esc_attr($instance['background_color']); ?>">
            </div><!-- .pt-admin-input-wrap -->

        </div><!-- .pt-holiday-packages -->
    <?php }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['background_color'] = sanitize_text_field($new_instance['background_color']);
        if ( current_user_can( 'unfiltered_html' ) )
            $instance['sub_title'] = $new_instance['sub_title'];
        else
            $instance['sub_title'] = wp_kses( trim( wp_unslash( $new_instance['sub_title'] ) ), wp_kses_allowed_html( 'post' ) );
        return $instance;
    }

    function widget($args, $instance)
    {
        ob_start();
        extract($args);
        global $post;

        $title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
        $sub_title = isset($instance['sub_title']) ? $instance['sub_title'] : '';
        $background_color = isset($instance['background_color']) ? $instance['background_color'] : null;

        $get_featured_pages = new WP_Query(array(
            'no_found_rows' => true,
            'post_status' => 'publish',
            'posts_per_page' => intval(5),
            'post_type' => array('page'),
            'orderby' => array('menu_order' => 'ASC', 'date' => 'DESC'),
            'meta_query' => array(
                array(
                    'key' => '_wp_page_template',
                    'value' => 'page-templates/template-packages.php'
                )
            )
        ));

        $inline_style = '';

        if ($background_color != '') {
            $inline_style = ' style="background-color:' . esc_attr($background_color) . '"';
        }

        echo $args['before_widget'] = str_replace('<section', '<section' . $inline_style, $args['before_widget']); ?>

        <div class="pt-holiday-packages-sec">
            <div class="container">
                <div class="row">
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

                    <div class="col-md-12">

                        <?php $first_post = true; ?>

                        <?php if ($get_featured_pages->have_posts()) : ?>

                            <?php while ($get_featured_pages->have_posts()) : $get_featured_pages->the_post();
                                $image_id       = get_post_thumbnail_id();
                                $image_path     = wp_get_attachment_image_src( $image_id, 'courtyard-400x300', true );
                                $image_alt      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                                $alt            = !empty( $image_alt ) ? $image_alt : the_title_attribute( 'echo=0' ) ;
                                if ($first_post) {
                                    $image_path = wp_get_attachment_image_src($image_id, 'courtyard-600x450', true);
                                    $first_post = false;
                                }
                                ?>

                                <div class="pt-holiday-package">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <figure>
                                            <img src="<?php echo esc_url( $image_path[0] ); ?>" alt="<?php echo esc_attr( $alt ); ?>" title="<?php the_title_attribute(); ?>" />
                                        </figure>
                                    <?php endif; ?>

                                    <div class="pt-holiday-package-cont transition5">
                                        <div class="pt-holiday-package-cont-holder">
                                            <h3><a title="<?php the_title_attribute(); ?>"
                                                   href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                            <a class="pt-holiday-package-read-more transition5"
                                               title="<?php the_title_attribute(); ?>"
                                               href="<?php the_permalink(); ?>"><?php esc_html_e('View Details', 'courtyard'); ?></a>
                                        </div>
                                    </div><!-- .pt-holiday-packages-cont -->
                                </div><!-- .pt-holiday-packages-col -->

                            <?php endwhile;
                            // Reset Post Data
                            wp_reset_postdata(); ?>

                        <?php endif; ?>

                    </div><!-- .col-md-12 -->
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .pt-holiday-packages-sec -->

        <?php echo $args['after_widget'];
        ob_end_flush();
    }
}