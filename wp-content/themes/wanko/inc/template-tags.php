<?php
/**
 * Template helper functions.
 *
 * @package Wanko
 */

defined( 'ABSPATH' ) || exit;

/**
 * Echo multiline theme-mod text as escaped HTML with <br>.
 *
 * @param string $key Setting key.
 */
function wanko_the_lines( $key ) {
	echo nl2br( esc_html( wanko_get( $key ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput
}

/**
 * Echo multiline theme-mod text as paragraphs (blank line = new paragraph).
 *
 * @param string $key Setting key.
 */
function wanko_the_paragraphs( $key ) {
	$text = trim( (string) wanko_get( $key ) );
	if ( '' === $text ) {
		return;
	}
	$paragraphs = preg_split( '/\n\s*\n/', $text );
	foreach ( $paragraphs as $p ) {
		echo '<p>' . nl2br( esc_html( trim( $p ) ) ) . '</p>'; // phpcs:ignore WordPress.Security.EscapeOutput
	}
}

/**
 * Output the site logo (custom logo or text fallback).
 */
function wanko_the_logo() {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}
	printf(
		'<a class="site-logo site-logo--text" href="%1$s" rel="home"><span class="site-logo__mark" aria-hidden="true">%3$s</span><span class="site-logo__name">%2$s</span></a>',
		esc_url( home_url( '/' ) ),
		esc_html( get_bloginfo( 'name' ) ),
		wanko_icon( 'paw' ) // phpcs:ignore WordPress.Security.EscapeOutput
	);
}

/**
 * Inline SVG icons.
 *
 * @param string $name Icon name.
 * @return string
 */
function wanko_icon( $name ) {
	$icons = array(
		'paw'   => '<svg viewBox="0 0 24 24" fill="currentColor"><circle cx="5.5" cy="10" r="2.3"/><circle cx="9.5" cy="5.5" r="2.4"/><circle cx="14.5" cy="5.5" r="2.4"/><circle cx="18.5" cy="10" r="2.3"/><path d="M12 9.5c-3.4 0-6.6 3.4-6.6 6.4 0 1.9 1.3 3.1 3 3.1 1.2 0 2.2-.7 3.6-.7s2.4.7 3.6.7c1.7 0 3-1.2 3-3.1 0-3-3.2-6.4-6.6-6.4z"/></svg>',
		'cat'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 9.5 3.5 3.8 8 6.3a9 9 0 0 1 8 0l4.5-2.5L20 9.5c.6 1.2 1 2.6 1 4 0 4.4-4 7.5-9 7.5s-9-3.1-9-7.5c0-1.4.4-2.8 1-4z"/><circle cx="9" cy="12.5" r=".9" fill="currentColor"/><circle cx="15" cy="12.5" r=".9" fill="currentColor"/><path d="M11 15.5h2l-1 1.2z" fill="currentColor"/><path d="M2.5 14.5h4M17.5 14.5h4M3 17l3.6-1M21 17l-3.6-1"/></svg>',
		'dog'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 7.5c-2.5 0-4.5 2-4.5 5.5s1 5 3 5.5c.4-3 1.2-5 2.5-6.5M17 7.5c2.5 0 4.5 2 4.5 5.5s-1 5-3 5.5c-.4-3-1.2-5-2.5-6.5"/><path d="M8 7.5c1-1.5 2.4-2.5 4-2.5s3 1 4 2.5c1.6 2.3 2 5.5 1 8.5-.8 2.4-2.8 4-5 4s-4.2-1.6-5-4c-1-3-.6-6.2 1-8.5z"/><circle cx="10" cy="12" r=".9" fill="currentColor"/><circle cx="14" cy="12" r=".9" fill="currentColor"/><path d="M12 15.2c-1 0-1.6.5-1.6 1 0 .6.7 1.1 1.6 1.1s1.6-.5 1.6-1.1c0-.5-.6-1-1.6-1z" fill="currentColor"/></svg>',
		'shop'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9.5 4.5 4h15L21 9.5"/><path d="M3 9.5c0 1.7 1.3 3 3 3s3-1.3 3-3c0 1.7 1.3 3 3 3s3-1.3 3-3c0 1.7 1.3 3 3 3s3-1.3 3-3"/><path d="M5 12.3V20h14v-7.7"/><path d="M10 20v-5h4v5"/></svg>',
		'box'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 3 7.5v9L12 21l9-4.5v-9z"/><path d="M3 7.5 12 12l9-4.5M12 12v9M7.5 5.3l9 4.5"/></svg>',
		'arrow' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>',
		'mail'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>',
		'ext'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 4h6v6M20 4l-9 9M18 13v6H5V6h6"/></svg>',
	);
	return isset( $icons[ $name ] ) ? '<span class="icon icon--' . esc_attr( $name ) . '" aria-hidden="true">' . $icons[ $name ] . '</span>' : '';
}

/**
 * Section heading with English label + Japanese title.
 *
 * @param string $en    English label.
 * @param string $ja    Japanese title.
 * @param string $align left|center.
 */
function wanko_section_title( $en, $ja, $align = 'center' ) {
	printf(
		'<div class="section-title section-title--%3$s"><span class="section-title__en">%1$s</span><h2 class="section-title__ja">%2$s</h2></div>',
		esc_html( $en ),
		esc_html( $ja ),
		esc_attr( $align )
	);
}

/**
 * Page hero (title band) for inner pages.
 *
 * @param string $ja Japanese title.
 * @param string $en English label.
 */
function wanko_page_hero( $ja, $en ) {
	printf(
		'<div class="page-hero"><div class="container"><span class="page-hero__en">%2$s</span><h1 class="page-hero__title">%1$s</h1></div></div>',
		esc_html( $ja ),
		esc_html( $en )
	);
}

/**
 * Breadcrumb list.
 *
 * @param array $items [ [ 'label' => ..., 'url' => ... ], ... ] (last item without url).
 */
function wanko_breadcrumb( $items ) {
	echo '<nav class="breadcrumb" aria-label="パンくずリスト"><div class="container"><ol>';
	printf( '<li><a href="%s">ホーム</a></li>', esc_url( home_url( '/' ) ) );
	foreach ( $items as $item ) {
		if ( ! empty( $item['url'] ) ) {
			printf( '<li><a href="%s">%s</a></li>', esc_url( $item['url'] ), esc_html( $item['label'] ) );
		} else {
			printf( '<li aria-current="page">%s</li>', esc_html( $item['label'] ) );
		}
	}
	echo '</ol></div></nav>';
}

/**
 * URL of a page by slug (falls back to a relative path).
 *
 * @param string $slug Page slug.
 * @return string
 */
function wanko_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return get_permalink( $page );
	}
	return home_url( '/' . $slug . '/' );
}

