<?php
/**
 * Front page: MV → NEWS → PRODUCTS → PHILOSOPHY → COMMITMENT → COLUMN → COMPANY → (CTA in footer).
 *
 * @package Wanko
 */

get_header();
$hero_image = wanko_get( 'hero_image' );
$btn_url    = wanko_get( 'hero_btn_url' );
if ( $btn_url && 0 === strpos( $btn_url, '/' ) ) {
	$btn_url = home_url( $btn_url );
}
?>

<section class="hero<?php echo $hero_image ? ' has-image' : ''; ?>">
	<div class="hero__bg" aria-hidden="true">
		<img src="<?php echo esc_url( $hero_image ? $hero_image : WANKO_URI . '/assets/img/hero-default.svg' ); ?>" alt="">
	</div>
	<div class="container hero__inner">
		<h1 class="hero__catch">
			<?php foreach ( wanko_lines_to_array( wanko_get( 'hero_catch' ) ) as $line ) : ?>
				<span class="hero__line"><?php echo esc_html( $line ); ?></span>
			<?php endforeach; ?>
		</h1>
		<p class="hero__lead"><?php wanko_the_lines( 'hero_lead' ); ?></p>
		<?php if ( wanko_get( 'hero_btn_label' ) ) : ?>
			<a class="btn btn--primary btn--lg" href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( wanko_get( 'hero_btn_label' ) ); ?><?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
		<?php endif; ?>
	</div>
	<div class="hero__scroll" aria-hidden="true"><span>Scroll</span></div>
</section>

<?php
$news = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3, 'ignore_sticky_posts' => true, 'no_found_rows' => true ) );
if ( $news->have_posts() ) :
	?>
	<section class="section section--news" id="news">
		<div class="container">
			<div class="section-head">
				<?php wanko_section_title( 'News', 'お知らせ', 'left' ); ?>
				<a class="text-link" href="<?php echo esc_url( wanko_news_url() ); ?>">お知らせ一覧<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
			</div>
			<ul class="news-list">
				<?php
				while ( $news->have_posts() ) :
					$news->the_post();
					get_template_part( 'template-parts/list-item' );
				endwhile;
				wp_reset_postdata();
				?>
			</ul>
		</div>
	</section>
<?php endif; ?>

<section class="section section--alt section--products" id="products">
	<div class="container">
		<?php wanko_section_title( 'Products', '商品紹介' ); ?>
		<p class="section-lead"><?php wanko_the_lines( 'products_lead' ); ?></p>
		<?php get_template_part( 'template-parts/product-categories' ); ?>
		<p class="text-center section-more"><a class="btn btn--primary" href="<?php echo esc_url( get_post_type_archive_link( 'products' ) ); ?>">商品一覧を見る<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a></p>
	</div>
</section>

<?php
$columns = new WP_Query( array( 'post_type' => 'column', 'posts_per_page' => 3, 'no_found_rows' => true ) );
if ( $columns->have_posts() ) :
	?>
	<section class="section section--column" id="column">
		<div class="container">
			<div class="section-head">
				<?php wanko_section_title( 'Column', 'わんこと暮らすコラム', 'left' ); ?>
				<a class="text-link" href="<?php echo esc_url( get_post_type_archive_link( 'column' ) ); ?>">コラム一覧<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
			</div>
			<div class="card-grid">
				<?php
				while ( $columns->have_posts() ) :
					$columns->the_post();
					get_template_part( 'template-parts/card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/commitment', null, array( 'compact' => true ) ); ?>

<?php get_template_part( 'template-parts/movie' ); ?>

<section class="section section--company-links" id="company">
	<div class="container company-intro">
		<div class="company-intro__text">
			<?php wanko_section_title( 'Company', '会社について', 'left' ); ?>
			<p><?php echo esc_html( wanko_get( 'company_name' ) ); ?>は、ペット用品・ペットおやつの卸売・販売と、ペットフードの定期便サービスを展開しています。</p>
			<dl class="company-intro__dl">
				<?php if ( wanko_get( 'company_ceo' ) ) : ?><div><dt>代表</dt><dd><?php echo esc_html( wanko_get( 'company_ceo' ) ); ?></dd></div><?php endif; ?>
				<?php if ( wanko_get( 'company_address' ) ) : ?><div><dt>所在地</dt><dd><?php wanko_the_lines( 'company_address' ); ?></dd></div><?php endif; ?>
			</dl>
			<a class="btn btn--ghost" href="<?php echo esc_url( wanko_page_url( 'company' ) ); ?>">会社概要<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
		</div>
		<div class="link-grid link-grid--col">
			<a class="link-tile" href="<?php echo esc_url( wanko_page_url( 'about/message' ) ); ?>"><span class="link-tile__en">Message</span><span class="link-tile__ja">私たちの想い</span><?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
			<a class="link-tile" href="<?php echo esc_url( wanko_page_url( 'business' ) ); ?>"><span class="link-tile__en">Business</span><span class="link-tile__ja">事業内容</span><?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
			<a class="link-tile" href="<?php echo esc_url( wanko_page_url( 'recruit' ) ); ?>"><span class="link-tile__en">Recruit</span><span class="link-tile__ja">採用情報</span><?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
