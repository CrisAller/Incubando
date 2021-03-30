<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Egg extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference',
        'weight',
        'starting_weight',
        'collection_date',
        'incubation_day',
        'starting_date',
        'pic_date',
        'real_pic_date',
        'weight_pic',
        'misbirth',
        'birth',
        'company_id',
        'specie_id',
    ];

    protected $casts = [
        'collection_date' => 'datetime:Y-m-d',
        'starting_date' => 'datetime:Y-m-d',
        'pic_date' => 'datetime:Y-m-d',
        'misbirth' => 'datetime:Y-m-d',
        'incubation_day' => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function specie()
    {
        return $this->belongsTo(Specie::class);
    }

    public function eggProjections()
    {
        return $this->hasMany(EggProjection::class);
    }

    public function getFormattedWeightAttribute()
    {
        $format = number_format($this->attributes['weight'], 2);
        return  $format. ' gr.';
    }

    public function getFormattedStartingWeightAttribute()
    {
        $format = number_format($this->attributes['starting_weight'], 2);
        return $format . ' gr.';
    }

    public function getState(){
        return [
            'state' => 'Incubando',
            'class' => 'bg-yellow-200 text-yellow-600'
        ];
    }


}
