<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoulangerRequest;
use App\Models\Boulanger;
use App\Models\Proprietaire;
use App\Models\Recette;
use Illuminate\Http\Request;

class BoulangerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $per_page = $request->per_page;
        $proprietaire_id = $request->proprietaire_id;
        $boulangers = Boulanger::with('proprietaire')
            ->when($search, function($query) use($search){
                $query->where("name", "like", "%${search}%");
            })
            ->when($proprietaire_id, function($query) use($proprietaire_id){
                $query->where("proprietaire_id", $proprietaire_id);
            })
            ->latest()
            ->paginate($per_page ?? 5);
        $proprietaires = Proprietaire::all();
        $countNonPaye = Recette::counteRecetteType();
        //dd($countNonPaye);
        return inertia('Boulanger/Index', compact('boulangers', 'proprietaires', 'countNonPaye'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proprietaires = Proprietaire::pluck('quantite', 'id');
        return response()->json(["proprietaires" => $proprietaires]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BoulangerRequest $request)
    {
        $option = Boulanger::create($request->validated());

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Boulanger $boulanger)
    {
        $recettes = Recette::where('boulanger_id', $boulanger->id)->orderBy('month', 'asc')->get();
        return inertia('Boulanger/ShowBoulanger', compact('boulanger', 'recettes'));
    }


    /**
     * Display the specified resource.
     */
    public function print(Request $request)
    {
        $search = $request->search;
        $per_page = $request->per_page;
        $proprietaire_id = $request->proprietaire_id;
        $boulangers = Boulanger::with('proprietaire')
            ->when($search, function($query) use($search){
                $query->where("name", "like", "%${search}%");
            })
            ->when($proprietaire_id, function($query) use($proprietaire_id){
                $query->where("proprietaire_id", $proprietaire_id);
            })
            ->latest()
            ->paginate($per_page ?? 5);
            $countNonPaye = Recette::counteRecetteType();
        return inertia('Boulanger/PrintBoulanger', compact('boulangers', 'countNonPaye'));
    }


    /**
     * Display the specified resource.
     */
    public function printDetail(Request $request)
    {
        $boulanger = Boulanger::with('proprietaire')->find($request->id);
        $recettes = Recette::where('boulanger_id', $request->id)->orderBy('month', 'asc')->get();
        $etatscountes = Recette::etatRecetteCountes($request->id);
        $countRecettes = Recette::counteRecetteBoulanger($request->id);
        //dd($countRecette);
        $etatsmontants = Recette::etatRecetteMontant($request->id);
        //dd($etatsmontants);
        return inertia('Boulanger/PrintShowBoulanger', compact('boulanger', 'recettes', 'etatscountes', 'etatsmontants','countRecettes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Boulanger $boulanger)
    {
        return response()->json(["boulanger" => $boulanger]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BoulangerRequest $request, Boulanger $boulanger)
    {
        $boulanger->update($request->validated());

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Boulanger $boulanger)
    {
        $countRecettes = $boulanger->recettes()->count();
        if($countRecettes > 0) {
            return redirect()->back()->withErrors( 'لايمكن مسح المخبزة لأنها تحتوي على مداخيل');
        }

        $boulanger->delete();
        return redirect()->back();
    }
}
