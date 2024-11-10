<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepenceRequest;
use App\Models\Depence;
use App\Models\Employeur;
use App\Models\TypeDepence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->per_page;
        $type_depence_id = $request->type_depence_id;
        $employeur_id = $request->employeur_id;
        $month = $request->month;

        $depences = Depence::with('type_depence', 'employeur')
            ->when($type_depence_id, function($query) use($type_depence_id){
                $query->where("type_depence_id", $type_depence_id);
            })
            ->when($employeur_id, function($query) use($employeur_id){
                $query->where("employeur_id", $employeur_id);
            })
            ->when($month, function($query) use($month){
                $query->whereMonth("date", $month);
            })
            ->latest()
            ->paginate($per_page ?? 5);
        $typedepences = TypeDepence::all();
        $employeurs = Employeur::all();
        return inertia('Depence/Index', compact('depences',  'typedepences', 'employeurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $typedepences = TypeDepence::all();
        $employeurs = Employeur::all();
        return inertia('Depence/CreateDepence', compact(  'typedepences', 'employeurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            //code...
            DB::beginTransaction();
            //dd($request->formData);

            $details_list = [];


            foreach ($request->formData as $key => $value) {
                Depence::create([
                    'type_depence_id'   => $value['type_depence_id'],
                    'created_by'        => $request->created_by,
                    'employeur_id'      => $value['employeur_id'] === '' ? null : $value['employeur_id'],
                    'montant'           => $value['montant'],
                    'description'       => $value['description'],
                    'date'              => $request->date,
                    'annee'             => $request->annee,
                ]);
            }

            //dd($details_list);

            DB::commit();

            return redirect()->route("depence.index");




        } catch (\Exception $e) {
            //Exception $e;
            DB::rollBack();
            dd($e);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Depence $depence)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function print(Request $request)
    {
        $per_page = $request->per_page;
        $type_depence_id = $request->type_depence_id;
        $employeur_id = $request->employeur_id;
        $month = $request->month;

        $depences = Depence::with('type_depence', 'employeur')
            ->when($type_depence_id, function($query) use($type_depence_id){
                $query->where("type_depence_id", $type_depence_id);
            })
            ->when($employeur_id, function($query) use($employeur_id){
                $query->where("employeur_id", $employeur_id);
            })
            ->when($month, function($query) use($month){
                $query->whereMonth("date", $month);
            })
            ->latest()
            ->paginate($per_page ?? 5);
        return inertia('Depence/PrintDepence', compact('depences'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Depence $depence)
    {
        $typedepences = TypeDepence::all();
        $employeurs = Employeur::all();
        return response()->json(["depence" => $depence]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepenceRequest $request, Depence $depence)
    {

        try {
            //code...
            DB::beginTransaction();
            //dd($request->formData);

            $depence->update($request->validated());

            DB::commit();

            return redirect('depence');

        } catch (\Exception $e) {
            //Exception $e;
            DB::rollBack();
            dd($e);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Depence $depence)
    {
        try {
            //code...
            DB::beginTransaction();
            //dd($request->formData);

            $depence->delete();

            DB::commit();

            return redirect()->back();

        } catch (\Exception $e) {
            //Exception $e;
            DB::rollBack();
            dd($e);
        }


    }
}
