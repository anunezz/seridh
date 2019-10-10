<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CatAttendingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_attendings')->insert([
            [
                'id' => 1,
                'name' => 'Secretaría de Relaciones Exteriores',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Secretaría de Gobernación',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'Secretaría del Trabajo y Previsión Social',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
