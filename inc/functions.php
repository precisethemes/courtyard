<?php
/**
 *  Define custom or extra function which needed for Courtyard
 *
 * @package Courtyard
 */
$courtyard_theme = wp_get_theme();
$courtyard_version = $courtyard_theme->get( 'Version' );

/**
 * Enqueue scripts and styles.
 */
function courtyard_scripts() {

	global $courtyard_version;

    // Add custom fonts, used in the main stylesheet.
    wp_enqueue_style( 'courtyard-fonts', courtyard_fonts_url(), array(), null );

    // Load the Bootstrap library according to customizer control option.
    if ( get_theme_mod( 'courtyard_optimize_bootstrap_activate', '1' ) == 1 ) {
        
        // Enqueue Optimize Bootstrap Grid
        wp_enqueue_style( 'bootstrap', get_theme_file_uri() . '/css/bootstrap.optimized.min.css', array(), '3.3.7', '' );
    } else {

        // Enqueue Bootstrap Grid
        wp_enqueue_style( 'bootstrap', get_theme_file_uri() . '/css/bootstrap.min.css', array(), '3.3.7', '' );
    }

    // Enqueue animate css
    wp_enqueue_style( 'animate', get_theme_file_uri() . '/css/animate.min.css', array(), '3.5.1', '' );

    // Enqueue FontAwesome
    wp_enqueue_style( 'font-awesome', get_theme_file_uri() . '/css/font-awesome.min.css', array(), '4.7.0', '' );

    // Enqueue elegant_font
    wp_enqueue_style( 'elegant-font', get_theme_file_uri() . '/css/elegant-font.custom.css', array(), '', '' );

    // Enqueue Swiper.css
    wp_enqueue_style( 'swiper', get_theme_file_uri() . '/css/swiper.min.css', array(), '3.4.0', '' );

	wp_enqueue_style( 'courtyard-style', get_stylesheet_uri() );

	// Enqueue Swiper
    wp_enqueue_script( 'swiper', get_theme_file_uri() . '/js/swiper.jquery.min.js', array( 'jquery' ), '3.4.0', true );

    // Custom JS
    wp_enqueue_script( 'courtyard-custom', get_theme_file_uri() . '/js/custom.js', array( 'jquery' ), $courtyard_version, true );

	wp_enqueue_script( 'courtyard-navigation', get_theme_file_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'courtyard-skip-link-focus-fix', get_theme_file_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'courtyard_scripts' );

/*--------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'courtyard_fonts_url' ) ) :
/**
 * Register Google fonts for Flash.
 *
 * Create your own courtyard_fonts_url() function to override in a child theme.
 *
 * @return string Google fonts URL for the theme.
 */
function courtyard_fonts_url() {
    $fonts_url = '';

    /**
     * Translators: If there are characters in your language that are not
     * supported by Roboto, translate this to 'off'. Do not translate
     * into your own language.
     */
    $roboto_font = _x( 'on', 'Courgette|Roboto font: on or off', 'courtyard' );

    if ( 'off' !== $roboto_font ) {
        $font_families = array();

        $font_families[] = 'Courgette|Roboto:300,400,500,700';

        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );

        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }

    return esc_url_raw( $fonts_url );
}
endif;

/*--------------------------------------------------------------------------------------------------*/
/**
 * Added customizer scripts
 */
function courtyard_admin_scripts( ) {
    global $courtyard_version;

    $pt_cScreen = get_current_screen();

    if( $pt_cScreen->id === "customize" || $pt_cScreen->id === "widgets" ) {
        // Run some code, only on the admin customize and wigets page
        wp_enqueue_style( 'courtyard-admin-style', get_theme_file_uri() .'/css/admin/admin-style.css', $courtyard_version, '' );
        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker' );     
        wp_enqueue_script( 'courtyard-color-picker', get_theme_file_uri() . '/js/admin/color-picker.js', array( 'wp-color-picker' ), $courtyard_version, true );
        wp_enqueue_script( 'courtyard-customizer-script', get_theme_file_uri() .'/js/admin/customizer-scripts.js', array( 'jquery' ), $courtyard_version, true  );
    }

    if( $pt_cScreen->id === "page" ) {
        // Enqueue Custom Admin Script, only on the admin Page page.
        wp_enqueue_script( 'courtyard-admin-script', get_theme_file_uri() .'/js/admin/admin-scripts.js', array( 'jquery' ), $courtyard_version, true );
    }
}
add_action('admin_enqueue_scripts', 'courtyard_admin_scripts');

