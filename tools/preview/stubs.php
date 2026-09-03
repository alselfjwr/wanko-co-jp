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
function get_template_part_args() {}
function is_404() { return '404' === ctx( 'view' ); }
function is_tax() { return false; }
function is_category() { return false; }
function is_post_type_archive( $t ) { return 'archive' === ctx( 'view' ) && $t === ctx( 'template' ); }
function is_search() { return false; }
function single_term_title( $p = '', $e = true ) { return ''; }

/* -- pages / links ------------------------------------------------------- */
function get_page_by_path( $slug ) { return (object) array( 'ID' => crc32( $slug ), 'slug' => $slug ); }
function get_permalink( $p = null ) {
	if ( is_int( $p ) ) { $f = preview_find( $p ); return $f ? $f['url'] : '#'; }
	if ( is_object( $p ) && isset( $p->slug ) ) { return home_url( '/' . $p->slug . '/' ); }
	if ( is_object( $p ) && isset( $p['url'] ) ) { return $p['url']; }
	if ( is_array( $p ) ) { return $p['url']; }
	return isset( $GLOBALS['wanko_ctx']['post']['url'] ) ? $GLOBALS['wanko_ctx']['post']['url'] : '#';
}
function get_post_type_archive_link( $t ) { return home_url( '/' . $t . '/' ); }
function get_page_template_slug() { return ''; }
function preview_terms( $tax ) {
	if ( 'product_category' === $tax ) {
		return array(
			(object) array( 'term_id' => 11, 'name' => 'フード', 'slug' => 'food', 'taxonomy' => $tax, 'description' => 'ドッグフード・キャットフード', 'parent' => 0 ),
			(object) array( 'term_id' => 12, 'name' => 'おやつ', 'slug' => 'treat', 'taxonomy' => $tax, 'description' => 'ごほうび・トレーニング用', 'parent' => 0 ),
			(object) array( 'term_id' => 13, 'name' => '用品', 'slug' => 'goods', 'taxonomy' => $tax, 'description' => 'トイレ・ケア用品・日用品', 'parent' => 0 ),
		);
	}
	if ( 'column_tag' === $tax ) {
		return array( (object) array( 'term_id' => 31, 'name' => '子犬', 'slug' => 'puppy', 'taxonomy' => $tax ), (object) array( 'term_id' => 32, 'name' => 'フード選び', 'slug' => 'food-select', 'taxonomy' => $tax ) );
	}
	return array(
		(object) array( 'term_id' => 1, 'name' => '犬との暮らし', 'slug' => 'life', 'taxonomy' => 'column_category' ),
		(object) array( 'term_id' => 2, 'name' => '健康', 'slug' => 'health', 'taxonomy' => 'column_category' ),
		(object) array( 'term_id' => 3, 'name' => '食事', 'slug' => 'food', 'taxonomy' => 'column_category' ),
	);
}
function get_terms( $args = array() ) { return preview_terms( isset( $args['taxonomy'] ) ? $args['taxonomy'] : 'column_category' ); }
function get_term_link( $t ) {
	if ( 'product_category' === $t->taxonomy ) { return home_url( '/products/' . $t->slug . '/' ); }
	return home_url( '/' . str_replace( '_', '-', $t->taxonomy ) . '/' . $t->slug . '/' );
}
function get_term_meta() { return ''; }
function wp_get_attachment_image_url() { return ''; }
function get_the_post_thumbnail_url( $p, $s = '' ) { return is_array( $p ) ? $p['thumb'] : ( is_object( $p ) && isset( $p->thumb ) ? $p->thumb : '' ); }
function get_the_post_thumbnail( $id, $size = '', $attr = array() ) { $p = preview_find( $id ); return $p && $p['thumb'] ? '<img src="' . esc_url( $p['thumb'] ) . '" alt="">' : ''; }
function preview_find( $id ) { foreach ( preview_posts() as $p ) { if ( $p['id'] === $id ) { return $p; } } return null; }
function get_post_meta( $id, $key = '', $single = false ) { $p = preview_find( $id ); $k = preg_replace( '/^_wanko_/', '', $key ); return ( $p && isset( $p['meta'][ $k ] ) ) ? $p['meta'][ $k ] : ''; }
function get_queried_object() { return preview_terms( 'product_category' )[0]; }
function wp_list_pluck( $list, $field ) { return array_map( function ( $o ) use ( $field ) { return is_object( $o ) ? $o->$field : $o[ $field ]; }, $list ); }

