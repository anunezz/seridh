<?php

namespace App\Imports;

use App\Http\Models\Cats\CatAttending;
use App\Http\Models\Cats\CatAttentionClassification;
use App\Http\Models\Cats\CatEntity;
use App\Http\Models\Cats\CatGoalsOds;
use App\Http\Models\Cats\CatGobOrder;
use App\Http\Models\Cats\CatGobPower;
use App\Http\Models\Cats\CatIndicator;
use App\Http\Models\Cats\CatLevelAttention;
use App\Http\Models\Cats\CatOds;
use App\Http\Models\Cats\CatPopulation;
use App\Http\Models\Cats\CatReviewRight;
use App\Http\Models\Cats\CatReviewTopic;
use App\Http\Models\Cats\CatRightsRecommendation;
use App\Http\Models\Cats\CatSolidarityAction;
use App\Http\Models\Cats\CatSubcategorySubrights;
use App\Http\Models\Cats\CatSubRights;
use App\Http\Models\Cats\CatSubtopic;
use App\Http\Models\Cats\DataControl;
use App\Http\Models\DocumentRecommendation;
use App\Http\Models\Recommendation;
use App\Http\Models\ReportedAction;
use App\Http\Traits\GoalsOdsTrait;
use App\Http\Traits\TopicsTrait;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Http\Traits\RightsTrait;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use stdClass;

