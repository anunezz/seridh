<?php
Route::group(['middleware' => ['auth:api']], function () {
    Route::resource('recommendations', 'RecommendationsController');
    Route::post('recommendations/upload/file', 'RecommendationsController@uploadFile');
    Route::get('recommendations/get/file/{id}', 'RecommendationsController@getFile');
    Route::get('recommendations/remove/file/{id}', 'RecommendationsController@disableFile');
    Route::post('recommendations/publish/register', 'RecommendationsController@publish');

    Route::post('recommendations/unpublish/register' ,'RecommendationsController@unpublish');
    Route::post('recommendations/upload/excel', 'RecommendationsController@readExcel');
});
Route::prefix('public')->group(function () {
    Route::get('recommendations/count', 'PublicController@count');
    Route::post('visits', 'PublicController@visits');
    Route::get('recommendations/labelsForm', 'PublicController@labelsForm');
    Route::post('recommendationFilter', 'PublicController@recommendationFilter');
    Route::get('listarPdf', 'PublicController@listPdf')->name('listar_pdf');
    Route::get('listarExcel', 'PublicController@listExcel');
    Route::get('listarWord', 'PublicController@listWord');
    Route::get('treeDerechosHumanos', 'PublicController@derechosHumanos');
    Route::post('detailsRecommendation', 'PublicController@detailsRecommendation');
});
