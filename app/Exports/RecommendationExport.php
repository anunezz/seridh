<?php

namespace App\Exports;

//use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Http\Models\Recommendation;

class RecommendationExport implements FromView
{
    public function view(): View
    {
        return view('files.recommendationexcel', [
            'response' => Recommendation::all()
        ]);
    }
}

