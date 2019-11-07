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
use App\Http\Models\Cats\CatSubcategorySubrights;
use App\Http\Models\Cats\CatSubRights;
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
                $findRecommendation = '<p style="font-family: Montserrat; font-size: 14px; font-style: normal; font-weight: normal;">'.trim($row[0]).'</p>';
                $existRecommendation = Recommendation::where('recommendation',$findRecommendation)->where('isActive',1)->first();
                $entity = CatEntity::where('name',trim($row[1]))->where('isActive',1)->pluck('id')->first();

                /*obtener ids Orden de Gobiernos*/
                $gobOrders = explode("||", $row[2]);
                $idsGob=[];
                foreach ($gobOrders as $gob){
                    $id = CatGobOrder::where('name',trim($gob))->where('isActive',1)->pluck('id')->first();
                    if (isset($id)){
                        array_push($idsGob,$id);
                    }
                    $id=null;
                }

                /*obtener ids Poder de Gobierno*/
                $powerGob = explode("||", $row[3]);
                $idsPow=[];
                foreach ($powerGob as $pow){
                    $id = CatGobPower::where('name',trim($pow))->where('isActive',1)->pluck('id')->first();
                    if (isset($id)){
                        array_push($idsPow,$id);
                    }
                    $id=null;
                }

                /*obtener ids Entidad encargada de atender*/
                $entEnc = explode("||", $row[4]);
                $idsEnt=[];
                foreach ($entEnc as $en){
                    $id = CatAttending::where('name',trim($en))->where('isActive',1)->pluck('id')->first();
                    if (isset($id)){
                        array_push($idsEnt,$id);
                    }
                    $id=null;
                }

                /*obtener ids Población*/
                $population = explode("||", $row[5]);
                $idsPop=[];
                foreach ($population as $pop){
                    $id = CatPopulation::where('name',trim($pop))->where('isActive',1)->pluck('id')->first();
                    if (isset($id)){
                        array_push($idsPop,$id);
                    }
                    $id=null;
                }

                /*obtener ids Acción solidaria*/
                $actionS = explode("||", $row[6]);
                $idsAct=[];
                foreach ($actionS as $act){
                    $id = CatSolidarityAction::where('name',trim($act))->where('isActive',1)->pluck('id')->first();
                    if (isset($id)){
                        array_push($idsAct,$id);
                    }
                    $id=null;
                }

                /*obtener ids ODS*/
                $ods = explode("||", $row[7]);
                $idsOds=[];
                foreach ($ods as $od){
                    $id = CatOds::where('name',trim($od))->where('isActive',1)->pluck('id')->first();
                    if (isset($id)){
                        array_push($idsOds,$id);
                    }
                    $id=null;
                }

                /*obtener ids Temas*/
                $themes = explode("||", $row[10]);
                $listThemes=[];
                foreach ($themes as $theme){
                    $them = CatSubtopic::where('name',trim($theme))->where('isActive',1)->first();
                    if (isset($them)){
                        $listThemes[$them['id']]=[
                            'cat_topic_id' => $them['cat_topic_id']
                        ];
                    }
                    $them=null;
                }


                $comments = '<p style="font-family: Montserrat; font-size: 14px; font-style: normal; font-weight: normal;">'.trim($row[11]).'</p>';
                $anio = (string)$row[12];
                $isPublished = $row[13]=='Si'?1:0;


                //dd($idsOds);
                /*crear recomendación*/
                if (is_null($existRecommendation )) {
                    //if ($col === false) {

                    $recommendation = new Recommendation();
                    $recommendation->user_id = auth()->user()->id;
                    $recommendation->recommendation = $findRecommendation;
                    $recommendation->cat_entity_id = $entity;
                    $recommendation->date = $anio;
                    $recommendation->comments = $comments;
                    $recommendation->isPublished = $isPublished;
                    $recommendation->save();

                    $recommendation->ods()->sync($idsOds);
                    $recommendation->order()->sync($idsGob);
                    $recommendation->power()->sync($idsPow);
                    $recommendation->attendig()->sync($idsEnt);
                    $recommendation->population()->sync($idsPop);
                    $recommendation->action()->sync($idsAct);
                    $recommendation->subtopic()->sync($listThemes);





                    /*obtener ids Derechos*/
                    $rights = explode("||", $row[8]);
                    $idsRights=[];
                    foreach ($rights as $right){
                        $id = CatSubRights::where('name',trim($right))->where('isActive',1)->first();
                        if (isset($id)){
                            $idsRights[$id['rights_recommendations_id']]=[
                                'subrigth_id' => $id['id'],
                                'subcategory_subrights_id' => null
                            ];
                            $recommendation->right()->attach($idsRights);
                        }
                        $id=null;
                        $idsRights=[];
                    }

                    /*obtener ids Subderechos y asociar con recomendación*/
                    $subRights = explode("||", $row[9]);
                    $idsSubRights=[];
                    foreach ($subRights as $subright){
                        $id = CatSubcategorySubrights::where('name',trim($subright))->where('isActive',1)->first();
                        $idAux = CatSubRights::where('id',trim($id['sub_rights_id']))->where('isActive',1)->pluck('rights_recommendations_id')->first();
                        if (isset($id)){
                            $idsSubRights[$idAux ]=[
                                'subrigth_id' => $id['sub_rights_id'],
                                'subcategory_subrights_id' => $id['id']
                            ];
                            $recommendation->right()->attach($idsSubRights);
                        }
                        $id=null;
                        $idsSubRights=[];
                    }
                    /*  } else {

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
                      }*/
                }
            }
        }
        session(["errorMasivo"=>$errorRe]);
    }
}
