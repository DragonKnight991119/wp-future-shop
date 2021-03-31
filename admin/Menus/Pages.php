<?php
/**
 * Admin Menu Pages
 *
 * @package FutureShop
 */

namespace FutureShop\Menus;

use FutureShop\Plugin;
use FutureShop\Config\Stripe;
use FutureShop\Helpers\Assets\Enqueue;
use FutureShop\Helpers\WP\Hooks;

/**
 * Admin Menus
 */
class Pages {

	/**
	 * Main menu position.
	 *
	 * @const number $position Admin menu position in WordPress.
	 */
	const POSITION = 55;

	/**
	 * Main menu SLUG.
	 *
	 * @const number $position Admin menu position in WordPress.
	 */
	const SLUG = 'future-shop';

	/**
	 * Main menu capabilities.
	 *
	 * @const number $position Admin menu position in WordPress.
	 */
	const CAP = 'manage_options';

	/**
	 * Menu Constructor
	 */
	public function __construct() {
		Hooks::load( __CLASS__ );
		Stripe::load();
	}

	/**
	 * Adds a menu sepearator befor our main menu;
	 *
	 * @return void
	 *
	 * @todo Check to ensure the menu position is available.
	 *
	 * @wp.hook action admin_init
	 */
	public static function add_menu_seperator() {
		$position = self::POSITION - 1;

		$GLOBALS['menu'][ $position ] = [ // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			'',
			'read',
			'separator' . $position,
			'',
			'wp-menu-separator',
		];

		ksort( $GLOBALS['menu'] );
	}

	/**
	 * Menu Page
	 *
	 * @return void
	 *
	 * @wp.hook action admin_menu
	 */
	public static function add_menu_page() {
		\add_menu_page(
			__( 'Store', 'future-shop' ),
			__( 'Store', 'future-shop' ),
			self::CAP,
			self::SLUG,
			[ __CLASS__, 'app' ],
			'dashicons-store',
			self::POSITION
		);
	}

	/**
	 * Menu Page
	 *
	 * @return void
	 *
	 * @wp.hook action admin_menu
	 */
	public static function add_submenu_pages() {
		foreach ( Data::submenu_pages() as $submenu => $data ) {
			\add_submenu_page(
				self::SLUG,
				$data['title'],
				$data['title'],
				self::CAP,
				self::SLUG . '.' . $submenu,
				[ $data['class'], 'render' ]
			);
		}
	}

	/**
	 * Application Scripts
	 *
	 * @return void
	 *
	 * @wp.hook action admin_enqueue_scripts
	 */
	public static function enqueue_scripts() {
		if ( ! strstr( get_current_screen()->id, self::SLUG ) ) {
			return;
		}

		Enqueue::script( 'app', 'app.js', [ 'wp-element' ] );
		Enqueue::style( 'app', 'app.css' );
	}

	/**
	 * Loads the app wrapper aaaaand... that's about it. 👉🏻
	 *
	 * @return void
	 */
	public static function app() {
		echo \wp_kses( '<div id="future-shop">FutureShop</div>', [ 'div' => [ 'id' => [] ] ] );
	}
}
