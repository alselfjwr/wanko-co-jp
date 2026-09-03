<?php
/**
 * Render every theme template to static HTML for a design check.
 * Usage: php tools/preview/render.php <outdir>
 * Then open <outdir>/index.html (assets are copied next to it).
 */
$out = isset( $argv[1] ) ? rtrim( $argv[1], '/' ) : __DIR__ . '/../../dist/preview';
$theme = realpath( __DIR__ . '/../../wp-content/themes/wanko' );
if ( ! is_dir( $out ) ) { mkdir( $out, 0777, true ); }
if ( ! is_dir( "$out/theme" ) ) { mkdir( "$out/theme", 0777, true ); }
// copy assets
$it = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( "$theme/assets", FilesystemIterator::SKIP_DOTS ) );
foreach ( $it as $f ) {
	$rel = substr( $f->getPathname(), strlen( $theme ) + 1 );
	@mkdir( dirname( "$out/theme/$rel" ), 0777, true );
	copy( $f->getPathname(), "$out/theme/$rel" );
}

define( 'PREVIEW_THEME_DIR', $theme );
define( 'PREVIEW_THEME_URI', './theme' );
require __DIR__ . '/stubs.php';
require $theme . '/functions.php';

$mods = array(
	'wanko_movie_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
);

$views = array(
	'index'      => array( 'view' => 'front',    'template' => '',           'title' => 'トップ',            'file' => 'front-page.php' ),
	'about'      => array( 'view' => 'page',     'template' => 'about',      'title' => '私たちについて',       'file' => 'page-about.php' ),
	'message'    => array( 'view' => 'page',     'template' => 'message',    'title' => '私たちの想い',        'file' => 'page-message.php' ),
	'philosophy' => array( 'view' => 'page',     'template' => 'philosophy', 'title' => 'ブランド理念',        'file' => 'page-philosophy.php' ),
	'commitment' => array( 'view' => 'page',     'template' => 'commitment', 'title' => '私たちのこだわり',      'file' => 'page-commitment.php' ),
	'company'    => array( 'view' => 'page',     'template' => 'company',    'title' => '会社概要',           'file' => 'page-company.php' ),
	'business'   => array( 'view' => 'page',     'template' => 'business',   'title' => '事業内容',           'file' => 'page-business.php' ),
	'products'   => array( 'view' => 'archive',  'template' => 'products',   'title' => '商品紹介',           'file' => 'archive-products.php' ),
	'category'   => array( 'view' => 'taxonomy', 'template' => 'products',   'title' => 'フード',            'file' => 'taxonomy-product_category.php' ),
	'product'    => array( 'view' => 'product',  'template' => 'products',   'title' => '商品詳細',           'file' => 'single-products.php' ),
	'news'       => array( 'view' => 'archive',  'template' => 'post',       'title' => 'お知らせ',           'file' => 'home.php' ),
	'column'     => array( 'view' => 'archive',  'template' => 'column',     'title' => 'コラム',            'file' => 'archive.php' ),
	'single'     => array( 'view' => 'single',   'template' => 'column',     'title' => '記事',             'file' => 'single.php' ),
	'recruit'    => array( 'view' => 'page',     'template' => 'recruit',    'title' => '採用情報',           'file' => 'page-recruit.php' ),
	'contact'    => array( 'view' => 'page',     'template' => 'contact',    'title' => 'お問い合わせ',         'file' => 'page-contact.php' ),
	'privacy'    => array( 'view' => 'page',     'template' => 'privacy',    'title' => 'プライバシーポリシー',    'file' => 'page-privacy.php' ),
	'sitemap'    => array( 'view' => 'page',     'template' => 'sitemap',    'title' => 'サイトマップ',         'file' => 'page-sitemap.php' ),
	'404'        => array( 'view' => '404',      'template' => '',           'title' => '404',              'file' => '404.php' ),
);

$page_content = array(
	'recruit' => wanko_default_recruit_content(),
	'privacy' => wanko_default_privacy_content(),
);

foreach ( $views as $name => $v ) {
	$GLOBALS['wanko_ctx'] = array_merge( $GLOBALS['wanko_ctx'], $v, array( 'mods' => $mods ) );
	$GLOBALS['wanko_main_query'] = null;
	$posts = preview_posts();
	if ( 'single' === $v['view'] ) {
		$GLOBALS['wanko_ctx']['post'] = $posts[ array_search( 5, array_column( $posts, 'id' ), true ) ];
	} elseif ( 'product' === $v['view'] ) {
		$GLOBALS['wanko_ctx']['post'] = $posts[ array_search( 101, array_column( $posts, 'id' ), true ) ];
	} elseif ( 'page' === $v['view'] ) {
		$GLOBALS['wanko_ctx']['post'] = array( 'id' => 100, 'type' => 'page', 'title' => $v['title'], 'date' => '2026-09-01', 'cat' => '', 'excerpt' => '', 'thumb' => '', 'url' => '#', 'content' => isset( $page_content[ $v['template'] ] ) ? $page_content[ $v['template'] ] : '' );
	} else {
		$GLOBALS['wanko_ctx']['post'] = $posts[0];
	}
	ob_start();
	include $theme . '/' . $v['file'];
	$html = ob_get_clean();
	// strip block comments for the static preview
	$html = preg_replace( '/<!-- \/?wp:[^>]*-->/', '', $html );
	file_put_contents( "$out/$name.html", $html );
	echo "wrote $name.html\n";
}
