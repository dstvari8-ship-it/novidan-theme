<?php
require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/sanitization.php';
require get_template_directory() . '/inc/functions.php';
require get_template_directory() . '/inc/helpers-post-meta.php';
require get_template_directory() . '/inc/custom-fields-post.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/customizer-styles.php';
require get_template_directory() . '/inc/user-meta.php';
require get_template_directory() . '/inc/term-meta.php';

/**
 * Common theme features.
 */
require_once get_theme_file_path( '/common/common.php' );

add_action( 'after_setup_theme', 'noozbeat_content_width', 0 );
function noozbeat_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'noozbeat_content_width', 750 );
}

add_action( 'after_setup_theme', 'noozbeat_setup' );
if( !function_exists( 'noozbeat_setup' ) ) :
function noozbeat_setup() {

	if ( ! defined( 'NOOZBEAT_NAME' ) ) {
		define( 'NOOZBEAT_NAME', 'noozbeat' );
	}
	if ( ! defined( 'CI_WHITELABEL' ) ) {
		// Set the following to true, if you want to remove any user-facing CSSIgniter traces.
		define( 'CI_WHITELABEL', false );
	}

	load_theme_textdomain( 'noozbeat', get_template_directory() . '/languages' );

	/*
	 * Theme supports.
	 */
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	add_theme_support( 'custom-background' );

	/*
	 * Image sizes.
	 */
	set_post_thumbnail_size( 750, 440, true );
	add_image_size( 'noozbeat_featured', 1140, 500, true );
	add_image_size( 'noozbeat_media', 360, 245, true );
	add_image_size( 'noozbeat_square', 360, 360, true );


	/*
	 * Navigation menus.
	 */
	register_nav_menus( array(
		'main_menu' => esc_html__( 'Main Menu', 'noozbeat' ),
		'top_menu'  => esc_html__( 'Top Menu', 'noozbeat' ),
	) );



	/*
	 * Default hooks
	 */
	// Prints the inline JS scripts that are registered for printing, and removes them from the queue.
	add_action( 'admin_footer', 'noozbeat_print_inline_js' );
	add_action( 'wp_footer', 'noozbeat_print_inline_js' );

	// Handle the dismissible sample content notice.
	add_action( 'admin_notices', 'noozbeat_admin_notice_sample_content' );
	add_action( 'wp_ajax_noozbeat_dismiss_sample_content', 'noozbeat_ajax_dismiss_sample_content' );

	// Wraps post counts in span.ci-count
	// Needed for the default widgets, however more appropriate filters don't exist.
	add_filter( 'get_archives_link', 'noozbeat_wrap_archive_widget_post_counts_in_span', 10, 2 );
	add_filter( 'wp_list_categories', 'noozbeat_wrap_category_widget_post_counts_in_span', 10, 2 );
}
endif;

add_action( 'wp_enqueue_scripts', 'noozbeat_enqueue_scripts' );
function noozbeat_enqueue_scripts() {

	/*
	 * Styles
	 */
	$theme = wp_get_theme();

	$font_url = '';
	/* translators: If there are characters in your language that are not supported by Open Sans and Roboto, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans and Roboto fonts: on or off', 'noozbeat' ) ) {
		$font_url = add_query_arg( 'family', urlencode( 'Open+Sans:400,400italic,700|Roboto:400,700&subset=latin,greek,vietnamese,cyrillic' ), '//fonts.googleapis.com/css' );
	}
	wp_register_style( 'noozbeat-google-font', esc_url( $font_url ) );

	wp_register_style( 'noozbeat-base', get_template_directory_uri() . '/css/base.css', array(), $theme->get( 'Version' ) );
	wp_register_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css', array(), '2.5.0' );
	wp_register_style( 'mmenu', get_template_directory_uri() . '/css/mmenu.css', array(), '5.2.0' );
	wp_register_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.7.0' );
	wp_register_style( 'magnific-popup', get_template_directory_uri() . '/css/magnific.css', array(), '1.0.0' );

	wp_register_style( 'noozbeat-style', get_template_directory_uri() . '/style.css', array(
		'noozbeat-google-font',
		'noozbeat-base',
		'noozbeat-common',
		'flexslider',
		'mmenu',
		'font-awesome',
		'magnific-popup',
	), $theme->get( 'Version' ) );

	if ( is_child_theme() ) {
		wp_register_style( 'noozbeat-style-child', get_stylesheet_directory_uri() . '/style.css', array(
			'noozbeat-style',
		), $theme->get( 'Version' ) );
	}


	/*
	 * Scripts
	 */
	wp_register_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery' ), '1.7.5', true );
	wp_register_script( 'mmenu', get_template_directory_uri() . '/js/jquery.mmenu.min.all.js', array( 'jquery' ), '5.2.0', true );
	wp_register_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider.js', array( 'jquery' ), '2.5.0', true );
	wp_register_script( 'fitVids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.1', true );
	wp_register_script( 'magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.js', array( 'jquery' ), '1.0.0', true );
	wp_register_script( 'matchHeight', get_template_directory_uri() . '/js/jquery.matchHeight-min.js', array( 'jquery' ), '0.7.0', true );

	wp_register_script( 'noozbeat-front-scripts', get_template_directory_uri() . '/js/scripts.js', array(
		'jquery',
		'superfish',
		'mmenu',
		'flexslider',
		'fitVids',
		'magnific-popup',
		'matchHeight'
	), $theme->get( 'Version' ), true );


	/*
	 * Enqueue
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_style( 'noozbeat-style' );
	if ( is_child_theme() ) {
		wp_enqueue_style( 'noozbeat-style-child' );
	}

	wp_enqueue_script( 'noozbeat-front-scripts' );


}

add_action( 'admin_enqueue_scripts', 'noozbeat_admin_enqueue_scripts' );
function noozbeat_admin_enqueue_scripts( $hook ) {
	$theme = wp_get_theme();

	/*
	 * Styles
	 */
	wp_register_style( 'noozbeat-repeating-fields', get_template_directory_uri() . '/css/admin/repeating-fields.css', array(), $theme->get( 'Version' ) );


	/*
	 * Scripts
	 */
	wp_register_script( 'noozbeat-repeating-fields', get_template_directory_uri() . '/js/admin/repeating-fields.js', array(
		'jquery',
		'jquery-ui-sortable'
	), $theme->get( 'Version' ), true );


	/*
	 * Enqueue
	 */
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		wp_enqueue_media();
		wp_enqueue_style( 'noozbeat-post-meta' );
		wp_enqueue_script( 'noozbeat-post-meta' );

		wp_enqueue_style( 'noozbeat-repeating-fields' );
		wp_enqueue_script( 'noozbeat-repeating-fields' );
	}

}