/**
 * Link to the news (posts) archive.
 *
 * @return string
 */
function wanko_news_url() {
	$page_id = (int) get_option( 'page_for_posts' );
	return $page_id ? get_permalink( $page_id ) : home_url( '/news/' );
}

/**
 * Render an EC shop card (photo card for dog / cat, wide banner for the general shop).
 *
 * @param string $key   cat|dog|all.
 * @param string $icon  Icon name.
 * @param string $style card|banner.
 */
function wanko_shop_card( $key, $icon, $style = 'card' ) {
	$name  = wanko_get( 'shop_' . $key . '_name' );
	$desc  = wanko_get( 'shop_' . $key . '_desc' );
	$url   = wanko_get( 'shop_' . $key . '_url' );
	$image = wanko_get( 'shop_' . $key . '_image' );
	$tag   = $url ? 'a' : 'div';
	$attr  = $url ? ' href="' . esc_url( $url ) . '" target="_blank" rel="noopener"' : '';
	$label = 'cat' === $key ? 'For Cats' : ( 'dog' === $key ? 'For Dogs' : 'For All Pets' );
	?>
	<<?php echo $tag; // phpcs:ignore ?> class="shop-card shop-card--<?php echo esc_attr( $style ); ?> shop-card--<?php echo esc_attr( $key ); ?><?php echo $url ? '' : ' is-soon'; ?>"<?php echo $attr; // phpcs:ignore ?>>
		<div class="shop-card__media">
			<?php if ( $image ) : ?>
				<img src="<?php echo esc_url( $image ); ?>" alt="" loading="lazy">
			<?php else : ?>
				<div class="shop-card__placeholder"><?php echo wanko_icon( $icon ); // phpcs:ignore ?></div>
			<?php endif; ?>
			<span class="shop-card__label"><?php echo esc_html( $label ); ?></span>
		</div>
		<div class="shop-card__body">
			<div class="shop-card__icon"><?php echo wanko_icon( $icon ); // phpcs:ignore ?></div>
			<h3 class="shop-card__name"><?php echo esc_html( $name ); ?></h3>
			<p class="shop-card__desc"><?php echo esc_html( $desc ); ?></p>
			<?php if ( $url ) : ?>
				<span class="shop-card__cta btn btn--ghost">サイトを見る <?php echo wanko_icon( 'ext' ); // phpcs:ignore ?></span>
			<?php else : ?>
				<span class="shop-card__soon">Coming Soon</span>
			<?php endif; ?>
		</div>
	</<?php echo $tag; // phpcs:ignore ?>>
	<?php
}

