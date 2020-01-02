<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CatSubRightsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Subrights = [
            ['id' => 1, 'rights_recommendations_id' => 1, 'name' => 'Derecho a la vida', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'rights_recommendations_id' => 1, 'name' => 'Derecho a la integridad personal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'rights_recommendations_id' => 1, 'name' => 'Derecho a la libertad y seguridad personal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'rights_recommendations_id' => 1, 'name' => 'Derecho al debido proceso legal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'rights_recommendations_id' => 1, 'name' => 'Derechos políticos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'rights_recommendations_id' => 1, 'name' => 'Derecho a la libertad de opinión y expresión', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'rights_recommendations_id' => 1, 'name' => 'Derecho al acceso a la información', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'rights_recommendations_id' => 1, 'name' => 'Derecho a la libertad de pensamiento, conciencia y religión', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 9, 'rights_recommendations_id' => 1, 'name' => 'Derecho a la libertad de asociación y reunión pacífica', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 10, 'rights_recommendations_id' => 1, 'name' => 'Derecho a la protesta social pacífica', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 11, 'rights_recommendations_id' => 1, 'name' => 'Derecho a la libertad de circulación y residencia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 12, 'rights_recommendations_id' => 1, 'name' => 'Derecho a la protección del honor, honra y reputación', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 13, 'rights_recommendations_id' => 1, 'name' => 'Derecho a la vida privada y la privacidad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 14, 'rights_recommendations_id' => 1, 'name' => 'Derechos al matrimonio y la familia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 15, 'rights_recommendations_id' => 1, 'name' => 'Derecho a la protección de la propiedad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 16, 'rights_recommendations_id' => 1, 'name' => 'Derecho a la igualdad y no discriminación', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 17, 'rights_recommendations_id' => 1, 'name' => 'Derecho a no ser sometido/a a esclavitud', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 18, 'rights_recommendations_id' => 1, 'name' => 'Derecho a no ser sometido/a a servidumbre', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 19, 'rights_recommendations_id' => 1, 'name' => 'Derecho a no ser sometido/a a trabajos forzados u obligatorios', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 20, 'rights_recommendations_id' => 1, 'name' => 'Derecho a no ser objeto de tráfico ilícito de personas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 21, 'rights_recommendations_id' => 1, 'name' => 'Derecho a no ser objeto de trata de personas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 22, 'rights_recommendations_id' => 1, 'name' => 'Derecho a la personalidad jurídica', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 23, 'rights_recommendations_id' => 1, 'name' => 'Derecho a la nacionalidad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['id' => 24, 'rights_recommendations_id' => 2, 'name' => 'Derecho a un nivel de vida adecuado', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 25, 'rights_recommendations_id' => 2, 'name' => 'Derecho al trabajo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 26, 'rights_recommendations_id' => 2, 'name' => 'Derecho a condiciones de trabajo equitativas y satisfactorias', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 27, 'rights_recommendations_id' => 2, 'name' => 'Derechos sindicales', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 28, 'rights_recommendations_id' => 2, 'name' => 'Derecho a la seguridad social', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 29, 'rights_recommendations_id' => 2, 'name' => 'Derecho a la educación de calidad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 30, 'rights_recommendations_id' => 2, 'name' => 'Derecho a la salud', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 31, 'rights_recommendations_id' => 2, 'name' => 'Derecho a la vivienda adecuada', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 32, 'rights_recommendations_id' => 2, 'name' => 'Derecho a la alimentación adecuada', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 33, 'rights_recommendations_id' => 2, 'name' => 'Derecho al agua potable y saneamiento', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 34, 'rights_recommendations_id' => 2, 'name' => 'Derecho a un medio ambiente sano, adecuado y saludable', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 35, 'rights_recommendations_id' => 2, 'name' => 'Derecho a participar en la vida cultural y a beneficiarse con el avance de la ciencia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['id' => 36, 'rights_recommendations_id' => 3, 'name' => 'Derechos de niñas, niños y adolescentes', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 37, 'rights_recommendations_id' => 3, 'name' => 'Derechos de las mujeres', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 38, 'rights_recommendations_id' => 3, 'name' => 'Derechos de las personas migrantes', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 39, 'rights_recommendations_id' => 3, 'name' => 'Derechos de las personas extranjeras', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 40, 'rights_recommendations_id' => 3, 'name' => 'Derechos de los pueblos indígenas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 41, 'rights_recommendations_id' => 3, 'name' => 'Derechos de las personas privadas de la libertad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 42, 'rights_recommendations_id' => 3, 'name' => 'Derechos de las personas con discapacidad', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 43, 'rights_recommendations_id' => 3, 'name' => 'Derechos de las personas adultas mayores', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 44, 'rights_recommendations_id' => 3, 'name' => 'Derechos de las personas víctimas de violaciones de los derechos humanos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 45, 'rights_recommendations_id' => 3, 'name' => 'Derechos de las personas defensoras de derechos humanos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 46, 'rights_recommendations_id' => 3, 'name' => 'Derechos de las personas periodistas ', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 47, 'rights_recommendations_id' => 3, 'name' => 'Derechos de las personas LGBTTTIQ+', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 48, 'rights_recommendations_id' => 3, 'name' => 'Derechos de las personas afrodescendientes', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 49, 'rights_recommendations_id' => 3, 'name' => 'Derechos de las personas desplazadas internas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('cat_sub_rights')->insert($Subrights);
    }
}
