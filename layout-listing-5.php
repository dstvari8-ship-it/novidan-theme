<?php
//
// This layout supports a maximum 4 posts.
//
?>
<div class="row">
	<div class="col-sm-6">
		<?php global $wp_query; ?>
		<?php if ( have_posts() ): ?>
			<?php the_post(); ?>
			<?php get_template_part( 'item', 'default' ); ?>
			</div><div class="col-sm-6">
		<?php endif; ?>

		<?php
		//
		// Checking $wp_query->current_post <= 2 while we want 3 more posts seems counter-intuitive but is correct.
		// $current_post is a zero-based counter and is only incremented by the_post() that executes AFTER our check.
		//
		?>
		<?php while ( have_posts() && $wp_query->current_post <= 2 ): the_post(); ?>
			<?php get_template_part( 'item', 'media-sm-nocontent' ); ?>
		<?php endwhile; ?>
	</div>
</div>
