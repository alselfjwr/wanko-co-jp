<?php
/**
 * PRODUCTS – category cards.
 *
 * @package Wanko
 */
$terms = get_terms( array( 'taxonomy' => 'product_category', 'hide_empty' => false, 'parent' => 0 ) );
if ( ! $terms || is_wp_error( $terms ) ) {
	return;
}
?>
<div class="cat-grid cat-grid--<?php echo esc_attr( min( count( $terms ), 4 ) ); ?>">
	<?php foreach ( $terms as $term ) : ?>
		<?php wanko_product_category_card( $term ); ?>
	<?php endforeach; ?>
</div>
