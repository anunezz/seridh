<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Recommendation;
use App\Http\Models\Visits;
use App\Http\Models\Cats\CatEntity;//Entidad emisora 1
use App\Http\Models\Cats\CatGobOrder; //Orden de gobierno 2
use App\Http\Models\Cats\CatGobPower; //Poder de gobierno 3
use App\Http\Models\Cats\CatAttending; //Entidad encargada de attender
use App\Http\Models\Cats\CatRightsRecommendation; //Derechos de la recomendacion 4
use App\Http\Models\Cats\CatPopulation; //Poblacion 5
use App\Http\Models\Cats\CatSolidarityAction; //Accion solidaria 6
//use App\Http\Models\Cats\CatReviewRight; // Revision de los derechos de la recocmendacion 8
use App\Http\Models\Cats\CatReviewTopic; // Revision de tema(s) 9
use App\Http\Models\Cats\CatSubtopic; // Revision de subtema(s) 10
use App\Http\Models\Cats\CatOds; //ODS(Objetivo de Desarrollo Sostenible) 10
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RecommendationExport;
use Exception;

// use DB;
class PublicController extends Controller
{
    public function count(){
        $recommendation = Recommendation::where('isActive','=', 1)->where('isPublished','=', 1)->count();
        $visits = new Visits;
        $CatEntity = CatEntity::where('isActive','=', 1)->count();

        return response()->json([
            'success' => true,
            'recommendation'=>$recommendation,
            'visits' => $visits,
            'issuingEntities' => $CatEntity
        ],200);
    }
    public function visits(Request $request){
       $visit = Visits::findOrFail($request->id);
       $visit->visits = $visit->visits + 1;
       $visit->save();
       $visitSum = Visits::sum('visits');
         return response()->json([
             'success' => true,
             'lResults'=> $visitSum
         ],200);
      }
      public function labelsForm(){
        $CatAttending    = CatAttending::where('isActive', 1)->get(['id', 'name']);
        $CatEntity       = CatEntity::where('isActive', 1)->get(['id', 'name']);
        $CatGobOrder     = CatGobOrder::where('isActive', 1)->get(['id', 'name']);
        $CatGobPower     = CatGobPower::where('isActive', 1)->get(['id', 'name']);
        $CatOds          = CatOds::where('isActive', 1)->get(['id', 'name']);
        $CatPopulation   = CatPopulation::where('isActive', 1)->get(['id', 'name']);
        $CatSolidarityAction = CatSolidarityAction::where('isActive', 1)->get(['id', 'name']);
        $CatRightsRecommendation = CatRightsRecommendation::where('isActive', 1)->get(['id', 'name']);
       // $CatReviewRight  = CatReviewRight::where('isActive', 1)->get(['id', 'name']);
      //  $CatReviewTopic   = CatReviewTopic::where('isActive', 1)->get(['id', 'name']);
        $CatSubtopic     = CatSubtopic::where('isActive', 1)->get(['id', 'name']);
        $years            = DB::table('recommendations')->select(DB::raw('YEAR(created_at) as year'))
                                                       ->where('isActive', 1)
                                                       ->groupBy('year')
                                                       ->orderBy('year', 'desc')
                                                       ->get();



        $data = array(
            "0" => array("id"=> 0,"name"=>"Año","data"=> $years),
            "1" => array("id"=> 1,"name"=>"Entidad emisora","data"=>$CatEntity),
            "2" => array("id"=> 2,"name"=>"Población","data"=> $CatPopulation),
            "3" => array("id"=> 3,"name"=>"Revisión de tema(s)","data"=> ''),
            "4" => array("id"=> 4,"name"=>"Entidad encargada de atender","data"=>$CatAttending),
            "5" => array("id"=> 5,"name"=>"ODS","data"=> $CatOds),
            '6' => array("id"=> 6,"name"=>"Buscar Recomendación","data"=>'')//,
            //'7' => array("id"=> 7,"name"=>"Buscar Recomendación prueba","data"=>'')
        );

        return response()->json([
            'success' => true,
            'lResults'=> $data
        ],200);
      }

      public function recommendationFilter(Request $request){

            $recommendation = Recommendation::with('ods')->where('isActive','=', 1)->where('isPublished','=', 1)
                    ->orWhere(function ($query) use($request){
                        foreach($request->date as $created_at_value){
                          $query->orWhereYear('created_at',$created_at_value);
                        }
                    })->orWhere(function ($query) use($request){
                          foreach($request->entity_id as $entity_id_value){
                            $query->orWhere('cat_entity_id',$entity_id_value);
                          }
                    })->get();

                    // dd($recommendation);

                    return response()->json([
                        'success' => true,
                        'lResults'=> $recommendation
                    ],200);
      }


      public function listPdf(Request $request){
        $recommendation = Recommendation::where('isActive','=', 1)->where('isPublished','=', 1)->get();
            $count = 4;
            $pdf = \PDF::loadView('files.recommendationpdf',['count'=>$count]);
            return $pdf->download('recomendaciones.pdf');
      }

      public function listExcel(){
        return Excel::download(new RecommendationExport(), 'recomendacionesexcel.xlsx');
      }

      public function listWord(){

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

            $section1 = $phpWord->AddSection();
            $section1->addText("Filtros de recomendaciones",array("size"=>10,"bold"=>true,"align"=>"right")); // Agregamos un titulo al documento con tamaño 22 y en negritas

            $styleTable = array('borderSize' => 6, 'borderColor' => 'black', 'cellMargin' => 40); // el borde de la tabla de 6px, color de borde = #888 , ...
            $styleFirstRow = array('borderBottomColor' => 'black', 'bgColor' => '#13322B');
            $phpWord->addTableStyle('table1', $styleTable,$styleFirstRow);

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
}
