<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salaire extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "salaires";

    protected $fillable = [
        'employeur_id',
        'created_by',
        'nombreJoursTravail',
        'montantJoursTravail',
        'montantNet',
        'montantAS',
        'date',
        'annee',
        'description'
    ];


    static public function montantSalaires($debut, $fin)
    {
        $query = self::all()->whereBetween('date', [$debut, $fin])->sum('montantNet');
        return $query;
    }

    static public function counteSalaire($debut, $fin)
    {
        $query = self::all()->whereBetween('date', [$debut, $fin])->count();
        return $query;
    }

    public function employeur()
    {
        return $this->belongsTo(Employeur::class);
    }
}
