<?php
/**
 * WordPress\Hooks
 *
 * @package S4B
 */

namespace S4B\WP;

/**
 * WP\Hooks class
 *
 * Allows for using WordPress Hooks in PHP classes, simply.
 */
class Hooks {

	/**
	 * Loads WordPress hooks in a beautifully convoluted way.
	 *
	 * @param object $class Current called __CLASS__.
	 *
	 * @return void
	 */
	public function load_hooks( $class ) {
		array_filter(
			get_class_methods( $class ),
			function( $name ) use ( $class ) {
				$reflection = new \ReflectionMethod( $class, $name );
				array_map(
					function( $hook ) use ( $name, $class ) {
						$hook = explode( ' ', trim( $hook, " \t\n\r\0\x0B\x2A" ) );

						$i = array_search( 'filter', $hook, true );

						if ( empty( $i ) && in_array( 'action', $hook, true ) ) {
							$i = array_search( 'action', $hook, true );
						}

						if ( empty( $i ) || empty( $hook[ $i + 1 ] ) ) {
							/**
							 * Use this section to check for a type tag.
							 *
							 * @todo Throw a warning that hook was found, but no type or tag was found.
							 */
							return;
						}

						$hook = (object) [
							'type'     => $hook[ $i ],
							'tag'      => $hook[ $i + 1 ],
							'priority' => ! empty( $hook[ $i + 2 ] ) ? $hook[ $i + 2 ] : 10,
							'args'     => ! empty( $hook[ $i + 3 ] ) ? $hook[ $i + 3 ] : 1,
						];

						call_user_func( 'add_' . $hook->type, $hook->tag, [ $class, $name ], $hook->priority, $hook->args );
					},
					array_values(
						array_filter(
							explode( "\n", $reflection->getDocComment() ),
							function( $line ) {
								if ( ! empty( strpos( $line, '@wp.hook' ) ) ) {
									return $line;
								}
							}
						)
					)
				);
			}
		);
	}
}
