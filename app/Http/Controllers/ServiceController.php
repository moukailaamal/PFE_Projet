<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\CategoryService;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('category')->get();
        $categories = CategoryService::all();
        return view('service.index', compact('services', 'categories'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'technician_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:category_services,id',
        ]);
    
        Service::create([
            'title' => $request->input('title'),
            'technician_id' => $request->input('technician_id'),
            'category_id' => $request->input('category_id'),
            'creation_date' => now(),
        ]);
      
        return redirect()->route('services.index')->with('success', 'Service ajouté avec succès');
    }

    public function update(Request $request, $id)
    {
        // Valider les données
        $request->validate([
            'title' => 'required|string|max:255',
            'technician_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:category_services,id',
        ]);
    
        // Récupérer le service
        $service = Service::findOrFail($id);
    
        // Afficher les données reçues pour le débogage
      
    
        // Mettre à jour le service
        $service->update([
            'title' => $request->input('title'),
            'technician_id' => $request->input('technician_id'),
            'category_id' => $request->input('category_id'),
        ]);
       
        // Vérifier si le service a été modifié
        if ($service->wasChanged()) {
            return redirect()->route('services.index')
                ->with('success', 'Félicitations ! Vous avez modifié votre service.');
        } else {
            return redirect()->route('services.index')
                ->with('info', 'Aucune modification apportée au service.');
        }
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service supprimé avec succès');
    }
}