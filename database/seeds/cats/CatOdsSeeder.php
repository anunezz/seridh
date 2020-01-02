<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CatOdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ods = [
            ['id' =>1, 'name' => 'Objetivo 1: Poner fin a la pobreza en todas sus formas en todo el mundo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>2, 'name' => 'Objetivo 2: Poner fin al hambre, lograr la seguridad alimentaria y la mejora de la nutrición y promover la agricultura sostenible', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>3, 'name' => 'Objetivo 3: Garantizar una vida sana y promover el bienestar para todos en todas las edades', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>4, 'name' => 'Objetivo 4: Garantizar una educación inclusiva, equitativa y de calidad y promover oportunidades de aprendizaje durante toda la vida para todos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>5, 'name' => 'Objetivo 5: Lograr la igualdad entre los géneros y empoderar a todas las mujeres y las niñas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>6, 'name' => 'Objetivo 6: Garantizar la disponibilidad de agua y su gestión sostenible y el saneamiento para todos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>7, 'name' => 'Objetivo 7: Garantizar el acceso a una energía asequible, segura, sostenible y moderna para todos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>8, 'name' => 'Objetivo 8: Promover el crecimiento económico sostenido, inclusivo y sostenible, el empleo pleno y productivo y el trabajo decente para todos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>9, 'name' => 'Objetivo 9: Industria, innovación e infrestructura', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>10, 'name' => 'Objetivo 10: Reducir la desigualdad en y entre los países', 'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['id' =>11, 'name' => 'Objetivo 11: Lograr que las ciudades y los asentamientos humanos sean inclusivos, seguros, resilientes y sostenibles', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>12, 'name' => 'Objetivo 12: Garantizar modalidades de consumo y producción sostenibles', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>13, 'name' => 'Objetivo 13: Adoptar medidas urgentes para combatir el cambio climático y sus efectos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>14, 'name' => 'Objetivo 14: Conservar y utilizar en forma sostenible los océanos, los mares y los recursos marinos para el desarrollo sostenible', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>15, 'name' => 'Objetivo 15: Gestionar sosteniblemente los bosques, luchar contra la desertificación, detener e invertir la degradación de las tierras y detener la pérdida de biodiversidad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>16, 'name' => 'Objetivo 16: Promover sociedades, justas, pacíficas e inclusivas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>17, 'name' => 'Objetivo 17: Revitalizar la Alianza Mundial para el Desarrollo Sostenible', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('cat_ods')->insert($ods);
    }
}
