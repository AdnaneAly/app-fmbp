<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Observation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "observations";


    protected $fillable = [
        'boulanger_id',
        'employeur_id',
        'created_by',
        'date',
        'message',
        'annee',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function boulanger()
    {
        return $this->belongsTo(Boulanger::class);
    }

    public function employeur()
    {
        return $this->belongsTo(Employeur::class);
    }
}
