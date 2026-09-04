<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">本文へ移動</a>
<header class="site-header" id="site-header">
	<div class="site-header__inner">
		<div class="site-header__brand"><?php wanko_the_logo(); ?></div>

		<button class="menu-toggle" type="button" aria-controls="global-nav" aria-expanded="false">
			<span class="menu-toggle__bar"></span>
			<span class="menu-toggle__label">MENU</span>
		</button>

		<nav class="global-nav" id="global-nav" aria-label="グローバルナビゲーション">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'global-nav__list',
				'depth'          => 1,
				'walker'         => new Wanko_Nav_Walker(),
				'fallback_cb'    => 'wanko_nav_fallback',
			) );
			?>
			<a class="btn btn--primary global-nav__contact" href="<?php echo esc_url( wanko_page_url( 'contact' ) ); ?>">
				<?php echo wanko_icon( 'mail' ); // phpcs:ignore ?>お問い合わせ
			</a>
		</nav>
	</div>
</header>
<main id="main" class="site-main">
