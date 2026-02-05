<?php
	$title = '';
	if ( is_archive() ) {
		$title = get_the_archive_title();
	} elseif ( is_page() ) {
		$title = single_post_title( '', false );
	} elseif ( is_404() ) {
		$title = esc_html__( 'Страница није пронађена', 'noozbeat' );
	} elseif ( is_search() ) {
		$title = esc_html__( 'Резултати претраге', 'noozbeat' );
	}
?>
<?php if ( ! empty( $title ) ): ?>
	<div class="col-xs-12">
		<div class="page-title">
			<?php echo $title; ?>
		</div>
	</div>
<?php endif; ?>
