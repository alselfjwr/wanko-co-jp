<?php
/**
 * Template Name: ブランド理念
 * Template Post Type: page
 *
 * @package Wanko
 */

get_header();
the_post();
wanko_page_hero( 'ブランド理念', 'Philosophy' );
wanko_breadcrumb( array(
	array( 'label' => '私たちについて', 'url' => wanko_page_url( 'about' ) ),
	array( 'label' => 'ブランド理念' ),
) );
$values = array_filter( array( wanko_get( 'value_1' ), wanko_get( 'value_2' ), wanko_get( 'value_3' ), wanko_get( 'value_4' ) ) );
?>
<section class="section purpose">
	<div class="container container--narrow text-center">
		<span class="eyebrow"><?php echo esc_html( wanko_get( 'company_name' ) ); ?></span>
		<h2 class="purpose__title">パーパス<span class="section-title__en">Purpose</span></h2>
		<p class="purpose__statement"><?php echo esc_html( wanko_get( 'purpose_title' ) ); ?></p>
		<p class="purpose__body"><?php wanko_the_lines( 'purpose_body' ); ?></p>
	</div>
</section>
<section class="section section--alt purpose">
	<div class="container container--narrow text-center">
		<span class="eyebrow">わたしたちがすること</span>
		<h2 class="purpose__title">ミッション<span class="section-title__en">Mission</span></h2>
		<p class="purpose__statement"><?php echo esc_html( wanko_get( 'mission_title' ) ); ?></p>
		<p class="purpose__body"><?php wanko_the_lines( 'mission_body' ); ?></p>
		<?php $video_id = wanko_youtube_id( wanko_get( 'movie_url' ) ); ?>
		<?php if ( $video_id ) : ?>
			<div class="movie-embed" style="margin-top:40px"><iframe src="https://www.youtube-nocookie.com/embed/<?php echo esc_attr( $video_id ); ?>?rel=0" title="<?php echo esc_attr( wanko_get( 'movie_title' ) ); ?>" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
		<?php endif; ?>
	</div>
</section>
<?php if ( $values ) : ?>
	<section class="section">
		<div class="container container--narrow">
			<div class="text-center"><span class="eyebrow">大切にしていること</span><h2 class="purpose__title">バリュー<span class="section-title__en">Value</span></h2></div>
			<ol class="num-blocks">
				<?php foreach ( array_values( $values ) as $i => $value ) : ?>
					<?php $parts = array_map( 'trim', explode( '：', $value, 2 ) ); ?>
					<li class="num-block">
						<h3 class="num-block__title"><span><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><em>／</em><?php echo esc_html( $parts[0] ); ?></h3>
						<?php if ( isset( $parts[1] ) ) : ?><p><?php echo esc_html( $parts[1] ); ?></p><?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>
<?php endif; ?>
<?php if ( get_the_content() ) : ?><section class="section"><div class="container container--narrow"><div class="prose prose--page"><?php the_content(); ?></div></div></section><?php endif; ?>
<section class="section section--tiles"><div class="container"><?php get_template_part( 'template-parts/company-tiles' ); ?></div></section>
<?php get_footer(); ?>
