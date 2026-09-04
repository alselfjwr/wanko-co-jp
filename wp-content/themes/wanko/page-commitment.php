<?php
/**
 * Template Name: 私たちのこだわり
 * Template Post Type: page
 *
 * @package Wanko
 */

get_header();
the_post();
wanko_page_hero( '私たちのこだわり', 'Commitment' );
wanko_breadcrumb( array(
	array( 'label' => '私たちについて', 'url' => wanko_page_url( 'about' ) ),
	array( 'label' => '私たちのこだわり' ),
) );
?>
<?php
$imgs = array(
	1 => wanko_get( 'commitment_image' ),
	2 => WANKO_URI . '/assets/img/photo-cat-food.jpg',
	3 => WANKO_URI . '/assets/img/photo-nyandeli.jpg',
	4 => wanko_get( 'story_image' ),
);
?>
<section class="section section--intro">
	<div class="container container--narrow text-center">
		<p class="quote-title"><?php echo esc_html( wanko_get( 'commitment_catch' ) ); ?></p>
		<p class="section-lead"><?php wanko_the_lines( 'commitment_lead' ); ?></p>
	</div>
</section>
<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
	<?php if ( ! wanko_get( "commitment_{$i}_title" ) ) { continue; } ?>
	<section class="alt-block<?php echo 0 === $i % 2 ? ' alt-block--reverse' : ''; ?><?php echo 1 === $i % 2 ? ' section--alt' : ''; ?>">
		<div class="container alt-block__inner">
			<figure class="alt-block__image"><img src="<?php echo esc_url( $imgs[ $i ] ); ?>" alt="" loading="lazy"></figure>
			<div class="alt-block__text">
				<span class="alt-block__num"><?php echo esc_html( sprintf( '%02d', $i ) ); ?></span>
				<h2 class="alt-block__title">「<?php echo esc_html( wanko_get( "commitment_{$i}_title" ) ); ?>」</h2>
				<div class="prose"><?php wanko_the_paragraphs( "commitment_{$i}_body" ); ?></div>
			</div>
		</div>
	</section>
<?php endfor; ?>
<?php if ( get_the_content() ) : ?>
	<section class="section"><div class="container container--narrow"><div class="prose prose--page"><?php the_content(); ?></div></div></section>
<?php endif; ?>
<section class="section section--tiles"><div class="container"><?php get_template_part( 'template-parts/company-tiles' ); ?></div></section>
<?php get_footer(); ?>
