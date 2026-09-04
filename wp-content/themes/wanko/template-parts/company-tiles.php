<?php
/**
 * 企業情報への導線（ごあいさつ／会社概要／採用情報）.
 *
 * @package Wanko
 */
$img     = WANKO_URI . '/assets/img/';
$company = wanko_page_url( 'company' );
?>
<div class="tile-grid tile-grid--3">
	<?php
	wanko_photo_tile( array( 'url' => $company . '#greeting', 'image' => wanko_get( 'story_image' ), 'ja' => 'ごあいさつ', 'en' => 'Greeting' ) );
	wanko_photo_tile( array( 'url' => $company . '#overview', 'image' => $img . 'photo-cat-goods.jpg', 'ja' => '会社概要', 'en' => 'Company' ) );
	wanko_photo_tile( array( 'url' => wanko_page_url( 'recruit' ), 'image' => $img . 'photo-all-pets.jpg', 'ja' => '採用情報', 'en' => 'Recruit' ) );
	?>
</div>
