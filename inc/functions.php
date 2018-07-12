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

    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Add custom fonts, used in the main stylesheet.
    wp_enqueue_style( 'courtyard-fonts', courtyard_fonts_url(), array(), null );

    // Load the Bootstrap library according to customizer control option.
    if ( get_theme_mod( 'courtyard_optimize_bootstrap_activate', '1' ) == 1 ) {
        
        // Enqueue Optimize Bootstrap Grid
        wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.optimized.min.css', array(), '3.3.7', '' );
    } else {

        // Enqueue Bootstrap Grid
        wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7', '' );
    }

    // Enqueue animate css
    wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.min.css', array(), '3.5.1', '' );

    // Enqueue FontAwesome
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.7.0', '' );

    // Enqueue elegant_font
    wp_enqueue_style( 'elegant-font', get_template_directory_uri() . '/css/elegant-font.custom.css', array(), '', '' );

    // Enqueue Swiper.css
    wp_enqueue_style( 'swiper', get_template_directory_uri() . '/css/swiper.min.css', array(), '3.4.0', '' );

    wp_enqueue_style( 'courtyard-style', get_stylesheet_uri() );

    // Enqueue Swiper
    wp_enqueue_script( 'swiper', get_template_directory_uri() . '/js/swiper.min.js', array( 'jquery' ), '4.3.3', true );

    // Custom JS
    wp_enqueue_script( 'courtyard-custom', get_template_directory_uri() . '/js/custom' .$suffix. '.js', array( 'jquery' ), $courtyard_version, true );

    wp_enqueue_script( 'courtyard-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

    wp_enqueue_script( 'courtyard-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'courtyard_scripts' );

/*--------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'courtyard_fonts_url' ) ) :
/**
 * Register Google fonts for Courtyard.
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

    $courtyard_admin_screen = get_current_screen();

    wp_enqueue_style( 'courtyard-welcome-style', get_template_directory_uri() . '/inc/welcome-screen/css/welcome.css', array(), true );

    wp_enqueue_script( 'courtyard-welcome-style-script', get_template_directory_uri() . '/inc/welcome-screen/js/welcome.js', array('jquery'),'', true );

    if( $courtyard_admin_screen->id === "customize" || $courtyard_admin_screen->id === "widgets" ) {
        // Run some code, only on the admin customize and wigets page
        wp_enqueue_style( 'courtyard-admin-style', get_template_directory_uri() .'/css/admin/admin-style.css', $courtyard_version, '' );

        // Image Uploader
        wp_enqueue_media();
        wp_enqueue_script( 'courtyard-image-uploader', get_template_directory_uri() . '/js/admin/image-uploader.js', false, $courtyard_version, true );

        // Color Picker
        wp_enqueue_style( 'wp-color-picker' );     
        wp_enqueue_script( 'courtyard-color-picker', get_template_directory_uri() . '/js/admin/color-picker.js', array( 'wp-color-picker' ), $courtyard_version, true );

        wp_enqueue_script( 'courtyard-customizer-script', get_template_directory_uri() .'/js/admin/customizer-scripts.js', array( 'jquery' ), $courtyard_version, true  );
    }

    if( $courtyard_admin_screen->id === "page" ) {
        // Enqueue Custom Admin Script, only on the admin Page page.
        wp_enqueue_script( 'courtyard-admin-script', get_template_directory_uri() .'/js/admin/admin-scripts.js', array( 'jquery' ), $courtyard_version, true );
    }
}
add_action('admin_enqueue_scripts', 'courtyard_admin_scripts');

/*--------------------------------------------------------------------------------------------------*/

/**
* Footer credits
*/
function courtyard_footer_credits() {
    printf( __( 'Copyright &copy; %1$s %3$s. %2$s.', 'courtyard' ), date('Y'), esc_html__('All rights reserved','courtyard'), '<a href="'.esc_url( home_url( '/' ) ) .'">' . esc_html( get_bloginfo( 'name', 'display' ) ) . '</a>' );
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
add_filter( 'parse_query', 'courtyard_page_by_template' );
add_action( 'manage_page_posts_custom_column', 'courtyard_render_page_columns' );
add_action( 'restrict_manage_posts', 'courtyard_template_filter' );


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
 * Listing the page by page templates
 */
function courtyard_page_by_template($query) {
    global $pagenow;
    if ( isset( $_GET['courtyard_template_filter'] ) ) {
        if(is_admin() && $pagenow=='edit.php' && isset($_GET['post_type']) && isset($_GET['post_type'])=='page'){
            $query->query_vars['meta_key'] = '_wp_page_template';
            $query->query_vars['meta_value'] = $_GET['courtyard_template_filter'];
        }
    }
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

/**
 * Page Templates Dropdown filter list.
 */
function courtyard_template_filter() {
    global $typenow;

    if( $typenow == 'page' ){

        $pt_templates = wp_get_theme()->get_page_templates();
        echo '<select name="courtyard_template_filter">';
        echo '<option value="">'.esc_html__('All Templates','courtyard').'</option>';
        foreach ( $pt_templates as $pt_template_name => $pt_template_filename ) {

            if ( isset( $_GET['courtyard_template_filter'] ) && ( $_GET['courtyard_template_filter'] == $pt_template_name ) ){
                $selected = "selected";
            } else {
                $selected = '';
            }
            echo '<option value="'.esc_attr( $pt_template_name ).'" '.$selected.'>' . esc_html( $pt_template_filename ).'</option>';
        }
        echo '</select>';

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
        $layout_meta = get_post_meta( $post->ID, 'page_specific_layout', true );
    }
    // Home page if Posts page is assigned
    if( is_home() && !( is_front_page() ) ) {
        $queried_id = get_option( 'page_for_posts' );
        $layout_meta = get_post_meta( $queried_id, 'page_specific_layout', true );

        if( $layout_meta != 'default_layout' && $layout_meta != '' ) {
            $layout = get_post_meta( $queried_id, 'page_specific_layout', true );
        }
    }
    elseif( is_page() ) {
        $layout = get_theme_mod( 'courtyard_page_global_sidebar', 'right_sidebar' );
        if( $layout_meta != 'default_layout' && $layout_meta != '' ) {
            $layout = get_post_meta( $post->ID, 'page_specific_layout', true );
        }
    }
    elseif( is_single() ) {
        $layout = get_theme_mod( 'courtyard_post_global_sidebar', 'right_sidebar' );
        if( $layout_meta != 'default_layout' && $layout_meta != '' ) {
            $layout = get_post_meta( $post->ID, 'page_specific_layout', true );
        }
    }
    return esc_html( $layout );
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
    } elseif ( $layout == "no_sidebar_full_width" ) {
        $classes = 'col-md-12';
    }
    return esc_html( $classes );
}
endif;

/*---------------------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'courtyard_sidebar_select' ) ) :
/**
 * Select and show sidebar based on post meta and customizer default settings
 */
function courtyard_sidebar_select() {
    $layout = courtyard_sidebar_layout_class();
    if( $layout != "no_sidebar_full_width" ) {
        if ( $layout == "right_sidebar" || $layout = "left_sidebar" || $layout = "default_layout" ) {
            echo '<div class="'.esc_attr( courtyard_secondary_sidebar() ).'">';
            get_sidebar();
            echo '</div>';
        }
    }
}
endif;

/*--------------------------------------------------------------------------------------------------*/

if ( ! function_exists ( 'courtyard_listing_pagination' ) ) :

function courtyard_listing_pagination( $total ) {

    /** 
    * We construct the pagination arguments to enter into our paginate_links
    * function. 
    */
    $big = 999999999; // need an unlikely integer
    $pagination_args = array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $total
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

if ( ! function_exists( 'courtyard_get_attachment_id_from_url' ) ) :
/**
 * Return attachement id from Image URL.
 */
function courtyard_get_attachment_id_from_url( $attachment_url = '' ) {
 
    global $wpdb;
    $attachment_id = false;
 
    // If there is no url, return.
    if ( '' == $attachment_url )
        return;
 
    // Get the upload directory paths
    $upload_dir_paths = wp_upload_dir();
 
    // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
    if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 
        // If this is the URL of an auto-generated thumbnail, get the URL of the original image
        $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
        // Remove the upload path base directory from the attachment URL
        $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
        // Finally, run a custom database query to get the attachment ID from the modified attachment URL
        $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
    }
 
    return $attachment_id;
}
endif;

/*--------------------------------------------------------------------------------------------------*/

if ( ! function_exists ( 'courtyard_related_pages_listing' ) ) :
    function courtyard_related_pages_listing(){
        global $post;
        $disable = '';
        $font_icon = '';
        $thumbnail = '';
        // List of related rooms
        if ( is_page_template( 'page-templates/template-rooms.php' ) ) {
            $disable  = get_post_meta($post->ID, 'room_related_posts_checkbox', true);
            $numbers = get_post_meta($post->ID, 'room_related_posts_number', true);
            $template = 'page-templates/template-rooms.php';
        } 
        // List of related services
        if ( is_page_template( 'page-templates/template-services.php' ) ) {
            $disable = get_post_meta($post->ID, 'service_related_posts_checkbox', true);
            $numbers = get_post_meta($post->ID, 'service_related_posts_number', true);
            $template = 'page-templates/template-services.php';
        }
        // List of related packages
        if ( is_page_template( 'page-templates/template-packages.php' ) ) {
            $disable  = get_post_meta($post->ID, 'packages_related_posts_checkbox', true);
            $numbers = get_post_meta($post->ID, 'packages_related_posts_number', true);
            $template = 'page-templates/template-packages.php';
        }

        if ( is_page_template( 'page-templates/template-packages.php' ) || is_page_template( 'page-templates/template-services.php' ) || is_page_template( 'page-templates/template-rooms.php' ) ) {

            if ( '1' == $disable ) {
                $get_featured_pages = new WP_Query( array(
                    'no_found_rows'   => true,
                    'post_status'     => 'publish',
                    'posts_per_page'  => intval ( $numbers ),
                    'post_type'       => array( 'page' ),
                    'orderby'         => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
                    'post__not_in'    => array($post->ID),
                    'meta_query' => array(
                        array(
                        'key'   => '_wp_page_template',
                        'value' => $template
                        )
                    ),
                ) );
                if ( $get_featured_pages->have_posts() ) { ?>

                    <aside id="pt-related-lists" class="widget widget_related_room">     
                        <h4 class="widget-title"><?php esc_html_e( 'Related', 'courtyard');?></h4>

                        <?php while( $get_featured_pages->have_posts() ) : $get_featured_pages->the_post();

                        $font_icon = get_post_meta($post->ID, 'service_icon', true);
                        $title_attribute          = the_title_attribute( 'echo=0' );
                        $image_id                 = get_post_thumbnail_id();
                        $image_path               = wp_get_attachment_image_src( $image_id, 'courtyard-400x260', true );
                        $image_alt                = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

                        if ( has_post_thumbnail() ) {
                            $thumbnail = '<figure>';
                            $thumbnail .= '<a title="'.esc_attr( $title_attribute ).'" href="'.esc_attr( get_the_permalink() ).'"><img src="' . esc_url($image_path[0]) . '" alt="' . esc_attr($image_alt) . '" title="'.esc_attr( $title_attribute ).'" /></a>';
                            $thumbnail .= '</figure>';
                        } elseif ( '' != $font_icon ) {
                            $thumbnail = '<a title="'.esc_attr( $title_attribute ).'" href="'.esc_attr( get_the_permalink() ).'"><span class="pt-service-icon"><i class="fa ' . esc_attr($font_icon) . '"></i></span></a>';
                        }

                        ?>
                        <div class="pt-related-wrap">

                            <?php echo $thumbnail; ?>

                            <h3><a title="<?php esc_attr( $title_attribute ); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                            <p><?php echo wp_trim_words( get_the_excerpt(), 22, '' ); ?></p>

                        </div><!-- .pt-related-col -->

                        <?php endwhile;

                        // Reset Post Data
                        wp_reset_postdata(); ?>
                    </aside>

                <?php }
            }
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
        $post_name = $post->post_name;
        $widget_id = sprintf("pt_widget_area_%s", esc_html( $post_name ));
        $first_widget_id = $_wp_sidebars_widgets[$widget_id][0];
        return esc_html( $first_widget_id );
    }
endif;

/*--------------------------------------------------------------------------------------------------*/
if ( ! function_exists ( 'courtyard_page_thumbnail' ) ) :
    function courtyard_page_thumbnail(){
        global $post;
        $font_icon = '';
        $thumbnail = '';
        $sidebar_class = courtyard_sidebar_layout_class();
        if ( $sidebar_class == 'no_sidebar_full_width' ) {
            $img_size = 'courtyard-1200x750';
        } else {
            $img_size = 'courtyard-800x500';
        }
        $title_attribute        = the_title_attribute( 'echo=0' );
        $image_id               = get_post_thumbnail_id();
        $image_path             = wp_get_attachment_image_src( $image_id, $img_size, true );
        $image_alt              = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
        $alt                    = !empty( $image_alt ) ? $image_alt : the_title_attribute( 'echo=0' );

        $font_icon = get_post_meta($post->ID, 'service_icon', true);

        if ( has_post_thumbnail() ) {
            $thumbnail = '<figure>';
            $thumbnail .= '<img src="' . esc_url($image_path[0]) . '" alt="' . esc_attr($alt) . '" title="'.esc_attr( $title_attribute ).'" />';
            $thumbnail .= '</figure>';
        } elseif( '' != $font_icon ) {
            $thumbnail = '<span class="pt-service-icon">';
            $thumbnail .= '<i class="fa ' . esc_attr($font_icon) . '"></i>';
            $thumbnail .= '</span>';
        }
        return $thumbnail;
    }
endif;

/*--------------------------------------------------------------------------------------------------*/
/**
 * Returns true if on a page which uses WooCommerce templates.
 */
if ( ! function_exists ( 'pt_is_realy_woocommerce_page' ) ) :
    function pt_is_realy_woocommerce_page () {
        if(  function_exists ( "is_woocommerce" ) && is_woocommerce()){
            return true;
        }
        $woocommerce_keys   =   array (
            "woocommerce_shop_page_id" ,
            "woocommerce_terms_page_id" ,
            "woocommerce_cart_page_id" ,
            "woocommerce_checkout_page_id" ,
            "woocommerce_pay_page_id" ,
            "woocommerce_thanks_page_id" ,
            "woocommerce_myaccount_page_id" ,
            "woocommerce_edit_address_page_id" ,
            "woocommerce_view_order_page_id" ,
            "woocommerce_change_password_page_id" ,
            "woocommerce_logout_page_id" ,
            "woocommerce_lost_password_page_id" ) ;
        foreach ( $woocommerce_keys as $wc_page_id ) {
            if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
                return true ;
            }
        }
        return false;
    }
endif;
