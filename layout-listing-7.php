<div class="row">
	<?php global $wp_query; ?>
	<?php
	//
	// Checking $wp_query->current_post <= 0 while we want 2 posts seems counter-intuitive but is correct.
	// $current_post is a zero-based counter and is only incremented by the_post() that executes AFTER our check.
	//
	?>
	<?php while ( have_posts() && $wp_query->current_post <= 0 ): the_post(); ?>
		<div class="col-sm-6">
			<?php get_template_part( 'item', 'default' ); ?>
		</div>
	<?php endwhile; ?>
</div>

<?php if ( $wp_query->post_count > 2 ): ?>
	<div class="row row-equal">
		<?php while ( have_posts() ): the_post(); ?>
			<div class="col-sm-6">
				<?php get_template_part( 'item', 'media-sm-nocontent' ); ?>
			</div>
		<?php endwhile; ?>
	</div>
<?php endif; ?>
