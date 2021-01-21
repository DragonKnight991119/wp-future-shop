<?php
/**
 * Stripe Products API
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
			'args'      => [ 'callback' => [ __CLASS__, 'all' ] ],
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
			'args'      => [ 'callback' => [ __CLASS__, 'single' ] ],
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
}

