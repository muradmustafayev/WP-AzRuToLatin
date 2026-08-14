<?php
/**
 * Transliterator tests.
 *
 * @package Wpmm_AzRuToLatin
 */

namespace Wpmm\AzRuToLatin\Tests;

use PHPUnit\Framework\TestCase;
use Wpmm\AzRuToLatin\Transliterator;

/**
 * Tests for the Transliterator class.
 */
class TransliteratorTest extends TestCase {

	/**
	 * Test default transliteration output.
	 */
	public function test_default_transliteration() {
		$t = new Transliterator();

		$this->assertSame( 'maksim', $t->transliterate( 'максим' ) );
		$this->assertSame( 'ehmed', $t->transliterate( 'əhməd' ) );
		$this->assertSame( 'Prazdnichnyj prazdnik', $t->transliterate( 'Праздничный праздник' ) );
	}

	/**
	 * Test custom table support.
	 */
	public function test_custom_table() {
		$t = new Transliterator( array( 'x' => 'y' ) );

		$this->assertSame( 'y', $t->transliterate( 'x' ) );
		$this->assertSame( 'abc', $t->transliterate( 'abc' ) );
	}

	/**
	 * Test that empty strings are handled gracefully.
	 */
	public function test_empty_string() {
		$t = new Transliterator();

		$this->assertSame( '', $t->transliterate( '' ) );
	}
}
