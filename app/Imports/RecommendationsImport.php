<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RecommendationsImport implements WithMultipleSheets
{
    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            'AccionesReportadas' => new SecondSheetImport(),
            'Recomendaciones' => new FirstSheetImport(),

        ];
    }
}
