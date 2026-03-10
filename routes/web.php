<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JeuController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Games routes
Route::get('/', [JeuController::class, 'index']);
Route::get('/add-jeu', [JeuController::class, 'create']);
Route::post('/store-jeu', [JeuController::class, 'store']);
Route::get('/checkout', [JeuController::class, 'checkoutPage'])->middleware('auth')->name('checkout.page');
Route::post('/checkout', [JeuController::class, 'checkout'])->middleware('auth');
Route::post('/api/cart-items', [ApiController::class, 'getCartItems']);

// Auth routes (Breeze)
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->account_type == 'vendeur') {
        // Show seller's games (both sold and unsold)
        $allJeux = \App\Models\Jeu::with(['plateforme', 'buyer'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Separate sold and unsold games
        $unsoldJeux = $allJeux->where('sold', false);
        $soldJeux = $allJeux->where('sold', true);
        $totalEarnings = $soldJeux->sum('prix');
        
        $jeux = $unsoldJeux; // For display in the grid
    } else {
        // Show all unsold games for buyers
        $jeux = \App\Models\Jeu::with(['plateforme', 'user'])
            ->where('sold', false)
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    return view('dashboard', compact('jeux'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// THIS IS THE ADMIN ROUTE
// Notice we use 'auth' AND 'admin' middleware
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth', 'admin'])->name('admin.dashboard');
Route::get('/admin/platforms', [AdminController::class, 'platforms'])->middleware(['auth', 'admin'])->name('admin.platforms');
Route::post('/admin/platforms', [AdminController::class, 'storePlatform'])->middleware(['auth', 'admin']);
Route::delete('/admin/platforms/{id}', [AdminController::class, 'destroyPlatform'])->middleware(['auth', 'admin']);
Route::get('/admin/categories', [AdminController::class, 'categories'])->middleware(['auth', 'admin'])->name('admin.categories');
Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->middleware(['auth', 'admin']);
Route::delete('/admin/categories/{id}', [AdminController::class, 'destroyCategory'])->middleware(['auth', 'admin'])->name('admin.categories.destroy'); 