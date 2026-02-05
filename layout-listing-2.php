<div class="row row-equal">
	<?php while ( have_posts() ): the_post(); ?>
		<div class="col-sm-6">
			<?php get_template_part( 'item', 'default-nocontent' ); ?>
		</div>
	<?php endwhile; ?>
</div>
