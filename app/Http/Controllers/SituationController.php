<?php

namespace App\Http\Controllers;

use App\Models\AutreRecette;
use App\Models\AvanceSalaire;
use App\Models\Boulanger;
use App\Models\Depence;
use App\Models\Employeur;
use App\Models\Recette;
use App\Models\Salaire;
use App\Models\TypeDepence;
use App\Models\TypeRecette;
use Illuminate\Http\Request;

class SituationController extends Controller
{
    public function index()
    {
        return inertia('Situation/Index');
    }


    public function etat(Request $request)
    {
        $request->validate([
            'debutSearch' => 'required|date',
            'finSearch' => 'required|date',
            'rapportSearch' => 'required|string',
        ]);

        $rapport = $request->input('rapportSearch') ?? 'All';
        $debut = $request->input('debutSearch') ?? '2024-01-01';
        $fin = $request->input('finSearch') ?? '2024-12-31';

        if ($debut <= $fin) {
            if ($rapport === 'All') {

                $data['dupMontantRecette']          = Recette::montantRecette($debut, $fin);
                $data['dupRecette']                 = Recette::counteRecette($debut, $fin);
                //dd($data['dupRecette']);

                $data['dupMontantAutreRecette']     = AutreRecette::montantAutreRecette($debut, $fin);
                $data['dupAutreRecette']            = AutreRecette::counteAutreRecette($debut, $fin);

                $data['dupMontantDepenceSalaire']   = Salaire::montantSalaires($debut, $fin);
                $data['dupDepenceSalaire']          = Salaire::counteSalaire($debut, $fin);

                $data['dupMontantAvanceSalaire']    = AvanceSalaire::montantAvanceSalaires($debut, $fin);
                $data['dupAvanceSalaire']           = AvanceSalaire::counteAvanceSalaire($debut, $fin);

                $data['dupMontantDepence']          = Depence::montantDepence($debut, $fin);
                $data['dupDepence']                 = Depence::counteDepence($debut, $fin);



                $data['dates']              = $request->all();
                $data['counteBoulanger']    = Boulanger::counteBoulangers();
                $data['counteArriereBoulanger']    = Boulanger::counteArriereBoulangers();
                $data['counteEmployeur']    = Employeur::counteEmployeurs();
                $data['typeRecettes']       = TypeRecette::pluck('name', 'id');
                $data['typeDepences']       = TypeDepence::pluck('name', 'id');
                //dd($data['dupMontantAutreRecette']);

                return inertia('Situation/Etat', compact('data'));
            } elseif ($rapport === 'depences') {
                $data['dupMontantDepenceSalaire']   = Salaire::montantSalaires($debut, $fin);
                $data['dupDepenceSalaire']          = Salaire::counteSalaire($debut, $fin);

                $data['dupMontantAvanceSalaire']    = AvanceSalaire::montantAvanceSalaires($debut, $fin);
                $data['dupAvanceSalaire']           = AvanceSalaire::counteAvanceSalaire($debut, $fin);

                $data['dupMontantDepence']          = Depence::montantDepence($debut, $fin);
                $data['dupDepence']                 = Depence::counteDepence($debut, $fin);



                $data['dates']              = $request->all();
                $data['counteBoulanger']    = Boulanger::counteBoulangers();
                $data['counteArriereBoulanger']    = Boulanger::counteArriereBoulangers();
                $data['counteEmployeur']    = Employeur::counteEmployeurs();
                $data['typeRecettes']       = TypeRecette::pluck('name', 'id');
                $data['typeDepences']       = TypeDepence::pluck('name', 'id');

                return inertia('Situation/EtatDepence', compact('data'));
            } else {
                $data['dupMontantRecette']          = Recette::montantRecette($debut, $fin);
                $data['dupRecette']                 = Recette::counteRecette($debut, $fin);

                $data['dupMontantAutreRecette']     = AutreRecette::montantAutreRecette($debut, $fin);
                $data['dupAutreRecette']            = AutreRecette::counteAutreRecette($debut, $fin);



                $data['dates']              = $request->all();
                $data['counteBoulanger']    = Boulanger::counteBoulangers();
                $data['counteArriereBoulanger']    = Boulanger::counteArriereBoulangers();
                $data['counteEmployeur']    = Employeur::counteEmployeurs();
                $data['typeRecettes']       = TypeRecette::pluck('name', 'id');
                $data['typeDepences']       = TypeDepence::pluck('name', 'id');

                return inertia('Situation/EtatRecette', compact('data'));
            }
        } else {
            return redirect()->back()->withErrors('تاريخ البداية يجب ان يكون اصغر من تاريخ النهاية');
        }
    }


