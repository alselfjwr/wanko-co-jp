<?php
/**
 * 私たちのお約束 – brand statement band (photo background) + three promises.
 *
 * @package Wanko
 */
$promise_image = wanko_get( 'promise_image' );
?>
<section class="section section--promise" id="promise">
	<div class="promise-band<?php echo $promise_image ? ' has-image' : ''; ?>">
		<?php if ( $promise_image ) : ?>
			<img class="promise-band__bg" src="<?php echo esc_url( $promise_image ); ?>" alt="" loading="lazy">
		<?php endif; ?>
		<div class="container promise-band__inner">
			<?php wanko_section_title( 'Our Promise', '私たちのお約束' ); ?>
			<p class="promise-band__catch"><?php echo esc_html( wanko_get( 'promise_catch' ) ); ?></p>
			<p class="promise-band__lead"><?php wanko_the_lines( 'promise_lead' ); ?></p>
		</div>
	</div>
	<div class="container">
		<ol class="promise-list">
			<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
				<li class="promise-item">
					<span class="promise-item__num"><?php echo esc_html( sprintf( '%02d', $i ) ); ?></span>
					<h3 class="promise-item__title"><?php echo esc_html( wanko_get( "promise_{$i}_title" ) ); ?></h3>
					<p class="promise-item__body"><?php wanko_the_lines( "promise_{$i}_body" ); ?></p>
				</li>
			<?php endfor; ?>
		</ol>
	</div>
</section>
