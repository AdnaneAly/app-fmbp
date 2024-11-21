<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoyenneRequest;
use App\Models\Moyenne;
use Illuminate\Http\Request;

class MoyenneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->per_page;
        $month = $request->month;
        $annee = session()->get('annee');

        $moyennes = Moyenne::when($month, function($query) use($month){
                $query->whereMonth("date", $month);
            })
            ->where('annee', $annee)
            ->latest()
            ->paginate($per_page ?? 10);
        return inertia('Depence/Moyenne/Index', compact('moyennes'));
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
    public function store(MoyenneRequest $request)
    {
        $option = Moyenne::create($request->validated());

        return redirect('moyenne');
    }

    /**
     * Display the specified resource.
     */
    public function show(Moyenne $moyenne)
    {
        return inertia('Depence/Moyenne/ShowMoyenne', compact('moyenne'));
    }


    /**
     * Display the specified resource.
     */
    public function print(Request $request)
    {
        $per_page = $request->per_page;
        $month = $request->month;
        $annee = session()->get('annee');

        $moyennes = Moyenne::when($month, function($query) use($month){
                $query->whereMonth("date", $month);
            })
            ->where('annee', $annee)
            ->latest()
            ->paginate($per_page ?? 10);
        return inertia('Depence/Moyenne/PrintMoyenne', compact('moyennes'));
    }


    /**
     * Display the specified resource.
     */
    public function printDetail(Request $request)
    {
        //dd($request->id);
        $moyenne = Moyenne::find($request->id);
        return inertia('Depence/Moyenne/PrintShowMoyenne', compact('moyenne'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Moyenne $moyenne)
    {
        return response()->json(["moyenne" => $moyenne]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MoyenneRequest $request, Moyenne $moyenne)
    {
        $moyenne->update($request->validated());

        return redirect('moyenne');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Moyenne $moyenne)
    {
        $moyenne->delete();
        return redirect()->back();
    }
}
