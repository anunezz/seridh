<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'App\\Console\\Kernel' => $baseDir . '/app/Console/Kernel.php',
    'App\\DataModel' => $baseDir . '/app/DataModel.php',
    'App\\Exceptions\\Handler' => $baseDir . '/app/Exceptions/Handler.php',
    'App\\Exports\\RecommendationExport' => $baseDir . '/app/Exports/RecommendationExport.php',
    'App\\Http\\Controllers\\ChangeLanguageController' => $baseDir . '/app/Http/Controllers/ChangeLanguageController.php',
    'App\\Http\\Controllers\\Controller' => $baseDir . '/app/Http/Controllers/Controller.php',
    'App\\Http\\Controllers\\GeneralController' => $baseDir . '/app/Http/Controllers/GeneralController.php',
    'App\\Http\\Controllers\\LangController' => $baseDir . '/app/Http/Controllers/LangController.php',
    'App\\Http\\Controllers\\LanguageController' => $baseDir . '/app/Http/Controllers/LanguageController.php',
    'App\\Http\\Controllers\\LoginController' => $baseDir . '/app/Http/Controllers/LoginController.php',
    'App\\Http\\Controllers\\PublicController' => $baseDir . '/app/Http/Controllers/PublicController.php',
    'App\\Http\\Controllers\\RecommendationsController' => $baseDir . '/app/Http/Controllers/RecommendationsController.php',
    'App\\Http\\Controllers\\TransactionsController' => $baseDir . '/app/Http/Controllers/TransactionsController.php',
    'App\\Http\\Kernel' => $baseDir . '/app/Http/Kernel.php',
    'App\\Http\\Middleware\\Authenticate' => $baseDir . '/app/Http/Middleware/Authenticate.php',
    'App\\Http\\Middleware\\CheckForMaintenanceMode' => $baseDir . '/app/Http/Middleware/CheckForMaintenanceMode.php',
    'App\\Http\\Middleware\\EncryptCookies' => $baseDir . '/app/Http/Middleware/EncryptCookies.php',
    'App\\Http\\Middleware\\RedirectIfAuthenticated' => $baseDir . '/app/Http/Middleware/RedirectIfAuthenticated.php',
    'App\\Http\\Middleware\\TrimStrings' => $baseDir . '/app/Http/Middleware/TrimStrings.php',
    'App\\Http\\Middleware\\TrustProxies' => $baseDir . '/app/Http/Middleware/TrustProxies.php',
    'App\\Http\\Middleware\\VerifyCsrfToken' => $baseDir . '/app/Http/Middleware/VerifyCsrfToken.php',
    'App\\Http\\Models\\Cats\\CatAttending' => $baseDir . '/app/Http/Models/Cats/CatAttending.php',
    'App\\Http\\Models\\Cats\\CatDate' => $baseDir . '/app/Http/Models/Cats/CatDate.php',
    'App\\Http\\Models\\Cats\\CatEntity' => $baseDir . '/app/Http/Models/Cats/CatEntity.php',
    'App\\Http\\Models\\Cats\\CatGobOrder' => $baseDir . '/app/Http/Models/Cats/CatGobOrder.php',
    'App\\Http\\Models\\Cats\\CatGobPower' => $baseDir . '/app/Http/Models/Cats/CatGobPower.php',
    'App\\Http\\Models\\Cats\\CatLanguage' => $baseDir . '/app/Http/Models/Cats/CatLanguage.php',
    'App\\Http\\Models\\Cats\\CatOds' => $baseDir . '/app/Http/Models/Cats/CatOds.php',
    'App\\Http\\Models\\Cats\\CatPopulation' => $baseDir . '/app/Http/Models/Cats/CatPopulation.php',
    'App\\Http\\Models\\Cats\\CatProfile' => $baseDir . '/app/Http/Models/Cats/CatProfile.php',
    'App\\Http\\Models\\Cats\\CatRightsRecommendation' => $baseDir . '/app/Http/Models/Cats/CatRightsRecommendation.php',
    'App\\Http\\Models\\Cats\\CatSolidarityAction' => $baseDir . '/app/Http/Models/Cats/CatSolidarityAction.php',
    'App\\Http\\Models\\Cats\\CatSubRights' => $baseDir . '/app/Http/Models/Cats/CatSubRights.php',
    'App\\Http\\Models\\Cats\\CatSubcategorySubrights' => $baseDir . '/app/Http/Models/Cats/CatSubcategorySubrights.php',
    'App\\Http\\Models\\Cats\\CatSubtopic' => $baseDir . '/app/Http/Models/Cats/CatSubtopic.php',
    'App\\Http\\Models\\Cats\\CatTopic' => $baseDir . '/app/Http/Models/Cats/CatTopic.php',
    'App\\Http\\Models\\Cats\\CatTransactionType' => $baseDir . '/app/Http/Models/Cats/CatTransactionType.php',
    'App\\Http\\Models\\Document' => $baseDir . '/app/Http/Models/Document.php',
    'App\\Http\\Models\\PublicRecommendation' => $baseDir . '/app/Http/Models/PulicRecommendation.php',
    'App\\Http\\Models\\Recommendation' => $baseDir . '/app/Http/Models/Recommendation.php',
    'App\\Http\\Models\\Transaction' => $baseDir . '/app/Http/Models/Transaction.php',
    'App\\Http\\Models\\Visits' => $baseDir . '/app/Http/Models/Visits.php',
    'App\\Http\\Traits\\RightsTrait' => $baseDir . '/app/Http/Traits/RightsTrait.php',
    'App\\Http\\Traits\\TopicsTrait' => $baseDir . '/app/Http/Traits/TopicsTrait.php',
    'App\\Imports\\FirstSheetImport' => $baseDir . '/app/Imports/FirstSheetImport.php',
    'App\\Imports\\RecommendationsImport' => $baseDir . '/app/Imports/RecommendationsImport.php',
    'App\\Providers\\AppServiceProvider' => $baseDir . '/app/Providers/AppServiceProvider.php',
    'App\\Providers\\AuthServiceProvider' => $baseDir . '/app/Providers/AuthServiceProvider.php',
    'App\\Providers\\BroadcastServiceProvider' => $baseDir . '/app/Providers/BroadcastServiceProvider.php',
    'App\\Providers\\EventServiceProvider' => $baseDir . '/app/Providers/EventServiceProvider.php',
    'App\\Providers\\RouteServiceProvider' => $baseDir . '/app/Providers/RouteServiceProvider.php',
    'App\\User' => $baseDir . '/app/User.php',
    'CatAttendingSeeder' => $baseDir . '/database/seeds/cats/CatAttendingSeeder.php',
    'CatDateSeeder' => $baseDir . '/database/seeds/cats/CatDateSeeder.php',
    'CatEntitySeeder' => $baseDir . '/database/seeds/cats/CatEntitySeeder.php',
    'CatGobOrderSeeder' => $baseDir . '/database/seeds/cats/CatGobOrderSeeder.php',
    'CatGobPowerSeeder' => $baseDir . '/database/seeds/cats/CatGobPowerSeeder.php',
    'CatLanguageSeeder' => $baseDir . '/database/seeds/cats/CatLanguageSeeder.php',
    'CatOdsSeeder' => $baseDir . '/database/seeds/cats/CatOdsSeeder.php',
    'CatPopulationSeeder' => $baseDir . '/database/seeds/cats/CatPopulationSeeder.php',
    'CatProfileSeeder' => $baseDir . '/database/seeds/cats/CatProfileSeeder.php',
    'CatRightRecommendationSeeder' => $baseDir . '/database/seeds/cats/CatRightRecommendationSeeder.php',
    'CatSolidarityActionSeeder' => $baseDir . '/database/seeds/cats/CatSolidarityActionSeeder.php',
    'CatSubCategorySubRightsTableSeeder' => $baseDir . '/database/seeds/cats/CatSubCategorySubRightsTableSeeder.php',
    'CatSubRightsTableSeeder' => $baseDir . '/database/seeds/cats/CatSubRightsTableSeeder.php',
    'CatSubtopicSeeder' => $baseDir . '/database/seeds/cats/CatSubtopicSeeder.php',
    'CatTopicSeeder' => $baseDir . '/database/seeds/cats/CatTopicSeeder.php',
    'CatTransactionTypeSeeder' => $baseDir . '/database/seeds/cats/CatTransactionTypeSeeder.php',
    'DatabaseSeeder' => $baseDir . '/database/seeds/DatabaseSeeder.php',
    'Tests\\Bootstrap' => $baseDir . '/tests/Bootstrap.php',
    'Tests\\CreatesApplication' => $baseDir . '/tests/CreatesApplication.php',
    'Tests\\Feature\\ExampleTest' => $baseDir . '/tests/Feature/ExampleTest.php',
    'Tests\\TestCase' => $baseDir . '/tests/TestCase.php',
    'Tests\\Unit\\ExampleTest' => $baseDir . '/tests/Unit/ExampleTest.php',
    'UsersTableSeeder' => $baseDir . '/database/seeds/UsersTableSeeder.php',
    'VisitsSeeder' => $baseDir . '/database/seeds/VisitsSeeder.php',
);
