<?php 
/**
 * Reviews Post type to save the user review during registration
 */

class TgtReview {

	public function __construct() {
		add_action( 'init', array( $this, 'custom_post_type' ) );
		add_action( 'add_meta_boxes', array( $this, 'tgt_add_meta' ) );
		/* Save post meta on the 'save_post' hook. */
		add_action( 'save_post', array( $this, 'save_post_meta' ) );
	}
	public function custom_post_type() {
		$labels = array(
			'name'           => __( 'Reviews', 'themegrill-test' ),
			'singular_name'  => __( 'Review', 'themegrill-test' ),
			'menu_name'      => __( 'Reviews', 'themegrill-test' ),
			'name_admin_bar' => __( 'Review', 'themegrill-test' ),
			'new_item'       => __( 'New Review', 'themegrill-test' ),
			'edit_item'      => __( 'Edit Review', 'themegrill-test' ),
			'view_item'      => __( 'View Review', 'themegrill-test' ),
			'all_items'      => __( 'All Reviews', 'themegrill-test' ),
			'search_items'   => __( 'Search Reviews', 'themegrill-test' ),
		);
		$args   = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'tgt-review' ),
			'capability_type'    => 'post',
			'capabilities'       => array(
				'create_posts'       => 'do_not_allow',
				'edit_post'          => 'update_core',
				'read_post'          => 'update_core',
				'delete_post'        => 'update_core',
				'edit_posts'         => 'update_core',
				'edit_others_posts'  => 'update_core',
				'delete_posts'       => 'update_core',
				'publish_posts'      => 'update_core',
				'read_private_posts' => 'update_core',
			),
			'hierarchical'       => false,
			'supports'           => array( 'title', 'editor', 'author' ),
		);
		register_post_type( 'tgt_review', $args );
	}
	/**
	 * Register Meta box
	 *
	 */
	public function tgt_add_meta() {
		$screen = sanitize_key( 'tgt_review' );
		add_meta_box(
			'rating',
			esc_html__( 'Rating', 'themegrill-test' ),
			array( $this, 'rating_meta_box_callback' ),
			$screen,
			'advanced',
			'high'
		);
	}
	/**
	 * Meta box output
	 *
	 */
	public function rating_meta_box_callback( $post ) {
		wp_nonce_field( 'rating_field', 'rating_field-nonce' );
		$rating = get_post_meta( $post->ID, '_rating', true );
		echo '<input type="number" name="_rating" min="1" max="5" value="' . esc_attr( $rating ) . '">';
	}

	public function save_post_meta( $post_id ) {
		if ( ! wp_verify_nonce( $_POST['rating_field-nonce'], 'rating_field' ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		$meta_value = intval( $_POST['_rating'] );
		update_post_meta( $post_id, '_rating', $meta_value );
	}

}
new TgtReview();
