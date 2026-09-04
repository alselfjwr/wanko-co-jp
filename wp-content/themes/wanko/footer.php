</main>

<?php if ( ! is_page( 'contact' ) && ! is_404() ) : ?>
	<?php get_template_part( 'template-parts/cta' ); ?>
<?php endif; ?>

<footer class="site-footer">
	<div class="container site-footer__inner">
		<nav class="site-footer__nav" aria-label="フッターナビゲーション">
			<div class="site-footer__group site-footer__group--products">
				<a class="site-footer__heading" href="<?php echo esc_url( get_post_type_archive_link( 'products' ) ); ?>">商品紹介</a>
				<div class="site-footer__cols">
					<?php
					$fterms = get_terms( array( 'taxonomy' => 'product_category', 'hide_empty' => false, 'parent' => 0 ) );
					if ( $fterms && ! is_wp_error( $fterms ) ) :
						foreach ( $fterms as $fterm ) :
							$fq = new WP_Query( array( 'post_type' => 'products', 'posts_per_page' => 12, 'no_found_rows' => true, 'orderby' => 'menu_order', 'order' => 'ASC', 'tax_query' => array( array( 'taxonomy' => 'product_category', 'field' => 'term_id', 'terms' => $fterm->term_id ) ) ) ); // phpcs:ignore WordPress.DB.SlowDBQuery
							?>
							<div class="site-footer__col">
								<a class="site-footer__sub" href="<?php echo esc_url( get_term_link( $fterm ) ); ?>"><?php echo esc_html( $fterm->name ); ?>一覧</a>
								<?php if ( $fq->have_posts() ) : ?>
									<ul class="site-footer__list">
										<?php while ( $fq->have_posts() ) : $fq->the_post(); ?>
											<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
										<?php endwhile; wp_reset_postdata(); ?>
									</ul>
								<?php endif; ?>
							</div>
							<?php
						endforeach;
					endif;
					?>
				</div>
			</div>
			<?php foreach ( wanko_sitemap_tree() as $item ) : ?>
				<?php if ( ! empty( $item['children'] ) && '商品紹介' !== $item['label'] ) : ?>
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
				<span class="site-footer__heading">お知らせ・コラム</span>
				<ul class="site-footer__list">
					<li><a href="<?php echo esc_url( wanko_news_url() ); ?>">お知らせ一覧</a></li>
					<li><a href="<?php echo esc_url( get_post_type_archive_link( 'column' ) ); ?>">コラム一覧</a></li>
					<li><a href="<?php echo esc_url( wanko_page_url( 'contact' ) ); ?>">お問い合わせ</a></li>
				</ul>
			</div>
		</nav>
	</div>
	<div class="site-footer__bottom">
		<div class="container site-footer__bottom-inner">
			<div class="site-footer__brand"><?php wanko_the_logo(); ?></div>
			<ul class="site-footer__small">
				<li><a href="<?php echo esc_url( wanko_page_url( 'company' ) ); ?>">会社概要</a></li>
				<li><a href="<?php echo esc_url( wanko_page_url( 'privacy' ) ); ?>">プライバシーポリシー</a></li>
				<li><a href="<?php echo esc_url( wanko_page_url( 'sitemap' ) ); ?>">サイトマップ</a></li>
			</ul>
			<?php
			$sns = array( 'sns_x' => 'X', 'sns_instagram' => 'Instagram', 'sns_line' => 'LINE' );
			$has = false;
			foreach ( $sns as $k => $l ) { if ( wanko_get( $k ) ) { $has = true; } }
			if ( $has ) :
				?>
				<ul class="site-footer__sns">
					<?php foreach ( $sns as $k => $l ) : ?>
						<?php if ( wanko_get( $k ) ) : ?><li><a href="<?php echo esc_url( wanko_get( $k ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $l ); ?></a></li><?php endif; ?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<small class="site-footer__copy">Copyright &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></small>
		</div>
	</div>
</footer>

<button class="to-top" type="button" aria-label="ページ上部へ戻る"><span></span></button>
<?php wp_footer(); ?>
</body>
</html>
