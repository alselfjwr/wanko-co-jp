<?php
/**
 * 企業情報 photo tiles (bottom of inner pages / top page).
 *
 * @package Wanko
 */
$img = WANKO_URI . '/assets/img/';
?>
<div class="tile-grid tile-grid--4">
	<?php
	wanko_photo_tile( array( 'url' => wanko_page_url( 'about/message' ), 'image' => wanko_get( 'story_image' ), 'ja' => 'ごあいさつ' ) );
	wanko_photo_tile( array( 'url' => wanko_page_url( 'about/philosophy' ), 'image' => $img . 'photo-all-pets.jpg', 'ja' => 'パーパス・ブランド理念' ) );
	wanko_photo_tile( array( 'url' => wanko_page_url( 'company' ), 'image' => $img . 'photo-cat-goods.jpg', 'ja' => '会社概要' ) );
	wanko_photo_tile( array( 'url' => wanko_page_url( 'about/commitment' ), 'image' => wanko_get( 'commitment_image' ), 'ja' => '私たちのこだわり' ) );
	?>
</div>
