<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeRecetteRequest;
use App\Models\TypeRecette;
use Illuminate\Http\Request;

class TypeRecetteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typerecettes = TypeRecette::latest()->paginate(4);
        return inertia('Operation/TypeRecette/Index', compact('typerecettes'));
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
    public function store(TypeRecetteRequest $request)
    {
        $option = TypeRecette::create($request->validated());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeRecette $typeRecette)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeRecette $typerecette)
    {
        return response()->json(["typerecette" => $typerecette]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TypeRecetteRequest $request, TypeRecette $typerecette)
    {
        $typerecette->update($request->validated());

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeRecette $typerecette)
    {
        $typerecette->delete();
        return redirect()->back();
    }
}
