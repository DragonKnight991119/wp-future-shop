<?php
/**
 * Future Shop Blocks
 *
 * @package FutureShop
 * @subpackage Editor
 */

namespace FutureShop\Editor;

use FutureShop\Plugin;
use FutureShop\Helpers\Assets\Manifest;
use FutureShop\Helpers\Assets\Debug;

// Blocks configuration array.
$blocks = [
	'namespace' => 'future-shop',
	'active'    => [
		'add-to-cart',
	],
];

$version = Debug::script() ? time() : Plugin::version();

\add_filter(
	'block_categories',
	/**
	 * Filter the block categories to add Future Shop.
	 *
	 * @param array $categories Block categories.
	 *
	 * @return array
	 */
	function( $categories ) use ( $blocks ) {
		return array_merge(
			[
				[
					'slug'  => $blocks['namespace'],
					'title' => __( 'Future Shop', 'future-shop' ),
				],
			],
			$categories,
		);
	}
);

// Loop over the active blocks and register.
foreach ( $blocks['active'] as $block ) {
	$block_path = __DIR__ . '/blocks/' . $block;
	$config     = $block_path . '/block.json';

	if ( file_exists( $config ) ) {
		$block = json_decode( file_get_contents( $config ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$args  = [];

		foreach ( $block['assets'] as $asset => $deps ) {
			// Setup the asset handle, which is based on the name and type.
			$handle = str_replace( '/', '-', $block['name'] );

			// Append editor to handle for editor files.
			if ( ! empty( strstr( $asset, 'editor' ) ) ) {
				$handle = $handle . '-editor';
			}

			// Append style to handle for css files.
			if ( ! empty( strstr( $asset, 'style' ) ) ) {
				$handle = $handle . '-style';
			}

			// Add assets to args, for registration.
			$args[ $asset ] = $handle;

			$file = str_replace( 'future-shop-', '', $handle ) . ( empty( strstr( $handle, '-style' ) ) ? '.js' : '.css' );

			// No asset found in the manifest, so bail.
			if ( ! array_key_exists( $file, Manifest::data() ) ) {
				return;
			}

			$file = Manifest::data( $file );

			if ( empty( strstr( $handle, '-style' ) ) ) {
				wp_register_script(
					$handle,
					Plugin::asset( $file ),
					$deps,
					$version,
					true
				);
			} else {
				wp_register_style(
					$handle,
					Plugin::asset( $file ),
					$deps,
					$version
				);
			}
		}

		if ( file_exists( $block_path . '/render.php' ) ) {
			require_once $block_path . '/render.php';
			$args['render_callback'] = preg_replace( '/-|\//', '_', $block['name'] ) . '_block_render';
		}

		\register_block_type( $block['name'], $args );
	}
}
