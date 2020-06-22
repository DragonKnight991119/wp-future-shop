<?php
/**
 * Stripe for Business
 *
 * @package   S4B
 * @author    Justin Kopepasah
 * @license   MPL-2.0
 *
 * Plugin Name:       Stripe for Business
 * Plugin URI:        https://juko.co/wp/plugins/stripe-for-business
 * Description:       Simple. Fast. Secure. Run your store with Stripe for Business, the only plugin with full Stripe integration to manage your business using WordPress.
 * Version:           0.0.1
 * Requires at least: 5.4
 * Requires PHP:      7.2
 * Author:            Justin Kopepasah
 * Author URI:        https://kopepasah.com
 * Text Domain:       stripe-for-business
 * License:           MPL-2.0
 * License URI:       https://www.mozilla.org/en-US/MPL/2.0/
 */

/**
 * Before we start the party, let's define some needed constants.
 *
 * @dev-note:
 *     These constants are organized alphabetically, manually. When adding
 *     constants, let's keep them in order. 🙏🏻 Thank you!
 */
foreach ( [
	'DIR'     => \plugin_dir_path( __FILE__ ),
	'URL'     => \plugin_dir_url( __FILE__ ),
	'VERSION' => \get_file_data( __FILE__, [ 'Version' => 'Version' ], 'plugin' )['Version'],
] as $name => $value ) {
	define( 'S4B_' . $name, $value );
}

// 🥳 Let's get this party started.
require_once S4B_DIR . 'src/bootstrap.php';
