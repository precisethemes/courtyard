<?php
/**
* This function is responsible for rendering metaboxes in single post/page area
* 
* @package Courtyard
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* --------------------------------------------- Page/Post Layout Options ---------------------------------------------*/
class Courtyard_Layout_Meta_Box {

	public function __construct() {

		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

	}

	public function init_metabox() {

		add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
		add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );

	}

	public function add_metabox() {

		// Adding layout meta box for Page
		add_meta_box( 
			'page_layout', 
			esc_html__( 'Select Layout', 'courtyard' ), 
			array( $this, 'render_metabox' ),
			'page', 
			'side', 
			'default' 
		);
		// Adding layout meta box for Post
		add_meta_box( 
			'page_layout', 
			esc_html__( 'Select Layout', 'courtyard' ), 
			array( $this, 'render_metabox' ),
			'post', 
			'side', 
			'default' 
		);
	}

	public function render_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( basename( __FILE__ ), 'courtyard_layout_metabox_nonce' );

		// Retrieve an existing value from the database.
		$layout = get_post_meta( $post->ID, 'page_specific_layout', true );

		// Set default values.
		if( empty( $layout ) ) $layout = 'default_layout'; ?>

		<div class="pt-input-wrap">
			<div class="pt-input-holder">
				<select id="page_specific_layout" name="page_specific_layout">
					<option value="default_layout" <?php echo selected( $layout, 'default_layout', false ); ?>><?php echo esc_html__( 'Default Layout', 'courtyard' ); ?></option>
					<option value="right_sidebar" <?php echo selected( $layout, 'right_sidebar', false ); ?>><?php echo esc_html__( 'Right Sidebar', 'courtyard' ); ?></option>
					<option value="left_sidebar" <?php echo selected( $layout, 'left_sidebar', false ); ?>><?php echo esc_html__( 'Left Sidebar', 'courtyard' ); ?></option>
					<option value="no_sidebar_full_width" <?php echo selected( $layout, 'no_sidebar_full_width', false ); ?>><?php echo esc_html__( 'No Sidebar Full Width', 'courtyard' ); ?></option>
				</select>
			</div><!-- .pt-input-holder -->
		</div><!-- .pt-input-wrap -->

		<?php
	}

	public function save_metabox( $post_id, $post ) {

		// Add nonce for security and authentication.
		if ( !isset( $_POST['courtyard_layout_metabox_nonce'] ) || !wp_verify_nonce( $_POST['courtyard_layout_metabox_nonce'], basename( __FILE__ ) ) )
    		return;

		// Stop WP from clearing custom fields on autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)
			return;

		if ('page' == $_POST['post_type']) {
			if (!current_user_can( 'edit_page', $post_id ) )
				return $post_id;
		}
		elseif (!current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// Sanitize user input.
		$new_service_icon = isset( $_POST['page_specific_layout'] ) ? sanitize_text_field( $_POST['page_specific_layout'] ) : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'page_specific_layout', $new_service_icon );

	}

}

new Courtyard_Layout_Meta_Box;

/* --------------------------------------------- Service Page Template ---------------------------------------------*/
class Courtyard_Service_Icon_Meta_Box {

	public function __construct() {

		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

	}

