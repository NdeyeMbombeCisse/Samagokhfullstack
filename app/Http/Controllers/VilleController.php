<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVilleRequest;
use App\Http\Requests\UpdateVilleRequest;
use App\Models\Ville;

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
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ville $ville)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ville $ville)
    {
        //
    }
}
