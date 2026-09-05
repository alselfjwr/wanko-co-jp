<?php
/**
 * テーマ内蔵のお問い合わせフォーム（プラグイン不要）.
 * カスタマイザーで Contact Form 7 等のショートコードが設定されている場合は使われません。
 *
 * @package Wanko
 */

defined( 'ABSPATH' ) || exit;

/**
 * Inquiry types.
 *
 * @return array
 */
function wanko_contact_types() {
	$types = wanko_lines_to_array( wanko_get( 'contact_types' ) );
	return $types ? $types : array( 'その他のお問い合わせ' );
}

/**
 * Handle a submission. Returns [ 'status' => 'sent'|'error'|'', 'errors' => [], 'values' => [] ].
 *
 * @return array
 */
function wanko_contact_handle() {
	$result = array( 'status' => '', 'errors' => array(), 'values' => array() );
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! isset( $_POST['wanko_contact_nonce'] ) ) {
		return $result;
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wanko_contact_nonce'] ) ), 'wanko_contact' ) ) {
		$result['status']   = 'error';
		$result['errors'][] = 'フォームの有効期限が切れました。ページを再読み込みして、もう一度お試しください。';
		return $result;
	}
	// Honeypot.
	if ( ! empty( $_POST['wanko_website'] ) ) {
		$result['status'] = 'sent';
		return $result;
	}

	$v = array(
		'name'    => sanitize_text_field( wp_unslash( $_POST['wanko_name'] ?? '' ) ),
		'email'   => sanitize_email( wp_unslash( $_POST['wanko_email'] ?? '' ) ),
		'tel'     => sanitize_text_field( wp_unslash( $_POST['wanko_tel'] ?? '' ) ),
		'type'    => sanitize_text_field( wp_unslash( $_POST['wanko_type'] ?? '' ) ),
		'message' => sanitize_textarea_field( wp_unslash( $_POST['wanko_message'] ?? '' ) ),
		'agree'   => ! empty( $_POST['wanko_agree'] ),
	);
	$result['values'] = $v;

	if ( ! in_array( $v['type'], wanko_contact_types(), true ) ) {
		$result['errors'][] = 'お問い合わせ種別を選択してください。';
	}
	if ( '' === $v['name'] ) {
		$result['errors'][] = 'お名前を入力してください。';
	}
	if ( '' === $v['email'] || ! is_email( $v['email'] ) ) {
		$result['errors'][] = 'メールアドレスを正しく入力してください。';
	}
	if ( '' === $v['message'] ) {
		$result['errors'][] = 'お問い合わせ内容を入力してください。';
	}
	if ( ! $v['agree'] ) {
		$result['errors'][] = 'プライバシーポリシーへの同意が必要です。';
	}
	if ( $result['errors'] ) {
		$result['status'] = 'error';
		return $result;
	}

	$to      = wanko_get( 'company_email' ) ? wanko_get( 'company_email' ) : get_option( 'admin_email' );
	$site    = get_bloginfo( 'name' );
	$subject = sprintf( '【%s】お問い合わせ（%s）', $site, $v['type'] );
	$body    = "ウェブサイトのお問い合わせフォームから送信されました。\n\n"
		. "■お問い合わせ種別\n" . $v['type'] . "\n\n"
		. "■お名前\n" . $v['name'] . "\n\n"
		. "■メールアドレス\n" . $v['email'] . "\n\n"
		. "■電話番号\n" . ( $v['tel'] ? $v['tel'] : '（未入力）' ) . "\n\n"
		. "■お問い合わせ内容\n" . $v['message'] . "\n\n"
		. "----\n送信日時: " . wp_date( 'Y-m-d H:i' ) . "\nIP: " . sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '' ) ) . "\n";
	$headers = array( 'Reply-To: ' . $v['name'] . ' <' . $v['email'] . '>' );
	$sent    = wp_mail( $to, $subject, $body, $headers );

	// 自動返信.
	if ( $sent ) {
		$auto = $v['name'] . " 様\n\nこの度は、" . $site . " へお問い合わせいただきありがとうございます。\n"
			. "以下の内容で受け付けいたしました。担当者より折り返しご連絡いたしますので、しばらくお待ちください。\n\n"
			. "■お問い合わせ種別\n" . $v['type'] . "\n\n"
			. "■お名前\n" . $v['name'] . "\n\n"
			. "■メールアドレス\n" . $v['email'] . "\n\n"
			. "■電話番号\n" . ( $v['tel'] ? $v['tel'] : '（未入力）' ) . "\n\n"
			. "■お問い合わせ内容\n" . $v['message'] . "\n\n----\n"
			. $site . "\n" . ( wanko_get( 'company_tel' ) ? 'TEL: ' . wanko_get( 'company_tel' ) . "\n" : '' ) . home_url( '/' ) . "\n";
		wp_mail( $v['email'], sprintf( '【%s】お問い合わせを受け付けました', $site ), $auto );
		$result['status'] = 'sent';
	} else {
		$result['status']   = 'error';
		$result['errors'][] = '送信に失敗しました。お手数ですが、お電話またはメールにてご連絡ください。';
	}
	return $result;
}

