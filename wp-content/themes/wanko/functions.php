<?php
/**
 * Wanko Corporate theme bootstrap.
 *
 * @package Wanko
 */

defined( 'ABSPATH' ) || exit;

define( 'WANKO_VERSION', '1.0.0' );
define( 'WANKO_DIR', get_template_directory() );
define( 'WANKO_URI', get_template_directory_uri() );

require WANKO_DIR . '/inc/setup.php';
require WANKO_DIR . '/inc/cpt.php';
require WANKO_DIR . '/inc/customizer.php';
require WANKO_DIR . '/inc/template-tags.php';
require WANKO_DIR . '/inc/activation.php';
require WANKO_DIR . '/inc/contact-form.php';
require WANKO_DIR . '/inc/seo.php';
