<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Egg;
use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use App\Models\EggProjection;
use ConsoleTVs\Charts\BaseChart;

class EggChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $egg = Egg::find($request->egg);
        $data = EggProjection::where('egg_id', $egg->id)->orderBy('incubation_day')->get();
        $weight_standard = [];
        $real_weight = [];
        $ideal_weight_above = [];
        $ideal_weight_below = [];
        foreach($data as $key => $projection){
            if($key%2 != 0){
                $weight_standard []= $projection->weight_standard;
                $ideal_weight_above []= $projection->ideal_weight_above;
                $ideal_weight_below []= $projection->ideal_weight_below;
            }
            // if($projection->real_weight == null){
            //     $real_weight []= " ";
            //     }else{
            //    $real_weight []= $projection->real_weight;
            // }


        }
        // $weight_standard = substr($weight_standard, -1);

        return Chartisan::build()
            ->labels([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36])
            ->dataset('weight_standard ', $weight_standard)
            ->dataset('real_weight', $real_weight)
            ->dataset('ideal_weight_above', $ideal_weight_above)
            ->dataset('ideal_weight_below', $ideal_weight_below);
    }
}
