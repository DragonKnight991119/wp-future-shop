<?php
/**
 * Future Shop's Cart.
 *
 * @package FutureShop
 */

namespace FutureShop\Theme\Cart;

use FutureShop\Plugin;
use FutureShop\Config\Stripe;
use FutureShop\Helpers\WP\Hooks;
use FutureShop\Helpers\Assets\Enqueue;
/**
 * Admin Menus
 */
class Init {

	const SLUG  = 'cart';
	const FILE  = 'cart.js';
	const STYLE = 'cart.css';

	/**
	 * Menu Constructor
	 */
	public function __construct() {
		Hooks::load( __CLASS__ );

	}

	/**
	 * Cart Script.
	 *
	 * @return void
	 *
	 * @wp.hook action wp_enqueue_scripts
	 */
	public static function enqueue_scripts() {
		Enqueue::script( self::SLUG, self::FILE );
		Enqueue::style( self::SLUG, self::STYLE );

		// Bring in StripeJS for the cart, we need it for checkout.
		wp_enqueue_script(
			'stripe-js',
			'//js.stripe.com/v3',
			[],
			false,
			false
		);

		// Send any info the cart might need to the frontend.
		wp_localize_script(
			'future-shop-cart',
			'future_shop',
			[ 
				'cart_svg' => file_get_contents( __DIR__ . '/cart.svg' ),
				'cart_src' => plugin_dir_url( __DIR__ ) . 'cart/cart.svg',
				'fs_pk'    => Stripe::public_key()
			] 
		);
	}
	/**
	 * Cart Template.
	 *
	 * @return void
	 *
	 * @wp.hook action wp_footer
	 */
	public static function cart_template() {
		?>
		<div id="future-shop-cart-background" class="future-shop-cart-background">

			<!-- Modal content -->
			<div class="future-shop-cart-content">
			<div class="cart-header">
				<span id="cart-close" class="cart-close" title="close">&times;</span>
				<h4>Cart</h4>
			</div>
			<div id="cart-body" class="cart-body">
			</div>
			<div class="cart-footer">
				<div class="subtotal-group">
					<span>Subtotal</span>
					<span id="cart-subtotal"></span>
				</div>
				<p>Shipping, taxes, and discounts calculated at checkout.</p>
				<div class="checkout-options">
					<button id="future-shop-stripe-checkout-button" class="checkout-button">Checkout</button>
				</div>
			</div>
			</div>

		</div>
		<?php
	}

}
