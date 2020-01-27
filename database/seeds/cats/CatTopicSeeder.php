<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CatTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topics=[
            ['id' =>1, 'name' => 'Acceso a la justicia y debido proceso', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>2, 'name' => 'Democracia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>3, 'name' => 'Desaparición forzada', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>4, 'name' => 'Desarrollo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>5, 'name' => 'Detención arbitraria', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>6, 'name' => 'Educación', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>7, 'name' => 'Ejecuciones extrajudiciales', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>8, 'name' => 'Empresas y derechos humanos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>9, 'name' => 'Fuerzas Armadas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>10, 'name' => 'Justicia transicional', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>11, 'name' => 'Libertad de expresión y asociación', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>12, 'name' => 'Medio ambiente y recursos naturales', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>13, 'name' => 'Mujeres', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>14, 'name' => 'Niñas, niños y adolescentes', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>15, 'name' => 'No discriminación', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>16, 'name' => 'Personas adultas mayores', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>17, 'name' => 'Personas afrodescendientes', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>18, 'name' => 'Personas con discapacidad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>19, 'name' => 'Personas defensoras de derechos humanos y personas periodistas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>20, 'name' => 'Personas desplazadas internas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>21, 'name' => 'Personas LGBTTTIQ+', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>22, 'name' => 'Personas migrantes, refugiadas y solicitantes de asilo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>23, 'name' => 'Personas víctimas de violaciones de derechos humanos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>24, 'name' => 'Personas y pueblos indígenas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>25, 'name' => 'Pobreza', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>26, 'name' => 'Salud', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>27, 'name' => 'Seguimiento de recomendaciones internacionales', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>28, 'name' => 'Seguridad y protección ciudadana', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>29, 'name' => 'Tortura, tratos crueles, inhumanos y/o degradantes', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>30, 'name' => 'Trabajo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>31, 'name' => 'Tráfico ilícito de personas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>32, 'name' => 'Trata de personas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' =>33, 'name' => 'Vivienda', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('cat_topics')->insert($topics);
    }
}
