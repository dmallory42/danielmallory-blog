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
			"console.log('%cthe footer never ends','color:#006994;font-style:italic');"
		);

		// The masthead's moon/sun switch.
		wp_add_inline_script(
			'danielmallory-console',
			"document.addEventListener('DOMContentLoaded',function(){" .
			"var b=document.querySelector('.dm-scheme-toggle');if(!b){return;}" .
			"var root=document.documentElement;" .
			"function sync(){var dark=root.classList.contains('dm-dark');" .
			"b.textContent=dark?'\\u2600':'\\u263E';" .
			"b.setAttribute('aria-pressed',dark?'true':'false');" .
			"var m=document.querySelector('meta[name=\"theme-color\"]');" .
			"if(m){m.setAttribute('content',dark?'#14120F':'#FBFAF7');}}" .
			"b.addEventListener('click',function(){root.classList.toggle('dm-dark');" .
			"try{localStorage.setItem('dm-scheme',root.classList.contains('dm-dark')?'dark':'light');}catch(e){}" .
			"sync();});sync();});"
		);

		// The footer's infinity, asked directly, unfolds a certain note
		// found in a certain manor.
		wp_add_inline_script(
			'danielmallory-console',
			"document.addEventListener('DOMContentLoaded',function(){" .
			"var inf=document.querySelector('.dm-infinity');" .
			"var panel=document.getElementById('dm-note-reveal');" .
			"if(!inf||!panel){return;}" .
			"var spiral=panel.querySelector('.dm-spiral');" .
			"if(spiral&&'IntersectionObserver' in window){" .
			"new IntersectionObserver(function(es){es.forEach(function(en){" .
			"if(en.isIntersecting){spiral.classList.add('is-drawn');}" .
			"});},{threshold:0.4}).observe(spiral);}" .
			"function toggle(){var open=panel.classList.toggle('is-open');" .
			"inf.setAttribute('aria-expanded',open?'true':'false');" .
			"if(!open&&spiral){spiral.classList.remove('is-drawn');}}" .
			"inf.addEventListener('click',toggle);" .
			"inf.addEventListener('keydown',function(e){" .
			"if(e.key==='Enter'||e.key===' '){e.preventDefault();toggle();}" .
			"});});"
		);
	}
);

// Modern browsers render emoji (and our ☾/☀ toggle glyphs) natively; the
// legacy compat script replaces them with s.w.org images and breaks the
// toggle's textContent handling.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Tint the browser chrome, and restore a saved dark-mode choice before
// first paint so there is no light flash.
add_action(
	'wp_head',
	function () {
		echo '<meta name="theme-color" content="#FBFAF7">' . "\n";
		echo "<script>(function(){try{if(localStorage.getItem('dm-scheme')==='dark'){document.documentElement.classList.add('dm-dark');var m=document.querySelector('meta[name=\"theme-color\"]');if(m){m.setAttribute('content','#14120F');}}}catch(e){}})();</script>" . "\n";
	},
	1
);

// Open Graph tags so shared links get a proper preview card.
add_action(
	'wp_head',
	function () {
		$title = is_singular() ? get_the_title() : get_bloginfo( 'name' );
		$url   = is_singular() ? get_permalink() : home_url( '/' );
		$type  = is_singular( 'post' ) ? 'article' : 'website';
		$desc  = is_singular() ? get_the_excerpt() : get_bloginfo( 'description' );

		printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
		printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
		printf( '<meta property="og:type" content="%s">' . "\n", esc_attr( $type ) );
		printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
		if ( $desc ) {
			printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( wp_strip_all_tags( $desc ) ) );
		}
		printf( '<meta property="og:image" content="%s">' . "\n", esc_url( get_theme_file_uri( 'assets/og-card.png' ) ) );
		echo '<meta property="og:image:width" content="1200">' . "\n";
		echo '<meta property="og:image:height" content="630">' . "\n";
		echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	},
	5
);

// The theme prints its own Open Graph tags; stop Jetpack duplicating them.
add_filter( 'jetpack_enable_open_graph', '__return_false' );

// A note for the view-source crowd.
add_action(
	'wp_head',
	function () {
		echo "\n<!--\n\n    ~^~^~^~^~^~^~^~^~^~^~^~^~^~\n\n    danielmallory.blog\n    hand-built, small, personal.\n    source: https://github.com/dmallory42/danielmallory-blog\n\n    ~^~^~^~^~^~^~^~^~^~^~^~^~^~\n\n-->\n";
	},
	2
);
