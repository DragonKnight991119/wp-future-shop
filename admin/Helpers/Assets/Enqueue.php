<?php
/**
 * Enqueueing assets.
 *
 * @package FutureShop
 */

namespace FutureShop\Helpers\Assets;

use FutureShop\Plugin;

/**
 * Enqueue class
 */
class Enqueue {

	const PREFIX = 'future-shop';

	/**
	 * Scripts enqueue.
	 *
	 * @param string  $slug   Script file slug.
	 * @param string  $file   Script file to enqueue.
	 * @param array   $deps   Script dependencies.
	 * @param boolean $footer True to load after the opening body.
	 *
	 * @return void
	 */
	public static function script( $slug = '', $file = '', $deps = [], $footer = true ) {
		if ( empty( $slug ) ) {
			return;
		}

		$version = Debug::script() ? time() : Plugin::version();
		$slug    = ! empty( $slug ) ? self::PREFIX . '-' . $slug : false;

		if ( array_key_exists( $file, Manifest::data() ) ) {
			$file = Manifest::data( $file );
		}

		if ( ! empty( $file ) && file_exists( Plugin::path( 'build/' . $file ) ) ) {
			wp_enqueue_script( $slug, Plugin::asset( $file ), $deps, $version, $footer );
		}
	}

	/**
	 * Styles enqueue.
	 *
	 * @param string  $slug  Script file slug.
	 * @param string  $file  Script file to enqueue.
	 * @param array   $deps  Script dependencies.
	 * @param boolean $media To which media this applies.
	 *
	 * @return void
	 */
	public static function style( $slug = '', $file = '', $deps = [], $media = 'all' ) {
		if ( empty( $slug ) ) {
			return;
		}
		$file = str_replace( '.css', '-style.css', $file );

		$version = Debug::style() ? time() : Plugin::version();
		$slug    = ! empty( $slug ) ? self::PREFIX . '-' . $slug : false;

		if ( array_key_exists( $file, Manifest::data() ) ) {
			$file = Manifest::data( $file );
		}

		if ( ! empty( $file ) && file_exists( Plugin::path( 'build/' . $file ) ) ) {
			wp_enqueue_style( $slug, Plugin::asset( $file ), $deps, $version, $media );
		}
	}
}
