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
	 * Register a single price route.
	 *
	 * @return array Single price route registration array.
	 */
	public static function register_route_price() {
		return [
			'namespace' => 'stripe/v7',
			'route'     => '/price/(?P<id>[\a-zA-Z0-9_]+)',
			'args'      => [
				'methods'  => 'GET',
				'callback' => [ __CLASS__, 'single' ],
			],
		];
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
	 * Updates a single price route.
	 *
	 * @return array Single price route registration array.
	 */
	public static function register_route_update_price() {
		return [
			'namespace' => 'stripe/v7',
			'route'     => '/price/(?P<id>[\a-zA-Z0-9_]+)',
			'args'      => [
				'methods'  => 'POST',
				'callback' => [ __CLASS__, 'update' ],
			],
		];
	}

	/**
	 * Deletes a single price route.
	 *
	 * @return array Single price route registration array.
	 */
	public static function register_route_delete_price() {
		return [
			'namespace' => 'stripe/v7',
			'route'     => '/price/(?P<id>[\a-zA-Z0-9_]+)',
			'args'      => [
				'methods'  => 'DELETE',
				'callback' => [ __CLASS__, 'delete' ],
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

	/**
	 * Retrieve a single price, based on the price ID.
	 *
	 * @todo Implement parameters.
	 *
	 * @return array JSON ready array.
	 */
	public static function single( object $request ) {
		return self::StripeClient()->prices->retrieve( $request->get_param( 'id' ) );
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

	/**
	 * Retrieve a single price, based on the price ID.
	 * Updates the specified price by setting the values of the parameters passed. Any parameters not provided are left unchanged.
	 * 
	 * Note: After prices are created, you can only update their metadata, nickname, and active fields. So we'll update the original price to inactive and create a new one.
	 *
	 * @todo Implement parameters.
	 *
	 * @return array JSON ready array.
	 */
	public static function update( object $request ) {

		$params = $request->get_params();

		self::StripeClient()->prices->update( 
			$request->get_param( 'id' ),
			[ 
				array (
					'active' => false
				)
			]
		);

		// Unset the price ID so it isn't used in the next call to create a new price.
		if ( !empty( $params['id'] ) ) {
			unset( $params['id'] );
		}

		$params['currency'] = FSStripe::get_store_currency();
		
		return self::StripeClient()->prices->create( $params );
	}

	/**
	 * Delete a single price, based on the price ID.
	 *
	 * @todo Implement parameters.
	 *
	 * @return array JSON ready array.
	 */
	public static function delete( object $request ) {
		return self::StripeClient()->prices->delete( $request->get_param( 'id' )  );
	}
}

