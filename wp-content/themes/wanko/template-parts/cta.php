<?php
/**
 * Contact CTA band shown above the footer.
 *
 * @package Wanko
 */
?>
<section class="cta-band">
	<div class="container cta-band__inner">
		<div class="cta-band__text">
			<span class="cta-band__en">Contact</span>
			<h2 class="cta-band__title">お気軽にお問い合わせください</h2>
			<p><?php echo esc_html( wanko_get( 'contact_lead' ) ); ?></p>
		</div>
		<div class="cta-band__actions">
			<a class="btn btn--primary btn--lg" href="<?php echo esc_url( wanko_page_url( 'contact' ) ); ?>"><?php echo wanko_icon( 'mail' ); // phpcs:ignore ?>お問い合わせフォーム</a>
			<?php if ( wanko_get( 'company_tel' ) ) : ?>
				<a class="cta-band__tel" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', wanko_get( 'company_tel' ) ) ); ?>">TEL <?php echo esc_html( wanko_get( 'company_tel' ) ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>
