<?php
/**
 * One-time setup when the theme is activated:
 * creates the fixed pages, assigns templates, sets front/news pages and builds the menu.
 * Safe to run repeatedly (existing pages are never overwritten).
 *
 * @package Wanko
 */

defined( 'ABSPATH' ) || exit;

/**
 * Page definitions: slug => [ title, template file, content ].
 *
 * @return array
 */
function wanko_page_definitions() {
	// slug => [ title, template, content, parent slug ]
	return array(
		'home'     => array( 'ホーム', '', '', '' ),
		'company'  => array( '企業情報', 'page-company.php', '', '' ),
		'business' => array( '事業内容', 'page-business.php', '', '' ),
		'news'     => array( 'お知らせ', '', '', '' ),
		'recruit'  => array( '採用情報', 'page-recruit.php', wanko_default_recruit_content(), '' ),
		'contact'  => array( 'お問い合わせ', 'page-contact.php', '', '' ),
		'privacy'  => array( 'プライバシーポリシー', 'page-privacy.php', wanko_default_privacy_content(), '' ),
		'sitemap'  => array( 'サイトマップ', 'page-sitemap.php', '', '' ),
	);
}

/**
 * Create pages and menus on activation.
 */
function wanko_activate() {
	$ids = array();

	foreach ( wanko_page_definitions() as $slug => $def ) {
		list( $title, $template, $content, $parent ) = $def;
		$path     = $parent ? $parent . '/' . $slug : $slug;
		$existing = get_page_by_path( $path );
		if ( $existing ) {
			$ids[ $slug ] = $existing->ID;
			if ( $template && get_page_template_slug( $existing->ID ) !== $template ) {
				update_post_meta( $existing->ID, '_wp_page_template', $template );
			}
			continue;
		}
		$id = wp_insert_post( array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_content' => $content,
			'post_parent'  => ( $parent && ! empty( $ids[ $parent ] ) ) ? $ids[ $parent ] : 0,
		) );
		if ( $id && ! is_wp_error( $id ) ) {
			$ids[ $slug ] = $id;
			if ( $template ) {
				update_post_meta( $id, '_wp_page_template', $template );
			}
		}
	}

	if ( ! empty( $ids['home'] ) && ! empty( $ids['news'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['home'] );
		update_option( 'page_for_posts', $ids['news'] );
	}
	if ( ! empty( $ids['privacy'] ) ) {
		update_option( 'wp_page_for_privacy_policy', $ids['privacy'] );
	}

	// Pretty permalinks (お知らせ: /news/slug/). WordPress の初期値のままなら置き換える.
	$structure = (string) get_option( 'permalink_structure' );
	if ( '' === $structure || '/%year%/%monthnum%/%day%/%postname%/' === $structure ) {
		update_option( 'permalink_structure', '/news/%postname%/' );
	}

	// WordPress 初期の「サンプルページ」「プライバシーポリシー（下書き）」を片付ける.
	foreach ( array( 'sample-page', 'privacy-policy' ) as $default_slug ) {
		$default_page = get_page_by_path( $default_slug, OBJECT, 'page' );
		if ( $default_page && ( 'draft' === $default_page->post_status || 'sample-page' === $default_slug ) ) {
			wp_trash_post( $default_page->ID );
		}
	}
	$hello = get_page_by_path( 'hello-world', OBJECT, 'post' );
	if ( $hello ) {
		wp_trash_post( $hello->ID );
	}

	wanko_build_menu( 'primary', 'グローバルナビ', array(
		array( 'page' => 'company' ),
		array( 'page' => 'business' ),
		array( 'page' => 'news' ),
		array( 'url'  => home_url( '/column/' ), 'title' => 'コラム' ),
		array( 'page' => 'recruit' ),
	), $ids );

	wanko_build_menu( 'footer', 'フッターナビ', array(
		array( 'page' => 'company' ),
		array( 'page' => 'business' ),
		array( 'page' => 'news' ),
		array( 'url'  => home_url( '/column/' ), 'title' => 'コラム' ),
		array( 'page' => 'recruit' ),
		array( 'page' => 'contact' ),
		array( 'page' => 'privacy' ),
		array( 'page' => 'sitemap' ),
	), $ids );

	// 初期のコラムカテゴリー（存在しない場合のみ作成）.
	wanko_register_post_types();
	foreach ( array( 'life' => '犬・猫との暮らし', 'health' => '健康', 'food' => '食事', 'care' => 'お手入れ', 'product' => '商品について' ) as $slug => $name ) {
		if ( ! term_exists( $slug, 'column_category' ) ) {
			wp_insert_term( $name, 'column_category', array( 'slug' => $slug ) );
		}
	}

	wanko_register_column_cpt();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'wanko_activate' );

/**
 * One-time migration: remove the「お問い合わせ」item from an already-created
 * primary menu (the header keeps its dedicated contact button instead).
 */
