<?php
/**
 * Configuration data, accesed from the object.
 *
 * @package FutureShop
 */

namespace FutureShop\Config;

/**
 * Static data class.
 */
class Data {

	/**
	 * Get the registered admin submenu pages.
	 *
	 * @return array Admin submenu pages.
	 */
	public static function submenu_pages() {
		return [
			__( 'products', 'future-shop' ),
			__( 'customers', 'future-shop' ),
			__( 'settings', 'future-shop' ),
		];
	}
}
