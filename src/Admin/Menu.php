<?php
/**
 * Admin Menu Pages
 *
 * @package S4B
 */

namespace S4B\Admin;

use S4B\WP\Hooks;
use S4B\Config\Data;

/**
 * Admin Menus
 */
class Menu extends Hooks implements Admin {

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
	const SLUG = 'stripe-for-business';

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
		$this->load_hooks( __CLASS__ );
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
			__( 'Store', 'stripe-for-business' ),
			__( 'Store', 'stripe-for-business' ),
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
		foreach ( Data::submenu_pages() as $submenu ) {
			\add_submenu_page(
				self::SLUG,
				ucwords( $submenu ),
				ucwords( $submenu ),
				self::CAP,
				self::SLUG . '.' . $submenu,
				[ __CLASS__, 'app' ]
			);
		}
	}

	/**
	 * Loads the app wrapper aaaaand... that's about it. 👉🏻
	 *
	 * @return void
	 */
	public static function app() {
		echo \wp_kses( '<div id="stripe-for-busiess">S4B</div>', [ 'div' => [ 'id' => [] ] ] );
	}
}
