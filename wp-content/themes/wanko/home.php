<?php
/**
 * News (posts) archive – assigned as "投稿ページ".
 *
 * @package Wanko
 */

get_header();
wanko_page_hero( 'お知らせ', 'News' );
wanko_breadcrumb( array( array( 'label' => 'お知らせ' ) ) );
?>
<div class="container section">
	<?php if ( have_posts() ) : ?>
		<ul class="news-list news-list--archive">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/list-item' );
			endwhile;
			?>
		</ul>
		<?php the_posts_pagination( array( 'prev_text' => '前へ', 'next_text' => '次へ', 'mid_size' => 1 ) ); ?>
	<?php else : ?>
		<p class="empty-note">現在、お知らせはありません。</p>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