/* -- loop ---------------------------------------------------------------- */
class WP_Query {
	public $posts; private $i = -1;
	public function __construct( $args = array() ) {
		$type  = isset( $args['post_type'] ) ? $args['post_type'] : 'post';
		$n     = isset( $args['posts_per_page'] ) ? $args['posts_per_page'] : 10;
		$not   = isset( $args['post__not_in'] ) ? $args['post__not_in'] : array();
		$pcat  = '';
		if ( ! empty( $args['tax_query'][0]['terms'] ) && 'product_category' === $args['tax_query'][0]['taxonomy'] ) {
			$terms = (array) $args['tax_query'][0]['terms'];
			foreach ( preview_terms( 'product_category' ) as $t ) { if ( $t->term_id === $terms[0] ) { $pcat = $t->slug; } }
		}
		$this->posts = array_values( array_filter( preview_posts(), function ( $p ) use ( $type, $not, $pcat ) {
			return $p['type'] === $type && ! in_array( $p['id'], $not, true ) && ( ! $pcat || ( isset( $p['pcat'] ) && $p['pcat'] === $pcat ) );
		} ) );
		if ( $n > 0 ) { $this->posts = array_slice( $this->posts, 0, $n ); }
	}
	public function have_posts() { return $this->i + 1 < count( $this->posts ); }
	public function the_post() { $this->i++; $GLOBALS['wanko_ctx']['post'] = $this->posts[ $this->i ]; }
}
$GLOBALS['wanko_main_query'] = null;
function have_posts() {
	if ( ! $GLOBALS['wanko_main_query'] ) {
		$q = new WP_Query( array( 'post_type' => ctx( 'template' ), 'posts_per_page' => 10 ) );
		if ( 'taxonomy' === ctx( 'view' ) ) { $q = new WP_Query( array( 'post_type' => 'products', 'posts_per_page' => 10, 'tax_query' => array( array( 'taxonomy' => 'product_category', 'terms' => 11 ) ) ) ); }
		$GLOBALS['wanko_main_query'] = $q;
	}
	return $GLOBALS['wanko_main_query']->have_posts();
}
function the_post() {
	if ( 'single' === ctx( 'view' ) || 'page' === ctx( 'view' ) || 'product' === ctx( 'view' ) ) { return; }
	$GLOBALS['wanko_main_query']->the_post();
}
function wp_reset_postdata() {}
function get_post() { return (object) ctx( 'post' ); }
function get_the_ID() { return ctx( 'post' )['id']; }
function get_post_type() { return ctx( 'post' )['type']; }
function the_permalink() { echo esc_url( ctx( 'post' )['url'] ); }
function the_title() { echo esc_html( ctx( 'post' )['title'] ); }
function get_the_title( $p = null ) { if ( is_int( $p ) ) { $f = preview_find( $p ); return $f ? $f['title'] : ''; } return is_array( $p ) ? $p['title'] : ctx( 'post' )['title']; }
function get_the_excerpt() { return ctx( 'post' )['excerpt']; }
function get_the_date( $f = 'Y.m.d' ) { return date( $f, strtotime( ctx( 'post' )['date'] ) ); }
function has_post_thumbnail( $id = null ) { $p = $id ? preview_find( $id ) : ctx( 'post' ); return ! empty( $p['thumb'] ); }
function the_post_thumbnail( $s = '', $a = array() ) { echo '<img src="' . esc_url( ctx( 'post' )['thumb'] ) . '" alt="">'; }
function get_the_terms( $id = null, $tax = '' ) {
	$p = $id ? preview_find( $id ) : ctx( 'post' );
	if ( ! $p ) { return false; }
	if ( 'product_category' === $tax ) { foreach ( preview_terms( $tax ) as $t ) { if ( $t->slug === ( isset( $p['pcat'] ) ? $p['pcat'] : '' ) ) { return array( $t ); } } return false; }
	if ( 'column_tag' === $tax ) { return 'column' === $p['type'] ? preview_terms( $tax ) : false; }
	if ( 'column_category' === $tax ) { foreach ( preview_terms( $tax ) as $t ) { if ( $t->name === $p['cat'] ) { return array( $t ); } } }
	return empty( $p['cat'] ) ? false : array( (object) array( 'name' => $p['cat'], 'term_id' => 99, 'slug' => 'x', 'taxonomy' => $tax ) );
}
function get_the_category() { $p = ctx( 'post' ); return empty( $p['cat'] ) ? array() : array( (object) array( 'name' => $p['cat'], 'slug' => 'x' ) ); }
function the_content() { echo ctx( 'post' )['content']; }
function get_the_content() { return ctx( 'post' )['content']; }
function get_previous_post() { return array( 'title' => 'ひとつ前の記事タイトル', 'url' => '#' ); }
function get_next_post() { return array( 'title' => 'ひとつ後の記事タイトル', 'url' => '#' ); }
function the_posts_pagination() { echo '<nav class="pagination"><div class="nav-links"><span class="page-numbers current">1</span><a class="page-numbers" href="#">2</a><a class="page-numbers" href="#">3</a><a class="next page-numbers" href="#">次へ</a></div></nav>'; }

