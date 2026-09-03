<?php
/**
 * Front page.
 *
 * @package Wanko
 */

get_header();
$hero_image = wanko_get( 'hero_image' );
$btn_url    = wanko_get( 'hero_btn_url' );
if ( $btn_url && 0 === strpos( $btn_url, '/' ) ) {
	$btn_url = home_url( $btn_url );
}
?>

<section class="hero<?php echo $hero_image ? ' has-image' : ''; ?>">
	<div class="hero__bg" aria-hidden="true">
		<?php if ( $hero_image ) : ?>
			<img src="<?php echo esc_url( $hero_image ); ?>" alt="">
		<?php else : ?>
			<img src="<?php echo esc_url( WANKO_URI . '/assets/img/hero-default.svg' ); ?>" alt="">
		<?php endif; ?>
	</div>
	<div class="container hero__inner">
		<h1 class="hero__catch">
			<?php foreach ( preg_split( '/\r\n|\r|\n/', (string) wanko_get( 'hero_catch' ) ) as $line ) : ?>
				<?php if ( '' !== trim( $line ) ) : ?><span class="hero__line"><?php echo esc_html( $line ); ?></span><?php endif; ?>
			<?php endforeach; ?>
		</h1>
		<p class="hero__lead"><?php wanko_the_lines( 'hero_lead' ); ?></p>
		<?php if ( wanko_get( 'hero_btn_label' ) ) : ?>
			<a class="btn btn--primary btn--lg" href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( wanko_get( 'hero_btn_label' ) ); ?><?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
		<?php endif; ?>
	</div>
	<div class="hero__scroll" aria-hidden="true"><span>Scroll</span></div>
</section>

<?php
$news = new WP_Query( array(
	'post_type'           => 'post',
	'posts_per_page'      => 4,
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
) );
if ( $news->have_posts() ) :
	?>
	<section class="section section--news" id="news">
		<div class="container">
			<div class="section-head">
				<?php wanko_section_title( 'News', 'お知らせ', 'left' ); ?>
				<a class="text-link" href="<?php echo esc_url( wanko_news_url() ); ?>">一覧を見る<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
			</div>
			<ul class="news-list">
				<?php
				while ( $news->have_posts() ) :
					$news->the_post();
					get_template_part( 'template-parts/list-item' );
				endwhile;
				wp_reset_postdata();
				?>
			</ul>
		</div>
	</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/shops' ); ?>

<?php
$columns = new WP_Query( array(
	'post_type'      => 'column',
	'posts_per_page' => 3,
	'no_found_rows'  => true,
) );
if ( $columns->have_posts() ) :
	?>
	<section class="section section--column" id="column">
		<div class="container">
			<div class="section-head">
				<?php wanko_section_title( 'Column', 'わんにゃんコラム', 'left' ); ?>
				<a class="text-link" href="<?php echo esc_url( get_post_type_archive_link( 'column' ) ); ?>">一覧を見る<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
			</div>
			<div class="card-grid">
				<?php
				while ( $columns->have_posts() ) :
					$columns->the_post();
					get_template_part( 'template-parts/card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/promise' ); ?>

<section class="section section--company-links">
	<div class="container">
		<?php wanko_section_title( 'Company', '企業情報' ); ?>
		<div class="link-grid">
			<a class="link-tile" href="<?php echo esc_url( wanko_page_url( 'company' ) . '#greeting' ); ?>">
				<span class="link-tile__en">Greeting</span>
				<span class="link-tile__ja">ごあいさつ</span>
				<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?>
			</a>
			<a class="link-tile" href="<?php echo esc_url( wanko_page_url( 'company' ) . '#overview' ); ?>">
				<span class="link-tile__en">Overview</span>
				<span class="link-tile__ja">会社概要</span>
				<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?>
			</a>
			<a class="link-tile" href="<?php echo esc_url( wanko_page_url( 'recruit' ) ); ?>">
				<span class="link-tile__en">Recruit</span>
				<span class="link-tile__ja">採用情報</span>
				<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?>
			</a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