/*--------------------------------------------------------------------------------------------------*/

/**
* Footer credits
*/
function courtyard_footer_credits() {
    printf( __( 'Copyright &copy; %1$s %3$s %2$s.', 'courtyard' ), date('Y'), esc_html__('All rights reserved','courtyard'), '<a href="'.esc_url( home_url( '/' ) ) .'">' . esc_html( get_bloginfo( 'name', 'display' ) ) . '</a>.' );
    echo '<span class="sep"> | </span>';
    printf( __( 'Designed by %2$s', 'courtyard' ), '', '<a href="'.esc_url( __('http://precisethemes.com/','courtyard' ) ) .'" rel="designer" target="_blank">Precise Themes</a>' );
}
add_action( 'courtyard_footer', 'courtyard_footer_credits' );

/*--------------------------------------------------------------------------------------------------*/

/**
 * Excerpt length
 */
function courtyard_excerpt_length( $length ) {
  $excerpt = get_theme_mod('courtyard_blog_post_excerpt_length', '40');
  return absint($excerpt);
}
add_filter( 'excerpt_length', 'courtyard_excerpt_length', 99 );

/*--------------------------------------------------------------------------------------------------*/
/**
 * Excerpt String .
 */
function courtyard_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'courtyard_excerpt_more' );

/*--------------------------------------------------------------------------------------------------*/

add_filter( 'manage_edit-page_columns', 'courtyard_page_columns' );
add_action( 'manage_page_posts_custom_column', 'courtyard_render_page_columns' );

/**
 * Define custom columns for page.
 * @param  array $existing_columns
 * @return array
 */
function courtyard_page_columns( $existing_columns ) {
    $new_column_list = array();
    foreach($existing_columns as $key => $title) {
        if ($key=='author') // Put the Page Template column before the Author column
            $new_column_list['template'] = esc_html__( 'Page Template', 'courtyard' );
        $new_column_list[$key] = $title;
    }
    return $new_column_list;
}

/**
 * Ouput custom columns for pages.
 * @param string $column
 */
function courtyard_render_page_columns( $column ){
    global $post;

    if ( 'template' == $column ) {
        $page_templates = get_page_templates();

        foreach ( $page_templates as $template_name => $template_filename ) {
            if ( $template_filename == get_page_template_slug( $post->ID ) ) {
                $template = $template_name;
            }
        }

        echo isset( $template ) ? esc_html( $template ) : esc_html__( 'Default Template', 'courtyard' );
    }
}

/*--------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'courtyard_sidebar_layout_class' ) ) :
/**
 * Generate layout class for sidebar based on customizer and post meta settings.
 */
function courtyard_sidebar_layout_class() {
    global $post;
    $layout = get_theme_mod( 'courtyard_blog_global_sidebar', 'right_sidebar' );
    
    // Front page displays in Reading Settings
    $page_for_posts = get_option('page_for_posts');
    // Get Layout meta
    if($post) {
        $layout_meta = get_post_meta( $post->ID, 'courtyard_page_specific_layout', true );
    }
    // Home page if Posts page is assigned
    if( is_home() && !( is_front_page() ) ) {
        $queried_id = get_option( 'page_for_posts' );
        $layout_meta = get_post_meta( $queried_id, 'courtyard_page_specific_layout', true );

        if( $layout_meta != 'default_layout' && $layout_meta != '' ) {
            $layout = get_post_meta( $queried_id, 'courtyard_page_specific_layout', true );
        }
    }
    elseif( is_page() ) {
        if( $layout_meta != 'default_layout' && $layout_meta != '' ) {
            $layout = get_post_meta( $post->ID, 'courtyard_page_specific_layout', true );
        }
    }
    elseif( is_single() ) {
        $layout = get_theme_mod( 'courtyard_post_global_sidebar', 'right_sidebar' );
        if( $layout_meta != 'default_layout' && $layout_meta != '' ) {
            $layout = get_post_meta( $post->ID, 'courtyard_page_specific_layout', true );
        }
    }
    return esc_html( $layout );
}
endif;

/*--------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'courtyard_sidebar_select' ) ) :
/**
 * Select and show sidebar based on post meta and customizer default settings
 */
function courtyard_sidebar_select() {
    $layout = courtyard_sidebar_layout_class();
    if( $layout != "no_sidebar_full_width" ) {
        if ( $layout == "right_sidebar" || $layout = "left_sidebar" ) {
            get_sidebar();
        }
    }
}
endif;

