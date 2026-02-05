<article id="post-<?php the_ID(); ?>" <?php post_class( 'item item-media item-xs' ); ?>>
	<?php if ( has_post_thumbnail() ): ?>
		<figure class="item-thumb">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'noozbeat_square' ); ?></a>
		</figure>
	<?php endif; ?>

	<div class="item-content">
		<?php if ( get_theme_mod( 'layout_post_date', 1 ) ): ?>
			<div class="item-meta">
				<time class="item-time" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			</div>
		<?php endif; ?>

		<?php $title = apply_filters( 'noozbeat_shorten_post_title', get_the_title(), get_the_ID(), 'media-xs' ); ?>
		<h2 class="item-title"><a href="<?php the_permalink(); ?>"><?php echo $title; ?></a></h2>


		<?php $excerpt = apply_filters( 'noozbeat_shorten_post_excerpt', get_the_excerpt(), get_the_ID(), 'media-xs' ); ?>
		<div class="item-excerpt">
			<?php echo $excerpt; ?>
		</div>
	</div>
</article>
