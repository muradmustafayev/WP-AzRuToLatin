<?php
/**
 * Plugin bootstrap.
 *
 * @package Wpmm_AzRuToLatin
 */

namespace Wpmm\AzRuToLatin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin class.
 */
class Plugin {

	/**
	 * Plugin instance.
	 *
	 * @var Plugin|null
	 */
	private static $instance = null;

	/**
	 * Transliterator instance.
	 *
	 * @var Transliterator
	 */
	private $transliterator;

	/**
	 * Sanitizer instance.
	 *
	 * @var Sanitizer
	 */
	private $sanitizer;

	/**
	 * Constructor.
	 */
	private function __construct() {
		$this->load_textdomain();

		$table = ( function_exists( 'apply_filters' ) ) ? apply_filters( 'wpmm_azrutolatin_transliteration_table', Transliterator::default_table() ) : Transliterator::default_table();

		$this->transliterator = new Transliterator( $table );
		$this->sanitizer      = new Sanitizer( $this->transliterator );
	}

	/**
	 * Get the plugin instance.
	 *
	 * @return Plugin
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 * Initialize the plugin.
	 */
	public function init() {
		// Filters will be registered in the next commit.
	}

	/**
	 * Load the plugin text domain.
	 */
	private function load_textdomain() {
		load_plugin_textdomain(
			'wpmm-azrutolatin',
			false,
			dirname( plugin_basename( WPMM_AZRUTOLATIN_FILE ) ) . '/languages'
		);
	}
}
