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
class Price extends Core {

	/**
	 * Constructor, which registers the endpoints.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->register( __CLASS__ );
	}

	/**
	 * Creates a single price route.
	 *
	 * @return array Single price route registration array.
	 */
	public static function register_route_create_price() {
		return [
			'namespace' => 'stripe/v7',
			'route'     => '/price',
			'args'      => [
				'methods'  => 'POST',
				'callback' => [ __CLASS__, 'create' ],
			],
		];
	}

	/**
	 * Create a single price, based on the price ID.
	 *
	 * @todo Implement parameters.
	 *
	 * @return array JSON ready array.
	 */
	public static function create( object $request ) {

		$params = $request->get_params();

		if ( !empty( $params['id'] ) ) {
			unset( $params['id'] );
		}
		
		return self::StripeClient()->prices->create(
			[
				'unit_amount' => $params['unit_amount'],
				'currency'    => FSStripe::get_store_currency(),
				'product'     => $params['product'],
			]
		);
	}
}

