<?php

namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

class CatAttentionClassification extends Model
{
    protected $fillable = ['level_attentions_id', 'name','isActive'];
}
