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
		<nav class="term-nav" aria-label="商品カテゴリー">
			<?php foreach ( $terms as $term ) : ?>
				<a href="#cat-<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></a>
			<?php endforeach; ?>
		</nav>

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
				<div class="section-head">
					<h2 class="product-group__title"><?php echo esc_html( $term->name ); ?></h2>
					<a class="text-link" href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?>の一覧<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
				</div>
				<?php if ( $term->description ) : ?><p class="product-group__desc"><?php echo esc_html( $term->description ); ?></p><?php endif; ?>
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
			</section>
		<?php endforeach; ?>
	<?php else : ?>
		<p class="empty-note">商品は準備中です。</p>
	<?php endif; ?>
</div>
<?php get_template_part( 'template-parts/shops' ); ?>
<?php get_footer(); ?>
