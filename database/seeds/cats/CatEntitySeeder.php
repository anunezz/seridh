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
                'name' => 'Comité contra la Tortura',
                'acronym' => 'CAT',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Comité contra las Desapariciones Forzadas',
                'acronym' => 'CED',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'Comité para la Eliminación de la Discriminación Racial',
                'acronym' => 'CEDAW',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'name' => 'Comité para la Protección de los Derechos de todos los Trabajadores Migratorios y de sus Familiares',
                'acronym' => 'CERD',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'name' => 'Comité de Derechos Económicos, Sociales y Culturales',
                'acronym' => 'CDESC',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);}

}
