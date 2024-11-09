<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvanceSalaireRequest;
use App\Models\AvanceSalaire;
use App\Models\Boulanger;
use App\Models\Employeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AvanceSalaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->per_page;
        $employeur_id = $request->employeur_id;
        $etatDepence = $request->etatDepence;

        $avancesalaires = AvanceSalaire::with('employeur')
            ->when($employeur_id, function($query) use($employeur_id){
                $query->where("employeur_id", $employeur_id);
            })
            ->when($etatDepence, function($query) use($etatDepence){
                $query->where("etat", $etatDepence);
            })
            ->latest()
            ->paginate($per_page ?? 5);
        $employeurs = Employeur::all();
        return inertia('Depence/AvanceSalaire/Index', compact('avancesalaires', 'employeurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $boulangers = Boulanger::all();
        $employeurs = Employeur::all();
        return inertia('Depence/AvanceSalaire/CreateAvanceSalaire', compact( 'boulangers', 'employeurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AvanceSalaireRequest $request)
    {
        try {
            //code...
            DB::beginTransaction();
            //dd($request->formData);

            $option = AvanceSalaire::create($request->validated());

            DB::commit();

            return redirect('avancesalaire');

        } catch (\Exception $e) {
            //Exception $e;
            DB::rollBack();
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AvanceSalaire $avanceSalaire)
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function getAvanceSalaire(Request $request)
    {
        $totalAvancer = AvanceSalaire::where('employeur_id', $request->id)->where('etat', 'noPaye')->sum('montantAvanceSalaire');
        return response()->json(["totalAvancer" => $totalAvancer]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AvanceSalaire $avancesalaire)
    {
        return response()->json(["avanceSalaire" => $avancesalaire]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AvanceSalaireRequest $request, AvanceSalaire $avancesalaire)
    {
        try {
            //code...
            DB::beginTransaction();

            if ( $request->etat === "noPaye" ) {

                $avancesalaire->update($request->validated());

                DB::commit();
                return redirect('avancesalaire');
            }

            return redirect()->back()->withErrors( 'Obss L\'Etat déja payé on ne peut pas le modifier');



        } catch (\Exception $e) {
            //Exception $e;
            DB::rollBack();
            dd($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AvanceSalaire $avancesalaire)
    {

        try {
            //code...
            DB::beginTransaction();

            if ( $avancesalaire->etat === "noPaye" ) {

                $avancesalaire->delete();

                DB::commit();
                return redirect()->back();
            }

            return redirect()->back()->withErrors( 'Obss L\'Etat déja payé on ne peut pas le supprimer');



        } catch (\Exception $e) {
            //Exception $e;
            DB::rollBack();
            dd($e);
        }


    }
}
