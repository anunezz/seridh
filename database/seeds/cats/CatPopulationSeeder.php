<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CatPopulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_populations')->insert([
            [
                'id' => 1,
                'name' => 'Niñas, Niños y Adolescentes',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Mujeres',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'Indigenas',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