	public function init_metabox() {

		add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
		add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );

	}

	public function add_metabox() {

		// Adding service_icon meta box for Page
		add_meta_box( 
			'service_icon', 
			esc_html__( 'Icon class', 'courtyard' ), 
			array( $this, 'render_metabox' ),
			'page', 
			'side', 
			'default' 
		);
	}

	public function render_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( basename( __FILE__ ), 'courtyard_service_metabox_nonce' );

		// Retrieve an existing value from the database.
		$service_icon = get_post_meta( $post->ID, 'service_icon', true );

		// Set default values.
		if( empty( $service_icon ) ) $service_icon = ''; ?>

		<div class="pt-input-wrap">
			<div class="pt-input-holder">
				<input type="text" id="service_icon" name="service_icon" value="<?php echo esc_attr( $service_icon ); ?>" placeholder="fa-refresh">
			</div><!-- .pt-input-holder -->
			<div class="pt-input-desc">
				<?php
				$url = 'http://fontawesome.io/icons/';
				$link = sprintf( __( '<a href="%s" target="_blank">Refer here</a> for icon class. For example: <strong>fa-refresh</strong>', 'courtyard' ), esc_url( $url ) );
				?>
				<p><em><?php echo esc_html__( 'Info:- If featured image is not used than display the icon in Services. ', 'courtyard' ) . $link; ?></em></p>
			</div><!-- .pt-input-desc -->
		</div><!-- .pt-input-wrap -->

		<?php
	}

	public function save_metabox( $post_id, $post ) {

		// Add nonce for security and authentication.
		if ( !isset( $_POST['courtyard_service_metabox_nonce'] ) || !wp_verify_nonce( $_POST['courtyard_service_metabox_nonce'], basename( __FILE__ ) ) )
    		return;

		// Stop WP from clearing custom fields on autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)
			return;

		if ('page' == $_POST['post_type']) {
			if (!current_user_can( 'edit_page', $post_id ) )
				return $post_id;
		}
		elseif (!current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// Sanitize user input.
		$new_service_icon = isset( $_POST['service_icon'] ) ? sanitize_text_field( $_POST['service_icon'] ) : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'service_icon', $new_service_icon );

	}

}

new Courtyard_Service_Icon_Meta_Box;

/* --------------------------------------------- Room Page Template ---------------------------------------------*/
class Courtyard_Room_Related_Post_Meta_Box {

	public function __construct() {

		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

	}

	public function init_metabox() {

		add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
		add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );

	}

	public function add_metabox() {

		// Adding room_checkbox meta box for Page
		add_meta_box( 
			'room_related_post', 
			esc_html__( 'Relatd Rooms', 'courtyard' ), 
			array( $this, 'render_metabox' ),
			'page', 
			'side', 
			'default' 
		);
	}

	public function render_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( basename( __FILE__ ), 'courtyard_room_related_post_metabox_nonce' );

		// Retrieve an existing value from the database.
		$room_checkbox = get_post_meta( $post->ID, 'room_related_posts_checkbox', true );
		$number_of_posts = get_post_meta( $post->ID, 'room_related_posts_number', true );

		// Set default values.
		if( empty( $room_checkbox ) ) $room_checkbox = 'checked';
		if( empty( $number_of_posts ) ) $number_of_posts = '10'; ?>

		<div class="pt-input-wrap">
			<div class="pt-input-holder">
				<input type="checkbox" id="room_related_posts_checkbox" name="room_related_posts_checkbox" value="<?php echo esc_attr( $room_checkbox ); ?>" <?php echo checked( $room_checkbox, 'checked', false ); ?>>
				<em><?php echo esc_html__( 'Check to display related rooms in single page widget sidebar area.', 'courtyard' ); ?></em>
			</div><!-- .pt-input-holder -->
		</div><!-- .pt-input-wrap -->

		<div class="pt-input-wrap">
			<div class=pt-input-label>
				<label for="room_related_posts_number"><?php echo esc_html__( 'No of posts to display', 'courtyard' ); ?></label>
			</div><!-- .pt-input-label -->
			<div class="pt-input-holder">
				<input type="number" id="room_related_posts_number" name="room_related_posts_number" value="<?php echo esc_attr( $number_of_posts ); ?>" >
			</div><!-- .pt-input-holder -->
		</div><!-- .pt-input-wrap -->

		<?php
	}

	public function save_metabox( $post_id, $post ) {

		// Add nonce for security and authentication.
		if ( !isset( $_POST['courtyard_room_related_post_metabox_nonce'] ) || !wp_verify_nonce( $_POST['courtyard_room_related_post_metabox_nonce'], basename( __FILE__ ) ) )
    		return;

		// Stop WP from clearing custom fields on autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)
			return;

		if ('page' == $_POST['post_type']) {
			if (!current_user_can( 'edit_page', $post_id ) )
				return $post_id;
		}
		elseif (!current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// Sanitize user input.
		$room_checkbox = isset( $_POST['room_related_posts_checkbox'] ) ? 'checked' : '';
		$number_of_posts = isset( $_POST['room_related_posts_number'] ) ? absint( $_POST['room_related_posts_number'] ) : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'room_related_posts_checkbox', $room_checkbox );
		update_post_meta( $post_id, 'room_related_posts_number', $number_of_posts );

	}

}

new Courtyard_Room_Related_Post_Meta_Box;
