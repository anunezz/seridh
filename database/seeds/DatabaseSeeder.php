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
            CatEntitySeeder::class,
            CatGobOrderSeeder::class,
            CatPopulationSeeder::class,
            CatSolidarityActionSeeder::class,
            CatOdsSeeder::class,
            CatGobPowerSeeder::class,
            CatAttendingSeeder::class,
            CatTopicSeeder::class,
            CatSubtopicSeeder::class,
            CatLanguageSeeder::class,
            CatDateSeeder::class,
            CatRightRecommendationSeeder::class,
            CatSubRightsTableSeeder::class,
            CatSubCategorySubRightsTableSeeder::class,
            CatIndicatorSeeder::class,
            CatLevelAttentionSeeder::class,
            CatAttentionclassificationSeeder::class,
            CatGoalsOdsSeeder::class,
            CarouselImagesSeeder::class,

            VisitsSeeder::class,
            PublicSeeder::class,
            UsersTableSeeder::class,
        ]);
    }
}