add_action( 'widgets_init', 'noozbeat_widgets_init' );
function noozbeat_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html_x( 'Blog', 'widget area', 'noozbeat' ),
		'id'            => 'blog',
		'description'   => esc_html__( 'This is the main sidebar.', 'noozbeat' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Pages', 'widget area', 'noozbeat' ),
		'id'            => 'page',
		'description'   => esc_html__( 'This sidebar appears on your static pages. If empty, the Blog sidebar will be shown instead.', 'noozbeat' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Homepage', 'widget area', 'noozbeat' ),
		'id'            => 'frontpage',
		'description'   => esc_html__( 'This widget area appears on your front page template.', 'noozbeat' ),
		'before_widget' => '<section id="%1$s" class="widget group %2$s section-category">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="section-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Footer left', 'widget area', 'noozbeat' ),
		'id'            => 'footer-left',
		'description'   => esc_html__( 'Footer widgets - Left column.', 'noozbeat' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Footer middle', 'widget area', 'noozbeat' ),
		'id'            => 'footer-middle',
		'description'   => esc_html__( 'Footer widgets - Middle column.', 'noozbeat' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Footer right', 'widget area', 'noozbeat' ),
		'id'            => 'footer-right',
		'description'   => esc_html__( 'Footer widgets - Right column.', 'noozbeat' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Ad - Header', 'widget area', 'noozbeat' ),
		'id'            => 'ad-header',
		'description'   => esc_html__( 'Advertisement area in the header. Use this area only for your banners.', 'noozbeat' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<span class="screen-reader-text">',
		'after_title'   => '</span>',
	) );

}

add_action( 'widgets_init', 'noozbeat_load_widgets' );
function noozbeat_load_widgets() {
	require get_template_directory() . '/inc/widgets/content.php';
	require get_template_directory() . '/inc/widgets/latest-posts.php';
	require get_template_directory() . '/inc/widgets/socials.php';
}


add_filter( 'excerpt_length', 'noozbeat_excerpt_length' );
function noozbeat_excerpt_length( $length ) {
	return get_theme_mod( 'excerpt_length', 55 );
}

add_filter( 'the_content', 'noozbeat_lightbox_rel', 12 );
add_filter( 'get_comment_text', 'noozbeat_lightbox_rel' );
add_filter( 'wp_get_attachment_link', 'noozbeat_lightbox_rel' );
if ( ! function_exists( 'noozbeat_lightbox_rel' ) ):
function noozbeat_lightbox_rel( $content ) {
	global $post;
	$attr = 'data-lightbox="gal[' . esc_attr( $post->ID ) . ']"';

	$matched = preg_match( '/<a.*?' . preg_quote( $attr ) . '.*?>.*<\/a>/i', $content, $matches );
	if ( ! $matched ) {
		$pattern     = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
		$replacement = '<a$1href=$2$3.$4$5 ' . $attr . '$6>$7</a>';
		$content     = preg_replace( $pattern, $replacement, $content );
	}

	return $content;
}
endif;


add_filter( 'wp_link_pages_args', 'noozbeat_wp_link_pages_args' );
function noozbeat_wp_link_pages_args( $params ) {
	$params = array_merge( $params, array(
		'before'         => '<div class="page-links">',
		'after'          => '</div>',
		'next_or_number' => 'next',
	) );

	return $params;
}

add_filter( 'wp_link_pages_link', 'noozbeat_wp_link_pages_link', 10, 2 );
function noozbeat_wp_link_pages_link( $link, $next ) {
	global $page;
	if ( $page < $next ) {
		preg_match( '#<a (.*?)>(.*)</a>#', $link, $matches );
		$link = '<a class="page-next" ' . $matches[1] . '>' . $matches[2] . '<i class="fa fa-angle-right"></i></a>';
	} elseif ( $page > $next ) {
		preg_match( '#<a (.*?)>(.*)</a>#', $link, $matches );
		$link = '<a class="page-prev" ' . $matches[1] . '><i class="fa fa-angle-left"></i>' . $matches[2] . '</a>';
	}

	return $link;
}


add_action( 'wp_head', 'noozbeat_print_google_analytics_tracking' );
if ( ! function_exists( 'noozbeat_print_google_analytics_tracking' ) ):
function noozbeat_print_google_analytics_tracking() {
	if ( is_admin() || ! get_theme_mod( 'google_anaytics_tracking_id' ) ) {
		return;
	}
	?>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', '<?php echo get_theme_mod( 'google_anaytics_tracking_id' ); ?>', 'auto');
		ga('send', 'pageview');
	</script>
	<?php
}
endif;


add_filter( 'get_archives_link', 'noozbeat_remove_archive_widget_nbsp', 15 );
function noozbeat_remove_archive_widget_nbsp( $output ) {
	$output = str_replace( '&nbsp;<span class="ci-count">', '<span class="ci-count">', $output );

	return $output;
}


if ( ! function_exists( 'noozbeat_get_social_networks' ) ):
function noozbeat_get_social_networks() {
	return array(
		array(
			'name'  => 'facebook',
			'label' => esc_html__( 'Facebook', 'noozbeat' ),
			'icon'  => 'fa-facebook',
		),
		array(
			'name'  => 'twitter',
			'label' => esc_html__( 'Twitter', 'noozbeat' ),
			'icon'  => 'fa-twitter',
		),
		array(
			'name'  => 'pinterest',
			'label' => esc_html__( 'Pinterest', 'noozbeat' ),
			'icon'  => 'fa-pinterest',
		),
		array(
			'name'  => 'instagram',
			'label' => esc_html__( 'Instagram', 'noozbeat' ),
			'icon'  => 'fa-instagram',
		),
		array(
			'name'  => 'linkedin',
			'label' => esc_html__( 'LinkedIn', 'noozbeat' ),
			'icon'  => 'fa-linkedin',
		),
		array(
			'name'  => 'tumblr',
			'label' => esc_html__( 'Tumblr', 'noozbeat' ),
			'icon'  => 'fa-tumblr',
		),
		array(
			'name'  => 'flickr',
			'label' => esc_html__( 'Flickr', 'noozbeat' ),
			'icon'  => 'fa-flickr',
		),
		array(
			'name'  => 'bloglovin',
			'label' => esc_html__( 'Bloglovin', 'noozbeat' ),
			'icon'  => 'fa-heart',
		),
		array(
			'name'  => 'youtube',
			'label' => esc_html__( 'YouTube', 'noozbeat' ),
			'icon'  => 'fa-youtube',
		),
		array(
			'name'  => 'vimeo',
			'label' => esc_html__( 'Vimeo', 'noozbeat' ),
			'icon'  => 'fa-vimeo',
		),
		array(
			'name'  => 'dribbble',
			'label' => esc_html__( 'Dribbble', 'noozbeat' ),
			'icon'  => 'fa-dribbble',
		),
		array(
			'name'  => 'wordpress',
			'label' => esc_html__( 'WordPress', 'noozbeat' ),
			'icon'  => 'fa-wordpress',
		),
		array(
			'name'  => '500px',
			'label' => esc_html__( '500px', 'noozbeat' ),
			'icon'  => 'fa-500px',
		),
		array(
			'name'  => 'soundcloud',
			'label' => esc_html__( 'Soundcloud', 'noozbeat' ),
			'icon'  => 'fa-soundcloud',
		),
		array(
			'name'  => 'spotify',
			'label' => esc_html__( 'Spotify', 'noozbeat' ),
			'icon'  => 'fa-spotify',
		),
		array(
			'name'  => 'vine',
			'label' => esc_html__( 'Vine', 'noozbeat' ),
			'icon'  => 'fa-vine',
		),
		array(
			'name'  => 'tripadvisor',
			'label' => esc_html__( 'Trip Advisor', 'noozbeat' ),
			'icon'  => 'fa-tripadvisor',
		),
		array(
			'name'  => 'telegram',
			'label' => esc_html__( 'Telegram', 'noozbeat' ),
			'icon'  => 'fa-telegram',
		),
	);
}
endif;

if ( ! function_exists( 'noozbeat_sanitize_review_score' ) ):
function noozbeat_sanitize_review_score( $value ) {
	$max_score = apply_filters( 'noozbeat_max_review_score', 10 );

	$value = floatval( $value );
	$value = $value < 0 ? 0 : $value;
	$value = $value > $max_score ? $max_score : $value;

	return $value;
}
endif;

if ( ! function_exists( 'noozbeat_get_content_widget_layout_choices' ) ):
function noozbeat_get_content_widget_layout_choices() {
	return apply_filters( 'noozbeat_content_widget_layout_choices', array(
		1  => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 1 ) ),
		2  => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 2 ) ),
		3  => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 3 ) ),
		4  => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 4 ) ),
		5  => esc_html( sprintf( __( 'Layout #%s (4 posts max)', 'noozbeat' ), 5 ) ),
		6  => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 6 ) ),
		7  => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 7 ) ),
		8  => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 8 ) ),
		9  => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 9 ) ),
		10 => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 10 ) ),
	) );
}
endif;

