<?php
/**
 * Future Shop's Cart.
 *
 * @package FutureShop
 */

namespace FutureShop\Theme\Cart;

use FutureShop\Plugin;
use FutureShop\Helpers\Assets\Enqueue;
use FutureShop\Helpers\WP\Hooks;

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

		wp_localize_script(
			'future-shop-cart',
			'future_shop',
			[ 'cart_svg' => file_get_contents( __DIR__ . '/cart.svg' ) ] 
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
				<span id="cart-close" class="cart-close" title="close">Close &times;</span>
				<h3>Cart</h3>
			</div>
			<div class="cart-body">
				<div class="cart-item">
					<div class="item-image">
						<img src="https://placehold.it/50x50" alt="item title">
					</div>
					<div class="item-contents">
						<span class="item-title">
							Widget 1
						</span>
						<div class="cart-actions">
							<div class="quantity-selector">
								<label for="" class="hidden">Quantity</label>
								<button class="item-decrement" type="button" aria-label="Reduce item quantity by one">-</button>
								<input type="number" id="" class="item-quantity-input" min="0" value="1">
								<button class="item-increment" type="button" aria-label="Increase item quantity by one">+</button>
							</div>
							<div class="item-price">
								$9.99
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="cart-footer">
				<h4>Subtotal</h3>
				<p>Shipping, taxes, and discounts calculated at checkout.</p>
				<button>Checkout</button>
			</div>
			</div>

		</div>
		<?php
	}

}
