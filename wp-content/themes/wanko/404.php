<?php
/**
 * 404 page.
 *
 * @package Wanko
 */

get_header();
wanko_page_hero( 'ページが見つかりません', '404 Not Found' );
?>
<section class="section">
	<div class="container container--narrow text-center">
		<div class="thumb-placeholder thumb-placeholder--lg"><?php echo wanko_icon( 'dog' ); // phpcs:ignore ?></div>
		<p>お探しのページは移動または削除された可能性があります。</p>
		<p><a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページへ戻る</a></p>
	</div>
</section>
<?php get_footer(); ?>
