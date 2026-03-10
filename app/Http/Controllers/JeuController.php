<?php

namespace App\Http\Controllers;

use App\Models\Jeu;
use Illuminate\Http\Request;

class JeuController extends Controller
{
    public function index()
    {
        $jeux = Jeu::with('plateforme')->get();
        return view('welcome', compact('jeux'));
    }

    public function create()
    {
        $plateformes = \App\Models\Plateforme::all();
        $categories = \App\Models\Category::orderBy('nom')->get();
        return view('add-jeu', compact('plateformes', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'categorie' => 'nullable|exists:categories,nom',
            'date_sortie' => 'required|date',
            'plateforme_id' => 'required|exists:plateforme,id',
            'prix' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        
        // Assign current user as the seller
        $data['user_id'] = auth()->id();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/games'), $imageName);
            $data['image_url'] = 'images/games/' . $imageName;
        }

        Jeu::create($data);
        return redirect('/')->with('success', 'Game added successfully!');
    }

    public function destroy($id)
    {
        $jeu = Jeu::findOrFail($id);
        
        // Check if user owns the game
        if ($jeu->user_id != auth()->id()) {
            return redirect()->back()->with('error', 'You can only delete your own games!');
        }

        $jeu->delete();
        return redirect()->back()->with('success', 'Game deleted successfully!');
    }

    public function checkout(Request $request)
    {
        $cart = $request->input('cart');
        
        // Handle if cart is sent as JSON string
        if (is_string($cart)) {
            $cart = json_decode($cart, true);
        }
        
        if (empty($cart) || !is_array($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        $totalAmount = 0;
        $gamesToBuy = [];

        foreach ($cart as $gameId) {
            $game = Jeu::findOrFail($gameId);
            
            if ($game->sold) {
                return redirect()->back()->with('error', 'Game "' . $game->nom . '" is already sold!');
            }

            $gamesToBuy[] = $game;
            $totalAmount += $game->prix;
        }

        // Process the purchase
        foreach ($gamesToBuy as $game) {
            $game->update([
                'sold' => true,
                'sold_at' => now(),
                'buyer_id' => auth()->id()
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Purchase completed! You bought ' . count($gamesToBuy) . ' games for $' . number_format($totalAmount, 2));
    }

    public function checkoutPage()
    {
        // Get cart from localStorage will be handled by JavaScript
        return view('checkout');
    }
}
