<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecetteRequest;
use App\Models\Boulanger;
use App\Models\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecetteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->per_page;
        $numeroFacture = $request->numeroFacture;
        $boulanger_id = $request->boulanger_id;
        $monthPaye = $request->monthPaye;
        $month = $request->month;
        $etatImpot = $request->etatImpot;
        $filter = $request->filter ?? 'boulanger_id';
        $annee = session()->get('annee');

        $recettes = Recette::with('boulanger')
            ->when($numeroFacture, function($query) use($numeroFacture){
                $query->where("numeroFacture", $numeroFacture);
            })
            ->when($boulanger_id, function($query) use($boulanger_id){
                $query->where("boulanger_id", $boulanger_id);
            })
            ->when($monthPaye, function($query) use($monthPaye){
                $query->whereMonth("date", $monthPaye);
            })
            ->when($month, function($query) use($month){
                $query->where("month", $month);
            })
            ->when($etatImpot, function($query) use($etatImpot){
                $query->where("type_recette", $etatImpot);
            })
            ->where('annee', $annee)
            ->orderBy($filter, 'asc')
            ->latest()
            ->paginate($per_page ?? 5);
        $boulangers = Boulanger::orderBy('name', 'asc')->get();
        return inertia('Recette/Index', compact('recettes', 'boulangers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $boulangers = Boulanger::orderBy('name', 'desc')->get();
        return inertia('Recette/CreateRecette', compact( 'boulangers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RecetteRequest $request)
    {
        try {
            //code...
            DB::beginTransaction();
            //dd($request->formData);

            $data = Recette::where('boulanger_id', $request->boulanger_id)->where('month', $request->month)->first();

            if ( $data !== null ) {
                return redirect()->back()->withErrors('لا يمكنك اضافة جبايتين في مخبزة واحدة لنفس الشهر!');
            }

            $option = Recette::create($request->validated());

            $boulanger = Boulanger::find($request->boulanger_id);

            $op = DB::table('boulangers')->where('id', $request->boulanger_id)->update(['arriere' => $boulanger->arriere - 1]);


            $recettes = Recette::where('boulanger_id', $request->boulanger_id)->orderBy('month', 'asc')->get();

            DB::commit();
            $boulangers = Boulanger::all();
            return inertia('Recette/Index', compact('boulangers', 'recettes'));

        } catch (\Exception $e) {
            //Exception $e;
            DB::rollBack();
            dd($e);
        }



    }


    /**
     * Store a newly created resource in storage.
     */
    public function storeRecette(RecetteRequest $request)
    {
        try {
            //code...
            DB::beginTransaction();
            //dd($request->formData);

            $data = Recette::where('boulanger_id', $request->boulanger_id)->where('month', $request->month)->first();

            if ( $data !== null ) {
                return redirect()->back()->withErrors('Interdit d\'ajouter deux impots pour une meme mois!');
            }

            $option = Recette::create($request->validated());

            $boulanger = Boulanger::find($request->boulanger_id);

            $op = DB::table('boulangers')->where('id', $request->boulanger_id)->update(['arriere' => $boulanger->arriere - 1]);


            $recettes = Recette::where('boulanger_id', $request->boulanger_id)->orderBy('month', 'asc')->get();

            DB::commit();

            return inertia('Boulanger/ShowBoulanger', compact('boulanger', 'recettes'));

        } catch (\Exception $e) {
            //Exception $e;
            DB::rollBack();
            dd($e);
        }



    }

    /**
     * Display the specified resource.
     */
    public function show(Recette $recette)
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function print(Request $request)
    {
        $per_page = $request->per_page;
        $numeroFacture = $request->numeroFacture;
        $boulanger_id = $request->boulanger_id;
        $monthPaye = $request->monthPaye;
        $month = $request->month;
        $etatImpot = $request->etatImpot;
        $annee = session()->get('annee');

        $recettes = Recette::with('boulanger')
            ->when($numeroFacture, function($query) use($numeroFacture){
                $query->where("numeroFacture", $numeroFacture);
            })
            ->when($boulanger_id, function($query) use($boulanger_id){
                $query->where("boulanger_id", $boulanger_id);
            })
            ->when($monthPaye, function($query) use($monthPaye){
                $query->whereMonth("date", $monthPaye);
            })
            ->when($month, function($query) use($month){
                $query->where("month", $month);
            })
            ->when($etatImpot, function($query) use($etatImpot){
                $query->where("type_recette", $etatImpot);
            })
            ->where('annee', $annee)
            ->latest()
            ->paginate($per_page ?? 10);

        return inertia('Recette/PrintRecette', compact('recettes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recette $recette)
    {
        return response()->json(["recette" => $recette]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RecetteRequest $request, Recette $recette)
    {

        try {
            //code...
            DB::beginTransaction();
            //dd($request->formData);

            $recette->update($request->validated());

            DB::commit();

            return redirect()->route('boulanger.show', $request->boulanger_id);

        } catch (\Exception $e) {
            //Exception $e;
            DB::rollBack();
            dd($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recette $recette)
    {
        try {
            //code...
            DB::beginTransaction();
            //dd($request->formData);
            $boulanger = Boulanger::find($recette->boulanger_id);
            $recette->delete();
            $op = DB::table('boulangers')->where('id', $recette->boulanger_id)->update(['arriere' => $boulanger->arriere + 1]);

            DB::commit();

            return redirect()->route('boulanger.show', $recette->boulanger_id);

        } catch (\Exception $e) {
            //Exception $e;
            DB::rollBack();
            dd($e);
        }

    }
}
