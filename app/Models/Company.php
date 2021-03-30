<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'city',
        'cif',
        'logo',
    ];

    public function eggs()
    {
        return $this->hasMany(Egg::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getFullUrl()
    { 
        return Storage::url($this->logo);        
    }
    
}
