<?php
/**
 * Stripe Connector
 *
 * @todo Class needs documentation and refining.
 *
 * @package FutureShop
 */

namespace FutureShop\Connectors\Stripe;

use FutureShop\Connectors\Connector;

/**
 * Core class for Stripe connector.
 */
class Core extends Connector {

	/**
	 * Sets up the Stripe client connection.
	 *
	 * @return object The connected Stripe client object or error.
	 */
	public static function StripeClient() {
		// @todo Constant needs to be defined.
		return new \Stripe\StripeClient( 'S4B_STRIPE_API_KEY' );
	}
}

