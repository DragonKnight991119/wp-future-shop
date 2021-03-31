<?php
/**
 * Configuration data, accesed from the object.
 *
 * @package FutureShop
 */

namespace FutureShop\Menus;

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
			'settings' => [
				'class' => __NAMESPACE__ . '\Settings',
				'title' => __( 'Settings', 'future-shop' ),
			],
		];
	}
}
