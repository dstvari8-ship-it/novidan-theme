<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="searchform" method="get" role="search">
	<div>
		<label class="screen-reader-text"><?php esc_html_e( 'Search for:', 'noozbeat' ); ?></label>
		<input type="text" placeholder="<?php echo esc_attr_x( 'Претрага', 'search box placeholder', 'noozbeat' ); ?>" name="s" value="<?php echo get_search_query(); ?>">
		<a class="btn searchsubmit"><i class="fa fa-search"></i></a>
	</div>
</form>
