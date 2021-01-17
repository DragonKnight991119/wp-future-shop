<?php
/**
 * Stripe Products Connector
 *
 * @todo Class needs documentation and refining.
 *
 * @package FutureShop
 */

namespace FutureShop\Connectors\Stripe;

/**
 * Products class.
 */
class Products extends Core {

	/**
	 * Constructor, which registers the endpoints.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->register( __CLASS__ );
	}

	/**
	 * Register the products route.
	 *
	 * @return array Products route registration array.
	 */
	public static function register_route_products() {
		return [
			'namespace' => 'stripe/v7',
			'route'     => '/products',
			'args'      => [ 'callback' => [ __CLASS__, 'all' ] ],
		];
	}

	/**
	 * Retrieve all products, based on specific parameters.
	 *
	 * @todo Implement parameters.
	 *
	 * @return array JSON ready array.
	 */
	public static function all() {
		return self::StripeClient()->products->all();
	}
}

