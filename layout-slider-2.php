<?php global $wp_query; ?>
<?php if ( have_posts() ): ?>
	<div class="slider">
		<?php the_post(); ?>
		<div class="slider-left">
			<?php get_template_part( 'slider', 'half' ); ?>
		</div>

		<?php if ( have_posts() ): ?>
			<div class="slider-right">
				<?php
				//
				// Checking $wp_query->current_post <= 1 while we want 2 more posts seems counter-intuitive but is correct.
				// $current_post is a zero-based counter and is only incremented by the_post() that executes AFTER our check.
				//
				?>
				<?php while ( have_posts() && $wp_query->current_post <= 1): the_post(); ?>
					<div class="slider-half">
						<?php get_template_part( 'slider', 'quarter' ); ?>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
