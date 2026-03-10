<?php

namespace App\Http\Controllers;

use App\Models\Plateforme;
use App\Models\Jeu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get statistics
        $stats = [
            'total_games' => Jeu::count(),
            'total_platforms' => Plateforme::count(),
            'total_users' => DB::table('users')->count(),
            'total_sellers' => DB::table('users')->where('account_type', 'vendeur')->count(),
            'total_buyers' => DB::table('users')->where('account_type', 'acheteur')->count(),
        ];

        // Get recent games
        $recentGames = Jeu::with(['plateforme', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get platforms with game count
        $platforms = Plateforme::withCount('jeux')
            ->orderBy('nom')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentGames', 'platforms'));
    }

    public function platforms()
    {
        $platforms = Plateforme::withCount('jeux')->orderBy('nom')->get();
        return view('admin.platforms', compact('platforms'));
    }

    public function storePlatform(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100|unique:plateforme,nom',
            'description' => 'nullable|string'
        ]);

        Plateforme::create([
            'nom' => $request->nom,
            'description' => $request->description
        ]);

        return redirect()->route('admin.platforms')->with('success', 'Platform added successfully!');
    }

    public function destroyPlatform($id)
    {
        $platform = Plateforme::findOrFail($id);
        
        // Check if platform has games
        if ($platform->jeux()->count() > 0) {
            return redirect()->route('admin.platforms')->with('error', 'Cannot delete platform with associated games!');
        }

        $platform->delete();
        return redirect()->route('admin.platforms')->with('success', 'Platform deleted successfully!');
    }

    public function categories()
    {
        $categories = Category::withCount('annonces')->orderBy('nom')->get();
        
        // Also get legacy categories from annonces table
        $legacyCategories = DB::table('annonce')
            ->select('categorie', DB::raw('count(*) as count'))
            ->whereNotNull('categorie')
            ->whereNotIn('categorie', function($query) {
                $query->select('nom')->from('categories');
            })
            ->groupBy('categorie')
            ->orderBy('categorie')
            ->get();

        return view('admin.categories', compact('categories', 'legacyCategories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100|unique:categories,nom',
            'description' => 'nullable|string'
        ]);

        Category::create([
            'nom' => $request->nom,
            'description' => $request->description
        ]);

        return redirect()->route('admin.categories')->with('success', 'Category added successfully!');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        
        // Check if category has annonces
        if ($category->annonces()->count() > 0) {
            return redirect()->route('admin.categories')->with('error', 'Cannot delete category with associated annonces!');
        }

        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully!');
    }
}
