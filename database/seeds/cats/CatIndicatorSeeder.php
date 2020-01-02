<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CatIndicatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $indicators = [
            ['id' => 1, 'name' => 'Indicador estructural', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'Indicador de proceso', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'Indicador de Resultados', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('cat_indicators')->insert($indicators );
    }
}
