<?php
Route::group(['middleware' => ['auth:api']], function () {
    Route::resource('recommendations', 'RecommendationsController');
    Route::post('recommendations/upload/file', 'RecommendationsController@uploadFile');
    Route::get('recommendations/get/file/{id}', 'RecommendationsController@getFile');
    Route::get('recommendations/remove/file/{id}', 'RecommendationsController@disableFile');
    Route::post('recommendations/publish/register', 'RecommendationsController@publish');
});
Route::prefix('public')->group(function () {
    Route::get('recommendations/count', 'PublicSeridhController@count');
    Route::post('visits', 'PublicSeridhController@visits');
    Route::get('recommendations/labelsForm', 'PublicSeridhController@labelsForm');
    Route::post('recommendationFilter', 'PublicSeridhController@recommendationFilter');
});
