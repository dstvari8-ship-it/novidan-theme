<div class="sidebar">
	<?php
		if( is_page_template( 'template-frontpage.php' ) ) {
			dynamic_sidebar( 'blog' );
		} elseif ( is_page() ) {
			dynamic_sidebar( 'page' );
		} else {
			dynamic_sidebar( 'blog' );
		}
	?>
</div>
