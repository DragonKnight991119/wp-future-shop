<?php
/**
 * Stripe configuration settings access and storage.
 *
 * @package FutureShop
 */

namespace FutureShop\Config;

/**
 * Allows accessing and controling Stripe configuration settings.
 */
class Stripe {

	/**
	 * Option name for Stripe configuration settings.
	 *
	 * @var string
	 */
	const OPTION_NAME = 'future_shop_stripe_settings';

	/**
	 * Construct the allowed options.
	 *
	 * @return void.
	 */
	public static function load() {
		\add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
	}

	/**
	 * Register the allowed options.
	 *
	 * @return void.
	 */
	public static function register_settings() {
		\register_setting( self::OPTION_NAME . '_group', 'stripe_public_key' );
		\register_setting( self::OPTION_NAME . '_group', 'stripe_secret_key' );	
	}

	/**
	 * Get the Future Shop options for Stripe.
	 *
	 * @return mixed Options array or false.
	 */
	public function get_options() {
		return \get_option( self::OPTION_NAME ) ?: [];
		return \get_option( self::OPTION_NAME ) ?: [];
	}

	/**
	 * Set the Future Shop options for Stripe.
	 *
	 * @param array $new_options New options to set.
	 *
	 * @return boolean True if options updated, otherwise false.
	 */
	private function set_options( $new_options = [] ) {
		return \update_option( self::OPTION_NAME, array_merge( $this->get_options(), $new_options ), false );
	}

	/**
	 * Check if the keys are defined.
	 *
	 * @return boolean True if both defined, otherwise false.
	 */
	public function keys_defined() {
		return defined( 'FUTURE_SHOP_STRIPE_PUBLIC_KEY' ) && defined( 'FUTURE_SHOP_STRIPE_SECRET_KEY' ) ? true : false;
	}

	/**
	 * Returns the Stripe public key option.
	 *
	 * @return mixed Public key as a string, otherwise false.
	 */
	public static function public_key() {
		$key = false;

		if ( defined( 'FUTURE_SHOP_STRIPE_PUBLIC_KEY' ) ) {
			$key = FUTURE_SHOP_STRIPE_PUBLIC_KEY;
		} else {
			$options = self::get_options();

			$key = $options['public_key'] ?: false;
		}

		return $key;
	}

	/**
	 * Returns the Stripe secret key option.
	 *
	 * @return mixed Secret key as a string, otherwise false.
	 */
	public static function secret_key() {
		$key = false;

		if ( defined( 'FUTURE_SHOP_STRIPE_SECRET_KEY' ) ) {
			$key = FUTURE_SHOP_STRIPE_SECRET_KEY;
		} else {
			$options = self::get_options();

			$key = $options['secret_key'] ?: false;
		}

		return $key;
	}
}
