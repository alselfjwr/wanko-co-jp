<?php
/**
 * Minimal WordPress function stubs so theme templates can be rendered to static HTML
 * without a WordPress install (design check / screenshot only).
 * Usage: php tools/preview/render.php <outdir>
 */

define( 'ABSPATH', __DIR__ . '/' );

$GLOBALS['wanko_ctx'] = array(
	'view'     => 'front',
	'posts'    => array(),
	'post'     => null,
	'title'    => '',
	'template' => '',
	'mods'     => array(),
);

function ctx( $k ) { return $GLOBALS['wanko_ctx'][ $k ]; }

/* -- hooks / registration: no-ops -------------------------------------- */
function add_action() {}
function add_filter() {}
function remove_action() {}
function register_nav_menus() {}
function register_post_type() {}
function register_taxonomy() {}
function add_theme_support() {}
function add_editor_style() {}
function set_post_thumbnail_size() {}
function add_image_size() {}
function load_theme_textdomain() {}
function flush_rewrite_rules() {}
function __( $s ) { return $s; }
function __return_empty_string() { return ''; }

/* -- escaping ------------------------------------------------------------ */
function esc_html( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES, 'UTF-8' ); }
function esc_attr( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES, 'UTF-8' ); }
function esc_url( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES, 'UTF-8' ); }
function esc_url_raw( $s ) { return $s; }
function sanitize_text_field( $s ) { return $s; }
function sanitize_textarea_field( $s ) { return $s; }
function sanitize_email( $s ) { return $s; }
function wp_kses_post( $s ) { return $s; }
function do_shortcode( $s ) { return $s; }

/* -- site info ----------------------------------------------------------- */
function home_url( $p = '/' ) { return 'https://wanko.co.jp' . $p; }
function get_bloginfo( $k ) { return 'name' === $k ? '合同会社わんわんわんこ' : 'UTF-8'; }
function bloginfo( $k ) { echo esc_html( get_bloginfo( $k ) ); }
function language_attributes() { echo 'lang="ja"'; }
function get_template_directory() { return PREVIEW_THEME_DIR; }
function get_template_directory_uri() { return PREVIEW_THEME_URI; }
function get_theme_mod( $k, $d = '' ) { $m = ctx( 'mods' ); return array_key_exists( $k, $m ) ? $m[ $k ] : $d; }
function set_theme_mod() {}
function has_custom_logo() { return false; }
function get_option( $k ) { return 'page_for_posts' === $k ? 0 : ''; }
function current_user_can() { return true; }
function is_wp_error( $x ) { return false; }
function wp_head() {
	echo '<title>' . esc_html( ctx( 'title' ) ) . ' | 合同会社わんわんわんこ</title>' . "\n";
	echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&family=Zen+Maru+Gothic:wght@500;700&display=swap">' . "\n";
	echo '<link rel="stylesheet" href="' . PREVIEW_THEME_URI . '/assets/css/main.css">' . "\n";
}
function wp_footer() { echo '<script src="' . PREVIEW_THEME_URI . '/assets/js/main.js"></script>' . "\n"; }
function wp_body_open() {}
function body_class() { echo 'class="' . ( 'front' === ctx( 'view' ) ? 'is-front no-logo' : 'no-logo' ) . '"'; }

/* -- conditionals -------------------------------------------------------- */
function is_front_page() { return 'front' === ctx( 'view' ); }
function is_page( $s = null ) { return 'page' === ctx( 'view' ) && ( null === $s || $s === ctx( 'template' ) ); }
function is_404() { return '404' === ctx( 'view' ); }
function is_tax() { return false; }
function is_category() { return false; }
function is_post_type_archive( $t ) { return 'archive' === ctx( 'view' ) && $t === ctx( 'template' ); }
function is_search() { return false; }
function single_term_title( $p = '', $e = true ) { return ''; }

/* -- pages / links ------------------------------------------------------- */
function get_page_by_path( $slug ) { return (object) array( 'ID' => crc32( $slug ), 'slug' => $slug ); }
function get_permalink( $p = null ) {
	if ( is_object( $p ) && isset( $p->slug ) ) { return home_url( '/' . $p->slug . '/' ); }
	if ( is_object( $p ) && isset( $p['url'] ) ) { return $p['url']; }
	if ( is_array( $p ) ) { return $p['url']; }
	return isset( $GLOBALS['wanko_ctx']['post']['url'] ) ? $GLOBALS['wanko_ctx']['post']['url'] : '#';
}
function get_post_type_archive_link( $t ) { return home_url( '/' . $t . '/' ); }
function get_page_template_slug() { return ''; }
function get_terms() { return array(
	(object) array( 'term_id' => 1, 'name' => 'ごはん', 'slug' => 'food' ),
	(object) array( 'term_id' => 2, 'name' => '健康', 'slug' => 'health' ),
	(object) array( 'term_id' => 3, 'name' => 'しつけ', 'slug' => 'training' ),
); }
function get_term_link( $t ) { return home_url( '/column-category/' . $t->slug . '/' ); }

