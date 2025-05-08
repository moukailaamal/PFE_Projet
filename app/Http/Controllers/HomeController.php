<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TechnicianDetail;
use App\Models\CategoryService;
use App\Models\Service;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        // Récupérer les paramètres de recherche
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $availability = $request->input('availability');
        $location = $request->input('location');
        $priceRange = $request->input('price_range');
    
        // Charger les catégories et services pour le formulaire
        $categories = CategoryService::all(); 
    
        // Construire la requête pour les techniciens avec jointure sur la table users
        $query = TechnicianDetail::with(['user' => function($q) {
            $q->where('status', 'active'); // Only include active users
        }])
        ->whereHas('user', function($q) {
            $q->where('status', 'active'); // Ensure the user is active
        });
    
        // Appliquer les filtres
        if ($search) {
            $query->where('specialty', 'like', '%' . $search . '%');
        }
    
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
    
        if ($availability) {
            $query->where('availability', $availability === 'available');
        }
    
        if ($location) {
            $query->where('location', 'like', '%' . $location . '%');
        }
        
        // Filter by price range
        if ($priceRange) {
            switch ($priceRange) {
                case '0-50':
                    $query->whereBetween('price', [0, 50]);
                    break;
                case '50-100':
                    $query->whereBetween('price', [50, 100]);
                    break;
                case '100-200':
                    $query->whereBetween('price', [100, 200]);
                    break;
                case '200+':
                    $query->where('price', '>', 200);
                    break;
            }
        }
        
        // Récupérer les techniciens filtrés et les grouper par spécialité
        $technicians = $query->get();
        $groupedTechnicians = $technicians->groupBy('specialty');
    
        // Retourner la vue avec les données
        return view('home', compact('groupedTechnicians', 'categories', 'search', 'categoryId', 'availability', 'location', 'priceRange'));
    }
}