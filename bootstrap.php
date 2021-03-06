<?php
/**
 * Bootstrap the plugin.
 *
 * @package FutureShop
 */

namespace FutureShop;

use FutureShop\Helpers\WP\Hooks;

/**
 * Bootstrap class, primarily used for kicking things off and cleanup.
 */
class Bootstrap {
	/**
	 * Bootstrap constructor.
	 */
	public function __construct() {
		Hooks::load( __CLASS__ );

		register_activation_hook( Plugin::file(), [ $this, 'activate' ] );
		register_deactivation_hook( Plugin::file(), [ $this, 'deactivate' ] );
	}

	/**
	 * Activate plugin.
	 *
	 * @return void
	 */
	public function activate() {}

	/**
	 * Deactivate plugin.
	 *
	 * @return void
	 */
	public function deactivate() {}

	/**
	 * Loads the admin.
	 *
	 * @wp.hook action plugins_loaded
	 */
	public static function admin() {
		new Menus\Pages( __CLASS__ );
	}

	/**
	 * Loads the public frontend.
	 *
	 * @wp.hook action after_setup_theme
	 */
	public static function theme() {
		new Theme\Cart\Init( __CLASS__ );
	}

	/**
	 * Registers Proxy API route classes.
	 *
	 * @wp.hook action rest_api_init
	 */
	public static function apis() {
		new APIs\Stripe\Products\Products( __CLASS__ );
		new APIs\Stripe\Products\Product( __CLASS__ );
		new APIs\Stripe\Products\ProductID( __CLASS__ );
		new APIs\Stripe\Prices\Prices( __CLASS__ );
		new APIs\Stripe\Prices\Price( __CLASS__ );
		new APIs\Stripe\Prices\PriceID( __CLASS__ );
	}
}
