<?php
/**
 * Template Name: 企業情報
 * Template Post Type: page
 *
 * ごあいさつ／会社概要／私たちのお約束（ページ内リンク）.
 *
 * @package Wanko
 */

get_header();
the_post();
wanko_page_banner( '企業情報', 'Company' );
wanko_breadcrumb( array( array( 'label' => '企業情報' ) ) );
$rows = array(
	'会社名'   => 'company_name',
	'代表者'   => 'company_ceo',
	'設立'    => 'company_founded',
	'資本金'   => 'company_capital',
	'所在地'   => 'company_address',
	'電話番号'  => 'company_tel',
	'FAX'   => 'company_fax',
	'メール'   => 'company_email',
	'営業時間'  => 'company_hours',
	'事業内容'  => 'company_business',
);
$imgs = array(
	1 => wanko_get( 'commitment_image' ),
	2 => WANKO_URI . '/assets/img/photo-cat-food.jpg',
	3 => WANKO_URI . '/assets/img/photo-nyandeli.jpg',
	4 => wanko_get( 'story_image' ),
);
?>
<nav class="anchor-nav" aria-label="ページ内リンク">
	<div class="container">
		<ul>
			<li><a href="#greeting">ごあいさつ</a></li>
			<li><a href="#overview">会社概要</a></li>
			<li><a href="#promise">私たちのお約束</a></li>
		</ul>
	</div>
</nav>

<section class="section" id="greeting">
	<div class="container container--narrow">
		<?php wanko_section_title( 'Greeting', 'ごあいさつ' ); ?>
		<p class="quote-title text-center"><?php echo esc_html( wanko_get( 'greeting_title' ) ); ?></p>
		<div class="greeting<?php echo wanko_get( 'greeting_image' ) ? ' has-image' : ''; ?>">
			<?php if ( wanko_get( 'greeting_image' ) ) : ?>
				<figure class="greeting__image"><img src="<?php echo esc_url( wanko_get( 'greeting_image' ) ); ?>" alt="<?php echo esc_attr( wanko_get( 'greeting_name' ) ); ?>"></figure>
			<?php endif; ?>
			<div class="greeting__text">
				<div class="prose"><?php wanko_the_paragraphs( 'greeting_body' ); ?></div>
				<p class="greeting__name"><?php echo esc_html( wanko_get( 'greeting_name' ) ); ?></p>
			</div>
		</div>
		<?php if ( wanko_get( 'story_image' ) ) : ?>
			<figure class="story-hero"><img src="<?php echo esc_url( wanko_get( 'story_image' ) ); ?>" alt="" loading="lazy"></figure>
		<?php endif; ?>
	</div>
</section>

<section class="section section--alt" id="overview">
	<div class="container container--narrow">
		<?php wanko_section_title( 'Company', '会社概要' ); ?>
		<h3 class="company-name"><?php echo esc_html( wanko_get( 'company_name' ) ); ?></h3>
		<table class="spec-table spec-table--lines">
			<tbody>
			<?php foreach ( $rows as $label => $key ) : ?>
				<?php
				$value = wanko_get( $key );
				if ( '' === trim( (string) $value ) ) {
					continue;
				}
				?>
				<tr>
					<th scope="row"><?php echo esc_html( $label ); ?></th>
					<td>
						<?php if ( 'company_business' === $key ) : ?>
							<ul class="plain-list">
								<?php foreach ( wanko_lines_to_array( $value ) as $line ) : ?><li><?php echo esc_html( $line ); ?></li><?php endforeach; ?>
							</ul>
						<?php elseif ( 'company_email' === $key ) : ?>
							<a href="mailto:<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $value ); ?></a>
						<?php elseif ( 'company_tel' === $key ) : ?>
							<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $value ) ); ?>"><?php echo esc_html( $value ); ?></a>
						<?php else : ?>
							<?php echo nl2br( esc_html( $value ) ); // phpcs:ignore ?>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<?php if ( wanko_get( 'company_map' ) ) : ?>
			<div class="map-embed"><iframe src="<?php echo esc_url( wanko_get( 'company_map' ) ); ?>" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" title="所在地の地図"></iframe></div>
		<?php elseif ( wanko_get( 'company_address' ) ) : ?>
			<div class="map-embed"><iframe src="https://www.google.com/maps?q=<?php echo rawurlencode( preg_replace( '/^〒?\d{3}-?\d{4}\s*/u', '', str_replace( "\n", ' ', wanko_get( 'company_address' ) ) ) ); ?>&output=embed" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" title="所在地の地図"></iframe></div>
			<p class="text-right"><a class="btn btn--ghost btn--sm" href="https://www.google.com/maps/search/?api=1&query=<?php echo rawurlencode( str_replace( "\n", ' ', wanko_get( 'company_address' ) ) ); ?>" target="_blank" rel="noopener">Google Mapで見る<?php echo wanko_icon( 'ext' ); // phpcs:ignore ?></a></p>
		<?php endif; ?>
		<?php if ( get_the_content() ) : ?><div class="prose prose--page" style="margin-top:40px"><?php the_content(); ?></div><?php endif; ?>
	</div>
</section>

<section class="section" id="promise">
	<div class="container container--narrow text-center">
		<?php wanko_section_title( 'Commitment', '私たちのお約束' ); ?>
		<p class="quote-title"><?php echo esc_html( wanko_get( 'commitment_catch' ) ); ?></p>
		<p class="section-lead"><?php wanko_the_lines( 'commitment_lead' ); ?></p>
	</div>
	<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
		<?php if ( ! wanko_get( "commitment_{$i}_title" ) ) { continue; } ?>
		<div class="alt-block<?php echo 0 === $i % 2 ? ' alt-block--reverse' : ''; ?>">
			<div class="container alt-block__inner">
				<figure class="alt-block__image"><img src="<?php echo esc_url( $imgs[ $i ] ); ?>" alt=""></figure>
				<div class="alt-block__text">
					<span class="alt-block__num"><?php echo esc_html( sprintf( '%02d', $i ) ); ?></span>
					<h3 class="alt-block__title">「<?php echo esc_html( wanko_get( "commitment_{$i}_title" ) ); ?>」</h3>
					<div class="prose"><?php wanko_the_paragraphs( "commitment_{$i}_body" ); ?></div>
				</div>
			</div>
		</div>
	<?php endfor; ?>
</section>

<section class="section section--tiles"><div class="container"><?php get_template_part( 'template-parts/company-tiles' ); ?></div></section>
<?php get_footer(); ?>
