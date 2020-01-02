<?php

namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

class CatSubcategorySubrights extends Model
{
    protected $fillable = ['sub_rights_id', 'name','isActive'];

    public function subcategories()
    {
        return $this->belongsToMany(Recommendation::class);
    }

    public function rigthRecommendation()
    {
        return $this->belongsTo(CatRightsRecommendation::class, 'rights_recommendations_id', 'id');
    }

    public function subRight()
    {
        return $this->belongsTo(CatSubRights::class, 'sub_rights_id', 'id');
    }

    protected $appends = ['hash'];

    public function getHashAttribute()
    {
        return encrypt($this->id);
    }

    public function getIsCreatorAttribute(): bool
    {
        return true;
        //return $this->user_id === auth()->user()->id;
    }
}
