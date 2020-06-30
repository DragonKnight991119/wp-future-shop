<?php
/**
 * Stripe Connector
 *
 * @todo Class needs documentation and refining.
 *
 * @package S4B
 */

namespace S4B\Connectors\Stripe;

use S4B\Connectors\Connector;

class Core extends Connector {

	public static function StripeClient() {
		// @TODO Constant needs to be defined.
		return new \Stripe\StripeClient( 'S4B_STRIPE_API_KEY' );
	}
}

