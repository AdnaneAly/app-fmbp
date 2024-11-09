<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProprietaireRequest;
use App\Models\Proprietaire;
use Illuminate\Http\Request;

class ProprietaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proprietaires = Proprietaire::latest()->paginate(4);
        return inertia('Operation/Proprietaire/Index', compact('proprietaires'));
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
    public function store(ProprietaireRequest $request)
    {
        $option = Proprietaire::create($request->validated());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Proprietaire $proprietaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proprietaire $proprietaire)
    {
        return response()->json(["proprietaire" => $proprietaire]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProprietaireRequest $request, Proprietaire $proprietaire)
    {
        $proprietaire->update($request->validated());

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proprietaire $proprietaire)
    {
        $proprietaire->delete();
        return redirect()->back();
    }
}