if ( ! function_exists( 'noozbeat_sanitize_content_widget_layout_choices' ) ):
function noozbeat_sanitize_content_widget_layout_choices( $value ) {
	$choices = noozbeat_get_content_widget_layout_choices();
	if ( array_key_exists( intval( $value ), $choices ) ) {
		return $value;
	}

	return '';
}
endif;

if ( ! function_exists( 'noozbeat_get_blog_cat_tag_layout_choices' ) ):
function noozbeat_get_blog_cat_tag_layout_choices() {
	return apply_filters( 'noozbeat_blog_cat_tag_layout_choices', array(
		1  => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 1 ) ),
		2  => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 2 ) ),
		3  => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 3 ) ),
		4  => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 4 ) ),
		10 => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 10 ) ),
	) );
}
endif;

if ( ! function_exists( 'noozbeat_sanitize_blog_cat_tag_layout_choices' ) ):
function noozbeat_sanitize_blog_cat_tag_layout_choices( $value ) {
	$choices = noozbeat_get_blog_cat_tag_layout_choices();
	if ( array_key_exists( intval( $value ), $choices ) ) {
		return $value;
	}

	return '';
}
endif;

if ( ! function_exists( 'noozbeat_get_slider_layout_choices' ) ):
function noozbeat_get_slider_layout_choices() {
	return apply_filters( 'noozbeat_slider_layout_choices', array(
		1 => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 1 ) ),
		2 => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 2 ) ),
		3 => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 3 ) ),
		4 => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 4 ) ),
		5 => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 5 ) ),
		6 => esc_html( sprintf( __( 'Layout #%s', 'noozbeat' ), 6 ) ),
	) );
}
endif;

if ( ! function_exists( 'noozbeat_sanitize_slider_layout_choices' ) ):
function noozbeat_sanitize_slider_layout_choices( $value ) {
	$choices = noozbeat_get_slider_layout_choices();
	if ( array_key_exists( intval( $value ), $choices ) ) {
		return $value;
	}

	return 1;
}
endif;


function noozbeat_get_columns_classes( $columns ) {
	switch ( intval( $columns ) ) {
		case 1:
			$classes = 'col-xs-12';
			break;
		case 2:
			$classes = 'col-sm-6 col-xs-12';
			break;
		case 3:
			$classes = 'col-md-4 col-sm-6 col-xs-12';
			break;
		case 4:
		default:
			$classes = 'col-md-3 col-sm-6 col-xs-12';
			break;
	}

	return $classes;
}


function noozbeat_get_default_footer_text() {
	if ( ! defined( 'CI_WHITELABEL' ) || ! CI_WHITELABEL ) {
		$text = sprintf( '<a href="%s">Noozbeat WordPress theme</a> by <a href="%s">CSSIgniter.com</a>',
			esc_url( 'http://www.cssigniter.com/ignite/themes/noozbeat/' ),
			esc_url( 'http://www.cssigniter.com/ignite/' )
		);
	} else {
		$text = sprintf( '<a href="%1$s">%2$s</a> &ndash; Powered by <a href="%3$s">WordPress</a>',
			esc_url( home_url( '/' ) ),
			get_bloginfo( 'name' ),
			esc_url( 'https://wordpress.org/' )
		);
	}

	return $text;
}

function noozbeat_sanitize_footer_text( $text ) {
	$allowed_html = array(
		'a'      => array(
			'href'  => array(),
			'class' => array(),
		),
		'img'    => array(
			'src'   => array(),
			'class' => array(),
		),
		'span'   => array(
			'class' => array(),
		),
		'i'      => array(
			'class' => array(),
		),
		'b'      => array(),
		'em'     => array(),
		'strong' => array(),
	);

	return wp_kses( $text, $allowed_html );
}

function noozbeat_trim_chars( $string, $length, $suffix = false ) {
	if ( false == $suffix ) {
		$suffix = esc_html__( '&hellip;', 'noozbeat' );
	}

	if ( mb_strlen( $string ) > $length ) {
		if ( is_rtl() ) {
			$string = mb_substr( $string, - absint( $length ) );
			$string = $suffix . $string;
		} else {
			$string = mb_substr( $string, 0, $length );
			$string = $string . $suffix;
		}
	}

	return $string;
}

add_filter( 'noozbeat_shorten_post_title', 'noozbeat_shorten_post_title', 10, 3 );
function noozbeat_shorten_post_title( $string, $id, $context ) {
	return noozbeat_trim_chars( $string, get_theme_mod( 'item_small_title_length', 50 ) );
}

add_filter( 'noozbeat_shorten_post_excerpt', 'noozbeat_shorten_post_excerpt', 10, 3 );
function noozbeat_shorten_post_excerpt( $string, $id, $context ) {
	return noozbeat_trim_chars( $string, 70 );
}


//
// Comment form
//
add_filter( 'comment_form_field_comment', 'noozbeat_comment_form_field_comment' );
function noozbeat_comment_form_field_comment( $field ) {
	return '<div class="row"><div class="col-xs-12">' . $field . '</div></div>';
}

add_action( 'comment_form_before_fields', 'noozbeat_comment_form_before_fields' );
function noozbeat_comment_form_before_fields() {
	echo '<div class="row">';
}

add_action( 'comment_form_after_fields', 'noozbeat_comment_form_after_fields' );
function noozbeat_comment_form_after_fields() {
	echo '</div>';
}

add_filter( 'comment_form_field_author', 'noozbeat_comment_form_field_wrap' );
add_filter( 'comment_form_field_email', 'noozbeat_comment_form_field_wrap' );
add_filter( 'comment_form_field_url', 'noozbeat_comment_form_field_wrap' );
function noozbeat_comment_form_field_wrap( $field ) {
	return '<div class="col-sm-4">' . trim( $field ) . '</div>' . "\n";
}

