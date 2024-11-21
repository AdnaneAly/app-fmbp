<?php

namespace App\Http\Controllers;

use App\Models\AvanceSalaire;
use App\Models\Boulanger;
use App\Models\Depence;
use App\Models\Moyenne;
use App\Models\Recette;
use App\Models\Salaire;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index() {
        return Inertia::render('Index');
    }


    public function contact() {
        return Inertia::render('Contact');
    }


    public function statistic() {

        $data = [];
        $recettes = [];
        $depences = [];
        for( $i = 1; $i <= 12; $i++){
            $recettes[] = Recette::montantRecetteSTQ($i) / 100;
        }


        for( $j = 1; $j <= 12; $j++){
            $depences[] = (Depence::montantDepenceSTQ($j) +
            AvanceSalaire::montantAvanceSalairesSTQ($j) +
            Moyenne::montantMoyennesSTQ($j) +
            Salaire::montantSalairesSTQ($j)) / 100;
        }

        $data['countBoulanger'] = Boulanger::counteBoulangers();
        $data['impotPaye'] = Recette::counteRecettesType('PAYE');
        $data['impotNoPaye'] = Recette::counteRecettesType('NONPAYE');
        $data['impotSemiPaye'] = Recette::counteRecettesType('SEMIPAYE');
        $data['impotExonerer'] = Recette::counteRecettesType('EXONERER');
        $data['impotFermer'] = Recette::counteRecettesType('FERMER');
        return Inertia::render('Statistic', compact('data', 'recettes', 'depences'));
    }


}
