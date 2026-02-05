<?php
	$columns = get_theme_mod( 'single_related_columns', 2 );
	$count   = apply_filters( 'noozbeat_single_related_count', $columns );
	$related = noozbeat_get_related_posts( get_the_ID(), $count );
?>
<?php if ( $related->have_posts() ): ?>
	<div class="entry-related">
		<?php if ( get_theme_mod( 'single_related_title', __( 'Прочитајте још', 'noozbeat' ) ) ): ?>
			<h3 class="section-title"><?php echo esc_html( get_theme_mod( 'single_related_title', __( 'Прочитајте још', 'noozbeat' ) ) ); ?></h3>
		<?php endif; ?>

		<div class="row">
			<?php while ( $related->have_posts() ): $related->the_post(); ?>
				<div class="<?php echo esc_attr( noozbeat_get_columns_classes( $columns ) ); ?>">
					<?php get_template_part( 'item', 'default-nocontent' ); ?>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div><!-- .entry-related -->
<?php endif; ?>
