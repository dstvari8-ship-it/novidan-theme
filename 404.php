<?php get_header(); ?>

<div class="col-xs-12">

	<div class="row">
		<div class="col-md-8 col-sm-12 col-xs-12">
			<div class="entry-content">
				<p><?php esc_html_e( 'The page you were looking for can not be found! Perhaps try searching?', 'noozbeat' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .entry-content -->
		</div><!-- .col-md-8 .col-sm-12 .col-xs-12 -->

		<div class="col-md-4 col-sm-12 col-xs-12">
			<?php get_sidebar(); ?>
		</div>
	</div><!-- .row -->

</div><!-- .col-xs-12 -->

<?php get_footer(); ?>
