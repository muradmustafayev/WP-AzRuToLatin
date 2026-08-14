<?php
/**
 * Sanitizer tests.
 *
 * @package Wpmm_AzRuToLatin
 */

namespace Wpmm\AzRuToLatin\Tests;

use PHPUnit\Framework\TestCase;
use Wpmm\AzRuToLatin\Sanitizer;
use Wpmm\AzRuToLatin\Transliterator;

/**
 * Tests for the Sanitizer class.
 */
class SanitizerTest extends TestCase {

	/**
	 * Sanitizer instance.
	 *
	 * @var Sanitizer
	 */
	private $sanitizer;

	/**
	 * Set up test fixtures.
	 */
	public function setUp(): void {
		parent::setUp();

		$this->sanitizer = new Sanitizer( new Transliterator() );
	}

	/**
	 * Test slug sanitization.
	 */
	public function test_slug_sanitization() {
		$this->assertSame( 'maksim', $this->sanitizer->slug( 'максим' ) );
		$this->assertSame( 'ehmed', $this->sanitizer->slug( 'əhməd' ) );
		$this->assertSame( 'prazdnichnyj-prazdnik', $this->sanitizer->slug( 'Праздничный праздник' ) );
	}

	/**
	 * Test file name sanitization.
	 */
	public function test_file_name_sanitization() {
		$this->assertSame( 'prazdnichnyj.docx', $this->sanitizer->file_name( 'Праздничный.docx' ) );
		$this->assertSame( 'ehmed-hesabat.pdf', $this->sanitizer->file_name( 'əhməd hesabat.pdf' ) );
	}

	/**
	 * Test preserving ASCII input.
	 */
	public function test_preserve_ascii_input() {
		$this->assertSame( 'hello-world', $this->sanitizer->slug( 'hello world' ) );
	}
}
