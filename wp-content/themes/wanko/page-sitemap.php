<?php
/**
 * Template Name: サイトマップ
 * Template Post Type: page
 *
 * @package Wanko
 */

get_header();
the_post();
wanko_page_hero( 'サイトマップ', 'Sitemap' );
wanko_breadcrumb( array( array( 'label' => 'サイトマップ' ) ) );
?>
<section class="section">
	<div class="container container--narrow">
		<ul class="sitemap-list">
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページ</a></li>
			<?php foreach ( wanko_sitemap_tree() as $item ) : ?>
				<li>
					<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
					<?php if ( ! empty( $item['children'] ) ) : ?>
						<ul>
							<?php foreach ( $item['children'] as $child ) : ?>
								<li><a href="<?php echo esc_url( $child['url'] ); ?>"><?php echo esc_html( $child['label'] ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
<?php get_footer(); ?>
