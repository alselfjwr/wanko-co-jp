<?php
/**
 * こだわりのペットフード – EC service tiles.
 *
 * @package Wanko
 */
?>
<section class="section section--alt section--shops" id="shops">
	<div class="container">
		<?php wanko_section_title( 'Pet Food', 'こだわりのペットフード' ); ?>
		<p class="section-lead">わんちゃん・ねこちゃんそれぞれに合わせたフードを、<br>専門のオンラインショップからご自宅へお届けします。</p>
		<div class="shop-grid">
			<?php
			wanko_shop_card( 'cat' );
			wanko_shop_card( 'dog' );
			wanko_shop_card( 'all' );
			?>
		</div>
	</div>
</section>
