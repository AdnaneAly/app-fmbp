<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Depence extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "depences";

    protected $fillable = [
        'type_depence_id',
        'employeur_id',
        'created_by',
        'montant',
        'date',
        'annee',
        'description'
    ];


    static public function montantDepence($debut, $fin)
    {
        $query = self::all()->whereBetween('date', [$debut, $fin])->groupBy('type_depence_id')->map(function ($group) {
            return $group->sum('montant');
        });
        return $query;
    }


    static public function counteDepence($debut, $fin)
    {
        $query = self::all()->whereBetween('date', [$debut, $fin])->groupBy('type_depence_id')->map(function ($group) {
            return $group->count();
        });
        return $query;
    }


    public function type_depence()
    {
        return $this->belongsTo(TypeDepence::class);
    }

    public function employeur()
    {
        return $this->belongsTo(Employeur::class);
    }
}
