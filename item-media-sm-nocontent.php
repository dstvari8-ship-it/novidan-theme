<article id="post-<?php the_ID(); ?>" <?php post_class( 'item item-media item-sm' ); ?>>
	<?php if ( has_post_thumbnail() ): ?>
		<figure class="item-thumb">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'noozbeat_media' ); ?></a>
		</figure>
	<?php endif; ?>

	<div class="item-content">
		<?php if ( get_theme_mod( 'layout_post_date', 1 ) ): ?>
			<div class="item-meta">
				<time class="item-time" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			</div>
		<?php endif; ?>

		<?php $title = apply_filters( 'noozbeat_shorten_post_title', get_the_title(), get_the_ID(), 'media-sm-nocontent' ); ?>
		<h2 class="item-title"><a href="<?php the_permalink(); ?>"><?php echo $title; ?></a></h2>
	</div>
</article>
