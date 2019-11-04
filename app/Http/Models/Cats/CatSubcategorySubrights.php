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

    public function subRight()
    {
        return $this->belongsTo(CatSubRights::class);
    }

}
