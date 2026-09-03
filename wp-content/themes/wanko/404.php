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
		<img class="mascot" src="<?php echo esc_url( WANKO_URI . '/assets/img/mascot.png' ); ?>" alt="" width="160" height="200">
		<p>お探しのページは移動または削除された可能性があります。</p>
		<p><a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページへ戻る</a></p>
	</div>
</section>
<?php get_footer(); ?>
