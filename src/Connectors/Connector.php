<?php
/**
 * Stripe Connector
 *
 * @todo Class needs documentation and refining.
 *
 * @package FutureShop
 */

namespace FutureShop\Connectors;

/**
 * Abstract class to extend when registering Connectors.
 */
abstract class Connector {

	/**
	 * Registers a Connector's routes.
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

				return register_rest_route(
					$register['namespace'],
					$register['route'],
					$register['args'],
				);
			}
		}
	}
}
