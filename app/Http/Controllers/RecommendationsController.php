<?php

namespace App\Http\Controllers;

use App\Http\Models\Cats\CatAttending;
use App\Http\Models\Cats\CatEntity;
use App\Http\Models\Cats\CatGobOrder;
use App\Http\Models\Cats\CatGobPower;
use App\Http\Models\Cats\CatIde;
use App\Http\Models\Cats\CatOds;
use App\Http\Models\Cats\CatPopulation;
use App\Http\Models\Cats\CatReviewRight;
use App\Http\Models\Cats\CatReviewTopic;
use App\Http\Models\Cats\CatRightsRecommendation;
use App\Http\Models\Cats\CatSolidarityAction;
use App\Http\Models\Cats\CatSubtopic;
use App\Http\Models\Document;
use App\Http\Models\Recommendation;
use App\Imports\RecommendationsImport;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RecommendationsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = $request->all();

            $recommendations = Recommendation::with('user', 'ods', 'entity:id,name',
                'order:id,name', 'power:id,name')
                ->search($data['filters'])
                ->where('isActive', true)
                ->orderBy('updated_at', 'DESC')
                ->paginate($data['perPage']);

            return response()->json([
                'recommendations' => $recommendations,
                'success'         => true
            ]);

        }
        catch ( \Exception $e ) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function create()
    {
        try {
            $ides = CatIde::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $entities = CatEntity::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $orders = CatGobOrder::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $powers = CatGobPower::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $attendings = CatAttending::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $rights = CatRightsRecommendation::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $populations = CatPopulation::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $actions = CatSolidarityAction::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $reviews = CatReviewRight::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $topics = CatReviewTopic::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $subtopics = CatSubtopic::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $ods = CatOds::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            return response()->json([
                'ides'        => $ides,
                'entities'    => $entities,
                'orders'      => $orders,
                'rights'      => $rights,
                'populations' => $populations,
                'actions'     => $actions,
                'reviews'     => $reviews,
                'topics'      => $topics,
                'ods'         => $ods,
                'powers'      => $powers,
                'attendings'  => $attendings,
                'subtopics'   => $subtopics,
                'success'     => true
            ]);

        }
        catch ( \Exception $e ) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $recommendation = new Recommendation();

            $recommendation->user_id = auth()->user()->id;
            $recommendation->fill($data);
            $recommendation->save();

            if ( count($data['cat_ods_id']) > 0 ) {
                $recommendation->ods()->sync($data['cat_ods_id']);
            }

            if ( count($data['files']) > 0 ) {
                foreach ( $data['files'] as $file ) {
                    $recommendationDocument = Document::find($file);

                    $recommendationDocument->recommendation_id = $recommendation->id;
                    $recommendationDocument->isActive = true;
                    $recommendationDocument->save();
                }
            }

            GeneralController::saveTransactionLog(2,
                'Crea una nueva recomendación con id: ' . $recommendation->id);

            DB::commit();

            return response()->json([
                'success' => true,
            ]);
        }
        catch ( \Exception $e ) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        try {

            $ides = CatIde::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $entities = CatEntity::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $orders = CatGobOrder::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $powers = CatGobPower::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $attendings = CatAttending::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $rights = CatRightsRecommendation::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $populations = CatPopulation::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $actions = CatSolidarityAction::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $reviews = CatReviewRight::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $topics = CatReviewTopic::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $subtopics = CatSubtopic::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $ods = CatOds::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $recommendation = Recommendation::with('documents', 'ods')->find(decrypt($id));

            $recommendationForm = [
                'recommendation'               => $recommendation->recommendation,
                'cat_ide_id'                   => $recommendation->cat_ide_id,
                'cat_entity_id'                => $recommendation->cat_entity_id,
                'cat_gob_order_id'             => $recommendation->cat_gob_order_id,
                'cat_gob_power_id'             => $recommendation->cat_gob_power_id,
                'cat_attendig_id'              => $recommendation->cat_attendig_id,
                'cat_rights_recommendation_id' => $recommendation->cat_rights_recommendation_id,
                'cat_population_id'            => $recommendation->cat_population_id,
                'cat_solidarity_action_id'     => $recommendation->cat_solidarity_action_id,
                'cat_review_right_id'          => $recommendation->cat_review_right_id,
                'cat_review_topic_id'          => $recommendation->cat_review_topic_id,
                'cat_subtopic_id'              => $recommendation->cat_subtopic_id,
                'cat_ods_id'                   => $recommendation->ods->pluck('id')->toArray(),
                'comments'                     => $recommendation->comments,
                'documents'                    => $recommendation->documents
            ];

            return response()->json([
                'ides'               => $ides,
                'entities'           => $entities,
                'orders'             => $orders,
                'rights'             => $rights,
                'populations'        => $populations,
                'actions'            => $actions,
                'reviews'            => $reviews,
                'topics'             => $topics,
                'ods'                => $ods,
                'powers'             => $powers,
                'attendings'         => $attendings,
                'subtopics'          => $subtopics,
                'recommendationForm' => $recommendationForm,
                'success'            => true
            ]);

        }
        catch ( \Exception $e ) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $recommendation = Recommendation::find(decrypt($id));

            $recommendation->fill($data);
            $recommendation->save();

            if ( count($data['cat_ods_id']) > 0 ) {
                $recommendation->ods()->sync($data['cat_ods_id']);
            }

            if ( count($data['files']) > 0 ) {
                foreach ( $data['files'] as $file ) {
                    $recommendationDocument = Document::find($file);

                    $recommendationDocument->recommendation_id = $recommendation->id;
                    $recommendationDocument->isActive = true;
                    $recommendationDocument->save();
                }
            }

            GeneralController::saveTransactionLog(2,
                'Edita una recomendación con id: ' . $recommendation->id);

            DB::commit();

            return response()->json([
                'success' => true,
            ]);
        }
        catch ( \Exception $e ) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function publish(Request $request)
    {
        try {

            $recommendation = Recommendation::find(decrypt($request->id));

            $recommendation->isPublished = true;
            $recommendation->save();

            GeneralController::saveTransactionLog(5,
                'Publica una recomendación con id: ' . $recommendation->id);

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }

    }

    public function unpublish(Request $request)
    {
        try {

            $recommendation = Recommendation::find(decrypt($request->id));

            $recommendation->isPublished = false;
            $recommendation->save();

            GeneralController::saveTransactionLog(5,
                'Despublica una recomendación con id: ' . $recommendation->id);

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }

    }


    public function destroy($id)
    {
        try {

            $recommendation = Recommendation::find(decrypt($id));

            $recommendation->isActive = false;
            $recommendation->save();

            GeneralController::saveTransactionLog(4,
                'Elimina una recomendación con id: ' . $recommendation->id);

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }


    }

    public function uploadFile(Request $request)
    {
        try {
            DB::beginTransaction();

            $file = new Document();
            $path = 'recommendations/files';
            $document = $request->document;
            $nameHash = encrypt($file->id) . '.' . $document->extension();

            $file->user_id = auth()->user()->id;
            $file->fileNameHash = $nameHash;
            $file->fileName = $document->getClientOriginalName();
            $file->save();

            $document->storeAs($path, $nameHash);

            DB::commit();

            return response()->json([
                'success'    => true,
                'documentId' => $file->id
            ]);
        }
        catch ( \Exception $e ) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getFile($id)
    {
        try {

            $document   = Document::find(decrypt($id));
            $pathToFile = storage_path() . '/app/recommendations/files/' . $document->fileNameHash;

            return response()->download(
                $pathToFile,
                $document->fileName,
                [],
                'inline'
            );
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }

    public function disableFile($id)
    {
        try {

            $document   = Document::find(decrypt($id));

            $document->isActive = false;
            $document->save();

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }

    public function readExcel(Request $request)
    {
        try {
            DB::beginTransaction();

            $path = '/';
            $document = $request->document;

            $document->storeAs($path, 'Recomendaciones.xlsm');

            Excel::import(new RecommendationsImport, 'Recomendaciones.xlsm');
            DB::commit();

            return response()->json([
                'success'    => true,
                'filas'      => session('errorMasivo')
            ]);
        }
        catch ( \Exception $e ) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
