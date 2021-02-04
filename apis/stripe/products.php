<?php
/**
 * Stripe Products
 *
 * @todo Class needs documentation and refining.
 *
 * @package FutureShop
 */

namespace FutureShop\APIs\Stripe;

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
			'args'      => [
				'methods'  => 'GET',
				'callback' => [ __CLASS__, 'all' ],
			]
		];
	}

	/**
	 * Register a single product route.
	 *
	 * @return array Single product route registration array.
	 */
	public static function register_route_product() {
		return [
			'namespace' => 'stripe/v7',
			'route'     => '/product/(?P<id>[\a-zA-Z0-9_]+)',
			'args'      => [
				'methods'  => 'GET',
				'callback' => [ __CLASS__, 'single' ],
			]
		];
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
				'methods'  => 'POST',
				'callback' => [ __CLASS__, 'create' ],
			]
		];
	}

	/**
	 * Updates a single product route.
	 *
	 * @return array Single product route registration array.
	 */
	public static function register_route_update_product() {
		return [
			'namespace' => 'stripe/v7',
			'route'     => '/product/(?P<id>[\a-zA-Z0-9_]+)',
			'args'      => [
				'methods'  => 'POST',
				'callback' => [ __CLASS__, 'update' ],
			]
		];
	}

	/**
	 * Deletes a single product route.
	 *
	 * @return array Single product route registration array.
	 */
	public static function register_route_delete_product() {
		return [
			'namespace' => 'stripe/v7',
			'route'     => '/product/(?P<id>[\a-zA-Z0-9_]+)',
			'args'      => [
				'methods'  => 'DELETE',
				'callback' => [ __CLASS__, 'delete' ],
			]
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

	/**
	 * Retrieve a single product, based on the product ID.
	 *
	 * @todo Implement parameters.
	 *
	 * @return array JSON ready array.
	 */
	public static function single( object $request ) {
		return self::StripeClient()->products->retrieve( $request->get_param( 'id' )  );
	}

	/**
	 * Create a single product, based on the product ID.
	 *
	 * @todo Implement parameters.
	 *
	 * @return array JSON ready array.
	 */
	public static function create( object $request ) {
		return self::StripeClient()->products->create(
			[
				'name'        => $request->get_param( 'name' ),
				'description' => $request->get_param( 'description' ),
				'active'      => true,// force true on creation
				'type'        => 'good',// force good on creation
				'images'      => [
					$request->get_param( 'featured_image' ),
				]
			]
		);
	}

	/**
	 * Retrieve a single product, based on the product ID.
	 *
	 * @todo Implement parameters.
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
				]
			]
		);
	}

	/**
	 * Delete a single product, based on the product ID.
	 *
	 * @todo Implement parameters.
	 *
	 * @return array JSON ready array.
	 */
	public static function delete( object $request ) {
		return self::StripeClient()->products->delete( $request->get_param( 'id' )  );
	}
}

