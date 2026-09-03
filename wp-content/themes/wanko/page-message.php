<?php
/**
 * Template Name: 私たちの想い
 * Template Post Type: page
 *
 * @package Wanko
 */

get_header();
the_post();
wanko_page_hero( '私たちの想い', 'Message' );
wanko_breadcrumb( array(
	array( 'label' => '私たちについて', 'url' => wanko_page_url( 'about' ) ),
	array( 'label' => '私たちの想い' ),
) );
$image = wanko_get( 'story_image' );
?>
<section class="section">
	<div class="container container--narrow text-center">
		<p class="story__catch story__catch--lg"><?php echo esc_html( wanko_get( 'story_catch' ) ); ?></p>
		<p class="section-lead"><?php wanko_the_lines( 'story_lead' ); ?></p>
		<?php if ( $image ) : ?><figure class="story-hero"><img src="<?php echo esc_url( $image ); ?>" alt=""></figure><?php endif; ?>
	</div>
</section>

<section class="section section--alt">
	<div class="container container--narrow">
		<ol class="story-steps">
			<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
				<?php if ( ! wanko_get( "story_{$i}_title" ) ) { continue; } ?>
				<li class="story-step">
					<span class="story-step__num"><?php echo esc_html( sprintf( '%02d', $i ) ); ?></span>
					<div class="story-step__body">
						<h2 class="story-step__title"><?php echo esc_html( wanko_get( "story_{$i}_title" ) ); ?></h2>
						<div class="prose"><?php wanko_the_paragraphs( "story_{$i}_body" ); ?></div>
					</div>
				</li>
			<?php endfor; ?>
		</ol>
	</div>
</section>

<section class="section">
	<div class="container container--narrow">
		<?php wanko_section_title( 'Greeting', '代表メッセージ' ); ?>
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
		<?php if ( get_the_content() ) : ?><div class="prose prose--page"><?php the_content(); ?></div><?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>