    public function printetat(Request $request)
    {

        $debut = $request->input('debutSearch') ?? '2024-01-01';
        $fin = $request->input('finSearch') ?? '2024-12-31';


        $data['dupMontantRecette']          = Recette::montantRecette($debut, $fin);
        $data['dupRecette']                 = Recette::counteRecette($debut, $fin);

        $data['dupMontantAutreRecette']     = AutreRecette::montantAutreRecette($debut, $fin);
        $data['dupAutreRecette']            = AutreRecette::counteAutreRecette($debut, $fin);

        $data['dupMontantDepenceSalaire']   = Salaire::montantSalaires($debut, $fin);
        $data['dupDepenceSalaire']          = Salaire::counteSalaire($debut, $fin);

        $data['dupMontantAvanceSalaire']    = AvanceSalaire::montantAvanceSalaires($debut, $fin);
        $data['dupAvanceSalaire']           = AvanceSalaire::counteAvanceSalaire($debut, $fin);

        $data['dupMontantDepence']          = Depence::montantDepence($debut, $fin);
        $data['dupDepence']                 = Depence::counteDepence($debut, $fin);



        $data['dates']              = $request->all();
        $data['counteBoulanger']    = Boulanger::counteBoulangers();
        $data['counteArriereBoulanger']    = Boulanger::counteArriereBoulangers();
        $data['counteEmployeur']    = Employeur::counteEmployeurs();
        $data['typeRecettes']       = TypeRecette::pluck('name', 'id');
        $data['typeDepences']       = TypeDepence::pluck('name', 'id');
        //dd($data['dupMontantAutreRecette']);

        return inertia('Situation/PrintEtat', compact('data'));
    }

    public function printdepence(Request $request)
    {
        $debut = $request->input('debutSearch') ?? '2024-01-01';
        $fin = $request->input('finSearch') ?? '2024-12-31';

        $data['dupMontantDepenceSalaire']   = Salaire::montantSalaires($debut, $fin);
        $data['dupDepenceSalaire']          = Salaire::counteSalaire($debut, $fin);

        $data['dupMontantAvanceSalaire']    = AvanceSalaire::montantAvanceSalaires($debut, $fin);
        $data['dupAvanceSalaire']           = AvanceSalaire::counteAvanceSalaire($debut, $fin);

        $data['dupMontantDepence']          = Depence::montantDepence($debut, $fin);
        $data['dupDepence']                 = Depence::counteDepence($debut, $fin);



        $data['dates']              = $request->all();
        $data['counteBoulanger']    = Boulanger::counteBoulangers();
        $data['counteArriereBoulanger']    = Boulanger::counteArriereBoulangers();
        $data['counteEmployeur']    = Employeur::counteEmployeurs();
        $data['typeRecettes']       = TypeRecette::pluck('name', 'id');
        $data['typeDepences']       = TypeDepence::pluck('name', 'id');

        return inertia('Situation/PrintDepence', compact('data'));
    }



    public function printrecette(Request $request)
    {
        $debut = $request->input('debutSearch') ?? '2024-01-01';
        $fin = $request->input('finSearch') ?? '2024-12-31';

        $data['dupMontantRecette']          = Recette::montantRecette($debut, $fin);
        $data['dupRecette']                 = Recette::counteRecette($debut, $fin);

        $data['dupMontantAutreRecette']     = AutreRecette::montantAutreRecette($debut, $fin);
        $data['dupAutreRecette']            = AutreRecette::counteAutreRecette($debut, $fin);



        $data['dates']              = $request->all();
        $data['counteBoulanger']    = Boulanger::counteBoulangers();
        $data['counteArriereBoulanger']    = Boulanger::counteArriereBoulangers();
        $data['counteEmployeur']    = Employeur::counteEmployeurs();
        $data['typeRecettes']       = TypeRecette::pluck('name', 'id');
        $data['typeDepences']       = TypeDepence::pluck('name', 'id');

        return inertia('Situation/PrintRecette', compact('data'));
    }
}
