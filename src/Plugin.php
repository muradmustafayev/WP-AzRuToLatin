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
		add_filter(
			'sanitize_title',
			function ( $title, $raw_title, $context ) {
				return $this->sanitizer->slug( $title, $context );
			},
			9,
			3
		);

		add_filter(
			'sanitize_file_name',
			function ( $filename ) {
				return $this->sanitizer->file_name( $filename );
			},
			10,
			1
		);

		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
	}

	/**
	 * Enqueue block editor assets for live slug transliteration.
	 */
	public function enqueue_block_editor_assets() {
		$asset_url = plugins_url( 'assets/js/gutenberg-slug.js', WPMM_AZRUTOLATIN_FILE );
		$asset_ver = WPMM_AZRUTOLATIN_VERSION;

		wp_enqueue_script(
			'wpmm-azrutolatin-block-editor',
			$asset_url,
			array( 'wp-data', 'wp-editor', 'wp-url' ),
			$asset_ver,
			true
		);

		wp_localize_script(
			'wpmm-azrutolatin-block-editor',
			'wpmmAzRuToLatin',
			array(
				'slugMap' => $this->transliterator->get_table(),
			)
		);
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
