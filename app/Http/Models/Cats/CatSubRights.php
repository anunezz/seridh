<?php

namespace App\Http\Models\Cats;
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
        return $this->belongsTo(CatRightsRecommendation::class);
    }

    public function subcategories()
    {
        return $this->hasMany(CatSubcategorySubrights::class, 'sub_rights_id');
    }
}

