<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CatProfileSeeder::class,
            CatTransactionTypeSeeder::class,
            CatIdeSeeder::class,
            CatEntitySeeder::class,
            CatGobOrderSeeder::class,
            CatRightRecommendationSeeder::class,
            CatPopulationSeeder::class,
            CatSolidarityActionSeeder::class,
            CatReviewRightsSeeder::class,
            CatReviewTopicSeeder::class,
            CatOdsSeeder::class,
            CatGobPowerSeeder::class,
            CatAttendingSeeder::class,
            CatSubtopicSeeder::class,
            CatLanguageSeeder::class,

            UsersTableSeeder::class,
        ]);
    }
}
