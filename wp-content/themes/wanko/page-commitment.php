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
<?php get_template_part( 'template-parts/commitment' ); ?>

<?php if ( get_the_content() ) : ?>
	<section class="section"><div class="container container--narrow"><div class="prose prose--page"><?php the_content(); ?></div></div></section>
<?php endif; ?>
<?php get_footer(); ?>
