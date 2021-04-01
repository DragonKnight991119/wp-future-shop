// Import the block settings.
import block from './block.json';

const { registerBlockType } = wp.blocks;

registerBlockType( block.name, {
	...block,

	attributes: {},

	edit : () => {
		return (
			<div className="wp-block-button">
				<a href="">Coming Soon</a>
			</div>
		);
	},

	save : () => {
		return (
			<div className="wp-block">
				<button
					class="add-to-cart"
					data-img-src=""
					data-prod-id=""
					data-title="Coming Soon"
					data-quantity="1"
					data-price-id=""
					data-price=""
					data-link=""
					>
					Coming Soon
				</button>
			</div>
		);
	},
} );
