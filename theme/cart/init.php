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
				<span id="cart-close" class="cart-close" title="close">&times;</span>
				<h4>Cart</h4>
			</div>
			<div class="cart-body">
				<div class="cart-item">
					<div class="item-image">
						<a href="#link-to-product">
							<img src="https://placehold.it/50x50" alt="item title">
						</a>
					</div>
					<div class="item-contents">
						<span class="item-title">
							<a href="#link-to-product">
								Widget 1
							</a>
						</span>
						<div class="cart-actions">
							<div class="quantity-selector">
								<label for="" class="hidden">Quantity</label>
								<button class="item-decrement" type="button" aria-label="Reduce item quantity by one" title="Reduce item quantity by one">-</button>
								<input type="text" id="" class="item-quantity-input" min="0" readonly>
								<button class="item-increment" type="button" aria-label="Increase item quantity by one" title="Increase item quantity by one">+</button>
							</div>
							<div class="remove-item">
								<button aria-label="Remove item" title="Remove item">&times;</button>
							</div>
						</div>
					</div>
					<div class="item-price">
						$9.99
					</div>
				</div>
			</div>
			<div class="cart-footer">
				<div class="subtotal-group">
					<span>Subtotal</span>
					<span>$99.99</span>
				</div>
				<p>Shipping, taxes, and discounts calculated at checkout.</p>
				<div class="checkout-options">
					<button>Checkout</button>
				</div>
			</div>
			</div>

		</div>
		<?php
	}

}
