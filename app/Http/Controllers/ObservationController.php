<?php

namespace App\Http\Controllers;

use App\Http\Requests\ObservationRequest;
use App\Models\Boulanger;
use App\Models\Employeur;
use App\Models\Observation;
use Illuminate\Http\Request;

class ObservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $per_page = $request->per_page;
        $boulanger_id = $request->boulanger_id;
        $employeur_id = $request->employeur_id;
        $annee = session()->get('annee');

        $observations = Observation::with('boulanger', 'employeur')
            ->when($search, function($query) use($search){
                $query->where("name", "like", "%${search}%");
            })
            ->when($boulanger_id, function($query) use($boulanger_id){
                $query->where("boulanger_id", $boulanger_id);
            })
            ->when($employeur_id, function($query) use($employeur_id){
                $query->where("employeur_id", $employeur_id);
            })
            ->where('annee', $annee)
            ->latest()
            ->paginate($per_page ?? 5);
        $boulangers = Boulanger::orderBy('name', 'asc')->get();
        $employeurs = Employeur::orderBy('name', 'asc')->get();
        return inertia('Observation/Index', compact('observations', 'boulangers', 'employeurs'));
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
    public function store(ObservationRequest $request)
    {
        $option = Observation::create($request->validated());

        return redirect('observation');
    }

    /**
     * Display the specified resource.
     */
    public function show(Observation $observation)
    {
        $observations = Observation::with('boulanger', 'employeur', 'comments')->where('boulanger_id', $observation->boulanger_id)->first();
        //dd($observations);
        $employeur = Employeur::pluck('name', 'id');
        $employeurs = Employeur::all();
        return inertia('Observation/ShowObservation', compact('observations', 'employeur', 'employeurs'));
    }


    /**
     * Display the specified resource.
     */
    public function print(Request $request)
    {

        $search = $request->search;
        $per_page = $request->per_page;
        $boulanger_id = $request->boulanger_id;
        $employeur_id = $request->employeur_id;
        $annee = session()->get('annee');

        $observations = Observation::with('boulanger', 'employeur')
            ->when($search, function($query) use($search){
                $query->where("name", "like", "%${search}%");
            })
            ->when($boulanger_id, function($query) use($boulanger_id){
                $query->where("boulanger_id", $boulanger_id);
            })
            ->when($employeur_id, function($query) use($employeur_id){
                $query->where("employeur_id", $employeur_id);
            })
            ->where('annee', $annee)
            ->latest()
            ->paginate($per_page ?? 5);
        return inertia('Observation/PrintObservation', compact('observations'));
    }

    /**
     * Display the specified resource.
     */

    public function prints(Request $request)
    {
        $observations = Observation::with('boulanger', 'employeur', 'comments')
            ->find($request->id);
        $employeur = Employeur::pluck('name', 'id');
        return inertia('Observation/PrintComment', compact('observations','employeur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Observation $observation)
    {
        return response()->json(["observation" => $observation]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ObservationRequest $request, Observation $observation)
    {
        $observation->update($request->validated());

        return redirect('observation');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Observation $observation)
    {
        $countComment = $observation->comments()->count();
        if($countComment > 0) {
            return redirect()->back()->withErrors( 'للأسف ! لايمكن مسح هذه الملاحظة  ');
        }
        $observation->delete();
        return redirect()->back();
    }
}
