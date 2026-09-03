<?php
/**
 * 商品の入力欄（メタボックス）と商品カテゴリーの画像設定。
 * ACF 等のプラグインなしで動作します。
 *
 * @package Wanko
 */

defined( 'ABSPATH' ) || exit;

/**
 * Product field definitions.
 * key => [ label, type(text|textarea|url|number), group ]
 *
 * @return array
 */
function wanko_product_fields() {
	return array(
		'catch'       => array( 'キャッチコピー', 'text', 'main' ),
		'price'       => array( '価格（例：1,980円（税込））', 'text', 'main' ),
		'buy_url'     => array( '購入URL（ECサイトの商品ページ）', 'url', 'main' ),
		'buy_label'   => array( '購入ボタンの文言（空欄なら「商品を購入する」）', 'text', 'main' ),
		'point1_ttl'  => array( 'POINT 01 見出し', 'text', 'points' ),
		'point1_txt'  => array( 'POINT 01 説明', 'textarea', 'points' ),
		'point2_ttl'  => array( 'POINT 02 見出し', 'text', 'points' ),
		'point2_txt'  => array( 'POINT 02 説明', 'textarea', 'points' ),
		'point3_ttl'  => array( 'POINT 03 見出し', 'text', 'points' ),
		'point3_txt'  => array( 'POINT 03 説明', 'textarea', 'points' ),
		'recommend'   => array( 'こんな子におすすめ（1行1項目）', 'textarea', 'recommend' ),
		'spec_name'   => array( '商品名（正式名称）', 'text', 'spec' ),
		'spec_volume' => array( '内容量', 'text', 'spec' ),
		'spec_target' => array( '対象（例：成犬用／全年齢）', 'text', 'spec' ),
		'spec_ingr'   => array( '原材料', 'textarea', 'spec' ),
		'spec_origin' => array( '原産国', 'text', 'spec' ),
		'spec_expiry' => array( '賞味期限', 'text', 'spec' ),
		'spec_store'  => array( '保存方法', 'text', 'spec' ),
		'spec_seller' => array( '販売元', 'text', 'spec' ),
		'notes'       => array( '注意事項', 'textarea', 'spec' ),
	);
}

/**
 * Spec table rows (label => meta key) in display order.
 *
 * @return array
 */
function wanko_product_spec_rows() {
	return array(
		'商品名'  => 'spec_name',
		'内容量'  => 'spec_volume',
		'対象'   => 'spec_target',
		'原材料'  => 'spec_ingr',
		'原産国'  => 'spec_origin',
		'賞味期限' => 'spec_expiry',
		'保存方法' => 'spec_store',
		'販売元'  => 'spec_seller',
		'注意事項' => 'notes',
	);
}

/**
 * Get a product field value.
 *
 * @param string   $key     Field key.
 * @param int|null $post_id Post ID.
 * @return string
 */
function wanko_product( $key, $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	return (string) get_post_meta( $post_id, '_wanko_' . $key, true );
}

/**
 * Register meta boxes.
 */
function wanko_product_meta_boxes() {
	$groups = array(
		'main'      => '商品の基本情報（価格・購入リンク）',
		'points'    => 'この商品の特徴（POINT 01〜03）',
		'recommend' => 'こんな子におすすめ',
		'spec'      => '商品情報（スペック表）',
	);
	foreach ( $groups as $id => $title ) {
		add_meta_box( 'wanko_product_' . $id, $title, 'wanko_product_meta_box_html', 'products', 'normal', 'high', array( 'group' => $id ) );
	}
}
add_action( 'add_meta_boxes', 'wanko_product_meta_boxes' );

/**
 * Render a meta box.
 *
 * @param WP_Post $post Post.
 * @param array   $box  Box args.
 */
function wanko_product_meta_box_html( $post, $box ) {
	$group = $box['args']['group'];
	wp_nonce_field( 'wanko_product_save', 'wanko_product_nonce' );
	echo '<table class="form-table wanko-meta"><tbody>';
	foreach ( wanko_product_fields() as $key => $def ) {
		list( $label, $type, $g ) = $def;
		if ( $g !== $group ) {
			continue;
		}
		$value = get_post_meta( $post->ID, '_wanko_' . $key, true );
		$id    = 'wanko_' . $key;
		echo '<tr><th scope="row"><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label></th><td>';
		if ( 'textarea' === $type ) {
			echo '<textarea id="' . esc_attr( $id ) . '" name="' . esc_attr( $id ) . '" rows="3" class="large-text">' . esc_textarea( $value ) . '</textarea>';
		} else {
			$input_type = 'url' === $type ? 'url' : 'text';
			echo '<input type="' . esc_attr( $input_type ) . '" id="' . esc_attr( $id ) . '" name="' . esc_attr( $id ) . '" value="' . esc_attr( $value ) . '" class="large-text">';
		}
		echo '</td></tr>';
	}
	echo '</tbody></table>';
	if ( 'main' === $group ) {
		echo '<p class="description">商品画像は右側の「商品画像（メイン）」から、商品説明は上の本文エリアに入力してください。商品カテゴリーは右側で選択します。</p>';
	}
}

/**
 * Save meta.
 *
 * @param int $post_id Post ID.
 */
