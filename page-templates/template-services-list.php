<?php
/**
 * Template Name: All Services Listing
 *
 * Displays the All Services Template of the theme.
 *
 * @package Courtyard
 */
get_header(); ?>

<div class="pt-services-sec">
    <div class="container">
        <div class="row">
            <div id="primary" class="pt-primary-wrap">
                <div class="col-md-12">
                    <header>
                        <?php the_title( '<h1 class="entry-title pt-single-post-title">', '</h1>' ); ?>
                    </header>
                </div><!-- .col-md-12 -->

                <div class="pt-services-slider">
                    <?php
                    $default_ppp = get_option( 'posts_per_page' );
                    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
                    $offset = ( $paged - 1 ) * $default_ppp;
                    $get_featured_pages = new WP_Query( array(
                        'post_status'     => 'publish',
                        'posts_per_page'  => intval ( $default_ppp ),
                        'post_type'       => array( 'page' ),
                        'orderby'         => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
                        'meta_query' => array(
                            array(
                            'key'   => '_wp_page_template',
                            'value' => 'page-templates/template-services.php'
                            )
                        ),
                        'paged'     => intval( $paged ),
                        'offset'    =>  $offset,
                    ) ); ?>

                    <?php if ($get_featured_pages->have_posts()) : ?>

                        <?php while ($get_featured_pages->have_posts()) : $get_featured_pages->the_post();
                            $title_attribute = the_title_attribute('echo=0');
                            $image_id = get_post_thumbnail_id();
                            $image_path = wp_get_attachment_image_src($image_id, 'thumbnail', true);
                            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                            $service_icon = get_post_meta($post->ID, 'service_icon', true);

                            if (has_post_thumbnail()) {
                                $service_class = 'service-thumbnail';
                                $service_image_holder = '<img src="' . esc_url($image_path[0]) . '" alt="' . esc_attr($image_alt) . '" title="' . esc_attr($title_attribute) . '" />';
                            } else {
                                $service_class = 'service-icon';
                                $service_image_holder = '<i class="fa ' . esc_attr($service_icon) . '"></i>';;
                            } ?>

                            <div class="col-md-4">
                                <div class="pt-service-col">
                                    <figure>
                                        <?php if (has_post_thumbnail() || !empty($service_icon)) : ?>
                                            <div class="<?php echo esc_attr($service_class); ?>">
                                                <?php echo $service_image_holder; ?>
                                            </div><!-- .thumbnail -->
                                        <?php endif; ?>
                                    </figure>

                                    <article class="pt-service-cont">
                                        <h3><a title="<?php esc_attr($title_attribute); ?>" href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h3>

                                        <p><?php echo wp_trim_words(get_the_excerpt(), 12, ''); ?></p>
                                    </article><!-- .pt-service-cont -->
                                </div><!-- .pt-service-col -->
                            </div><!-- .col-md-4 -->

                            <?php endwhile;

                            if ( function_exists( 'courtyard_listing_pagination' ) ) {
                                courtyard_listing_pagination( $get_featured_pages->max_num_pages,"",$paged );
                            }
                        
                            // Reset Post Data
                            wp_reset_postdata();

                        else :

                            get_template_part( 'template-parts/content', 'none' );

                    endif; ?>

                </div><!-- .pt-services-slider -->
            </div><!-- #primary -->

        </div><!-- .row -->
    </div><!-- .container -->
</div><!-- .pt-services-sec -->

<?php get_footer();
