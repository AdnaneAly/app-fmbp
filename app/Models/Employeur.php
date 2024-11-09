<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employeur extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "employeurs";

    protected $fillable = [
        'name',
        'grade_id',
        'montantSalaire',
        'nni',
        'tel',
        'date',
        'etat',
        'description'
    ];

    static public function counteEmployeurs()
    {
        $query = self::all()->where('etat', 'active')->count();
        return $query;
    }


    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
