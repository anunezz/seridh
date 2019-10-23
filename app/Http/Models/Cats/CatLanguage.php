<?php namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

class CatLanguage extends Model
{
    protected $table = "cat_languages";

    protected $fillable = ["acronym", "description"];

}

