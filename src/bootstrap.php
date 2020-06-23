<?php
/**
 * Bootstrap the plugin.
 *
 * @package S4B
 */

namespace S4B;

use S4B\WP\Hooks;

/**
 * Bootstrap class, primarily used for kicking things off and cleanup.
 */
class Bootstrap extends Hooks {
	/**
	 * Bootstrap constructor.
	 */
	public function __construct() {
		$this->load_hooks( __CLASS__ );

		register_activation_hook( S4B_FILE, [ $this, 'activate' ] );
		register_deactivation_hook( S4B_FILE, [ $this, 'deactivate' ] );
	}

	/**
	 * Activate plugin.
	 *
	 * @return void
	 */
	public function activate() {}

	/**
	 * Deactivate plugin.
	 *
	 * @return void
	 */
	public function deactivate() {}

	/**
	 * Loads the admin.
	 *
	 * @wp.hook action plugins_loaded
	 */
	public static function admin() {
		new Admin\Menu( __CLASS__ );
	}
}
