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
            ['id' => 1, 'name' => 'CIVILPOL', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'DESCA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'GRUPOS Y PERSONAS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ];

        DB::table('cat_rights_recommendations')->insert($RightsRecommendations);
    }
}
