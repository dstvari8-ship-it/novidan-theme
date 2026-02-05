<?php
/*
 * Template Name: Fullwidth Page
 */
?>

<?php get_header(); ?>

<?php while ( have_posts() ): the_post(); ?>
	<div class="col-xs-12">

		<?php global $page; ?>
		<?php if ( has_post_thumbnail() && 1 == $page ): ?>
			<figure class="entry-thumb">
				<a class="ci-lightbox"
				   href="<?php echo esc_url( noozbeat_get_image_src( get_post_thumbnail_id(), 'large' ) ); ?>"><?php the_post_thumbnail( 'noozbeat_featured' ); ?></a>
			</figure>
		<?php endif; ?>

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div><!-- .entry-content -->

		<?php comments_template(); ?>

	</div><!-- .col-xs-12 -->
<?php endwhile; ?>

<?php get_footer(); ?>
