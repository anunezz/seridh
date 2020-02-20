<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;


class RecommendationsExport implements FromCollection


{

    public function collection()
    {
        $collection = collect();

        return $collection->push([
           'hola'
       ]);
    }




}

