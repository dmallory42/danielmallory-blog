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
			"console.log('This is an easter egg. It is not the only one — how many depends on how you count.');" .
			"console.log('Hints: select some text · /humans.txt · the footer never ends.');" .
			"console.log('Source, if you want to cheat: https://github.com/dmallory42/danielmallory-blog');"
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
			"var calm=window.matchMedia('(prefers-reduced-motion: reduce)').matches;" .
			"if(spiral&&'IntersectionObserver' in window){" .
			"new IntersectionObserver(function(es){es.forEach(function(en){" .
			"if(en.isIntersecting){spiral.classList.add('is-drawn');}" .
			"});},{threshold:0.4}).observe(spiral);}" .
			"function toggle(){var open=panel.classList.toggle('is-open');" .
			"inf.setAttribute('aria-expanded',open?'true':'false');" .
			"if(open&&!calm){setTimeout(function(){" .
			"window.scrollBy({top:window.innerHeight*0.6,behavior:'smooth'});},250);}" .
			"if(!open&&spiral){spiral.classList.remove('is-drawn');}}" .
			"inf.addEventListener('click',toggle);" .
			"inf.addEventListener('keydown',function(e){" .
			"if(e.key==='Enter'||e.key===' '){e.preventDefault();toggle();}" .
			"});});"
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
