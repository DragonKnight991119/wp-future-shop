<?php
/**
 * Stripe Connector
 *
 * @todo Class needs documentation and refining.
 *
 * @package FutureShop
 */

namespace FutureShop\APIs\Stripe;

use FutureShop\APIs\API;
use FutureShop\Config\Stripe;

/**
 * Core class for Stripe connector.
 */
class Core extends API {

	/**
	 * Sets up the Stripe client connection.
	 *
	 * @return object The connected Stripe client object or error.
	 */
	public static function StripeClient() {
		return new \Stripe\StripeClient( Stripe::secret_key() );
	}
}

