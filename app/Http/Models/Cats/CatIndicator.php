<?php

namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

class CatIndicator extends Model
{
    protected $fillable = ['name','isActive'];
}
