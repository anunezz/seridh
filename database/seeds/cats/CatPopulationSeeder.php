<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CatPopulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $population = [
            ['id' =>1, 'name' => 'Mujeres', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>2, 'name' => 'Niñas, niños y adolescentes', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>3, 'name' => 'Peritos médicos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>4, 'name' => 'Personas adultas mayores', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>5, 'name' => 'Personas afrodescendientes', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>6, 'name' => 'Personas con discapacidad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>7, 'name' => 'Personas defensoras de derechos humanos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>8, 'name' => 'Personas defensoras del medio ambiente', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>9, 'name' => 'Personas desplazadas internas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>10, 'name' => 'Personas en centros de detención', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>11, 'name' => 'Personas en general', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>12, 'name' => 'Personas extranjeras', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>13, 'name' => 'Personas indígenas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>14, 'name' => 'Personas integrantes de las Fuerzas Armadas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>15, 'name' => 'Personas LGBTTTIQ+', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>16, 'name' => 'Personas migrantes', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>17, 'name' => 'Personas periodistas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>18, 'name' => 'Personas privadas de la libertad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>19, 'name' => 'Personas servidoras públicas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>20, 'name' => 'Personas solicitantes de la condición de asilo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>21, 'name' => 'Personas solicitantes de la condición de refugiado', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>22, 'name' => 'Personas trabajadoras domésticas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>23, 'name' => 'Personas trabajadoras migrantes', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>24, 'name' => 'Personas víctimas de desaparición forzada', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>25, 'name' => 'Personas víctimas de tortura', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>26, 'name' => 'Personas víctimas de violaciones a los derechos humanos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('cat_populations')->insert($population);
    }
}
