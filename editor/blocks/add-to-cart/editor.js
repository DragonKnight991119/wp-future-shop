// Import the block settings.
import block from './block.json';

const { registerBlockType } = wp.blocks;

registerBlockType( block.name, {
	...block,

	attributes: {},

	edit : () => {
		return (
			<div className="wp-block-button">
				<a href="">Add to Cart</a>
			</div>
		);
	},

	save : () => {
		return (
			<div className="wp-block">
				<button
					class="add-to-cart"
					data-img-src=""
					data-prod-id="prod_IuAjFZZToznvgq"
					data-title="Thing 1"
					data-quantity="1"
					data-price-id="price_0IIMSvFQiA51kwBGiUFq8iNK"
					data-price="599"
					data-link="/product-1/"
					>
					Thing 1
				</button>
			</div>
		);
	},
} );
