<?php
/**
 * Single post (お知らせ) and single column.
 *
 * @package Wanko
 */

get_header();
the_post();

$is_column = 'column' === get_post_type();
$root_ja   = $is_column ? 'わんこと暮らすコラム' : 'お知らせ';
$root_en   = $is_column ? 'Column' : 'News';
$root_url  = $is_column ? get_post_type_archive_link( 'column' ) : wanko_news_url();

wanko_page_hero( $root_ja, $root_en );
wanko_breadcrumb( array(
	array( 'label' => $root_ja, 'url' => $root_url ),
	array( 'label' => get_the_title() ),
) );
?>
<div class="container section">
	<article class="entry">
		<header class="entry__header">
			<div class="post-meta"><?php wanko_post_meta(); ?></div>
			<h1 class="entry__title"><?php the_title(); ?></h1>
		</header>
		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="entry__thumb"><?php the_post_thumbnail( 'post-thumbnail' ); ?></figure>
		<?php endif; ?>
		<?php if ( $is_column ) : ?>
			<nav class="toc" data-toc aria-label="目次" hidden>
				<p class="toc__title">目次</p>
				<ol class="toc__list"></ol>
			</nav>
		<?php endif; ?>
		<div class="entry__content prose" data-toc-source>
			<?php the_content(); ?>
		</div>
		<?php
		if ( $is_column ) {
			$tags = get_the_terms( get_the_ID(), 'column_tag' );
			if ( $tags && ! is_wp_error( $tags ) ) {
				echo '<ul class="tag-list">';
				foreach ( $tags as $tag ) {
					printf( '<li><a href="%s">#%s</a></li>', esc_url( get_term_link( $tag ) ), esc_html( $tag->name ) );
				}
				echo '</ul>';
			}
		}
		?>
	</article>

	<?php
	if ( $is_column ) :
		$related = wanko_related_columns( get_the_ID() );
		if ( $related->have_posts() ) :
			?>
			<section class="related">
				<?php wanko_section_title( 'Related', '関連記事', 'left' ); ?>
				<div class="card-grid">
					<?php
					while ( $related->have_posts() ) :
						$related->the_post();
						get_template_part( 'template-parts/card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</section>
		<?php endif; ?>
	<?php endif; ?>

	<nav class="post-nav" aria-label="前後の記事">
		<?php
		$prev = get_previous_post();
		$next = get_next_post();
		?>
		<div class="post-nav__item post-nav__item--prev">
			<?php if ( $prev ) : ?>
				<a href="<?php echo esc_url( get_permalink( $prev ) ); ?>"><span>前の記事</span><?php echo esc_html( get_the_title( $prev ) ); ?></a>
			<?php endif; ?>
		</div>
		<a class="btn btn--ghost" href="<?php echo esc_url( $root_url ); ?>">一覧へ戻る</a>
		<div class="post-nav__item post-nav__item--next">
			<?php if ( $next ) : ?>
				<a href="<?php echo esc_url( get_permalink( $next ) ); ?>"><span>次の記事</span><?php echo esc_html( get_the_title( $next ) ); ?></a>
			<?php endif; ?>
		</div>
	</nav>
</div>
<?php get_footer(); ?>
