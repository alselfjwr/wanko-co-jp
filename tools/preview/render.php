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
	'wanko_company_ceo'     => '代表社員　山田 太郎',
	'wanko_company_founded' => '2020年4月',
	'wanko_company_address' => "〒000-0000\n東京都○○区○○ 1-2-3",
	'wanko_company_tel'     => '03-0000-0000',
	'wanko_company_email'   => 'info@example.com',
	'wanko_company_hours'   => '平日 9:00〜18:00',
	'wanko_shop_cat_url'    => 'https://example.com/nyan',
);

$views = array(
	'index'    => array( 'view' => 'front',   'template' => '',        'title' => 'トップ',          'file' => 'front-page.php' ),
	'company'  => array( 'view' => 'page',    'template' => 'company', 'title' => '企業情報',         'file' => 'page-company.php' ),
	'business' => array( 'view' => 'page',    'template' => 'business','title' => '事業内容',         'file' => 'page-business.php' ),
	'news'     => array( 'view' => 'archive', 'template' => 'post',    'title' => 'お知らせ',         'file' => 'home.php' ),
	'column'   => array( 'view' => 'archive', 'template' => 'column',  'title' => 'コラム',          'file' => 'archive.php' ),
	'single'   => array( 'view' => 'single',  'template' => 'post',    'title' => '記事',           'file' => 'single.php' ),
	'recruit'  => array( 'view' => 'page',    'template' => 'recruit', 'title' => '採用情報',         'file' => 'page-recruit.php' ),
	'contact'  => array( 'view' => 'page',    'template' => 'contact', 'title' => 'お問い合わせ',       'file' => 'page-contact.php' ),
	'privacy'  => array( 'view' => 'page',    'template' => 'privacy', 'title' => 'プライバシーポリシー', 'file' => 'page-privacy.php' ),
	'404'      => array( 'view' => '404',     'template' => '',        'title' => '404',            'file' => '404.php' ),
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
		$GLOBALS['wanko_ctx']['post'] = $posts[0];
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
