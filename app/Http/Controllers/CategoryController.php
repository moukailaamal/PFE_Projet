<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryService;

class CategoryController extends Controller
{
     // index
     public function index()
     {
         $categories = CategoryService::all();
         return view('category.index', compact('categories'));
     }
 
     // store
     public function store(Request $request)
     {
         // Validation des données
         $request->validate([
             'name' => 'required|string|max:255',
             'description' => 'nullable|string',
         ]);
         
         // Création de la catégorie
         CategoryService::create([
             'name' => $request->input('name'),
             'description' => $request->input('description'),
         ]);
 
         return redirect()->route('categories.index')->with('success', 'Catégorie ajoutée avec succès');
     }
 
     // update
     public function update(Request $request, $id)
     {
         // Validation des données
         $request->validate([
             'name' => 'required|string|max:255',
             'description' => 'nullable|string',
         ]);
         $category = CategoryService::find($id);
         $category->name = $request->input('name');
         $category->description=$request->input('description');
         $category->save();
         if ($category->wasChanged()) {
            // La catégorie a été modifiée avec succès
            return redirect()->route('categories.index')
                ->with('success', 'Félicitations ! Vous avez modifié votre catégorie.')
               ;
        } else {
            // Aucune modification n'a été apportée à la catégorie
            return redirect()->route('categories.index')
                ->with('error', 'Aucune modification apportée à la catégorie.')
               ;
        }
     }
 
     // destroy
     public function destroy($id)
     {
         $category = CategoryService::findOrFail($id); // Utilisation de findOrFail pour s'assurer que la catégorie existe
         $category->delete();
 
         return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès');
     }
}