add_filter( 'comment_form_default_fields', 'noozbeat_comment_form_default_fields_placeholder' );
function noozbeat_comment_form_default_fields_placeholder( $fields ) {
	$new_class = 'sr-only';

	foreach ( $fields as $key => $field ) {
		preg_match( '/\<label.*?\>/', $field, $label );
		if ( ! empty( $label[0] ) ) {
			preg_match( '/class=([\'"])(.*?)(\1)/', $label[0], $label_classes );

			$new_field = '';

			if ( ! empty( $label_classes ) && isset( $label_classes[2] ) ) {
				$all_classes    = explode( ' ', $label_classes[2] . ' ' . $new_class );
				$all_classes    = array_filter( array_unique( $all_classes ) );
				$new_class_attr = sprintf( 'class="%s"', esc_attr( implode( ' ', $all_classes ) ) );
				$new_label      = str_replace( $label_classes[0], $new_class_attr, $label[0] );
				$new_field      = str_replace( $label[0], $new_label, $field );
			} else {
				$new_class_attr = sprintf( 'class="%s"', esc_attr( $new_class ) );
				$new_field = str_replace( '<label', '<label ' . $new_class_attr . ' ', $field );
			}

			preg_match( '#\<label.*?\>(.*?)\</label\>#', $new_field, $label_text );
			if( ! empty( $label_text[1] ) ) {
				$text = strip_tags( $label_text[1] );
				$new_field = str_replace( '<input', '<input placeholder="' . esc_attr( $text ) . '" ', $new_field );
			}
			$fields[ $key ] = $new_field;
		}

	}

	return $fields;
}

add_filter( 'comment_form_field_comment', 'noozbeat_comment_form_field_comment_placeholder' );
function noozbeat_comment_form_field_comment_placeholder( $field ) {
	$new_class = 'sr-only';

	preg_match( '/\<label.*?\>/', $field, $label );
	if ( ! empty( $label[0] ) ) {
		preg_match( '/class=([\'"])(.*?)(\1)/', $label[0], $label_classes );

		$new_field = '';

		if ( ! empty( $label_classes ) && isset( $label_classes[2] ) ) {
			$all_classes    = explode( ' ', $label_classes[2] . ' ' . $new_class );
			$all_classes    = array_filter( array_unique( $all_classes ) );
			$new_class_attr = sprintf( 'class="%s"', esc_attr( implode( ' ', $all_classes ) ) );
			$new_label      = str_replace( $label_classes[0], $new_class_attr, $label[0] );
			$new_field      = str_replace( $label[0], $new_label, $field );
		} else {
			$new_class_attr = sprintf( 'class="%s"', esc_attr( $new_class ) );
			$new_field = str_replace( '<label', '<label ' . $new_class_attr . ' ', $field );
		}

		preg_match( '#\<label.*?\>(.*?)\</label\>#', $new_field, $label_text );
		if( ! empty( $label_text[1] ) ) {
			$text = strip_tags( $label_text[1] );
			$new_field = str_replace( '<textarea', '<textarea placeholder="' . esc_attr( $text ) . '" ', $new_field );
		}
		$field = $new_field;
	}

	return $field;
}


//
// Inject valid GET parameters as theme_mod values
//
add_filter( 'theme_mod_single_header_fullwidth', 'noozbeat_handle_url_theme_mod_single_header_fullwidth' );
function noozbeat_handle_url_theme_mod_single_header_fullwidth( $value ) {
	if ( isset( $_GET['header_full'] ) ) {
		$value = noozbeat_sanitize_checkbox( $_GET['header_full'] );
	}

	return $value;
}

add_filter( 'theme_mod_frontpage_slider_layout', 'noozbeat_handle_url_theme_mod_frontpage_slider_layout' );
function noozbeat_handle_url_theme_mod_frontpage_slider_layout( $value ) {
	if ( isset( $_GET['slider'] ) ) {
		$value = noozbeat_sanitize_slider_layout_choices( $_GET['slider'] );
	}

	return $value;
}

/**
 * Theme Elements
 */
if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( PHP_VERSION, '5.4', '>=' ) ) {
	require_once( 'inc/elements.php' );
}

function noozbeat_post_types() {
	$post_types_available = get_post_types( array( 'public' => true ), 'objects' );
	unset( $post_types_available['attachment'] );
	if ( post_type_exists( 'elementor_library' ) ) {
		unset( $post_types_available['elementor_library'] );
	}

	$noozbeat_pt[] = '';

	foreach ( $post_types_available as $key => $pt ) {
		$noozbeat_pt[ $key ] = $pt->label;
	}

	return $noozbeat_pt;
}

add_action( 'wp_ajax_noozbeat_get_posts', 'ajax_noozbeat_posts' );
function ajax_noozbeat_posts() {

	// Verify nonce
	if ( ! isset( $_POST['noozbeat_post_nonce'] ) || ! wp_verify_nonce( $_POST['noozbeat_post_nonce'], 'noozbeat_post_nonce' ) ) {
		die( 'Permission denied' );
	}

	$post_type = $_POST['post_type'];

	$q = new WP_Query( array(
		'post_type' => $post_type,
		'posts_per_page' => -1,
	) );
	?>

	<option><?php esc_html_e( 'Select an item', 'noozbeat' ); ?></option>

	<?php while ( $q->have_posts() ) : $q->the_post(); ?>
		<option value="<?php echo esc_attr( get_the_ID() ); ?>"><?php the_title(); ?></option>
		<?php
	endwhile;
	wp_reset_postdata();
	wp_die();
}



if ( ! defined( 'NOOZBEAT_WHITELABEL' ) || false === (bool) NOOZBEAT_WHITELABEL ) {
	add_filter( 'pt-ocdi/import_files', 'noozbeat_ocdi_import_files' );
	add_action( 'pt-ocdi/after_import', 'noozbeat_ocdi_after_import_setup' );
}

add_filter( 'pt-ocdi/timeout_for_downloading_import_file', 'noozbeat_ocdi_download_timeout' );
function noozbeat_ocdi_download_timeout( $timeout ) {
	return 60;
}

function noozbeat_ocdi_import_files( $files ) {
	if ( ! defined( 'NOOZBEAT_NAME' ) ) {
		define( 'NOOZBEAT_NAME', 'noozbeat' );
	}

	$demo_dir_url = untrailingslashit( apply_filters( 'noozbeat_ocdi_demo_dir_url', 'https://www.cssigniter.com/sample_content/' . NOOZBEAT_NAME ) );

	// When having more that one predefined imports, set a preview image, preview URL, and categories for isotope-style filtering.
	$new_files = array(
		array(
			'import_file_name'           => esc_html__( 'Demo Import', 'noozbeat' ),
			'import_file_url'            => $demo_dir_url . '/content.xml',
			'import_widget_file_url'     => $demo_dir_url . '/widgets.wie',
			'import_customizer_file_url' => $demo_dir_url . '/customizer.dat',
		),
	);

	return array_merge( $files, $new_files );
}

function noozbeat_ocdi_after_import_setup() {
	// Set up nav menus.
	$main_menu = get_term_by( 'name', 'Main', 'nav_menu' );
	$top_menu  = get_term_by( 'name', 'Top', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
		'main_menu' => $main_menu->term_id,
		'top_menu'  => $top_menu->term_id,
	) );

	// Set up home and blog pages.
	$front_page_id = get_page_by_title( 'Home' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );

	// Try to force a term recount.
	// wp_defer_term_counting( false ) doesn't work properly as there are post imported from different AJAX requests.
	$taxonomies = get_taxonomies( array(), 'names' );
	foreach ( $taxonomies as $taxonomy ) {
		$terms             = get_terms( $taxonomy, array( 'hide_empty' => false ) );
		$term_taxonomy_ids = wp_list_pluck( $terms, 'term_taxonomy_id' );

		wp_update_term_count( $term_taxonomy_ids, $taxonomy );
	}
}

