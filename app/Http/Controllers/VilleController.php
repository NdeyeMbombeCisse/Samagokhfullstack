<?php

namespace App\Http\Controllers;

use App\Models\Ville;
use Illuminate\Http\Request;

class VilleController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:ville-list|ville-create|ville-edit|ville-delete', ['only' => ['index','show']]);
         $this->middleware('permission:ville-create', ['only' => ['create','store']]);
         $this->middleware('permission:ville-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:ville-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Ville::all();

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
        $ville = Ville::find($id);


        if(!$ville){
            return response()->json(['message'=>'ville non trouvée',404]);
        }
        return $ville;

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

