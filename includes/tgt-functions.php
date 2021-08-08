<?php
/**
 * The file that defines hooks  for themegrilltest
 *
 * @package Themegrill Test
 */


add_filter( 'tgt_user_name', 'tgt_create_user_name' );
add_action( 'tgt_send_welcome_mail', 'tgt_send_email' );

// function to fetch username from email.
function tgt_create_user_name( $email ) {
	$username = strstr( $email, '@', true );
	return $username;
}

//function to send welcome email to currently registered user.
function tgt_send_email( $userdata = array() ) {
	$to       = $userdata['user_email'];
	$subject  = 'Registration Successfull';
	$from     = sanitize_email( get_option( 'admin_email' ) );
	$headers  = "From: $from";
	$message  = 'Welcome to ' . get_option( 'blogname' );
	$message .= 'You have been registered as ' . $userdata['user_login'];
	wp_mail( $to, $subject, $message, $headers );
}

function tgt_rating_filters() {
	// Check for nonce security
	if ( ! wp_verify_nonce( $_POST['nonce'], 'tgt_ajax-nonce' ) ) {
		die( 'Busted!' );
	}
	$data   = intval( $_POST['rating'] );
	$latest = rest_sanitize_boolean( $_POST['latest'] );
	$order  = $latest ? 'DESC' : 'ASC';
	$args   = array(
		'post_type'      => 'tgt_review',
		'posts_per_page' => 5,
		'order'          => $order,
	);
	if ( $data && '' !== 0 ) {
		$args['meta_query'] = array(
			array(
				'key'     => '_rating',
				'value'   => $data,
				'compare' => '==',
			),
		);
	}
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) :
		while ( $query->have_posts() ) :
			$query->the_post();
			tgt_loop_content();
		endwhile;
	else :
		esc_html_e( 'No rating Found', 'themegrill-test' );
	endif;
	wp_die();
}
// hook to fire when user are logged in
add_action( 'wp_ajax_tgt_rating_filter', 'tgt_rating_filters' );
add_action( 'wp_ajax_tgt_pagination', 'tgt_paginations' );

function tgt_paginations() {
	// Check for nonce security
	if ( ! wp_verify_nonce( $_POST['nonce'], 'tgt_ajax-nonce' ) ) {
		die( 'Busted!' );
	}
	//$data = intval( $_POST['rating'] );
	$page  = intval( $_POST['page'] );
	$args  = array(
		'post_type'      => 'tgt_review',
		'posts_per_page' => 5,
		'paged'          => $page,
	);
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) :
		while ( $query->have_posts() ) :
			$query->the_post();
			tgt_loop_content();
		endwhile;
	else :
		esc_html_e( 'No page Found', 'themegrill-test' );
	endif;
	wp_die();
}


function tgt_loop_content() {
	$html  = '<div class="tgt-items">';
	$html .= '<div class="tgt_user_name">';
	$html .= get_the_title();
	$html .= '</div>';
	$html .= '<div class="tgt_user_email">' . get_the_author_meta( 'user_email' ) . '</div>';
	$html .= '<div class="tgt_rating">' . __( 'Rating', 'themegrill-test' ) . ':' . get_post_meta( get_the_ID(), '_rating', true ) . '</div>';
	$html .= '<div class="tgt_rating">' . __( 'Review', 'themegrill-test' ) . ':' . wp_kses_post( get_the_content() ) . '</div>';
	$html .= '</div>';
	echo $html;
}
