<?php
/**
 * The file for registration abd validation
 * @package Themegrill Test
 */

class TgtRegistration {
	private $reg_errors;
	private $first_name;
	private $last_name;
	private $password;
	private $email;
	private $username;
	private $review_details;
	private $review;
	public function register() {
		if ( isset( $_POST['submit'] ) ) {
			check_admin_referer( 'tgt-register', 'tgt-register-nonce' );
			$this->first_name     = sanitize_text_field( $_POST['first_name'] );
			$this->last_name      = sanitize_text_field( $_POST['last_name'] );
			$this->password       = esc_attr( $_POST['password'] );
			$this->email          = sanitize_email( $_POST['email'] );
			$this->username       = sanitize_user( apply_filters( 'tgt_user_name', $this->email ) );
			$this->review_details = sanitize_textarea_field( $_POST['review_details'] );
			$this->review         = intval( $_POST['review'] );
			$this->register_validation();
			$this->complete_registration();
		}
	}
	// form validation
	private function register_validation() {
		$this->reg_errors = new WP_Error();
		if ( empty( $this->first_name ) || empty( $this->password ) || empty( $this->email ) ) {
			$this->reg_errors->add( 'field', __( 'Required form field is missing', 'themegrill-test' ) );
		}
		if ( ! is_email( $this->email ) ) {
			$this->reg_errors->add( 'email_invalid', __( 'Email Invalid.', 'themegrill-test' ) );
		}
		if ( email_exists( $this->email ) ) {
			$this->reg_errors->add( 'email_exists', __( 'Email aready exists', 'themegrill-test' ) );
		}

		if ( is_wp_error( $this->reg_errors ) ) {

			foreach ( $this->reg_errors->get_error_messages() as $error ) {

				echo '<div>';
				echo '<strong>' . esc_html__( 'ERROR', 'themegrill-test' ) . '</strong>: ';
				echo $error . '<br/>';
				echo '</div>';
			}
		}
	}

	//insert the user to database
	private function complete_registration() {
		if ( 1 > count( $this->reg_errors->get_error_messages() ) ) {
			$userdata = array(
				'user_login' => $this->username,
				'user_email' => $this->email,
				'user_pass'  => $this->password,
				'first_name' => $this->first_name,
				'last_name'  => $this->last_name,
			);
			$user     = wp_insert_user( $userdata );
			do_action( 'tgt_send_welcome_mail', $userdata );
			$my_rating = array(
				'post_type'    => 'tgt_review',
				'post_title'   => wp_strip_all_tags( $this->username ),
				'post_content' => $this->review_details,
				'post_status'  => 'publish',
				'post_author'  => $user,
				'meta_input'   => array(
					'_rating' => $this->review,
				),
			);
			wp_insert_post( $my_rating );
			echo __( 'Registration complete. Goto' ) . '<a href="' . esc_url( get_site_url() . '/wp-login.php ' ) . '">' . __( 'login page' ) . '</a>.';
		}
	}

}
