<?php
/**
 * Stripe Products
 *
 * @todo Class needs documentation and refining.
 *
 * @package FutureShop
 */

namespace FutureShop\APIs\Stripe\Products;

use FutureShop\APIs\Stripe\Core;

/**
 * Products class.
 */
class ProductID extends Core {

	/**
	 * Constructor, which registers the endpoints.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->register( __CLASS__ );
	}

	/**
	 * Register a single product route.
	 * Updates a single product route.
	 * Deletes a single product route.
	 *
	 * @return array Single product route registration array.
	 */
	public static function register_route_product() {
		return [
			'namespace' => 'stripe/v7',
			'route'     => '/product/(?P<id>[\a-zA-Z0-9_]+)',
			'args'      => [
				[
					'methods'  => 'GET',
					'callback' => [ __CLASS__, 'single' ],
				],
				[
					'methods'  => 'POST',
					'callback' => [ __CLASS__, 'update' ],
				],
				[
					'methods'  => 'DELETE',
					'callback' => [ __CLASS__, 'delete' ],
				],
			],
		];
	}

	/**
	 * Retrieve a single product, based on the product ID.
	 *
	 * @param object $request Request object.
	 *
	 * @return array JSON ready array.
	 */
	public static function single( object $request ) {
		return self::StripeClient()->products->retrieve( $request->get_param( 'id' ) );
	}

	/**
	 * Retrieve a single product, based on the product ID.
	 *
	 * @param object $request Request object.
	 *
	 * @return array JSON ready array.
	 */
	public static function update( object $request ) {
		return self::StripeClient()->products->update(
			$request->get_param( 'id' ),
			[
				'name'        => $request->get_param( 'name' ),
				'description' => $request->get_param( 'description' ),
				'images'      => [
					$request->get_param( 'featured_image' ),
				],
			]
		);
	}

	/**
	 * Delete a single product, based on the product ID.
	 *
	 * @param object $request Request object.
	 *
	 * @return array JSON ready array.
	 */
	public static function delete( object $request ) {
		return self::StripeClient()->products->delete( $request->get_param( 'id' ) );
	}
}