add_action( 'init', 'noozbeat_migrate_custom_css_to_customizer' );
function noozbeat_migrate_custom_css_to_customizer() {
	if ( ! is_admin() || wp_doing_ajax() || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ) {
		return;
	}

	$migrated = get_theme_mod( 'custom_css_migrated', false );

	if ( $migrated || ! function_exists( 'wp_update_custom_css_post' ) ) {
		return;
	}

	// Migrate any existing theme CSS to the core option added in WordPress 4.7.
	$css = get_theme_mod( 'custom_css', '' );
	if ( $css ) {
		// Preserve any CSS already added to the core option.
		$core_css = wp_get_custom_css();

		$return = wp_update_custom_css_post( $core_css .
			PHP_EOL . PHP_EOL .
			"/* Migrated CSS from the theme's old custom CSS setting. */" .
			PHP_EOL .
			html_entity_decode( $css )
		);

		if ( ! is_wp_error( $return ) ) {
			// Remove the old option, so that the CSS is stored in only one place moving forward.
			set_theme_mod( 'custom_css', '' );
			set_theme_mod( 'custom_css_migrated', true );
		}
	}
}
function prefix_category_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    }
    return $title;
}
add_filter( 'get_the_archive_title', 'prefix_category_title' );

function webp_upload_mimes( $existing_mimes ) {
	// add webp to the list of mime types
	$existing_mimes['webp'] = 'image/webp';

	// return the array back to the function with our added mime type
	return $existing_mimes;
}
add_filter( 'mime_types', 'webp_upload_mimes' );

//** * Enable preview / thumbnail for webp image files.*/
function webp_is_displayable($result, $path) {
    if ($result === false) {
        $displayable_image_types = array( IMAGETYPE_WEBP );
        $info = @getimagesize( $path );

        if (empty($info)) {
            $result = false;
        } elseif (!in_array($info[2], $displayable_image_types)) {
            $result = false;
        } else {
            $result = true;
        }
    }

    return $result;
}
add_filter('file_is_displayable_image', 'webp_is_displayable', 10, 2);
function custom_mime_types($mimes) {
    $mimes['jpg|jpeg'] = 'image/jpeg'; // Dozvoljava JPEG fajlove
    $mimes['png'] = 'image/png';       // Dozvoljava PNG fajlove
    return $mimes;
}
add_filter('upload_mimes', 'custom_mime_types');





// ✅ Ispravno učitavanje prevoda teme
add_action('after_setup_theme', function() {
    load_theme_textdomain('noozbeat', get_template_directory() . '/languages');
});

// ✅ Automatsko postavljanje naslovne slike ako ne postoji
function oznaci_naslovne_clanke_automatski($post_id) {
    if (get_post_type($post_id) == 'post' && !has_post_thumbnail($post_id)) {
        $attachments = get_attached_media('image', $post_id);
        if (!empty($attachments)) {
            $first_attachment = reset($attachments);
            set_post_thumbnail($post_id, $first_attachment->ID);
        }
    }
}
add_action('save_post', 'oznaci_naslovne_clanke_automatski');

// ✅ Automatsko dodavanje članka na početnu stranicu
function automatski_prikazi_na_pocetnoj($post_id) {
    if (get_post_type($post_id) == 'post' && get_post_status($post_id) == 'publish') {
        update_post_meta($post_id, '_show_on_front_page', '1');
    }
}
add_action('save_post', 'automatski_prikazi_na_pocetnoj');

// ✅ Automatsko označavanje članka kao istaknuti (sticky) (maks. 5 sticky postova)
function automatski_oznaci_sticky_post($post_id) {
    if (get_post_type($post_id) == 'post' && get_post_status($post_id) == 'publish') {
        $sticky_posts = get_option('sticky_posts', array());

        // Ograničavamo sticky postove na 5
        if (count($sticky_posts) >= 5) {
            array_shift($sticky_posts);
        }

        if (!in_array($post_id, $sticky_posts)) {
            $sticky_posts[] = $post_id;
            update_option('sticky_posts', $sticky_posts);
        }
    }
}
add_action('save_post', 'automatski_oznaci_sticky_post');

// ✅ Funkcija za optimizaciju svih slika (JPEG kompresija i WebP konverzija)
function optimizuj_sve_slike() {
    $args = array(
        'post_type'      => 'attachment',
        'post_mime_type' => array('image/jpeg', 'image/png'),
        'post_status'    => 'inherit',
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $attachment_id = get_the_ID();
            $file_path = get_attached_file($attachment_id);

            if (file_exists($file_path)) {
                try {
                    $mime = mime_content_type($file_path);
                    if ($mime == 'image/jpeg') {
                        $original_image = @imagecreatefromjpeg($file_path);
                        if ($original_image) {
                            imagejpeg($original_image, $file_path, 75);
                            imagedestroy($original_image);
                        }
                    } elseif ($mime == 'image/png') {
                        $original_image = @imagecreatefrompng($file_path);
                        if ($original_image && imageistruecolor($original_image)) {
                            $webp_path = str_replace('.png', '.webp', $file_path);
                            imagewebp($original_image, $webp_path, 80);
                            imagedestroy($original_image);
                        }
                    }
                } catch (Exception $e) {
                    error_log("Greška pri optimizaciji: " . $e->getMessage());
                }
            }
        }
        wp_reset_postdata();
    }

    // Preusmeravanje nakon optimizacije
    if (!wp_doing_ajax()) {
        wp_redirect(admin_url());
        exit;
    }
}

// ✅ Ručno pokretanje optimizacije putem URL-a: `?optimizuj_slike=1`
if (isset($_GET['optimizuj_slike'])) {
    optimizuj_sve_slike();
}





function convert_png_to_webp($image_path) {
    $image = imagecreatefrompng($image_path);
    if ($image) {
        $webp_path = str_replace('.png', '.webp', $image_path);
        imagewebp($image, $webp_path, 80);
        imagedestroy($image);
        return $webp_path;
    }
    return $image_path;
}





function convert_images_to_webp($attachment_id) {
    $file_path = get_attached_file($attachment_id);
    $info = pathinfo($file_path);

    if ($info['extension'] === 'jpg' || $info['extension'] === 'jpeg' || $info['extension'] === 'png') {
        $webp_path = $info['dirname'] . '/' . $info['filename'] . '.webp';
        if (!file_exists($webp_path)) {
            if ($info['extension'] === 'jpg' || $info['extension'] === 'jpeg') {
                $image = imagecreatefromjpeg($file_path);
            } elseif ($info['extension'] === 'png') {
                $image = imagecreatefrompng($file_path);
            }
            imagewebp($image, $webp_path, 80); // 80% kvaliteta
            imagedestroy($image);
        }
    }
}
add_action('add_attachment', 'convert_images_to_webp');





add_filter('wp_get_attachment_image_attributes', function($attr) {
    $attr['loading'] = 'lazy';
    return $attr;
});







function preload_lcp_image() {
    echo '<link rel="preload" as="image" href="https://novidan.rs/wp-content/uploads/2025/02/img_26.webp" type="image/webp">';
}
add_action('wp_head', 'preload_lcp_image');







