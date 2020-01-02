<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CatAttentionclassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attentionClassifications = [
            ['id' => 1, 'level_attentions_id' => 2, 'name' => 'No se cuenta con registro', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'level_attentions_id' => 2, 'name' => 'No existen condiciones para su atención', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'level_attentions_id' => 2, 'name' => 'No se han hecho acciones', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'level_attentions_id' => 2, 'name' => 'Otra', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'level_attentions_id' => 2, 'name' => 'No aplica', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['id' => 6, 'level_attentions_id' => 3, 'name' => 'Atención parcial', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'level_attentions_id' => 3, 'name' => 'Atención continua', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'level_attentions_id' => 3, 'name' => 'No aplica', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('cat_attention_classifications')->insert($attentionClassifications);
    }
}
