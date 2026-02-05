<?php global $wp_query; ?>
<?php if ( have_posts() ): ?>
	<div class="slider">
		<?php the_post(); ?>
		<div class="slider-left">
			<?php get_template_part( 'slider', 'half' ); ?>
		</div>

		<?php if ( have_posts() ): ?>
			<div class="slider-right">
				<div class="slider-half">
					<?php the_post(); ?>
					<div class="slider-left">
						<?php get_template_part( 'slider', 'eighth' ); ?>
					</div>

					<?php if ( have_posts() ): ?>
						<?php the_post(); ?>
						<div class="slider-right">
							<?php get_template_part( 'slider', 'eighth' ); ?>
						</div>
					<?php endif; ?>
				</div>

				<?php
				//
				// This $wp_query->current_post != -1 check is needed for cases when only 2 posts exist.
				// Due to the way have_posts() operates, the query rewinds and the same (first) post gets displayed again.
				//
				?>
				<?php if ( have_posts() && $wp_query->current_post != -1 ): ?>
					<?php the_post(); ?>
					<div class="slider-half">
						<?php get_template_part( 'slider', 'quarter' ); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
