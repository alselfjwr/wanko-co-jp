<?php
/**
 * Custom post types and taxonomies.
 *
 * - お知らせ: standard "post" type (renamed in admin), URL /news/.
 * - コラム:   custom post type "column" + taxonomies "column_category", "column_tag".
 *
 * @package Wanko
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register post types and taxonomies.
 */
function wanko_register_post_types() {
	// ---- コラム ----
	register_post_type( 'column', array(
		'labels'        => array(
			'name'               => 'コラム',
			'singular_name'      => 'コラム',
			'add_new'            => '新規追加',
			'add_new_item'       => 'コラムを追加',
			'edit_item'          => 'コラムを編集',
			'new_item'           => '新規コラム',
			'view_item'          => 'コラムを表示',
			'search_items'       => 'コラムを検索',
			'not_found'          => 'コラムが見つかりません',
			'not_found_in_trash' => 'ゴミ箱にコラムはありません',
			'all_items'          => 'コラム一覧',
			'menu_name'          => 'コラム',
		),
		'public'        => true,
		'has_archive'   => true,
		'rewrite'       => array( 'slug' => 'column', 'with_front' => false ),
		'menu_position' => 6,
		'menu_icon'     => 'dashicons-edit-page',
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
		'show_in_rest'  => true,
	) );

	register_taxonomy( 'column_category', 'column', array(
		'labels'            => array(
			'name'          => 'コラムカテゴリー',
			'singular_name' => 'コラムカテゴリー',
			'add_new_item'  => 'カテゴリーを追加',
			'edit_item'     => 'カテゴリーを編集',
			'menu_name'     => 'カテゴリー',
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'column-category', 'with_front' => false ),
	) );

	register_taxonomy( 'column_tag', 'column', array(
		'labels'            => array(
			'name'          => 'コラムタグ',
			'singular_name' => 'コラムタグ',
			'add_new_item'  => 'タグを追加',
			'menu_name'     => 'タグ',
		),
		'hierarchical'      => false,
		'public'            => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'column-tag', 'with_front' => false ),
	) );
}
add_action( 'init', 'wanko_register_post_types' );

/**
 * Backwards-compatible alias (activation code calls this).
 */
function wanko_register_column_cpt() {
	wanko_register_post_types();
}

/**
 * Rename "投稿" to "お知らせ" in the admin UI.
 */
function wanko_rename_posts_labels() {
	global $wp_post_types;
	if ( empty( $wp_post_types['post'] ) ) {
		return;
	}
	$labels                     = $wp_post_types['post']->labels;
	$labels->name               = 'お知らせ';
	$labels->singular_name      = 'お知らせ';
	$labels->add_new            = '新規追加';
	$labels->add_new_item       = 'お知らせを追加';
	$labels->edit_item          = 'お知らせを編集';
	$labels->new_item           = '新規お知らせ';
	$labels->view_item          = 'お知らせを表示';
	$labels->search_items       = 'お知らせを検索';
	$labels->not_found          = 'お知らせが見つかりません';
	$labels->not_found_in_trash = 'ゴミ箱にお知らせはありません';
	$labels->all_items          = 'お知らせ一覧';
	$labels->menu_name          = 'お知らせ';
	$labels->name_admin_bar     = 'お知らせ';
}
add_action( 'init', 'wanko_rename_posts_labels' );

function wanko_rename_posts_menu() {
	global $menu, $submenu;
	if ( isset( $menu[5] ) ) {
		$menu[5][0] = 'お知らせ';
	}
	if ( isset( $submenu['edit.php'] ) ) {
		$submenu['edit.php'][5][0]  = 'お知らせ一覧';
		$submenu['edit.php'][10][0] = '新規追加';
	}
}
add_action( 'admin_menu', 'wanko_rename_posts_menu' );

add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );
