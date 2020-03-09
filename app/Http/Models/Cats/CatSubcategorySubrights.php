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

    protected $appends = ['is_used', 'hash'];

    public function scopeSearch($query, $search)
    {
        return $query->when(!empty($search), function ($query) use ($search){
            return $query->where('name', 'like', '%' .$search . '%')
                ->orWhereHas('subRight', function ($q) use ($search) {
                    $q->where('name', 'like', '%' .$search . '%');

                });

        });
    }

    public function getIsUsedAttribute()
    {
        $isUsed = \DB::table('recommendation_right_subright')->where('subcategory_subrights_id', $this->id)->first();

        return $isUsed ? true : false;
    }

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
