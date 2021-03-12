/**
 * Create the FutureShop Window Object
 */
window.FutureShop = {
	// Set initial properties and state
	cartModal: '',
	cartState: '',
	cartMenuButton: '',
	cartCloseButton: '',

	initialize: function() {
		this.setInitialProps();
		this.addInitialListeners();
	},
	setInitialProps: function() {
		this.cartModal = document.getElementById("future-shop-cart-background");
		this.cartMenuButton = document.getElementsByClassName("menu-cart");
		this.cartClose = document.getElementById("cart-close");

		// Set the button with a cart.
		for (const button of this.cartMenuButton) {
			button.innerHTML = `<img src="${future_shop.cart_src}" alt="Shopping Cart"/>`;
			button.addEventListener('click', (e) => {this.openCart(e)});
		}
		// this.cartMenuButton.innerHTML = `<img src="${future_shop.cart_src}" alt="Shopping Cart"/>`;
	},
	addInitialListeners: function() {
		// this.cartMenuButton.addEventListener('click', (e) => {this.openCart(e)});
		this.cartClose.addEventListener('click', (e) => {this.closeCart(e)});
		this.cartModal.addEventListener('click', (e) => {this.closeCart(e)});

		window.addEventListener('storage', this.handleStorageEvent);
	},
	handleStorageEvent: function(storageEvent) {
		if('cart' === storageEvent.key) {
			// handle when something is stored to the cart
			console.log('cart storage');
		}
	},
	openCart: function(e) {
		e.preventDefault();
		this.cartModal.style.display = "block";
		this.cartClose.focus();
	},
	closeCart: function(e) {
		// Close cart on close button.
		this.cartModal.style.display = "none";

		// Close cart on window background click.
		if (e.target == this.cartModal) {
			this.cartModal.style.display = "none";
		}
	},
	makeCartItem: function() {
		// holds the template for the cart item
		return `<div class="cart-item">
				<div class="item-image">
					<a href="#link-to-product">
						<img src="https://placehold.it/50x50" alt="item title">
					</a>
				</div>
				<div class="item-contents">
					<span class="item-title">
						<a href="#link-to-product">
							Widget 1
						</a>
					</span>
					<div class="cart-actions">
						<div class="quantity-selector">
							<label for="" class="hidden">Quantity</label>
							<button class="item-decrement" type="button" aria-label="Reduce item quantity by one" title="Reduce item quantity by one">-</button>
							<input type="text" id="" class="item-quantity-input" min="0" readonly>
							<button class="item-increment" type="button" aria-label="Increase item quantity by one" title="Increase item quantity by one">+</button>
						</div>
						<div class="remove-item">
							<button aria-label="Remove item" title="Remove item">&times;</button>
						</div>
					</div>
				</div>
				<div class="item-price">
					$9.99
				</div>
			</div>`
	},
	getCartItems: function() {
		// call localStorage to get cart items
	},
	addCartItem: function() {
		// add cart item to localStorage
		// TODO: this is the first thing, I think
		// 1. each item should have an imageSrc, a stripe prodID, a title, a quantity, and a priceID, and maybe a price in integer form we can make a decimal, e.g. 999 would come out to 9.99
		// 2. each item is added as an object in local storage to the fs_cart localStorage key, so the key is an array of items
		// 3. items are shown in the order they were added.
	},
	showCartItems: function() {
		// put items in the cart display
	},
	removeCartItem: function() {
		// when someone x's out an item
	},
	decrementItem: function() {
		// decrese quanity by 1
	},
	incrementItem: function() {
		// increse quanity by 1
	},
	getCartTotal: function() {
		// take the total prices from the cart state and add them
	},
	setCartTotal: function() {
		// getCartTotal and manipulate it to be the right format, e.g. from 999 to $9.99
	}

};

/** Action after page loads */
window.FutureShop.initialize();
