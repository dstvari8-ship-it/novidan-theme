<?php get_header(); ?>

<div class="col-md-8 col-sm-12 col-xs-12">
	<section class="section-category">
		<?php
			$layout = '';
			$layout = get_term_meta( get_queried_object_id(), 'layout', true );
			$layout = ! empty( $layout ) ? $layout : get_theme_mod( 'layout_tag' );
			get_template_part( 'layout-listing', $layout );
		?>
	</section>

	<?php noozbeat_pagination(); ?>
</div>

<div class="col-md-4 col-sm-12 col-xs-12">
	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