/*--------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'courtyard_primary_sidebar' ) ) :
/**
 * Select and show sidebar based on post meta and customizer default settings
 */
function courtyard_primary_sidebar() {
    $layout = courtyard_sidebar_layout_class();
    
    if ( $layout == "right_sidebar" ) {
        $classes = 'col-md-8';
    } elseif ( $layout == "left_sidebar" ) {
        $classes = 'col-md-8 pull-right';
    } elseif ( $layout == "no_sidebar_full_width" ) {
        $classes = 'col-md-12';
    }
    return esc_html( $classes );
}
endif;

/*--------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'courtyard_secondary_sidebar' ) ) :
/**
 * Select and show sidebar based on post meta and customizer default settings
 */
function courtyard_secondary_sidebar() {
    $layout = courtyard_sidebar_layout_class();
    
    if ( $layout == "right_sidebar" ) {
        $classes = 'col-md-4 ';
    } elseif ( $layout == "left_sidebar" ) {
        $classes = 'col-md-4 pull-left';
    }
    return esc_html( $classes );
}
endif;

/*--------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'courtyard_navigation' ) ) :
/**
 * Return the navigations.
 */
function courtyard_navigation() {
    $show_post_nex_prev_article = get_theme_mod( 'courtyard_post_nex_prev_article' , '1' ); 
    if( is_archive() || is_home() || is_search() ) {
    /**
     * Checking WP-PageNaviplugin exist
     */
    if ( function_exists('wp_pagenavi' ) ) :
        wp_pagenavi();
    else:
        global $wp_query;
        if ( $wp_query->max_num_pages > 1 ) :
            the_posts_pagination( array(
                'prev_text'          => __( '&laquo; Previous', 'courtyard' ),
                'next_text'          => __( 'Next &raquo;', 'courtyard' ),
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'courtyard' ) . ' </span>',
            ) );
        endif;
    endif;
  }

  if ( is_single() && $show_post_nex_prev_article == 1 ) {
    if( is_attachment() ) {
    ?>
    <nav class="navigation post-navigation" role="navigation">
        <div class="nav-links">
            <?php if ( get_adjacent_post( false, '', true ) ): // if there are older posts ?>
                <div class="nav-previous">
                    <?php previous_image_link( false, esc_html__( '&larr; Previous', 'courtyard' ) ); ?>
                </div>
            <?php endif; ?>

            <?php if ( get_adjacent_post( false, '', false ) ): // if there are newer posts ?>
                <div class="nav-next">
                    <?php next_image_link( false, esc_html__( 'Next &rarr;', 'courtyard' ) ); ?>
                </div>
            <?php endif; ?>
        </div>
    </nav>
    <?php
    }
    else {
    ?>
    <nav class="navigation post-navigation" role="navigation">
        <div class="nav-links">
            <?php if ( get_adjacent_post( false, '', true ) ): // if there are older posts ?>
                <div class="nav-previous">
                    <?php previous_post_link( '%link', '<span class="meta-nav">' . esc_html_x( '&larr; Previous Post', 'Previous post link', 'courtyard' ) . '</span>' ); ?>
                </div>
            <?php endif; ?>

            <?php if ( get_adjacent_post( false, '', false ) ): // if there are newer posts ?>
                <div class="nav-next">
                    <?php next_post_link( '%link', '<span class="meta-nav">' . esc_html_x( 'Next Post &rarr;', 'Next post link', 'courtyard' ) . '</span>' ); ?>
                </div>
            <?php endif; ?>                
        </div>
    </nav>
    <?php
    }
  } 
}
endif;

/*--------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'courtyard_the_custom_logo' ) ) :
    /**
     * Displays the optional custom logo.
     *
     * Does nothing if the custom logo is not available.
     */
    function courtyard_the_custom_logo() {
        if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) { 
            the_custom_logo();
        }
    }
endif;

