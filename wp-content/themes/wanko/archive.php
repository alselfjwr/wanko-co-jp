<?php
/**
 * Generic archive (column CPT, column categories, post categories).
 *
 * @package Wanko
 */

get_header();

$is_column = is_post_type_archive( 'column' ) || is_tax( 'column_category' ) || is_tax( 'column_tag' ) || 'column' === get_post_type();
$root_ja   = $is_column ? 'わんこと暮らすコラム' : 'お知らせ';
$root_en   = $is_column ? 'Column' : 'News';
$root_url  = $is_column ? get_post_type_archive_link( 'column' ) : wanko_news_url();

$crumbs = array();
if ( is_tax() || is_category() ) {
	$crumbs[] = array( 'label' => $root_ja, 'url' => $root_url );
	$crumbs[] = array( 'label' => single_term_title( '', false ) );
} else {
	$crumbs[] = array( 'label' => $root_ja );
}

wanko_page_hero( $root_ja, $root_en );
wanko_breadcrumb( $crumbs );
?>
<div class="container section">
	<?php if ( is_tax() || is_category() ) : ?>
		<p class="archive-filter">カテゴリー：<strong><?php single_term_title(); ?></strong></p>
	<?php endif; ?>

	<?php if ( $is_column ) : ?>
		<?php $terms = get_terms( array( 'taxonomy' => 'column_category', 'hide_empty' => true ) ); ?>
		<?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
			<ul class="term-nav">
				<li><a class="<?php echo is_post_type_archive( 'column' ) ? 'is-active' : ''; ?>" href="<?php echo esc_url( $root_url ); ?>">すべて</a></li>
				<?php foreach ( $terms as $term ) : ?>
					<li><a class="<?php echo is_tax( 'column_category', $term->term_id ) ? 'is-active' : ''; ?>" href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<?php if ( $is_column ) : ?>
			<div class="card-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/card' );
				endwhile;
				?>
			</div>
		<?php else : ?>
			<ul class="news-list news-list--archive">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/list-item' );
				endwhile;
				?>
			</ul>
		<?php endif; ?>
		<?php the_posts_pagination( array( 'prev_text' => '前へ', 'next_text' => '次へ', 'mid_size' => 1 ) ); ?>
	<?php else : ?>
		<p class="empty-note">まだ記事がありません。</p>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
