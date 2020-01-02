<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CatLevelAttentionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levelAttentions = [
            ['id' => 1, 'name' => 'Atendida', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'No atendida', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'En proceso de atención', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('cat_level_attentions')->insert($levelAttentions);
    }
}
