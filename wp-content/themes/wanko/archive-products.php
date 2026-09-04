<?php
/**
 * 商品一覧 (/products/): grouped by top-level category.
 *
 * @package Wanko
 */

get_header();
wanko_page_hero( '商品紹介', 'Products' );
wanko_breadcrumb( array( array( 'label' => '商品紹介' ) ) );
$terms = get_terms( array( 'taxonomy' => 'product_category', 'hide_empty' => false, 'parent' => 0 ) );
?>
<div class="container section">
	<?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
		<?php foreach ( $terms as $term ) : ?>
			<?php
			$q = new WP_Query( array(
				'post_type'      => 'products',
				'posts_per_page' => -1,
				'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
				'no_found_rows'  => true,
				'tax_query'      => array( array( 'taxonomy' => 'product_category', 'field' => 'term_id', 'terms' => $term->term_id ) ), // phpcs:ignore WordPress.DB.SlowDBQuery
			) );
			?>
			<section class="product-group" id="cat-<?php echo esc_attr( $term->slug ); ?>">
				<div class="product-group__head">
					<span class="product-group__icon"><?php echo wanko_icon( 'food' === $term->slug ? 'dog' : ( 'treat' === $term->slug ? 'cat' : 'paw' ) ); // phpcs:ignore ?></span>
					<h2 class="product-group__title"><?php echo esc_html( $term->name ); ?>を探す</h2>
					<span class="product-group__sub">おすすめ<?php echo esc_html( $term->name ); ?></span>
				</div>
				<?php if ( $q->have_posts() ) : ?>
					<div class="product-grid">
						<?php
						while ( $q->have_posts() ) :
							$q->the_post();
							wanko_product_card();
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				<?php else : ?>
					<p class="empty-note">このカテゴリーの商品は準備中です。</p>
				<?php endif; ?>
				<p class="text-center section-more"><a class="btn btn--primary" href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?>一覧<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a></p>
			</section>
		<?php endforeach; ?>
	<?php else : ?>
		<p class="empty-note">商品は準備中です。</p>
	<?php endif; ?>
</div>
<?php get_template_part( 'template-parts/shops' ); ?>
<?php get_footer(); ?>
