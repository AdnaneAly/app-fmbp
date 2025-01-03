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
        $numeroFacture = $request->numeroFacture;
        $type_recette_id = $request->type_recette_id;
        $month = $request->month;
        $annee = session()->get('annee');

        $autrerecettes = AutreRecette::with('typerecette')
            ->when($type_recette_id, function($query) use($type_recette_id){
                $query->where("type_recette_id", $type_recette_id);
            })
            ->when($numeroFacture, function($query) use($numeroFacture){
                $query->where("numeroFacture", $numeroFacture);
            })
            ->when($month, function($query) use($month){
                $query->whereMonth("date", $month);
            })
            ->where('annee', $annee)
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
    public function show(AutreRecette $autrerecette)
    {
        $typerecette = TypeRecette::pluck('name', 'id');
        $boulanger = Boulanger::pluck('name', 'id');
        return inertia('Recette/AutreRecette/ShowAutreRecette', compact( 'autrerecette', 'typerecette', 'boulanger'));
    }


    /**
     * Display the specified resource.
     */
    public function print(Request $request)
    {
        $per_page = $request->per_page;
        $numeroFacture = $request->numeroFacture;
        $type_recette_id = $request->type_recette_id;
        $month = $request->month;
        $annee = session()->get('annee');

        $autrerecettes = AutreRecette::with('typerecette')
            ->when($type_recette_id, function($query) use($type_recette_id){
                $query->where("type_recette_id", $type_recette_id);
            })
            ->when($numeroFacture, function($query) use($numeroFacture){
                $query->where("numeroFacture", $numeroFacture);
            })
            ->when($month, function($query) use($month){
                $query->whereMonth("date", $month);
            })
            ->where('annee', $annee)
            ->latest()
            ->paginate($per_page ?? 5);
        return inertia('Recette/AutreRecette/PrintAutreRecette', compact('autrerecettes'));
    }


    /**
     * Display the specified resource.
     */
    public function printDetail(Request $request)
    {
        $autrerecette = AutreRecette::with('typerecette', 'boulanger')->find($request->id);
        return inertia('Recette/AutreRecette/PrintShowAutreRecette', compact('autrerecette'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AutreRecette $autrerecette)
    {
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