class FirstSheetImport implements ToModel, WithBatchInserts, WithChunkReading
{
    protected $fila = 1;
    protected $errorRe = [];
    protected $errorsReportedActions = [];
    protected $goodReportedActions = [];
    public function model(array $row)
    {
        if (count($this->errorsReportedActions)==0){
            $this->errorsReportedActions = session('errorsReportedActions');
        }
        if (count($this->goodReportedActions)==0){
            $this->goodReportedActions = session('reportedActions');
        }
        if (($row[0] != "Texto de recomendación") && ($row[0] != "Ejemplo")) {
            $emptyRow = false;
            foreach ($row as $ro){
                if ($ro != null){
                    $emptyRow = true;
                }
            }
            if ($emptyRow){
                $col=false;
                for ($i=0;$i<12;$i++){
                    if (is_null($row[$i])){
                        $col=true;
                    }
                }

                /*obtener ids*/
                $this->errorRecommendation = [];
                if (is_null($row[0])){
                    array_push($this->errorRecommendation,'No tiene texto de recomenación');
                    $col=true;
                }
                $findRecommendation = '<p style="font-family: Montserrat; font-size: 14px; font-style: normal; font-weight: normal;">'.trim($row[0]).'</p>';
                $existRecommendation = Recommendation::where('recommendation',$findRecommendation)->where('isActive',1)->first();
                $entity = CatEntity::where('name',trim($row[1]))->where('isActive',1)->first();

                $errorEntity=[];
                $folio='';
                if (is_null($entity)){
                    array_push($errorEntity,$row[1]);
                    $col=true;
                }else{
                    $siglasE = $entity->acronym;
                    $num = Recommendation::where('cat_entity_id',$entity->id)->count();
                    $num++;
                    while (strlen($num)<4){
                        $num= '0'.$num;
                    }
                    $folio = $siglasE.$row[11].$num;
                }

                /*obtener ids Orden de Gobiernos*/
                $gobOrders = explode("||", $row[2]);
                $idsGob=[];
                $errorGob=[];
                if ($row[2]!=null){
                    foreach ($gobOrders as $gob){
                        if (strlen($gob)>0){
                            $id = CatGobOrder::where('name',trim($gob))->where('isActive',1)->pluck('id')->first();
                            if (isset($id)){
                                array_push($idsGob,$id);
                            }else{
                                array_push($errorGob,$gob);
                                $col=true;
                            }
                        }
                        $id=null;
                    }
                }else{
                    array_push($errorGob,'Columna vacía.');
                    $col=true;
                }

                /*obtener ids Poder de Gobierno*/
                $powerGob = explode("||", $row[3]);
                $idsPow=[];
                $errorPow=[];
                if ($row[3]!=null){
                    foreach ($powerGob as $pow){
                        if (strlen($pow)>0){
                            $id = CatGobPower::where('name',trim($pow))->where('isActive',1)->pluck('id')->first();
                            if (isset($id)){
                                array_push($idsPow,$id);
                            }else{
                                array_push($errorPow,$pow);
                                $col=true;
                            }
                        }
                        $id=null;
                    }
                }else{
                    array_push($errorPow,'Columna vacía.');
                    $col=true;
                }

                /*obtener ids Autoridad encargada de atender*/
                $entEnc = explode("||", $row[4]);
                $idsEnt=[];
                $errorAuthority=[];
                if ($row[4]!=null){
                    foreach ($entEnc as $en){
                        if (strlen($en)>0){
                            $id = CatAttending::where('name',trim($en))->where('isActive',1)->pluck('id')->first();
                            if (isset($id)){
                                array_push($idsEnt,$id);
                            }else{
                                array_push($errorAuthority,$en);
                                $col=true;
                            }
                        }
                        $id=null;
                    }
                }else{
                    array_push($errorAuthority,'Columna vacía.');
                    $col=true;
                }

                /*obtener ids Población*/
                $population = explode("||", $row[5]);
                $idsPop=[];
                $errorPop=[];
                if ($row[5]!=null){
                    foreach ($population as $pop){
                        if (strlen($pop)>0){
                            $id = CatPopulation::where('name',trim($pop))->where('isActive',1)->pluck('id')->first();
                            if (isset($id)){
                                array_push($idsPop,$id);
                            }else{
                                array_push($errorPop,$pop);
                                $col=true;
                            }
                        }
                        $id=null;
                    }
                }else{
                    array_push($errorPop,'Columna vacía.');
                    $col=true;
                }


                /*obtener ids Acción solidaria*/
                $actionS = explode("||", $row[6]);
                $idsAct=[];
                $errorAction = [];
                if ($row[6]!=null){
                    foreach ($actionS as $act){
                        if (strlen($act)>0){
                            $id = CatSolidarityAction::where('name',trim($act))->where('isActive',1)->pluck('id')->first();
                            if (isset($id)){
                                array_push($idsAct,$id);
                            }else{
                                array_push($errorAction,$act);
                                $col=true;
                            }
                        }else{
                            array_push($errorAction,'Columna vacía.');
                            $col=true;
                        }
                        $id=null;
                    }
                }else{
                    array_push($errorAction,'Columna vacía.');
                    $col=true;
                }

                /*obtener ids ODS*/
                $ods = explode("||", $row[7]);
                $idsOds=[];
                $listGoalsOds=[];
                $auxGoalsOd = [];
                $errorOds = [];
                if ($row[7]){
                    foreach ($ods as $od){
                        if (strlen($od)>0){
                            $id = CatGoalsOds::whereAcronym(trim($od))->whereIsactive(1)->first();
                            if (isset($id)){
                                $listGoalsOds[$id->id]=[
                                    'ods_id' => $id->ods_id
                                ];
                                array_push($auxGoalsOd ,$id);
                            }else{
                                array_push($errorOds,$od);
                                $col=true;
                            }
                        }
                        $id=null;
                    }
                }else{
                    array_push($errorOds,'Columna vacía.');
                    $col=true;
                }

                /*obtener ids Temas*/
                $themes = explode("||", $row[9]);
                $listThemes=[];
                $auxTopics = [];
                $erroreTopics = [];
                if ($row[9]!=null){
                    foreach ($themes as $theme){
                        if (strlen($theme)>0){
                            $them = CatSubtopic::where('name',trim($theme))->where('isActive',1)->first();
                            if (isset($them)){
                                $listThemes[$them['id']]=[
                                    'cat_topic_id' => $them['cat_topic_id']
                                ];
                                array_push($auxTopics ,$them);
                            }else{
                                array_push($erroreTopics,$theme);
                                $col=true;
                            }
                            $them=null;
                        }
                    }
                }else{
                    array_push($erroreTopics,'Columna vacía.');
                    $col=true;
                }


                $comments = '<p style="font-family: Montserrat; font-size: 14px; font-style: normal; font-weight: normal;">'.trim($row[10]).'</p>';
                $errorComment = [];
                if (is_null($row[10])){
                    array_push($errorComment,$row[10]);
                    $col = true;
                }

                $errorAnio = [];
                if(is_null($row[11])){
                    array_push($errorAnio,'Columna vacía.');
                    $col = true;
                }
                $anio = (string)$row[11];
                $isValidity = $row[12]=='Si' || $row[12]=='si' ? 1 : 0;
                $isDirected = $row[13]=='Si' || $row[13]=='si' ? 1 : 0;
                $isPublished = $row[14]=='Si' || $row[14]=='si' ? 1 : 0;

                /*Documentos*/
                $errorDocs = [];
                $lisDocs = [];
                if ($row[15]!=null){
                    $documents = explode("||", $row[15]);
                    foreach ($documents as $document){
                        if (strlen($document)>0){
                            $findDoc = DocumentRecommendation::whereFolio(trim($document))->whereIsactive(1)
                                ->pluck('id')->first();
                            if (is_null($findDoc)){
                                array_push($errorDocs,$document);
                                $col = true;
                            }else{
                                array_push($lisDocs,$findDoc);
                            }
                        }
                    }
                }
                /*****************/

                /*Control de datos*/
                $indicator = null;
                if ($row[16]!=null){
                    $indicator = CatIndicator::whereName(trim($row[16]))->whereIsactive(1)
                        ->pluck('id')->first();
                }
                $levelAttention = null;
                if ($row[17]!=null){
                    $levelAttention = CatLevelAttention::whereName(trim($row[17]))->whereIsactive(1)
                        ->pluck('id')->first();
                }
                $classification = null;
                if ($row[18]!=null && $levelAttention!=null){
                    $classification = CatAttentionClassification::whereLevelAttentionsId($levelAttention)
                        ->whereName(trim($row[18]))->whereIsactive(1)->pluck('id')->first();
                }

                $dataControl = [
                    'recommendation_id'       => null,
                    'typeIndicator'           => $indicator,
                    'levelAttention'          => $levelAttention,
                    'attentionClassification' => $classification
                ];
                /**********************************/

                /*Derechos*/
                /*obtener ids Derechos para arbol*/
                $derechos = explode("||", $row[8]);
                $findRightslll = [];
                $erroreRights = [];
                $findRights = [];
                $auxRightlll = [];
                $auxRight = [];
                if ($row[8]!=null){
                    foreach ($derechos as $d){
                        if (strlen($d)>0){
                            $find = strpos($d, '2.-');
                            if ($find===false){
                                array_push($findRightslll,$d);
                            }else{
                                if (substr_count($d, '2.-')>1){
                                    array_push($erroreRights,$d);
                                    $col=true;
                                }else{
                                    $auxDerecho = explode("2.-", $d);
                                    array_push($findRights,$auxDerecho[1]);
                                }
                            }
                        }
                    }


                    foreach ($findRightslll as $existRightlll){
                        $id = CatSubcategorySubrights::where('name',trim($existRightlll))->where('isActive',1)->first();
                        if (isset($id)){
                            array_push($auxRightlll ,$id);
                        }else{
                            array_push($erroreRights,$existRightlll);
                            $col=true;
                        }
                        $id=null;
                    }

                    /*obtener ids Derechos lll para arbol*/
                    foreach ($findRights as $existRight){
                        $id = CatSubRights::where('name',trim($existRight))->where('isActive',1)->first();
                        if (isset($id)){
                            array_push($auxRight ,$id);
                        }else{
                            if ($existRight!==""){
                                array_push($erroreRights,$existRight);
                            }
                            $col=true;
                        }
                        $id=null;
                    }
                }else{
                    array_push($erroreRights,'Columna vacía.');
                    $col=true;
                }


                $topics = TopicsTrait::orderTopics($auxTopics );
                $goalsOds = GoalsOdsTrait::orderOds($auxGoalsOd);
                $rights = RightsTrait::orderRights(null,$auxRight,$auxRightlll);

                $tree = [
                    'rightsShowIds'   => $rights['showIds'],
                    'rightsListR'     => $rights['listR'],
                    'topicsShowIdes'  => $topics['showIde'],
                    'topicsListThemes'=> $topics['listThemes'],
                    'showOdsIds'      => $goalsOds['showOdsIds'],
                    'goalsOdsList'    => $goalsOds['listOds']
                ];

                $errorsAll =[
                    'errorRecommendation' => $this->errorRecommendation ? $this->errorRecommendation : null,
                    'errorEntity' => $errorEntity ? $errorEntity : null,
                    'errorOrdenGob' => $errorGob ? $errorGob : null,
                    'errorPower' => $errorPow ? $errorPow : null ,
                    'errorAuthority' => $errorAuthority ? $errorAuthority : null,
                    'errorPop' => $errorPop ? $errorPop : null,
                    'errorAction' => $errorAction ? $errorAction : null,
                    'errorOds' => $errorOds ? $errorOds : null,
                    'errorAnio' => $errorAnio ? $errorAnio : null,
                    'errorRights' => null,
                    'errorRightslll' => $erroreRights ? $erroreRights : null,
                    'errorTopics' => $erroreTopics ? $erroreTopics : null,
                    'errorComment' => $errorComment ? $errorComment :null,
                    'errorDocs' => $errorDocs ? $errorDocs : null
                ];

                $text = trim($row[0]);
                $textTrunc=$text;
                /*if (strlen($text)>250) {
                    for ($i=0;$i<267;$i++){
                        $textTrunc = $textTrunc.$text[$i];
                    }
                    //$textTrunc = substr(utf8_encode($text), 0, 267);
                    dd($textTrunc);
                    $textTrunc = $textTrunc . "...";
                }else{
                    $textTrunc =$text;
                }*/

                /*crear recomendación*/
                if (is_null($existRecommendation )) {

                    $errorReportRec = [];
                    $goodReportRec = [];
                    $i = 0;
                    foreach ($this->errorsReportedActions as $errorRep){
                        if ($this->fila == $errorRep['idRec']){
                            array_push($errorReportRec,$errorRep);
                            $col=true;
                            unset($this->errorsReportedActions[$i]);
                        }
                        $i++;
                    }
                    $j=0;
                    foreach ($this->goodReportedActions as $goodReported){
                        if ($this->fila == $goodReported['idRec']){
                            array_push($goodReportRec,$goodReported);
                            unset($this->goodReportedActions[$j]);
                        }
                        $j++;
                    }

                    if ($col === false) {
                        $recommendation = new Recommendation();
                        $recommendation->user_id = auth()->user()->id;
                        $recommendation->recommendation = $findRecommendation;
                        $recommendation->validity = $isValidity;
                        $recommendation->directed = $isDirected;
                        $recommendation->cat_entity_id = $entity->id;
                        $recommendation->date = $anio;
                        $recommendation->comments = $comments;
                        $recommendation->invoice = $folio;
                        $recommendation->isPublished = $isPublished;
                        $recommendation->save();
                        $recommendation->docs()->sync($lisDocs);

                        $dataControl['recommendation_id'] = $recommendation->id;
                        $dataCo = new DataControl();
                        $dataCo->fill($dataControl);
                        $dataCo->save();

                        $recommendation->goalsOds()->sync($listGoalsOds);
                        $recommendation->order()->sync($idsGob);
                        $recommendation->power()->sync($idsPow);
                        $recommendation->attendig()->sync($idsEnt);
                        $recommendation->population()->sync($idsPop);
                        $recommendation->action()->sync($idsAct);
                        $recommendation->subtopic()->sync($listThemes);
                        foreach ($goodReportRec as $rep){
                            $iniAut='';
                            if (count($rep['authorities'])>1){
                                $iniAut = 'VAEA';
                            }else{
                                $attending = CatAttending::find($rep['authorities'][0]);
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
                            $rep['recommendation_id'] = $recommendation->id;
                            $rep['invoice'] = $folio.$iniAut.$num;

                            $repA = new ReportedAction();
                            $repA->fill($rep);
                            $repA->save();

                            $repA->action()->sync($rep['reportedActions']);
                            $repA->population()->sync($rep['population']);
                            $repA->attendig()->sync($rep['authorities']);
                        }

                        /*obtener ids Derechos*/
                        $idsRights=[];
                        foreach ($findRights as $right){
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
                        $subRights = explode("||", $row[8]);
                        $idsSubRights=[];
                        foreach ($subRights as $subright){
                            if(strlen($subright)>0){
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
                        }

                    } else {
                        $errorRows = new stdClass();
                        $errorRows->row = $this->fila;
                        $errorRows->textTrunc = $textTrunc;
                        $errorRows->recommendation = $findRecommendation;
                        $errorRows->ods = str_replace("||", ", ", $row[7]);;
                        $errorRows->entity = $entity;
                        $errorRows->gobOrder = $idsGob;
                        $errorRows->gobPower = $idsPow;
                        $errorRows->attending = $idsEnt;
                        $errorRows->population = $idsPop;
                        $errorRows->solidarityAction = $idsAct;
                        $errorRows->odsIds = $idsOds;
                        $errorRows->anio = $anio;
                        $errorRows->validity = $isValidity;
                        $errorRows->directed = $isDirected;
                        $errorRows->dataControl = $dataControl;
                        $errorRows->comments = $comments;
                        $errorRows->docs = $lisDocs;
                        $errorRows->tree = $tree;
                        $errorRows->errorsAll = $errorsAll;
                        $errorRows->errorReportedActions = $errorReportRec;
                        $errorRows->goodReportedActions = $goodReportRec;
                        $newRow = (array)$errorRows;
                        array_push($this->errorRe, $newRow);
                    }
                }
            }
        }
        $this->fila++;
        session(["errorMasivo"=>$this->errorRe]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
