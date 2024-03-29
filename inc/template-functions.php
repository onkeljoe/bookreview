<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Book_Review
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function bookreview_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	if ( is_404() ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'bookreview_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function bookreview_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'bookreview_pingback_header' );

/**
 * add custom post type and standard post to the posts navigation
 * if current post is post or custom post type
 * @param string where-clause to filter nav links
 * @return string
 */
function bookreview_cpt_to_post_nav($where) {
	$parts = explode(' AND ', $where, 3);
	$old = 'p.post_type = ';
	$posttype = trim(substr($parts[1], strpos($parts[1],$old)+strlen($old)));
	$posttype = str_replace("'", "", $posttype);
	if ( 'post' === $posttype || 'book' === $posttype ) {
		$parts[1] = "p.post_type IN ( 'book', 'post' )";
	}
	return implode (' AND ', $parts);
}
add_filter ( 'get_next_post_where', 'bookreview_cpt_to_post_nav', 100 );
add_filter ( 'get_previous_post_where', 'bookreview_cpt_to_post_nav', 100 );