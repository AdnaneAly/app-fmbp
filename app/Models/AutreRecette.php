<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutreRecette extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "autre_recettes";


    protected $fillable = [
        'type_recette_id',
        'created_by',
        'montant',
        'numeroFacture',
        'date',
        'annee',
        'description'
    ];


    static public function montantAutreRecette($debut, $fin)
    {
        $query = self::all()->whereBetween('date', [$debut, $fin])->groupBy('type_recette_id')->map(function ($group) {
            return $group->sum('montant');
        });
        return $query;
    }

    static public function counteAutreRecette($debut, $fin)
    {
        $query = self::all()->whereBetween('date', [$debut, $fin])->groupBy('type_recette_id')->map(function ($group) {
            return $group->count();
        });
        return $query;
    }

    public function typeRecette()
    {
        return $this->belongsTo(TypeRecette::class);
    }
}
