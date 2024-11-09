<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AvanceSalaire extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "avance_salaires";
    protected $fillable = [
        'employeur_id',
        'created_by',
        'montantAvanceSalaire',
        'date',
        'annee',
        'description',
        'etat',
    ];


    static public function montantAvanceSalaires($debut, $fin)
    {
        $query = self::all()->whereBetween('date', [$debut, $fin])->sum('montantAvanceSalaire');
        return $query;
    }


    static public function counteAvanceSalaire($debut, $fin)
    {
        $query = self::all()->whereBetween('date', [$debut, $fin])->count();
        return $query;
    }



    public function employeur()
    {
        return $this->belongsTo(Employeur::class);
    }
}
