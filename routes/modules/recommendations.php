<?php

use App\Http\Controllers\RecommendationsController;
use App\Http\Models\Recommendation;
use Maatwebsite\Excel\Concerns\FromView;

Route::get('recommendations/get/files', 'RecommendationsController@documents');
Route::get('recommendations/get/public-files', 'RecommendationsController@publicDocuments');
Route::get('recommendations/get/recommendation/files', 'RecommendationsController@recommendationDocuments');


Route::group(['middleware' => ['auth:api']], function () {

    //Administración del portal publico
    Route::post('recommendations/saveMessages', 'ConsolePublic@saveMessages');
    Route::get('recommendations/adminPublic', 'ConsolePublic@getData');
    Route::post('recommendations/updateImg/file', 'ConsolePublic@updateImg');
    Route::post('recommendations/deleteImg/file', 'ConsolePublic@deleteImg');
    Route::get('carousel/images', 'ConsolePublic@carouselImages');
    Route::get('allies/images', 'ConsolePublic@alliesImages');

    //Aliados
    Route::get('recommendations/adminPublicAllies', 'ConsolePublic@getDataAllies');
    Route::post('recommendations/updateImg/fileAllies', 'ConsolePublic@updateImgAllies');
    Route::post('recommendations/deleteImg/fileAllies', 'ConsolePublic@deleteImgAllies');

    //Fin Administración del portal publico

    Route::resource('recommendations', 'RecommendationsController');

    Route::post('recommendations/upload/file', 'RecommendationsController@uploadFile');
    Route::post('recommendations/upload/file/img', 'RecommendationsController@uploadFileImg');

    Route::get('recommendations/get/file/{id}', 'RecommendationsController@getFile');
    Route::get('recommendations/get/publicdoc/{id}', 'RecommendationsController@getImages');

    Route::delete('recommendations/remove/file/{id}', 'RecommendationsController@disableFile');
    Route::post('recommendations/publish/register', 'RecommendationsController@publish');
    Route::get('filter-recommendations','RecommendationsController@getGonsult');
    Route::get('filter-catalogs','RecommendationsController@searchCatalogs');

    Route::post('recommendations/unpublish/register' ,'RecommendationsController@unpublish');
    Route::post('recommendations/upload/excel', 'RecommendationsController@readExcel');

    Route::post('recommendations/save/file', 'RecommendationsController@saveFile');
    Route::post('recommendations/publish/doc/register', 'RecommendationsController@publishDoc');
    Route::post('recommendations/unpublish/doc/register' ,'RecommendationsController@unpublishDoc');
    Route::get('recommendations/public/document', 'RecommendationsController@publicDocument');
    Route::delete('recommendations/remove/files/pdf/{id}', 'RecommendationsController@disableFilePdf');

    Route::resource('reportedActions','ReportedActionController');

    Route::get('recommendations/edit/document/{id}', 'RecommendationsController@editDocuments');
    Route::put('recommendations/update/document/{id}', 'RecommendationsController@updateDoc');
    Route::put('recommendations/update/document/publi/{id}', 'RecommendationsController@updateDocPubli');

    Route::get('recommendations/create/entities', 'RecommendationsController@createEntities');
    Route::post('recommendations/save/entities', 'RecommendationsController@newRegister2');

    Route::get('recommendations/get-cat', 'RecommendationsController@getCatalogByType');
    Route::post('recommendations/upload/file/recommendation', 'RecommendationsController@uploadFileRecommendation');
    Route::delete('recommendations/remove/documents/pdf/{id}', 'RecommendationsController@disableDocumentPdf');
    Route::post('recommendations/save/doc', 'RecommendationsController@saveDoc');
    Route::get('recommendations/edit/doc/{id}', 'RecommendationsController@editDoc');

});


Route::prefix('public')->group(function () {
    Route::get('index-public/recommendations','PublicController@getData');
    Route::get('recommendations/count', 'PublicController@count');
    Route::post('exportFile', 'PublicController@exportFile');
    Route::get('recommendations/labelsForm', 'PublicController@labelsForm');
    Route::post('recommendationFilter', 'PublicController@recommendationFilter');
    Route::post('detailsRecommendation', 'PublicController@detailsRecommendation');
    Route::get('dashboard', 'DashboardController');
    Route::post('dashboardsFilters', 'PublicController@dashboardsFilters');
    Route::get('downloadPdf/{id}', 'PublicController@downloadPdf');
    Route::get('downloadDocumenPdf/{id}', 'PublicController@downloadDocumenPdf');
    Route::post('reportedActions', 'PublicController@reportedActions');
    Route::get('count/documen/pdf/{id}', 'PublicController@countDocumenPdf');
    Route::get('messages/adminPublic', 'PublicController@getMessages');
    Route::get('downloadDocumentPublicPdf/{id}', 'PublicController@downloadDocumentPublicPdf');
    Route::get('get/language','PublicController@getLanguage');
    Route::get('get/language/spanish','PublicController@getSpanish');
    Route::get('filter-documents','PublicController@getDocumentPublic');
    Route::get('exportRecomendaciones','PublicController@listExcel');

});





