<?php
/**
 * Card item for column / news grids.
 *
 * @package Wanko
 */
?>
<article class="card">
	<a class="card__link" href="<?php the_permalink(); ?>">
		<div class="card__thumb"><?php wanko_the_thumbnail(); ?></div>
		<div class="card__body">
			<div class="post-meta"><?php wanko_post_meta(); ?></div>
			<h3 class="card__title"><?php the_title(); ?></h3>
			<p class="card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
		</div>
	</a>
</article>
