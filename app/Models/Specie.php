<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specie extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'specie_name',
        'weightlost_standard',
        'weightlost_min',
        'weightlost_max',
    ];

    public function eggs()
    {
        return $this->hasMany(Egg::class);
    }
}
