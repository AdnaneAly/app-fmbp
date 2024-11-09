<?php

namespace App\Http\Controllers;

use App\Http\Requests\AutreRecetteRequest;
use App\Models\AutreRecette;
use App\Models\Boulanger;
use App\Models\TypeRecette;
use Illuminate\Http\Request;

class AutreRecetteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->per_page;
        $boulanger_id = $request->boulanger_id;
        $type_recette_id = $request->type_recette_id;

        $autrerecettes = AutreRecette::with('typerecette')
            ->when($type_recette_id, function($query) use($type_recette_id){
                $query->where("type_recette_id", $type_recette_id);
            })
            ->when($boulanger_id, function($query) use($boulanger_id){
                $query->where("boulanger_id", $boulanger_id);
            })
            ->latest()
            ->paginate($per_page ?? 5);
        $boulangers = Boulanger::all();
        $typerecettes = TypeRecette::all();
        return inertia('Recette/AutreRecette/Index', compact('autrerecettes', 'boulangers', 'typerecettes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //$boulangers = Boulanger::all();
        $typerecettes = TypeRecette::all();
        return inertia('Recette/AutreRecette/CreateAutreRecette', compact( 'typerecettes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AutreRecetteRequest $request)
    {
        $option = AutreRecette::create($request->validated());

        return redirect('autrerecette');
    }

    /**
     * Display the specified resource.
     */
    public function show(AutreRecette $autreRecette)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AutreRecette $autrerecette)
    {
        $boulangers = Boulanger::all();
        $typerecettes = TypeRecette::all();
        return response()->json(["autreRecette" => $autrerecette]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AutreRecetteRequest $request, AutreRecette $autrerecette)
    {
        $autrerecette->update($request->validated());

        return redirect('autrerecette');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AutreRecette $autrerecette)
    {
        $autrerecette->delete();
        return redirect()->back();
    }
}
