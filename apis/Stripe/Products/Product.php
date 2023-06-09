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
class Product extends Core {

	/**
	 * Constructor, which registers the endpoints.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->register( __CLASS__ );
	}

	/**
	 * Creates a single product route.
	 *
	 * @return array Single product route registration array.
	 */
	public static function register_route_create_product() {
		return [
			'namespace' => 'stripe/v7',
			'route'     => '/product',
			'args'      => [
				'methods'             => 'POST',
				'callback'            => [ __CLASS__, 'create' ],
				'permission_callback' => function() {
					return current_user_can( 'administrator' );
				},
			],
		];
	}

	/**
	 * Create a single product, based on the product ID.
	 *
	 * @param object $request Request object.
	 *
	 * @return array JSON ready array.
	 */
	public static function create( object $request ) {
		return self::StripeClient()->products->create(
			[
				'name'        => $request->get_param( 'name' ),
				'description' => $request->get_param( 'description' ),
				'active'      => true,
				'type'        => 'good',
				'images'      => [
					$request->get_param( 'featured_image' ),
				],
			]
		);
	}
}

