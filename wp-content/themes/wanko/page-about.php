<?php
/**
 * Template Name: 私たちについて（ハブ）
 * Template Post Type: page
 *
 * @package Wanko
 */

get_header();
the_post();
wanko_page_hero( '私たちについて', 'About Us' );
wanko_breadcrumb( array( array( 'label' => '私たちについて' ) ) );
?>
<?php get_template_part( 'template-parts/story' ); ?>

<section class="section section--alt">
	<div class="container">
		<div class="link-grid">
			<a class="link-tile link-tile--lg" href="<?php echo esc_url( wanko_page_url( 'about/message' ) ); ?>"><span class="link-tile__en">Message</span><span class="link-tile__ja">私たちの想い</span><span class="link-tile__desc">なぜこの事業を始めたのか、これから実現したいこと。</span><?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
			<a class="link-tile link-tile--lg" href="<?php echo esc_url( wanko_page_url( 'about/philosophy' ) ); ?>"><span class="link-tile__en">Philosophy</span><span class="link-tile__ja">ブランド理念</span><span class="link-tile__desc">PURPOSE・MISSION・VALUE。私たちの存在意義と約束。</span><?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
			<a class="link-tile link-tile--lg" href="<?php echo esc_url( wanko_page_url( 'about/commitment' ) ); ?>"><span class="link-tile__en">Commitment</span><span class="link-tile__ja">私たちのこだわり</span><span class="link-tile__desc">原材料・品質・安全・暮らし。4つのこだわり。</span><?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/commitment' ); ?>

<?php if ( get_the_content() ) : ?>
	<section class="section"><div class="container"><div class="prose prose--page"><?php the_content(); ?></div></div></section>
<?php endif; ?>
<?php get_footer(); ?>
