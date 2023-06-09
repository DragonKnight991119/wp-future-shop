<?php
/**
 * Future Shop
 *
 * @package FutureShop
 * @author  Future Shop Contributors
 * @license MPL-2.0
 *
 * Plugin Name:       Future Shop
 * Plugin URI:        https://wordpress.org/plugins/future-shop
 * Description:       Simple. Fast. Secure. Run your store with Future Shop, the only plugin with native Stripe integration to manage your business using WordPress.
 * Version:           0.0.1
 * Requires PHP:      7.2
 * Requires at least: 5.4
 * Author:            Future Shop Contributors
 * Author URI:        https://github.com/future-shop/wp-future-shop/graphs/contributors
 * Text Domain:       future-shop
 * License:           MPL-2.0
 * License URI:       https://www.mozilla.org/en-US/MPL/2.0/
 */

namespace FutureShop;

/**
 * Plugin Config
 *
 * Static class to get plugin details... required for #allTheThings
 */
abstract class Plugin {
	/**
	 * Gets the plugin directory path.
	 *
	 * @return string Plugin dir path.
	 */
	public static function dir() {
		return plugin_dir_path( __FILE__ );
	}

	/**
	 * Gets a file path, within the plugin.
	 *
	 * @param string $file Path to file, relative to plugin root.
	 *
	 * @return string Plugin file.
	 */
	public static function path( $file = '' ) {
		return self::dir() . $file;
	}

	/**
	 * Gets the plugin file path.
	 *
	 * @return string Plugin file.
	 */
	public static function file() {
		return __FILE__;
	}

	/**
	 * Gets the plugin url.
	 *
	 * @return string Plugin url.
	 */
	public static function url() {
		return plugin_dir_url( __FILE__ );
	}

	/**
	 * Gets the url to an asset, relative to the plugin root.
	 *
	 * @param string $file Asset file.
	 *
	 * @return string Plugin url.
	 */
	public static function asset( $file = '' ) {
		return self::url() . trailingslashit( 'build' ) . $file;
	}

	/**
	 * Gets the plugin version.
	 *
	 * @return string Plugin version.
	 */
	public static function version() {
		return get_file_data( __FILE__, [ 'Version' => 'Version' ], 'plugin' )['Version'];
	}
}

// Load up the party supplies.
require_once Plugin::dir() . 'vendor/autoload.php';

// 🥳 Let's get this party started.
new Bootstrap( __FILE__ );
