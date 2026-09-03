<?php
/**
 * こだわりのペットフード (EC banner) section – dog / cat photo cards + general shop banner.
 *
 * @package Wanko
 */
?>
<section class="section section--shops" id="shops">
	<div class="container">
		<?php wanko_section_title( 'Pet Food', 'こだわりのペットフード' ); ?>
		<p class="section-lead">わんちゃん・ねこちゃんそれぞれに合わせたフードを、専門のオンラインショップからご自宅へお届けします。</p>
		<div class="shop-grid">
			<?php
			wanko_shop_card( 'dog', 'dog' );
			wanko_shop_card( 'cat', 'cat' );
			?>
		</div>
		<?php wanko_shop_card( 'all', 'shop', 'banner' ); ?>
	</div>
</section>
