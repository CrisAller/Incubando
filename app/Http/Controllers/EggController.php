<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Egg;
use App\Models\Specie;
use Illuminate\Http\Request;
use App\Models\EggProjection;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreEggRequest;
use App\Http\Requests\UpdateEggRequest;
use App\Http\Controllers\EggProjectionController;

class EggController extends Controller
{
    public function index()
    {
        return view('eggs.index')->with([
             'eggs' => Egg::all(),
             'eggController' => new EggController(),
            ]);
    }

    public function create()
    {
        return view('eggs.create')->with([
            'company' => auth()->user()->company,
            'species' => DB::table('species')->get(),
        ]);
    }

    public function store(StoreEggRequest $request)
    {
        $egg = Egg::where('id', 3)->with('specie')->first();
        $fields = $request->validated();
        $egg = Egg::create($fields);
        $projection = new EggProjectionController();
        $pic = $projection->createProjectionEgg($egg);
        $egg->update($pic);

        $projection = EggProjection::where('incubation_day', $egg->incubation_day)->where('egg_id', $egg->id)->first();
        $projection->update([
            'real_weight' => $fields['weight']
        ]);

        $egg = Egg::where('id', $egg->id)->with('specie')->first();
        $projections = EggProjection::where('egg_id', $egg->id)->get();

        return redirect()->route("eggs.show", ['egg' => $egg])->with([
            'projections' => $projections,
            'today' => Carbon::now()
        ]);
    }

    public function show(Egg $egg)
    {
       $data_chart = $this->dataChart($egg);

        return view('eggs.show')->with([
            'egg' => Egg::where('id', $egg->id)->with('specie')->first(),
            'projections' => EggProjection::where('egg_id', $egg->id)->orderBy('incubation_day')->get(),
            'real_weight' =>$data_chart['real_weight'],
            'ideal_weight_above' =>$data_chart['ideal_weight_above'],
            'ideal_weight_below' =>$data_chart['ideal_weight_below'],
            'misbirth' =>$data_chart['misbirth'],
            'real_pic_date' =>$data_chart['real_pic_date'],
            'birth' => $data_chart['birth'],
            'projection_controller' => new EggProjectionController(),
        ]);
    }

    private function dataChart(Egg $egg)
    {
        $data = EggProjection::where('egg_id', $egg->id)->orderBy('incubation_day')->get();
        $real_weight = [];
        $ideal_weight_above = [];
        $ideal_weight_below = [];
        $misbirth = [];
        $real_pic_date = [];
        $birth = [];
        foreach($data as $key => $projection){
            if($key%2 != 0){
                $ideal_weight_above []= $projection->ideal_weight_above;
                $ideal_weight_below []= $projection->ideal_weight_below;
                if($projection->real_weight == null){
                    $real_weight []= ",";
                }else{
                    $real_weight []= $projection->real_weight;
                }

                if($egg->misbirth != $projection->incubation_date){
                    $misbirth[] = ",";
                }else{
                    $misbirth[] = $egg->starting_weight;
                }

                if($egg->real_pic_date != $projection->incubation_date){
                    $real_pic_date[] = ",";
                }else{
                    $real_pic_date[] = $egg->starting_weight;
                }

                if($egg->birth != $projection->incubation_date){
                    $birth[] = ",";
                }else{
                    $birth[] = $egg->starting_weight;
                }

            }else{
                if($projection->real_weight != null){
                    $last_position = count($real_weight) - 1;
                    $real_weight [$last_position]= $projection->real_weight;
                }
                if($egg->misbirth == $projection->incubation_date){
                    $last_position = count($misbirth) -1;
                    $misbirth[$last_position] = $egg->starting_weight;
                }
                if($egg->real_pic_date == $projection->incubation_date){
                    $last_position = count($real_pic_date) -1;
                    $real_pic_date[$last_position] = $egg->starting_weight;
                }
                if($egg->birth == $projection->incubation_date){
                    $last_position = count($birth) -1;
                    $birth[$last_position] = $egg->starting_weight;
                }
            }

        }
       $data_chart = [
            'real_weight' => json_encode($real_weight),
            'ideal_weight_above' => json_encode($ideal_weight_above),
            'ideal_weight_below' => json_encode($ideal_weight_below),
            'misbirth' => json_encode($misbirth),
            'real_pic_date' => json_encode($real_pic_date),
            'birth' => json_encode($birth),
        ];

        return$data_chart;
    }

        public function edit(Egg $egg)
    {
        return view('eggs.edit')->with([
            'egg' => $egg,
            'species' => DB::table('species')->get(),
        ]);
    }

    public function update(Egg $egg, UpdateEggRequest $request)
    {
        $fields = $request->validated();

        $egg->update($fields);

        $projection = new EggProjectionController();
        $pic = $projection->updateProjections($egg);

        $egg->update($pic);

        return redirect()->route('eggs.show', ['egg' => $egg]);
    }

    public function delete(Egg $egg)
    {
        $projections = EggProjection::where('egg_id', $egg->id)->get();
        foreach($projections as $projection){
            $projection->delete();
        }
        $egg->delete();
        return redirect()->route('eggs.index');
    }

    public function states(Egg $egg)
    {
        if($egg->misbirth){
            $state = 'Abortado';
            $class = 'bg-red-200 text-red-600';
        }elseif($egg->birth){
            $state = 'Nacido';
            $class = 'bg-green-200 text-green-600';
        }else{
            $state = 'Incubando';
            $class = 'bg-yellow-200 text-yellow-600';
        }

        return [
            'state' => $state,
            'class' => $class,
        ];
    }

}
