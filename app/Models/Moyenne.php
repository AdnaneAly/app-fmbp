<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moyenne extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "moyennes";

    protected $fillable = [
        'type',
        'niveau',
        'reference',
        'numeroFacture',
        'created_by',
        'montant',
        'date',
        'annee',
        'description'
    ];


    static public function montantMoyennes($debut, $fin)
    {
        $query = self::all()->whereBetween('date', [$debut, $fin])->sum('montant');
        return $query;
    }

    static public function counteMoyenne($debut, $fin)
    {
        $query = self::all()->whereBetween('date', [$debut, $fin])->count();
        return $query;
    }

    static public function montantMoyennesSTQ($month)
    {
        $annee = session()->get('annee');
        $query = self::select()->whereMonth('date', $month)->where('annee', $annee)->sum('montant');
        return $query;
    }
}
