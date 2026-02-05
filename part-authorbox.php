<div class="entry-author-box">
	<div class="entry-author-avatar">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 100, 'avatar_default', esc_attr( get_the_author_meta( 'display_name' ) ), array( 'extra_attr' => 'itemprop="image"' ) ); ?>
	</div>

	<div class="entry-author-info">
		<p class="entry-author-name">
			<?php the_author(); ?>
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
				<?php esc_html_e( 'View all posts', 'noozbeat' ); ?>
			</a>
		</p>

		<?php if ( get_the_author_meta( 'description' ) ): ?>
			<div class="entry-author-bio">
				<?php echo wp_kses( get_the_author_meta( 'description' ), noozbeat_get_allowed_tags() ); ?>
			</div>
		<?php endif; ?>

		<div class="entry-author-socials">
			<?php get_template_part( 'part-social-icons' ); ?>
		</div>
	</div>
</div>
