<?php
/**
 * Row item for the news list.
 *
 * @package Wanko
 */
?>
<li class="news-item">
	<a class="news-item__link" href="<?php the_permalink(); ?>">
		<div class="post-meta"><?php wanko_post_meta(); ?></div>
		<span class="news-item__title"><?php the_title(); ?></span>
		<?php echo wanko_icon( 'arrow' ); // phpcs:ignore ?>
	</a>
</li>
