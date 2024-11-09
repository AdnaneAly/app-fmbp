<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proprietaire extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "proprietaires";

    protected $fillable = [
        'name',
        'tel',
        'address',
        'description'
    ];

    public function boulangers()
    {
        return $this->hasMany(Boulanger::class);
    }
}
