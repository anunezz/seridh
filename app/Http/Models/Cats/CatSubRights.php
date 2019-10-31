<?php

namespace App\Http\Models\Cats;

use App\Http\Models\Recommendation;
use Illuminate\Database\Eloquent\Model;

class CatSubRights extends Model
{
    protected $fillable = ['rights_recommendations_id', 'name','isActive'];

    public function recommendations()
    {
        return $this->belongsToMany(Recommendation::class);
    }

    public function rigthRecommendation()
    {
        return $this->belongsTo(CatSubRights::class);
    }
}

