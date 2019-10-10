<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CatRightRecommendationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_rights_recommendations')->insert([
            [
                'id' => 1,
                'name' => 'Derechos Civiles y Políticos (genérico)',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Derecho a la vida',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'Derecho a no ser sometido a ejecuciones sumarias, extrajudiciales o arbitrarias',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