/* -- loop ---------------------------------------------------------------- */
class WP_Query {
	public $posts; private $i = -1;
	public function __construct( $args = array() ) {
		$type  = isset( $args['post_type'] ) ? $args['post_type'] : 'post';
		$n     = isset( $args['posts_per_page'] ) ? $args['posts_per_page'] : 10;
		$this->posts = array_slice( array_values( array_filter( preview_posts(), function ( $p ) use ( $type ) { return $p['type'] === $type; } ) ), 0, $n );
	}
	public function have_posts() { return $this->i + 1 < count( $this->posts ); }
	public function the_post() { $this->i++; $GLOBALS['wanko_ctx']['post'] = $this->posts[ $this->i ]; }
}
$GLOBALS['wanko_main_query'] = null;
function have_posts() {
	if ( ! $GLOBALS['wanko_main_query'] ) {
		$q = new WP_Query( array( 'post_type' => ctx( 'template' ), 'posts_per_page' => 10 ) );
		$GLOBALS['wanko_main_query'] = $q;
	}
	return $GLOBALS['wanko_main_query']->have_posts();
}
function the_post() {
	if ( 'single' === ctx( 'view' ) || 'page' === ctx( 'view' ) ) { return; }
	$GLOBALS['wanko_main_query']->the_post();
}
function wp_reset_postdata() {}
function get_post() { return (object) ctx( 'post' ); }
function get_the_ID() { return ctx( 'post' )['id']; }
function get_post_type() { return ctx( 'post' )['type']; }
function the_permalink() { echo esc_url( ctx( 'post' )['url'] ); }
function the_title() { echo esc_html( ctx( 'post' )['title'] ); }
function get_the_title( $p = null ) { return is_array( $p ) ? $p['title'] : ctx( 'post' )['title']; }
function get_the_excerpt() { return ctx( 'post' )['excerpt']; }
function get_the_date( $f = 'Y.m.d' ) { return date( $f, strtotime( ctx( 'post' )['date'] ) ); }
function has_post_thumbnail() { return ! empty( ctx( 'post' )['thumb'] ); }
function the_post_thumbnail( $s = '', $a = array() ) { echo '<img src="' . esc_url( ctx( 'post' )['thumb'] ) . '" alt="">'; }
function get_the_terms() { $p = ctx( 'post' ); return empty( $p['cat'] ) ? false : array( (object) array( 'name' => $p['cat'] ) ); }
function get_the_category() { $p = ctx( 'post' ); return empty( $p['cat'] ) ? array() : array( (object) array( 'name' => $p['cat'], 'slug' => 'x' ) ); }
function the_content() { echo ctx( 'post' )['content']; }
function get_the_content() { return ctx( 'post' )['content']; }
function get_previous_post() { return array( 'title' => 'ひとつ前の記事タイトル', 'url' => '#' ); }
function get_next_post() { return array( 'title' => 'ひとつ後の記事タイトル', 'url' => '#' ); }
function the_posts_pagination() { echo '<nav class="pagination"><div class="nav-links"><span class="page-numbers current">1</span><a class="page-numbers" href="#">2</a><a class="page-numbers" href="#">3</a><a class="next page-numbers" href="#">次へ</a></div></nav>'; }

/* -- template loading ---------------------------------------------------- */
function get_template_part( $slug ) { include PREVIEW_THEME_DIR . '/' . $slug . '.php'; }
function get_header() { include PREVIEW_THEME_DIR . '/header.php'; }
function get_footer() { include PREVIEW_THEME_DIR . '/footer.php'; }
function wp_nav_menu( $args ) { wanko_nav_fallback( $args ); }

/* -- sample content ------------------------------------------------------ */
function preview_posts() {
	return array(
		array( 'id' => 1, 'type' => 'post', 'title' => 'コーポレートサイトをリニューアルしました', 'date' => '2026-09-08', 'cat' => 'お知らせ', 'excerpt' => '', 'thumb' => '', 'url' => '#',
			'content' => '<p>このたび、合同会社わんわんわんこのコーポレートサイトをリニューアルいたしました。事業内容やお知らせ、コラムなどを随時発信してまいります。</p><h2>リニューアルのポイント</h2><ul><li>スマートフォンでも見やすいデザインに刷新</li><li>お知らせ・コラムを定期的に更新</li><li>各ECサイトへの導線を整理</li></ul><p>今後とも合同会社わんわんわんこをよろしくお願いいたします。</p>' ),
		array( 'id' => 2, 'type' => 'post', 'title' => '夏季休業のお知らせ', 'date' => '2026-08-01', 'cat' => '', 'excerpt' => '', 'thumb' => '', 'url' => '#', 'content' => '' ),
		array( 'id' => 3, 'type' => 'post', 'title' => '「わんわんデリバリーフーズ」の取り扱い商品を追加しました', 'date' => '2026-07-15', 'cat' => '商品情報', 'excerpt' => '', 'thumb' => '', 'url' => '#', 'content' => '' ),
		array( 'id' => 4, 'type' => 'post', 'title' => '法人さま向け卸販売のご案内ページを公開しました', 'date' => '2026-06-20', 'cat' => '', 'excerpt' => '', 'thumb' => '', 'url' => '#', 'content' => '' ),
		array( 'id' => 5, 'type' => 'column', 'title' => '愛犬のごはん、量はどれくらいが正解？体重別の目安', 'date' => '2026-09-01', 'cat' => 'ごはん', 'excerpt' => '「うちの子、食べすぎ？」と感じたことはありませんか。体重と活動量からみる1日の給与量の目安をまとめました。', 'thumb' => '', 'url' => '#', 'content' => '' ),
		array( 'id' => 6, 'type' => 'column', 'title' => 'ねこちゃんの水分不足に注意。ウェットフードの活用法', 'date' => '2026-08-20', 'cat' => '健康', 'excerpt' => 'もともと水をあまり飲まない猫。フード選びで水分補給をサポートするコツをご紹介します。', 'thumb' => '', 'url' => '#', 'content' => '' ),
		array( 'id' => 7, 'type' => 'column', 'title' => '子犬を迎えたら最初にそろえたい用品リスト', 'date' => '2026-08-05', 'cat' => 'しつけ', 'excerpt' => 'ケージ、トイレ、食器、おもちゃ。初日から必要なものと、あとから買い足せばよいものを整理しました。', 'thumb' => '', 'url' => '#', 'content' => '' ),
	);
}
