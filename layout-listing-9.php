<?php global $wp_query; ?>
<?php while ( have_posts() ): the_post(); ?>
	<?php if ( $wp_query->current_post == 0 ): ?>
		<?php get_template_part( 'item', 'lg-inset' ); ?>
	<?php else: ?>
		<?php get_template_part( 'item', 'media-sm' ); ?>
	<?php endif; ?>
<?php endwhile; ?>
