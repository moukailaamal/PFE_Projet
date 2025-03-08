<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TechnicienDetail;
use App\Models\CategoryService;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        // Récupérer les paramètres de recherche
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $availability = $request->input('availability');
        $location = $request->input('location');
    
        // Charger les catégories pour le formulaire
        $categories = CategoryService::all(); 
    
        // Construire la requête pour les techniciens
        $query = TechnicienDetail::with('user');
    
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
            $query->where('location', 'like', '%' . $location . '%'); // Correction : Utiliser $location
        }
    
        // Récupérer les techniciens filtrés et les grouper par spécialité
        $technicians = $query->get();
        $groupedTechnicians = $technicians->groupBy('specialty');
    
        // Retourner la vue avec les données
        return view('home', compact('groupedTechnicians', 'categories', 'search', 'categoryId', 'availability', 'location'));
    }
}