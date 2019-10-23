<?php

Route::group(['middleware' => ['auth:api']], function () {
    Route::resource('recommendations', 'RecommendationsController');

    Route::post('recommendations/upload/file', 'RecommendationsController@uploadFile');
    Route::get('recommendations/get/file/{id}', 'RecommendationsController@getFile');
    Route::get('recommendations/remove/file/{id}', 'RecommendationsController@disableFile');
    Route::post('recommendations/publish/register', 'RecommendationsController@publish');
    Route::post('recommendations/upload/excel', 'RecommendationsController@readExcel');
});
