<div class="entry-navigation">
	<?php
		$in_same_term = false;
		if ( get_theme_mod( 'single_navigation_same_term', '' ) ) {
			$in_same_term = true;
		}

		$prev_post = get_previous_post( $in_same_term );
		$next_post = get_next_post( $in_same_term );
	?>
	<?php if ( ! empty( $next_post ) ): ?>
		<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="entry-prev">
			<span><i class="fa fa-angle-left"></i> <?php esc_html_e( 'Претходна вест', 'noozbeat' ); ?></span>
			<p class="entry-navigation-title"><?php echo get_the_title( $next_post ); ?></p>
		</a>
	<?php else: ?>
		<span class="entry-prev">&nbsp;</span>
	<?php endif; ?>

	<?php if ( ! empty( $prev_post ) ): ?>
		<a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="entry-next">
			<span><?php esc_html_e( 'Следећа вест', 'noozbeat' ); ?> <i class="fa fa-angle-right"></i></span>
			<p class="entry-navigation-title"><?php echo get_the_title( $prev_post ); ?></p>
		</a>
	<?php else: ?>
		<span class="entry-next">&nbsp;</span>
	<?php endif; ?>
</div><!-- .entry-navigation -->
