<?php
/**
 * Admin Menu Settings Submenu Page
 *
 * @dev-note This setting page is only temporary, as all settings will be stored
 *           using the REST API, managed through an app, in the future.
 *
 * @package FutureShop
 */

namespace FutureShop\Menus;

use FutureShop\Config\Stripe;

/**
 * Setting page.
 */
class Settings {

	/**
	 * Loads the settings.
	 *
	 * @return void
	 */
	public static function render() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved', 'wporg' ), 'updated' );
		}

		settings_errors( 'wporg_messages' );

		$stripe_settings   = Stripe::get_options();
		$pres_currencies   = Stripe::get_presentment_currencies();
		$selected_currency = $stripe_settings['currency'] ?? '';

		?>
		<div class="wrap">
			<form method="post" action="options.php">
				<?php \settings_fields( Stripe::OPTION_NAME . '_group' ); ?>

				<table class="form-table">
					<tr valign="top">
						<th scope="row">Stripe Public Key</th>
						<td><input type="text" name="<?php echo esc_attr( Stripe::OPTION_NAME ); ?>[public_key]" value="<?php echo esc_attr( $stripe_settings['public_key'] ?? '' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row">Stripe Secret Key</th>
						<td><input type="password" name="<?php echo esc_attr( Stripe::OPTION_NAME ); ?>[secret_key]" value="<?php echo esc_attr( $stripe_settings['secret_key'] ?? '' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row">Store Currency</th>
						<td>
							<select name="<?php echo esc_attr( Stripe::OPTION_NAME ); ?>[currency]" />
								<option selected disabled>Choose Currency</option>
								<?php foreach ( $pres_currencies as $key => $value ) : ?>
									<option value="<?php echo esc_attr( $key ); ?>" <?php echo ( $key === $stripe_settings['currency'] ) ? 'selected' : ''; ?>>
										<?php echo esc_html( $value ); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
				</table>

				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
}
