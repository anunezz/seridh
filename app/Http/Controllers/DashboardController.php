<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Models\Recommendation;
use App\Http\Models\Cats\CatEntity;
use App\Http\Models\Cats\CatSolidarityAction;
use App\Http\Traits\GoalsOdsTrait;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $reportedaction = Recommendation::with('reportedaction','goalsOds.ods')
        ->where('isActive', '=', 1)
        ->where('isPublished', '=', 1)->get();

        $arraytypeReportedAction = [];
        $countReportedaction = [];
        $recommendationOds = [];
        $authority = [];
        $AccionesReportadasAuthority = [];

        foreach ($reportedaction as $value) {
                     array_push($recommendationOds,$value->goalsOds);

                     $attendig  = explode(",",$value->implode_attendigacronym);
                      if(count($attendig)>0){
                         foreach ($attendig as $valueeeee) {
                            array_push($authority,trim($valueeeee));
                         }
                      }

            foreach ($value->reportedaction as $v) {
                array_push( $AccionesReportadasAuthority,explode("|", $v->implode_attendig));
                array_push( $arraytypeReportedAction , explode("|", $v->implode_action));
            }
        }

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

        $authority = array_count_values( $authority);
        $dataAuthority = [];
        foreach ($authority as $key => $value) {
           array_push($dataAuthority,["name"=>$key,"count"=>$value]);
        }
       // dd($dataAuthority );


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

       $r = [];
       foreach($arraytypeReportedAction as $value){
           foreach ($value as $v) {
            array_push($r, trim($v) );
          }
       }
       $dashboardReportedActions = [];
       foreach (array_count_values($r) as $key => $value) {
            array_push($dashboardReportedActions, array("name" => $key , "count"=> $value) );
       }



    $sql_recommendation = DB::table('recommendations')
    ->select('action.name as actionName', DB::raw('COUNT(action.name) as totalName') )
    ->join("action_recommendation as actionR", "actionR.recommendation_id", "=", "recommendations.id")
    ->join("cat_solidarity_actions as action", "action.id", "=", "actionR.cat_solidarity_action_id")
    ->groupBy('action.name')
    ->where('recommendations.isActive', '=', 1)
    ->where('recommendations.isPublished', '=', 1)
    ->get();

     //$Actionname = array();

     $actions = [];
     $sum = 0;
     foreach ($sql_recommendation as $value) {
         array_push($actions, ["name" => $value->actionName, "count" => $value->totalName]);
         if($value->totalName > 0){
          $sum = $sum + $value->totalName;
         }
     }
     $resultsActions = [ "total" => $sum,
                         "data" => $actions];

    function catEntityfn($id){
            $CatEntity = CatEntity::findOrFail($id);
           // $CatEntity->name = explode('-',$CatEntity->name);
            $CatEntity->acronym = explode('-',$CatEntity->acronym);

            return $CatEntity->acronym[0];
    }

         $catAcction = CatSolidarityAction::where('isActive',1)->get();  //Acciones

         $entidad = Recommendation::select('cat_entity_id as entidad',
                         DB::raw('COUNT(cat_entity_id ) as total'))
                                 ->distinct('cat_entity_id')
                                 ->where('isActive','=', 1)
                                 ->where('isPublished','=', 1)
                                 ->groupBy('cat_entity_id')
                                 ->get();

                                 $arrayEntidad = [];
                                 foreach ($entidad as $value) {
                                    array_push( $arrayEntidad, ['total' => $value->total,
                                                       'entidad' => catEntityfn($value->entidad) ] );
                                 }

                                 $data = array();
                                    foreach ($catAcction as $value) {
                                        array_push($data, array('name' => $value->name,
                                                                  'id' => $value->id));
                                    }

                                 $date = Recommendation::select('date as fecha',
                                 DB::raw('COUNT(date ) as total'))
                                         ->distinct('date')
                                         ->where('isActive','=', 1)
                                         ->where('isPublished','=', 1)
                                         ->groupBy('date')
                                         ->orderBy('total', 'ASC')
                                         ->get(['fecha','total']);


        $arrayDate = array();
        foreach ($date as $value){
        array_push($arrayDate, array('total'=>$value->total,'date'=>$value->fecha ));
        }


       // dd($datosReportadasAuthority );

        return response()->json([
            'success'  => true,
            'lResults' => ['entity' => $arrayEntidad,
                         'ridhYear' => $arrayDate,
                          'actions' => $resultsActions,
         'dashboardReportedActions' => $dashboardReportedActions,
                     'dashboardOds' => $dataOds,
               'dashboardAuthority' => $dataAuthority,
     'dashboardReportadasAuthority' => $datosReportadasAuthority]

        ],200);

    }

}
