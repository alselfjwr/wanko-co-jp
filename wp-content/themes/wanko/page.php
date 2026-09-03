<?php
/**
 * Default page template.
 *
 * @package Wanko
 */

get_header();
the_post();
wanko_page_hero( get_the_title(), '' );
wanko_breadcrumb( array( array( 'label' => get_the_title() ) ) );
?>
<div class="container section">
	<div class="prose prose--page">
		<?php the_content(); ?>
	</div>
</div>
<?php get_footer(); ?>
