<?php
/**
 * Configuration data, accesed from the object.
 *
 * @package S4B
 */

namespace S4B\Config;

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
			__( 'products', 'stripe-for-business' ),
			__( 'customers', 'stripe-for-business' ),
			__( 'settings', 'stripe-for-business' ),
		];
	}
}
