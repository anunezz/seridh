<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Http\Models\Cats\CatRightsRecommendation;
use App\Http\Models\Cats\CatSubRights;

class CatRightRecommendationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $RightsRecommendations = [
            ['id' => 1, 'name' => 'Derechos Civiles y Políticos (genérico)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'Derechos económicos, sociales, culturales y ambientales (genérico)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'Derechos de Grupos y Personas Específicas (génerico)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ];

        DB::table('cat_rights_recommendations')->insert($RightsRecommendations);
    }
}
