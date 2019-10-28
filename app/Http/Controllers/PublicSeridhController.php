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
use Illuminate\Support\Facades\DB;
// use DB;
class PublicSeridhController extends Controller
{
    public function count(){
        $recommendation = Recommendation::where('isActive','=', 1)->where('isPublished','=', 1)->count();
        $visits = new VisitsQuery;
        $CatEntity = CatEntity::where('isActive','=', 1)->count();

        return response()->json([
            'success' => true,
            'recommendation'=>$recommendation,
            'visits' => $visits,
            'issuingEntities' => $CatEntity
        ],200);
    }
    public function visits(Request $request){
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
        $CatAttending    = CatAttending::where('isActive', 1)->get();
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
                                                       ->orderBy('year', 'desc')
                                                       ->get();
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
        'cat_population_id','cat_review_topic_id','cat_attendig_id','cat_ods_id')
        ->where('isActive','=', 1)->where('isPublished','=', 1)
          ->where(function ($query) use($request){
              $query->orWhereIn('cat_entity_id',$request->entity_id)
                    ->orWhereIn('cat_population_id',$request->population_id)
                    ->orWhereIn('cat_review_topic_id',$request->review_topic_id)
                    ->orWhereIn('cat_attendig_id',$request->attendig_id);
                foreach($request->date as $value){
                  $query->orWhereYear('created_at',$value);
                }
            })->orderBy('id', 'desc')->paginate(2);

                    return response()->json([
                        'success' => true,
                        'lResults'=> $recommendation,
                        'pagination' => [
                            'total'        => $recommendation->total(),
                            'current_page' => $recommendation->currentPage(),
                            'per_page'     => $recommendation->perPage(),
                            'last_page'    => $recommendation->lastPage(),
                            'from'         => $recommendation->firstItem(),
                            'to'           => $recommendation->lastItem(),
                        ]
                    ],200);
      }
}
