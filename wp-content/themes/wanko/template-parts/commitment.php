<?php
/**
 * COMMITMENT – 私たちのこだわり.
 * - Top page (args.compact = true): photo left + text right (reference-site style).
 * - Commitment page: photo band + 4 items.
 *
 * @package Wanko
 */
$image   = wanko_get( 'commitment_image' );
$compact = ! empty( $args['compact'] );
?>
<?php if ( $compact ) : ?>
<section class="section section--alt section--commitment" id="commitment">
	<div class="container commitment<?php echo $image ? ' has-image' : ''; ?>">
		<?php if ( $image ) : ?>
			<figure class="commitment__image"><img src="<?php echo esc_url( $image ); ?>" alt="" width="1600" height="900"></figure>
		<?php endif; ?>
		<div class="commitment__text">
			<?php wanko_section_title( 'Commitment', '私たちのお約束', 'left' ); ?>
			<p class="commitment__catch"><?php echo esc_html( wanko_get( 'commitment_catch' ) ); ?></p>
			<p class="commitment__lead"><?php wanko_the_lines( 'commitment_lead' ); ?></p>
			<ol class="commitment__list">
				<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
					<?php if ( ! wanko_get( "commitment_{$i}_title" ) ) { continue; } ?>
					<li><span><?php echo esc_html( sprintf( '%02d', $i ) ); ?></span><?php echo esc_html( wanko_get( "commitment_{$i}_title" ) ); ?></li>
				<?php endfor; ?>
			</ol>
			<a class="btn btn--ghost" href="<?php echo esc_url( wanko_page_url( 'company' ) . '#promise' ); ?>">お約束を見る<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
		</div>
	</div>
</section>
<?php else : ?>
<section class="section section--promise" id="commitment">
	<div class="promise-band<?php echo $image ? ' has-image' : ''; ?>">
		<?php if ( $image ) : ?>
			<img class="promise-band__bg" src="<?php echo esc_url( $image ); ?>" alt="" loading="lazy">
		<?php endif; ?>
		<div class="container promise-band__inner">
			<?php wanko_section_title( 'Commitment', '私たちのお約束' ); ?>
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
	</div>
</section>
<?php endif; ?>
