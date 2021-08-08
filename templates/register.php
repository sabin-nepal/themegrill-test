<?php
/**
 * Register page templates
 * use [tgt_register] shortcode to display this template page in a theme
 * @package Themegrill Test
 */
defined( 'ABSPATH' ) || exit; ?>
<form method="post">
	<div class="tgt-form-group">
		<div class="tgt-form-control">
			<label for="first_name"><?php esc_html_e( 'First Name', 'themegrill-test' ); ?></label>
			<input type="text" name="first_name" id="first_name" class="tgt-input">
		</div>
		<div class="tgt-form-control">
			<label for="last_name"><?php esc_html_e( 'Last Name', 'themegrill-test' ); ?></label>
			<input type="text" name="last_name" id="last_name" class="tgt-input">
		</div>
		<div class="tgt-form-control">
			<label for="email"><?php esc_html_e( 'Email', 'themegrill-test' ); ?></label>
			<input type="email" name="email" id="email" class="tgt-input">
		</div>
		<div class="tgt-form-control">
			<label for="password"><?php esc_html_e( 'Password', 'themegrill-test' ); ?></label>
			<input type="password" name="password" id="password" class="tgt-input">
		</div>
		<div class="tgt-form-control">
			<label for="review_details"><?php esc_html_e( 'Review Details', 'themegrill-test' ); ?></label>
			<textarea rows="5" cols="10" name="review_details" id="review_details" class="tgt-input details-input"></textarea>
		</div>
		<div class="tgt-form-control">
			<input type="range" min="1" max="5" step="1" name="review" data-orientation="vertical" >
		</div>
		<div class="tgt-form-control">
			<?php wp_nonce_field( 'tgt-register', 'tgt-register-nonce' ); ?>
			<input type="submit" name="submit" id="register" class="tgt-button">
		</div>
	</div>
</form>
