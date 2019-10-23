<?php

namespace App\Imports;

use App\Http\Models\Cats\CatAttending;
use App\Http\Models\Cats\CatEntity;
use App\Http\Models\Cats\CatGobOrder;
use App\Http\Models\Cats\CatGobPower;
use App\Http\Models\Cats\CatOds;
use App\Http\Models\Cats\CatPopulation;
use App\Http\Models\Cats\CatReviewRight;
use App\Http\Models\Cats\CatReviewTopic;
use App\Http\Models\Cats\CatRightsRecommendation;
use App\Http\Models\Cats\CatSolidarityAction;
use App\Http\Models\Cats\CatSubtopic;
use App\Http\Models\Recommendation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use stdClass;

class FirstSheetImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $errorRe = [];
        foreach ($rows as $row) {
            if (($row[0] != "Texto de recomendación")) {
                $col=false;
                for ($i=0;$i<14;$i++){
                    if (is_null($row[$i])){
                        $col=true;
                    }
                }

                /*obtener ids*/
                $findRecommendation = '<p style="font-family: Montserrat; font-size: 14px; font-style: normal; font-weight: normal;">'.$row[0].'</p>';
                $existRecommendation = Recommendation::where('recommendation',$findRecommendation)->where('isActive',1)->first();
                $entity = CatEntity::where('name',$row[1])->where('isActive',1)->first();
                $gobOrder = CatGobOrder::where('name',$row[2])->where('isActive',1)->first();
                $gobPower = CatGobPower::where('name',$row[3])->where('isActive',1)->first();
                $attending = CatAttending::where('name',$row[4])->where('isActive',1)->first();
                $rightsRe = CatRightsRecommendation::where('name',$row[5])->where('isActive',1)->first();
                $population = CatPopulation::where('name',$row[6])->where('isActive',1)->first();
                $solidarityAction = CatSolidarityAction::where('name',$row[7])->where('isActive',1)->first();
                $reviewRight = CatReviewRight::where('name',$row[8])->where('isActive',1)->first();
                $review_topic = CatReviewTopic::where('name',$row[9])->where('isActive',1)->first();
                $subtopic = CatSubtopic::where('name',$row[10])->where('isActive',1)->first();
                $comments = '<p style="font-family: Montserrat; font-size: 14px; font-style: normal; font-weight: normal;">'.$row[12].'</p>';
                $isPublished = $row[13]=='Si'?1:0;
                /************/

                /*separar ods del excel y agregar ids*/
                $odsIds= array();
                $ods = str_replace(", ",",",$row[11] );
                $ods = explode(",", $ods);
                foreach ($ods as $od){
                    $fetchIds = CatOds::where('name',$od)->pluck('id')->first();
                    if (count($odsIds)>0){
                        $existID=false;
                        foreach ($odsIds as $x){
                            if ($fetchIds===$x) $existID=true;
                        }
                        if($existID===false) array_push($odsIds,$fetchIds);
                    }else{
                        array_push($odsIds,$fetchIds);
                    }
                }
                /********************************/

                if ($col===false){
                    if (is_null($existRecommendation )){
                        $recommendation = new Recommendation();
                        $recommendation -> user_id = auth()->user()->id;
                        $recommendation -> recommendation = $findRecommendation;
                        $recommendation -> cat_entity_id = $entity->id;
                        $recommendation -> cat_gob_order_id = $gobOrder->id;
                        $recommendation -> cat_gob_power_id = $gobPower->id;
                        $recommendation -> cat_attendig_id = $attending->id;
                        $recommendation -> cat_rights_recommendation_id = $rightsRe->id;
                        $recommendation -> cat_population_id = $population->id;
                        $recommendation -> cat_solidarity_action_id = $solidarityAction->id;
                        $recommendation -> cat_review_right_id = $reviewRight->id;
                        $recommendation -> cat_review_topic_id = $review_topic->id;
                        $recommendation -> cat_subtopic_id = $subtopic->id;
                        $recommendation -> cat_ods_id = null;
                        $recommendation -> comments = $comments;
                        $recommendation -> isPublished = $isPublished;
                        $recommendation->save();
                        $recommendation->ods()->sync($odsIds);
                    }
                }else{

                    $errorRows = new stdClass();
                    $errorRows->recommendation = $findRecommendation;
                    $errorRows->ods = $row[11];
                    $errorRows->entity = $entity;
                    $errorRows->gobOrder = $gobOrder;
                    $errorRows->gobPower = $gobPower;
                    $errorRows->attending = $attending;
                    $errorRows->rightsRe = $rightsRe;
                    $errorRows->population = $population;
                    $errorRows->solidarityAction = $solidarityAction;
                    $errorRows->reviewRight = $reviewRight;
                    $errorRows->review_topic = $review_topic;
                    $errorRows->subtopic = $subtopic;
                    $errorRows->comments = $comments;
                    $errorRows->isPublished = $isPublished;
                    $errorRows->odsIds = $odsIds;
                    $newRow = (array)$errorRows;
                    array_push($errorRe, $newRow);
                }
            }
        }
        session(["errorMasivo"=>$errorRe]);
    }
}
