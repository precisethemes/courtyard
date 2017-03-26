<?php
/**
 * Template Name: All Packages Listing
 *
 * Displays the All Packages Template of the theme.
 *
 * @package Courtyard
 */
get_header(); ?>

<div class="pt-holiday-packages-sec">
    <div class="container">
        <div class="row">

            <div id="primary" class="pt-primary-wrap pt-listing-page">

                <div class="col-md-12">
                    <header>
                        <?php the_title( '<h1 class="entry-title pt-single-post-title">', '</h1>' ); ?>
                    </header>
                </div><!-- .col-md-12 -->


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
                        'value' => 'page-templates/template-packages.php'
                        )
                    ),
                    'paged'     => intval( $paged ),
                    'offset'    =>  $offset,
                ) );
                ?>

                <?php if ($get_featured_pages->have_posts()) : ?>

                    <?php while ($get_featured_pages->have_posts()) : $get_featured_pages->the_post();
                        $title_attribute = the_title_attribute('echo=0');
                        $image_id = get_post_thumbnail_id();
                        $image_path = wp_get_attachment_image_src($image_id, 'courtyard-400x300', true);
                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                        $holiday_package_thumbnail = '<img src="' . esc_url($image_path[0]) . '" alt="' . esc_attr($image_alt) . '" title="' . esc_attr($title_attribute) . '" />';
                        ?>

                        <div class="pt-holiday-package col-md-4">
                            <?php if (has_post_thumbnail()) : ?>
                                <figure>
                                    <?php echo $holiday_package_thumbnail; ?>
                                </figure>
                            <?php endif; ?>

                            <div class="pt-holiday-package-cont transition5">
                                <div class="pt-holiday-package-cont-holder">
                                    <h3><a title="<?php esc_attr($title_attribute); ?>"
                                           href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                    <a class="pt-holiday-package-read-more transition5"
                                       title="<?php esc_attr($title_attribute); ?>"
                                       href="<?php the_permalink(); ?>"><?php esc_html_e('View Details', 'courtyard'); ?></a>
                                </div>
                            </div><!-- .pt-holiday-packages-cont -->
                        </div><!-- .pt-holiday-packages-col -->

                    <?php endwhile;

                    if ( function_exists( 'courtyard_listing_pagination' ) ) {
                        courtyard_listing_pagination( $get_featured_pages->max_num_pages,"",$paged );
                    }

                    // Reset Post Data
                    wp_reset_postdata();

                else :

                    get_template_part( 'template-parts/content', 'none' ); ?>

                <?php endif; ?>

            </div><!-- #primary -->
        </div><!-- .row -->
    </div><!-- .container -->
</div><!-- .pt-holiday-packages-sec -->

<?php get_footer();
