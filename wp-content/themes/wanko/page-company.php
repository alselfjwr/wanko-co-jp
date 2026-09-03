<?php
/**
 * Template Name: 企業情報
 * Template Post Type: page
 *
 * @package Wanko
 */

get_header();
the_post();
wanko_page_hero( '企業情報', 'Company' );
wanko_breadcrumb( array( array( 'label' => '企業情報' ) ) );
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
	<div class="container">
		<?php wanko_section_title( 'Greeting', 'ごあいさつ' ); ?>
		<div class="greeting<?php echo wanko_get( 'greeting_image' ) ? ' has-image' : ''; ?>">
			<?php if ( wanko_get( 'greeting_image' ) ) : ?>
				<figure class="greeting__image"><img src="<?php echo esc_url( wanko_get( 'greeting_image' ) ); ?>" alt="<?php echo esc_attr( wanko_get( 'greeting_name' ) ); ?>"></figure>
			<?php endif; ?>
			<div class="greeting__text">
				<h3 class="greeting__title"><?php echo esc_html( wanko_get( 'greeting_title' ) ); ?></h3>
				<div class="prose"><?php wanko_the_paragraphs( 'greeting_body' ); ?></div>
				<p class="greeting__name"><?php echo esc_html( wanko_get( 'greeting_name' ) ); ?></p>
			</div>
		</div>
	</div>
</section>

<section class="section section--alt" id="overview">
	<div class="container">
		<?php wanko_section_title( 'Overview', '会社概要' ); ?>
		<?php
		$rows = array(
			'会社名'   => 'company_name',
			'代表者'   => 'company_ceo',
			'設立'    => 'company_founded',
			'資本金'   => 'company_capital',
			'所在地'   => 'company_address',
			'電話番号'  => 'company_tel',
			'メール'   => 'company_email',
			'営業時間'  => 'company_hours',
			'事業内容'  => 'company_business',
		);
		?>
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
								<?php foreach ( array_filter( array_map( 'trim', explode( "\n", $value ) ) ) as $line ) : ?>
									<li><?php echo esc_html( $line ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php elseif ( 'company_email' === $key ) : ?>
							<a href="mailto:<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $value ); ?></a>
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
		<?php endif; ?>
		<?php if ( get_the_content() ) : ?>
			<div class="prose prose--page"><?php the_content(); ?></div>
		<?php endif; ?>
	</div>
</section>

<?php get_template_part( 'template-parts/promise' ); ?>

<?php get_footer(); ?>
