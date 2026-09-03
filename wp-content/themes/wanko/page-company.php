<?php
/**
 * Template Name: 会社概要
 * Template Post Type: page
 *
 * @package Wanko
 */

get_header();
the_post();
wanko_page_hero( '会社概要', 'Company' );
wanko_breadcrumb( array( array( 'label' => '会社概要' ) ) );
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
?>
<section class="section" id="overview">
	<div class="container">
		<table class="spec-table">
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
		<?php endif; ?>
		<?php if ( get_the_content() ) : ?><div class="prose prose--page" style="margin-top:40px"><?php the_content(); ?></div><?php endif; ?>
		<div class="link-grid" style="margin-top:48px">
			<a class="link-tile" href="<?php echo esc_url( wanko_page_url( 'about/message' ) ); ?>"><span class="link-tile__en">Message</span><span class="link-tile__ja">私たちの想い</span><?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
			<a class="link-tile" href="<?php echo esc_url( wanko_page_url( 'business' ) ); ?>"><span class="link-tile__en">Business</span><span class="link-tile__ja">事業内容</span><?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
			<a class="link-tile" href="<?php echo esc_url( wanko_page_url( 'recruit' ) ); ?>"><span class="link-tile__en">Recruit</span><span class="link-tile__ja">採用情報</span><?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
		</div>
	</div>
</section>
<?php get_footer(); ?>
