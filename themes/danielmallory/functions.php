<?php
/**
 * Theme setup for danielmallory.
 */

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style(
			'danielmallory-style',
			get_stylesheet_uri(),
			array(),
			wp_get_theme()->get( 'Version' )
		);

		wp_register_script( 'danielmallory-console', false, array(), false, true );
		wp_enqueue_script( 'danielmallory-console' );
		wp_add_inline_script(
			'danielmallory-console',
			"console.log('%c~ ~ ~  you found the engine room  ~ ~ ~','color:#006994;font-weight:700');" .
			"console.log('Hand-built block theme. Source: https://github.com/dmallory42/danielmallory-blog');"
		);
	}
);

// A note for the view-source crowd.
add_action(
	'wp_head',
	function () {
		echo "\n<!--\n\n    ~^~^~^~^~^~^~^~^~^~^~^~^~^~\n\n    danielmallory.blog\n    hand-built, small, personal.\n    source: https://github.com/dmallory42/danielmallory-blog\n\n    ~^~^~^~^~^~^~^~^~^~^~^~^~^~\n\n-->\n";
	},
	2
);
