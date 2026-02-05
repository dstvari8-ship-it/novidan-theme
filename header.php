<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <meta name="google-site-verification" content="D0hpYPcYzyb2Uml4cqWQWBCRXo0143VBnRuubyvQ8SM" />
	<?php wp_head(); ?>
	<link rel="preload" as="image" href="https://novidan.rs/wp-content/uploads/2025/02/img_264931-18-400x250.webp" type="image/webp">

</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page">

<header class="header">
	<?php if ( get_theme_mod( 'header_bar_show', 1 ) ): ?>
		<div class="pre-head">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-sm-5">
						<?php if ( get_theme_mod( 'header_bar_socials', 1 ) ) {
							get_template_part( 'part-social-icons' );
						} ?>
					</div>

					<div class="col-md-8 col-sm-7 text-right">
						<?php if ( get_theme_mod( 'header_bar_navigation', 1 ) ): ?>
							<?php wp_nav_menu( array(
								'theme_location' => 'top_menu',
								'container'      => '',
								'menu_id'        => '',
								'menu_class'     => 'nav-pre-head list-inline',
								'fallback_cb'    => '',
								'depth'          => 1,
							) ); ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="mast-head">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="head-wrap">
						<div class="head-wrap-col-left">
							<div class="site-logo">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
									<?php if ( get_theme_mod( 'logo' ) ): ?>
										<img

<img

    src="<?php echo esc_url( get_theme_mod( 'logo' ) ); ?>"
    alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"/>


									<?php else: ?>
										<?php bloginfo( 'name' ); ?>
									<?php endif; ?>
								</a>

							</div>

							<?php if ( get_theme_mod( 'header_tagline', 1 ) ): ?>
								<p class="site-tagline"><?php bloginfo( 'description' ); ?></p>
							<?php endif; ?>

						</div>

						<div class="head-wrap-col-right">
							<?php dynamic_sidebar( 'ad-header' ); ?>
						</div>
					</div>

					<nav class="nav">
						<a href="#mobilemenu" class="mobile-trigger"><i class="fa fa-navicon"></i> <?php esc_html_e( 'МЕНИ', 'noozbeat' ); ?></a>

						<?php wp_nav_Menu( array(
							'theme_location' => 'main_menu',
							'container'      => '',
							'menu_id'        => '',
							'menu_class'     => 'navigation'
						) ); ?>

						<?php get_template_part( 'searchform-header' ); ?>
					</nav><!-- #nav -->

					<div id="mobilemenu"></div>
				</div>
			</div>
		</div>
	</div>
</header>


<?php if ( ! is_page_template( 'template-builder.php' ) ) { ?>

  <?php if ( ! is_front_page() ) {
  	get_template_part( 'part-breadcrumbs' );
  } ?>
  
  <main class="main">
  	<div class="container">
  		<div class="row">
  
  			<?php if ( ! is_front_page() ) {
  				get_template_part( 'part-page-title' );
  			} ?>
  
<?php } ?>




