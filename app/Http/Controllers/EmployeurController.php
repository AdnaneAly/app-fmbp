<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeurRequest;
use App\Models\Employeur;
use App\Models\Grade;
use Illuminate\Http\Request;

class EmployeurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $per_page = $request->per_page;
        $grade_id = $request->grade_id;

        $employeurs = Employeur::with('grade')
            ->when($search, function($query) use($search){
                $query->where("name", "like", "%${search}%");
            })
            ->when($grade_id, function($query) use($grade_id){
                $query->where("grade_id", $grade_id);
            })
            ->latest()
            ->paginate($per_page ?? 5);
        $grades = Grade::all();
        return inertia('Employeur/Index', compact('employeurs', 'grades'));
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
    public function store(EmployeurRequest $request)
    {
        //dd($request->all());
        $option = Employeur::create($request->validated());

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Employeur $employeur)
    {
        return response()->json(["employeur" => $employeur]);
    }


    /**
     * Display the specified resource.
     */
    public function print(Request $request)
    {
        $search = $request->search;
        $per_page = $request->per_page;
        $grade_id = $request->grade_id;

        $employeurs = Employeur::with('grade')
            ->when($search, function($query) use($search){
                $query->where("name", "like", "%${search}%");
            })
            ->when($grade_id, function($query) use($grade_id){
                $query->where("grade_id", $grade_id);
            })
            ->latest()
            ->paginate($per_page ?? 5);
        return inertia('Employeur/PrintEmployeur', compact('employeurs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employeur $employeur)
    {
        return response()->json(["employeur" => $employeur]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeurRequest $request, Employeur $employeur)
    {
        $employeur->update($request->validated());

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employeur $employeur)
    {
        $employeur->delete();
        return redirect()->back();
    }
}
