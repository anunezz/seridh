<?php

namespace App\Http\Controllers;

use App\Http\Models\Cats\CatAttending;
use App\Http\Models\ReportedAction;
use Cache;
use Illuminate\Http\Request;
use DB;

class ReportedActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        dd($request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('create');
    }


    public function store(Request $request)
    {
        $iniAut='';
        if (count($request->cat_attendig_id)>1){
            $iniAut = 'VAEA';
        }else{
            $attending = CatAttending::find($request->cat_attendig_id[0]);
            $name = str_replace(" ", "", trim($attending->name));
            for ($i=0;$i<strlen($name);$i++){
                if(preg_match("/[A-Z]/", $name[$i])===1) {
                    $iniAut = $iniAut.$name[$i];
                }
            }
        }
        $data = $request->all();

        $num = ReportedAction::whereRecommendationId(decrypt($data['recommendation_id']))->count();
        $num++;
        while (strlen($num)<3){
            $num= '0'.$num;
        }
        $folio = $data['invoiceRe'].$iniAut.$num;

        $data['invoice'] = $folio;
        $data['recommendation_id'] = decrypt($data['recommendation_id']);

        try {
            $reportedAction = new ReportedAction();
            $reportedAction->fill($data);
            $reportedAction->save();

            $reportedAction->action()->sync($data['cat_solidarity_action_id']);
            $reportedAction->population()->sync($data['cat_population_id']);
            $reportedAction->attendig()->sync($data['cat_attendig_id']);

            return response()->json([
                'success' => true,
                'folio' => $reportedAction->invoice,
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }


    public function show($id)
    {
        try {
            if (request()->wantsJson()){
                $relations = ['action:id','population:id','attendig:id'];
                $reportedActions = ReportedAction::with($relations)->whereRecommendationId(decrypt($id))
                    ->whereIsactive(1)->orderBy('id','desc')->get();

                $listReportedActions=[];
                foreach ($reportedActions as $reported){
                    $arrayActions = [];
                    foreach ($reported->action as $action){
                        array_push($arrayActions,$action->id);
                    }
                    $arrayPopulations = [];
                    foreach ($reported->population as $population){
                        array_push($arrayPopulations,$population->id);
                    }
                    $arrayAttendig = [];
                    foreach ($reported->attendig as $attendig){
                        array_push($arrayAttendig,$attendig->id);
                    }

                    $listReportedActions[]=[
                        'id'=> encrypt($reported->id),
                        'invoice'=>$reported->invoice,
                        'date'=>$reported->date,
                        'description'=>$reported->description,
                        'cat_solidarity_action_id' => $arrayActions,
                        'cat_population_id' => $arrayPopulations,
                        'cat_attendig_id' => $arrayAttendig
                    ];
                }
                return response()->json([
                    'reportedActions'     => $listReportedActions,
                ]);
            }else{
                return response()->view('errors.404', [], 404);
            }
        }
        catch ( \Exception $e ) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd('edit');
    }

    public function update(Request $request, $id)
    {


        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['recommendation_id'] = decrypt($data['recommendation_id']);
            $reportedAction = ReportedAction::find(decrypt($id));
            $reportedAction->fill($data);
            $reportedAction->save();

            $reportedAction->action()->sync($data['cat_solidarity_action_id']);
            $reportedAction->population()->sync($data['cat_population_id']);
            $reportedAction->attendig()->sync($data['cat_attendig_id']);
            DB::commit();
            Cache::forget('dashboard');
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

    public function destroy($id)
    {
        try {

            $reportedAction = ReportedAction::find(decrypt($id));

            $reportedAction->isActive = 0;
            $reportedAction->save();

            GeneralController::saveTransactionLog(4,
                'Elimina una recomendación con id: ' . $reportedAction->id);
            Cache::forget('dashboard');
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