/**
 * Render the form.
 */
function wanko_contact_form() {
	$r = wanko_contact_handle();
	$v = wp_parse_args( $r['values'], array( 'name' => '', 'email' => '', 'tel' => '', 'type' => '', 'message' => '', 'agree' => false ) );

	if ( 'sent' === $r['status'] ) {
		?>
		<div class="form-thanks">
			<p class="form-thanks__title">お問い合わせを受け付けました</p>
			<p>ご入力いただいたメールアドレスに受付確認メールをお送りしました。担当者より折り返しご連絡いたしますので、しばらくお待ちください。</p>
			<p><a class="btn btn--ghost" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページへ戻る<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a></p>
		</div>
		<?php
		return;
	}
	?>
	<?php if ( $r['errors'] ) : ?>
		<ul class="form-errors">
			<?php foreach ( $r['errors'] as $e ) : ?><li><?php echo esc_html( $e ); ?></li><?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<form class="wform" method="post" action="<?php echo esc_url( get_permalink() . '#form' ); ?>" novalidate>
		<?php wp_nonce_field( 'wanko_contact', 'wanko_contact_nonce' ); ?>
		<p class="wform__hp" aria-hidden="true"><label>Website<input type="text" name="wanko_website" tabindex="-1" autocomplete="off"></label></p>

		<div class="wform__row">
			<label class="wform__label" for="wanko_type">お問い合わせ種別<span class="req">必須</span></label>
			<div class="wform__field">
				<select id="wanko_type" name="wanko_type" required>
					<option value="" <?php selected( $v['type'], '' ); ?>>選択してください</option>
					<?php foreach ( wanko_contact_types() as $t ) : ?>
						<option value="<?php echo esc_attr( $t ); ?>" <?php selected( $v['type'], $t ); ?>><?php echo esc_html( $t ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="wform__row">
			<label class="wform__label" for="wanko_name">お名前<span class="req">必須</span></label>
			<div class="wform__field"><input type="text" id="wanko_name" name="wanko_name" value="<?php echo esc_attr( $v['name'] ); ?>" placeholder="例）山田 花子" required autocomplete="name"></div>
		</div>
		<div class="wform__row">
			<label class="wform__label" for="wanko_email">メールアドレス<span class="req">必須</span></label>
			<div class="wform__field"><input type="email" id="wanko_email" name="wanko_email" value="<?php echo esc_attr( $v['email'] ); ?>" placeholder="例）info@example.com" required autocomplete="email"></div>
		</div>
		<div class="wform__row">
			<label class="wform__label" for="wanko_tel">電話番号<span class="opt">任意</span></label>
			<div class="wform__field"><input type="tel" id="wanko_tel" name="wanko_tel" value="<?php echo esc_attr( $v['tel'] ); ?>" placeholder="例）06-0000-0000" autocomplete="tel"></div>
		</div>
		<div class="wform__row">
			<label class="wform__label" for="wanko_message">お問い合わせ内容<span class="req">必須</span></label>
			<div class="wform__field"><textarea id="wanko_message" name="wanko_message" rows="7" required placeholder="お問い合わせ内容をご記入ください"><?php echo esc_textarea( $v['message'] ); ?></textarea></div>
		</div>
		<div class="wform__agree">
			<label><input type="checkbox" name="wanko_agree" value="1" <?php checked( $v['agree'] ); ?> required> <a href="<?php echo esc_url( wanko_page_url( 'privacy' ) ); ?>" target="_blank" rel="noopener">プライバシーポリシー</a>に同意します</label>
		</div>
		<div class="wform__submit">
			<button type="submit" class="btn btn--primary btn--lg">送信する<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></button>
		</div>
	</form>
	<?php
}
