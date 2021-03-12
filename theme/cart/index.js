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
		this.cartMenuButton = document.getElementById("future-shop-menu-cart");
		this.cartClose = document.getElementById("cart-close");

		// Set the button with a cart.
		this.cartMenuButton.innerHTML = `<img src="${future_shop.cart_src}" alt="Shopping Cart"/>`;
	},
	addInitialListeners: function() {
		this.cartMenuButton.addEventListener('click', (e) => {this.openCart(e)});
		this.cartClose.addEventListener('click', (e) => {this.closeCart(e)});
		this.cartModal.addEventListener('click', (e) => {this.closeCart(e)});
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
};

/** Action after page loads */
window.FutureShop.initialize();