function konvertuj_slike_u_webp() {
    $args = array(
        'post_type'      => 'attachment',
        'post_mime_type' => array('image/jpeg', 'image/png'),
        'post_status'    => 'inherit',
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $attachment_id = get_the_ID();
            $file_path = get_attached_file($attachment_id);

            if (file_exists($file_path)) {
                $webp_path = str_replace(array('.jpg', '.jpeg', '.png'), '.webp', $file_path);

                if (!file_exists($webp_path)) {
                    try {
                        $mime_type = mime_content_type($file_path);
                        if ($mime_type == 'image/jpeg') {
                            $image = imagecreatefromjpeg($file_path);
                            imagewebp($image, $webp_path, 80);
                            imagedestroy($image);
                        } elseif ($mime_type == 'image/png') {
                            $image = imagecreatefrompng($file_path);
                            imagewebp($image, $webp_path, 80);
                            imagedestroy($image);
                        }
                        
                        // Dodaj WebP fajl u WP medija biblioteku
                        $wp_filetype = wp_check_filetype($webp_path, null);
                        $attachment = array(
                            'post_mime_type' => $wp_filetype['type'],
                            'post_title'     => get_the_title($attachment_id) . ' - WebP',
                            'post_content'   => '',
                            'post_status'    => 'inherit'
                        );
                        $attach_id = wp_insert_attachment($attachment, $webp_path, $attachment_id);
                        require_once(ABSPATH . 'wp-admin/includes/image.php');
                        $attach_data = wp_generate_attachment_metadata($attach_id, $webp_path);
                        wp_update_attachment_metadata($attach_id, $attach_data);

                    } catch (Exception $e) {
                        error_log("Greška pri konverziji slike: " . $e->getMessage());
                    }
                }
            }
        }
        wp_reset_postdata();
    }
    echo "✅ Konverzija u WebP završena!";
}

// 🚀 **Pokreni konverziju preko URL-a:**
if (isset($_GET['konvertuj_slike'])) {
    konvertuj_slike_u_webp();
}




function preload_lcp_image_for_mobile() {
    if (wp_is_mobile()) {
        $image_url = "https://novidan.rs/wp-content/uploads/2025/02/img_26.webp"; // Promeni putanju ako treba
        echo '<link rel="preload" as="image" href="' . esc_url($image_url) . '" type="image/webp" fetchpriority="high">';
    }
}
add_action('wp_head', 'preload_lcp_image_for_mobile');







function get_webp_image_mobile($image_url) {
    if (wp_is_mobile()) {
        $webp_url = preg_replace('/\.(jpg|jpeg|png)/i', '.webp', $image_url);
        $webp_path = str_replace(site_url(), ABSPATH, $webp_url);
        
        return file_exists($webp_path) ? $webp_url : $image_url;
    }
    return $image_url;
}






add_filter('wp_get_attachment_image_attributes', function($attr, $attachment, $size) {
    if (wp_is_mobile() && $size == 'full') {
        $attr['loading'] = 'eager';  // LCP slika se učitava odmah
        $attr['fetchpriority'] = 'high';
    } else {
        $attr['loading'] = 'lazy'; // Sve ostale slike su lazy
    }
    return $attr;
}, 10, 3);





function async_css_loading() {
    echo '<link rel="stylesheet" href="https://novidan.rs/wp-content/themes/noozbeat/style.css" media="print" onload="this.onload=null;this.media=\'all\'">';
}
add_action('wp_head', 'async_css_loading');






