<?php
/**
 * Stripe Prices
 *
 * @todo Class needs documentation and refining.
 *
 * @package FutureShop
 */

namespace FutureShop\APIs\Stripe;

use FutureShop\Config\Stripe as FSStripe;

/**
 * Prices class.
 */
class Prices extends Core {

	/**
	 * Constructor, which registers the endpoints.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->register( __CLASS__ );
	}

	/**
	 * Register the prices route.
	 *
	 * @return array Prices route registration array.
	 */
	public static function register_route_prices() {
		return [
			'namespace' => 'stripe/v7',
			'route'     => '/prices',
			'args'      => [
				'methods'  => 'GET',
				'callback' => [ __CLASS__, 'all' ],
			],
		];
	}

	/**
	 * Retrieve all prices, based on specific parameters.
	 *
	 * @todo Implement parameters.
	 *
	 * @return array JSON ready array.
	 */
	public static function all() {
		return self::StripeClient()->prices->all();
	}
}

