<?php
/**
 * Front page: MV → NEWS → PRODUCTS → PHILOSOPHY → COMMITMENT → COLUMN → COMPANY → (CTA in footer).
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
		<img src="<?php echo esc_url( $hero_image ? $hero_image : WANKO_URI . '/assets/img/hero-default.svg' ); ?>" alt="">
	</div>
	<div class="container hero__inner">
		<?php if ( wanko_get( 'hero_label' ) ) : ?><span class="hero__label"><?php echo esc_html( wanko_get( 'hero_label' ) ); ?></span><?php endif; ?>
		<h1 class="hero__catch">
			<?php foreach ( wanko_lines_to_array( wanko_get( 'hero_catch' ) ) as $line ) : ?>
				<span class="hero__line"><?php echo esc_html( $line ); ?></span>
			<?php endforeach; ?>
		</h1>
		<p class="hero__lead"><?php wanko_the_lines( 'hero_lead' ); ?></p>
		<?php if ( wanko_get( 'hero_btn_label' ) ) : ?>
			<a class="btn btn--outline-white" href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( wanko_get( 'hero_btn_label' ) ); ?><?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
		<?php endif; ?>
	</div>
	<div class="hero__scroll" aria-hidden="true"><span>Scroll</span></div>
</section>

<?php
$news = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3, 'ignore_sticky_posts' => true, 'no_found_rows' => true ) );
if ( $news->have_posts() ) :
	?>
	<section class="news-row" id="news">
		<div class="container news-row__inner">
			<h2 class="news-row__title">お知らせ</h2>
			<ul class="news-row__list">
				<?php
				while ( $news->have_posts() ) :
					$news->the_post();
					?>
					<li><a href="<?php the_permalink(); ?>"><time><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time><span><?php the_title(); ?></span></a></li>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</ul>
			<a class="text-link news-row__more" href="<?php echo esc_url( wanko_news_url() ); ?>">お知らせ一覧を見る<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
		</div>
	</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/shops' ); ?>

<?php
$columns = new WP_Query( array( 'post_type' => 'column', 'posts_per_page' => 3, 'no_found_rows' => true ) );
if ( $columns->have_posts() ) :
	?>
	<section class="section section--column" id="column">
		<div class="container">
			<div class="section-head">
				<?php wanko_section_title( 'Column', 'わんこと暮らすコラム', 'left' ); ?>
				<a class="text-link" href="<?php echo esc_url( get_post_type_archive_link( 'column' ) ); ?>">コラム一覧<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?></a>
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

<?php get_template_part( 'template-parts/commitment', null, array( 'compact' => true ) ); ?>

<?php get_template_part( 'template-parts/movie' ); ?>

<section class="section section--company-links" id="company">
	<div class="container">
		<?php wanko_section_title( 'Company', '企業情報' ); ?>
		<?php get_template_part( 'template-parts/company-tiles' ); ?>
	</div>
</section>

<?php get_footer(); ?>
