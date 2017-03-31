<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package courtyard
 */

if ( ! function_exists( 'courtyard_posted_one' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function courtyard_posted_one() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		/* translators: %s: post date */
		__( '<span class="screen-reader-text">Posted on</span> %s', 'courtyard' ),
		'<span class="posted-on"><i class="fa fa-calendar"></i> <a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a></span>'
	);

	// Get the author name; wrap it in a link.
	$byline = sprintf(
		/* translators: %s: post author */
		__( '<span class="screen-reader-text">Posted author</span> %s', 'courtyard' ),
		'<span class="author vcard"><i class="fa fa-user"></i> <a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
	);

	if ( is_single() ) : 
		if ( get_theme_mod('courtyard_post_meta_date', '1') == 1 ) :
			echo '<span class="posted-on">';
			echo $posted_on;
			echo '</span>';
		endif;

		if ( get_theme_mod('courtyard_post_meta_author', '1') == 1 ) :
			echo '<span class="byline">';
			echo $byline;
			echo '</span>';
		endif;
	else :
		if ( get_theme_mod('courtyard_blog_post_date', '1') == 1 ) :
			echo '<span class="posted-on">';
			echo $posted_on;
			echo '</span>';
		endif;

		if ( get_theme_mod( 'courtyard_blog_post_author', '1' ) == 1 ) :
			echo '<span class="byline">';
			echo $byline;
			echo '</span>';
		endif;
	endif; 

	// WPCS: XSS OK.


}
endif;

if ( ! function_exists( 'courtyard_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function courtyard_entry_footer() {

	/* translators: used between list items, there is a space after the comma */
	$separate_meta = __( ', ', 'courtyard' );

	// Get Categories for posts.
	$categories_list = get_the_category_list( $separate_meta );

	// Get Tags for posts.
	$tags_list = get_the_tag_list( '', $separate_meta );

	// We don't want to output .entry-footer if it will be empty, so make sure its not.
	if ( ( ( courtyard_categorized_blog() && $categories_list ) || $tags_list ) || get_edit_post_link() ) {

		echo '<footer class="entry-footer">';

			if ( 'post' === get_post_type() ) {
				if ( ( $categories_list && courtyard_categorized_blog() ) || $tags_list ) {
					echo '<span class="cat-tags-links">';

						// Make sure there's more than one category before displaying.
						if ( $categories_list && courtyard_categorized_blog() && ( get_theme_mod('courtyard_post_meta_categories', '1') == 1 ) ) {
							echo '<span class="cat-links"><i class="fa fa-hashtag"></i><span class="screen-reader-text"></span>' . $categories_list . '</span>';
						}

						if ( $tags_list && ( get_theme_mod('courtyard_post_meta_tags', '1') == 1 ) ) {
							echo '<span class="tags-links"><i class="fa fa-tags"></i><span class="screen-reader-text"></span>' . $tags_list . '</span>';
						}

					echo '</span>';
				}
			}

			if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) && ( get_theme_mod('courtyard_blog_post_comments', '1') == 1 ) ) {
				echo '<span class="comments-link">';
				/* translators: %s: post title */
				comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'courtyard' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
				echo '</span>';
			}

			courtyard_edit_link();

		echo '</footer> <!-- .entry-footer -->';
	}
}
endif;


if ( ! function_exists( 'courtyard_edit_link' ) ) :
/**
 * Returns an accessibility-friendly link to edit a post or page.
 *
 * This also gives us a little context about what exactly we're editing
 * (post or page?) so that users understand a bit more where they are in terms
 * of the template hierarchy and their content. Helpful when/if the single-page
 * layout with multiple posts/pages shown gets confusing.
 */
function courtyard_edit_link() {

	$link = edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'courtyard' ),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);

	return $link;
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function courtyard_categorized_blog() {
	$category_count = get_transient( 'courtyard_categories' );

	if ( false === $category_count ) {
		// Create an array of all the categories that are attached to posts.
		$categories = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$category_count = count( $categories );

		set_transient( 'courtyard_categories', $category_count );
	}

	return $category_count > 1;
}


/**
 * Flush out the transients used in courtyard_categorized_blog.
 */
function courtyard_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'courtyard_categories' );
}
add_action( 'edit_category', 'courtyard_category_transient_flusher' );
add_action( 'save_post',     'courtyard_category_transient_flusher' );
