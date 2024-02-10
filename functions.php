<?php
/**
 * Book Review functions and definitions
 *
 * @package Book_Review
 */

if ( ! function_exists( 'bookreview_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function bookreview_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'bookreview', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		//Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'head-nav' => esc_html__( 'Head Menu', 'bookreview' ),
			'foot-nav' => esc_html__( 'Foot Menu', 'bookreview' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'bookreview_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'bookreview_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bookreview_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'bookreview_content_width', 640 );
}
add_action( 'after_setup_theme', 'bookreview_content_width', 0 );

/**
 * Register widget area.
 */
function bookreview_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'bookreview' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'bookreview' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'bookreview_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bookreview_scripts() {

	wp_enqueue_style( 'webfonts', get_stylesheet_directory_uri() . '/assets/css/fonts.css' );
	wp_enqueue_style( 'fontawesome', get_stylesheet_directory_uri() . '/assets/css/all.css' );
	wp_enqueue_style( 'bookreview-style', get_stylesheet_uri() );

	wp_enqueue_script( 'bookreview-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'bookreview-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bookreview_scripts' );

/**
 * Add custom post type 'book' to default and archive posts query
 */
function bookreview_add_books_to_query( $query ) {
	if ( $query->is_main_query() && ( ! $query->is_admin ) ) {
		if ( $query->is_home() || $query->is_archive() )
			$query->set( 'post_type', array( 'post', 'book' ) );
	}
	return $query;
}
add_action( 'pre_get_posts', 'bookreview_add_books_to_query' );

/**
 * Add category book to custom post type 'book' on saving
 */
function bookreview_save_book_meta( $post_id, $post, $update ) {
    if ( 'book' != $post->post_type ) {
        return;
	}
	$term_id = 'buecher';
    wp_set_object_terms( $post_id, $term_id, 'category', true );
}
add_action( 'save_post', 'bookreview_save_book_meta', 10, 3 );

/**
 * display custom post type book in recent posts widget
 */
function bookreview_recentpost_add_book( $params ) {
    $params['post_type'] = array( 'post', 'book' );
    return $params;
}
add_filter( 'widget_posts_args', 'bookreview_recentpost_add_book' );

/**
 * add custom post type book to archive widget
 */
function bookreview_getarchives_where( $where ){
    $where = str_replace( "post_type = 'post'", "post_type IN ( 'post', 'book' )", $where );
    return $where;
}
add_filter( 'getarchives_where', 'bookreview_getarchives_where' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

