<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeDepenceRequest;
use App\Models\TypeDepence;

class TypeDepenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typedepences = TypeDepence::latest()->paginate(4);
        return inertia('Operation/TypeDepence/Index', compact('typedepences'));
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
    public function store(TypeDepenceRequest $request)
    {
        $option = TypeDepence::create($request->validated());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeDepence $typeDepence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeDepence $typedepence)
    {
        return response()->json(["typedepence" => $typedepence]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TypeDepenceRequest $request, TypeDepence $typedepence)
    {
        $typedepence->update($request->validated());

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeDepence $typedepence)
    {
        $typedepence->delete();
        return redirect()->back();
    }
}
