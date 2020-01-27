<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\CarouselImages;
use App\Http\Models\Cats\CatLanguage;
use App\Http\Models\ConsolePublicRecommendation;
use App\Http\Models\DocumentRecommendation;
use App\Http\Models\Files;
use Illuminate\Http\Request;
use App\Http\Models\Recommendation;
use App\Http\Models\ReportedAction;
use App\Http\Models\PublicRecommendation;
use App\Http\Models\Visits; //Visitas
use App\Http\Models\Cats\CatEntity;//Entidad emisora
use App\Http\Models\Cats\CatGobOrder; //Orden de gobierno
use App\Http\Models\Cats\CatGobPower; //Poder de gobierno
use App\Http\Models\Cats\CatAttending; //Autoridad
use App\Http\Models\Cats\CatSolidarityAction; // Accion solicitada
use App\Http\Models\Cats\CatRightsRecommendation; //Derechos de la recomendacion 4
use App\Http\Models\Cats\CatSubRights;
use App\Http\Models\Cats\CatSubcategorySubrights;
use App\Http\Models\Cats\CatTopic;
use App\Http\Models\Cats\CatDate;
use App\Http\Models\Cats\CatPopulation; //Poblacion 5
use App\Http\Models\Cats\CatReviewTopic; // Revision de tema(s) 9
use App\Http\Models\Cats\CatSubtopic; // Revision de subtema(s) 10
use App\Http\Models\Cats\CatOds; //ODS(Objetivo de Desarrollo Sostenible) 10
use App\Http\Models\Document;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RecommendationExport;
use App\Http\Traits\RightsTrait;
use App\Http\Traits\TopicsTrait;
use App\Http\Traits\GoalsOdsTrait;

use Exception;

