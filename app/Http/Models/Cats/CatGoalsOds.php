<?php

namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

class CatGoalsOds extends Model
{

    protected $fillable = ['ods_id', 'name','isActive','acronym', 'cat'];
    protected $appends = ['is_used', 'hash'];

    public function scopeSearch($query, $search)
    {
        return $query->when(!empty($search), function ($query) use ($search){
            return $query->where('name', 'like', '%' .$search . '%')->orWhere ('acronym', 'like', '%' .$search . '%')
                ->orWhereHas('ods', function ($q) use ($search) {
                    $q->where('name', 'like', '%' .$search . '%');

                });
        });
    }

    public function getIsUsedAttribute()
    {
        $isUsed = \DB::table('ods_recommendation')->where('goals_ods_id', $this->id)->first();

        return $isUsed ? true : false;
    }

    public function ods()
    {
        return $this->belongsTo(CatOds::class, 'ods_id', 'id')
            ->whereIsactive(true);

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

    public function scopeOfType($query, $search)
    {
        if (!empty($search)) {
            return $query->where('name', 'like', '%'. $search . '%')
                    ->orWhere('acronym', 'like', '%' . $search . '%');
        }
        return $query;
    }



}
