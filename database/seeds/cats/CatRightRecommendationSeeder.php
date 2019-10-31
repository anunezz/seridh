<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Http\Models\Cats\CatRightsRecommendation;
use App\Http\Models\Cats\CatSubRights;

class CatRightRecommendationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $RightsRecommendations = collect([
            ['id' => 1, 'name' => 'Derechos Civiles y Políticos (genérico)'],
            ['id' => 2, 'name' => 'Derechos económicos, sociales, culturales y ambientales (genérico)'],
            ['id' => 3, 'name' => 'Derechos de Grupos y Personas Específicas (génerico)']
        ]);
        $Subrights = collect([
            ['right_id' => 1, 'name' => 'Derecho a la vida'],
            ['right_id' => 1, 'name' => 'Derecho a la integridad personal'],
            ['right_id' => 1, 'name' => 'Derecho a la libertad y seguridad personal'],
            ['right_id' => 1, 'name' => 'Derecho al debido proceso legal'],
            ['right_id' => 1, 'name' => 'Derechos políticos'],
            ['right_id' => 1, 'name' => 'Derecho a la libertad de expresión y acceso a la información'],
            ['right_id' => 1, 'name' => 'Derecho a la libertad de pensamiento, conciencia y religión'],
            ['right_id' => 1, 'name' => 'Derecho a la libertad de asociación y reunión pacífica'],
            ['right_id' => 1, 'name' => 'Derecho a la libertad de circulación y residencia'],
            ['right_id' => 1, 'name' => 'Derecho a la protección del honor y la vida privada'],
            ['right_id' => 1, 'name' => 'Derechos al matrimonio y la familia'],
            ['right_id' => 1, 'name' => 'Derecho a la protección de la propiedad'],
            ['right_id' => 1, 'name' => 'Derecho a la igualdad y la no discriminación'],
            ['right_id' => 1, 'name' => 'Derecho a no ser sometido a esclavitud, servidumbre u otras formas de explotación'],
            ['right_id' => 1, 'name' => 'Derecho a la personalidad jurídica'],
            ['right_id' => 1, 'name' => 'Derecho a la nacionalidad'],
            ['right_id' => 1, 'name' => 'Derecho a la verdad'],

            ['right_id' => 2, 'name' => 'Derecho a un nivel de vida adecuado'],
            ['right_id' => 2, 'name' => 'Derecho al trabajo'],
            ['right_id' => 2, 'name' => 'Derecho a condiciones de trabajo equitativas y satisfactorias'],
            ['right_id' => 2, 'name' => 'Derechos sindicales'],
            ['right_id' => 2, 'name' => 'Derecho a la seguridad social'],
            ['right_id' => 2, 'name' => 'Derecho a la educación'],
            ['right_id' => 2, 'name' => 'Derecho a la salud'],
            ['right_id' => 2, 'name' => 'Derecho de acceso a los servicios públicos'],
            ['right_id' => 2, 'name' => 'Derecho a la vivienda adecuada'],
            ['right_id' => 2, 'name' => 'Derecho a la alimentación adecuada'],
            ['right_id' => 2, 'name' => 'Derecho al agua potable y saneamiento'],
            ['right_id' => 2, 'name' => 'Derecho a un medio ambiente sano'],
            ['right_id' => 2, 'name' => 'Derecho a participar en el desarrollo'],
            ['right_id' => 2, 'name' => 'Derecho al acceso a la cultura y a los beneficios del progreso científico'],

            ['right_id' => 3, 'name' => 'Derechos de niñas, niños y adolescentes'],
            ['right_id' => 3, 'name' => 'Derechos de las mujeres'],
            ['right_id' => 3, 'name' => 'Derechos de las personas migrantes'],
            ['right_id' => 3, 'name' => 'Derechos de las personas extranjeras'],
            ['right_id' => 3, 'name' => 'Derechos de los pueblos indígenas'],
            ['right_id' => 3, 'name' => 'Derechos de las personas privadas de su libertad'],
            ['right_id' => 3, 'name' => 'Derechos de las personas con discapacidad'],
            ['right_id' => 3, 'name' => 'Derechos de las personas adultas mayores'],
            ['right_id' => 3, 'name' => 'Derechos de las minorías'],
            ['right_id' => 3, 'name' => 'Derechos de las personas defensoras de derechos humanos'],
            ['right_id' => 3, 'name' => 'Derechos de las víctimas de violaciones a los derechos humanos'],
            ['right_id' => 3, 'name' => 'Derechos de las personas desplazadas internas'],
            ['right_id' => 3, 'name' => 'Derechos de las personas afrodescendientes'],
            ['right_id' => 3, 'name' => 'Derechos de los periodistas y comunicadores'],
            ['right_id' => 3, 'name' => 'Derechos de las personas LGBTTTIQ+'],
        ]);

        foreach ($RightsRecommendations as $rightsRecommendation){
            $right = new CatRightsRecommendation();
            $right->name = $rightsRecommendation['name'];
            $right->save();
            foreach ($Subrights as $subright){
                if ($rightsRecommendation['id']===$subright['right_id']){
                    $sub = new CatSubRights();
                    $sub->rights_recommendations_id = $right->id;
                    $sub->name = $subright['name'];
                    $sub->save();
                }
            }
        }
    }
}
