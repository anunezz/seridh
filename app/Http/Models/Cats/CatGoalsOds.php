<?php

namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

class CatGoalsOds extends Model
{

    protected $fillable = ['ods_id', 'name','isActive','acronym', 'cat'];
    protected $appends = ['hash'];


    public function ods()
    {
        return $this->belongsTo(CatOds::class, 'ods_id', 'id');

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
