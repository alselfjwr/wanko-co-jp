<?php
/**
 * Template Name: 採用情報
 * Template Post Type: page
 *
 * @package Wanko
 */

get_header();
the_post();
wanko_page_hero( '採用情報', 'Recruit' );
wanko_breadcrumb( array( array( 'label' => '採用情報' ) ) );
?>
<section class="section">
	<div class="container">
		<?php wanko_section_title( 'Message', '一緒に働く仲間を募集しています' ); ?>
		<p class="section-lead"><?php wanko_the_lines( 'recruit_lead' ); ?></p>
		<?php if ( wanko_get( 'recruit_body' ) ) : ?>
			<div class="prose prose--narrow"><?php wanko_the_paragraphs( 'recruit_body' ); ?></div>
		<?php endif; ?>
	</div>
</section>

<section class="section section--alt">
	<div class="container">
		<?php wanko_section_title( 'Commitment', '大切にしていること' ); ?>
		<ol class="promise-list promise-list--4">
			<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
				<?php if ( ! wanko_get( "commitment_{$i}_title" ) ) { continue; } ?>
				<li class="promise-item">
					<span class="promise-item__num"><?php echo esc_html( sprintf( '%02d', $i ) ); ?></span>
					<h3 class="promise-item__title"><?php echo esc_html( wanko_get( "commitment_{$i}_title" ) ); ?></h3>
					<p class="promise-item__body"><?php wanko_the_lines( "commitment_{$i}_body" ); ?></p>
				</li>
			<?php endfor; ?>
		</ol>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="prose prose--page"><?php the_content(); ?></div>
	</div>
</section>

<?php get_footer(); ?>
