<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Boulanger extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "boulangers";
    protected $fillable = [
        'name',
        'address',
        'created_by',
        'proprietaire_id',
        'etat',
        'description'
    ];


    static public function counteBoulangers()
    {
        $query = self::all()->where('etat', 'active')->count();
        return $query;
    }
    public function proprietaire()
    {
        return $this->belongsTo(Proprietaire::class);
    }

}
