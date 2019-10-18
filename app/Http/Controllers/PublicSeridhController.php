<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Recommendation;
use App\Http\Models\VisitsQuery;
//use Illuminate\Support\Facades\DB;
use DB;


class PublicSeridhController extends Controller
{
    public function count(){
        //if(!$request->ajax()) return redirect('/');
        $recommendation = Recommendation::where('isActive', 1)->where('isPublished', 1)->count();
        $visits = new VisitsQuery;

        return response()->json([
            'success' => true,
            'recommendation'=>$recommendation,
            'visits' => $visits
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


}
