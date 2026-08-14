<?php
/**
 * Plugin Name:       AzRuToLatin
 * Plugin URI:        https://github.com/muradmustafayev/WP-AzRuToLatin
 * Description:       Converts Azerbaijani and Russian characters in post/page slugs to Latin characters.
 * Version:           2.0.0
 * Requires at least: 6.6
 * Requires PHP:      7.4
 * Author:            Murad Mustafayev
 * Author URI:        https://muradmustafayev.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wpmm-azrutolatin
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WPMM_AZRUTOLATIN_VERSION', '2.0.0' );
define( 'WPMM_AZRUTOLATIN_FILE', __FILE__ );

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
} else {
	spl_autoload_register(
		function ( $class_name ) {
			$prefix   = 'Wpmm\\AzRuToLatin\\';
			$base_dir = plugin_dir_path( WPMM_AZRUTOLATIN_FILE ) . 'src/';
			$len      = strlen( $prefix );

			if ( strncmp( $prefix, $class_name, $len ) !== 0 ) {
				return;
			}

			$relative_class = substr( $class_name, $len );
			$file           = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

			if ( file_exists( $file ) ) {
				require $file;
			}
		}
	);
}

add_action(
	'plugins_loaded',
	function () {
		\Wpmm\AzRuToLatin\Plugin::instance();
	}
);
