<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaireRequest;
use App\Models\Employeur;
use App\Models\Salaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->per_page;
        $employeur_id = $request->employeur_id;
        $month = $request->month;

        $salaires = Salaire::with( 'employeur')
            ->when($employeur_id, function($query) use($employeur_id){
                $query->where("employeur_id", $employeur_id);
            })
            ->when($month, function($query) use($month){
                $query->whereMonth("date", $month);
            })
            ->latest()
            ->paginate($per_page ?? 5);
        $employeurs = Employeur::all();
        return inertia('Depence/Salaire/Index', compact('salaires',  'employeurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employeurs = Employeur::all();
        return inertia('Depence/Salaire/CreateSalaire', compact( 'employeurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalaireRequest $request)
    {
        //dd($request->all());
        try {
            //code...
            DB::beginTransaction();
            //dd($request->formData);

            $option = Salaire::create($request->validated());
            DB::table('avance_salaires')->where('employeur_id', $request['employeur_id'])->where('etat', 'noPaye')->update(['etat' => 'paye']);

            DB::commit();

            return redirect('salaire');

        } catch (\Exception $e) {
            //Exception $e;
            DB::rollBack();
            dd($e);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Salaire $salaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salaire $salaire)
    {
        $employeurs = Employeur::all();
        return inertia('Depence/Salaire/EditSalaire', compact( 'salaire', 'employeurs'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function print(Request $request)
    {
        $per_page = $request->per_page;
        $employeur_id = $request->employeur_id;
        $month = $request->month;

        $salaires = Salaire::with( 'employeur')
            ->when($employeur_id, function($query) use($employeur_id){
                $query->where("employeur_id", $employeur_id);
            })
            ->when($month, function($query) use($month){
                $query->whereMonth("date", $month);
            })
            ->latest()
            ->paginate($per_page ?? 5);
        return inertia('Depence/Salaire/PrintSalaire', compact('salaires'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalaireRequest $request, Salaire $salaire)
    {
        try {
            //code...
            DB::beginTransaction();
            //dd($request->formData);

            $salaire->update($request->validated());

            DB::commit();

            return redirect('salaire');

        } catch (\Exception $e) {
            //Exception $e;
            DB::rollBack();
            dd($e);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salaire $salaire)
    {
        $annee = $salaire->annee;
        $day = (int) date("d", strtotime($salaire->date));
        $month = date("m", strtotime($salaire->date));
        $numberDay = cal_days_in_month(CAL_GREGORIAN, $month, $annee);
        $debut = $day <= 15 ? $annee.'-'.$month.'-01' : $annee.'-'.$month.'-15';
        $fin = $day <= 15 ? $annee.'-'.$month.'-15' :  $annee.'-'.$month.'-'.$numberDay;

        try {
            //code...
            DB::beginTransaction();
            //dd($request->formData);
            $op = DB::table('avance_salaires')->where('employeur_id', $salaire['employeur_id'])->whereBetween('date', [$debut, $fin])->where('etat', 'paye')->update(['etat' => 'noPaye']);

            if ($op) {
                $salaire->delete();
                DB::commit();
                return redirect()->back();
            }else {
                return redirect()->back()->withErrors('Desole! On ne peut pas supprimer cette salaire ');
            }

        } catch (\Exception $e) {
            //Exception $e;
            DB::rollBack();
            dd($e);
        }


    }
}
