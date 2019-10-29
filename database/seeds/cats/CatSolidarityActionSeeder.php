<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CatSolidarityActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_solidarity_actions')->insert([
            [
                'id' => 1,
                'name' => 'Acciones en conjunto con la sociedad civil',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Acciones judiciales',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'Acciones legislativas',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'name' => 'Cooperacion internacional',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'name' => 'Educación, capacitación y/o sensibilización en derechos humano',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
