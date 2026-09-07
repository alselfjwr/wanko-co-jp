<?php
/**
 * Basic on-page SEO without a plugin:
 * title (front page), meta description, OGP / Twitter card, favicon, JSON-LD.
 *
 * @package Wanko
 */

/**
 * Title separator「｜」.
 */
add_filter( 'document_title_separator', function () { return '｜'; } );
add_filter( 'document_title', function ( $title ) { return str_replace( ' ｜ ', '｜', $title ); } );

/**
 * Front page title: "<事業内容のキーワード>｜<会社名>".
 */
function wanko_document_title_parts( $parts ) {
	if ( is_front_page() ) {
		$parts['title']   = wanko_get( 'seo_home_title' ) ? wanko_get( 'seo_home_title' ) : get_bloginfo( 'name' );
		$parts['tagline'] = wanko_get( 'seo_home_title' ) ? get_bloginfo( 'name' ) : '';
		unset( $parts['site'] );
	}
	return $parts;
}
add_filter( 'document_title_parts', 'wanko_document_title_parts' );

/**
 * Plain-text description for the current request (≈120 chars).
 *
 * @return string
 */
function wanko_seo_description() {
	$desc = '';
	if ( is_front_page() ) {
		$desc = wanko_get( 'seo_desc_home' );
	} elseif ( is_home() ) {
		$desc = wanko_get( 'seo_desc_news' );
	} elseif ( is_post_type_archive( 'column' ) || is_tax( array( 'column_category', 'column_tag' ) ) ) {
		$desc = wanko_get( 'seo_desc_column' );
	} elseif ( is_singular() ) {
		$post = get_queried_object();
		if ( is_page() ) {
			$desc = wanko_get( 'seo_desc_' . $post->post_name );
		}
		if ( '' === $desc && has_excerpt( $post ) ) {
			$desc = get_the_excerpt( $post );
		}
		if ( '' === $desc && ! is_page() ) {
			$desc = wp_strip_all_tags( strip_shortcodes( $post->post_content ) );
		}
	}
	if ( '' === trim( (string) $desc ) ) {
		$desc = wanko_get( 'seo_desc_default' );
	}
	$desc = trim( preg_replace( '/\s+/u', ' ', (string) $desc ) );
	return mb_strlen( $desc ) > 120 ? mb_substr( $desc, 0, 119 ) . '…' : $desc;
}

/**
 * OGP image URL for the current request (featured image → default).
 *
 * @return string
 */
function wanko_seo_image() {
	if ( is_singular() && has_post_thumbnail() ) {
		$src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
		if ( $src ) {
			return $src[0];
		}
	}
	$img = wanko_get( 'seo_og_image' );
	return $img ? $img : WANKO_URI . '/assets/img/og-default.jpg';
}

/**
 * Canonical-ish URL of the current request.
 *
 * @return string
 */
function wanko_seo_url() {
	if ( is_front_page() ) {
		return home_url( '/' );
	}
	if ( is_singular() ) {
		return get_permalink();
	}
	if ( is_home() ) {
		return wanko_news_url();
	}
	if ( is_post_type_archive( 'column' ) ) {
		return get_post_type_archive_link( 'column' );
	}
	if ( is_tax() || is_category() || is_tag() ) {
		$link = get_term_link( get_queried_object() );
		return is_wp_error( $link ) ? home_url( '/' ) : $link;
	}
	return home_url( add_query_arg( array(), $GLOBALS['wp']->request ? '/' . $GLOBALS['wp']->request . '/' : '/' ) );
}

/**
 * Output meta description, OGP, Twitter card and favicon links.
 */
function wanko_seo_head() {
	$title = wp_get_document_title();
	$desc  = wanko_seo_description();
	$url   = wanko_seo_url();
	$image = wanko_seo_image();
	$type  = is_singular( array( 'post', 'column' ) ) ? 'article' : 'website';

	echo "\n<!-- SEO -->\n";
	if ( $desc ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	}
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:locale" content="ja_JP">' . "\n" );
	printf( '<meta property="og:type" content="%s">' . "\n", esc_attr( $type ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
	if ( $desc ) {
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $desc ) );
	}
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
	printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
	if ( 'article' === $type ) {
		printf( '<meta property="article:published_time" content="%s">' . "\n", esc_attr( get_the_date( 'c' ) ) );
		printf( '<meta property="article:modified_time" content="%s">' . "\n", esc_attr( get_the_modified_date( 'c' ) ) );
	}
	printf( '<meta name="twitter:card" content="summary_large_image">' . "\n" );
	printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $title ) );
	if ( $desc ) {
		printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $desc ) );
	}
	printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $image ) );

	// Favicon: theme-bundled icons unless a Site Icon is set in the customizer.
	if ( ! has_site_icon() ) {
		$img = WANKO_URI . '/assets/img/';
		printf( '<link rel="icon" href="%sfavicon.ico" sizes="any">' . "\n", esc_url( $img ) );
		printf( '<link rel="icon" href="%sfavicon-512.png" type="image/png" sizes="512x512">' . "\n", esc_url( $img ) );
		printf( '<link rel="apple-touch-icon" href="%sapple-touch-icon.png">' . "\n", esc_url( $img ) );
	}
	printf( '<meta name="theme-color" content="#0a3190">' . "\n" );
}
add_action( 'wp_head', 'wanko_seo_head', 5 );

