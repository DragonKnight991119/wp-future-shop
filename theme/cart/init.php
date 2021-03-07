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
		<div id="myModal" class="modal">

			<!-- Modal content -->
			<div class="modal-content">
			<div class="modal-header">
				<span class="close">&times;</span>
				<h2>Modal Header</h2>
			</div>
			<div class="modal-body">
				<p>Some text in the Modal Body</p>
				<p>Some other text...</p>
			</div>
			<div class="modal-footer">
				<h3>Modal Footer</h3>
			</div>
			</div>

		</div>
		<?php
	}

}
