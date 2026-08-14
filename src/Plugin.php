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
	 * Constructor.
	 */
	private function __construct() {
		$this->load_textdomain();
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
		// Filters will be registered here.
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
