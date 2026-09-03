<?php
/**
 * Customizer settings (外観 > カスタマイズ).
 *
 * All site-specific copy lives here so the client can edit text without touching code.
 *
 * @package Wanko
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default values shared by the customizer and the templates.
 *
 * @return array
 */
function wanko_defaults() {
	return array(
		// メインビジュアル.
		'hero_catch'       => "わんちゃんにも、ねこちゃんにも。\n「おいしい」と「安心」を毎日に。",
		'hero_lead'        => '合同会社わんわんわんこは、ペット関連用品の卸販売と、こだわりのペットフードのお届けを通じて、ペットと飼い主さまの毎日を支えます。',
		'hero_image'       => '',
		'hero_btn_label'   => '事業内容を見る',
		'hero_btn_url'     => '/business/',

		// こだわりのペットフード（ECサイトバナー）.
		'shop_cat_name'    => 'にゃんにゃんデリバリーフーズ',
		'shop_cat_desc'    => 'ねこちゃん専用のこだわりフードをご自宅へお届け。',
		'shop_cat_url'     => '',
		'shop_dog_name'    => 'わんわんデリバリーフーズ',
		'shop_dog_desc'    => 'わんちゃんの健康を考えたフードをご自宅へお届け。',
		'shop_dog_url'     => '',
		'shop_all_name'    => 'ペット総合ショップ',
		'shop_all_desc'    => 'フードから日用品まで、ペットとの暮らしをまるごとサポート。',
		'shop_all_url'     => '',

		// 私たちのお約束.
		'promise_lead'     => '私たちは、ペットも飼い主さまも「家族」だと考えています。だからこそ、商品選びからお届けまで、妥協しません。',
		'promise_1_title'  => '安心・安全な商品だけを',
		'promise_1_body'   => '取り扱う商品は、私たち自身が自分のペットに与えたいと思えるものだけ。原材料・製造背景を確認したうえでお届けします。',
		'promise_2_title'  => '飼い主さまの声に寄り添う',
		'promise_2_body'   => '小さなご相談にも丁寧に対応します。お困りごとがあれば、まずはお気軽にお問い合わせください。',
		'promise_3_title'  => 'パートナーと共に育つ',
		'promise_3_body'   => 'お取引先さま、スタッフ、そしてペットたち。関わるすべての存在と、長く良い関係を築いていきます。',

		// ごあいさつ.
		'greeting_title'   => 'ペットと人が、もっと幸せに暮らせる社会へ。',
		'greeting_body'    => "合同会社わんわんわんこのウェブサイトをご覧いただき、ありがとうございます。\n\n私たちは、ペット関連用品の卸販売を軸に、ペットフードのデリバリー事業を展開しています。「自分のペットに与えたいものだけを届ける」を合言葉に、商品の選定からお客さまのもとへ届くまで、ひとつひとつ丁寧に向き合っています。\n\nこれからも、ペットと飼い主さまの毎日に寄り添う企業であり続けます。",
		'greeting_name'    => '合同会社わんわんわんこ　代表',
		'greeting_image'   => '',

		// 会社概要.
		'company_name'     => '合同会社わんわんわんこ',
		'company_ceo'      => '',
		'company_founded'  => '',
		'company_capital'  => '',
		'company_address'  => '',
		'company_tel'      => '',
		'company_email'    => '',
		'company_hours'    => '',
		'company_business' => "ペット関連用品の卸販売\nペットフードのデリバリー販売（にゃんにゃんデリバリーフーズ／わんわんデリバリーフーズ）\nペット総合ショップの運営（準備中）",
		'company_map'      => '',

		// 採用情報.
		'recruit_lead'     => '「ペットが好き」その気持ちを、仕事にしませんか。合同会社わんわんわんこでは、一緒に事業を育ててくれる仲間を募集しています。',
		'recruit_body'     => '',

		// お問い合わせ.
		'contact_lead'     => '商品のお取り扱い、法人さまのお取引、採用に関するご質問など、お気軽にお問い合わせください。',
		'contact_shortcode' => '',

		// フッター / SNS.
		'sns_instagram'    => '',
		'sns_x'            => '',
		'sns_line'         => '',
		'footer_note'      => '',
	);
}

/**
 * Get a theme mod with default fallback.
 *
 * @param string $key Setting key.
 * @return mixed
 */
function wanko_get( $key ) {
	$defaults = wanko_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	$value    = get_theme_mod( 'wanko_' . $key, $default );
	return $value;
}

