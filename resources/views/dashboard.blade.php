<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(auth()->user()->account_type == 'acheteur')
                        <!-- Buyer Dashboard -->
                        <h3 class="text-lg font-medium mb-4">Welcome, {{ auth()->user()->name }}! (Buyer)</h3>
                        <p class="mb-6">Here are all games available for purchase:</p>
                        
                        <!-- Shopping Cart -->
                        <div class="mb-6 p-4 bg-orange-50 border border-orange-200 rounded-lg">
                            <div class="flex justify-between items-center">
                                <h4 class="font-medium text-orange-800">🛒 Your Cart (<span id="cart-count">0</span> items)</h4>
                                <div class="flex gap-2">
                                    <button onclick="clearCart()" class="text-sm text-orange-600 hover:text-orange-800">Clear Cart</button>
                                    <form action="/checkout" method="POST" id="checkout-form" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                            🛒 Checkout
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div id="cart-items" class="mt-2 text-sm text-gray-600">
                                Your cart is empty
                            </div>
                        </div>
                        
                        @if(isset($jeux) && $jeux->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($jeux as $jeu)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <h4 class="font-medium text-lg mb-2">{{ $jeu->nom }}</h4>
                                        @if($jeu->categorie)
                                            <p class="text-sm text-gray-600 mb-1">Category: {{ $jeu->categorie }}</p>
                                        @endif
                                        <p class="text-sm text-gray-600 mb-1">Release: {{ $jeu->date_sortie }}</p>
                                        <p class="text-sm font-semibold text-green-600 mb-2">Price: ${{ number_format($jeu->prix, 2) }}</p>
                                        @if($jeu->plateforme)
                                            <p class="text-sm text-gray-600 mb-2">Platform: {{ $jeu->plateforme->nom }}</p>
                                        @endif
                                        @if($jeu->description)
                                            <p class="text-sm text-gray-700 mb-3">{{ Str::limit($jeu->description, 80) }}</p>
                                        @endif
                                        @if($jeu->image_url)
                                            <img src="{{ asset($jeu->image_url) }}" alt="{{ $jeu->nom }}" class="w-full h-32 object-cover rounded mb-3">
                                        @endif>
                                        <div class="flex gap-2 mt-3">
                                            <button onclick="alert('Contact seller for: {{ $jeu->nom }}')" class="bg-green-600 text-white px-3 py-2 rounded text-sm hover:bg-green-700 flex-1">
                                                Contact Seller
                                            </button>
                                            <button onclick="addToCart({{ $jeu->id }})" class="bg-orange-500 text-white px-3 py-2 rounded text-sm hover:bg-orange-600 flex items-center justify-center" title="Add to Cart" style="min-width: 50px;">
                                                🛒
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No games available for sale at the moment.</p>
                        @endif
                        
                    @elseif(auth()->user()->account_type == 'vendeur')
                        <!-- Seller Dashboard -->
                        <h3 class="text-lg font-medium mb-4">Welcome, {{ auth()->user()->name }}! (Seller)</h3>
                        
                        <!-- Earnings Summary -->
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <h4 class="font-medium text-green-800 mb-2">💰 Your Earnings</h4>
                            <div class="text-2xl font-bold text-green-600">
                                ${{ number_format($soldJeux->sum('prix') ?? 0, 2) }}
                            </div>
                            <div class="text-sm text-gray-600 mt-1">
                                From {{ $soldJeux->count() ?? 0 }} sold games
                            </div>
                        </div>
                        
                        <!-- Sold Games Section -->
                        @if(isset($soldJeux) && $soldJeux->count() > 0)
                            <div class="mb-6">
                                <h4 class="font-medium text-lg mb-3">🏷️ Sold Games ({{ $soldJeux->count() }})</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($soldJeux as $jeu)
                                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 opacity-75">
                                            <h4 class="font-medium text-lg mb-2">{{ $jeu->nom }}</h4>
                                            <p class="text-sm text-gray-600 mb-1">Category: {{ $jeu->categorie }}</p>
                                            <p class="text-sm text-gray-600 mb-1">Release: {{ $jeu->date_sortie }}</p>
                                            <p class="text-sm font-semibold text-green-600 mb-2">Price: ${{ number_format($jeu->prix, 2) }}</p>
                                            @if($jeu->plateforme)
                                                <p class="text-sm text-gray-600 mb-2">Platform: {{ $jeu->plateforme->nom }}</p>
                                            @endif
                                            @if($jeu->buyer)
                                                <p class="text-sm text-blue-600 mb-2">Sold to: {{ $jeu->buyer->name }}</p>
                                                <p class="text-sm text-gray-500">Sold on: {{ $jeu->sold_at->format('M d, Y') }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <div>
                            <a href="/add-jeu" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                                Add New Game
                            </a>
                        </div>
                        
                        @if(isset($jeux) && $jeux->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($jeux as $jeu)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <h4 class="font-medium text-lg mb-2">{{ $jeu->nom }}</h4>
                                        <p class="text-sm text-gray-600 mb-1">Genre: {{ $jeu->genre }}</p>
                                        <p class="text-sm text-gray-600 mb-1">Release: {{ $jeu->date_sortie }}</p>
                                        <p class="text-sm font-semibold text-green-600 mb-2">Price: ${{ number_format($jeu->prix, 2) }}</p>
                                        @if($jeu->plateforme)
                                            <p class="text-sm text-gray-600 mb-2">Platform: {{ $jeu->plateforme->nom }}</p>
                                        @endif
                                        @if($jeu->description)
                                            <p class="text-sm text-gray-700 mb-3">{{ Str::limit($jeu->description, 80) }}</p>
                                        @endif
                                        @if($jeu->image_url)
                                            <img src="{{ asset($jeu->image_url) }}" alt="{{ $jeu->nom }}" class="w-full h-32 object-cover rounded mb-3">
                                        @endif>
                                        <div class="flex gap-2 mt-3">
                                            <button class="bg-yellow-500 text-white px-3 py-2 rounded text-sm hover:bg-yellow-600 flex-1">
                                                Edit
                                            </button>
                                            <button onclick="deleteGame({{ $jeu->id }})" class="bg-red-500 text-white px-3 py-2 rounded text-sm hover:bg-red-600 flex items-center justify-center" title="Delete Game" style="min-width: 50px;">
                                                🗑️
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 bg-gray-50 rounded-lg">
                                <p class="text-gray-500 mb-4">You haven't listed any games yet.</p>
                                <a href="/add-jeu" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    Add Your First Game
                                </a>
                            </div>
                        @endif
                        
                    @else
                        <!-- Default/Fallback -->
                        <p>Welcome! Your account type is not set.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
// Shopping Cart functionality
let cart = JSON.parse(localStorage.getItem('cart')) || [];

function addToCart(gameId) {
    console.log('Adding to cart:', gameId);
    
    // Find game data from the page
    const games = @json($jeux ?? []);
    console.log('Available games:', games);
    
    const game = games.find(g => g.id === gameId);
    console.log('Found game:', game);
    
    if (game) {
        // Check if already in cart
        if (!cart.find(item => item.id === gameId)) {
            cart.push({
                id: game.id,
                nom: game.nom,
                prix: game.prix,
                categorie: game.categorie,
                plateforme: game.plateforme?.nom || 'Unknown'
            });
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartDisplay();
            console.log('Cart updated:', cart);
        } else {
            console.log('Game already in cart');
        }
    } else {
        console.log('Game not found');
    }
}

function removeFromCart(gameId) {
    cart = cart.filter(item => item.id !== gameId);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
}

function clearCart() {
    cart = [];
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
}

function updateCartDisplay() {
    cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const cartCount = document.getElementById('cart-count');
    const cartItems = document.getElementById('cart-items');
    
    cartCount.textContent = cart.length;
    
    if (cart.length === 0) {
        cartItems.innerHTML = 'Your cart is empty';
    } else {
        let html = '<ul class="space-y-1">';
        cart.forEach(item => {
            html += `<li class="flex justify-between items-center py-1">
                <span>${item.nom} - $${item.prix}</span>
                <button onclick="removeFromCart(${item.id})" class="text-red-500 text-xs ml-2 hover:text-red-700">Remove</button>
            </li>`;
        });
        html += '</ul>';
        cartItems.innerHTML = html;
    }
}

// Handle checkout form submission
document.getElementById('checkout-form').addEventListener('submit', function(e) {
    if (cart.length === 0) {
        e.preventDefault();
        alert('Your cart is empty!');
        return false;
    }
    
    // Add cart items to hidden input before submission
    let hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'cart';
    hiddenInput.value = JSON.stringify(cart);
    this.appendChild(hiddenInput);
});

// Initialize cart display on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartDisplay();
});
</script>
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

function deleteGame(gameId) {
    if (confirm('Are you sure you want to delete this game?')) {
        fetch(`/delete-jeu/${gameId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Failed to delete game');
            }
        })
        .then(data => {
            showNotification('Game deleted successfully!');
            // Reload the page to update the game list
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error deleting game!');
        });
    }
}

// Initialize cart display on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartDisplay();
});
</script>
