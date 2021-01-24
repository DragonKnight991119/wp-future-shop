<?php
/**
 * Stripe Prices
 *
 * @todo Class needs documentation and refining.
 *
 * @package FutureShop
 */

namespace FutureShop\APIs\Stripe;

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
			'args'      => array(
				'methods'  => 'GET',
				'callback' => [ __CLASS__, 'all' ],
			)
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
			'args'      => array(
				'methods'  => 'GET',
				'callback' => [ __CLASS__, 'single' ],
			)
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
			'args'      => array(
				'methods'  => 'POST',
				'callback' => [ __CLASS__, 'create' ],
			)
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
			'route'     => '/product/(?P<id>[\a-zA-Z0-9_]+)',
			'args'      => array(
				'methods'  => 'POST',
				'callback' => [ __CLASS__, 'update' ],
			)
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
			'args'      => array(
				'methods'  => 'DELETE',
				'callback' => [ __CLASS__, 'delete' ],
			)
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
		return self::StripeClient()->prices->retrieve( $request->get_param( 'id' )  );
	}

	/**
	 * Create a single price, based on the price ID.
	 *
	 * @todo Implement parameters.
	 *
	 * @return array JSON ready array.
	 */
	public static function create( object $request ) {
		return self::StripeClient()->prices->create(
			array(
				'unit_amount' => $request->get_param( 'unit_amount' ),
				'currency'    => $request->get_param( 'currency' ),
				'product'     => $request->get_param( 'product' ),
			)
		);
	}

	/**
	 * Retrieve a single price, based on the price ID.
	 *
	 * @todo Implement parameters.
	 *
	 * @return array JSON ready array.
	 */
	public static function update( object $request ) {
		// var_dump($request->get_params());
		// wp_die();
		return self::StripeClient()->prices->update(
			$request->get_param( 'id' ),
			array(
				'name'        => $request->get_param( 'name' ),
				'description' => $request->get_param( 'description' ),
				'images'      => array(
					$request->get_param( 'feature_image' ),
				)
			)
		);
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

