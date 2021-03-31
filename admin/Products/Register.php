<?php
/**
 * Products class, for managing products and connections to Stripe.
 *
 * @package FutureShop
 */

namespace FutureShop\Products;

use FutureShop\Helpers\WP\Hooks;

/**
 * Products registration class.
 */
class Register {

	/**
	 * Post Type Key
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_post_type/#parameters
	 */
	const KEY = 'product';

	/**
	 * Regiration Constructor
	 */
	public function __construct() {
		Hooks::load( __CLASS__ );
	}

	/**
	 * Registration initilizer, hooks into WordPress.
	 *
	 * @wp.hook action init
	 */
	public static function init() {
		register_post_type( self::KEY, self::args() );
	}

	/**
	 * Post type arguments.
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_post_type/#parameters
	 */
	public static function args() {
		return [
			'labels'       => self::labels(),
			'capabilities' => [ 'manage_options' ],
			'map_meta_cap' => true,
			'description'  => _x( 'Products post type.', 'post type description' ),
			'public'       => true,
			'show_in_menu' => false,
			'show_in_rest' => true,
			'supports'     => [ 'title', 'editor', 'revisions', 'author', 'excerpt', 'thumbnail', 'custom-fields', 'post-formats' ],
			'has_archive'  => 'products',
			'rewrite'      => [
				'slug'       => 'product',
				'with_front' => false,
			],
		];
	}

	/**
	 * Post type labels.
	 *
	 * @see https://developer.wordpress.org/reference/functions/get_post_type_labels/
	 */
	public static function labels() {
		return [
			'name'                     => _x( 'Products', 'post type general name' ),
			'singular_name'            => _x( 'Product', 'post type singular name' ),
			'add_new'                  => _x( 'Add New', 'post' ),
			'add_new_item'             => __( 'Add New Product' ),
			'edit_item'                => __( 'Edit Product' ),
			'new_item'                 => __( 'New Product' ),
			'view_item'                => __( 'View Product' ),
			'view_items'               => __( 'View Products' ),
			'search_items'             => __( 'Search Products' ),
			'not_found'                => __( 'No products found.' ),
			'not_found_in_trash'       => __( 'No products found in Trash.' ),
			'all_items'                => __( 'All Products' ),
			'archives'                 => __( 'Product Archives' ),
			'attributes'               => __( 'Product Attributes' ),
			'insert_into_item'         => __( 'Insert into product' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this product' ),
			'featured_image'           => _x( 'Featured image', 'product' ),
			'set_featured_image'       => _x( 'Set featured image', 'product' ),
			'remove_featured_image'    => _x( 'Remove featured image', 'product' ),
			'use_featured_image'       => _x( 'Use as featured image', 'product' ),
			'filter_items_list'        => __( 'Filter products list' ),
			'filter_by_date'           => __( 'Filter by date' ),
			'items_list_navigation'    => __( 'Products list navigation' ),
			'items_list'               => __( 'Products list' ),
			'item_published'           => __( 'Product published.' ),
			'item_published_privately' => __( 'Products published privately.' ),
			'item_reverted_to_draft'   => __( 'Products reverted to draft.' ),
			'item_scheduled'           => __( 'Products scheduled.' ),
			'item_updated'             => __( 'Products updated.' ),
		];
	}
}
