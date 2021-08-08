<?php
/**
 * Reviews page templates
 * use [tgt_reviews] shortcode to display this template page in a theme
 * @package Themegrill Test
 */
defined( 'ABSPATH' ) || exit;
$args  = array(
	'post_type'      => 'tgt_review',
	'posts_per_page' => 5,
	'paged'          => 1,
	'order'          => 'ASC',
);
$query = new WP_Query( $args ); ?>

<div class="tgt_reviews">
	<div class="tgt_order">
		<select class="tgt_order_select" id="tgt-order">
			<option value="0"><?php esc_html_e( 'Default', 'themegrill-test' ); ?></option>
			<?php
			for ( $i = 1; $i <= 5; $i++ ) {
				echo '<option value="' . $i . '">' . $i . ' ' . __( 'Rating', 'themegrill-test' ) . '</option>';
			}
			?>
		</select>
		<input type="checkbox" name="latest" id="latest">Latest
	</div>
	<div class="tgt_reviews_loop" id="tgt-loop">
		<?php
		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) :
				$query->the_post();
				tgt_loop_content();
			endwhile;
		endif;
		?>
	</div>
	<div id="paginationAjax">
		<?php
		$total_page = $query->max_num_pages;
		if ( $total_page > 1 ) {
			for ( $i = 1; $i <= $total_page; $i++ ) {
				echo '<li><a name="page" href="#" class="pagination" value="' . $i . '">' . $i . '</a></li>';
			}
		}
		wp_reset_query();
		?>
	</div>
</div>
