<?php
/**
 * Optional movie section (shown only when a YouTube URL is set).
 *
 * @package Wanko
 */
$video_id = wanko_youtube_id( wanko_get( 'movie_url' ) );
if ( ! $video_id ) {
	return;
}
?>
<section class="section section--movie" id="movie">
	<div class="container container--narrow">
		<?php wanko_section_title( 'Movie', wanko_get( 'movie_title' ) ); ?>
		<?php if ( wanko_get( 'movie_lead' ) ) : ?>
			<p class="section-lead"><?php wanko_the_lines( 'movie_lead' ); ?></p>
		<?php endif; ?>
		<div class="movie-embed">
			<iframe src="https://www.youtube-nocookie.com/embed/<?php echo esc_attr( $video_id ); ?>?rel=0" title="<?php echo esc_attr( wanko_get( 'movie_title' ) ); ?>" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
	</div>
</section>
