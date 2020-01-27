<?php

use Illuminate\Database\Seeder;

class CatLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_languages')->insert(
            array(

                array(
                    'acronym'               => 'es',
                    'description'           => 'Espanol',
                    'created_at'            => '2019-01-1 23:23:23',
                    'updated_at'            => '2019-01-01 23:23:23',
                    'deleted_at'            => NULL
                ),
                array(
                    'acronym'               => 'en',
                    'description'           => 'Ingles',
                    'created_at'            => '2019-01-01 23:23:23',
                    'updated_at'            => '2019-01-01 23:23:23',
                    'deleted_at'            => NULL
                ),


            ));
    }
}
