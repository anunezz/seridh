<?php

namespace App\Http\Models\Cats;

use App\Http\Models\Recommendation;
use Illuminate\Database\Eloquent\Model;

class DataControl extends Model
{
    protected $fillable = ['recommendation_id', 'typeIndicator','levelAttention','attentionClassification','isActive'];

    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class);
    }
}
