<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EggProjection extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'incubation_day',
        'incubation_date',
        'weight_standard',
        'ideal_weight_above',
        'ideal_weight_below',
        'real_weight',
        'timestamp_weight',
        'egg_id',
        'user_id',
    ];

    protected $casts = [
        'incubation_date' => 'datetime:Y-m-d',
    ];

    public function egg()
    {
        return $this->belongsTo(Egg::class);
    }

    public function user()
    {
        return $this->belongTo(User::class);
    }

    public function getFormattedWeightStandardAttribute()
    {
        $format = number_format($this->attributes['weight_standard'], 2);
        return  $format. ' gr.';
    }

    public function getFormattedRealWeightAttribute()
    {
        $format = number_format($this->attributes['real_weight'], 2);
        return  $format. ' gr.';
    }
}
