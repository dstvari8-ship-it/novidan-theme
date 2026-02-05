<?php while ( have_posts() ): the_post(); ?>
	<?php get_template_part( 'item', 'lg' ); ?>
<?php endwhile; ?>
