<?php
/**
 * Template Name: All Rooms Listing
 *
 * Displays the All Rooms Template of the theme.
 *
 * @package Courtyard
 */

get_header(); ?>

<div class="pt-rooms-sec">
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
				$get_featured_pages = new WP_Query( array(
					'post_status'     => 'publish',
					'posts_per_page'  => intval ( $default_ppp ),
					'post_type'       => array( 'page' ),
					'orderby'         => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
					'meta_query' => array(
						array(
						'key'   => '_wp_page_template',
						'value' => 'page-templates/template-rooms.php'
						)
					),
					'paged'     => intval( $paged ),
				) );
				if ( $get_featured_pages->have_posts() ) : ?>

					<?php while( $get_featured_pages->have_posts() ) : $get_featured_pages->the_post();
					$custom_image = get_template_directory_uri() . '/inc/admin/images/courtyard-default-400x260.png';
					$title_attribute = the_title_attribute( 'echo=0' );
					$image_id = get_post_thumbnail_id();
					$image_path = wp_get_attachment_image_src( $image_id, 'courtyard-400x260', true );
					$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                    $alt = !empty( $image_alt ) ? $image_alt : the_title_attribute( 'echo=0' ) ;
					?>

					<div class="col-md-4">
                        <div class="pt-room-col">

                            <figure>
                                <a title="<?php esc_attr( $title_attribute ); ?>" href="<?php the_permalink(); ?>">
									<?php if ( has_post_thumbnail() ) : ?>
										<img src="<?php echo esc_url( $image_path[0] ); ?>" alt="<?php echo esc_attr( $alt ); ?>" title="<?php the_title_attribute(); ?>" />
									<?php else : ?>
										<img src="<?php echo esc_url( $custom_image ); ?>" alt="<?php echo esc_attr( $alt ); ?>" title="<?php the_title_attribute(); ?>" />
									<?php endif; ?>
                                </a>
                            </figure>

                            <div class="pt-room-cont transition35">
                                <a title="<?php esc_attr( $title_attribute ); ?>" href="<?php the_permalink(); ?>"><i class="pt-arrow-right transition5"></i></a>
                                <h3><a title="<?php esc_attr( $title_attribute ); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                <p><?php echo wp_trim_words( get_the_excerpt(), 22, '' ); ?></p>

                                <div class="pt-read-more">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo esc_html__('Read More', 'courtyard'); ?></a>
                                </div><!-- .pt-read-more -->
                            </div><!-- .pt-room-cont -->
					    </div><!-- .pt-room-col -->
                    </div>

					<?php endwhile;

					// Custom Pagination
                    $total = $get_featured_pages->max_num_pages;
                    
                    if ( function_exists( 'courtyard_listing_pagination' ) ) {
                        courtyard_listing_pagination( $total );
                    }

					// Reset Post Data
					wp_reset_postdata();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>
			</div><!-- #primary -->

		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- .pt-room-sec -->

<?php get_footer();
