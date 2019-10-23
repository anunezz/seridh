<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Recommendation;
use App\Http\Models\VisitsQuery;
use App\Http\Models\Cats\CatEntity;//Entidad emisora 1
use App\Http\Models\Cats\CatGobOrder; //Orden de gobierno 2
use App\Http\Models\Cats\CatGobPower; //Poder de gobierno 3
use App\Http\Models\Cats\CatAttending; //Entidad encargada de attender
use App\Http\Models\Cats\CatRightsRecommendation; //Derechos de la recomendacion 4
use App\Http\Models\Cats\CatPopulation; //Poblacion 5
use App\Http\Models\Cats\CatSolidarityAction; //Accion solidaria 6
use App\Http\Models\Cats\CatReviewRight; // Revision de los derechos de la recocmendacion 8
use App\Http\Models\Cats\CatReviewTopic; // Revision de tema(s) 9
use App\Http\Models\Cats\CatSubtopic; // Revision de subtema(s) 10
use App\Http\Models\Cats\CatOds; //ODS(Objetivo de Desarrollo Sostenible) 10
//use Illuminate\Support\Facades\DB;
use DB;
class PublicSeridhController extends Controller
{
    public function count(){
        //if(!$request->ajax()) return redirect('/');
        $recommendation = Recommendation::where('isActive','=', 1)->where('isPublished','=', 1)->count();
        $visits = new VisitsQuery;
        $CatEntity = Recommendation::select('cat_entity_id')->where('cat_entity_id','!=', null)->where('isActive','=', 1)->where('isPublished','=', 1)->count();

        return response()->json([
            'success' => true,
            'recommendation'=>$recommendation,
            'visits' => $visits,
            'issuingEntities' => $CatEntity
        ],200);
    }
    public function visits(Request $request){
      // if(!$request->ajax()) return redirect('/');
       $visit = VisitsQuery::findOrFail($request->id);
       $visit->visits = $visit->visits + 1;
       $visit->save();
       $visitSum = VisitsQuery::sum('visits');
         return response()->json([
             'success' => true,
             'lResults'=> $visitSum
         ],200);
      }
      public function labelsForm(){
        $CatAttending    = CatAttending::select('name')->get();
        $CatEntity       = CatEntity::where('isActive', 1)->get();
        $CatGobOrder     = CatGobOrder::where('isActive', 1)->get();
        $CatGobPower     = CatGobPower::where('isActive', 1)->get();
        $CatOds          = CatOds::where('isActive', 1)->get();
        $CatPopulation   = CatPopulation::where('isActive', 1)->get();
        $CatSolidarityAction = CatSolidarityAction::where('isActive', 1)->get();
        $CatRightsRecommendation = CatRightsRecommendation::where('isActive', 1)->get(['id', 'name']);
        $CatReviewRight  = CatReviewRight::where('isActive', 1)->get();
        $CatReviewTopic   = CatReviewTopic::where('isActive', 1)->get();
        $CatSubtopic     = CatSubtopic::where('isActive', 1)->get();
        $YEAR            = DB::table('recommendations')->select(DB::raw('YEAR(created_at) as year'))
                                                       ->where('isActive', 1)
                                                       ->groupBy('year')
                                                       ->get();



        // $data = array(
        //     "0" => array("id"=> 0,"name"=>"Entidad emisora","data"=>$CatEntity),
        //     "1" => array("id"=> 1,"name"=>"Orden de gobierno","data"=>$CatGobOrder),
        //     "2" => array("id"=> 2,"name"=>"Poder de gobierno","data"=>$CatGobPower),
        //     "3" => array("id"=> 3,"name"=>"Entidad encargada de atender","data"=>$CatAttending),
        //     "4" => array("id"=> 4,"name"=>"Derechos de la recomendación","data"=>$CatRightsRecommendation),
        //     "5" => array("id"=> 5,"name"=>"Población","data"=> $CatPopulation),
        //     "6" => array("id"=> 6,"name"=>"Acción Solidaria","data"=> $CatSolidarityAction),
        //     "7" => array("id"=> 7,"name"=>"Revisión de los derechos de la recomendación","data"=> $CatReviewRight),
        //     "8" => array("id"=> 8,"name"=>"Revisión de tema(s)","data"=> $CatReviewTopic),
        //     "9" => array("id"=> 9,"name"=>"Revisión de subtema(s)","data"=> $CatSubtopic ),
        //     "10" => array("id"=>10,"name"=>"ODS (Objetivos de Desarrollo Sostenible)","data"=> $CatOds),
        // );



        $currentYear = date("Y");
        $years = array();
        $sum = intval($currentYear);
        for ($i=0; $i < 17; $i++){
                $value = $currentYear - $i;
                array_push($years, array( "name" => $value , 'id'=>$value) );
            }





        $data = array(
            "0" => array("id"=> 0,"name"=>"Año","data"=> $YEAR),
            "1" => array("id"=> 1,"name"=>"Entidad emisora","data"=>$CatEntity),
            "2" => array("id"=> 2,"name"=>"Población","data"=> $CatPopulation),
            "3" => array("id"=> 3,"name"=>"Revisión de tema(s)","data"=> $CatReviewTopic),
            "4" => array("id"=> 4,"name"=>"Entidad encargada de atender","data"=>$CatAttending),
            "5" => array("id"=> 5,"name"=>"ODS","data"=> $CatOds),
            '6' => array("id"=> 6,"name"=>"Buscar Recomendación","data"=>'')
        );


        return response()->json([
            'success' => true,
            'lResults'=> $data,
            'EntidadEncargadadeatender'=> $CatAttending
        ],200);
      }


      public function recommendationFilter(Request $request){




        $recommendation = DB::table('recommendations')->select('id','created_at','cat_entity_id',
        'cat_population_id','cat_review_topic_id','cat_ods_id')
        ->where('isActive','=', 1)->where('isPublished','=', 1)
          ->where(function ($query) use($request){
              $query->orWhereIn('cat_entity_id',$request->entity_id);
                foreach($request->date as $value){
                  $query->orWhereYear('created_at',$value);
                }

                  // ->orWhereIn('cat_gob_power_id', [2,1])
                  // ->orWhereIn('cat_attendig_id', [2,1]); //entidad encargada de atender
                  // derechos de la recomendacion cat_rights_recommendation_id
                  // poblacion cat_population_i
                  // accion solkdaria cat_solidarity_action_id
                  // revision de derechos de la recomendacion    cat_review_right_id
                  // revision de temas    cat_review_topic_id
                  // revision de subtemas  cat_subtopic_id
                  // ODS (Objetivos de Desarrollo Sostenible)  cat_ods_i
          })->orderBy('id', 'desc')->get();
                    return response()->json([
                        'success' => true,
                        'lResults'=> $recommendation
                    ],200);
      }
}
