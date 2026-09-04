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
		'<a class="site-logo site-logo--image" href="%1$s" rel="home"><img src="%3$s" alt="%2$s" width="167" height="72"></a>',
		esc_url( home_url( '/' ) ),
		esc_attr( get_bloginfo( 'name' ) ),
		esc_url( WANKO_URI . '/assets/img/logo.svg' )
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
		'<div class="section-title section-title--%3$s"><h2 class="section-title__ja">%2$s</h2><span class="section-title__en">%1$s</span></div>',
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
	wanko_page_banner( $ja, $en );
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
 * EC service tile (にゃんにゃん／わんわん／総合ショップ) – photo tile + button.
 *
 * @param string $key cat|dog|all.
 */
function wanko_shop_card( $key ) {
	$name  = wanko_get( 'shop_' . $key . '_name' );
	$desc  = wanko_get( 'shop_' . $key . '_desc' );
	$url   = wanko_get( 'shop_' . $key . '_url' );
	$image = wanko_get( 'shop_' . $key . '_image' );
	$en    = 'cat' === $key ? 'CAT FOOD' : ( 'dog' === $key ? 'DOG FOOD' : 'PET SHOP' );
	?>
	<div class="shop-block<?php echo $url ? '' : ' is-soon'; ?>">
		<a class="photo-tile" href="<?php echo esc_url( $url ? $url : '#shops' ); ?>"<?php echo $url ? ' target="_blank" rel="noopener"' : ' aria-disabled="true" tabindex="-1"'; ?>>
			<?php if ( $image ) : ?><img src="<?php echo esc_url( $image ); ?>" alt="" loading="lazy"><?php endif; ?>
			<span class="photo-tile__text">
				<span class="photo-tile__en"><?php echo esc_html( $en ); ?></span>
				<span class="photo-tile__ja"><?php echo esc_html( $name ); ?></span>
				<?php if ( ! $url ) : ?><span class="photo-tile__soon">Coming Soon</span><?php endif; ?>
			</span>
		</a>
		<p class="shop-block__desc"><?php echo esc_html( $desc ); ?></p>
		<?php if ( $url ) : ?>
			<a class="btn btn--ghost btn--sm" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener">サイトを見る<?php echo wanko_icon( 'ext' ); // phpcs:ignore ?></a>
		<?php else : ?>
			<span class="btn btn--ghost btn--sm is-disabled">Coming Soon</span>
		<?php endif; ?>
	</div>
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
	$company  = wanko_page_url( 'company' );
	$business = wanko_page_url( 'business' );
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
			'url'      => $business,
			'children' => array(
				array( 'label' => 'ペット関連用品の卸販売', 'url' => $business . '#wholesale' ),
				array( 'label' => wanko_get( 'shop_cat_name' ), 'url' => $business . '#shops' ),
				array( 'label' => wanko_get( 'shop_dog_name' ), 'url' => $business . '#shops' ),
				array( 'label' => wanko_get( 'shop_all_name' ), 'url' => $business . '#shops' ),
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
 * Related column posts (same category, fallback to latest).
 *
 * @param int $post_id Post ID.
 * @param int $count   Number of posts.
 * @return WP_Query
 */
function wanko_related_columns( $post_id, $count = 3 ) {
	$args  = array(
		'post_type'      => 'column',
		'posts_per_page' => $count,
		'post__not_in'   => array( $post_id ),
		'no_found_rows'  => true,
	);
	$terms = get_the_terms( $post_id, 'column_category' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		$args['tax_query'] = array( array( 'taxonomy' => 'column_category', 'field' => 'term_id', 'terms' => wp_list_pluck( $terms, 'term_id' ) ) ); // phpcs:ignore WordPress.DB.SlowDBQuery
	}
	$q = new WP_Query( $args );
	if ( ! $q->have_posts() && isset( $args['tax_query'] ) ) {
		unset( $args['tax_query'] );
		$q = new WP_Query( $args );
	}
	return $q;
}

/**
 * Split multiline text into an array of trimmed non-empty lines.
 *
 * @param string $text Text.
 * @return array
 */
function wanko_lines_to_array( $text ) {
	return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $text ) ) ) );
}

/**
 * Post date + optional category label for list items.
 */
