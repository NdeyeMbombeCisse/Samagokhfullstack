<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommuneRequest;
use App\Http\Requests\UpdateCommuneRequest;
use App\Models\Commune;
use Illuminate\Http\Request;

class CommuneController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $communes = Commune::all();
        return response()->json($communes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommuneRequest $request)
    {
        $commune = Commune::create($request->validated());
        return response()->json($commune, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Commune $commune)
    {
        return response()->json($commune);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommuneRequest $request, Commune $commune)
    {
        $commune->update($request->validated());
        return response()->json($commune);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commune $commune)
    {
        $commune->delete();
        return response()->json(null, 204);
    }

    public function getTotalCommunes()
    {
        $totalCommunes = Commune::count();

        return response()->json($totalCommunes);
    }
}
