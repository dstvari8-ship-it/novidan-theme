<?php
/*
 * Template Name: Homepage Template
 */
?>
<?php get_header(); ?>

<?php
	$q = new WP_Query( array(
		'post_type'  => 'post',
		'meta_query' => array(
			array(
				'key'   => 'noozbeat_in_front',
				'value' => 1
			),
		),
	) );
?>
<?php if ( $q->have_posts() ): ?>
	<div class="col-xs-12">
		<?php
			global $wp_query;
			$old_wp_query = $wp_query;
			$wp_query = $q;
			get_template_part( 'layout-slider', get_theme_mod( 'frontpage_slider_layout', 1 ) );
			$wp_query = $old_wp_query;
		?>
	</div>
<?php endif; ?>

<div class="col-md-8 col-sm-12 col-xs-12">
	<?php dynamic_sidebar( 'frontpage' ); ?>
</div>

<div class="col-md-4 col-sm-12 col-xs-12">
	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>