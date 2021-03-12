// Get the modal
var cartModal = document.getElementById("future-shop-cart-background");

// Get the button that opens the modal
var cartMenuButton = document.getElementById("future-shop-menu-cart");

// Get the <span> element that closes the modal
var cartClose = document.getElementById("cart-close");

cartMenuButton.innerHTML = future_shop.cart_svg;
cartMenuButton.innerText = '🛒';

// When the user clicks the button, open the modal 
cartMenuButton.onclick = function() {
  cartModal.style.display = "block";
  cartClose.focus();
}

// When the user clicks on <span> (x), close the modal
cartClose.onclick = function() {
	cartModal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == cartModal) {
    cartModal.style.display = "none";
  }
}
