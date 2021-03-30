<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Specie;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $users = User::factory(10)->create();
        $fields = [
            [
                'specie_name' => 'FALCO PEREGRINUS',
                'weightlost_standard' => 16,
                'weightlost_min' => 15,
                'weightlost_max' => 18,
            ],
            [
                'specie_name' => 'FALCO CHERRUG',
                'weightlost_standard' => 16,
                'weightlost_min' => 14,
                'weightlost_max' => 18,
            ],
            [
                'specie_name' => 'FALCO RUSTICOLUS',
                'weightlost_standard' => 16,
                'weightlost_min' => 14,
                'weightlost_max' => 17,
            ],
            [
                'specie_name' => 'FALCO RUSTICOLUS X CHERRUG',
                'weightlost_standard' => 16,
                'weightlost_min' => 14,
                'weightlost_max' => 18,
            ],
            [
                'specie_name' => 'FALCO RUSTICOLUS X PEREGRINUS', 
                'weightlost_standard' => '16',
                'weightlost_min' => 14,
                'weightlost_max' => 18,
            ],
            [
                'specie_name' => 'FALCO MEXICANUS',
                'weightlost_standard' => '16',
                'weightlost_min' => 15,
                'weightlost_max' => 19,
            ],
            [
                'specie_name' => 'FALCO BIARMICUS',
                'weightlost_standard' => '16',
                'weightlost_min' => 14,
                'weightlost_max' => 17,
            ],
        ];

        foreach($fields as $field){
           Specie::create($field); 
        }
        
        
    }
}
