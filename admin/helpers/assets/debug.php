<?php
/**
 * Assets debug mode.
 *
 * @package FutureShop
 */

namespace FutureShop\Helpers\Assets;

/**
 * Debug class
 */
class Debug {

	/**
	 * Scripts debug.
	 *
	 * @return boolean True if in script debug mode, otherwise false.
	 */
	public static function script() {
		return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
	}
}
