<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Recette extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "recettes";
    protected $fillable = [
        'boulanger_id',
        'type_recette',
        'created_by',
        'montant',
        'numeroFacture',
        'date',
        'month',
        'annee',
        'description'
    ];


    static public function montantRecette($debut, $fin)
    {
        try {
            //code...
            $query = DB::table('recettes')
            ->where('deleted_at', NULL)
            ->whereBetween('date', [$debut, $fin])
            ->select('type_recette', DB::raw('SUM(montant) as total'))
            ->groupBy('type_recette')
            ->get()
            ->pluck('total', 'type_recette');

        return $query;
        } catch (Exception $e) {
            //throw $th;
            dd($e);
        }
    }


    static public function etatRecetteCountes($boulanger_id)
    {
        try {
            //code...
            $query = DB::table('recettes')
            ->where('deleted_at', NULL)
            ->where('boulanger_id', $boulanger_id)
            ->select('type_recette', DB::raw('COUNT(*) as total'))
            ->groupBy('type_recette')
            ->get()
            ->pluck('total', 'type_recette');

        return $query;
        } catch (Exception $e) {
            //throw $th;
            dd($e);
        }
    }


    static public function etatRecetteMontant($boulanger_id)
    {
        try {
            //code...
            $query = DB::table('recettes')
            ->where('deleted_at', NULL)
            ->where('boulanger_id', $boulanger_id)
            ->select('type_recette', DB::raw('SUM(montant) as total'))
            ->groupBy('type_recette')
            ->get()
            ->pluck('total', 'type_recette');

        return $query;
        } catch (Exception $e) {
            //throw $th;
            dd($e);
        }
    }

    static public function counteRecette($debut, $fin)
    {
        $query = self::all()->whereBetween('date', [$debut, $fin])->groupBy('type_recette')->map(function ($group) {
            return $group->count();
        });
        return $query;
    }

    public function boulanger()
    {
        return $this->belongsTo(Boulanger::class);
    }

}
