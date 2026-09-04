<?php
/**
 * Template Name: 事業内容
 * Template Post Type: page
 *
 * @package Wanko
 */

get_header();
the_post();
wanko_page_hero( '事業内容', 'Business' );
wanko_breadcrumb( array( array( 'label' => '事業内容' ) ) );
?>
<section class="section" id="wholesale">
	<div class="container">
		<?php wanko_section_title( 'Wholesale', 'ペット用品・ペットおやつの卸売・販売' ); ?>
		<div class="feature">
			<div class="feature__icon"><?php echo wanko_icon( 'box' ); // phpcs:ignore ?></div>
			<div class="feature__text prose">
				<?php wanko_the_paragraphs( 'wholesale_body' ); ?>
				<ul>
					<li>ペットショップ・動物病院・トリミングサロンさまへの卸販売</li>
					<li>ECサイト運営事業者さまへの商品供給</li>
					<li>小ロットからのご注文・新規お取引のご相談</li>
				</ul>
				<p><a class="btn btn--ghost" href="<?php echo esc_url( wanko_page_url( 'contact' ) ); ?>">お取引のご相談はこちら<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a></p>
			</div>
		</div>
	</div>
</section>

<?php $partners = array_filter( array_map( 'trim', explode( "\n", (string) wanko_get( 'partners_list' ) ) ) ); ?>
<?php if ( $partners ) : ?>
	<section class="section section--partners" id="partners">
		<div class="container">
			<?php wanko_section_title( 'Partners', '主要取引メーカー' ); ?>
			<p class="section-lead">国内外の主要メーカーとのお取引により、豊富な品揃えと安定した供給を実現しています。（五十音順・敬称略）</p>
			<ul class="partner-list">
				<?php foreach ( $partners as $partner ) : ?>
					<li><?php echo esc_html( $partner ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/shops' ); ?>

<?php if ( get_the_content() ) : ?>
	<section class="section">
		<div class="container">
			<div class="prose prose--page"><?php the_content(); ?></div>
		</div>
	</section>
<?php endif; ?>

<section class="section section--tiles"><div class="container"><?php get_template_part( 'template-parts/company-tiles' ); ?></div></section>
<?php get_footer(); ?>
