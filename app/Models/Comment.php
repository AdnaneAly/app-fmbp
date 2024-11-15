<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "comments";


    protected $fillable = [
        'observation_id',
        'employeur_id',
        'date',
        'message',
        'image',
        'annee',
    ];


    public function imageUrl(): string
    {
        return Storage::disk('public')->url($this->image);
    }


    public function observations()
    {
        return $this->belongsTo(Observation::class);
    }

    public function employeurs()
    {
        return $this->belongsTo(Employeur::class);
    }
}
