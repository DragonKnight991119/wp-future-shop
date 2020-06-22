<?php
/**
 * Bootstrap the plugin.
 *
 * @package S4B
 */

namespace S4B;

/**
 * Bootstrap class, primarily used for kicking things off and cleanup.
 */
class Bootstrap {

	/**
	 * Bootstrap constructor.
	 */
	public function __construct() {
		$this->load_hooks( __CLASS__ );

		// Register plugin on/off hooks.
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
}
