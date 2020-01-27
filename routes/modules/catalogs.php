<?php

Route::group(['middleware' => ['auth:api']], function () {
    Route::resource('typeIndicator', 'TypeIndicatorController');
    Route::resource('levelAttention', 'LevelAttentionController');
    Route::resource('attentionClassification', 'AttentionClassificationController');
    Route::get('cats/get/catalogos', 'CatalogsController@getCatalogos');
    Route::post('cats/new-register', 'CatalogsController@newRegister');
    Route::put('cats/update/register', 'CatalogsController@updateRegister');
    Route::delete('cats/remove/order/{id}', 'CatalogsController@disableOrder');
    Route::delete('cats/remove/entity/{id}', 'CatalogsController@disableEntity');
    Route::delete('cats/remove/power/{id}', 'CatalogsController@disablePower');
    Route::delete('cats/remove/attendig/{id}', 'CatalogsController@disableAttendig');
    Route::delete('cats/remove/population/{id}', 'CatalogsController@disablePopulation');
    Route::delete('cats/remove/action/{id}', 'CatalogsController@disableAction');
    Route::delete('cats/remove/ods/{id}', 'CatalogsController@disableOds');
    Route::delete('cats/remove/topic/{id}', 'CatalogsController@disableTopic');
    Route::delete('cats/remove/right/{id}', 'CatalogsController@disableRight');
    Route::delete('cats/remove/subtopic/{id}', 'CatalogsController@disableSubtopic');
    Route::delete('cats/remove/subright/{id}', 'CatalogsController@disableSubright');
    Route::delete('cats/remove/subcategory/{id}', 'CatalogsController@disableSubcategory');
    Route::delete('cats/remove/goals/ods/{id}', 'CatalogsController@disableGoalsOds');
    Route::post('cats/disable-register', 'CatalogsController@disableRegister');
    Route::post('cats/searchCats', 'CatalogsController@searchCats');
});
