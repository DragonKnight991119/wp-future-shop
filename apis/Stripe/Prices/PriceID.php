<?php
/**
 * Stripe Prices
 *
 * @todo Class needs documentation and refining.
 *
 * @package FutureShop
 */

namespace FutureShop\APIs\Stripe;

namespace FutureShop\APIs\Stripe\Prices;

use FutureShop\APIs\Stripe\Core;
use FutureShop\Config\Stripe as FSStripe;

/**
 * Prices class.
 */
class PriceID extends Core {

	/**
	 * Constructor, which registers the endpoints.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->register( __CLASS__ );
	}

	/**
	 * Register a single price route.
	 * Updates a single price route.
	 * Deletes a single price route.
	 *
	 * @return array Single price route registration array.
	 */
	public static function register_route_price() {
		return [
			'namespace' => 'stripe/v7',
			'route'     => '/price/(?P<id>[\a-zA-Z0-9_]+)',
			'args'      => [
				[
					'methods'             => 'GET',
					'callback'            => [ __CLASS__, 'single' ],
					'permission_callback' => function() {
						return current_user_can( 'administrator' );
					},
				],
				[
					'methods'             => 'POST',
					'callback'            => [ __CLASS__, 'update' ],
					'permission_callback' => function() {
						return current_user_can( 'administrator' );
					},
				],
				[
					'methods'             => 'DELETE',
					'callback'            => [ __CLASS__, 'delete' ],
					'permission_callback' => function() {
						return current_user_can( 'administrator' );
					},
				],
			],
		];
	}

	/**
	 * Retrieve a single price, based on the price ID.
	 *
	 * @param object $request Request object.
	 *
	 * @return array JSON ready array.
	 */
	public static function single( object $request ) {
		return self::StripeClient()->prices->retrieve( $request->get_param( 'id' ) );
	}

	/**
	 * Retrieve a single price, based on the price ID.
	 * Updates the specified price by setting the values of the parameters passed. Any parameters not provided are left unchanged.
	 *
	 * Note: After prices are created, you can only update their metadata, nickname, and active fields. So we'll update the original price to inactive and create a new one.
	 *
	 * @param object $request Request object.
	 *
	 * @return array JSON ready array.
	 */
	public static function update( object $request ) {

		$params = $request->get_params();

		self::StripeClient()->prices->update(
			$request->get_param( 'id' ),
			[
				[
					'active' => false,
				],
			]
		);

		// Unset the price ID so it isn't used in the next call to create a new price.
		if ( ! empty( $params['id'] ) ) {
			unset( $params['id'] );
		}

		$params['currency'] = FSStripe::get_store_currency();

		return self::StripeClient()->prices->create( $params );
	}

	/**
	 * Delete a single price, based on the price ID.
	 *
	 * @param object $request Request object.
	 *
	 * @return array JSON ready array.
	 */
	public static function delete( object $request ) {
		return self::StripeClient()->prices->delete( $request->get_param( 'id' ) );
	}
}

