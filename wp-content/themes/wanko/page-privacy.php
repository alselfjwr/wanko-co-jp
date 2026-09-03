<?php
/**
 * Template Name: プライバシーポリシー
 * Template Post Type: page
 *
 * @package Wanko
 */

get_header();
the_post();
wanko_page_hero( 'プライバシーポリシー', 'Privacy Policy' );
wanko_breadcrumb( array( array( 'label' => 'プライバシーポリシー' ) ) );
?>
<section class="section">
	<div class="container container--narrow">
		<div class="prose prose--page prose--legal"><?php the_content(); ?></div>
	</div>
</section>
<?php get_footer(); ?>
