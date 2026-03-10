<?php

namespace App\Http\Controllers;

use App\Models\Jeu;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getCartItems(Request $request)
    {
        $cart = $request->input('cart', []);
        $games = Jeu::whereIn('id', $cart)
            ->where('sold', false)
            ->get(['id', 'nom', 'prix']);
        
        return response()->json($games);
    }
}
