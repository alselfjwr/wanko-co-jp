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
<section class="section philosophy">
	<div class="container container--narrow">
		<div class="philo-block philo-block--purpose">
			<span class="philo-block__en">Purpose</span>
			<span class="philo-block__ja">私たちの存在意義</span>
			<h2 class="philo-block__title"><?php echo esc_html( wanko_get( 'purpose_title' ) ); ?></h2>
			<p class="philo-block__body"><?php wanko_the_lines( 'purpose_body' ); ?></p>
		</div>
		<div class="philo-arrow" aria-hidden="true"></div>
		<div class="philo-block philo-block--mission">
			<span class="philo-block__en">Mission</span>
			<span class="philo-block__ja">私たちがすること</span>
			<h2 class="philo-block__title"><?php echo esc_html( wanko_get( 'mission_title' ) ); ?></h2>
			<p class="philo-block__body"><?php wanko_the_lines( 'mission_body' ); ?></p>
		</div>
		<?php if ( $values ) : ?>
			<div class="philo-arrow" aria-hidden="true"></div>
			<div class="philo-block philo-block--value">
				<span class="philo-block__en">Value</span>
				<span class="philo-block__ja">大切にしていること</span>
				<ul class="value-list">
					<?php foreach ( array_values( $values ) as $i => $value ) : ?>
						<?php $parts = array_map( 'trim', explode( '：', $value, 2 ) ); ?>
						<li>
							<span class="value-list__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
							<strong><?php echo esc_html( $parts[0] ); ?></strong>
							<?php if ( isset( $parts[1] ) ) : ?><span><?php echo esc_html( $parts[1] ); ?></span><?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
		<?php if ( get_the_content() ) : ?><div class="prose prose--page"><?php the_content(); ?></div><?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>