function wanko_post_meta() {
	if ( 'column' === get_post_type() ) {
		$terms = get_the_terms( get_the_ID(), 'column_category' );
		$tags  = get_the_terms( get_the_ID(), 'column_tag' );
		echo '<span class="post-meta__tags">';
		if ( $terms && ! is_wp_error( $terms ) ) {
			echo '<span class="post-meta__cat">#' . esc_html( $terms[0]->name ) . '</span>';
		}
		if ( $tags && ! is_wp_error( $tags ) ) {
			foreach ( array_slice( $tags, 0, 2 ) as $tag ) {
				echo '<span class="post-meta__cat">#' . esc_html( $tag->name ) . '</span>';
			}
		}
		echo '</span>';
		echo '<time class="post-meta__date" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date( 'Y.m.d' ) ) . '</time>';
		return;
	}
	echo '<time class="post-meta__date" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date( 'Y.m.d' ) ) . '</time>';
	{
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
		'企業情報'   => wanko_page_url( 'company' ),
		'事業内容'   => wanko_page_url( 'business' ),
		'お知らせ'   => wanko_news_url(),
		'コラム'    => get_post_type_archive_link( 'column' ),
		'採用情報'   => wanko_page_url( 'recruit' ),
		'お問い合わせ' => wanko_page_url( 'contact' ),
	);
	if ( 'footer' === $args['theme_location'] ) {
		$items['プライバシーポリシー'] = wanko_page_url( 'privacy' );
		$items['サイトマップ']      = wanko_page_url( 'sitemap' );
	}
	echo '<ul class="' . esc_attr( $args['menu_class'] ) . '">';
	foreach ( $items as $label => $url ) {
		$seg = explode( '/', trim( (string) wp_parse_url( $url, PHP_URL_PATH ), '/' ) )[0];
		$en  = wanko_en_label( $seg );
		printf( '<li class="menu-item"><a href="%s">%s<span class="nav-ja">%s</span></a></li>', esc_url( $url ), $en ? '<span class="nav-en">' . esc_html( $en ) . '</span>' : '', esc_html( $label ) );
	}
	echo '</ul>';
}

/**
 * English label for a nav item / category slug.
 *
 * @param string $slug Slug or path segment.
 * @return string
 */
function wanko_en_label( $slug ) {
	$map = array(
		'products'   => 'Products',
		'about'      => 'About',
		'message'    => 'Message',
		'philosophy' => 'Philosophy',
		'commitment' => 'Commitment',
		'company'    => 'Company',
		'business'   => 'Business',
		'news'       => 'News',
		'column'     => 'Column',
		'recruit'    => 'Recruit',
		'contact'    => 'Contact',
		'privacy'    => 'Privacy',
		'sitemap'    => 'Sitemap',
		'food'       => 'Food',
		'treat'      => 'Treats',
		'goods'      => 'Goods',
		'other'      => 'Others',
	);
	$slug = strtolower( trim( (string) $slug, '/' ) );
	return isset( $map[ $slug ] ) ? $map[ $slug ] : '';
}

/**
 * Nav walker: renders "EN label" above the Japanese label (reference-site style).
 * Uses the menu item description as the EN label when set; otherwise maps from the URL.
 */
class Wanko_Nav_Walker extends Walker_Nav_Menu {
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) { // phpcs:ignore
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes = array_filter( $classes, function ( $c ) { return $c && 0 === strpos( $c, 'current' ) || 'menu-item' === $c; } );
		$en      = trim( (string) $item->description );
		if ( '' === $en ) {
			$path = trim( (string) wp_parse_url( $item->url, PHP_URL_PATH ), '/' );
			$seg  = $path ? explode( '/', $path )[0] : '';
			$en   = wanko_en_label( $seg );
		}
		$output .= '<li class="' . esc_attr( implode( ' ', $classes ) ) . '">';
		$output .= '<a href="' . esc_url( $item->url ) . '"' . ( ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '' ) . '>';
		if ( $en ) {
			$output .= '<span class="nav-en">' . esc_html( $en ) . '</span>';
		}
		$output .= '<span class="nav-ja">' . esc_html( $item->title ) . '</span></a>';
	}
	public function end_el( &$output, $item, $depth = 0, $args = null ) { // phpcs:ignore
		$output .= '</li>';
	}
}

/**
 * Photo tile with dark overlay and centered text (products / company sections).
 *
 * @param array $tile [ url, image, en, ja, sub ].
 */
function wanko_photo_tile( $tile ) {
	?>
	<a class="photo-tile" href="<?php echo esc_url( $tile['url'] ); ?>">
		<?php if ( ! empty( $tile['image'] ) ) : ?>
			<img src="<?php echo esc_url( $tile['image'] ); ?>" alt="" loading="lazy">
		<?php endif; ?>
		<span class="photo-tile__text">
			<?php if ( ! empty( $tile['en'] ) ) : ?><span class="photo-tile__en"><?php echo esc_html( $tile['en'] ); ?></span><?php endif; ?>
			<span class="photo-tile__ja"><?php echo esc_html( $tile['ja'] ); ?></span>
			<?php if ( ! empty( $tile['sub'] ) ) : ?><span class="photo-tile__sub"><?php echo esc_html( $tile['sub'] ); ?></span><?php endif; ?>
		</span>
	</a>
	<?php
}

/**
 * Page hero with photo banner (rounded, overlay) – reference-site style.
 *
 * @param string $ja    Japanese title.
 * @param string $en    English label.
 * @param string $image Image URL (defaults to customizer page_hero_image).
 */
function wanko_page_banner( $ja, $en, $image = '' ) {
	$image = $image ? $image : wanko_get( 'page_hero_image' );
	?>
	<div class="page-banner<?php echo $image ? ' has-image' : ''; ?>">
		<div class="page-banner__inner">
			<?php if ( $image ) : ?><img src="<?php echo esc_url( $image ); ?>" alt=""><?php endif; ?>
			<div class="page-banner__text">
				<h1 class="page-banner__title"><?php echo esc_html( $ja ); ?></h1>
				<?php if ( $en ) : ?><span class="page-banner__en"><?php echo esc_html( $en ); ?></span><?php endif; ?>
			</div>
		</div>
	</div>
	<?php
}