function wanko_product_save( $post_id ) {
	if ( ! isset( $_POST['wanko_product_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wanko_product_nonce'] ) ), 'wanko_product_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( wanko_product_fields() as $key => $def ) {
		$name = 'wanko_' . $key;
		if ( ! isset( $_POST[ $name ] ) ) {
			continue;
		}
		$raw = wp_unslash( $_POST[ $name ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		switch ( $def[1] ) {
			case 'url':
				$value = esc_url_raw( $raw );
				break;
			case 'textarea':
				$value = sanitize_textarea_field( $raw );
				break;
			default:
				$value = sanitize_text_field( $raw );
		}
		if ( '' === $value ) {
			delete_post_meta( $post_id, '_wanko_' . $key );
		} else {
			update_post_meta( $post_id, '_wanko_' . $key, $value );
		}
	}
}
add_action( 'save_post_products', 'wanko_product_save' );

/* -------------------------------------------------------------------------
 * 商品カテゴリーの画像（トップ・一覧のカードに使用）
 * ---------------------------------------------------------------------- */

/**
 * Category image field on add/edit term screens.
 *
 * @param WP_Term|string $term Term or taxonomy.
 */
function wanko_product_category_image_field( $term ) {
	$image_id = is_object( $term ) ? (int) get_term_meta( $term->term_id, 'wanko_image_id', true ) : 0;
	$src      = $image_id ? wp_get_attachment_image_url( $image_id, 'wanko-card' ) : '';
	$is_edit  = is_object( $term );
	echo $is_edit ? '<tr class="form-field"><th scope="row"><label>カテゴリー画像</label></th><td>' : '<div class="form-field"><label>カテゴリー画像</label>';
	echo '<div class="wanko-term-image">';
	echo '<img src="' . esc_url( $src ) . '" style="max-width:240px;height:auto;display:' . ( $src ? 'block' : 'none' ) . ';margin-bottom:8px;border-radius:8px">';
	echo '<input type="hidden" name="wanko_image_id" value="' . esc_attr( $image_id ) . '">';
	echo '<button type="button" class="button wanko-term-image-select">画像を選択</button> ';
	echo '<button type="button" class="button wanko-term-image-remove" style="display:' . ( $src ? 'inline-block' : 'none' ) . '">削除</button>';
	echo '<p class="description">トップページ・商品一覧のカテゴリーカードに表示されます（推奨 900×600px）。</p>';
	echo '</div>';
	echo $is_edit ? '</td></tr>' : '</div>';
}
add_action( 'product_category_add_form_fields', 'wanko_product_category_image_field' );
add_action( 'product_category_edit_form_fields', 'wanko_product_category_image_field' );

/**
 * Save category image.
 *
 * @param int $term_id Term ID.
 */
function wanko_product_category_image_save( $term_id ) {
	if ( isset( $_POST['wanko_image_id'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$id = absint( wp_unslash( $_POST['wanko_image_id'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( $id ) {
			update_term_meta( $term_id, 'wanko_image_id', $id );
		} else {
			delete_term_meta( $term_id, 'wanko_image_id' );
		}
	}
}
add_action( 'created_product_category', 'wanko_product_category_image_save' );
add_action( 'edited_product_category', 'wanko_product_category_image_save' );

/**
 * Media picker script for the term screens.
 *
 * @param string $hook Admin page hook.
 */
function wanko_product_category_admin_assets( $hook ) {
	if ( ! in_array( $hook, array( 'edit-tags.php', 'term.php' ), true ) ) {
		return;
	}
	if ( empty( $_GET['taxonomy'] ) || 'product_category' !== $_GET['taxonomy'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}
	wp_enqueue_media();
	wp_add_inline_script( 'media-editor', "
	(function($){
		$(document).on('click','.wanko-term-image-select',function(e){
			e.preventDefault();
			var wrap=$(this).closest('.wanko-term-image');
			var frame=wp.media({title:'カテゴリー画像を選択',button:{text:'この画像を使う'},multiple:false});
			frame.on('select',function(){
				var a=frame.state().get('selection').first().toJSON();
				wrap.find('input[type=hidden]').val(a.id);
				wrap.find('img').attr('src',(a.sizes&&a.sizes.medium?a.sizes.medium.url:a.url)).show();
				wrap.find('.wanko-term-image-remove').show();
			});
			frame.open();
		});
		$(document).on('click','.wanko-term-image-remove',function(e){
			e.preventDefault();
			var wrap=$(this).closest('.wanko-term-image');
			wrap.find('input[type=hidden]').val('');
			wrap.find('img').hide();
			$(this).hide();
		});
	})(jQuery);" );
}
add_action( 'admin_enqueue_scripts', 'wanko_product_category_admin_assets' );

/**
 * Category image URL with fallbacks (own image → first product's thumbnail → '').
 *
 * @param WP_Term $term Term.
 * @param string  $size Image size.
 * @return string
 */
function wanko_product_category_image( $term, $size = 'wanko-card' ) {
	// 1. Image set on the category.
	$image_id = (int) get_term_meta( $term->term_id, 'wanko_image_id', true );
	if ( $image_id ) {
		$url = wp_get_attachment_image_url( $image_id, $size );
		if ( $url ) {
			return (string) $url;
		}
	}
	// 2. Theme default photos for the initial categories.
	$defaults = array(
		'food'  => 'photo-cat-food.jpg',
		'treat' => 'photo-cat-treat.jpg',
		'goods' => 'photo-cat-goods.jpg',
	);
	if ( isset( $defaults[ $term->slug ] ) ) {
		return WANKO_URI . '/assets/img/' . $defaults[ $term->slug ];
	}
	// 3. First product's featured image.
	$q = new WP_Query( array(
		'post_type'      => 'products',
		'posts_per_page' => 1,
		'no_found_rows'  => true,
		'meta_key'       => '_thumbnail_id', // phpcs:ignore WordPress.DB.SlowDBQuery
		'tax_query'      => array( array( 'taxonomy' => 'product_category', 'field' => 'term_id', 'terms' => $term->term_id ) ), // phpcs:ignore WordPress.DB.SlowDBQuery
	) );
	if ( $q->have_posts() ) {
		$url = get_the_post_thumbnail_url( $q->posts[0], $size );
		if ( $url ) {
			return (string) $url;
		}
	}
	return '';
}
