<?php

namespace App\Http\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;


class ConsolePublicRecommendation extends Model
{
    protected $table = 'public_recomendation';
    protected $fillable = ['seridh','activeSeridh','undersecretary','activeUndersecretary',
        'path_undersecretary', 'dgdhd','path_dgdhd','activeDgdhd'];

}
