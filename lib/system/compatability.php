<?php
/**
 * Compatability Check
 *
 * Validates system requirements are met in order to run this plugin.
 *
 * @package S4B
 */

namespace S4B\LIB\System\Compatability;

/**
 * Validates the WordPress version is at a specific minimum.
 *
 * @param number $required Required WordPress version minimum.
 *
 * @return boolean True if version is met, otherwise false.
 */
function check_wp_verson( $required = '5.4' ) {
	return version_compare( $required, $GLOBALS['wp_version'], '>=' );
}

/**
 * Validates the PHP version is at a specific minimum.
 *
 * @param number $required Required PHP version minimum.
 *
 * @return boolean True if version is met, otherwise false.
 */
function check_php_version( $required = '7.3' ) {
	return version_compare( $required, PHP_VERSION, '>=' );
}