<?php

namespace App\Exports;

//use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Http\Models\Recommendation;

class AllRecomendationExport implements FromCollection
{

    public function view(): View
    {

        return Excel::dowload(Recommendation::all(),'R-exportacion.xlsx');
        // return view('files.allrecomendationsexportexcel', [
        //     'response' => Recommendation::all()
        // ]);
    }
}

