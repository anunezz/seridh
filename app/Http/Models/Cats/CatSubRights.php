<?php

namespace App\Http\Models\Cats;
use Illuminate\Database\Eloquent\Model;

class CatSubRights extends Model
{
    protected $fillable = ['rights_recommendations_id', 'name','isActive', 'cat'];

    public function recommendations()
    {
        return $this->belongsToMany(Recommendation::class);
    }

    public function rigthRecommendation()
    {
        return $this->belongsTo(CatRightsRecommendation::class, 'rights_recommendations_id', 'id');
    }

    public function subcategories()
    {
        return $this->hasMany(CatSubcategorySubrights::class, 'sub_rights_id');
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

