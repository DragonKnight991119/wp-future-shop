<?php
/**
 * Stripe for Business
 *
 * @package   S4B
 * @author    Justin Kopepasah
 * @license   MPL-2.0
 *
 * Plugin Name:       Stripe for Business
 * Plugin URI:        https://juko.co/wp/plugins/stripe-for-business
 * Description:       Simple. Fast. Secure. Run your store with Stripe for Business, the only plugin with full Stripe integration to manage your business using WordPress.
 * Version:           0.0.1
 * Requires at least: 5.4
 * Requires PHP:      7.2
 * Author:            Justin Kopepasah
 * Author URI:        https://kopepasah.com
 * Text Domain:       stripe-for-business
 * License:           MPL-2.0
 * License URI:       https://www.mozilla.org/en-US/MPL/2.0/
 */

namespace S4B;

/**
 * Plugin Config
 *
 * Static class to get plugin details... required for #allTheThings
 */
abstract class Plugin {
	/**
	 * Gets the plugin directory path.
	 *
	 * @return void
	 */
	public static function dir() {
		return plugin_dir_path( __FILE__ );
	}

	/**
	 * Gets the plugin file path.
	 *
	 * @return void
	 */
	public static function file() {
		return __FILE__;
	}

	/**
	 * Gets the plugin url.
	 *
	 * @return void
	 */
	public static function url() {
		return plugin_dir_url( __FILE__ );
	}

	/**
	 * Gets the plugin version.
	 *
	 * @return void
	 */
	public static function version() {
		return get_file_data( __FILE__, [ 'Version' => 'Version' ], 'plugin' )['Version'];
	}
}

// Load up the party supplies.
require_once Plugin::dir() . 'vendor/autoload.php';

// 🥳 Let's get this party started.
new Bootstrap( __FILE__ );
