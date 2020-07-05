<?php
/**
 * Stripe Connector
 *
 * @todo Class needs documentation and refining.
 *
 * @package FutureShop
 */

namespace FutureShop\Connectors;

abstract class Connector {

	public function register( $class ) {
		foreach( get_class_methods( $class ) as $route ) {
			if ( substr( $route, 0, 14 ) === "register_route" ) {
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
