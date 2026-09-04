<?php
/**
 * 商品詳細.
 *
 * @package Wanko
 */

get_header();
the_post();
$terms   = get_the_terms( get_the_ID(), 'product_category' );
$term    = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
$buy_url = wanko_product( 'buy_url' );
$buy_lbl = wanko_product( 'buy_label' ) ? wanko_product( 'buy_label' ) : '商品を購入する';
$crumbs  = array( array( 'label' => '商品紹介', 'url' => get_post_type_archive_link( 'products' ) ) );
if ( $term ) {
	$crumbs[] = array( 'label' => $term->name, 'url' => get_term_link( $term ) );
}
$crumbs[] = array( 'label' => get_the_title() );
wanko_breadcrumb( $crumbs );
?>
<article class="product">
	<div class="container section product__top">
		<?php
		// Gallery: featured image + other images uploaded to this product (max 5).
		$gallery = array();
		if ( has_post_thumbnail() ) {
			$gallery[] = get_post_thumbnail_id();
		}
		foreach ( get_attached_media( 'image', get_the_ID() ) as $att ) {
			if ( ! in_array( $att->ID, $gallery, true ) ) {
				$gallery[] = $att->ID;
			}
		}
		$gallery = array_slice( $gallery, 0, 5 );
		?>
		<div class="product__gallery" data-gallery>
			<div class="product__main">
				<?php if ( $gallery ) : ?>
					<?php echo wp_get_attachment_image( $gallery[0], 'large', false, array( 'data-gallery-main' => '' ) ); ?>
				<?php else : ?>
					<div class="thumb-placeholder thumb-placeholder--square"><?php echo wanko_icon( 'box' ); // phpcs:ignore ?></div>
				<?php endif; ?>
			</div>
			<?php if ( count( $gallery ) > 1 ) : ?>
				<ul class="product__thumbs">
					<?php foreach ( $gallery as $i => $att_id ) : ?>
						<li><button type="button" class="<?php echo 0 === $i ? 'is-active' : ''; ?>" data-full="<?php echo esc_url( wp_get_attachment_image_url( $att_id, 'large' ) ); ?>"><?php echo wp_get_attachment_image( $att_id, 'thumbnail' ); ?></button></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
		<div class="product__summary">
			<?php if ( $term ) : ?><a class="product__cat" href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a><?php endif; ?>
			<h1 class="product__name"><?php the_title(); ?></h1>
			<?php if ( wanko_product( 'catch' ) ) : ?><p class="product__catch"><?php echo esc_html( wanko_product( 'catch' ) ); ?></p><?php endif; ?>
			<?php if ( get_the_excerpt() ) : ?><p class="product__desc"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
			<?php if ( wanko_product( 'price' ) ) : ?><p class="product__price"><?php echo esc_html( wanko_product( 'price' ) ); ?></p><?php endif; ?>
			<?php if ( $buy_url ) : ?>
				<a class="btn btn--primary btn--lg product__buy" href="<?php echo esc_url( $buy_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $buy_lbl ); ?><?php echo wanko_icon( 'ext' ); // phpcs:ignore ?></a>
				<p class="product__buy-note">ECサイトへ移動します</p>
			<?php else : ?>
				<a class="btn btn--ghost product__buy" href="<?php echo esc_url( wanko_page_url( 'contact' ) ); ?>">この商品について問い合わせる<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
			<?php endif; ?>
		</div>
	</div>

	<?php $has_points = wanko_product( 'point1_ttl' ) || wanko_product( 'point2_ttl' ) || wanko_product( 'point3_ttl' ); ?>
	<?php if ( $has_points ) : ?>
		<section class="section section--alt">
			<div class="container">
				<?php wanko_section_title( 'Point', 'この商品の特徴' ); ?>
				<ol class="point-list">
					<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
						<?php if ( ! wanko_product( "point{$i}_ttl" ) ) { continue; } ?>
						<li class="point-item">
							<span class="point-item__num">POINT <?php echo esc_html( sprintf( '%02d', $i ) ); ?></span>
							<h3 class="point-item__title"><?php echo esc_html( wanko_product( "point{$i}_ttl" ) ); ?></h3>
							<p class="point-item__body"><?php echo nl2br( esc_html( wanko_product( "point{$i}_txt" ) ) ); // phpcs:ignore ?></p>
						</li>
					<?php endfor; ?>
				</ol>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( get_the_content() ) : ?>
		<section class="section">
			<div class="container container--narrow">
				<?php wanko_section_title( 'About', '商品について' ); ?>
				<div class="prose"><?php the_content(); ?></div>
			</div>
		</section>
	<?php endif; ?>

	<?php $recommend = wanko_lines_to_array( wanko_product( 'recommend' ) ); ?>
	<?php if ( $recommend ) : ?>
		<section class="section section--alt">
			<div class="container container--narrow">
				<?php wanko_section_title( 'Recommend', 'こんな子におすすめ' ); ?>
				<ul class="check-list">
					<?php foreach ( $recommend as $line ) : ?><li><?php echo esc_html( $line ); ?></li><?php endforeach; ?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

	<?php
	$rows = array();
	foreach ( wanko_product_spec_rows() as $label => $key ) {
		if ( '' !== trim( wanko_product( $key ) ) ) {
			$rows[ $label ] = wanko_product( $key );
		}
	}
	?>
	<?php if ( $rows ) : ?>
		<section class="section">
			<div class="container container--narrow">
				<?php wanko_section_title( 'Information', '商品情報' ); ?>
				<table class="spec-table"><tbody>
					<?php foreach ( $rows as $label => $value ) : ?>
						<tr><th scope="row"><?php echo esc_html( $label ); ?></th><td><?php echo nl2br( esc_html( $value ) ); // phpcs:ignore ?></td></tr>
					<?php endforeach; ?>
				</tbody></table>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $buy_url ) : ?>
		<section class="section section--alt text-center">
			<div class="container container--narrow">
				<?php wanko_section_title( 'Shop', '購入する' ); ?>
				<p class="section-lead">この商品はオンラインショップでご購入いただけます。</p>
				<a class="btn btn--primary btn--lg" href="<?php echo esc_url( $buy_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $buy_lbl ); ?><?php echo wanko_icon( 'ext' ); // phpcs:ignore ?></a>
			</div>
		</section>
	<?php endif; ?>

	<?php
	$related = new WP_Query( array(
		'post_type'      => 'products',
		'posts_per_page' => 3,
		'post__not_in'   => array( get_the_ID() ),
		'no_found_rows'  => true,
		'tax_query'      => $term ? array( array( 'taxonomy' => 'product_category', 'field' => 'term_id', 'terms' => $term->term_id ) ) : array(), // phpcs:ignore WordPress.DB.SlowDBQuery
	) );
	if ( $related->have_posts() ) :
		?>
		<section class="section">
			<div class="container">
				<?php wanko_section_title( 'Related', '関連商品' ); ?>
				<div class="product-grid">
					<?php
					while ( $related->have_posts() ) :
						$related->the_post();
						wanko_product_card();
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<div class="container section-more text-center" style="padding-bottom:64px">
		<a class="btn btn--ghost" href="<?php echo esc_url( $term ? get_term_link( $term ) : get_post_type_archive_link( 'products' ) ); ?>">商品一覧へ戻る</a>
	</div>
</article>
<?php get_footer(); ?>
