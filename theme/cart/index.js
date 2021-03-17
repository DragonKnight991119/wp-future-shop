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
	cartQuantity: 0,
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
	},
	openCart: function(e) {
		e.preventDefault();
		const cart = this.getCartItems();
		this.cartModal.style.display = "block";
		this.cartClose.focus();
		this.cartSubtotal = 0;

		// Hydrate the cart.
		this.updateCart(cart);

		// Add listeners to the increment, decrement, and remove buttons.
		this.setupCartActionButtons();

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

							<button class="item-decrement" type="button" data-price-id="${item.priceId}" aria-label="Reduce item quantity by one" title="Reduce item quantity by one">-</button>
							
							<input type="text" class="item-quantity-input" min="0" value="${item.quantity}" readonly>
							
							<button class="item-increment" type="button" data-price-id="${item.priceId}" aria-label="Increase item quantity by one" title="Increase item quantity by one">+</button>
						</div>
						<div class="remove-item">
							<button class="item-remove" aria-label="Remove item" data-price-id="${item.priceId}" title="Remove item">&times;</button>
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
	clearCart: function() {
		const cartBody = document.getElementById('cart-body');
		cartBody.innerHTML = '';
	},
	updateCart: function(cart) {
		localStorage.setItem(this.localStorageKey, JSON.stringify(cart) );
		this.clearCart();
		this.showCartItems();
	},
	addCartItem: function(e) {
		// Stringify and parse the dataset so it's an object and not a DOMStringMap.
		const productData = JSON.parse(JSON.stringify(e.target.dataset));
		const cart = this.getCartItems();

		// Set the cart state.
		this.cart = this.deduplicateCartItems(cart, productData);

		this.updateCart(cart);
		// Open cart whenever an item is added.
		this.openCart(e);
	},
	deduplicateCartItems: function(cart, newItem) {

		let duplicate = false;

		for( index in cart ) {
			if( cart[index]['priceId'] === newItem.priceId ) {
				cart[index]['quantity'] = parseInt(cart[index]['quantity']) + parseInt(newItem['quantity']);

				return cart;
			}
		}

		if( !duplicate ) {
			// Add new product data to cart.
			cart.push(newItem);
		}

		return cart;
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
	decrementItem: function(e) {
		// decrese quantity by 1
		console.log(e.target);
		console.log(e.target.dataset);
		for( index in cart ) {
			if( cart[index]['priceId'] === newItem.priceId ) {
				cart[index]['quantity'] = parseInt(cart[index]['quantity']) + parseInt(newItem['quantity']);

				return cart;
			}
		}
	},
	incrementItem: function(e) {
		// increse quantity by 1
		const cart = this.getCartItems();


	},
	removeCartItem: function(e) {
		const cart = this.getCartItems();
		console.log(cart)
		for( index in cart ) {
			if( cart[index]['priceId'] === e.target.dataset.priceId ) {
				cart.splice(index, 1);

				this.updateCart(cart);
			}
		}

	},
	getCartSubtotal: function() {
		// Manipulate it to be the right format, e.g. from 999 to $9.99
		return this.parsePrice(this.cartSubtotal, 1);
	},
	setCartSubtotal: function(price, quantity) {
		let subtotal = parseInt(this.cartSubtotal);

		this.cartSubtotal = subtotal + ( parseInt(price) * parseInt(quantity) );
	},
	setupCartActionButtons: function() {
		const decrementButtons = document.getElementsByClassName('item-decrement');

		for(const button of decrementButtons) {
			button.addEventListener('click', (e) => {this.decrementItem(e)});
		}

		const incrementButtons = document.getElementsByClassName('item-increment');
		for(const button of incrementButtons) {
			button.addEventListener('click', (e) => {this.incrementItem(e)});
		}

		const removeButtons = document.getElementsByClassName('item-remove')
		for(const button of removeButtons) {
			button.addEventListener('click', (e) => {this.removeCartItem(e)});
		}
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
	},
	getCartQuantity: function() {
		// Get the total quantity of the items in the cart
		const cart = this.getCartItems();
		let quantity = 0;

		if(0 === cart.length) {
			this.setCartQuantity(quantity);
			return;
		}

		for(const item of cart ) {
			quantity += parseInt(item.quantity);
			console.log(item)
		}
		console.log(quantity)
		this.setCartQuantity(quantity);
	},
	setCartQuantity: function(quantity) {
		// Set quantity in any cart button.
		for(const button of this.cartMenuButton) {
			let buttonHtml = button.innerHTML;

			if(0 < this.cartQuantity) {
				buttonHtml += `<span class="cart-quantity">${this.cartQuantity}</span>`;
			}

			button.innerHTML = buttonHtml;
			button.addEventListener('click', (e) => {this.openCart(e)});
		}

		// Set the total quantity of the items in the cart
		this.cartQuantity = quantity;
	}

};

/** Action after page loads */
window.FutureShop.initialize();