function wanko_migrate_primary_menu_contact() {
	if ( get_option( 'wanko_migrated_nav_contact' ) ) {
		return;
	}
	$locations = get_nav_menu_locations();
	if ( ! empty( $locations['primary'] ) ) {
		$contact = get_page_by_path( 'contact' );
		foreach ( (array) wp_get_nav_menu_items( (int) $locations['primary'] ) as $item ) {
			$is_contact = ( $contact && 'page' === $item->object && (int) $item->object_id === (int) $contact->ID )
				|| 'contact' === basename( untrailingslashit( (string) wp_parse_url( $item->url, PHP_URL_PATH ) ) );
			if ( $is_contact ) {
				wp_delete_post( $item->ID, true );
			}
		}
	}
	update_option( 'wanko_migrated_nav_contact', 1 );
}
add_action( 'init', 'wanko_migrate_primary_menu_contact', 20 );

/**
 * Build a nav menu once and assign it to a location.
 *
 * @param string $location Menu location.
 * @param string $name     Menu name.
 * @param array  $items    Items.
 * @param array  $ids      Page ids by slug.
 */
function wanko_build_menu( $location, $name, $items, $ids ) {
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! empty( $locations[ $location ] ) && wp_get_nav_menu_object( $locations[ $location ] ) ) {
		return;
	}
	$menu = wp_get_nav_menu_object( $name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $name );
		if ( is_wp_error( $menu_id ) ) {
			return;
		}
		foreach ( $items as $item ) {
			if ( ! empty( $item['page'] ) && ! empty( $ids[ $item['page'] ] ) ) {
				wp_update_nav_menu_item( $menu_id, 0, array(
					'menu-item-object-id' => $ids[ $item['page'] ],
					'menu-item-object'    => 'page',
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
				) );
			} elseif ( ! empty( $item['url'] ) ) {
				wp_update_nav_menu_item( $menu_id, 0, array(
					'menu-item-title'  => $item['title'],
					'menu-item-url'    => $item['url'],
					'menu-item-type'   => 'custom',
					'menu-item-status' => 'publish',
				) );
			}
		}
	} else {
		$menu_id = $menu->term_id;
	}
	$locations[ $location ] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

/**
 * Default recruit page content (editable in the block editor).
 *
 * @return string
 */
function wanko_default_recruit_content() {
	return <<<'HTML'
<!-- wp:heading -->
<h2 class="wp-block-heading">募集要項</h2>
<!-- /wp:heading -->

<!-- wp:table -->
<figure class="wp-block-table"><table><tbody>
<tr><th>募集職種</th><td>（例）EC運営スタッフ／物流・出荷スタッフ</td></tr>
<tr><th>雇用形態</th><td>（例）正社員／アルバイト・パート</td></tr>
<tr><th>仕事内容</th><td>（例）ペットフード・用品の受注対応、商品管理、出荷業務、ECサイト運営サポート</td></tr>
<tr><th>勤務地</th><td>（例）本社（住所）</td></tr>
<tr><th>勤務時間</th><td>（例）9:00〜18:00（休憩1時間）</td></tr>
<tr><th>給与</th><td>（例）経験・能力を考慮のうえ決定</td></tr>
<tr><th>休日・休暇</th><td>（例）週休2日制、年末年始、有給休暇</td></tr>
<tr><th>応募資格</th><td>（例）ペットが好きな方、未経験歓迎</td></tr>
</tbody></table></figure>
<!-- /wp:table -->

<!-- wp:heading -->
<h2 class="wp-block-heading">応募方法</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>お問い合わせフォームより「採用について」を選択のうえ、お名前・ご連絡先・希望職種をご記入ください。担当者より折り返しご連絡いたします。</p>
<!-- /wp:paragraph -->
HTML;
}

/**
 * Default privacy policy content.
 *
 * @return string
 */
function wanko_default_privacy_content() {
	return <<<'HTML'
<!-- wp:paragraph -->
<p>合同会社わんわんわんこ（以下「当社」）は、お客さまの個人情報の重要性を認識し、以下の方針に基づき個人情報の保護に努めます。</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">1. 個人情報の取得について</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>当社は、お問い合わせ、商品のご注文、採用への応募などの際に、適法かつ公正な手段により個人情報を取得します。</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">2. 個人情報の利用目的</h2>
<!-- /wp:heading -->
<!-- wp:list -->
<ul><!-- wp:list-item --><li>お問い合わせへの回答およびご連絡のため</li><!-- /wp:list-item --><!-- wp:list-item --><li>商品の発送、代金の請求、アフターサービスのため</li><!-- /wp:list-item --><!-- wp:list-item --><li>採用選考およびご連絡のため</li><!-- /wp:list-item --><!-- wp:list-item --><li>当社サービスに関するご案内のため</li><!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">3. 個人情報の第三者提供</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>当社は、法令に基づく場合を除き、ご本人の同意なく個人情報を第三者に提供することはありません。</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">4. 個人情報の管理</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>当社は、個人情報への不正アクセス、紛失、漏えい、改ざんなどを防止するため、適切な安全管理措置を講じます。</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">5. 個人情報の開示・訂正・削除</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>ご本人からの個人情報の開示、訂正、削除などのご請求には、ご本人であることを確認のうえ、速やかに対応します。</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">6. アクセス解析ツールについて</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>当サイトでは、サイトの改善のためにアクセス解析ツールを利用する場合があります。これらのツールはCookieを使用してデータを収集しますが、個人を特定する情報は含まれません。</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">7. お問い合わせ窓口</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>個人情報の取り扱いに関するお問い合わせは、お問い合わせフォームよりご連絡ください。</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>制定日：2026年9月</p>
<!-- /wp:paragraph -->
HTML;
}
