<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Checkout
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Complete Your Purchase</h3>
                    
                    <!-- Cart Items -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-700 mb-3">Order Summary</h4>
                        <div id="checkout-items" class="space-y-3">
                            <!-- Cart items will be populated by JavaScript -->
                        </div>
                    </div>

                    <!-- Checkout Form -->
                    <form action="/checkout" method="POST" id="checkout-form">
                        @csrf
                        <input type="hidden" name="cart" id="cart-input">
                        
                        <div class="border-t pt-6">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-lg font-medium text-gray-900">Total:</span>
                                <span id="total-amount" class="text-2xl font-bold text-green-600">$0.00</span>
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-md text-lg font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    🛒 Complete Purchase
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
// Shopping Cart functionality for checkout page
let cart = JSON.parse(localStorage.getItem('cart')) || [];

function updateCheckoutDisplay() {
    const checkoutItems = document.getElementById('checkout-items');
    const totalAmount = document.getElementById('total-amount');
    const cartInput = document.getElementById('cart-input');
    
    if (cart.length === 0) {
        checkoutItems.innerHTML = '<p class="text-gray-500">Your cart is empty</p>';
        totalAmount.textContent = '$0.00';
        cartInput.value = '[]';
    } else {
        // Get game details for cart items
        fetch('/api/cart-items', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({cart: cart})
        })
        .then(response => response.json())
        .then(games => {
            let html = '<div class="space-y-3">';
            let total = 0;
            
            games.forEach(game => {
                html += `
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                        <div>
                            <h5 class="font-medium">${game.nom}</h5>
                            <p class="text-sm text-gray-600">Category: ${game.categorie || 'N/A'}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-semibold text-green-600">$${game.prix}</span>
                        </div>
                    </div>
                `;
                total += game.prix;
            });
            
            html += '</div>';
            checkoutItems.innerHTML = html;
            totalAmount.textContent = `$${total.toFixed(2)}`;
            cartInput.value = JSON.stringify(cart);
        })
        .catch(error => {
            console.error('Error fetching cart items:', error);
            checkoutItems.innerHTML = '<p class="text-red-500">Error loading cart items</p>';
        });
    }
}

// Handle checkout form submission
document.getElementById('checkout-form').addEventListener('submit', function(e) {
    if (cart.length === 0) {
        e.preventDefault();
        alert('Your cart is empty!');
        return false;
    }
    
    // Cart is already set in hidden input, just submit
});

// Initialize checkout display on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCheckoutDisplay();
});
</script>
