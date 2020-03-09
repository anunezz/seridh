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
        return $this->hasMany(CatSubcategorySubrights::class, 'sub_rights_id')
            ->whereIsactive(true);
    }

    protected $appends = ['is_used', 'hash'];

    public function scopeSearch($query, $search)
    {
        return $query->when(!empty($search), function ($query) use ($search){
            return $query->where('name', 'like', '%' .$search . '%')
                ->orWhereHas('rigthRecommendation', function ($q) use ($search) {
                    $q->where('name', 'like', '%' .$search . '%');

                });

        });
    }

    public function getIsUsedAttribute()
    {
        $isUsed = \DB::table('recommendation_right_subright')->where('subrigth_id', $this->id)->first();

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

