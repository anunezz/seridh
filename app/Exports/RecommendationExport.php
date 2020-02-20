<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;

class RecommendationExport implements WithMultipleSheets

{
    use Exportable;

    public function sheets(): array
    {
       $sheets = [];

       $sheets[] = new RecommendationsExport();
       $sheets[] = new RecommendationsExport();
       return $sheets;
    }




}

