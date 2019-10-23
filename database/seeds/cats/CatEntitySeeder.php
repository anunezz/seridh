<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CatEntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_entities')->insert([
            [
                'id' => 1,
                'name' => 'A1.1 CAT- Comité contra la Tortura',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'A1.2 CED- Comité contra las Desapariciones Forzadas',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'A1.3 CEDAW- Comité para la Eliminación de la Discriminación Racial',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'name' => 'A1.4 CERD- Comité para la Protección de los Derechos de todos los Trabajadores Migratorios y de sus Familiares',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);}

}