/**
 * Register customizer panels, sections, settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function wanko_customize_register( $wp_customize ) {
	$defaults = wanko_defaults();

	$wp_customize->add_panel( 'wanko_panel', array(
		'title'    => 'サイトコンテンツ（わんわんわんこ）',
		'priority' => 10,
	) );

	$sections = array(
		'hero'     => 'トップ：メインビジュアル',
		'shop'     => 'トップ：こだわりのペットフード（ECサイト）',
		'promise'  => '私たちのお約束',
		'greeting' => '企業情報：ごあいさつ',
		'company'  => '企業情報：会社概要',
		'recruit'  => '採用情報',
		'contact'  => 'お問い合わせ',
		'footer'   => 'フッター・SNS',
	);
	$i = 10;
	foreach ( $sections as $id => $title ) {
		$wp_customize->add_section( 'wanko_' . $id, array(
			'title'    => $title,
			'panel'    => 'wanko_panel',
			'priority' => $i,
		) );
		$i += 10;
	}

	/*
	 * key => [ section, label, type, description ]
	 * type: text | textarea | url | image | email
	 */
	$fields = array(
		'hero_catch'        => array( 'hero', 'キャッチコピー（改行可）', 'textarea' ),
		'hero_lead'         => array( 'hero', 'リード文', 'textarea' ),
		'hero_image'        => array( 'hero', 'メインビジュアル画像（推奨 1600×1000px）', 'image' ),
		'hero_btn_label'    => array( 'hero', 'ボタンのラベル', 'text' ),
		'hero_btn_url'      => array( 'hero', 'ボタンのリンク先', 'text' ),

		'shop_cat_name'     => array( 'shop', '【ねこ】サービス名', 'text' ),
		'shop_cat_desc'     => array( 'shop', '【ねこ】説明文', 'textarea' ),
		'shop_cat_url'      => array( 'shop', '【ねこ】ECサイトURL（空欄で Coming Soon 表示）', 'url' ),
		'shop_dog_name'     => array( 'shop', '【いぬ】サービス名', 'text' ),
		'shop_dog_desc'     => array( 'shop', '【いぬ】説明文', 'textarea' ),
		'shop_dog_url'      => array( 'shop', '【いぬ】ECサイトURL（空欄で Coming Soon 表示）', 'url' ),
		'shop_all_name'     => array( 'shop', '【総合】サービス名', 'text' ),
		'shop_all_desc'     => array( 'shop', '【総合】説明文', 'textarea' ),
		'shop_all_url'      => array( 'shop', '【総合】ECサイトURL（空欄で Coming Soon 表示）', 'url' ),

		'promise_lead'      => array( 'promise', 'リード文', 'textarea' ),
		'promise_1_title'   => array( 'promise', 'お約束1：見出し', 'text' ),
		'promise_1_body'    => array( 'promise', 'お約束1：本文', 'textarea' ),
		'promise_2_title'   => array( 'promise', 'お約束2：見出し', 'text' ),
		'promise_2_body'    => array( 'promise', 'お約束2：本文', 'textarea' ),
		'promise_3_title'   => array( 'promise', 'お約束3：見出し', 'text' ),
		'promise_3_body'    => array( 'promise', 'お約束3：本文', 'textarea' ),

		'greeting_title'    => array( 'greeting', '見出し', 'text' ),
		'greeting_body'     => array( 'greeting', '本文（空行で段落分け）', 'textarea' ),
		'greeting_name'     => array( 'greeting', '署名（役職・氏名）', 'text' ),
		'greeting_image'    => array( 'greeting', '代表写真（任意）', 'image' ),

		'company_name'      => array( 'company', '会社名', 'text' ),
		'company_ceo'       => array( 'company', '代表者', 'text' ),
		'company_founded'   => array( 'company', '設立', 'text' ),
		'company_capital'   => array( 'company', '資本金', 'text' ),
		'company_address'   => array( 'company', '所在地（改行可）', 'textarea' ),
		'company_tel'       => array( 'company', '電話番号', 'text' ),
		'company_email'     => array( 'company', 'メールアドレス', 'email' ),
		'company_hours'     => array( 'company', '営業時間', 'text' ),
		'company_business'  => array( 'company', '事業内容（1行1項目）', 'textarea' ),
		'company_map'       => array( 'company', 'Googleマップ埋め込み用 src URL（任意）', 'url' ),

		'recruit_lead'      => array( 'recruit', 'リード文', 'textarea' ),
		'recruit_body'      => array( 'recruit', '補足文（募集要項は固定ページ本文に記載）', 'textarea' ),

		'contact_lead'      => array( 'contact', 'リード文', 'textarea' ),
		'contact_shortcode' => array( 'contact', 'フォームのショートコード（例：[contact-form-7 id="123" title="お問い合わせ"]）', 'text' ),

		'sns_instagram'     => array( 'footer', 'Instagram URL', 'url' ),
		'sns_x'             => array( 'footer', 'X（旧Twitter）URL', 'url' ),
		'sns_line'          => array( 'footer', 'LINE公式アカウント URL', 'url' ),
		'footer_note'       => array( 'footer', 'フッター補足文（任意）', 'textarea' ),
	);

	$sanitizers = array(
		'text'     => 'sanitize_text_field',
		'textarea' => 'wanko_sanitize_textarea',
		'url'      => 'esc_url_raw',
		'image'    => 'esc_url_raw',
		'email'    => 'sanitize_email',
	);

	$priority = 10;
	foreach ( $fields as $key => $def ) {
		list( $section, $label, $type ) = $def;
		$setting_id = 'wanko_' . $key;

		$wp_customize->add_setting( $setting_id, array(
			'default'           => isset( $defaults[ $key ] ) ? $defaults[ $key ] : '',
			'sanitize_callback' => $sanitizers[ $type ],
			'transport'         => 'refresh',
		) );

		$args = array(
			'label'    => $label,
			'section'  => 'wanko_' . $section,
			'priority' => $priority++,
		);

		if ( 'image' === $type ) {
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $setting_id, $args ) );
		} else {
			$args['type'] = 'textarea' === $type ? 'textarea' : ( 'url' === $type ? 'url' : ( 'email' === $type ? 'email' : 'text' ) );
			$wp_customize->add_control( $setting_id, $args );
		}
	}
}
add_action( 'customize_register', 'wanko_customize_register' );

/**
 * Sanitize multiline text (keeps line breaks, strips tags).
 *
 * @param string $value Raw value.
 * @return string
 */
function wanko_sanitize_textarea( $value ) {
	return sanitize_textarea_field( $value );
}
