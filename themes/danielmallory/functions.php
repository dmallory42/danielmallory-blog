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

		// The footer's infinity, asked directly, quotes a certain note
		// found in a certain manor.
		wp_add_inline_script(
			'danielmallory-console',
			"document.addEventListener('DOMContentLoaded',function(){" .
			"var p=document.querySelector('.dm-infinity');" .
			"p=p&&p.closest('p');if(!p){return;}" .
			"var original=p.innerHTML,busy=false;" .
			"p.addEventListener('click',function(e){" .
			"if(busy||!e.target.closest('.dm-infinity')){return;}" .
			"busy=true;p.classList.add('dm-note');p.textContent='does it never end?';" .
			"setTimeout(function(){p.innerHTML=original;p.classList.remove('dm-note');busy=false;},4000);" .
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
