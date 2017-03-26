<?php

/**
 * Featured Posts Widget section.
 */
class courtyard_recent_posts_widget extends WP_Widget
{
    function __construct()
    {
        $widget_ops = array('classname' => 'pt-recent-posts-section', 'description' => esc_html__('Display latest posts or posts of specific category.', 'courtyard'));
        $control_ops = array('width' => 200, 'height' => 250);
        parent::__construct(false, $name = esc_html__('PT: Recent Posts', 'courtyard'), $widget_ops, $control_ops);
    }

    function form($instance)
    {
        $instance = wp_parse_args(
            (array)$instance, array(
                'title' => '',
                'sub_title' => '',
                'type' => 'latest',
                'category' => '',
                'random_posts' => '0',
                'background_color' => '',
            )
        );
        $type = $instance['type'];
        $category = $instance['category'];
        $random_posts = $instance['random_posts'] ? 'checked="checked"' : '';
        ?>

        <div class="pt-recent-posts">

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
                <input type="radio" <?php checked($type, 'latest') ?> id="<?php echo $this->get_field_id('type'); ?>"
                       name="<?php echo $this->get_field_name('type'); ?>"
                       value="latest"/><?php esc_html_e('Show latest Posts', 'courtyard'); ?><br/>
                <input type="radio" <?php checked($type, 'category') ?> id="<?php echo $this->get_field_id('type'); ?>"
                       name="<?php echo $this->get_field_name('type'); ?>"
                       value="category"/><?php esc_html_e('Show posts from a category', 'courtyard'); ?><br/>
            </div><!-- .pt-admin-input-wrap -->

            <div class="pt-admin-input-wrap">
                <label
                    for="<?php echo $this->get_field_id('category'); ?>"><?php esc_html_e('Select category', 'courtyard'); ?></label>
                <?php wp_dropdown_categories(array('show_option_none' => '', 'name' => $this->get_field_name('category'), 'selected' => $category)); ?>
            </div><!-- .pt-admin-input-wrap -->

            <div class="pt-admin-input-wrap">
                <input type="checkbox" <?php echo $random_posts; ?>
                       id="<?php echo $this->get_field_id('random_posts'); ?>"
                       name="<?php echo $this->get_field_name('random_posts'); ?>"
                       value="<?php echo esc_attr($instance['random_posts']); ?>">
                <label
                    for="<?php echo $this->get_field_id('random_posts'); ?>"><?php esc_html_e('Check to display the random post from either the chosen category or from latest post.', 'courtyard'); ?></label>
            </div><!-- .pt-admin-input-wrap -->

            <div class="pt-admin-input-wrap">
                <label
                    for="<?php echo $this->get_field_id('background_color'); ?>"><?php esc_html_e('Background Color', 'courtyard'); ?></label>
                <input type="text" id="<?php echo $this->get_field_id('background_color'); ?>" class="pt-color-picker"
                       name="<?php echo $this->get_field_name('background_color'); ?>"
                       value="<?php echo esc_attr($instance['background_color']); ?>">
            </div><!-- .pt-admin-input-wrap -->

        </div><!-- .pt-recent-posts -->
    <?php }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['type'] = $new_instance['type'];
        $instance['category'] = $new_instance['category'];
        $instance['random_posts'] = isset($new_instance['random_posts']) ? 1 : 0;
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

        $title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
        $sub_title = isset($instance['sub_title']) ? $instance['sub_title'] : '';
        $type = isset($instance['type']) ? $instance['type'] : 'latest';
        $category = isset($instance['category']) ? $instance['category'] : '';
        $random_posts = !empty($instance['random_posts']) ? 'true' : 'false';
        $background_color = isset($instance['background_color']) ? $instance['background_color'] : null;

        if ($type == 'latest' && $random_posts == 'false') {
            $get_featured_posts = new WP_Query(array(
                'posts_per_page' => intval(3),
                'post_type' => 'post',
                'ignore_sticky_posts' => true,
                'no_found_rows' => true,
            ));
        } elseif ($type == 'latest' && $random_posts == 'true') {
            $get_featured_posts = new WP_Query(array(
                'posts_per_page' => intval(3),
                'post_type' => 'post',
                'ignore_sticky_posts' => true,
                'no_found_rows' => true,
                'orderby' => 'rand',
            ));
        } elseif ($type == 'category' && $random_posts == 'false') {
            $get_featured_posts = new WP_Query(array(
                'posts_per_page' => intval(3),
                'post_type' => 'post',
                'category__in' => $category,
                'no_found_rows' => true,
            ));
        } elseif ($type == 'category' && $random_posts == 'true') {
            $get_featured_posts = new WP_Query(array(
                'posts_per_page' => intval(3),
                'post_type' => 'post',
                'category__in' => $category,
                'no_found_rows' => true,
                'orderby' => 'rand',
            ));
        }

        $inline_style = '';
        
        if ( $background_color != '') {
            $inline_style = ' style="background-color:' . esc_attr($background_color) . '"';
        }

        echo $args['before_widget'] = str_replace('<section', '<section' .$inline_style , $args['before_widget']); ?>

        <div class="pt-recent-posts-sec">
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

                    <?php if ($get_featured_posts->have_posts()) : ?>
                        <?php while ($get_featured_posts->have_posts()) : $get_featured_posts->the_post();
                            $image_id       = get_post_thumbnail_id();
                            $image_path     = wp_get_attachment_image_src( $image_id, 'courtyard-400x260', true );
                            $image_alt      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                            $alt            = !empty( $image_alt ) ? $image_alt : the_title_attribute( 'echo=0' ) ;
                            ?>
                            <div class="col-md-4 col-sm-6 col-sm-6">
                                <div class="pt-recent-posts-col">

                                    <?php if (has_post_thumbnail()) : ?>
                                        <figure>
                                            <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">
                                                <img src="<?php echo esc_url( $image_path[0] ); ?>" alt="<?php echo esc_attr( $alt ); ?>" title="<?php the_title_attribute(); ?>" />
                                            </a>

                                            <div class="pt-blog-date transition5">
                                                <div class="pt-blog-post-month"><?php echo esc_html( get_the_time("M") ); ?><br/><?php echo esc_html( get_the_time("Y") ); ?></div>
                                                <div class="pt-blog-post-day"><?php echo esc_html( get_the_time("d") ); ?></div>
                                            </div>

                                            <div class="pt-blog-post-more-icon transition5">
                                                <a class="transition5" title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>" ><i class="pt-arrow-right transition5"></i></a>
                                            </div>
                                        </figure>
                                    <?php endif; ?>

                                    <article class="pt-recent-posts-cont">
                                        <h3><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                        <p><?php echo wp_trim_words(get_the_excerpt(), 18, ''); ?></p>

                                        <div class="pt-recent-posts-read-more">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php esc_html_e(get_theme_mod('courtyard_blog_read_more_text', esc_html__('Read More', 'courtyard'))); ?></a>
                                        </div><!-- .pt-recent-posts-read-more -->

                                    </article><!-- .pt-recent-posts-cont -->
                                </div><!-- .pt-recent-posts-col -->

                            </div><!-- .col-md-4 -->
                        <?php endwhile;
                        // Reset Post Data
                        wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .pt-recent-posts-sec -->

        <?php echo $args['after_widget'];
        ob_end_flush();
    }
}