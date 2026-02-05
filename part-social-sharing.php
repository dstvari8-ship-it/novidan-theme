<?php if ( in_the_loop() ): ?>
	<span class="entry-share"><?php esc_html_e( 'Share:', 'noozbeat' ); ?>
		<?php
			$thumb_id = get_post_thumbnail_id();

			$facebook = add_query_arg( array(
				'u' => get_permalink(),
			), 'https://www.facebook.com/sharer.php' );

			$twitter = add_query_arg( array(
				'url' => get_permalink(),
			), 'https://twitter.com/share' );

			$pinterest = add_query_arg( array(
				'url'         => get_permalink(),
				'description' => get_the_title(),
				'media'       => noozbeat_get_image_src( get_post_thumbnail_id(), 'large' ),
			), 'https://pinterest.com/pin/create/bookmarklet/' );
		?>
		<a target="_blank" class="icon-social" href="<?php echo esc_url( $facebook ); ?>"><i class="fa fa-facebook"></i></a>
		<a target="_blank" class="icon-social" href="<?php echo esc_url( $twitter ); ?>"><i class="fa fa-twitter"></i></a>
		<?php if ( ! empty( $thumb_id ) ): ?>
			<a target="_blank" class="icon-social" href="<?php echo esc_url( $pinterest ); ?>"><i class="fa fa-pinterest"></i></a>
		<?php endif; ?>
	</span>
<?php endif; ?>
