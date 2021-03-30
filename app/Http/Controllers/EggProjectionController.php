<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectionRequest;
use App\Models\Egg;
use App\Models\EggProjection;
use Carbon\Carbon;

class EggProjectionController extends Controller
{
    public function createProjectionEgg(Egg $egg)
    {
        $initial_data = $this->initialDataProjection($egg);

        $day = 0;
        $date = $egg->collection_date->subDays($egg->incubation_day)->addHour(10);
        $hour = '10:00';
        for ($i=0; $i < 73; $i++) {
            $day += 0.5;
            if($hour == '10:00'){
                $hour = '22:00';
            }else{
                $hour = '10:00';
            }
            $eggProjection = [
                'incubation_day' => $day,
                'incubation_date' => $date->addHour(12),
                'weight_standard' => $initial_data['starting_weight'] - ($egg->specie->weightlost_standard / 35) * $day,
                'ideal_weight_above' => $initial_data['starting_weight'] - ($egg->specie->weightlost_max / 35) * $day,
                'ideal_weight_below' => $initial_data['starting_weight'] - ($egg->specie->weightlost_min / 35) * $day,
                'egg_id' => $egg->id,
                'user_id' => auth()->user()->id,
            ];
            EggProjection::create($eggProjection);

        }
        return $initial_data;
    }

    public function updateProjections(Egg $egg)
    {
        $projections = EggProjection::where('egg_id', $egg->id)->get();
        $initial_data = $this->initialDataProjection($egg);

        foreach ($projections as $projection) {

            $day = $projection->incubation_day;
            if(substr($day, -2, 2) == .5){
                $hour = '22';
            }else{
                $hour = '10';
            }
            $eggProjection = [
                'incubation_day' => $day,
                'incubation_date' => $egg->collection_date->subDays($egg->incubation_day)->addDays($day)->addHour($hour),
                'weight_standard' => $initial_data['starting_weight'] - ($egg->specie->weightlost_standard / 35) * $day,
                'ideal_weight_above' => $initial_data['starting_weight'] - ($egg->specie->weightlost_max / 35) * $day,
                'ideal_weight_below' => $initial_data['starting_weight'] - ($egg->specie->weightlost_min / 35) * $day,
                'egg_id' => $egg->id,
                'user_id' => auth()->user()->id,
            ];
            $projection->update($eggProjection);
        }
        return $initial_data;
    }

    private function initialDataProjection(Egg $egg)
    {
        $starting_date = $egg->collection_date->subDays($egg->incubation_day);
        $starting_weight = $egg->weight + (($egg->specie->weightlost_standard / 35) * $egg->incubation_day);
        $weight_pic = $starting_weight - ($starting_weight * ($egg->specie->weightlost_standard / 100));
        $pic_date = $egg->collection_date->subDays($egg->incubation_day)->addDays(29);
        $initial_data = [
            'starting_weight' => $starting_weight,
            'starting_date' => $starting_date,
            'weight_pic' => $weight_pic,
            'pic_date' => $pic_date
        ];

        return $initial_data;
    }

    public function addWeight(Egg $egg, EggProjection $projection)
    {
        // return redirect()->route('projection.update', ['egg' => $egg, 'projection' => $projection]);
        return view('eggs.addweight')->with([
            'egg' => $egg,
            'projection' => $projection
        ]);
    }

    public function update(Egg $egg, EggProjection $projection, UpdateProjectionRequest $request)
    {
        $projection->real_weight = $request->real_weight;
        $projection->save();

        if($egg->real_pic_date == $projection->incubation_date && !$request->pic_date){
            $egg->real_pic_date = null;
        }elseif($request->pic_date){
            $egg->real_pic_date = $projection->incubation_date;
        }

        if($egg->misbirth == $projection->incubation_date && !$request->misbirth){
            $egg->misbirth = null;
        }elseif($request->misbirth){
            $egg->misbirth = $projection->incubation_date;
        }

        if($egg->birth == $projection->incubation_date && !$request->birth){
            $egg->birth = null;
        }elseif($request->birth){
            $egg->birth = $projection->incubation_date;
        }
        $egg->save();

        return redirect()->route('eggs.show', ['egg' => $egg])->with([
            'projection' => EggProjection::where('egg_id', $egg->id)->get(),
            'today' => Carbon::now()
        ]);
    }

    public function states(Egg $egg, EggProjection $projection)
    {
        if($egg->misbirth || $egg->birth){

            if($projection->incubation_date == $egg->birth){
                $state = 'Nacido';
                $class = 'bg-green-200 text-green-600';
            }elseif($projection->incubation_date == $egg->misbirth  && $projection->incubation_date != $egg->real_pic_date){
                $state = 'Abortado';
                $class = 'bg-red-200 text-red-600';
            }elseif($projection->incubation_date == $egg->real_pic_date){
                $state = 'Pic';
                $class = 'bg-blue-200 text-blue-600';
            }elseif(($projection->incubation_date < $egg->collection_date && $projection->incubation_date < $egg->misbirth && $projection->incubation_date != $egg->real_pic_date)
                || ($projection->incubation_date < $egg->collection_date && $projection->incubation_date < $egg->birth && $projection->incubation_date != $egg->real_pic_date) ){
                $state = 'En nido';
                $class = 'bg-gray-200 text-gray-600';
            }elseif (($projection->incubation_date < Carbon::now() && $projection->incubation_date < $egg->misbirth && $projection->incubation_date != $egg->real_pic_date)
                || ($projection->incubation_date < Carbon::now() && $projection->incubation_date < $egg->birth && $projection->incubation_date != $egg->real_pic_date)){
                $state = 'Incubando';
                $class = 'bg-yellow-200 text-yellow-600';
            }else{
                $state = '';
                $class = '';
            }
        }else{
            if($projection->incubation_date == $egg->birth){
                $state = 'Nacido';
                $class = 'bg-green-200 text-green-600';
            }elseif($projection->incubation_date == $egg->real_pic_date){
                $state = 'Pic';
                $class = 'bg-blue-200 text-blue-600';
            }elseif($projection->incubation_date < $egg->collection_date  && $projection->incubation_date != $egg->real_pic_date){
                $state = 'En nido';
                $class = 'bg-gray-200 text-gray-600';
            }elseif ($projection->incubation_date < Carbon::now()  && $projection->incubation_date != $egg->real_pic_date){
                $state = 'Incubando';
                $class = 'bg-yellow-200 text-yellow-600';
            }else{
                $state = '';
                $class = '';
            }
        }

        return [
            'state' => $state,
            'class' => $class,
        ];
    }

}
