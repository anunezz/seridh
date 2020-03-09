<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Models\Recommendation;

class RecommendationsExport implements FromCollection


{

    public function collection()
    {
        $collection = collect();

        $results = Recommendation::get();

        foreach ($results as  $value) {
            $collection->push([
                $value->recommendation
            ]);
        }

        return $collection;
    }




}

