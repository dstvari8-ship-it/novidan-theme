<?php get_header(); ?>

<div class="col-md-8 col-sm-12 col-xs-12">
	<section class="section-category">
		<?php
			global $wp_query;

			$found = $wp_query->found_posts;
			$none  = esc_html__( 'Нема резултата. Молимо проширите своје појмове и претражите поново.', 'noozbeat' );
			$one   = esc_html__( 'Пронађен је само један резултат. Mожда бисте желели да проширити своје појмове и да поново претражите.', 'noozbeat' );
			$many  = esc_html( sprintf( _n( '%d Резултат претраге.', '%d Резултат претраге.', $found, 'noozbeat' ), $found ) );
		?>
		<div class="entry-content">
			<p><?php noozbeat_e_inflect( $found, $none, $one, $many ); ?></p>
			<?php if ( $found < 2 ) {
				get_search_form();
			} ?>
		</div><!-- .entry-content -->

		<?php
			$layout = get_theme_mod( 'layout_blog' );
			get_template_part( 'layout-listing', $layout );
		?>
	</section>

	<?php noozbeat_pagination(); ?>
</div>

<div class="col-md-4 col-sm-12 col-xs-12">
	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
