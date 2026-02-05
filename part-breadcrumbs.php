<?php if ( get_theme_mod( 'layout_breadcrumbs', 1 ) && ( function_exists( 'bcn_display_list' ) || function_exists( 'yoast_breadcrumb' ) ) ): ?>
	<div class="container breadcrumb-container">
		<div class="row">
			<div class="col-xs-12">
				<?php if ( function_exists( 'bcn_display_list' ) ): ?>
					<ul class="ci-breadcrumb">
						<?php bcn_display_list(); ?>
					</ul>
				<?php elseif ( function_exists( 'yoast_breadcrumb' ) ): ?>
					<?php yoast_breadcrumb( '<p class="ci-breadcrumb">', '</p>' ); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>

