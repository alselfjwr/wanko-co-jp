<?php
/**
 * 私たちのお約束 section (used on the front page and the company page).
 *
 * @package Wanko
 */
?>
<section class="section section--promise" id="promise">
	<div class="container">
		<?php wanko_section_title( 'Our Promise', '私たちのお約束' ); ?>
		<p class="section-lead"><?php wanko_the_lines( 'promise_lead' ); ?></p>
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
