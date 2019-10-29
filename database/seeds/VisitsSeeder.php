<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VisitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('visits')->insert([
                [
                    'id' => 1,
                    'page' => 'publico',
                    'visits' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => 2,
                    'page' => 'recommendations',
                    'visits' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            ]);

            $this->command->info("La tabla visits fue creada exitosamente...");
    }
}
