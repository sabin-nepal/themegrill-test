<?php
/**
 * Content of Reviews page templates
 * @package Themegrill Test
 */
defined( 'ABSPATH' ) || exit; ?>
<div class="tgt_items">
	<div class="tgt_user_name">
		<?php the_title(); ?>
	</div>
	<div class="tgt_user_email">
		<?php echo get_the_author_meta( 'user_email' ); ?>
	</div>
	<div class="tgt_rating">
		<?php
			printf(
				/* translators: %s: rating */
				__( 'Rating: %s', 'themegrill-test' ),
				get_post_meta( get_the_ID(), '_rating', true )
			);
			?>
	</div>
	<div class="tgt_rating">
		<?php
			printf(
				/* translators: %s: review description */
				__( 'Review: %s', 'themegrill-test' ),
				wp_kses_post( get_the_content() )
			);
			?>
	</div>
</div>