/**
 * JSON-LD: Organization on every page, Article on お知らせ／コラム single.
 */
function wanko_seo_jsonld() {
	$name   = wanko_get( 'company_name' ) ? wanko_get( 'company_name' ) : get_bloginfo( 'name' );
	$same   = array_values( array_filter( array( wanko_get( 'sns_instagram' ), wanko_get( 'sns_x' ), wanko_get( 'sns_line' ), wanko_get( 'shop_cat_url' ) ) ) );
	$addr   = trim( (string) wanko_get( 'company_address' ) );
	$org    = array(
		'@context' => 'https://schema.org',
		'@type'    => 'Organization',
		'@id'      => home_url( '/#organization' ),
		'name'     => $name,
		'url'      => home_url( '/' ),
		'logo'     => WANKO_URI . '/assets/img/logo-full.png',
	);
	if ( wanko_get( 'company_tel' ) ) {
		$org['telephone'] = wanko_get( 'company_tel' );
	}
	if ( wanko_get( 'company_email' ) ) {
		$org['email'] = wanko_get( 'company_email' );
	}
	if ( $addr ) {
		$lines = preg_split( '/\R/u', $addr );
		$org['address'] = array(
			'@type'           => 'PostalAddress',
			'addressCountry'  => 'JP',
			'postalCode'      => preg_replace( '/[^0-9-]/u', '', (string) $lines[0] ),
			'streetAddress'   => trim( implode( ' ', array_slice( $lines, 1 ) ) ),
		);
	}
	if ( $same ) {
		$org['sameAs'] = $same;
	}
	$graph = array( $org );

	if ( is_singular( array( 'post', 'column' ) ) ) {
		$post    = get_queried_object();
		$graph[] = array(
			'@context'         => 'https://schema.org',
			'@type'            => 'column' === $post->post_type ? 'Article' : 'NewsArticle',
			'headline'         => get_the_title( $post ),
			'description'      => wanko_seo_description(),
			'image'            => wanko_seo_image(),
			'datePublished'    => get_the_date( 'c', $post ),
			'dateModified'     => get_the_modified_date( 'c', $post ),
			'mainEntityOfPage' => get_permalink( $post ),
			'author'           => array( '@type' => 'Organization', 'name' => $name ),
			'publisher'        => array( '@id' => home_url( '/#organization' ) ),
		);
	}
	foreach ( $graph as $item ) {
		echo '<script type="application/ld+json">' . wp_json_encode( $item, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
	}
}
add_action( 'wp_head', 'wanko_seo_jsonld', 6 );

/**
 * BreadcrumbList JSON-LD (printed by wanko_breadcrumb()).
 *
 * @param array $items Breadcrumb items after「ホーム」.
 */
function wanko_seo_breadcrumb_jsonld( $items ) {
	$list = array( array( '@type' => 'ListItem', 'position' => 1, 'name' => 'ホーム', 'item' => home_url( '/' ) ) );
	$pos  = 2;
	foreach ( $items as $item ) {
		$entry = array( '@type' => 'ListItem', 'position' => $pos++, 'name' => $item['label'] );
		if ( ! empty( $item['url'] ) ) {
			$entry['item'] = $item['url'];
		}
		$list[] = $entry;
	}
	echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $list ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}

/**
 * Featured images without an alt text fall back to the post title,
 * so new コラム／お知らせ get a meaningful alt automatically.
 */
function wanko_thumbnail_alt_fallback( $attr, $attachment ) {
	if ( empty( $attr['alt'] ) ) {
		$post_id = get_the_ID();
		if ( $post_id && (int) get_post_thumbnail_id( $post_id ) === (int) $attachment->ID ) {
			$attr['alt'] = get_the_title( $post_id );
		} elseif ( $attachment->post_title ) {
			$attr['alt'] = $attachment->post_title;
		}
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'wanko_thumbnail_alt_fallback', 10, 2 );
