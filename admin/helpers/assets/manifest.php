<?php
/**
 * Assets manifest loader.
 *
 * @package FutureShop
 */

namespace FutureShop\Helpers\Assets;

use FutureShop\Plugin;
use FutureShop\Helpers\Cache\Config;

/**
 * Manifest class
 */
class Manifest {

	const CACHE_KEY = 'manifest';
	const FILE      = 'dist/manifest.json';

	/**
	 * Static caller for manifest data array.
	 *
	 * @param string $key Array key for which to search.
	 *
	 * @return array Array of manifest data or empty array.
	 */
	public static function data( $key = '' ) {
		$data = \wp_cache_get( self::CACHE_KEY );

		if ( ! $data ) {
			$file = Plugin::path( self::FILE );

			$data = json_decode( file_get_contents( $file ), true ) ?? []; // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

			\wp_cache_set( self::CACHE_KEY, $data, Config::GROUP );
		}

		if ( ! empty( $key ) && array_key_exists( $key, $data ) ) {
			return $data[ $key ];
		} else {
			return $data;
		}

		return $data;
	}
}