class PublicController extends Controller
{
    function getData(Request $request)
    {
        try {
            if ($request->wantsJson()){
                Recommendation::$withoutAppends = true;
                $catRights = RightsTrait::orderRights(null, null, null);
                $entities = CatEntity::select('id','name')->where('isActive',true)->get();
                $catPopulation = CatPopulation::select('id','name')->where('isActive', 1)->get();
                $catTopics = TopicsTrait::orderTopics(null);
                $catAutorities = CatAttending::select('id','name')->where('isActive', 1)->get();
                $catOds = CatOds::select('id','name')->where('isActive', 1)->get();
                $CatSolidarityAction = CatSolidarityAction::where('isActive', 1)->get(['id', 'name']);
                $goalsOds = GoalsOdsTrait::orderOds(null);

                $catYears = Recommendation::select('date')
                    ->where('isActive','=', 1)
                    ->where('isPublished','=', 1)
                    ->groupBy('date')
                    ->orderBy('date', 'desc')
                    ->get(['date']);

                return response()->json([
                    'success' => true,
                    'catYears' => $catYears,
                    'catEntities' => $entities,
                    'catPopulations' => $catPopulation,
                    'catTopics' => $catTopics,
                    'catAutorities' => $catAutorities,
                    'catOds' => $catOds,
                    "goalsOds" => $goalsOds,
                    'catActions' => $CatSolidarityAction,
                    'catRights' => $catRights

                ], 200);
            }else{
                return response()->view('errors.404', [], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);

        }
    }

    public function dashboardsFilters(Request $request){
        try{
            function EntidadEmisora($value){
                $CatEntity = CatEntity::where('isActive', '=', 1)->get();
                foreach ($CatEntity as $v) {
                    if($value === $v->id){
                        return $v->acronym;
                    }
                }
            }

            $data = $request->all();
            $results = Recommendation::with('right','subright','subcategory','topic.subtop','reportedaction')
                ->publicConsult($data['params'])
                ->where('isActive', '=', 1)->where('isPublished', '=', 1)
                ->orderBy('date', 'desc')
                ->get();


            $datayears = [];
            $datosActions = [];
            $datosEntidadEmisora = [];
            $recommendationOds = [];
            $authority = [];
            $AccionesReportadasAuthority = [];

            foreach ($results as $value) {
                array_push($recommendationOds,$value->goalsOds );
                array_push($datosEntidadEmisora,EntidadEmisora($value->cat_entity_id));
                array_push($datosActions,$value->implode_action);
                array_push($datayears,$value->date);

                $attendig  = explode(",",$value->implode_attendigacronym);
                if(count($attendig)>0){
                    foreach ($attendig as $valueeeee) {
                        array_push($authority,trim($valueeeee));
                    }
                }

                foreach ($value->reportedaction as $v) {
                    array_push( $AccionesReportadasAuthority,explode("|", $v->implode_attendig));

                }
            }

            //Resolviendo por Accion reportada por autoridad
            $dataReportadasAuthority = [];
            foreach ($AccionesReportadasAuthority as  $valueAut) {
                foreach ($valueAut as $e) {
                    array_push($dataReportadasAuthority,trim($e));
                }
            }

            $DATAreportadasAuthority = array_count_values($dataReportadasAuthority);
            $datosReportadasAuthority = [];
            foreach ($DATAreportadasAuthority as $key => $value) {
                array_push( $datosReportadasAuthority,["name"=>$key,"count"=>$value]);
            }
            //Fin de Accion reportada por autoridad

            //Resolvienddo por autoridad
            $authority = array_count_values( $authority);
            $dataAuthority = [];
            foreach ($authority as $key => $value) {
                array_push($dataAuthority,["name"=>$key,"count"=>$value]);
            }
            //Fin de autoridad

            //Resolviendo ODS
            $parentOds = [];
            for ($i=0; $i < count($recommendationOds); $i++) {
                foreach($recommendationOds[$i] as $valueNameOds){
                    array_push($parentOds,"ODS ".$valueNameOds->ods->id);
                }
            }

            $parentOds = array_count_values($parentOds);
            $dataOds = [];
            foreach ($parentOds as $key => $value) {
                $id = explode(' ',$key);
                array_push($dataOds,["name"=>$key,'count'=>$value,"id"=>$id[1]]);
            }
            //Fin de ODS

            //Resolviendo Entidad Emisora
            $datosEntidadEmisora = array_count_values($datosEntidadEmisora);
            $entidad = [];
            foreach ($datosEntidadEmisora as $key => $value) {
                array_push($entidad,["name"=>$key,"count"=>$value]);
            }
            //Fin de entidad emisora

            //Resolviendo años por recomendacion
            $datayears = array_count_values($datayears);
            $anio = [];
            foreach ($datayears as $key => $value) {
                array_push($anio,["name"=>$key,"count"=>$value]);
            }
            //Fin de resolviendo años por recomendacion

            $CatSolidarityAction = CatSolidarityAction::where('isActive', '=', 1)->get(['name']);

            function explodeAction($data){
                return  explode("|", $data);
            }

            $json = [];
            for ($i=0; $i < count($datosActions) ; $i++) {
                $r = explodeAction($datosActions[$i]);
                for ($f=0; $f < count($r) ; $f++) {
                    array_push($json,trim($r[$f]) );
                }
            }

            $arrayy = [];
            foreach($CatSolidarityAction as $v){
                $yy = [];
                for ($i=0; $i < count($json); $i++) {
                    if($v->name == $json[$i]){
                        array_push($yy, $json[$i] );
                    }
                }
                if(count($yy) > 0){
                    array_push($arrayy, ["name"=> $v->name, "count" => count($yy)] );
                }
            }



            return response()->json([
                'success' => true,
                'lResults' => ["dashboardActionRequested" => $arrayy,
                    "anio" => $anio,
                    "entidad" => $entidad,
                    "ODS" => $dataOds,
                    "Autoridad" => $dataAuthority,
                    "datosReportadasAuthority" => $datosReportadasAuthority ]
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error al  catSolidarityAction ' . $e->getMessage()
            ], 300);
        }
    }


    public function count(Request $request)
    {
        //  DB::beginTransaction();
        try{
            if ($request->wantsJson()){
                $recommendation = Recommendation::where('isActive', '=', 1)
                    ->where('isPublished', '=', 1)->count();



                //dd("recomendacion: ",$recommendation);
                // $visit = Visits::findOrFail(1);
                // $visit->visits = $visit->visits + 1;
                // $visit->save();
                $Entity = CatEntity::where('isActive', '=', 1)->count();
                $Topic = CatTopic::where('isActive', '=', 1)->count();



                $reportedaction = Recommendation::with('reportedaction')
                    ->where('isActive', '=', 1)
                    ->where('isPublished', '=', 1)->get();




                $arraytypeReportedAction = [];
                $countReportedaction = [];
                foreach ($reportedaction as $value) {
                    foreach ($value->reportedaction as $v) {

                        array_push( $countReportedaction, $v );
                    }
                }

                //dd($countReportedaction);

                $CatEntity = CatEntity::where('isActive', 1)->get(['id', 'name']);
                $CatPopulation = CatPopulation::where('isActive', 1)->get(['id', 'name']);
                $CatAttending = CatAttending::where('isActive', 1)->get(['id', 'name']);
                $CatOds = CatOds::where('isActive', 1)->get(['id', 'name']);
                $CatSolidarityAction = CatSolidarityAction::where('isActive', 1)->get(['id', 'name']);

                $CatDate = Recommendation::select('date')
                    ->where('isActive', 1)
                    ->where('isPublished', 1)
                    ->orderBy('date', 'desc')
                    ->get();

                $arrayaDate = array();
                foreach ($CatDate as $date) {
                    array_push($arrayaDate, $date->date);
                }

                $CatRightsRecommendation = CatRightsRecommendation::where('isActive', 1)->get(['id', 'name']); // 1
                $CatSubRights = CatSubRights::where('isActive', 1)->get(['id', 'name', 'rights_recommendations_id']); // 2
                $CatSubcategorySubrights = CatSubcategorySubrights::where('isActive', 1)->get(['id', 'name', 'sub_rights_id']); //3

                $data = array(
                    "0" => array("id" => 0, "name" => "Año", "data" => $arrayaDate),
                    "1" => array("id" => 1, "name" => "Entidad Emisora", "data" => $CatEntity),
                    "2" => array("id" => 2, "name" => "Población", "data" => $CatPopulation),
                    "3" => array("id" => 3, "name" => "Temas", "data" => ''),
                    "4" => array("id" => 4, "name" => "Autoridad", "data" => $CatAttending),
                    "5" => array("id" => 5, "name" => "ODS", "data" => $CatOds),
                    "6" => array("id" => 6, "name" => "Derechos Humanos", "data" => ''),
                    "7" => array("id" => 7, "name" => "Acción solicitada", "data" => $CatSolidarityAction),
                    '8' => array("id" => 8, "name" => "Buscar", "data" => '')
                );

                return response()->json([
                    'success' => true,
                    'lResults' => ['recommendation' => $recommendation,
                        //   'vists' => $visit->visits,
                        'entity' => $Entity,
                        'topics' => $Topic,
                        'reportedaction' => count($countReportedaction),
                        'cats' => $data
                    ]
                ], 200);

            }else{
                return response()->view('errors.404', [], 404);
            }

        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
        }

    }

    public function labelsForm(Request $request)
    {
        try{
            if ($request->wantsJson()){
                $CatEntity = CatEntity::where('isActive', 1)->get(['id', 'name']);
                $CatPopulation = CatPopulation::where('isActive', 1)->get(['id', 'name']);
                $CatAttending = CatAttending::where('isActive', 1)->get(['id', 'name']);
                $CatOds = CatOds::where('isActive', 1)->get(['id', 'name']);

                $CatDate = Recommendation::select('date')
                    ->where('isActive', 1)
                    ->where('isPublished', 1)
                    ->orderBy('date', 'desc')
                    ->get();

                $arrayaDate = array();
                foreach ($CatDate as $date) {
                    array_push($arrayaDate, $date->date);
                }

                $CatRightsRecommendation = CatRightsRecommendation::where('isActive', 1)->get(['id', 'name']); // 1
                $CatSubRights = CatSubRights::where('isActive', 1)->get(['id', 'name', 'rights_recommendations_id']); // 2
                $CatSubcategorySubrights = CatSubcategorySubrights::where('isActive', 1)->get(['id', 'name', 'sub_rights_id']); //3

                $data = array(
                    "0" => array("id" => 0, "name" => "Año", "data" => $arrayaDate),
                    "1" => array("id" => 1, "name" => "Entidad emisora", "data" => $CatEntity),
                    "2" => array("id" => 2, "name" => "Población", "data" => $CatPopulation),
                    "3" => array("id" => 3, "name" => "Temas", "data" => ''),
                    "4" => array("id" => 4, "name" => "Autoridad", "data" => $CatAttending),
                    "5" => array("id" => 5, "name" => "ODS", "data" => $CatOds),
                    "6" => array("id" => 6, "name" => "Derechos Humanos", "data" => ''),
                    '7' => array("id" => 7, "name" => "Buscar", "data" => '')
                );

                return response()->json([
                    'success' => true,
                    'lResults' => $data
                ], 200);

            }else{
                return response()->view('errors.404', [], 404);
            }

            }
          catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información labelsForm ' . $e->getMessage()
            ], 300);
        }
    }


    public function downloadDocument($id)
    {
        try{
            $CatEntity = CatEntity::where('isActive', 1)->get(['id', 'name']);
            $CatPopulation = CatPopulation::where('isActive', 1)->get(['id', 'name']);
            $CatAttending = CatAttending::where('isActive', 1)->get(['id', 'name']);
            $CatOds = CatOds::where('isActive', 1)->get(['id', 'name']);

            $CatDate = Recommendation::select('date')
                ->where('isActive', 1)
                ->where('isPublished', 1)
                ->orderBy('date', 'desc')
                ->get();

            $arrayaDate = array();
            foreach ($CatDate as $date) {
                array_push($arrayaDate, $date->date);
            }

            $CatRightsRecommendation = CatRightsRecommendation::where('isActive', 1)->get(['id', 'name']); // 1
            $CatSubRights = CatSubRights::where('isActive', 1)->get(['id', 'name', 'rights_recommendations_id']); // 2
            $CatSubcategorySubrights = CatSubcategorySubrights::where('isActive', 1)->get(['id', 'name', 'sub_rights_id']); //3

            $data = array(
                "0" => array("id" => 0, "name" => "Año", "data" => $arrayaDate),
                "1" => array("id" => 1, "name" => "Entidad emisora", "data" => $CatEntity),
                "2" => array("id" => 2, "name" => "Población", "data" => $CatPopulation),
                "3" => array("id" => 3, "name" => "Temas", "data" => ''),
                "4" => array("id" => 4, "name" => "Autoridad", "data" => $CatAttending),
                "5" => array("id" => 5, "name" => "ODS", "data" => $CatOds),
                "6" => array("id" => 6, "name" => "Derechos Humanos", "data" => ''),
                '7' => array("id" => 7, "name" => "Buscar", "data" => '')
            );

            return response()->json([
                'success' => true,
                'lResults' => $data
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información labelsForm ' . $e->getMessage()
            ], 300);
        }
    }


    public function arrayName($action, $data)
    {
        $array = array();
        switch ($action) {
            case 'rigth':
            {
                foreach ($data as $value) {
                    array_push($array, json_encode(array('name' => $value->name,
                        'id' => $value->id)));
                }
                break;
            }
            case 'subright':
            {
                foreach ($data as $value) {
                    array_push($array, json_encode(array('name' => $value->name,
                        'id' => $value->id,
                        'rights_recommendations_id' => $value->rights_recommendations_id)));
                }
                break;
            }
            case 'subcategory':
            {
                foreach ($data as $value) {
                    array_push($array, json_encode(array('name' => $value->name,
                        'id' => $value->id,
                        'sub_rights_id' => $value->sub_rights_id)));
                }
                break;
            }
        }

        $array = array_unique($array);
        $dataRight = array();
        foreach ($array as $value) {
            array_push($dataRight, json_decode($value, true));
        }
        return $dataRight;
    }

    public function jsonNames($id)
    {
        $recommendation = Recommendation::with('right', 'subright', 'subcategory')->find($id);
        $arrayRight = self::arrayName("rigth", $recommendation->right);
        $arraySubright = self::arrayName("subright", $recommendation->subright);
        $arraySubcategory = self::arrayName("subcategory", $recommendation->subcategory);

        $data = array();
        for ($i = 0; $i < count($arrayRight); $i++) {
            $jsonSubright = array();
            for ($e = 0; $e < count($arraySubright); $e++) {
                if ($arraySubright[$e]['rights_recommendations_id'] === $arrayRight[$i]['id']) {
                    $jsonSubcategory = array();
                    for ($u = 0; $u < count($arraySubcategory); $u++) {
                        if ($arraySubright[$e]['id'] === $arraySubcategory[$u]['sub_rights_id']) {
                            array_push($jsonSubcategory, array('id' => $arraySubcategory[$u]['id'],
                                'name' => $arraySubcategory[$u]['name'],
                                'sub_rights_id' => $arraySubcategory[$u]['sub_rights_id']));
                        }
                    }

                    array_push($jsonSubright, array('name' => $arraySubright[$e]['name'],
                        'id' => $arraySubright[$e]['id'],
                        'rights_recommendations_id' => $arraySubright[$e]['rights_recommendations_id'],
                        'data' => $jsonSubcategory));
                }
            }
            array_push($data, array('name' => $arrayRight[$i]['name'],
                'id' => $arrayRight[$i]['id'],
                'data' => $jsonSubright));

        }

        return $data;
    }

    public function arrayODS($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    public function Ods($ods){
        $parent = [];
        $child = [];

        foreach ($ods as $value) {
            array_push($child, [ 'id'=>$value->ods_id, 'name'=>$value->name]);
            array_push($parent,['name'=>$value->ods->name,'id'=>$value->ods->id]);
        }

        $data = [];
        $p = self::arrayODS($parent,'id');

        foreach ($p as $val) {
            $subOds = [];
            foreach ($child as $valCH){
                if($val['id'] === $valCH['id']){
                    array_push($subOds,$valCH['name']);
                }
            }
            array_push($data,['name'=> $val['name'],"data"=>$subOds]);
        }
        //Qeuda pendiente agregar los datos de Ods para las graficas
        return $data;
    }

    public function recommendationFilter(Request $request)
    {
        try {
            function CatEntity($id){
                $CatEntity = CatEntity::where('isActive', 1)->get(['id', 'name']);
                foreach ($CatEntity as $value) {
                    if ($value->id === $id) {
                        return $value->name;
                    }
                }
            }

            $data = $request->all();

            $results = Recommendation::with('right','subright','subcategory','topic.subtop','reportedaction.action','reportedaction.population','goalsOds.ods','docs')
                ->publicConsult($data['params'])
                ->where('isActive', '=', 1)->where('isPublished', '=', 1)->distinct('id')
                ->orderBy('date', 'desc')
                ->paginate($data['perPage']);

            foreach ($results as $value) {
                $value->cat_entity_id = CatEntity($value->cat_entity_id);
                $value->cat_gob_order_id = self::jsonNames($value->id);
                $value->Ods = self::Ods($value->goalsOds);
            }

            return response()->json([
                'success' => true,
                'recommendations' => $results
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al filtrar ' . $e->getMessage()
            ], 300);

        }
    }

    public function reportedActions(Request $request){
        try{
            $ReportedAction = ReportedAction::with('population','action')
                ->where('isActive', 1)
                ->where('recommendation_id',$request->id)
                ->get();

            return response()->json([
                'success' => true,
                'lResults' => $ReportedAction
            ], 200);

        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error al reportedActions ' . $e->getMessage()
            ], 300);
        }

    }

    public function explodeWords($data)
    {
        return $data = explode(",", $data);
    }

    public function detailsRecommendation(Request $request)
    {

        $recommendation = Recommendation::find($request->details);
        $populations = self::explodeWords(Recommendation::find($request->details)->implode_population);
        $CatGobOrder = self::explodeWords(Recommendation::find($request->details)->implode_order);
        $CatGobPower = self::explodeWords(Recommendation::find($request->details)->implode_power);
        $CatAttending = self::explodeWords(Recommendation::find($request->details)->implode_attendig);
        $CatSolidarityAction = self::explodeWords(Recommendation::find($request->details)->implode_action);
        $ods = self::explodeWords(Recommendation::find($request->details)->implode_ods);

        // dd($CatGobPower);

        function CatEntity($id)
        {
            $CatEntity = CatEntity::where('isActive', 1)->get(['id', 'name']);
            foreach ($CatEntity as $value) {
                if ($value->id === $id) {
                    return $value->name . $id;
                }
            }
        }

        $data = ['recommendation' => $recommendation->recommendation,
            'entity' => CatEntity($recommendation->cat_entity_id),
            'population' => $populations,
            'catGobOrder' => $CatGobOrder,
            'CatGobPower' => $CatGobPower,
            'CatAttending' => $CatAttending,
            'CatSolidarityAction' => $CatSolidarityAction,
            'ods' => $ods,
            'comments' => $recommendation->comments,
            'date' => $recommendation->date
        ];


        return response()->json([
            'success' => true,
            'lResults' => $data
        ], 200);

    }


    //public function exportFile($json)
    public function exportFile(Request $request)
    {
        $json = $request->all();

        function CatEntity($id){
            $CatEntity = CatEntity::where('isActive', 1)->get(['id', 'name']);
            foreach ($CatEntity as $value) {
                if ($value->id === $id) {
                    return $value->name;
                }
            }
        }

        if( isset($json['id']) === true   ){

            $results = Recommendation::with('right','subright','subcategory','subtopic','topic.subtop','reportedaction.action','reportedaction.attendig','action','goalsOds.ods')
                ->where('isActive', '=', 1)
                ->where('isPublished', '=', 1)
                ->distinct('id')
                ->findOrFail($json['id']);
            $results = [$results];

        }else{

            $results = Recommendation::with('right','subright','subcategory','subtopic','topic.subtop','reportedaction.action','reportedaction.attendig','action','goalsOds.ods')
                ->publicConsult($json)
                ->where('isActive', '=', 1)
                ->where('isPublished', '=', 1)
                ->distinct('id')
                ->orderBy('id', 'desc')
                ->get();
        }

        foreach ($results as $value) {
            $value->cat_entity_id = CatEntity($value->cat_entity_id);
            $value->right = self::jsonNames($value->id);
            $value->Ods = self::Ods($value->goalsOds);
        }

        $pdf = \PDF::loadView('files.recommendationpdf',compact('results'));
        $pdf->setOptions(['isPhpEnabled' => true]);
        return $pdf->download('recomendaciones.pdf');
    }


    public function listExcel()
    {
        return Excel::download(new RecommendationExport(), 'recomendacionesexcel.xlsx');
    }

    public function listWord()
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $section1 = $phpWord->AddSection();
        $section1->addText("Filtros de recomendaciones", array("size" => 10, "bold" => true, "align" => "right")); // Agregamos un titulo al documento con tamaño 22 y en negritas

        $styleTable = array('borderSize' => 6, 'borderColor' => 'black', 'cellMargin' => 40); // el borde de la tabla de 6px, color de borde = #888 , ...
        $styleFirstRow = array('borderBottomColor' => 'black', 'bgColor' => '#13322B');
        $phpWord->addTableStyle('table1', $styleTable, $styleFirstRow);

        $table1 = $section1->addTable("table1"); // creamos la tabla
        $table1->addRow(); // agregamos una fila a la tabla
        $table1->addCell()->addText("Nombre"); // agregamos la columna 1
        $table1->addCell()->addText("Direccion"); // agregamos la columna 2
        $table1->addCell()->addText("Email"); // agregamos la columna 3
        $table1->addCell()->addText("Telefono"); // agregamos la columna 4

        $table1->addRow(); // agregamos otra fila pra los datos
        $table1->addCell()->addText("Airan Osmar"); // fila 2, columna 1, debe coincidir con la columna de la fila anterior
        $table1->addCell()->addText("Eje 3 norte"); // fila 2, columna 2, debe coincidir con la columna de la fila anterior
        $table1->addCell()->addText("Airan osmar"); // fila 2, columna 3, debe coincidir con la columna de la fila anterior
        $table1->addCell()->addText("6272635"); // fila 2, columna 4, debe coincidir con la columna de la fila anterior

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path('recommendationWord.docx'));
        } catch (Exception $e) {
        }
        return response()->download(storage_path('recommendationWord.docx'));
    }


    public function dataFiles($request)
    {
        $request = json_decode($request);
        function CatEntity($id)
        {
            $CatEntity = CatEntity::where('isActive', 1)->get(['id', 'name']);
            foreach ($CatEntity as $value) {
                if ($value->id === $id) {
                    return $value->name . $id;
                }
            }
        }

        function chekNamesOptions($r)
        {
            $jsonCheck = array();
            if (count($r->date) > 0) { //Año
                $checkYears = array();
                foreach ($r->date as $years) {
                    array_push($checkYears, $years);
                }
                array_push($jsonCheck, array("years" => $checkYears));
            }

            if (count($r->entity_id) > 0) { //Entidad emisora
                $CatEntity = CatEntity::where('isActive', 1)->get(['id', 'name']);
                $checkEntity = array();
                foreach ($CatEntity as $v) {
                    foreach ($r->entity_id as $entity_value) {
                        if ($v->id === $entity_value) {
                            array_push($checkEntity, $v->name);
                        }
                    }
                }
                array_push($jsonCheck, array("entity" => $checkEntity));
            }

            if (count($r->population_id) > 0) { //Población
                $CatPopulation = CatPopulation::where('isActive', 1)->get(['id', 'name']);
                $checkPopulation = array();
                foreach ($CatPopulation as $v) {
                    foreach ($r->population_id as $population_value) {
                        if ($v->id === $population_value) {
                            array_push($checkPopulation, $v->name);
                        }
                    }
                }
                array_push($jsonCheck, array("population" => $checkPopulation));
            }

            if (count($r->attending_id) > 0) { //Entidad emisora
                $CatAttending = CatAttending::where('isActive', 1)->get(['id', 'name']);
                $checkCatAttending = array();
                foreach ($CatAttending as $v) {
                    foreach ($r->attending_id as $attending_value) {
                        if ($v->id === $attending_value) {
                            array_push($checkCatAttending, $v->name);
                        }
                    }
                }

                array_push($jsonCheck, array("attending" => $checkCatAttending));
            }
            if (count($r->attending_id) > 0) { //ODS
                $CatOds = CatOds::where('isActive', 1)->get(['id', 'name']);
                $checkCatOds = array();
                foreach ($CatOds as $v) {
                    foreach ($r->ods_id as $ods_id_value) {
                        if ($v->id === $ods_id_value) {
                            array_push($checkCatOds, $v->name);
                        }
                    }
                }

                array_push($jsonCheck, array("ods" => $checkCatOds));
            }
            return $jsonCheck;
        }

        $sqldata = [];
        //          Población                             Autoridad                         ODS
        if (count($request->population_id) > 0 || count($request->attending_id) > 0 || count($request->ods_id) > 0) {
            $sql_recommendation = DB::table('recommendations')
                ->select('recommendations.id as id',
                    //'recommendations.recommendation',
                    //  'population_recommendation.cat_population_id as id_poblacion',
                    'cat_populations.name as name_poblacion',
                    'cat_attendings.name as name_attendings',
                    'cat_ods.name as name_ods')
                ->join("population_recommendation", "population_recommendation.recommendation_id", "=", "recommendations.id")
                ->join("cat_populations", "cat_populations.id", "=", "population_recommendation.cat_population_id")
                ->join("attendig_recommendation", "attendig_recommendation.recommendation_id", "=", "recommendations.id")
                ->join("cat_attendings", "cat_attendings.id", "=", "attendig_recommendation.cat_attending_id")
                ->join("ods_recommendation", "ods_recommendation.recommendation_id", "=", "recommendations.id")
                ->join("cat_ods", "cat_ods.id", "=", "ods_recommendation.cat_ods_id")
                ->orWhere(function ($query) use ($request) {
                    foreach ($request->population_id as $population_id_value) {
                        $query->orWhere('population_recommendation.cat_population_id', $population_id_value);
                    }
                    foreach ($request->attending_id as $attending_value) {
                        $query->orWhere('attendig_recommendation.cat_attending_id', $attending_value);
                    }
                    foreach ($request->ods_id as $ods_value) {
                        $query->orWhere('ods_recommendation.cat_ods_id', $ods_value);
                    }
                })->where('recommendations.isActive', '=', 1)->where('recommendations.isPublished', '=', 1)->get();
            //dd($sql_recommendation);
            $sqldata = array();
            foreach ($sql_recommendation as $value) {
                array_push($sqldata, array($value->id));
            }
        }

        $recommendation = Recommendation::with('right', 'subright', 'subcategory')->orWhere(function ($query) use ($request) {
            if (count($request->date) > 0) {
                $query->whereIn('date', $request->date);
            }
        })->where(function ($query) use ($request, $sqldata) {
            if (count($request->entity_id) > 0) {
                $query->whereIn('cat_entity_id', $request->entity_id);
            }
            if (count($sqldata) > 0) {
                $query->whereIn('id', $sqldata);
            }
        })->where('isActive', '=', 1)->where('isPublished', '=', 1)
            ->orderBy('id', 'desc')
            ->get();


        $data = array();
        foreach ($recommendation as $value) {
            $ods = Recommendation::find($value->id)->implode_ods;
            $populations = Recommendation::find($value->id)->implode_population;
            $attendings = Recommendation::find($value->id)->implode_attendig;
            array_push($data, array("id" => $value->id
            , "recommendation" => $value->recommendation
            , "date" => $value->date
            , "entity_id" => CatEntity($value->cat_entity_id) // nameAttending($value->cat_entity_id)
            , "population" => $populations
            , "themas" => "PENDIENTE"
            , "right" => self::jsonNames($value->id)
            , "ods" => $ods
            , "attendings" => $attendings
            ));
        }
        //  dd(chekNamesOptions($request));
        //dd($data);

        if ($request->file === true) {
            return $data;
        } else {
            return response()->json([
                'success' => true,
                'lResults' => ["jsonFilters" => $data, 'count' => count($data), "checkNames" => chekNamesOptions($request)]
            ], 200);
        }


    }

    public function downloadPdf(Request $request, $id)
    {
        try {
            if ($request->wantsJson()){
                $pdf = \App::make('dompdf.wrapper');

                $pdf->loadView('recommendation');
                //, compact('recommendations'));

                return $pdf->download();

            }else{
                return response()->view('errors.404', [], 404);
            }

        }
        catch ( \Exception $e ) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción ' . $e->getMessage(),
                'errror'  => $e
            ], 500);
        }
    }


    public function downloadDocumenPdf(Request $request, $id)
    {
        try {

                $document   = Files::with('documents')->find($id);

                $pathToFile = storage_path() . '/app/recommendations/files/' . $document->documents->fileNameHash;

                return response()->download(
                    $pathToFile,
                    $document->documents->fileName,
                    [],
                    'inline'
                );




        }

        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e,
            ], 500);
        }
    }

    public function countDocumenPdf(Request $request, $id)
    {
        try {
                $document   = Files::with('documents')->find($id);
                $doc = Document::find($document->document_id);

                $doc->downloadCount = $doc->downloadCount + 1;
                $doc->save();

                return response()->json([
                    'success' => true
                ]);

        }

        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => dd($e),
            ], 500);
        }
    }

    public function getMessages(Request $request)
    {
        try {
            if ($request->wantsJson()){
                $data = $request->all();

                if ($data['type'] == 1){
                    return CarouselImages::select('fileNameHash')->whereIsactive(1)->whereType(1)->get();
                }else if ($data['type'] == 2){
                    $configPublic = ConsolePublicRecommendation::find(1);
                    $pathUnsecre = CarouselImages::find($configPublic->path_undersecretary);
                    $pathDgdhd = CarouselImages::find($configPublic->path_dgdhd);
                    $dataPublic = [
                        'seridh'               => $configPublic->seridh,
                        'activeSeridh'         => $configPublic->activeSeridh == 1 ? true : false,
                        'undersecretary'       => $configPublic->undersecretary,
                        'path_undersecretary'  => [],
                        'activeUndersecretary' => $configPublic->activeUndersecretary == 1 ? true : false,
                        'dgdhd'                => $configPublic->dgdhd,
                        'path_dgdhd'           => [],
                        'activeDgdhd'          => $configPublic->activeDgdhd == 1 ? true : false,
                    ];
                    return response()->json([
                        'dataPublic' => $dataPublic,
                        'path_undersecretary'  => '/img/public/messages/'.$pathUnsecre->fileNameHash,
                        'path_dgdhd'           => '/img/public/messages/'.$pathDgdhd ->fileNameHash,
                        'success'   => true
                    ]);
                } else {
                    return CarouselImages::select('fileNameHash','text','link')->whereIsactive(1)->whereType(3)->get();
                }

            }else{
                return response()->view('errors.404', [], 404);
            }

        }
        catch ( \Exception $e ){
            return response()->json([
                'success' => false,
                'message' => dd($e)
            ]);
        }
    }

    public function downloadDocumentPublicPdf(Request $request, $id)
    {
        try {
                $document   = DocumentRecommendation::with('documents')->find($id);
                $pathToFile = storage_path() . '/app/recommendations/files/' . $document->documents->fileNameHash;

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
                'message' => $e,
            ], 500);
        }
    }

    public function getLanguage(Request $request, $lang = 'en')
    {

        try {
            if ($request->wantsJson()){
                $langs = CatLanguage::select('acronym')->get()->pluck('acronym');
                //	$langs = $result;//['es', 'en', 'cn','fra','bra'];
                $status = false;
                foreach ($langs as $item) {
                    if ($lang == $item) {
                        $status = true;
                    }
                }

                if ($status) {
                    $pathToFile = storage_path() . "/app/lang/" . $lang . '.json';
                    return response()->download(
                        $pathToFile,
                        $lang,
                        [],
                        'inline'//attachment
                    );
                } else {
                    return response()->json([
                        'success' => false,
                    ], 404);
                }

            }else{
                return response()->view('errors.404', [], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getSpanish(Request $request, $lang = 'es')
    {

        try {
            if ($request->wantsJson()){
                $langs = CatLanguage::select('acronym')->get()->pluck('acronym');
                //	$langs = $result;//['es', 'en', 'cn','fra','bra'];
                $status = false;
                foreach ($langs as $item) {
                    if ($lang == $item) {
                        $status = true;
                    }
                }

                if ($status) {
                    $pathToFile = storage_path() . "/app/lang/" . $lang . '.json';
                    return response()->download(
                        $pathToFile,
                        $lang,
                        [],
                        'inline'//attachment
                    );
                } else {
                    return response()->json([
                        'success' => false,
                    ], 404);
                }

            }else{
                return response()->view('errors.404', [], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getDocumentPublic(Request $request){
        try {
            if ($request->wantsJson()){
                $data = $request->all();
                $search = json_decode($data['filters']);

                $files = Files::with( 'documents')
                    ->consult($search)
                    ->where('isActive', true)
                    ->orderBy('updated_at', 'DESC')
                    ->paginate($data['perPage']);


                return response()->json([
                    'files' => $files,
                    'success' => true
                ]);

            }else{
                return response()->view('errors.404', [], 404);
            }

        }
        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


}
