<?php
/**
 * Stripe Products Connector
 *
 * @todo Class needs documentation and refining.
 *
 * @package S4B
 */

namespace S4B\Connectors\Stripe;

class Products extends Core {

	public function __construct() {
		$this->register( __CLASS__ );
	}

	public static function register_route_products() {
		return [
			'namespace' => 'stripe/v7',
			'route'     => '/products',
			'args'      => [ 'callback' => [ __CLASS__, 'get_products' ] ],
		];
	}

	public static function get_products() {
		return self::StripeClient()->products->all( [ 'limit' => 3 ] );
	}
}

