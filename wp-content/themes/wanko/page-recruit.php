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
		<?php wanko_section_title( 'Our Values', '大切にしていること' ); ?>
		<?php if ( wanko_get( 'recruit_values_lead' ) ) : ?>
			<p class="section-lead"><?php wanko_the_lines( 'recruit_values_lead' ); ?></p>
		<?php endif; ?>
		<ol class="value-cards">
			<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
				<?php if ( ! wanko_get( "recruit_value_{$i}_title" ) ) { continue; } ?>
				<li class="value-card">
					<span class="value-card__num"><?php echo esc_html( sprintf( '%02d', $i ) ); ?></span>
					<div class="value-card__text">
						<h3 class="value-card__title"><?php echo esc_html( wanko_get( "recruit_value_{$i}_title" ) ); ?></h3>
						<p class="value-card__body"><?php wanko_the_lines( "recruit_value_{$i}_body" ); ?></p>
					</div>
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
