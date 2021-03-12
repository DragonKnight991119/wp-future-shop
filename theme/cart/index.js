/**
 * Create the FutureShop Window Object
 */
window.FutureShop = {
	// Set initial properties and state
	cartModal: '',
	cart: '',
	cartMenuButton: '',
	cartCloseButton: '',
	addToCartButton: '',

	initialize: function() {
		this.setInitialProps();
		this.addInitialListeners();
	},
	setInitialProps: function() {
		this.cartModal = document.getElementById("future-shop-cart-background");
		this.cartMenuButton = document.getElementsByClassName("menu-cart");
		this.cartClose = document.getElementById("cart-close");
		this.addToCartButton = document.getElementsByClassName("add-to-cart");
		// this.cartMenuButton.innerHTML = `<img src="${future_shop.cart_src}" alt="Shopping Cart"/>`;
	},
	addInitialListeners: function() {
		// this.cartMenuButton.addEventListener('click', (e) => {this.openCart(e)});
		this.cartClose.addEventListener('click', (e) => {this.closeCart(e)});
		this.cartModal.addEventListener('click', (e) => {this.closeCart(e)});

		// Set any cart buttons.
		for(const button of this.cartMenuButton) {
			button.innerHTML = `<img src="${future_shop.cart_src}" alt="Shopping Cart"/>`;
			button.addEventListener('click', (e) => {this.openCart(e)});
		}

		// Set any add-to-cart buttons.
		for(const button of this.addToCartButton) {
			button.addEventListener('click', (e) => {this.addCartItem(e)});
		}


		window.addEventListener('storage', (e) => {this.handleStorageEvent(e)});
	},
	handleStorageEvent: function(storageEvent) {
		console.log('storage!')
		if('futureShopCart' === storageEvent.key) {
			// handle when something is stored to the cart
			console.log('cart storage');
		}
	},
	openCart: function(e) {
		e.preventDefault();
		this.cartModal.style.display = "block";
		this.cartClose.focus();

		// Add items to cart
		this.showCartItems();
	},
	closeCart: function(e) {
		const cartBody = document.getElementById('cart-body');
		cartBody.innerHTML = '';

		// Close cart on close button.
		this.cartModal.style.display = "none";

		// Close cart on window background click.
		if (e.target == this.cartModal) {
			this.cartModal.style.display = "none";
		}
	},
	makeCartItem: function(item) {
		const price = this.parsePrice(item.price);
		// holds the template for the cart item
		return `<div class="item-image">
					<a href="${item.link}">
						<img src="${item.imgSrc}" alt="item title">
					</a>
				</div>
				<div class="item-contents">
					<span class="item-title">
						<a href="${item.link}">
							${item.title}
						</a>
					</span>
					<div class="cart-actions">
						<div class="quantity-selector">
							<label for="" class="hidden">Quantity</label>

							<button class="item-decrement" type="button" aria-label="Reduce item quantity by one" title="Reduce item quantity by one">-</button>
							
							<input type="text" id="" class="item-quantity-input" min="0" value="${item.quantity}" readonly>
							
							<button class="item-increment" type="button" aria-label="Increase item quantity by one" title="Increase item quantity by one">+</button>
						</div>
						<div class="remove-item">
							<button aria-label="Remove item" title="Remove item">&times;</button>
						</div>
					</div>
				</div>
				<div class="item-price">
					${price}
				</div>`
	},
	getCartItems: function() {
		this.cart = JSON.parse(localStorage.getItem('futureShopCart') || "[]");
	},
	addCartItem: function(e) {
		const productData = e.target.dataset
		const cart = JSON.parse(localStorage.getItem('futureShopCart') || "[]");

		// Add new product data to cart.
		cart.push(productData);

		// TODO: dedupe products added more than once, just increase the quantity

		localStorage.setItem('futureShopCart', JSON.stringify(cart) );

		// Open cart whenever an item is added.
		this.openCart(e);
	},
	showCartItems: function() {
		const cart = JSON.parse(localStorage.getItem('futureShopCart') || "[]");
		const cartBody = document.getElementById('cart-body');

		if(0 === cart.length) {
			let newItem = document.createElement("div");
			newItem.classList.add('cart-item');   
			newItem.innerHTML = 'There are no items in your cart.';
			cartBody.appendChild(newItem)
			return;
		}

		for(const item of cart ) {
			console.log(item)
			let newItem = document.createElement("div");
			newItem.classList.add('cart-item');   
			newItem.innerHTML = this.makeCartItem(item);
			cartBody.appendChild(newItem)
		}
	},
	parsePrice: function(price) {
		// parse the price of the item
		return price;
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
