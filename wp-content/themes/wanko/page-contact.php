<?php
/**
 * Template Name: お問い合わせ
 * Template Post Type: page
 *
 * @package Wanko
 */

get_header();
the_post();
wanko_page_banner( 'お問い合わせ', 'Contact' );
wanko_breadcrumb( array( array( 'label' => 'お問い合わせ' ) ) );
$shortcode = wanko_get( 'contact_shortcode' );
?>
<section class="section">
	<div class="container container--narrow">
		<p class="section-lead"><?php wanko_the_lines( 'contact_lead' ); ?></p>

		<?php if ( wanko_get( 'company_tel' ) || wanko_get( 'company_email' ) ) : ?>
			<div class="contact-direct">
				<?php if ( wanko_get( 'company_tel' ) ) : ?>
					<div class="contact-direct__item">
						<span class="contact-direct__label">お電話でのお問い合わせ</span>
						<a class="contact-direct__value" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', wanko_get( 'company_tel' ) ) ); ?>"><?php echo esc_html( wanko_get( 'company_tel' ) ); ?></a>
						<?php if ( wanko_get( 'company_hours' ) ) : ?><span class="contact-direct__note"><?php echo esc_html( wanko_get( 'company_hours' ) ); ?></span><?php endif; ?>
					</div>
				<?php endif; ?>
				<?php if ( wanko_get( 'company_email' ) ) : ?>
					<div class="contact-direct__item">
						<span class="contact-direct__label">メールでのお問い合わせ</span>
						<a class="contact-direct__value" href="mailto:<?php echo esc_attr( wanko_get( 'company_email' ) ); ?>"><?php echo esc_html( wanko_get( 'company_email' ) ); ?></a>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="contact-form" id="form">
			<h2 class="contact-form__title">お問い合わせフォーム</h2>
			<?php if ( $shortcode ) : ?>
				<?php echo do_shortcode( wp_kses_post( $shortcode ) ); ?>
			<?php elseif ( get_the_content() ) : ?>
				<div class="prose"><?php the_content(); ?></div>
			<?php else : ?>
				<?php wanko_contact_form(); ?>
			<?php endif; ?>
		</div>

		<p class="contact-privacy">ご入力いただいた個人情報は、<a href="<?php echo esc_url( wanko_page_url( 'privacy' ) ); ?>">プライバシーポリシー</a>に基づき、お問い合わせへの対応および必要なご連絡のためにのみ利用します。</p>
	</div>
</section>
<?php get_footer(); ?>