/**
 * Extract a YouTube video id from a URL.
 *
 * @param string $url YouTube URL.
 * @return string
 */
function wanko_youtube_id( $url ) {
	if ( preg_match( '~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/))([A-Za-z0-9_-]{6,})~', (string) $url, $m ) ) {
		return $m[1];
	}
	return '';
}

/**
 * Structured site map used by the sitemap page and the footer.
 *
 * @return array
 */
function wanko_sitemap_tree() {
	$company = wanko_page_url( 'company' );
	return array(
		array(
			'label'    => '企業情報',
			'url'      => $company,
			'children' => array(
				array( 'label' => 'ごあいさつ', 'url' => $company . '#greeting' ),
				array( 'label' => '会社概要', 'url' => $company . '#overview' ),
				array( 'label' => '私たちのお約束', 'url' => $company . '#promise' ),
			),
		),
		array(
			'label'    => '事業内容',
			'url'      => wanko_page_url( 'business' ),
			'children' => array(
				array( 'label' => 'ペット関連用品の卸販売', 'url' => wanko_page_url( 'business' ) . '#wholesale' ),
				array( 'label' => wanko_get( 'shop_cat_name' ), 'url' => wanko_page_url( 'business' ) . '#shops' ),
				array( 'label' => wanko_get( 'shop_dog_name' ), 'url' => wanko_page_url( 'business' ) . '#shops' ),
				array( 'label' => wanko_get( 'shop_all_name' ), 'url' => wanko_page_url( 'business' ) . '#shops' ),
			),
		),
		array( 'label' => 'お知らせ', 'url' => wanko_news_url() ),
		array( 'label' => 'コラム', 'url' => get_post_type_archive_link( 'column' ) ),
		array( 'label' => '採用情報', 'url' => wanko_page_url( 'recruit' ) ),
		array( 'label' => 'お問い合わせ', 'url' => wanko_page_url( 'contact' ) ),
		array( 'label' => 'プライバシーポリシー', 'url' => wanko_page_url( 'privacy' ) ),
		array( 'label' => 'サイトマップ', 'url' => wanko_page_url( 'sitemap' ) ),
	);
}

/**
 * Post date + optional category label for list items.
 */
function wanko_post_meta() {
	echo '<time class="post-meta__date" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date( 'Y.m.d' ) ) . '</time>';
	if ( 'column' === get_post_type() ) {
		$terms = get_the_terms( get_the_ID(), 'column_category' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			echo '<span class="post-meta__cat">' . esc_html( $terms[0]->name ) . '</span>';
		}
	} else {
		$cats = get_the_category();
		if ( $cats && 'uncategorized' !== $cats[0]->slug ) {
			echo '<span class="post-meta__cat">' . esc_html( $cats[0]->name ) . '</span>';
		}
	}
}

/**
 * Placeholder thumbnail when a post has no featured image.
 *
 * @param string $size Image size.
 */
function wanko_the_thumbnail( $size = 'wanko-card' ) {
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( $size, array( 'loading' => 'lazy' ) );
		return;
	}
	$icon = 'column' === get_post_type() ? 'cat' : 'paw';
	echo '<div class="thumb-placeholder">' . wanko_icon( $icon ) . '</div>'; // phpcs:ignore
}

/**
 * Fallback menu when no menu is assigned yet.
 *
 * @param array $args wp_nav_menu args.
 */
function wanko_nav_fallback( $args ) {
	$items = array(
		'企業情報'       => wanko_page_url( 'company' ),
		'事業内容'       => wanko_page_url( 'business' ),
		'お知らせ'       => wanko_news_url(),
		'コラム'        => get_post_type_archive_link( 'column' ),
		'採用情報'       => wanko_page_url( 'recruit' ),
		'お問い合わせ'     => wanko_page_url( 'contact' ),
	);
	if ( 'footer' === $args['theme_location'] ) {
		$items['プライバシーポリシー'] = wanko_page_url( 'privacy' );
		$items['サイトマップ']      = wanko_page_url( 'sitemap' );
	}
	echo '<ul class="' . esc_attr( $args['menu_class'] ) . '">';
	foreach ( $items as $label => $url ) {
		printf( '<li class="menu-item"><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</ul>';
}
