<?php
/**
 * Transliterator.
 *
 * @package Wpmm_AzRuToLatin
 */

namespace Wpmm\AzRuToLatin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Transliterator class.
 *
 * Converts Azerbaijani (Latin script) and Russian (Cyrillic script)
 * characters to ASCII Latin equivalents.
 */
class Transliterator {

	/**
	 * Transliteration table.
	 *
	 * @var array
	 */
	private $table;

	/**
	 * Constructor.
	 *
	 * @param array|null $table Custom transliteration table or null for default.
	 */
	public function __construct( ?array $table = null ) {
		$this->table = ( null === $table ) ? self::default_table() : $table;
	}

	/**
	 * Transliterate a string.
	 *
	 * @param string $text Text to transliterate.
	 * @return string Transliterated text.
	 */
	public function transliterate( string $text ): string {
		$text = $this->normalize( $text );

		return strtr( $text, $this->table );
	}

	/**
	 * Get the default transliteration table.
	 *
	 * The table is based on ISO 9 / BGN-PCGN conventions and keeps
	 * Azerbaijani and Russian slugs readable and unique.
	 *
	 * @return array Default transliteration table.
	 */
	public static function default_table(): array {
		$az = array(
			'ə' => 'e',
			'ü' => 'u',
			'ğ' => 'g',
			'ö' => 'o',
			'ı' => 'i',
			'ç' => 'c',
			'ş' => 's',
			'Ə' => 'E',
			'Ü' => 'U',
			'Ğ' => 'G',
			'Ö' => 'O',
			'İ' => 'I',
			'Ç' => 'C',
			'Ş' => 'S',
			'№' => 'No',
			'–' => '-',
			'—' => '-',
			'−' => '-',
			'«' => '',
			'»' => '',
			'„' => '',
			'“' => '',
			'”' => '',
			'…' => '',
		);

		$ru = array(
			'А' => 'A',
			'а' => 'a',
			'Б' => 'B',
			'б' => 'b',
			'В' => 'V',
			'в' => 'v',
			'Г' => 'G',
			'г' => 'g',
			'Ґ' => 'G',
			'ґ' => 'g',
			'Д' => 'D',
			'д' => 'd',
			'Е' => 'E',
			'е' => 'e',
			'Ё' => 'Yo',
			'ё' => 'yo',
			'Є' => 'Ye',
			'є' => 'ye',
			'Ж' => 'Zh',
			'ж' => 'zh',
			'З' => 'Z',
			'з' => 'z',
			'И' => 'I',
			'и' => 'i',
			'І' => 'I',
			'і' => 'i',
			'Ї' => 'Yi',
			'ї' => 'yi',
			'Й' => 'J',
			'й' => 'j',
			'К' => 'K',
			'к' => 'k',
			'Л' => 'L',
			'л' => 'l',
			'М' => 'M',
			'м' => 'm',
			'Н' => 'N',
			'н' => 'n',
			'О' => 'O',
			'о' => 'o',
			'П' => 'P',
			'п' => 'p',
			'Р' => 'R',
			'р' => 'r',
			'С' => 'S',
			'с' => 's',
			'Т' => 'T',
			'т' => 't',
			'У' => 'U',
			'у' => 'u',
			'Ф' => 'F',
			'ф' => 'f',
			'Х' => 'H',
			'х' => 'h',
			'Ц' => 'Ts',
			'ц' => 'ts',
			'Ч' => 'Ch',
			'ч' => 'ch',
			'Ш' => 'Sh',
			'ш' => 'sh',
			'Щ' => 'Shh',
			'щ' => 'shh',
			'Ъ' => '',
			'ъ' => '',
			'Ы' => 'Y',
			'ы' => 'y',
			'Ь' => '',
			'ь' => '',
			'Э' => 'E',
			'э' => 'e',
			'Ю' => 'Yu',
			'ю' => 'yu',
			'Я' => 'Ya',
			'я' => 'ya',
		);

		return array_merge( $az, $ru );
	}

	/**
	 * Get the current transliteration table.
	 *
	 * @return array Transliteration table.
	 */
	public function get_table(): array {
		return $this->table;
	}

	/**
	 * Normalize the input to composed Unicode form.
	 *
	 * This helps the transliteration table match pre-composed characters
	 * like Ё instead of decomposed Е + combining diaeresis.
	 *
	 * @param string $text Input text.
	 * @return string Normalized text.
	 */
	private function normalize( string $text ): string {
		if ( function_exists( 'normalizer_normalize' ) && class_exists( 'Normalizer' ) ) {
			$normalized = normalizer_normalize( $text, \Normalizer::FORM_C );

			if ( false !== $normalized ) {
				return $normalized;
			}
		}

		return $text;
	}
}
