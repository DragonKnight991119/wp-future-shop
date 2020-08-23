<?php
/**
 * Compatability Check
 *
 * Validates system requirements are met in order to run this plugin.
 *
 * @package FutureShop
 */

namespace FutureShop\Config;

/**
 * Compatability Class
 */
class Compatability {

	/**
	 * Validates the WordPress version is at a specific minimum.
	 *
	 * @param number $required Required WordPress version minimum.
	 *
	 * @return boolean True if version is met, otherwise false.
	 */
	public static function wp_version( $required = '5.4' ) {
		return version_compare( $required, $GLOBALS['wp_version'], '>=' );
	}

	/**
	 * Validates the PHP version is at a specific minimum.
	 *
	 * @param number $required Required PHP version minimum.
	 *
	 * @return boolean True if version is met, otherwise false.
	 */
	public static function php_version( $required = '7.3' ) {
		return version_compare( $required, PHP_VERSION, '>=' );
	}
}
