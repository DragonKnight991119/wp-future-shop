<?php
/**
 * Abstract API class used for creating proxy APIs for external services.
 *
 * @package FutureShop
 */

namespace FutureShop\APIs;

/**
 * Abstract class to extend when registering API connections.
 */
abstract class API {

	/**
	 * Registers an API's routes.
	 *
	 * @todo Consider renaming method to register_methods.
	 *
	 * @param object $class The current class object passed.
	 *
	 * @return boolean True on success, false otherwise.
	 */
	public function register( $class ) {
		// @todo Check that a class was passed.
		foreach ( get_class_methods( $class ) as $route ) {
			if ( substr( $route, 0, 14 ) === 'register_route' ) {
				$register = call_user_func( [ $class, $route ] );

				register_rest_route(
					$register['namespace'],
					$register['route'],
					$register['args'],
				);
			}
		}
	}
}
