<?php if ( have_posts() ): ?>
	<div class="slider">
		<?php the_post(); ?>
		<div class="slider-left">
			<?php get_template_part( 'slider', 'half' ); ?>
		</div>

		<?php if ( have_posts() ): ?>
			<div class="slider-right">
				<?php the_post(); ?>
				<div class="slider-half">
					<?php get_template_part( 'slider', 'quarter' ); ?>
				</div>

				<?php if ( have_posts() ): ?>
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
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
