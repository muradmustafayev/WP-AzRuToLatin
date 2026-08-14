<?php
/**
 * Sanitizer.
 *
 * @package Wpmm_AzRuToLatin
 */

namespace Wpmm\AzRuToLatin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sanitizer class.
 *
 * Wraps the Transliterator and produces WordPress-ready slugs and file names.
 */
class Sanitizer {

	/**
	 * Transliterator instance.
	 *
	 * @var Transliterator
	 */
	private $transliterator;

	/**
	 * Constructor.
	 *
	 * @param Transliterator $transliterator Transliterator instance.
	 */
	public function __construct( Transliterator $transliterator ) {
		$this->transliterator = $transliterator;
	}

	/**
	 * Transliterate a string.
	 *
	 * Runs the wpmm_azrutolatin_should_transliterate filter so other
	 * plugins can disable transliteration per context.
	 *
	 * @param string $text    Text to transliterate.
	 * @param string $context Context, e.g. 'save' or 'file_name'.
	 * @return string Transliterated text.
	 */
	public function transliterate( string $text, string $context = '' ): string {
		if ( function_exists( 'apply_filters' ) && ! apply_filters( 'wpmm_azrutolatin_should_transliterate', true, $text, $context ) ) {
			return $text;
		}

		return $this->transliterator->transliterate( $text );
	}

	/**
	 * Produce a URL-safe slug.
	 *
	 * @param string $title   Title to sanitize.
	 * @param string $context Context passed to sanitize_title_with_dashes.
	 * @return string Sanitized slug.
	 */
	public function slug( string $title, string $context = 'save' ): string {
		$title = $this->transliterate( $title, $context );

		if ( function_exists( 'sanitize_title_with_dashes' ) ) {
			return sanitize_title_with_dashes( $title, '', $context );
		}

		return $this->sanitize_with_dashes( $title );
	}

	/**
	 * Produce a safe file name.
	 *
	 * The extension is preserved and lower-cased; the base name is
	 * transliterated and then cleaned to ASCII alphanumerics, dashes and
	 * underscores.
	 *
	 * @param string $filename File name to sanitize.
	 * @return string Sanitized file name.
	 */
	public function file_name( string $filename ): string {
		if ( function_exists( 'apply_filters' ) && ! apply_filters( 'wpmm_azrutolatin_should_transliterate', true, $filename, 'file_name' ) ) {
			return $filename;
		}

		$extension = '';
		$dot_pos   = strrpos( $filename, '.' );

		if ( false !== $dot_pos ) {
			$extension = substr( $filename, $dot_pos );
			$base      = substr( $filename, 0, $dot_pos );
		} else {
			$base = $filename;
		}

		$base = $this->transliterator->transliterate( $base );
		$base = $this->sanitize_with_dashes( $base );

		$extension = strtolower( $extension );

		return $base . $extension;
	}

	/**
	 * Replace non-slug characters with dashes and lower-case.
	 *
	 * Fallback when WordPress sanitization helpers are unavailable.
	 *
	 * @param string $text Text to sanitize.
	 * @return string Sanitized text.
	 */
	private function sanitize_with_dashes( string $text ): string {
		$text = preg_replace( '/[^A-Za-z0-9_-]/', '-', $text );
		$text = preg_replace( '/-+/', '-', $text );
		$text = trim( $text, '-' );

		if ( function_exists( 'mb_strtolower' ) ) {
			return mb_strtolower( $text, 'UTF-8' );
		}

		return strtolower( $text );
	}
}
