</main>

<?php if ( ! is_page( 'contact' ) && ! is_404() ) : ?>
	<?php get_template_part( 'template-parts/cta' ); ?>
<?php endif; ?>

<footer class="site-footer">
	<div class="container site-footer__inner">
		<div class="site-footer__brand">
			<?php wanko_the_logo(); ?>
			<?php if ( wanko_get( 'company_address' ) ) : ?>
				<p class="site-footer__address"><?php wanko_the_lines( 'company_address' ); ?></p>
			<?php endif; ?>
			<?php if ( wanko_get( 'footer_note' ) ) : ?>
				<p class="site-footer__note"><?php wanko_the_lines( 'footer_note' ); ?></p>
			<?php endif; ?>
			<?php
			$sns = array(
				'sns_instagram' => 'Instagram',
				'sns_x'         => 'X',
				'sns_line'      => 'LINE',
			);
			$has_sns = false;
			foreach ( $sns as $k => $label ) {
				if ( wanko_get( $k ) ) {
					$has_sns = true;
				}
			}
			if ( $has_sns ) :
				?>
				<ul class="site-footer__sns">
					<?php foreach ( $sns as $k => $label ) : ?>
						<?php if ( wanko_get( $k ) ) : ?>
							<li><a href="<?php echo esc_url( wanko_get( $k ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $label ); ?></a></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<nav class="site-footer__nav" aria-label="フッターナビゲーション">
			<?php foreach ( wanko_sitemap_tree() as $item ) : ?>
				<?php if ( ! empty( $item['children'] ) ) : ?>
					<div class="site-footer__group">
						<a class="site-footer__heading" href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
						<ul class="site-footer__list">
							<?php foreach ( $item['children'] as $child ) : ?>
								<li><a href="<?php echo esc_url( $child['url'] ); ?>"><?php echo esc_html( $child['label'] ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
			<div class="site-footer__group">
				<span class="site-footer__heading">メニュー</span>
				<ul class="site-footer__list">
					<?php foreach ( wanko_sitemap_tree() as $item ) : ?>
						<?php if ( empty( $item['children'] ) ) : ?>
							<li><a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
		</nav>
	</div>
	<div class="site-footer__bottom">
		<small>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></small>
	</div>
</footer>

<button class="to-top" type="button" aria-label="ページ上部へ戻る"><span></span></button>
<?php wp_footer(); ?>
</body>
</html>
