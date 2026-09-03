<?php
/**
 * カテゴリ別商品一覧 (/products/{category}/).
 *
 * @package Wanko
 */

get_header();
$term = get_queried_object();
wanko_page_hero( $term->name, 'Products' );
wanko_breadcrumb( array(
	array( 'label' => '商品紹介', 'url' => get_post_type_archive_link( 'products' ) ),
	array( 'label' => $term->name ),
) );
$siblings = get_terms( array( 'taxonomy' => 'product_category', 'hide_empty' => false, 'parent' => 0 ) );
?>
<div class="container section">
	<?php if ( $siblings && ! is_wp_error( $siblings ) ) : ?>
		<nav class="term-nav" aria-label="商品カテゴリー">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'products' ) ); ?>">すべて</a>
			<?php foreach ( $siblings as $t ) : ?>
				<a class="<?php echo $t->term_id === $term->term_id ? 'is-active' : ''; ?>" href="<?php echo esc_url( get_term_link( $t ) ); ?>"><?php echo esc_html( $t->name ); ?></a>
			<?php endforeach; ?>
		</nav>
	<?php endif; ?>
	<?php if ( $term->description ) : ?><p class="product-group__desc"><?php echo esc_html( $term->description ); ?></p><?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<div class="product-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				wanko_product_card();
			endwhile;
			?>
		</div>
		<?php the_posts_pagination( array( 'prev_text' => '前へ', 'next_text' => '次へ', 'mid_size' => 1 ) ); ?>
	<?php else : ?>
		<p class="empty-note">このカテゴリーの商品は準備中です。</p>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
