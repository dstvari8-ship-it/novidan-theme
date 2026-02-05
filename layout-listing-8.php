<?php global $wp_query; ?>
<?php if ( have_posts() ): the_post(); ?>
	<?php get_template_part( 'item', 'lg-inset' ); ?>
<?php endif; ?>

<?php if ( $wp_query->post_count > 1 ): ?>
	<div class="row row-equal">
		<?php while ( have_posts() ): the_post(); ?>
			<div class="col-sm-6">
				<?php get_template_part( 'item', 'media-sm-nocontent' ); ?>
			</div>
		<?php endwhile; ?>
	</div>
<?php endif; ?>