/*--------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'courtyard_breadcrumbs' ) ) :
/**
 * Breadcrumbs
 */
    function courtyard_breadcrumbs() {

        // Get the query & post information
        global $post,$wp_query;

        $delimiter = get_theme_mod( 'courtyard_breadcrumbs_sep', '/' );
        if ( $delimiter == '' ) {
            $delimiter    = '/'; // delimiter between crumbs
        }
        $home_title         = esc_html__('Home', 'courtyard');

        // Do not display on the homepage
        if ( !is_front_page() ) {

            // Build the breadcrums
            echo '<ul class="pt-breadcrumbs-items">';

            // Home page
            echo '<li class="pt-breadcrumbs-item pt-breadcrumbs-begin"><a class="pt-breadcrumbs-home" href="' . esc_html( get_home_url() ) . '" title="' . esc_attr( $home_title ) . '"><span>' . esc_html( $home_title ) . '</span></a></li>';
            echo '<li class="pt-breadcrumbs-delimiter">'.esc_html( $delimiter ).'</li>';

            if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

                // If post is a custom post type
                $post_type = get_post_type();

                // If it is a custom post type display name and link
                if($post_type != 'post' && $post_type !='product') {

                    $post_type_object       = get_post_type_object($post_type);
                    $post_type_archive_link = get_post_type_archive_link($post_type);

                    echo '<li class="pt-breadcrumbs-item"><a class="item-taxonomy" href="' . esc_url( $post_type_archive ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '"><span>' . esc_html( $post_type_object->labels->name ) . '</span></a></li>';
                    echo '<li class="pt-breadcrumbs-delimiter">'.esc_html( $delimiter ).'</li>';
                }

                $custom_taxonomy = get_queried_object()->name;
                echo '<li class="pt-breadcrumbs-item"><span>' . esc_html( $custom_taxonomy ) . '</span></li>';

            } elseif ( is_single() ) {

                // If post is a custom post type
                $post_type = get_post_type();

                // If it is a custom post type display name and link
                if($post_type != 'post' && $post_type != 'product' ) {

                    $post_type_object = get_post_type_object($post_type);
                    $post_type_archive = get_post_type_archive_link($post_type);

                    echo '<li class="pt-breadcrumbs-item"><a class="item-custom-post-type" href="' . esc_url( $post_type_archive_link ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '"><span>' . esc_html( $post_type_object->labels->name ) . '</span></a></li>';
                    echo '<li class="pt-breadcrumbs-delimiter">'.esc_html( $delimiter ).'</li>';
                }

                // Get post category info
                $category = get_the_category();

                if(!empty($category)) {

                    // Get last category post is in
                    $slice_array   = array_slice($category, -1);
                    $last_category = array_pop($slice_array);

                    // Get parent any categories and create array
                    $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                    $cat_parents     = explode(',',$get_cat_parents);

                    // Loop through parent categories and store in variable $cat_display
                    $cat_display = '';
                    foreach($cat_parents as $parents) {
                        $cat_display .= '<li class="pt-breadcrumbs-item item-category"><span>'. wp_kses_post( $parents ) .'</span></li>';
                        $cat_display .= '<li class="pt-breadcrumbs-delimiter">'.esc_html( $delimiter ).'</li>';
                    }

                }

                // Check if the post is in a category
                if(!empty($last_category)) {
                    echo $cat_display;
                    echo '<li class="pt-breadcrumbs-item"><span>' . esc_html( get_the_title() ) . '</span></li>';

                } else {

                    echo '<li class="pt-breadcrumbs-item"><span>' . esc_html( get_the_title() ) . '</span></li>';

                }

            } elseif ( is_category() ) {

                // Category page
                echo '<li class="pt-breadcrumbs-item"><span>' . single_cat_title('', false) . '</span></li>';

            } elseif ( is_page() ) {

                // Standard page
                if( $post->post_parent ){

                    // If child page, get parents
                    $anc = get_post_ancestors( $post->ID );

                    // Get parents in the right order
                    $anc = array_reverse($anc);

                    $parents = '';

                    // Parent page loop
                    foreach ( $anc as $ancestor ) {
                        $parents .= '<li class="pt-breadcrumbs-item"><a class="item-parent" href="' . esc_url ( get_permalink($ancestor) ) . '" title="' . esc_attr( get_the_title($ancestor) ) . '"><span>' . esc_html( get_the_title($ancestor) ) . '</span></a></li>';
                        $parents  .= '<li class="pt-breadcrumbs-delimiter">'.esc_html( $delimiter ).'</li>';
                    }

                    // Display parent pages
                    echo $parents;

                    // Current page
                    echo '<li class="pt-breadcrumbs-item"><span>' . esc_html( get_the_title() ) . '</span></li>';

                } else {

                    // Just display current page if not parents
                    echo '<li class="pt-breadcrumbs-item"><span>' . esc_html( get_the_title() ) . '</span></li>';
                }

            } elseif ( is_tag() ) {

                // Get tag information
                $term_id        = get_query_var('tag_id');
                $taxonomy       = 'post_tag';
                $args           = 'include=' . absint( $term_id );
                $terms          = get_terms( $taxonomy, $args );
                $get_term_id    = $terms[0]->term_id;
                $get_term_slug  = $terms[0]->slug;
                $get_term_name  = $terms[0]->name;

                // Display the tag name
                echo '<li class="pt-breadcrumbs-item"><span>' . esc_html( $get_term_name ) . '</span></li>';

            } elseif ( is_day() ) {

                // Year link
                echo '<li class="pt-breadcrumbs-item"><a class="item-year" href="' . esc_url( get_year_link( get_the_time('Y') ) ) . '" title="' . esc_attr( get_the_time('Y') ). '"><span>' . esc_html( get_the_time('Y') ) . '</span></a></li>';
                echo '<li class="pt-breadcrumbs-delimiter">'.esc_html( $delimiter ).'</li>';

                // Month link
                echo '<li class="pt-breadcrumbs-item"><a class="item-month" href="' . esc_url( get_month_link( get_the_time('Y'), get_the_time('m') ) ) . '" title="' . esc_attr( get_the_time('M') ) . '"><span>' . esc_html( get_the_time('M') ) . '</span></a></li>';
                echo '<li class="pt-breadcrumbs-delimiter">'.esc_html( $delimiter ).'</li>';

                // Day display
                echo '<li class="pt-breadcrumbs-item"><span>' . esc_html( get_the_time('jS') ) .'</span></li>';

            } elseif ( is_month() ) {

                // Year link
                echo '<li class="pt-breadcrumbs-item"><a class="item-year" href="' . esc_url( get_year_link( get_the_time('Y') ) ) . '" title="' . esc_attr( get_the_time('Y') ). '"><span>' . esc_html( get_the_time('Y') ) . '</span></a></li>';
                echo '<li class="pt-breadcrumbs-delimiter">'.esc_html( $delimiter ).'</li>';

                // Month link
                echo '<li class="pt-breadcrumbs-item"><span>' . esc_html( get_the_time('M') ) . '</span></li>';

            } elseif ( is_year() ) {

                // Display year archive
                echo '<li class="pt-breadcrumbs-item"><span>' . esc_html( get_the_time('Y') ). '</span></li>';

            } elseif ( is_author() ) {

                // Get the author information
                global $author;
                $userdata = get_userdata( $author );

                // Display author name
                echo '<li class="pt-breadcrumbs-item"><span>' . esc_html( $userdata->display_name ). '</span></li>';

            } elseif ( get_query_var('paged') ) {

                // Paginated archives
                echo '<li class="pt-breadcrumbs-item"><span>'.esc_html__( 'Page', 'courtyard' ) . esc_html( get_query_var('paged') ) . '</span></li>';

            } elseif ( is_search() ) {

                // Search results page
                echo '<li class="pt-breadcrumbs-item"><span>' .esc_html__( 'Search results for: ', 'courtyard' ) . esc_html( get_search_query() ) . '</span></li>';

            } elseif ( is_404() ) {

                // 404 page
                echo '<li class="pt-breadcrumbs-item"><span>'.esc_html__('404 Error', 'courtyard').'</span></li>';
            } elseif ( is_shop() ) {

                // Shop Page
                $shop_page_id = wc_get_page_id( 'shop' );
                $shop_page    = get_post( $shop_page_id );
                echo '<li class="pt-breadcrumbs-item"><span>'.esc_html( get_the_title( $shop_page ) ).'</span></li>';
            }

            echo '</ul>';

        }
    }
endif;

/*--------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'courtyard_display_breadcrumbs' ) ) :
/**
 * Displays the optional to show the breadcrumbs in innerpages.
 */
    function courtyard_display_breadcrumbs() {
        if ( get_theme_mod( 'courtyard_breadcrumbs_activate', '1') == 1 ) { ?>
            <div class="pt-breadcrumbs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <?php courtyard_breadcrumbs(); ?>
                        </div><!-- .col-md-12 -->
                    </div><!-- .row-->
                </div><!-- .container-->
            </div><!-- .pt-breadcrumbs-->
        <?php }
    }
endif;

/*--------------------------------------------------------------------------------------------------*/

if ( ! function_exists ( 'courtyard_listing_pagination' ) ) :

    function courtyard_listing_pagination($numpages = '', $pagerange = '', $paged='') {

        if ( empty( $pagerange ) ) {
            $default_ppp = get_option( 'posts_per_page' );
            $pagerange = absint( $default_ppp );
        }

        /**
        * This first part of our function is a fallback
        * for custom pagination inside a regular loop that
        * uses the global $paged and global $wp_query variables.
        * 
        * It's good because we can now override default pagination
        * in our theme, and use this function in default quries
        * and custom queries.
        */
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        if ( $numpages == '' ) {
            global $wp_query;
            $numpages = $wp_query->max_num_pages;
            if( !$numpages ) {
                $numpages = 1;
            }
        }

        /** 
        * We construct the pagination arguments to enter into our paginate_links
        * function. 
        */
        $pagination_args = array(
            'base'            => get_pagenum_link(1) . '%_%',
            'format'          => 'page/%#%',
            'total'           => absint( $numpages ),
            'current'         => absint( $paged ),
            'show_all'        => False,
            'end_size'        => 1,
            'mid_size'        => absint( $pagerange ),
            'prev_next'       => True,
            'prev_text'       => __('&laquo Previous','courtyard'),
            'next_text'       => __('Next &raquo','courtyard'),
            'type'            => 'plain',
            'add_args'        => false,
            'add_fragment'    => ''
        );

        if ( paginate_links($pagination_args) ) {
        echo '<div class="col-md-12">';
        echo "<div class='pt-pagination-nav'>"; 
        echo paginate_links($pagination_args);
        echo "</div>";
        echo '</div>';
        }

    }

endif;

/*--------------------------------------------------------------------------------------------------*/

if ( ! function_exists ( 'courtyard_related_rooms_lists' ) ) :
    function courtyard_related_rooms_lists(){
        global $post;
        $related_room_display = get_post_meta($post->ID, 'room_related_posts_checkbox', true);
        $related_room_numbers = get_post_meta($post->ID, 'room_related_posts_number', true);
        if ( $related_room_display == 'checked') {
            $get_featured_pages = new WP_Query( array(
                'no_found_rows'   => true,
                'post_status'     => 'publish',
                'posts_per_page'  => intval ( $related_room_numbers ),
                'post_type'       => array( 'page' ),
                'orderby'         => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
                'meta_query' => array(
                    array(
                    'key'   => '_wp_page_template',
                    'value' => 'page-templates/template-rooms.php'
                    )
                ),
            ) );
            if ( $get_featured_pages->have_posts() ) { ?>

                <aside id="related-rooms-lists" class="widget widget_related_room">     
                    <h4 class="widget-title"><?php echo esc_html( 'Related Rooms', 'courtyard');?></h4> 

                    <?php while( $get_featured_pages->have_posts() ) : $get_featured_pages->the_post();
                    $title_attribute          = the_title_attribute( 'echo=0' );
                    $image_id                 = get_post_thumbnail_id();
                    $image_path               = wp_get_attachment_image_src( $image_id, 'courtyard-400x260', true );
                    $image_alt                = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                    $room_thumbnail = '<img src="'.esc_url( $image_path[0] ).'" alt="'.esc_attr( $image_alt ).'" title="'.esc_attr( $title_attribute ).'" />';

                    ?>
                    <div>

                        <?php if( has_post_thumbnail() ) : ?>
                            <figure>
                                <a title="<?php esc_attr( $title_attribute ); ?>" href="<?php the_permalink(); ?>"><?php echo $room_thumbnail; ?></a>
                            </figure>
                        <?php endif; ?>

                        <div>
                            <h3><a title="<?php esc_attr( $title_attribute ); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                            <p><?php echo wp_trim_words( get_the_excerpt(), 22, '' ); ?></p>
                        </div><!-- .pt-room-cont -->

                    </div><!-- .pt-room-col -->

                    <?php endwhile;

                    // Reset Post Data
                    wp_reset_postdata(); ?>
                </aside>

            <?php }
        }
    }
endif;

/*--------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'courtyard_fetch_first_frontpage_widget_id' ) ) :
/**
 * Fetch the first widget id of frontpage widget sidebar.
 */
    function courtyard_fetch_first_frontpage_widget_id() {
        global $_wp_sidebars_widgets,$post;
        $post_id = $post->ID;
        $widget_id = sprintf("pt_widget_area_%s", absint( $post_id ));
        $first_widget_id = $_wp_sidebars_widgets[$widget_id][0];
        return esc_html( $first_widget_id );
    }
endif;
