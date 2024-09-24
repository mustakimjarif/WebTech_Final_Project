// cart.js

localStorage.clear();

document.addEventListener('DOMContentLoaded', () => {
    // Initialize the cart from localStorage or as an empty array
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    console.log('Initial Cart:', cart); // Debugging: Check the initial cart state
    updateCartCount();

    function updateCartCount() {
        // Ensure that cart contains items with a valid 'quantity' property
        const cartCount = cart.reduce((total, item) => {
            return total + (item.quantity || 0); // Fallback to 0 if quantity is undefined
        }, 0);

        console.log('Updated Cart Count:', cartCount); // Debugging: Check the updated cart count
        document.getElementById('cart-count').textContent = cartCount;
    }

    window.addToCart = function (item) {
        // Ensure 'quantity' is initialized as a number
        item.quantity = item.quantity || 1;

        // Check if the item already exists in the cart
        const existingItemIndex = cart.findIndex(cartItem => cartItem.id === item.id);

        if (existingItemIndex !== -1) {
            // If item exists, increment the quantity
            cart[existingItemIndex].quantity += 1;
        } else {
            // If item doesn't exist, add it to the cart
            cart.push(item);
        }

        // Save the updated cart in localStorage
        localStorage.setItem('cart', JSON.stringify(cart));

        console.log('Cart after adding:', cart); // Debugging: Check cart after adding an item
        // Update the cart count display
        updateCartCount();
    }
});
