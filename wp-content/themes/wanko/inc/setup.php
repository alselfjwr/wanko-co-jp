<?php
/**
 * Theme setup: supports, menus, assets, misc tweaks.
 *
 * @package Wanko
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register theme supports and navigation menus.
 */
function wanko_setup() {
	load_theme_textdomain( 'wanko', WANKO_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 280,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );

	set_post_thumbnail_size( 1200, 675, true );
	add_image_size( 'wanko-card', 640, 400, true );

	register_nav_menus( array(
		'primary' => __( 'グローバルナビゲーション', 'wanko' ),
		'footer'  => __( 'フッターナビゲーション', 'wanko' ),
	) );
}
add_action( 'after_setup_theme', 'wanko_setup' );

/**
 * Enqueue front-end assets.
 */
function wanko_enqueue_assets() {
	wp_enqueue_style(
		'wanko-fonts',
		'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&family=Noto+Serif+JP:wght@400;600&family=Cinzel:wght@400;700&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'wanko-main', WANKO_URI . '/assets/css/main.css', array( 'wanko-fonts' ), WANKO_VERSION );
	wp_enqueue_script( 'wanko-main', WANKO_URI . '/assets/js/main.js', array(), WANKO_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'wanko_enqueue_assets' );

/**
 * Preconnect to Google Fonts.
 */
function wanko_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array( 'href' => 'https://fonts.googleapis.com', 'crossorigin' );
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'wanko_resource_hints', 10, 2 );

/**
 * Excerpt tweaks for Japanese text.
 */
function wanko_excerpt_length() {
	return 60;
}
add_filter( 'excerpt_length', 'wanko_excerpt_length' );

function wanko_excerpt_more() {
	return '…';
}
add_filter( 'excerpt_more', 'wanko_excerpt_more' );

/**
 * Body classes for layout hooks.
 */
function wanko_body_classes( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'is-front';
	}
	if ( ! has_custom_logo() ) {
		$classes[] = 'no-logo';
	}
	return $classes;
}
add_filter( 'body_class', 'wanko_body_classes' );

/**
 * Housekeeping: remove version output and emoji scripts.
 */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
add_filter( 'the_generator', '__return_empty_string' );

/**
 * Disable site search (no search page in the site map).
 */
function wanko_disable_search( $query, $error = true ) {
	if ( is_search() && ! is_admin() ) {
		$query->is_search       = false;
		$query->query_vars['s'] = false;
		$query->query['s']      = false;
		if ( $error ) {
			$query->is_404 = true;
		}
	}
}
add_action( 'parse_query', 'wanko_disable_search' );
add_filter( 'get_search_form', '__return_empty_string' );
