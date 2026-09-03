<?php
/**
 * OUR PHILOSOPHY – 私たちの想い (top page teaser).
 *
 * @package Wanko
 */
$image = wanko_get( 'story_image' );
?>
<section class="section section--story" id="philosophy">
	<div class="container story<?php echo $image ? ' has-image' : ''; ?>">
		<?php if ( $image ) : ?>
			<figure class="story__image"><img src="<?php echo esc_url( $image ); ?>" alt="" loading="lazy"></figure>
		<?php endif; ?>
		<div class="story__text">
			<?php wanko_section_title( 'Our Philosophy', '私たちの想い', 'left' ); ?>
			<p class="story__catch"><?php echo esc_html( wanko_get( 'story_catch' ) ); ?></p>
			<p class="story__lead"><?php wanko_the_lines( 'story_lead' ); ?></p>
			<a class="btn btn--ghost" href="<?php echo esc_url( wanko_page_url( 'about' ) ); ?>">私たちについて<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
		</div>
	</div>
</section>
