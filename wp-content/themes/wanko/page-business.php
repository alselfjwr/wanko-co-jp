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
		<?php wanko_section_title( 'Wholesale', 'ペット関連用品の卸販売' ); ?>
		<div class="feature">
			<div class="feature__icon"><?php echo wanko_icon( 'box' ); // phpcs:ignore ?></div>
			<div class="feature__text prose">
				<p>ペットフード、おやつ、日用品、トイレ用品など、ペット関連用品を小売店さま・法人さま向けに卸販売しています。取り扱いブランドの選定から在庫管理、配送まで一貫して対応し、安定した供給体制でお取引先さまの店舗運営を支えます。</p>
				<ul>
					<li>ペットショップ・動物病院・トリミングサロンさまへの卸販売</li>
					<li>ECサイト運営事業者さまへの商品供給</li>
					<li>小ロットからのご相談・新規お取引のご相談</li>
				</ul>
				<p><a class="btn btn--ghost" href="<?php echo esc_url( wanko_page_url( 'contact' ) ); ?>">お取引のご相談はこちら<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a></p>
			</div>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/shops' ); ?>

<?php if ( get_the_content() ) : ?>
	<section class="section">
		<div class="container">
			<div class="prose prose--page"><?php the_content(); ?></div>
		</div>
	</section>
<?php endif; ?>

<?php get_footer(); ?>
