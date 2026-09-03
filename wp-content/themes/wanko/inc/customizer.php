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
	$img = get_template_directory_uri() . '/assets/img/';
	return array(
		// メインビジュアル.
		'hero_catch'       => "わんちゃんにも、ねこちゃんにも。\n「おいしい」と「安心」を毎日に。",
		'hero_lead'        => '合同会社わんわんわんこは、ペット用品・ペットおやつの卸売・販売と、こだわりのペットフードのお届けを通じて、飼い主さまとペット双方にとって価値のあるサービスを提供しています。',
		'hero_image'       => $img . 'photo-hero.jpg',
		'hero_btn_label'   => '事業内容を見る',
		'hero_btn_url'     => '/business/',

		// こだわりのペットフード（ECサイトバナー）.
		'shop_cat_name'    => 'にゃんにゃんデリバリーフーズ',
		'shop_cat_desc'    => '猫の「食べる」をもっとラクに。猫の状態やライフステージに合わせたフードを定期的にお届けする、カスタマイズ可能なキャットフードの定期便です。',
		'shop_cat_url'     => 'https://nyan-nyan-delivery.myshopify.com/',
		'shop_cat_image'   => '',
		'shop_dog_name'    => 'わんわんデリバリーフーズ',
		'shop_dog_desc'    => 'わんちゃんの健康を考えたフードを、ご自宅へ定期的にお届けするサービスです。',
		'shop_dog_url'     => '',
		'shop_dog_image'   => $img . 'photo-dog-food.jpg',
		'shop_all_name'    => 'ペット総合ショップ',
		'shop_all_desc'    => 'フードから日用品まで、ペットとの暮らしをまるごとサポート。',
		'shop_all_url'     => '',
		'shop_all_image'   => '',

		// 私たちのお約束.
		'promise_image'    => $img . 'photo-dog-grass.jpg',
		'promise_catch'    => '飼い主さまとペット、双方にとって価値のあるサービスを。',
		'promise_lead'     => '私たちは、品質と安心を重視し、お客さま満足度の向上に向けて継続的なサービス改善に取り組んでいます。',
		'promise_1_title'  => '信頼性の高い商品',
		'promise_1_body'   => '主要メーカーとの取引により、ペットフードから日用品・ケア用品・季節商品まで、信頼できる商品を豊富にご用意しています。',
		'promise_2_title'  => '安定した供給体制',
		'promise_2_body'   => '小ロットでのご注文にも対応し、取引規模やニーズに応じた柔軟なご提案と、継続的にご利用いただける供給体制を整えています。',
		'promise_3_title'  => '品質と安心を最優先に',
		'promise_3_body'   => 'ペットの健康維持と飼い主さまの利便性の両立を目指し、安定した品質のサービスを継続的に提供します。',

		// ごあいさつ.
		'greeting_title'   => 'ペットと人が、もっと幸せに暮らせる社会へ。',
		'greeting_body'    => "合同会社わんわんわんこのウェブサイトをご覧いただき、ありがとうございます。\n\n当社は、ペット用品およびペットおやつの卸売・販売を中心に事業を展開しています。信頼性の高い商品と安定した供給体制を通じて、飼い主さまとペット双方にとって価値のあるサービスを提供することが私たちの使命です。\n\n品質と安心を重視し、お客さま満足度の向上に向けて継続的なサービス改善に取り組んでまいります。今後とも、合同会社わんわんわんこをよろしくお願いいたします。",
		'greeting_name'    => '合同会社わんわんわんこ　代表執行役員　鷲見 翼',
		'greeting_image'   => '',

		// 会社概要.
		'company_name'     => '合同会社わんわんわんこ',
		'company_ceo'      => '代表執行役員　鷲見 翼',
		'company_founded'  => '',
		'company_capital'  => '',
		'company_address'  => "〒550-0005\n大阪府大阪市西区西本町1丁目2-19 AXIS西本町セントラルビル401",
		'company_tel'      => '06-7167-9040',
		'company_fax'      => '06-6710-9175',
		'company_email'    => 'info2@wanko.co.jp',
		'company_hours'    => '',
		'company_business' => "ペット用品・ペットおやつの卸売・販売\nキャットフードの定期便「にゃんにゃんデリバリーフーズ」の運営\nドッグフードの定期便「わんわんデリバリーフーズ」（準備中）\nペット総合ショップの運営（準備中）",
		'company_map'      => '',

		// 事業内容：卸販売・主要取引メーカー.
		'wholesale_body'   => "当社は、ペット用品およびペットおやつの卸売・販売を行っています。ペットフードをはじめ、日用品、ケア用品、季節商品など幅広い商品を取り扱っています。\n\n小ロットでのご注文にも対応しており、取引規模やニーズに応じた柔軟なご提案が可能です。安定した供給体制のもと、継続的にご利用いただける環境を整えています。ご相談・お見積りなど、お気軽にお問い合わせください。",
		'partners_list'    => "㈱アイル\nアイシア㈱\n秋元水産㈱\nイースター㈱\n㈱イトウアンドカンパニーリミテッド\nいなばペットフード㈱\nオリエンタル酵母工業㈱\n㈱グリーンベル\n現代製薬㈱\n近喜商事㈱\nシヤチハタ㈱\n㈱マルカン サンライズ\n新東北化学工業㈱\n㈱スマック\n㈱スーパーキャット\nデビフペット㈱\nドギーマンハヤシ㈱\n日本ペットフード㈱\nネスレ日本㈱ネスレピュリナペットケア\nハイペット㈱\n常陸化工㈱\n日本ヒルズ・コルゲート㈱\nペパーレット㈱\nペットライン㈱\n㈱ペティオ\nマースジャパンリミテッド\n㈱マルカン\n㈲ヤマダシステム\nユニ・チャーム㈱\nライオンペット㈱",

		// 採用情報.
		'recruit_lead'     => '「ペットが好き」その気持ちを、仕事にしませんか。合同会社わんわんわんこでは、一緒に事業を育ててくれる仲間を募集しています。',
		'recruit_body'     => '',

		// お問い合わせ.
		'contact_lead'     => 'ご不明な点やご質問がございましたら、お気軽にお問い合わせください。商品のお取り扱い、法人さまのお取引、採用に関するご相談も承ります。',
		'contact_shortcode' => '',

		// ムービー（任意）.
		'movie_url'        => '',
		'movie_title'      => 'わんわんわんこムービー',
		'movie_lead'       => '',

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
		'business' => '事業内容：卸販売・主要取引メーカー',
		'recruit'  => '採用情報',
		'movie'    => 'トップ：ムービー（任意）',
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
		'shop_cat_image'    => array( 'shop', '【ねこ】写真（推奨 900×600px）', 'image' ),
		'shop_dog_name'     => array( 'shop', '【いぬ】サービス名', 'text' ),
		'shop_dog_desc'     => array( 'shop', '【いぬ】説明文', 'textarea' ),
		'shop_dog_url'      => array( 'shop', '【いぬ】ECサイトURL（空欄で Coming Soon 表示）', 'url' ),
		'shop_dog_image'    => array( 'shop', '【いぬ】写真（推奨 900×600px）', 'image' ),
		'shop_all_name'     => array( 'shop', '【総合】サービス名', 'text' ),
		'shop_all_desc'     => array( 'shop', '【総合】説明文', 'textarea' ),
		'shop_all_url'      => array( 'shop', '【総合】ECサイトURL（空欄で Coming Soon 表示）', 'url' ),
		'shop_all_image'    => array( 'shop', '【総合】写真（推奨 1600×600px）', 'image' ),

		'promise_image'     => array( 'promise', '背景写真（推奨 1600×900px）', 'image' ),
		'promise_catch'     => array( 'promise', 'キャッチ（写真の上に大きく表示）', 'text' ),
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
		'company_fax'       => array( 'company', 'FAX', 'text' ),
		'company_email'     => array( 'company', 'メールアドレス', 'email' ),
		'company_hours'     => array( 'company', '営業時間', 'text' ),
		'company_business'  => array( 'company', '事業内容（1行1項目）', 'textarea' ),
		'company_map'       => array( 'company', 'Googleマップ埋め込み用 src URL（任意）', 'url' ),

		'wholesale_body'    => array( 'business', '卸販売の説明文（空行で段落分け）', 'textarea' ),
		'partners_list'     => array( 'business', '主要取引メーカー（1行1社）', 'textarea' ),

		'recruit_lead'      => array( 'recruit', 'リード文', 'textarea' ),
		'recruit_body'      => array( 'recruit', '補足文（募集要項は固定ページ本文に記載）', 'textarea' ),

		'movie_url'         => array( 'movie', 'YouTube動画URL（設定するとトップに表示）', 'url' ),
		'movie_title'       => array( 'movie', '見出し', 'text' ),
		'movie_lead'        => array( 'movie', 'リード文', 'textarea' ),

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
