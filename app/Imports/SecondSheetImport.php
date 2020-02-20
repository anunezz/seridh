<?php

namespace App\Imports;

use App\Http\Models\Cats\CatAttending;
use App\Http\Models\Cats\CatPopulation;
use App\Http\Models\Cats\CatSolidarityAction;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use stdClass;

/*ini_set('memory_limit', '1024M');*/
class SecondSheetImport implements ToModel, WithBatchInserts, WithChunkReading
{
    protected $allGood = [];
    protected $allErrors = [];
    protected $fila = 2;

    public function model(array $row)
    {
            if ((trim($row[0]) != "No. fila de recomendación") && (trim($row[5]) != "Ejemplo") && (trim($row[5]) != "Ejemplo2")) {
                $errors = false;
                for ($i=0;$i<6;$i++){
                    if (is_null(trim($row[$i]))){
                        $errors = true;
                    }
                }

                $recommendation = null;
                $errorsRec = null;
                if (is_null(trim($row[0]))){
                    $errorsRec = '';
                    $errors = true;
                }else{
                    $recommendation = (int)$row[0];
                }

                /*Fecha de reporte*/
                $date = null;
                $errorsDate = null;
                $validDate = strpos(trim($row[1]), '-');
                if ($validDate==false) {
                    $errorsDate = $row[1];
                    $errors = true;
                }else{
                    $date = $row[1];
                }

                /*Accion Solicitada*/
                $typeReportedActions = explode("||", $row[2]);
                $errorsReportedActions = [];
                $goodReportedActions = [];
                foreach ($typeReportedActions as $reportedAction){
                    $findAction = CatSolidarityAction::where('name',trim($reportedAction))->where('isActive',1)->pluck('id')->first();
                    if (is_null($findAction)){
                        array_push($errorsReportedActions,$reportedAction);
                        $errors = true;
                    }else{
                        array_push($goodReportedActions,$findAction);
                    }
                }

                /*Población beneficiaria*/
                $populations = explode("||", $row[3]);
                $errorsPopulations = [];
                $goodPopulations = [];
                foreach ($populations as $population){
                    $findPopulation = CatPopulation::where('name',trim($population))->where('isActive',1)->pluck('id')->first();
                    if (is_null($findPopulation)){
                        array_push($errorsPopulations,$population);
                        $errors = true;
                    }else{
                        array_push($goodPopulations,$findPopulation);
                    }
                }

                /*Autoridad encargada de atender*/
                $authorities = explode("||", $row[4]);
                $errorsAuthorities = [];
                $goodAuthorities = [];
                foreach ($authorities as $authority){
                    $findAuthority= CatAttending::where('name',trim($authority))->where('isActive',1)->pluck('id')->first();
                    if (is_null($findAuthority)){
                        array_push($errorsAuthorities,$authority);
                        $errors = true;
                    }else{
                        array_push($goodAuthorities,$findAuthority);
                    }
                }

                $errorDescription = null;
                $description = '';
                if (is_null(trim($row[5]))){
                    $errorDescription = 'La acción reportada no cueta con un descripción';
                }else{
                    $description = '<p style="font-family: Montserrat; font-size: 14px; font-style: normal; font-weight: normal;">'.trim($row[5]).'</p>';
                }

                $registry = new stdClass();
                $registry->rowExcel = $this->fila;
                $registry->idRec = $recommendation;
                $registry->errorIdRec = $errorsRec;
                $registry->date = $date;
                $registry->errorDate = $errorsDate;
                $registry->reportedActions = $goodReportedActions;
                $registry->errorReportedActions = $errorsReportedActions;
                $registry->population = $goodPopulations;
                $registry->errorPopulation = $errorsPopulations;
                $registry->authorities = $goodAuthorities;
                $registry->errorAuthorities = $errorsAuthorities;
                $registry->description = $description;
                $registry->errorDescription = $errorDescription;

                $registro = (array)$registry;

                if ($errors){
                    array_push($this->allErrors,$registro);
                }else{
                    array_push($this->allGood,$registro);
                }
                $this->fila++;
            }
        session(["reportedActions"=>$this->allGood,"errorsReportedActions"=>$this->allErrors]);
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