function defer_js_loading($tag, $handle, $src) {
    if (is_admin()) {
        return $tag;
    }
    
    if (strpos($tag, 'jquery') === false) {
        return str_replace(' src', ' defer src', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'defer_js_loading', 10, 3);





function get_mobile_optimized_logo() {
    $logo_url = get_theme_mod('logo');
    if (!$logo_url) return '';

    if (wp_is_mobile()) {
        return str_replace(array('.jpg', '.jpeg', '.png'), '.webp', $logo_url);
    }

    return $logo_url;
}




add_image_size('small', 320, 180, true);
add_image_size('medium', 640, 360, true);



function add_custom_image_sizes() {
    add_image_size('small', 320, 180, true);  // Za mobilne uređaje
    add_image_size('medium', 640, 360, true); // Za tablete
    add_image_size('large', 1024, 576, true); // Standardno
}
add_action('after_setup_theme', 'add_custom_image_sizes');




function get_responsive_image($post_id, $default_size = 'large') {
    if (wp_is_mobile()) {
        return get_the_post_thumbnail_url($post_id, 'small');  // Manja slika za mobilne uređaje
    }
    return get_the_post_thumbnail_url($post_id, $default_size);
}



function dodaj_aria_label_za_ikonice($content) {
    // Definiši listu ikonica i njihovog značenja
    $ikonice = array(
        'fa-facebook'  => 'Facebook profil',
        'fa-instagram' => 'Instagram profil',
        'fa-twitter'   => 'Twitter nalog',
        'fa-youtube'   => 'YouTube kanal',
        'fa-rss'       => 'RSS Feed',
        'fa-linkedin'  => 'LinkedIn profil',
        'fa-pinterest' => 'Pinterest profil',
        'fa-envelope'  => 'Kontakt email',
        'fa-home'      => 'Početna stranica',
    );

    // Prolazak kroz listu i zamena <a> tagova sa nedostajućim atributima
    foreach ($ikonice as $class => $label) {
        $pattern = '/<a([^>]*?)><i class="fa ' . $class . '"><\/i><\/a>/';
        $replacement = '<a$1 aria-label="' . esc_attr($label) . '" title="' . esc_attr($label) . '"><i class="fa ' . $class . '"></i></a>';
        $content = preg_replace($pattern, $replacement, $content);
    }

    return $content;
}
add_filter('the_content', 'dodaj_aria_label_za_ikonice');




function add_aria_label_to_social_links($content) {
    $content = str_replace(
        '<a href="https://www.facebook.com', 
        '<a aria-label="Facebook" href="https://www.facebook.com', 
        $content
    );

    $content = str_replace(
        '<a href="https://www.instagram.com', 
        '<a aria-label="Instagram" href="https://www.instagram.com', 
        $content
    );

    $content = str_replace(
        '<a href="https://novidan.rs/feed', 
        '<a aria-label="RSS Feed" href="https://novidan.rs/feed', 
        $content
    );

    return $content;
}
add_filter('the_content', 'add_aria_label_to_social_links');






function add_missing_alt_tags($content) {
    $content = preg_replace_callback('/<img([^>]+)>/i', function($matches) {
        if (strpos($matches[1], 'alt=') === false) {
            return '<img ' . $matches[1] . ' alt="Slika sa sajta">';
        }
        return '<img ' . $matches[1] . '>';
    }, $content);
    return $content;
}
add_filter('the_content', 'add_missing_alt_tags');





function add_aria_labels_to_social_links($content) {
    $content = str_replace(
        '<a href="https://www.facebook.com',
        '<a aria-label="Facebook" href="https://www.facebook.com',
        $content
    );
    $content = str_replace(
        '<a href="https://www.instagram.com',
        '<a aria-label="Instagram" href="https://www.instagram.com',
        $content
    );
    $content = str_replace(
        '<a href="https://novidan.rs/feed/',
        '<a aria-label="RSS Feed" href="https://novidan.rs/feed/',
        $content
    );
    return $content;
}
add_filter('the_content', 'add_aria_labels_to_social_links');





function add_aria_labels_to_social_icons($content) {
    $social_links = array(
        'facebook.com'  => 'Facebook',
        'instagram.com' => 'Instagram',
        'twitter.com'   => 'Twitter',
        'linkedin.com'  => 'LinkedIn',
        'youtube.com'   => 'YouTube'
    );

    foreach ($social_links as $url => $label) {
        $content = str_replace(
            '<a href="https://' . $url,
            '<a aria-label="' . $label . '" href="https://' . $url,
            $content
        );
    }

    return $content;
}
add_filter('the_content', 'add_aria_labels_to_social_icons');




$post_id = wp_insert_post(array(
    'post_title'    => $naslov,  
    'post_content'  => $sadrzaj,
    'post_status'   => 'publish',
    'post_author'   => 1,
    'post_category' => array($kategorija),
));

if ($post_id) {
    // Ručno pokreni funkcije jer WordPress hook možda ne radi
    oznaci_naslovne_clanke_automatski($post_id);
    automatski_prikazi_na_pocetnoj($post_id);
    automatski_oznaci_sticky_post($post_id);
}




add_action('save_post', 'oznaci_naslovne_clanke_automatski', 99);
add_action('save_post', 'automatski_prikazi_na_pocetnoj', 99);
add_action('save_post', 'automatski_oznaci_sticky_post', 99);













function add_lazyload_webp_to_images($content) {
    // Proveri da li je naslovna stranica
    if (is_front_page()) {
        // Dodaj loading="lazy" u sve <img> tagove
        $content = preg_replace('/<img(.*?)src=/', '<img loading="lazy"$1src=', $content);
        
        // Zameni .jpg i .png slike sa .webp verzijom ako postoji
        $content = preg_replace_callback('/<img(.*?)src=["\'](.*?)(\.jpg|\.png)["\'](.*?)>/', function ($matches) {
            $original_img = $matches[2] . $matches[3]; // Originalna slika
            $webp_img = $matches[2] . '.webp'; // WebP verzija slike

            // Proveri da li WebP slika postoji na serveru
            if (file_exists(ABSPATH . str_replace(site_url(), '', $webp_img))) {
                return '<img' . $matches[1] . 'src="' . $webp_img . '"' . $matches[4] . '>';
            } else {
                return '<img' . $matches[1] . 'src="' . $original_img . '"' . $matches[4] . '>';
            }
        }, $content);
    }
    return $content;
}
add_filter('the_content', 'add_lazyload_webp_to_images');




function remove_unused_scripts() {
    if (is_front_page()) {
        wp_dequeue_script('wp-embed'); // Onemogućava WordPress embed skriptu
        wp_dequeue_script('jquery-migrate'); // Uklanja jQuery Migrate ako nije potreban
    }
}
add_action('wp_enqueue_scripts', 'remove_unused_scripts', 100);





function debug_loaded_scripts() {
    global $wp_scripts;
    foreach ($wp_scripts->queue as $handle) {
        error_log("Loaded script: " . $handle);
    }
}
add_action('wp_footer', 'debug_loaded_scripts');





function auto_add_alt_text($content) {
    global $post;
    if (!$post) return $content;

    $post_title = esc_attr(get_the_title($post->ID));

    // Pronalazi sve <img> tagove koji nemaju ALT ili imaju prazan ALT
    $content = preg_replace_callback(
        '/<img(?![^>]*alt=)["\']([^"\']+)["\']([^>]+)>/i',
        function ($matches) use ($post_title) {
            return '<img src="' . esc_attr($matches[1]) . '" ' . $matches[2] . ' alt="' . $post_title . '">';
        },
        $content
    );

    return $content;
}
add_filter('the_content', 'auto_add_alt_text', 999);






function auto_add_featured_image_alt($html, $post_id, $post_thumbnail_id, $size, $attr) {
    $post_title = esc_attr(get_the_title($post_id));

    // Ako alt atribut ne postoji ili je prazan, dodaj naslov posta
    if (strpos($html, 'alt=""') !== false || !strpos($html, 'alt=')) {
        $html = preg_replace('/<img(.*?)alt=["\']{0,1}["\']{0,1}(.*?)>/i', '<img$1alt="' . $post_title . '" $2>', $html);
    }

    return $html;
}
add_filter('post_thumbnail_html', 'auto_add_featured_image_alt', 999, 5);




function add_alt_to_lazyload_images($content) {
    global $post;
    if (!$post) return $content;

    $post_title = esc_attr(get_the_title($post->ID));

    // Pronalazi slike koje koriste lazy-load (data-src umesto src)
    $content = preg_replace_callback(
        '/<img(?![^>]*alt=)([^>]*?)data-src=["\']([^"\']+)["\']([^>]*?)>/i',
        function ($matches) use ($post_title) {
            return '<img ' . $matches[1] . 'data-src="' . esc_attr($matches[2]) . '" ' . $matches[3] . ' alt="' . $post_title . '">';
        },
        $content
    );

    return $content;
}
add_filter('the_content', 'add_alt_to_lazyload_images', 999);



function auto_set_image_alt($post_ID) {
    $image_title = get_the_title($post_ID);
    if (!empty($image_title)) {
        update_post_meta($post_ID, '_wp_attachment_image_alt', $image_title);
    }
}
add_action('add_attachment', 'auto_set_image_alt');





function update_missing_image_alts() {
    $attachments = get_posts(array(
        'post_type' => 'attachment',
        'numberposts' => -1
    ));

    foreach ($attachments as $attachment) {
        $alt_text = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
        
        if (empty($alt_text)) {
            $alt_text = get_the_title($attachment->ID);
            update_post_meta($attachment->ID, '_wp_attachment_image_alt', $alt_text);
        }
    }
}
add_action('admin_init', 'update_missing_image_alts');





function add_alt_to_all_images($content) {
    global $post;
    if (!$post) return $content;

    $post_title = esc_attr(get_the_title($post->ID));

    // Dodaje ALT za slike koje ga nemaju
    $content = preg_replace_callback(
        '/<img(?![^>]*alt=)([^>]*?)src=["\']([^"\']+)["\']([^>]*?)>/i',
        function ($matches) use ($post_title) {
            return '<img ' . $matches[1] . 'src="' . esc_attr($matches[2]) . '" ' . $matches[3] . ' alt="' . $post_title . '">';
        },
        $content
    );

    // Dodaje ALT za lazy-load slike (data-src)
    $content = preg_replace_callback(
        '/<img(?![^>]*alt=)([^>]*?)data-src=["\']([^"\']+)["\']([^>]*?)>/i',
        function ($matches) use ($post_title) {
            return '<img ' . $matches[1] . 'data-src="' . esc_attr($matches[2]) . '" ' . $matches[3] . ' alt="' . $post_title . '">';
        },
        $content
    );

    return $content;
}
add_filter('the_content', 'add_alt_to_all_images', 999);





function auto_generate_alt_text($post_ID) {
    $post_title = get_the_title($post_ID);
    $image_alt = get_post_meta($post_ID, '_wp_attachment_image_alt', true);

    if (empty($image_alt)) {
        $alt_text = $post_title . " - Fotografija iz članka";
        update_post_meta($post_ID, '_wp_attachment_image_alt', $alt_text);
    }
}
add_action('add_attachment', 'auto_generate_alt_text');




function auto_add_post_title_as_alt($content) {
    global $post;
    if (!$post) return $content;

    $post_title = esc_attr(get_the_title($post->ID));

    preg_match_all('/<img(?!.*alt=)[^>]+>/i', $content, $matches);

    if (!empty($matches[0])) {
        foreach ($matches[0] as $img_tag) {
            $new_img_tag = str_replace('<img', '<img alt="' . $post_title . '"', $img_tag);
            $content = str_replace($img_tag, $new_img_tag, $content);
        }
    }

    return $content;
}
add_filter('the_content', 'auto_add_post_title_as_alt');









function custom_theme_widgets_init() {
    register_sidebar( array(
        'name'          => 'Sidebar za članke',
        'id'            => 'sidebar-single',
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action( 'widgets_init', 'custom_theme_widgets_init' );







// 👇 Zalepi ovo odmah ispod svega ostalog
add_action('wp_head', function () {
    if (is_single() && has_post_thumbnail()) {
        $thumbnail_id = get_post_thumbnail_id();
        $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'full');
        echo '<link rel="preload" as="image" href="' . esc_url($thumbnail_url) . '" />';
    }
});




add_filter( 'rocket_sitemap_preload_list', function( $sitemaps ) {
    $sitemaps[] = 'https://novidan.rs/sitemap_index.xml';
    return $sitemaps;
});





// Dodavanje WP Rocket dugmeta za ručni preload
add_action( 'admin_menu', function() {
	add_submenu_page(
		'tools.php', // ispod Alatke
		'WP Rocket Preload', // naslov stranice
		'WP Rocket Preload', // naziv u meniju
		'manage_options',
		'wp-rocket-preload',
		'custom_wp_rocket_preload_page'
	);
});

function custom_wp_rocket_preload_page() {
	if ( isset($_POST['trigger_preload']) ) {
		if ( function_exists('run_rocket_sitemap_preload') ) {
			run_rocket_sitemap_preload();
			echo '<div class="notice notice-success is-dismissible"><p>✅ Preload pokrenut!</p></div>';
		} else {
			echo '<div class="notice notice-error"><p>❌ WP Rocket preload funkcija nije pronađena.</p></div>';
		}
	}
	echo '<div class="wrap">';
	echo '<h1>WP Rocket – Ručni Preload</h1>';
	echo '<form method="post">';
	submit_button( 'Pokreni Preload' , 'primary', 'trigger_preload');
	echo '</form>';
	echo '</div>';
}




// Automatski preload početne strane i kategorija kad se objavi novi post
add_action( 'save_post', 'custom_auto_preload_on_post_publish', 20, 3 );
function custom_auto_preload_on_post_publish( $post_id, $post, $update ) {

    // Samo za objavljene postove
    if ( $post->post_status !== 'publish' ) {
        return;
    }

    // Samo za objave (ne stranice itd.)
    if ( $post->post_type !== 'post' ) {
        return;
    }

    if ( function_exists( 'rocket_clean_post' ) ) {
        rocket_clean_post( $post_id ); // obriši keš za novi post
    }

    // Preloaduj homepage
    if ( function_exists( 'rocket_clean_home' ) ) {
        rocket_clean_home();
    }

    // Preloaduj sve kategorije vezane za post
    $categories = get_the_category( $post_id );
    if ( ! empty( $categories ) && function_exists( 'rocket_clean_term' ) ) {
        foreach ( $categories as $category ) {
            rocket_clean_term( $category->term_id, 'category' );
        }
    }
}




// ✅ Preload za novu objavu – uključuje: post, homepage, kategorije, tagove
add_action( 'save_post', 'custom_auto_preload_full', 20, 3 );
function custom_auto_preload_full( $post_id, $post, $update ) {

    if ( $post->post_status !== 'publish' || $post->post_type !== 'post' ) return;

    // Očisti i keširaj post
    if ( function_exists( 'rocket_clean_post' ) ) {
        rocket_clean_post( $post_id );
    }

    // Homepage
    if ( function_exists( 'rocket_clean_home' ) ) {
        rocket_clean_home();
    }

    // Kategorije
    $categories = get_the_category( $post_id );
    if ( ! empty( $categories ) && function_exists( 'rocket_clean_term' ) ) {
        foreach ( $categories as $category ) {
            rocket_clean_term( $category->term_id, 'category' );
        }
    }

    // Tagovi
    $tags = get_the_tags( $post_id );
    if ( ! empty( $tags ) && function_exists( 'rocket_clean_term' ) ) {
        foreach ( $tags as $tag ) {
            rocket_clean_term( $tag->term_id, 'post_tag' );
        }
    }
}




// ✅ Dodaj cron akciju koja se pokreće svaka 3h
if ( ! wp_next_scheduled( 'custom_cron_preload' ) ) {
    wp_schedule_event( time(), 'every_three_hours', 'custom_cron_preload' );
}

// ✅ Funkcija za preload preko sitemap linka
add_action( 'custom_cron_preload', 'run_wp_rocket_preload' );
function run_wp_rocket_preload() {
    if ( function_exists( 'run_rocket_sitemap_preload' ) ) {
        run_rocket_sitemap_preload();
    }
}

// ✅ Registruj novi interval (3 sata)
add_filter( 'cron_schedules', 'custom_cron_schedule' );
function custom_cron_schedule( $schedules ) {
    $schedules['every_three_hours'] = array(
        'interval' => 10800,
        'display'  => esc_html__( 'Every 3 Hours' )
    );
    return $schedules;
}









function dodaj_jsonld_za_vesti() {
    if (is_single() && 'post' === get_post_type()) {
        global $post;
        $naslov = get_the_title($post);
        $url = get_permalink($post);
        $datum = get_the_date('c', $post);
        $modifikovan = get_the_modified_date('c', $post);
        $autor = get_the_author_meta('display_name', $post->post_author);
        $opis = has_excerpt($post) ? get_the_excerpt($post) : wp_trim_words(strip_tags($post->post_content), 30, '...');
        $slika = get_the_post_thumbnail_url($post, 'full');
        $logo = 'https://novidan.rs/wp-content/uploads/2021/03/9b09b992.png'; // promeni ako se logo promeni

        $jsonld = [
            "@context" => "https://schema.org",
            "@type" => "NewsArticle",
            "headline" => $naslov,
            "image" => [$slika],
            "datePublished" => $datum,
            "dateModified" => $modifikovan,
            "author" => [
                "@type" => "Person",
                "name" => $autor
            ],
            "publisher" => [
                "@type" => "Organization",
                "name" => "Novi Dan",
                "logo" => [
                    "@type" => "ImageObject",
                    "url" => $logo
                ]
            ],
            "description" => $opis,
            "mainEntityOfPage" => [
                "@type" => "WebPage",
                "@id" => $url
            ]
        ];

        echo '<script type="application/ld+json">' . wp_json_encode($jsonld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
    }
}
add_action('wp_head', 'dodaj_jsonld_za_vesti');




function novidan_custom_excerpt_length($length) {
    return 55; // npr. 45 reči
}
add_filter('excerpt_length', 'novidan_custom_excerpt_length');





add_action('pre_get_posts', function ($query) {
    if (is_admin() || !$query->is_main_query()) return;

    if ($query->is_category(4)) {
        $query->set('posts_per_page', 21);
    }
});





