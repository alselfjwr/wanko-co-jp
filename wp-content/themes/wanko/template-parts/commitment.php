<?php
/**
 * COMMITMENT – 私たちのこだわり (photo band + 4 items). Used on the top page and the commitment page.
 *
 * @package Wanko
 */
$image = wanko_get( 'commitment_image' );
$link  = ! empty( $args['show_link'] );
?>
<section class="section section--promise" id="commitment">
	<div class="promise-band<?php echo $image ? ' has-image' : ''; ?>">
		<?php if ( $image ) : ?>
			<img class="promise-band__bg" src="<?php echo esc_url( $image ); ?>" alt="" loading="lazy">
		<?php endif; ?>
		<div class="container promise-band__inner">
			<?php wanko_section_title( 'Commitment', '私たちのこだわり' ); ?>
			<p class="promise-band__catch"><?php echo esc_html( wanko_get( 'commitment_catch' ) ); ?></p>
			<p class="promise-band__lead"><?php wanko_the_lines( 'commitment_lead' ); ?></p>
		</div>
	</div>
	<div class="container">
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
		<?php if ( $link ) : ?>
			<p class="text-center section-more"><a class="btn btn--ghost" href="<?php echo esc_url( wanko_page_url( 'about/commitment' ) ); ?>">こだわりをもっと見る<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a></p>
		<?php endif; ?>
	</div>
</section>
