<?php
/**
 * Plugin Name: Daniel Mallory Blog
 * Description: Site functionality for danielmallory.blog.
 * Version: 0.3.0
 * Author: Daniel Mallory
 * License: GPL-2.0-or-later
 * Text Domain: dm-blog
 */

defined( 'ABSPATH' ) || exit;

/**
 * Projects — the "things I've built" shelf.
 *
 * Title = project name, excerpt = the one-liner shown on the homepage,
 * content = the longer story (with links) on the project's own page.
 */
add_action(
	'init',
	function () {
		register_post_type(
			'project',
			array(
				'labels'       => array(
					'name'          => 'Projects',
					'singular_name' => 'Project',
				),
				'public'       => true,
				'show_in_rest' => true,
				'menu_icon'    => 'dashicons-hammer',
				'supports'     => array( 'title', 'editor', 'excerpt' ),
				'has_archive'  => false,
				'rewrite'      => array( 'slug' => 'projects' ),
			)
		);
	}
);

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

/**
 * Number posts like issues of a zine: "№ 3 · July 6, 2026".
 *
 * The number is the post's position in publish order, prepended to the
 * post-date block on posts.
 */
add_filter(
	'render_block_core/post-date',
	function ( $content, $block, $instance ) {
		$post_id = $instance->context['postId'] ?? 0;
		if ( ! $post_id || 'post' !== get_post_type( $post_id ) || 'publish' !== get_post_status( $post_id ) ) {
			return $content;
		}

		static $ids = null;
		if ( null === $ids ) {
			$ids = get_posts(
				array(
					'post_type'   => 'post',
					'post_status' => 'publish',
					'orderby'     => 'date',
					'order'       => 'ASC',
					'numberposts' => -1,
					'fields'      => 'ids',
				)
			);
		}

		$position = array_search( $post_id, $ids, true );
		if ( false === $position ) {
			return $content;
		}

		$badge = sprintf( '<span class="dm-post-number">&#8470; %d</span> · ', $position + 1 );

		return preg_replace( '/(<div[^>]*>)/', '$1' . $badge, $content, 1 );
	},
	10,
	3
);
