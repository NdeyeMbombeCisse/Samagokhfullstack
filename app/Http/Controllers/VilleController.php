<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ville;
use App\Models\Commune;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VilleController extends Controller
{

    // function __construct()
    // {
    //      $this->middleware('permission:ville-list|ville-create|ville-edit|ville-delete', ['only' => ['index','show']]);
    //      $this->middleware('permission:ville-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:ville-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:ville-delete', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResponse
    {
        $villes= Ville::all();
        return response()->json(['data' => $villes]); // Assurez-vous que vous envoyez les données sous la clé 'data'
    }

    public function infoCommunes():JsonResponse
    {
        $villes= Ville::all();
       
        return response()->json(['data' => $villes]); // Assurez-vous que vous envoyez les données sous la clé 'data'
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle'=>'required|string|max:225',
            'description'=>'required|string',
        ]);
        return Ville::create($request->all());

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Recherche de la ville par son ID
        $ville = Ville::find($id);
    
        // Vérification si la ville existe
        if (!$ville) {
            return response()->json(['message' => 'Ville non trouvée'], 404);
        }
    
        // Récupérer toutes les communes associées à cette ville
        $communes = Commune::where('ville_id', $id)->get();
    
        // Récupérer l'utilisateur avec le rôle de maire dans cette ville en fonction de la commune_id
        $maire = User::whereHas('roles', function ($query) {
            $query->where('name', 'maire');
        })->whereIn('commune_id', $communes->pluck('id'))->first();
    
        // Retourner la ville, les communes et les informations du maire
        return response()->json([
            'ville' => $ville,
            'communes' => $communes,
            'maire' => $maire
        ]);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ville = Ville::find($id);


        if(!$ville){
            return response()->json(['message'=>'ville non trouvée',404]);
        }
        $request->validate([
            'libelle'=>'required|string|max:225',
            'description'=>'required|string',
        ]);
        $ville->update($request->all());
        return $ville;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ville = Ville::find($id);


        if(!$ville){
            return response()->json(['message'=>'ville non trouvée',404]);
        }


        $ville->delete();
        return response()->json(['message'=>'Ville supprimée avec succés']);
    }

    }

