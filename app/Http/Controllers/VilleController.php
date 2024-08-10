<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVilleRequest;
use App\Http\Requests\UpdateVilleRequest;
use App\Models\Ville;

class VilleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Ville::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVilleRequest $request)
    {
        $ville = Ville::create($request->validated());
        return response()->json($ville, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ville $ville)
    {
        return response()->json($ville);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ville $ville)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVilleRequest $request, Ville $ville)
    {
        $ville->update($request->validated());
        return response()->json($ville);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ville $ville)
    {
        $ville->delete();
        return response()->json(['message' => 'Ville supprimée avec succès']);
    }
}
