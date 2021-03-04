<?php
/**
 * Future Shop's Cart.
 *
 * @package FutureShop
 */

namespace FutureShop\Theme\Cart;

use FutureShop\Plugin;
use FutureShop\Helpers\Assets\Enqueue;
use FutureShop\Helpers\WP\Hooks;

/**
 * Admin Menus
 */
class Init {

	const FILE = 'cart.js';
	const SLUG = 'cart';

	/**
	 * Menu Constructor
	 */
	public function __construct() {
		Hooks::load( __CLASS__ );
	}

	/**
	 * Cart Script.
	 *
	 * @return void
	 *
	 * @wp.hook action wp_enqueue_scripts
	 */
	public static function enqueue_scripts() {
		Enqueue::script( self::SLUG, self::FILE );
	}

}
