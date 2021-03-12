/**
 * Create the FutureShop Window Object
 */
window.FutureShop = {
	// Set initial properties and state
	addToCartButton: '',
	cart: [],
	cartCloseButton: '',
	cartIsOpen: false,
	cartMenuButton: '',
	cartModal: '',
	cartSubtotal: 0,
	checkoutButton: '',
	localStorageKey: 'futureShopCart',

	initialize: function() {
		this.setInitialProps();
		this.addInitialListeners();
	},
	setInitialProps: function() {
		this.cart = JSON.parse(localStorage.getItem(this.localStorageKey) || '[]' );

		this.cartModal = document.getElementById("future-shop-cart-background");
		this.cartMenuButton = document.getElementsByClassName("menu-cart");
		this.cartClose = document.getElementById("cart-close");
		this.addToCartButton = document.getElementsByClassName("add-to-cart");
		this.checkoutButton = document.getElementById("future-shop-stripe-checkout-button");
		// this.cartMenuButton.innerHTML = `<img src="${future_shop.cart_src}" alt="Shopping Cart"/>`;
	},
	addInitialListeners: function() {
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

		// Handle checkout button
		if(Stripe) {
			this.setupCheckoutButton();
		} else {
			this.checkoutButton.disabled = true;
			console.error('Oh no, it looks like Stripe has not be added or is not responding');
		}


		window.addEventListener('storage', (e) => {this.handleStorageEvent(e)});
	},
	handleStorageEvent: function(storageEvent) {
		console.log('storage!')
		if(this.localStorageKey === storageEvent.key) {
			// handle when something is stored to the cart
			console.log('cart storage');
		}
	},
	openCart: function(e) {
		e.preventDefault();
		this.cartModal.style.display = "block";
		this.cartClose.focus();
		this.cartSubtotal = 0;

		// Add items to cart
		this.showCartItems();

		// Update checkout button.
		this.setupCheckoutButton(e);
	},
	closeCart: function(e) {
		if (e.target.id === this.cartModal.id || e.target.id === this.cartClose.id) {
			// Clear cart body before closing... for now.
			// TODO: work off of cart state, rather than just the DOM.
			const cartBody = document.getElementById('cart-body');
			cartBody.innerHTML = '';

			// Close the cart.
			this.cartModal.style.display = "none";
		}
	},
	makeCartItem: function(item) {
		const price = this.parsePrice(item.price, item.quantity);
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
							
							<input type="text" class="item-quantity-input" min="0" value="${item.quantity}" readonly>
							
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
		return this.cart;
	},
	addCartItem: function(e) {
		const productData = e.target.dataset
		const cart = this.getCartItems();

		// Add new product data to cart.
		cart.push(productData);

		// Set the cart state.
		this.cart = cart;

		// TODO: dedupe products added more than once, just increase the quantity

		localStorage.setItem(this.localStorageKey, JSON.stringify(cart) );

		// Open cart whenever an item is added.
		this.openCart(e);
	},
	showCartItems: function() {
		const cart = this.getCartItems();
		const cartBody = document.getElementById('cart-body');

		if(0 === cart.length) {
			let noItem = document.createElement("div");
			noItem.classList.add('cart-item');   
			noItem.innerHTML = 'There are no items in your cart.';
			cartBody.appendChild(noItem)
			return;
		}

		for(const item of cart ) {
			// Ceate the item for the cart
			let newItem = document.createElement("div");
			newItem.classList.add('cart-item');   
			newItem.innerHTML = this.makeCartItem(item);
			// Add new item to cart.
			cartBody.appendChild(newItem)

			// Pass price to be subtotaled.
			this.setCartSubtotal(item.price, item.quantity);
		}

		const subtotal = document.getElementById('cart-subtotal')

		subtotal.innerText = this.getCartSubtotal();
	},
	parsePrice: function(price, quantity) {
		// parse the price of the item
		return '$' + ( (parseInt(price) * parseInt(quantity)) / 100 ).toFixed(2);;
	},
	removeCartItem: function() {
		// when someone x's out an item
	},
	decrementItem: function() {
		// decrese quantity by 1
	},
	incrementItem: function() {
		// increse quantity by 1
	},
	getCartSubtotal: function() {
		console.log(this.cartSubtotal)
		// Manipulate it to be the right format, e.g. from 999 to $9.99
		return this.parsePrice(this.cartSubtotal, 1);
	},
	setCartSubtotal: function(price, quantity) {
		let subtotal = parseInt(this.cartSubtotal);

		this.cartSubtotal = subtotal + ( parseInt(price) * parseInt(quantity) );
	},
	setupCheckoutButton: function() {
		// Create a new Stripe object for checkout.
		this.stripe = new Stripe(future_shop.fs_pk);
		this.checkoutButton.addEventListener('click', (e) => {this.handleCheckoutButton(e)});
	},
	handleCheckoutButton: function(e) {
		e.preventDefault();

		// TODO: make sure to dedupe before getting here.
		const lineItems = this.cart.map(item => {
			return {
				"price": item.priceId,
				"quantity": parseInt(item.quantity)
			};
		});

		console.log(lineItems)
		this.stripe.redirectToCheckout({
			lineItems,
			mode: 'payment',
			successUrl: 'https://futureshop.local/thank-you',
			cancelUrl: 'https://futureshop.local/shop',
			billingAddressCollection: 'required',
			shippingAddressCollection: {
				allowedCountries: ['US', 'CA'],
			},
			submitType: 'pay',
			customerEmail: 'customer@example.com',
			}).then(function (result) {
				console.error(result);
			});
	}

};

/** Action after page loads */
window.FutureShop.initialize();
