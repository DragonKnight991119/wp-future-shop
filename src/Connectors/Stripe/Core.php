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

class Core extends Connector {

	public static function StripeClient() {
		// @TODO Constant needs to be defined.
		return new \Stripe\StripeClient( 'S4B_STRIPE_API_KEY' );
	}
}

