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
			<p>To start using Future Shop, you will need to enter your Stripe API Keys below.<br/>You can grab your <b>live</b> Stripe Keys <a href="https://dashboard.stripe.com/apikeys" target="_blank" rel="noopener noreferrer">here</a> or your <b>test</b> Stripe Keys <a href="https://dashboard.stripe.com/test/apikeys" target="_blank" rel="noopener noreferrer">here</a>.<br/>You can read more about Stripe API Keys <a href="https://stripe.com/docs/keys" target="_blank" rel="noopener noreferrer">here</a></p>

			<form method="post" action="options.php">
				<?php \settings_fields( Stripe::OPTION_NAME . '_group' ); ?>
				<?php \do_settings_sections( Stripe::OPTION_NAME . '_group' ); ?>
				<?php $cart_position = $stripe_settings['cart_position']; ?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row">Stripe Public Key</th>
						<td><input type="text" class="regular-text" name="<?php echo esc_attr( Stripe::OPTION_NAME ); ?>[public_key]" value="<?php echo esc_attr( $stripe_settings['public_key'] ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row">Stripe Secret Key</th>
						<td><input type="password" class="regular-text" name="<?php echo esc_attr( Stripe::OPTION_NAME ); ?>[secret_key]" value="<?php echo esc_attr( $stripe_settings['secret_key'] ); ?>" /></td>
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
					<tr valign="top">
						<th scope="row">Thank You Page</th>
						<td>
							<?php
								wp_dropdown_pages(
									array(
										'name'             => esc_attr( Stripe::OPTION_NAME . '[thank_you_page]' ),
										'echo'             => 1,
										'show_option_none' => esc_attr( '&mdash; Select &mdash;' ),
										'option_none_value' => '0',
										'selected'         => esc_attr( $stripe_settings['thank_you_page'] ),
									)
								);
							?>
							<p>This is the page that should customers will be redirected to after a successful<br/>payment on Stripe Checkout.</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Cart Bubble Position</th>
						<td><select name="<?php echo esc_attr( Stripe::OPTION_NAME ); ?>[cart_position]"/>
							<option>--Select a cart position--</option>
							<?php foreach ( self::CART_POSITIONS as $key => $value ) : ?>
							<option
								value="<?php echo esc_attr( $key ); ?>"
								<?php echo ( $key === $stripe_settings['cart_position'] ) ? 'selected' : ''; ?>
								><?php echo esc_html( $value ); ?></option>
							<?php endforeach; ?>
						</select>
						<p>Select a position for your cart bubble to appear.<br/>Otherwise, you can add a cart span menu item to your WordPress menus with:<br/><code><?php echo esc_html( '<span title="cart" class="future-shop-menu-cart"></span>' ); ?></code></p>
						</td>
					</tr>
				</table>

				<?php submit_button(); ?>

			</form>
		</div>
		<?php
	}
}
