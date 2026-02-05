<article class="item item-lg item-inset item-full" style="background-image: url(<?php echo esc_url( noozbeat_get_image_src( get_post_thumbnail_id(), 'noozbeat_featured' ) ); ?>);">
	<div class="item-content">
		<?php if ( get_theme_mod( 'single_categories', 1 ) || get_theme_mod( 'layout_post_date', 1 ) ): ?>
			<div class="item-meta">
				<?php if ( get_theme_mod( 'single_categories', 1 ) ): ?>
					<div class="item-categories"><?php the_terms( get_the_ID(), 'category' ); ?></div>
				<?php endif; ?>
				<?php if ( get_theme_mod( 'layout_post_date', 1 ) ): ?>
					<time class="item-time" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<h2 class="item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	</div>
</article>
