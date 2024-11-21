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
    public function index(Request $request)
    {
        $per_page = $request->per_page;
        $search = $request->search;

        $proprietaires = Proprietaire::with('boulangers')
            ->when($search, function ($query) use ($search) {
            $query->where("name", "like", "%${search}%");
        })
            ->latest()
            ->paginate($per_page ?? 10);
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
     * Display the specified resource.
     */
    public function print(Request $request)
    {
        $per_page = $request->per_page;
        $search = $request->search;

        $proprietaires = Proprietaire::with('boulangers')
            ->when($search, function ($query) use ($search) {
            $query->where("name", "like", "%${search}%");
        })
            ->latest()
            ->paginate($per_page ?? 10);
        return inertia('Operation/Proprietaire/PrintProprietaire', compact('proprietaires'));
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
        $countBoulanger = $proprietaire->boulangers()->count();
        if ($countBoulanger > 0) {
            return redirect()->back()->withErrors('لايمكن مسح هذا المالك لأن لديه مخابز');
        }

        $proprietaire->delete();
        return redirect()->back();
    }
}
