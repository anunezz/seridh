<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CarouselImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carousel = [
            ['id' => 1, 'fileName' => 'seridhh.png', 'fileNameHash' => 'seridhh.png', 'isActive' => 1,'link'=>'', 'type' => 1,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'fileName' => 'seridh3.png', 'fileNameHash' => 'seridh3.png', 'isActive' => 1,'link'=>'','type' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('carousel_images')->insert($carousel);
    }
}
