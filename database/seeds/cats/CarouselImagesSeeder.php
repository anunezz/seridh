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
            ['id' => 1, 'fileName' => 'seridhh.png', 'fileNameHash' => 'seridhh.png', 'isActive' => 1,'link'=>'','text'=>'', 'type' => 1,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'fileName' => 'seridh3.png', 'fileNameHash' => 'seridh3.png', 'isActive' => 1,'link'=>'','text'=>'','type' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'fileName' => 'subsecretaria.jpg', 'fileNameHash' => 'subsecretaria.jpg', 'isActive' => 1,'link'=>'','text'=>'','type' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'fileName' => 'dgdh.jpg', 'fileNameHash' => 'dgdh.jpg', 'isActive' => 1,'link'=>'','text'=>'','type' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'fileName' => 'logo-onu.png', 'fileNameHash' => 'logo-onu.png', 'isActive' => 1,'link'=>'https://www.un.org/es','text'=>"Lorem ipsum dolor sit amet, consectetur adipisicing elit.",'type' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('carousel_images')->insert($carousel);
    }
}
