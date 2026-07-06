<?php
/**
 * Plugin Name: Daniel Mallory Blog
 * Description: Site functionality for danielmallory.blog.
 * Version: 0.2.0
 * Author: Daniel Mallory
 * License: GPL-2.0-or-later
 * Text Domain: dm-blog
 */

defined( 'ABSPATH' ) || exit;

/**
 * Serve /humans.txt — the old-web tradition of crediting the human.
 */
add_action(
	'template_redirect',
	function () {
		$path = wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH );
		if ( '/humans.txt' !== untrailingslashit( $path ) ) {
			return;
		}

		header( 'Content-Type: text/plain; charset=utf-8' );
		echo "/* TEAM */\n";
		echo "Human: Daniel Mallory\n";
		echo "Role: writes the words, breaks the code\n";
		echo "Site: https://danielmallory.blog\n";
		echo "\n/* SITE */\n";
		echo "Stack: WordPress, one hand-rolled block theme\n";
		echo "Type: Hanken Grotesk\n";
		echo "Accent: Ocean (#006994)\n";
		echo "Deployed: git push, and the rest takes care of itself\n";
		exit;
	}
);

add_action(
	'wp_head',
	function () {
		printf( '<link rel="author" href="%s">' . "\n", esc_url( home_url( '/humans.txt' ) ) );
	}
);
