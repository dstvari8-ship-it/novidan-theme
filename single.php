<?php get_header(); ?>

<div class="col-xs-12">

	<?php if ( ! get_theme_mod( 'single_header_fullwidth', 1 ) ): ?>
		<div class="row">
			<div class="col-md-8 col-sm-12 col-xs-12">
	<?php endif; ?>

	<?php while ( have_posts() ): the_post(); ?>

		<div class="entry-head <?php echo esc_attr( get_theme_mod( 'single_header_centered' ) ? 'text-center' : '' ); ?>"> <!-- add the class .text-center for a centered article header -->
			<?php if ( get_theme_mod( 'single_categories', 1 ) || get_theme_mod( 'layout_post_date', 1 ) ): ?>
				<div class="entry-meta">
					<?php if ( get_theme_mod( 'single_categories', 1 ) ): ?>
						<div class="entry-categories">
							<?php the_terms( get_the_ID(), 'category' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( get_theme_mod( 'layout_post_date', 1 ) ): ?>
						<time class="entry-time" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<h1 class="entry-title"><?php the_title(); ?></h1>

			<div class="entry-submeta">
				<?php if ( get_theme_mod( 'single_author', 1 ) ): ?>
					<span><?php esc_html_e( 'Author:', 'noozbeat' ); ?> <?php the_author_posts_link(); ?></span>
				<?php endif; ?>
				<?php if ( get_theme_mod( 'single_comments', 1 ) ): ?>
					<span><a href="<?php echo esc_url( get_comments_link() ); ?>"><?php comments_number(); ?></a></span>
				<?php endif; ?>
				<?php get_template_part( 'part-social-sharing' ); ?>
			</div>
		</div><!-- .entry-head -->

	<?php endwhile; ?>

	<?php rewind_posts(); ?>

	<?php if ( get_theme_mod( 'single_header_fullwidth', 1 ) ): ?>
		<div class="row">
			<div class="col-md-8 col-sm-12 col-xs-12">
	<?php endif; ?>

			<?php while ( have_posts() ): the_post(); ?>

				<?php global $page; ?>
				<?php if ( has_post_thumbnail() && get_theme_mod( 'single_featured', 1 ) && 1 == $page ): ?>
					<figure class="entry-thumb">
						<a class="ci-lightbox" href="<?php echo esc_url( noozbeat_get_image_src( get_post_thumbnail_id(), 'large' ) ); ?>"><?php the_post_thumbnail(); ?></a>
					</figure>
				<?php endif; ?>

				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>

					<?php
						$source_text = get_post_meta( get_the_ID(), 'noozbeat_post_source_text', true );
						$source_url  = get_post_meta( get_the_ID(), 'noozbeat_post_source_url', true );
						$via_text    = get_post_meta( get_the_ID(), 'noozbeat_post_via_text', true );
						$via_url     = get_post_meta( get_the_ID(), 'noozbeat_post_via_url', true );
					?>
					<?php if ( ! empty( $source_text ) || ! empty( $via_text ) || ( has_tag() && get_theme_mod( 'single_tags', 1 ) ) ): ?>
						<ul class="entry-fields">
							<?php if ( ! empty( $source_text ) ): ?>
								<li><span><?php esc_html_e( 'Source:', 'noozbeat' ); ?></span>
									<?php if ( ! empty( $source_url ) ): ?>
										<a href="<?php echo esc_url( $source_url ); ?>"><?php echo esc_html( $source_text ); ?></a>
									<?php else: ?>
										<?php echo esc_html( $source_text ); ?>
									<?php endif; ?>
								</li>
							<?php endif; ?>

							<?php if ( ! empty( $via_text ) ): ?>
								<li><span><?php esc_html_e( 'Via:', 'noozbeat' ); ?></span>
									<?php if ( ! empty( $via_url ) ): ?>
										<a href="<?php echo esc_url( $via_url ); ?>"><?php echo esc_html( $via_text ); ?></a>
									<?php else: ?>
										<?php echo esc_html( $via_text ); ?>
									<?php endif; ?>
								</li>
							<?php endif; ?>

							<?php if ( get_theme_mod( 'single_tags', 1 ) ) {
								the_tags( '<li><span>' . esc_html__( 'Tags:', 'noozbeat' ) . '</span> ', ', ', '</li>' );
							} ?>
						</ul>
					<?php endif; ?>
				</div><!-- .entry-content -->

				<?php get_template_part( 'part-review' ); ?>

				<?php if ( get_theme_mod( 'single_prevnext_post', 1 ) ) {
					get_template_part( 'part-navigation' );
				} ?>

				<?php if ( get_theme_mod( 'single_authorbox', 1 ) ) {
					get_template_part( 'part-authorbox' );
				} ?>

				<?php if ( get_theme_mod( 'single_related', 1 ) ) {
					get_template_part( 'part-related' );
				} ?>

				<?php comments_template(); ?>

			<?php endwhile; ?>

		</div><!-- .col-md-8 .col-sm-12 .col-xs-12 -->

		<div class="col-md-4 col-sm-12 col-xs-12">
			<?php get_sidebar('single'); ?>
		</div>
	</div><!-- .row -->

</div><!-- .col-xs-12 -->

<?php get_footer(); ?>
