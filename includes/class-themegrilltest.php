<?php
/**
 * The file that defines the core plugin class
 * @package Themegrill Test
 */
defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'ThemeGrillTest' ) ) :
	class ThemeGrillTest {

		public function __construct() {

			$this->includes();
			$this->init_hooks();
		}
		// initialize hooks.
		public function init_hooks() {

			add_shortcode( 'tgt_register', array( $this, 'tgt_register_shortcode' ) );
			add_shortcode( 'tgt_reviews', array( $this, 'tgt_review_template_shortcode' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

		}
		// includes the class,functions.
		public function includes() {

			require_once TGT_PLUGIN_PATH . 'includes/class-tgt-registration.php';
			require_once TGT_PLUGIN_PATH . 'includes/class-tgt-review.php';
			require_once TGT_PLUGIN_PATH . 'includes/tgt-functions.php';
		}
		//create registration shortcode
		public function tgt_register_shortcode() {
			$registration = new TgtRegistration();
			ob_start();
			$registration->register();
			include TGT_PLUGIN_PATH . 'templates/register.php';
			return ob_get_clean();

		}
		//create review display page template shortcode
		public function tgt_review_template_shortcode() {
			ob_start();
			if ( is_user_logged_in() ) {
				include TGT_PLUGIN_PATH . 'templates/reviews.php';
			} else {
				echo '<div classs="tgt-error text-center">Sorry you are not authorized to view this page.</div>';
			}
			return ob_get_clean();

		}
		// enqueue style and script for frontend.
		public function enqueue() {
			global $post;
			//enqueue style and scripts if post content contains shortcode
			if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'tgt_register' ) ) {
				wp_enqueue_style( 'tgt-range-slider-style', TGT_PLUGIN_URL . 'assets/css/rangeslider.css' );
				//enqueue scripts
				wp_enqueue_script( 'tgt-range-slider', TGT_PLUGIN_URL . 'assets/js/rangeslider.min.js', array( 'jquery' ), '2.3.0', true );
			}

			//enqueue style
			wp_enqueue_style( 'tgt-style', TGT_PLUGIN_URL . 'assets/css/style.css' );

			wp_register_script( 'tgt_review_script', TGT_PLUGIN_URL . 'assets/js/index.js', array( 'jquery' ) );
			wp_localize_script(
				'tgt_review_script',
				'myAjax',
				array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( 'tgt_ajax-nonce' ),
				)
			);
			wp_enqueue_script( 'tgt_review_script' );
		}
	}
endif;