/* -- template loading ---------------------------------------------------- */
function get_template_part( $slug, $name = null, $args = array() ) { include PREVIEW_THEME_DIR . '/' . $slug . '.php'; }
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
		array( 'id' => 101, 'type' => 'products', 'pcat' => 'food', 'title' => 'わんわんプレミアム チキン&ライス 2kg', 'date' => '2026-08-01', 'cat' => 'フード', 'excerpt' => '国産チキンを主原料にした、成犬用の総合栄養食。毎日のごはんに安心を。', 'thumb' => PREVIEW_THEME_URI . '/assets/img/photo-dog-food.jpg', 'url' => 'product.html', 'content' => '<p>厳選した国産チキンと国産米を主原料に、わんちゃんの健康を第一に考えて作ったドライフードです。</p><h2>おいしさと栄養バランス</h2><p>小粒設計で小型犬でも食べやすく、消化に配慮した配合です。</p>',
			'meta' => array( 'catch' => '毎日のごはんに、国産チキンの安心を。', 'price' => '3,980円（税込）', 'buy_url' => 'https://example.com/', 'point1_ttl' => '国産チキンが主原料', 'point1_txt' => '第一原料に国産チキンを使用。良質なたんぱく質を届けます。', 'point2_ttl' => '消化にやさしい配合', 'point2_txt' => '穀物の配合を見直し、お腹にやさしいレシピにしました。', 'point3_ttl' => '小粒で食べやすい', 'point3_txt' => '小型犬やシニア犬でも噛みやすい小粒サイズです。', 'recommend' => "毎日のごはんを見直したい\n食が細くなってきた\nお腹の調子が気になる", 'spec_name' => 'わんわんプレミアム チキン&ライス', 'spec_volume' => '2kg', 'spec_target' => '成犬用（1歳〜）', 'spec_ingr' => '鶏肉、米、大麦、鶏脂、ビートパルプ、フィッシュオイル、ビタミン類、ミネラル類', 'spec_origin' => '日本', 'spec_expiry' => '製造日より18ヶ月', 'spec_store' => '直射日光・高温多湿を避けて保存', 'spec_seller' => '合同会社わんわんわんこ', 'notes' => '開封後はなるべく早くお召し上がりください。' ) ),
		array( 'id' => 102, 'type' => 'products', 'pcat' => 'food', 'title' => 'にゃんにゃんセレクト まぐろ&サーモン 1.5kg', 'date' => '2026-07-20', 'cat' => 'フード', 'excerpt' => '', 'thumb' => '', 'url' => 'product.html', 'content' => '', 'meta' => array( 'catch' => '魚好きのねこちゃんに。', 'price' => '2,980円（税込）' ) ),
		array( 'id' => 103, 'type' => 'products', 'pcat' => 'treat', 'title' => 'ささみジャーキー 100g', 'date' => '2026-07-10', 'cat' => 'おやつ', 'excerpt' => '', 'thumb' => '', 'url' => 'product.html', 'content' => '', 'meta' => array( 'catch' => 'ごほうびに、無添加ささみ。', 'price' => '680円（税込）' ) ),
		array( 'id' => 104, 'type' => 'products', 'pcat' => 'goods', 'title' => '消臭ペットシーツ レギュラー 100枚', 'date' => '2026-07-01', 'cat' => '用品', 'excerpt' => '', 'thumb' => '', 'url' => 'product.html', 'content' => '', 'meta' => array( 'catch' => '毎日使うものだから、たっぷり。', 'price' => '1,480円（税込）' ) ),
		array( 'id' => 5, 'type' => 'column', 'title' => '愛犬のごはん、量はどれくらいが正解？体重別の目安', 'date' => '2026-09-01', 'cat' => 'ごはん', 'excerpt' => '「うちの子、食べすぎ？」と感じたことはありませんか。体重と活動量からみる1日の給与量の目安をまとめました。', 'thumb' => '', 'url' => '#', 'content' => '<p>「うちの子、食べすぎ？」と感じたことはありませんか。</p><h2>1日の給与量の目安</h2><p>体重と活動量から計算します。</p><h3>小型犬（〜5kg）</h3><p>目安は…</p><h3>中型犬（5〜20kg）</h3><p>目安は…</p><h2>おやつの分は差し引く</h2><p>おやつは1日の必要カロリーの10%以内に。</p><h2>迷ったら獣医師に相談を</h2><p>体型のチェック方法もご紹介します。</p>' ),
		array( 'id' => 6, 'type' => 'column', 'title' => 'ねこちゃんの水分不足に注意。ウェットフードの活用法', 'date' => '2026-08-20', 'cat' => '健康', 'excerpt' => 'もともと水をあまり飲まない猫。フード選びで水分補給をサポートするコツをご紹介します。', 'thumb' => '', 'url' => '#', 'content' => '' ),
		array( 'id' => 7, 'type' => 'column', 'title' => '子犬を迎えたら最初にそろえたい用品リスト', 'date' => '2026-08-05', 'cat' => 'しつけ', 'excerpt' => 'ケージ、トイレ、食器、おもちゃ。初日から必要なものと、あとから買い足せばよいものを整理しました。', 'thumb' => '', 'url' => '#', 'content' => '' ),
	);
}
