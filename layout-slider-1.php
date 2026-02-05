<?php if ( have_posts() ): the_post(); ?>
	<div class="slider">
		<?php get_template_part( 'slider', 'fullwidth' ); ?>
	</div>
<?php endif; ?>