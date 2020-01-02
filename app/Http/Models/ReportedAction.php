<?php

namespace App\Http\Models;

use App\Http\Models\Cats\CatAttending;
use App\Http\Models\Cats\CatPopulation;
use App\Http\Models\Cats\CatSolidarityAction;
use Illuminate\Database\Eloquent\Model;

use App\Http\Traits\CustomModelLogic;
use Carbon\Carbon;

class ReportedAction extends Model
{
    protected $fillable = ['invoice','recommendation_id','date','description'];

   protected $appends = ['implode_action','implode_attendig'];
   //protected $appends = ['implode_action'];


    public function population()
    {
        return $this->belongsToMany(
            CatPopulation::class,
            'reported_population',
            'reported_id',
            'population_id'
        );
    }

    public function action()
    {
        return $this->belongsToMany(
            CatSolidarityAction::class,
            'reported_type_acction',
            'reported_id',
            'type_action_id'
        );
    }

    public function attendig()
    {
        return $this->belongsToMany(
            CatAttending::class,
            'reported_authority',
            'reported_id',
            'authority_id'
        );
    }


    public function getImplodeActionAttribute()
    {
        return implode('|', $this->action->pluck('name')->toArray());
    }

    public function getImplodeAttendigAttribute()
    {
        return implode('|', $this->attendig->pluck('acronym')->toArray());
    }


}
