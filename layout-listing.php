<?php /* This is the same as layout-listing-3.php */ ?>
<?php while ( have_posts() ): the_post(); ?>
	<?php get_template_part( 'item', 'media' ); ?>
<?php endwhile; ?>