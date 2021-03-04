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
	}

	/**
	 * Loads the app wrapper aaaaand... that's about it. 👉🏻
	 *
	 * @return void
	 */
	public static function app() {

		$stripe_settings = Stripe::get_options();
		$pres_currencies = Stripe::get_presentment_currencies();

		echo \wp_kses( '<div id="future-shop">FutureShop</div>', [ 'div' => [ 'id' => [] ] ] );

		?>
		<div class="wrap">
		<form method="post" action="options.php">
			<?php \settings_fields( Stripe::OPTION_NAME . '_group' ); ?>
			<?php \do_settings_sections( Stripe::OPTION_NAME . '_group' ); ?>

			<table class="form-table">
				<tr valign="top">
				<th scope="row">Stripe Public Key</th>
				<td><input type="text" name="<?php echo esc_attr( Stripe::OPTION_NAME ); ?>[public_key]" value="<?php echo esc_attr( $stripe_settings['public_key'] ); ?>" /></td>
				</tr>
				<tr valign="top">
				<th scope="row">Stripe Secret Key</th>
				<td><input type="text" name="<?php echo esc_attr( Stripe::OPTION_NAME ); ?>[secret_key]" value="<?php echo esc_attr( $stripe_settings['secret_key'] ); ?>" /></td>
				</tr>
				<tr valign="top">
				<th scope="row">Store Currency</th>
				<td><select name="<?php echo esc_attr( Stripe::OPTION_NAME ); ?>[currency]" />
					<option>--Select a currency--</option>
					<?php foreach ( $pres_currencies as $key => $value ) : ?>
					<option
						value="<?php echo esc_attr( $key ); ?>"
						<?php echo ( $key === $stripe_settings['currency'] ) ? 'selected' : ''; ?>
						><?php echo esc_html( $value ); ?></option>
					<?php endforeach; ?>
				</select></td>
				</tr>
			</table>

			<?php submit_button(); ?>

		</form>
		</div>
		<?php
	}
}
