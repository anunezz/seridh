<?php

namespace App\Http\Controllers;

use App\Http\Models\Cats\CatAttending;
use App\Http\Models\Cats\CatEntity;
use App\Http\Models\Cats\CatGoalsOds;
use App\Http\Models\Cats\CatGobOrder;
use App\Http\Models\Cats\CatGobPower;
use App\Http\Models\Cats\CatOds;
use App\Http\Models\Cats\CatDate;
use App\Http\Models\Cats\CatPopulation;
use App\Http\Models\Cats\CatRightsRecommendation;
use App\Http\Models\Cats\CatSolidarityAction;
use App\Http\Models\Cats\CatSubcategorySubrights;
use App\Http\Models\Cats\CatSubRights;
use App\Http\Models\Cats\CatSubtopic;
use App\Http\Models\Cats\CatTopic;
use App\Http\Models\Cats\DataControl;
use App\Http\Models\Document;
use App\Http\Models\Recommendation;
use App\Http\Models\ReportedAction;
use App\Http\Traits\TopicsTrait;
use App\Imports\RecommendationsImport;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Traits\RightsTrait;
use App\Http\Models\Files;
use App\Http\Models\DocumentRecommendation;
use App\User;

use App\Http\Traits\GoalsOdsTrait;
use phpDocumentor\Reflection\File;

class RecommendationsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = $request->all();

            $recommendations = Recommendation::with('user', 'entity:id,name',
                'order', 'power')
                ->search($data['filters'])
                ->where('isActive', true)
                ->orderBy('updated_at', 'DESC')
                ->paginate($data['perPage']);

            $entity = CatEntity::select(['name','id'])->get();

            return response()->json([
                'recommendations' => $recommendations,
                'entity' => $entity,
                'success'         => true
            ]);

        }
        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function documents(Request $request)
    {
        try {

            $data = $request->all();

            $documents = Files::select(['title','description','document_id','id','created_at','isPublished'])
                ->with('documents:id,fileName,fileNameHash,downloadCount')
                ->where('isActive', true)
                ->orderBy('updated_at', 'DESC')
                ->paginate($data['perPage']);

            return response()->json([
                'documents' => $documents,
                'success'   => true
            ]);

        }
        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => dd($e)
            ]);
        }
    }

    public function getGonsult(Request $request){
        try {
             $data = $request->all();
             $search = json_decode($data['filters']);

            $recommendations = Recommendation::with('user', 'ods', 'entity:id,name',
                'order', 'power')
                ->consult($search)
                ->where('isActive', true)
                ->orderBy('updated_at', 'DESC')
                ->paginate($data['perPage']);


            return response()->json([
                'recommendations' => $recommendations,
                'success'         => true
            ]);

        }
        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function create()
    {
        try {

            $lastId = Recommendation::orderBy('id', 'desc')->pluck('id')->first();
            $lastId = $lastId + 1;

            $entities = CatEntity::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name', 'acronym']);


            $orders = CatGobOrder::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $powers = CatGobPower::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $attendings = CatAttending::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $rights = RightsTrait::orderRights(null, null, null);

            $topics = TopicsTrait::orderTopics(null);

            $top = CatTopic::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $rig = CatRightsRecommendation::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $subrig = CatSubRights::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $goalsOds = GoalsOdsTrait::orderOds(null);

            $populations = CatPopulation::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $actions = CatSolidarityAction::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $subtopics = CatSubtopic::with('topic')->where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name', 'cat_topic_id']);

            $ods = CatOds::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $dates = CatDate::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $documents = Document::where('isActive', 1)
                ->orderBy('fileName')
                ->get(['id', 'fileName']);


            return response()->json([
                'entities'    => $entities,
                'orders'      => $orders,
                'populations' => $populations,
                'actions'     => $actions,
                'topics'      => $topics['tree'],
                'goalsOds'    => $goalsOds['tree'],
                'rights'      => $rights,
                'ods'         => $ods,
                'dates'       => $dates,
                'powers'      => $powers,
                'attendings'  => $attendings,
                'subtopics'   => $subtopics,
                'documents'   => $documents,
                'top'         => $top,
                'rig'         => $rig,
                'subrig'      => $subrig,

//
//                'tree' => $tree,
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
            $data = $request->recommendation;
            $control = $data['dataControl'];
            $reportedA = $request->reported;
            /*Generar Folio**********************************/
            $entidad = CatEntity::find($data['cat_entity_id']);
            $siglasE = $entidad->acronym;
            $num = Recommendation::where('cat_entity_id',$data['cat_entity_id'])->count();
            $num++;
            while (strlen($num)<4){
                $num= '0'.$num;
            }
            $folio = $siglasE.$data['date'].$num;
            $data['invoice'] = $folio;
            /************************************************/
            $recommendation = new Recommendation();
            $recommendation->user_id = auth()->user()->id;
            $recommendation->fill($data);
            $recommendation->save();
            $recommendation->docs()->sync($data['documents']);

            $control['recommendation_id'] = $recommendation->id;
            $dataControl = new DataControl();
            $dataControl->fill($control);
            $dataControl->save();

            /*if ( count($data['documents']) > 0 ) {
                foreach ($data['documents'] as $documentId){
                    $document = Document::find($documentId);

                    $document->recommendation_id = $recommendation->id;
                    $document->save();
                }
            }*/

            foreach ($reportedA as $re){
                $iniAut='';
                if (count($re['cat_attendig_id'])>1){
                    $iniAut = 'VAEA';
                }else{
                    $attending = CatAttending::find($re['cat_attendig_id'][0]);
                    $name = str_replace(" ", "",trim($attending->name));
                    for ($i=0;$i<strlen($name);$i++){
                        if(preg_match("/[A-Z]/", $name[$i])===1) {
                            $iniAut = $iniAut.$name[$i];
                        }
                    }
                }
                $num = ReportedAction::whereRecommendationId($recommendation->id)->count();
                $num++;
                while (strlen($num)<3){
                    $num= '0'.$num;
                }

                $re['recommendation_id'] = $recommendation->id;
                $re['invoice'] = $folio.$iniAut.$num;

                $reportedAction = new ReportedAction();
                $reportedAction->fill($re);
                $reportedAction->save();

                $reportedAction->action()->sync($re['cat_solidarity_action_id']);
                $reportedAction->population()->sync($re['cat_population_id']);
                $reportedAction->attendig()->sync($re['cat_attendig_id']);
            }
            /*$reportedA['recommendation_id'] = $recommendation->id;
            $reportedA['invoice'] = $folio.'Aut'.'000';*/

            $listRights=[];
            foreach ($data['listRights'] as $item){
                $listRights[$item['right_id']]=[
                    'subrigth_id' => $item['subrights_id'],
                    'subcategory_subrights_id' => $item['subcategory_id']
                ];
                $recommendation->right()->attach($listRights);
                $listRights=[];
            }

            $listGoalsOds=[];
            foreach ($data['listGoalsOds'] as $item){
                $listGoalsOds[$item['cat_goal_id']]=[
                    'ods_id' => $item['ods_id']
                ];
            }
            $recommendation->goalsOds()->sync($listGoalsOds);

            $listThemes=[];
            foreach ($data['listThemes'] as $item){
                $listThemes[$item['cat_subtopic_id']]=[
                    'cat_topic_id' => $item['cat_topic_id']
                ];
            }
                // dd($data['listThemes']);
                $recommendation->subtopic()->sync($listThemes);


            /*if ( count($data['cat_ods_id']) > 0 ) {
                $recommendation->ods()->sync($data['cat_ods_id']);
            }*/

            if ( count($data['cat_gob_order_id']) > 0 ){
                $recommendation->order()->sync($data['cat_gob_order_id']);
            }

            if ( count($data['cat_gob_power_id']) > 0 ){
                $recommendation->power()->sync($data['cat_gob_power_id']);
            }

            if ( count($data['cat_attendig_id']) > 0 ){
                $recommendation->attendig()->sync($data['cat_attendig_id']);
            }

            if ( count($data['cat_population_id']) > 0 ){
                $recommendation->population()->sync($data['cat_population_id']);
            }

            if ( count($data['cat_solidarity_action_id']) > 0 ){
                $recommendation->action()->sync($data['cat_solidarity_action_id']);
            }

            /*if ( count($data['files']) > 0 ) {
                foreach ( $data['files'] as $file ) {
                    $recommendationDocument = Document::find($file);

                    $recommendationDocument->recommendation_id = $recommendation->id;
                    $recommendationDocument->isActive = true;
                    $recommendationDocument->save();
                }
            }*/



            GeneralController::saveTransactionLog(2,
                'Crea una nueva recomendación con id: ' . $recommendation->id);

            DB::commit();

            return response()->json([
                'success' => true,
                'folio' => $folio,
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

    public function saveDocument(Request $request)
    {
        try {
            DB::beginTransaction();

            $file = new Document();
            $path = 'recommendations/files';
            $document = $request->document;
            $nameHash = encrypt($file->id) . '.' . $document->extension();

            $file->isActive = 1;
            $file->isType = 1;
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


    public function edit(Request $request, $id)
    {
        try {

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


            $populations = CatPopulation::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $actions = CatSolidarityAction::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);


            $subtopics = CatSubtopic::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $dates = CatDate::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $relations = ['order', 'power', 'attendig', 'population','dataControl',
                          'right', 'subright','subcategory', 'subtopic','goalsOds','docs'];

            $recommendation = Recommendation::with($relations)->find(decrypt($id));

           // dd($recommendation->docs);

            $rights = RightsTrait::orderRights($recommendation->right->all(),$recommendation->subright->all(),$recommendation->subcategory->all());

            $topics = TopicsTrait::orderTopics($recommendation->subtopic->all());

            $goalsOds = GoalsOdsTrait::orderOds($recommendation->goalsOds->all());

            $recommendationForm = [
                'recommendation'               => $recommendation->recommendation,
                'validity'                     => $recommendation->validity,
                'directed'                     => $recommendation->directed,
                'cat_entity_id'                => $recommendation->cat_entity_id,
                'cat_gob_order_id'             => $recommendation->order->pluck('id')->toArray(),
                'cat_gob_power_id'             => $recommendation->power->pluck('id')->toArray(),
                'cat_attendig_id'              => $recommendation->attendig->pluck('id')->toArray(),
                'cat_population_id'            => $recommendation->population->pluck('id')->toArray(),
                'cat_solidarity_action_id'     => $recommendation->action->pluck('id')->toArray(),
                'cat_review_right_id'          => $recommendation->cat_review_right_id,
                'cat_review_topic_id'          => $recommendation->cat_review_topic_id,
                'date'                         => $recommendation->date,
                'comments'                     => $recommendation->comments,
                'invoice'                      => $recommendation->invoice,
                'listRights'                   => $rights['listR'],
                'listThemes'                   => $topics['listThemes'],
                'listGoalsOds'                 => $goalsOds['listOds'],
                'documents'                    => $recommendation->docs->pluck('id')->toArray(),
                'dataControl'                  => $recommendation->dataControl,
                'isPublished'                  => $recommendation->isPublished,
            ];
//dd($recommendationForm);
            return response()->json([
                'entities'           => $entities,
                'orders'             => $orders,
                'populations'        => $populations,
                'actions'            => $actions,
                'dates'              => $dates,
                'powers'             => $powers,
                'attendings'         => $attendings,
                'subtopics'          => $subtopics,
                'recommendationForm' => $recommendationForm,
                'success'            => true,
                'showIds'            => $rights['showIds'],
                'rights'             => $rights['rights'],
                'showIde'            => $topics['showIde'],
                'showOdsIds'         => $goalsOds['showOdsIds'],
                'topics'             => $topics['tree'],
                'goalsOds'           => $goalsOds['tree'],
                'folioRe'            =>$recommendation->invoice,
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
            $control = $data['dataControl'];
            $recommendation = Recommendation::find(decrypt($id));
            $recommendation->fill($data);
            $recommendation->save();

            $recommendation->docs()->sync($data['documents']);

            $dataControl = DataControl::find($control['id']);
            $dataControl->fill($control);
            $dataControl->save();

            $recommendation->right()->detach();

            $listRights=[];
            foreach ($data['listRights'] as $item){
                $listRights[$item['right_id']]=[
                    'subrigth_id' => $item['subrights_id'],
                    'subcategory_subrights_id' => $item['subcategory_id']
                ];
                $recommendation->right()->attach($listRights);
                $listRights=[];
            }
            $listGoalsOds=[];
            foreach ($data['listGoalsOds'] as $item){
                $listGoalsOds[$item['cat_goal_id']]=[
                    'ods_id' => $item['ods_id']
                ];
            }
            $recommendation->goalsOds()->sync($listGoalsOds);

              $listThemes=[];
              foreach ($data['listThemes'] as $item) {
                  $listThemes[$item['cat_subtopic_id']] = [
                      'cat_topic_id' => $item['cat_topic_id']
                  ];
              }
                  $recommendation->subtopic()->sync($listThemes);


            /*if ( count($data['cat_ods_id']) > 0 ) {
                $recommendation->ods()->sync($data['cat_ods_id']);
            }*/

            if ( count($data['cat_gob_order_id']) > 0 ){
                $recommendation->order()->sync($data['cat_gob_order_id']);
            }

            if ( count($data['cat_gob_power_id']) > 0 ){
                $recommendation->power()->sync($data['cat_gob_power_id']);
            }

            if ( count($data['cat_attendig_id']) > 0 ){
                $recommendation->attendig()->sync($data['cat_attendig_id']);
            }

            if ( count($data['cat_population_id']) > 0 ){
                $recommendation->population()->sync($data['cat_population_id']);
            }

            if ( count($data['cat_solidarity_action_id']) > 0 ){
                $recommendation->action()->sync($data['cat_solidarity_action_id']);
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
            $file->isActive=1;
            $file->isType= 2;
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

            $erros = session('errorMasivo');
            session()->forget(['errorsReportedActions', 'reportedActions','errorMasivo']);
            return response()->json([
                'success'    => true,
                'filas'      => $erros
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

    public function getImages($id)
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

    public function publicDocuments(Request $request)
    {
        try {

            $data = $request->all();

            $documents = Files::select(['title','description','document_id','id','created_at','isPublished'])
                ->with('documents:id,fileName,fileNameHash,downloadCount')
                ->where('isActive', true)
                ->where('isPublished', true)
                ->orderBy('updated_at', 'DESC')
                ->paginate($data['perPage']);

            return response()->json([
                'documents' => $documents,
                'success'   => true
            ]);

        }
        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => dd($e)
            ]);
        }
    }

    public function saveFile(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $files = new files();

            $data['title'];

            //$files->user_id = auth()->user()->id;
            $files->fill($data);
            $files->document_id = $data['files'][0];
            $files->save();


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

    public function files(Request $request)
    {
        try {

            $data = $request->all();
            $files = Files::select(['title','description'])

                ->where('isActive', true)
                ->orderBy('updated_at', 'DESC')
                ->paginate($data['perPage']);

            return response()->json([
                'files' => $files,
                'success'   => true
            ]);

        }
        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => dd($e)
            ]);
        }
    }

    public function publishDoc(Request $request)
    {
        try {

            $files = Files::find(decrypt($request->id));

            $files->isPublished = true;
            $files->save();

            GeneralController::saveTransactionLog(5,
                'Publica una recomendación con id: ' . $files->id);

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

    public function unpublishDoc(Request $request)
    {
        try {

            $files = Files::find(decrypt($request->id));

            $files->isPublished = false;
            $files->save();

            GeneralController::saveTransactionLog(5,
                'Despublica una recomendación con id: ' . $files->id);

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción ',
            ], 500);
        }

    }

    public function disableFilePdf($id)
    {
        try {

            $files   = Files::find(decrypt($id));

            $files->isActive = false;
            $files->save();

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

    public function editDocuments(Request $request, $id)
    {
        try {
            $files = Files::with('documents:id,fileName')->where('id', decrypt($id))->where('isActive', 1)
                ->orderBy('title')
                ->first(['id', 'title', 'description', 'document_id']);


            return response()->json([
                'files'     => $files,
                'success'   => true

            ]);

        }

        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => dd($e)
            ]);
        }
    }

    public function updateDoc(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $files = Files::with('documents')->find(decrypt($id));


            $files->title = $data['title'];
            $files->description = $data['description'];


            $files->save();


            GeneralController::saveTransactionLog(2,
                'Edita un documento con id: ' . $files->id);

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


    public function updateDocPubli(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $files = Files::with('documents')->find(decrypt($id));


            $files->title = $data['title'];
            $files->description = $data['description'];
            $files->isPublished = true;

            $files->save();


            GeneralController::saveTransactionLog(2,
                'Edita un documento con id: ' . $files->id);

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

    public function createEntities()
    {
        try {

            $entities = CatEntity::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $topics = CatTopic::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $subtopics = CatSubtopic::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name', 'cat_topic_id']);



            return response()->json([
                'entities'    => $entities,
                'topics'      => $topics,
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

    public function saveEntities(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $entities = new CatEntity();

            $entities->fill($data);
            $entities->save();

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


    public function uploadFileRecommendation(Request $request)
    {
        try {
            DB::beginTransaction();

            $file = new Document();
            $path = 'recommendations/files';
            $document = $request->document;
            $nameHash = encrypt($file->id) . '.' . $document->extension();

            $file->user_id = auth()->user()->id;
            $file->isActive=1;
            $file->isType= 1;
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

    public function recommendationDocuments(Request $request)
    {
        try {

            $data = $request->all();
            $documents = null;
            if (isset($data['transfer'])){
                $documents = DocumentRecommendation::all();
            }
            else{
                $documents = DocumentRecommendation::select(['folio','document_id','id','isActive'])
                    ->with('documents:id,fileName,fileNameHash,downloadCount')
                    ->where('isActive', true)
                    ->orderBy('updated_at', 'DESC')
                    ->paginate($data['perPage']);
            }

            return response()->json([
                'documents' => $documents,
                'success'   => true
            ]);

        }
        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => dd($e)
            ]);
        }
    }

    public function disableDocumentPdf($id)
    {
        try {

            $documents   = DocumentRecommendation::find(decrypt($id));

            $documents->isActive = false;
            $documents->save();

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


    public function saveDoc(Request $request)
    {
        try {

            DB::beginTransaction();
            $data = $request->all();

            $entidad = CatEntity::find($data['cat_entity_id']);
            $siglasE = $siglasE = explode("-", $entidad->acronym);
            $num = DocumentRecommendation::where('cat_entity_id',$data['cat_entity_id'])->count();
            $num++;
            $R = 'R';
            while (strlen($num)<4){
                $num= '0'.$num;
            }
            $folio = $R.$siglasE[0].$data['date'].$num;
            $data['folio'] = $folio;

            $files = new DocumentRecommendation();

            $files->fill($data);
            $files->document_id = $data['files'][0];

            $files->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'folio' => $folio,
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

    public function editDoc(Request $request, $id)
    {
        try {

            $files = Document::where('id', decrypt($id))->where('isActive', 1)
                ->orderBy('fileName')
                ->get(['id', 'fileName']);


            return response()->json([
                'files'     => $files,
                'success'   => true

            ]);
        }

        catch ( \Exception $e ) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function disableDocument($id)
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



}
