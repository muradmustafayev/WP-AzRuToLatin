/**
 * Live transliteration of the Gutenberg post/page slug.
 *
 * @package Wpmm_AzRuToLatin
 */

(function (wp, settings) {
	'use strict';

	if ( ! wp || ! wp.data || ! settings || ! settings.slugMap ) {
		return;
	}

	var select = wp.data.select;
	var dispatch = wp.data.dispatch;
	var cleanForSlug = wp.url && wp.url.cleanForSlug ? wp.url.cleanForSlug : null;
	var slugMap = settings.slugMap;

	var isUpdating = false;
	var debounceTimer = null;
	var lastTitle = '';
	var lastAutoSlug = '';
	var DEBOUNCE_MS = 300;

	/**
	 * Replace characters using the transliteration table.
	 *
	 * @param {string} text Input text.
	 * @return {string} Transliterated text.
	 */
	function transliterate(text) {
		var result = '';
		var i;

		for ( i = 0; i < text.length; i++ ) {
			var ch = text.charAt( i );
			result += slugMap.hasOwnProperty( ch ) ? slugMap[ch] : ch;
		}

		return result;
	}

	/**
	 * Build a URL-safe slug from a title.
	 *
	 * @param {string} title Post title.
	 * @return {string} Slug.
	 */
	function buildSlug(title) {
		if ( ! title ) {
			return '';
		}

		var transliterated = transliterate( title );

		if ( cleanForSlug ) {
			return cleanForSlug( transliterated );
		}

		return transliterated
			.toLowerCase()
			.replace( /[^a-z0-9_-]+/g, '-' )
			.replace( /-+/g, '-' )
			.replace( /^-|-$/g, '' );
	}

	/**
	 * Update the edited post slug if it is still auto-generated.
	 */
	function updateSlug() {
		var editor = select( 'core/editor' );
		if ( ! editor ) {
			return;
		}

		var title = editor.getEditedPostAttribute( 'title' ) || '';
		var slug = editor.getEditedPostAttribute( 'slug' ) || '';

		if ( isUpdating ) {
			return;
		}

		// Do not override a manually edited slug.
		if ( slug && slug !== lastAutoSlug && slug !== buildSlug( lastTitle ) ) {
			return;
		}

		var newSlug = buildSlug( title );
		if ( newSlug === slug ) {
			return;
		}

		isUpdating = true;
		dispatch( 'core/editor' ).editPost( { slug: newSlug } );
		lastAutoSlug = newSlug;
		lastTitle = title;
		isUpdating = false;
	}

	wp.data.subscribe( function () {
		if ( debounceTimer ) {
			clearTimeout( debounceTimer );
		}

		debounceTimer = setTimeout( updateSlug, DEBOUNCE_MS );
	});
})( window.wp, window.wpmmAzRuToLatin || {} );
