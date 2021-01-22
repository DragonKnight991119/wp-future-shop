<?php
/**
 * Stripe Connection
 *
 * @todo Class needs documentation and refining.
 *
 * @package FutureShop
 */

namespace FutureShop\APIs\Stripe;

use FutureShop\Config\Stripe;
use FutureShop\APIs\API;

/**
 * Core class for Stripe connection.
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

